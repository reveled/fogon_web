( function( $ ) {

	"use strict";

	$( document ).ready( function() {

		/* Product Quick View */
		$( document ).on( 'click', '.crafto-quick-view', function() {
			var _this     = $( this );
			var productId = _this.data( 'product_id' );
			var $popup    = $( '.crafto-quick-view-popup' );

			// Show the popup
			$popup.css({
				visibility: 'visible',
				opacity: '1',
				display: 'block'
			});

			_this.addClass( 'loading' );

			if ( productId != '' && productId != undefined ) { // Check product id
				$.ajax({
					type: 'POST',
					url: CraftoWoo.ajaxurl, 
					data: {
						'action': 'quick_view_product_details',
						'productid' : productId
					},
					success:function( response ) {
						var $quickViewPopup = $( '#crafto_quick_view_popup' );

						if ( $quickViewPopup.length > 0 ) {
							// Update the quick view popup content
							$quickViewPopup.html( response );

							_this.removeClass( 'loading' );

							// Initialize tooltips if present
							var el_crafto_tooltip = $( '.crafto-tooltip' );
							if ( el_crafto_tooltip.length > 0 ) {
								el_crafto_tooltip.tooltip();
							}

							// Open the popup using Magnific Popup
							if ( 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
								$.magnificPopup.open({
									delegate: 'a',
									fixedContentPos: true,
									items: {
										src: '#crafto_quick_view_popup',
										type: 'inline'
									},
									mainClass: 'mfp-fade quick-view-popup-wrap crafto-mfp-bg-white crafto-quick-view-popup',
									callbacks: {
										elementParse: function( item ) {
											// Initialize product gallery and variations
											var product_gallery = $( item.src ).find( '.woocommerce-product-gallery' );
											if ( product_gallery.length > 0 ) {
												product_gallery.each( function() {
													$( this ).wc_product_gallery();
												});
											}

											// Variation Form
											var form_variation = $( item.src ).find( '.variations_form' );
											if ( form_variation.length > 0 ) {
												form_variation.each( function() {
													$( this ).wc_variation_form();
												});
											}

											// Init after gallery.
											setTimeout( function() {
												form_variation.trigger( 'check_variations' );
												form_variation.trigger( 'wc_variation_form' );
											}, 100 );

											// Disable zoom feature for images in the popup
											$( '.woocommerce-product-gallery__image' ).attr( 'style',  'pointer-events:none !important' );

											// Trigger quick view open event
											$( document.body ).trigger( 'crafto_quick_view_product_details_open_popup' );
										}
									}
								});
							}

							// Initialize countdown for product deals
							if ( 'undefined' != typeof CraftoMain && $.inArray( 'countdown', CraftoMain.disable_scripts ) < 0 ) {
								var dealWrap = $( '.crafto-quick-view-deal-wrap' );
								if ( dealWrap.length > 0 ) {
									dealWrap.each( function() {
										var endDate = $( this ).attr( 'data-end-date' );
										if ( CraftoWoo.moment_timezone ) {
											var endDateMoment = moment.tz( endDate, $( this ).attr( 'data-timezone' ) );
												endDate    = endDateMoment.toDate();
										}

										if ( endDate != '' && endDate != undefined ) {
											$( this ).countdown( endDate, function( event ) {
												$( this ).html(
													event.strftime( '' 
														+ '<span class="crafto-product-deal-days">%D<span>' + CraftoWoo.product_deal_day + '</span></span>'
														+ '<span class="crafto-product-deal-hours">%H<span>' + CraftoWoo.product_deal_hour + '</span></span>'
														+ '<span class="crafto-product-deal-mins">%M<span>' + CraftoWoo.product_deal_min + '</span></span>'
														+ '<span class="crafto-product-deal-secs">%S<span>' + CraftoWoo.product_deal_sec + '</span></span>'
													)
												);
											});
										}
									});
								}
							}

							// Initialize the quick view image slider using Swiper
							if ( $( '.quick-view-images' ).length > 0 && 'undefined' != typeof CraftoMain && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
								var quickViewSlider = new Swiper( '.quick-view-images', {
									navigation: {
										nextEl: '.swiper-button-next',
										prevEl: '.swiper-button-prev',
									},
									watchOverflow: true,
								});
							}

							setTimeout( function() {
								// Set default variation if present
								craftoSetDefaultVariation();
							}, 100 );

							// Initialize swatches for variations
							$( '#crafto_quick_view_popup .variations_form' ).craftoVariationSwatchesForm();

							// Reset slider position when variation is changed
							if ( $( '#crafto_quick_view_popup .quick-view-images' ).length > 0 ) {
								$( '.variations_form.cart' ).on( 'found_variation', function ( e ) {
									quickViewSlider.slideTo( 0, 1000, false );
									e.preventDefault();
								});

								$( '.variations_form.cart' ).on( 'click', '.reset_variations', function ( e ) {  
									quickViewSlider.slideTo( 0, 1000, false );
									e.preventDefault();
								})
							}
						}
					}
				});
			}
		});

		function craftoSetDefaultVariation() {
			const $variationsForm = $( '.variations_form' );

			if ( $variationsForm.length > 0 ) {
				$variationsForm.find( '.crafto-attribute-filter' ).each( function() {
					var el_wrap = $( this ),
						el_variation_select = el_wrap.closest( '.value' ).find( 'select' );

					el_wrap.find( '.crafto-swatch' ).each( function() {
						const value = $( this ).data( 'value' );

						if ( ! el_variation_select.find( 'option[value="' + value + '"]' ).length ) {
							$( this ).addClass( 'disable' );
						} else {
							$( this ).removeClass( 'disable' );
						}
					});
				});
			}
		};
	});

	var $quick_view_fragment_refresh;
	if ( typeof wc_cart_fragments_params !== 'undefined' ) {
		$quick_view_fragment_refresh = {
			url: wc_cart_fragments_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'get_refreshed_fragments' ),
			type: 'POST',
			success: function( data ) {
				if ( data && data.fragments ) {
					$.each( data.fragments, function( key, value ) {
						$( key ).replaceWith( value );
					});

					$( document.body ).trigger( 'wc_fragments_refreshed' );
					/* Open mini cart in slide view */
					if( $( '.crafto-mini-cart-slide-sidebar' ).length > 0 ) {
						setTimeout( function() {
							$( '.widget_shopping_cart .mini-cart-slide' ).trigger( 'click' );
						}, 10 );
					}
				}
			}
		};

		$( document ).on( 'submit', '.quick-view-product form.cart', function( e ) {
		e.preventDefault();

		var product_url = window.location,
			form = $( this );

		form.find( 'button' ).block({
			message: null,
		});

		$.post( product_url, form.serialize() + '&_wp_http_referer=' + product_url, function() {
			// update fragments
			$.ajax( $quick_view_fragment_refresh );

			$( '.crafto-cart-message' ).remove();

			$( document.body ).append( '<div class="crafto-cart-message alt-font"><i class="fas fa-check"></i>'+ CraftoWoo.quickview_addtocart_message +'</div>' );

			form.find( 'button' ).unblock();

			// Close popup when added add to cart
			if ( 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
				$( '#crafto_quick_view_popup' ).magnificPopup( 'close' );
			}

			// Product added Message
			setTimeout( function(){
				$( '.crafto-cart-message' ).remove();
			}, 3000 );
			$( '.reset_variations' ).trigger( 'click' );
		});
	});
	}

})( jQuery );
