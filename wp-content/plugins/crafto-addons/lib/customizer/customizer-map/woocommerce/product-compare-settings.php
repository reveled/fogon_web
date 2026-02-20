<?php
/**
 * Crafto Product Compare Settings
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Separator Settings */

$wp_customize->add_setting(
	'crafto_compare_product_style_separator',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Separator_Control(
		$wp_customize,
		'crafto_compare_product_style_separator',
		array(
			'label'    => esc_html__( 'Compare Style and Data', 'crafto-addons' ),
			'type'     => 'crafto_separator',
			'section'  => 'crafto_add_product_compare_panel',
			'settings' => 'crafto_compare_product_style_separator',
		)
	)
);

/* End Separator Settings */

/* Enable Compare Product Heading */

$wp_customize->add_setting(
	'crafto_compare_product_enable_heading',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_compare_product_enable_heading',
		array(
			'label'    => esc_html__( 'Enable Heading', 'crafto-addons' ),
			'section'  => 'crafto_add_product_compare_panel',
			'settings' => 'crafto_compare_product_enable_heading',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Compare Product Heading */

/* Compare Product Heading Text */

$wp_customize->add_setting(
	'crafto_compare_product_heading_text',
	array(
		'default'           => esc_html__( 'Compare Products', 'crafto-addons' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'crafto_compare_product_heading_text',
		array(
			'label'           => esc_html__( 'Heading Label', 'crafto-addons' ),
			'section'         => 'crafto_add_product_compare_panel',
			'settings'        => 'crafto_compare_product_heading_text',
			'type'            => 'text',
			'active_callback' => 'crafto_compare_product_heading_callback',
		),
	),
);

/* End Compare Product Heading Text */

/* Enable Compare Product Filter */

$wp_customize->add_setting(
	'crafto_compare_product_enable_filter',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_compare_product_enable_filter',
		array(
			'label'    => esc_html__( 'Enable Filter', 'crafto-addons' ),
			'section'  => 'crafto_add_product_compare_panel',
			'settings' => 'crafto_compare_product_enable_filter',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Compare Product Filter */

/* Custom Callback Functions */

if ( ! function_exists( 'crafto_compare_product_heading_callback' ) ) :
	/**
	 * Callback function for determining the compare product heading.
	 *
	 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
	 */
	function crafto_compare_product_heading_callback( $control ) {
		if ( $control->manager->get_setting( 'crafto_compare_product_enable_heading' )->value() === '1' ) {
			return true;
		} else {
			return false;
		}
	}
endif;

/* End Callback Functions */
