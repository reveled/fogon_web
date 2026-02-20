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
					'.elementor-widget-crafto-product-list',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.productList( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-product-list.default', CraftoAddonsInit.productList );
			}
		},
		productList: function productList( $scope ) {
			$scope.each( function() {
				var $scope            = $( this );
				const element_data_id = $scope.data( 'id' );
				const list_masonry_id = $( '.elementor-element-' + element_data_id + ' .shop-wrapper' );

				if ( list_masonry_id.length > 0 && list_masonry_id.hasClass( 'grid-masonry' ) && 'undefined' != typeof CraftoMain && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 ) {
					list_masonry_id.imagesLoaded( function() {
						list_masonry_id.removeClass( 'grid-loading' );
						list_masonry_id.isotope( {
							layoutMode: 'masonry',
							itemSelector: '.grid-item',
							percentPosition: true,
							stagger: 0,
							masonry: {
								columnWidth: '.grid-sizer'
							}
						});

						list_masonry_id.isotope();

						setTimeout( function() {
							list_masonry_id.isotope();
						}, 500 );

					});
				} else {
					list_masonry_id.removeClass( 'grid-loading' );
					list_masonry_id.find( '.grid-item' ).removeClass( 'crafto-animated elementor-invisible' );
				}

				const $elShopHover = $scope.find( '.shop-hover' );
				if ( $elShopHover.length > 0 ) {
					$elShopHover.each( function() {
						let $elThis     = $( this );
						let tooltip_pos = $elThis.data( 'tooltip-position' );
						if ( tooltip_pos != '' && tooltip_pos != undefined ) { // Check tooltip position
							$elThis.find( 'a i' ).each( function() {
								let $icon = $( this );
								$icon.attr({
									'data-bs-placement': tooltip_pos,
									'data-bs-toggle': 'tooltip'
								});
								if ( typeof bootstrap !== 'undefined' && bootstrap.Tooltip ) {
                                    new bootstrap.Tooltip( $icon[0] );
                                }
							});
						}
					});
				}

				// For infiniteScroll
				var $productinfinite;
				let product_grid_id         = list_masonry_id.parents( '.elementor-widget' ).data( 'id' ),
					elementorElement        = '.elementor-element-' + product_grid_id,
					product_list_grid       = $scope.find( '.shop-wrapper' ),
					uniqueId                = product_list_grid.data( 'uniqueid' ),
					el_grid_item            = '.' + uniqueId + ' .grid-item',
					el_navigation           = elementorElement + ' .post-infinite-scroll-pagination',
					product_settings        = product_list_grid.data( 'product-settings' ) || {},
					product_pagination_type = product_settings.pagination_type,
					el_navigation_anchor    = elementorElement + ' .post-infinite-scroll-pagination a';

				if ( $( el_navigation_anchor ).length > 0 && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'infinite-scroll', CraftoMain.disable_scripts ) < 0 ) {
					if ( 'load-more-pagination' === product_pagination_type ) {
						$productinfinite = list_masonry_id.infiniteScroll( {
							path: el_navigation_anchor,
							history: false,
							navSelector: el_navigation,
							contentSelector: el_navigation,
							append: el_grid_item,
							status: '.page-load-status',
							scrollThreshold: false,
							loadOnScroll: false,
							button: '.view-more-button',
						});
					} else {
						$productinfinite = list_masonry_id.infiniteScroll( {
							path: el_navigation_anchor,
							history: false,
							navSelector: el_navigation,
							contentSelector: el_navigation,
							append: el_grid_item,
							status: '.page-load-status',
							scrollThreshold: 100,
							loadOnScroll: true,
						});
					}

					$productinfinite.on( 'append.infiniteScroll', function( event, response, path, items ) {
						var $newProductPost = $( items );
						$newProductPost.imagesLoaded( function() {
							if ( list_masonry_id.hasClass( 'grid-masonry' ) ) {
								list_masonry_id.isotope( 'appended', $newProductPost );
								list_masonry_id.isotope( 'layout' );
							} else {
								list_masonry_id.append( $newProductPost );
							}
						});
					});

					const $elPageLoadStatus = $( '.page-load-status' );
					$productinfinite.on( 'last.infiniteScroll', function( event, response, path ) {
						$elPageLoadStatus.hide();
						setTimeout( function() {
							$elPageLoadStatus.show();
						}, 500 );
						setTimeout( function() { 
							$elPageLoadStatus.hide();
						}, 2500 );
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
