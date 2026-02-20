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
					'.elementor-widget-crafto-instagram',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.instagramInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-instagram.default', CraftoAddonsInit.instagramInit );
			}
		},
		instagramInit: function( $scope ) {
			$scope.each( function() {
				var $scope    = $( this );
				const $target = $scope.find( '.instagram-feed-masonry' );

				CraftoAddonsInit.defaultSwiperSlider( $scope );
				if ( $target.length > 0 ) { 
					CraftoAddonsInit.defaultIsotope( $scope );
				}
			});
		},
		defaultSwiperSlider: function( $scope ) {
			let tabletBreakPoint = 991;
			if ( 'undefined' !== typeof elementorFrontendConfig ) {
				if ( 'undefined' !== typeof elementorFrontendConfig.breakpoints ) {
					if ( 'undefined' !== typeof elementorFrontendConfig.breakpoints.lg ) {
						tabletBreakPoint = elementorFrontendConfig.breakpoints.lg - 1;
					}
				}
			}

			let element_data_id     = $scope.attr( 'data-id' ),
				unique_id           = '.elementor-element-' + element_data_id + ' .swiper',
				target              = $( unique_id ),
				settings            = target.data( 'settings' ) || {},
				breakpointsSettings = {},
				breakpoints         = elementorFrontend.config.breakpoints;

			if ( 'undefined' != typeof CraftoMain && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
				/* START slider breakpoints */
					if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.widescreen ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.widescreen.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show'] ) || 1,
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
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.tablet ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.tablet.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_tablet_extra'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.mobile_extra ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.mobile_extra.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_tablet'] ) || 1,
					};
				}

				if ( 'undefined' !== typeof( elementorFrontend.config.responsive.breakpoints.mobile ) ) {
					breakpointsSettings[elementorFrontend.config.responsive.breakpoints.mobile.value+1] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_mobile_extra'] ) || 1,
					};
				}

				if ('undefined' !== typeof( breakpoints.xs ) ) {
					breakpointsSettings[breakpoints.xs] = {
						slidesPerView: parseInt( settings['crafto_slides_to_show_mobile'] ) || 1,
					};
				}

				let swiperOptions = {
					slidesPerView: settings['slides_to_show'],
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
				
				if ( settings['direction'] ) {

					swiperOptions.direction = settings['direction'];

					swiperOptions['on'] = {
						init: function() {
							let _this = this;
							if ( getWindowWidth() <= tabletBreakPoint ) {
								_this.changeDirection( 'horizontal' );
							} else {
								_this.changeDirection( settings['direction'] );
							}
							_this.update();
						},
						resize: function() {
							let _this = this;
							if ( getWindowWidth() <= tabletBreakPoint ) {
								_this.changeDirection( 'horizontal' );
							} else {
								_this.changeDirection( settings['direction'] );
							}
							setTimeout( function() {
								_this.update();
							}, 100 );
						}
					};
				}
				if ( 'yes' === settings['allowtouchmove'] ) {
					swiperOptions.allowTouchMove = true;
				}
				if ( 'undefined' !== typeof( settings['image_spacing'] ) && '' !== settings['image_spacing']['size'] && null !== settings['image_spacing']['size'] ) {
					swiperOptions.spaceBetween = settings['image_spacing']['size'];
				}

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

				if ( 'yes' === settings['autoplay'] ) {
					if ( el_preloader_overlay.length > 0 ) {
						let checkPreloader = setInterval( function() {
							if ( el_preloader_overlay.css( 'display' ) === 'none' ) {
								clearInterval( checkPreloader );

								// Update autoplay delay and restart Swiper autoplay
								defaultswiperObj.params.autoplay = {
									delay: settings['autoplay_speed'],
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
		},
		defaultIsotope: function( target, itemSelector, columnWidth  ) { // Common FUNC. for isotop
			if ( target.length === 0 ) {
				return;
			}

			if ( ! itemSelector ) {
				itemSelector = '.grid-item';
			}

			if ( ! columnWidth ) {
				columnWidth = '.grid-sizer';
			}
			if ( ( undefined !== typeof CraftoMain ) &&
				$.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 &&
				$.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
				target.imagesLoaded( function() {
					target.isotope( {
						layoutMode: 'masonry',
						itemSelector: itemSelector,
						percentPosition: true,
						stagger: 0,
						masonry: {
							columnWidth: columnWidth
						}
					});
					target.isotope();

					setTimeout( function() {
						target.isotope();
					}, 500 );
				});
			}

			// Resize event with debounce
			let resizeTimeout;
			$window.on( 'resize', function() {
				if ( ! $( 'body' ).hasClass( 'elementor-editor-active' ) ) {
					clearTimeout( resizeTimeout );
					resizeTimeout = setTimeout( function() {
						if ( target.length > 0 &&
							( undefined !== typeof CraftoMain ) &&
							$.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 &&
							$.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
							target.imagesLoaded( function() {
								target.isotope( 'layout' );
							});
						}
					}, 500 );
				}
			});
		},
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
