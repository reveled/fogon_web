<?php
/**
 * Metabox For Single Post Layout.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( 'post' === $post->post_type ) {

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);
	crafto_meta_box_upload(
		'crafto_post_layout_bg_image_single',
		esc_html__( 'Hero Background Image', 'crafto-addons' ),
		esc_html__( 'Set the background image for the hero section.', 'crafto-addons' ),
		array()
	);
	crafto_meta_box_dropdown(
		'crafto_single_post_top_space_single',
		esc_html__( 'Prevent Content Overlap', 'crafto-addons' ),
		array(
			'default' => esc_html__( 'Default', 'crafto-addons' ),
			'1'       => esc_html__( 'On', 'crafto-addons' ),
			'0'       => esc_html__( 'Off', 'crafto-addons' ),
		),
		esc_html__( 'Adds space to prevent content from overlapping the header.', 'crafto-addons' ),
	);
	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);
} elseif ( 'portfolio' === $post->post_type ) {

	// Portfolio Style & Data.

	crafto_after_main_separator_start(
		'separator_main_start',
		''
	);

	crafto_meta_box_colorpicker(
		'crafto_single_portfolio_item_hover_color_single',
		esc_html__( 'Hover Color', 'crafto-addons' ),
		esc_html__( 'Set the hover color for this portfolio item in the grid.', 'crafto-addons' ),
	);

	crafto_before_main_separator_end(
		'separator_main_end',
		''
	);
}
