<?php
/**
 * Crafto Addons Extra Functions.
 *
 * @package Crafto
 */

use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If class `Crafto_Addons_Extra_Functions` doesn't exists yet.
if ( ! class_exists( 'Crafto_Addons_Extra_Functions' ) ) {

	/**
	 * Define `Crafto_Addons_Extra_Functions` class
	 */
	class Crafto_Addons_Extra_Functions {

		/**
		 * Constructor
		 */
		public function __construct() {
			$this->crafto_init();

			add_action( 'admin_bar_menu', array( $this, 'crafto_admin_bar_menu' ), 98 );
			add_filter( 'upload_mimes', array( $this, 'crafto_allow_mime_types' ) );
			add_action( 'wp_head', array( $this, 'crafto_addressbar_color_wp_head_meta' ) );

			add_action( 'init', array( $this, 'crafto_clear_cache_data' ), 20 );
			add_action( 'admin_init', array( $this, 'crafto_clear_cache_data' ), 20 );
			add_action( 'init', array( $this, 'crafto_custom_post_type_unregister' ), 20 );
			add_action( 'elementor/widgets/register', array( $this, 'crafto_unregister_widgets' ), 16 );
			add_action( 'wp_footer', array( $this, 'crafto_promo_popup' ) );
			add_action( 'wp_footer', array( $this, 'crafto_side_icon' ), -2 );
			add_action( 'wp_footer', array( $this, 'crafto_custom_page_cursor' ), -3 );
			add_filter( 'body_class', array( $this, 'crafto_custom_cursor' ) );

			add_action( 'crafto_attr_body', array( $this, 'crafto_mobile_nav_body_attributes' ) );
			add_action( 'wp_head', array( $this, 'crafto_mobile_nav_body_attr_elementor_preview' ) );
			add_action( 'crafto_before_register_style_js', array( __CLASS__, 'crafto_before_register_style_js_callback' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'crafto_additional_js_output' ), 999 );
			add_action( 'customize_register', array( $this, 'crafto_customizer_settings' ), 100 );
			add_action( 'admin_print_footer_scripts', [ $this, 'crafto_inline_js' ] );

			add_action( 'customize_save', array( $this, 'crafto_customize_save' ) );
			add_action( 'customize_controls_init', array( $this, 'crafto_customize_preview_init' ) );
			add_action( 'wp_ajax_crafto_save_mega_menu_settings', array( $this, 'crafto_save_mega_menu_settings' ) );
			add_action( 'wp_ajax_crafto_add_user_to_mailchimp_list', array( $this, 'crafto_add_user_to_mailchimp_list' ) );
			add_action( 'wp_ajax_nopriv_crafto_add_user_to_mailchimp_list', array( $this, 'crafto_add_user_to_mailchimp_list' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'crafto_admin_dequeue_scripts' ), 999 );

			add_filter( 'elementor/controls/hover_animations/additional_animations', array( $this, 'crafto_additional_hover_animations' ) );
			add_action( 'elementor/shapes/additional_shapes', array( $this, 'crafto_additional_shapes_render' ) );

			add_action( 'wp_ajax_crafto_live_search', array( $this, 'crafto_live_search' ) );
			add_action( 'wp_ajax_nopriv_crafto_live_search', array( $this, 'crafto_live_search' ) );

			add_action( 'wp_ajax_crafto_simple_live_search', array( $this, 'crafto_simple_live_search' ) );
			add_action( 'wp_ajax_nopriv_crafto_simple_live_search', array( $this, 'crafto_simple_live_search' ) );

			add_action( 'pre_get_posts', array( $this, 'crafto_multiple_post_type_search' ) );
			add_action( 'wp_footer', array( $this, 'crafto_addons_theme_registered_scripts' ) );

			add_action( 'wp_ajax_crafto_update_mime_support', array( $this, 'crafto_update_mime_support' ) );

			if ( is_revolution_slider_activated() ) {
				add_action( 'enqueue_block_editor_assets', array( $this, 'crafto_revslider_gutenberg_cgb_editor_assets' ) );
				add_action( 'template_redirect', array( $this, 'crafto_remove_revslider_inline_script' ) );
				add_action( 'wp_enqueue_scripts', array( $this, 'crafto_enqueue_script_styles_rev_slider' ) );
			}

			if ( is_contact_form_7_activated() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'crafto_dequeue_script_styles_contact_form7' ), 20 );
				add_action( 'elementor/frontend/widget/before_render', array( $this, 'crafto_load_script_styles_contact_form7' ) );
			}

			if ( is_woocommerce_activated() ) {
				add_filter( 'woocommerce_settings_pages', array( $this, 'crafto_wishlist_page_option' ) );
				add_filter( 'display_post_states', array( $this, 'crafto_wishlist_change_post_state' ), 10, 2 );
				add_action( 'customize_register', array( $this, 'crafto_change_woocommerce_panel_priorities' ) );
				add_filter( 'gettext', array( $this, 'crafto_woo_cart_coupon_button_text' ), 10, 3 );

				add_filter(
					'woocommerce_breadcrumb_defaults',
					function ( $defaults ) {
						$defaults['delimiter'] = ''; // removes delimiter.
						return $defaults; // returns rest of links.
					}
				);
			}

			if ( class_exists( 'LearnPress' ) ) {
				add_filter(
					'learn-press/course/html-image',
					function ( $section, $course ) {
						// Get the course ID.
						$course_id = $course->get_id();

						// Fetch a custom image URL (Replace this with your logic).
						// $custom_image_url = get_post_meta( $course_id, '_custom_course_image', true );.

						// If no custom image is set, use the default LearnPress image.
						$post_thumbnail_url = get_the_post_thumbnail_url( $course_id, 'full' );

						// Modify the content with the dynamic image.
						if ( $post_thumbnail_url ) {
							$section['content'] = '<img src="' . esc_url( $post_thumbnail_url ) . '" alt="' . esc_attr( get_the_title( $course_id ) ) . '">';
						}

						return $section;
					},
					10,
					2
				);

				// Error: Rest not logged in error.
				if ( class_exists( 'Give' ) ) {
					add_action( 'wp_footer', array( $this, 'crafto_givewp_wp_json' ) );
				}

				if ( is_woocommerce_activated() ) {
					add_filter( 'woocommerce_layered_nav_count_maybe_cache', '__return_false' );
				}
			}
		}

		/**
		 * Get Post Content.
		 */
		public static function crafto_get_the_post_content() {
			/**
			 * Apply filters to change post/page content
			 *
			 * @since 1.0
			 */
			return apply_filters( 'the_content', get_the_content() );
		}

		/**
		 * Change the priority of the WooCommerce panel in the WordPress Customizer.
		 *
		 * This function checks if the WooCommerce panel exists in the Customizer, and if it does,
		 * it changes the panel's priority to 12, ensuring the panel appears in a specific position
		 * relative to other panels in the Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize The Customizer manager object.
		 */
		public function crafto_change_woocommerce_panel_priorities( $wp_customize ) {
			if ( null !== $wp_customize->get_panel( 'woocommerce' ) ) {
				$wp_customize->get_panel( 'woocommerce' )->priority = 12;
			}
		}

		/**
		 * Crafto get addon/theme all script list.
		 */
		public function crafto_addons_theme_registered_scripts() {
			global $wp_scripts;
			if ( ! isset( $wp_scripts ) ) {
				return [];
			}

			$script_handles = [];
			foreach ( $wp_scripts->registered as $handle => $script ) {
				if ( strpos( $script->src, 'wp-content/plugins/crafto-addons/' ) !== false ) {
					$formatted_handle = str_replace( '-', ' ', $handle );
					$formatted_handle = ucwords( $formatted_handle );
					$formatted_handle = str_replace( ' ', ' ', $formatted_handle );

					// Add to the array with the formatted handle as the key and the title as the value.
					$script_handles[ $handle ] = esc_html( $formatted_handle );
				}
			}
			foreach ( $wp_scripts->registered as $handle => $script ) {
				if ( strpos( $script->src, 'wp-content/themes/crafto/' ) !== false ) {
					$formatted_handle = str_replace( '-', ' ', $handle );
					$formatted_handle = ucwords( $formatted_handle );
					$formatted_handle = str_replace( ' ', ' ', $formatted_handle );

					// Add to the array with the formatted handle as the key and the title as the value.
					$script_handles[ $handle ] = esc_html( $formatted_handle );
				}
			}

			$exclude_js_keys = [
				'crafto-customizer-preview',
				'crafto-customizer-woo-preview',
				'crafto-gutenberg-block',
				'crafto-googleapis',
			];

			/**
			 * Apply filters for exclude js from the async if user dont want to asynchronous.
			 *
			 * @since 1.0
			 */
			$exclude_js_keys_list = apply_filters( 'crafto_exclude_js_from_async', $exclude_js_keys );

			$script_handles = array_diff_key( $script_handles, array_flip( $exclude_js_keys_list ) );

			set_transient( 'crafto_addon_theme_js_lists', $script_handles, 0 );
		}

		/**
		 * Check revolution widget is in page or not.
		 */
		public function crafto_is_revslider_used() {
			global $post;

			// Check if the Revolution Slider shortcode is in post content.
			if ( ! empty( $post->post_content ) && has_shortcode( $post->post_content, 'rev_slider' ) ) {
				return true;
			}

			// Check if RevSlider widget is active.
			if ( function_exists( 'is_active_widget' ) && is_active_widget( false, false, 'revslider_widget', true ) ) {
				return true;
			}

			// Check if RevSlider is loaded via global function.
			if ( function_exists( 'setRevStart' ) ) {
				return true;
			}

			// Check if Elementor is used and includes the RevSlider widget.
			if ( is_elementor_activated() ) {
				$document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
				if ( $document && $document->is_built_with_elementor() ) {
					$elements = $document->get_elements_data();
					foreach ( $elements as $element ) {
						if ( ! empty( $element['widgetType'] ) && 'slider_revolution' === $element['widgetType'] ) {
							return true;
						}
					}
				}
			}

			return false;
		}

		/**
		 * Remove revolution slider inline scripts.
		 */
		public function crafto_remove_revslider_inline_script() {
			// Only run on frontend.
			if ( is_admin() || ( is_elementor_activated() && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
				return;
			}

			// If RevSlider is not used, remove inline scripts.
			if ( ! $this->crafto_is_revslider_used() ) {
				ob_start( function ( $content ) {
					// Remove any <script> that contains either SR7. or rs_adminBarToolBarTopFunction.
					return preg_replace_callback( '/<script\b[^>]*>(.*?)<\/script>/is', function ( $matches ) {
						if (
							strpos( $matches[1], 'SR7.' ) !== false ||
							strpos( $matches[1], 'rs_adminBarToolBarTopFunction' ) !== false
						) {
							return '';
						}
						return $matches[0];
					}, $content );
				} );
			}
		}

		/**
		 * Load Revolution Slider scripts and styles in the Revolution Slider Widget.
		 */
		public function crafto_enqueue_script_styles_rev_slider() {

			if ( is_admin() || ( is_elementor_activated() && \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
				return;
			}

			if ( wp_style_is( 'sr7css', 'enqueued' ) ) {
				wp_dequeue_style( 'sr7css' );
			}

			if ( wp_script_is( 'sr7', 'enqueued' ) ) {
				wp_dequeue_script( 'sr7' );
			}

			$post_id = get_the_ID();

			// Get Elementor data from post meta.
			$elementor_data = get_post_meta( $post_id, '_elementor_data', true );

			if ( ! empty( $elementor_data ) && strpos( $elementor_data, 'slider_revolution' ) !== false ) {
				wp_enqueue_style( 'sr7css-css', plugins_url( 'revslider/public/css/sr7.css' ), [], null );
				wp_enqueue_script( 'sr7-js', plugins_url( 'revslider/public/js/sr7.js' ), [ 'jquery' ], null, true );
			}
		}

		/**
		 * Dequeue Contact Form 7 plugin styles and scripts.
		 *
		 * This function removes the Contact Form 7 styles and scripts from.
		 * being loaded on the front end, which can help optimize performance.
		 * if the forms are not used on certain pages.
		 */
		public function crafto_dequeue_script_styles_contact_form7() {
			if ( ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				// Check if the styles and scripts are enqueued before dequeuing.
				if ( wp_style_is( 'contact-form-7', 'enqueued' ) ) {
					wp_dequeue_style( 'contact-form-7' );
				}

				if ( wp_script_is( 'contact-form-7', 'enqueued' ) ) {
					wp_dequeue_script( 'contact-form-7' );
				}
			}
		}

		/**
		 * Load Contact Form 7 scripts and styles in the Contact Form 7 Widget.
		 *
		 * This function checks if the widget is of type 'crafto-contact-form'.
		 * and enqueues the necessary scripts and styles for Contact Form 7.
		 *
		 * @param mixed $widget The widget instance containing settings.
		 */
		public function crafto_load_script_styles_contact_form7( $widget ) {
			// Check if the widget is a Contact Form 7 widget.
			if ( 'crafto-contact-form' !== $widget->get_name() ) {
				return; // Early return for better readability.
			}

			// Enqueue Contact Form 7 scripts and styles if the functions exist.
			if ( function_exists( 'wpcf7_enqueue_scripts' ) ) {
				wpcf7_enqueue_scripts();
			}

			if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
				wpcf7_enqueue_styles();
			}
		}

		/**
		 * Wishlist page change post state
		 *
		 * @param string[] $post_states An array of post display states.
		 * @param WP_Post  $post        The current post object.
		 */
		public function crafto_wishlist_change_post_state( $post_states, $post ) {
			$crafto_wishlist_id = get_option( 'woocommerce_wishlist_page_id' );

			if ( $crafto_wishlist_id === $post->ID ) {
				$post_states['crafto_wishlist_page'] = esc_html__( 'Wishlist Page', 'crafto-addons' );
			}

			return $post_states;
		}

		/**
		 * Set Wishlist Page.
		 *
		 * @param mixed $settings Settings.
		 */
		public function crafto_wishlist_page_option( $settings ) {
			$wishlist_page_settings = [];

			$wishlist_page_settings[] = array(
				'title'    => esc_html__( 'Wishlist page', 'crafto-addons' ),
				'id'       => 'woocommerce_wishlist_page_id',
				'type'     => 'single_select_page',
				'default'  => '',
				'class'    => 'wc-enhanced-select-nostd',
				'css'      => 'min-width:300px;',
				'desc_tip' => esc_html__( 'This sets the base page of your wishlist.', 'crafto-addons' ),
			);

			array_splice( $settings, 5, 0, $wishlist_page_settings );
			
			return $settings;
		}

		/**
		 * Hooks used in theme
		 */
		public function crafto_init() {
			$crafto_used_hooks = [
				[
					'name'  => esc_html__( 'Before Body', 'crafto-addons' ),
					'value' => 'crafto_before_body_content',
				],
				[
					'name'  => esc_html__( 'After Body', 'crafto-addons' ),
					'value' => 'crafto_after_body_content',
				],
				[
					'name'  => esc_html__( 'Before Header', 'crafto-addons' ),
					'value' => 'crafto_before_header',
				],
				[
					'name'  => esc_html__( 'After Header', 'crafto-addons' ),
					'value' => 'crafto_after_header',
				],
				[
					'name'  => esc_html__( 'Before Footer', 'crafto-addons' ),
					'value' => 'crafto_before_footer',
				],
				[
					'name'  => esc_html__( 'After Footer', 'crafto-addons' ),
					'value' => 'crafto_after_footer',
				],
				[
					'name'  => esc_html__( 'Before Main Content Wrap', 'crafto-addons' ),
					'value' => 'crafto_before_main_content_wrap',
				],
				[
					'name'  => esc_html__( 'After Main Content Wrap', 'crafto-addons' ),
					'value' => 'crafto_after_main_content_wrap',
				],
				[
					'name'  => esc_html__( 'Before Blog Single', 'crafto-addons' ),
					'value' => 'crafto_before_single',
				],
				[
					'name'  => esc_html__( 'After Blog Single', 'crafto-addons' ),
					'value' => 'crafto_after_single',
				],
				[
					'name'  => esc_html__( 'Before Portfolio Single', 'crafto-addons' ),
					'value' => 'crafto_before_single_portfolio',
				],
				[
					'name'  => esc_html__( 'After Portfolio Single', 'crafto-addons' ),
					'value' => 'crafto_after_single_portfolio',
				],
				[
					'name'  => esc_html__( 'Before Property Single', 'crafto-addons' ),
					'value' => 'crafto_before_single_property',
				],
				[
					'name'  => esc_html__( 'After Property Single', 'crafto-addons' ),
					'value' => 'crafto_after_single_property',
				],
				[
					'name'  => esc_html__( 'Before Tour Single', 'crafto-addons' ),
					'value' => 'crafto_before_single_tours',
				],
				[
					'name'  => esc_html__( 'After Tour Single', 'crafto-addons' ),
					'value' => 'crafto_after_single_tours',
				],
				[
					'name'  => esc_html__( 'Before Post Default Blog/Home', 'crafto-addons' ),
					'value' => 'crafto_before_post_default',
				],
				[
					'name'  => esc_html__( 'After Post Default Blog/Home', 'crafto-addons' ),
					'value' => 'crafto_after_post_default',
				],
				[
					'name'  => esc_html__( 'Before Post Archive', 'crafto-addons' ),
					'value' => 'crafto_before_post_archive',
				],
				[
					'name'  => esc_html__( 'After Post Archive', 'crafto-addons' ),
					'value' => 'crafto_after_post_archive',
				],
				[
					'name'  => esc_html__( 'Before Portfolio Archive', 'crafto-addons' ),
					'value' => 'crafto_before_portfolio_archive',
				],
				[
					'name'  => esc_html__( 'After Portfolio Archive', 'crafto-addons' ),
					'value' => 'crafto_after_portfolio_archive',
				],
				[
					'name'  => esc_html__( 'Before Property Archive', 'crafto-addons' ),
					'value' => 'crafto_before_property_archive',
				],
				[
					'name'  => esc_html__( 'After Property Archive', 'crafto-addons' ),
					'value' => 'crafto_after_property_archive',
				],
				[
					'name'  => esc_html__( 'Before Tour Archive', 'crafto-addons' ),
					'value' => 'crafto_before_tours_archive',
				],
				[
					'name'  => esc_html__( 'After Tour Archive', 'crafto-addons' ),
					'value' => 'crafto_after_tours_archive',
				],
			];

			if ( isset( $_GET['crafto_hooks'] ) ) { // phpcs:ignore
				foreach ( $crafto_used_hooks as $hook ) {
					add_action(
						$hook['value'],
						function () use ( $hook ) {
							$this->crafto_display_hook_info( $hook );
						}
					);
				}
			}
		}

		/**
		 * Outputs the hook information.
		 *
		 * @param array $hook The hook information.
		 */
		private function crafto_display_hook_info( $hook ) {
			echo '<div style="background: #fce8ba; padding: 8px; border-radius: 4px; margin: 4px; align-self: center; color: black; font-size: 14px; font-weight: 600; line-height: 20px; text-align: center; border: 2px dashed #feba09;">' .
				esc_html( $hook['name'] ) .
				' <i style="font-size:12px;font-weight:normal;line-height:20px;" title="' . esc_attr__( 'Hook name to use in PHP', 'crafto-addons' ) . '">' .
				' (' . esc_html( $hook['value'] ) . ')</i></div>';
		}

		/**
		 * Add menu item in Admin bar
		 *
		 * @param object $admin_bar Array of menus.
		 */
		public function crafto_admin_bar_menu( $admin_bar ) {
			// Early return if not administrator.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$admin_bar->add_menu(
				array(
					'id'    => 'crafto-adminbar-item',
					'title' => esc_html__( 'Crafto Settings', 'crafto-addons' ),
					'href'  => admin_url( 'admin.php?page=crafto-theme-setup' ),
				)
			);

			if ( ! is_admin() ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-adminbar-item',
						'id'     => 'crafto-hooks',
						'title'  => esc_html__( 'Show Crafto Hooks', 'crafto-addons' ),
						'href'   => '?crafto_hooks=true',
					)
				);
			}

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-header-and-footer',
					'title'  => esc_html__( 'Header & Footer', 'crafto-addons' ),
					'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=header' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-page-title',
					'title'  => esc_html__( 'Page Title', 'crafto-addons' ),
					'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=custom-title' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-popup-view',
					'title'  => esc_html__( 'Popup', 'crafto-addons' ),
					'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=promo_popup' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-archive-all',
					'title'  => esc_html__( 'Archive', 'crafto-addons' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-archive-all',
					'id'     => 'crafto-archive',
					'title'  => esc_html__( 'Post Archive ( Blog, Author, Category, Search, etc... )', 'crafto-addons' ),
					'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=archive' ),
				)
			);

			if ( '0' === get_theme_mod( 'crafto_disable_portfolio', '0' ) ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-archive-all',
						'id'     => 'crafto-archive-portfolio',
						'title'  => esc_html__( 'Portfolio Archive', 'crafto-addons' ),
						'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=archive-portfolio' ),
					)
				);
			}

			if ( '0' === get_theme_mod( 'crafto_disable_property', '0' ) ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-archive-all',
						'id'     => 'crafto-archive-property',
						'title'  => esc_html__( 'Property Archive', 'crafto-addons' ),
						'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=archive-property' ),
					)
				);
			}

			if ( '0' === get_theme_mod( 'crafto_disable_tours', '0' ) ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-archive-all',
						'id'     => 'crafto-archive-tours',
						'title'  => esc_html__( 'Tour Archive', 'crafto-addons' ),
						'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=archive-tours' ),
					)
				);
			}

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-single-all',
					'title'  => esc_html__( 'Single', 'crafto-addons' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-single-all',
					'id'     => 'crafto-single',
					'title'  => esc_html__( 'Post Single', 'crafto-addons' ),
					'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=single' ),
				)
			);

			if ( '0' === get_theme_mod( 'crafto_disable_portfolio', '0' ) ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-single-all',
						'id'     => 'crafto-single-portfolio',
						'title'  => esc_html__( 'Portfolio Single', 'crafto-addons' ),
						'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=single-portfolio' ),
					)
				);
			}

			if ( '0' === get_theme_mod( 'crafto_disable_property', '0' ) ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-single-all',
						'id'     => 'crafto-single-property',
						'title'  => esc_html__( 'Property Single', 'crafto-addons' ),
						'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=single-properties' ),
					)
				);
			}

			if ( '0' === get_theme_mod( 'crafto_disable_tours', '0' ) ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-single-all',
						'id'     => 'crafto-single-tours',
						'title'  => esc_html__( 'Tour Single', 'crafto-addons' ),
						'href'   => admin_url( 'edit.php?post_type=themebuilder&template_type=single-tours' ),
					)
				);
			}

			if ( is_woocommerce_activated() ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-adminbar-item',
						'id'     => 'crafto-woocommerce',
						'title'  => esc_html__( 'WooCommerce', 'crafto-addons' ),
						'href'   => admin_url( 'customize.php?autofocus%5Bpanel%5D=woocommerce' ),
					)
				);
			}

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-custom-css',
					'title'  => esc_html__( 'Custom CSS', 'crafto-addons' ),
					'href'   => admin_url( 'customize.php?autofocus%5Bsection%5D=custom_css' ),
				)
			);
			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-custom-js',
					'title'  => esc_html__( 'Custom JS', 'crafto-addons' ),
					'href'   => admin_url( 'customize.php?autofocus%5Bsection%5D=crafto_custom_js' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-maintenance-mode',
					'title'  => esc_html__( 'Maintenance Mode', 'crafto-addons' ),
					'href'   => admin_url( 'admin.php?page=elementor-tools#tab-maintenance_mode' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-performance',
					'title'  => esc_html__( 'Perfomance Manager', 'crafto-addons' ),
					'href'   => admin_url( 'customize.php?autofocus%5Bsection%5D=crafto_add_perfomance_panel' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-general-settings',
					'title'  => esc_html__( 'Advanced Theme Options', 'crafto-addons' ),
					'href'   => admin_url( 'customize.php?autofocus%5Bpanel%5D=crafto_add_general_panel' ),
				)
			);

			$admin_bar->add_menu(
				array(
					'parent' => 'crafto-adminbar-item',
					'id'     => 'crafto-system-info',
					'title'  => esc_html__( 'System Info', 'crafto-addons' ),
					'href'   => admin_url( 'site-health.php?tab=debug' ),
					'meta'   => array(
						'target' => '_blank',
					),
				)
			);

			if ( ! is_admin() ) {
				$admin_bar->add_menu(
					array(
						'parent' => 'crafto-adminbar-item',
						'id'     => 'crafto-reset-temporary-data',
						'title'  => esc_html__( 'Clear Temporary Data', 'crafto-addons' ),
						'href'   => '?crafto_reset_temporary_data=true',
					)
				);
			}
		}

		/**
		 * Add crafto clear cache data
		 */
		public function crafto_clear_cache_data() {
			// Early return if not administrator.
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			if ( ! is_admin() ) {
				if ( isset( $_GET['crafto_reset_temporary_data'] ) ) { // phpcs:ignore
					if ( is_multisite() ) {
						// Deletes the temporary library cache option from the database.
						delete_site_option( 'crafto_temp_library_cache' );
					}

					// Deletes the temporary library cache option from the database.
					delete_option( 'crafto_temp_library_cache' );
					// Deletes the stored transient containing the remote theme version.
					delete_transient( 'theme_remote_version' );

					// Deletes the stored transient containing the local_google_fonts and fonts css files.
					if ( is_elementor_activated() ) {
						delete_option( '_elementor_local_google_fonts' );
						\Elementor\Core\Files\Fonts\Google_Font::clear_cache();
					}
				}
			}
		}

		/**
		 * Add meta tags for address bar color.
		 */
		public function crafto_addressbar_color_wp_head_meta() {
			$crafto_addressbar_color = get_theme_mod( 'crafto_addressbar_color', '' );

			if ( ! empty( $crafto_addressbar_color ) ) {
				// Meta tag for Chrome, Firefox OS, Opera.
				echo '<meta name="theme-color" content="' . $crafto_addressbar_color . '">' . PHP_EOL; // phpcs:ignore
				// Meta tag for Windows Phone.
				echo '<meta name="msapplication-navbutton-color" content="' . $crafto_addressbar_color . '">' . PHP_EOL; // phpcs:ignore
			}

			// Check for Internet Explorer and set compatibility mode.
			if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) ) { // phpcs:ignore
				echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />' . PHP_EOL;
			}
		}

		/**
		 * Allow to support MIME Type.
		 *
		 * @param array $mimes MIME Type.
		 */
		public function crafto_allow_mime_types( $mimes ) {
			$crafto_svg_support = get_theme_mod( 'crafto_svg_support', '0' );

			if ( '1' === $crafto_svg_support ) {
				$mimes['svg']  = 'image/svg+xml';
				$mimes['svgz'] = 'image/svg+xml';
			}

			$crafto_font_support = get_theme_mod( 'crafto_font_support', '0' );
			if ( '1' === $crafto_font_support ) {
				$mimes['ttf']   = 'font/ttf';
				$mimes['woff']  = 'font/woff';
				$mimes['woff2'] = 'font/woff2';
				$mimes['eot']   = 'application/vnd.ms-fontobject';

				/**
				 * Allow additional MIME types through filter.
				 *
				 * @since 1.0
				 * @param array $mimes MIME types array.
				 */
				$mimes = apply_filters( 'crafto_font_allow_mime_types', $mimes );
			}

			return $mimes;
		}

		/**
		 * Crafto font support set value.
		 */
		public function crafto_update_mime_support() {
			if ( isset( $_POST['crafto_font_support'] ) ) { // phpcs:ignore
				$crafto_font_support = sanitize_text_field( $_POST['crafto_font_support'] ); // phpcs:ignore
				// Update the theme mod.
				set_theme_mod( 'crafto_font_support', $crafto_font_support );

				wp_send_json_success(
					[
						'font_support' => $crafto_font_support,
					]
				);
			}
		}

		/**
		 * Return custom additional hover animations effects.
		 *
		 * @return array List of hover animations.
		 */
		public static function crafto_additional_hover_animations() {
			return [
				'float-2px'       => esc_html__( 'Crafto Float Two Up', 'crafto-addons' ),
				'float-3px'       => esc_html__( 'Crafto Float Three Up', 'crafto-addons' ),
				'float-5px'       => esc_html__( 'Crafto Float Five Up', 'crafto-addons' ),
				'float-10px'      => esc_html__( 'Crafto Float Ten Up', 'crafto-addons' ),
				'btn-slide-up'    => esc_html__( 'Crafto Button Slide Up', 'crafto-addons' ),
				'btn-slide-down'  => esc_html__( 'Crafto Button Slide Down', 'crafto-addons' ),
				'btn-slide-left'  => esc_html__( 'Crafto Button Slide Left', 'crafto-addons' ),
				'btn-slide-right' => esc_html__( 'Crafto Button Slide Right', 'crafto-addons' ),
				'btn-switch-icon' => esc_html__( 'Crafto Button Switch Icon', 'crafto-addons' ),
				'btn-switch-text' => esc_html__( 'Crafto Button Switch Text', 'crafto-addons' ),
				'btn-reveal-icon' => esc_html__( 'Crafto Button Reveal Icon', 'crafto-addons' ),
			];
		}

		/**
		 * Return crafto custom button hover animations.
		 *
		 * @return array Array of button hover animation classes.
		 */
		public static function crafto_custom_hover_animation_effect() {
			$btn_hvr_animation_arr = [
				'btn-slide-up',
				'btn-slide-down',
				'btn-slide-left',
				'btn-slide-right',
				'btn-switch-icon',
				'btn-switch-text',
				'btn-reveal-icon',
			];

			/**
			 * Apply filters to button hover animation effect.
			 *
			 * @since 1.0
			 * @param array $btn_hvr_animation_arr Array of button hover animations.
			 */
			return apply_filters( 'crafto_button_hover_animation', $btn_hvr_animation_arr );
		}

		/**
		 * Deregister and dequeue styles/scripts.
		 */
		public static function crafto_before_register_style_js_callback() {
			// Remove Elementor's imagesLoaded JS library.
			wp_deregister_script( 'imagesloaded' );
			wp_dequeue_script( 'imagesloaded' );

			// Remove Elementor's Swiper JS library.
			wp_deregister_script( 'swiper' );
			wp_dequeue_script( 'swiper' );

			// Remove Elementor's Swiper CSS library.
			wp_deregister_style( 'swiper' );
			wp_dequeue_style( 'swiper' );

			$font_awesome_styles = [
				'elementor-icons-shared-0',
				'elementor-icons-fa-regular',
				'elementor-icons-fa-brands',
				'elementor-icons-fa-solid',
			];

			foreach ( $font_awesome_styles as $style ) {
				wp_deregister_style( $style );
				wp_dequeue_style( $style );
			}
		}

		/**
		 * Return template content.
		 *
		 * @param mixed $template_id Get template content.
		 * @return string|null The content of the template or null if not found.
		 */
		public static function crafto_get_builder_content_for_display( $template_id ) {
			// Check if Elementor is loaded.
			if ( ! class_exists( 'Elementor\Plugin' ) ) {
				return null; // Return null for consistency.
			}

			// Ensure the template ID is provided.
			if ( empty( $template_id ) ) {
				return null; // Return null if the ID is not valid.
			}

			$template_content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $template_id );

			return $template_content;
		}

		/**
		 * Check elementor edit mode.
		 */
		public static function is_crafto_elementor_editor_preview_mode() {
			// Check if Elementor is active.
			if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
				return;
			}

			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				return true;
			}
			
			return false;
		}

		/**
		 * Check elementor edit mode.
		 */
		public static function crafto_editor_load_compressed_assets() {
			// Check if Elementor is active.
			if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
				return false;
			}

			/**
			 * Filter to modify load_compressed_assets
			 *
			 * @since 1.0
			 */
			$crafto_load_compressed_assets = apply_filters( 'crafto_load_compressed_assets_editor', true );

			if ( $crafto_load_compressed_assets && ( \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() ) ) {
				return true;
			}
			
			return false;
		}

		/**
		 * Return crafto slider breakpoint issue
		 *
		 * @param mixed $breakpoint Get breakpoint for slider.
		 */
		public static function crafto_slider_breakpoints( $breakpoint ) {
			/* START slider breakpoints */
			$crafto_slides_to_show              = ( isset( $breakpoint->get_settings( 'crafto_slides_to_show' )['size'] ) && $breakpoint->get_settings( 'crafto_slides_to_show' )['size'] ) ? $breakpoint->get_settings( 'crafto_slides_to_show' )['size'] : '';
			$crafto_items_spacing               = ( isset( $breakpoint->get_settings( 'crafto_items_spacing' )['size'] ) && $breakpoint->get_settings( 'crafto_items_spacing' )['size'] ) ? $breakpoint->get_settings( 'crafto_items_spacing' )['size'] : '';
			$crafto_slides_to_show_widescreen   = ( isset( $breakpoint->get_settings( 'crafto_slides_to_show_widescreen' )['size'] ) && $breakpoint->get_settings( 'crafto_slides_to_show_widescreen' )['size'] ) ? $breakpoint->get_settings( 'crafto_slides_to_show_widescreen' )['size'] : '';
			$crafto_items_spacing_widescreen    = ( isset( $breakpoint->get_settings( 'crafto_items_spacing_widescreen' )['size'] ) && $breakpoint->get_settings( 'crafto_items_spacing_widescreen' )['size'] ) ? $breakpoint->get_settings( 'crafto_items_spacing_widescreen' )['size'] : '';
			$crafto_slides_to_show_laptop       = ( isset( $breakpoint->get_settings( 'crafto_slides_to_show_laptop' )['size'] ) && $breakpoint->get_settings( 'crafto_slides_to_show_laptop' )['size'] ) ? $breakpoint->get_settings( 'crafto_slides_to_show_laptop' )['size'] : '';
			$crafto_items_spacing_laptop        = ( isset( $breakpoint->get_settings( 'crafto_items_spacing_laptop' )['size'] ) && $breakpoint->get_settings( 'crafto_items_spacing_laptop' )['size'] ) ? $breakpoint->get_settings( 'crafto_items_spacing_laptop' )['size'] : '';
			$crafto_slides_to_show_tablet_extra = ( isset( $breakpoint->get_settings( 'crafto_slides_to_show_tablet_extra' )['size'] ) && $breakpoint->get_settings( 'crafto_slides_to_show_tablet_extra' )['size'] ) ? $breakpoint->get_settings( 'crafto_slides_to_show_tablet_extra' )['size'] : '';
			$crafto_items_spacing_tablet_extra  = ( isset( $breakpoint->get_settings( 'crafto_items_spacing_tablet_extra' )['size'] ) && $breakpoint->get_settings( 'crafto_items_spacing_tablet_extra' )['size'] ) ? $breakpoint->get_settings( 'crafto_items_spacing_tablet_extra' )['size'] : '';
			$crafto_slides_to_show_tablet       = ( isset( $breakpoint->get_settings( 'crafto_slides_to_show_tablet' )['size'] ) && $breakpoint->get_settings( 'crafto_slides_to_show_tablet' )['size'] ) ? $breakpoint->get_settings( 'crafto_slides_to_show_tablet' )['size'] : '';
			$crafto_items_spacing_tablet        = ( isset( $breakpoint->get_settings( 'crafto_items_spacing_tablet' )['size'] ) && $breakpoint->get_settings( 'crafto_items_spacing_tablet' )['size'] ) ? $breakpoint->get_settings( 'crafto_items_spacing_tablet' )['size'] : '';
			$crafto_slides_to_show_mobile_extra = ( isset( $breakpoint->get_settings( 'crafto_slides_to_show_mobile_extra' )['size'] ) && $breakpoint->get_settings( 'crafto_slides_to_show_mobile_extra' )['size'] ) ? $breakpoint->get_settings( 'crafto_slides_to_show_mobile_extra' )['size'] : '';
			$crafto_items_spacing_mobile_extra  = ( isset( $breakpoint->get_settings( 'crafto_items_spacing_mobile_extra' )['size'] ) && $breakpoint->get_settings( 'crafto_items_spacing_mobile_extra' )['size'] ) ? $breakpoint->get_settings( 'crafto_items_spacing_mobile_extra' )['size'] : '';
			$crafto_slides_to_show_mobile       = ( isset( $breakpoint->get_settings( 'crafto_slides_to_show_mobile' )['size'] ) && $breakpoint->get_settings( 'crafto_slides_to_show_mobile' )['size'] ) ? $breakpoint->get_settings( 'crafto_slides_to_show_mobile' )['size'] : '';
			$crafto_items_spacing_mobile        = ( isset( $breakpoint->get_settings( 'crafto_items_spacing_mobile' )['size'] ) && $breakpoint->get_settings( 'crafto_items_spacing_mobile' )['size'] ) ? $breakpoint->get_settings( 'crafto_items_spacing_mobile' )['size'] : '';
			$auto_slide                         = $breakpoint->get_settings( 'crafto_slide_width_auto' );

			/*
			 * Slide to Show for Mobile Portrait.
			 */
			if ( ! empty( $crafto_slides_to_show_mobile ) ) {
				$crafto_slides_to_show_mobile = $crafto_slides_to_show_mobile;
			} elseif ( ! empty( $crafto_slides_to_show_mobile_extra ) ) {
				$crafto_slides_to_show_mobile = $crafto_slides_to_show_mobile_extra;
			} elseif ( ! empty( $crafto_slides_to_show_tablet ) ) {
				$crafto_slides_to_show_mobile = $crafto_slides_to_show_tablet;
			} elseif ( ! empty( $crafto_slides_to_show_tablet_extra ) ) {
				$crafto_slides_to_show_mobile = $crafto_slides_to_show_tablet_extra;
			} elseif ( ! empty( $crafto_slides_to_show_laptop ) ) {
				$crafto_slides_to_show_mobile = $crafto_slides_to_show_laptop;
			} elseif ( ! empty( $crafto_slides_to_show_widescreen ) ) {
				$crafto_slides_to_show_mobile = $crafto_slides_to_show_widescreen;
			} else {
				$crafto_slides_to_show_mobile = $crafto_slides_to_show;
			}

			/*
			 * Item Spacing for Mobile Portrait.
			 */
			if ( ! empty( $crafto_items_spacing_mobile ) ) {
				$crafto_items_spacing_mobile = $crafto_items_spacing_mobile;
			} elseif ( ! empty( $crafto_items_spacing_mobile_extra ) ) {
				$crafto_items_spacing_mobile = $crafto_items_spacing_mobile_extra;
			} elseif ( ! empty( $crafto_items_spacing_tablet ) ) {
				$crafto_items_spacing_mobile = $crafto_items_spacing_tablet;
			} elseif ( ! empty( $crafto_items_spacing_tablet_extra ) ) {
				$crafto_items_spacing_mobile = $crafto_items_spacing_tablet_extra;
			} elseif ( ! empty( $crafto_items_spacing_laptop ) ) {
				$crafto_items_spacing_mobile = $crafto_items_spacing_laptop;
			} elseif ( ! empty( $crafto_items_spacing_widescreen ) ) {
				$crafto_items_spacing_mobile = $crafto_items_spacing_widescreen;
			} else {
				$crafto_items_spacing_mobile = $crafto_items_spacing;
			}

			/*
			 * Slide to Show for Mobile Landscape.
			 */
			if ( ! empty( $crafto_slides_to_show_mobile_extra ) ) {
				$crafto_slides_to_show_mobile_extra = $crafto_slides_to_show_mobile_extra;
			} elseif ( ! empty( $crafto_slides_to_show_tablet ) ) {
				$crafto_slides_to_show_mobile_extra = $crafto_slides_to_show_tablet;
			} elseif ( ! empty( $crafto_slides_to_show_tablet_extra ) ) {
				$crafto_slides_to_show_mobile_extra = $crafto_slides_to_show_tablet_extra;
			} elseif ( ! empty( $crafto_slides_to_show_laptop ) ) {
				$crafto_slides_to_show_mobile_extra = $crafto_slides_to_show_laptop;
			} elseif ( ! empty( $crafto_slides_to_show_widescreen ) ) {
				$crafto_slides_to_show_mobile_extra = $crafto_slides_to_show_widescreen;
			} else {
				$crafto_slides_to_show_mobile_extra = $crafto_slides_to_show;
			}

			/*
			 * Item Spacing for Mobile Landscape.
			 */
			if ( ! empty( $crafto_items_spacing_mobile_extra ) ) {
				$crafto_items_spacing_mobile_extra = $crafto_items_spacing_mobile_extra;
			} elseif ( ! empty( $crafto_items_spacing_tablet ) ) {
				$crafto_items_spacing_mobile_extra = $crafto_items_spacing_tablet;
			} elseif ( ! empty( $crafto_items_spacing_tablet_extra ) ) {
				$crafto_items_spacing_mobile_extra = $crafto_items_spacing_tablet_extra;
			} elseif ( ! empty( $crafto_items_spacing_laptop ) ) {
				$crafto_items_spacing_mobile_extra = $crafto_items_spacing_laptop;
			} elseif ( ! empty( $crafto_items_spacing_widescreen ) ) {
				$crafto_items_spacing_mobile_extra = $crafto_items_spacing_widescreen;
			} else {
				$crafto_items_spacing_mobile_extra = $crafto_items_spacing;
			}

			/*
			 * End Mobile Portrait & Landscape
			 */

			/*
			 * Slide to Show for Tablet Portrait.
			 */
			if ( ! empty( $crafto_slides_to_show_tablet ) ) {
				$crafto_slides_to_show_tablet = $crafto_slides_to_show_tablet;
			} elseif ( ! empty( $crafto_slides_to_show_tablet_extra ) ) {
				$crafto_slides_to_show_tablet = $crafto_slides_to_show_tablet_extra;
			} elseif ( ! empty( $crafto_slides_to_show_laptop ) ) {
				$crafto_slides_to_show_tablet = $crafto_slides_to_show_laptop;
			} elseif ( ! empty( $crafto_slides_to_show_widescreen ) ) {
				$crafto_slides_to_show_tablet = $crafto_slides_to_show_widescreen;
			} else {
				$crafto_slides_to_show_tablet = $crafto_slides_to_show;
			}

			// Item Spacing for Tablet Portrait.
			if ( ! empty( $crafto_items_spacing_tablet ) ) {
				$crafto_items_spacing_tablet = $crafto_items_spacing_tablet;
			} elseif ( ! empty( $crafto_items_spacing_tablet_extra ) ) {
				$crafto_items_spacing_tablet = $crafto_items_spacing_tablet_extra;
			} elseif ( ! empty( $crafto_items_spacing_laptop ) ) {
				$crafto_items_spacing_tablet = $crafto_items_spacing_laptop;
			} elseif ( ! empty( $crafto_items_spacing_widescreen ) ) {
				$crafto_items_spacing_tablet = $crafto_items_spacing_widescreen;
			} else {
				$crafto_items_spacing_tablet = $crafto_items_spacing;
			}

			/*
			 * Slide to Show for Tablet Landscape.
			 */
			if ( ! empty( $crafto_slides_to_show_tablet_extra ) ) {
				$crafto_slides_to_show_tablet_extra = $crafto_slides_to_show_tablet_extra;
			} elseif ( ! empty( $crafto_slides_to_show_laptop ) ) {
				$crafto_slides_to_show_tablet_extra = $crafto_slides_to_show_laptop;
			} elseif ( ! empty( $crafto_slides_to_show_widescreen ) ) {
				$crafto_slides_to_show_tablet_extra = $crafto_slides_to_show_widescreen;
			} else {
				$crafto_slides_to_show_tablet_extra = $crafto_slides_to_show;
			}

			/*
			 * Item Spacing for Tablet Landscape.
			 */
			if ( ! empty( $crafto_items_spacing_tablet_extra ) ) {
				$crafto_items_spacing_tablet_extra = $crafto_items_spacing_tablet_extra;
			} elseif ( ! empty( $crafto_items_spacing_laptop ) ) {
				$crafto_items_spacing_tablet_extra = $crafto_items_spacing_laptop;
			} elseif ( ! empty( $crafto_items_spacing_widescreen ) ) {
				$crafto_items_spacing_tablet_extra = $crafto_items_spacing_widescreen;
			} else {
				$crafto_items_spacing_tablet_extra = $crafto_items_spacing;
			}

			/*
			 * End Tablet Portrait & Landscape
			 */

			/*
			 * Slide to Show for Laptop
			 */
			if ( ! empty( $crafto_slides_to_show_laptop ) ) {
				$crafto_slides_to_show_laptop = $crafto_slides_to_show_laptop;
			} elseif ( ! empty( $crafto_slides_to_show_widescreen ) ) {
				$crafto_slides_to_show_laptop = $crafto_slides_to_show_widescreen;
			} else {
				$crafto_slides_to_show_laptop = $crafto_slides_to_show;
			}

			/*
			 * Item Spacing for Laptop
			 */
			if ( ! empty( $crafto_items_spacing_laptop ) ) {
				$crafto_items_spacing_laptop = $crafto_items_spacing_laptop;
			} elseif ( ! empty( $crafto_items_spacing_widescreen ) ) {
				$crafto_items_spacing_laptop = $crafto_items_spacing_widescreen;
			} else {
				$crafto_items_spacing_laptop = $crafto_items_spacing;
			}

			/*
			 * End Laptop
			 */

			/*
			 * Slide to Show for Widescreen
			 */
			if ( ! empty( $crafto_slides_to_show_widescreen ) ) {
				$crafto_slides_to_show_widescreen = $crafto_slides_to_show_widescreen;
			} else {
				$crafto_slides_to_show_widescreen = $crafto_slides_to_show;
			}

			/*
			 * Item Spacing for Widescreen
			 */
			if ( ! empty( $crafto_items_spacing_widescreen ) ) {
				$crafto_items_spacing_widescreen = $crafto_items_spacing_widescreen;
			} else {
				$crafto_items_spacing_widescreen = $crafto_items_spacing;
			}

			/*
			 * End Widescreen
			 */

			if ( 'slider-width-auto' === $auto_slide ) {
				$crafto_slides_to_show              = 'auto';
				$crafto_slides_to_show_widescreen   = 'auto';
				$crafto_slides_to_show_laptop       = 'auto';
				$crafto_slides_to_show_mobile       = 'auto';
				$crafto_slides_to_show_mobile_extra = 'auto';
				$crafto_slides_to_show_tablet       = 'auto';
				$crafto_slides_to_show_tablet_extra = 'auto';
				$crafto_items_spacing               = '';
				$crafto_items_spacing_widescreen    = '';
				$crafto_items_spacing_laptop        = '';
				$crafto_items_spacing_tablet_extra  = '';
				$crafto_items_spacing_tablet        = '';
				$crafto_items_spacing_mobile_extra  = '';
				$crafto_items_spacing_mobile        = '';
			}

			if ( 'slide' === $breakpoint->get_settings( 'crafto_effect' ) || null === $breakpoint->get_settings( 'crafto_effect' ) ) {
				$slider_viewport = array(
					'crafto_slides_to_show'              => $crafto_slides_to_show,
					'crafto_slides_to_show_widescreen'   => $crafto_slides_to_show_widescreen,
					'crafto_slides_to_show_laptop'       => $crafto_slides_to_show_laptop,
					'crafto_slides_to_show_mobile'       => $crafto_slides_to_show_mobile,
					'crafto_slides_to_show_mobile_extra' => $crafto_slides_to_show_mobile_extra,
					'crafto_slides_to_show_tablet'       => $crafto_slides_to_show_tablet,
					'crafto_slides_to_show_tablet_extra' => $crafto_slides_to_show_tablet_extra,
					'crafto_items_spacing'               => $crafto_items_spacing,
					'crafto_items_spacing_widescreen'    => $crafto_items_spacing_widescreen,
					'crafto_items_spacing_laptop'        => $crafto_items_spacing_laptop,
					'crafto_items_spacing_tablet_extra'  => $crafto_items_spacing_tablet_extra,
					'crafto_items_spacing_tablet'        => $crafto_items_spacing_tablet,
					'crafto_items_spacing_mobile_extra'  => $crafto_items_spacing_mobile_extra,
					'crafto_items_spacing_mobile'        => $crafto_items_spacing_mobile,
				);
			} else {
				$slider_viewport = array(
					'crafto_slides_to_show'              => 1,
					'crafto_slides_to_show_widescreen'   => 1,
					'crafto_slides_to_show_laptop'       => 1,
					'crafto_slides_to_show_mobile'       => 1,
					'crafto_slides_to_show_mobile_extra' => 1,
					'crafto_slides_to_show_tablet'       => 1,
					'crafto_slides_to_show_tablet_extra' => 1,
					'crafto_items_spacing'               => '',
					'crafto_items_spacing_widescreen'    => '',
					'crafto_items_spacing_laptop'        => '',
					'crafto_items_spacing_tablet_extra'  => '',
					'crafto_items_spacing_tablet'        => '',
					'crafto_items_spacing_mobile_extra'  => '',
					'crafto_items_spacing_mobile'        => '',
				);
			}

			return $slider_viewport;
		}

		/**
		 * Return taxonomy title option.
		 *
		 * @param string $option Meta key.
		 * @param mixed  $default_value Default meta value.
		 * @return mixed Taxonomy title option value.
		 */
		public static function crafto_taxonomy_title_option( $option, $default_value ) {
			$crafto_option_value = '';

			$crafto_t_id = ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || ( is_woocommerce_activated() && ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_tax( 'product_brand' ) ) ) || is_category() || is_tag() ) ? get_queried_object()->term_id : get_query_var( 'cat' );

			$value = get_term_meta( $crafto_t_id, $option, true );

			if ( strlen( $value ) > 0 && ( 'default' !== $value ) && ( is_category() || is_tag() || is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || ( is_woocommerce_activated() && ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_tax( 'product_brand' ) ) ) ) && ! ( is_author() || is_search() ) ) {
				$crafto_option_value = $value;
			} else {
				$crafto_option_value = get_theme_mod( $option, $default_value );
			}

			return $crafto_option_value;
		}

		/**
		 * Add mobile navigation body data attributes.
		 *
		 * @param array $attributes Add attributes.
		 * @return array Modified attributes.
		 */
		public function crafto_mobile_nav_body_attributes( $attributes ) {
			// Retrieve header section ID and styles.
			$crafto_header_section_id            = function_exists( 'crafto_header_section_id' ) ? crafto_header_section_id() : '';
			$crafto_header_style                 = crafto_theme_builder_meta_data( $crafto_header_section_id, 'crafto_template_header_style', '' );
			$crafto_header_style                 = ( ! empty( $crafto_header_style ) ) ? $crafto_header_style : 'standard';
			$crafto_header_mobile_menu_style     = crafto_theme_builder_meta_data( $crafto_header_section_id, 'crafto_header_mobile_menu_style', '' );
			$crafto_header_mobile_menu_alignment = crafto_theme_builder_meta_data( $crafto_header_section_id, 'crafto_header_mobile_menu_trigger_alignment', '' );
			$crafto_header_mobile_menu_bg_color  = crafto_theme_builder_meta_data( $crafto_header_section_id, 'crafto_header_mobile_menu_bg_color', '' );
			$crafto_header_mobile_menu_bg_image  = crafto_theme_builder_meta_data( $crafto_header_section_id, 'crafto_header_mobile_menu_bg_image', '' );
			$crafto_header_mobile_menu_bg_image  = wp_get_attachment_url( $crafto_header_mobile_menu_bg_image );

			// Set attributes if header style is standard.
			if ( 'standard' === $crafto_header_style ) {
				$attributes['data-mobile-nav-style']             = ( ! empty( $crafto_header_mobile_menu_style ) ) ? $crafto_header_mobile_menu_style : 'classic';
				$attributes['data-mobile-nav-trigger-alignment'] = ( ! empty( $crafto_header_mobile_menu_alignment ) ) ? $crafto_header_mobile_menu_alignment : 'left';

				if ( $crafto_header_mobile_menu_bg_color ) {
					$attributes['data-mobile-nav-bg-color'] = $crafto_header_mobile_menu_bg_color;
				}

				if ( $crafto_header_mobile_menu_bg_image ) {
					$attributes['data-mobile-nav-bg-image'] = $crafto_header_mobile_menu_bg_image;
				}
			}

			return $attributes;
		}

		/**
		 * Add mobile navigation body data attributes in Elementor preview.
		 */
		public function crafto_mobile_nav_body_attr_elementor_preview() {
			if ( ! is_singular( 'themebuilder' ) ) {
				return;
			}

			$crafto_header_section_id            = crafto_builder_option( 'crafto_header_section', '' );
			$crafto_header_style                 = get_post_meta( $crafto_header_section_id, '_crafto_template_header_style', true );
			$crafto_header_style                 = ( ! empty( $crafto_header_style ) ) ? $crafto_header_style : 'standard';
			$crafto_header_mobile_menu_style     = get_post_meta( $crafto_header_section_id, '_crafto_header_mobile_menu_style', true );
			$crafto_header_mobile_menu_alignment = get_post_meta( $crafto_header_section_id, '_crafto_header_mobile_menu_trigger_alignment', true );
			$crafto_header_mobile_menu_bg_color  = get_post_meta( $crafto_header_section_id, '_crafto_header_mobile_menu_bg_color', true );
			$crafto_header_mobile_menu_bg_image  = get_post_meta( $crafto_header_section_id, '_crafto_header_mobile_menu_bg_image', true );

			$crafto_header_mobile_menu_style     = ( ! empty( $crafto_header_mobile_menu_style ) ) ? $crafto_header_mobile_menu_style : 'classic';
			$crafto_header_mobile_menu_alignment = ( ! empty( $crafto_header_mobile_menu_alignment ) ) ? $crafto_header_mobile_menu_alignment : 'left';

			if ( 'standard' === $crafto_header_style ) {
				?>
				<script type="text/javascript">
					( function( $ ) {
						setTimeout( function () {
							$( 'body' ).attr( { 'data-mobile-nav-style': '<?php echo sprintf( '%s', $crafto_header_mobile_menu_style ); // phpcs:ignore ?>', 'data-mobile-nav-trigger-alignment': '<?php echo sprintf( '%s', $crafto_header_mobile_menu_alignment ); // phpcs:ignore ?>', 'data-mobile-nav-bg-color': '<?php echo sprintf( '%s', $crafto_header_mobile_menu_bg_color ); // phpcs:ignore ?>', 'crafto-header-mobile-menu-bg-image': '<?php echo sprintf( '%s', $crafto_header_mobile_menu_bg_image ); // phpcs:ignore ?>'} );
						}, 1000 );
					})( jQuery );
				</script>
				<?php
			}
		}

		/**
		 * AJAX callback to save mega menu settings
		 */
		public function crafto_save_mega_menu_settings() {
			// Check user permissions.
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error(
					array(
						'message' => esc_html__( 'You are not allowed to do this', 'crafto-addons' ),
					)
				);
			}

			// Get the current menu item ID.
			$current_menu_item_id = ( isset( $_POST['current_menu_itemt_id'] ) ) ? absint( $_POST['current_menu_itemt_id'] ) : false; // phpcs:ignore

			if ( ! $current_menu_item_id ) {
				wp_send_json_error(
					array(
						'message' => esc_html__( 'Incorrect input data', 'crafto-addons' ),
					)
				);
			}

			$enable_mega_submenu = isset( $_POST['enable_mega_submenu'] ) ? $_POST['enable_mega_submenu'] : false; // phpcs:ignore
			update_post_meta( $current_menu_item_id, '_enable_mega_submenu', $enable_mega_submenu );

			$disable_megamenu_link = isset( $_POST['disable_megamenu_link'] ) ? $_POST['disable_megamenu_link'] : false; // phpcs:ignore
			update_post_meta( $current_menu_item_id, '_disable_megamenu_link', $disable_megamenu_link );

			// List of fields to update.
			$fields_to_update = array(
				'_mega_menu_style'          => isset( $_POST['select_mega_menu'] ) ? $_POST['select_mega_menu'] : NULL, // phpcs:ignore
				'_megamenu_hover_color'     => isset( $_POST['crafto_megamenu_hover_color'] ) ? $_POST['crafto_megamenu_hover_color'] : NULL, // phpcs:ignore
				'_menu_item_icon'           => isset( $_POST['menu-item-icon'] ) ? $_POST['menu-item-icon'] : NULL, // phpcs:ignore
				'_menu_item_icon_position'  => isset( $_POST['menu-item-icon-position'] ) ? $_POST['menu-item-icon-position'] : 'before', // phpcs:ignore
				'_menu_item_svg_icon_image' => isset( $_POST['upload_field'] ) ? $_POST['upload_field'] : NULL, // phpcs:ignore
				'_menu_item_label'          => isset( $_POST['menu-item-label'] ) ? $_POST['menu-item-label'] : NULL, // phpcs:ignore
				'_menu_item_label_color'    => isset( $_POST['menu-item-label-color'] ) ? $_POST['menu-item-label-color'] : NULL, // phpcs:ignore
				'_menu_item_label_bg_color' => isset( $_POST['menu-item-label-bg-color'] ) ? $_POST['menu-item-label-bg-color'] : NULL, // phpcs:ignore
			);
			// Update post meta for each field.
			foreach ( $fields_to_update as $meta_key => $meta_value ) {
				if ( NULL !== $meta_value ) {
					update_post_meta( $current_menu_item_id, $meta_key, $meta_value );
				}
			}

			wp_send_json_success(
				array(
					'message' => esc_html__( 'Success!', 'crafto-addons' ),
				)
			);
			wp_die(); // Properly terminate the AJAX request.
		}

		/**
		 * Customize - Save custom fonts
		 */
		public function crafto_customize_save() {
			$filesystem = Crafto_filesystem::init_filesystem();
			$upload_dir = wp_upload_dir();
			$base_dir   = wp_normalize_path( untrailingslashit( $upload_dir['basedir'] ) );
			$srcdir     = wp_normalize_path( $base_dir . '/crafto-fonts/crafto-temp-fonts' );

			// Validate that the directory is within uploads/crafto-fonts.
			$fonts_dir = $base_dir . '/crafto-fonts';
			if ( strpos( $srcdir, $fonts_dir ) === 0 && is_dir( $srcdir ) ) {
				$filesystem->delete( $srcdir, FS_CHMOD_DIR );
			}
		}

		/**
		 * Customize - Create folder for custom fonts.
		 */
		public function crafto_customize_preview_init() {
			$theme_custom_fonts = get_theme_mod( 'crafto_custom_fonts', '' );
			$theme_custom_fonts = ! empty( $theme_custom_fonts ) ? json_decode( $theme_custom_fonts ) : array();

			if ( is_array( $theme_custom_fonts ) && ! empty( $theme_custom_fonts ) ) {
				foreach ( $theme_custom_fonts as $key => $fonts ) {
					if ( ! empty( $fonts[0] ) ) {
						$fontfamily           = str_replace( ' ', '-', $fonts[0] );
						$filesystem           = Crafto_Filesystem::init_filesystem();
						$upload_dir           = wp_upload_dir();
						$targetdir            = untrailingslashit( wp_normalize_path( $upload_dir['basedir'] ) ) . '/crafto-fonts/' . $fontfamily;
						$srcdir               = untrailingslashit( wp_normalize_path( $upload_dir['basedir'] ) ) . '/crafto-fonts/crafto-temp-fonts';
						$font_family_location = $srcdir . '/' . $fontfamily;

						// Create the target directory if it doesn't exist.
						if ( ! file_exists( $targetdir ) ) {
							wp_mkdir_p( $targetdir );
						}

						// Copy the font files and clean up.
						if ( file_exists( $font_family_location ) ) {
							copy_dir( $font_family_location, $targetdir );
							$filesystem->delete( $font_family_location, FS_CHMOD_DIR );
						}
					}
				}
			}
		}

		/**
		 * Remove RevSlider conflict in widgets page.
		 */
		public function crafto_revslider_gutenberg_cgb_editor_assets() {
			global $pagenow;

			// Check if we are on the widgets page.
			if ( 'widgets.php' === $pagenow ) {
				// Dequeue the RevSlider Gutenberg block script.
				wp_dequeue_script( 'revslider_gutenberg-cgb-block-js' );
			}
		}

		/**
		 * Issue fixed: SG speed optimizer and crafto theme both uses the same "data-icon" attribute to display the icon.
		 */
		public function crafto_admin_dequeue_scripts() {
			if ( ! is_admin() ) {
				return;
			}

			$page = isset( $_GET['page'] ) && ! empty( $_GET['page'] ) ? $_GET['page'] : ''; // phpcs:ignore

			// Define pages to check against.
			$excluded_pages = [
				'sg-security',
				'site-security',
				'login-settings',
				'activity-log',
				'post-hack-actions',
				'sgo_frontend',
				'sg-cachepress',
				'sgo_caching',
				'sgo_environment',
				'sgo_media',
				'sgo_analysis',
			];

			// Check if the current page is in the excluded list.
			if ( in_array( $page, $excluded_pages, true ) ) {

				// Remove conflict icons libraries.
				$icons_styles = [
					'font-awesome',
					'et-line-icons',
					'themify-icons',
				];

				foreach ( $icons_styles as $style ) {
					wp_deregister_style( $style );
					wp_dequeue_style( $style );
				}
			}
		}

		/**
		 * Custom post type unregister.
		 */
		public function crafto_custom_post_type_unregister() {
			// Define the post types and their associated taxonomies.
			$post_types = [
				'portfolio'  => [
					'portfolio-category',
					'portfolio-tags',
				],
				'properties' => [
					'properties-types',
					'properties-agents',
				],
				'tours'      => [
					'tour-destination',
					'tour-activity',
				],
			];

			foreach ( $post_types as $post_type => $taxonomies ) {
				if ( 'properties' === $post_type ) {
					$post_type_settings_slug = 'property';
				} else {
					$post_type_settings_slug = $post_type;
				}

				if ( '1' === get_theme_mod( "crafto_disable_{$post_type_settings_slug}", '0' ) ) {
					unregister_post_type( $post_type );
					foreach ( $taxonomies as $taxonomy ) {
						unregister_taxonomy( $taxonomy );
					}
				}
			}
		}

		/**
		 * Custom Post Type Widgets unregister.
		 *
		 * @param mixed $widgets_manager Widgets Manager.
		 */
		public function crafto_unregister_widgets( $widgets_manager ) {
			// Define the widgets to unregister based on theme settings.
			$widgets_to_unregister = [
				'portfolio' => [
					'crafto-portfolio',
					'crafto-archive-portfolio',
					'crafto-portfolio-slider',
					'crafto-interactive-portfolio',
					'crafto-minimal-portfolio',
					'crafto-vertical-portfolio',
					'crafto-horizontal-portfolio',
				],
				'property'  => [
					'crafto-property',
					'crafto-property-price',
					'crafto-property-meta',
					'crafto-property-address',
					'crafto-property-gallery-carousel',
					'crafto-archive-property',
				],
				'tours'     => [
					'crafto-tours',
					'crafto-tours-meta-details',
					'crafto-archive-tours',
					'crafto-trip-header',
				],
			];

			foreach ( $widgets_to_unregister as $type => $widgets ) {
				if ( '1' === get_theme_mod( "crafto_disable_{$type}", '0' ) ) {
					foreach ( $widgets as $widget ) {
						$widgets_manager->unregister( $widget );
					}
				}
			}
		}

		/**
		 * Add custom body class for custom cursor.
		 *
		 * @param array $classes Add dynamic classes in body tag.
		 * @return array Updated classes.
		 */
		public function crafto_custom_cursor( $classes ) {
			// Check if the custom cursor feature is enabled.
			$crafto_enable_custom_cursor = get_theme_mod( 'crafto_enable_custom_cursor', '0' );
			if ( '1' === $crafto_enable_custom_cursor ) {
				$classes[] = 'custom-cursor';
			}

			return $classes;
		}

		/**
		 * Add custom cursor HTML if enabled.
		 */
		public function crafto_custom_page_cursor() {
			$crafto_enable_custom_cursor = get_theme_mod( 'crafto_enable_custom_cursor', '0' );

			// Check if the custom cursor feature is enabled.
			if ( '1' === $crafto_enable_custom_cursor ) {
				?>
				<div class="cursor-page-inner">
					<div class="circle-cursor circle-cursor-inner"></div>
					<div class="circle-cursor circle-cursor-outer"></div>
				</div>
				<?php
			}
		}

		/**
		 * Add popup.
		 */
		public function crafto_promo_popup() {
			$crafto_enable_promo_popup              = get_theme_mod( 'crafto_enable_promo_popup', '0' );
			$crafto_enable_promo_popup_on_home_page = get_theme_mod( 'crafto_enable_promo_popup_on_home_page', '0' );

			/**
			 * Apply filters to enable/disable popup
			 *
			 * @since 1.0
			 */
			$crafto_enable_promo_popup  = apply_filters( 'crafto_enable_promo_popup', $crafto_enable_promo_popup );// phpcs:ignore
			$crafto_promo_popup_section = get_theme_mod( 'crafto_promo_popup_section', '' );

			if ( '1' === $crafto_enable_promo_popup && ! empty( $crafto_promo_popup_section ) ) {
				if ( '0' === $crafto_enable_promo_popup_on_home_page || ( '1' === $crafto_enable_promo_popup_on_home_page && is_front_page() ) ) {
					$flag          = false;
					$crafto_siteid = ( is_multisite() ) ? '-' . get_current_blog_id() : '';
					$cookie_name   = 'crafto-promo-popup' . $crafto_siteid;// phpcs:ignore

					if ( ! isset( $_COOKIE[ $cookie_name ] ) || ( isset( $_COOKIE[ $cookie_name ] ) && 'shown' !== $_COOKIE[ $cookie_name ] ) ) {
						$flag = true;
					}
					?>
					<div class="crafto-promo-popup-wrap">
						<?php
						if ( current_user_can( 'edit_posts' ) && ! is_customize_preview() && ! empty( $crafto_promo_popup_section ) ) {
							$edit_link = add_query_arg(
								array(
									'post'   => $crafto_promo_popup_section,
									'action' => 'elementor',
								),
								admin_url( 'post.php' )
							);
							?>
							<a href="<?php echo esc_url( $edit_link ); ?>" target="_blank" data-bs-placement="right" title="<?php echo esc_attr__( 'Edit Popup Template', 'crafto-addons' ); ?>" class="edit-crafto-section edit-promo crafto-tooltip"><span class="screen-reader-text"><?php echo esc_html__( 'Edit Popup Template', 'crafto-addons' ); ?></span></a>
							<?php
						}

						/**
						 * Fires to Load Popup from the Section Builder.
						 *
						 * @since 1.0
						 */
						do_action( 'crafto_theme_promo_popup' );
						?>
					</div>
					<?php
					wp_enqueue_script( 'crafto-promo-popup' );
				}
			}
		}

		/**
		 * Add side icon.
		 */
		public function crafto_side_icon() {
			$crafto_enable_side_icon = get_theme_mod( 'crafto_enable_side_icon', '0' );
			/**
			 * Apply filters to enable/disable side icon
			 *
			 * @since 1.0
			 */
			$crafto_enable_side_icon               = apply_filters( 'crafto_enable_side_icon', $crafto_enable_side_icon ); // phpcs:ignore
			$crafto_side_icon_section              = get_theme_mod( 'crafto_side_icon_section', '' );
			$crafto_side_icon_button_first_text    = get_theme_mod( 'crafto_side_icon_button_first_text', esc_html__( '52+ Pre-built sites', 'crafto-addons' ) );
			$crafto_side_icon_second_button_link   = get_theme_mod( 'crafto_side_icon_second_button_link', '' );
			$crafto_enable_side_icon_first_button  = get_theme_mod( 'crafto_enable_side_icon_first_button', '0' );
			$crafto_enable_side_icon_second_button = get_theme_mod( 'crafto_enable_side_icon_second_button', '0' );

			if ( '1' === $crafto_enable_side_icon && ! empty( $crafto_side_icon_section ) ) {
				?>
				<div class="theme-demos">
					<?php
					if ( ( '1' === $crafto_enable_side_icon_first_button && ! empty( $crafto_side_icon_section ) ) || ( '1' === $crafto_enable_side_icon_second_button && ! empty( $crafto_side_icon_second_button_link ) ) ) {
						?>
						<div class="demo-button-wrapper">
						<?php
					}
					if ( '1' === $crafto_enable_side_icon_second_button && ! empty( $crafto_side_icon_second_button_link ) ) {
						?>
						<div class="buy-theme">
							<a href="<?php echo esc_url( $crafto_side_icon_second_button_link ); ?>" target="_blank">
								<img src="<?php echo esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/all-demo-icon.svg' ); ?>" height="1" width="1" alt="<?php echo esc_attr__( 'All Demo Icon', 'crafto-addons' ); ?>">
							</a>
						</div>
						<?php
					}
					if ( '1' === $crafto_enable_side_icon_first_button && ! empty( $crafto_side_icon_section ) ) {
						?>
						<div class="all-demo">
							<div class="demo-link">
								<div class="theme-wrapper">
									<div><?php echo esc_html( $crafto_side_icon_button_first_text ); ?></div>
								</div>
							</div>
						</div>
						<?php
					}
					if ( ( '1' === $crafto_enable_side_icon_first_button && ! empty( $crafto_side_icon_section ) ) || ( '1' === $crafto_enable_side_icon_second_button && ! empty( $crafto_side_icon_second_button_link ) ) ) {
						?>
						</div>
						<?php
					}
					?>
					<span class="close-popup"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg></span>
					<div class="theme-demos-main">
						<div class="demos-wrapper">
							<?php
							if ( current_user_can( 'edit_posts' ) && ! is_customize_preview() && '1' === $crafto_enable_side_icon_first_button && ! empty( $crafto_side_icon_section ) ) {
								$edit_link = add_query_arg(
									array(
										'post'   => $crafto_side_icon_section,
										'action' => 'elementor',
									),
									admin_url( 'post.php' )
								);
								?>
								<a href="<?php echo esc_url( $edit_link ); ?>" target="_blank" data-bs-placement="right" title="<?php echo esc_attr__( 'Edit Side Icon Template', 'crafto-addons' ); ?>" class="edit-crafto-section edit-side-icon"><span class="screen-reader-text"><?php echo esc_html__( 'Edit Side Icon Template', 'crafto-addons' ); ?></span></a>
								<?php
							}

							/**
							 * Fires to Load Side Icon Content from the Section Builder.
							 *
							 * @since 1.0
							 */
							do_action( 'crafto_theme_side_icon' );
							?>
						</div>
					</div>
				</div>
				<?php
				wp_enqueue_style( 'crafto-side-icon' );

				if ( is_rtl() ) {
					wp_enqueue_style( 'crafto-side-icon-rtl' );
				}
			}
		}

		/**
		 * Additional JS field
		 */
		public function crafto_additional_js_output() {
			$additional_js = get_option( 'crafto_custom_js', '' );

			// Return early if no additional JS is set.
			if ( '' === $additional_js ) {
				return;
			}

			// Add the additional JS as inline script.
			wp_add_inline_script( 'crafto-main', $additional_js );
		}

		/**
		 * Initialize Customizer settings export/import.
		 *
		 * @param WP_Customize_Manager $wp_customize The instance of the WordPress Customizer manager.
		 */
		public function crafto_customizer_settings( $wp_customize ) {
			// Check if the current user has permission to edit theme options.
			if ( ! current_user_can( 'edit_theme_options' ) ) {
				return;
			}

			// Handle export request.
			if ( isset( $_REQUEST['crafto-export'] ) ) { // phpcs:ignore
				$this->crafto_customizer_export( $wp_customize );
			}

			// Handle import request.
			if ( isset( $_REQUEST['crafto-import'] ) && isset( $_FILES['crafto-import-file'] ) ) { // phpcs:ignore
				$this->crafto_customizer_import( $wp_customize );
			}
		}

		/**
		 * Customizer settings export.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function crafto_customizer_export( $wp_customize ) {
			// Verify the nonce for security.
			if ( ! wp_verify_nonce( $_REQUEST['crafto-export'], 'crafto-exporting' ) ) { // phpcs:ignore
				return;
			}

			// Core options that should not be exported.
			$core_options = array(
				'page_for_posts',
				'blogname',
				'show_on_front',
				'blogdescription',
				'page_on_front',
			);

			// Prepare data for export.
			$theme_name     = get_stylesheet();
			$template       = get_template();
			$charset        = get_option( 'blog_charset' );
			$theme_settings = get_theme_mods();
			$settings_data  = array(
				'template' => $template,
				'mods'     => $theme_settings ? $theme_settings : array(),
				'options'  => array(),
			);

			// Get options from the Customizer API.
			$settings = $wp_customize->settings();

			foreach ( $settings as $key => $setting ) {

				if ( 'option' === $setting->type ) {

					// Skip widget data.
					if ( 'widget_' === substr( strtolower( $key ), 0, 7 ) ) {
						continue;
					}

					// Skip sidebar data.
					if ( 'sidebars_' === substr( strtolower( $key ), 0, 9 ) ) {
						continue;
					}

					// Skip core options.
					if ( in_array( $key, $core_options, true ) ) {
						continue;
					}

					$settings_data['options'][ $key ] = $setting->value();
				}
			}

			// Include custom CSS if available.
			if ( function_exists( 'wp_get_custom_css_post' ) ) {
				$settings_data['wp_css'] = wp_get_custom_css();
			}

			// Set download headers and output the data.
			header( 'Content-disposition: attachment; filename=' . $theme_name . '-export.json' ); // phpcs:ignore
			header( 'Content-Type: application/octet-stream; charset=' . $charset ); // phpcs:ignore

			// Serialize and output the export data.
			echo serialize( $settings_data ); // phpcs:ignore

			// End script execution.
			die();
		}

		/**
		 * Customizer settings import.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public function crafto_customizer_import( $wp_customize ) {
			// Verify the nonce for security.
			if ( ! wp_verify_nonce( $_REQUEST['crafto-import'], 'crafto-importing' ) ) { // phpcs:ignore
				return;
			}

			// Ensure WordPress upload support is loaded.
			if ( ! function_exists( 'wp_handle_upload' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			// Setup internal vars.
			$template  = get_template();
			$overrides = array(
				'test_form' => false,
				'test_type' => false,
				'mimes'     => array(
					'json' => 'text/plain',
				),
			);

			// Handle the uploaded file.
			$file = wp_handle_upload( $_FILES['crafto-import-file'], $overrides ); // phpcs:ignore

			// Check for errors or non-existent file.
			if ( isset( $file['error'] ) && ! file_exists( $file['file'] ) ) {
				return;
			}

			// Get the upload data.
			$file_content = file_get_contents( $file['file'] ); // phpcs:ignore
			$file_data    = @unserialize( $file_content ); // phpcs:ignore

			// Remove the uploaded file.
			unlink( $file['file'] );

			// Data checks.
			if ( 'array' !== gettype( $file_data ) ) {
				$error_message = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'crafto-addons' );
				echo "<script type='text/javascript'>alert('$error_message');</script>"; // phpcs:ignore
				return;
			}

			if ( ! isset( $file_data['template'] ) || ! isset( $file_data['mods'] ) ) {
				$error_message = __( 'Error importing settings! Please check that you uploaded a customizer export file.', 'crafto-addons' );
				echo "<script type='text/javascript'>alert('$error_message');</script>"; // phpcs:ignore
				return;
			}

			if ( $file_data['template'] !== $template ) {
				$error_message = __( 'Error importing settings! The settings you uploaded are not for the current theme.', 'crafto-addons' );
				echo "<script type='text/javascript'>alert('$error_message');</script>"; // phpcs:ignore
				return;
			}

			// Import custom CSS if available.
			if ( function_exists( 'wp_update_custom_css_post' ) && isset( $file_data['wp_css'] ) && '' !== $file_data['wp_css'] ) {
				wp_update_custom_css_post( $file_data['wp_css'] );
			}

			// Call the customize_save action.
			do_action( 'customize_save', $wp_customize );

			// Loop through and save the mods.
			foreach ( $file_data['mods'] as $key => $val ) {
				do_action( 'customize_save_' . $key, $wp_customize );
				set_theme_mod( $key, $val );
			}

			// Call the customize_save_after action.
			do_action( 'customize_save_after', $wp_customize );
		}

		/**
		 * Add custom additional shapes
		 *
		 * @param array $additional_shapes Custom Shapes.
		 */
		public function crafto_additional_shapes_render( $additional_shapes ) {
			for ( $i = 1; $i <= 4; $i++ ) {
				/* translators: %1$s is the label of shape */
				$label      = sprintf( esc_html__( 'Crafto Shape - %1$s', 'crafto-addons' ), $i ); // phpcs:ignore
				$shape_key  = 'crafto-custom-shape-' . esc_attr( $i );
				$shape_path = CRAFTO_ADDONS_ROOT . '/includes/assets/images/shape-divider/' . esc_attr( $i ) . '.svg';
				$shape_url  = CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/shape-divider/' . esc_attr( $i ) . '.svg';

				$additional_shapes[ $shape_key ] = [
					'title'        => esc_html( $label ),
					'path'         => $shape_path,
					'url'          => $shape_url,
					'has_flip'     => false,
					'has_negative' => false,
				];
			}

			return $additional_shapes;
		}

		/**
		 * Add user to Mailchimp list.
		 */
		public function crafto_add_user_to_mailchimp_list() {
			// Check the nonce for security.
			check_ajax_referer( 'crafto-mailchimp-form', 'security', false );

			if ( ! class_exists( 'Crafto_MailChimp' ) ) {
				return;
			}

			$api_key = get_theme_mod( 'crafto_mailchimp_access_api_key', '' );

			// Validate the API key.
			if ( empty( $api_key ) || strpos( $api_key, '-' ) === false ) {
				?>
				<div class="alert alert-info">
					<?php echo esc_html__( 'Please, input the MailChimp Api Key in Customize Panel.', 'crafto-addons' ); ?>
				</div>
				<?php
				wp_die();
			}

			$mailchimp = new \Crafto_MailChimp( $api_key );
			$list_id   = isset( $_POST['list_id'] ) ? wp_unslash( $_POST['list_id'] ) : ''; // phpcs:ignore
			$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : ''; // phpcs:ignore
			$fname     = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : ''; // phpcs:ignore
			$tags      = isset( $_POST['tags'] ) ? explode( ',', sanitize_text_field( wp_unslash( $_POST['tags'] ) ) ) : []; // phpcs:ignore

			// Validate the list ID.
			if ( empty( $list_id ) ) {
				?>
				<div class="alert alert-info">
					<?php echo esc_html__( 'Wrong List ID, please select a real one.', 'crafto-addons' ); ?>
				</div>
				<?php
				wp_die();
			}

			// Add user to Mailchimp list.
			$result = $mailchimp->post(
				"lists/$list_id/members",
				[
					'email_address' => $email,
					'merge_fields'  => [
						'FNAME' => $fname,
					],
					'tags'          => $tags,
					'status'        => 'subscribed',
				]
			);

			if ( $mailchimp->success() ) {
				?>
				<div class="alert alert-success">
					<?php echo esc_html__( 'Thank you, you have been added to our mailing list.', 'crafto-addons' ); ?>
				</div>
				<?php
			} else {
				echo $mailchimp->get_last_error(); // phpcs:ignore
			}

			if ( ! $mailchimp->get_last_error() && isset( json_decode( wp_remote_retrieve_body( $mailchimp->get_last_response() ), true )['detail'] ) ) {
				switch ( json_decode( wp_remote_retrieve_body( $mailchimp->get_last_response() ), true )['title'] ) {
					case 'Member Exists':
						/* translators: %s is the email of member */
						printf( '<div class="alert alert-warning">%s</div>', sprintf( esc_html__( '%1$s is already a list member.', 'crafto-addons' ), $email ) ); // phpcs:ignore
						break;
					default:
						echo '<div class="alert alert-danger">' . json_decode( wp_remote_retrieve_body( $mailchimp->get_last_response() ), true )['detail'] . '</div>'; // phpcs:ignore
						break;
				}
			}
			wp_die();
		}

		/**
		 * Function to Crafto Live Search.
		 */
		public function crafto_live_search() {
			$search_query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : ''; // phpcs:ignore
			$post_types   = isset( $_GET['post_type'] ) ? array_map( 'sanitize_text_field', (array) $_GET['post_type'] ) : []; // phpcs:ignore
			$post_length  = isset( $_GET['post_length'] ) ? sanitize_text_field( $_GET['post_length'] ) : ''; // phpcs:ignore
			$results      = [];

			foreach ( $post_types as $post_type ) {
				$args = [
					's'              => $search_query,
					'post_type'      => $post_type,
					'posts_per_page' => 5,
				];

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {
					$results[ $post_type ] = $this->crafto_get_search_results( $query );
				}
			}

			// Check and display results.
			if ( ! empty( $results ) ) {
				$this->crafto_display_search_results( $results, $post_length );
			} else {
				$this->crafto_display_no_results_message();
			}

			wp_die();
		}

		/**
		 * Function to Crafto Live Search.
		 */
		public function crafto_simple_live_search() {
			$search_query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : ''; // phpcs:ignore
			$post_types   = isset( $_GET['post_type'] ) ? array_map( 'sanitize_text_field', (array) $_GET['post_type'] ) : []; // phpcs:ignore
			$post_length  = isset( $_GET['post_length'] ) ? sanitize_text_field( $_GET['post_length'] ) : ''; // phpcs:ignore
			$results      = [];

			foreach ( $post_types as $post_type ) {
				$args = [
					's'              => $search_query,
					'post_type'      => $post_type,
					'posts_per_page' => -1,
				];

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) {
					$results[ $post_type ] = $this->crafto_get_search_results( $query );
				}
			}

			// Check and display results.
			if ( ! empty( $results ) ) {
				$this->crafto_display_simple_search_results( $results, $post_length );
			} else {
				$this->crafto_display_no_results_message();
			}

			wp_die();
		}

		/**
		 * Get formatted search results.
		 *
		 * @param WP_Query $query The WP_Query instance.
		 * @return array Formatted results.
		 */
		private function crafto_get_search_results( $query ) {
			$posts = [];
			while ( $query->have_posts() ) {
				$query->the_post();
				$posts[] = [
					'title'     => get_the_title(),
					'permalink' => get_permalink(),
					'thumbnail' => get_the_post_thumbnail( null, 'full' ),
				];
			}

			return [
				'posts'       => $posts,
				'total_posts' => $query->found_posts,
			];
		}

		/**
		 * Display search results.
		 *
		 * @param array $results Search results data.
		 * @param array $post_length Search results data.
		 */
		private function crafto_display_search_results( $results, $post_length ) {
			?>
			<div class="container">
				<ul class="nav nav-tabs" id="search-tab" role="tablist">
					<?php
					$first = true;
					foreach ( $results as $post_type => $data ) {
						$active_class = $first ? 'active' : '';
						?>
						<li class="nav-item <?php echo esc_attr( $post_type ); ?>" role="presentation">
							<a class="nav-link <?php echo esc_attr( $active_class ); ?>" id="<?php echo esc_attr( $post_type ); ?>-tab" data-bs-toggle="tab" href="#<?php echo esc_attr( $post_type ); ?>" role="tab" aria-controls="<?php echo esc_attr( $post_type ); ?>" aria-selected="<?php echo esc_attr( $active_class ? 'true' : 'false' ); ?>">
								<?php echo esc_html( ucfirst( $post_type ) ); ?>
							</a>
						</li>
						<?php
						$first = false;
					}
					?>
				</ul>
				<div class="tab-content" id="search-tab-content">
					<?php
					$first = true;
					foreach ( $results as $post_type => $data ) {
						$active_class = $first ? 'show active' : '';
						?>
						<div class="tab-pane fade <?php echo esc_attr( $active_class ); ?>" id="<?php echo esc_attr( $post_type ); ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr( $post_type ); ?>-tab">
							<ul>
								<?php
								foreach ( $data['posts'] as $post ) :
									?>
									<li>
										<?php
										if ( $post['thumbnail'] ) :
											?>
											<a href="<?php echo esc_url( $post['permalink'] ); ?>"><?php echo $post['thumbnail']; // phpcs:ignore ?></a>
											<?php
										endif;
										?>
										<a href="<?php echo esc_url( $post['permalink'] ); ?>">
											<?php
											$search_title = ! empty( $post_length ) ? wp_trim_words( $post['title'], $post_length, '...' ) : $post['title'];
											echo esc_html( $search_title );
											?>
										</a>
									</li>
									<?php
								endforeach;
								?>
							</ul>
							<?php
							if ( isset( $data['total_posts'] ) && $data['total_posts'] > 5 ) :
								?>
								<div class="view-more-btn-container"></div>
								<?php
							endif;
							?>
						</div>
						<?php
						$first = false;
					}
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Display search results.
		 *
		 * @param array $results Search results data.
		 * @param array $post_length Search results data.
		 */
		private function crafto_display_simple_search_results( $results, $post_length ) {
			?>
			<div class="simple-search-results">
				<ul class="simple-search-listing">
					<?php
					foreach ( $results as $post_type => $data ) {
						foreach ( $data['posts'] as $post ) {
							?>
							<li>
								<?php
								if ( $post['thumbnail'] ) {
									echo $post['thumbnail']; // phpcs:ignore
								}
								?>
								<a href="<?php echo esc_url( $post['permalink'] ); ?>">
									<?php
									$search_title = ! empty( $post_length ) ? wp_trim_words( $post['title'], $post_length, '...' ) : $post['title'];
									echo esc_html( $search_title );
									?>
								</a>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>
			<?php
		}

		/**
		 * Display a message when no results are found.
		 */
		private function crafto_display_no_results_message() {
			?>
			<p><?php echo esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'crafto-addons' ); ?></p>
			<?php
		}

		/**
		 * Function to handle Crafto Multiple Post Type Search.
		 *
		 * @param WP_Query $query The WP_Query object.
		 */
		public function crafto_multiple_post_type_search( $query ) {
			// Check if we are not in the admin area and if it's the main search query.
			if ( ! is_admin() && $query->is_search() && $query->is_main_query() && isset( $_GET['post_type'] ) ) { // phpcs:ignore
				$search_post_type = array_map( 'sanitize_text_field', $_GET['post_type'] ); // phpcs:ignore
				$query->set( 'post_type', ! empty( $search_post_type ) ? $search_post_type : 'post' );
			}
		}

		/**
		 * Replace apply coupon to apply.
		 *
		 * @param array $translated_text text.
		 * @param array $text wc text.
		 * @param array $domain check domain.
		 */
		public function crafto_woo_cart_coupon_button_text( $translated_text, $text, $domain ) {
			if ( is_cart() && 'Apply coupon' === $text && 'woocommerce' === $domain ) {
				return esc_html__( 'Apply', 'crafto-addons' );
			}
			return $translated_text;
		}

		/**
		 * Inline scripts for admin pages.
		 *
		 * @since 1.0
		 */
		public function crafto_inline_js() {
			ob_start();
			?>
			<script type="text/javascript">
				if ( 'undefined' !== typeof jQuery ) {
					jQuery( document ).ready( function( $ ) {
						$( "ul#adminmenu a[href*='admin.php?page=crafto-theme-help']" ).attr( 'target', '_blank' );
					});
				}
			</script>
			<?php
			echo ob_get_clean(); // phpcs:ignore
		}

		/**
		 * GiveWP plugin not logged in user rest api error fix.
		 *
		 * @since 1.0
		 */
		public function crafto_givewp_wp_json() {
			if ( ! is_user_logged_in() ) {
				?>
				<script>
				( function() {
					const originalFetch = window.fetch;
					window.fetch = function( input, init ) {
						const url = typeof input === 'string' ? input : input?.url || '';
						if ( url.includes( '/wp-json/wp/v2/users/me' ) && ! document.body.classList.contains( 'logged-in' ) ) {
							return Promise.resolve(new Response( null, { status: 204 } ) );
						}
						return originalFetch( input, init );
					};
				})();
				</script>
				<?php
			}
		}

	}
	new Crafto_Addons_Extra_Functions();
}

