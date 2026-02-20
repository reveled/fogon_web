<?php
/**
 * Crafto Quick View Settings.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Separator Settings */

$wp_customize->add_setting(
	'crafto_quick_view_product_style_separator',
	array(
		'default'           => '',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Separator_Control(
		$wp_customize,
		'crafto_quick_view_product_style_separator',
		array(
			'label'    => esc_html__( 'Product Style and Data', 'crafto-addons' ),
			'type'     => 'crafto_separator',
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_style_separator',
		)
	)
);

/* End Separator Settings */

/* Enable Product Compare */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_compare',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_compare',
		array(
			'label'    => esc_html__( 'Enable Compare', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_compare',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product Compare */

/* Compare Text */

$wp_customize->add_setting(
	'crafto_quick_view_product_compare_text',
	array(
		'default'           => esc_html__( 'Add to compare', 'crafto-addons' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'crafto_quick_view_product_compare_text',
		array(
			'label'           => esc_html__( 'Compare Label', 'crafto-addons' ),
			'section'         => 'crafto_add_product_quick_view_panel',
			'settings'        => 'crafto_quick_view_product_compare_text',
			'type'            => 'text',
			'active_callback' => 'crafto_quick_view_product_compare_text_callback',
		)
	)
);

/* End Compare Text */

/* Enable Product Wishlist */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_wishlist',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_wishlist',
		array(
			'label'    => esc_html__( 'Enable Wishlist', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_wishlist',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product Wishlist */

/*  Wishlist Text  */

$wp_customize->add_setting(
	'crafto_quick_view_product_wishlist_text',
	array(
		'default'           => esc_html__( 'Add to Wishlist', 'crafto-addons' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'crafto_quick_view_product_wishlist_text',
		array(
			'label'           => esc_html__( 'Wishlist Label', 'crafto-addons' ),
			'section'         => 'crafto_add_product_quick_view_panel',
			'settings'        => 'crafto_quick_view_product_wishlist_text',
			'type'            => 'text',
			'active_callback' => 'crafto_quick_view_product_wishlist_text_callback',
		)
	)
);

/* End Wishlist Text */

/* Enable Product Title */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_title_link',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_title_link',
		array(
			'label'    => esc_html__( 'Enable Title Link', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_title_link',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product Title */

/* Enable Product Sale Box */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_sale_box',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_sale_box',
		array(
			'label'    => esc_html__( 'Enable Sale Label', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_sale_box',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product Sale Box */

/* Enable Product New Box */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_new_box',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_new_box',
		array(
			'label'    => esc_html__( 'Enable New Label', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_new_box',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product New Box */

/* Enable Product Category */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_category',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_category',
		array(
			'label'    => esc_html__( 'Enable Category', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_category',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product Category */

/* Enable Product Tag */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_tag',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_tag',
		array(
			'label'    => esc_html__( 'Enable Tag', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_tag',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product Tag */

/* Enable Product SKU */

$wp_customize->add_setting(
	'crafto_quick_view_product_enable_sku',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_quick_view_product_enable_sku',
		array(
			'label'    => esc_html__( 'Enable SKU', 'crafto-addons' ),
			'section'  => 'crafto_add_product_quick_view_panel',
			'settings' => 'crafto_quick_view_product_enable_sku',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
		)
	)
);

/* End Enable Product SKU */

/* Custom Callback Functions */

if ( ! function_exists( 'crafto_quick_view_product_compare_text_callback' ) ) :
	/**
	 * Callback function for determining the quick view product compare text.
	 *
	 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
	 */
	function crafto_quick_view_product_compare_text_callback( $control ) {
		if ( $control->manager->get_setting( 'crafto_quick_view_product_enable_compare' )->value() === '1' ) {
			return true;
		} else {
			return false;
		}
	}
endif;

if ( ! function_exists( 'crafto_quick_view_product_wishlist_text_callback' ) ) :
	/**
	 * Callback function for determining the quick view product wishlist text.
	 *
	 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
	 */
	function crafto_quick_view_product_wishlist_text_callback( $control ) {
		if ( $control->manager->get_setting( 'crafto_quick_view_product_enable_wishlist' )->value() === '1' ) {
			return true;
		} else {
			return false;
		}
	}
endif;

/* End Custom Callback Functions */
