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
					'.elementor-widget-crafto-stack-section',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.stackSectionInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-stack-section.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.stackSectionInit );
				});
			}
		},
		stackSectionInit: function stackSectionInit() {
			stackAnimation();
			function stackAnimation() {
				var stackLastScroll = 0;
				var windowScrollTop = window.pageYOffset || document.documentElement.scrollTop;
				var el_stack_box    = $( 'div.stack-box' );

				if ( el_stack_box.length === 0 ) {
					return;
				}

				if ( getWindowWidth() > 1199 ) {
					el_stack_box.each( function() {
						let $elThis    = $( this );
						let stackItems = $elThis.find( 'div.stack-item' );

						if ( stackItems.length > 0 ) {
							if ( windowScrollTop > stackLastScroll ) {
								$elThis.addClass( 'forward' ).removeClass( 'reverse' );
							} else {
								$elThis.removeClass( 'forward' ).addClass( 'reverse' );
							}

							for ( var i = 0; i < stackItems.length - 1; i++ ) {
								var stackBoxHeight   = ( $elThis.height() / ( stackItems.length ) ) * i,
									stackTopPosition = $elThis.offset().top;

								if ( ( windowScrollTop - stackTopPosition ) > stackBoxHeight ) {
									var yMove = windowScrollTop - stackTopPosition - stackBoxHeight;
									if ( yMove > $elThis.outerHeight() ) {
										yMove = $elThis.outerHeight();
									}

									$( stackItems[i] ).css( { 'height': 'calc(100vh - ' + yMove + 'px)' } ).addClass( 'active' );
								} else {
									$( stackItems[i] ).css( { 'height': 'calc(100vh - 0px)' } ).removeClass( 'active' );
								}
							}
							for ( var k = 99,i = 0; k >= 0,i < stackItems.length; k--,i++ ) {
								$( stackItems[i] ).css( { 'z-index': + k } );
							}
						}
					});
				} else {
					$( '.stack-box div.stack-item' ).css( { 'height': 'inherit' } );
				}

				stackLastScroll = windowScrollTop;
			}

			$window.on( 'scroll', function() {
				stackAnimation();
			});

			// Get window width
			function getWindowWidth() {
				return window.innerWidth;
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

})( jQuery );
