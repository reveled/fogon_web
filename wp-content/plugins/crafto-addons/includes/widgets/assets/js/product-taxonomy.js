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
					'.elementor-widget-crafto-product-taxonomy',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.productTaxonomy( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-product-taxonomy.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.productTaxonomy );
				});
			}
		},
		productTaxonomy: function productTaxonomy( $scope ) {
			$scope.each( function() {
				let $scope = $( this );

				const element_data_id     = $scope.data( 'id' );
				const taxonomy_masonry_id = $( '.elementor-element-' + element_data_id + ' .product-taxonomy-list' );

				if ( taxonomy_masonry_id.length > 0 && taxonomy_masonry_id.hasClass( 'grid-masonry' ) && 'undefined' != typeof CraftoMain && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 ) {
					taxonomy_masonry_id.imagesLoaded( function() {
						taxonomy_masonry_id.removeClass( 'grid-loading' );
						taxonomy_masonry_id.isotope( {
							layoutMode: 'masonry',
							itemSelector: '.grid-item',
							percentPosition: true,
							stagger: 0,
							masonry: {
								columnWidth: '.grid-sizer'
							}
						});

						taxonomy_masonry_id.isotope();

						setTimeout( function() {
							taxonomy_masonry_id.isotope();
						}, 500 );
					});
				} else {
					taxonomy_masonry_id.removeClass( 'grid-loading' );
					taxonomy_masonry_id.find( '.grid-item' ).removeClass( 'crafto-animated elementor-invisible' );
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
