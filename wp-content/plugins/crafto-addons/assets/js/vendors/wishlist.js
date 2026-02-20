( function( $ ) {

	"use strict";

	const $document = $( document );
	
	/* document ready event start code */
	$document.ready( function() {

		/* Add Product wishlist */
		$document.on( 'click', '.crafto-wishlist-add', function() {
			const thisItem           = $( this );
			const productId          = thisItem.data( 'product_id' );
			const $wishlistItem      = $( '.crafto-wishlist[data-product_id="' + productId + '"]' );
			const $wishlistAddedIcon = $wishlistItem.find( 'i' );

			// If the product is already in the wishlist and the wishlist URL is empty, exit
			if ( thisItem.hasClass( 'wishlist-added' ) && CraftoWoo.wishlist_url !== '' ) {
				return;
			}           

			// If no product ID, exit
			if ( ! productId ) {
				return;
			}

			thisItem.addClass( 'loading' );
			
			$.ajax({
				type : 'POST',
				url : CraftoWoo.ajaxurl,
				data : {
					'action' : 'crafto_addons_add_wishlist',
					'wishlistid' : productId
				},
				success:function() {
					// Update the wishlist item (icon, class, and message)
					$wishlistItem.addClass( 'wishlist-added' );
					$wishlistAddedIcon.removeClass( 'icon-feather-heart' ).addClass( 'icon-feather-heart-on' );

					// Remove any previous messages
					$( '.crafto-wishlist-message, .crafto-cart-message' ).remove();

					$( document.body ).append( '<div class="crafto-wishlist-message alt-font"><i class="fa-solid fa-check"></i>' + CraftoWoo.wishlist_added_message + '</div>' );

					if ( CraftoWoo.wishlist_url ) {
						$wishlistItem.attr( 'href', CraftoWoo.wishlist_url );
						$wishlistAddedIcon.attr( 'title', CraftoWoo.browse_wishlist_text ).attr( 'data-original-title', CraftoWoo.browse_wishlist_text ).attr( 'data-bs-original-title', CraftoWoo.browse_wishlist_text );
						$wishlistItem.find( 'span.button-text' ).text( CraftoWoo.browse_wishlist_text );
						$wishlistItem.removeClass( 'crafto-wishlist-add' );
					} else {
						$wishlistItem.removeClass( 'crafto-wishlist-add' ).addClass( 'crafto-wishlist-remove' );
						$wishlistAddedIcon.attr( 'title', CraftoWoo.remove_wishlist_text ).attr( 'data-original-title', CraftoWoo.remove_wishlist_text ).attr( 'data-bs-original-title', CraftoWoo.remove_wishlist_text );
						$wishlistItem.find( 'span.button-text' ).text( CraftoWoo.remove_wishlist_text );
					}

					// Product added message fade out
					setTimeout( function() {
						thisItem.removeClass( 'loading' );
						$( '.crafto-wishlist-message' ).fadeOut( 500, function() {
							$( this ).remove();
						});
					}, 3000 );

					// Update wishlist page and trigger refresh
					$document.trigger( 'crafto-wishlist-refresh' );
				},
			});
		});

		/* Remove Product wishlist */
		$document.on( 'click', '.crafto-wishlist-remove', function() {
			const thisItem           = $( this );
			const productId          = thisItem.data( 'product_id' );
			const $wishlistItem      = $( '.crafto-wishlist[data-product_id="' + productId + '"]' );
			const $wishlistAddedIcon = $wishlistItem.find( 'i' );

			if ( productId ) {
				thisItem.addClass( 'loading' );
				$( '.crafto-wishlist-message, .crafto-cart-message' ).remove();
				$( document.body ).append( '<div class="crafto-wishlist-message alt-font"><i class="fa-solid fa-times"></i>' + CraftoWoo.wishlist_remove_message + '</div>' );
				
				if ( CraftoWoo.wishlist_url ) {
					// Default layout icon , link and text change
					$wishlistItem.find( 'span.wish-list-text' ).html( CraftoWoo.add_to_wishlist_text );
					$wishlistItem.removeClass( 'wishlist-added' ).attr( 'href', 'javascript:void(0);' );
					$wishlistItem.find( 'i' ).removeClass( 'icon-feather-heart-on' ).addClass( CraftoWoo.wishlist_icon );
					$wishlistItem.find( 'i' ).attr( 'title', '' ).attr( 'data-original-title', CraftoWoo.add_to_wishlist_text ).attr( 'data-bs-original-title', CraftoWoo.add_to_wishlist_text );
				} else {
					// Default layout icon , link and text change
					$wishlistItem.removeClass( 'crafto-wishlist-remove' ).addClass( 'crafto-wishlist-add' );
					$wishlistItem.find( 'span.wish-list-text' ).html( CraftoWoo.add_to_wishlist_text );
					$wishlistItem.removeClass( 'wishlist-added' ).attr( 'href', 'javascript:void(0);' );
					$wishlistItem.find( 'i' ).removeClass( 'icon-feather-heart-on' );
					$wishlistItem.find( 'i' ).addClass( CraftoWoo.wishlist_icon );
					$wishlistItem.find( 'i' ).attr( 'title', '' ).attr( 'data-original-title', CraftoWoo.add_to_wishlist_text ).attr( 'data-bs-original-title', CraftoWoo.add_to_wishlist_text );
				}
				
			}
		});

		/* Added to cart by clicking single product add to cart button and remove from wishlist */
		$document.on( 'click', '.crafto-page-remove-wish, .crafto-wishlist-page .product_type_simple.single-add-to-cart', function() {
			var thisItem = $( this );
			var removeid = thisItem.attr( 'data-product_id' );

			if ( removeid != '' && removeid != undefined ) {

				thisItem.addClass( 'loading' );
	  
				$.ajax({
					type : 'POST',
					url : CraftoWoo.ajaxurl,
					data : {
						'action' : 'crafto_addons_page_remove_wishlist',
						'removeids' : removeid
					},
					success:function( response ) {
						thisItem.removeClass( 'loading' );
						$( '.crafto-wishlist-page' ).html( response );

						if ( thisItem.hasClass( 'button' ) ) {
							$( '.crafto-wishlist-message, .crafto-cart-message' ).remove();
							$( document.body ).append( '<div class="crafto-wishlist-message alt-font"><i class="fa-solid fa-check"></i>' + CraftoWoo.wishlist_addtocart_message + '</div>' );
						} else {
							$( '.crafto-wishlist-message' ).remove();
							$( '.crafto-cart-message' ).remove();
							$( document.body ).append( '<div class="crafto-wishlist-message alt-font"><i class="fa-solid fa-check"></i>' + CraftoWoo.wishlist_remove_message + '</div>' );    
						}

						// Product remove Message
						setTimeout( function() {
							$( '.crafto-wishlist-message' ).remove();
						},1000 );

						// Update wishlist page and trigger refresh
						$document.trigger( 'crafto-wishlist-refresh' );
					},
				});
			}
		});

		// Active checkbox for wishlist page.
		$document.on( 'click', '.crafto-wishlist-opt', function() {
			const $elThis = $( this );
			const allOpts = $( '.crafto-all-wishlist-opt' );

			// Toggle the 'active' class on the individual option
			$elThis.toggleClass( 'active' );

			if ( $elThis.hasClass( 'active' ) ) {
				allOpts.removeClass( 'active' );
			}
		});

		/* Remove all selected wishlist from wishlist page */
		$document.on( 'click', '.crafto-remove-wishlist-selected', function() {
			var thisItem    = $( this );
			var $checkboxes = $( '.crafto-wishlist-opt.active' );
			var product_ids = [];

			// Collect product IDs
			$checkboxes.each( function() {
				var product_id = $( this ).data( 'product_id' );
				if ( product_id != '' && product_id != undefined ) {
					product_ids.push( product_id );
				}
			});

			// If no product IDs to remove
			if ( product_ids.length === 0 ) {
				$( '.crafto-wishlist-error-message' ).removeClass( 'd-none' );
				remove_error_message();
				return;
			}

			thisItem.addClass( 'loading' );

			$.ajax({
				type : 'POST',
				url : CraftoWoo.ajaxurl,
				data : {
					'action' : 'crafto_addons_page_remove_wishlist',
					'removeids' : product_ids.join(',')
				},
				success:function( response ) {
					$checkboxes.each( function() {
						var product_id = $( this ).data('product_id');
						if ( product_id != '' && product_id != undefined ) {
							var $wishlist = $( '.crafto-wishlist[data-product_id="' + product_id + '"]' );
							$wishlist.find( 'span.wish-list-text' ).html( CraftoWoo.add_to_wishlist_text );
							$wishlist.removeClass( 'wishlist-added' ).attr( 'href', 'javascript:void(0);' );
							$wishlist.find( 'i' ).addClass( CraftoWoo.wishlist_icon ).removeClass( 'icon-feather-heart' ).attr( 'title', '' ).attr( 'data-original-title', CraftoWoo.add_to_wishlist_text );
						}
					});

					// Clear old messages and show success message
					$( '.crafto-wishlist-message, .crafto-cart-message' ).remove();
					$( document.body ).append( '<div class="crafto-wishlist-message alt-font"><i class="fa-solid fa-check"></i>' + CraftoWoo.wishlist_multi_select_message + '</div>' );

					$( '.crafto-wishlist-page' ).html( response );

					// Remove the success message after a short delay
					setTimeout( function() {
						$( '.crafto-wishlist-message' ).remove();
					}, 1000 );

					// Update wishlist page and trigger refresh
					$document.trigger( 'crafto-wishlist-refresh' );

					// Remove loading state
					thisItem.removeClass('loading');
				},
			});
		});

		/* Empty wishlist from wishlist page */
		$document.on( 'click', '.crafto-empty-wishlist', function() {
			if ( confirm( CraftoWoo.wishlist_empty_message ) ) {
				$.ajax({
					type : 'POST',
					url : CraftoWoo.ajaxurl,
					data : {
						'action': 'crafto_addons_empty_wishlist_all'
					},
					success:function( response ) {
						// Default layout icon , link and text change
						$( '.crafto-wishlist-page' ).html( response );

						// Product remove Message
						setTimeout( function() {
							$( '.crafto-wishlist-message' ).remove();
						},1000 );

						// Update wishlist page and trigger refresh
						$document.trigger( 'crafto-wishlist-refresh' );
					},
				});
			}
		});

		// Select all check box radio button
		$document.on( 'click', '.product-check .crafto-all-wishlist-opt', function() {
			const $elThis = $( this );
			const allOpts = $( '.crafto-wishlist-opt' );

			// Toggle the 'active' class on the individual option
			$elThis.toggleClass( 'active' );
			
			if ( $elThis.hasClass( 'active' ) ) {
				allOpts.addClass('active');
			} else {
				allOpts.removeClass('active');
			}
		});

		// Refresh wishlist
		$document.on( 'crafto-wishlist-refresh', function() {
			$.ajax({
				type : 'POST',
				url : CraftoWoo.ajaxurl,
				data : {
					'action': 'crafto_refresh_wishlist'
				},
				success:function( response ) {
					// Refresh wishlist count
					$( '.crafto-wishlist-counter' ).replaceWith( response );
				},
			});
		});
		 
	}); /* document ready event end code */

	/* Display error message in wishlist page based on time out function */
	var remove_message_link;
	function remove_error_message() {
		// Clear the existing timeout if there's one
		if ( remove_message_link ) {
			clearTimeout( remove_message_link );
		}

		// Set a new timeout to hide the error message after 3 seconds
		remove_message_link = setTimeout( function() {
			$( '.crafto-wishlist-error-message' ).addClass( 'd-none' );
		}, 3000 );
	}

})( jQuery );