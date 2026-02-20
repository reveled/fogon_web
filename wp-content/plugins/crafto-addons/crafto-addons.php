<?php
/**
 * Plugin Name: Crafto Addons
 * Description: A part of Crafto theme, which brings AI, premium features, custom elements & template library to supercharge Crafto.
 * Plugin URI: https://www.themezaa.com
 * Version: 1.9
 * Author: Themezaa Team
 * Author URI: https://www.themezaa.com
 * Text Domain: crafto-addons
 *
 * Elementor tested up to: 3.32.4
 *
 * @package Crafto
 * @since   1.0
 */

defined( 'CRAFTO_ADDONS_PLUGIN_VERSION' ) || define( 'CRAFTO_ADDONS_PLUGIN_VERSION', '1.9' );
defined( 'CRAFTO_ADDONS_ROOT' ) || define( 'CRAFTO_ADDONS_ROOT', dirname( __FILE__ ) );
defined( 'CRAFTO_ADDONS_ROOT_URI' ) || define( 'CRAFTO_ADDONS_ROOT_URI', plugins_url() . '/crafto-addons' );

defined( 'CRAFTO_ADDONS_ASSETS_DIR' ) || define( 'CRAFTO_ADDONS_ASSETS_DIR', CRAFTO_ADDONS_ROOT . '/assets' );
defined( 'CRAFTO_ADDONS_CSS_DIR' ) || define( 'CRAFTO_ADDONS_CSS_DIR', CRAFTO_ADDONS_ASSETS_DIR . '/css' );
defined( 'CRAFTO_ADDONS_JS_DIR' ) || define( 'CRAFTO_ADDONS_JS_DIR', CRAFTO_ADDONS_ASSETS_DIR . '/js' );
defined( 'CRAFTO_ADDONS_INCLUDES_DIR' ) || define( 'CRAFTO_ADDONS_INCLUDES_DIR', CRAFTO_ADDONS_ROOT . '/includes' );
defined( 'CRAFTO_ADDONS_WIDGETS_DIR' ) || define( 'CRAFTO_ADDONS_WIDGETS_DIR', CRAFTO_ADDONS_INCLUDES_DIR . '/widgets' );
defined( 'CRAFTO_ADDONS_LIB_DIR' ) || define( 'CRAFTO_ADDONS_LIB_DIR', CRAFTO_ADDONS_ROOT . '/lib' );
defined( 'CRAFTO_ADDONS_BUILDER_DIR' ) || define( 'CRAFTO_ADDONS_BUILDER_DIR', CRAFTO_ADDONS_INCLUDES_DIR . '/theme-builder' );
defined( 'CRAFTO_ADDONS_TEMPLATE_LIBRARY_PATH' ) || define( 'CRAFTO_ADDONS_TEMPLATE_LIBRARY_PATH', CRAFTO_ADDONS_INCLUDES_DIR . '/template-library' );
defined( 'CRAFTO_ADDONS_METABOX_DIR' ) || define( 'CRAFTO_ADDONS_METABOX_DIR', CRAFTO_ADDONS_ROOT . '/meta-box' );
defined( 'CRAFTO_ADDONS_CUSTOMIZER' ) || define( 'CRAFTO_ADDONS_CUSTOMIZER', CRAFTO_ADDONS_LIB_DIR . '/customizer' );
defined( 'CRAFTO_ADDONS_IMPORT' ) || define( 'CRAFTO_ADDONS_IMPORT', CRAFTO_ADDONS_ROOT . '/importer' );
defined( 'CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH' ) || define( 'CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH', CRAFTO_ADDONS_ROOT . '/custom-post-type' );
defined( 'CRAFTO_ADDONS_CUSTOMIZER_MAPS' ) || define( 'CRAFTO_ADDONS_CUSTOMIZER_MAPS', CRAFTO_ADDONS_LIB_DIR . '/customizer/customizer-map' );
defined( 'CRAFTO_ADDONS_CUSTOMIZER_CONTROLS' ) || define( 'CRAFTO_ADDONS_CUSTOMIZER_CONTROLS', CRAFTO_ADDONS_LIB_DIR . '/customizer/customizer-control' );

defined( 'CRAFTO_ADDONS_ASSETS_URI' ) || define( 'CRAFTO_ADDONS_ASSETS_URI', CRAFTO_ADDONS_ROOT_URI . '/assets' );
defined( 'CRAFTO_ADDONS_CSS_URI' ) || define( 'CRAFTO_ADDONS_CSS_URI', CRAFTO_ADDONS_ASSETS_URI . '/css' );
defined( 'CRAFTO_ADDONS_JS_URI' ) || define( 'CRAFTO_ADDONS_JS_URI', CRAFTO_ADDONS_ASSETS_URI . '/js' );
defined( 'CRAFTO_ADDONS_VENDORS_CSS_URI' ) || define( 'CRAFTO_ADDONS_VENDORS_CSS_URI', CRAFTO_ADDONS_CSS_URI . '/vendors' );
defined( 'CRAFTO_ADDONS_VENDORS_JS_URI' ) || define( 'CRAFTO_ADDONS_VENDORS_JS_URI', CRAFTO_ADDONS_JS_URI . '/vendors' );
defined( 'CRAFTO_ADDONS_METABOX_URI' ) || define( 'CRAFTO_ADDONS_METABOX_URI', CRAFTO_ADDONS_ROOT_URI . '/meta-box' );
defined( 'CRAFTO_ADDONS_INCLUDES_URI' ) || define( 'CRAFTO_ADDONS_INCLUDES_URI', CRAFTO_ADDONS_ROOT_URI . '/includes' );
defined( 'CRAFTO_ADDONS_WIDGETS_URI' ) || define( 'CRAFTO_ADDONS_WIDGETS_URI', CRAFTO_ADDONS_INCLUDES_URI . '/widgets' );
defined( 'CRAFTO_ADDONS_BUILDER_URI' ) || define( 'CRAFTO_ADDONS_BUILDER_URI', CRAFTO_ADDONS_INCLUDES_URI . '/theme-builder' );
defined( 'CRAFTO_ADDONS_TEMPLATE_LIBRARY_URI' ) || define( 'CRAFTO_ADDONS_TEMPLATE_LIBRARY_URI', CRAFTO_ADDONS_INCLUDES_URI . '/template-library' );
defined( 'CRAFTO_ADDONS_MEGAMENU_URI' ) || define( 'CRAFTO_ADDONS_MEGAMENU_URI', CRAFTO_ADDONS_INCLUDES_URI . '/mega-menu' );
defined( 'CRAFTO_ADDONS_IMPORTER_SAMPLE_DATA_URI' ) || define( 'CRAFTO_ADDONS_IMPORTER_SAMPLE_DATA_URI', CRAFTO_ADDONS_ROOT_URI . '/importer/sample-data/' );
defined( 'CRAFTO_ADDONS_IMPORTER_SAMPLE_DATA' ) || define( 'CRAFTO_ADDONS_IMPORTER_SAMPLE_DATA', CRAFTO_ADDONS_ROOT . '/importer/sample-data/' );
defined( 'CRAFTO_ADDONS_DEMO_URI' ) || define( 'CRAFTO_ADDONS_DEMO_URI', 'https://crafto.themezaa.com/' );
defined( 'CRAFTO_ADDONS_IMP_DEMO_URI' ) || define( 'CRAFTO_ADDONS_IMP_DEMO_URI', 'https://craimp.themezaa.com/' );

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Crafto_Addons` doesn't exists yet.
if ( ! class_exists( 'Crafto_Addons' ) ) {
	/**
	 * Define Crafto_Addons class.
	 */
	class Crafto_Addons {

		/**
		 * Initialize constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'crafto_require_files' ) );
			add_action( 'plugins_loaded', array( $this, 'crafto_main_elementor_file_loaded' ) );

			/**
			 * Performance manager include file.
			 */
			if ( file_exists( CRAFTO_ADDONS_LIB_DIR . '/classes/class-crafto-performance-manager.php' ) ) {
				require_once CRAFTO_ADDONS_LIB_DIR . '/classes/class-crafto-performance-manager.php';
			}

			/**
			 * Critical CSS include file
			 */
			if ( file_exists( CRAFTO_ADDONS_LIB_DIR . '/classes/class-critical-css.php' ) ) {
				require_once CRAFTO_ADDONS_LIB_DIR . '/classes/class-critical-css.php';
			}
		}

		/**
		 * Includes require files
		 */
		public function crafto_require_files() {
			if ( file_exists( CRAFTO_ADDONS_LIB_DIR . '/require-theme-files.php' ) ) {
				require_once CRAFTO_ADDONS_LIB_DIR . '/require-theme-files.php';
			}
		}

		/**
		 * Elementor Require files
		 */
		public function crafto_main_elementor_file_loaded() {
			if ( file_exists( CRAFTO_ADDONS_INCLUDES_DIR . '/plugin.php' ) ) {
				require_once CRAFTO_ADDONS_INCLUDES_DIR . '/plugin.php';
			}
		}
	}

	new Crafto_Addons();
}
