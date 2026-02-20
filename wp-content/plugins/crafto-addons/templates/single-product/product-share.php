<?php
/**
 * Single Product Wishlist
 *
 * This template can be overridden by copying it to yourtheme/crafto/single-product/product-share.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$crafto_single_product_enable_social_share = crafto_option( 'crafto_single_product_enable_social_share', '1' );
$crafto_single_product_share_title         = crafto_option( 'crafto_single_product_share_title', esc_html__( 'Share', 'crafto-addons' ) );

if ( '1' === $crafto_single_product_enable_social_share ) {
	global $product;

	echo apply_filters( 'crafto_single_product_share_link', // phpcs:ignore
		sprintf(
			'<a href="#crafto_product_share" data-product_id="%s" class="alt-font %s">%s</a>',
			esc_attr( $product->get_id() ),
			esc_attr( isset( $class ) ? $class : '' ),
			'<i class="feather icon-feather-share-2"></i><span class="share-text button-text">' . esc_html( $crafto_single_product_share_title ) . '</span>'
		),
		$product
	);
}
