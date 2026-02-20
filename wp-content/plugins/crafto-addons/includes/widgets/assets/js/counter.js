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
					'.elementor-widget-crafto-counter',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.verticalCounterInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-counter.default', CraftoAddonsInit.verticalCounterInit );
			}
		},
		verticalCounterInit: function( $scope ) {
			$scope.each( function() {
				var $scope            = $( this );
				const target          = $scope.find( '.vertical-counter-wrapper' );
				let content           = null;
				const counter         = $scope.find( '.vertical-counter' );
				const counterValue    = counter.data( 'value' );
				const individualValue = counterValue.toString().split( '' );
				const value_length    = individualValue.length;
				const wrapper         = wp.template( 'vertical-counter' );

				content = wrapper();

				if ( counter.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'appear', CraftoMain.disable_scripts ) < 0 && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
					counter.each( function() {
						for ( let i = 0; i < value_length; i++ ) {
							counter.append( content );
						}

						counter.find( '.vertical-counter-number' ).each( function( index ) {
							$( this ).attr( 'data-value', individualValue[ index ] );
						} );
					});

					function triggerCounterAnimation( counterElement ) {
						if ( counterElement.hasClass( 'appear' ) ) {
							return;
						}

						counterElement.addClass( 'appear' );
						counterElement.find( '.vertical-counter-number' ).each( function() {
							const _this = $( this );
							const value = _this.attr( 'data-value' );
							if ( value <= 9 ) {
								anime( {
									targets: this.querySelector( 'ul' ),
									translateY: [ 0, `${-value * 10}%` ],
									duration: 2000,
									easing: 'easeOutCubic'
								} );
							}
						} );
					}

					function isInViewport( element ) {
						const elementTop     = element.offset().top;
						const elementBottom  = elementTop + element.outerHeight();
						const viewportTop    = $window.scrollTop();
						const viewportBottom = viewportTop + $window.height();
						return elementBottom > viewportTop && elementTop < viewportBottom;
					}

					function checkAndTrigger() {
						counter.each( function() {
							const $elThis = $( this );
							if ( isInViewport( $elThis ) ) {
								triggerCounterAnimation( $elThis );
							}
						} );
					}

					// Initial check
					checkAndTrigger();
					$window.on( 'scroll', checkAndTrigger );

					function calculateHeight() {
						counter.each( function() {
							const $elThis  = $( this );
							const fontSize = $elThis.find( '.vertical-counter-number li' ).height();
							$elThis.height( fontSize );
						} );
					}
				
					if ( $( '.vertical-counter' ).length > 0 ) {
						calculateHeight();
						$window.on( 'resize', function() {
							calculateHeight();
						} );
					}

					$( document ).on( 'appear', '.vertical-counter', function( e ) {
						triggerCounterAnimation( $( this ) );
					} );

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

} )( jQuery );
