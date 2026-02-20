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
					'.elementor-widget-crafto-pie-chart',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.pieChartInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-pie-chart.default', CraftoAddonsInit.pieChartInit );
			}
		},
		pieChartInit: function() {
			const charts = $( '.chart' );

			function createObserver( chart ) {
				const observer = new IntersectionObserver(
					( entries, observer ) => {
						entries.forEach( ( entry ) => {
							if ( entry.isIntersecting ) {
								animateProgressBar( chart );
								observer.unobserve( entry.target );
							}
						});
					},
					{
						threshold: 0.5
					}
				);
				observer.observe( chart );
			}

			function animateProgressBar( chart ) {
				const canvas = chart.querySelector( 'canvas' );

				if ( ! canvas ) {
					return;
				}
				const dpr        = window.devicePixelRatio || 1;
				const context    = canvas.getContext( '2d' );
				const lineWidth  = chart.getAttribute( 'data-line-width' ) || 9;
				const percent    = parseInt(chart.getAttribute( 'data-percent' ), 10) || 90;
				const trackColor = chart.getAttribute( 'data-track-color' ) || "#F01A1A";
				const startColor = chart.getAttribute( 'data-start-color' ) || "#868688";
				const endColor   = chart.getAttribute( 'data-end-color' ) || "#5758D6";
				const size       = chart.getAttribute( 'data-size' ) || 180;
				const radius     = ( size - lineWidth ) / 2;
				const center     = size / 2;	

				canvas.width  = size * dpr;
				canvas.height = size * dpr;
				canvas.style.width  = `${size}px`;
				canvas.style.height = `${size}px`;
				context.scale(dpr, dpr);

				context.beginPath();
				context.arc( center, center, radius, 0, 2 * Math.PI );
				context.lineWidth = lineWidth;
				context.strokeStyle = trackColor;
				context.stroke();

				function drawProgressBar( currentPercent ) {
					context.clearRect( 0, 0, canvas.width, canvas.height );

					context.beginPath();
					context.arc( center, center, radius, 0, 2 * Math.PI );
					context.lineWidth = lineWidth;
					context.strokeStyle = trackColor;
					context.stroke();

					context.beginPath();
					context.arc( center, center, radius, 0, ( 2 * Math.PI * currentPercent ) / 100 );
					context.lineWidth = lineWidth;
					context.lineCap = 'round';
					const gradient = context.createLinearGradient( 0, 0, size, size );
					gradient.addColorStop( 1, startColor );
					gradient.addColorStop( 0, endColor );
					context.strokeStyle = gradient;
					context.stroke();

					chart.querySelector( '.percent' ).textContent = Math.round( currentPercent ) + '%';
				}

				let currentPercent = 0;
				const animationDuration = 1500;
				const stepTime = 10;
				const increment = ( percent / animationDuration ) * stepTime;

				function animate() {
					if ( currentPercent < percent ) {
						currentPercent += increment;
						drawProgressBar( currentPercent );
						requestAnimationFrame( animate );
					} else {
						drawProgressBar( percent );
					}
				}

				animate();
			}

			charts.each( function() {
				createObserver( this );
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

})( jQuery );
