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
					'.elementor-widget-crafto-team-member',
				];

				widgets.forEach( element => {
					if ( $( element ).length > 0 ) {
						CraftoAddonsInit.teamMemeberInit( $( element ) );
					}
				});
			} else {
				const widgets = [
					'crafto-team-member.default',
				];

				widgets.forEach( hook => {
					elementorFrontend.hooks.addAction( `frontend/element_ready/${hook}`, CraftoAddonsInit.teamMemeberInit );
				});
			}
		},
		teamMemeberInit: function( $scope ) {
			let $target = $scope.find( '.team-style-1' );
			if ( 0 === $target.length ) {
				return;
			}

			$target.each( function() {
				let $elThis    = $( this ),
					figcaption = $elThis.find( 'figcaption' );

				if ( figcaption.length > 0 ) {
					setTimeout( function() {
						$elThis.css( {
							'padding-bottom': figcaption.outerHeight()
						});
					}, 200 );
				}
			});

			$target.on( 'mouseenter mouseleave', function( e ) {
				$( this ).find( '.social-icon' ).slideToggle( 400 );
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
