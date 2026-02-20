<?php
namespace CraftoAddons\Theme_Builder;

/**
 * Section builder initialize
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Theme_Builder_Init` doesn't exists yet.
if ( ! class_exists( 'Theme_Builder_Init' ) ) {

	/**
	 * Define Section Builder Init class.
	 */
	class Theme_Builder_Init {

		private static $elementor_instance;

		/**
		 * Section Builder Init constructor.
		 *
		 * Initializing the Elementor modules manager.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function __construct() {
			if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( '\Elementor\Plugin::instance' ) ) {
				self::$elementor_instance = \Elementor\Plugin::instance();
				$this->includes_files();
			}

			add_action( 'elementor/page_templates/canvas/before_content', array( $this, 'before_content' ) );
			add_action( 'elementor/page_templates/canvas/after_content', array( $this, 'after_content' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'crafto_load_style_and_script' ) );
		}

		/** Section Builder - Enqueue scripts and styles. */
		public function crafto_load_style_and_script() {
			if ( class_exists( 'Crafto_Builder_Helper' ) ) {
				if ( \Crafto_Builder_Helper::is_themebuilder_screen() ) {
					wp_register_style(
						'bootstrap-icons',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/bootstrap-icons.min.css',
						[],
						'1.11.3'
					);
					wp_enqueue_style( 'bootstrap-icons' );

					wp_register_style(
						'crafto-select2',
						CRAFTO_ADDONS_CSS_URI . '/admin/select2.min.css',
						[],
						'4.0.13'
					);
					wp_enqueue_style( 'crafto-select2' );

					wp_register_script(
						'crafto-select2',
						CRAFTO_ADDONS_JS_URI . '/admin/select2.min.js',
						[
							'jquery',
						],
						'4.0.13',
						true
					);
					wp_enqueue_script( 'crafto-select2' );

					wp_register_style(
						'themebuilder-new-template',
						CRAFTO_ADDONS_BUILDER_URI . '/assets/admin/themebuilder.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						false
					);
					wp_enqueue_style( 'themebuilder-new-template' );

					if ( is_rtl() ) {
						wp_register_style(
							'themebuilder-new-template-rtl',
							CRAFTO_ADDONS_BUILDER_URI . '/assets/admin/themebuilder-rtl.css',
							[],
							CRAFTO_ADDONS_PLUGIN_VERSION,
							false
						);
						wp_enqueue_style( 'themebuilder-new-template-rtl' );
					}

					wp_register_script(
						'themebuilder-new-template',
						CRAFTO_ADDONS_BUILDER_URI . '/assets/admin/themebuilder.js',
						[
							'jquery',
							'crafto-select2',
						],
						CRAFTO_ADDONS_PLUGIN_VERSION,
						true
					);
					wp_enqueue_script( 'themebuilder-new-template' );

					wp_localize_script(
						'themebuilder-new-template',
						'craftoBuilder',
						array(
							'ajaxurl' => admin_url( 'admin-ajax.php' ),
							'i18n'    => array(
								'placeholder'          => esc_html__( 'Select', 'crafto-addons' ),
								'responseErrorMessage' => esc_html__( 'Something went wrong', 'crafto-addons' ),
							),
						)
					);
				}
			}
		}

		/** Section Builder - load header style. */
		public function before_content() {
			global $post;

			$crafto_header_layout_class = '';
			$crafto_header_sticky_type  = '';
			$crafto_default_template    = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( ! empty( $post ) && is_object( $post ) && isset( $post->ID ) ) {
				$crafto_header_template_id_by_meta = crafto_meta_box_values( 'crafto_template_header_style' );
				$crafto_header_template_id_by_meta = ( ! empty( $crafto_header_template_id_by_meta ) ) ? $crafto_header_template_id_by_meta : 'standard';
				$crafto_header_layout_class        = ' ' . $crafto_header_template_id_by_meta;
			}

			switch ( $crafto_default_template ) {
				case 'mini-header':
					$crafto_header_sticky_type = crafto_meta_box_values( 'crafto_mini_header_sticky_type' );
					?>
					<div class="mini-header-main-wrapper <?php echo esc_attr( $crafto_header_sticky_type ); ?>">
					<?php
					break;
				case 'header':
					$crafto_header_sticky_type = crafto_meta_box_values( 'crafto_header_sticky_type' );
					?>
					<header id="masthead" class="site-header" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
					<nav class="header-common-wrapper navbar navbar-expand-lg fixed-top <?php echo esc_attr( $crafto_header_sticky_type ) . esc_attr( $crafto_header_layout_class ); ?>">
					<?php
					break;
				case 'footer':
					?>
					<footer class="footer-main-wrapper site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
					<?php
					break;
				case 'custom-title':
					$crafto_custom_title_class = array( 'crafto-main-title-wrapper' );
					/**
					 * Apply filters to add title wrapper class
					 *
					 * @since 1.0
					 */
					$crafto_custom_title_wrapper_class = apply_filters( 'crafto_main_title_wrapper_class', $crafto_custom_title_class ); // phpcs:ignore

					$class = ( is_array( $crafto_custom_title_wrapper_class ) ) ? implode( ' ', $crafto_custom_title_wrapper_class ) : '';
					?>
					<div class="<?php echo esc_attr( $class ); ?>">
					<?php
					break;
			}
		}

		/** Section Builder - load afetr content.*/
		public function after_content() {
			$crafto_default_template = crafto_meta_box_values( 'crafto_theme_builder_template' );

			switch ( $crafto_default_template ) {
				case 'mini-header':
					?>
					</div>
					<?php
					break;
				case 'header':
					?>
					</nav>
					</header>
					<?php
					break;
				case 'footer':
					?>
					</footer>
					<?php
					break;
				case 'custom-title':
					?>
					</div>
					<?php
					break;
			}
		}

		/**
		 * Theme Builder - load includes file.
		 */
		public function includes_files() {
			$file_path = CRAFTO_ADDONS_BUILDER_DIR . '/conditions/theme-builder-functions.php';
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
			}
		}

		/**
		 * Return Section Builder Content .
		 *
		 * @param mixed $template_id Template Id.
		 */
		public static function get_content_frontend( $template_id = '' ) {
			if ( ! empty( $template_id ) ) {
				$template_content = \Crafto_Addons_Extra_Functions::crafto_get_builder_content_for_display( $template_id );
				printf( '%s', $template_content ); // phpcs:ignore
			} else {
				return true;
			}
		}
	} // End of Class
} // End of Class Exists
