( function( $ ) {

	"use strict";

	const $window = $( window );

	let CraftoAddonsInit = {
		init: function init() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-vertical-portfolio.default', CraftoAddonsInit.defaultImagecarouselInit );
		},
		defaultImagecarouselInit: function( $scope ) {
			let tabletBreakPoint = 991;
			let animeBreakPoint  = 1199;

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

			let element_data_id     = $scope.data( 'id' ),
				unique_id           = '.elementor-element-' + element_data_id + ' .swiper',
				target              = $( unique_id ),
				settings            = target.data( 'settings' ) || {},
				breakpointsSettings = {},
				breakpoints         = elementorFrontend.config.breakpoints;

			if ( 0 === target.length || 'undefined' === typeof Swiper ) {
				return;
			}

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

			let swiperOptions = {
				slidesPerView: settings['crafto_slides_to_show'],
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

			if ( 'yes' === settings['parallax'] ) {
				swiperOptions.parallax = true;
			}

			if ( 'yes' === settings['autoheight'] ) {
				swiperOptions.autoHeight = true;
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
			if ( 'yes' === settings['allowtouchmove'] ) {
				swiperOptions.allowTouchMove = true;
			}
			swiperOptions['on'] = {
				init: function() {
					let activeIndex   = this.activeIndex,
						current_slide = this.slides[activeIndex];
					
					let el_preloader_overlay = $( '.preloader-overlay' );
						
					fullScreenSlideHeight();
					if ( settings['direction'] ) {
						this.changeDirection( settings['direction'] );
						this.update();
					}

					function handlePreloader() {
						if ( el_preloader_overlay.length > 0 ) {
							let checkPreloader = setInterval( function() {
								if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
									clearInterval( checkPreloader );
									$( this ).fancyTextEffectSlide( current_slide );
									$( this ).animeTextEffectSlide( current_slide );
								}
							}, 10 );
						} else {
							$( this ).fancyTextEffectSlide( current_slide );
							$( this ).animeTextEffectSlide( current_slide );
						}
					}

					if ( 'undefined' != typeof CraftoFrontend && 'undefined' != typeof CraftoMain && $.inArray( 'appear', CraftoMain.disable_scripts ) < 0  && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
						if ( getWindowWidth() > animeBreakPoint ) {
							if ( '0' === CraftoFrontend.all_animations_disable ) {
								handlePreloader();
							}
						} else {
							if ( '1' === CraftoFrontend.mobile_animation_disable ) {
								if ( el_preloader_overlay.length > 0 ) {
									let checkPreloader = setInterval( function() {
										if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
											clearInterval( checkPreloader );
											$( this ).removeAttr( 'data-anime data-fancy-text' );
										}
									}, 10 );
								} else {
									$( this ).removeAttr( 'data-anime data-fancy-text' );
								}
							} else {
								handlePreloader();
							}
						}
					}
				},
				resize: function() {
					fullScreenSlideHeight();
					if ( settings['direction'] ) {
						let _this = this;
						_this.changeDirection( settings['direction'] );
						setTimeout( function() {
							_this.update();
						}, 100 );
					}
				},
				slideChange: function() {
					let activeIndex   = this.activeIndex,
						current_slide = this.slides[activeIndex];

					let el_preloader_overlay = $( '.preloader-overlay' );

					function slideChangePreloader() {
						if ( el_preloader_overlay.length > 0 ) {
							if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
								$( this ).fancyTextEffectSlide( current_slide );
								$( this ).animeTextEffectSlide( current_slide );
							}
						} else {
							$( this ).fancyTextEffectSlide( current_slide );
							$( this ).animeTextEffectSlide( current_slide );
						}
					}

					if ( getWindowWidth() > animeBreakPoint ) {
						if ( 'undefined' != typeof CraftoMain && $.inArray( 'appear', CraftoMain.disable_scripts ) < 0  && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
							if ( 'undefined' != typeof CraftoFrontend && '0' === CraftoFrontend.all_animations_disable ) {
								slideChangePreloader();
							}
						}
					} else {
						if ( 'undefined' != typeof CraftoFrontend && '1' === CraftoFrontend.mobile_animation_disable ) {
							if ( el_preloader_overlay.length > 0 ) {
								let checkPreloader = setInterval( function() {
									if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
										clearInterval( checkPreloader );
										$( this ).removeAttr( 'data-anime data-fancy-text' );
									}
								}, 10 );
							} else {
								$( this ).removeAttr( 'data-anime data-fancy-text' );
							}
						} else {
							slideChangePreloader();
						}
					}
				}
			};

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
		}
	}

	$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );

})( jQuery );
