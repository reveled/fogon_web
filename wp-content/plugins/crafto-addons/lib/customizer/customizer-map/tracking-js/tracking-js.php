<?php
/**
 * Crafto JavaScript Tracking Code option - Customize
 *
 * @package Crafto
 */

/** Exit if accessed directly. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* JavaScript Tracking Code */
global $wp_version;

$wp_customize->add_setting(
	'crafto_tracking_js',
	array(
		'type' => 'option',
	)
);

if ( $wp_version < '4.9.0' ) {

	/*============================================*/

	/* For JavaScript Tracking Code */

	/*============================================*/

	$wp_customize->add_setting(
		'crafto_tracking_code_separator',
		[
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
		]
	);

	$wp_customize->add_control(
		new Crafto_Customize_Separator_Control(
			$wp_customize,
			'crafto_tracking_code_separator',
			[
				'label'    => esc_html__( 'JavaScript Tracking Code', 'crafto-addons' ),
				'type'     => 'crafto_separator',
				'section'  => 'crafto_tracking_js',
				'settings' => 'crafto_tracking_code_separator',
				'priority' => 7,
			]
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_html_js',
			array(
				'type'        => 'script',
				'settings'    => 'crafto_tracking_js',
				'section'     => 'crafto_tracking_js',
				'description' => esc_html__( 'Tracking Code (Google Analytics, Facebook Pixel, Google Remarketing, Live Chat tools, Eye tracking, Affiliate tracking pixels and more). Only accepts javascript code, wrapped with <script> tags. It will be added inside HEAD tag.', 'crafto-addons' ),

			)
		)
	);

} else {

	/*============================================*/

	/* For JavaScript Tracking Code */

	/*============================================*/

	$wp_customize->add_setting(
		'crafto_tracking_code_separator',
		[
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
		]
	);

	$wp_customize->add_control(
		new Crafto_Customize_Separator_Control(
			$wp_customize,
			'crafto_tracking_code_separator',
			[
				'label'    => esc_html__( 'JavaScript Tracking Code', 'crafto-addons' ),
				'type'     => 'crafto_separator',
				'section'  => 'crafto_tracking_js',
				'settings' => 'crafto_tracking_code_separator',
				'priority' => 7,
			]
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Code_Editor_Control(
			$wp_customize,
			'custom_html_js',
			array(
				'code_type'   => 'script',
				'settings'    => 'crafto_tracking_js',
				'section'     => 'crafto_tracking_js',
				'description' => esc_html__( 'Tracking Code (Google Analytics, Facebook Pixel, Google Remarketing, Live Chat tools, Eye tracking, Affiliate tracking pixels and more). Only accepts javascript code, wrapped with <script> tags. It will be added inside HEAD tag.', 'crafto-addons' ),

			)
		)
	);
}
/* End JavaScript Tracking Code */
