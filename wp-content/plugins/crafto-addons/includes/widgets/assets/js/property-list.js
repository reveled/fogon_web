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
					'.elementor-widget-crafto-property',
					'.elementor-widget-crafto-archive-property',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.propertyListInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-property.default',
					'crafto-archive-property.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.propertyListInit );
				});
			}
		},
		propertyListInit: function( $scope ) {
			$scope.each( function() {
				var $scope                   = $( this );
				let property_list_grid       = $scope.find( '.crafto-property-list' ),
					element_data_id          = $scope.data( 'id' ),
					uniqueId                 = property_list_grid.data( 'uniqueid' ),
					property_settings        = property_list_grid.data( 'property-settings' ) || {},
					property_pagination_type = property_settings.pagination_type,
					property_masonry_id      = $( '.elementor-element-' + element_data_id + ' .crafto-property-list' );

				if ( typeof imagesLoaded == 'function' ) {
					property_list_grid.each( function() {
						let _this = $( this );
						_this.imagesLoaded( function() {
							_this.removeClass( 'grid-loading' );
						});
					});
				}

				// For infiniteScroll
				var $propertyinfinite;
				let property_grid_id     = property_masonry_id.parents( '.elementor-widget' ).data( 'id' ),
					elementorElement     = '.elementor-element-' + property_grid_id,
					el_grid_item         = '.' + uniqueId + ' .grid-item',
					el_navigation        = elementorElement + ' .post-infinite-scroll-pagination',
					el_navigation_anchor = elementorElement + ' .post-infinite-scroll-pagination a';

				if ( property_masonry_id.length > 0 && property_masonry_id.hasClass( 'grid-masonry' ) && 'undefined' != typeof CraftoMain && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 ) {
					property_masonry_id.imagesLoaded( function() {
						property_masonry_id.removeClass( 'grid-loading' );
						property_masonry_id.isotope( {
							layoutMode: 'masonry',
							itemSelector: '.grid-item',
							percentPosition: true,
							stagger: 0,
							masonry: {
								columnWidth: '.grid-sizer'
							}
						});

						property_masonry_id.isotope();

						setTimeout( function() {
							property_masonry_id.isotope();
						}, 500 );
					});
				} else {
					property_masonry_id.removeClass( 'grid-loading' );
					property_masonry_id.find( '.grid-item' ).removeClass( 'crafto-animated elementor-invisible' );
				}

				if ( $( el_navigation_anchor ).length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'infinite-scroll', CraftoMain.disable_scripts ) < 0 ) {
					if ( 'load-more-pagination' === property_pagination_type ) {
						$propertyinfinite = property_masonry_id.infiniteScroll( {
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
						$propertyinfinite = property_masonry_id.infiniteScroll( {
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

					$propertyinfinite.on( 'append.infiniteScroll', function( event, response, path, items ) {
						var $newPropertyPost = $( items );
						$newPropertyPost.imagesLoaded( function() {
							if ( property_masonry_id.hasClass( 'grid-masonry' ) ) {
								property_masonry_id.isotope( 'appended', $newPropertyPost );
								property_masonry_id.isotope( 'layout' );
							} else {
								property_masonry_id.append( $newPropertyPost );
							}
						});
					});

					const $elPageLoadStatus = $( '.page-load-status' );
					$propertyinfinite.on( 'last.infiniteScroll', function( event, response, path ) {
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

	// If Elementor is already initialized, manually trigger.
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
