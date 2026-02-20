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
					'.elementor-widget-crafto-looping-animation',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.loopingAnimationInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-looping-animation.default', CraftoAddonsInit.loopingAnimationInit );
			}
		},
		loopingAnimationInit:function() {
			const wrapperElAll = document.querySelectorAll( '.looping-wrapper' ) || false;
			if ( typeof( wrapperElAll ) != 'undefined' && wrapperElAll != null && 'undefined' != typeof CraftoMain && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
				wrapperElAll.forEach( function( wrapperEl ) {
					const numberOfEls = 100;
					const duration    = 6000;
					const delay       = duration / numberOfEls;

					let tl = anime.timeline({
						duration: delay,
						complete: function() {
							tl.restart();
						}
					});

					function createEl( i ) {
						let   el         = document.createElement( 'div' );
						const rotate     = ( 360 / numberOfEls ) * i;
						const translateY = -50;

						el.classList.add( 'el' );
						el.style.transform = 'rotate(' + rotate + 'deg) translateY(' + translateY + '%)';
						tl.add({
							begin: function() {
								anime({
									targets : el,
									rotate : [ rotate + 'deg', rotate + 10 + 'deg' ],
									translateY : [ translateY + '%', translateY + 10 + '%' ],
									scale : [ 1, 1.25 ],
									easing : 'easeInOutSine',
									direction : 'alternate',
									duration : duration * .1
								});
							}
						});

						if ( wrapperEl ) {
							wrapperEl.appendChild( el );
						}
					}

					for ( let i = 0; i < numberOfEls; i++ ) {
						createEl( i );
					}
				});
			}
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

} )( jQuery );
