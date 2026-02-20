<?php
/**
 * Crafto Customize option - Customize
 *
 * @package Crafto
 */

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Crafto_Addons_Customizer` doesn't exists yet.
if ( ! class_exists( 'Crafto_Addons_Customizer' ) ) {

	/**
	 * Define customizer class
	 */
	class Crafto_Addons_Customizer {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'customize_register', array( $this, 'crafto_add_customizer_sections' ) );
			add_action( 'customize_register', array( $this, 'crafto_register_options_settings_and_controls' ), 20 );
		}

		/**
		 * Register sections of settings in the Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function crafto_add_customizer_sections( $wp_customize ) {

			if ( ! is_crafto_theme_activated() ) {
				return;
			}

			// Add Custom Additional JS.
			$wp_customize->add_section(
				'crafto_custom_js',
				array(
					'title'    => esc_html__( 'Additional JS', 'crafto-addons' ),
					'priority' => 9,
				)
			);

			// Add Custom JavaScript Tracking Code.
			$wp_customize->add_section(
				'crafto_tracking_js',
				array(
					'title'    => esc_html__( 'Tracking Code', 'crafto-addons' ),
					'priority' => 9,
				)
			);

			// Add Customizer import export.
			$wp_customize->add_section(
				'crafto_import_export',
				array(
					'title'    => esc_html__( 'Export / Import Settings', 'crafto-addons' ),
					'priority' => 9,
				)
			);
		}

		/**
		 * Register options for settings and controls
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function crafto_register_options_settings_and_controls( $wp_customize ) {

			/* Register Custom Controls */
			if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_CONTROLS . '/class-crafto-customizer-separator-control.php' ) ) {
				require_once CRAFTO_ADDONS_CUSTOMIZER_CONTROLS . '/class-crafto-customizer-separator-control.php';
			}

			/* Register Custom switch control */
			if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_CONTROLS . '/class-crafto-customizer-switch-control.php' ) ) {
				require_once CRAFTO_ADDONS_CUSTOMIZER_CONTROLS . '/class-crafto-customizer-switch-control.php';
			}

			/* Register Custom import control */
			if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_CONTROLS . '/class-crafto-customizer-import-control.php' ) ) {
				require_once CRAFTO_ADDONS_CUSTOMIZER_CONTROLS . '/class-crafto-customizer-import-control.php';
			}

			/* Register Additional Settings */
			if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/additional-js/additional-js.php' ) ) {
				require_once CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/additional-js/additional-js.php';
			}

			/* Register Additional Settings */
			if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/tracking-js/tracking-js.php' ) ) {
				require_once CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/tracking-js/tracking-js.php';
			}

			/* Register General theme Settings */
			if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/general-theme-options/general-layout-settings.php' ) ) {
				require_once CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/general-theme-options/general-layout-settings.php';
			}

			if ( is_woocommerce_activated() ) {
				/* Register Product Archive Layout Settings */
				if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/product-archive-layout-settings.php' ) ) {
					require_once CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/product-archive-layout-settings.php';
				}
				/* Register Product Single Product Layout Settings */
				if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/single-product-layout-settings.php' ) ) {
					require_once CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/single-product-layout-settings.php';
				}
				/* Register Product Quick View Settings */
				if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/product-quick-view-settings.php' ) ) {
					require_once CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/product-quick-view-settings.php';
				}
				/* Register Product Quick View Settings */
				if ( file_exists( CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/product-compare-settings.php' ) ) {
					require_once CRAFTO_ADDONS_CUSTOMIZER_MAPS . '/woocommerce/product-compare-settings.php';
				}
			}
		}
	} // end of class

	new crafto_Addons_Customizer();

} // end of class_exists
