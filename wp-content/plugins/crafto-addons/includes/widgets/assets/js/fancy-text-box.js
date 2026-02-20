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
					'.elementor-widget-crafto-fancy-text-box',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.fancyTextBoxInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-fancy-text-box.default', CraftoAddonsInit.fancyTextBoxInit );
			}
		},
		fancyTextBoxInit: function fancyTextBoxInit( $scope ) {
			$scope.each( function() {
				var $scope    = $( this );
				const $target = $scope.find( '.fancy-text-box-style-2' );

				if ( $target.length > 0 ) {
					$target.each( function() {
						const $elThis    = $( this );
						const figcaption = $elThis.find( 'figcaption' );

						if ( figcaption.length > 0 ) {
							setTimeout( function() {
								$elThis.css( {
									'padding-bottom': figcaption.outerHeight()
								});
							}, 200 );
						}
					});
				}
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

})( jQuery );
