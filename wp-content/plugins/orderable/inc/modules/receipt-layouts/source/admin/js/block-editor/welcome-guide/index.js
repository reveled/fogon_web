/* global orderableReceiptWelcomeGuide*/

/**
 * External dependencies
 */
import { registerPlugin } from '@wordpress/plugins';
import {
	PluginDocumentSettingPanel,
	store as editorStore,
} from '@wordpress/editor';
import { store as editPostStore } from '@wordpress/edit-post';
import { Guide, Button } from '@wordpress/components';
import {
	useState,
	createInterpolateElement,
	useEffect,
} from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { useDispatch } from '@wordpress/data';

/**
 * Internal dependencies
 */
import HowToUseImg from './images/how-to-use.png';
import PreMadeTemplatesImg from './images/pre-made-templates.png';
import BuildFromScratchImg from './images/build-from-scratch.png';
import CustomizeEachBlockImg from './images/customize-each-block.png';
import DocumentationImg from './images/documentation.png';

function Image( { src } ) {
	return (
		<picture className="edit-post-welcome-guide__image">
			<img src={ src } alt="" />
		</picture>
	);
}

function Content( { title, body } ) {
	return (
		<>
			<h1 className="edit-post-welcome-guide__heading">{ title }</h1>
			<p className="edit-post-welcome-guide__text">{ body }</p>
		</>
	);
}

function WelcomeGuide( { close } ) {
	return (
		<Guide
			className="edit-post-welcome-guide"
			onFinish={ close }
			pages={ [
				{
					image: <Image src={ HowToUseImg } />,
					content: (
						<Content
							title={ __(
								'How to Use Receipt Layouts!',
								'orderable'
							) }
							body={ __(
								'Receipt Layouts allow you to create specific tickets/receipts to suit your business. Whether it’s a kitchen ticket, delivery driver note, or customer receipt, you can create and customize it here.',
								'orderable'
							) }
						/>
					),
				},
				{
					image: <Image src={ PreMadeTemplatesImg } />,
					content: (
						<Content
							title={ __(
								'Using Our Pre-Made Templates',
								'orderable'
							) }
							body={ __(
								'Edit one of our pre-made templates by adding a pattern. Add a block, click Browse all, then Patterns, and you’ll see a list of pre-built templates you can customize.',
								'orderable'
							) }
						/>
					),
				},
				{
					image: <Image src={ BuildFromScratchImg } />,
					content: (
						<Content
							title={ __( 'Build From Scratch', 'orderable' ) }
							body={ __(
								'Alternatively, you can build your own custom layout from scratch. Add the blocks you want from the order total, the table number, and more.',
								'orderable'
							) }
						/>
					),
				},
				{
					image: <Image src={ CustomizeEachBlockImg } />,
					content: (
						<Content
							title={ __( 'Customize Each Block', 'orderable' ) }
							body={ __(
								'Each block you add can be customized to suit you. You can change the label or hide it, adjust colors, padding, and more. Because this is the WordPress editor, you can add custom text anywhere in the layout.',
								'orderable'
							) }
						/>
					),
				},
				{
					image: <Image src={ DocumentationImg } />,
					content: (
						<Content
							title={ __(
								'Learn More About Receipt Layouts',
								'orderable'
							) }
							body={ createInterpolateElement(
								__(
									"Not quite sure where to start? We've got you covered! Check out our documentation to learn more about <a>Receipt Layouts</a>.",
									'orderable'
								),
								{
									a: (
										// eslint-disable-next-line jsx-a11y/anchor-has-content
										<a
											href="https://orderable.com/docs/ticket-receipt-layouts/"
											target="_blank"
											rel="noreferrer"
										/>
									),
								}
							) }
						/>
					),
				},
			] }
		/>
	);
}

function TutorialPanel() {
	const shouldShowWelcomeGuide =
		orderableReceiptWelcomeGuide?.shouldShowWelcomeGuide;
	const [ isOpen, setIsOpen ] = useState( shouldShowWelcomeGuide );

	const { setIsInserterOpened } = useDispatch( editorStore.name );
	const { openGeneralSidebar } = useDispatch( editPostStore.name );

	useEffect( () => {
		if ( ! shouldShowWelcomeGuide ) {
			return;
		}

		setIsInserterOpened( true );

		setTimeout( () => {
			const patternTabElement = document.querySelector(
				'.block-editor-tabbed-sidebar__tab[id*="-patterns"]'
			);

			if ( patternTabElement ) {
				patternTabElement.click();

				const receiptPatternsElement = document.querySelector(
					'[id*="orderable/receipt-layouts"]'
				);
				receiptPatternsElement?.click();

				openGeneralSidebar( 'edit-post/document' );
			}
		}, 350 );
	}, [ shouldShowWelcomeGuide, openGeneralSidebar, setIsInserterOpened ] );

	return (
		<PluginDocumentSettingPanel
			title={ __( 'Tutorial', 'orderable' ) }
			name="orderable-receipt-tutorial"
		>
			<Button variant="secondary" onClick={ () => setIsOpen( true ) }>
				{ __( 'Show Welcome Guide', 'orderable' ) }
			</Button>
			{ isOpen && <WelcomeGuide close={ () => setIsOpen( false ) } /> }
		</PluginDocumentSettingPanel>
	);
}

registerPlugin( 'orderable-receipt-layout-tutorial', {
	render: TutorialPanel,
	icon: 'welcome-view-site',
} );
