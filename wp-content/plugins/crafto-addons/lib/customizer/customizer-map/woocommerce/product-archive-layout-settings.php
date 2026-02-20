<?php
/**
 * Crafto Archive Layout Settings
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Enable Product Quick View */

$wp_customize->add_setting(
	'crafto_product_archive_enable_quick_view',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_product_archive_enable_quick_view',
		array(
			'label'    => esc_html__( 'Enable Quick View', 'crafto-addons' ),
			'section'  => 'crafto_add_product_archive_layout_panel',
			'settings' => 'crafto_product_archive_enable_quick_view',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
			'priority' => '3',
		)
	)
);

/* End Enable Product Quick View */

/*  Quick View Text  */

$wp_customize->add_setting(
	'crafto_product_archive_quick_view_text',
	array(
		'default'           => esc_html__( 'Quick View', 'crafto-addons' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'crafto_product_archive_quick_view_text',
		array(
			'label'           => esc_html__( 'Quick View Label', 'crafto-addons' ),
			'section'         => 'crafto_add_product_archive_layout_panel',
			'settings'        => 'crafto_product_archive_quick_view_text',
			'type'            => 'text',
			'priority'        => '3',
			'active_callback' => 'crafto_product_archive_quick_view_text_callback',
		)
	)
);

if ( ! function_exists( 'crafto_product_archive_quick_view_text_callback' ) ) :
	/**
	 * Callback function for determining the quick view text visibility on product archives.
	 *
	 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
	 */
	function crafto_product_archive_quick_view_text_callback( $control ) {
		if ( '1' === $control->manager->get_setting( 'crafto_product_archive_enable_quick_view' )->value() ) {
			return true;
		} else {
			return false;
		}
	}
endif;

/* End Quick View Text */

/* Enable Product Wishlist */

$wp_customize->add_setting(
	'crafto_product_archive_enable_wishlist',
	array(
		'default'           => '1',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_product_archive_enable_wishlist',
		array(
			'label'    => esc_html__( 'Enable Wishlist', 'crafto-addons' ),
			'section'  => 'crafto_add_product_archive_layout_panel',
			'settings' => 'crafto_product_archive_enable_wishlist',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
			'priority' => '4',
		)
	)
);

/* End Enable Product Wishlist */

/*  Wishlist Text  */

$wp_customize->add_setting(
	'crafto_product_archive_wishlist_text',
	array(
		'default'           => esc_html__( 'Add to Wishlist', 'crafto-addons' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'crafto_product_archive_wishlist_text',
		array(
			'label'           => esc_html__( 'Wishlist Label', 'crafto-addons' ),
			'section'         => 'crafto_add_product_archive_layout_panel',
			'settings'        => 'crafto_product_archive_wishlist_text',
			'type'            => 'text',
			'priority'        => '4',
			'active_callback' => 'crafto_product_archive_wishlist_text_callback',
		)
	)
);

if ( ! function_exists( 'crafto_product_archive_wishlist_text_callback' ) ) :
	/**
	 * Callback function for determining the wishlist feature visibility on product archives.
	 *
	 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
	 */
	function crafto_product_archive_wishlist_text_callback( $control ) {
		if ( '1' === $control->manager->get_setting( 'crafto_product_archive_enable_wishlist' )->value() ) {
			return true;
		} else {
			return false;
		}
	}
endif;

/* End Wishlist Text */

/* Enable Product Compare */

$wp_customize->add_setting(
	'crafto_product_archive_enable_compare',
	array(
		'default'           => '0',
		'sanitize_callback' => 'esc_attr',
	)
);

$wp_customize->add_control(
	new Crafto_Customize_Switch_Control(
		$wp_customize,
		'crafto_product_archive_enable_compare',
		array(
			'label'    => esc_html__( 'Enable Compare', 'crafto-addons' ),
			'section'  => 'crafto_add_product_archive_layout_panel',
			'settings' => 'crafto_product_archive_enable_compare',
			'type'     => 'crafto_switch',
			'choices'  => array(
				'1' => esc_html__( 'On', 'crafto-addons' ),
				'0' => esc_html__( 'Off', 'crafto-addons' ),
			),
			'priority' => '5',
		)
	)
);

/* End Enable Product Compare */

/*  Compare Text  */

$wp_customize->add_setting(
	'crafto_product_archive_compare_text',
	array(
		'default'           => esc_html__( 'Compare', 'crafto-addons' ),
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new WP_Customize_Control(
		$wp_customize,
		'crafto_product_archive_compare_text',
		array(
			'label'           => esc_html__( 'Compare Label', 'crafto-addons' ),
			'section'         => 'crafto_add_product_archive_layout_panel',
			'settings'        => 'crafto_product_archive_compare_text',
			'type'            => 'text',
			'priority'        => '5',
			'active_callback' => 'crafto_product_archive_compare_text_callback',
		)
	)
);

/* End Compare Text */

if ( ! function_exists( 'crafto_product_archive_compare_text_callback' ) ) :
	/**
	 * Callback function for determining the compare feature visibility on product archives.
	 *
	 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
	 */
	function crafto_product_archive_compare_text_callback( $control ) {
		if ( '1' === $control->manager->get_setting( 'crafto_product_archive_enable_compare' )->value() ) {
			return true;
		} else {
			return false;
		}
	}
endif;
