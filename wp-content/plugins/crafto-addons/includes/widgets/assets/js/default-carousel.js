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
					'.elementor-widget-crafto-feature-box-carousel',
					'.elementor-widget-crafto-image-carousel',
					'.elementor-widget-crafto-content-slider',
					'.elementor-widget-crafto-dynamic-slider',
					'.elementor-widget-crafto-client-image-carousel',
					'.elementor-widget-crafto-blog-post-slider',
					'.elementor-widget-crafto-tours',
					'.elementor-widget-crafto-archive-tours',,
					'.elementor-widget-crafto-product-slider',
					'.elementor-widget-crafto-property-gallery-carousel',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.defaultImagecarouselInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-feature-box-carousel.default',
					'crafto-image-carousel.default',
					'crafto-content-slider.default',
					'crafto-dynamic-slider.default',
					'crafto-client-image-carousel.default',
					'crafto-blog-post-slider.default',
					'crafto-tours.default',
					'crafto-archive-tours.default',
					'crafto-product-slider.default',
					'crafto-property-gallery-carousel.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.defaultImagecarouselInit );
				});
			}
		},
		defaultImagecarouselInit: function( $scope ) {
			// Early return if Swiper not exist.
			if ( 'undefined' === typeof Swiper ) {
				return;
			}

			if ( $scope.find( '.feature-box-carousel-style-1' ).length > 0 ) {
				$scope.find( '.feature-box-carousel-style-1 img' ).attr( 'loading', 'eager' );
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
				let element_data_id     = $scope.attr( 'data-id' ),
					unique_id           = '.elementor-element-' + element_data_id + ' .swiper',
					target              = $( unique_id ),
					settings            = target.data( 'settings' ) || {},
					breakpointsSettings = {},
					breakpoints         = elementorFrontend.config.breakpoints;

				/* START slider breakpoints */
				if ( 'slider-width-auto' !== settings['auto_slide'] ) {
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

				if ( $scope.hasClass( 'el-content-carousel-style-7' ) ) {

					const $fancyTextRotator = $( '.fancy-text-rotator' );
					const animeBreakPoint   = 1199;

					$fancyTextRotator.each( function() {
						var $elThis = $( this );

						const el_preloader_overlay = $( '.preloader-overlay' );

						function carouselCheckPreloader() {
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

						if ( 'undefined' != typeof CraftoFrontend && 'undefined' != typeof CraftoMain && $elThis.length > 0  && $.inArray( 'appear', CraftoMain.disable_scripts ) < 0  && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
							if ( getWindowWidth() > animeBreakPoint ) {
								if ( '0' === CraftoFrontend.all_animations_disable ) {
									carouselCheckPreloader();
								}
							} else {
								if ( '1' === CraftoFrontend.mobile_animation_disable ) {
									if ( el_preloader_overlay.length > 0 ) {
										let checkPreloader = setInterval( function() {
											if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
												clearInterval( checkPreloader );
												$elThis.removeAttr( 'data-fancy-text' );
											}
										}, 10 );
									} else {
										$elThis.removeAttr( 'data-fancy-text' );
									}
								} else {
									carouselCheckPreloader();
								}
							}
						}
					});
				}

				let swiperOptions = {
					spaceBetween: parseInt( settings['crafto_items_spacing'] ) || 0,
					loop: 'yes' === settings['loop'],
					speed: settings['speed'],
					keyboard: {
						enabled: true,
						onlyInViewport: true
					},
					breakpoints: breakpointsSettings,
					on: {
						resize: function() {
							defaultswiperObj.update();
						}
					}
				};

				if ( 'slider-width-auto' !== settings['auto_slide'] ) {
					swiperOptions.slidesPerView = settings['crafto_slides_to_show'];
				} else {
					swiperOptions.slidesPerView = 'auto';
				}

				if ( 'yes' === settings['parallax'] ) {
					swiperOptions.parallax = true;
				} else {
					swiperOptions.parallax = false;
				}

				if ( 'yes' === settings['autoheight'] ) {
					swiperOptions.autoHeight = true;
				}

				if ( 'yes' === settings['allowtouchmove'] ) {
					swiperOptions.allowTouchMove = true;
				} else {
					swiperOptions.allowTouchMove = false;
				}

				if ( 'yes' === settings['mousewheel'] ) {
					swiperOptions.mousewheel = true;
				}

				if ( settings['effect'] ) {
					swiperOptions.effect = settings['effect'];
				}

				if ( 'fade' === settings['effect'] ) {
					swiperOptions.fadeEffect = {
						crossFade: true
					};
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

				if ( 'yes' === settings['centered_slides'] ) {
					swiperOptions.centeredSlides = true;
				}

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

				if ( 'yes' === settings['pagination'] && 'thumb' === settings['pagination_style'] ) {
					swiperOptions.pagination = {
						el: '.slider-custom-image-pagination',
						clickable: true,
						renderBullet: function( index, className ) {
							let imgSrc = $( sliderAvtarImage[ index ] ).attr( 'src' );

							let paginationHTML = '';
								paginationHTML += '<span class="cover-background ';
								paginationHTML += className;
								paginationHTML += '" style="background: url(';
								paginationHTML += imgSrc;
								paginationHTML += ')"></span>';

							return paginationHTML;
						},
					};
				}

				if ( 'vertical' === settings['direction'] ) {
					swiperOptions.iOSEdgeSwipeThreshold = 200;
					swiperOptions.touchReleaseOnEdges   = true;
				}

				if ( settings['direction'] ) {
					swiperOptions.direction = settings['direction'];
				}

				swiperOptions['on'] = {
					init: function() {
						fullScreenSlideHeight();
						if ( settings['direction'] ) {
							if ( getWindowWidth() <= tabletBreakPoint ) {
								this.changeDirection( 'horizontal' );
							} else {
								this.changeDirection( settings['direction'] );
							}
							this.update();
						}
					},
					resize: function() {
						fullScreenSlideHeight();
						if ( settings['direction'] ) {
							if ( getWindowWidth() <= tabletBreakPoint ) {
								this.changeDirection( 'horizontal' );
							} else {
								this.changeDirection( settings['direction'] );
							}

							let _this = this;
							setTimeout( function() {
								_this.update();
							}, 100 );
						}
					},
					slideChange: function() {
						let activeIndex = this.activeIndex,
							current_slide = $( this.slides[activeIndex] );

						const slidechange_shadow_animation = current_slide.find( '.shadow-animation.slider-shadow-animation' );

						if ( slidechange_shadow_animation.length === 0 ) {
							return;
						}

						if ( ! this.shadowScrollBound ) {
							$window.on( 'scroll', function() {
								slidechange_apply_shadow_effect();
							});
							this.shadowScrollBound = true;
						}

						$( this.slides ).not( current_slide ).find( '.shadow-animation.slider-shadow-animation' ).removeClass( 'shadow-in' );

						slidechange_shadow_animation.removeClass( 'shadow-in' );

						setTimeout( function() {
							slidechange_apply_shadow_effect();
						}, 600 );

						function slidechange_apply_shadow_effect() {
							current_slide.find( '.shadow-animation.slider-shadow-animation' ).each( function() {
								slider_add_box_animation_class( $( this ) );
							});
						}

						function slider_add_box_animation_class( boxObj ) {
							if ( boxObj.length > 0 ) {
								let box_w    = boxObj.width(),
									box_h    = boxObj.height(),
									offset   = boxObj.offset(),
									right    = offset.left + parseInt( box_w ),
									bottom   = offset.top + parseInt( box_h ),
									visibleX = Math.max( 0, Math.min( box_w, window.pageXOffset + window.innerWidth - offset.left, right - window.pageXOffset ) ),
									visibleY = Math.max( 0, Math.min( box_h, window.pageYOffset + window.innerHeight - offset.top, bottom - window.pageYOffset ) ),
									visible  = ( visibleX * visibleY ) / ( box_w * box_h );

								const delay = boxObj.attr( 'data-animation-delay' );

								if ( visible >= 1 ) {
									if ( typeof delay !== 'undefined' && delay > 10 ) {
										setTimeout( function() {
											boxObj.addClass( 'shadow-in' );
										}, delay );
									} else {
										boxObj.addClass( 'shadow-in' );
									}
								}
							}
						}
					}
				};

				if ( 'yes' === settings['pagination'] && 'number' === settings['pagination_style'] && 'number-style-3' === settings['number_style'] ) {
					let $element = $( '.elementor-element-' + element_data_id );
					let $navNext = $element.find( '.number-next' );
					let $navPrev = $element.find( '.number-prev' );
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

				function setMinHeight() {
					let divMax = 0;
					let $elContentCarousel = $scope.find( '.content-slider' );
					if ( $elContentCarousel.length > 0 ) {
						$elContentCarousel.css( 'min-height', '' );
						$elContentCarousel.each( function() {
							let divHeight = $( this ).outerHeight();
							if ( divHeight >= divMax ) {
								divMax = divHeight;
							}
						} );

						if ( 'yes' === settings['minheight'] ) {
							$elContentCarousel.css( 'min-height', divMax + 'px' );
						}
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
