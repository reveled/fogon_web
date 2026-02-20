import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, ToggleControl } from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';
import './editor.scss';

export default function Edit( { attributes, setAttributes } ) {
	const serviceDateLabel =
		attributes.deliveryDateLabel || __( 'Delivery Date:', 'orderable' );
	const serviceTimeLabel =
		attributes.deliveryTimeLabel || __( 'Delivery Time:', 'orderable' );

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Content', 'orderable' ) }>
					<ToggleControl
						label={ __( 'Show label', 'orderable' ) }
						checked={ attributes.showLabel }
						onChange={ ( value ) =>
							setAttributes( { showLabel: value } )
						}
					/>
					<TextControl
						label={ __( 'Label', 'orderable' ) }
						placeholder={ __( 'Payment method: ', 'orderable' ) }
						value={ attributes.label }
						onChange={ ( value ) =>
							setAttributes( { label: value } )
						}
					/>
					<TextControl
						label={ __( 'Delivery Date Label', 'orderable' ) }
						placeholder={ __( 'Delivery Date:', 'orderable' ) }
						value={ attributes.deliveryDateLabel }
						onChange={ ( value ) =>
							setAttributes( { deliveryDateLabel: value } )
						}
					/>
					<TextControl
						label={ __( 'Delivery Time Label', 'orderable' ) }
						placeholder={ __( 'Delivery Time:', 'orderable' ) }
						value={ attributes.deliveryTimeLabel }
						onChange={ ( value ) =>
							setAttributes( { deliveryTimeLabel: value } )
						}
					/>
					<TextControl
						label={ __( 'Pickup Date Label', 'orderable' ) }
						placeholder={ __( 'Pickup Date:', 'orderable' ) }
						value={ attributes.pickupDateLabel }
						onChange={ ( value ) =>
							setAttributes( { pickupDateLabel: value } )
						}
					/>
					<TextControl
						label={ __( 'Pickup Time Label', 'orderable' ) }
						placeholder={ __( 'Pickup Time:', 'orderable' ) }
						value={ attributes.pickupTimeLabel }
						onChange={ ( value ) =>
							setAttributes( { pickupTimeLabel: value } )
						}
					/>
					<ToggleControl
						label={ __( 'Show date', 'orderable' ) }
						checked={ attributes.showDate }
						onChange={ ( value ) =>
							setAttributes( { showDate: value } )
						}
					/>
					<ToggleControl
						label={ __( 'Show time', 'orderable' ) }
						checked={ attributes.showTime }
						onChange={ ( value ) =>
							setAttributes( { showTime: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			{ attributes.showLabel && (
				<div className="orderable-service-date-time__label wp-block-orderable-receipt-layouts__label">
					{ attributes.label }
				</div>
			) }

			{ attributes.showDate && (
				<div className="orderable-service-date-time__date">
					<span className="wp-block-orderable-receipt-layouts__label">
						{ serviceDateLabel }
					</span>
					{ ' August 28, 2024' }
				</div>
			) }

			{ attributes.showTime && (
				<div className="orderable-service-date-time__time">
					<span className="wp-block-orderable-receipt-layouts__label">
						{ serviceTimeLabel }
					</span>
					{ ' 3:00 PM' }
				</div>
			) }
		</div>
	);
}
