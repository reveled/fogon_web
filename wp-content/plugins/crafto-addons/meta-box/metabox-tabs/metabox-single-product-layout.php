<?php
/**
 * Metabox For Single Product Layout.
 *
 * @package Crafto
 */

if ( ! empty( $post->post_type ) && 'product' === $post->post_type ) {
	crafto_after_inner_separator_start(
		'separator_start',
		''
	);
	crafto_meta_box_dropdown(
		'crafto_product_single_premade_style_single',
		esc_html__( 'Single Product Style', 'crafto-addons' ),
		array(
			'default'                => esc_html__( 'Default', 'crafto-addons' ),
			'single-product-default' => esc_html__( 'Product Layout Default', 'crafto-addons' ),
			'single-product-classic' => esc_html__( 'Product Layout Classic', 'crafto-addons' ),
		)
	);
	crafto_meta_box_dropdown(
		'crafto_new_product_shop_single',
		esc_html__( 'Mark as New', 'crafto-addons' ),
		array(
			'0' => esc_html__( 'No', 'crafto-addons' ),
			'1' => esc_html__( 'Yes', 'crafto-addons' ),
		),
		esc_html__( "Enable to display a 'New' label on the product.", 'crafto-addons' ),
	);

	crafto_before_inner_separator_end(
		'separator_end',
		''
	);
}
