( function( $ ) {

	"use strict";

	const $window = $( window );

	let CraftoAddonsInit = {
		init: function() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-video-button',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.videoButtonInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-video-button.default', CraftoAddonsInit.videoButtonInit );
			}
		},
		videoButtonInit: function( $scope ) {
			$scope.each( function() {
				var $scope   = $( this );
				let $elPopup = $( $scope.find( '.popup-youtube' ) );
				if ( $elPopup.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
					$( document ).on( 'click', '.video-icon-box', function( e ) {
						e.preventDefault();
						let $elThis = $( this );
						if ( $elThis.hasClass( 'popup-youtube' ) ) {
							$elThis.magnificPopup( 'open' );
						}
					});

					if ( $elPopup.length > 0 ) {
						$elPopup.magnificPopup( {
							preloader: false,
							type: 'iframe',
							mainClass: 'mfp-fade crafto-video-popup',
							removalDelay: 160,
							fixedContentPos: true,
							closeBtnInside: false,
							disableOn: typeof CraftoFrontend !== 'undefined' ? CraftoFrontend.magnific_popup_video_disableOn : 0,
							iframe: {
								patterns: {
									youtube: {
										index: 'youtube.com/',
										id: function(url) {
											var m = url.match(/[\\?\\&]v=([^\\?\\&]+)/);
											if ( !m || !m[1] ) return null;
											return m[1];
										},
										src: 'https://www.youtube.com/embed/%id%?autoplay=1&controls=1&rel=0'
									}
								}
							}
						});
					}
				}
			});
		}
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
