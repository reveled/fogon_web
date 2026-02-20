<?php
/**
 * Single Product Compare
 *
 * This template can be overridden by copying it to yourtheme/crafto/single-product/compare-product.php.
 *
 * @package Crafto
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

/**
 * Apply filters for single product compare link so user can add it's own compare link.
 *
 * @since 1.0
 */

// phpcs:ignore
echo apply_filters(
	'crafto_addons_single_product_compare_link',
	sprintf(
		'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
		esc_attr( $product->get_id() ),
		esc_attr( isset( $class ) ? $class : '' ),
		'<i class="' . esc_attr( $compare_icon ) . '" title="' . esc_attr( $compare_text ) . '"></i><span class="compare-text button-text">' . $compare_text . '</span>'
	),
	$product
);
