<?php
/**
 * Loop Compare
 *
 * This template can be overridden by copying it to yourtheme/crafto/loop/compare-product.php.
 *
 * @package Crafto
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
$product_archive_list_style          = crafto_get_product_archive_list_style();
$crafto_single_product_compare_icon  = get_theme_mod( 'crafto_single_product_compare_icon', 'icon-feather-layers' );
$crafto_product_archive_compare_text = get_theme_mod( 'crafto_product_archive_compare_text', esc_html__( 'Compare', 'crafto-addons' ) );

$title_attribute = '';
if ( ! empty( $crafto_product_archive_compare_text ) ) {
	$title_attribute = ' title="' . esc_attr( $crafto_product_archive_compare_text ) . '"';
}

// phpcs:ignore
echo apply_filters(
	'crafto_addons_loop_product_compare_link',
	sprintf(
		'<a rel="nofollow" href="javascript:void(0);" data-product_id="%s" class="alt-font %s">%s</a>',
		esc_attr( $product->get_id() ),
		esc_attr( isset( $class ) ? $class : 'button' ),
		'<i class="' . esc_attr( $crafto_single_product_compare_icon ) . '"' . $title_attribute . '></i><span class="compare-text button-text">' . $crafto_product_archive_compare_text . '</span>'
	),
	$product
);
