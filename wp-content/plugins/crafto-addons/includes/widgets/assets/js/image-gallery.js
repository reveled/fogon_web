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
					'.elementor-widget-crafto-image-gallery',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.ImageGalleryInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-image-gallery.default', CraftoAddonsInit.ImageGalleryInit );
			}
		},
		ImageGalleryInit:function( $scope ) {
			$scope.each( function() {
				var $scope       = $( this );
				const $elGallery = $scope.find( '.image-gallery-grid' );
				if ( $elGallery.length > 0  && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
					$elGallery.each( function() {
						let _this = $( this );
						_this.imagesLoaded( function() {
							_this.removeClass( 'grid-loading' );
							_this.isotope({
								layoutMode: 'masonry',
								itemSelector: '.grid-item',
								percentPosition: true,
								stagger: 0,
								masonry: {
									columnWidth: '.grid-sizer',
								}
							});
						});
					});
				}

				craftoAnimations();
				function craftoAnimations() {
					const elements = document.getElementsByClassName( 'crafto-animated' );
					Array.from( elements).forEach( function( element ) {
						let dataAnimation      = ( element.getAttribute( 'data-animation' ) || '' ).trim();
						let dataAnimationDelay = parseInt( element.getAttribute( 'data-animation-delay' ), 10 ) || 0;
				
						if ( ! dataAnimation || dataAnimation === 'none' ) {
							element.classList.remove( 'elementor-invisible' );
							return;
						}

						setTimeout( function() {
							element.classList.remove( 'elementor-invisible' );
							let validClasses = dataAnimation.split( ' ' ).filter( Boolean );
							if ( validClasses.length ) {
								element.classList.add( 'animated', ...validClasses );
							} else {
								console.warn( 'Invalid animation class name:', dataAnimation );
							}
						}, dataAnimationDelay );
					});
				}

				const $target          = $scope.find( '.image-gallery-grid' );
				const $elAtroposMobile = $target.data( 'crafto_image_atropos_mobile' ) || {};
				const $atroposItems    = document.querySelectorAll( '.has-atropos' );

				if ( 'yes' === $elAtroposMobile && getWindowWidth() < 1200 ) {
					destroyAtropos();
				} else {
					initAtropos();
				}

				function initAtropos() {
					if ( $atroposItems.length > 0 && getWindowWidth() > 1199 ) {
						$atroposItems.forEach( function( atroposItem ) {
							let myAtropos = Atropos({
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
			});

			function getWindowWidth() {
				return window.innerWidth;
			}
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

} )( jQuery );
