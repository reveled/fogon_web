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
					'.elementor-widget-crafto-sliding-box',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.SlidingboxInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-sliding-box.default', CraftoAddonsInit.SlidingboxInit );
			}
		},
		SlidingboxInit: function() {
			const slideboxstyle = () => {
				const el_sliding_box = $( '.sliding-box' );
				if ( el_sliding_box.length > 0 ) {
					el_sliding_box.each( function() {
						const $valueObj         = $( this ),
							$body_rtl           = $( 'body.rtl' ),
							$totalWidth         = $valueObj.outerWidth(),
							$slidingBoxItem     = $valueObj.find( '.sliding-box-item' ),
							slidingLength       = $slidingBoxItem.length,
							devideRightPadding  = parseInt( $valueObj.css('padding-right') ) / slidingLength,
							devideLeftPadding   = parseInt( $valueObj.css('padding-left') ) / slidingLength,
							usageWidth          = ( slidingLength * 30 ) + 30 + devideRightPadding + devideLeftPadding,
							useWidth            = $totalWidth - usageWidth,
							devideLength        = slidingLength + 1,
							devideWidth         = ( useWidth / devideLength ),
							activeWidth         = devideWidth * 2,
							$el_slidItem        = $valueObj.find( '.sliding-box-item, .sliding-box-img, .sliding-box-item .sliding-box-content' ),
							$el_slidItemContent = $valueObj.find( '.sliding-box-item .sliding-box-content' ),
							$el_slidItemActive  = $valueObj.find( '.sliding-box-item.active' );

						// Apply styles
						$el_slidItem.css( 'width', devideWidth );

						if ( $body_rtl.length > 0 ) {
							$el_slidItemContent.css( 'right', devideWidth );
						} else {
							$el_slidItemContent.css( 'left', devideWidth );
						}

						$el_slidItemActive.css( 'width', activeWidth );

						// Mouseenter handler
						$valueObj.on( 'mouseenter', '.sliding-box-item', function() {
							$slidingBoxItem.removeClass( 'active' );
							$( this ).addClass( 'active' );
							$el_slidItem.css( 'width', devideWidth );

							if ( $body_rtl.length > 0 ) {
								$el_slidItemContent.css( 'right', devideWidth );
							} else {
								$el_slidItemContent.css( 'left', devideWidth );
							}

							$valueObj.find( '.sliding-box-item.active' ).css( 'width', activeWidth );
						});
					});
				}
			};

			// Resize event with debounce
			let resizeTimeout;
			$window.on( 'resize', function() {
				clearTimeout( resizeTimeout );
				resizeTimeout = setTimeout( function() {
					slideboxstyle();
				}, 100 );
			});

			// Initial call
			slideboxstyle();
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

})( jQuery );
