<?php
/**
 * Theme Builder Elementor Canvas
 *
 * @package Crafto
 */

namespace CraftoAddons\Theme_Builder\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Theme_Builder_Elementor_Canvas` doesn't exists yet.
if ( ! class_exists( 'Theme_Builder_Elementor_Canvas' ) ) {

	/**
	 * Define Theme_Builder_Elementor_Canvas class
	 */
	class Theme_Builder_Elementor_Canvas {

		public $current_template_type;

		private static $elementor_instance;
		/**
		 * Theme Builder Elementor Canvas constructor.
		 *
		 * Initializing the Elementor modules manager.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function __construct() {

			if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( '\Elementor\Plugin::instance' ) ) {
				self::$elementor_instance = \Elementor\Plugin::instance();
			}

			add_action( 'wp', array( $this, 'crafto_load_hooks' ) );
		}
		/** Theme Builder - load hooks style. */
		public function crafto_load_hooks() {
			add_action( 'crafto_theme_mini_header', 'crafto_render_mini_header' );
			add_action( 'crafto_theme_header', 'crafto_render_header' );
			add_action( 'crafto_theme_footer', 'crafto_render_footer' );
			add_action( 'crafto_theme_custom_title', 'crafto_render_custom_title' );
			add_action( 'crafto_theme_archive', 'crafto_render_archive' );
			add_action( 'crafto_theme_archive_portfolio', 'crafto_render_archive_portfolio' );
			add_action( 'crafto_theme_single', 'crafto_render_single_post' );
			add_action( 'crafto_theme_single_portfolio', 'crafto_render_single_portfolio' );
			add_action( 'crafto_theme_single_property', 'crafto_render_single_property' );
			add_action( 'crafto_theme_archive_property', 'crafto_render_archive_property' );
			add_action( 'crafto_theme_single_tours', 'crafto_render_single_tours' );
			add_action( 'crafto_theme_archive_tours', 'crafto_render_archive_tours' );
			add_action( 'crafto_theme_404_page', 'crafto_render_404_page' );
			add_action( 'crafto_theme_promo_popup', 'crafto_render_promo_popup' );
			add_action( 'crafto_theme_side_icon', 'crafto_render_side_icon' );
		}
	}
}
