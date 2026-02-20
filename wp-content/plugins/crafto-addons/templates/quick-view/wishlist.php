<?php
/**
 * Quick View Product Wishlist
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/wishlist.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

$product_id    = $product->get_id();
$data          = crafto_addons_get_product_wishlist();
$wishlist_id   = get_option( 'woocommerce_wishlist_page_id' );
$wishlish_icon = get_theme_mod( 'crafto_single_product_wishlish_icon', 'icon-feather-heart' );
$wishlist_text = get_theme_mod( 'crafto_quick_view_product_wishlist_text', esc_html__( 'Add to wishlist', 'crafto-addons' ) );

if ( ! empty( $data ) ) {
	if ( '' !== $wishlist_id ) {
		if ( in_array( $product_id, $data, false ) ) {
			 // phpcs:ignore
			echo apply_filters(
				'crafto_quick_view_product_wishlist_link',
				sprintf(
					'<a rel="nofollow" href="' . get_permalink( $wishlist_id ) . '" data-product_id="%s" class="alt-font %s">%s</a>',
					esc_attr( $product->get_id() ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					'<i class="icon-feather-heart-on" title="' . esc_attr__( 'Browse wishlist', 'crafto-addons' ) . '"></i><span class="wish-list-text button-text">' . esc_html__( 'Browse wishlist', 'crafto-addons' ) . '</span>'
				),
				$product
			);
		} else {
			 // phpcs:ignore
			echo apply_filters(
				'crafto_quick_view_product_wishlist_link',
				sprintf(
					'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
					esc_attr( $product->get_id() ),
					esc_attr( isset( $class ) ? $class : 'button' ),
					'<i class="' . esc_attr( $wishlish_icon ) . '" title="' . esc_attr( $wishlist_text ) . '"></i><span class="wish-list-text button-text">' . $wishlist_text . '</span>'
				),
				$product
			);
		}
	} elseif ( in_array( $product_id, $data, false ) ) {
		// phpcs:ignore
		echo apply_filters(
			'crafto_quick_view_product_wishlist_link',
			sprintf(
				'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="wishlist-added alt-font %s">%s</a>',
				esc_attr( $product->get_id() ),
				esc_attr( isset( $class ) ? $class : 'button' ),
				'<i class="icon-feather-heart-on" title="' . esc_attr__( 'Remove wishlist', 'crafto-addons' ) . '"></i><span class="wish-list-text button-text">' . esc_html__( 'Remove Wishlist', 'crafto-addons' ) . '</span>'
			),
			$product
		);
	} else {
		// phpcs:ignore
		echo apply_filters(
			'crafto_quick_view_product_wishlist_link',
			sprintf(
				'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
				esc_attr( $product->get_id() ),
				esc_attr( isset( $class ) ? $class : 'button' ),
				'<i class="' . esc_attr( $wishlish_icon ) . '" title="' . esc_attr( $wishlist_text ) . '"></i><span class="wish-list-text button-text">' . $wishlist_text . '</span>'
			),
			$product
		);
	}
} else {
	// phpcs:ignore
	echo apply_filters(
		'crafto_quick_view_product_wishlist_link',
		sprintf(
			'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
			esc_attr( $product->get_id() ),
			esc_attr( isset( $class ) ? $class : 'button' ),
			'<i class="' . esc_attr( $wishlish_icon ) . '" data-bs-toggle="tooltip" title="' . esc_attr( $wishlist_text ) . '"></i><span class="wish-list-text button-text">' . $wishlist_text . '</span>'
		),
		$product
	);
}
