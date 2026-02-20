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
					'.elementor-widget-crafto-video',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.videoInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-video.default', CraftoAddonsInit.videoInit );
			}
		},
		videoInit: function( $scope ) {
			$scope.each( function() {
				var $scope            = $( this );
				const videoBg         = $scope.find( '.video-bg' );
				const playButton      = $scope.find( '.video-play' );
				const videoPlayIcon   = $scope.find( '.video-play-icon' );
				const element_data_id = $scope.attr( 'data-id' );
				const unique_id       = '.elementor-element-' + element_data_id + ' .bg-video-wrapper';
				const target          = $( unique_id );
				const settings        = target.data( 'settings' ) || {};

				// Prevent default behavior for the video background click
				videoBg.on( 'click', ( e ) => e.stopPropagation() );

				// Play/Pause video logic
				playButton.on( 'click', function() {
					const isPlaying = $( this ).attr( 'playing' );

					videoBg.trigger( isPlaying ? 'pause' : 'play' );
					$( this ).attr( 'playing', !isPlaying ? 'true' : null );
					videoPlayIcon.toggleClass( 'remove-play-icon', !isPlaying );
				});

				// Initialize FitVids if required
				const elFitVideos = $( '.fit-videos' );
				if ( elFitVideos.length > 0 && ( 'undefined' != typeof CraftoMain ) && $.inArray( 'fitvids', CraftoMain.disable_scripts ) < 0 && $.fn.fitVids ) {
					elFitVideos.fitVids();
				}

				if ( 'yes' === settings['enable_bg_video'] ) {
					$scope.addClass( 'bg-video' );
				} else {
					$scope.removeClass( 'bg-video' );
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
