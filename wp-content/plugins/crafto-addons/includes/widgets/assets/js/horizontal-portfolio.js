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
					'.elementor-widget-crafto-horizontal-portfolio',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.horizontalPortfolioInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-horizontal-portfolio.default', CraftoAddonsInit.horizontalPortfolioInit );
			}
		},
		horizontalPortfolioInit: function() {
			const ThreeDLetterMenuEffect = () => {
				const $elLetterItem = $( '.letter-item' );
				if ( $elLetterItem.length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
					$elLetterItem.each( function() {
						const _self            = this;
						const MenuLink         = _self.querySelector( '.menu-item-text' );
						const MenuText         = MenuLink.querySelector( 'span' );
						const hoverReveal      = _self.querySelector( '.hover-reveal' );
						const hoverRevealInner = _self.querySelector( '.hover-reveal-inner' );
						const hoverRevealImg   = _self.querySelector( '.hover-reveal-img' );

						// Split text for animation effect
						MenuLink.innerHTML = `<span>${MenuText.innerHTML}</span><span class="clone">${MenuText.innerHTML}</span>`;
						MenuLink.querySelectorAll( 'span' ).forEach( item => {
							item.setAttribute( 'data-splitting', true );
							Splitting();
						});

						// Add hover effects
						const handleHover = ( event ) => {
							const opacity    = event.type === 'mouseenter' ? [0, 1] : 0;
							const scaleInner = event.type === 'mouseenter' ? [0.5, 1] : [1, 0.5];
							const scaleImg   = event.type === 'mouseenter' ? [2, 1] : [1, 2];
							const duration   = 1000;

							anime({
								targets: hoverReveal,
								opacity: opacity,
								duration: duration,
								easing: 'easeOutQuad',
							});

							anime({
								targets: hoverRevealInner,
								scale: scaleInner,
								easing: 'easeOutQuad',
							});

							anime({
								targets: hoverRevealImg,
								scale: scaleImg,
								easing: 'easeOutQuad',
							});
						};

						_self.addEventListener( 'mouseenter', handleHover );
						_self.addEventListener( 'mouseleave', handleHover );

						// Mousemove effect for hover reveal
						const handleMouseMove = ( e ) => {
							$elLetterItem.each( function() {
								const _self        = this;
								const hoverReveal  = _self.querySelector( '.hover-reveal' );
								const imgHeight    = hoverReveal.clientHeight;
								const imgWidth     = hoverReveal.clientWidth;
								const windowWidth  = window.innerWidth;
								const windowHeight = window.innerHeight;

								let posX = e.clientX + 20;
								let posY = e.clientY + 20;

								anime({
									targets: hoverReveal,
									translateX: posX + imgWidth > windowWidth ? e.clientX - imgWidth : posX,
									translateY: posY + imgHeight > windowHeight ? e.clientY - imgHeight : posY,
									duration: 400,
									easing: 'easeOutQuad',
								});
							});
						};

						document.addEventListener( 'mousemove', handleMouseMove );
					});
				}
			}

			ThreeDLetterMenuEffect();
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

})( jQuery );
