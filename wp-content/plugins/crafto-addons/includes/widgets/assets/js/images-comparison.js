( function( $ ) {

	"use strict";

	const $window = $( window );

	let CraftoAddonsInit = {
		init: function() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-images-comparison',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.imagesComparison( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-images-comparison.default', CraftoAddonsInit.imagesComparison );
			}
		},
		imagesComparison: function( $scope ) {
			$scope.each( function() {
				var $scope = $( this );

				const $image_compare = $scope.find( '.image-compare' );
				if ( $image_compare.length > 0  && 'undefined' != typeof CraftoMain && $.inArray( 'image-compare-viewer', CraftoMain.disable_scripts ) < 0  ) {
					let $settings = $image_compare.data( 'settings' );
					var default_offset_pct   = $settings.default_offset_pct,
						orientation          = $settings.orientation,
						before_label         = $settings.before_label,
						after_label          = $settings.after_label,
						no_overlay           = $settings.no_overlay,
						on_hover             = $settings.on_hover,
						add_circle_blur      = $settings.add_circle_blur,
						add_circle_shadow    = $settings.add_circle_shadow,
						add_circle           = $settings.add_circle,
						smoothing            = $settings.smoothing,
						smoothing_amount     = $settings.smoothing_amount,
						bar_color            = $settings.bar_color,
						move_slider_on_hover = $settings.move_slider_on_hover;
			
					let viewers = document.querySelectorAll( '#' + $settings.id );
		
					let options = {
						// UI Theme Defaults
						controlColor : bar_color,
						controlShadow: add_circle_shadow,
						addCircle : add_circle,
						addCircleBlur: add_circle_blur,
					
						// Label Defaults
						showLabels: ( before_label && before_label.trim() !== '' ) && ( after_label && after_label.trim() !== '' ) ? no_overlay : false,
						labelOptions : {
							before : before_label,
							after : after_label,
							onHover : on_hover
						},
					
						// Smoothing
						smoothing : smoothing,
						smoothingAmount: smoothing_amount,
					
						// Other options
						hoverStart : move_slider_on_hover,
						verticalMode : orientation,
						startingPoint : default_offset_pct,
						fluidMode : false
					};

					viewers.forEach( function( element ) {
						var view = new ImageCompare( element, options ).mount();
					});
				}
			});
		},
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

} )( jQuery );
