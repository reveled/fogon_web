( function( $ ) {

	"use strict";

	const $window = $( window );

	let CraftoAddonsInit = {
		init: function init() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-slider.default', CraftoAddonsInit.SliderInit );
		},
		SliderInit: function( $scope ) {
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
				const full_screen_slide      = $( '.full-screen-slide' );
				const crafto_main_title_wrap = $( '.crafto-main-title-wrappper' );

				if ( full_screen_slide.length > 0 && typeof CraftoMain !== 'undefined' && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 ) {
					let headerHeight      = getTopSpaceHeaderHeight();
					let wpadminbarHeight  = $wpadminbar.length > 0 ? getwpadminbarHeight() : 0;
					let tsFullTitleHeight = crafto_main_title_wrap.length > 0 ? crafto_main_title_wrap.outerHeight() : 0;

					full_screen_slide.each(function () {
						const $elThis    = $( this );
						const $elParents = $elThis.parents( '.e-con' );

						function setSlideHeight( height ) {
							if ( $elParents.hasClass( 'top-space' ) ) {
								$elThis.css( 'height', height - headerHeight );
							} else if ( getWindowWidth() <= tabletBreakPoint ) {
								let fulltotalHeight = headerHeight + tsFullTitleHeight;
								$elThis.css( 'height', height - fulltotalHeight );
							} else {
								$elThis.css( 'height', height - wpadminbarHeight );
							}
						}

						setSlideHeight( getWindowHeight() );

						$elParents.imagesLoaded( function () {
							setSlideHeight( getWindowHeight() );
						});
					});
				}
			}

			let element_data_id = $scope.data( 'id' ),
				unique_id       = '.elementor-element-' + element_data_id + ' .swiper',
				target          = $( unique_id ),
				settings        = target.data( 'settings' ) || {};

			if ( 0 === target.length || 'undefined' === typeof Swiper ) {
				return;
			}
			if ( 'undefined' != typeof CraftoMain && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
				let swiperOptions = {
					slidesPerView: 1,
					loop: 'yes' === settings['loop'],
					parallax: 'yes' === settings['parallax'],
					keyboard: {
						enabled: true,
						onlyInViewport: true,
					},
					on: {
						resize: function() {
							defaultswiperObj.update();
						}
					}
				};
				if ( settings['speed'] ) {
					swiperOptions.speed = settings['speed'];
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
				} else {
					swiperOptions.allowTouchMove = false;
				}
				
				swiperOptions['on'] = {
					init: function() {
						let activeIndex   = this.activeIndex,
							current_slide = this.slides[activeIndex];

						let el_preloader_overlay = $( '.preloader-overlay' );

						fullScreenSlideHeight();
						if ( settings['direction'] ) {
							if ( getWindowWidth() <= tabletBreakPoint ) {
								this.changeDirection( 'horizontal' );
							} else {
								this.changeDirection( settings['direction'] );
							}
							
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
						let resizeTimeout;
						if ( settings['direction'] ) {
							let _this = this;
							if ( getWindowWidth() <= tabletBreakPoint ) {
								_this.changeDirection( 'horizontal' );
							} else {
								_this.changeDirection( settings['direction'] );
							}

							clearTimeout( resizeTimeout );
							resizeTimeout = setTimeout( function() {
								_this.update();
							}, 100 ); // 100ms debounce
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

				if ( settings['effect'] ) {
					swiperOptions.effect = settings['effect'];
				}

				if ( 'yes' === settings['centered_slides'] ) {
					swiperOptions.centeredSlides = true;
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

				if ( 'yes' === settings['mousewheel'] ) {
					swiperOptions.mousewheel = true;
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
							fullScreenSlideHeight();
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
					}
				}
				if ( 'undefined' != typeof CraftoMain && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
					var defaultswiperObj = new Swiper( unique_id, swiperOptions );
				}
			}

			// Resize event with debounce
			let resizeTimeout;
			$window.on( 'resize', function() {
				clearTimeout( resizeTimeout );
				resizeTimeout = setTimeout( function() {
					fullScreenSlideHeight();
				}, 300 ); // 300ms debounce
			});
		}
	}

	$window.on( 'elementor/frontend/init', CraftoAddonsInit.init );

} )( jQuery );
