<?php
/**
 * Loop Wishlist
 *
 * This template can be overridden by copying it to yourtheme/crafto/loop/wishlist.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$product_id = $product->get_id();
// Get Wishlist Details.

$data                       = crafto_addons_get_product_wishlist();
$product_archive_list_style = crafto_get_product_archive_list_style();
$wishlish_icon              = get_theme_mod( 'crafto_single_product_wishlish_icon', 'icon-feather-heart' );
$wishlist_text              = get_theme_mod( 'crafto_product_archive_wishlist_text', esc_html__( 'Add to Wishlist', 'crafto-addons' ) );
$browse_title_attribute     = ' title="' . esc_attr__( 'Browse wishlist', 'crafto-addons' ) . '"';
$remove_title_attribute     = ' title="' . esc_attr__( 'Remove wishlist', 'crafto-addons' ) . '"';
$title_attribute            = ' title="' . esc_attr( $wishlist_text ) . '"';
$wishlist_id                = get_option( 'woocommerce_wishlist_page_id' );

if ( ! empty( $data ) ) {
	if ( ! empty( $wishlist_id ) ) {
		if ( ! empty( $data ) && in_array( $product_id, $data, false ) ) {
			// phpcs:ignore
			echo apply_filters(
				'crafto_loop_product_wishlist_link',
				sprintf(
					'<a rel="nofollow" href="%s" data-product_id="%s" class="alt-font %s">%s</a>',
					esc_url( get_permalink( $wishlist_id ) ),
					esc_attr( $product->get_id() ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					'<i class="icon-feather-heart-on"' . $browse_title_attribute . '></i><span class="wish-list-text button-text">' . esc_html__( 'Browse wishlist', 'crafto-addons' ) . '</span>'
				),
				$product
			);
		} else {
			// phpcs:ignore
			echo apply_filters(
				'crafto_loop_product_wishlist_link',
				sprintf(
					'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
					esc_attr( $product->get_id() ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					'<i class="' . esc_attr( $wishlish_icon ) . '"' . $title_attribute . '></i><span class="wish-list-text button-text">' . esc_html( $wishlist_text ) . '</span>'
				),
				$product
			);
		}
	} elseif ( ! empty( $data ) && in_array( $product_id, $data, false ) ) {
		// phpcs:ignore
		echo apply_filters(
			'crafto_loop_product_wishlist_link',
			sprintf(
				'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="wishlist-added alt-font %s">%s</a>',
				esc_attr( $product->get_id() ),
				esc_attr( isset( $class ) ? $class : 'button' ),
				'<i class="icon-feather-heart-on"' . $remove_title_attribute . '></i><span class="wish-list-text button-text">' . esc_html__( 'Remove wishlist', 'crafto-addons' ) . '</span>'
			),
			$product
		);
	} else {
		// phpcs:ignore
		echo apply_filters(
			'crafto_loop_product_wishlist_link',
			sprintf(
				'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
				esc_attr( $product->get_id() ),
				esc_attr( isset( $class ) ? $class : 'button' ),
				'<i class="' . esc_attr( $wishlish_icon ) . '"' . $title_attribute . '></i><span class="wish-list-text button-text">' . esc_html( $wishlist_text ) . '</span>'
			),
			$product
		);
	}
} else {
	// phpcs:ignore
	echo apply_filters(
		'crafto_loop_product_wishlist_link',
		sprintf(
			'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
			esc_attr( $product->get_id() ),
			esc_attr( isset( $class ) ? $class : 'button' ),
			'<i class="' . esc_attr( $wishlish_icon ) . '"' . $title_attribute . '></i><span class="wish-list-text button-text">' . esc_html( $wishlist_text ) . '</span>'
		),
		$product
	);
}
