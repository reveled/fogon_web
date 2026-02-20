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
					'.elementor-widget-crafto-tabs',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.tabsInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-tabs.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.tabsInit );
				});
			}
		},
		tabsInit: function() {
			const contentSection  = $( '.section' );
			const navigationLinks = $( '.nav-tabs .tab-link' );
			if ( navigationLinks.length > 0 && $( '.tab-style-11' ).length > 0 ) {
				navigationLinks.on( 'click', function( event ) {
					event.preventDefault();
					const target = $( this.hash );
					updateURL( this.hash );
					focusToActiveSection( target );
				});

				$window.on( 'scroll resize', function() {
					updateNavigation();
				});

				updateNavigation();
				function updateNavigation() {
					var scrollPos    = $window.scrollTop();
					var windowHeight = $window.height();

					contentSection.each( function() {
						let $elThis       = $( this );
						var sectionTop    = $elThis.offset().top;
						var sectionBottom = sectionTop + $elThis.outerHeight();
						var sectionName   = $elThis.attr( 'id' );
						var navLink       = $( '.nav a[href="#' + sectionName + '"]' );

						if ( scrollPos + windowHeight / 2 >= sectionTop && scrollPos + windowHeight / 2 <= sectionBottom ) {
							navigationLinks.removeClass( 'active' );
							navLink.addClass( 'active' );
							updateURL( `#${sectionName}` );
						}
					});
				}

				function updateURL(hash) {
					if ( history.pushState ) {
						history.replaceState( null, null, hash );
					} else {
						window.location.hash = hash;
					}
				}
	
				function focusToActiveSection( target ) {
					if ( target.length ) {
						const $wpadminbar      = $( '#wpadminbar' );
						const wpadminbarHeight = $wpadminbar.outerHeight();

						var content_height = $wpadminbar.length > 0 ? wpadminbarHeight : 0;

						const targetOffset = target.offset().top - content_height;
						
						window.scrollTo({
							top: targetOffset,
							behavior: 'smooth'
						});
				
						setTimeout(() => {
							if ( ! target.is( '[tabindex]' ) ) {
								target.attr( 'tabindex', '-1' );
							}
							target.focus();
							target.on( 'blur', function() {
								target.removeAttr( 'tabindex' );
							});
						}, 1000 );
					}
				}
			}

			$( 'a[data-bs-toggle="tab"]' ).on( 'shown.bs.tab', function( e ) {
				let $elThis  = $( this ),
					hrefAttr = $elThis.attr( 'href' ),
					_parents = $elThis.parents( '.crafto-tabs' );
			
				let product_list_filter_grid = _parents.find( hrefAttr ).find( '.elementor-widget-crafto-product-list' ),
					list_masonry_id          = product_list_filter_grid.find( '.grid-masonry' );

				if ( list_masonry_id.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
					list_masonry_id.imagesLoaded( function() {
						list_masonry_id.isotope( {
							layoutMode: 'masonry',
							transitionDuration: 0,
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
				}

				let $elMasonry = $( '.crafto-tabs .grid-masonry' );
				if ( $elMasonry.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
					$window.on( 'resize', function() {
						setTimeout( function() {
							$elMasonry.each( function() {
								let $tabs = $( this ); // Reference the tabs element
								if ( $tabs.length > 0 ) {
									$tabs.imagesLoaded( function() {
										$tabs.isotope( 'layout' ); // Use $tabs instead of $(this)
									});
								}
							});
						}, 500 );
					});
				}

				let widget_crafto_counter = _parents.find( hrefAttr ).find( '.elementor-widget-crafto-counter' ),
					vertical_counter      = widget_crafto_counter.find( '.vertical-counter' );

				if ( vertical_counter.length > 0 ) {
					const activeTabPane = $( `${ $( this ).attr( 'href' ) }` );
					activeTabPane.find( '.vertical-counter' ).each( function() {
						const $elThis   = $( this );
						const $elValue  = $elThis.data( 'value' );
						const divHeight = $elThis.find( 'li' ).height();
						$elThis.height( divHeight );

						if ( $elValue <= 9 ) {
							$elThis.find( 'ul' ).css( { 'transform': 'translateY(-' + $elValue * 10 + '%)' } );
						}
					});

					$( '.vertical-counter' ).each( function() {
						$( this ).appear();
						$window.trigger( 'resize' );
					});

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

})(	jQuery );
