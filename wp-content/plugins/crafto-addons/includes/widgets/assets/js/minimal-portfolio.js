( function( $ ) {

	"use strict";

	let CraftoAddonsInit = {
		init: function init() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-minimal-portfolio.default', CraftoAddonsInit.minimalPortfolioInit );
		},
		minimalPortfolioInit: function minimalPortfolioInit() {
			
			const sticky_container = document.querySelector( '.portfolio-minimal-wrapper' );

			if ( typeof( sticky_container ) != 'undefined' && sticky_container != null ) {

				let winsize;

				const calcWinsize = () => winsize = {
					width: window.innerWidth,
					height: window.innerHeight
				};

				calcWinsize();

				window.addEventListener( 'resize', calcWinsize );

				class Menu {
					constructor() {
						this.DOM = {
							menu: document.querySelector( '.portfolio-minimal-wrapper .portfolio-box' )
						};

						this.DOM.menuLinks = [...this.DOM.menu.querySelectorAll( '.portfolio-item' )];

						this.mousePos = {
							x: winsize.width / 2,
							y: winsize.height / 2
						};

						this.lastMousePos = {
							translation: {
								x: winsize.width / 2,
								y: winsize.height / 2
							},
							displacement: {
								x: 0,
								y: 0
							}
						};
						this.dmScale = 0;
						this.current = -1;
						
						if ( 'undefined' != typeof CraftoMain && $.inArray( 'anime', CraftoMain.disable_scripts ) < 0 ) {
							this.initEvents();
						}
						
						requestAnimationFrame( () => this.render() );
					}

					initEvents() {
						document.body.style.setProperty( 'background-color', this.DOM.menuLinks[0].getAttribute( 'data-bg' ) )
						let active_item;

						this.DOM.menuLinks.forEach( ( item, i ) => {
							let imgPath = item.getAttribute( 'data-img' );
							let bgColor = item.getAttribute( 'data-bg' );

							item.querySelector( '.svg-wrapper' ).innerHTML = `
								<svg class="distort" width="960" height="980" viewBox="0 0 960 980">
									<filter id="distortionFilter${i}">
										<feTurbulence type="fractalNoise" baseFrequency="0.01 0.003" numOctaves="5" seed="2" stitchTiles="noStitch" x="0%" y="0%" width="100%" height="100%" result="noise"/>
										<feDisplacementMap in="SourceGraphic" in2="noise" scale="0" xChannelSelector="R" yChannelSelector="B" x="0%" y="0%" width="100%" height="100%" filterUnits="userSpaceOnUse"/>
									</filter>
									<g filter="url(#distortionFilter${i})">
										<image class="distort__img" x="80" y="0" xlink:href="${imgPath}" height="980" width="960" />
									</g>
								</svg>
							`
							const displaceMentEl = [...item.querySelectorAll( 'feDisplacementMap' )];

							item.addEventListener( 'mouseenter', () => {
								item.closest( '.portfolio-box' ).childNodes.forEach(item => item.classList && item.classList.remove( 'active' ) )
								item.classList.add( 'active' );
								if ( item !== active_item ) {
									anime({
										targets: displaceMentEl,
										scale: [
											{
												value: 50,
												duration: 0
											},
											{
												value: 0.3,
												duration: 1200
											}
										],
										easing: 'easeInOutQuad'
									});
								}
								document.body.style.setProperty( 'background-color', bgColor )
								active_item = item;
							});

							item.addEventListener( 'mouseleave', () => {
								active_item = item;
							})
						});
					}
					render() {
						requestAnimationFrame( () => this.render() );
					}
				}

				new Menu();
			}
		}
	};
	
	$( window ).on( 'elementor/frontend/init', CraftoAddonsInit.init );

})( jQuery );
