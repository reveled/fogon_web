<?php
/**
 * Crafto Critical CSS file.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Crafto_Critical_CSS' ) ) {

	/**
	 * Define class
	 */
	class Crafto_Critical_CSS {

		/**
		 * Construct
		 */
		public function __construct() {
			add_action( 'wp_head', array( $this, 'crafto_critical_inline_styles' ) );
			add_action( 'admin_menu', array( $this, 'crafto_critical_css_add_menu' ), 10 );
			add_action( 'init', array( $this, 'crafto_hide_admin_bar_for_iframe' ) );
			add_action( 'template_redirect', array( $this, 'crafto_allow_iframe_access' ), 1 );
			add_action( 'wp_head', array( $this, 'crafto_load_saved_critical_css' ), 2 );
			add_action( 'wp_footer', array( $this, 'crafto_enqueue_extraction_script' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'crafto_admin_enqueue_critical_style_script' ) );

			add_action( 'wp_ajax_crafto_save_extracted_css', array( $this, 'crafto_save_extracted_css' ) );
			add_action( 'wp_ajax_nopriv_crafto_save_extracted_css', array( $this, 'crafto_save_extracted_css' ) );

			add_action( 'wp_ajax_crafto_update_existing_css', array( $this, 'crafto_update_existing_css' ) );
			add_action( 'wp_ajax_nopriv_crafto_update_existing_css', array( $this, 'crafto_update_existing_css' ) );

			add_action( 'wp_ajax_crafto_delete_css_entry', array( $this, 'crafto_delete_css_entry' ) );
			add_action( 'wp_ajax_nopriv_crafto_delete_css_entry', array( $this, 'crafto_delete_css_entry' ) );

			add_action( 'wp_ajax_check_page_exists', array( $this, 'crafto_check_page_exists' ) );
			add_action( 'wp_ajax_nopriv_check_page_exists', array( $this, 'crafto_check_page_exists' ) );
		}

		/**
		 * Add Sub menu Critical CSS under Crafto theme setup.
		 */
		public function crafto_critical_css_add_menu() {
			add_submenu_page(
				'crafto-theme-setup',
				esc_html__( 'Critical CSS', 'crafto-addons' ),
				esc_html__( 'Critical CSS', 'crafto-addons' ),
				'manage_options',
				'crafto-theme-critical-css',
				array( $this, 'crafto_theme_critical_css_admin_page' ),
				4
			);
		}

		/**
		 * Critical CSS admin page.
		 */
		public function crafto_theme_critical_css_admin_page() {
			/* Check current user permission */
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'crafto-addons' ) );
			}

			$crafto_is_theme_license_active = function_exists( 'crafto_is_theme_license_active' ) ? crafto_is_theme_license_active() : '';

			/* Gets a WP_Theme object for a theme. */
			$crafto_theme_obj  = wp_get_theme();
			$crafto_theme_name = $crafto_theme_obj->get( 'Name' );
			$crafto_theme_name = str_ireplace(
				array(
					'child',
					' child',
				),
				array(
					'',
					'',
				),
				$crafto_theme_name
			);

			$crafto_theme_name = trim( $crafto_theme_name );

			$theme_license_url = add_query_arg(
				array(
					'page' => 'crafto-theme-setup',
				),
				admin_url( 'admin.php' )
			);
			?>
			<div class="wrap">
				<h1><?php echo esc_html__( 'Critical CSS Generator', 'crafto-addons' ); ?></h1>
			</div>
			<div class="crafto-critical-css-wrap">
				<?php
				if ( ! $crafto_is_theme_license_active ) {
					?>
					<div class="warning-wrap">
						<h3>
							<i class="bi bi-info-circle-fill"></i>
							<?php echo esc_html__( 'Notice: ', 'crafto-addons' ); ?>
							<span>
								<?php
								echo sprintf(
									/* translators: %1$s is the label of activate */

									/* translators: %2$s is the label of theme */
									esc_html__( 'Please %1$s your %2$s theme license to unlock premium features.', 'crafto-addons' ),
									'<a href="' . esc_url( $theme_license_url ) . '">' . esc_html__( 'activate', 'crafto-addons' ) . '</a>',
									esc_html( $crafto_theme_name ),
								);
								?>
							</span>
						</h3>
					</div>
					<?php
					return; // Stop further script execution.
				}
				?>
				<div class="critical-input-wrap">
					<input type="url" id="crafto_critical_css_url" placeholder="<?php echo esc_attr__( 'Enter URL for Critical CSS Generation', 'crafto-addons' ); ?>" style="width: 60%;" />
					<button class="button button-primary" id="crafto_generate_css"><?php echo esc_html__( 'Generate Critical CSS', 'crafto-addons' ); ?></button>
				</div>
				<iframe id="crafto_iframe" style="width: 100%; height: 500px; display: none;"></iframe>
				<div id="crafto_loader" style="display: none; text-align: center;">
					<div class="crafto-spinner"></div>
				</div>
				<h3><?php echo esc_html__( 'List of Optimized URLs', 'crafto-addons' ); ?></h3>
				<?php $critical_css_entries = $this->crafto_get_all_critical_css(); ?>
				<div class="crafto-critical-list-table">
				<div class="crafto-critical-list-table-heading">
					<div class="crafto-list-table-heading taxonomie-col-4">
						<div class="crafto-list-table-heading-cell"><?php echo esc_html__( 'Critical CSS URLs', 'crafto-addons' ); ?></div>
						<div class="crafto-list-table-heading-cell"><?php echo esc_html__( 'Last Generated On', 'crafto-addons' ); ?></div>
						<div class="crafto-list-table-heading-cell"><?php echo esc_html__( 'Manage', 'crafto-addons' ); ?></div>
					</div>
				</div>
				<?php
				if ( ! empty( $critical_css_entries ) ) {
					?>
					<div class="crafto-critical-list-table-items">
						<?php
						foreach ( $critical_css_entries as $entry ) {
							?>
							<div class="crafto-list-table-items">
								<div class="crafto-list-table-item name">
									<a href="<?php echo esc_url( $entry['url'] ); ?>" target="_blank">
										<?php echo esc_html( $entry['url'] ); ?>
									</a>
								</div>
								<div class="crafto-list-table-item time"><?php echo esc_html( $entry['date'] ); ?></div>
								<div class="crafto-list-table-item actions">
									<button class="button crafto-regenerate-css" data-meta-id="<?php echo esc_attr( $entry['meta_id'] ); ?>" data-url="<?php echo esc_url( $entry['url'] ); ?>"><?php echo esc_html__( 'Regenerate CSS', 'crafto-addons' ); ?></button>
									<button class="button crafto-delete-css" data-meta-id="<?php echo esc_attr( $entry['meta_id'] ); ?>" data-url="<?php echo esc_url( $entry['url'] ); ?>"><?php echo esc_html__( 'Delete CSS', 'crafto-addons' ); ?></button>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				} else {
					?>
					<div class="crafto-list-table-item not-found">
						<span><?php echo esc_html__( 'You haven\'t generated Critical CSS for any pages yet.', 'crafto-addons' ); ?></span>
					</div>
					<?php
				}
				?>
				</div>
				<div class="bottom-warning-wrap">
					<h3>
						<?php
						echo sprintf(
							'%1$s<span> %2$s <a href="%3$s">%4$s</a>.</span>',
							esc_html__( 'Important:', 'crafto-addons' ),
							esc_html__( 'Once the CSS is generated, you can enable the feature for optimal performance from Appearance > Customizer > Perfomance Manager > Styles & Scripts > ', 'crafto-addons' ),
							esc_url( get_admin_url() . 'customize.php?autofocus%5Bpanel%5D=crafto_add_perfomance_panel' ),
							esc_html__( 'Critical CSS', 'crafto-addons' ),
						);
						?>
					</h3>
				</div>
			</div>
			<script>
				document.getElementById( 'crafto_generate_css' ).addEventListener( 'click', function() {
					const inputField = document.getElementById( 'crafto_critical_css_url' );
					const checkUrl   = inputField.value;
					const button     = this; // Reference to the button
					const loader     = document.getElementById( 'crafto_loader' ); // Loader element

					if ( ! checkUrl || ! inputField.checkValidity() ) {
						inputField.classList.add( 'input-error' );
						return;
					} else {
						inputField.classList.remove( 'input-error' );
					}

					function fetchPageExists(checkUrl) {
						return fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); // phpcs:ignore. ?>', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/x-www-form-urlencoded'
							},
							body: 'action=check_page_exists&url=' + encodeURIComponent( checkUrl )
						})
						.then( response => response.json())
						.then( data => {
							if ( data.success ) {
								inputField.classList.remove( 'input-error' );
								return true;
							} else {
								inputField.classList.add( 'input-error' );
								return false;
							}
						})
						.catch( error => {
							inputField.classList.add( 'input-error' );
							return false;
						});
					}

					fetchPageExists( checkUrl ).then( exists => {
						if ( ! exists ) {
							inputField.classList.add( 'input-error' );
							return false; // Handle error case
						} else {
							// Show loader above the button
							loader.style.display = 'flex';
							button.disabled      = true; // Disable button while processing

							var craftoIframe = document.getElementById( 'crafto_iframe' );
							craftoIframe.style.display = 'none';
							craftoIframe.src = checkUrl + '?preview=true&nocache=' + new Date().getTime() + '&crafto_iframe=true';

							craftoIframe.onload = function() {
								setTimeout(() => {
									craftoIframe.contentWindow.postMessage({ extractCSS: true }, "*");
								}, 2000 );
							};

							window.addEventListener( 'message', function( event ) {
								if ( event.data && event.data.extractedCSS ) {
									// Send extracted CSS to WordPress via AJAX.
									fetch( '<?php echo esc_url( admin_url( "admin-ajax.php" ) ); // phpcs:ignore. ?>', {
										method : 'POST',
										headers: {
											'Content-Type': 'application/x-www-form-urlencoded'
										},
										body: 'action=crafto_save_extracted_css&css=' + encodeURIComponent( event.data.extractedCSS ) + '&page_url=' + encodeURIComponent( checkUrl )
									}).then( response => response.text() )
									.then( data => {
										location.reload();
									} )
									.catch( error => console.error( 'Error:', error ) )
									.finally( () => {
										// Hide loader and enable button after process is complete
										loader.style.display = 'none';
										button.disabled      = false;
									} );
								}
							});
						}
					});
				});

				// REGENERATE Critical CSS
				document.querySelectorAll( '.crafto-regenerate-css' ).forEach(button => {
					button.addEventListener( 'click', function () {
					const url    = this.getAttribute( 'data-url' );
					const button = this; // Reference to the button
					const loader = document.getElementById( 'crafto_loader' );  // Loader element
						if ( ! url ) {
							alert( 'Invalid URL.' );
							return;
						}

						// Show loader above the button
						loader.style.display = 'flex';
						button.disabled      = true;     // Disable button while processing

						window.addEventListener( 'message', handleMessage, { once: true } );

						var craftoIframe = document.getElementById( 'crafto_iframe' );
						craftoIframe.src = url + '?preview=true&nocache=' + new Date().getTime() + '&crafto_iframe=true';

						craftoIframe.onload = function () {
							setTimeout(() => {
								craftoIframe.contentWindow.postMessage({ extractCSS: true }, "*");
							}, 2000 );
						};

						function handleMessage( event ) {
							if ( event.data && event.data.extractedCSS ) {
								window.removeEventListener( 'message', handleMessage );

								fetch( '<?php echo esc_url( admin_url( "admin-ajax.php" ) ); // phpcs:ignore. ?>', {
									method: 'POST',
									headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
									body: new URLSearchParams({
										action: 'crafto_update_existing_css',
										css: event.data.extractedCSS,
										page_url: url
									})
								})
								.then( response => response.json() )
								.then( data => {
									if ( data.success ) {
										location.reload();
									} else {
										alert( 'Error updating CSS: ' + data.data.message );
									}
								})
								.catch( error => console.error( 'Error:', error ) )
								.finally(() => {
									// Hide loader and enable button after process is complete
									loader.style.display = 'none';
									button.disabled      = false;
								});
							}
						}
					});
				});

				// DELETE Critical CSS
				document.querySelectorAll( '.crafto-delete-css' ).forEach( button => {
					button.addEventListener( 'click', function () {
					const url    = this.getAttribute( 'data-url' ); // Get URL from the button
					const button = this; // Reference to the button
					const loader = document.getElementById( 'crafto_loader' ); // Loader element

						if ( ! url ) {
							alert( 'Invalid URL.' );
							return;
						}

						if ( ! confirm( 'Are you sure you want to delete this CSS entry?' ) ) {
							return;
						}

						// Show loader above the button
						loader.style.display = 'flex';
						button.disabled      = true; // Disable button while processing

						fetch('<?php echo esc_url( admin_url( "admin-ajax.php" ) ); // phpcs:ignore. ?>', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/x-www-form-urlencoded'
							},
							body: 'action=crafto_delete_css_entry&page_url=' + encodeURIComponent( url )
						})
						.then( response => response.json() )
						.then( data => {
							if ( data.success ) {
								location.reload();
							} else {
								alert( 'Error deleting CSS: ' + data.data.message );
							}
						})
						.catch( error => console.error( 'Error:', error ) )
						.finally(() => {
							// Hide loader and enable button after process is complete
							loader.style.display = 'none';
							button.disabled      = false;
						});
					});
				});

				// Remove 'inputerror' class when the user focuses on the input field
				document.getElementById( 'crafto_critical_css_url' ).addEventListener( 'focus', function () {
					this.classList.remove( 'inputerror' );
				});
			</script>
			<?php
		}

		/**
		 * Critical Inline CSS page.
		 */
		public function crafto_critical_inline_styles() {
			?>
			<style>
				.crafto-page-layout,
				.footer-sticky,
				.footer-main-wrapper,
				.theme-demos,
				.hamburger-menu-wrapper,
				.site-header svg,
				.mini-header-main-wrapper svg,
				.crafto-cookie-policy-wrapper,
				.verticalbar-wrap,
				header .elementor-widget,
				header .elementor-widget-crafto-button {
					visibility: hidden;
					opacity: 0;
				}

				.crafto-theme-ready .crafto-page-layout,
				.crafto-theme-ready .footer-sticky,
				.crafto-theme-ready .footer-main-wrapper,
				.crafto-theme-ready .theme-demos,
				.crafto-theme-ready .hamburger-menu-wrapper,
				.crafto-theme-ready .site-header svg,
				.crafto-theme-ready .mini-header-main-wrapper svg,
				.crafto-theme-ready .crafto-cookie-policy-wrapper,
				.crafto-theme-ready .verticalbar-wrap,
				.crafto-theme-ready header .elementor-widget,
				.crafto-theme-ready header .elementor-widget-crafto-button {
					visibility: visible;
					opacity: 1;
				}

				body:not(.crafto-theme-ready) .crafto-page-layout,
				body:not(.crafto-theme-ready) .footer-sticky,
				body:not(.crafto-theme-ready) .footer-main-wrapper,
				body:not(.crafto-theme-ready) .theme-demos,
				body:not(.crafto-theme-ready) .hamburger-menu-wrapper,
				body:not(.crafto-theme-ready) .site-header svg,
				body:not(.crafto-theme-ready) .mini-header-main-wrapper svg,
				body:not(.crafto-theme-ready) .crafto-cookie-policy-wrapper,
				body:not(.crafto-theme-ready) .verticalbar-wrap,
				body:not(.crafto-theme-ready) header .elementor-widget,
				body:not(.crafto-theme-ready) header .elementor-widget-crafto-button {
					transition: opacity 250ms ease-in, visibility 0ms ease-in 250ms;
				}
			</style>
			<?php
		}

		/**
		 * Critical CSS Url Check.
		 */
		public function crafto_check_page_exists() {

			set_theme_mod( 'crafto_preload_critical_css', '0' );

			if ( empty( $_POST['url'] ) ) { // phpcs:ignore.
				wp_send_json_error(
					[
						'exists'  => false,
						'message' => esc_html__( 'No URL provided.', 'crafto-addons' ),
					]
				);
				wp_die();
			}

			$url         = esc_url_raw( $_POST['url'] ); // phpcs:ignore.
			$home_url    = home_url();
			$home_host   = parse_url( $home_url, PHP_URL_HOST ); // phpcs:ignore.
			$home_path   = trim( parse_url( $home_url, PHP_URL_PATH ), '/' ); // phpcs:ignore.
			$parsed_url  = wp_parse_url( $url );
			$request_uri = trim( $parsed_url['path'] ?? '', '/' );

			// Validate host.
			if ( empty( $parsed_url['host'] ) || $parsed_url['host'] !== $home_host ) {
				wp_send_json_error(
					[
						'exists'  => false,
						'message' => esc_html__( 'URL does not belong to this site.', 'crafto-addons' ),
					]
				);
				wp_die();
			}

			// Normalize homepage path.
			if ( $request_uri === $home_path || '' === $request_uri ) {
				wp_send_json_success(
					[
						'exists'  => true,
						'message' => esc_html__( 'Homepage found.', 'crafto-addons' ),
					]
				);
				wp_die();
			}

			// Check for post/page ID.
			$post_id = url_to_postid( $url );
			if ( $post_id ) {
				wp_send_json_success(
					[
						'exists'  => true,
						'message' => esc_html__( 'Page/Post found.', 'crafto-addons' ),
					]
				);
				wp_die();
			}

			// Try simulating the request via WP.
			$request_path           = '/' . $request_uri;
			$_SERVER['REQUEST_URI'] = $request_path;

			global $wp;
			$wp->main();

			if ( is_home() || is_archive() || is_post_type_archive() || is_category() || is_tag() || is_author() || is_date() || is_search() || is_page() || ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_cart' ) && is_cart() ) || ( function_exists( 'is_checkout' ) && is_checkout() ) ) {
				wp_send_json_success(
					[
						'exists'  => true,
						'message' => esc_html__( 'Valid archive or special page found.', 'crafto-addons' ),
					]
				);
				wp_die();
			}

			$response = wp_remote_head( $url );
			if ( ! is_wp_error( $response ) && wp_remote_retrieve_response_code( $response ) === 200 ) {
				wp_send_json_success(
					[
						'exists'  => true,
						'message' => esc_html__( 'Valid page detected (via HTTP fallback).', 'crafto-addons' ),
					]
				);
				wp_die();
			}

			wp_send_json_error(
				[
					'exists'  => false,
					'message' => esc_html__( 'URL not found.', 'crafto-addons' ),
				]
			);
			wp_die();
		}


		/**
		 * Critical CSS extract through javascript.
		 */
		public function crafto_enqueue_extraction_script() {
			?>
			<script>
				window.addEventListener( 'message', function ( event ) {
					if ( event.data && event.data.extractCSS ) {
						const usedSelectors = new Set();

						// Get all visible elements in the viewport
						document.querySelectorAll( '*' ).forEach( el => {
							const rect = el.getBoundingClientRect();

							if (
								rect.bottom >= 0 &&
								rect.top <= window.innerHeight &&
								getComputedStyle(el).display !== 'none' &&
								getComputedStyle(el).visibility !== 'hidden' &&
								getComputedStyle(el).opacity !== '0'
							)
							{

								usedSelectors.add( el.tagName.toLowerCase() );
								el.classList.forEach( cls => usedSelectors.add( '.' + cls ) );
								if ( el.id ) usedSelectors.add( '#' + el.id );
							}
						});

						// Extract only CSS rules that match used elements
						const extractedCSS = Array.from( document.styleSheets )
							.filter( sheet => {
								try {
									return !!sheet.cssRules; // Avoid CORS errors
								} catch ( err ) {
									console.log( `CORS restriction: Unable to access "${sheet.href}"` );
									return false;
								}
							})
							.map( sheet => Array.from( sheet.cssRules )
								.map( rule => {
									try {
										if ( rule.type === CSSRule.FONT_FACE_RULE ) {
											return null; // Exclude @font-face
										} else if ( rule.type === CSSRule.STYLE_RULE ) {
											try {
												const elements = document.querySelectorAll(rule.selectorText);
												for (const el of elements) {
													const rect = el.getBoundingClientRect();
													if (rect.top >= 0 && rect.bottom <= window.innerHeight && getComputedStyle(el).display !== 'none') {
														return rule.cssText;
													}
												}
											} catch (e) {
												console.log( `Something went wrong.` );
											}
											return null;
										} else if ( rule.type === CSSRule.MEDIA_RULE ) {
											const mediaCSS = Array.from( rule.cssRules )
												.map( mediaRule => usedSelectors.has( mediaRule.selectorText ) ? mediaRule.cssText : null )
												.filter( Boolean )
												.join( ' ' );
											return mediaCSS ? `@media ${rule.conditionText} {${mediaCSS}}` : null;
										}
										return null;
									} catch ( e ) {
										console.warn( `Skipping rule due to error: ${e.message}` );
										return null;
									}
								})
							)
							.flat()
							.filter( rule => rule != null )
							.join(' ');

						window.parent.postMessage( { extractedCSS }, "*" );
					}
				});
			</script>
			<?php
		}

		/**
		 * Hide and show admin bar in critical css admin page if critical CSS iframe is loading.
		 */
		public function crafto_hide_admin_bar_for_iframe() {
			if ( isset( $_GET['crafto_iframe'] ) && $_GET['crafto_iframe'] === 'true' ) { // phpcs:ignore.
				add_filter( 'show_admin_bar', '__return_false' );
			}
		}

		/**
		 * Prevent to redirect.
		 */
		public function crafto_allow_iframe_access() {
			if ( isset( $_SERVER['HTTP_REFERER'] ) && strpos( $_SERVER['HTTP_REFERER'], 'crafto-theme-critical-css') !== false ) { // phpcs:ignore.
				remove_action( 'template_redirect', 'wp_redirect_admin_locations', 10, 2 );
			}
		}

		/**
		 * Extracted Critical CSS update in the database.
		 */
		public function crafto_save_extracted_css() {
			if ( isset( $_POST['css'] ) && isset( $_POST['page_url'] ) ) { // phpcs:ignore.
				global $wpdb;
				$css       = wp_strip_all_tags( $_POST['css'] ); // phpcs:ignore.
				$page_url  = esc_url_raw( $_POST['page_url'] ); // phpcs:ignore.
				$timestamp = gmdate( 'F j, Y H:i:s A' );

				/**
				 * Function to normalize URL by removing trailing slash.
				 *
				 * @param object $url get data.
				 */
				function normalize_url( $url ) {
					if ( ! is_string( $url ) ) {
						return ''; // Return empty string if not a valid URL.
					}
					return rtrim( $url, '/' ); // Removes trailing slash.
				}

				// Normalize input URL.
				$page_url = normalize_url( $page_url );

				// Check if the URL already exists in any stored options.
				$option_keys = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'crafto_critical_css_%'" ); // phpcs:ignore.

				foreach ( $option_keys as $option_key ) {
					$existing_data = get_option( $option_key, [] );

					foreach ( $existing_data as $entry ) {
						if ( isset( $entry['url'] ) && normalize_url( $entry['url'] ) === $page_url ) {
							wp_send_json_error(
								[
									'message' => esc_html__( 'This URL already exists!.', 'crafto-addons' ),
								]
							);
							wp_die();
						}
					}
				}

				// If URL doesn't exist, proceed to save it.
				$meta_id  = count( $option_keys ) + 1;
				$new_data = [
					'url'  => $page_url,
					'date' => $timestamp,
					'css'  => wp_unslash( $css ),
				];

				update_option( "crafto_critical_css_{$meta_id}", [ $meta_id => $new_data ] );

				wp_send_json_success(
					[
						'message' => esc_html__( 'CSS saved successfully!', 'crafto-addons' ),
					]
				);
			} else {
				wp_send_json_error(
					[
						'message' => esc_html__( 'Error: No CSS data received!', 'crafto-addons' ),
					]
				);
			}
			wp_die();
		}

		/**
		 * Load extracted Critical CSS internally to frontend.
		 */
		public function crafto_load_saved_critical_css() {
			$crafto_preload_critical_css = get_theme_mod( 'crafto_preload_critical_css', '0' );
			if ( ! is_user_logged_in() && '1' === $crafto_preload_critical_css && ! isset( $_GET['crafto_iframe'] ) ) { // phpcs:ignore.

				global $wpdb, $wp;

				$option_keys = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'crafto_critical_css_%'" ); // phpcs:ignore.
				$current_url = home_url( add_query_arg( [], $wp->request ) );
				$printed     = false;
				foreach ( $option_keys as $options ) {
					$saved_critical_css = get_option( $options, '' );

					foreach ( $saved_critical_css as $critical ) {
						if ( ! $printed ) {
							$printed = true;
						}

						if ( isset( $critical['url'] ) && untrailingslashit( $critical['url'] ) === $current_url ) {
							echo '<style id="crafto-critical-css">' . wp_strip_all_tags( wp_specialchars_decode( $critical['css'] ) ) . '</style>'; // phpcs:ignore.
							break 2;
						}
					}
				}
			}
		}

		/**
		 * Crafto Get all Critical Css.
		 */
		public function crafto_get_all_critical_css() {
			global $wpdb;

			$option_names = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'crafto_critical_css_%'" ); // phpcs:ignore.
			$critical_css_entries = [];
			foreach ( $option_names as $option_name ) {
				$option_data = get_option( $option_name, [] );

				if ( is_array( $option_data ) ) {
					foreach ( $option_data as $meta_id => $entry ) {
						if ( isset( $entry['url'], $entry['date'], $entry['css'] ) ) {
							$critical_css_entries[] = [
								'meta_id' => $meta_id,
								'url'     => esc_url( $entry['url'] ),
								'date'    => esc_html( $entry['date'] ),
								'css'     => esc_html( $entry['css'] ),
							];
						}
					}
				}
			}

			return $critical_css_entries;
		}

		/**
		 * Crafto Update Existing Css.
		 */
		public function crafto_update_existing_css() {

			if ( ! isset( $_POST['css'] ) || ! isset( $_POST['page_url'] ) ) { // phpcs:ignore.
				wp_send_json_error(
					[
						'message' => esc_html__( 'Missing parameters.', 'crafto-addons' ),
					]
				);
			}
			set_theme_mod( 'crafto_preload_critical_css', '0' );

			$css      = wp_unslash( $_POST['css'] ); // phpcs:ignore.
			$page_url = esc_url_raw( $_POST['page_url'] ); // phpcs:ignore.

			global $wpdb;
			$option_keys = $wpdb->get_col( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'crafto_critical_css_%'" ); // phpcs:ignore.

			$matched_key = null;
			foreach ( $option_keys as $option_key ) {
				$option_data = get_option( $option_key, [] );
				if ( ! empty( $option_data ) && is_array( $option_data ) ) {
					foreach ( $option_data as $id => $entry ) {
						if ( isset( $entry['url'] ) && $entry['url'] === $page_url ) {
							$matched_key = $option_key;
							$meta_id     = $id;
							break 2;
						}
					}
				}
			}

			if ( ! $matched_key ) {
				wp_send_json_error(
					[
						'message' => esc_html__( 'No matching entry found.', 'crafto-addons' ),
					]
				);
			}

			$option_data[ $meta_id ]['css']  = $css;
			$option_data[ $meta_id ]['date'] = gmdate( 'F j, Y H:i:s A' );

			update_option( $matched_key, $option_data );

			wp_send_json_success(
				[
					'message' => esc_html__( 'CSS updated successfully.', 'crafto-addons' ),
				]
			);
		}

		/**
		 * Crafto Delete Css Entry.
		 */
		public function crafto_delete_css_entry() {
			if ( ! isset( $_POST['page_url'] ) ) { // phpcs:ignore.
				wp_send_json_error(
					[
						'message' => esc_html__( 'Missing URL parameter.', 'crafto-addons' ),
					]
				);
			}
			$page_url = esc_url_raw( $_POST['page_url'] ); // phpcs:ignore.

			global $wpdb;
			$option_keys = $wpdb->get_col( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE 'crafto_critical_css_%'" ); // phpcs:ignore.
			if ( ! $option_keys ) {
				wp_send_json_error(
					[
						'message' => esc_html__( 'No CSS entries found.', 'crafto-addons' ),
					]
				);
			}

			foreach ( $option_keys as $key ) {
				$entries = get_option( $key, [] );

				if ( ! is_array( $entries ) ) {
					continue;
				}

				foreach ( $entries as $id => $entry ) {
					if ( isset( $entry['url'] ) && $entry['url'] === $page_url ) {

						unset( $entries[ $id ] );

						if ( empty( $entries ) ) {
							delete_option( $key );
						} else {
							update_option( $key, $entries );
						}

						wp_send_json_success(
							[
								'message' => esc_html__( 'CSS deleted successfully.', 'crafto-addons' ),
							]
						);
					}
				}
			}

			wp_send_json_error(
				[
					'message' => esc_html__( 'No matching CSS entry found.', 'crafto-addons' ),
				]
			);
		}

		/**
		 * Enqueue scripts and styles admin side
		 */
		public function crafto_admin_enqueue_critical_style_script() {
			if ( isset( $_GET['page'] ) && 'crafto-theme-critical-css' === $_GET['page'] ) { // phpcs:ignore.
				wp_register_style(
					'bootstrap-icons',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/bootstrap-icons.min.css',
					[],
					'1.11.3'
				);
				wp_enqueue_style( 'bootstrap-icons' );

				wp_register_style(
					'crafto-critical-admin-style',
					CRAFTO_ADDONS_CSS_URI . '/admin/crafto-critical-admin-style.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-critical-admin-style' );

				if ( is_rtl() ) {
					wp_register_style(
						'crafto-critical-admin-style-rtl',
						CRAFTO_ADDONS_CSS_URI . '/admin/crafto-critical-admin-style-rtl.css',
						[],
						CRAFTO_ADDONS_PLUGIN_VERSION
					);
					wp_enqueue_style( 'crafto-critical-admin-style-rtl' );
				}
			}
		}
	}

	new Crafto_Critical_CSS();
}
