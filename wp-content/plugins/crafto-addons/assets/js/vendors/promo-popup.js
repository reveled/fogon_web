( function( $ ) {

    "use strict";

	$( document ).ready( function () {

		// Get window WIDTH.
		function getWindowWidth() {
			return window.innerWidth;
		}

		const $window = $( window );

		// Cache CraftoMain disable_scripts array and check
		const isMagnificEnabled = ( 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 );

		// Check if promo popup is enabled and not disabled
		if ( 'undefined' !== typeof CraftoPromo &&
			'1' === CraftoPromo.enable_promo_popup && 
			isMagnificEnabled ) {

			// Check mobile popup condition
			if ( '1' === CraftoPromo.enable_mobile_promo_popup && getWindowWidth() < CraftoPromo.popup_disable_mobile_width ) {
				return false; // Exit if on mobile
			}

			const promo_cookie_name = `crafto-promo-popup${CraftoPromo.site_id}`;
			const promo_popup       = getCraftoCookie( promo_cookie_name );

			// Handle display after a certain time (Time Delay)
			if ( 'some-time' === CraftoPromo.display_promo_popup_after ) {
				if ( 'shown' !== promo_popup &&
					! $( '.crafto-promo-show-popup' ).is( ':checked' ) ) {
					setTimeout( showpromoPopup, CraftoPromo.delay_time_promo_popup );
				}
			} else if ( 'user-scroll' === CraftoPromo.display_promo_popup_after ) { // Handle display on scroll
				$window.on( 'scroll', function() {
					if ( $( document ).scrollTop() >= CraftoPromo.scroll_promo_popup && 
						'shown' !== promo_popup &&
						! $( '.crafto-promo-show-popup' ).is( ':checked' ) ) {
						showpromoPopup();
					}
				});
			} else if ( 'on-page-exit-intent' === CraftoPromo.display_promo_popup_after ) { // Handle display on page exit intent
				$window.on( 'mouseleave', function( e ) {
					// Only show if the mouse leaves the page upwards (i.e., exiting the viewport)
					if ( 
						e.clientY <= 0 ||  // Top edge: Mouse leaving the page upwards
						e.clientY >= $(window).height() - 1  // Bottom edge: Mouse leaving towards the bottom
					) {
						if ( 'shown' !== promo_popup &&
						! $( '.crafto-promo-show-popup' ).is( ':checked' ) ) {
							showpromoPopup();
						}
					}
				});
			}
		}
	});

	function showpromoPopup() {
		if ( '1' == CraftoPromo.enable_promo_popup ) {
			var cookie_name = 'crafto-promo-popup' + CraftoPromo.site_id;
			$( '#crafto-promo-show-popup' ).on( 'change', function() {
				setCraftoCookie( cookie_name, 'shown', CraftoPromo.expired_days_promo_popup );
			});

			$( '.crafto-promo-popup-wrap' ).show();

			$.magnificPopup.open({
				items: {
					src: '.crafto-promo-popup-wrap',
				},
				fixedContentPos: true,
				type: 'inline',
				removalDelay: 10,
				closeBtnInside: true,
				mainClass: 'crafto-promo-popup-mfp-bg'
			});
		}
	}
	// Set Crafto Cookie
	function setCraftoCookie( cname, cvalue, exdays ) {
		const d = new Date();
		if ( exdays ) {
			d.setTime(d.getTime() + ( exdays * 24 * 60 * 60 * 1000 ) );
		}

		const expires   = exdays ? `;expires=${d.toUTCString()}` : '';
		document.cookie = `${cname}=${cvalue}${expires};path=/`;
	}

	// Get Crafto Cookie
	function getCraftoCookie( cname ) {
		const name          = `${cname}=`;
		const decodedCookie = decodeURIComponent( document.cookie );
		const cookies       = decodedCookie.split(';');

		for ( const cookie of cookies ) {
			const trimmedCookie = cookie.trim();
			if ( trimmedCookie.startsWith( name ) ) {
				return trimmedCookie.substring( name.length );
			}
		}
		return "";
	}

})( jQuery );
