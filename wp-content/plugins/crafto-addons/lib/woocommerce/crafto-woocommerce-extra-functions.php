<?php
/**
 * Crafto Woocommerce Extra Functions.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'crafto_print_woo_popups' ) ) {
	/**
	 * To Add compare, quickview, promopopup product popup functionality.
	 */
	function crafto_print_woo_popups() {

		// Load for Compare product popup.
		$crafto_product_archive_enable_compare = crafto_get_product_archive_enable_compare();
		$crafto_single_product_enable_compare  = crafto_get_single_product_enable_compare();

		if ( '1' === $crafto_product_archive_enable_compare || '1' === $crafto_single_product_enable_compare ) {
			echo '<div id="crafto_compare_popup" class="woocommerce crafto-popup-content crafto-compare-popup crafto-white-popup"></div>';

			// To enqueue add to compare script.
			wp_enqueue_script( 'crafto-product-compare' );
		}

		// Load for Quick View product popup.
		$crafto_product_archive_enable_quick_view = crafto_get_product_archive_enable_quick_view();

		if ( '1' === $crafto_product_archive_enable_quick_view ) {

			echo '<div id="crafto_quick_view_popup" class="woocommerce crafto-popup-content crafto-quick-view-popup crafto-white-popup"></div>';

			// Load for quick view single product.
			wp_enqueue_script( 'wc-single-product' );

			// Load for quick view single product variation.
			wp_enqueue_script( 'wc-add-to-cart-variation' );

			// To enqueue add to Quick View script.
			wp_enqueue_script( 'crafto-quick-view' );

			$crafto_quick_view_product_enable_wishlist = get_theme_mod( 'crafto_quick_view_product_enable_wishlist', '1' );
			if ( '1' === $crafto_quick_view_product_enable_wishlist ) {
				wp_enqueue_script( 'crafto-wishlist' );
			}
		}

		echo '<div id="crafto_product_share" class="woocommerce crafto-popup-content crafto-share-popup crafto-white-popup">' . crafto_single_product_share_shortcode() . '</div>'; // phpcs:ignore. 
	}
}

/**
 * Load compare, quickview, promopopup details in footer
 *
 * @see crafto_print_woo_popups()
 */
add_action( 'wp_footer', 'crafto_print_woo_popups', -1 );
