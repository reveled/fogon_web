( function( $ ) {

	"use strict";

	var el_import_content_popup_wrap = $( '.import-inner-content-popup-wrap' );
	$( document ).on( 'click', '.crafto-import-popup-close', function( e ) {
		if ( el_import_content_popup_wrap.hasClass( 'open' ) ) {
			el_import_content_popup_wrap.removeClass( 'open' );
		}
	});

	var el_import_content_main_popup = $( '.demo-data-import-main-popup' );
	$( document ).on( 'click', '.btn-import-cancel', function( e ) {
		if ( 'block' === el_import_content_main_popup.css( 'display' ) ) {
			el_import_content_main_popup.css( 'display', 'none' );
		}
	});

	// Demo Import Popup Panel
	$( document ).on( 'click', '.crafto-demo-import-popup', function( e ) {

		e.preventDefault();

		var el_demo_import_main_popup = $( '.demo-data-import-main-popup' );

		$( '.popup-loader' ).addClass( 'crafto-popup-loading' );

		var demoKey   = $( this ).attr( 'demo-popup-key' );
		var setupName = $( this ).attr( 'demo-popup-name' );

		var ajaxData = {
			action: 'crafto_import_popup_panel',
			demo_key: demoKey,
			demo_name: setupName,
		};

		var request = $.ajax({
			type: 'POST',
			url: ajaxurl,
			data: ajaxData,
		});
		request.success( function( response ) {

			el_demo_import_main_popup.addClass( 'popup-overlay' ).show();

			$( '.popup-loader' ).removeClass( 'crafto-popup-loading' );
			if ( 'success' === response.status ) {
			    el_demo_import_main_popup.html( response.html );
			}
		});
		request.fail( function( jqXHR, textStatus ) {

		} );
	});

	// Import demo data
	$( document ).on( 'click', '.crafto-demo-import', function( e ) {
		e.preventDefault();

		/* Return false if current element has disable attribute */
		if ( $( this ).attr( 'disabled' ) ) {
			return false;
		}

		/* Add disable attribute in all element to block import click */
		craftoDisableButton( '.crafto-demo-import' );
		var demoKey            = $( this ).attr( 'demo-data' );
		var importProceedFlag  = false;
		var importFullOptions  = [];

		var el_crafto_checkbox_field = $( '.crafto-checkbox' );
		
		el_crafto_checkbox_field.each( function( key, option ) {
			if ( $( this ).is( ':checked' ) ) {
				importFullOptions.push( $( option ).val() );
			} else if ( $( this ).is( ':not(:checked)' ) ) {
				$( this ).attr( 'disabled', 'disabled' );
			}
		});

		// Check at least empty post id and display info message
		if ( 0 === importFullOptions.length ) {

			alert( craftoImport.no_single_layout );

			el_crafto_checkbox_field.each( function( key, option ) {
				$( this ).removeAttr( 'disabled' );
			});

			importProceedFlag = false;

			// Remove loader
			craftoRemoveLoader( '.crafto-demo-import' );

			return false;
		} else {
			var confirmMsg = confirm( craftoImport.full_import_confirmation );
			if ( confirmMsg ) {

				// Add loader
				craftoAddLoader( this );

				// Proceed to import demo data
				importProceedFlag = true;
			}
		}

		// Check flag for ready to import / delete process
		if ( true === importProceedFlag ) {

			craftoFullDemoImport( importFullOptions, demoKey );

		} else {

			// Remove loader
			craftoRemoveLoader( '.crafto-demo-import' );

			var currentTab = $( this ).parents( '.active-tab' );

			return false;
		}
	});

	// Import full demo data
	function craftoFullDemoImport( importFullOptions, demoKey ) {

		var importOption = importFullOptions.shift();

		if ( '' !== importOption &&  undefined != importOption ) {

			var importOptionLabel = $( '.active-tab' ).find( '.crafto-checkbox[value="' + importOption + '"]' ).attr( 'data-label' );

			if ( importOptionLabel.length > 0 ) { 
				$( '.crafto-import-button span' ).text( craftoImport.importing + ' ' + importOptionLabel );
			}
			$( '.btn-import-cancel' ).addClass( 'disabled' );
			var ajaxData = {
				action: 'crafto_import_sample_data',
				full_import_options: importOption,
				demo_key : demoKey,
			};
			var request = $.ajax({
				url: ajaxurl,
				type: 'POST',
				data: ajaxData,
				crossDomain: true,
			});
			request.success( function( response ) {

				craftoDisableCheckbox( '.import-content-full-wrap .crafto-checkbox', importOption, demoKey );

				var remainImportCount = importFullOptions.length;

				if ( remainImportCount > 0 ) {
					$( '.btn-import-cancel' ).removeClass( 'disabled' );
					craftoFullDemoImport( importFullOptions, demoKey );

				} else {

					$( '.crafto-import-button' ).text( craftoImport.import_finished );
					setTimeout( function() {
						window.location.href = craftoImport.redirect_after_import;
					}, 1500 );
				}
				
			});
			request.fail( function( jqXHR, textStatus ) {

				alert( 'Request failed: ' + textStatus );

				// Remove loader
				craftoRemoveLoader( '.crafto-demo-import' );
			});
		}
	}

	// Disable Checkbox
	function craftoDisableCheckbox( obj, key, demoKey ) {
		$( '.active-tab' ).find( obj + '[value="' + key + '"]' ).attr( 'disabled', 'disabled' );
	}

	// Add Loader
	function craftoAddLoader( objName ) {
		$( objName ).addClass( 'crafto-button-loading' );
	}

	// Remove Loader
	function craftoRemoveLoader( objName ) {
		$( objName ).removeClass( 'btn-link-disabled crafto-button-loading' ).removeAttr( 'disabled' );
	}

	// Disable Button
	function craftoDisableButton( objName ) {
		$( objName ).addClass( 'btn-link-disabled' ).attr( 'disabled', 'disabled' );
	}

})( jQuery );
