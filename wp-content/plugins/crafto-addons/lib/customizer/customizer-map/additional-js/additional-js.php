<?php
/**
 * Crafto Additional JS option - Customize
 *
 * @package Crafto
 */

/** Exit if accessed directly. */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Addtional JS */
global $wp_version;

if ( $wp_version < '4.9.0' ) {

	/*============================================*/

	/* For Additional JS */

	/*============================================*/

	$wp_customize->add_setting(
		'crafto_additional_js_separator',
		[
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
		]
	);

	$wp_customize->add_control(
		new Crafto_Customize_Separator_Control(
			$wp_customize,
			'crafto_additional_js_separator',
			[
				'label'    => esc_html__( 'Additional JS', 'crafto-addons' ),
				'type'     => 'crafto_separator',
				'section'  => 'crafto_custom_js',
				'settings' => 'crafto_additional_js_separator',
				'priority' => 7,
			]
		)
	);

	$wp_customize->add_setting(
		'crafto_custom_js',
		array(
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_html',
			array(
				'type'        => 'textarea',
				'settings'    => 'crafto_custom_js',
				'section'     => 'crafto_custom_js',
				'description' => esc_html__( 'Only accepts javascript code, wrapped with <script> tags and valid HTML markup. It will be added before </body> tag.', 'crafto-addons' ),
			)
		)
	);

} else {

	/*============================================*/

	/* For Additional JS */

	/*============================================*/

	$wp_customize->add_setting(
		'crafto_additional_js_separator',
		[
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
		]
	);

	$wp_customize->add_control(
		new Crafto_Customize_Separator_Control(
			$wp_customize,
			'crafto_additional_js_separator',
			[
				'label'    => esc_html__( 'Additional JS', 'crafto-addons' ),
				'type'     => 'crafto_separator',
				'section'  => 'crafto_custom_js',
				'settings' => 'crafto_additional_js_separator',
				'priority' => 7,
			]
		)
	);

	$wp_customize->add_setting(
		'crafto_custom_js',
		array(
			'type' => 'option',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Code_Editor_Control(
			$wp_customize,
			'custom_html',
			array(
				'code_type'   => 'javascript',
				'settings'    => 'crafto_custom_js',
				'section'     => 'crafto_custom_js',
				'description' => esc_html__( 'Only accepts javascript code, wrapped with <script> tags and valid HTML markup. It will be added before </body> tag.', 'crafto-addons' ),
			)
		)
	);
}
/* End Addtional Js */
