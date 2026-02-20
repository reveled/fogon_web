( function( $ ) {

	"use strict";

	const $document = $( document );

	$document.ready( function () {
		// Product compare on click.
		$document.on( 'click', '.crafto-compare', function() {
			var _this        = $( this );
			var productId    = _this.data( 'product_id' );
			var $popup       = $( '.crafto-compare-popup' );
			var $compareText = _this.find( '.compare-text' );
			var $icon        = _this.find( 'i' );

			// Show the popup
			$popup.css({
				visibility: 'visible',
				opacity: '1',
				display: 'block'
			});

			$compareText.text( CraftoWoo.compare_added_text );
			$icon.attr( 'data-original-title', CraftoWoo.compare_added_text );

			if ( productId != '' && productId != undefined ) { // Check product id
				var cookieName = 'crafto-compare' + CraftoWoo.site_id;
				var productIds  = getCraftoCookie( cookieName ) || [];

				if ( productIds != '' && productIds != undefined ) { // Check stored value
					
					if ( productIds && !Array.isArray( productIds ) ) {
						productIds = productIds.split( ',' );
					}
					
					if ( $.inArray( productId.toString(), productIds ) === -1 ) {
						productIds.push( productId );
					}
				} else { // Check array is not created
					productIds = new Array();
					productIds.push( productId );
				}

				// Set cookie
				setCraftoCookie( cookieName, productIds, '1' );

				_this.addClass( 'loading' );

				$.ajax({
					type: 'POST',
					url: CraftoWoo.ajaxurl, 
					data: {
						'action': 'compare_details',
						'productid' : productId
					},
					success:function( response ) {
						var $comparePopup = $( '#crafto_compare_popup' );
						if ( $comparePopup.length > 0 ) {
							// Update the compare popup content
							$comparePopup.html( response );							
							// odd even class in li
							$( '.compare-table li:odd' ).addClass( 'odd' );
							$( '.compare-table li:even' ).addClass( 'even' );

							// For checkbox Filter.
							$( '.crafto-compare-product-filter-opt' ).on( 'click', function() {
								$( this ).toggleClass( 'active' );
							});

							_this.removeClass( 'loading' );

							// Equalize the height of comparison table items
							$comparePopup.imagesLoaded().progress( function() {
								var max_height = 0;
								$comparePopup.find( '.content-left ul.compare-table li' ).each( function( index ) {
									max_height = $( this ).height();
									$( '.content-right .compare-table' ).find( 'li:eq(' + index + ')' ).each( function( i ) {
										if ( max_height < $( this ).height() ) {
											max_height = $( this ).height();
										}
									});

									$( '.compare-table' ).find( 'li:eq(' + index + ')' ).height( max_height );
								});
							});

							// Open the popup in Magnific Popup
							if ( 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
								$.magnificPopup.close();
								$.magnificPopup.open({
									items: {
										src: '#crafto_compare_popup',
										type: 'inline'
									},
									fixedContentPos: true,
									mainClass: 'mfp-fade compare-details-popup-wrap crafto-mfp-bg-white crafto-compare-popup',
									callbacks: {
										elementParse: function( item ) {
											// Update custom scrollbars and trigger events
											craftoAddonsCompareProductFilterCSS();
											craftoAddonsCustomHorizontalScroll( '.compare-popup-main-content .content-right' );
											craftoAddonsCustomVerticalScroll( '.compare-popup-main-content' );
											$( document.body ).trigger( 'crafto_addons_compare_details_open_popup' );
										}
									}
								});
							}
						}
					}
				});
			}
		});

		// Remove product from compare products.
		$document.on( 'click', 'a.crafto-compare-product-remove', function() {
			var thisItem       = $( this );
			var productId      = thisItem.data( 'product_id' );
			var $compareButton = $( '.crafto-compare[data-product_id = ' + productId + ']' );

			// Check if productId exists
			if ( productId != '' && productId != undefined ) {
				// Confirm product removal
				if ( confirm( CraftoWoo.compare_remove_message ) ) {
					var cookieName = 'crafto-compare' + CraftoWoo.site_id;
					var productIds  = getCraftoCookie( cookieName );

					if ( productIds != '' && productIds != undefined ) { // Check stored value
						thisItem.closest( 'li.list-details' ).append( '<div class="crafto-loader"></div>' );

						productIds = productIds.split(',');
						productIds.splice( productIds.indexOf( productId ), 1 );

						// Set removed cookie
						var cookieName = 'crafto-compare' + CraftoWoo.site_id;
						setCraftoCookie( cookieName, productIds, '1' );

						thisItem.parents( 'li' ).remove();
						$compareButton.find( '.compare-text' ).text( CraftoWoo.compare_text );
						$compareButton.find( 'i' ).attr( 'data-original-title', CraftoWoo.compare_text );

						// Dynamically update the main list width
						craftoAddonsCompareProductFilterCSS();

						// Reinitialize custom horizontal and vertical scrollbars
						craftoAddonsCustomHorizontalScroll( '.compare-popup-main-content .content-right' );
						craftoAddonsCustomVerticalScroll( '.compare-popup-main-content' );

						// Close popup when compare list is empty
						if ( getCraftoCookie( cookieName ).length == 0 && 'undefined' != typeof CraftoMain && $.inArray( 'magnific-popup', CraftoMain.disable_scripts ) < 0 ) {
							$( '#crafto_compare_popup' ).magnificPopup( 'close' );
						}

						// Remove the loader spinner
						thisItem.find( '.crafto-loader' ).remove();
					}
				}
			}
		});

		// Remove product after added into cart from compare products popup on click add to cart button.
		$document.on( 'click', 'a.crafto-popup-cart-button', function() {
			var thisItem  = $( this );
			var productId = thisItem.data( 'product_id' );

			// Check if productId exists
			if ( productId != '' && productId != undefined ) {
				// Hide the 'Add to Cart' button
				setTimeout( function() {
					thisItem.closest( 'li' ).find( '.crafto-popup-cart-button' ).fadeOut();
				}, 100 );
			}
		});

		// Click filter button in compare products popup.
		$document.on( 'click', '.crafto-compare-filter', function() {
			var $filterButton     = $( this );
			var $activeCheckboxes = $( '.crafto-compare-product-filter-opt.active' );
			var checkedCount      = $activeCheckboxes.length;
			var $errorMsg         = $( '.compare-error-msg' );

			// If at least 2 checkboxes are selected
			if ( checkedCount >= 2 ) {
				// Hide the error message if visible
				if ( ! $errorMsg.hasClass( 'display-none' ) ) {
				   $errorMsg.addClass( 'display-none' );
				}

				// Hide all list details initially
				var $listDetails = $filterButton.closest( '.crafto-compare-popup' ).find( '.list-details' );
				$listDetails.addClass( 'display-none' );

				// Show the list items that match the active checkboxes
				$activeCheckboxes.each( function() {
					$( this ).closest( '.list-details' ).removeClass( 'display-none' );
				});

				// Dynamically update the main list width
				craftoAddonsCompareProductFilterCSS();

				// Update custom scrollbar if necessary
				if ( 'undefined' != typeof CraftoMain && $.inArray( 'mCustomScrollbar', CraftoMain.disable_scripts ) < 0 ) {
					$( '.compare-popup-main-content .content-right' ).mCustomScrollbar( 'update' );
				}

			} else {
				// Show error message if fewer than 2 checkboxes are selected
				$errorMsg.removeClass( 'display-none' );
				filtermessage();
			}
		});

		// Click Reset Button in compare products popup.
		$document.on( 'click', '.crafto-compare-reset', function() {
			$( 'ul.compare-lists-wrap li' ).removeClass( 'display-none' );
			$( '.crafto-compare-product-filter-opt' ).removeClass( 'active' );

			// Reset the width of the content-right container
			$( '.compare-popup-main-content .content-right' ).css( 'width', '' );

			// Dynamically update the main list width after resetting
			craftoAddonsCompareProductFilterCSS();

			// Update custom scrollbar if available and not disabled
			if ( 'undefined' != typeof CraftoMain && $.inArray( 'mCustomScrollbar', CraftoMain.disable_scripts ) < 0 ) {
				$( '.compare-popup-main-content .content-right' ).mCustomScrollbar( 'update' );
			}
		});
		
		// Compare data equal height after clicking from quick view
		$document.on( 'crafto_quick_view_product_details_open_popup', function() {
			// Dynamically update the main list width
			craftoAddonsCompareProductFilterCSS();

			// Update custom scrollbar
			craftoAddonsCustomHorizontalScroll( '.compare-popup-main-content .content-right' );
		});

		/* Compare Filter message timeout Function */
		var filter_link;
		function filtermessage() {
			// Clear the existing timeout if there's one
			if ( filter_link ) {
				clearTimeout( filter_link );
			}

			// Set a new timeout to hide the error message after 3 seconds
			filter_link = setTimeout( function() {
				$( '.compare-error-msg' ).addClass( 'display-none' );
			}, 3000);
		}

	});

	/* Product Compare Function */
	function craftoAddonsCompareProductFilterCSS() {
		// Select the compare list container and initialize width variable
		var $container = $( '.compare-lists-wrap' );
		var totalWidth = 0;

		// Select only visible list items and calculate their total width
		var $visibleItems = $( 'li.list-details:not(.display-none)', $container );
		totalWidth = $visibleItems.toArray().reduce( function( sum, item ) {
			return sum + $( item).outerWidth( true );
		}, 0 );

		// Update the container width based on total visible items width
		$container.css( 'width', totalWidth + $container.outerWidth( true ) - $container.width() );
	}


	/* Horizontal Scrollbar */
	function craftoAddonsCustomHorizontalScroll( key ) {
	    craftoAddonsCustomScroll( key, 'x' );
	}

	/* Vertical Scrollbar */
	function craftoAddonsCustomVerticalScroll( key ) {
	    craftoAddonsCustomScroll( key, 'y' );
	}

	/* Custom Scroll Bar Function (Horizontal or Vertical) */
	function craftoAddonsCustomScroll( key, axis = 'y' ) {
		// Set default key if not provided
		if ( typeof key === 'undefined' || key === null || key === '') { 
			key = axis === 'x' ? '.compare-popup-main-content .content-right' : '.compare-popup-main-content'; 
		}

		// Ensure mCustomScrollbar is available and not disabled
		if ( 'undefined' != typeof CraftoMain && $.inArray( 'mCustomScrollbar', CraftoMain.disable_scripts ) < 0 ) {
			$( key ).mCustomScrollbar({
				axis: axis, // 'x' for horizontal, 'y' for vertical
				scrollInertia: 100,
				scrollButtons: { enable: false },
				keyboard: { enable: true },
				mouseWheel: {
					enable: axis === 'y', // Enable mouse wheel for vertical scrolling
					scrollAmount: 200
				},
				advanced: {
					updateOnContentResize: true, // Update scrollbar on content resize
					autoExpandHorizontalScroll: axis === 'x', // Expand horizontally for horizontal scroll
				}
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
		const decodedCookie = decodeURIComponent(document.cookie);
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
