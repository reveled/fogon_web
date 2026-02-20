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
					'.elementor-widget-crafto-testimonial-carousel',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.testimonialCarouselInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-testimonial-carousel.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.testimonialCarouselInit );
				});
			}
		},
		testimonialCarouselInit: function( $scope ) {
			// Early return if Swiper not exists.
			if ( 'undefined' === typeof Swiper ) {
				return;
			}

			$scope.each( function() {
				var $scope = $( this );

				let element_data_id     = $scope.data( 'id' ),
					unique_id           = '.elementor-element-' + element_data_id + ' .swiper',
					target              = $( unique_id ),
					sliderAvtarImage    = target.find( '.avtar-image img' ),
					settings            = target.data( 'settings' ) || {},
					breakpointsSettings = {},
					breakpoints         = elementorFrontend.config.breakpoints;

				/* START slider breakpoints */
				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.widescreen ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.widescreen.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show'] ) || 1,
						spaceBetween: parseInt( settings['crafto_items_spacing'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.laptop ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.laptop.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_widescreen'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.tablet_extra ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.tablet_extra.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_laptop'] ) || 1,
						spaceBetween: parseInt( settings['crafto_items_spacing_laptop'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.tablet ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.tablet.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_tablet_extra'] ) || 1,
						spaceBetween: parseInt( settings['crafto_items_spacing_tablet_extra'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.mobile_extra ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.mobile_extra.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_tablet'] ) || 1,
						spaceBetween: parseInt( settings['crafto_items_spacing_tablet'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.mobile ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.mobile.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_mobile_extra'] ) || 1,
						spaceBetween: parseInt( settings['crafto_items_spacing_mobile_extra'] ) || 1,
					};
				}
				if ( 'undefined' !== typeof( breakpoints.xs ) ) {
					breakpointsSettings[breakpoints.xs] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_mobile'] ) || 1,
						spaceBetween: parseInt( settings['crafto_items_spacing_mobile'] ) || 1,
					};
				}
				/* END slider breakpoints */

				let swiperOptions = {
					slidesPerView: settings[ 'crafto_slides_to_show' ],
					spaceBetween: parseInt( settings['crafto_items_spacing'] ) || 0,
					loop: 'yes' === settings['loop'],
					speed: settings['speed'],
					autoHeight: 'yes' === settings['autoheight'],
					keyboard: {
						enabled: true,
						onlyInViewport: true
					},
					breakpoints: breakpointsSettings,
				};

				if ( 'yes' === settings['allowtouchmove'] ) {
					swiperOptions.allowTouchMove = true;
				}
				if ( settings['effect'] ) {
					swiperOptions.effect = settings['effect'];
				}

				if ( 'fade' === settings['effect'] ) {
					swiperOptions.fadeEffect = {
						crossFade: true
					};
				}

				if ( 'yes' === settings['coverflowEffect'] ) {
					swiperOptions.effect = 'coverflow';
					swiperOptions.coverflowEffect = {
						rotate: 0,
						stretch: 100,
						depth: 150,
						modifier: 1.5,
						slideShadows: true
					};
				}

				if ( 'yes' === settings['centered_slides'] ) {
					swiperOptions.centeredSlides = true
				}

				let el_preloader_overlay = $( '.preloader-overlay' );

				if ( 'yes' === settings['autoplay'] || undefined !== defaultswiperObj ) {
					if ( el_preloader_overlay.length > 0 ) {
						let checkPreloader = setInterval( function() {
							if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
								clearInterval( checkPreloader );

								// Update autoplay delay and restart Swiper autoplay
								defaultswiperObj.params.autoplay = {
									delay: settings['autoplay_speed'],
									disableOnInteraction: false
								};

								defaultswiperObj.autoplay.start(); // Ensure autoplay starts fresh

								if ( 'yes' === settings['pause_on_hover'] ) {
									$( unique_id ).on( 'mouseenter', function() {
										defaultswiperObj.autoplay.stop();
									});
									$( unique_id ).on( 'mouseleave', function() {
										defaultswiperObj.autoplay.start();
									});
								}
							}
						}, 10 );
					} else {
						swiperOptions.autoplay = {
							delay: settings['autoplay_speed'],
							disableOnInteraction: false
						};

						if ( 'yes' === settings['pause_on_hover'] ) {
							$( unique_id ).on( 'mouseenter', function() {
								defaultswiperObj.autoplay.stop();
							});
							$( unique_id ).on( 'mouseleave', function() {
								defaultswiperObj.autoplay.start();
							});
						}
					}
				}

				if ( 'yes' === settings['navigation'] ) {
					swiperOptions.navigation = {
						prevEl: '.elementor-swiper-button-prev',
						nextEl: '.elementor-swiper-button-next',
					};
				}

				if ( 'yes' === settings['pagination'] && 'dots' === settings['pagination_style'] ) {
					swiperOptions.pagination = {
						el: '.swiper-pagination',
						type: 'bullets',
						clickable: true,
					};
				}

				if ( 'yes' === settings['pagination'] && 'number' === settings['pagination_style'] ) {
					swiperOptions.pagination = {
						el: '.swiper-pagination',
						type: 'bullets',
						clickable: true,
						renderBullet: function( index, className ) {
							var pagination = index + 1;
							var pageNumber = ( pagination < 10 ) ? '0' + pagination.toString() : pagination.toString();
							return '<span class="' + className + '">' + ( pageNumber ) + '</span>';
						  },
					};
				}

				if ( 'yes' === settings['pagination'] && 'thumb' === settings['pagination_style'] ) {
					swiperOptions.pagination = {
						el: '.slider-custom-image-pagination',
						clickable: true,
						renderBullet: function( index, className ) {
							var imgSrc = $( sliderAvtarImage[ index ] ).attr( 'src' );
							var paginationHTML = '';
								paginationHTML += '<span class="cover-background ';
								paginationHTML += className;
								paginationHTML += '" style="background: url(';
								paginationHTML += imgSrc;
								paginationHTML += ')"></span>';

							return paginationHTML;
						},
					};
				}

				if ( 'yes' === settings['pagination'] && 'number' === settings['pagination_style'] && 'number-style-3' === settings['number_style'] ) {
				let $navNext = $( '.number-next' );
				let $navPrev = $( '.number-prev' );

				swiperOptions.pagination = {
					el: '.swiper-pagination-wrapper .swiper-pagination',
					type: 'progressbar',
					clickable: true,
				};
				swiperOptions['on'] = {
					init: function() {
						let realSlidesCount;
						if ( swiperOptions.loop ) {
							realSlidesCount = this.slides.length / (this.params.loopAdditionalSlides + 1);
						} else {
							realSlidesCount = this.slides.length;
						}
						if ( realSlidesCount < swiperOptions.slidesPerView ) {
							if ( $navNext.length ) {
								$navNext.hide();
							}

							if ( $navPrev.length ) {
								$navPrev.hide();
							}

							if ( this.pagination && this.pagination.el ) {
								$( this.pagination.el ).hide();
							}
						} else {
							if ( $navNext.length ) {
								$navNext.show();
							}

							if ( $navPrev.length ) {
								$navPrev.show();
							}

							if ( this.pagination && this.pagination.el ) {
								$( this.pagination.el ).show();
							}
				
							// Display the total number of slides
							$navNext.text( realSlidesCount < 10 ? '0' + realSlidesCount : realSlidesCount );
							$navPrev.text( '01' );
						}
					},
					slideChange: function() {
						let activeSlide;
						if ( swiperOptions.slidesPerView > 1 ) {
							activeSlide = this.realIndex + 1; // +1 to make it 1-based
						} else {
							activeSlide = this.realIndex + 1;
						}
				
						$navPrev.each( function() {
							$( this ).text( activeSlide < 10 ? '0' + activeSlide : activeSlide );
						});
					}
				};
			}

				if ( 'undefined' != typeof CraftoMain && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
					var defaultswiperObj = new Swiper( unique_id, swiperOptions );
				}

				let setMinHeight = function() {
				let divMax                   = 0;
				let	authorDivMax             = 0;
				let $elTestimonialContent    = $scope.find( '.testimonial-carousel-content' );
				let $elTestimonialAuthorMeta = $scope.find( '.testimonials-author-meta' );

				// Find the largest object height.
				if ( $elTestimonialContent.length > 0 ) {
					$elTestimonialContent.css( 'min-height', '' );
					$elTestimonialContent.each( function() {
						let divHeight = $( this ).outerHeight();
						if ( divHeight >= divMax ) {
							divMax = divHeight
						}
					});

					if ( 'yes' === settings['minheight'] ) {
						$elTestimonialContent.css( 'min-height', divMax + 'px' );
					}
				}

				if ( $elTestimonialAuthorMeta.length > 0 ) {
					$elTestimonialAuthorMeta.css( 'min-height', '' );
					$elTestimonialAuthorMeta.each( function() {
						let authorDivHeight = $( this ).height();
						if ( authorDivHeight >= authorDivMax ) {
							authorDivMax = authorDivHeight;
						}
					});

					$elTestimonialAuthorMeta.css( 'min-height', authorDivMax + 'px' );
				}
			};
			
				$window.on( 'load resize orientationchange', function() {
					setMinHeight();
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

})( jQuery );
