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
					'.elementor-widget-crafto-media-gallery',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.mediaGalleryInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-media-gallery.default', CraftoAddonsInit.mediaGalleryInit );
			}
		},
		mediaGalleryInit: function( $scope ) {
			$scope.each( function() {
				var $scope       = $( this );
				const $elGallery = $scope.find( '.image-gallery-grid' );

				if ( $elGallery.length > 0  && 'undefined' != typeof CraftoMain && $.inArray( 'imagesloaded', CraftoMain.disable_scripts ) < 0 && $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
					$elGallery.each( function() {
						let $elThis = $( this );
						$elThis.imagesLoaded( function() {
							$elThis.removeClass( 'grid-loading' );
							$elThis.isotope({
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

				// Popup
				const $elPopup = $scope.find( '.popup-youtube' );
				if ( $elPopup.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
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

				// For fit videos
				const $elFitVideos = $scope.find( '.fit-videos' );
				if ( $elFitVideos.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'fitvids', CraftoMain.disable_scripts ) < 0  && $.fn.fitVids ) {
					$elFitVideos.fitVids();
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

} )( jQuery );
