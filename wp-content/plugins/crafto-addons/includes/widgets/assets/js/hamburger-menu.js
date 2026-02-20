( function( $ ) {

	"use strict";

	const $window = $( window );

	let CraftoAddonsInit = {
		init: function init() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-hamburger-menu',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.hamburgerMenuInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-hamburger-menu.default', CraftoAddonsInit.hamburgerMenuInit );
			}
		},
		hamburgerMenuInit: function hamburgerMenuInit( $scope ) {
			const $body = $( 'body' );
			const $html = $( 'html' );

			$scope.each( function() {
				var $scope = $( this );

				const $hamburgerMenuWrapper = $( $scope.find( '.hamburger-menu-wrapper' ) );
				if ( 'undefined' != typeof CraftoMain && $.inArray( 'mCustomScrollbar', CraftoMain.disable_scripts ) < 0 ) {
					if ( $( '.hamburger-menu-full' ).length > 0 || $( '.hamburger-menu-modern' ).length > 0 ) {
						$hamburgerMenuWrapper.find( '.crafto-navigation-wrapper' ).mCustomScrollbar();
					}
		
					if ( $( '.hamburger-menu-modern' ).length > 0 ) {
						$( '.hamburger-menu' ).mCustomScrollbar();
					}
			
					if ( $( '.hamburger-menu-half' ).length > 0 ) {
						$hamburgerMenuWrapper.find( '.hamburger-menu' ).mCustomScrollbar();
					}
				}
			});

			$( document ).on( 'click', '.header-push-button .push-button', function( event ) {
				event.preventDefault();
				const isMenuOpen = $body.hasClass( 'show-menu' );
				if ( isMenuOpen ) {
					$body.removeClass( 'show-menu' );
					$( '.menu-list-item.open' ).removeClass( 'show' );
					$( '.sub-menu-item' ).collapse( 'hide' );
					$html.removeClass( 'overflow-hidden' );
				} else {
					$body.addClass( 'show-menu' );
					$html.addClass( 'overflow-hidden' );
				}
			});
		}
	}

	// If Elementor is already initialized, manually trigger.
	if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
		if ( typeof elementorFrontend !== 'undefined' && ! elementorFrontend.isEditMode() ) {
			CraftoAddonsInit.init();
		} else {
			$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );
		}
	} else {
		$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );
	}

})( jQuery );
