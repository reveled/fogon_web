<?php
/**
 * Crafto Performance Manager
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// If class `Crafto_Performance_Manager` doesn't exists yet.
if ( ! class_exists( 'Crafto_Performance_Manager' ) ) {

	class Crafto_Performance_Manager {
		/**
		 * Constructor
		 */
		public function __construct() {
			$crafto_remove_url_query_string = get_theme_mod( 'crafto_remove_url_query_string', '0' );
			$crafto_disable_xmlrpc          = get_theme_mod( 'crafto_disable_xmlrpc', '0' );
			$crafto_remove_rsd_link         = get_theme_mod( 'crafto_remove_rsd_link', '0' );
			$crafto_remove_shortlink        = get_theme_mod( 'crafto_remove_shortlink', '0' );
			$crafto_remove_wp_ver_generator = get_theme_mod( 'crafto_remove_wp_version_generator', '0' );
			$crafto_js_async                = get_theme_mod( 'crafto_js_async', '0' );
			$crafto_load_strategy           = get_theme_mod( 'crafto_load_strategy', 'defer' );

			add_action( 'wp', array( $this, 'crafto_remove_style_wp_emojis' ) );

			if ( '1' === $crafto_js_async && 'delay' === $crafto_load_strategy ) {
				add_action( 'wp', array( $this, 'crafto_delay_scripts' ) );
			}

			add_action( 'init', array( $this, 'crafto_remove_feed_links' ) );
			add_action( 'wp_head', array( $this, 'crafto_preload_resources' ), -5 );
			add_action( 'wp_enqueue_scripts', array( $this, 'crafto_remove_gutenberg_styles' ), 20 );
			add_action( 'wp_enqueue_scripts', array( $this, 'crafto_dequeue_styles_scripts' ), 999 );
			add_action( 'wp_print_footer_scripts', array( $this, 'crafto_dequeue_styles_scripts' ), 0 );
			add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'crafto_remove_script_style' ), 20 );
			add_action( 'init', array( $this, 'crafto_conditionally_remove_speculative_rules' ) );
			add_action( 'wp_footer', array( $this, 'crafto_apply_speculation_rules' ) );
			add_action( 'wp_default_scripts', array( $this, 'crafto_disable_jquery_migrate' ) );
			add_action( 'wp_print_styles', array( $this, 'crafto_remove_dashicons' ), 100 );
			add_action( 'pre_ping', array( $this, 'crafto_remove_self_ping' ) );
			add_filter( 'jpeg_quality', array( $this, 'crafto_set_jpeg_quality' ) );
			add_filter( 'wp_editor_set_quality', array( $this, 'crafto_set_jpeg_quality' ) );
			add_filter( 'big_image_size_threshold', array( $this, 'crafto_set_big_image_size_threshold' ) );
			add_filter( 'wp_revisions_to_keep', array( $this, 'crafto_set_revisions_to_keep' ), 10, 2 );
			add_filter( 'heartbeat_settings', array( $this, 'crafto_set_heartbeat_time_interval' ) );
			add_filter( 'wp_resource_hints', array( $this, 'crafto_add_prefetch_dns_urls' ), 9, 2 );
			add_filter( 'wp_resource_hints', array( $this, 'crafto_add_preconnect_urls' ), 10, 2 );

			$crafto_preload_critical_css = get_theme_mod( 'crafto_preload_critical_css', '0' );
			if ( '1' === $crafto_preload_critical_css ) {
				add_filter( 'style_loader_tag', array( $this, 'crafto_preload_css_head' ), 999, 2 );
			}

			// Disable WooCommerce cart fragments.
			add_action( 'wp_enqueue_scripts', array( $this, 'crafto_remove_cart_fragments' ), 11 );

			if ( '1' === $crafto_remove_url_query_string && ! is_admin() ) {
				add_filter( 'script_loader_src', array( $this, 'crafto_remove_query_strings' ), 15, 1 );
				add_filter( 'style_loader_src', array( $this, 'crafto_remove_query_strings' ), 15, 1 );
			}

			if ( '1' === $crafto_disable_xmlrpc ) {
				add_filter( 'xmlrpc_enabled', '__return_false' );
			}

			if ( '1' === $crafto_remove_rsd_link ) {
				remove_action( 'wp_head', 'rsd_link' );
				remove_action( 'wp_head', 'wlwmanifest_link' );
			}

			if ( '1' === $crafto_remove_shortlink ) {
				remove_action( 'wp_head', 'wp_shortlink_wp_head' );
			}

			if ( '1' === $crafto_remove_wp_ver_generator ) {
				remove_action( 'wp_head', 'wp_generator' );
			}

			add_action(
				'elementor/frontend/after_enqueue_styles',
				function () {
					// Check if we're in the admin area or the current user has permission to manage options.
					if ( is_admin() || current_user_can( 'manage_options' ) ) {
						return;
					}

					$crafto_elementor_icons_css = crafto_option( 'crafto_elementor_icons_css_file', '0' );
					if ( '1' === $crafto_elementor_icons_css ) {
						wp_dequeue_style( 'elementor-icons' );
					}
				}
			);
		}

		/**
		 * Remove RSS feed links from <head> if the "Disable RSS Feeds" option is enabled in the Customizer.
		 *
		 * This helps clean up the page head and prevents bots or users from discovering disabled RSS endpoints.
		 */
		public function crafto_remove_feed_links() {
			$crafto_disable_rss_feeds = get_theme_mod( 'crafto_disable_rss_feeds', '0' );
			if ( '1' === $crafto_disable_rss_feeds ) {
				remove_action( 'wp_head', 'feed_links', 2 );
				remove_action( 'wp_head', 'feed_links_extra', 3 );

				// Optional: Disable actual RSS feed output (hard block).
				add_action( 'do_feed', array( $this, 'crafto_disable_rss' ), 1 );
				add_action( 'do_feed_rdf', array( $this, 'crafto_disable_rss' ), 1 );
				add_action( 'do_feed_rss', array( $this, 'crafto_disable_rss' ), 1 );
				add_action( 'do_feed_rss2', array( $this, 'crafto_disable_rss' ), 1 );
				add_action( 'do_feed_atom', array( $this, 'crafto_disable_rss' ), 1 );
			}
		}

		/**
		 * Callback to block RSS feed output.
		 */
		public function crafto_disable_rss() {
			wp_die( esc_html__( 'RSS feeds are disabled on this site.', 'crafto-addons' ), '', array( 'response' => 403 ) );
		}

		/**
		 * Function for delay JS.
		 */
		public function crafto_delay_scripts() {
			$crafto_delay_scope         = get_theme_mod( 'crafto_delay_scope', 'globally' );
			$crafto_delay_exclude_pages = get_theme_mod( 'crafto_delay_exclude_pages', '' );

			$delay_excecute = false;
			if ( 'homepage' === $crafto_delay_scope && ( is_front_page() || is_home() ) ) {
				$delay_excecute = true;
			}

			if ( 'globally' === $crafto_delay_scope ) {
				$home_path    = parse_url( home_url(), PHP_URL_PATH ) ?? '/'; // phpcs:ignore
				$current_path = parse_url( home_url( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) ?? '/'; // phpcs:ignore
				$current_path = str_replace( $home_path, '/', $current_path ); // phpcs:ignore
				$current_path = trailingslashit( $current_path );

				$excluded_pages = [];
				if ( ! empty( $crafto_delay_exclude_pages ) ) {
					$crafto_exclude_pages = preg_replace( '/\s+/', ' ', trim( $crafto_delay_exclude_pages ) );
					$excluded_pages       = array_map( 'trailingslashit', array_filter( explode( ' ', $crafto_exclude_pages ) ) );
				}

				if ( ! in_array( $current_path, $excluded_pages, true ) ) {
					$delay_excecute = true;
				}
			}

			if ( $delay_excecute ) {
				add_filter( 'script_loader_tag', array( $this, 'crafto_delay_wp_scripts' ), 10, 2 );
				add_action( 'wp_head', array( $this, 'crafto_delay_scripts_loaded_sequentially' ), 999 );
			}
		}

		/**
		 * Add resource preload
		 *
		 * @param string $tag Style HTML.
		 *
		 * @param string $handle WordPress style handle.
		 *
		 * @return string $html Style HTML.
		 */
		public function crafto_preload_css_head( $tag, $handle ) {
			// user is logged in.
			if ( is_user_logged_in() ) {
				return $tag;
			}

			$non_critical_css_files_array = array();

			$crafto_gdpr_enable = get_theme_mod( 'crafto_gdpr_enable', '0' );

			if ( '1' === $crafto_gdpr_enable ) {
				$non_critical_css_files_array[] = 'crafto-theme-gdpr';
			}

			$preload_critical_css_list = apply_filters( 'crafto_preload_critical_css', $non_critical_css_files_array );

			if ( ! in_array( $handle, $preload_critical_css_list, true ) ) {
				if ( ! is_admin() && is_elementor_activated() && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
					$fallback = '<noscript>' . $tag . '</noscript>'; // phpcs:ignore
					$preload  = str_replace(
						"rel='stylesheet'",
						"rel='preload' as=\"style\" onload=\"this.onload=null;this.rel='stylesheet'\"",
						$tag
					);

					$tag = $preload . $fallback; // phpcs:ignore
				}
			}

			return $tag;
		}

		/**
		 * Javascript execution via delay
		 *
		 * @param string $tag Script HTML.
		 * @param string $handle Script handle.
		 *
		 * @since 1.0
		 */
		public function crafto_delay_wp_scripts( $tag, $handle ) {
			if ( is_user_logged_in() ) { // user is logged in.
				return $tag;
			}

			if ( ! is_admin() && is_elementor_activated() && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				// Retrieve delay scripts and exclusion list.
				$delayed_scripts         = crafto_get_delay_js();
				$crafto_js_exclude_delay = get_theme_mod( 'crafto_js_exclude_delay', '' );

				// Convert exclusion list into an array.
				$crafto_js_exclude_delay_array = [];
				if ( ! empty( $crafto_js_exclude_delay ) ) {
					$crafto_js_exclude_delay_array = explode( ',', $crafto_js_exclude_delay );
				}

				if ( ! empty( $crafto_js_exclude_delay_array ) ) {
					foreach ( $crafto_js_exclude_delay_array as $delay_js_key ) {
						unset( $delayed_scripts[ $delay_js_key ] );
					}
				}

				// Optimize search by using an array flip.
				$delayed_scripts = array_flip( $delayed_scripts );

				// Check if the script is in the list of delayed scripts.
				if ( in_array( $handle, $delayed_scripts, true ) ) {
					$tag = str_replace( 'src=', 'delay=', $tag );
				}

				return $tag;
			}

			return $tag;
		}

		/**
		 * Delay javascripts loaded sequentially.
		 *
		 * @since 1.0
		 */
		public function crafto_delay_scripts_loaded_sequentially() {
			// Early return if user is logged in.
			if ( is_user_logged_in() ) {
				return;
			}

			if ( is_elementor_activated() && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				?>
				<script>
					document.addEventListener( 'DOMContentLoaded', function () {
						const autoLoadDuration = 1.6 * 1000; // 1.6 Seconds delay
						const eventList = [
							'keydown',
							'mousemove',
							'wheel',
							'touchmove',
							'touchstart',
							'touchend',
						];

						const autoLoadTimeout = setTimeout(triggerScripts, autoLoadDuration);

						eventList.forEach(event => {
							window.addEventListener( event, triggerScripts, { passive: true } );
						});

						// Function to trigger scripts loading after the delay or user interaction
						function triggerScripts() {
							loadScriptsSequentially(); // Start loading scripts
							clearTimeout(autoLoadTimeout);
							eventList.forEach(event => {
								window.removeEventListener(event, triggerScripts);
							});
						}

						// Function to load all scripts sequentially
						function loadScriptsSequentially() {
							const scripts = Array.from( document.querySelectorAll( 'script[delay]' ) );

							// Start with an empty resolved promise
							let promiseChain = Promise.resolve();

							scripts.forEach(( scriptTag ) => {
								promiseChain = promiseChain.then(() => {
									return new Promise(( resolve, reject ) => {
										let src = scriptTag.getAttribute( 'delay' );
										if ( src ) {
											scriptTag.setAttribute( 'src', src );
											scriptTag.removeAttribute( 'delay' );

											// When the script is loaded, resolve the promise
											scriptTag.onload = () => {
												// If the script is for progress-bar, trigger its initialization
												if ( src.includes( 'progress-bar.js' ) && typeof elementorFrontend !== 'undefined' ) {
													elementorFrontend.hooks.doAction( 'frontend/element_ready/crafto-progress-bar.default', jQuery(document));
												}

												if ( src.includes( 'frontend-lite.js' ) && typeof elementorFrontend !== 'undefined' ) {
													elementorFrontend.hooks.doAction( 'frontend/element_ready/container', jQuery(document));
												}

												resolve(); // Move to next script
											};

											// Handle script loading errors
											scriptTag.onerror = () => {
												resolve(); // Continue loading even if one script fails
											};

											document.body.appendChild(scriptTag); // Append the script tag to the document
										} else {
											resolve(); // Skip empty script tags
										}
									});
								});
							});

							// When all scripts are loaded, trigger any final actions
							promiseChain.then(() => {
								if ( typeof elementorFrontend !== 'undefined' ) {
									const widgets = {
										'container': 'container',
										'crafto-video-button-widget': 'crafto-video-button.default',
										'crafto-accordion-widget': 'crafto-accordion.default',
										'crafto-popup-widget': 'crafto-popup.default,crafto-dismiss-button.default',
										'crafto-dismiss-button': 'crafto-dismiss-button.default',
										'crafto-tilt-box-widget': 'crafto-tilt-box.default',
										'crafto-image-widget': 'crafto-image.default',
										'crafto-3d-parallax-hover-widget': 'crafto-3d-parallax-hover.default',
										'crafto-text-editor': 'crafto-text-editor.default',
										'crafto-simple-menu-widget': 'crafto-menu-list-items.default,crafto-custom-menu.default',
										'crafto-mega-menu-widget': 'crafto-mega-menu.default',
										'crafto-heading-widget': 'crafto-heading.default',
										'crafto-search-form-widget': 'crafto-search-form.default',
										'crafto-hamburger-menu-widget': 'crafto-hamburger-menu.default',
										'crafto-media-gallery-widget': 'crafto-media-gallery.default',
										'crafto-image-gallery-widget': 'crafto-image-gallery.default',
										'crafto-team-member-widget': 'crafto-team-member.default',
										'crafto-newsletter': 'crafto-newsletter.default',
										'crafto-countdown-widget': 'crafto-countdown.default',
										'crafto-counter-widget': 'crafto-counter.default',
										'crafto-tabs-widget': 'crafto-tabs.default',
										'crafto-fancy-text-box-widget': 'crafto-fancy-text-box.default',
										'crafto-sliding-box-widget': 'crafto-sliding-box.default',
										'crafto-text-rotator': 'crafto-text-rotator.default',
										'crafto-pie-chart-widget': 'crafto-pie-chart.default',
										'crafto-blog-list-widget': 'crafto-blog-list.default',
										'crafto-archive-blog': 'crafto-archive-blog.default',
										'crafto-loop-builder': 'crafto-loop-builder.default',
										'crafto-interactive-banner-widget': 'crafto-interactive-banner.default',
										'crafto-product-taxonomy-widget': 'crafto-product-taxonomy.default',
										'crafto-stack-section': 'crafto-stack-section.default',
										'crafto-portfolio-widget': 'crafto-portfolio.default,crafto-archive-portfolio.default',
										'crafto-horizontal-portfolio-widget': 'crafto-horizontal-portfolio.default',
										'crafto-portfolio-slider-widget': 'crafto-portfolio-slider.default',
										'crafto-testimonial-carousel': 'crafto-testimonial-carousel.default',
										'crafto-feature-box-carousel': 'crafto-feature-box-carousel.default',
										'crafto-marquee-slider': 'crafto-marquee-slider.default',
										'crafto-image-carousel-widget': 'crafto-image-carousel.default',
										'crafto-content-slider': 'crafto-content-slider.default',
										'crafto-default-carousel': 'crafto-dynamic-slider.default',
										'client-image-carousel': 'crafto-client-image-carousel.default',
										'crafto-blog-slider-widget': 'crafto-blog-post-slider.default',
										'crafto-tours-widget': 'crafto-tours.default,crafto-archive-tours.default',
										'crafto-product-slider-widget': 'crafto-product-slider.default',
										'crafto-product-list-widget': 'crafto-product-list.default',
										'crafto-property-gallery-carousel': 'crafto-property-gallery-carousel.default',
										'crafto-video-widget': 'crafto-video.default',
										'crafto-instagram-widget': 'crafto-instagram.default',
										'crafto-particle-effect-widget': 'crafto-particle-effect.default',
										'crafto-looping-animation': 'crafto-looping-animation.default',
										'crafto-property-widget': 'crafto-property.default,crafto-archive-property.default',
										'crafto-text-slider-widget': 'crafto-text-slider.default',
										'crafto-images-comparison': 'crafto-images-comparison.default',
										'crafto-lottie-animation': 'crafto-lottie.default',
										'crafto-post-layout': 'crafto-post-layout.default',
										'crafto-back-to-top': 'crafto-back-to-top.default',
									};
									<?php
									$crafto_js_exclude_delay = get_theme_mod( 'crafto_js_exclude_delay', '' );

									$crafto_js_exclude_delay_array = [];
									if ( ! empty( $crafto_js_exclude_delay ) ) {
										$crafto_js_exclude_delay_array = explode( ',', $crafto_js_exclude_delay );
									}

									if ( ! empty( $crafto_js_exclude_delay_array ) ) {
										foreach ( $crafto_js_exclude_delay_array as $delay_js_key ) {
											?>
											delete widgets['<?php echo esc_html( $delay_js_key ); ?>'];
											<?php
										}
									}
									?>
									let duplicate_hooks = [];
									Object.keys(widgets).forEach( ( hook, index ) => {
										var hooks_array = widgets[hook].split(",");
										hooks_array.forEach( ( hooks, indexs ) => {
											if ( ! duplicate_hooks.includes( hooks ) ) {
												duplicate_hooks.push( hooks );
												elementorFrontend.hooks.doAction( `frontend/element_ready/${hooks}`, jQuery( document ) );
											}
										});
									});

									// Trigger Elementor refresh for all widgets
									elementorFrontend.elements.$window.trigger( 'resize' );
								}
							});
						}
					});
				</script>
				<?php
			}
		}

		/**
		 * JPG image quality control
		 *
		 * @param string $quality JPG image quality.
		 *
		 * @since 1.0
		 */
		public function crafto_set_jpeg_quality( $quality ) {
			$crafto_jpg_image_quality = get_theme_mod( 'crafto_jpg_image_quality', '' );

			// Return the custom quality if set, otherwise return the default quality.
			return $crafto_jpg_image_quality ? (int) $crafto_jpg_image_quality : $quality;
		}

		/**
		 * Control Image Size Threshold
		 *
		 * @since 1.0
		 */
		public function crafto_set_big_image_size_threshold() {
			$threshold = (int) get_theme_mod( 'crafto_big_image_size_threshold', 2560 );
			$threshold = 0 === $threshold ? false : $threshold;

			return $threshold;
		}

		/**
		 * Crafto remove WP emojis.
		 */
		public function crafto_remove_style_wp_emojis() {
			$crafto_wp_emojis = get_theme_mod( 'crafto_wp_emojis', '0' );

			// Check if the user has enabled emojis.
			if ( '1' === $crafto_wp_emojis ) {
				// Remove emoji scripts and styles.
				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );
				remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
				remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
				remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
				// Disable TinyMCE emoji plugin.
				add_filter( 'tiny_mce_plugins', array( $this, 'crafto_disable_emojis_tinymce' ) );
				// Remove DNS prefetch for emojis.
				add_filter( 'wp_resource_hints', array( $this, 'crafto_disable_emojis_remove_dns_prefetch' ), 10, 2 );
			}
		}

		/**
		 * Disable Emojis in TinyMCE Editor.
		 *
		 * @param array $plugins Emojis tinymce.
		 */
		public function crafto_disable_emojis_tinymce( $plugins ) {
			// Remove the wpemoji plugin if present.
			return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
		}

		/**
		 * Remove the WordPress emoji CDN hostname from DNS prefetching hints.
		 *
		 * @param  array  $urls URLs to print for resource hints.
		 * @param  string $relation_type The relation type the URLs are printed for.
		 * @return array  Difference betwen the two arrays.
		 */
		public function crafto_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
			if ( 'dns-prefetch' === $relation_type ) {
				$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
				foreach ( $urls as $key => $url ) {
					if ( false !== strpos( $url, $emoji_svg_url_bit ) ) {
						unset( $urls[ $key ] );
					}
				}
			}

			return $urls;
		}

		/**
		 * Remove Gutenberg global and inline styles based on theme settings.
		 */
		public static function crafto_remove_gutenberg_styles() {
			$crafto_enable_remove_global_styles = get_theme_mod( 'crafto_enable_remove_global_styles', '0' );

			// Check if global styles should be removed.
			if ( '1' === $crafto_enable_remove_global_styles ) {
				// Remove global and classic theme styles.
				wp_deregister_style( 'global-styles' );
				wp_dequeue_style( 'global-styles' );
				wp_deregister_style( 'classic-theme-styles' );
				wp_dequeue_style( 'classic-theme-styles' );
			}

			$disabled_styles = get_theme_mod( 'crafto_disable_gutenberg_styles', '' );
			$disabled_styles = explode( ',', $disabled_styles );

			if ( is_array( $disabled_styles ) ) {
				foreach ( $disabled_styles as $style ) {
					wp_deregister_style( $style );
					wp_dequeue_style( $style );
				}
			}
		}

		/**
		 * Remove Elementor CSS and JavaScript based on theme options.
		 */
		public static function crafto_remove_script_style() {
			if ( is_elementor_activated() && ! \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				// Get options for dialog JS.
				$crafto_elementor_dialog_js = crafto_option( 'crafto_elementor_dialog_js_library', '0' );

				// Deregister and dequeue dialog JS if enabled.
				if ( '1' === $crafto_elementor_dialog_js ) {
					wp_deregister_script( 'elementor-dialog' );
					wp_dequeue_script( 'elementor-dialog' );
				}
			}
		}

		/**
		 * Disable jQuery Migrate if the corresponding theme option is enabled.
		 *
		 * @param WP_Scripts $scripts WP_Scripts object.
		 * @return void
		 */
		public function crafto_disable_jquery_migrate( $scripts ) {
			// Check if the setting to disable jQuery Migrate is enabled.
			$crafto_disable_jq_migrate = get_theme_mod( 'crafto_disable_jq_migrate', '0' );

			if ( '1' !== $crafto_disable_jq_migrate ) {
				return; // Exit if the option is not enabled.
			}

			// Only apply this on the front end.
			if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
				$script = $scripts->registered['jquery'];

				// Remove jQuery Migrate from the jQuery dependencies if it exists.
				if ( $script->deps ) {
					$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
				}
			}
		}

		/**
		 * Disable Dashicons if the corresponding theme option is enabled.
		 */
		public function crafto_remove_dashicons() {
			// Check if the setting to disable dashicons is enabled.
			$crafto_disable_dashicons = get_theme_mod( 'crafto_disable_dashicons', '0' );

			// Exit if Dashicons should not be disabled.
			if ( '1' !== $crafto_disable_dashicons ) {
				return;
			}

			// Only remove Dashicons if the admin bar is not showing and not in customizer preview.
			if ( ! is_admin_bar_showing() && ! is_customize_preview() ) {
				wp_dequeue_style( 'dashicons' );
				wp_deregister_style( 'dashicons' );
			}
		}

		/**
		 * Disables pingbacks from the site by removing self-pings.
		 *
		 * @param array $links Array of URLs that may include self-pings.
		 */
		public function crafto_remove_self_ping( &$links ) {
			// Get the setting to disable self-pings.
			$crafto_disable_self_pings = get_theme_mod( 'crafto_disable_self_pings', '0' );

			// Exit if self-pings should not be disabled.
			if ( '1' !== $crafto_disable_self_pings ) {
				return;
			}

			// Get the home URL.
			$home = get_option( 'home' );

			// Remove self-ping links.
			foreach ( $links as $l => $link ) {
				if ( str_starts_with( $link, $home ) ) {
					unset( $links[ $l ] );
				}
			}
		}

		/**
		 * Set Heartbeat Interval.
		 *
		 * @param array $settings Heartbeat settings.
		 * @return array Modified heartbeat settings.
		 */
		public function crafto_set_heartbeat_time_interval( $settings ) {
			$crafto_control_heartbeat  = get_theme_mod( 'crafto_control_heartbeat', '0' );
			$crafto_heartbeat_interval = (int) get_theme_mod( 'crafto_heartbeat_interval', 60 );

			// If heartbeat control is enabled, set the interval.
			if ( '1' === $crafto_control_heartbeat ) {
				$settings['interval'] = $crafto_heartbeat_interval;
			}

			return $settings;
		}

		/**
		 * Prefetch DNS URLs.
		 *
		 * @param array  $hints Array of resources and their attributes.
		 * @param string $relation_type The relation type the URLs are printed for.
		 *                              One of 'dns-prefetch', 'preconnect', 'prefetch', or 'prerender'.
		 * @return array Modified hints array with added DNS prefetch URLs.
		 */
		public function crafto_add_prefetch_dns_urls( $hints, $relation_type ) {
			// Only proceed if the relation type is 'dns-prefetch'.
			if ( 'dns-prefetch' !== $relation_type ) {
				return $hints;
			}

			// Retrieve the user-defined DNS URLs from the theme mod.
			$crafto_prefetch_dns_urls = get_theme_mod( 'crafto_prefetch_dns_urls', '' );

			// Decode the JSON data to an array.
			$urls = json_decode( $crafto_prefetch_dns_urls, true );

			// Ensure the data is an array and iterate through it.
			if ( is_array( $urls ) ) {
				foreach ( $urls as $resource ) {
					// Validate each URL before adding it to the hints array.
					if ( isset( $resource['url'] ) && ! empty( $resource['url'] ) ) {
						$validated_url = esc_url( $resource['url'] );
						if ( ! empty( $validated_url ) ) {
							$hints[] = $validated_url;
						}
					}
				}
			}

			return $hints;
		}

		/**
		 * Dequeue custom scripts.
		 */
		public function crafto_dequeue_styles_scripts() {
			$crafto_dequeue_scripts = crafto_meta_box_values( 'crafto_dequeue_scripts' );
			if ( is_array( $crafto_dequeue_scripts ) || is_object( $crafto_dequeue_scripts ) ) {
				foreach ( $crafto_dequeue_scripts as $scripts ) {
					if ( isset( $scripts['textarea'] ) ) {
						// Remove JS.
						wp_deregister_script( $scripts['textarea'] );
						wp_dequeue_script( $scripts['textarea'] );

						// Remove CSS.
						wp_deregister_style( $scripts['textarea'] );
						wp_dequeue_style( $scripts['textarea'] );
					}
				}
			}
		}

		/**
		 * Preconnect URLs.
		 *
		 * This function adds URLs for preconnecting based on user-defined settings.
		 * The URLs should be provided in a newline-separated format, optionally with a "crossorigin" attribute.
		 *
		 * @param array  $hints Array of resources and their attributes.
		 * @param string $relation_type The relation type the URLs are printed for.
		 *                              One of 'dns-prefetch', 'preconnect', 'prefetch', or 'prerender'.
		 * @return array Modified hints array with added preconnect URLs.
		 */
		public function crafto_add_preconnect_urls( $hints, $relation_type ) {
			// Only proceed if the relation type is 'preconnect'.
			if ( 'preconnect' !== $relation_type ) {
				return $hints;
			}

			// Retrieve the user-defined preconnect URLs.
			$crafto_preconnect_urls = get_theme_mod( 'crafto_preconnect_urls', '' );

			// Decode the JSON data to an array.
			$urls = json_decode( $crafto_preconnect_urls, true );

			// Ensure the data is an array and iterate through it.
			if ( is_array( $urls ) ) {
				foreach ( $urls as $resource ) {
					// Validate each URL before adding it to the hints array.
					if ( isset( $resource['url'] ) && ! empty( $resource['url'] ) ) {
						$hint = [
							'href' => esc_url( $resource['url'] ),
						];

						// Add crossorigin attribute if set.
						if ( isset( $resource['isChecked'] ) && $resource['isChecked'] ) {
							$hint[] = 'crossorigin';
						}

						$hints[] = $hint;
					}
				}
			}

			return $hints;
		}

		/**
		 * Preload Resources like CSS, JS, Fonts URLs.
		 */
		public function crafto_preload_resources() {
			$preload_resources_theme = get_theme_mod( 'crafto_preload_resources', wp_json_encode( [] ) );
			$resources_array_theme   = json_decode( $preload_resources_theme, true );
			$preload_resources_meta  = crafto_meta_box_values( 'crafto_preload_resources' );

			// Combine both resources into one array.
			$combined_resources = array_merge( (array) $resources_array_theme, (array) $preload_resources_meta );

			// Early return if no valid resources.
			if ( empty( $combined_resources ) ) {
				return;
			}

			$preload_tags        = [];
			$processed_resources = [];

			// Detect the current device type.
			$is_mobile = isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/(android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT'] ); // phpcs:ignore
			$current_device = $is_mobile ? 'mobile' : 'desktop';

			// Loop through all combined resources.
			foreach ( $combined_resources as $resource ) {
				$url    = '';
				$type   = '';
				$device = 'all'; // Default to all devices.

				// Check if resource is from customizer or meta box.
				if ( isset( $resource['url'], $resource['type'], $resource['device'] ) ) {
					$url    = esc_url( $resource['url'] );
					$type   = esc_html( $resource['type'] );
					$device = esc_html( $resource['device'] );
				} elseif ( isset( $resource['select'], $resource['textarea'], $resource['select_device'] ) ) {
					$url    = esc_url( trim( $resource['textarea'] ) );
					$type   = esc_attr( $resource['select'] );
					$device = esc_attr( $resource['select_device'] );
				}

				// Skip if the resource is for a different device.
				if ( 'all' !== $device && $device !== $current_device ) {
					continue;
				}

				// Generate a unique key for each resource based on URL and type.
				$resource_key = $url . '|' . $type;

				// Add the preload tag only if it hasn't been processed.
				if ( ! empty( $url ) && ! in_array( $resource_key, $processed_resources, true ) ) {
					$processed_resources[] = $resource_key;

					// Generate the appropriate preload tag based on the resource type.
					switch ( $type ) {
						case 'document':
							$preload_tags[] = "<link rel='preload' href='$url' as='document' />\n";
							break;
						case 'font':
							$preload_tags[] = "<link rel='preload' href='$url' as='font' type='font/woff2' crossorigin='anonymous' />\n";
							break;
						case 'image':
							$preload_tags[] = "<link rel='preload' href='$url' as='image' />\n";
							break;
						case 'script':
							$preload_tags[] = "<link rel='preload' href='$url' as='script' />\n";
							break;
						case 'style':
							$preload_tags[] = "<link rel='preload' href='$url' as='style' />\n";
							break;
					}
				}
			}

			echo implode( '', $preload_tags ); // phpcs:ignore
		}

		/**
		 * Set the post revisions limit.
		 *
		 * @param int     $num  Number of revisions to store.
		 * @param WP_Post $post Post object.
		 * @return int
		 **/
		public function crafto_set_revisions_to_keep( $num, $post ) {
			$crafto_post_revisions = get_theme_mod( 'crafto_post_revisions', '' );

			// If no custom revisions limit is set, return the default.
			if ( '' === $crafto_post_revisions ) {
				return $num;
			}

			$revisions_limit = (int) $crafto_post_revisions;

			return ( $revisions_limit >= 0 ) ? $revisions_limit : $num;
		}

		/**
		 * Parse the url of script/style tags to remove the version query string.
		 *
		 * @param string $url  Script loader source path.
		 *
		 * @return string
		 */
		public function crafto_remove_query_strings( $url ) {
			$parts = preg_split( '/\?ver|\?timestamp/', $url );
			return $parts[0];
		}

		/**
		 * Optimize WooCommerce cart fragments.
		 */
		public function crafto_remove_cart_fragments() {
			// Do not run on admin pages.
			if ( is_admin() ) {
				return;
			}

			if ( ! is_woocommerce_activated() ) {
				return;
			}

			$crafto_disable_cart_fragments = get_theme_mod( 'crafto_disable_cart_fragments', '0' );
			if ( '1' === $crafto_disable_cart_fragments ) {
				if ( ! is_cart() && ! is_checkout() ) {
					wp_dequeue_script( 'wc-cart-fragments' );
					wp_deregister_script( 'wc-cart-fragments' );
				}
			}
		}

		/**
		 * Remove Speculative Rules API.
		 */
		public function crafto_conditionally_remove_speculative_rules() {
			$crafto_enable_speculative = get_theme_mod( 'crafto_enable_speculative', '0' );

			if ( '0' === $crafto_enable_speculative ) {
				remove_action( 'wp_footer', 'wp_print_speculation_rules' );
			}
		}

		/**
		 * Speculative Rules API.
		 */
		public function crafto_apply_speculation_rules() {
			$rules = $this->crafto_get_speculation_rules();

			if ( empty( $rules ) ) {
				return;
			}

			echo '<script type="speculationrules">';
			echo wp_json_encode( $rules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			echo '</script>';
		}

		/**
		 * Add script for Speculative Rules API.
		 */
		public function crafto_get_speculation_rules() {
			$crafto_enable_speculative = get_theme_mod( 'crafto_enable_speculative', '0' );

			if ( '0' === $crafto_enable_speculative ) {
				return array();
			}

			$crafto_speculative_mode               = get_theme_mod( 'crafto_speculative_mode', 'prerender' );
			$crafto_speculative_eagerness          = get_theme_mod( 'crafto_speculative_eagerness', 'moderate' );
			$crafto_prefetch_speculative_eagerness = get_theme_mod( 'crafto_prefetch_speculative_eagerness', 'moderate' );
			$selected_eagerness                    = ( 'prerender' === $crafto_speculative_mode ) ? $crafto_speculative_eagerness : $crafto_prefetch_speculative_eagerness;

			$site_url  = get_site_url();
			$main_url  = network_site_url();
			$merge_url = array_merge( [ $site_url ], [ $main_url ] );

			// Fetch excluded URLs from theme mod.
			$excluded_urls = get_theme_mod( 'crafto_page_exclude_preload', '' );
			$excluded_urls = array_filter( array_map( 'trim', explode( "\n", $excluded_urls ) ) );

			// Prepend site URL to each excluded URL.
			$excluded_urls = array_map(
				function ( $url ) use ( $site_url ) {
					return rtrim( $site_url, '/' ) . $url;
				},
				$excluded_urls
			);

			// Add exclusion for wp-admin URLs in both site and subsite.
			$wp_admin_exclusions = array_map(
				function ( $url ) {
					return rtrim( $url, '/' ) . '/wp-admin/*';
				},
				$merge_url
			);

			$all_excluded_urls = array_merge( $excluded_urls, $wp_admin_exclusions );

			$rules = array(
				$crafto_speculative_mode => array(
					array(
						'where'     => [
							'and' => [
								[
									'href_matches' => '/*',
								],
								[
									'not' => [
										'href_matches' => $all_excluded_urls,
									],
								],
							],
						],
						'eagerness' => $selected_eagerness,
					),
				),
			);

			return $rules;
		}
	}

	new Crafto_Performance_Manager();
}
