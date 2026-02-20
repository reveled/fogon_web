/**
 * External dependencies
 */
import { registerPlugin } from '@wordpress/plugins';
import { store as editorStore, PluginSidebar } from '@wordpress/editor';
import {
	Button,
	PanelBody,
	ComboboxControl,
	Spinner,
	Notice,
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalSpacer as Spacer,
	Disabled,
	Flex,
} from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';
import { addQueryArgs } from '@wordpress/url';
import { debounce } from '@wordpress/compose';

/**
 * Get the receipt URL
 *
 * @param {number} orderId
 * @param {number} receiptLayoutId
 * @return {Promise} Receipt URL promise
 */
function getReceiptURL( orderId, receiptLayoutId ) {
	return wp
		.apiFetch( {
			path: `wc/v3/orders/${ orderId }/receipt?force_new=true&orderable_layout_id=${ receiptLayoutId }`,
			method: 'POST',
		} )
		.then( ( response ) => {
			const receiptUrl = response?.receipt_url;

			if ( wp.url.isURL( receiptUrl ) ) {
				return receiptUrl;
			}
		} );
}

/**
 * Get the WooCommerce orders
 *
 * @param {Object} parameters
 * @return {Promise} Orders promise
 */
function getOrders( parameters ) {
	const defaultParameters = {
		per_page: 4,
		status: [ 'pending', 'processing', 'on-hold', 'completed' ],
	};

	const args = {
		...defaultParameters,
		...parameters,
	};

	return apiFetch( {
		path: addQueryArgs( 'wc/v3/orders', args ),
	} );
}

/**
 * Order field component
 *
 * @param {Object} props
 */
const OrderField = ( props ) => {
	return (
		<ComboboxControl
			__next40pxDefaultSize
			__nextHasNoMarginBottom
			label={ __( 'Order', 'orderable' ) }
			help={ __(
				'Select the order from the list or type to search',
				'orderable'
			) }
			{ ...props }
		/>
	);
};

/**
 * Preview component
 *
 * @param {Object}  props
 * @param {boolean} props.canPreview
 * @param {number}  props.layoutId
 */
const Preview = ( { canPreview, layoutId } ) => {
	const [ order, setOrder ] = useState();
	const [ isLoading, setIsLoading ] = useState( true );
	const [ isLoadingReceiptUrl, setIsLoadingReceiptUrl ] = useState();
	const [ options, setOptions ] = useState( [] );
	const [ searchTerm, setSearchTerm ] = useState();

	const isDisabled = ! canPreview || isLoadingReceiptUrl;

	useEffect( () => {
		setIsLoading( true );
		getOrders( { search: searchTerm ? searchTerm : undefined } )
			.then( ( orders ) => {
				setOptions(
					orders.map( ( orderItem ) => ( {
						value: orderItem.id,
						label: `#${ orderItem.id } - ${ orderItem.billing.first_name } ${ orderItem.billing.last_name }`,
					} ) )
				);

				if ( ! order ) {
					setOrder( orders[ 0 ].id );
				}
			} )
			.finally( () => {
				setIsLoading( false );
			} );
	}, [ searchTerm, order ] );

	const debouncedOnFilterValueChange = debounce( ( inputValue ) => {
		if ( inputValue ) {
			setIsLoading( true );
			setSearchTerm( inputValue );
		}
	}, 300 );

	const orderFieldComponent = (
		<OrderField
			value={ order }
			onChange={ ( value ) => {
				if ( ! value ) {
					setSearchTerm( '' );
					return;
				}

				setOrder( value );
			} }
			isLoading={ isLoading }
			options={ options }
			onFilterValueChange={ debouncedOnFilterValueChange }
		/>
	);

	return (
		<>
			{ isDisabled && (
				<Disabled style={ { opacity: '0.75' } }>
					{ orderFieldComponent }
				</Disabled>
			) }

			{ ! isDisabled && orderFieldComponent }

			<Button
				variant="primary"
				icon={
					isLoadingReceiptUrl ? (
						<Spinner style={ { margin: '0 0 0 9px' } } />
					) : (
						'external'
					)
				}
				iconPosition="right"
				disabled={ isLoading || ! canPreview }
				style={ { marginTop: '15px' } }
				onClick={ () => {
					setIsLoadingReceiptUrl( true );

					getReceiptURL( order, layoutId )
						.then( ( url ) => {
							if ( ! url ) {
								return;
							}

							window.open( url, '_blank' );
						} )
						.finally( () => {
							setIsLoadingReceiptUrl( false );
						} );
				} }
			>
				{ __( 'Preview', 'orderable' ) }
			</Button>
		</>
	);
};

/**
 * Preview Sidebar component
 */
const PreviewSidebar = () => {
	const [ isLoading, setIsLoading ] = useState( true );
	const [ hasOrders, setHasOrders ] = useState( false );
	const receiptLayout = useSelect(
		( select ) => select( editorStore.name ).getCurrentPost(),
		[]
	);

	const isPublished = 'auto-draft' !== receiptLayout.status;

	useEffect( () => {
		setIsLoading( true );
		getOrders( { per_page: 1 } )
			.then( ( orders ) => {
				setHasOrders( !! orders?.length );
			} )
			.finally( () => {
				setIsLoading( false );
			} );
	}, [] );

	const canPreview = isPublished && hasOrders;

	let errorMessage;
	switch ( false ) {
		case isPublished:
			errorMessage = __(
				'You need to publish the receipt layout first to preview it.',
				'orderable'
			);
			break;

		case hasOrders:
			errorMessage = __(
				'You need to have at least one order to preview the receipt.',
				'orderable'
			);
			break;

		default:
			errorMessage = '';
			break;
	}

	return (
		<PluginSidebar
			name="plugin-sidebar-example"
			title={ __( 'Preview', 'orderable' ) }
			icon={ 'printer' }
		>
			<PanelBody>
				{ ! canPreview && (
					<Spacer marginBottom="16px">
						<Notice
							status="warning"
							isDismissible={ false }
							style={ { marginBottom: '20px' } }
						>
							{ errorMessage }
						</Notice>
					</Spacer>
				) }

				<p>
					{ __(
						'Preview the receipt layout using real data.',
						'orderable'
					) }
				</p>

				{ isLoading && (
					<Flex justify="center">
						<Spinner />
					</Flex>
				) }

				{ ! isLoading && (
					<Preview
						canPreview={ canPreview }
						layoutId={ receiptLayout.id }
					/>
				) }
			</PanelBody>
		</PluginSidebar>
	);
};

// Register the plugin.
registerPlugin( 'orderable-receipt-layout-preview-sidebar', {
	render: PreviewSidebar,
} );
