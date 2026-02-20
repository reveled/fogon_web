<?php
/**
 * Loop Compare
 *
 * This template can be overridden by copying it to yourtheme/crafto/loop/add-to-cart.php.
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
	'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
	sprintf(
		'<a href="%s" data-quantity="%s" class="alt-font %s" %s>%s</a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
		'<i class="' . crafto_get_product_button_icon() . '" title="' . esc_attr( $product->add_to_cart_text() ) . '"></i><span class="add-to-cart-text button-text">' . esc_html( $product->add_to_cart_text() ) . '</span>'
	),
	$product,
	$args
);
