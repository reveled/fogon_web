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
					'.elementor-widget-crafto-interactive-banner',
				];
				widgets.forEach( element => { 
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.interactiveBannerInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-interactive-banner.default', CraftoAddonsInit.interactiveBannerInit );
			}
		},
		interactiveBannerInit: function interactiveBannerInit() {
			const $atroposItems = document.querySelectorAll( '.has-atropos' ); 

			if ( 0 === $atroposItems.length ) {
				return;
			}

			if ( $atroposItems.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'atropos', CraftoMain.disable_scripts ) < 0 ) {
				initAtropos();
				function initAtropos() {
					if ( getWindowWidth() > 1199 ) {
						$atroposItems.forEach( function( atroposItem ) {
							const myAtropos = Atropos({
								el: atroposItem
							});
						});
					}
				}
			}

			function getWindowWidth() {
				return window.innerWidth;
			}
		}
	};

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

})( jQuery );
