<?php
/**
 * Quick View Product Compare
 *
 * This template can be overridden by copying it to yourtheme/crafto/quick-view/compare-product.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
// phpcs:ignore
echo apply_filters(
	'crafto_addons_quick_view_product_compare_link',
	sprintf(
		'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
		esc_attr( $product->get_id() ),
		esc_attr( isset( $class ) ? $class : '' ),
		'<i class="' . esc_attr( $compare_icon ) . '" title="' . esc_attr( $compare_text ) . '"></i><span class="compare-text button-text">' . $compare_text . '</span>'
	),
	$product
);
