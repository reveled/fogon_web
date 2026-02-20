( function( $ ) {

	"use strict";

	const $window   = $( window );
	const $document = $( document );

	let CraftoAddonsInit = {
		init: function init() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-popup',
					'.elementor-widget-crafto-dismiss-button',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.PopupInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-popup.default',
					'crafto-dismiss-button.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.PopupInit );
				});
			}
		},
		PopupInit: function( $scope ) {
			// Cache CraftoMain disable_scripts array and check
			const isMagnificEnabled = ( 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 );

			// Function to initialize magnificPopup for a given selector and options
			function initMagnificPopup( selector, options ) {
				if ( isMagnificEnabled ) {
					const element = $( selector );
					if ( element.length ) {
						element.magnificPopup( options );
					}
				}
			}

			// Modal magnific popup
			initMagnificPopup( '.popup-modal', {
				type: 'inline',
				mainClass: 'crafto-modal-popup',
				preloader: false,
				closeBtnInside: true,
				blackbg: true,
				midClick: true
			});

			// Subscribe magnific popup
			initMagnificPopup( '.subscribe-popup', {
				type: 'inline',
				mainClass: 'crafto-subscribe-popup',
				preloader: false,
				closeBtnInside: true,
				blackbg: true,
			});

			// Contact form magnific popup
			initMagnificPopup( '.popup-with-form', {
				type: 'inline',
				preloader: false,
				mainClass: 'crafto-contant-form-popup',
				fixedContentPos: true,
				closeBtnInside: true,
			});

			// magnific popup dismiss
			$document.on( 'click', '.popup-modal-dismiss', function( e ) {
				e.preventDefault();
				if ( isMagnificEnabled ) {
					$.magnificPopup.close();
				}
			});

			// Auto open popup
			const subscribe_form_cookie_name = ( 'undefined' != typeof CraftoFrontend ) ? `crafto_subscribe_form_popup_auto${CraftoFrontend.site_id}` : 'crafto_subscribe_form_popup_auto';
			const subscribe_form_popup       = getCraftoCookie( subscribe_form_cookie_name );
			const subscribe_popup            = $scope.find( '.subscribe-pop-auto' );

			if ( subscribe_popup.length > 0 && ( 'undefined' === typeof subscribe_form_popup || '' == subscribe_form_popup ) ) {
				setTimeout( () => {
					if ( ! $( 'body' ).hasClass( 'crafto-lightbox-show' ) ) {
						$( '.subscribe-form-popup a', $scope ).trigger( 'click' );
					}
				}, 2000 );
			}

			$document.on( 'click', '.popup-prevent-text', function( e ) {
				setCraftoCookie( subscribe_form_cookie_name, 'visited', '7' );
			});

			// Set Crafto Cookie
			function setCraftoCookie( cname, cvalue, exdays ) {
				const d = new Date();

				if ( exdays ) {
					d.setTime(d.getTime() + ( exdays * 24 * 60 * 60 * 1000 ) );
				}

				const expires   = exdays ? `;expires=${d.toUTCString()}` : '';
				document.cookie = `${cname}=${cvalue}${expires};path=/`;
			}

			// Get Crafto Cookie
			function getCraftoCookie( cname ) {
				const name          = `${cname}=`;
				const decodedCookie = decodeURIComponent( document.cookie );
				const cookies       = decodedCookie.split( ';' );

				for ( const cookie of cookies ) {
					const trimmedCookie = cookie.trim();
					if ( trimmedCookie.startsWith( name ) ) {
						return trimmedCookie.substring( name.length );
					}
				}
				return "";
			}
		},
	}
	
	// If Elementor is already initialized, manually trigger
	if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
		if ( typeof elementorFrontend !== 'undefined' && ! elementorFrontend.isEditMode() ) {
			CraftoAddonsInit.init();
		} else {
			$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );
		}
	} else {
		$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );
	}

} )( jQuery );
