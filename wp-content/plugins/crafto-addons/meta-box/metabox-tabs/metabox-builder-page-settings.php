<?php
/**
 * Metabox For Builder Page Settings
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Get all register `Header` section list. */
$crafto_header_section_array = crafto_get_builder_section_data( 'header', true );
/* Get all register `Footer` section list. */
$crafto_footer_section_array = crafto_get_builder_section_data( 'footer', true );

crafto_after_inner_separator_start(
	'separator_main_start',
	''
);

/* Header Settings Start */

crafto_meta_box_dropdown(
	'crafto_enable_header_single',
	esc_html__( 'Show Header', 'crafto-addons' ),
	[
		'default' => esc_html__( 'Default', 'crafto-addons' ),
		'1'       => esc_html__( 'On', 'crafto-addons' ),
		'0'       => esc_html__( 'Off', 'crafto-addons' ),
	],
	esc_html__( 'Enable or disable header display on this page.', 'crafto-addons' ),
);

crafto_meta_box_dropdown(
	'crafto_header_section_single',
	esc_html__( 'Header Template', 'crafto-addons' ),
	$crafto_header_section_array,
	esc_html__( 'Choose a header template for this page.', 'crafto-addons' ),
	[
		'element' => 'crafto_enable_header_single',
		'value'   => [
			'default',
			'1',
		],
	]
);

/* Header Settings End */

crafto_before_inner_separator_end(
	'separator_main_end',
	''
);

crafto_meta_box_separator(
	'crafto_footer_setting_single',
	esc_html__( 'Footer Settings', 'crafto-addons' )
);

crafto_after_inner_separator_start(
	'separator_main_start',
	''
);

crafto_meta_box_dropdown(
	'crafto_enable_footer_single',
	esc_html__( 'Show Footer', 'crafto-addons' ),
	[
		'default' => esc_html__( 'Default', 'crafto-addons' ),
		'1'       => esc_html__( 'On', 'crafto-addons' ),
		'0'       => esc_html__( 'Off', 'crafto-addons' ),
	],
	esc_html__( 'Enable or disable footer display on this page.', 'crafto-addons' ),
);
crafto_meta_box_dropdown(
	'crafto_footer_section_single',
	esc_html__( 'Footer Template', 'crafto-addons' ),
	$crafto_footer_section_array,
	esc_html__( 'Choose a footer template for this page.', 'crafto-addons' ),
	[
		'element' => 'crafto_enable_footer_single',
		'value'   => [
			'default',
			'1',
		],
	]
);

crafto_before_inner_separator_end(
	'separator_main_end',
	''
);
