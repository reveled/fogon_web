<?php
/**
 * Metabox functionality.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Calls the class on the post edit screen.
 */
function crafto_meta_box_obj() {

	if ( ! is_crafto_theme_activated() ) {
		return;
	}

	new Crafto_Meta_Boxes();
}

if ( is_admin() ) {
	add_action( 'load-post.php', 'crafto_meta_box_obj' );
	add_action( 'load-post-new.php', 'crafto_meta_box_obj' );
	add_action( 'load-edit-tags.php', 'crafto_meta_box_obj' );
	add_action( 'load-term.php', 'crafto_meta_box_obj' );
	add_action( 'load-user-edit.php', 'crafto_meta_box_obj' );
	add_action( 'load-profile.php', 'crafto_meta_box_obj' );
}

// If class `Crafto_Meta_Boxes` doesn't exists yet.
if ( ! class_exists( 'Crafto_Meta_Boxes' ) ) {

	/**
	 * Define Crafto_Meta_Boxes Class
	 */
	class Crafto_Meta_Boxes {

		/**
		 * Hook into the appropriate actions when the class is constructed.
		 */
		public function __construct() {

			$this->crafto_metabox_addons();
			add_action( 'add_meta_boxes', [ $this, 'crafto_add_meta_boxes' ] );
			add_action( 'save_post', [ $this, 'crafto_save_meta_box' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_script_loader' ] );

			/* Portfolio CPT */
			add_action( 'add_meta_boxes', [ $this, 'crafto_add_meta_boxes_portfolios' ] );

			/* Properties CPT */
			add_action( 'add_meta_boxes', [ $this, 'crafto_add_meta_boxes_properties' ] );

			add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_wp_codemirror' ] );
			add_filter( 'wp_default_editor', [ $this, 'crafto_wysiwyg_default_load' ] );
		}

		/**
		 * Enqueue WordPress CodeMirror CSS and JavaScript.
		 */
		public function enqueue_wp_codemirror() {

			wp_enqueue_code_editor( [ 'type' => 'text/css' ] );

			wp_enqueue_script( 'wp-codemirror' );
			wp_enqueue_style( 'wp-codemirror' );
		}
		/**
		 * Adds the meta box functions container.
		 */
		public function crafto_metabox_addons() {
			if ( file_exists( CRAFTO_ADDONS_METABOX_DIR . '/meta-box-maps.php' ) ) {
				require_once CRAFTO_ADDONS_METABOX_DIR . '/meta-box-maps.php';
			}
		}

		/**
		 * Adds the meta box container.
		 *
		 * @param array $crafto_post_type Post types.
		 * @since 1.0
		 * @access public
		 */
		public function crafto_add_meta_boxes( $crafto_post_type ) {

			// limit meta box to certain post types.
			$crafto_post_types = [
				'post',
				'page',
				'portfolio',
				'properties',
				'tours',
				'themebuilder',
			];

			/* if WooCommerce plugin is activated */
			if ( is_woocommerce_activated() ) {
				$crafto_post_types[] = 'product';
			}

			$flag = false;
			if ( in_array( $crafto_post_type, $crafto_post_types, true ) ) {
				$flag = true;
			}

			if ( true === $flag ) {
				switch ( $crafto_post_type ) {
					case 'post':
						$this->crafto_add_meta_box(
							'crafto_admin_options',
							esc_html__( 'Crafto Post Settings', 'crafto-addons' ),
							$crafto_post_type
						);
						break;
					case 'portfolio':
						$this->crafto_add_meta_box(
							'crafto_admin_options',
							esc_html__( 'Crafto Portfolio Settings', 'crafto-addons' ),
							$crafto_post_type
						);
						break;
					case 'tours':
						$this->crafto_add_meta_box(
							'crafto_admin_options',
							esc_html__( 'Crafto Tour Settings', 'crafto-addons' ),
							$crafto_post_type
						);
						break;
					case 'properties':
						$this->crafto_add_meta_box(
							'crafto_admin_options',
							esc_html__( 'Crafto Property Settings', 'crafto-addons' ),
							$crafto_post_type
						);
						break;
					case 'product':
						/* if WooCommerce plugin is activated */
						if ( is_woocommerce_activated() ) {
							$this->crafto_add_meta_box(
								'crafto_admin_options',
								esc_html__( 'Crafto Product Settings', 'crafto-addons' ),
								$crafto_post_type
							);
						}
						break;
					case 'themebuilder':
						$this->crafto_add_meta_box(
							'crafto_meta_builder_setting',
							esc_html__( 'Crafto Theme Builder Settings', 'crafto-addons' ),
							$crafto_post_type
						);
						break;
					case 'page':
						$this->crafto_add_meta_box(
							'crafto_admin_options',
							esc_html__( 'Crafto Page Settings', 'crafto-addons' ),
							$crafto_post_type
						);
						break;
				}
			}
		}

		/**
		 * Adds the meta box.
		 *
		 * @param mixed  $crafto_id Meta Key.
		 * @param string $crafto_label_name Meta label name.
		 * @param array  $crafto_post_type Post type.
		 * @since 1.0
		 * @access public
		 */
		public function crafto_add_meta_box( $crafto_id, $crafto_label_name, $crafto_post_type ) {

			add_meta_box(
				$crafto_id,
				$crafto_label_name,
				[
					$this,
					$crafto_id,
				],
				$crafto_post_type,
				'advanced',
				'default'
			);
		}

		/**
		 * Adds admin options.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function crafto_admin_options() {

			global $post;

			if ( is_woocommerce_activated() && 'product' === $post->post_type ) {

				$crafto_tabs_title = [
					0 => esc_html__( 'Header and Footer', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => sprintf( '%s %s', esc_html__( 'Single', 'crafto-addons' ), ucfirst( $post->post_type ) ),
					4 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tabs = [
					0 => esc_html__( 'Header Settings', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => sprintf( '%s %s', esc_html__( 'Single', 'crafto-addons' ), ucfirst( $post->post_type ) ),
					4 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tab_content = [
					'builder-page-settings',
					'title-wrapper',
					'performance',
					'single-product-layout',
					'custom-css',
				];
			} elseif ( 'post' === $post->post_type || 'portfolio' === $post->post_type ) {

				$crafto_tabs_title = [
					0 => esc_html__( 'Header and Footer', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => sprintf( '%s %s', esc_html__( 'Single', 'crafto-addons' ), ucfirst( $post->post_type ) ),
					4 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tabs = [
					0 => esc_html__( 'Header Settings', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => sprintf( '%s %s', esc_html__( 'Single', 'crafto-addons' ), ucfirst( $post->post_type ) ),
					4 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tab_content = [
					'builder-page-settings',
					'title-wrapper',
					'performance',
					'single-post-layout',
					'custom-css',
				];
			} elseif ( 'tours' === $post->post_type ) {

				$crafto_tabs_title = [
					0 => esc_html__( 'Header and Footer', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tabs = [
					0 => esc_html__( 'Header Settings', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tab_content = [
					'builder-page-settings',
					'title-wrapper',
					'performance',
					'custom-css',
				];
			} elseif ( 'properties' === $post->post_type ) {

				$crafto_tabs_title = [
					0 => esc_html__( 'Header and Footer', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tabs = [
					0 => esc_html__( 'Header Settings', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tab_content = [
					'builder-page-settings',
					'title-wrapper',
					'performance',
					'custom-css',
				];
			} else {

				$crafto_tabs_title = [
					0 => esc_html__( 'Header and Footer', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tabs = [
					0 => esc_html__( 'Header Settings', 'crafto-addons' ),
					1 => esc_html__( 'Page Title', 'crafto-addons' ),
					2 => esc_html__( 'Performance', 'crafto-addons' ),
					3 => esc_html__( 'Custom CSS', 'crafto-addons' ),
				];

				$crafto_page_tab_content = [
					'builder-page-settings',
					'title-wrapper',
					'performance',
					'custom-css',
				];
			}

			$crafto_icon_class = [
				'bi bi-window',
				'bi bi-h-square',
				'bi bi-speedometer2',
				'bi bi-clipboard2-check',
				'bi bi-code-square',
			];

			$crafto_custom_icon_class = [
				'bi bi-window',
				'bi bi-h-square',
				'bi bi-speedometer2',
				'bi bi-clipboard2-check',
				'bi bi-code-square',
			];

			if ( ! empty( $crafto_tabs_title ) ) {
				?>
				<ul class="crafto_meta_box_tabs">
					<?php
					$crafto_icon     = 0;
					$crafto_showicon = '';

					foreach ( $crafto_tabs_title as $tab_key => $tab_name ) {
						if ( 'post' === $post->post_type || 'portfolio' === $post->post_type ) {
							if ( $crafto_icon_class ) {
								$crafto_icon_class_key = isset( $crafto_icon_class[ $crafto_icon ] ) ? $crafto_icon_class[ $crafto_icon ] : '';
								$crafto_showicon       = '<i class="' . esc_attr( $crafto_icon_class_key ) . '"></i>';
							}
						} else {
							if ( $crafto_custom_icon_class ) {
								$crafto_custom_icon_class_key = isset( $crafto_custom_icon_class[ $crafto_icon ] ) ? $crafto_custom_icon_class[ $crafto_icon ] : '';
								$crafto_showicon              = '<i class="' . esc_attr( $crafto_custom_icon_class_key ) . '"></i>';
							}
						}

						$crafto_page_tab_content_key = isset( $crafto_page_tab_content[ $tab_key ] ) ? $crafto_page_tab_content[ $tab_key ] : '';
						?>
						<li class="crafto_tab_<?php echo esc_attr( $crafto_page_tab_content_key ); ?>">
							<a href="<?php echo esc_url( $tab_name ); ?>">
								<?php printf( '%s', $crafto_showicon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span class="group_title"><?php echo esc_html( $tab_name ); ?></span>
							</a>
						</li>
						<?php
						++$crafto_icon;
					}
					?>
				</ul>
				<?php
			}
			?>
			<div class="crafto_meta_box_tab_content">
				<?php
				foreach ( $crafto_page_tab_content as $tab_content_key => $tab_content_name ) {
					?>
					<div class="crafto_meta_box_tab" id="crafto_tab_<?php echo esc_attr( $tab_content_name ); ?>">
						<div class="main_tab_title">
							<h3>
								<?php
								echo isset( $crafto_page_tabs[ $tab_content_key ] ) ? $crafto_page_tabs[ $tab_content_key ] : '';// phpcs:ignore
								$reset_key = isset( $crafto_page_tabs[ $tab_content_key ] ) ? $crafto_page_tabs[ $tab_content_key ] : '';
								if ( 'Performance' === $reset_key ) {
									$clear_button_value = esc_html__( 'Reset', 'crafto-addons' ) . ' ' . $reset_key;
									?>
									<a href="javascript:void(0);" reset_key="<?php echo esc_attr( $reset_key ); ?>" class="button button-primary crafto_tab_reset_settings"><?php echo esc_html( $clear_button_value ); ?></a>
									<?php
								}
								?>
							</h3>
						</div>
						<?php
						if ( file_exists( CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-' . $tab_content_name . '.php' ) ) {
							require_once CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-' . $tab_content_name . '.php';
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
			<div class="clear"></div>
			<?php
		}
		/**
		 * Adds the meta box for Portfolio.
		 *
		 * @param mixed $crafto_post_type Crafto Post Type.
		 * @since 1.0
		 * @access public
		 */
		public function crafto_add_meta_boxes_portfolios( $crafto_post_type ) {
			// limit meta box to certain post types.
			$crafto_post_types = [
				'portfolio',
				'post',
			];

			$flag = false;
			if ( in_array( $crafto_post_type, $crafto_post_types, true ) ) {
				$flag = true;
			}

			if ( true === $flag ) {
				$this->crafto_add_meta_box(
					'crafto_admin_options_single',
					sprintf( 'Crafto %1$s %2$s', ucfirst( $crafto_post_type ), esc_html__( 'Format Data', 'crafto-addons' ) ),
					$crafto_post_type
				);
			}
		}

		/**
		 * Adds the meta box for Property.
		 *
		 * @param mixed $crafto_post_type Crafto Post Type.
		 * @since 1.0
		 * @access public
		 */
		public function crafto_add_meta_boxes_properties( $crafto_post_type ) {
			// limit meta box to certain post types.
			$crafto_post_types = [
				'properties',
				'tours',
			];

			$label = '';
			if ( 'properties' === $crafto_post_type ) {
				$label = esc_html__( 'Property', 'crafto-addons' );
			}

			if ( 'tours' === $crafto_post_type ) {
				$label = esc_html__( 'Tour', 'crafto-addons' );
			}

			$flag = false;
			if ( in_array( $crafto_post_type, $crafto_post_types, true ) ) {
				$flag = true;
			}

			if ( true === $flag ) {
				$this->crafto_add_meta_box(
					'crafto_admin_options_single',
					sprintf( 'Crafto %1$s %2$s', $label, esc_html__( 'Details', 'crafto-addons' ) ),
					$crafto_post_type
				);
			}
		}

		/**
		 * Adds the meta box for Theme Builder.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function crafto_meta_builder_setting() {
			global $post;
			?>
			<div class="crafto_meta_box_tab_content_single">
				<div id="crafto_tab_single" class="crafto_meta_box_tab"></div>
				<?php
				if ( isset( $post->post_type ) && ! empty( $post->post_type ) && 'themebuilder' === $post->post_type ) {
					if ( file_exists( CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-bulider-section-settings.php' ) ) {
						require_once CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-bulider-section-settings.php';
					}
				}
				?>
			</div>
			<div class="clear"></div>
			<?php
		}

		/**
		 * Adds the meta box for single post and portfolio
		 *
		 * @since 1.0
		 * @access public
		 */
		public function crafto_admin_options_single() {
			global $post;
			?>
			<div class="crafto_meta_box_tab_content_single">
				<?php
				if ( 'portfolio' === $post->post_type ) {
					?>
					<input name="crafto_portfolio_post_type_single" id="crafto_portfolio_post_type_single" type="hidden" value="" />
					<?php
				}
				?>
				<div class="crafto_meta_box_tab" id="crafto_tab_single"></div>
				<?php
				if ( 'post' === $post->post_type ) {
					if ( file_exists( CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-post-setting.php' ) ) {
						require_once CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-post-setting.php';
					}
				} elseif ( 'portfolio' === $post->post_type ) {
					if ( file_exists( CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-portfolio-setting.php' ) ) {
						require_once CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-portfolio-setting.php';
					}
				} elseif ( 'properties' === $post->post_type ) {
					if ( file_exists( CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-property-setting.php' ) ) {
						require_once CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-property-setting.php';
					}
				} elseif ( 'tours' === $post->post_type ) {
					if ( file_exists( CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-tour-setting.php' ) ) {
						require_once CRAFTO_ADDONS_METABOX_DIR . '/metabox-tabs/metabox-tour-setting.php';
					}
				}
				?>
			</div>
			<div class="clear"></div>
			<?php
		}

		/**
		 * Save the meta when the post is saved.
		 *
		 * @param int $crafto_post_id The ID of the post being saved.
		 */
		public function crafto_save_meta_box( $crafto_post_id ) {

			// If this is an autosave, our form has not been submitted,
			// so we don't want to do anything.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $crafto_post_id;
			}
			/* OK, its safe for us to save the data now. */
			$crafto_data    = [];
			$select_options = [];
			// Meta Prefix.
			$meta_prefix = '_';
			foreach ( $_POST as $key => $value ) { // phpcs:ignore

				if ( strpos( $key, 'crafto_custom_meta_' ) !== false ) {
					continue;
				}

				// Sanitize the user input.
				$crafto_data = isset( $_POST[ $key ] ) ? $_POST[ $key ] : ''; // phpcs:ignore

				if ( strstr( $key, '_crafto_' ) ) {
					$select_options[] = array(
						strstr( $key, '_crafto_' ) => $crafto_data,
					);

				} elseif ( strstr( $key, 'crafto_' ) ) {
					$select_options[] = array(
						strstr( $meta_prefix . $key, 'crafto_' ) => $crafto_data,
					);
				}

				if ( isset( $_POST[ 'crafto_preload_resources' ] ) && is_array( $_POST[ 'crafto_preload_resources' ] ) ) { // phpcs:ignore
					$preload_resources = [];
					foreach ( $_POST[ 'crafto_preload_resources' ] as $resource ) { // phpcs:ignore
						if ( ! empty( $resource['textarea'] ) && ! empty( $resource['select'] ) ) {
							$preload_resources[] = [
								'textarea' => sanitize_text_field( $resource['textarea'] ),
								'select'   => sanitize_text_field( $resource['select'] ),
							];
						}
					}

					update_post_meta( $crafto_post_id, 'crafto_global_meta', $preload_resources );
				}

				if ( isset( $_POST[ 'crafto_dequeue_scripts' ] ) && is_array( $_POST[ 'crafto_dequeue_scripts' ] ) ) { // phpcs:ignore
					$dequeue_scripts = [];
					foreach ( $_POST[ 'crafto_dequeue_scripts' ] as $resource ) { // phpcs:ignore
						if ( ! empty( $resource['textarea'] ) ) {
							$dequeue_scripts[] = [
								'textarea' => sanitize_text_field( $resource['textarea'] ),
							];
						}
					}

					update_post_meta( $crafto_post_id, 'crafto_global_meta', $dequeue_scripts );
				}

				if ( strstr( $key, 'crafto_theme_builder_template' ) ) {
					update_post_meta( $crafto_post_id, $meta_prefix . $key, $crafto_data );
				}

				update_post_meta( $crafto_post_id, 'crafto_global_meta', $select_options );
			}

			// List of fields to update.
			$fields_to_update = array(
				'_crafto_template_specific_post'               => isset( $_POST['crafto_template_specific_post'] ) ? $_POST['crafto_template_specific_post'] : [], // phpcs:ignore
				'_crafto_template_specific_portfolio'          => isset( $_POST['crafto_template_specific_portfolio'] ) ? $_POST['crafto_template_specific_portfolio'] : [], // phpcs:ignore
				'_crafto_template_specific_properties'         => isset( $_POST['crafto_template_specific_properties'] ) ? $_POST['crafto_template_specific_properties'] : [], // phpcs:ignore
				'_crafto_template_specific_tours'              => isset( $_POST['crafto_template_specific_tours'] ) ? $_POST['crafto_template_specific_tours'] : [], // phpcs:ignore
				'_crafto_template_specific_exclude_post'       => isset( $_POST['crafto_template_specific_exclude_post'] ) ? $_POST['crafto_template_specific_exclude_post'] : [], // phpcs:ignore
				'_crafto_template_specific_exclude_portfolio'  => isset( $_POST['crafto_template_specific_exclude_portfolio'] ) ? $_POST['crafto_template_specific_exclude_portfolio'] : [], // phpcs:ignore
				'_crafto_template_specific_exclude_properties' => isset( $_POST['crafto_template_specific_exclude_properties'] ) ? $_POST['crafto_template_specific_exclude_properties'] : [], // phpcs:ignore
				'_crafto_template_specific_exclude_tours'      => isset( $_POST['crafto_template_specific_exclude_tours'] ) ? $_POST['crafto_template_specific_exclude_tours'] : [], // phpcs:ignore
				'_crafto_mini_header_display_type'             => isset( $_POST['crafto_mini_header_display_type'] ) ? $_POST['crafto_mini_header_display_type'] : [], // phpcs:ignore
				'_crafto_header_display_type'                  => isset( $_POST['crafto_header_display_type'] ) ? $_POST['crafto_header_display_type'] : [], // phpcs:ignore
				'_crafto_footer_display_type'                  => isset( $_POST['crafto_footer_display_type'] ) ? $_POST['crafto_footer_display_type'] : [], // phpcs:ignore
				'_crafto_custom_title_display_type'            => isset( $_POST['crafto_custom_title_display_type'] ) ? $_POST['crafto_custom_title_display_type'] : [], // phpcs:ignore
			);

			// Update post meta for each field.
			foreach ( $fields_to_update as $meta_key => $meta_value ) {
				update_post_meta( $crafto_post_id, $meta_key, $meta_value );
			}
		}

		/**
		 * Enqueue scripts and styles admin side
		 */
		public function admin_script_loader() {
			global $pagenow;

			if ( is_admin() && ( 'post-new.php' === $pagenow || 'post.php' === $pagenow || 'edit-tags.php' === $pagenow || 'term.php' === $pagenow || 'user-edit.php' === $pagenow || 'profile.php' === $pagenow ) ) {

				wp_register_style(
					'alpha-color-picker',
					CRAFTO_ADDONS_METABOX_URI . '/css/alpha-color-picker.css',
					[
						'wp-color-picker',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-timepicker',
					CRAFTO_ADDONS_METABOX_URI . '/css/flatpickr.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'date-picker',
					CRAFTO_ADDONS_METABOX_URI . '/css/date-picker.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-admin-metabox',
					CRAFTO_ADDONS_METABOX_URI . '/css/meta-box.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_register_style(
					'crafto-admin-metabox-rtl',
					CRAFTO_ADDONS_METABOX_URI . '/css/meta-box-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);

				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_style( 'thickbox' );
				wp_enqueue_style( 'date-picker' );
				wp_enqueue_style( 'alpha-color-picker' );
				wp_enqueue_style( 'crafto-timepicker' );
				wp_enqueue_style( 'crafto-admin-metabox' );
				if ( is_rtl() ) {
					wp_enqueue_style( 'crafto-admin-metabox-rtl' );
				}

				wp_register_script(
					'alpha-color-picker',
					CRAFTO_ADDONS_METABOX_URI . '/js/alpha-color-picker.js',
					[
						'jquery',
						'wp-color-picker',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);

				wp_register_script(
					'crafto-timepicker',
					CRAFTO_ADDONS_METABOX_URI . '/js/flatpickr.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);

				wp_register_script(
					'crafto-admin-metabox-cookie',
					CRAFTO_ADDONS_METABOX_URI . '/js/metabox-cookie.js',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);

				wp_register_script(
					'crafto-admin-metabox',
					CRAFTO_ADDONS_METABOX_URI . '/js/meta-box.js',
					[
						'jquery',
						'crafto-select2',
						'crafto-admin-metabox-cookie',
						'media-upload',
						'jquery-ui-sortable',
						'alpha-color-picker',
						'crafto-timepicker',
					],
					CRAFTO_ADDONS_PLUGIN_VERSION,
					true
				);

				wp_enqueue_media();
				wp_enqueue_editor();
				wp_enqueue_script( 'wp-block-library' );
				wp_enqueue_script( 'wp-format-library' );
				wp_enqueue_script( 'wp-editor' );
				wp_enqueue_script( 'wp-color-picker' );
				wp_enqueue_script( 'media-upload' );
				wp_enqueue_script( 'thickbox' );
				wp_enqueue_script( 'jquery-ui-sortable' );
				wp_enqueue_script( 'alpha-color-picker' );
				wp_enqueue_script( 'crafto-admin-metabox-cookie-js' );
				wp_enqueue_script( 'crafto-admin-metabox' );
				wp_enqueue_script( 'jquery-ui-datepicker' );
				wp_enqueue_script( 'crafto-timepicker' );

				wp_localize_script(
					'crafto-admin-metabox',
					'CraftoMetabox',
					[
						'i18n'                   => [
							'reset_message' => esc_attr__( 'This will remove / clear all ### for this page and then it will use settings from WordPress customize panel. Are you sure to clear ###?', 'crafto-addons' ),
						],
						'preload_desktop'        => esc_html__( 'Desktop', 'crafto-addons' ),
						'preload_mobile'         => esc_html__( 'Mobile', 'crafto-addons' ),
						'preload_all'            => esc_html__( 'All Devices', 'crafto-addons' ),
						'preload_document'       => esc_html__( 'Document', 'crafto-addons' ),
						'preload_font'           => esc_html__( 'Font', 'crafto-addons' ),
						'preload_image'          => esc_html__( 'Image', 'crafto-addons' ),
						'preload_script'         => esc_html__( 'Script', 'crafto-addons' ),
						'preload_style'          => esc_html__( 'Style', 'crafto-addons' ),
						'custom_meta_iconpicker' => esc_html__( 'Select Icon', 'crafto-addons' ),
						'ajaxurl'                => admin_url( 'admin-ajax.php' ),
						'ai_post_button'         => esc_url( CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/crafto-ai-logo.svg' ),
					]
				);
			}
		}

		/**
		 * Default load text editor in wysiwyg
		 */
		public function crafto_wysiwyg_default_load() {
			return 'html';
		}
	}
}
