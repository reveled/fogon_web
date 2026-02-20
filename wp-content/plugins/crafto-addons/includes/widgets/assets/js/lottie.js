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
					'.elementor-widget-crafto-lottie',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.lottieInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-lottie.default', CraftoAddonsInit.lottieInit );
			}
		},
		lottieInit: function( $scope ) {
			if ( 'undefined' != typeof CraftoMain && $.inArray( 'lottie', CraftoMain.disable_scripts ) < 0 ) {
				$scope.each( function() {
					var $scope = $( this );
					let element_data_id = $scope.attr( 'data-id' ),
						unique_id       = '.elementor-element-' + element_data_id + ' .lottie-animation-wrapper',
						target          = $( unique_id ),
						settings        = target.data( 'settings' ) || {};

					const $elAnimation = $scope.find( '.lottie-animation' );

					if ( $elAnimation.length > 0 ) {
						$elAnimation.each( function() {
							let $element        = $( this ),
								animationUrl    = $element.data( 'animation-url' ),
								viewportStart   = settings[ 'viewport_start' ],
								viewportEnd     = settings[ 'viewport_end' ],
								startPoint      = settings[ 'start_point' ],
								endPoint        = settings[ 'end_point' ],
								relativeTo      = settings[ 'relative_to' ],
								reverse         = settings[ 'reverse' ],
								hoverOutAction  = settings[ 'hover_out' ];
				
							let animation = lottie.loadAnimation({
								container: this,
								loop: 'true' === settings[ 'lottie_loop' ] ? true : false,
								autoplay: false,
								renderer: settings[ 'renderer' ],
								path: animationUrl,
							});

							animation.setSpeed( settings[ 'speed' ] );

							if ( 'arriving_to_viewport' === settings[ 'trigger' ] ) {
								function checkViewport() {
									let elementTop     = $element.offset().top,
										elementHeight  = $element.outerHeight(),
										scrollTop      = $window.scrollTop(),
										viewportHeight = $window.height();

									let start = viewportStart / 100 * viewportHeight;
									let end   = viewportEnd / 100 * viewportHeight;

									if ( scrollTop + end >= elementTop && scrollTop + start <= elementTop + elementHeight ) {

										let startFrame    = ( startPoint / 100 ) * animation.totalFrames;
										let endFrame      = ( endPoint / 100 ) * animation.totalFrames;
										let repeatCount   = 0;
										const totalPlays  = parseInt( settings['number_of_time'], 0 );

										animation.playSegments( [ startFrame, endFrame ], true );

										if ( 'yes' === reverse ) {
											animation.setDirection(-1);
										}

										if ( '' !== settings[ 'number_of_time' ] && 0 !== settings[ 'number_of_time' ] ) {
											animation.addEventListener( 'loopComplete', function() {
												repeatCount++;
												if ( repeatCount >= totalPlays - 1 ) {
													animation.loop = false;
												}
											} );
										}
									} else {
										animation.stop();
									}
								}

								$window.on( 'scroll resize', checkViewport );
								checkViewport();

							}

							if ( 'on_click' === settings['trigger'] ) {
								$element.on( 'click', function() {
									let totalFrames = animation.totalFrames || animation.animationData.op;
									let startFrame  = Math.round( ( startPoint / 100 ) * totalFrames );
									let endFrame    = Math.round( ( endPoint / 100) * totalFrames );

									if ( startFrame < 0 ) {
										startFrame = 0;
									}

									if ( endFrame > totalFrames ) {
										endFrame = totalFrames;
									}

									let repeatCount   = 0;
									let numberOfTimes = parseInt( settings['number_of_time'] ) || 0;
									const totalPlays  = parseInt( settings['number_of_time'], 0 );

									// Remove previous event listener to prevent stacking
									animation.removeEventListener( 'loopComplete' );

									// Reverse direction if enabled
									if ( 'yes' === reverse ) {
										animation.setDirection( -1 );
									} else {
										animation.setDirection( 1 );
									}

									animation.goToAndPlay( startFrame, true );

									if ( 'true' === settings[ 'lottie_loop' ] ) {
										if ( numberOfTimes === 0 ) {
											// If blank or 0, set infinite loop
											animation.loop = true;
										} else {
											// Ensure animation loops the correct number of times
											animation.loop = true;
								
											animation.addEventListener( 'loopComplete', function() {
												repeatCount++;
												if ( repeatCount >= totalPlays ) {
													animation.loop = false;
													animation.stop(); // Stop animation after the final loop
												}
											});
										}
									}
								});
							}

							if ( 'on_hover' === settings['trigger'] ) {
								let numberOfTimes = parseInt( settings['number_of_time'] ) || 0;

								$element.on( 'mouseenter', function() {
									let repeatCount  = 0;
									let totalFrames  = animation.totalFrames || animation.animationData.op;
									let startFrame   = Math.round( ( startPoint / 100 ) * totalFrames );
									let endFrame     = Math.round( ( endPoint / 100 ) * totalFrames );
									const totalPlays = parseInt( settings['number_of_time'], 0 );

									// Set direction before playing
									if ( hoverOutAction === 'reverse' ) {
										animation.setDirection( 1 ); // Play forward
									}

									// Remove previous event listeners to prevent stacking
									animation.removeEventListener( 'loopComplete' );

									if ( 'true' === settings['lottie_loop'] && hoverOutAction === 'default' ) {
										if ( numberOfTimes === 0 ) {
											animation.loop = true;
										} else {
											animation.loop = true;
											animation.addEventListener( 'loopComplete', function() {
												repeatCount++;
												if ( repeatCount >= totalPlays ) {
													animation.loop = false;
													animation.stop();
												}
											});
										}
									}

									animation.playSegments( [startFrame, endFrame], true );
								});

								$element.on( 'mouseleave', function() {
									if ( hoverOutAction === 'reverse' ) {
										animation.setDirection( -1 ); // Set direction to reverse
									} else if ( hoverOutAction === 'pause' ) {
										animation.pause(); // Pause instead of stopping completely
									}
								});
							}

							if ( 'bind_to_scroll' === settings[ 'trigger' ] ) {
								function bindScroll() {
									let elementTop     = $element.offset().top,
										elementHeight  = $element.outerHeight(),
										scrollTop      = $window.scrollTop(),
										viewportHeight = $window.height(),
										start          = elementTop - ( viewportHeight * ( 1 - viewportStart / 100 ) ),
										end            = elementTop + elementHeight - ( viewportHeight * ( 1 - viewportEnd / 100 ) ),
										scrollPosition = ( scrollTop - start ) / ( end - start ),
										progress       = Math.min( Math.max( scrollPosition, 0 ), 1 );
					
									if ( relativeTo === 'viewport' ) {

									   animation.goToAndStop( progress * animation.totalFrames, true );

									} else if ( relativeTo === 'page' ) {
										let scrollTop      = $window.scrollTop(),
											documentHeight = $( document ).height(),
											viewportHeight = $window.height();

										let progress = scrollTop / ( documentHeight - viewportHeight );
										progress = Math.min( Math.max( progress, 0 ), 1) ;
			
										animation.goToAndStop( progress * animation.totalFrames, true );

									}
								}
					
								$window.on( 'scroll resize', bindScroll );

								bindScroll();
							}

							if ( 'none' === settings[ 'trigger' ] ) {
								animation.stop();
							}
						});
					}
				});
			}
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
