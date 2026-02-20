! ( function ( $ ) {

	"use strict";

	$( document ).ready( function() {
		const $tabRepeater        = $( '#crafto-custom-product-tab-repeater' );
		const $accordionTab       = $( '#crafto-accordion-product-tab' );
		const craftoGlobalContent = tinyMCEPreInit.mceInit.content;

		// Add new accordion tab
		$( document ).on( 'click', '.add-row', function() {
			let maxTabId = 0;

			// Calculate the next tab ID
			$tabRepeater.find( '.crafto-textarea' ).each( function() {
				const tabId  = parseInt( $( this ).attr( 'id' ).replace( 'edit_post', '' ), 10 );
					maxTabId = Math.max( maxTabId, tabId );
			});

			const nextTabId = maxTabId + 1;

			// Fetch and append the new tab
			$.post( CraftoWooAdmin.ajaxurl, {
				action: 'crafto_custom_tab_details',
				tabid: nextTabId
			}).done( function ( response ) {
				$accordionTab.append( response );
				const editorId = `edit_post${nextTabId}`;

				// Refresh accordion and initialize editors
				$accordionTab.accordion( 'refresh' );
				tinymce.init( craftoGlobalContent );
				tinyMCE.execCommand( 'mceAddEditor', true, editorId );

				quicktags({ id: editorId });
			});
		});

		// Remove accordion tab
		$( document ).on( 'click', '.remove-row', function() {
			if ( confirm( CraftoWooAdmin.i18n.tabRemoveMessage ) ) {
				$( this ).closest( '.crafto-single-product-tab-main-structure' ).remove();
			}
		});

		// Initialize accordion and sortable functionality
		if ( $accordionTab.length > 0 ) {
			$accordionTab.accordion({
				collapsible: true,
				active: false,
				heightStyle: 'fill',
				header: 'h3'
			}).sortable({
				axis: 'y',
				handle: 'h3',
				items: '.crafto-single-product-tab-main-structure'
			});
		}
	});

})( window.jQuery );
