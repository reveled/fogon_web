<?php
/**
 * Crafto Addons Template Functions.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/******* Compare template functions start ****** */

if ( ! function_exists( 'crafto_addons_template_loop_product_compare' ) ) {
	/**
	 * To Add compare functionality to shop page.
	 *
	 * @param mixed $args Optional. Arguments for the compare functionality.
	 */
	function crafto_addons_template_loop_product_compare( $args = array() ) {
		global $product;

		// To get Product archive list style.
		$crafto_product_archive_enable_compare = crafto_get_product_archive_enable_compare();

		if ( '1' !== $crafto_product_archive_enable_compare ) {
			return false;
		}

		if ( $product ) {
			$defaults = array(
				'quantity' => 1,
				'class'    => implode(
					' ',
					array_filter(
						array(
							'button',
							'product_type_' . $product->get_type(),
							'crafto-compare',
						)
					)
				),
			);

			$args = apply_filters( 'crafto_loop_product_compare_args', wp_parse_args( $args, $defaults ), $product );

			crafto_addons_get_template( 'loop/compare-product.php', $args );
		}

		// To enqueue add to compare script.
		wp_enqueue_script( 'crafto-product-compare' );
	}
}

if ( ! function_exists( 'crafto_addons_template_single_product_share' ) ) {
	/**
	 * Crafto Addons Template Single Product Share.
	 *
	 * @param mixed $args Optional.
	 */
	function crafto_addons_template_single_product_share( $args = array() ) {

		$defaults = array(
			'class' =>
			implode(
				' ',
				array_filter(
					array(
						'crafto-product-share',
					)
				)
			),
		);

		$args = apply_filters( 'crafto_single_product_share_link', wp_parse_args( $args, $defaults ) );

		crafto_addons_get_template( 'single-product/product-share.php', $args );
	}
}

if ( ! function_exists( 'crafto_addons_compare_details' ) ) {
	/**
	 * To Compare product template.
	 *
	 * @param mixed $productids details.
	 */
	function crafto_addons_compare_details( $productids ) {
		$crafto_compare_product_enable_heading = get_theme_mod( 'crafto_compare_product_enable_heading', '1' );
		$crafto_compare_product_heading_text   = get_theme_mod( 'crafto_compare_product_heading_text', esc_html__( 'Compare Products', 'crafto-addons' ) );
		$crafto_compare_product_enable_filter  = get_theme_mod( 'crafto_compare_product_enable_filter', '1' );

		$defaults = array(
			'productids'     => $productids,
			'enable_heading' => $crafto_compare_product_enable_heading,
			'heading_text'   => $crafto_compare_product_heading_text,
			'enable_filter'  => $crafto_compare_product_enable_filter,
		);

		$defaults = apply_filters( 'crafto_compare_product_details_args', $defaults );

		crafto_addons_get_template( 'compare-popup/compare-details.php', $defaults );
	}
}

if ( ! function_exists( 'crafto_addons_common_add_to_cart' ) ) {
	/**
	 * Compare Product Add To Cart.
	 *
	 * @param mixed $product cart.
	 * @param mixed $class_details cart.
	 */
	function crafto_addons_common_add_to_cart( $product, $class_details = '' ) {

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      =>
				implode(
					' ',
					array_filter(
						array(
							'button',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ' . $class_details : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', $defaults, $product );
			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
			}

			wc_get_template( 'loop/add-to-cart.php', $args );
		}
	}
}

if ( ! function_exists( 'crafto_addons_template_quick_view_product_compare' ) ) {
	/**
	 * Output the quick view product compare.
	 *
	 * @param mixed $args Optional. Arguments for the compare functionality.
	 */
	function crafto_addons_template_quick_view_product_compare( $args = array() ) {
		global $product;

		$crafto_quick_view_product_enable_compare = get_theme_mod( 'crafto_quick_view_product_enable_compare', '1' );

		if ( '1' !== $crafto_quick_view_product_enable_compare ) {
			return false;
		}

		$crafto_single_product_compare_icon     = get_theme_mod( 'crafto_single_product_compare_icon', 'icon-feather-repeat' );
		$crafto_quick_view_product_compare_text = get_theme_mod( 'crafto_quick_view_product_compare_text', esc_html__( 'Add to compare', 'crafto-addons' ) );

		if ( $product ) {
			$defaults = array(
				'compare_icon' => $crafto_single_product_compare_icon,
				'compare_text' => $crafto_quick_view_product_compare_text,
				'quantity'     => 1,
				'class'        => implode(
					' ',
					array_filter(
						array(
							'product_type_' . $product->get_type(),
							'crafto-compare',
						)
					)
				),
			);

			$args = apply_filters( 'crafto_quick_view_product_compare_args', wp_parse_args( $args, $defaults ), $product );

			crafto_addons_get_template( 'quick-view/compare-product.php', $args );
		}
	}
}

if ( ! function_exists( 'crafto_addons_template_single_product_compare' ) ) {
	/**
	 * To Add compare functionality to single page.
	 *
	 * @param mixed $args product compare.
	 */
	function crafto_addons_template_single_product_compare( $args = array() ) {
		if ( is_product() ) {

			global $product;

			$crafto_single_product_enable_compare = crafto_option( 'crafto_single_product_enable_compare', '1' );

			if ( '1' !== $crafto_single_product_enable_compare ) {
				return false;
			}

			$crafto_single_product_compare_icon = crafto_option( 'crafto_single_product_compare_icon', 'icon-feather-repeat' );
			$crafto_single_product_compare_text = crafto_option( 'crafto_single_product_compare_text', esc_html__( 'Add to compare', 'crafto-addons' ) );

			if ( $product ) {
				$defaults = array(
					'compare_icon' => $crafto_single_product_compare_icon,
					'compare_text' => $crafto_single_product_compare_text,
					'quantity'     => 1,
					'class'        => implode(
						' ',
						array_filter(
							array(
								'product_type_' . $product->get_type(),
								'crafto-compare',
							)
						)
					),
				);

				$args = apply_filters( 'crafto_single_product_compare_args', wp_parse_args( $args, $defaults ), $product );

				crafto_addons_get_template( 'single-product/compare-product.php', $args );
			}
		}

		// To enqueue add to compare script.
		wp_enqueue_script( 'crafto-product-compare' );
	}
}

/******* Compare template functions end ****** */

/******* Quick View template functions start ****** */

if ( ! function_exists( 'crafto_addons_template_loop_product_quick_view' ) ) {
	/**
	 * To Add quick view functionality to shop page.
	 *
	 * @param mixed array $args Optional. An associative array of arguments to customize the quick view functionality.
	 */
	function crafto_addons_template_loop_product_quick_view( $args = array() ) {
		global $product;

		// To get Product archive list style.

		$crafto_product_archive_enable_quick_view = crafto_get_product_archive_enable_quick_view();
		if ( '1' !== $crafto_product_archive_enable_quick_view ) {
			return false;
		}

		if ( $product ) {
			$defaults = array(
				'quantity' => 1,
				'class'    => implode(
					' ',
					array_filter(
						array(
							'button',
							'crafto-quick-view',
						)
					)
				),
			);

			$args = apply_filters( 'crafto_loop_product_quick_view_args', wp_parse_args( $args, $defaults ), $product );

			crafto_addons_get_template( 'loop/quick-view.php', $args );

			// To enqueue add to Quick View script.
			wp_enqueue_script( 'crafto-quick-view' );
		}
	}
}

if ( ! function_exists( 'crafto_show_quick_view_product_sale_flash' ) ) {
	/**
	 * Output the product sale flash.
	 */
	function crafto_show_quick_view_product_sale_flash() {

		crafto_addons_get_template( 'quick-view/sale-flash.php' );
	}
}

if ( ! function_exists( 'crafto_show_quick_view_product_image' ) ) {
	/**
	 * Output the quick view product image.
	 */
	function crafto_show_quick_view_product_image() {

		crafto_addons_get_template( 'quick-view/product-image.php' );
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_top_content_wrap_start' ) ) {
	/**
	 * Output the quick view top content wrap.
	 */
	function crafto_template_quick_view_product_top_content_wrap_start() {
		echo '<div class="summary-main-title">';
			echo '<div class="summary-main-title-left">';
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_title' ) ) {
	/**
	 * Output the quick view product title.
	 */
	function crafto_template_quick_view_product_title() {
		crafto_addons_get_template( 'quick-view/title.php' );
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_top_content_wrap_middle' ) ) {
	/**
	 * Output the quick view top content wrap middle.
	 */
	function crafto_template_quick_view_product_top_content_wrap_middle() {
		echo '</div>';
		echo '<div class="summary-main-title-right">';
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_top_content_wrap_end' ) ) {
	/**
	 * Output the quick view top content wrap end.
	 */
	function crafto_template_quick_view_product_top_content_wrap_end() {
			echo '</div>';
		echo '</div>';
	}
}

if ( ! function_exists( 'crafto_icon_content_wrap_start' ) ) {
	/**
	 * Crafto Icon Content Wrap Start.
	 */
	function crafto_icon_content_wrap_start() {
		echo '<div class="shop-icon-wrap" data-tooltip-position="left">';
	}
}

if ( ! function_exists( 'crafto_icon_content_wrap_end' ) ) {
	/**
	 * Crafto Icon Content Wrap End.
	 */
	function crafto_icon_content_wrap_end() {
		echo '</div>';
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_sku' ) ) {
	/**
	 * Output the quick view product sku.
	 */
	function crafto_template_quick_view_product_sku() {
		crafto_addons_get_template( 'quick-view/meta-sku.php' );
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_rating' ) ) {
	/**
	 * Output the quick view product rating.
	 */
	function crafto_template_quick_view_product_rating() {
		crafto_addons_get_template( 'quick-view/rating.php' );
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_price' ) ) {
	/**
	 * Output the quick view product price.
	 */
	function crafto_template_quick_view_product_price() {
		crafto_addons_get_template( 'quick-view/price.php' );
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_excerpt' ) ) {
	/**
	 * Crafto Template Quick View Product Excerpt.
	 */
	function crafto_template_quick_view_product_excerpt() {
		crafto_addons_get_template( 'quick-view/short-description.php' );
	}
}

if ( ! function_exists( 'crafto_quick_view_product_add_hidden_product_id' ) ) {
	/**
	 * Output the quick view product ajax add to cart.
	 */
	function crafto_quick_view_product_add_hidden_product_id() {

		global $product;

		echo '<input type="hidden" name="add-to-cart" value="' . esc_attr( $product->get_id() ) . '" />';
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_ajax_add_to_cart' ) ) {
	/**
	 * Crafto Template Quick View Product Ajax Add To Cart.
	 */
	function crafto_template_quick_view_product_ajax_add_to_cart() {
		add_action( 'woocommerce_after_add_to_cart_quantity', 'crafto_quick_view_product_add_hidden_product_id' );
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_wishlist' ) ) {
	/**
	 * Output the quick view product wishlist.
	 *
	 * @param array $args Optional. An associative array of arguments to customize the wishlist functionality.
	 */
	function crafto_template_quick_view_product_wishlist( $args = array() ) {

		global $product;

		$crafto_quick_view_product_enable_wishlist = get_theme_mod( 'crafto_quick_view_product_enable_wishlist', '1' );
		if ( '1' !== $crafto_quick_view_product_enable_wishlist ) {
			return false;
		}

		$class              = '';
		$crafto_wishlist_id = get_option( 'woocommerce_wishlist_page_id' );
		$wishlist_url       = ! empty( $crafto_wishlist_id ) ? get_permalink( $crafto_wishlist_id ) : '';
		$data               = crafto_addons_get_product_wishlist();
		$productid          = $product->get_id();

		if ( empty( $data ) ) {
			$class = 'crafto-wishlist crafto-wishlist-add';
		} else {
			$is_in_wishlist = in_array( $productid, $data, false ); // phpcs:ignore

			if ( ! empty( $wishlist_url ) ) {
				$class = $is_in_wishlist ? 'crafto-wishlist' : 'crafto-wishlist crafto-wishlist-add';
			} else {
				$class = $is_in_wishlist ? 'crafto-wishlist crafto-wishlist-remove' : 'crafto-wishlist crafto-wishlist-add';
			}
		}

		if ( $product ) {
			$classes = [ 'product_type_' . $product->get_type(), $class ];

			$defaults = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( $classes ) ),
			);

			// Merge defaults with provided args, and apply filter.
			$args = apply_filters( 'crafto_quick_view_product_wishlist_args', wp_parse_args( $args, $defaults ), $product );

			// Load the template.
			crafto_addons_get_template( 'quick-view/wishlist.php', $args );
		}
	}
}

if ( ! function_exists( 'crafto_template_quick_view_product_meta' ) ) {
	/**
	 * Output the quick view product meta.
	 */
	function crafto_template_quick_view_product_meta() {

		crafto_addons_get_template( 'quick-view/meta.php' );
	}
}

if ( ! function_exists( 'crafto_quick_view_product_details' ) ) {
	/**
	 * Display product details in the quick view modal.
	 *
	 * @param int $productid The ID of the product to show.
	 */
	function crafto_quick_view_product_details( $productid ) {

		if ( empty( $productid ) ) {
			return '';
		}

		$product = wc_get_product( $productid );

		if ( ! $product ) {
			return ''; // Exit if product is not found.
		}

		// Set up query to fetch the product by ID.
		$args = array(
			'p'             => absint( $product->get_id() ),
			'post_type'     => 'product',
			'post_status'   => 'publish',
			'no_found_rows' => true,
		);

		$single_product = new WP_Query( $args );

		if ( ! $single_product->have_posts() ) {
			return ''; // Exit if no product is found.
		}

		// For "is_single" to always make load comments_template() for reviews.
		$single_product->is_single = true;

		global $wp_query;

		// Backup query object so following loops think this is a product page.
		$previous_wp_query = $wp_query;
		// @codingStandardsIgnoreStart
		$wp_query = $single_product;
		// @codingStandardsIgnoreEnd

		ob_start();

		while ( $single_product->have_posts() ) {
			$single_product->the_post();
			// Output the product details template.
			crafto_addons_get_template( 'quick-view/product-details.php' );
		}

		// Restore $previous_wp_query and reset post data.
		// @codingStandardsIgnoreStart
		$wp_query = $previous_wp_query;
		// @codingStandardsIgnoreEnd
		wp_reset_postdata();

		// Get the buffered content and wrap it in WooCommerce container.
		$output = ob_get_clean();

		// Optionally enqueue script for quick view.
		wp_enqueue_script( 'crafto-quick-view' );

		echo '<div class="woocommerce">' . $output . '</div>'; // phpcs:ignore
	}
}

/******* Quick View template functions end ****** */

/******* Wishlist template functions end ****** */

if ( ! function_exists( 'crafto_addons_template_loop_product_wishlist' ) ) {
	/**
	 * Add wishlist functionality to the shop page.
	 *
	 * @param array $args Optional. An associative array of arguments to customize the wishlist functionality.
	 */
	function crafto_addons_template_loop_product_wishlist( $args = array() ) {
		global $product;

		// Get product archive list style and wishlist option.
		$crafto_product_archive_enable_wishlist = crafto_get_product_archive_enable_wishlist();

		// If wishlist functionality is disabled, exit.
		if ( '1' !== $crafto_product_archive_enable_wishlist ) {
			return false;
		}

		$class              = '';
		$crafto_wishlist_id = get_option( 'woocommerce_wishlist_page_id' );
		$wishlist_url       = ! empty( $crafto_wishlist_id ) ? get_permalink( $crafto_wishlist_id ) : '';
		$data               = crafto_addons_get_product_wishlist();
		$productid          = $product->get_id();

		if ( empty( $data ) ) {
			$class = 'crafto-wishlist crafto-wishlist-add';
		} else {
			$is_in_wishlist = in_array( $productid, $data, false ); // phpcs:ignore

			if ( ! empty( $wishlist_url ) ) {
				$class = $is_in_wishlist ? 'crafto-wishlist' : 'crafto-wishlist crafto-wishlist-add';
			} else {
				$class = $is_in_wishlist ? 'crafto-wishlist crafto-wishlist-remove' : 'crafto-wishlist crafto-wishlist-add';
			}
		}

		if ( $product ) {
			$classes = [ 'button', 'product_type_' . $product->get_type(), $class ];

			$defaults = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( $classes ) ),
			);

			// Merge defaults with provided args, and apply filter.
			$args = apply_filters( 'crafto_loop_product_wishlist_args', wp_parse_args( $args, $defaults ), $product );

			// Load the template.
			crafto_addons_get_template( 'loop/wishlist.php', $args );
		}

		// Enqueue wishlist script.
		wp_enqueue_script( 'crafto-wishlist' );
	}
}

if ( ! function_exists( 'crafto_addons_template_single_product_wishlist' ) ) {
	/**
	 * Add wishlist functionality to the single product page.
	 *
	 * @param array $args Optional. An associative array of arguments to customize the wishlist button.
	 */
	function crafto_addons_template_single_product_wishlist( $args = array() ) {
		// Check if we are on a single product page.
		if ( ! is_product() ) {
			return;
		}

		global $product;

		// Get theme setting for enabling wishlist on single product pages.
		$crafto_single_product_enable_wishlist = get_theme_mod( 'crafto_single_product_enable_wishlist', '1' );

		// If wishlist is disabled, exit.
		if ( '1' !== $crafto_single_product_enable_wishlist ) {
			return false;
		}

		$class              = '';
		$crafto_wishlist_id = get_option( 'woocommerce_wishlist_page_id' );
		$wishlist_url       = ! empty( $crafto_wishlist_id ) ? get_permalink( $crafto_wishlist_id ) : '';
		$data               = crafto_addons_get_product_wishlist();
		$productid          = $product->get_id();

		if ( empty( $data ) ) {
			$class = 'crafto-wishlist crafto-wishlist-add';
		} else {
			$is_in_wishlist = in_array( $productid, $data, false ); // phpcs:ignore

			if ( ! empty( $wishlist_url ) ) {
				$class = $is_in_wishlist ? 'crafto-wishlist' : 'crafto-wishlist crafto-wishlist-add';
			} else {
				$class = $is_in_wishlist ? 'crafto-wishlist crafto-wishlist-remove' : 'crafto-wishlist crafto-wishlist-add';
			}
		}

		if ( $product ) {
			$classes = [ 'button', 'product_type_' . $product->get_type(), $class ];

			$defaults = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( $classes ) ),
			);

			// Merge defaults with provided args, and apply filter.
			$args = apply_filters( 'crafto_single_product_wishlist_args', wp_parse_args( $args, $defaults ), $product );

			// Render the wishlist button template.
			crafto_addons_get_template( 'single-product/wishlist.php', $args );
		}

		// Enqueue wishlist script.
		wp_enqueue_script( 'crafto-wishlist' );
	}
}

if ( ! function_exists( 'crafto_wishlist_page_add_to_cart' ) ) {
	/**
	 * Wishlist Page Product Add To Cart.
	 *
	 * @param mixed  $product The product object or product ID to be added to the cart.
	 * @param string $class_details Optional.
	 */
	function crafto_wishlist_page_add_to_cart( $product, $class_details = '' ) {

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'button',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button ' . $class_details : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'crafto_wishlist_page_add_to_cart_args', $defaults, $product );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
			}

			crafto_addons_get_template( 'loop/add-to-cart.php', $args );
		}
	}
}

if ( ! function_exists( 'crafto_addons_wishlist_data' ) ) {
	/**
	 * List of Wishlist data.
	 *
	 * @param mixed $data The data to be used in the wishlist template.
	 */
	function crafto_addons_wishlist_data( $data ) {

		$defaults = array( 'data' => $data );
		crafto_addons_get_template( 'wishlist/product-wishlist.php', $defaults );

		// To enqueue add to wishlist script.
		wp_enqueue_script( 'crafto-wishlist' );
	}
}

/******* Wishlist template functions end ****** */
