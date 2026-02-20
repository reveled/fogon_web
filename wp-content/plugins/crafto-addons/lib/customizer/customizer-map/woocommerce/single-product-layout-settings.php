<?php
/**
 * Crafto Product Layout Settings
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

	/* Enable Product Variation Swatches Style */

	$wp_customize->add_setting(
		'crafto_single_product_variation_swatch_style',
		array(
			'default'           => 'boxed',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'crafto_single_product_variation_swatch_style',
			array(
				'label'    => esc_html__( 'Variation Switch Style', 'crafto-addons' ),
				'section'  => 'crafto_add_product_layout_panel',
				'settings' => 'crafto_single_product_variation_swatch_style',
				'type'     => 'select',
				'choices'  => array(
					'none'  => esc_html__( 'Default', 'crafto-addons' ),
					'boxed' => esc_html__( 'Boxed', 'crafto-addons' ),
				),
				'priority' => '3',
			)
		)
	);

	/* End Enable Product Variation Swatches Style */

	/* Enable Product Wishlist */

	$wp_customize->add_setting(
		'crafto_single_product_enable_wishlist',
		array(
			'default'           => '1',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new Crafto_Customize_Switch_Control(
			$wp_customize,
			'crafto_single_product_enable_wishlist',
			array(
				'label'    => esc_html__( 'Enable Wishlist', 'crafto-addons' ),
				'section'  => 'crafto_add_product_layout_panel',
				'settings' => 'crafto_single_product_enable_wishlist',
				'type'     => 'crafto_switch',
				'choices'  => array(
					'1' => esc_html__( 'On', 'crafto-addons' ),
					'0' => esc_html__( 'Off', 'crafto-addons' ),
				),
				'priority' => '5',
			)
		)
	);

	/* End Enable Product Wishlist */

	/*  Wishlist Text */

	$wp_customize->add_setting(
		'crafto_single_product_wishlist_text',
		array(
			'default'           => esc_html__( 'Add to Wishlist', 'crafto-addons' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'crafto_single_product_wishlist_text',
			array(
				'label'           => esc_html__( 'Wishlist Label', 'crafto-addons' ),
				'section'         => 'crafto_add_product_layout_panel',
				'settings'        => 'crafto_single_product_wishlist_text',
				'type'            => 'text',
				'active_callback' => 'crafto_single_product_wishlist_text_callback',
				'priority'        => '5',
			)
		)
	);

	if ( ! function_exists( 'crafto_single_product_wishlist_text_callback' ) ) :
		/**
		 * Callback function for handling single product wishlist text settings.
		 *
		 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
		 */
		function crafto_single_product_wishlist_text_callback( $control ) {
			if ( '1' === $control->manager->get_setting( 'crafto_single_product_enable_wishlist' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	endif;

	/* End Wishlist Text */

	/* Enable Product Compare */

	$wp_customize->add_setting(
		'crafto_single_product_enable_compare',
		array(
			'default'           => '1',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new Crafto_Customize_Switch_Control(
			$wp_customize,
			'crafto_single_product_enable_compare',
			array(
				'label'    => esc_html__( 'Enable Compare', 'crafto-addons' ),
				'section'  => 'crafto_add_product_layout_panel',
				'settings' => 'crafto_single_product_enable_compare',
				'type'     => 'crafto_switch',
				'choices'  => array(
					'1' => esc_html__( 'On', 'crafto-addons' ),
					'0' => esc_html__( 'Off', 'crafto-addons' ),
				),
				'priority' => '6',
			)
		)
	);

	/* End Enable Product Compare */

	/*  Compare Text  */

	$wp_customize->add_setting(
		'crafto_single_product_compare_text',
		array(
			'default'           => esc_html__( 'Add to compare', 'crafto-addons' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'crafto_single_product_compare_text',
			array(
				'label'           => esc_html__( 'Compare Label', 'crafto-addons' ),
				'section'         => 'crafto_add_product_layout_panel',
				'settings'        => 'crafto_single_product_compare_text',
				'type'            => 'text',
				'active_callback' => 'crafto_single_product_compare_text_callback',
				'priority'        => '6',
			)
		)
	);

	if ( ! function_exists( 'crafto_single_product_compare_text_callback' ) ) :
		/**
		 * Callback function for handling single product wishlist text settings.
		 *
		 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
		 */
		function crafto_single_product_compare_text_callback( $control ) {
			if ( '1' === $control->manager->get_setting( 'crafto_single_product_enable_compare' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	endif;

	/* End Compare Text */

	/* Enable Product Share */

	$wp_customize->add_setting(
		'crafto_single_product_enable_social_share',
		array(
			'default'           => '1',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new Crafto_Customize_Switch_Control(
			$wp_customize,
			'crafto_single_product_enable_social_share',
			array(
				'label'    => __( 'Enable Share', 'crafto-addons' ),
				'section'  => 'crafto_add_product_layout_panel',
				'settings' => 'crafto_single_product_enable_social_share',
				'type'     => 'crafto_switch',
				'choices'  => array(
					'1' => esc_html__( 'On', 'crafto-addons' ),
					'0' => esc_html__( 'Off', 'crafto-addons' ),
				),
				'priority' => '3',
			)
		)
	);

	/* End Enable Product Share */

	/*  Share Text  */

	$wp_customize->add_setting(
		'crafto_single_product_share_title',
		array(
			'default'           => esc_html__( 'Enable Share', 'crafto-addons' ),
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'crafto_single_product_share_title',
			array(
				'label'           => esc_html__( 'Share Label', 'crafto-addons' ),
				'section'         => 'crafto_add_product_layout_panel',
				'settings'        => 'crafto_single_product_share_title',
				'type'            => 'text',
				'active_callback' => 'crafto_single_product_share_text_callback',
				'priority'        => '3',
			)
		)
	);

	if ( ! function_exists( 'crafto_single_product_share_text_callback' ) ) :
		/**
		 * Callback function for handling single product share text settings.
		 *
		 * @param WP_Customize_Control $control The control instance from the WordPress Customizer.
		 */
		function crafto_single_product_share_text_callback( $control ) {
			if ( '1' === $control->manager->get_setting( 'crafto_single_product_enable_social_share' )->value() ) {
				return true;
			} else {
				return false;
			}
		}
	endif;

	/* End Share Text */

	/* Product navigation & Bradcrumb Separator setting */

	$wp_customize->add_setting(
		'crafto_single_product_breadcrumb_navigation',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new Crafto_Customize_Separator_Control(
			$wp_customize,
			'crafto_single_product_breadcrumb_navigation',
			array(
				'label'    => __( 'Breadcrumb', 'crafto-addons' ),
				'type'     => 'crafto_separator',
				'section'  => 'crafto_add_product_layout_panel',
				'settings' => 'crafto_single_product_breadcrumb_navigation',
				'priority' => '8',
			)
		)
	);

	/* End Product navigation & Bradcrumb Separator setting */

	/* Enable Product Title After Breadcrumb */

	$wp_customize->add_setting(
		'crafto_single_product_enable_title_after_breadcrumb',
		array(
			'default'           => '1',
			'sanitize_callback' => 'esc_attr',
		)
	);

	$wp_customize->add_control(
		new Crafto_Customize_Switch_Control(
			$wp_customize,
			'crafto_single_product_enable_title_after_breadcrumb',
			array(
				'label'    => __( 'Enable Breadcrumb', 'crafto-addons' ),
				'section'  => 'crafto_add_product_layout_panel',
				'settings' => 'crafto_single_product_enable_title_after_breadcrumb',
				'type'     => 'crafto_switch',
				'choices'  => array(
					'1' => esc_html__( 'On', 'crafto-addons' ),
					'0' => esc_html__( 'Off', 'crafto-addons' ),
				),
				'priority' => '8',
			)
		)
	);

	/* End Enable Product Title After Breadcrumb */
