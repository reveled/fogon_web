( function( $ ) {

	"use strict";

	const $window   = $( window );
    const $document = $( document );

    let CraftoAddonsInit = {
        init: function init() {
			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy ) {
				if ( typeof elementorFrontend === 'undefined' ) {
					return;
				}
			}

			if ( typeof CraftoMain !== 'undefined' && '1' === CraftoMain.craftoDelay && 'delay' === CraftoMain.craftoLoadStrategy && ! elementorFrontend.isEditMode() ) {
				const widgets = [
					'.elementor-widget-crafto-back-to-top',
				];
				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.BacktotopInit( $( element ) );
					}
				});
			} else {
				elementorFrontend.hooks.addAction( 'frontend/element_ready/crafto-back-to-top.default', CraftoAddonsInit.BacktotopInit );
			}
		},
        BacktotopInit: function( $scope ) {
            let $elScrollTopArrow = $( '.crafto-scroll-top-arrow' );
            $window.on( 'scroll', function() {
                const scrollTop = $document.scrollTop();
                if ( scrollTop > 150 ) {
                    $elScrollTopArrow.addClass( 'visible' );
                } else {
                    $elScrollTopArrow.removeClass( 'visible' );
                }
            });

             $document.on( 'click', '.crafto-scroll-top-arrow, .crafto-scroll-top', function( e ) {
            	e.preventDefault();
               	$( 'html, body' ).animate({
				    scrollTop: 0
				}, 800 );
            });

            function scrollIndicator() {
                const el_scroll_progress = $( '.crafto-scroll-progress' );
                const scrollTop          = document.documentElement.scrollTop;

                if ( el_scroll_progress.length > 0 ) {
                    el_scroll_progress.toggleClass( 'visible', scrollTop > 200 );
                    const scrollHeight     = document.documentElement.scrollHeight;
                    const windowHeight     = document.documentElement.clientHeight;
                    const maxScrollTop     = scrollHeight - windowHeight;
                    const scrollPercentage = Math.min( ( scrollTop / ( maxScrollTop - 200 ) ) * 100, 100 );
                    $( '.crafto-scroll-point' ).css( 'height', scrollPercentage + '%' );
                }
            }

            $window.on( 'scroll', function() {
                scrollIndicator();
            });
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
