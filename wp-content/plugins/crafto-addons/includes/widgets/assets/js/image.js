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
					'.elementor-widget-crafto-image',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.ImageInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-image.default', CraftoAddonsInit.ImageInit );
			}
		},
		ImageInit: function( $scope ) {
			$scope.each( function() {
				var $scope = $( this );
				CraftoAddonsInit.setParallax( $scope );
				CraftoAddonsInit.handleShadowAnimation();
				
				$window.on( 'resize', CraftoAddonsInit.setParallax( $scope ) );
			});
		},
		setParallax: function( $scope ) {
			const $parallaxLiquid = $scope.find( '.has-parallax-liquid' );
			if ( $parallaxLiquid.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'parallax-liquid', CraftoMain.disable_scripts ) < 0 ) {
				$parallaxLiquid.each( function() {
					const $elThis       = $( this );
					const scale         = parseFloat( $elThis.attr( 'data-parallax-scale') || 0 );
					const scaleFraction = parseFloat( $elThis.attr( 'data-parallax-scale-fraction' ) );
					$elThis.parallaxLiquidImg( 1.5, scale, scaleFraction );
				});
			}
		},
		handleShadowAnimation: function() {
			const $shadowAnimation = $( '.elementor-widget-crafto-image .shadow-animation' );
			if ( 0 === $shadowAnimation.length ) {
				return;
			}

			$shadowAnimation.removeClass( 'shadow-in' );

			setTimeout( function() {
				CraftoAddonsInit.applyShadowEffect( $shadowAnimation );
			}, 600 );

			$window.on( 'scroll', function() {
				CraftoAddonsInit.applyShadowEffect( $shadowAnimation );
			});
		},
		applyShadowEffect: function( $shadowAnimation ) {
			$shadowAnimation.each( function() {
				CraftoAddonsInit.addBoxAnimationClass( $( this ) );
			});
		},
		addBoxAnimationClass: function( $boxObj ) {
			const boxWidth  = $boxObj.width();
			const boxHeight = $boxObj.height();
			const offset    = $boxObj.offset();
			const right     = offset.left + boxWidth;
			const bottom    = offset.top + boxHeight;

			const visibleX = Math.max( 0, Math.min( boxWidth, window.scrollX + window.innerWidth - offset.left, right - window.scrollX ) );
			const visibleY = Math.max( 0, Math.min( boxHeight, window.scrollY + window.innerHeight - offset.top, bottom - window.scrollY ) );
			const visible  = visibleX * visibleY / ( boxWidth * boxHeight );

			if ( visible >= 0.5 ) {
				const delay = parseInt( $boxObj.attr( 'data-animation-delay' ), 10 ) || 0;
				if ( delay > 10 ) {
					setTimeout( function() {
						$boxObj.addClass( 'shadow-in' );
					}, delay );
				} else {
					$boxObj.addClass( 'shadow-in' );
				}
			}
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

})(jQuery);
