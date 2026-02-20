<?php
/**
 * Loop Quick View
 *
 * This template can be overridden by copying it to yourtheme/crafto/loop/quick-view.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$product_archive_list_style             = crafto_get_product_archive_list_style();
$crafto_single_product_quick_view_icon  = get_theme_mod( 'crafto_single_product_quick_view_icon', 'icon-feather-eye' );
$crafto_product_archive_quick_view_text = get_theme_mod( 'crafto_product_archive_quick_view_text', esc_html__( 'Quick View', 'crafto-addons' ) );

$title_attribute = ' title="' . esc_attr( $crafto_product_archive_quick_view_text ) . '"';

echo apply_filters( 'woocommerce_loop_product_quick_view_link', // phpcs:ignore
	sprintf(
		'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
		esc_attr( $product->get_id() ),
		esc_attr( isset( $class ) ? $class : 'button' ),
		'<i class="' . esc_attr( $crafto_single_product_quick_view_icon ) . '"' . $title_attribute . '></i><span class="quick-view-text button-text">' . $crafto_product_archive_quick_view_text . '</span>'
	),
	$product,
);
