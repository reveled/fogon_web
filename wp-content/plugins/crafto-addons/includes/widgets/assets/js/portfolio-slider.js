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
					'.elementor-widget-crafto-portfolio-slider',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.portfolioSliderInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-portfolio-slider.default', CraftoAddonsInit.portfolioSliderInit );
			}

		},
		portfolioSliderInit: function( $scope ) {
			// Early return if Swiper not exist.
			if ( 'undefined' === typeof Swiper ) {
				return;
			}

			let tabletBreakPoint = 991;
			if ( 'undefined' !== typeof elementorFrontendConfig ) {
				if ( 'undefined' !== typeof elementorFrontendConfig.breakpoints ) {
					if ( 'undefined' !== typeof elementorFrontendConfig.breakpoints.lg ) {
						tabletBreakPoint = elementorFrontendConfig.breakpoints.lg - 1;
					}
				}
			}

			const $wpadminbar        = $( '#wpadminbar' );
			const $miniHeaderWrapper = $( '.mini-header-main-wrapper' );
			const $HeaderWrapper     = $( '.header-common-wrapper.standard' );

			function getWindowWidth() {
				return window.innerWidth;
			}

			function getWindowHeight() {
				return $window.height();
			}

			function getwpadminbarHeight() {
				let wpadminbarHeight = 0;
					wpadminbarHeight = $wpadminbar.outerHeight();
					wpadminbarHeight = Math.round( wpadminbarHeight );
				
				return wpadminbarHeight;
			}

			function getTopSpaceHeaderHeight() {
				let mini_header_height = 0,
					main_header_height = 0,
					wpadminbarHeight   = 0,
					ts_height          = 0;
				
				if ( $wpadminbar.length > 0 ) {
					wpadminbarHeight = getwpadminbarHeight();
					ts_height        = ts_height + wpadminbarHeight;
				}

				if ( $miniHeaderWrapper.length > 0 ) {
					let mini_header_object = $miniHeaderWrapper;
						mini_header_height = mini_header_object.outerHeight();
						ts_height          = ts_height + mini_header_height;
				}

				if ( $HeaderWrapper.length > 0 ) {
					let main_header_object = $HeaderWrapper;
						main_header_height = main_header_object.outerHeight();
						ts_height          = ts_height + main_header_height;
				}

				return ts_height;
			}

			function fullScreenSlideHeight() {
				/* Full Screen Slide */
				const full_screen_slide      = $( '.full-screen-slide' );
				const crafto_main_title_wrap = $( '.crafto-main-title-wrappper' );

				if ( full_screen_slide.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 ) {
					let headerHeight      = 0,
						wpadminbarHeight  = 0,
						tsFullTitleHeight = 0;
					headerHeight = getTopSpaceHeaderHeight();
					if ( $wpadminbar.length > 0 ) {
						wpadminbarHeight = getwpadminbarHeight();
					}
					if ( crafto_main_title_wrap.length > 0 ) {
						tsFullTitleHeight = crafto_main_title_wrap.outerHeight();
					}
					
					full_screen_slide.each( function() {
						let _self    = $( this );
						let _parents = _self.parents( '.e-con' );
						_parents.imagesLoaded( function() {
							let minheight = getWindowHeight();
							if ( _parents.hasClass( 'top-space' ) ) {
								minheight = minheight - tsFullTitleHeight;
								_self.css( 'height', ( minheight - headerHeight ) );
							} else {
								if ( getWindowWidth() <= tabletBreakPoint ) {
									let fulltotalHeight =  headerHeight + tsFullTitleHeight;
									_self.css( 'height', minheight - fulltotalHeight );
								} else {
									_self.css( 'height', ( minheight - wpadminbarHeight ) );
								}
							}
						});
					});
				}
			}

			$scope.each( function() {
				var $scope              = $( this );
				let element_data_id     = $scope.data( 'id' ),
					unique_id           = '.elementor-element-' + element_data_id + ' .swiper',
					target              = $( unique_id ),
					settings            = target.data( 'settings' ) || {},
					breakpointsSettings = {},
					breakpoints         = elementorFrontend.config.breakpoints;

				const $elPopup = $scope.find( '.popup-video' );
				if ( $elPopup.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
					$elPopup.off( 'click.mfp' ).on( 'click.mfp', function ( e ) {
						e.preventDefault();

						const src = $( this ).attr( 'href' ) || $( this ).data( 'src' );
						if ( ! src ) {
							return;
						}
						$.magnificPopup.open({
							items: {
								src: src,
							},
							type: 'iframe',
							mainClass: 'mfp-fade crafto-video-popup',
							removalDelay: 160,
							preloader: false,
							fixedContentPos: true,
							closeBtnInside: false,
							callbacks: {
								close: function () {
									if ( $.magnificPopup.instance ) {
										$.magnificPopup.instance._lastFocusedEl = null;
									}
								},
							},
						});
					});
				}

				/* START slider breakpoints */
				if ( 'auto' !== settings['crafto_slides_to_show'] ) {
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
				}

				/* END slider breakpoints */
				
				let swiperOptions = {
					slidesPerView: settings['crafto_slides_to_show'],
					spaceBetween: settings['crafto_items_spacing'],
					loop: 'yes' === settings['loop'],
					speed: settings['speed'],
					keyboard: {
						enabled: true,
						onlyInViewport: true
					},
					breakpoints: breakpointsSettings,
				};

				if ( 'yes' === settings['allowtouchmove'] ) {
					swiperOptions.allowTouchMove = true;
				}

				let resizeTimeout;
				swiperOptions['on'] = {
					init: function() {
						fullScreenSlideHeight(); // Apply full screen slide height
					},
					resize: function() {
						fullScreenSlideHeight(); // Apply full screen slide height
						let _this = this;
						clearTimeout( resizeTimeout );
						resizeTimeout = setTimeout( function() {
							_this.update();
						}, 100 ); // 100ms debounce
					}
				};

				if ( 'yes' === settings['navigation'] ) {
					swiperOptions.navigation = {
						prevEl: '.elementor-element-' + element_data_id + ' .elementor-swiper-button-prev',
						nextEl: '.elementor-element-' + element_data_id + ' .elementor-swiper-button-next'
					};
				}

				if ( 'yes' === settings['pagination'] && 'dots' === settings['pagination_style'] ) {
					swiperOptions.pagination = {
						el: '.elementor-element-' + element_data_id + ' .swiper-pagination',
						type: 'bullets',
						clickable: true,
						dynamicBullets: settings['navigation_dynamic_bullets'],
					};
				}

				if ( 'yes' === settings['pagination'] && 'number' === settings['pagination_style'] ) {
					swiperOptions.pagination = {
						el: '.elementor-element-' + element_data_id + ' .swiper-pagination',
						type: 'bullets',
						clickable: true,
						renderBullet: function( index, className ) {
							let pagination = index + 1;
							let pageNumber = ( pagination < 10 ) ? '0' + pagination.toString() : pagination.toString();
							return '<span class="' + className + '">' + ( pageNumber ) + '</span>';
						  },
					};
				}

				if ( 'yes' === settings['pagination'] && 'number' === settings['pagination_style'] && 'number-style-3' === settings['number_style'] ) {
					let $navNext = $( '.number-next' );
					let $navPrev = $( '.number-prev' );
					swiperOptions.pagination = {
						el: '.elementor-element-' + element_data_id + ' .swiper-pagination',
						type: 'progressbar',
						clickable: true,
					};
					swiperOptions['on'] = {
						init: function() {
							let realSlidesCount;
							if ( swiperOptions.loop ) {
								realSlidesCount = this.slides.length / ( this.params.loopAdditionalSlides + 1 );
							} else {
								realSlidesCount = this.slides.length;
							}
							if ( realSlidesCount < swiperOptions.slidesPerView ) {
								if ( $navNext.length ) $navNext.hide();
								if ( $navPrev.length ) $navPrev.hide();
								if ( this.pagination && this.pagination.el ) {
									$( this.pagination.el ).hide();
								}
							} else {
								if ( $navNext.length ) $navNext.show();
								if ( $navPrev.length ) $navPrev.show();
								if ( this.pagination && this.pagination.el ) {
									$( this.pagination.el ).show();
								}
					
								// Display the total number of slides
								$navNext.text( realSlidesCount < 10 ? '0' + realSlidesCount : realSlidesCount );
								$navPrev.text( '01' );
							}

							this.update();
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

				if ( settings['effect'] ) {
					swiperOptions.effect = settings['effect'];
				}

				if ( 'yes' === settings['centered_slides'] ) {
					swiperOptions.centeredSlides = true;
				}

				if ( typeof( settings['image_spacing'] ) !== 'undefined' &&
					settings['image_spacing']['size'] !== '' &&
					settings['image_spacing']['size'] !== null ) {
					swiperOptions.spaceBetween = settings['image_spacing']['size'];
				}

				if ( 'fade' === settings['effect'] ) {
					swiperOptions.fadeEffect = {
						crossFade: true
					};
				}

				let el_preloader_overlay = $( '.preloader-overlay' );

				if ( 'yes' === settings['autoplay'] || undefined !== swiperObj ) {
					if ( el_preloader_overlay.length > 0 ) {
						let checkPreloader = setInterval( function() {
							if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
								clearInterval( checkPreloader );

								// Update autoplay delay and restart Swiper autoplay
								swiperObj.params.autoplay = {
									delay: settings['autoplay_speed'],
								};

								swiperObj.autoplay.start(); // Ensure autoplay starts fresh

								if ( 'yes' === settings['pause_on_hover'] ) {
									$( unique_id ).on( 'mouseenter', function() {
										swiperObj.autoplay.stop();
									});
									$( unique_id ).on( 'mouseleave', function() {
										swiperObj.autoplay.start();
									});
								}
							}
						}, 10 );
					} else {
						swiperOptions.autoplay = {
							delay: settings['autoplay_speed'],
						};

						if ( 'yes' === settings['pause_on_hover'] ) {
							$( unique_id ).on( 'mouseenter', function() {
								swiperObj.autoplay.stop();
							});
							$( unique_id ).on( 'mouseleave', function() {
								swiperObj.autoplay.start();
							});
						}
					}
				}

				if ( 'yes' === settings['mousewheel'] ) {
					swiperOptions.mousewheel = true;
				}

				if ( ( 'undefined' != typeof CraftoMain ) && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
					var swiperObj = new Swiper( unique_id, swiperOptions );
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

})( jQuery );
