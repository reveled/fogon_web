( function( $ ) {

	"use strict";

	const $window = $( window );

	var CraftoAddonsInit = {
		init: function init() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-tours',
					'.elementor-widget-crafto-archive-tours',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.tourListInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-tours.default',
					'crafto-archive-tours.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.tourListInit );
				});
			}
		},
		tourListInit: function( $scope ) {
			$scope.each( function() {
				var $scope          = $( this );
				let element_data_id = $scope.attr( 'data-id' ),
					tour_masonry_id = $( '.elementor-element-' + element_data_id + ' .grid' );

				if ( tour_masonry_id.length > 0 && tour_masonry_id.hasClass( 'grid-masonry' ) && 'undefined' != typeof CraftoMain && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 ) {
					tour_masonry_id.imagesLoaded( function() {
						tour_masonry_id.removeClass( 'grid-loading' );
						tour_masonry_id.isotope( {
							layoutMode: 'masonry',
							itemSelector: '.grid-item',
							percentPosition: true,
							stagger: 0,
							masonry: {
								columnWidth: '.grid-sizer'
							}
						});

						tour_masonry_id.isotope();

						setTimeout( function() {
							tour_masonry_id.isotope();
						}, 500 );

					});
				} else {
					tour_masonry_id.removeClass( 'grid-loading' );
					tour_masonry_id.find( '.grid-item' ).removeClass( 'crafto-animated elementor-invisible' );
				}

				let tour_list_grid       = $scope.find( '.crafto-tour-list' ),
					uniqueId             = tour_list_grid.data( 'uniqueid' ),
					tour_settings        = tour_list_grid.data( 'tour-settings' ) || {},
					tour_pagination_type = tour_settings.pagination_type;

				// For infiniteScroll
				var $tourinfinite
				let tour_grid_id         = tour_masonry_id.parents( '.elementor-widget' ).data( 'id' ),
					elementorElement     = '.elementor-element-' + tour_grid_id,
					el_grid_item         = '.' + uniqueId + ' .grid-item',
					el_navigation        = elementorElement + ' .post-infinite-scroll-pagination',
					el_navigation_anchor = elementorElement + ' .post-infinite-scroll-pagination a';

				if ( $( el_navigation_anchor ).length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'infinite-scroll', CraftoMain.disable_scripts ) < 0 ) {
					if ( 'load-more-pagination' === tour_pagination_type ) {
						$tourinfinite = tour_masonry_id.infiniteScroll( {
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
						$tourinfinite = tour_masonry_id.infiniteScroll( {
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

					$tourinfinite.on( 'append.infiniteScroll', function( event, response, path, items ) {
						var $newtourpost = $( items );
						$newtourpost.imagesLoaded( function() {
							if ( tour_masonry_id.hasClass( 'grid-masonry' ) ) {
								tour_masonry_id.isotope( 'appended', $newtourpost );
								tour_masonry_id.isotope( 'layout' );
							} else {
								tour_masonry_id.append( $newtourpost );
							}
						});
					});

					const el_page_load_status = $( '.page-load-status' );
					$tourinfinite.on( 'last.infiniteScroll', function( event, response, path ) {
						el_page_load_status.hide();
						setTimeout( function() {
							el_page_load_status.show();
						}, 500 );
						setTimeout( function() { 
							el_page_load_status.hide();
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
