<?php
/**
 * Crafto Woocommerce Global Functions.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'crafto_get_product_archive_enable_quick_view' ) ) {
	/**
	 * To get Product archive enable quick view.
	 */
	function crafto_get_product_archive_enable_quick_view() {

		$enable_quick_view = crafto_option( 'crafto_product_archive_enable_quick_view', '1' );

		return apply_filters( 'crafto_product_archive_enable_quick_view', $enable_quick_view );
	}
}

if ( ! function_exists( 'crafto_get_product_archive_list_style' ) ) {
	/**
	 * To get Product archive list style.
	 */
	function crafto_get_product_archive_list_style() {

		$shop_style = get_theme_mod( 'crafto_product_archive_premade_style', 'shop-standard' );

		return apply_filters( 'crafto_product_archive_style', $shop_style );
	}
}

if ( ! function_exists( 'crafto_get_single_content_product_style' ) ) {
	/**
	 * To get Single content product style.
	 */
	function crafto_get_single_content_product_style() {

		$product_page_style = crafto_option( 'crafto_product_single_premade_style', 'single-product-classic' );

		return apply_filters( 'crafto_product_single_style', $product_page_style );
	}
}

if ( ! function_exists( 'crafto_addons_get_product_wishlist' ) ) {
	/**
	 * To get Product wishlist.
	 */
	function crafto_addons_get_product_wishlist() {

		if ( is_user_logged_in() ) {

			$user_id = get_current_user_id();
			$data    = get_user_meta( $user_id, '_crafto_wishlist', true );

		} else {
			$siteid      = ( is_multisite() ) ? '-' . get_current_blog_id() : '';
			$cookie_name = 'crafto-wishlist' . $siteid;
			$data        = ! empty( $_COOKIE[ $cookie_name ] ) ? $_COOKIE[ $cookie_name ] : ''; // phpcs:ignore
		}

		$data = ! empty( $data ) ? explode( ',', $data ) : array();
		return $data;
	}
}

if ( ! function_exists( 'crafto_get_product_archive_enable_wishlist' ) ) {
	/**
	 * To get Product archive enable wishlist.
	 */
	function crafto_get_product_archive_enable_wishlist() {

		$enable_wishlist = crafto_option( 'crafto_product_archive_enable_wishlist', '1' );

		return apply_filters( 'crafto_product_archive_enable_wishlist', $enable_wishlist );
	}
}

if ( ! function_exists( 'crafto_get_product_archive_enable_compare' ) ) {
	/**
	 * To get Product archive enable compare.
	 */
	function crafto_get_product_archive_enable_compare() {

		$enable_compare = crafto_option( 'crafto_product_archive_enable_compare', '0' );

		return apply_filters( 'crafto_product_archive_enable_compare', $enable_compare );
	}
}

if ( ! function_exists( 'crafto_get_single_product_enable_compare' ) ) {
	/**
	 * To get Product Single Product enable compare.
	 */
	function crafto_get_single_product_enable_compare() {

		$enable_compare = crafto_option( 'crafto_single_product_enable_compare', '1' );

		return apply_filters( 'crafto_single_product_enable_compare', $enable_compare );
	}
}

if ( ! function_exists( 'crafto_addons_remove_product_wishlist' ) ) {
	/**
	 * Remove products from the wishlist.
	 *
	 * @param mixed $wishlistids Array of wishlist product IDs to remove.
	 * @return string Updated wishlist data.
	 */
	function crafto_addons_remove_product_wishlist( $wishlistids ) {

		if ( ! empty( $wishlistids ) && is_array( $wishlistids ) ) {

			// Get user wishlist data.
			$data = crafto_addons_get_product_wishlist();

			// Return early if no data in wishlist.
			if ( empty( $data ) ) {
				return '';
			}

			// Remove wishlist IDs from the current wishlist using array_diff.
			$data = array_diff( $data, $wishlistids );

			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();

				// Update user wishlist data.
				update_user_meta( $user_id, '_crafto_wishlist', implode( ',', $data ) );
			} else {
				// Update cookie wishlist data.
				$cookie_name = 'crafto-wishlist' . ( is_multisite() ? '-' . get_current_blog_id() : '' );
				setcookie( $cookie_name, implode( ',', $data ), 0, '/' );
			}

			// Return the updated wishlist data.
			return implode( ',', $data );
		}
	}
}

if ( ! function_exists( 'crafto_addons_wishlist_page_data' ) ) {
	/**
	 * Wishlist Widget Refresh.
	 *
	 * @param mixed $data Get Data.
	 */
	function crafto_addons_wishlist_page_data( $data ) {

		$data = ! empty( $data ) ? explode( ',', $data ) : array();

		// Page Refresh After delete wishlist item.
		$output = '';

		if ( ! empty( $data ) ) {

			do_action( 'crafto_addons_wishlist_data', $data );

		} else {

			$defaults = array( 'data' => $data );
			ob_start();
			crafto_addons_get_template( 'wishlist/product-wishlist.php', $defaults );
			$output = ob_get_contents();
			ob_end_clean();
		}

		echo wp_kses_post( $output );
	}
}

if ( ! function_exists( 'crafto_addons_set_product_wishlist' ) ) {
	/**
	 *  To set Product wishlist.
	 *
	 * @param mixed $wishlistid wishlist.
	 */
	function crafto_addons_set_product_wishlist( $wishlistid ) {

		if ( ! empty( $wishlistid ) ) {

			// Get user wishlist data.
			$data = crafto_addons_get_product_wishlist();

			if ( ! empty( $data ) ) {

				if ( ! in_array( $wishlistid, $data, false ) ) {

					$data[] = $wishlistid;
				}
			} else {

				$data[] = $wishlistid;
			}

			$data = ! empty( $data ) ? implode( ',', $data ) : '';

			if ( is_user_logged_in() ) {

				$user_id = get_current_user_id();

				// Update user wishlist data.
				update_user_meta( $user_id, '_crafto_wishlist', $data );

			} else {

				// Update cookie wishlist data.
				$siteid      = ( is_multisite() ) ? '-' . get_current_blog_id() : '';
				$cookie_name = 'crafto-wishlist' . $siteid;
				setcookie( $cookie_name, $data, 0, '/' );
			}

			return $data;
		}
	}
}

// For Change single product popup image options.
if ( ! function_exists( 'crafto_override_single_product_photoswipe_options' ) ) {
	/**
	 *  To set Product popup image.
	 *
	 * @param mixed $options product popup image.
	 */
	function crafto_override_single_product_photoswipe_options( $options ) {
		$options['showAnimationDuration'] = 500;
		$options['bgOpacity']             = '0.7';
		$options['closeOnVerticalDrag']   = false;

		return $options;
	}
}
add_filter( 'woocommerce_single_product_photoswipe_options', 'crafto_override_single_product_photoswipe_options', 999 );
