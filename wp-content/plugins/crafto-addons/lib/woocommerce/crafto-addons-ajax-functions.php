<?php
/**
 * Crafto Addons Ajax functions.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'crafto_addons_ajax_compare_details' ) ) {
	/**
	 * Handles AJAX requests for comparing product details.
	 */
	function crafto_addons_ajax_compare_details() {
		// Initialize output and cookie name.
		$output      = '';
		$cookie_name = 'crafto-compare' . ( is_multisite() ? '-' . get_current_blog_id() : '' );

		// Get the cookie values.
		$cookie     = ! empty( $_COOKIE[ $cookie_name ] ) ? $_COOKIE[ $cookie_name ] : ''; // phpcs:ignore
		$productids = ! empty( $cookie ) ? explode( ',', $cookie ) : array();

		if ( ! empty( $productids ) ) {

			ob_start();
			// Display compare details.
			do_action( 'crafto_compare_details', $productids );
			$output .= ob_get_contents();
			ob_end_clean();

			echo sprintf( '%s', $output ); // phpcs:ignore
		}
		wp_die();
	}
}
add_action( 'wp_ajax_compare_details', 'crafto_addons_ajax_compare_details' );
add_action( 'wp_ajax_nopriv_compare_details', 'crafto_addons_ajax_compare_details' );

if ( ! function_exists( 'crafto_addons_ajax_quick_view_product_details' ) ) {
	/**
	 * AJAX to Add quick view product functionality.
	 */
	function crafto_addons_ajax_quick_view_product_details() {
		$productid = ! empty( $_POST['productid'] ) ? $_POST['productid'] : ''; // phpcs:ignore

		if ( ! empty( $productid ) ) {

			ob_start();
			// Display quick view product details.
			do_action( 'crafto_quick_view_product_details', $productid );
			$output = ob_get_contents();
			ob_end_clean();

			echo sprintf( '%s', $output ); // phpcs:ignore
		}
		wp_die();
	}
}
add_action( 'wp_ajax_quick_view_product_details', 'crafto_addons_ajax_quick_view_product_details' );
add_action( 'wp_ajax_nopriv_quick_view_product_details', 'crafto_addons_ajax_quick_view_product_details' );

if ( ! function_exists( 'crafto_addons_add_wishlist' ) ) {
	/**
	 * Ajax to Add Wishlist product Functionality.
	 */
	function crafto_addons_add_wishlist() {
		$wishlistid = ! empty( $_POST['wishlistid'] ) ? $_POST['wishlistid'] : ''; // phpcs:ignore
		$data       = crafto_addons_set_product_wishlist( $wishlistid );
		wp_die();
	}
}
add_action( 'wp_ajax_crafto_addons_add_wishlist', 'crafto_addons_add_wishlist' );
add_action( 'wp_ajax_nopriv_crafto_addons_add_wishlist', 'crafto_addons_add_wishlist' );

if ( ! function_exists( 'crafto_addons_page_remove_wishlist' ) ) {
	/**
	 * Remove product in Wishlist page.
	 */
	function crafto_addons_page_remove_wishlist() {

		$removeid = ! empty( $_POST['removeids'] ) ? $_POST['removeids'] : ''; // phpcs:ignore

		if ( ! empty( $removeid ) ) {

			$removeid = explode( ',', $removeid );

			// Remove Wishlist Data.
			$data = crafto_addons_remove_product_wishlist( $removeid );
			crafto_addons_wishlist_page_data( $data );
		}
		wp_die();
	}
}

add_action( 'wp_ajax_crafto_addons_page_remove_wishlist', 'crafto_addons_page_remove_wishlist' );
add_action( 'wp_ajax_nopriv_crafto_addons_page_remove_wishlist', 'crafto_addons_page_remove_wishlist' );

if ( ! function_exists( 'crafto_addons_empty_wishlist_all' ) ) {
	/**
	 * Clears all items from the user's wishlist (either from user meta or cookies).
	 */
	function crafto_addons_empty_wishlist_all() {
		// Check if the user is logged in.
		if ( is_user_logged_in() ) {
			// Get current user ID and clear wishlist from user meta.
			$user_id = get_current_user_id();
			update_user_meta( $user_id, '_crafto_wishlist', '' ); // phpcs:ignore
		} else {
			// Clear the wishlist cookie for non-logged-in users.
			$cookie_name = ( is_multisite() ) ? 'crafto-wishlist-' . get_current_blog_id() : 'crafto-wishlist'; // phpcs:ignore
			setcookie( $cookie_name, '', time() - 3600, '/' ); // Expire the cookie immediately.
		}

		// Prepare data for the wishlist template.
		$data     = array();
		$defaults = array(
			'data' => $data,
		);

		ob_start();
		crafto_addons_get_template( 'wishlist/product-wishlist.php', $defaults );
		$output = ob_get_contents();
		ob_end_clean();

		echo sprintf( '%s', $output ); // phpcs:ignore
		wp_die();
	}
}
add_action( 'wp_ajax_crafto_addons_empty_wishlist_all', 'crafto_addons_empty_wishlist_all' );
add_action( 'wp_ajax_nopriv_crafto_addons_empty_wishlist_all', 'crafto_addons_empty_wishlist_all' );

if ( ! function_exists( 'crafto_refresh_wishlist' ) ) {
	/**
	 * Refresh wishlist
	 */
	function crafto_refresh_wishlist() {

		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$data    = get_user_meta( $user_id, '_crafto_wishlist', true );
		} else {
			$cookie_name = ( is_multisite() ) ? 'crafto-wishlist-' . get_current_blog_id() : 'crafto-wishlist';
			$data        = ! empty( $_COOKIE[ $cookie_name ] ) ? $_COOKIE[ $cookie_name ] : ''; // phpcs:ignore
		}

		$data = ! empty( $data ) ? explode( ',', $data ) : array();

		if ( is_array( $data ) ) {
			$data = count( $data );
			echo sprintf( '<span class="crafto-wishlist-counter alt-font">%s</span>', $data ); // phpcs:ignore
		}

		wp_die();
	}
}
add_action( 'wp_ajax_crafto_refresh_wishlist', 'crafto_refresh_wishlist' );
add_action( 'wp_ajax_nopriv_crafto_refresh_wishlist', 'crafto_refresh_wishlist' );
