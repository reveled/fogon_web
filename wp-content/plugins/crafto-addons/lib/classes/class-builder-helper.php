<?php
/**
 * Crafto theme builder helper
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If class `Crafto_Builder_Helper` doesn't exists yet.
if ( ! class_exists( 'Crafto_Builder_Helper' ) ) {

	/**
	 * Define Crafto_Builder_Helper class
	 */
	class Crafto_Builder_Helper {

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'wp_ajax_crafto_theme_builder_lightbox', array( $this, 'crafto_theme_builder_lightbox' ) );
			add_action( 'wp_ajax_nopriv_crafto_theme_builder_lightbox', array( $this, 'crafto_theme_builder_lightbox' ) );

			add_action( 'wp_ajax_crafto_get_posts_list_callback', array( __CLASS__, 'crafto_get_posts_list_callback' ) );
			add_action( 'wp_ajax_nopriv_crafto_get_posts_list_callback', array( __CLASS__, 'crafto_get_posts_list_callback' ) );

			add_action( 'wp_ajax_crafto_get_exclude_posts_list_callback', array( __CLASS__, 'crafto_get_exclude_posts_list_callback' ) );
			add_action( 'wp_ajax_nopriv_crafto_get_exclude_posts_list_callback', array( __CLASS__, 'crafto_get_exclude_posts_list_callback' ) );

			add_action( 'admin_footer', array( $this, 'crafto_admin_new_template_lightbox' ) );
		}

		/**
		 * Check Theme builder post or not.
		 */
		public static function is_themebuilder_screen() {

			global $pagenow, $typenow;

			if ( 'themebuilder' === $typenow && ( 'edit.php' === $pagenow || 'post.php' === $pagenow ) ) {
				return true;
			}
			return false;
		}

		/**
		 * Check elementor edit mode.
		 */
		public static function is_crafto_elementor_editor_preview_mode() {
			// Check if Elementor is active.
			if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
				return false;
			}

			if ( is_elementor_activated() && ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Check if Theme builder template type is post archive.
		 */
		public static function is_theme_builder_archive_template() {
			global $post;

			if ( is_category() || is_archive() || is_author() || is_tag() || is_search() || is_home() ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'archive' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Check if Theme builder template type is portfolio archive.
		 */
		public static function is_theme_builder_archive_portfolio_template() {
			global $post;

			if ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'archive-portfolio' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Check if Theme builder template type is property archive.
		 */
		public static function is_theme_builder_archive_property_template() {
			global $post;

			if ( is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'archive-property' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Check if Theme builder template type is tours archive.
		 */
		public static function is_theme_builder_archive_tours_template() {
			global $post;

			if ( is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'archive-tours' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Check if Theme builder template type is custom title.
		 */
		public static function is_theme_builder_page_title_template() {
			global $post;

			if ( is_category() || is_archive() || is_author() || is_tag() || is_search() || is_home() || is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) || ( is_woocommerce_activated() && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_tax( 'product_brand' ) ) ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'custom-title' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Check if Theme builder template type is single post.
		 */
		public static function is_theme_builder_single_post_template() {
			global $post;

			$post_type_array  = [ 'post' ];
			$post_type        = [];
			$custom_post_type = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
			if ( ! empty( $custom_post_type ) ) {
				$post_type = wp_list_pluck( $custom_post_type, 'name' );
			}

			$post_type_slug = array_merge( $post_type_array, $post_type );

			if ( is_singular( $post_type_slug ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'single' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Check if Theme builder template type is single property.
		 */
		public static function is_theme_builder_single_property_template() {
			global $post;

			if ( is_singular( 'properties' ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'single-properties' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Check if Theme builder template type is single tour.
		 */
		public static function is_theme_builder_single_tour_template() {
			global $post;

			if ( is_singular( 'tours' ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'single-tours' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}


		/**
		 * Check if Theme builder template type is single post.
		 */
		public static function is_theme_builder_all_single_template() {
			global $post;

			$post_type_array  = [ 'post', 'portfolio', 'properties', 'tours', 'product' ];
			$post_type        = [];
			$custom_post_type = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
			if ( ! empty( $custom_post_type ) ) {
				$post_type = wp_list_pluck( $custom_post_type, 'name' );
			}

			$post_type_slug = array_merge( $post_type_array, $post_type );

			if ( is_singular( $post_type_slug ) ) {
				return true;
			}

			if ( empty( $post->ID ) ) {
				return false;
			}

			if ( ! isset( $post->ID ) ) {
				return false;
			}

			$crafto_get_template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );

			if ( 'themebuilder' === $post->post_type && self::is_crafto_elementor_editor_preview_mode() ) {
				if ( 'single' === $crafto_get_template_type || 'single-portfolio' === $crafto_get_template_type || 'single-properties' === $crafto_get_template_type || 'single-tours' === $crafto_get_template_type ) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}

		/**
		 * Return template type.
		 */
		public static function crafto_theme_builder_template_types() {
			$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );
			$crafto_disable_property  = get_theme_mod( 'crafto_disable_property', '0' );
			$crafto_disable_tours     = get_theme_mod( 'crafto_disable_tours', '0' );

			// Initialize template types.
			$crafto_template_type = array(
				'mini-header'  => esc_html__( 'Top Bar', 'crafto-addons' ),
				'header'       => esc_html__( 'Header', 'crafto-addons' ),
				'footer'       => esc_html__( 'Footer', 'crafto-addons' ),
				'custom-title' => esc_html__( 'Page Title', 'crafto-addons' ),
				'404_page'     => esc_html__( '404', 'crafto-addons' ),
				'promo_popup'  => esc_html__( 'Popup', 'crafto-addons' ),
				'side_icon'    => esc_html__( 'Side Icon', 'crafto-addons' ),
				'archive'      => esc_html__( 'Post Archive', 'crafto-addons' ),
				'single'       => esc_html__( 'Post Single', 'crafto-addons' ),
			);
			if ( '1' !== $crafto_disable_portfolio ) {
				$crafto_template_type['archive-portfolio'] = esc_html__( 'Portfolio Archive', 'crafto-addons' );
				$crafto_template_type['single-portfolio']  = esc_html__( 'Portfolio Single', 'crafto-addons' );
			}
			if ( '1' !== $crafto_disable_property ) {
				$crafto_template_type['archive-property']  = esc_html__( 'Property Archive', 'crafto-addons' );
				$crafto_template_type['single-properties'] = esc_html__( 'Property Single', 'crafto-addons' );
			}
			if ( '1' !== $crafto_disable_tours ) {
				$crafto_template_type['archive-tours'] = esc_html__( 'Tour Archive', 'crafto-addons' );
				$crafto_template_type['single-tours']  = esc_html__( 'Tour Single', 'crafto-addons' );
			}

			return $crafto_template_type;
		}

		/**
		 * Return template type.
		 *
		 * @param mixed $template_type template type.
		 */
		public static function crafto_get_template_type_by_key( $template_type = '' ) {
			$template_type_data = self::crafto_theme_builder_template_types();
			$template_type_data = ! empty( $template_type ) && isset( $template_type_data[ $template_type ] ) ? $template_type_data[ $template_type ] : $template_type_data;

			return $template_type_data;
		}
		/**
		 * Return mini header sticky type.
		 *
		 * @param mixed $mini_header_sticky_type Add mini header sticky type.
		 */
		public static function crafto_get_mini_header_sticky_type_by_key( $mini_header_sticky_type = '' ) {
			$mini_header_sticky_type_data = array(
				'always-fixed'  => esc_html__( 'Always Fixed', 'crafto-addons' ),
				'disable-fixed' => esc_html__( 'Disable Fixed', 'crafto-addons' ),
			);
			return ! empty( $mini_header_sticky_type ) ? $mini_header_sticky_type_data[ $mini_header_sticky_type ] : $mini_header_sticky_type_data;
		}

		/**
		 * Return header style.
		 *
		 * @param mixed $header_style Add header style.
		 */
		public static function crafto_get_header_style_by_key( $header_style = '' ) {
			$header_style_data = array(
				'standard'          => esc_html__( 'Standard', 'crafto-addons' ),
				'left-menu-classic' => esc_html__( 'Left Menu Classic', 'crafto-addons' ),
				'left-menu-modern'  => esc_html__( 'Left Menu Modern', 'crafto-addons' ),
			);
			return ! empty( $header_style ) ? $header_style_data[ $header_style ] : $header_style_data;
		}

		/**
		 * Return header sticky type.
		 *
		 * @param mixed $header_sticky_type Add header sticky type.
		 */
		public static function crafto_get_header_sticky_type_by_key( $header_sticky_type = '' ) {
			$header_sticky_type_data = array(
				'always-fixed'        => esc_html__( 'Always Fixed', 'crafto-addons' ),
				'disable-fixed'       => esc_html__( 'Disable Fixed', 'crafto-addons' ),
				'header-reverse'      => esc_html__( 'Reverse Auto', 'crafto-addons' ),
				'reverse-back-scroll' => esc_html__( 'Reverse Back Scroll', 'crafto-addons' ),
				'responsive-sticky'   => esc_html__( 'Responsive Sticky', 'crafto-addons' ),
			);
			return ! empty( $header_sticky_type ) ? $header_sticky_type_data[ $header_sticky_type ] : $header_sticky_type_data;
		}

		/**
		 * Return header sticky type.
		 *
		 * @param mixed $header_display_type Add header display type.
		 */
		public static function crafto_get_header_display_type_by_key( $header_display_type = '' ) {
			$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );
			$crafto_disable_property  = get_theme_mod( 'crafto_disable_property', '0' );
			$crafto_disable_tours     = get_theme_mod( 'crafto_disable_tours', '0' );

			$selection_options = array(
				'basic-global'      => esc_html__( 'Entire Website', 'crafto-addons' ),
				'basic-page'        => esc_html__( 'All Pages', 'crafto-addons' ),
				'basic-single'      => esc_html__( 'All Posts Single', 'crafto-addons' ),
				'basic-archives'    => esc_html__( 'All Archives', 'crafto-addons' ),
				'special-search'    => esc_html__( 'Search Page', 'crafto-addons' ),
				'special-not-found' => esc_html__( '404 Page', 'crafto-addons' ),
				'special-blog'      => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
				'special-front'     => esc_html__( 'Front Page', 'crafto-addons' ),
			);
			if ( '1' !== $crafto_disable_portfolio ) {
				$selection_options['special-portfolio-archive'] = esc_html__( 'Portfolio Archive', 'crafto-addons' );
				$selection_options['special-portfolio-single']  = esc_html__( 'Portfolio Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_property ) {
				$selection_options['special-property-archive'] = esc_html__( 'Property Archive', 'crafto-addons' );
				$selection_options['special-property-single']  = esc_html__( 'Property Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_tours ) {
				$selection_options['special-tours-archive'] = esc_html__( 'Tour Archive', 'crafto-addons' );
				$selection_options['special-tours-single']  = esc_html__( 'Tour Single', 'crafto-addons' );
			}
			if ( is_woocommerce_activated() ) {
				$selection_options['special-woo-shop']        = esc_html__( 'WooCommerce Shop Page', 'crafto-addons' );
				$selection_options['special-product-archive'] = esc_html__( 'Products Archive', 'crafto-addons' );
				$selection_options['special-product-single']  = esc_html__( 'Products Single', 'crafto-addons' );
			}
			return ! empty( $header_display_type ) ? $selection_options[ $header_display_type ] : $selection_options;
		}

		/**
		 * Return footer sticky type.
		 *
		 * @param mixed $footer_display_type Add footer display type.
		 */
		public static function crafto_get_footer_display_type_by_key( $footer_display_type = '' ) {
			$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );
			$crafto_disable_property  = get_theme_mod( 'crafto_disable_property', '0' );
			$crafto_disable_tours     = get_theme_mod( 'crafto_disable_tours', '0' );

			$selection_options = array(
				'basic-global'      => esc_html__( 'Entire Website', 'crafto-addons' ),
				'basic-page'        => esc_html__( 'All Pages', 'crafto-addons' ),
				'basic-single'      => esc_html__( 'All Posts Single', 'crafto-addons' ),
				'basic-archives'    => esc_html__( 'All Archives', 'crafto-addons' ),
				'special-search'    => esc_html__( 'Search Page', 'crafto-addons' ),
				'special-not-found' => esc_html__( '404 Page', 'crafto-addons' ),
				'special-blog'      => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
				'special-front'     => esc_html__( 'Front Page', 'crafto-addons' ),
			);
			if ( '1' !== $crafto_disable_portfolio ) {
				$selection_options['special-portfolio-archive'] = esc_html__( 'Portfolio Archive', 'crafto-addons' );
				$selection_options['special-portfolio-single']  = esc_html__( 'Portfolio Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_property ) {
				$selection_options['special-property-archive'] = esc_html__( 'Property Archive', 'crafto-addons' );
				$selection_options['special-property-single']  = esc_html__( 'Property Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_tours ) {
				$selection_options['special-tours-archive'] = esc_html__( 'Tour Archive', 'crafto-addons' );
				$selection_options['special-tours-single']  = esc_html__( 'Tour Single', 'crafto-addons' );
			}
			if ( is_woocommerce_activated() ) {
				$selection_options['special-woo-shop']        = esc_html__( 'WooCommerce Shop Page', 'crafto-addons' );
				$selection_options['special-product-archive'] = esc_html__( 'Products Archive', 'crafto-addons' );
				$selection_options['special-product-single']  = esc_html__( 'Products Single', 'crafto-addons' );
			}
			return ! empty( $footer_display_type ) ? $selection_options[ $footer_display_type ] : $selection_options;
		}

		/**
		 * Return footer sticky type.
		 *
		 * @param mixed $mini_header_display_type Add footer display type.
		 */
		public static function crafto_get_mini_header_display_type_by_key( $mini_header_display_type = '' ) {
			$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );
			$crafto_disable_property  = get_theme_mod( 'crafto_disable_property', '0' );
			$crafto_disable_tours     = get_theme_mod( 'crafto_disable_tours', '0' );

			$selection_options = array(
				'basic-global'      => esc_html__( 'Entire Website', 'crafto-addons' ),
				'basic-page'        => esc_html__( 'All Pages', 'crafto-addons' ),
				'basic-single'      => esc_html__( 'All Posts Single', 'crafto-addons' ),
				'basic-archives'    => esc_html__( 'All Archives', 'crafto-addons' ),
				'special-search'    => esc_html__( 'Search Page', 'crafto-addons' ),
				'special-not-found' => esc_html__( '404 Page', 'crafto-addons' ),
				'special-blog'      => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
				'special-front'     => esc_html__( 'Front Page', 'crafto-addons' ),
			);
			if ( '1' !== $crafto_disable_portfolio ) {
				$selection_options['special-portfolio-archive'] = esc_html__( 'Portfolio Archive', 'crafto-addons' );
				$selection_options['special-portfolio-single']  = esc_html__( 'Portfolio Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_property ) {
				$selection_options['special-property-archive'] = esc_html__( 'Property Archive', 'crafto-addons' );
				$selection_options['special-property-single']  = esc_html__( 'Property Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_tours ) {
				$selection_options['special-tours-archive'] = esc_html__( 'Tour Archive', 'crafto-addons' );
				$selection_options['special-tours-single']  = esc_html__( 'Tour Single', 'crafto-addons' );
			}
			if ( is_woocommerce_activated() ) {
				$selection_options['special-woo-shop']        = esc_html__( 'WooCommerce Shop Page', 'crafto-addons' );
				$selection_options['special-product-archive'] = esc_html__( 'Products Archive', 'crafto-addons' );
				$selection_options['special-product-single']  = esc_html__( 'Products Single', 'crafto-addons' );
			}
			return ! empty( $mini_header_display_type ) ? $selection_options[ $mini_header_display_type ] : $selection_options;
		}

		/**
		 * Return custom title sticky type.
		 *
		 * @param mixed $custom_title_display_type Add custom title display type.
		 */
		public static function crafto_get_custom_title_display_type_by_key( $custom_title_display_type = '' ) {
			$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );
			$crafto_disable_property  = get_theme_mod( 'crafto_disable_property', '0' );
			$crafto_disable_tours     = get_theme_mod( 'crafto_disable_tours', '0' );

			$selection_options = array(
				'basic-global'      => esc_html__( 'Entire Website', 'crafto-addons' ),
				'basic-page'        => esc_html__( 'All Pages', 'crafto-addons' ),
				'basic-single'      => esc_html__( 'All Posts Single', 'crafto-addons' ),
				'basic-archives'    => esc_html__( 'All Archives', 'crafto-addons' ),
				'special-search'    => esc_html__( 'Search Page', 'crafto-addons' ),
				'special-not-found' => esc_html__( '404 Page', 'crafto-addons' ),
				'special-blog'      => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
				'special-front'     => esc_html__( 'Front Page', 'crafto-addons' ),
			);
			if ( '1' !== $crafto_disable_portfolio ) {
				$selection_options['special-portfolio-archive'] = esc_html__( 'Portfolio Archive', 'crafto-addons' );
				$selection_options['special-portfolio-single']  = esc_html__( 'Portfolio Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_property ) {
				$selection_options['special-property-archive'] = esc_html__( 'Property Archive', 'crafto-addons' );
				$selection_options['special-property-single']  = esc_html__( 'Property Single', 'crafto-addons' );
			}

			if ( '1' !== $crafto_disable_tours ) {
				$selection_options['special-tours-archive'] = esc_html__( 'Tour Archive', 'crafto-addons' );
				$selection_options['special-tours-single']  = esc_html__( 'Tour Single', 'crafto-addons' );
			}
			if ( is_woocommerce_activated() ) {
				$selection_options['special-woo-shop']        = esc_html__( 'WooCommerce Shop Page', 'crafto-addons' );
				$selection_options['special-product-archive'] = esc_html__( 'Products Archive', 'crafto-addons' );
				$selection_options['special-product-single']  = esc_html__( 'Products Single', 'crafto-addons' );
			}
			if ( class_exists( 'LearnPress' ) ) {
				$courses_page_id = learn_press_get_page_id( 'courses' );
				if ( $courses_page_id ) {
					$courses_page_slug                       = get_post_field( 'post_name', $courses_page_id );
					$selection_options[ $courses_page_slug ] = esc_html__( 'Courses Archive', 'crafto-addons' );
				}
			}
			return ! empty( $custom_title_display_type ) ? $selection_options[ $custom_title_display_type ] : $selection_options;
		}

		/**
		 * Return footer sticky type.
		 *
		 * @param mixed $footer_sticky_type Add footer sticky type.
		 */
		public static function crafto_get_footer_sticky_type_by_key( $footer_sticky_type = '' ) {
			$footer_sticky_type_data = array(
				'no-sticky' => esc_html__( 'Non Sticky', 'crafto-addons' ),
				'sticky'    => esc_html__( 'Sticky', 'crafto-addons' ),
				'overlap'   => esc_html__( 'Overlap', 'crafto-addons' ),
			);
			return ! empty( $footer_sticky_type ) ? $footer_sticky_type_data[ $footer_sticky_type ] : $footer_sticky_type_data;
		}

		/**
		 * Return Archive style.
		 *
		 * @param mixed $archive_style Add archive style.
		 */
		public static function crafto_get_archive_style_by_key( $archive_style = '' ) {
			$archive_style_data = array(
				'general' => esc_html__( 'All Archives', 'crafto-addons' ),
			);

			$custom_post_type = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
			if ( ! empty( $custom_post_type ) ) {
				foreach ( $custom_post_type as $post_type_name ) {
					$post_type_slug  = $post_type_name['name'];
					$post_type_label = $post_type_name['label'];

					$custom_post_type_key   = $post_type_slug;
					$custom_post_type_label = sprintf( '%1$s %2$s %3$s', esc_html__( 'All', 'crafto-addons' ), esc_html( $post_type_label ), esc_html__( 'Archive', 'crafto-addons' ) );

					$archive_style_data[ $custom_post_type_key ] = $custom_post_type_label;
				}
			}

			$archive_style_data['blog-home-archive']        = esc_html__( 'Blog/Home Archive', 'crafto-addons' );
			$archive_style_data['author-archives']          = esc_html__( 'Author Archive', 'crafto-addons' );
			$archive_style_data['date-archives']            = esc_html__( 'Date Archive', 'crafto-addons' );
			$archive_style_data['search-archives-template'] = esc_html__( 'Search Results', 'crafto-addons' );
			$archive_style_data['category-archives']        = esc_html__( 'Categories', 'crafto-addons' );
			$archive_style_data['tag-archives']             = esc_html__( 'Tags', 'crafto-addons' );

			if ( class_exists( 'Give' ) ) {
				$archive_style_data['give_forms_category'] = esc_html__( 'Give Category', 'crafto-addons' );
			}

			$taxonomies      = [];
			$crafto_taxonomy = apply_filters( 'crafto_get_taxonomy_data', get_option( 'crafto_register_taxonomies', [] ), get_current_blog_id() );
			if ( ! empty( $crafto_taxonomy ) ) {
				$taxonomies = wp_list_pluck( $crafto_taxonomy, 'label' );
			}

			if ( ! empty( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomies_slug => $taxonomies_name ) {

					$custom_taxonomies = $taxonomies_slug;

					$archive_style_data[ $custom_taxonomies ] = $taxonomies_name;
				}
			}

			return ! empty( $archive_style ) ? $archive_style_data[ $archive_style ] : $archive_style_data;
		}

		/**
		 * Return Archive portfolio style.
		 *
		 * @param mixed $archive_portfolio_style Add archive portfolio style.
		 */
		public static function crafto_get_archive_portfolio_style_by_key( $archive_portfolio_style = '' ) {
			$archive_portfolio_style_data = array(
				'general'                 => esc_html__( 'All Portfolio Archives', 'crafto-addons' ),
				'portfolio-cat-archives'  => esc_html__( 'Portfolio Categories', 'crafto-addons' ),
				'portfolio-tags-archives' => esc_html__( 'Portfolio Tags', 'crafto-addons' ),
			);
			return ! empty( $archive_portfolio_style ) ? $archive_portfolio_style_data[ $archive_portfolio_style ] : $archive_portfolio_style_data;
		}

		/**
		 * Return Archive property style.
		 *
		 * @param mixed $archive_property_style Add archive property style.
		 */
		public static function crafto_get_archive_property_style_by_key( $archive_property_style = '' ) {
			$archive_property_style_data = array(
				'general'         => esc_html__( 'All Property Archives', 'crafto-addons' ),
				'property-types'  => esc_html__( 'Property Types', 'crafto-addons' ),
				'property-agents' => esc_html__( 'Property Agents', 'crafto-addons' ),
			);
			return ! empty( $archive_property_style ) ? $archive_property_style_data[ $archive_property_style ] : $archive_property_style_data;
		}

		/**
		 * Return Archive tours style.
		 *
		 * @param mixed $archive_tours_style Add archive tours style.
		 */
		public static function crafto_get_archive_tours_style_by_key( $archive_tours_style = '' ) {
			$archive_tours_style_data = array(
				'general'           => esc_html__( 'All Tour Archives', 'crafto-addons' ),
				'tours-destination' => esc_html__( 'Tour Destination', 'crafto-addons' ),
				'tours-activity'    => esc_html__( 'Tour Activities', 'crafto-addons' ),
			);
			return ! empty( $archive_tours_style ) ? $archive_tours_style_data[ $archive_tours_style ] : $archive_tours_style_data;
		}

		/**
		 * AJAX callback to add new template with lightbox
		 */
		public function crafto_theme_builder_lightbox() {
			// Early return if template type is empty.
			if ( ! isset( $_REQUEST['template_type'] ) && empty( $_REQUEST['template_type'] ) ) { // phpcs:ignore
				return;
			}

			$template_type            = $_REQUEST['template_type']; // phpcs:ignore
			$mini_header_sticky_style = ( isset( $_REQUEST['mini_header_sticky_style'] ) && ! empty( $_REQUEST['mini_header_sticky_style'] ) ) ? $_REQUEST['mini_header_sticky_style'] : 'always-fixed'; // phpcs:ignore
			$crafto_mini_header_display_type = ( isset( $_REQUEST['crafto_mini_header_display_type'] ) && ! empty( $_REQUEST['crafto_mini_header_display_type'] ) ) ? $_REQUEST['crafto_mini_header_display_type'] : ''; // phpcs:ignore
			$template_style           = ( isset( $_REQUEST['template_style'] ) && ! empty( $_REQUEST['template_style'] ) ) ? $_REQUEST['template_style'] : 'standard'; // phpcs:ignore
			$header_sticky_style      = ( isset( $_REQUEST['header_sticky_style'] ) && ! empty( $_REQUEST['header_sticky_style'] ) ) ? $_REQUEST['header_sticky_style'] : 'always-fixed'; // phpcs:ignore
			$header_display_style     = ( isset( $_REQUEST['header_display_style'] ) && ! empty( $_REQUEST['header_display_style'] ) ) ? $_REQUEST['header_display_style'] : ''; // phpcs:ignore
			$footer_sticky_style      = ( isset( $_REQUEST['footer_sticky_style'] ) && ! empty( $_REQUEST['footer_sticky_style'] ) ) ? $_REQUEST['footer_sticky_style'] : ''; // phpcs:ignore
			$crafto_footer_display_type = ( isset( $_REQUEST['crafto_footer_display_type'] ) && ! empty( $_REQUEST['crafto_footer_display_type'] ) ) ? $_REQUEST['crafto_footer_display_type'] : ''; // phpcs:ignore
			$crafto_custom_title_display_type = ( isset( $_REQUEST['crafto_custom_title_display_type'] ) && ! empty( $_REQUEST['crafto_custom_title_display_type'] ) ) ? $_REQUEST['crafto_custom_title_display_type'] : ''; // phpcs:ignore
			$template_title           = ( isset( $_REQUEST['template_title'] ) && ! empty( $_REQUEST['template_title'] ) ) ? $_REQUEST['template_title'] : ''; // phpcs:ignore

			/* Default Posts */
			$template_archive       = ( isset( $_REQUEST['archive_style'] ) && ! empty( $_REQUEST['archive_style'] ) ) ? $_REQUEST['archive_style'] : ''; // phpcs:ignore
			$specific_posts         = ( isset( $_REQUEST['specific_posts'] ) && ! empty( $_REQUEST['specific_posts'] ) ) ? $_REQUEST['specific_posts'] : ''; // phpcs:ignore
			$specific_exclude_posts = ( isset( $_REQUEST['specific_exclude_posts'] ) && ! empty( $_REQUEST['specific_exclude_posts'] ) ) ? $_REQUEST['specific_exclude_posts'] : ''; // phpcs:ignore

			/* Custom Post type - Portfolios */
			$template_archive_portfolio = ( isset( $_REQUEST['archive_portfolio_style'] ) && ! empty( $_REQUEST['archive_portfolio_style'] ) ) ? $_REQUEST['archive_portfolio_style'] : ''; // phpcs:ignore
			$specific_portfolio         = ( isset( $_REQUEST['specific_portfolio'] ) && ! empty( $_REQUEST['specific_portfolio'] ) ) ? $_REQUEST['specific_portfolio'] : ''; // phpcs:ignore
			$specific_exclude_portfolio = ( isset( $_REQUEST['specific_exclude_portfolio'] ) && ! empty( $_REQUEST['specific_exclude_portfolio'] ) ) ? $_REQUEST['specific_exclude_portfolio'] : ''; // phpcs:ignore

			/* Custom Post type - Property */
			$template_archive_property   = ( isset( $_REQUEST['archive_property_style'] ) && ! empty( $_REQUEST['archive_property_style'] ) ) ? $_REQUEST['archive_property_style'] : ''; // phpcs:ignore
			$specific_properties         = ( isset( $_REQUEST['specific_properties'] ) && ! empty( $_REQUEST['specific_properties'] ) ) ? $_REQUEST['specific_properties'] : ''; // phpcs:ignore
			$specific_exclude_properties = ( isset( $_REQUEST['specific_exclude_properties'] ) && ! empty( $_REQUEST['specific_exclude_properties'] ) ) ? $_REQUEST['specific_exclude_properties'] : ''; // phpcs:ignore

			/* Custom Post type - Tour */
			$template_archive_tours = ( isset( $_REQUEST['archive_tours_style'] ) && ! empty( $_REQUEST['archive_tours_style'] ) ) ? $_REQUEST['archive_tours_style'] : ''; // phpcs:ignore
			$specific_tours         = ( isset( $_REQUEST['specific_tours'] ) && ! empty( $_REQUEST['specific_tours'] ) ) ? $_REQUEST['specific_tours'] : ''; // phpcs:ignore
			$specific_exclude_tours = ( isset( $_REQUEST['specific_exclude_tours'] ) && ! empty( $_REQUEST['specific_exclude_tours'] ) ) ? $_REQUEST['specific_exclude_tours'] : ''; // phpcs:ignore

			$meta_query_arr = [];
			$meta_query_arr = array(
				'crafto_theme_builder_template' => $template_type,
			);

			if ( 'mini-header' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_mini_header_sticky_type'  => $mini_header_sticky_style,
					'crafto_mini_header_display_type' => $crafto_mini_header_display_type,
				);
			}

			if ( 'header' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_header_style' => $template_style,
					'crafto_header_sticky_type'    => $header_sticky_style,
					'crafto_header_display_type'   => $header_display_style,
				);
			}

			if ( 'footer' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_footer_sticky_type'  => $footer_sticky_style,
					'crafto_footer_display_type' => $crafto_footer_display_type,
				);
			}

			if ( 'archive' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_archive_style' => $template_archive,
				);
			}

			if ( 'single' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_specific_post' => $specific_posts,
				);

				$meta_query_arr[] = array(
					'crafto_template_specific_exclude_post' => $specific_exclude_posts,
				);

			}

			if ( 'archive-portfolio' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_archive_portfolio_style' => $template_archive_portfolio,
				);
			}

			if ( 'single-portfolio' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_specific_portfolio' => $specific_portfolio,
				);
				$meta_query_arr[] = array(
					'crafto_template_specific_exclude_portfolio' => $specific_exclude_portfolio,
				);
			}

			if ( 'archive-property' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_archive_property_style' => $template_archive_property,
				);
			}

			if ( 'single-properties' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_specific_properties' => $specific_properties,
				);
				$meta_query_arr[] = array(
					'crafto_template_specific_exclude_properties' => $specific_exclude_properties,
				);
			}

			if ( 'archive-tours' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_archive_tours_style' => $template_archive_tours,
				);
			}

			if ( 'single-tours' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_template_specific_tours' => $specific_tours,
				);

				$meta_query_arr[] = array(
					'crafto_template_specific_exclude_tours' => $specific_exclude_tours,
				);
			}

			if ( 'custom-title' === $template_type ) {
				$meta_query_arr[] = array(
					'crafto_custom_title_display_type' => $crafto_custom_title_display_type,
				);
			}

			$new_post_id = wp_insert_post(
				array(
					'post_title' => $template_title,
					'post_type'  => 'themebuilder',
				),
				true
			);

			/**
			 * Add / Update `crafto_global_meta` post meta.
			 */
			update_post_meta( $new_post_id, 'crafto_global_meta', $meta_query_arr );

			/**
			 * Add / Update `_crafto_theme_builder_template` post meta.
			 */
			update_post_meta( $new_post_id, '_crafto_theme_builder_template', $template_type );
			update_post_meta( $new_post_id, '_crafto_template_specific_post', $specific_posts );
			update_post_meta( $new_post_id, '_crafto_template_specific_portfolio', $specific_portfolio );
			update_post_meta( $new_post_id, '_crafto_template_specific_properties', $specific_properties );
			update_post_meta( $new_post_id, '_crafto_template_specific_tours', $specific_tours );
			update_post_meta( $new_post_id, '_crafto_template_specific_exclude_post', $specific_exclude_posts );
			update_post_meta( $new_post_id, '_crafto_template_specific_exclude_portfolio', $specific_exclude_portfolio );
			update_post_meta( $new_post_id, '_crafto_template_specific_exclude_properties', $specific_exclude_properties );
			update_post_meta( $new_post_id, '_crafto_template_specific_exclude_tours', $specific_exclude_tours );
			update_post_meta( $new_post_id, '_crafto_mini_header_display_type', $crafto_mini_header_display_type );
			update_post_meta( $new_post_id, '_crafto_header_display_type', $header_display_style );
			update_post_meta( $new_post_id, '_crafto_footer_display_type', $crafto_footer_display_type );
			update_post_meta( $new_post_id, '_crafto_custom_title_display_type', $crafto_custom_title_display_type );

			if ( empty( $template_title ) ) {
				$post_data = array(
					'ID'         => $new_post_id,
					'post_title' => sprintf(
						'%1$s %2$s %3$s%4$s',
						esc_html__( 'Section', 'crafto-addons' ),
						esc_html( ucfirst( $template_type ) ),
						esc_html__( '#', 'crafto-addons' ),
						esc_html( $new_post_id )
					),
				);

				wp_update_post( $post_data );
			}

			$output = add_query_arg(
				array(
					'post'   => $new_post_id,
					'action' => 'elementor',
				),
				admin_url( 'edit.php' )
			);

			printf( $output ); // phpcs:ignore
			wp_die();
		}

		/**
		 * AJAX callback to add new template with lightbox
		 */
		public function crafto_admin_new_template_lightbox() {
			if ( self::is_themebuilder_screen() ) {
				global $pagenow;

				$crafto_current_template           = '';
				$crafto_current_mini_header_sticky = '';
				$crafto_current_header             = '';
				$crafto_current_header_sticky      = '';
				$crafto_header_display_type        = '';
				$crafto_current_footer_sticky      = '';
				$crafto_footer_display_type        = '';
				$crafto_custom_title_display_type  = '';
				$crafto_mini_header_display_type   = '';
				$crafto_current_archive            = '';
				$crafto_current_archive_portfolio  = '';

				if ( is_admin() && 'edit.php' === $pagenow ) {
					$crafto_current_template           = crafto_meta_box_values( 'crafto_theme_builder_template' );
					$crafto_current_mini_header_sticky = crafto_meta_box_values( 'crafto_mini_header_sticky_type' );
					$crafto_current_header             = crafto_meta_box_values( 'crafto_template_header_style' );
					$crafto_current_header_sticky      = crafto_meta_box_values( 'crafto_header_sticky_type' );
					$crafto_header_display_type        = crafto_meta_box_values( 'crafto_header_display_type' );
					$crafto_current_footer_sticky      = crafto_meta_box_values( 'crafto_footer_sticky_type' );
					$crafto_footer_display_type        = crafto_meta_box_values( 'crafto_footer_display_type' );
					$crafto_custom_title_display_type  = crafto_meta_box_values( 'crafto_custom_title_display_type' );
					$crafto_mini_header_display_type   = crafto_meta_box_values( 'crafto_mini_header_display_type' );
					$crafto_current_archive            = crafto_meta_box_values( 'crafto_template_archive_style' );
					$crafto_current_archive_portfolio  = crafto_meta_box_values( 'crafto_template_archive_portfolio_style' );
				}

				$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );
				$crafto_disable_property  = get_theme_mod( 'crafto_disable_property', '0' );
				$crafto_disable_tours     = get_theme_mod( 'crafto_disable_tours', '0' );
				?>
				<div class="themebuilder-outer">
					<div class="themebuilder-inner">
						<div class="inner-wrap">
							<button class="close"><i class="bi bi-x"></i></button>
							<form class="themebuilder-new-template-form">
								<div class="themebuilder-new-template-form-title">
									<img src="<?php echo esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/crafto-theme-builder.svg' ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'Bedroom', 'crafto-addons' ); ?>">
								</div>
								<div class="themebuilder-form-field">
									<div class="template-form-field">
										<label for="themebuilder-template-type" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Template Type', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-template-type" class="themebuilder-form-field-select themebuilder-form-field-template" name="template_type" required="required" autocomplete="off">
											<?php
											$crafto_types = self::crafto_theme_builder_template_types();

											if ( '1' === $crafto_disable_portfolio ) {
												unset( $crafto_types['archive-portfolio'] );
												unset( $crafto_types['single-portfolio'] );
											}

											if ( '1' === $crafto_disable_property ) {
												unset( $crafto_types['archive-property'] );
												unset( $crafto_types['single-properties'] );
											}

											if ( '1' === $crafto_disable_tours ) {
												unset( $crafto_types['archive-tours'] );
												unset( $crafto_types['single-tours'] );
											}

											foreach ( $crafto_types as $key => $value ) {
												if ( ! empty( $crafto_current_template ) && 'edit.php' === $pagenow ) {
													$selected = ( $crafto_current_template === $key ) ? ' selected="selected"' : '';
												} else {
													$selected = ( 'header' === $key ) ? ' selected="selected"' : '';
												}

												$label = '';
												if ( 'archive' === $key ) {
													$label = esc_html__( 'Post', 'crafto-addons' );
												} elseif ( 'archive-portfolio' === $key ) {
													$label = esc_html__( 'Portfolio', 'crafto-addons' );
												} elseif ( 'archive-property' === $key ) {
													$label = esc_html__( 'Property', 'crafto-addons' );
												} elseif ( 'archive-tours' === $key ) {
													$label = esc_html__( 'Tour', 'crafto-addons' );
												}

												if ( $label ) {
													?>
													<optgroup label="<?php echo esc_attr( $label ); ?>">
													<?php
												}
												?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
													<?php echo $value; // phpcs:ignore ?>
												</option>
												<?php
												if ( 'single' === $key || 'single-portfolio' === $key || 'single-properties' === $key || 'single-tours' === $key ) {
													?>
													</optgroup>
													<?php
												}
											}
											?>
											</select>
										</div>
									</div>
									<div class="mini-header-form-field input-field-control">
										<label for="themebuilder-mini-header-sticky-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Sticky Type', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-mini-header-sticky-style" class="themebuilder-mini-header-sticky-style" name="template_style" required="required">
											<?php
											$crafto_mini_header_sticky = self::crafto_get_mini_header_sticky_type_by_key();
											foreach ( $crafto_mini_header_sticky as $key => $value ) {
												if ( ! empty( $crafto_current_mini_header_sticky ) && 'edit.php' === $pagenow ) {
													$selected = ( $crafto_current_mini_header_sticky === $key ) ? ' selected="selected"' : '';
												} else {
													$selected = ( 'always-fixed' === $key ) ? ' selected="selected"' : '';
												}
												?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
													<?php echo esc_html( $value ); ?>
												</option>
												<?php
											}
											?>
											</select>
										</div>
									</div>
									<div class="header-form-field input-field-control">
										<label for="themebuilder-template-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Header Style', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-template-style" class="themebuilder-form-field-template-style" name="template_style" required="required">
											<?php
											$crafto_header_style = self::crafto_get_header_style_by_key();
											foreach ( $crafto_header_style as $key => $value ) {
												if ( ! empty( $crafto_current_header ) && 'edit.php' === $pagenow ) {
													$selected = ( $crafto_current_header === $key ) ? ' selected="selected"' : '';
												} else {
													$selected = ( 'standard' === $key ) ? ' selected="selected"' : '';
												}
												?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
													<?php echo esc_html( $value ); ?>
												</option>
												<?php
											}
											?>
											</select>
										</div>
									</div>
									<div class="header-form-field input-field-control">
										<label for="themebuilder-sticky-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Sticky Type', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-sticky-style" class="themebuilder-form-field-sticky-style" name="template_style" required="required">
											<?php
											$crafto_sticky_type = self::crafto_get_header_sticky_type_by_key();
											foreach ( $crafto_sticky_type as $key => $value ) {
												if ( ! empty( $crafto_current_header_sticky ) && 'edit.php' === $pagenow ) {
													$selected = ( $crafto_current_header_sticky === $key ) ? ' selected="selected"' : '';
												} else {
													$selected = ( 'always-fixed' === $key ) ? ' selected="selected"' : '';
												}
												?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
													<?php echo esc_html( $value ); ?>
												</option>
												<?php
											}
											?>
											</select>
										</div>
									</div>

									<div class="footer-form-field input-field-control">
										<label for="themebuilder-footer-sticky-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Sticky Type', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-footer-sticky-style" class="themebuilder-footer-sticky-style" name="template_style" required="required">
											<?php
											$crafto_footer_sticky_type = self::crafto_get_footer_sticky_type_by_key();
											foreach ( $crafto_footer_sticky_type as $key => $value ) {
												if ( ! empty( $crafto_current_footer_sticky ) && 'edit.php' === $pagenow ) {
													$selected = ( $crafto_current_footer_sticky === $key ) ? ' selected="selected"' : '';
												} else {
													$selected = ( 'no-sticky' === $key ) ? ' selected="selected"' : '';
												}
												?>
												<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
													<?php echo esc_html( $value ); ?>
												</option>
												<?php
											}
											?>
											</select>
										</div>
									</div>
									<div class="header-form-field input-field-control">
										<label for="themebuilder-display-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-display-style" class="themebuilder-form-field-display-style crafto-dropdown-select2" name="disple_template_style[]" required="required" multiple="multiple" style="width:99%;max-width:25em;">
											<?php
											$special_pages = array(
												array(
													'name' => esc_html__( 'Search Page', 'crafto-addons' ),
													'value' => 'special-search',
												),
												array(
													'name' => esc_html__( '404 Page', 'crafto-addons' ),
													'value' => 'special-not-found',
												),
												array(
													'name' => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
													'value' => 'special-blog',
												),
												array(
													'name' => esc_html__( 'Front Page', 'crafto-addons' ),
													'value' => 'special-front',
												),
											);

											if ( '1' !== $crafto_disable_portfolio ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Single', 'crafto-addons' ),
													'value' => 'special-portfolio-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Archive', 'crafto-addons' ),
													'value' => 'special-portfolio-archive',
												);
											}

											if ( '1' !== $crafto_disable_property ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Property Single', 'crafto-addons' ),
													'value' => 'special-property-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Property Archive', 'crafto-addons' ),
													'value' => 'special-property-archive',
												);
											}

											if ( '1' !== $crafto_disable_tours ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Single', 'crafto-addons' ),
													'value' => 'special-tours-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Archive', 'crafto-addons' ),
													'value' => 'special-tours-archive',
												);
											}

											if ( class_exists( 'WooCommerce' ) ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Products Single', 'crafto-addons' ),
													'value' => 'special-product-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Products Archive', 'crafto-addons' ),
													'value' => 'special-product-archive',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'WooCommerce Shop Page', 'crafto-addons' ),
													'value' => 'special-woo-shop',
												);
											}

											$selection_options = array(
												'basic' => array(
													'label' => esc_html__( 'Basic', 'crafto-addons' ),
													'value' => array(
														array(
															'name' => esc_html__( 'Entire Website', 'crafto-addons' ),
															'value' => 'basic-global',
														),
														array(
															'name' => esc_html__( 'All Pages', 'crafto-addons' ),
															'value' => 'basic-page',
														),
														array(
															'name' => esc_html__( 'All Posts Single', 'crafto-addons' ),
															'value' => 'basic-single',
														),
														array(
															'name' => esc_html__( 'All Archives', 'crafto-addons' ),
															'value' => 'basic-archives',
														),
													),
												),
												'special-pages' => array(
													'label' => esc_html__( 'Special Pages', 'crafto-addons' ),
													'value' => $special_pages,
												),
											);

											foreach ( $selection_options as $group_key => $group ) {
												?>
												<!-- Group Header -->
												<option disabled><?php echo esc_html( $group['label'] ); ?></option>

												<!-- Group Options -->
												<?php
												foreach ( $group['value'] as $option ) {
													$selected = ( 'basic-global' === $option['value'] ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $option['name'] ); ?></option>
													<?php
												}
											}
											?>
											</select>
										</div>
									</div>
									<div class="footer-form-field input-field-control">
										<label for="themebuilder-footer-display-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-footer-display-style" class="themebuilder-form-field-footer-display-style crafto-dropdown-select2" name="footer_disple_template_style[]" required="required" multiple="multiple" style="width:99%;max-width:25em;">
											<?php
											$special_pages = array(
												array(
													'name' => esc_html__( 'Search Page', 'crafto-addons' ),
													'value' => 'special-search',
												),
												array(
													'name' => esc_html__( '404 Page', 'crafto-addons' ),
													'value' => 'special-not-found',
												),
												array(
													'name' => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
													'value' => 'special-blog',
												),
												array(
													'name' => esc_html__( 'Front Page', 'crafto-addons' ),
													'value' => 'special-front',
												),
											);

											if ( '1' !== $crafto_disable_portfolio ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Single', 'crafto-addons' ),
													'value' => 'special-portfolio-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Archive', 'crafto-addons' ),
													'value' => 'special-portfolio-archive',
												);
											}

											if ( '1' !== $crafto_disable_property ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Property Single', 'crafto-addons' ),
													'value' => 'special-property-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Property Archive', 'crafto-addons' ),
													'value' => 'special-property-archive',
												);
											}

											if ( '1' !== $crafto_disable_tours ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Single', 'crafto-addons' ),
													'value' => 'special-tours-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Archive', 'crafto-addons' ),
													'value' => 'special-tours-archive',
												);
											}

											if ( class_exists( 'WooCommerce' ) ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Products Single', 'crafto-addons' ),
													'value' => 'special-product-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Products Archive', 'crafto-addons' ),
													'value' => 'special-product-archive',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'WooCommerce Shop Page', 'crafto-addons' ),
													'value' => 'special-woo-shop',
												);
											}
											$selection_options = array(
												'basic' => array(
													'label' => esc_html__( 'Basic', 'crafto-addons' ),
													'value' => array(
														array(
															'name' => esc_html__( 'Entire Website', 'crafto-addons' ),
															'value' => 'basic-global',
														),
														array(
															'name' => esc_html__( 'All Pages', 'crafto-addons' ),
															'value' => 'basic-page',
														),
														array(
															'name' => esc_html__( 'All Posts Single', 'crafto-addons' ),
															'value' => 'basic-single',
														),
														array(
															'name' => esc_html__( 'All Archives', 'crafto-addons' ),
															'value' => 'basic-archives',
														),
													),
												),
												'special-pages' => array(
													'label' => esc_html__( 'Special Pages', 'crafto-addons' ),
													'value' => $special_pages,
												),
											);

											foreach ( $selection_options as $group_key => $group ) {
												?>
												<!-- Group Footer -->
												<option disabled><?php echo esc_html( $group['label'] ); ?></option>

												<!-- Group Options -->
												<?php
												foreach ( $group['value'] as $option ) {
													$selected = ( 'basic-global' === $option['value'] ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $option['name'] ); ?></option>
													<?php
												}
											}
											?>
											</select>
										</div>
									</div>
									<div class="custom-title-form-field input-field-control">
										<label for="themebuilder-custom-title-display-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-custom-title-display-style" class="themebuilder-form-field-custom-title-display-style crafto-dropdown-select2" name="custom_title_disple_template_style[]" required="required" multiple="multiple" style="width:99%;max-width:25em;">
											<?php
											$special_pages = array(
												array(
													'name' => esc_html__( 'Search Page', 'crafto-addons' ),
													'value' => 'special-search',
												),
												array(
													'name' => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
													'value' => 'special-blog',
												),
												array(
													'name' => esc_html__( 'Front Page', 'crafto-addons' ),
													'value' => 'special-front',
												),
											);

											if ( '1' !== $crafto_disable_portfolio ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Single', 'crafto-addons' ),
													'value' => 'special-portfolio-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Archive', 'crafto-addons' ),
													'value' => 'special-portfolio-archive',
												);
											}

											if ( '1' !== $crafto_disable_property ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Property Single', 'crafto-addons' ),
													'value' => 'special-property-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Property Archive', 'crafto-addons' ),
													'value' => 'special-property-archive',
												);
											}

											if ( '1' !== $crafto_disable_tours ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Single', 'crafto-addons' ),
													'value' => 'special-tours-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Archive', 'crafto-addons' ),
													'value' => 'special-tours-archive',
												);
											}

											if ( class_exists( 'WooCommerce' ) ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Products Single', 'crafto-addons' ),
													'value' => 'special-product-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Products Archive', 'crafto-addons' ),
													'value' => 'special-product-archive',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'WooCommerce Shop Page', 'crafto-addons' ),
													'value' => 'special-woo-shop',
												);
											}
											if ( class_exists( 'LearnPress' ) ) {
												$courses_page_id = learn_press_get_page_id( 'courses' );
												if ( $courses_page_id ) {
													$courses_page_slug = get_post_field( 'post_name', $courses_page_id );
													$special_pages[]   = array(
														'name' => esc_html__( 'Courses Archive', 'crafto-addons' ),
														'value' => $courses_page_slug,
													);
												}
											}
											$selection_options = array(
												'basic' => array(
													'label' => esc_html__( 'Basic', 'crafto-addons' ),
													'value' => array(
														array(
															'name' => esc_html__( 'Entire Website', 'crafto-addons' ),
															'value' => 'basic-global',
														),
														array(
															'name' => esc_html__( 'All Pages', 'crafto-addons' ),
															'value' => 'basic-page',
														),
														array(
															'name' => esc_html__( 'All Posts Single', 'crafto-addons' ),
															'value' => 'basic-single',
														),
														array(
															'name' => esc_html__( 'All Archives', 'crafto-addons' ),
															'value' => 'basic-archives',
														),
													),
												),
												'special-pages' => array(
													'label' => esc_html__( 'Special Pages', 'crafto-addons' ),
													'value' => $special_pages,
												),
											);

											foreach ( $selection_options as $group_key => $group ) {
												?>
												<!-- Group custom title -->
												<option disabled><?php echo esc_html( $group['label'] ); ?></option>

												<!-- Group Options -->
												<?php
												foreach ( $group['value'] as $option ) {
													$selected = ( 'basic-global' === $option['value'] ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $option['name'] ); ?></option>
													<?php
												}
											}
											?>
											</select>
										</div>
									</div>
									<div class="mini-header-form-field input-field-control">
										<label for="themebuilder-mini-header-display-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-mini-header-display-style" class="themebuilder-form-field-mini-header-display-style crafto-dropdown-select2" name="mini_header_disple_template_style[]" required="required" multiple="multiple" style="width:99%;max-width:25em;">
											<?php
											$special_pages = array(
												array(
													'name' => esc_html__( 'Search Page', 'crafto-addons' ),
													'value' => 'special-search',
												),
												array(
													'name' => esc_html__( 'Blog / Posts Page', 'crafto-addons' ),
													'value' => 'special-blog',
												),
												array(
													'name' => esc_html__( 'Front Page', 'crafto-addons' ),
													'value' => 'special-front',
												),
											);

											if ( '1' !== $crafto_disable_portfolio ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Single', 'crafto-addons' ),
													'value' => 'special-portfolio-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Portfolio Archive', 'crafto-addons' ),
													'value' => 'special-portfolio-archive',
												);
											}

											if ( '1' !== $crafto_disable_property ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Property Single', 'crafto-addons' ),
													'value' => 'special-property-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Property Archive', 'crafto-addons' ),
													'value' => 'special-property-archive',
												);
											}

											if ( '1' !== $crafto_disable_tours ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Single', 'crafto-addons' ),
													'value' => 'special-tours-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Tour Archive', 'crafto-addons' ),
													'value' => 'special-tours-archive',
												);
											}

											if ( class_exists( 'WooCommerce' ) ) {
												$special_pages[] = array(
													'name' => esc_html__( 'Products Single', 'crafto-addons' ),
													'value' => 'special-product-single',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'Products Archive', 'crafto-addons' ),
													'value' => 'special-product-archive',
												);
												$special_pages[] = array(
													'name' => esc_html__( 'WooCommerce Shop Page', 'crafto-addons' ),
													'value' => 'special-woo-shop',
												);
											}
											$selection_options = array(
												'basic' => array(
													'label' => esc_html__( 'Basic', 'crafto-addons' ),
													'value' => array(
														array(
															'name' => esc_html__( 'Entire Website', 'crafto-addons' ),
															'value' => 'basic-global',
														),
														array(
															'name' => esc_html__( 'All Pages', 'crafto-addons' ),
															'value' => 'basic-page',
														),
														array(
															'name' => esc_html__( 'All Posts Single', 'crafto-addons' ),
															'value' => 'basic-single',
														),
														array(
															'name' => esc_html__( 'All Archives', 'crafto-addons' ),
															'value' => 'basic-archives',
														),
													),
												),
												'special-pages' => array(
													'label' => esc_html__( 'Special Pages', 'crafto-addons' ),
													'value' => $special_pages,
												),
											);

											foreach ( $selection_options as $group_key => $group ) {
												?>
												<!-- Group custom title -->
												<option disabled><?php echo esc_html( $group['label'] ); ?></option>

												<!-- Group Options -->
												<?php
												foreach ( $group['value'] as $option ) {
													$selected = ( 'basic-global' === $option['value'] ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo esc_attr( $selected ); ?>><?php echo esc_html( $option['name'] ); ?></option>
													<?php
												}
											}
											?>
											</select>
										</div>
									</div>
									<div class="archive-form-field input-field-control">
										<label for="themebuilder-archive-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-archive-style" class="themebuilder-form-field-archive-style crafto-dropdown-select2" name="archive_style[]" multiple="multiple" style="width:99%;max-width:25em;">
												<?php
												$crafto_archive_style = self::crafto_get_archive_style_by_key();
												foreach ( $crafto_archive_style as $key => $value ) {
													$selected = ( 'general' === $key ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
														<?php echo esc_attr( $value ); ?>
													</option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
									<!-- Portfolio Archive -->
									<div class="archive-portfolio-form-field input-field-control">
										<label for="themebuilder-archive-portfolio-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-archive-portfolio-style" class="themebuilder-form-field-archive-portfolio-style crafto-dropdown-select2" name="archive_portfolio_style[]" multiple="multiple" style="width:99%;max-width:25em;">
												<?php
												$crafto_archive_portfolio_style = self::crafto_get_archive_portfolio_style_by_key();
												foreach ( $crafto_archive_portfolio_style as $key => $value ) {
													$selected = ( 'general' === $key ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
														<?php echo esc_html( $value ); ?>
													</option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
									<!-- Property Archive -->
									<div class="archive-property-form-field input-field-control">
										<label for="themebuilder-archive-property-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-archive-property-style" class="themebuilder-form-field-archive-property-style crafto-dropdown-select2" name="archive_property_style[]" multiple="multiple" style="width:99%;max-width:25em;">
												<?php
												$crafto_archive_property_style = self::crafto_get_archive_property_style_by_key();
												foreach ( $crafto_archive_property_style as $key => $value ) {
													$selected = ( 'general' === $key ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
														<?php echo esc_html( $value ); ?>
													</option>
													<?php
												}
												?>
											</select>
										</div>
									</div>

									<!-- Tour Archive -->
									<div class="archive-tours-form-field input-field-control">
										<label for="themebuilder-archive-tours-style" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Display On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-archive-tours-style" class="themebuilder-form-field-archive-tours-style crafto-dropdown-select2" name="archive_tours_style[]" multiple="multiple" style="width:99%;max-width:25em;">
												<?php
												$crafto_archive_tours_style = self::crafto_get_archive_tours_style_by_key();
												foreach ( $crafto_archive_tours_style as $key => $value ) {
													$selected = ( 'general' === $key ) ? ' selected="selected"' : '';
													?>
													<option value="<?php echo esc_attr( $key ); ?>"<?php echo esc_attr( $selected ); ?>>
														<?php echo esc_html( $value ); ?>
													</option>
													<?php
												}
												?>
											</select>
										</div>
									</div>
									<!-- Display on / Hide on for Single Post. -->
									<div class="single-form-field input-field-control">
										<label for="themebuilder-single-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Disaply On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-list" class="themebuilder-single-list crafto-dropdown-select2" name="specific_posts[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
									<div class="single-form-field input-field-control">
										<label for="themebuilder-single-exclude-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Hide On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-exclude-list" class="themebuilder-single-exclude-list crafto-dropdown-select2" name="specific_exclude_posts[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
									<!-- Display on / Hide on for Single Portfolio. -->
									<div class="single-portfolio-form-field input-field-control">
										<label for="themebuilder-single-portfolio-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Disaply On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-portfolio-list" class="themebuilder-single-portfolio-list crafto-dropdown-select2" name="specific_portfolio[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
									<div class="single-portfolio-form-field input-field-control">
										<label for="themebuilder-single-portfolio-exclude-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Hide On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-portfolio-exclude-list" class="themebuilder-single-portfolio-exclude-list crafto-dropdown-select2" name="specific_exclude_portfolio[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
									<!-- Display on / Hide on for Single Properties. -->
									<div class="single-properties-form-field input-field-control">
										<label for="themebuilder-single-properties-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Disaply On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-properties-list" class="themebuilder-single-properties-list crafto-dropdown-select2" name="specific_properties[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
									<div class="single-properties-form-field input-field-control">
										<label for="themebuilder-single-properties-exclude-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Hide On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-properties-exclude-list" class="themebuilder-single-properties-exclude-list crafto-dropdown-select2" name="specific_exclude_properties[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
									<!-- Display on / Hide on for Single Tours. -->
									<div class="single-tours-form-field input-field-control">
										<label for="themebuilder-single-tours-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Disaply On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-tours-list" class="themebuilder-single-tours-list crafto-dropdown-select2" name="specific_tours[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
									<div class="single-tours-form-field input-field-control">
										<label for="themebuilder-single-tours-exclude-list" class="themebuilder-new-template-form-label">
											<?php echo esc_html__( 'Hide On', 'crafto-addons' ); ?>
										</label>
										<div class="crafto-builder-form-select-wrap">
											<select id="themebuilder-single-tours-exclude-list" class="themebuilder-single-tours-exclude-list crafto-dropdown-select2" name="specific_exclude_tours[]" multiple="multiple" style="width:99%;max-width:25em;"></select>
										</div>
									</div>
								</div>
								<div class="themebuilder-form-field">
									<label for="themebuilder-new-template-form-post-title" class="themebuilder-new-template-form-label">
										<?php echo esc_html__( 'Template Name', 'crafto-addons' ); ?>
									</label>
									<input type="text" placeholder="<?php echo esc_attr__( 'Enter Template Name', 'crafto-addons' ); ?>" id="themebuilder-new-template-form-post-title" class="themebuilder-new-template-form-post-title required" name="themebuilder-new-template-post-title">
								</div>
								<button id="themebuilder-form-submit" class="create-template-button">
									<?php echo esc_html__( 'Create Template', 'crafto-addons' ); ?>
								</button>
							</form>
						</div>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * Crafto Get Posts List.
		 *
		 * @param string $crafto_post_type crafto post type slug.
		 */
		public static function crafto_get_posts_list_query( $crafto_post_type ) {
			global $wpdb;
			if ( 'post' === $crafto_post_type ) {
				$crafto_post_type_array = [];
				$custom_post_type       = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
				if ( ! empty( $custom_post_type ) ) {
					$crafto_post_type_array = wp_list_pluck( $custom_post_type, 'name' );
				}
				array_unshift( $crafto_post_type_array, 'post' );
				$placeholders = array_fill( 0, count( $crafto_post_type_array ), '%s' );

				// Prepare the SQL query using a prepared statement.
				$post_data = $wpdb->get_results( // phpcs:ignore
					$wpdb->prepare(
						" SELECT * FROM {$wpdb->posts} WHERE post_type IN (" . implode( ', ', $placeholders ) . ") AND post_status = 'publish' ORDER BY post_date DESC", $crafto_post_type_array // phpcs:ignore
					)
				);
			} else {
				// Prepare the SQL query using a prepared statement.
				$post_data = $wpdb->get_results( // phpcs:ignore
					$wpdb->prepare(
						"SELECT * FROM {$wpdb->posts} WHERE post_type = %s AND post_status = 'publish' ORDER BY post_date DESC",
						$crafto_post_type,
					)
				);
			}

			return $post_data;
		}

		/**
		 * Ajax callback to get all posts list in the template lightbox dropdown
		 */
		public static function crafto_get_posts_list_callback() {

			$crafto_post_type = ( isset( $_REQUEST['crafto_post_type'] ) && ! empty( $_REQUEST['crafto_post_type'] ) ) ? sanitize_key( $_REQUEST['crafto_post_type'] ) : 'post'; // phpcs:ignore

			// Define post type names in an associative array.
			$post_type_names = array(
				'post'       => esc_attr__( 'Posts', 'crafto-addons' ),
				'portfolio'  => esc_attr__( 'Portfolios', 'crafto-addons' ),
				'properties' => esc_attr__( 'Properties', 'crafto-addons' ),
				'tours'      => esc_attr__( 'Tours', 'crafto-addons' ),
			);

			$crafto_post_name = isset( $post_type_names[ $crafto_post_type ] ) ? $post_type_names[ $crafto_post_type ] : 'Post';

			$post_data = self::crafto_get_posts_list_query( $crafto_post_type );

			$crafto_post_type_array = [];
			$custom_post_type       = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
			if ( ! empty( $custom_post_type ) ) {
				$crafto_post_type_array = wp_list_pluck( $custom_post_type, 'name' );
				array_unshift( $crafto_post_type_array, 'post' );
			}

			// Start output buffering.
			ob_start();
			if ( ! empty( $post_data ) ) {
				// Output the "All Single" option.
				echo sprintf(
					'<option value="all-single" selected="selected">%1$s %2$s</option>',
					esc_html__( 'All Single', 'crafto-addons' ),
					esc_html( $crafto_post_name )
				);

				$custom_post_type = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
				if ( ! empty( $custom_post_type ) ) {
					foreach ( $custom_post_type as $post_type_name ) {

						$post_type_slug  = $post_type_name['name'];
						$post_type_label = $post_type_name['label'];

						echo '<option value="single-' . esc_html( $post_type_slug ) . '-all" >All Single ' . esc_html( $post_type_label ) . '</option>';
					}
				}

				// Output each post as an option.
				foreach ( $post_data as $value ) {
					printf(
						'<option value="%s">%s</option>',
						esc_attr( $value->ID ),
						esc_html( $value->post_title )
					);
				}
			}

			if ( 'post' === $crafto_post_type && empty( $crafto_post_type_array ) ) {
				$categories = get_categories(
					[
						'post_type' => $crafto_post_type,
					]
				);

				if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
					foreach ( $categories as $category ) {
						$post_count = $category->count < 10 ? '0' . $category->count : $category->count;
						printf(
							'<option value="%1$s">%2$s (%3$s)</option>',
							esc_attr( $category->term_id ),
							esc_attr__( 'Category: ', 'crafto-addons' ) . esc_html( $category->name ),
							esc_attr( $post_count ),
						);
					}
				}

				$tag_args = array(
					'taxonomy'   => 'post_tag',
					'hide_empty' => true,
					'orderby'    => 'name',
					'order'      => 'ASC',
				);

				$tags = get_tags( $tag_args );
				if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
					foreach ( $tags as $tag ) {
						$post_count = $tag->count < 10 ? '0' . $tag->count : $tag->count;
						printf(
							'<option value="%1$s">%2$s (%3$s)</option>',
							esc_attr( $tag->term_id ),
							esc_attr__( 'Tags: ', 'crafto-addons' ) . esc_html( $tag->name ),
							esc_attr( $post_count ),
						);
					}
				}
			} elseif ( 'post' === $crafto_post_type && ! empty( $crafto_post_type_array ) ) {
				$taxonomies_list = [];
				foreach ( $crafto_post_type_array as $post_type_single ) {
					$taxonomies = get_object_taxonomies( $post_type_single, 'objects' );
					if ( ! empty( $taxonomies ) ) {
						foreach ( $taxonomies as $taxonomies_array ) {
							if ( 'post_format' !== $taxonomies_array->name ) {
								$taxonomies_list[ $taxonomies_array->name ] = $taxonomies_array->label;
							}
						}
					}
				}
				$taxonomies_list = array_unique( $taxonomies_list ); // All taxonomies list array.

				if ( ! empty( $taxonomies_list ) ) {
					foreach ( $taxonomies_list as $taxonomies_term_slug => $taxonomies_term_label ) {
						$categories = get_terms(
							[
								'taxonomy'   => $taxonomies_term_slug,
								'hide_empty' => false,
							]
						);

						if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
							foreach ( $categories as $category ) {
								$post_count = $category->count < 10 ? '0' . $category->count : $category->count;
								printf(
									'<option value="%1$s">%2$s (%3$s)</option>',
									esc_attr( $category->term_id ),
									esc_attr( $taxonomies_term_label ) . ': ' . esc_html( $category->name ),
									esc_attr( $post_count ),
								);
							}
						}
					}
				}
			} elseif ( 'portfolio' === $crafto_post_type ) { // Portfolio Post Type.
				self::crafto_terms_list_html( 'portfolio-category', 'Category' );
				self::crafto_terms_list_html( 'portfolio-tags', 'Tags' );

			} elseif ( 'properties' === $crafto_post_type ) { // Properties Post Type.
				self::crafto_terms_list_html( 'properties-types', 'Property Types' );
				self::crafto_terms_list_html( 'properties-agents', 'Property Agent' );

			} elseif ( 'tours' === $crafto_post_type ) { // Tours Post Type.
				self::crafto_terms_list_html( 'tour-destination', 'Destination' );
				self::crafto_terms_list_html( 'tour-activity', 'Activities' );
			}

			$output = ob_get_contents();
			ob_end_clean();
			echo $output; // phpcs:ignore
			wp_die();
		}

		/**
		 * Ajax callback to get all posts list in the template lightbox dropdown
		 */
		public static function crafto_get_exclude_posts_list_callback() {

			$crafto_post_type = ( isset( $_REQUEST['crafto_post_type'] ) && ! empty( $_REQUEST['crafto_post_type'] ) ) ? sanitize_key( $_REQUEST['crafto_post_type'] ) : 'post'; // phpcs:ignore

			$post_data = self::crafto_get_posts_list_query( $crafto_post_type );

			// Start output buffering.
			ob_start();
			if ( ! empty( $post_data ) ) {
				// Output each post as an option.
				foreach ( $post_data as $value ) {
					printf(
						'<option value="%s">%s</option>',
						esc_attr( $value->ID ),
						esc_html( $value->post_title )
					);
				}
			}

			$output = ob_get_contents();
			ob_end_clean();
			echo $output; // phpcs:ignore
			wp_die();
		}

		/**
		 * Return all posts list and this function used in the meta dropdown list.
		 *
		 * @param string $crafto_post_type The type of posts to retrieve.
		 */
		public static function crafto_get_all_posts_list( $crafto_post_type = 'post' ) {

			// Define post type names in an associative array.
			$post_type_names = array(
				'post'       => esc_attr__( 'Posts', 'crafto-addons' ),
				'portfolio'  => esc_attr__( 'Portfolios', 'crafto-addons' ),
				'properties' => esc_attr__( 'Properties', 'crafto-addons' ),
				'tours'      => esc_attr__( 'Tours', 'crafto-addons' ),
			);

			$crafto_post_name = isset( $post_type_names[ $crafto_post_type ] ) ? $post_type_names[ $crafto_post_type ] : 'Post';

			$post_data = self::crafto_get_posts_list_query( $crafto_post_type );

			$crafto_post_type_array = [];
			$custom_post_type       = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
			if ( ! empty( $custom_post_type ) ) {
				$crafto_post_type_array = wp_list_pluck( $custom_post_type, 'name' );
				array_unshift( $crafto_post_type_array, 'post' );
			}

			// Initialize the array to hold post data.
			$post_arr = [];
			// If there are posts, populate the array.
			if ( ! empty( $post_data ) ) {
				$post_arr['all-single'] = sprintf( '%s %s', esc_attr__( 'All Single', 'crafto-addons' ), $crafto_post_name );

				$custom_post_type = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
				if ( ! empty( $custom_post_type ) ) {
					foreach ( $custom_post_type as $post_type_name ) {

						$post_type_slug  = $post_type_name['name'];
						$post_type_label = $post_type_name['label'];

						$custom_post_type_slug = 'single-' . esc_html( $post_type_slug ) . '-all';

						$post_arr[ $custom_post_type_slug ] = sprintf( '%s %s', esc_attr__( 'All Single', 'crafto-addons' ), esc_html( $post_type_label ) );
					}
				}

				foreach ( $post_data as $key => $value ) {
					$post_arr[ $value->ID ] = esc_html( $value->post_title );
				}

				if ( 'post' === $crafto_post_type && empty( $crafto_post_type_array ) ) {
					$categories = get_categories(
						[
							'post_type' => $crafto_post_type,
						]
					);

					if ( ! empty( $categories ) ) {
						foreach ( $categories as $category ) {
							$post_count                     = $category->count < 10 ? '0' . $category->count : $category->count;
							$post_arr[ $category->term_id ] = sprintf( '%1$s %2$s (%3$s)', esc_attr__( 'Category:', 'crafto-addons' ), $category->name, $post_count );
						}
					}

					$tag_args = array(
						'taxonomy'   => 'post_tag',
						'hide_empty' => true,
						'orderby'    => 'name',
						'order'      => 'ASC',
					);

					$tags = get_tags( $tag_args );
					if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) {
						foreach ( $tags as $tag ) {
							$post_count                = $tag->count < 10 ? '0' . $tag->count : $tag->count;
							$post_arr[ $tag->term_id ] = sprintf( '%1$s %2$s (%3$s)', esc_attr__( 'Tags:', 'crafto-addons' ), $tag->name, $post_count );
						}
					}
				} elseif ( 'post' === $crafto_post_type && ! empty( $crafto_post_type_array ) ) {
					$taxonomies_list = [];
					foreach ( $crafto_post_type_array as $post_type_single ) {
						$taxonomies = get_object_taxonomies( $post_type_single, 'objects' );
						if ( ! empty( $taxonomies ) ) {
							foreach ( $taxonomies as $taxonomies_array ) {
								if ( 'post_format' !== $taxonomies_array->name ) {
									$taxonomies_list[ $taxonomies_array->name ] = $taxonomies_array->label;
								}
							}
						}
					}
					$taxonomies_list = array_unique( $taxonomies_list ); // All taxonomies list array.

					if ( ! empty( $taxonomies_list ) ) {
						foreach ( $taxonomies_list as $taxonomies_term_slug => $taxonomies_term_label ) {
							$categories = get_terms(
								[
									'taxonomy'   => $taxonomies_term_slug,
									'hide_empty' => false,
								]
							);
							if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
								foreach ( $categories as $category ) {
									$post_arr[ $category->term_id ] = sprintf( '%1$s %2$s (%3$s)', $taxonomies_term_label . ':', $category->name, $category->term_id );
								}
							}
						}
					}
				} elseif ( 'portfolio' === $crafto_post_type ) {
					$post_arr = self::crafto_terms_list_id( 'portfolio-category', 'Category:', $post_arr );
					$post_arr = self::crafto_terms_list_id( 'portfolio-tags', 'Tags:', $post_arr );
				} elseif ( 'properties' === $crafto_post_type ) {
					$post_arr = self::crafto_terms_list_id( 'property-types', 'Property Types', $post_arr );
					$post_arr = self::crafto_terms_list_id( 'property-agents', 'Property Agents', $post_arr );
				} elseif ( 'tours' === $crafto_post_type ) {
					$post_arr = self::crafto_terms_list_id( 'tour-destination', 'Destination:', $post_arr );
					$post_arr = self::crafto_terms_list_id( 'tour-activity', 'Activities:', $post_arr );
				}
			}

			return $post_arr;
		}

		/**
		 * Return all posts list and this function used in the meta dropdown list.
		 *
		 * @param string $crafto_post_type The type of posts to retrieve.
		 */
		public static function crafto_get_all_posts_list_exclude( $crafto_post_type = 'post' ) {

			// Define post type names in an associative array.
			$post_type_names = array(
				'post'       => esc_attr__( 'Posts', 'crafto-addons' ),
				'portfolio'  => esc_attr__( 'Portfolios', 'crafto-addons' ),
				'properties' => esc_attr__( 'Properties', 'crafto-addons' ),
				'tours'      => esc_attr__( 'Tours', 'crafto-addons' ),
			);

			$post_data = self::crafto_get_posts_list_query( $crafto_post_type );

			// Initialize the array to hold post data.
			$post_arr = [];
			// If there are posts, populate the array.
			if ( ! empty( $post_data ) ) {
				foreach ( $post_data as $key => $value ) {
					$post_arr[ $value->ID ] = esc_html( $value->post_title );
				}
			}

			return $post_arr;
		}

		/**
		 * Return post template id
		 *
		 * @param string $template_key The key used to locate the template file.
		 *
		 * @param string $default The key used to default templates.
		 */
		public static function crafto_get_specific_item_template( $template_key = 'single', $default = 'all-single' ) {
			// Current Post, Portfolio, Property ID etc..
			$current_post_id   = get_the_ID();
			$current_post_type = get_post_type( $current_post_id );
			$post_type_name    = [ 'portfolio', 'tours', 'properties' ];

			if ( is_singular( $current_post_type ) && "single-{$current_post_type}" === $template_key && in_array( $current_post_type, $post_type_name, true ) ) {
				$meta_key         = "_crafto_template_specific_{$current_post_type}";
				$meta_key_exclude = "_crafto_template_specific_exclude_{$current_post_type}";
			} else {
				$meta_key         = '_crafto_template_specific_post';
				$meta_key_exclude = '_crafto_template_specific_exclude_post';
			}

			// Prepare the WP_Query arguments.
			$default_args = array(
				'post_type'      => 'themebuilder',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'no_found_rows'  => true,
			);

			$args = [
				'meta_query'     => [ // phpcs:ignore
					'relation' => 'AND',
					[
						'key'   => '_crafto_theme_builder_template',
						'value' => $template_key,
					],
					[
						'key'     => $meta_key,
						'value'   => sprintf( ':"%s";', $current_post_id ),
						'compare' => 'LIKE',
					],
				],
			];

			$args = array_merge( $default_args, $args );

			// Execute the query.
			$temp_query = new \WP_Query( $args );

			// Check if any posts were found.
			$temp_query1 = '';
			if ( $temp_query->have_posts() ) {
				foreach ( $temp_query->get_posts() as $post ) {
					return $post->ID;
				}
				wp_reset_postdata();
			} else {
				$taxonomies = get_object_taxonomies( get_post_type( $current_post_id ) );
				$all_terms  = [];
				foreach ( $taxonomies as $taxonomy ) {
					// Get the terms for each taxonomy.
					$terms = wp_get_post_terms( $current_post_id, $taxonomy );

					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						// Merge terms of each taxonomy into the $all_terms array.
						$all_terms = array_merge( $all_terms, $terms );
					}
				}

				$args1 = [];
				if ( ! empty( $all_terms ) ) {
					$term_arr = array( 'relation' => 'OR' );
					foreach ( $all_terms as $term ) {
						$termid     = $term->term_id;
						$term_arr[] = [
							'key'     => $meta_key,
							'value'   => sprintf( ':"%s";', $termid ),
							'compare' => 'LIKE',
						];
					}

					$args1 = [
						'meta_query' => [ // phpcs:ignore
							'relation' => 'AND',
							[
								'key'   => '_crafto_theme_builder_template',
								'value' => $template_key,
							],
							$term_arr,
						],
					];

					$args1 = array_merge( $default_args, $args1 );

					$temp_query1 = new \WP_Query( $args1 );
				}

				if ( ! empty( $temp_query1 ) && $temp_query1->have_posts() ) {
					foreach ( $temp_query1->get_posts() as $post ) {
						return $post->ID;
					}
				} else {
					// Check if a published "single-{post_type}-all" template exists.
					$published_specific_all = get_posts(
						[
							'post_type'      => 'themebuilder',
							'post_status'    => 'publish',
							'posts_per_page' => 1,
							// phpcs:ignore
							'meta_query'     => [
								[
									'key'   => '_crafto_theme_builder_template',
									'value' => $template_key,
								],
								[
									'key'     => $meta_key,
									'value'   => sprintf( ':"single-%s-all";', $current_post_type ),
									'compare' => 'LIKE',
								],
							],
						]
					);

					// Use published specific-all if exists.
					if ( ! empty( $published_specific_all ) ) {
						return $published_specific_all[0]->ID;
					}

					// If there's a draft one, stop — don't use all-single fallback.
					$draft_specific_all = get_posts(
						[
							'post_type'      => 'themebuilder',
							'post_status'    => [ 'draft', 'pending' ],
							'posts_per_page' => 1,
							// phpcs:ignore
							'meta_query'     => [
								[
									'key'   => '_crafto_theme_builder_template',
									'value' => $template_key,
								],
								[
									'key'     => $meta_key,
									'value'   => sprintf( ':"single-%s-all";', $current_post_type ),
									'compare' => 'LIKE',
								],
							],
						]
					);

					if ( ! empty( $draft_specific_all ) ) {
						return '0';
					}

					// If no draft or published "single-{post_type}-all", try "all-single".
					$args2 = [
						// phpcs:ignore
						'meta_query' => [
							'relation' => 'AND',
							[
								'key'   => '_crafto_theme_builder_template',
								'value' => $template_key,
							],
							[
								'key'     => $meta_key,
								'value'   => ':"all-single";',
								'compare' => 'LIKE',
							],
						],
					];

					$args2       = array_merge( $default_args, $args2 );
					$temp_query2 = new \WP_Query( $args2 );

					if ( $temp_query2->have_posts() ) {
						foreach ( $temp_query2->get_posts() as $post ) {
							$excluded = get_post_meta( $post->ID, $meta_key_exclude, true );
							if ( ! empty( $excluded ) ) {
								$is_exclude = in_array( (string) $current_post_id, $excluded, true );
								if ( false === $is_exclude ) {
									return $post->ID;
								}
							} else {
								return $post->ID;
							}
						}
					}
				}

				wp_reset_postdata();
			}

			return '0'; // Return '0' if no post is found.
		}

		/**
		 * Return single post template id
		 *
		 * @param string $template_key The key used to locate the template file.
		 */
		public static function crafto_get_exists_single_template( $template_key = 'single' ) {
			// Prepare the WP_Query arguments.
			$temp_query = new \WP_Query(
				[
					'post_type'      => 'themebuilder',
					'post_status'    => 'publish',
					'posts_per_page' => 1,
					'orderby'        => 'date',
					'order'          => 'DESC',
					'no_found_rows'  => true,
					'meta_query'     => [ // phpcs:ignore
						'relation' => 'AND',
						[
							'key'   => '_crafto_theme_builder_template',
							'value' => $template_key,
						],
					],
				]
			);

			if ( $temp_query->have_posts() ) {
				foreach ( $temp_query->get_posts() as $post ) {
					return $post->ID;
				}
				wp_reset_postdata();
			} else {
				return '0';
			}
		}

		/**
		 * Return term lists
		 *
		 * @param string $taxonomy Custom taxonomy slug.
		 *
		 * @param string $label Label in the lists.
		 */
		public static function crafto_terms_list_html( $taxonomy, $label ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => true,
				)
			);

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$post_count = $term->count < 10 ? '0' . $term->count : $term->count;
					printf(
						'<option value="%1$s">%2$s (%3$s)</option>',
						esc_attr( $term->term_id ),
						esc_attr( $label ) . ' ' . esc_html( $term->name ),
						esc_attr( $post_count ),
					);
				}
			}
		}

		/**
		 * Return term id
		 *
		 * @param string $taxonomy Custom taxonomy slug.
		 * @param string $label Label in the lists.
		 * @param mixd   $post_arr term list.
		 */
		public static function crafto_terms_list_id( $taxonomy, $label, $post_arr ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => true,
				)
			);

			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$post_count                 = $term->count < 10 ? '0' . $term->count : $term->count;
					$post_arr[ $term->term_id ] = sprintf( '%1$s %2$s (%3$s)', esc_attr( $label ), $term->name, $post_count );
				}
			}

			return $post_arr;
		}
	}

	new Crafto_Builder_Helper();
}
