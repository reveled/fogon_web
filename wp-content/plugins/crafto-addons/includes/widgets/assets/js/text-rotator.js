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
					'.elementor-widget-crafto-text-rotator',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.textRotatorWidget( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-text-rotator.default', CraftoAddonsInit.textRotatorWidget );
			}
		},
		textRotatorWidget: function( $scope ) {
			$scope.each( function() {
				var $scope            = $( this );
				const el_text_rotator = $( '.text-rotator' );
				
				el_text_rotator.each( function() {
					var $elThis = $( this );

					const el_preloader_overlay = $( '.preloader-overlay' );

					if ( $elThis.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'appear', CraftoMain.disable_scripts ) < 0  && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {

						$( this ).appear().trigger( 'resize ready' );

						if ( 'undefined' != typeof CraftoFrontend && '0' === CraftoFrontend.all_animations_disable ) {
							if ( el_preloader_overlay.length > 0 ) {
								let checkPreloader = setInterval( function() {
									if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
										clearInterval( checkPreloader );
										$scope.fancyTextEffect();
									}
								}, 10 );
							} else {
								$scope.fancyTextEffect();
							}
						}
					}
				});
			});
		}
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
