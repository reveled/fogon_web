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
					'.elementor-widget-crafto-marquee-slider',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.defaultImagecarouselInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-marquee-slider.default', CraftoAddonsInit.defaultImagecarouselInit );
			}
		},
		defaultImagecarouselInit: function( $scope ) {
			// Early return if Swiper not exists.
			if ( 'undefined' === typeof Swiper ) {
				return;
			}

			$scope.each( function() {
				var $elThis             = $( this );
				let element_data_id     = $elThis.attr( 'data-id' ),
					unique_id           = '.elementor-element-' + element_data_id + ' .swiper',
					target              = $( unique_id ),
					settings            = target.data( 'settings' ) || {},
					breakpointsSettings = {},
					breakpoints         = elementorFrontend.config.breakpoints;

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.widescreen ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.widescreen.value+1] = {
						spaceBetween: parseInt( settings['crafto_items_spacing'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.tablet_extra ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.tablet_extra.value+1] = {
						spaceBetween: parseInt( settings['crafto_items_spacing_laptop'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.tablet ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.tablet.value+1] = {
						spaceBetween: parseInt( settings['crafto_items_spacing_tablet_extra'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.mobile_extra ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.mobile_extra.value+1] = {
						spaceBetween: parseInt( settings['crafto_items_spacing_tablet'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.mobile ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.mobile.value+1] = {
						spaceBetween: parseInt( settings['crafto_items_spacing_mobile_extra'] ) || 1,
					};
				}

				if ('undefined' !== typeof( breakpoints.xs ) ) {
					breakpointsSettings[breakpoints.xs] = {
						spaceBetween: parseInt( settings['crafto_items_spacing_mobile'] ) || 1,
					};
				}

				let swiperOptions = {
					slidesPerView: 'auto',
					loop: 'yes',
					autoplay: 'yes',
					speed: settings['speed'],
					centeredSlides: true,
					allowTouchMove: false,
					breakpoints: breakpointsSettings,
					keyboard: {
						enabled: true,
						onlyInViewport: true
					},
					on: {
						resize: function() {
							defaultswiperObj.update();
						}
					}
				};

				if ( 'undefined' != typeof( settings['image_spacing'] ) && '' !== settings['image_spacing']['size'] && null !== settings['image_spacing']['size'] && 'yes' !== settings['slider_separator'] ) {
					swiperOptions.spaceBetween = settings['image_spacing'];
				}

				if ( settings['effect'] ) {
					swiperOptions.effect = 'slide';
				}

				swiperOptions.autoplay = {
					delay: 0,
					disableOnInteraction: false,
				};

				if ( 'yes' === settings['pause_on_hover'] ) {
					$( target ).on( 'mouseenter', function() {
						defaultswiperObj.autoplay.stop();
					});
					$( target ).on( 'mouseleave', function() {
						defaultswiperObj.autoplay.start();
					});
				}

				if ( 'undefined' != typeof CraftoMain && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
					var defaultswiperObj = new Swiper( unique_id, swiperOptions );
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
