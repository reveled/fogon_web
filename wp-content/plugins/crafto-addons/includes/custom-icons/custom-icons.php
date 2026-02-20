<?php
/**
 * Custom Icons initialize
 *
 * @package Crafto
 */

namespace CraftoAddons\Custom_Icons;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Custom_Icons` doesn't exists yet.
if ( ! class_exists( 'Custom_Icons' ) ) {

	/**
	 * Define Custom_Icons class
	 */
	class Custom_Icons {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->add_hooks();
		}

		/**
		 * Add required hooks
		 */
		private function add_hooks() {
			// Bind custom icons with elementor.
			add_filter( 'elementor/icons_manager/additional_tabs', [ $this, 'crafto_custom_icons' ] );
			// Editor enqueue scripts.
			add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'crafto_editor_custom_styles_scripts' ] );
			add_action( 'wp_enqueue_scripts', [ $this, 'crafto_editor_custom_styles_scripts' ] );
		}

		/**
		 * Enqueue styles for editor
		 */
		public function crafto_editor_custom_styles_scripts() {
			$icon_flag = false;
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_CSS_DIR . '/vendors/crafto-icons.min.css' ) ) {
				$icon_flag = true;
			}

			if ( $icon_flag ) {
				wp_register_style(
					'crafto-icons',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/crafto-icons.min.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-icons' );
			} else {
				wp_register_style(
					'fontawesome',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/fontawesome.min.css',
					[],
					'7.1.0'
				);
				wp_enqueue_style( 'fontawesome' );

				wp_register_style(
					'bootstrap-icons',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/bootstrap-icons.min.css',
					[],
					'1.11.3'
				);
				wp_enqueue_style( 'bootstrap-icons' );

				wp_register_style(
					'themify',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/themify-icons.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'themify' );

				wp_register_style(
					'simple-line',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/simple-line-icons.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'simple-line' );

				wp_register_style(
					'et-line',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/et-line-icons.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'et-line' );

				wp_register_style(
					'iconsmind-line',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/iconsmind-line.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'iconsmind-line' );

				wp_register_style(
					'iconsmind-solid',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/iconsmind-solid.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'iconsmind-solid' );

				wp_register_style(
					'feather',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/feather-icons.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'feather' );
			}
		}

		/**
		 * Custom Icons
		 *
		 * @param array $settings custom icons settings.
		 */
		public function crafto_custom_icons( $settings ) {
			$config      = [];
			$set_config  = [];
			$icons_array = [];

			$custom_icon_library_load = [
				'fa-regular',
				'fa-solid',
				'fa-brands',
				'bootstrap',
				'themify',
				'et-line',
				'simple-line',
				'iconsmind-line',
				'iconsmind-solid',
				'feather',
			];

			foreach ( $custom_icon_library_load as $value ) {
				$prefix         = '';
				$display_prefix = '';

				$key       = str_replace( '-', '_', $value );
				$json_path = CRAFTO_ADDONS_INCLUDES_DIR . '/assets/icon-json/' . $value . '.json';
				$label     = ucwords( str_replace( '-', ' ', $value ) );

				switch ( $value ) {
					case 'fa-regular':
						$label          = 'Font Awesome - Regular (New)';
						$prefix         = 'fa-';
						$display_prefix = 'fa-regular';
						break;
					case 'fa-solid':
						$label          = 'Font Awesome - Solid (New)';
						$prefix         = 'fa-';
						$display_prefix = 'fa-solid';
						break;
					case 'fa-brands':
						$label          = 'Font Awesome - Brands (New)';
						$prefix         = 'fa-';
						$display_prefix = 'fa-brands';
						break;
					case 'bootstrap':
						$prefix = 'bi-';
						break;
					case 'themify':
						$prefix = 'ti-';
						break;
				}

				if ( file_exists( $json_path ) ) {
					$icons_array[ $key ] = [
						ucwords( $label ),
						$prefix,
						$display_prefix,
						'crafto-custom-icon',
						CRAFTO_ADDONS_PLUGIN_VERSION,
						CRAFTO_ADDONS_INCLUDES_URI . '/assets/icon-json/' . $value . '.json',
					];
				}
			}

			/**
			 * Apply filters to modify custom icons list
			 *
			 * @since 1.0
			 */
			$icons_list  = apply_filters( 'crafto_add_custom_icons', [] );
			$icons_array = array_merge( $icons_array, $icons_list );

			if ( ! empty( $icons_array ) ) {
				foreach ( $icons_array as $icon_name => $icon_val ) {
					$set_config['name']            = $icon_name . '_icons';
					$set_config['label']           = $icon_val[0];
					$set_config['url']             = '';
					$set_config['enqueue']         = '';
					$set_config['prefix']          = $icon_val[1];
					$set_config['displayPrefix']   = $icon_val[2];
					$set_config['labelIcon']       = $icon_val[3];
					$set_config['ver']             = $icon_val[4];
					$set_config['fetchJson']       = $icon_val[5];
					$set_config['native']          = true;
					$config[ $set_config['name'] ] = $set_config;
				}
			}

			return array_merge( $settings, $config );
		}
	}
}
