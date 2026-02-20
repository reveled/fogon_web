jQuery( document ).ready( function ( $ ) {

	"use strict";

	function getWindowWidth() {
		return window.innerWidth;
	}

	let checkWidgetBlock = $( '.widget.widget_block' );
	if ( checkWidgetBlock.length > 0 ) {
		checkWidgetBlock.each(function() {
			let $widget = $( this );
		
			// Check if the div is empty OR it contains .crafto-active-filters
			if ( $widget.html().trim() === '' || $widget.find( '.crafto-active-filters' ).length > 0 ) {
				$widget.addClass( 'crafto-product-price' );
			}
		});
	}
	
	function updateFilters( excludePrice = false ) {
		const url = new URL( window.location.href );
	
		// Handle attribute filters
		$( '.filter-checkbox, .color-filter-checkbox, .size-filter-checkbox, .attribute-filter-checkbox' ).each( function () {
			const termSlug = $( this ).data( 'term-slug' ),
			      taxonomy = $( this ).data( 'taxonomy' ),
			      paramKey = 'filter_' + taxonomy;
	
			let params = url.searchParams.get( paramKey ) ? url.searchParams.get( paramKey ).split( ',' ) : [];
	
			if ( $( this ).is( ':checked' ) ) {
				if ( ! params.includes( termSlug ) ) {
					params.push( termSlug );
				}
			} else {
				params = params.filter( slug => slug !== termSlug );
			}
	
			if ( params.length ) {
				url.searchParams.set( paramKey, params.join( ',' ) );
			} else {
				url.searchParams.delete( paramKey );
			}
		});
	
		// Only add max_price when the filter button is clicked
		if ( ! excludePrice ) {

			const maxPrice      = $( '#maxPrice' ).val();
			const minPrice      = $( '#minPrice' ).val();
			const $priceWrapper = $( '.price-range-wrapper' );

			if ( maxPrice && maxPrice > 0 && minPrice ) {
				url.searchParams.set( 'max_price', maxPrice );
				url.searchParams.set( 'min_price', minPrice );
			} else {
				url.searchParams.delete( 'max_price' );
				url.searchParams.delete( 'min_price' );
				$priceWrapper.css( '--low-value', '0%' );
				$priceWrapper.css( '--high-value', '100%' );
			}
		}

		$( '.crafto-shop-content-part .crafto-shop-common-isotope' ).block( { message: null, overlayCSS: { background: '#ffffff', opacity: 0.6 } } );

		// Perform AJAX request to update products and pagination
		$.ajax({
			url: url.toString(),
			type: 'GET',
			success: function ( response ) {
				const $response = $( response );

				window.history.pushState( null, '', url.toString() );

				refreshShopProducts( response );
			
				var newFilters = $response.find( '.widget.widget_block' ).html(); // Target correctly

				if ( newFilters !== undefined && newFilters.trim() !== '' && $( '.widget_block' ).hasClass( 'crafto-product-price' ) === true ) {
					$( '.widget.widget_block.crafto-product-price' ).html( newFilters ); // Update only when valid
				}
			}
			
		});
		return false;
	}
	
	// Checkbox filter event - Exclude price filtering when selecting a category
	$( '.filter-checkbox, .color-filter-checkbox, .size-filter-checkbox, .attribute-filter-checkbox' ).on( 'change', function () {
		updateFilters( true );
	});

	$( '.woocommerce-ordering' ).on( 'submit', function () {
		const url = new URL( window.location.href );

		$( '.crafto-shop-content-part .crafto-shop-common-isotope' ).block( { message: null, overlayCSS: { background: '#ffffff', opacity: 0.6 } } );

		$.ajax({
			url: url.toString(),
			type: 'GET',
			data: $( this ).serialize(),
			success: function ( response ) {
				refreshShopProducts( response );
			
				window.history.pushState( null, '', url.toString() );
			}
			
		});
		return false;
	});
	
	const $minPrice      = $( '#minPrice' );
	const $maxPrice      = $( '#maxPrice' );
	const $minPriceValue = $( '#minPriceValue' );
	const $maxPriceValue = $( '#maxPriceValue' );
	let $priceWrapper    = $( '.price-range-wrapper' );

	// Get original max price from data attribute
	const originalMaxPrice = parseInt( $maxPrice.attr( 'data-max' ) );

	function getUrlParam( param ) {
		const urlParams = new URLSearchParams( window.location.search );
		return urlParams.has( param ) ? parseInt( urlParams.get( param ) ) : null;
	}

	function updatePriceValues() {
		let minVal = parseInt( $minPrice.val() );
		let maxVal = parseInt( $maxPrice.val() );

		if ( minVal >= maxVal ) {
			$minPrice.val( maxVal - 1 ); // Prevent overlap
			minVal = parseInt( $minPrice.val() );
		}

		$minPriceValue.text( `$${minVal}` );
		$maxPriceValue.text( `$${maxVal}` );

		$priceWrapper.css( '--low-value', ( minVal / originalMaxPrice ) * 100 + '%' );
		$priceWrapper.css( '--high-value', ( maxVal / originalMaxPrice ) * 100 + '%' );
	}

	// Set initial values from URL on page load
	let minPriceFromURL = getUrlParam( 'min_price' );
	let maxPriceFromURL = getUrlParam( 'max_price' );

	if ( minPriceFromURL !== null ) $minPrice.val( minPriceFromURL );
	if ( maxPriceFromURL !== null ) {
		$maxPrice.val( maxPriceFromURL );
	} else {
		$maxPrice.val( originalMaxPrice ); // Reset max price to original value
	}

	$minPrice.on( 'input', updatePriceValues );
	$maxPrice.on( 'input', updatePriceValues );

	// Apply filters when button is clicked
	$( document ).on( 'click', '.crafto-price-range button', function ( e ) {
		e.preventDefault();
		updateFilters();
	});
	
	$( document ).on( 'click', '.clear-all-filters', function ( e ) {
		e.preventDefault(); // Prevent default page reload
	
		const url = new URL( $( this ).attr( 'href' ), window.location.origin );

		$( '.crafto-shop-content-part .crafto-shop-common-isotope' ).block( { message: null, overlayCSS: { background: '#ffffff', opacity: 0.6 } } );

		$.ajax({
			url: url.toString(),
			type: 'GET',
			success: function ( response ) {
				// Update pagination
				refreshShopProducts( response );
	
				// Remove the Active Filters section
				$( '.crafto-active-filters' ).remove();
	
				// Uncheck all checkboxes
				$( '.filter-checkbox, .color-filter-checkbox, .size-filter-checkbox, .attribute-filter-checkbox' ).prop( 'checked', false );
	
				// Reset price range
				let $minPrice     = $( '#minPrice' );
				let $maxPrice     = $( '#maxPrice' );
				let $priceWrapper = $( '.price-range-wrapper' );
	
				// Get min & max values
				var min = $minPrice.attr( 'min' );
				var max = $maxPrice.attr( 'max' );
	
				// Reset price inputs
				$minPrice.val( min ).trigger( 'input' ); 
				$maxPrice.val( max ).trigger( 'input' );
	
				// Update displayed values
				$( '#minPriceValue' ).text( '$' + min );
				$( '#maxPriceValue' ).text( '$' + max );
	
				// Reset CSS custom properties for range slider
				$priceWrapper.css( '--low-value', '0%' );
				$priceWrapper.css( '--high-value', '100%' );
	
				// Ensure slider updates correctly
				$minPrice.trigger( 'change' );
				$maxPrice.trigger( 'change' );
	
				// Update browser URL
				window.history.pushState( null, '', url.toString() );
			},
		} );
		return false;
	} );
	
	$( document ).on( 'click', '.crafto-active-filters ul li a', function ( e ) {
		e.preventDefault(); // Prevent default link behavior
	
		let $this              = $( this );
		let clickedFilter      = $this.data( 'slug' ) || $this.text().trim().toLowerCase();
		let url                = new URL( window.location.href );
		let params             = new URLSearchParams( url.search );
		let priceFilterRemoved = false;
	
		// **Check if the clicked filter is a price filter**
		let isPriceFilter = clickedFilter.includes( 'price' ) || clickedFilter.includes( '$' );
	
		// **Remove the clicked filter from URL**
		params.forEach( ( value, key ) => {
			let values = value.split( ',' ).map( v => v.trim().toLowerCase() );
			let updatedValues = values.filter( v => v !== clickedFilter );
	
			if ( values.includes( clickedFilter ) ) {
				if ( updatedValues.length > 0 ) {
					params.set( key, updatedValues.join( ',' ) ); // Update remaining values
				} else {
					params.delete( key ); // Remove param if empty
				}
			}
		} );
	
		// **Forcefully remove price filters**
		if ( isPriceFilter || clickedFilter === 'min_price' || clickedFilter === 'max_price' ) {
			params.delete( 'max_price' );
			params.delete( 'min_price' );
			priceFilterRemoved = true;
		}
	
		// **Update URL without reloading**
		url.search = params.toString();
		window.history.replaceState( null, "", url.href );

		$( '.crafto-shop-content-part .crafto-shop-common-isotope' ).block( { message: null, overlayCSS: { background: '#ffffff', opacity: 0.6 } } );
	
		// **Perform AJAX request**
		$.ajax({
			url: url.href,
			type: "GET",
			success: function ( response ) {
				let $response  = $( response );
				let newFilters = $response.find( '.crafto-active-filters' ).html();
	
				if ( newFilters ) {
					$( '.crafto-active-filters' ).html( newFilters );
				} else {
					$( '.crafto-active-filters' ).remove();
				}
	
				// Update pagination
				refreshShopProducts( response );
	
				// Reset checkboxes and dropdowns
				$( '.filter-checkbox, .size-filter-checkbox, .color-filter-checkbox, .attribute-filter-checkbox, .price-range-input' ).each( function () {
					let termSlug = $( this ).attr( 'data-term-slug' ) || $( this ).val();
					if ( termSlug.toLowerCase() === clickedFilter ) {
						if ( $( this ).is( 'select' ) ) {
							$( this ).val( "" ).trigger( 'change' ); // Reset dropdown
						} else {
							$( this ).prop( 'checked', false ).trigger( 'change' ); // Uncheck checkboxes
						}
					}
				});
	
				// Reset Price Range Sliders & Remove from Active Filters
				if ( priceFilterRemoved ) {
					let minPrice      = $( '#minPrice' ).attr( 'min' );
					let maxPrice      = $( '#maxPrice' ).attr( 'max' );
					let $priceWrapper = $( '.price-range-wrapper' );

					// Set initial values
					$priceWrapper.css( '--low-value', '0%' );
					$priceWrapper.css( '--high-value', '100%' );
	
					$( '#minPrice' ).val( minPrice );
					$( '#maxPrice' ).val( maxPrice );
	
					$( '#minPriceValue' ).text( '$' + minPrice ); // Reset min price display
					$( '#maxPriceValue' ).text( '$' + maxPrice ); // Reset max price display
	
					// Remove price filter from active filters
					$( '.crafto-active-filters ul li' ).each( function () {

						let filterText = $( this ).text().trim().toLowerCase();

						if ( filterText.includes( 'price' ) || filterText.includes( '$' ) ) {
							$( this ).remove(); // Remove price filter
						}
					} );
				}
			},
		} );
		return false;
	} );

	var CraftoMain           = window.CraftoMain || { disable_scripts: [] },
		productCommonWrap    = $( '.crafto-product-list-common-wrap.products' ),
		commonPagination     = $( '.crafto-common-pagination-wrap .crafto-common-scroll a.next' ),
		shopContentPart      = '.crafto-shop-content-part ul.products',
		commonPaginationWrap = '.crafto-common-pagination-wrap',
		defaultPagination    = '.crafto-default-pagination-wrap',
		shopContent          = '.crafto-shop-content-part',
		pageLoadStatus       = $( '.page-load-status' );

	if ( 'undefined' != typeof CraftoMain && $.inArray( 'swiper', CraftoMain.disable_scripts ) < 0 ) {
		if ( $( '.recent-product-widget' ).length > 0 ) {
			new Swiper( '.recent-product-widget', {
				slidesPerView: 1,
				spaceBetween: 10,
				loop: true,
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
			});
		}
	}

	if ( getWindowWidth() < 992 ) {
		var filter_length = $( '.crafto-active-filters' ).length;
		if ( filter_length > 0 ) {
			var filter_length_left  = $( '.crafto-left-common-sidebar-link' ).length;
			var filter_length_right = $( '.crafto-right-common-sidebar-link' ).length;
			if ( filter_length_left > 0 ) {
				setTimeout( function() {
					$( '.crafto-left-common-sidebar-link' ).click();
				}, 1500 );
			}
			if ( filter_length_right > 0 ) {
				setTimeout( function() {
					$( '.crafto-right-common-sidebar-link' ).click();
				}, 1500 );
			}
		}
	}

	if ( productCommonWrap.length > 0 && commonPagination.length > 0  ) {
		var $productinfinite = filterProductInfiniteScroll();
			productAppendInfiniteScroll( $productinfinite );
	}

	function refreshProductTooltip() {
		var tooltip_pos = $( '.product-buttons-wrap, .shop-icon-wrap' ).attr( 'data-tooltip-position' );
		if ( tooltip_pos != '' && tooltip_pos != undefined ) { // Check tooltip position
			$( '.product-buttons-wrap a i, .shop-icon-wrap a i' ).attr( 'data-bs-placement', tooltip_pos ).tooltip();
		}
	}

	function productAppendInfiniteScroll( $productinfinite ) {

		if ( commonPagination.length > 0 && ! $( '.crafto-shop-list' ).length > 0 ) {
			if ( $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
				$productinfinite.on( 'append.infiniteScroll', function( event, response, path, items ) {
					/* For safari */
					$( items ).find('img[srcset]').each( function( i, img ) {
						img.outerHTML = img.outerHTML;
					});
					/* For new element set masonry */
					if ( $.inArray( 'isotope', CraftoMain.disable_scripts ) < 0 ) {
						var $newProducts = $( items );
						$newProducts.imagesLoaded( function() {
							productCommonWrap.isotope( 'appended', $newProducts );
							if ( productCommonWrap.data( 'isotope' ) ) {
								productCommonWrap.isotope( 'layout' );
							}
						});
					}

					refreshProductTooltip();
				});
			}
			$productinfinite.on( 'last.infiniteScroll', function( event, response, path ) {
				pageLoadStatus.hide();
				setTimeout( function() {
					pageLoadStatus.show();
				}, 500 );
				setTimeout( function() {
					pageLoadStatus.hide();
				}, 2500 );
			});
		}
	}

	function filterProductInfiniteScroll() {
		if ( $.inArray( 'infinite-scroll', CraftoMain.disable_scripts ) < 0 ) {
			let navselector     = '.crafto-common-pagination-wrap .crafto-common-scroll';
			let contentselector = '.crafto-product-list-common-wrap.products';
			let itemselector    = '.crafto-product-list-common-wrap.products .product';

			if( commonPagination.length > 0 ) {
				var $productinfinite = $( '.crafto-product-list-common-wrap.products' ).infiniteScroll({
					path: '.crafto-common-pagination-wrap .crafto-common-scroll a.next',
					history: false,
					navSelector: navselector,
					contentSelector: contentselector,
					append: itemselector,
					status: '.page-load-status',
					button: '.view-more-button'
				});
			}

			if ( $( '.crafto-loadmore-pagination-wrap .crafto-loadmore-scroll a.next' ).length > 0 ) {
				$( '.view-more-button' ).css( 'display', 'block' );
				$productinfinite.infiniteScroll( 'option', {
					scrollThreshold: false,
					loadOnScroll: false
				});
			}
			return $productinfinite;
		}
	}

	function refreshShopProducts( response ) {
		if ( response != '' && response != undefined ) {

			var destroyLayout = false;
			if ( $( shopContentPart ).length > 0 ) {

				destroyLayout = true;
			}

			var reInitializeInfiniteScroll = false;
			if ( ! $( commonPaginationWrap ).length > 0 ) {
				
				reInitializeInfiniteScroll = true;
			}

			if ( $( response ).find( shopContentPart ).length > 0 && $( shopContentPart ).length > 0 ) {

				var products = $( response ).find( shopContentPart ).html();

				// Display products
				$( shopContentPart ).html( products );

			} else {                     

				var products = $( response ).find( shopContent ).html();

				// Display products
				$( shopContent ).html( products );
			}

			if ( $( response ).find( defaultPagination ).length > 0 ) {

				$( defaultPagination ).html( $( response ).find( defaultPagination ).html() );

			} else {

				$( defaultPagination ).html( '' );
			}

			// Display infinite pagination
			if ( $( response ).find( commonPaginationWrap ).length > 0 ) {

				$( commonPaginationWrap ).html( $( response ).find( commonPaginationWrap ).html() );

				/* Product Archive Infinite Scroll */
				if ( commonPagination.length > 0 ) {
					var $productinfinite = filterProductInfiniteScroll();
					$productinfinite.infiniteScroll( 'create' );
				}
				if ( reInitializeInfiniteScroll ) { // Re-Initialize Infinite Scroll
					$( shopContentPart ).after( '<div class="crafto-common-pagination-wrap wow fadeIn">' + $( response ).find( commonPaginationWrap ).html() + '</div>' );
					$productinfinite = filterProductInfiniteScroll();
					$productinfinite.infiniteScroll( 'create' );
					productAppendInfiniteScroll( $productinfinite );
				}
			} else {

				if ( $( commonPaginationWrap ).length > 0 ) {
					var $productinfinite = filterProductInfiniteScroll();
					if ( $productinfinite != '' && $productinfinite != undefined ) {

						$( '.view-more-button' ).css( 'display', 'none' );
						$productinfinite.infiniteScroll( 'destroy' );
					}
				}
			}

			// Display Tooltip
			refreshProductTooltip();

			// Display Filter Count
			$( '.woocommerce-result-count' ).html( $( response ).find( '.woocommerce-result-count' ).html() );

			// Display ordering form
			$( '.woocommerce-ordering-ajax' ).html( $( response ).find( '.woocommerce-ordering-ajax' ).html() );

			if ( destroyLayout ) {

				/* Destroy isotope */
				if ( $( '.crafto-shop-common-isotope' ).data( 'isotope' ) ) {
					$( '.crafto-shop-common-isotope' ).isotope( 'destroy' );
				}
			}

			var transitionTime = 0;
			if ( $( '.crafto-column-switch' ).length > 0 ) { // Column switch is found

				transitionTime = '0.4s';
			}
			var $shop_common = $( '.crafto-shop-common-isotope' );
			$shop_common.imagesLoaded( function () {
				$shop_common.isotope({
					layoutMode: 'masonry',
					itemSelector: '.product',
					percentPosition: true,
					transitionDuration: transitionTime,
					stagger: 0,
					masonry: {
						columnWidth: '.grid-sizer',
					},
				});
				$shop_common.isotope();
				if ( $( '.crafto-shop-common-isotope' ).data( 'isotope' ) ) {
					setTimeout( function() {
						if ( $shop_common.data( 'isotope' ) ) {
							$shop_common.isotope( 'layout' );
						}
					}, 500 );
				}
			});
		}
	}
});
