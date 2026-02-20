( function( $ ) {

	"use strict";

	const $window   = $( window );
	const $document = $( document );

	let CraftoAddonsInit = {
		init: function init() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-portfolio',
					'.elementor-widget-crafto-archive-portfolio',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.portfolioInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-portfolio.default',
					'crafto-archive-portfolio.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.portfolioInit );
				});
			}

		},
		portfolioInit: function( $scope ) {
			// Get Window Width.
			function getWindowWidth() {
				return window.innerWidth;
			}

			// For Portfolio `Transform` style.
			$document.on( 'mousemove', '.mousetip-wrapper', function( e ) {
				let $elThis = $( this );
				let mouseX  = e.pageX - $elThis.offset().left + 20;
				let mouseY  = e.pageY - $elThis.offset().top + 20;
				$elThis.find( '.caption' ).show().css( {
					top: mouseY,
					left: mouseX
				});
			});

			/* Parallax background and layout */
			const $elParallaxBackground = $( '.has-parallax-background' );
			const $elParallaxLayout     = $( '.has-parallax-layout' );
			if ( 'undefined' != typeof CraftoMain && $.inArray( 'custom-parallax', CraftoMain.disable_scripts ) < 0 && $.fn.parallax ) {
				if ( $elParallaxBackground.length > 0 ) {
					$elParallaxBackground.each( function() {
						const ratio = parseFloat( $( this ).attr( 'data-parallax-background-ratio' ) || 0.5 );
						$( this ).parallax( '50%', ratio );
					});
				}

				if ( $elParallaxLayout.length > 0 ) {
					$elParallaxLayout.each( function() {
						const ratio = parseFloat( $( this ).attr( 'data-parallax-layout-ratio' ) || 1 );
						$( this ).parallaxImg( '50%', ratio );
					});
				}
			}

			$scope.each( function() {
				var $scope = $( this );
				let target = $scope.find( '.portfolio-wrap' );
				if ( 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
					const $elPopup = $scope.find( '.popup-video' );
					if ( $elPopup.length > 0 ) {
						$elPopup.magnificPopup( {
							preloader: false,
							type: 'iframe',
							mainClass: 'mfp-fade crafto-video-popup',
							removalDelay: 160,
							fixedContentPos: true,
							closeBtnInside: false,
							disableOn: typeof CraftoFrontend !== 'undefined' ? CraftoFrontend.magnific_popup_video_disableOn : 0,
						});
					}

					const $elGridImage = $scope.find( '.grid-item .hide-image' );
					if ( $elGridImage.length > 0 ) {
						$( '.grid-item a' ).each( function() {
							let post_id = $( this ).attr( 'data-group' );
							$elGridImage.hide();
							$( 'a[data-group=' + post_id + ']' ).magnificPopup( {
								type: 'image',
								closeOnContentClick: true,
								closeBtnInside: false,
								fixedContentPos: true,
								gallery: {
									enabled: true
								},
								image: {
									titleSrc: function( item ) {
										const title   = item.el.attr( 'title' ) || '';
										const caption = item.el.attr( 'data-lightbox-caption' ) || '';
										return `${title}${caption ? `${caption}` : ''}`;
									}
								},
							});
						});
					}
				}

				const $atroposItems          = document.querySelectorAll( '.has-atropos' );
				const disable_atropos_mobile = target.data( 'crafto_portfolio_atropos_mobile' ) || {};
				if ( $atroposItems.length && 'undefined' != typeof CraftoMain && $.inArray( 'atropos', CraftoMain.disable_scripts ) < 0 ) {
					if ( 'yes' === disable_atropos_mobile && getWindowWidth() < 1200 ) {
						destroyAtropos();
					} else {
						initAtropos();
					}
				}

				function initAtropos() {
					if ( getWindowWidth() > 1199 ) {
						$atroposItems.forEach( function( atroposItem ) {
							Atropos( {
								el: atroposItem
							});
						});
					}
				}

				function destroyAtropos() {
					if ( $atroposItems.length > 0 ) {
						$atroposItems.forEach( function( atroposItem ) {
							if ( atroposItem.__atropos__ ) {
								atroposItem.__atropos__.destroy();
							}
						});
					}
				}

				if ( $scope.find( '.portfolio-animation' ).length > 0 ) {
					let skroller;
					// Function to initialize Skrollr
					function portfolioInitSkrollr() {
						skroller = skrollr.init({
							forceHeight: false,
							smoothScrollingDuration: 1000,
							mobileCheck: function() {
								return false;
							}
						});
					}

					function portfolioDestroySkrollr() {
						var portfolioSection = $( '.elementor-widget-crafto-portfolio, .elementor-widget-crafto-archive-portfolio' );
						if ( portfolioSection && typeof portfolioSection.skroller !== 'undefined' ) {
							portfolioSection.skroller.destroy();
							skroller = undefined;
						}
					}

					function portfolioReInitSkrollr() {
						portfolioDestroySkrollr();
						if ( getWindowWidth() > 1199 ) {
							setTimeout( function() {
								portfolioInitSkrollr();
							}, 1000 );
						}
					}

					function portfolioSkrollr() {
						let screenWidth             = getWindowWidth();
						let crafto_portfolio_laptop = $( $scope ).find( '.portfolio-wrap' ).data( 'laptop' );
						
						portfolioReInitSkrollr();
						$( $scope ).find( '.portfolio-item' ).each( function() {
							let $elThis              = $( this ).find( '.portfolio-animation' );
							let portfolio_desktop_bt = $elThis.data( 'dektop-bottom-top' );
							let portfolio_desktop_tb = $elThis.data( 'dektop-top-bottom' );
							let portfolio_laptop_bt  = $elThis.data( 'laptop-bottom-top' );
							let portfolio_laptop_tb  = $elThis.data( 'laptop-top-bottom' );

							if ( screenWidth <= crafto_portfolio_laptop ) {
								portfolioReInitSkrollr();
								$elThis.attr( 'data-bottom-top', portfolio_laptop_bt );
								$elThis.attr( 'data-top-bottom', portfolio_laptop_tb );
							} else if ( screenWidth > crafto_portfolio_laptop ) {
								portfolioReInitSkrollr();
								$elThis.attr( 'data-bottom-top', portfolio_desktop_bt );
								$elThis.attr( 'data-top-bottom', portfolio_desktop_tb );
							}
						});
					}

					portfolioSkrollr();
					$window.on( 'resize', function() {
						if ( $scope.hasClass( 'elementor-widget-crafto-portfolio' ) || $scope.hasClass( 'elementor-widget-crafto-archive-portfolio' ) ) {
							portfolioSkrollr();
						}
					});
				}
				
				let portfolio_settings          = target.data( 'portfolio-settings' ) || {};
				let	portfolio_justified_gallery = $( $scope ).find( '.portfolio-justified-gallery' );
				let	portfolio_pagination_type   = portfolio_settings.pagination_type;
				let	element_data_id             = $scope.attr( 'data-id' );
				let	portfolio_masonry_id        = $( '.elementor-element-' + element_data_id + ' .portfolio-wrap' );
				let	portfolio_lastRow           = portfolio_justified_gallery.data( 'last-row' ) || {};				

				if ( portfolio_masonry_id.length > 0 && ( 'undefined' != typeof CraftoMain ) && portfolio_masonry_id.hasClass( 'grid-masonry' ) && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
					let portfolio_filter = portfolio_masonry_id.not( '.portfolio-justified-gallery' ).imagesLoaded( function() {
						portfolio_masonry_id.removeClass( 'grid-loading' );
						portfolio_filter.isotope( {
							layoutMode: 'masonry',
							itemSelector: '.grid-masonry .grid-item',
							percentPosition: true,
							stagger: 0,
							masonry: {
								columnWidth: '.grid-sizer'
							}
						});

						portfolio_filter.isotope();

						setTimeout( function() {
							portfolio_filter.isotope();
						}, 500 );

						portfolio_list_animation( portfolio_masonry_id );
					});
				} else {
					portfolio_masonry_id.removeClass( 'grid-loading' );
					portfolio_masonry_id.find( '.grid-item' ).removeClass( 'crafto-animated elementor-invisible' );
				}

				let hidedefault       = true;
				const $elActiveFilter = $( '.grid-filter > li.active > span' );
				if ( $elActiveFilter.length > 0 ) {
					$elActiveFilter.each( function() {
						const selector  = $( this ).attr( 'data-filter' );
						if ( '*' != selector ) {
							hidedefault = false;
						}
					});

					default_selector( hidedefault );
				}

				const grid_selectors = $scope.find( '.grid-filter > li > span' );
				grid_selectors.on( 'click.grid-filter', function() {
					const $elThis  = $( this );
					const selector = $elThis.attr( 'data-filter' );
					const _parent  = $elThis.parent();

					let $elCraftoAnimated = $( selector ).parent().find( '.crafto-animated' );
					let $elPortfolioWrap  = $scope.find( '.portfolio-wrap' );

					if ( $elPortfolioWrap.hasClass( 'grid-masonry' ) ) {
						$elCraftoAnimated.removeAttr( 'data-animation data-animation-delay' ).removeClass( 'crafto-animated animated fadeIn elementor-invisible' );
						grid_selectors.parent().removeClass( 'active' );
						_parent.addClass( 'active' );

						// Handle filter for masonry or justified gallery
						if ( $elPortfolioWrap.hasClass( 'portfolio-justified-gallery' ) && 'undefined' != typeof CraftoMain && $.inArray( 'justified-gallery', CraftoMain.disable_scripts ) < 0 ) {
							$elPortfolioWrap.justifiedGallery({
								filter: selector
							});
						} else {
							if ( 'undefined' != typeof CraftoMain && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
								$elPortfolioWrap.isotope( { filter: selector });
							}
						}
					} else {
						// Handle filtering in non-masonry layouts
						if ( '*' != selector ) {
							$elPortfolioWrap.find( '.grid-item' ).css( 'display', 'none' );
							$elPortfolioWrap.find( selector ).css( 'display', 'block' );
						} else {
							$elPortfolioWrap.find( '.grid-item' ).css( 'display', 'block' );
						}

						$elThis.parents( '.nav-tabs' ).find( '.active' ).removeClass( 'active' );
						_parent.addClass( 'active' );
					}

					return false;
				});

				var $portfolioinfinite;
				let	portfolio_grid_id    = portfolio_masonry_id.parents( '.elementor-widget' ).data( 'id' ),
					elementorElement     = '.elementor-element-' + portfolio_grid_id,
					el_navigation        = elementorElement + ' .post-infinite-scroll-pagination',
					el_navigation_anchor = elementorElement + ' .post-infinite-scroll-pagination a',
					selectorItem         = elementorElement + ' .grid-item';

				if ( $( el_navigation_anchor ).length > 0  && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'infinite-scroll', CraftoMain.disable_scripts ) < 0 ) {
					if ( 'load-more-pagination' === portfolio_pagination_type ) {
						$portfolioinfinite =  portfolio_masonry_id.infiniteScroll( {
							path: el_navigation_anchor,
							history: false,
							navSelector: el_navigation,
							contentSelector: el_navigation,
							append: selectorItem,
							status: elementorElement + ' .page-load-status',
							scrollThreshold: false,
							button: elementorElement + ' .view-more-button'
						});

					} else {
						$portfolioinfinite =  portfolio_masonry_id.infiniteScroll( {
							path: el_navigation_anchor,
							history: false,
							navSelector: el_navigation,
							contentSelector: el_navigation,
							append: selectorItem,
							scrollThreshold: 100,
							loadOnScroll: true,
							status: elementorElement + ' .page-load-status'
						});
					}

					$portfolioinfinite.on( 'append.infiniteScroll', function( event, response, path, items ) {
						var $newportfoliogpost = $( items );
						$newportfoliogpost.imagesLoaded( function() {
							if ( portfolio_masonry_id.hasClass( 'grid-masonry' ) ) {
								portfolio_masonry_id.isotope( 'appended', $newportfoliogpost );
								portfolio_masonry_id.isotope( 'layout' );
							} else {
								portfolio_masonry_id.append( $newportfoliogpost );
							}

							portfolio_list_animation( portfolio_masonry_id );

							// Recall Justified gallery
							if ( portfolio_justified_gallery.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'justified-gallery', CraftoMain.disable_scripts ) < 0 ) {
								portfolio_justified_gallery.justifiedGallery( 'norewind' );
							}
						});
					});

					const $elPageLoadStatus = $( '.page-load-status' );
					$portfolioinfinite.on( 'last.infiniteScroll', function( event, response, path ) {
						$elPageLoadStatus.hide();
						setTimeout( function() {
							$elPageLoadStatus.show();
						}, 500 );
						setTimeout( function() { 
							$elPageLoadStatus.hide();
						}, 2500 );
					});
				}

				function default_selector( hidedefault ) {
					if ( 'undefined' != typeof CraftoMain && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
						let $elGridFilter = $( '.grid-filter' );
						if ( $elGridFilter.length > 0 ) {
							$elGridFilter.each( function() {
								let portfolio_filter    = $scope.find( $( this ).find( 'li.active span' ).attr( 'data-filter' ) );
								let portfolio_unique_id = $scope.find( $( '.portfolio-wrap' ) );

								if ( portfolio_unique_id.length > 0 && portfolio_unique_id.hasClass( 'grid-masonry' ) ) {
									portfolio_unique_id.isotope( {
										layoutMode: 'masonry',
										itemSelector: '.grid-item',
										percentPosition: true,
										masonry: {
											columnWidth: '.grid-sizer'
										},
										filter: portfolio_filter
									});
									portfolio_list_animation( portfolio_filter );
								} else {
									portfolio_unique_id.find( '.grid-item' ).removeClass( 'crafto-animated elementor-invisible' );
								}
							});
						}
					}
				}

				function portfolio_list_animation( target ) {
					const _element = target.find( '.crafto-animated' );
					if ( _element.length > 0 ) {
						let observer = new IntersectionObserver( function( entries ) {
							entries.forEach( function( entry ) {
								if ( entry.isIntersecting ) {
									let _this              = $( entry.target );
									let dataAnimation      = _this.attr( 'data-animation' ) || '';
									let dataAnimationDelay = _this.attr( 'data-animation-delay' ) || 0;

									if ( dataAnimation === '' || dataAnimation === 'none' ) {
										_this.removeClass( 'elementor-invisible' );
									} else {
										setTimeout( function() {
											_this.removeClass( 'elementor-invisible' ).addClass( 'animated ' + dataAnimation );
										}, dataAnimationDelay );
									}

									observer.unobserve( entry.target );
								}
							});
						}, { threshold: 0.1 });

						_element.each( function() {
							observer.observe( this );
						});
					}
				}

				CraftoAddonsInit.defaultJustifiedGallery( portfolio_justified_gallery, portfolio_lastRow, $scope );
			});
		},
		defaultJustifiedGallery: function( portfolio_justified_gallery, portfolio_lastRow, $scope ) {
			if ( portfolio_justified_gallery.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'justified-gallery', CraftoMain.disable_scripts ) < 0 ) {
				if ( 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 ) {
					$document.imagesLoaded( function() {
						initJustifiedGallery();
					});
				} else {

					initJustifiedGallery();
				}
			}
			function initJustifiedGallery() {
				let element_data_id = $scope.data( 'id' ),
					unique_id       = '.elementor-element-' + element_data_id + '.elementor-widget-crafto-portfolio, .elementor-element-' + element_data_id + '.elementor-widget-crafto-archive-portfolio',
					target          = $( unique_id ),
					settings        = target.data( 'settings' ) || {};

				if ( 'undefined' != typeof CraftoMain && $.inArray( 'justified-gallery', CraftoMain.disable_scripts ) < 0 ) {
					portfolio_justified_gallery.justifiedGallery( {
						rowHeight: settings['crafto_portfolio_row_height'] ? settings['crafto_portfolio_row_height'] : 500,
						maxRowHeight: false,
						captions: true,
						margins: 15,
						waitThumbnailsLoad: true,
						lastRow: portfolio_lastRow
					});
				}

				// Tooltip at cursor position
				$document.on( 'mousemove', '.jg-entry', function( e ) {
					const $elThis    = $( this );
					const $elCaption = $elThis.find( '.caption' );

					let imageWidth   = $elThis.width(),
						captionWidth = $elCaption.width(),
						parentOffset = $elThis.offset(),
						relX         = e.pageX - parentOffset.left + 20,
						relY         = e.pageY - parentOffset.top;

					if ( relX + captionWidth + 30 > imageWidth ) {
						relX = relX - captionWidth - 65;
					}

					$elThis.css( 'overflow', 'visible' );
					$elCaption.css( {
						left: relX + 'px',
						right: 'auto',
						top: relY + 'px',
						bottom: 'auto'
					});
				});

				$document.on( 'mouseleave', '.jg-entry', function() {
					const $elThis = $( this );
					$elThis.css( 'overflow', '' );
					$elThis.find( '.caption' ).css({
						left: '',
						right: '',
						top: '',
						bottom: ''
					});
				});
			}
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
