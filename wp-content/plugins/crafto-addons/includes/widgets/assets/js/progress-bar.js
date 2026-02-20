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
					'.elementor-widget-crafto-progress-bar',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.progressBarInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-progress-bar.default', CraftoAddonsInit.progressBarInit );
			}
		},
		progressBarInit: function( $scope ) {
			$scope.each( function() {
				var $scope          = $( this );
				const $progressBars = $scope.find( '.elementor-progress-bar' );
				if ( $progressBars.length ) {
					const observer = new IntersectionObserver( entries => {
						entries.forEach( entry => {
							if ( entry.isIntersecting ) {
								const $progressBar = $( entry.target );
								$progressBar.css( 'width', $progressBar.data( 'max' ) + '%' );
								observer.unobserve( entry.target );
							}
						});
					}, { threshold: 0 });

					$progressBars.each( function() {
						observer.observe( this );
					});
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
