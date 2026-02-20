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
					'.elementor-widget-crafto-tilt-box',
					'.elementor-widget-crafto-image',
					'.elementor-widget-crafto-3d-parallax-hover',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.tiltAtroposInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-tilt-box.default',
					'crafto-image.default',
					'crafto-3d-parallax-hover.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.tiltAtroposInit );
				});
			}
		},
		tiltAtroposInit: function tiltAtroposInit() {
			let atroposItems = document.querySelectorAll( '.has-atropos' );
			if ( atroposItems.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'atropos', CraftoMain.disable_scripts ) < 0 ) {
				initAtropos();
				function initAtropos() {
					if ( getWindowWidth() > 1199 ) {
						atroposItems.forEach( function( atroposItem ) {
							let myAtropos = Atropos({
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
