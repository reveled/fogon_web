<?php
/**
 * Crafto Importer Class
 *
 * Handles the import process for sample data, including posts, pages, theme builder templates,
 * Elementor templates, menus, and other site content.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Crafto_Importer' ) ) {
	/**
	 * Crafto importer class.
	 */
	class Crafto_Importer {
		/**
		 * Class Constructor
		 */
		public function __construct() {
			add_filter( 'woocommerce_create_pages', '__return_false' );
			add_action( 'admin_enqueue_scripts', array( $this, 'crafto_demo_import_script_style' ) );
			add_action( 'crafto_demo_import_callback', array( $this, 'crafto_demo_import_callback' ) );
			// Hook For Import Sample Data & Log Messages.
			add_action( 'wp_ajax_crafto_import_sample_data', array( $this, 'crafto_import_sample_data' ) );
			add_action( 'wp_ajax_crafto_refresh_import_log', array( $this, 'crafto_refresh_import_log' ) );

			add_action( 'wp_ajax_crafto_import_popup_panel', array( $this, 'crafto_import_popup_panel' ) );
			add_action( 'wp_ajax_nopriv_crafto_import_popup_panel', array( $this, 'crafto_import_popup_panel' ) );
		}

		/**
		 * Enqueue scripts for import functionality
		 *
		 * @param string $hook Action hook to execute when the event is run.
		 */
		public function crafto_demo_import_script_style( $hook ) {
			if ( is_admin() && ( 'toplevel_page_crafto-theme-setup' === $hook || 'crafto_page_crafto-theme-setup-wizard' === $hook || 'crafto_page_crafto-theme-setup-reset-demo' === $hook || 'crafto_page_crafto-theme-setup-update-plugin' === $hook ) ) {

				wp_register_style(
					'mCustomScrollbar',
					CRAFTO_ADDONS_VENDORS_CSS_URI . '/jquery.mCustomScrollbar.min.css',
					[],
					'3.1.5'
				);
				wp_enqueue_style( 'mCustomScrollbar' );

				wp_register_script(
					'mCustomScrollbar',
					CRAFTO_ADDONS_VENDORS_JS_URI . '/jquery.mCustomScrollbar.concat.min.js',
					[],
					'3.1.13',
					true
				);
				wp_enqueue_script( 'mCustomScrollbar' );

				wp_register_script(
					'crafto-import',
					CRAFTO_ADDONS_ROOT_URI . '/importer/assets/js/import.js',
					array(
						'jquery',
						'mCustomScrollbar',
					),
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);
				wp_enqueue_script( 'crafto-import' );

				wp_localize_script(
					'crafto-import',
					'craftoImport',
					array(
						'full_import_confirmation' => esc_html__( 'Are you sure you want to proceed? It will skip matching items and add new ones.', 'crafto-addons' ),
						'importing'                => esc_html__( 'Importing', 'crafto-addons' ),
						'import_finished'          => esc_html__( 'Importing', 'crafto-addons' ),
						'no_single_layout'         => esc_html__( 'Please choose at least one item from the list to import.', 'crafto-addons' ),
						'redirect_after_import'    => admin_url( 'admin.php?page=crafto-theme-setup-wizard&step=import-success' ),
						'tgm_plugin_nonce'         => array(
							'update'  => wp_create_nonce( 'tgmpa-update' ),
							'install' => wp_create_nonce( 'tgmpa-install' ),
						),
					),
				);
			}
		}

		/**
		 * Demo import callback
		 *
		 * @param string $step step for process.
		 * @return void
		 */
		public function crafto_demo_import_callback( $step ) {
			if ( 'import-demo' === $step ) {
				/** WXR_Parser class */
				if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser.php' ) ) {
					require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';
				}

				/** WXR_Parser_SimpleXML class */
				if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php' ) ) {
					require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';
				}

				/** WXR_Parser_XML class */
				if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php' ) ) {
					require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';
				}

				/** WXR_Parser_Regex class */
				if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php' ) ) {
					require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';
				}

				$parser = new WXR_Parser();
				?>
				<div class="demo-data-import-main-popup"></div>
				<?php
				if ( is_crafto_addons_activated() && is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) {
					?>
					<div class="import-content import-content-tab-box import-content-notices">
						<h3>
							<i class="bi bi-info-circle-fill"></i>
							<?php echo esc_html__( 'Notice: ', 'crafto-addons' ); ?>
							<span><?php echo esc_html__( 'Please deactivate WordPress Importer plugin and then try demo data import to make it run successfully.', 'crafto-addons' ); ?></span>
						</h3>
					</div>
					<?php
				} else {
					$demo_listing = $this->import_data_collection();
					?>
					<div class="import-content-wrap">
						<?php
						if ( ! empty( $demo_listing ) ) {
							?>
							<div class="import-inner-content-popup-wrap">
								<div class="import-demo-list">
									<ul id="demo-list">
										<?php
										foreach ( $demo_listing as $key => $value ) {
											if ( 'landing' === $key ) {
												$common_site_url = CRAFTO_ADDONS_DEMO_URI;
											} else {
												$common_site_url = CRAFTO_ADDONS_DEMO_URI . $key;
											}
											?>
											<li class="<?php echo esc_attr( $key ); ?>-demo">
												<div class="import-inner-content-wrap">
													<div class="import-image-wrap">
														<img src="<?php echo esc_url( CRAFTO_ADDONS_ROOT_URI . '/importer/assets/images/demo-' . $key . '.jpg' ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" />
													</div>
													<div class="title-wrap">
														<h3><?php echo esc_html( $value['name'] ); ?></h3>
														<div class="preview-button">
															<a demo-popup-key="<?php echo esc_attr( $key ); ?>" demo-popup-name="<?php echo esc_attr( $value['name'] ); ?>" class="import-button crafto-demo-import-popup" href="javascript:void(0);">
																<?php echo esc_html__( 'Import', 'crafto-addons' ); ?>
															</a>
															<a class="import-button crafto-demo-import-preview" href="<?php echo esc_url( $common_site_url ); ?>" target="_blank"><?php echo esc_html__( 'Preview', 'crafto-addons' ); ?></a>
														</div>
													</div>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
							</div>
							<div id="no-results-message"><?php echo esc_html__( 'No demos found matching your search.', 'crafto-addons' ); ?></div>
							<?php
						} else {
							$message = esc_html__( 'Something went wrong with the import content. Please refresh the page and try again!', 'crafto-addons' );
							printf( '<div class="import-content-notices"><h3><span>%1$s</span></h3></div>', $message );// phpcs:ignore
						}
						?>
					</div>
					<?php
				}
			}
		}

		/**
		 * Undocumented function
		 */
		public function import_data_collection() {
			global $wp_filesystem;

			require_once ABSPATH . '/wp-admin/includes/file.php';

			WP_Filesystem();

			$local_file = CRAFTO_ADDONS_IMPORT . '/collection.json';

			$collection_json = '';
			if ( $wp_filesystem->exists( $local_file ) ) {
				$collection_json = $wp_filesystem->get_contents( $local_file );
			}

			$data_array = json_decode( $collection_json, true );

			if ( null === $data_array ) {
				return array();
			}

			return $data_array;
		}

		/**
		 * Undocumented function
		 *
		 * @return void
		 */
		public function crafto_import_popup_panel() {
			$data = $this->import_data_collection();
			$key  = isset( $_POST['demo_key'] ) & ! empty( $_POST['demo_key'] ) ? $_POST['demo_key'] : ''; // phpcs:ignore

			if ( ! empty( $key ) && ! empty( $data ) ) {
				if ( ! empty( $data[ $key ] ) ) {
					$demo_name        = isset( $data[ $key ]['name'] ) & ! empty( $data[ $key ]['name'] ) ? $data[ $key ]['name'] : '';
					$demo_live_url    = isset( $data[ $key ]['url'] ) & ! empty( $data[ $key ]['url'] ) ? $data[ $key ]['url'] : '';
					$required_plugins = isset( $data[ $key ]['plugins'] ) & ! empty( $data[ $key ]['plugins'] ) ? $data[ $key ]['plugins'] : '';
					$import_post_type = isset( $data[ $key ]['import_post_type'] ) & ! empty( $data[ $key ]['import_post_type'] ) ? $data[ $key ]['import_post_type'] : array();
					$import_plugins   = isset( $data[ $key ]['import_plugins'] ) & ! empty( $data[ $key ]['import_plugins'] ) ? $data[ $key ]['import_plugins'] : array();

					// Full Import Data Layout Start.
					ob_start();
					?>
					<div class="import-content-full-wrap active-tab">
						<div class="import-content-full-inner-wrap">
							<div class="demo-import-wrapper">
								<div class="demo-preview-image">
									<img src="<?php echo esc_url( CRAFTO_ADDONS_ROOT_URI . '/importer/assets/images/demo-' . esc_attr( $key ) . '.jpg' ); ?>" alt="<?php echo esc_attr( $key ); ?>" />
								</div>
								<div class="demo-import-content-part">
									<button class="btn-import-cancel"><i class="bi bi-x"></i></button>
									<div class="crafto-full-import-choice-wrap">
										<h2><?php echo sprintf( '%s', esc_html( $demo_name ) ); ?></h2>
										<div class="crafto-core-separator"><?php echo esc_html__( 'The following plugins are required or recommended to import this demo.', 'crafto-addons' ); ?></div>
										<ul class="crafto-drawer pluings-all">
										<?php
										if ( ! empty( $required_plugins ) ) {
											foreach ( $required_plugins as $plugin ) {
												?>
												<li data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>">
													<label><?php echo esc_html( $plugin['name'] ); ?></label>
													<?php
													$plugin_file = WP_PLUGIN_DIR . '/' . $plugin['path'];
													if ( file_exists( $plugin_file ) ) {
														if ( is_plugin_active( $plugin['path'] ) ) {
															?>
															<span><?php echo esc_html__( 'Active', 'crafto-addons' ); ?></span>
															<?php
														} else {
															?>
															<input type="checkbox" name="default_plugins[<?php echo esc_attr( $plugin['slug'] ); ?>]" class="checkbox" id="default_plugins_<?php echo esc_attr( $plugin['slug'] ); ?>" value="1" checked >
															<span class="plugin-main-wrapper single-plugin-install"><span><?php echo esc_html__( 'Active', 'crafto-addons' ); ?></span></span>
															<?php
														}
													} else {
														?>
														<input type="checkbox" name="default_plugins[<?php echo esc_attr( $plugin['slug'] ); ?>]" class="checkbox" id="default_plugins_<?php echo esc_attr( $plugin['slug'] ); ?>" value="1" checked >
														<span class="plugin-main-wrapper single-plugin-install"><span><?php echo esc_html__( 'Install', 'crafto-addons' ); ?></span></span>
														<?php
													}
													?>
												</li>
												<?php
											}
										}
										?>
										</ul>
										<div class="crafto-import-choice">
											<ul class="import-choice-left">
											<?php
											$import_choices = array(
												'posts' => esc_html__( 'Posts', 'crafto-addons' ),
												'pages' => esc_html__( 'Pages', 'crafto-addons' ),
											);

											// $import_post_type - portfolio, property, tours, products, course.
											if ( ! empty( $import_post_type ) ) {
												foreach ( $import_post_type as $import_post_type_array ) {
													if ( ! empty( $import_post_type_array ) ) {
														foreach ( $import_post_type_array as $key1 => $value ) {
															$import_choices[ $key1 ] = $value;
														}
													}
												}
											}

											$import_choices['widgets']         = esc_html__( 'WordPress Widgets', 'crafto-addons' );
											$import_choices['navigation_menu'] = esc_html__( 'Navigation Menu Items', 'crafto-addons' );
											$import_choices['contact_forms']   = esc_html__( 'Contact Form', 'crafto-addons' );

											foreach ( $import_choices as $key_choice => $value_choice ) {
												$hidden_cls = '';
												$checked    = ' checked';

												if ( ! is_woocommerce_activated() && 'products' === $key_choice ) {
													$hidden_cls = ' class="hidden"';
													$checked    = '';
												}

												if ( ! class_exists( 'LearnPress' ) && 'course' === $key_choice ) {
													$hidden_cls = ' class="hidden"';
													$checked    = '';
												}

												if ( ! class_exists( 'Give' ) && 'givewp' === $key_choice ) {
													$hidden_cls = ' class="hidden"';
													$checked    = '';
												}

												if ( 'contact_forms' === $key_choice ) {
													if ( ! array_key_exists( 'contact_forms', $import_plugins ) ) {
														$hidden_cls = ' class="hidden"';
														$checked    = '';
													} elseif ( ! is_contact_form_7_activated() ) {
														$hidden_cls = ' class="hidden"';
														$checked    = '';
													}
												}
												?>
												<li<?php echo $hidden_cls; // phpcs:ignore ?>>
													<input id="<?php echo esc_attr( $key_choice ); ?>"<?php echo esc_attr( $checked ); ?> type="checkbox" class="crafto-checkbox" value="<?php echo esc_attr( $key_choice ); ?>" data-label="<?php echo esc_attr( $value_choice ); ?>">
													<label for="<?php echo esc_attr( $key_choice ); ?>"><?php echo esc_attr( $value_choice ); ?></label>
												</li>
												<?php
											}
											?>
											</ul>
											<?php
											$import_choices_general = array(
												'elementor_library' => esc_html__( 'Elementor Templates', 'crafto-addons' ),
												'default_kit' => esc_html__( 'Elementor Global Kit', 'crafto-addons' ),
												'theme_builder' => esc_html__( 'Theme Builder', 'crafto-addons' ),
												'customizer' => esc_html__( 'Theme Options', 'crafto-addons' ),
												'rev_slider' => esc_html__( 'Slider Revolution', 'crafto-addons' ),
												'media' => esc_html__( 'Media (Attachment)', 'crafto-addons' ),
											);

											$elementor_el = array(
												'elementor_library',
												'theme_builder',
												'default_kit',
											);
											?>
											<ul class="import-choice-right">
												<?php
												foreach ( $import_choices_general as $key_choice => $value_choice ) {
													$hidden_cls = '';
													$checked    = ' checked';

													if ( 'rev_slider' === $key_choice ) {
														if ( ! array_key_exists( 'rev_slider', $import_plugins ) ) {
															$hidden_cls = ' class="hidden"';
															$checked    = '';
														} elseif ( ! is_revolution_slider_activated() ) {
															$hidden_cls = ' class="hidden"';
															$checked    = '';
														}
													}

													if ( ! is_elementor_activated() && in_array( $key_choice, $elementor_el, true ) ) {
														$hidden_cls = ' class="hidden"';
														$checked    = '';
													}
													?>
													<li<?php echo $hidden_cls; // phpcs:ignore ?>>
														<input id="<?php echo esc_attr( $key_choice ); ?>"<?php echo esc_attr( $checked ); ?> type="checkbox" class="crafto-checkbox" value="<?php echo esc_attr( $key_choice ); ?>" data-label="<?php echo esc_attr( $value_choice ); ?>">
														<label for="<?php echo esc_attr( $key_choice ); ?>"><?php echo esc_attr( $value_choice ); ?></label>
													</li>
													<?php
												}
												?>
											</ul>
										</div>
									</div>
									<div class="import-content-top">
										<a data-demo-import="full" demo-data="<?php echo $key; // phpcs:ignore ?>" class="crafto-import-button crafto-demo-import" href="javascript:void(0);"><span><?php echo esc_html__( 'Import Demo', 'crafto-addons' ); ?></span></a>
									</div>
									<div class="crafto-regenerate-notice">
										<?php // phpcs:ignore ?>
										<span><?php echo esc_html__( 'Now, please install and run', 'crafto-addons'); ?> <a title="<?php echo esc_html__( 'Regenerate Thumbnails', 'crafto-addons' ); ?>" href="<?php echo admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=830&amp;height=472' ); ?>"><?php echo esc_html__( 'Regenerate Thumbnails', 'crafto-addons' ); ?></a> <?php echo esc_html__( 'plugin once.', 'crafto-addons' ); ?>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php
					$output_string = ob_get_contents();
					ob_end_clean();
					$response = array(
						'status' => 'success',
						'html'   => $output_string,
					);
					wp_send_json( $response );
				}
			}
			wp_die();
		}

		/**
		 * Import Full data like ( media, posts, pages, products, navigation menu, Theme Builder, contact forms ).
		 *
		 * @return void
		 */
		public function crafto_import_sample_data() {
			global $wpdb, $wp_rewrite;

			$from = rtrim( CRAFTO_ADDONS_DEMO_URI, '/' );
			$to   = rtrim( site_url(), '/' );

			if ( current_user_can( 'manage_options' ) && ! is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) {
				/* Load WP Importer */
				if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
					define( 'WP_LOAD_IMPORTERS', true );
				}

				/* Check if main importer class doesn't exist */
				if ( ! class_exists( 'WP_Importer' ) ) {
					$wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
					include $wp_importer;
				}

				// If WP importer doesn't exist.
				if ( ! class_exists( 'WP_Import' ) ) {
					$wp_import = CRAFTO_ADDONS_IMPORT . '/wordpress-importer.php';

					if ( file_exists( $wp_import ) ) {
						include $wp_import;
					}
				}

				// Check for main import class and wp import class.
				// Demo_key means demo wise import.
				if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
					// Import demo data.
					if ( isset( $_POST['demo_key'] ) && ! empty( $_POST['demo_key'] ) ) { // phpcs:ignore
						$demo_key           = $_POST['demo_key']; // phpcs:ignore
						$full_import_option = ! empty( $_POST['full_import_options'] ) ? $_POST['full_import_options'] : ''; // phpcs:ignore

						add_filter( 'intermediate_image_sizes_advanced', array( $this, 'crafto_no_image_resize' ) );
						add_filter( 'upload_mimes', array( $this, 'crafto_set_svg_mimes' ) );
						add_filter( 'elementor/files/allow_unfiltered_upload', [ $this, 'crafto_allow_unfiltered_uploads' ] );

						// Import Full data like ( media, posts, pages, products, navigation menu, Theme Builder, contact forms ).
						if ( ! empty( $full_import_option ) ) {
							$post_xml_keys = array(
								'posts',
								'pages',
								'portfolio',
								'property',
								'tours',
								'products',
								'course',
								'elementor_library',
								'theme_builder',
								'mega_menu',
								'navigation_menu',
								'contact_forms',
								'media',
								'default_kit',
							);

							// Import Sample Data XML.
							$importer = new WP_Import();

							// Import Posts, Pages, Product Content, Images, Menus.
							$importer->import_menu       = true;
							$importer->fetch_attachments = true;

							if ( in_array( $full_import_option, $post_xml_keys, true ) ) {
								$sample_data_navigation_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/' . $full_import_option . '.xml';
								if ( file_exists( $sample_data_navigation_xml ) ) {
									// Delete old imported menu post data.
									if ( 'navigation_menu' === $full_import_option ) {
										$post_data = $wpdb->get_results( "SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $wpdb->escape( '_crafto_menu_import_data' ) . "' AND meta_value='1'" ); // phpcs:ignore
										if ( ! empty( $post_data ) ) {
											foreach ( $post_data as $key => $value ) {
												if ( ! empty( $value ) && ! empty( $value->post_id ) ) {
													wp_delete_post( $value->post_id );
												}
											}
										}
									}

									// Delete auto generated form data.
									if ( 'contact_forms' === $full_import_option ) {
										$form = get_page_by_path( 'contact-form-1', OBJECT, 'wpcf7_contact_form' );
										if ( $form ) {
											wp_delete_post( $form->ID, true );
										}
									}

									// Delete auto generated "hello world" post.
									if ( 'posts' === $full_import_option ) {
										$hello_world = get_page_by_path( 'hello-world', OBJECT, 'post' );
										if ( $hello_world ) {
											wp_delete_post( $hello_world->ID, true );
										}
									}

									// Import Woocommerce data if WooCommerce plugin is activated and selected option from full import.
									if ( is_woocommerce_activated() && 'products' === $full_import_option ) {
										// Before Import Sample Data Add Woocommerce Attribute.
										$old_attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . 'woocommerce_attribute_taxonomies' ); // phpcs:ignore

										if ( empty( $old_attribute_taxonomies ) ) {
											$this->crafto_import_log( 'MESSAGE - WooCommerce Before Import Sample Data Add Woocommerce Attributes Start.' );

											if ( dirname( __FILE__ ) . '/class-woocommerce-attribute-taxonomies.php' ) {
												require_once dirname( __FILE__ ) . '/class-woocommerce-attribute-taxonomies.php';
											}

											$attribute_taxonomies_data = new Crafto_Set_Attribute_Taxonomies();

											$attributes = array();
											if ( 'decor-store' === $demo_key ) {
												$attributes['fabric']   = esc_html__( 'Fabric', 'crafto-addons' );
												$attributes['material'] = esc_html__( 'Material', 'crafto-addons' );
											} elseif ( 'fasion-store' === $demo_key ) {
												$attributes['size']     = esc_html__( 'Size', 'crafto-addons' );
												$attributes['material'] = esc_html__( 'Material', 'crafto-addons' );
											} elseif ( 'jewellery-store' === $demo_key ) {
												$attributes['size'] = esc_html__( 'Size', 'crafto-addons' );
											}

											$attribute_taxonomies_data->add_woocommerce_attribute_taxonomies( $attributes );

											$this->crafto_import_log( 'MESSAGE - WooCommerce Before Import Sample Data Add Woocommerce Attributes End.' );
										}

										// Product terms.
										$sample_product_terms_data_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/product_terms.xml';
										if ( file_exists( $sample_product_terms_data_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - Product Terms.xml Import Start.' );
											$importer->import( $sample_product_terms_data_xml );
											$this->crafto_import_log( 'MESSAGE - Product Terms.xml Import End' );
										}

										// For Variation Products.
										$variation_sample_data_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/' . $full_import_option . '-variation.xml';
										if ( file_exists( $variation_sample_data_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - Variation ' . ucfirst( $full_import_option ) . '.xml Import Start.' );
											$importer->import( $variation_sample_data_xml );
											$this->crafto_import_log( 'MESSAGE - Variation ' . ucfirst( $full_import_option ) . '.xml Import End' );
										}
									}

									// Theme Builder.
									if ( 'theme_builder' === $full_import_option || 'elementor_library' === $full_import_option ) {
										$sample_data_xml1 = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/' . $full_import_option . '.xml';
										if ( file_exists( $sample_data_xml1 ) ) {
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import Start.' );
											$importer->import( $sample_data_xml1 );
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import End' );
										}
									}

									// Import Post Terms.
									if ( 'posts' === $full_import_option ) {
										$posts_term_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/posts_terms.xml';
										if ( file_exists( $posts_term_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import Start.' );
											$importer->import( $posts_term_xml );
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import End' );
										}
									}

									// Import Tour Terms.
									if ( 'tours' === $full_import_option ) {
										$tour_term_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/tours_terms.xml';
										if ( file_exists( $tour_term_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import Start.' );
											$importer->import( $tour_term_xml );
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import End' );
										}
									}

									// Import lessons.
									if ( 'course' === $full_import_option ) {
										$lessons_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/lessons.xml';
										if ( file_exists( $lessons_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import Start.' );
											$importer->import( $lessons_xml );
											$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import End' );
										}
									}

									if ( 'default_kit' !== $full_import_option ) {
										$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import Start.' );
										$importer->import( $sample_data_navigation_xml );
										$this->crafto_import_log( 'MESSAGE - ' . ucfirst( $full_import_option ) . '.xml Import End' );
									}

									// For Privacy policy page.
									$privacy_policy = get_page_by_path( 'privacy-policy' );

									// Privacy Policy page assign in woocommerce setting.
									if ( ! empty( $privacy_policy ) && ! empty( $privacy_policy->ID ) ) {
										update_option( 'wp_page_for_privacy_policy', $privacy_policy->ID );
									} else {
										if ( ! $privacy_policy ) {
											$page_id = wp_insert_post(
												array(
													'post_title'     => esc_html__( 'Privacy Policy', 'crafto-addons' ),
													'post_status'    => 'publish',
													'post_type'      => 'page',
													'post_author'    => get_current_user_id(),
													'comment_status' => 'closed',
													'ping_status'    => 'closed',
												)
											);

											if ( $page_id && ! is_wp_error( $page_id ) ) {
												update_option( 'wp_page_for_privacy_policy', $page_id );
											}
										}
									}

									// Variation Product stock status change.
									if ( is_woocommerce_activated() && 'products' === $full_import_option ) {
										// phpcs:ignore
										$variation_product_ids = $wpdb->get_col( "SELECT DISTINCT p.post_parent FROM {$wpdb->prefix}posts p INNER JOIN {$wpdb->prefix}postmeta as pm ON p.ID = pm.post_id WHERE p.post_parent > 0 AND p.post_type LIKE 'product_variation' AND pm.meta_key = '_crafto_demo_import_data' AND pm.meta_value = '1'" );
										if ( ! empty( $variation_product_ids ) ) {
											foreach ( $variation_product_ids as $variation_product_id ) {
												update_post_meta( $variation_product_id, '_stock_status', 'instock' );
											}
										}
									}

									if ( is_woocommerce_activated() && 'pages' === $full_import_option ) {
										$this->crafto_import_log( 'MESSAGE - Import WooCommerce Pages Setting Start.' );
										// Set Woocommerce Default Pages.
										$woopages = array(
											'woocommerce_shop_page_id'            => 'shop',
											'woocommerce_cart_page_id'            => 'cart',
											'woocommerce_checkout_page_id'        => 'checkout',
											'woocommerce_myaccount_page_id'       => 'my account',
											'woocommerce_lost_password_page_id'   => 'lost-password',
											'woocommerce_edit_address_page_id'    => 'edit-address',
											'woocommerce_view_order_page_id'      => 'view-order',
											'woocommerce_change_password_page_id' => 'change-password',
											'woocommerce_logout_page_id'          => 'logout',
											'woocommerce_pay_page_id'             => 'pay',
											'woocommerce_thanks_page_id'          => 'order-received',
											'woocommerce_wishlist_page_id'        => 'wishlist',
										);

										foreach ( $woopages as $option_name => $page_slug ) {
											$page = get_page_by_path( $page_slug );

											if ( $page && $page->ID ) {
												update_option( $option_name, $page->ID );
											}
										}

										$shop_page_id = wc_get_page_id( 'shop' );
										if ( ! empty( $shop_page_id ) ) {
											update_post_meta( $shop_page_id, '_crafto_page_enable_title_single', 'default' );
											update_post_meta( $shop_page_id, '_crafto_page_title_opacity_single', '0.0' );
											update_post_meta( $shop_page_id, '_crafto_page_title_color_single', '' );
										}
										$this->crafto_import_log( 'MESSAGE - Import WooCommerce Pages Setting End.' );

										// We no longer need to install pages.
										delete_option( '_wc_needs_pages' );
									}

									if ( 'course' === $full_import_option && 'elearning' === $demo_key ) {
										// Set LearnPress Default Pages based on page slugs.
										$learnpages = array(
											'learn_press_courses_page_id'           => 'courses',
											'courses_page_id'                       => 'courses',
											'learn_press_single_instructor_page_id' => 'lp-profile',
											'learn_press_profile_page_id'           => 'lp-profile',
											'learn_press_checkout_page_id'          => 'lp-checkout',
										);

										foreach ( $learnpages as $option_name => $page_slug ) {
											$page = get_page_by_path( $page_slug );

											if ( $page && isset( $page->ID ) && 'publish' === get_post_status( $page->ID ) ) {
												update_option( $option_name, $page->ID );
											}
										}

										// Set recommanded options.
										update_option( 'learn_press_layout_single_course', 'classic' );
										update_option( 'learn_press_width_container', '1220px' );
										update_option( 'learn_press_primary_color', '#313e3b' );
										update_option( 'learn_press_secondary_color', '#828c8a' );
									}

									// Import Mega menu.
									$sample_mega_menu_data_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/mega_menu.xml';
									if ( 'navigation_menu' === $full_import_option && file_exists( $sample_mega_menu_data_xml ) ) {
										$importer->import( $sample_mega_menu_data_xml );
									}

									// Registered menu locations in theme.
									if ( 'navigation_menu' === $full_import_option ) {
										$this->crafto_import_log( __( 'MESSAGE - Import Menu Location Start.', 'crafto-addons' ) );
										$this->crafto_assign_menu_to_theme_location();
										$this->crafto_import_log( __( 'MESSAGE - Import Menu Location End.', 'crafto-addons' ) );
									}

									/*
									 * Active Site Setting Kit
									 */
									if ( 'default_kit' === $full_import_option ) {
										$default_kit_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/default_kit.xml';
									
										if ( file_exists( $default_kit_xml ) ) {
											// Remove Exist Site Setting.
											delete_option( 'elementor_active_kit' );

											$target_titles = [ 'Default Kit', 'Imported Kit', 'Crafto Default Kit' ];

											$kits = get_posts( [
												'post_type'              => 'elementor_library',
												'post_status'            => [ 'publish', 'draft', 'trash' ],
												'numberposts'            => -1,
												'fields'                 => 'ids',
												'ignore_sticky_posts'    => true,
												'update_post_term_cache' => false,
												'update_post_meta_cache' => false,
												'suppress_filters'       => true,
											] );

											$matching_ids = [];
											foreach ( $kits as $post_id ) {
												$title = get_the_title( $post_id );
												if ( in_array( $title, $target_titles, true ) ) {
													$matching_ids[] = (int) $post_id;
												}
											}

											if ( ! empty( $matching_ids ) ) {
												$ids_in = implode( ',', $matching_ids );
												$wpdb->query( "DELETE FROM {$wpdb->posts} WHERE ID IN ($ids_in)" ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
											}

											$importer->import( $default_kit_xml );

											$default_kit_query = new WP_Query(
												array(
													'post_type'              => 'elementor_library',
													'title'                  => 'Crafto Default Kit',
													'post_status'            => 'publish',
													'posts_per_page'         => 1,
													'no_found_rows'          => true,
													'ignore_sticky_posts'    => true,
													'update_post_term_cache' => false,
													'update_post_meta_cache' => false,
													'orderby'                => 'ID',
													'order'                  => 'DESC',
												)
											);

											if ( ! empty( $default_kit_query->post ) ) {
												$kit_id = $default_kit_query->post->ID;

												// Optional: Confirm the post hasn't been trashed or deleted.
												if ( get_post_status( $kit_id ) !== false ) {
													// Update the active Elementor Kit if needed.
													if ( get_option( 'elementor_active_kit' ) !== $kit_id ) {
														update_option( 'elementor_active_kit', $kit_id );
													}
												}
											}

											wp_reset_postdata();
										}
									}

									if ( 'landing' === $demo_key ) {
										$this->crafto_update_elementor_replace_urls_for_landing();
									} else {
										$this->crafto_update_elementor_replace_urls();
									}

									$this->crafto_update_elementor_default_features();
								}
							} elseif ( 'givewp' === $full_import_option && 'charity' === $demo_key ) {
								$donation_forms_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/donation_forms.xml';
								if ( file_exists( $donation_forms_xml ) ) {
									$this->crafto_import_log( 'MESSAGE - donation_forms.xml Import Start.' );
									$importer->import( $donation_forms_xml );
									$this->crafto_import_log( 'MESSAGE - donation_forms.xml Import End.' );
								}

								$donations_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/donations.xml';
								if ( file_exists( $donations_xml ) ) {
									$this->crafto_import_log( 'MESSAGE - donations.xml Import Start.' );
									$importer->import( $donations_xml );
									$this->crafto_import_log( 'MESSAGE - donations.xml Import End.' );
								}

								if ( class_exists( 'Give' ) ) {
									$wp_give_import = CRAFTO_ADDONS_IMPORT . '/class-give-import.php';

									if ( file_exists( $wp_give_import ) ) {
										include $wp_give_import;

										$give_importer = new Crafto_Give_Import();

										$blog_id = null;
										if ( is_multisite() ) {
											$blog_id = get_current_blog_id();
										}

										$give_campaigns_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/give_campaigns.xml';
										if ( file_exists( $give_campaigns_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - give_campaigns.xml Import Start.' );
											$give_importer->import_parse_give_campaigns( $give_campaigns_xml, $blog_id );
											$this->crafto_import_log( 'MESSAGE - give_campaigns.xml Import End.' );
										}

										$give_revenue_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/give_revenue.xml';
										if ( file_exists( $give_revenue_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - give_revenue_xml.xml Import Start.' );
											$give_importer->import_parse_give_revenue( $give_revenue_xml, $blog_id );
											$this->crafto_import_log( 'MESSAGE - give_revenue_xml.xml Import End.' );
										}

										$give_comments_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/give_comments.xml';
										if ( file_exists( $give_comments_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - give_comments.xml Import Start.' );
											$give_importer->import_parse_give_comments( $give_comments_xml, $blog_id );
											$this->crafto_import_log( 'MESSAGE - give_comments.xml Import End.' );
										}

										$give_donors_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/give_donors.xml';
										if ( file_exists( $give_donors_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - give_donors.xml Import Start.' );
											$give_importer->import_parse_give_donors( $give_donors_xml, $blog_id );
											$this->crafto_import_log( 'MESSAGE - give_donors.xml Import End.' );
										}

										$give_formmeta_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/give_formmeta.xml';
										if ( file_exists( $give_formmeta_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - give_formmeta.xml Import Start.' );
											$give_importer->import_parse_give_formmeta( $give_formmeta_xml, $blog_id );
											$this->crafto_import_log( 'MESSAGE - give_formmeta.xml Import End.' );
										}

										$give_donationmeta_xml = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/give_donationmeta.xml';
										if ( file_exists( $give_donationmeta_xml ) ) {
											$this->crafto_import_log( 'MESSAGE - give_donationmeta.xml Import Start.' );
											$give_importer->import_parse_give_donationmeta( $give_donationmeta_xml, $blog_id );
											$this->crafto_import_log( 'MESSAGE - give_donationmeta.xml Import End.' );
										}
									}
								}
							} elseif ( 'customizer' === $full_import_option ) {
								// Import Theme Customize file.
								$theme_options_file = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/theme_settings.json';

								if ( file_exists( $theme_options_file ) ) {

									$remove_options = get_theme_mods();

									if ( ! empty( $remove_options ) && ! is_array( $remove_options ) ) {
										$remove_options = json_decode( $remove_options );
									}
									$this->crafto_import_log( __( 'MESSAGE - Before Import Customize Clear All Customize Settings Start.', 'crafto-addons' ) );

									if ( ! empty( $remove_options ) ) {
										foreach ( $remove_options as $key => $value ) {
											remove_theme_mod( $key );
										}
									}
									$this->crafto_import_log( __( 'MESSAGE - Before Import Customize Clear All Customize Settings End.', 'crafto-addons' ) );

									// Save new settings.
									$this->crafto_import_log( __( 'MESSAGE - Import Customize Setting Start.', 'crafto-addons' ) );
									// phpcs:ignore
									$encode_options = file_get_contents( $theme_options_file );
									$options        = json_decode( $encode_options, true );

									if ( ! empty( $options ) ) {

										if ( is_multisite() ) {
											$upload_dir      = wp_upload_dir();
											$old_upload_base = $to . '/wp-content/uploads'; // phpcs:ignore
											$new_upload_base = $upload_dir['baseurl'];
										}

										foreach ( $options as $key => $value ) {
											// Replace old domain in all strings (optional helper)
											$value = $this->crafto_replace_old_domain_recursive_customizer( $value, $from, $to );

											// If this is multisite and we're importing into a subsite, switch context.
											if ( is_multisite() && 'crafto_custom_fonts' === $key ) {
												$value = str_replace( $old_upload_base, $new_upload_base, $value );
											}

											if ( is_multisite() && 'crafto_page_not_found_image' === $key ) {
												$value = str_replace( $old_upload_base, $new_upload_base, $value );
											}

											set_theme_mod( $key, $value );
										}

										if ( isset( $options['crafto_custom_fonts'] ) && ! empty( $options['crafto_custom_fonts'] ) ) {
											$this->crafto_import_custom_font_family( $options['crafto_custom_fonts'] );
										}
									}

									$this->crafto_import_log( __( 'MESSAGE - Import Customize Setting End.', 'crafto-addons' ) );

									$this->crafto_assign_menu_to_theme_location();

									// Reading settings.
									$homepage_query = new WP_Query(
										array(
											'post_type'   => 'page',
											'title'       => 'Home',
											'post_status' => 'publish',
											'posts_per_page' => 1,
											'no_found_rows' => true,
											'ignore_sticky_posts' => true,
											'update_post_term_cache' => false,
											'update_post_meta_cache' => false,
										)
									);

									if ( ! empty( $homepage_query->post ) ) {
										$homepage = $homepage_query->post;
									} else {
										$homepage = null;
									}

									if ( isset( $homepage ) && $homepage->ID ) {
										$this->crafto_import_log( __( 'MESSAGE - Set Static Homepage Start.', 'crafto-addons' ) );
										update_option( 'show_on_front', 'page' );
										update_option( 'page_on_front', $homepage->ID ); // Front Page.
										$this->crafto_import_log( __( 'MESSAGE - Set Static Homepage End.', 'crafto-addons' ) );

									} else {
										$this->crafto_import_log( __( 'NOTICE - Static Homepage Couldn\'t Be Set.', 'crafto-addons' ) );
									}

									if ( is_woocommerce_activated() ) {
										$this->crafto_import_log( __( 'MESSAGE - Set Woocommerce Settings Start.', 'crafto-addons' ) );
										update_option( 'woocommerce_single_image_width', '800' );
										update_option( 'woocommerce_thumbnail_image_width', '360' );
										update_option( 'woocommerce_thumbnail_cropping', 'uncropped' );
										$this->crafto_import_log( __( 'MESSAGE - Set Woocommerce Settings End.', 'crafto-addons' ) );
									}
								}
							} elseif ( 'widgets' === $full_import_option ) {
								// Sidebar Widgets Json File.
								$widgets_file = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/widget_data.json';

								if ( file_exists( $widgets_file ) ) {
									// Add data to widgets.
									$this->crafto_import_log( __( 'MESSAGE - Before Import Widget Clear All Widgetarea Start.', 'crafto-addons' ) );
									$sidebars = wp_get_sidebars_widgets();

									unset( $sidebars['wp_inactive_widgets'] );

									foreach ( $sidebars as $sidebar => $widgets ) {
										$sidebars[ $sidebar ] = array();
									}

									$sidebars['wp_inactive_widgets'] = array();
									wp_set_sidebars_widgets( $sidebars );
									$this->crafto_import_log( __( 'MESSAGE - Before Import Widget Clear All Widgetarea End.', 'crafto-addons' ) );
									// phpcs:ignore
									$widget_data = file_get_contents( $widgets_file );

									$this->crafto_import_log( __( 'MESSAGE - Import Widget Setting Start.', 'crafto-addons' ) );
									$import_widgets = $this->crafto_import_widget_sample_data( $widget_data );
								}
							} elseif ( 'rev_slider' === $full_import_option ) { // Import Revolution sliders.
								// Import Revslider.
								if ( is_revolution_slider_activated() ) {
									$rev_directory = dirname( __FILE__ ) . '/sample-data/' . $demo_key . '/revsliders';
									if ( file_exists( $rev_directory ) && is_dir( $rev_directory ) ) {
										$rev_files = $this->crafto_get_zip_import_files( $rev_directory, 'zip' );
										$slider    = new RevSlider();
										$this->crafto_import_log( __( 'MESSAGE - Import Revslider Start.', 'crafto-addons' ) );
										foreach ( $rev_files as $rev_file ) {
											// finally import rev slider data files.
											$filepath = $rev_file;
											ob_start();
											$slider->importSliderFromPost( true, false, $filepath );
											ob_clean();
											ob_end_clean();
										}

										$this->crafto_revslider_clear_all_transients();

										$this->crafto_import_log( __( 'MESSAGE - Import Revslider End.', 'crafto-addons' ) );
									}
								}
							}

							$wp_rewrite->set_permalink_structure( '/%postname%/' );

							// Flush rules after install.
							flush_rewrite_rules();
						}

						remove_filter( 'elementor/files/allow_unfiltered_upload', [ $this, 'crafto_allow_unfiltered_uploads' ] );
						remove_filter( 'upload_mimes', array( $this, 'crafto_set_svg_mimes' ) );
					}
				}
			}
			wp_die();
		}

		/**
		 * Clears all Revolution Slider-related transients from the WordPress options table.
		 */
		public function crafto_revslider_clear_all_transients() {
			global $wpdb;
			// phpcs:ignore
			$wpdb->query( "DELETE FROM ". $wpdb->prefix . 'options' ." WHERE `option_name` LIKE '_transient_revslider_slider_%'" );
			// phpcs:ignore
			$wpdb->query( "DELETE FROM ". $wpdb->prefix . 'options' ." WHERE `option_name` LIKE '_transient_timeout_revslider_slider_%'" );
		}

		/**
		 * Undocumented function
		 *
		 * @param mixed $widget_data Widgets data.
		 *
		 * For More Info Check Widget Import Plugin ( http://wordpress.org/plugins/widget-settings-importexport/ ).
		 *
		 * @return void
		 */
		public function crafto_import_widget_sample_data( $widget_data ) {
			$json_data    = json_decode( $widget_data, true );
			$sidebar_data = $json_data[0];
			$widget_data  = $json_data[1];

			if ( ! empty( $widget_data ) ) {
				foreach ( $widget_data as $widget_title => $widget_value ) {
					foreach ( $widget_value as $widget_key => $widget_value ) {
						$widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
					}
				}
			}

			$sidebar_data = array( array_filter( $sidebar_data ), $widgets );
			$this->crafto_parse_import_widget_sample_data( $sidebar_data );
		}

		/**
		 * Undocumented function
		 *
		 * @param array $import_array Sidebar data.
		 */
		public function crafto_parse_import_widget_sample_data( $import_array ) {
			global $wp_registered_sidebars;

			$new_widgets      = array();
			$sidebars_data    = $import_array[0];
			$widget_data      = $import_array[1];
			$current_sidebars = get_option( 'sidebars_widgets' );

			if ( ! empty( $sidebars_data ) ) {
				foreach ( $sidebars_data as $import_sidebar => $import_widgets ) {
					foreach ( $import_widgets as $import_widget ) {
						// if the sidebar exists.
						if ( isset( $wp_registered_sidebars[ $import_sidebar ] ) ) {
							$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
							$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );

							$current_widget_data = get_option( 'widget_' . $title );
							$new_widget_name     = $this->crafto_get_new_widget_name( $title, $index );
							$new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

							if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
								while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
									$new_index++;
								}
							}
							$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
							if ( array_key_exists( $title, $new_widgets ) ) {

								$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
								$multiwidget = $new_widgets[ $title ]['_multiwidget']; // phpcs:ignore
								unset( $new_widgets[ $title ]['_multiwidget'] );
								$new_widgets[ $title ]['_multiwidget'] = $multiwidget;
							} else {
								$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];

								$current_multiwidget = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : false;

								$new_multiwidget = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
								// phpcs:ignore
								$multiwidget = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
								unset( $current_widget_data['_multiwidget'] );

								$current_widget_data['_multiwidget'] = $multiwidget;
								$new_widgets[ $title ]               = $current_widget_data;
							}
						}
					}
				}
			}

			if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
				update_option( 'sidebars_widgets', $current_sidebars );

				foreach ( $new_widgets as $title => $content ) {
					update_option( 'widget_' . $title, $content );
				}
				$this->crafto_import_log( __( 'MESSAGE - Import Widget Setting End.', 'crafto-addons' ) );
				return true;
			}
			$this->crafto_import_log( __( 'NOTICE - Import Widget Setting Not Completed.', 'crafto-addons' ) );
			return false;
		}

		/**
		 * Undocumented function
		 *
		 * @param mixed $widget_name Widgets name.
		 * @param mixed $widget_index Widgets index.
		 */
		public function crafto_get_new_widget_name( $widget_name, $widget_index ) {
			$all_widget_array = array();
			$current_sidebars = get_option( 'sidebars_widgets' );

			foreach ( $current_sidebars as $sidebar => $widgets ) {
				// phpcs:ignore
				if ( ! empty( $widgets ) && is_array( $widgets ) && 'wp_inactive_widgets' != $sidebar ) {
					foreach ( $widgets as $widget ) {
						$all_widget_array[] = $widget;
					}
				}
			}

			while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array, true ) ) {
				$widget_index++;
			}

			$new_widget_name = $widget_name . '-' . $widget_index;

			return $new_widget_name;
		}

		/**
		 * Retrieves a list of files of a specific type from a given directory,
		 * intended for handling ZIP-based import functionality.
		 *
		 * This function scans the specified directory and returns an array of file paths
		 * that match the given file extension. It is typically used to gather importable
		 * files (e.g., XML, JSON, etc.) extracted from a ZIP archive.
		 *
		 * @param string $directory Absolute or relative path to the directory to scan.
		 * @param string $filetype  File extension to match (e.g., 'xml', 'json').
		 *
		 * @return array An array of matching file paths. Returns an empty array if no matches are found or the directory doesn't exist.
		 */
		public function crafto_get_zip_import_files( $directory, $filetype ) {
			$files      = array();
			$phpversion = phpversion();

			// Check if the php version allows for recursive iterators.
			if ( version_compare( $phpversion, '5.2.11', '>' ) ) {
				// phpcs:ignore
				if ( $filetype != '*' ) {
					$filetype = '/^.*\.' . $filetype . '$/';
				} else {
					$filetype = '/.+\.[^.]+$/';
				}
				$directory_iterator = new RecursiveDirectoryIterator( $directory );
				$recusive_iterator  = new RecursiveIteratorIterator( $directory_iterator );
				$regex_iterator     = new RegexIterator( $recusive_iterator, $filetype );

				foreach ( $regex_iterator as $file ) {
					$files[] = $file->getPathname();
				}
				// Fallback to glob() for older php versions.
			} else {
				// phpcs:ignore
				if ( $filetype != '*' ) {
					$filetype = '*.' . $filetype;
				}

				foreach ( glob( $directory . $filetype ) as $filename ) {
					$filename = basename( $filename );
					$files[]  = $directory . $filename;
				}
			}
			return $files;
		}

		/**
		 * Logs messages related to the import process.
		 *
		 * This function writes a message to an import log file. It supports both appending
		 * new messages or overwriting the existing log content. Useful for tracking the
		 * progress and diagnosing issues during ZIP/demo imports.
		 *
		 * @param string  $message The message to log. Can include timestamps, file names, status updates, etc.
		 * @param boolean $append  Optional. Whether to append to the log file (true) or overwrite it (false). Default is true.
		 *
		 * @return void
		 */
		public function crafto_import_log( $message, $append = true ) {
			$upload_dir = wp_upload_dir();
			if ( isset( $upload_dir['baseurl'] ) ) {
				$data = '';
				if ( ! empty( $message ) ) {
					$data = '<p>' . gmdate( 'Y-m-d H:i:s' ) . ' - ' . $message . '</p>';
				}

				if ( true === $append ) {
					// phpcs:ignore
					file_put_contents( $upload_dir['basedir'] . '/importer.log', $data, FILE_APPEND );
				} else {
					// phpcs:ignore
					file_put_contents( $upload_dir['basedir'] . '/importer.log', $data );
				}
			}
		}

		/**
		 * Generate log file
		 */
		public function get_crafto_import_log() {
			$upload_dir = wp_upload_dir();
			if ( isset( $upload_dir['baseurl'] ) ) {
				if ( file_exists( $upload_dir['basedir'] . '/importer.log' ) ) {
					// phpcs:ignore
					return file_get_contents( $upload_dir['basedir'] . '/importer.log' );
				}
			}
			return '';
		}

		/**
		 * Processing log file
		 *
		 * @return void
		 */
		public function crafto_refresh_import_log() {
			$check_crafto_log = $this->get_crafto_import_log();
			// don't add message if ERROR was found, JS script is going to stop refreshing.
			if ( true === strpos( $check_crafto_log, 'ERROR' ) ) {
				$this->crafto_import_log( __( 'MESSAGE - Import in progress...', 'crafto-addons' ) );
			}
			$printlog = $this->get_crafto_import_log();
			echo $printlog; // phpcs:ignore
			wp_die();
		}

		/**
		 * Assign menu to theme location
		 *
		 * @return void
		 */
		public function crafto_assign_menu_to_theme_location() {
			// When customizer import, menu id can't change.
			$locations = get_theme_mod( 'nav_menu_locations' );

			// Registered menus.
			$menus = wp_get_nav_menus();
			// Assign menus to theme locations.
			if ( ! empty( $menus ) ) {
				foreach ( $menus as $menu ) {
					if ( 'Main Menu' === $menu->name ) {
						$locations['primary-menu'] = $menu->term_id;
					}
				}
			}
			// Set menus to locations.
			set_theme_mod( 'nav_menu_locations', $locations );
		}

		/**
		 * Return no Image Size
		 *
		 * @param mixed $sizes Sizes of images.
		 */
		public function crafto_no_image_resize( $sizes ) {
			return array();
		}

		public function crafto_allow_unfiltered_uploads( $enabled ) {
			// Allow only during this process
			return true;
		}

		/**
		 * Allow to support MIME Type.
		 *
		 * @param array $mimes MIME Type.
		 */
		public function crafto_set_svg_mimes( $mimes ) {

			$mimes['svg']  = 'image/svg+xml';
			$mimes['svgz'] = 'image/svg+xml';
			
			return $mimes;
		}

		/**
		 * Import custom fonts files from /uploads
		 *
		 * @param mixed $theme_custom_fonts Font family JSON data.
		 */
		public function crafto_import_custom_font_family( $theme_custom_fonts ) {
			/* Check current user permission */
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( esc_html__( 'Unauthorized request.', 'crafto-addons' ) );
			}

			$theme_custom_fonts = ! empty( $theme_custom_fonts ) ? substr( $theme_custom_fonts, 1, -1 ) : [];

			$font_data = json_decode( $theme_custom_fonts, true );

			if ( ! is_array( $font_data ) ) {
				wp_send_json_error( esc_html__( 'Invalid font data.', 'crafto-addons' ) );
			}

			// Load WordPress file handling functions if not already available
			if ( ! function_exists( 'download_url' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			if ( ! function_exists( 'wp_mkdir_p' ) ) {
				require_once ABSPATH . 'wp-includes/functions.php';
			}

			// Initialize WordPress filesystem
			$filesystem = Crafto_Filesystem::init_filesystem();

			// Extract font family name and normalize folder name
			$font_name   = array_shift( $font_data );
			$font_folder = str_replace( ' ', '-', $font_name ); // Cerebri-Sans.
			$upload_dir  = wp_upload_dir();
			$target_dir  = trailingslashit( $upload_dir['basedir'] ) . 'crafto-fonts/' . $font_folder . '/';

			// Create the directory if it doesn't exist.
			wp_mkdir_p( $target_dir );

			// Skip the first entry only (font family).
			$font_data_count = count( $font_data );
			for ( $i = 0; $i < $font_data_count; $i += 5 ) {
				$urls = array_slice( $font_data, $i, 4 ); // Get woff2, woff, ttf, eot (skip weight at $i+4).

				foreach ( $urls as $url ) {
					if ( empty( $url ) ) {
						continue;
					}

					$tmp_file = download_url( $url );
					if ( is_wp_error( $tmp_file ) ) {
						continue;
					}

					$filename    = basename( $url );
					$destination = $target_dir . $filename;

					// Copy temp file to destination.
					if ( ! $filesystem->copy( $tmp_file, $destination, true, FS_CHMOD_FILE ) ) {
						$filesystem->delete( $tmp_file ); // Clean up temp file if copy fails.
						continue;
					}

					// Clean up temp file after successful copy.
					$filesystem->delete( $tmp_file );
				}
			}
		}

		/**
		 * Replace URls with old urls
		 *
		 * @since 1.3
		 */
		private function crafto_update_elementor_replace_urls() {
			$from = rtrim( CRAFTO_ADDONS_DEMO_URI, '/' );
			$to   = rtrim( site_url(), '/' );

			if ( is_multisite() ) {

				$sites = get_sites();

				foreach ( $sites as $site ) {
					switch_to_blog( $site->blog_id );

					$upload_dir       = wp_upload_dir();
					$correct_base_url = rtrim( $upload_dir['baseurl'], '/' );

					$from_base = 'https://crafto.themezaa.com/wp-content/uploads';
					$to_base   = $correct_base_url;

					$this->crafto_replace_elementor_data_urls( $from_base, $to_base );
					restore_current_blog();
				}
			} else {
				// Single site fallback.
				$this->crafto_replace_elementor_data_urls( $from, $to );
			}
		}

		/**
		 * Replace plain URLs in Elementor raw JSON data
		 *
		 * @param string $from_url Old URL.
		 *
		 * @param string $to_url New URL.
		 *
		 * @since 1.3
		 */
		private function crafto_replace_elementor_data_urls( $from, $to ) {
			global $wpdb;

			$this->crafto_import_log( __( 'MESSAGE - Import Replace URLs Item Start.', 'crafto-addons' ) );

			// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
			$wpdb->query(
				"UPDATE {$wpdb->postmeta} " .
				"SET `meta_value` = REPLACE(`meta_value`, '" . $from . "', '" .  $to . "') " .
				"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
			// @codingStandardsIgnoreEnd

			// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
			$wpdb->query(
				"UPDATE {$wpdb->postmeta} " .
				"SET `meta_value` = REPLACE(`meta_value`, '" . str_replace( '/', '\\\/', $from ) . "', '" . str_replace( '/', '\\\/', $to ) . "') " .
				"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
			// @codingStandardsIgnoreEnd

			// Replace in serialized meta (e.g., _elementor_page_settings)
			$this->crafto_replace_serialized_urls( $from, $to );

			// @codingStandardsIgnoreEnd

			$this->crafto_import_log( __( 'MESSAGE - Import Replace URLs Item End.', 'crafto-addons' ) );
		}

		/**
		 * Replace serialized URls with old urls
		 *
		 * @param string $from_url Old URL.
		 *
		 * @param string $to_url New URL.
		 *
		 * @since 1.0
		 */
		private function crafto_replace_serialized_urls( $from_url, $to_url ) {
			global $wpdb;

			// Get all rows where meta_key = '_elementor_page_settings.

			// phpcs:ignore
			$results = $wpdb->get_results(
				"SELECT meta_id, meta_value
				FROM {$wpdb->postmeta}
				WHERE meta_key = '_elementor_page_settings'"
			);
			
			foreach ( $results as $row ) {
				$meta_id        = $row->meta_id;
				$original_value = $row->meta_value;

				// Unserialize safely.
				$data = maybe_unserialize( $original_value );

				if ( is_array( $data ) || is_object( $data ) ) {
					// Replace recursively.
					$updated_data = $this->crafto_recursive_replace_url( $from_url, $to_url, $data );

					// If something changed, update the meta.
					if ( $updated_data !== $data ) {
						$new_value = maybe_serialize( $updated_data );
						// phpcs:ignore
						$wpdb->update(
							$wpdb->postmeta,
							// phpcs:ignore
							[ 'meta_value' => $new_value ],
							[ 'meta_id' => $meta_id ]
						);
					}
				}
			}
		}

		/**
		 * Replace serialized URls with old urls
		 *
		 * @param string $from Old URL.
		 *
		 * @param string $to New URL.
		 *
		 * @param string $data Content.
		 *
		 * @since 1.0
		 */
		private function crafto_recursive_replace_url( $from, $to, $data ) {
			if ( is_array( $data ) ) {
				foreach ( $data as $key => $value ) {
					// phpcs:ignore
					$data[ $key ] = $this->crafto_recursive_replace_url( $from, $to, $value );
				}
			} elseif ( is_object( $data ) ) {
				foreach ( $data as $key => $value ) {
					$data->$key = $this->crafto_recursive_replace_url( $from, $to, $value );
				}
			} elseif ( is_string( $data ) ) {
				$data = str_replace( $from, $to, $data );
			}
			
			return $data;
		}

		/**
		 * Recursively replaces old domain with new domain in strings or arrays.
		 *
		 * @param string $data data content.
		 *
		 * @param string $old_domain Old URL.
		 *
		 * @param string $new_domain New URL.
		 */
		private function crafto_replace_old_domain_recursive_customizer( $data, $old_domain, $new_domain ) {
			if ( is_array( $data ) ) {
				foreach ( $data as $k => $v ) {
					$data[ $k ] = $this->crafto_replace_old_domain_recursive_customizer( $v, $old_domain, $new_domain );
				}
			} elseif ( is_string( $data ) ) {
				$data = str_replace( $old_domain, $new_domain, $data );
			}
			return $data;
		}

		/**
		 * Replace URls with old urls for landing.
		 *
		 * @since 1.0
		 */
		private function crafto_update_elementor_replace_urls_for_landing() {
			if ( is_multisite() ) {
				$sites = get_sites();

				foreach ( $sites as $site ) {
					switch_to_blog( $site->blog_id );

					$upload_dir       = wp_upload_dir();
					$correct_base_url = rtrim( $upload_dir['baseurl'], '/' );

					$from_base = 'https://crafto.themezaa.com/wp-content/uploads';
					$to_base   = $correct_base_url;

					$this->crafto_replace_elementor_data_urls_for_landing( $from_base, $to_base );
					restore_current_blog();
				}
			} else {
				$from = rtrim( 'https://crafto.themezaa.com/wp-content/uploads/', '/' );
				$to   = rtrim( site_url( '/wp-content/uploads/' ), '/' );
				// Single site fallback
				$this->crafto_replace_elementor_data_urls_for_landing( $from, $to );
			}
		}

		/**
		 * Replace URLs with old urls
		 *
		 * @since 1.3
		 */
		private function crafto_replace_elementor_data_urls_for_landing( $from, $to ) {
			global $wpdb;

			$this->crafto_import_log( __( 'MESSAGE - Import Replace URLs Item Start.', 'crafto-addons' ) );

			// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
			$wpdb->query(
				"UPDATE {$wpdb->postmeta} " .
				"SET `meta_value` = REPLACE(`meta_value`, '" . $from . "', '" .  $to . "') " .
				"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
			// @codingStandardsIgnoreEnd

			// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
			$wpdb->query(
				"UPDATE {$wpdb->postmeta} " .
				"SET `meta_value` = REPLACE(`meta_value`, '" . str_replace( '/', '\\\/', $from ) . "', '" . str_replace( '/', '\\\/', $to ) . "') " .
				"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
			// @codingStandardsIgnoreEnd

			$this->crafto_import_log( __( 'MESSAGE - Import Replace URLs Item End.', 'crafto-addons' ) );

			$from1 = rtrim( CRAFTO_ADDONS_IMP_DEMO_URI, '/' );
			$to1   = rtrim( CRAFTO_ADDONS_DEMO_URI, '/' );

			$this->crafto_import_log( __( 'MESSAGE - Import Landing Replace URLs Item Start.', 'crafto-addons' ) );

			// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
			$wpdb->query(
				"UPDATE {$wpdb->postmeta} " .
				"SET `meta_value` = REPLACE(`meta_value`, '" . $from1 . "', '" .  $to1 . "') " .
				"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
			// @codingStandardsIgnoreEnd

			// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
			$wpdb->query(
				"UPDATE {$wpdb->postmeta} " .
				"SET `meta_value` = REPLACE(`meta_value`, '" . str_replace( '/', '\\\/', $from1 ) . "', '" . str_replace( '/', '\\\/', $to1 ) . "') " .
				"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
			// @codingStandardsIgnoreEnd

			$this->crafto_replace_serialized_urls( $from1, $to1 );

			// @codingStandardsIgnoreEnd

			$this->crafto_import_log( __( 'MESSAGE - Import Landing Replace URLs Item End.', 'crafto-addons' ) );
		}

		/**
		 * Set default - Elementor > Settings > Features
		 *
		 * @since 1.0
		 */
		private function crafto_update_elementor_default_features() {
			if ( get_option( 'elementor_experiment-e_font_icon_svg' ) === 'active' ||
				get_option( 'elementor_experiment-e_font_icon_svg' ) === 'default' ) {
				update_option( 'elementor_experiment-e_font_icon_svg', 'inactive' );
			} else {
				add_option( 'elementor_experiment-e_font_icon_svg', 'inactive', '', 'yes' );
			}

			if ( get_option( 'elementor_experiment-e_element_cache' ) === 'active' ||
				get_option( 'elementor_experiment-e_element_cache' ) === 'default' ) {
				update_option( 'elementor_experiment-e_element_cache', 'inactive' );
			} else {
				add_option( 'elementor_experiment-e_element_cache', 'inactive', '', 'yes' );
			}

			if ( get_option( 'elementor_experiment-e_optimized_markup' ) === 'active' ||
				get_option( 'elementor_experiment-e_optimized_markup' ) === 'default' ) {
				update_option( 'elementor_experiment-e_optimized_markup', 'inactive' );
			} else {
				add_option( 'elementor_experiment-e_optimized_markup', 'inactive', '', 'yes' );
			}

			if ( get_option( 'elementor_element_cache_ttl' ) !== 'disable' ) {
				update_option( 'elementor_element_cache_ttl', 'disable' );
			} else {
				add_option( 'elementor_element_cache_ttl', 'disable', '', 'yes' );
			}

			// Regenerate CSS
			if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( '\Elementor\Plugin::instance' ) ) {
				\Elementor\Plugin::$instance->files_manager->clear_cache();
			}

			// Deletes the stored transient containing the local_google_fonts and fonts css files.
			if ( is_elementor_activated() ) {
				delete_option( '_elementor_local_google_fonts' );
				\Elementor\Core\Files\Fonts\Google_Font::clear_cache();
			}

			update_option( 'woocommerce_coming_soon', 'no' );
		}
	}

	new Crafto_Importer();
}
