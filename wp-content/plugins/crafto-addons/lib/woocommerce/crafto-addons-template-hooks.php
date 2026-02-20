<?php
/**
 * Crafto Addons Template Hooks.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/******* Compare hooks start ****** */

	/**
	 * Display compare details
	 *
	 * @see crafto_addons_compare_details()
	 */
	add_action( 'crafto_compare_details', 'crafto_addons_compare_details' );

	/**
	 * Display compare add to cart button
	 *
	 * @see crafto_addons_compare_list_add_to_cart()
	 */
	add_action( 'crafto_addons_compare_list_add_to_cart', 'crafto_addons_common_add_to_cart', 10, 2 );

	/**
	 * Display compare add to cart button
	 *
	 * @see crafto_addons_template_quick_view_product_compare()
	 */
	add_action( 'crafto_quick_view_product_summary', 'crafto_addons_template_quick_view_product_compare', 32 );

/******* Compare hooks end ****** */

/******* Quick View Hooks Start ****** */

	/**
	 * Display quick view product details
	 *
	 * @see crafto_quick_view_product_details()
	 */
	add_action( 'crafto_quick_view_product_details', 'crafto_quick_view_product_details' );

	/**
	 * Before Quick View Product Summary Div.
	 *
	 * @see crafto_show_quick_view_product_sale_flash()
	 * @see crafto_show_quick_view_product_image()
	 */
	add_action( 'crafto_before_quick_view_product_summary', 'crafto_show_quick_view_product_sale_flash', 10 );
	add_action( 'crafto_before_quick_view_product_summary', 'crafto_show_quick_view_product_image', 20 );

	/**
	 * Quick View Product Summary Box.
	 *
	 * @see crafto_template_quick_view_product_top_content_wrap_start()
	 * @see crafto_template_quick_view_product_title()
	 * @see crafto_template_quick_view_product_price()
	 * @see crafto_template_quick_view_product_top_content_wrap_middle()
	 * @see crafto_template_quick_view_product_rating()
	 * @see crafto_template_quick_view_product_sku()
	 * @see crafto_template_quick_view_product_top_content_wrap_end()
	 * @see crafto_template_quick_view_product_excerpt()
	 * @see woocommerce_template_single_add_to_cart()
	 * @see crafto_template_quick_view_product_wishlist()
	 * @see crafto_template_quick_view_product_meta()
	 * @see woocommerce_template_single_sharing()
	 */

	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_top_content_wrap_start', 2 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_title', 5 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_price', 11 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_top_content_wrap_middle', 9 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_rating', 9 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_sku', 10 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_top_content_wrap_end', 12 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_excerpt', 20 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_ajax_add_to_cart', 30 );
	add_action( 'crafto_quick_view_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_wishlist', 31 );
	add_action( 'crafto_quick_view_product_summary', 'crafto_template_quick_view_product_meta', 40 );
	add_action( 'crafto_quick_view_product_summary', 'woocommerce_template_single_sharing', 50 );

/******* Quick View Hooks End ****** */

/******* Shop loop style hooks start ****** */


if ( ! function_exists( 'crafto_addons_before_shop_loop' ) ) {
	/**
	 * Before shop loop hook.
	 *
	 * @param mixed $product_archive_list_style .
	 */
	function crafto_addons_before_shop_loop( $product_archive_list_style ) {

		if ( 'shop-standard' === $product_archive_list_style ) {

			add_action( 'woocommerce_before_shop_loop_item_title', 'crafto_icon_content_wrap_start', 109 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'crafto_addons_template_loop_product_quick_view', 110 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'crafto_addons_template_loop_product_wishlist', 115 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'crafto_addons_template_loop_product_compare', 120 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'crafto_icon_content_wrap_end', 121 );

		} elseif ( 'shop-simple' === $product_archive_list_style ) {

			add_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_quick_view', 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'crafto_addons_template_loop_product_wishlist', 15 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'crafto_addons_template_loop_product_compare', 20 );

		} else {

			add_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_quick_view', 15 );
			add_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_wishlist', 20 );
			add_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_compare', 25 );
		}
	}
}
add_action( 'crafto_before_shop_loop', 'crafto_addons_before_shop_loop' );

if ( ! function_exists( 'crafto_addons_after_shop_loop' ) ) {
	/**
	 * After shop loop hook.
	 *
	 * @param mixed $product_archive_list_style .
	 */
	function crafto_addons_after_shop_loop( $product_archive_list_style ) {

		if ( 'shop-standard' === $product_archive_list_style ) {

				remove_action( 'woocommerce_before_shop_loop_item_title', 'crafto_addons_template_loop_product_quick_view', 110 );
				remove_action( 'woocommerce_before_shop_loop_item_title', 'crafto_addons_template_loop_product_wishlist', 115 );
				remove_action( 'woocommerce_before_shop_loop_item_title', 'crafto_addons_template_loop_product_compare', 120 );

		} elseif ( 'shop-simple' === $product_archive_list_style ) {

				remove_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_quick_view', 10 );
				remove_action( 'woocommerce_after_shop_loop_item_title', 'crafto_addons_template_loop_product_wishlist', 15 );
				remove_action( 'woocommerce_after_shop_loop_item_title', 'crafto_addons_template_loop_product_compare', 20 );

		} else {
				remove_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_quick_view', 10 );
				remove_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_wishlist', 15 );
				remove_action( 'crafto_shop_loop_button', 'crafto_addons_template_loop_product_compare', 20 );
		}
	}
}
add_action( 'crafto_after_shop_loop', 'crafto_addons_after_shop_loop' );

/******* Shop loop style hooks end ****** */

/******* Single product style hooks start ****** */

if ( ! function_exists( 'crafto_addons_woocommerce_before_main_content' ) ) {
	/**
	 * WordPress woocommerce_before_main_content Action
	 */
	function crafto_addons_woocommerce_before_main_content() {

		if ( ! is_admin() ) {

			// Single content Simple Rating upper to title.
				$crafto_get_single_content_product_style = crafto_get_single_content_product_style();
			if ( ! empty( $crafto_get_single_content_product_style ) ) {
				switch ( $crafto_get_single_content_product_style ) {
					case 'single-product-classic':
					case 'single-product-default':
					default:
							/**
							 * To Add compare product functionality after wishlist link
							 *
							 * @see crafto_addons_template_single_product_wishlist()
							 */
							add_action( 'woocommerce_single_product_summary', 'crafto_addons_template_single_product_wishlist', 31 );

							add_action( 'woocommerce_single_product_summary', 'crafto_addons_template_single_product_share', 33 );

							/**
							 * To Add compare product functionality after Compare link
							 *
							 * @see crafto_addons_template_single_product_compare()
							 */
							add_action( 'woocommerce_single_product_summary', 'crafto_addons_template_single_product_compare', 32 );
						break;
				}
			}
		}
	}
}
add_action( 'woocommerce_before_main_content', 'crafto_addons_woocommerce_before_main_content' );

if ( ! function_exists( 'crafto_woocommerce_breadcrumb' ) ) {
	/**
	 * To Remove woocommerce_breadcrumb Action And Add New Action For WooCommerce Breadcrumb
	 *
	 * @param mixed $args .
	 */
	function crafto_woocommerce_breadcrumb( $args = array() ) {
		$args = wp_parse_args(
			$args,
			apply_filters(
				'woocommerce_breadcrumb_defaults',
				array(
					'delimiter'   => '',
					'wrap_before' => '',
					'wrap_after'  => '',
					'before'      => '<li>',
					'after'       => '</li>',
					'home'        => _x( 'Home', 'breadcrumb', 'crafto-addons' ),
				)
			)
		);

		$breadcrumbs = new WC_Breadcrumb();

		if ( ! empty( $args['home'] ) ) {
			$breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
		}

		$args['breadcrumb'] = $breadcrumbs->generate();

		/**
		 * WooCommerce Breadcrumb hook
		 *
		 * @hooked WC_Structured_Data::generate_breadcrumblist_data() - 10
		 */
		do_action( 'woocommerce_breadcrumb', $breadcrumbs, $args );

		wc_get_template( 'global/breadcrumb.php', $args );
	}
}
add_action( 'crafto_woocommerce_breadcrumb', 'crafto_woocommerce_breadcrumb', 20, 0 );

/******* Wishlist Hooks Start ****** */

/**
 * Display Wishlist add to cart button
 *
 * @see crafto_wishlist_list_add_to_cart()
 */
add_action( 'crafto_wishlist_page_add_to_cart', 'crafto_wishlist_page_add_to_cart', 10, 2 );

/**
 * Display wishlist shortcode data
 *
 * @see crafto_addons_wishlist_data()
 */
add_action( 'crafto_addons_wishlist_data', 'crafto_addons_wishlist_data' );

/******* Wishlist Hooks End ****** 1*/

/**
 * Display add to cart button into content widget, product slider
 *
 * @see crafto_addons_common_add_to_cart()
 * @see crafto_addons_template_loop_product_quick_view()
 * @see crafto_addons_template_loop_product_compare()
 * @see crafto_addons_template_loop_product_wishlist()
 */
add_action( 'crafto_content_widget_button', 'crafto_addons_common_add_to_cart', 10 );
add_action( 'crafto_content_widget_button', 'crafto_addons_template_loop_product_quick_view', 20 );
add_action( 'crafto_content_widget_button', 'crafto_addons_template_loop_product_compare', 30 );
add_action( 'crafto_content_widget_button', 'crafto_addons_template_loop_product_wishlist', 40 );
