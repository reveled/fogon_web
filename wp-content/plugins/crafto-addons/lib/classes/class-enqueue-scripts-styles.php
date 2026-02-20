<?php
/**
 * Enqueue Styles and Scripts.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crafto_Addons_Enqueue_Scripts_Styles' ) ) {
	/**
	 * Define enqueue scripts and styles
	 */
	class Crafto_Addons_Enqueue_Scripts_Styles {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->add_hooks();
		}

		/**
		 * Add hooks to register style & scripts.
		 */
		public function add_hooks() {
			add_action( 'wp_head', [ $this, 'crafto_inline_custom_css_render' ], 8 );

			$crafto_load_css_footer = get_theme_mod( 'crafto_load_css_footer', '0' );
			$crafto_load_css_footer = ( '1' === $crafto_load_css_footer && ! Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) ? 'wp_footer' : 'wp_enqueue_scripts';

			add_action( $crafto_load_css_footer, array( $this, 'crafto_enqueue_script_style' ) );
			add_action( 'wp_footer', [ $this, 'crafto_load_vendors_styles_in_footer' ] );
			add_action( 'wp', [ $this, 'crafto_conditionally_load_frontend_css' ] );
			add_action( 'wp_footer', [ $this, 'crafto_performance_custom_load_css' ] );
			add_action( 'admin_enqueue_scripts', array( $this, 'crafto_admin_enqueue_style_script' ) );
			add_action( 'customize_controls_enqueue_scripts', [ $this, 'crafto_customize_enqueue_styles_scripts' ] );
			add_action( 'admin_footer', [ $this, 'crafto_load_admin_footer_css' ] );
		}

		/**
		 * Conditionally load frontend css
		 */
		public function crafto_conditionally_load_frontend_css() {
			$frontend_hook = ( isset( $_GET['s'] ) || is_404() || is_archive() || is_front_page() ) ? 'wp_enqueue_scripts' : 'elementor/frontend/after_enqueue_styles';

			add_action( $frontend_hook, [ $this, 'crafto_load_frontend_css' ], 5 );
		}

		/**
		 * Inline custom CSS load in footer (backend)
		 */
		public function crafto_load_admin_footer_css() {
			$output_css = '#adminmenu .wp-menu-image img { padding: 5px 0 0;opacity: 1;width: 24px;}';
			echo '<style type="text/css">' . sprintf( '%s', $output_css ) . '</style>'; // phpcs:ignore
		}

		/**
		 * Register & enqueue styles for customize
		 */
		public function crafto_customize_enqueue_styles_scripts() {
			wp_register_style(
				'crafto-addons-custom-admin',
				CRAFTO_ADDONS_CSS_URI . '/admin/crafto-addons-custom-admin.css',
				[],
				CRAFTO_ADDONS_PLUGIN_VERSION
			);
			wp_enqueue_style( 'crafto-addons-custom-admin' );
		}

		/**
		 * Inline custom CSS load in head (frontend)
		 */
		public function crafto_inline_custom_css_render() {
			$output_css = 'body.disable-all-animation [data-anime], body.disable-all-animation [data-fancy-text], body.disable-all-animation .swiper-slide [data-fancy-text], body.disable-all-animation .swiper-slide .slider-subtitle[data-anime] { opacity: 1 !important;}.appear:not(.anime-complete) .e-con.e-flex, .appear:not(.anime-complete), .appear:not(.anime-complete) .elementor-widget-container {transition: 0s;}[data-top-bottom] {transition: transform .65s cubic-bezier(.23,1,.32,1);}';

			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
			if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
				$output_css .= '[data-anime],[data-fancy-text] { opacity: 0; }[data-anime].appear, [data-fancy-text].appear { opacity: 1; } [data-anime].anime-complete, [data-fancy-text].anime-complete { opacity: 1; }';
			}

			echo '<style type="text/css" id="crafto-theme-custom-css">' . sprintf( '%s', $output_css ) . '</style>'; // phpcs:ignore
		}

		/**
		 * Inline custom CSS load
		 */
		public function crafto_performance_custom_load_css() {
			$output_css = crafto_meta_box_values( 'crafto_performance_custom_css' );
			if ( ! empty( $output_css ) ) {
				echo '<style type="text/css" id="crafto-theme-custom-css">' . sprintf( '%s', $output_css ) . '</style>'; // phpcs:ignore
			}
		}

		/**
		 * Register & enqueue styles in frontend CSS.
		 */
		public function crafto_load_frontend_css() {
			$flag     = false;
			$rtl_flag = false;
			if ( Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_CSS_DIR . '/vendors/crafto-addons-vendors.min.css' ) ) {
				$flag = true;
			}

			if ( Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_CSS_DIR . '/vendors/crafto-addons-vendors-rtl.min.css' ) && is_rtl() ) {
				$rtl_flag = true;
			}

			if ( ! $flag ) {
				wp_register_style(
					'crafto-addons-frontend',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/frontend.css',
					[ 'elementor-frontend' ],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
				wp_enqueue_style( 'crafto-addons-frontend' );
			}
			
			if ( is_rtl() && ! $rtl_flag ) {
				wp_register_style(
					'crafto-addons-frontend-rtl',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/frontend-rtl.css',
					[ 'elementor-frontend' ],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
				wp_enqueue_style( 'crafto-addons-frontend-rtl' );
			}

			// All combined css of vendors which is load in only editor.
			if ( $flag ) {
				wp_register_style(
					'crafto-addons-vendors',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/crafto-addons-vendors.min.css',
					[ 'elementor-frontend' ],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-addons-vendors' );
			}

			if ( $rtl_flag && is_rtl() ) {
				wp_register_style(
					'crafto-addons-frontend-rtl',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/crafto-addons-vendors-rtl.min.css',
					[ 'elementor-frontend' ],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-addons-frontend-rtl' );
			}
		}

		/**
		 * Register & enqueue styles in footer.
		 */
		public function crafto_load_vendors_styles_in_footer() {
			$flag     = false;
			$rtl_flag = false;
			if ( Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_CSS_DIR . '/vendors/crafto-addons-vendors.min.css' ) ) {
				$flag = true;
			}

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_CSS_DIR . '/vendors/crafto-addons-vendors-rtl.min.css' ) && is_rtl() ) {
				$rtl_flag = true;
			}

			$icon_flag = false;
			if ( Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() && file_exists( CRAFTO_ADDONS_CSS_DIR . '/vendors/crafto-icons.min.css' ) ) {
				$icon_flag = true;
			}

			if ( ! $icon_flag ) {
				if ( crafto_disable_module_by_key( 'fontawesome' ) ) {
					// Elementor's Enqueue Fonts Style.
					wp_enqueue_style( 'elementor-icons-shared-0' );
					wp_enqueue_style( 'elementor-icons-fa-regular' );
					wp_enqueue_style( 'elementor-icons-fa-brands' );
					wp_enqueue_style( 'elementor-icons-fa-solid' );

					wp_register_style(
						'fontawesome',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/fontawesome.min.css',
						[],
						'7.1.0'
					);
					wp_enqueue_style( 'fontawesome' );
				}

				if ( crafto_disable_module_by_key( 'iconsmind-line' ) ) {
					wp_register_style(
						'iconsmind-line',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/iconsmind-line.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
					wp_enqueue_style( 'iconsmind-line' );
				}

				if ( crafto_disable_module_by_key( 'iconsmind-solid' ) ) {
					wp_register_style(
						'iconsmind-solid',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/iconsmind-solid.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
					wp_enqueue_style( 'iconsmind-solid' );
				}
			}

			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
			if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'magic-cursor' ) ) {
				wp_register_style(
					'crafto-magic-cursor',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/magic-cursor.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
				);
				wp_enqueue_style( 'crafto-magic-cursor' );
			}

			if ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) ) {
				wp_register_style(
					'crafto-portfolio-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/portfolio-list.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-portfolio-widget' );
			}

			if ( is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) ) {
				wp_register_style(
					'crafto-property-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/property-list.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-property-widget' );
			}

			if ( is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) {
				wp_register_style(
					'crafto-tours-widget',
					CRAFTO_ADDONS_WIDGETS_URI . '/assets/css/tour.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-tours-widget' );
			}

			// Popup.
			$crafto_enable_promo_popup        = get_theme_mod( 'crafto_enable_promo_popup', '0' );
			$crafto_enable_promo_popup        = apply_filters( 'crafto_enable_promo_popup', $crafto_enable_promo_popup );
			$crafto_promo_popup_section       = get_theme_mod( 'crafto_promo_popup_section', '' );
			$crafto_display_promo_popup_after = crafto_post_meta_by_id( $crafto_promo_popup_section, 'crafto_display_promo_popup_after' );
			$crafto_display_promo_popup_after = ( ! empty( $crafto_display_promo_popup_after ) ) ? $crafto_display_promo_popup_after : 'some-time';
			$crafto_delay_time_promo_popup    = crafto_post_meta_by_id( $crafto_promo_popup_section, 'crafto_delay_time_promo_popup' );
			$crafto_delay_time_promo_popup    = ( ! empty( $crafto_delay_time_promo_popup ) ) ? $crafto_delay_time_promo_popup : '100';
			$crafto_scroll_promo_popup        = crafto_post_meta_by_id( $crafto_promo_popup_section, 'crafto_scroll_promo_popup' );
			$crafto_scroll_promo_popup        = ( ! empty( $crafto_scroll_promo_popup ) ) ? $crafto_scroll_promo_popup : '500';
			$crafto_scroll_promo_popup        = str_replace( 'px', '', $crafto_scroll_promo_popup );
			$crafto_enable_mobile_promo_popup = crafto_post_meta_by_id( $crafto_promo_popup_section, 'crafto_enable_mobile_promo_popup' );
			$crafto_promo_popup_cookie_expire = crafto_post_meta_by_id( $crafto_promo_popup_section, 'crafto_promo_popup_cookie_expire' );
			$crafto_promo_popup_cookie_expire = ( ! empty( $crafto_promo_popup_cookie_expire ) ) ? $crafto_promo_popup_cookie_expire : '7';

			// Side Icon.
			$crafto_enable_side_icon  = get_theme_mod( 'crafto_enable_side_icon', '0' );
			$crafto_side_icon_section = get_theme_mod( 'crafto_side_icon_section', '' );

			if ( is_crafto_addons_activated() && is_elementor_activated() && '1' === $crafto_enable_side_icon && ! empty( $crafto_side_icon_section ) ) {
				wp_register_style(
					'crafto-side-icon',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/crafto-side-icon.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				if ( is_rtl() ) {
					wp_register_style(
						'crafto-side-icon-rtl',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/crafto-side-icon-rtl.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
				}
			}

			if ( is_crafto_addons_activated() && is_elementor_activated() && '1' === $crafto_enable_promo_popup && ! empty( $crafto_promo_popup_section ) ) {
				wp_register_script(
					'crafto-promo-popup',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/promo-popup.js',
					[
						'magnific-popup',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/promo-popup.js' )
				);

				$crafto_localize_arr = array(
					'site_id'                    => is_multisite() ? '-' . get_current_blog_id() : '',
					'enable_promo_popup'         => $crafto_enable_promo_popup,
					'scroll_promo_popup'         => $crafto_scroll_promo_popup,
					'display_promo_popup_after'  => $crafto_display_promo_popup_after,
					'delay_time_promo_popup'     => $crafto_delay_time_promo_popup,
					'expired_days_promo_popup'   => $crafto_promo_popup_cookie_expire,
					'enable_mobile_promo_popup'  => $crafto_enable_mobile_promo_popup,
					'popup_disable_mobile_width' => apply_filters( 'crafto_popup_disable_mobile_width', 768 ),
				);

				if ( is_elementor_activated() && wp_script_is( 'elementor-frontend', 'registered' ) ) {
					wp_localize_script(
						'elementor-frontend',
						'CraftoPromo',
						$crafto_localize_arr
					);
				} else {
					wp_localize_script(
						'crafto-promo-popup',
						'CraftoPromo',
						$crafto_localize_arr
					);
				}
			}

			if ( is_woocommerce_activated() ) {
				$crafto_wishlist_id            = get_option( 'woocommerce_wishlist_page_id' );
				$compare_text                  = apply_filters( 'crafto_compare_text', esc_html__( 'Add to compare', 'crafto-addons' ) );
				$crafto_compare_added_text     = apply_filters( 'crafto_compare_added_text', esc_html__( 'Compare products', 'crafto-addons' ) );
				$crafto_compare_remove_message = apply_filters( 'crafto_compare_remove_message', esc_html__( 'Are you sure you want to remove?', 'crafto-addons' ) );
				$browse_wishlist_text          = apply_filters( 'crafto_browse_wishlist_text', esc_html__( 'Browse wishlist', 'crafto-addons' ) );
				$remove_wishlist_text          = apply_filters( 'crafto_remove_wishlist_text', esc_html__( 'Remove wishlist', 'crafto-addons' ) );
				$wishlist_added_message        = apply_filters( 'crafto_wishlist_added_message', esc_html__( 'Product was added to wishlist successfully', 'crafto-addons' ) );
				$wishlist_remove_message       = apply_filters( 'crafto_wishlist_removed_message', esc_html__( 'Product was removed from wishlist successfully', 'crafto-addons' ) );
				$wishlist_addtocart_message    = apply_filters( 'crafto_wishlist_addtocart_message', esc_html__( 'Product was added to cart successfully', 'crafto-addons' ) );
				$wishlist_multi_select_message = apply_filters( 'crafto_wishlist_multi_select_message', esc_html__( 'Selected Products was removed from wishlist successfully', 'crafto-addons' ) );
				$wishlist_empty_message        = apply_filters( 'crafto_wishlist_empty_message', esc_html__( 'Are you sure you want to empty wishlist?', 'crafto-addons' ) );

				$wishlist_icon         = get_theme_mod( 'crafto_single_product_wishlist_icon', 'icon-feather-heart' );
				$archive_wishlist_text = get_theme_mod( 'crafto_product_archive_wishlist_text', esc_html__( 'Add to Wishlist', 'crafto-addons' ) );
				$single_wishlist_text  = get_theme_mod( 'crafto_single_product_wishlist_text', esc_html__( 'Add to Wishlist', 'crafto-addons' ) );
				$wishlist_text         = is_product() ? $single_wishlist_text : $archive_wishlist_text;
				$moment_timezone       = apply_filters( 'crafto_countdown_moment_timezone', true );

				$crafto_localize_arr['product_deal_day']              = esc_html__( 'Days', 'crafto-addons' );
				$crafto_localize_arr['product_deal_hour']             = esc_html__( 'Hours', 'crafto-addons' );
				$crafto_localize_arr['product_deal_min']              = esc_html__( 'Min', 'crafto-addons' );
				$crafto_localize_arr['product_deal_sec']              = esc_html__( 'Sec', 'crafto-addons' );
				$crafto_localize_arr['wishlist_url']                  = ! empty( $crafto_wishlist_id ) ? get_permalink( $crafto_wishlist_id ) : '';
				$crafto_localize_arr['wishlist_added_message']        = $wishlist_added_message;
				$crafto_localize_arr['wishlist_remove_message']       = $wishlist_remove_message;
				$crafto_localize_arr['wishlist_icon']                 = $wishlist_icon;
				$crafto_localize_arr['moment_timezone']               = $moment_timezone;
				$crafto_localize_arr['compare_text']                  = $compare_text;
				$crafto_localize_arr['compare_added_text']            = $crafto_compare_added_text;
				$crafto_localize_arr['compare_remove_message']        = $crafto_compare_remove_message;
				$crafto_localize_arr['wishlist_empty_message']        = $wishlist_empty_message;
				$crafto_localize_arr['searchpageurl']                 = home_url( '/' );
				$crafto_localize_arr['ajaxurl']                       = admin_url( 'admin-ajax.php' );
				$crafto_localize_arr['add_to_wishlist_text']          = $wishlist_text;
				$crafto_localize_arr['browse_wishlist_text']          = $browse_wishlist_text;
				$crafto_localize_arr['remove_wishlist_text']          = $remove_wishlist_text;
				$crafto_localize_arr['wishlist_addtocart_message']    = $wishlist_addtocart_message;
				$crafto_localize_arr['wishlist_multi_select_message'] = $wishlist_multi_select_message;
				$crafto_localize_arr['quickview_addtocart_message']   = esc_html__( 'Product was added to cart successfully', 'crafto-addons' );
				$crafto_localize_arr['site_id']                       = is_multisite() ? '-' . get_current_blog_id() : '';

				if ( is_elementor_activated() && wp_script_is( 'elementor-frontend', 'registered' ) ) {
					wp_localize_script(
						'elementor-frontend',
						'CraftoWoo',
						$crafto_localize_arr
					);
				} else {
					if ( wp_script_is( 'crafto-main', 'enqueued' ) ) {
						wp_localize_script(
							'crafto-main',
							'CraftoWoo',
							$crafto_localize_arr,
						);
					}
				}

				wp_register_script(
					'crafto-gutenberg-block',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/gutenberg-block.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/gutenberg-block.js' ),
				);
				wp_enqueue_script( 'crafto-gutenberg-block' );

				wp_enqueue_script( 'wc-cart-fragments' );

				wp_register_script(
					'crafto-quick-view',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/quick-view.js',
					[ 'wc-cart-fragments' ],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/quick-view.js' ),
				);

				wp_register_script(
					'crafto-product-compare',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/compare.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/compare.js' ),
				);

				wp_register_script(
					'crafto-wishlist',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/wishlist.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					crafto_load_async_javascript( CRAFTO_ADDONS_VENDORS_JS_URI . '/wishlist.js' ),
				);
			}

			if ( crafto_disable_module_by_key( 'hover-animation' ) && ! $flag && ! $rtl_flag ) {
				wp_register_style(
					'hover-animation',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/hover-min.css',
					[],
					'2.3.1'
				);
				wp_enqueue_style( 'hover-animation' );
			}
		}

		/**
		 * Add hooks to register style & scripts.
		 */
		public function crafto_enqueue_script_style() {
			$dependancy_main_style = [];
			$crafto_preload        = get_theme_mod( 'crafto_preload', '0' );

			if ( wp_style_is( 'crafto-style', 'enqueued' ) ) {
				$dependancy_main_style[] = 'crafto-style';
			}

			if ( crafto_disable_module_by_key( 'grid-style' ) ) {
				if ( is_rtl() ) {
					wp_register_style(
						'crafto-grid-style-rtl',
						CRAFTO_ADDONS_VENDORS_CSS_URI . '/grid-style-rtl.css',
						$dependancy_main_style,
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
					wp_enqueue_style( 'crafto-grid-style-rtl' );
				}

				wp_register_style(
					'crafto-grid-style',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/grid-style.css',
					$dependancy_main_style,
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-grid-style' );
			}
			
			if ( '1' === $crafto_preload ) {
				wp_register_style(
					'crafto-custom-preloader',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/preloader.css',
					$dependancy_main_style,
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-custom-preloader' );
			}
		}

		/**
		 * Enqueue scripts and styles admin side
		 *
		 * @param string $hook Action hook to execute when the event is run.
		 */
		public function crafto_admin_enqueue_style_script( $hook ) {
			global $typenow;

			if ( is_woocommerce_activated() && 'widgets.php' === $hook ) {
				wp_register_style(
					'crafto-woocommerce-gutenberg-widget',
					CRAFTO_ADDONS_CSS_URI . '/admin/crafto-woocommerce-widget.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-woocommerce-gutenberg-widget' );
			}

			if ( is_woocommerce_activated() && 'product' === $typenow && ( 'post-new.php' === $hook || 'post.php' === $hook ) ) {
				wp_enqueue_script( 'jquery-ui-accordion' );
				wp_register_script(
					'crafto-custom-woo-admin',
					CRAFTO_ADDONS_JS_URI . '/admin/custom-woo-admin.js',
					[
						'jquery',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);
				wp_enqueue_script( 'crafto-custom-woo-admin' );

				wp_localize_script(
					'crafto-custom-woo-admin',
					'CraftoWooAdmin',
					[
						'i18n'    => array(
							'tabRemoveMessage' => esc_html__( 'Are you sure you want to remove?', 'crafto-addons' ),
						),
						'ajaxurl' => admin_url( 'admin-ajax.php' ),
					]
				);
			}

			if ( 'tours' === $typenow && ( 'post-new.php' === $hook || 'post.php' === $hook || 'edit-tags.php' === $hook || 'term.php' === $hook ) ) {
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

				wp_register_script(
					'crafto-custom-tours-admin',
					CRAFTO_ADDONS_JS_URI . '/admin/custom-tours-admin.js',
					[
						'jquery',
						'crafto-select2',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);
				wp_enqueue_script( 'crafto-custom-tours-admin' );

				wp_localize_script(
					'crafto-custom-tours-admin',
					'CraftoToursAdmin',
					[
						'i18n'    => array(
							'placeholder' => esc_html__( 'Select Activity Icon', 'crafto-addons' ),
						),
						'ajaxurl' => admin_url( 'admin-ajax.php' ),
					]
				);
			}

			// Register new custom post types styles & scripts.
			if ( isset( $_GET['page'] ) && ( 'crafto-theme-post-types' === $_GET['page'] || 'crafto-theme-taxonomies' === $_GET['page'] || 'crafto-theme-meta-box' === $_GET['page'] ) ) { // phpcs:ignore.

				wp_register_script(
					'crafto-register-custom-post-types',
					CRAFTO_ADDONS_JS_URI . '/admin/register-custom-post-types.js',
					[
						'jquery',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);
				wp_enqueue_script( 'crafto-register-custom-post-types' );

				wp_localize_script(
					'crafto-register-custom-post-types',
					'register_post_type_ajax_object',
					array(
						'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
						'delete_posttype_confirm' => esc_html__( 'Are you sure you want to permanently delete this post type? Please, keep in mind that it is not possible to recover your content once deleted.', 'crafto-addons' ),
						'delete_taxonomy_confirm' => esc_html__( 'Are you sure you want to permanently delete this taxonomies? Please, keep in mind that it is not possible to recover your content once deleted.', 'crafto-addons' ),
						'delete_meta_confirm'     => esc_html__( 'Are you sure you want to permanently delete this meta? Please, keep in mind that it is not possible to recover your content once deleted.', 'crafto-addons' ),
						'post_types_checkbox'     => esc_html__( 'Please select a post type to associate with.', 'crafto-addons' ),
						'post_types_no_data'      => esc_html__( 'No data found.', 'crafto-addons' ),
					)
				);

				wp_register_style(
					'bootstrap-icons',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/bootstrap-icons.min.css',
					[],
					'1.11.3'
				);
				wp_enqueue_style( 'bootstrap-icons' );

				wp_register_style(
					'crafto-register-custom-post-types',
					CRAFTO_ADDONS_CSS_URI . '/admin/register-custom-post-types.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-register-custom-post-types' );

				if ( is_rtl() ) {
					wp_register_style(
						'crafto-register-custom-post-types-rtl',
						CRAFTO_ADDONS_CSS_URI . '/admin/register-custom-post-types-rtl.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
					wp_enqueue_style( 'crafto-register-custom-post-types-rtl' );
				}
			}
		}
	}

	new Crafto_Addons_Enqueue_Scripts_Styles();
}
