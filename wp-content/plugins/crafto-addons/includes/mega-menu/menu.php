<?php
/**
 * Mega Menu initialize
 *
 * @package Crafto
 */

namespace CraftoAddons\Mega_menu;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Menu` doesn't exists yet.
if ( ! class_exists( 'Menu' ) ) {

	/**
	 * Define menu class
	 */
	class Menu {

		protected $current_menu_id = null;

		/**
		 * Custom post type slug
		 *
		 * @var string $post_type Post type slug
		 */
		public $post_type = 'crafto-mega-menu';

		/**
		 * Constructor for the class
		 */
		public function __construct() {
			add_action( 'init', [ $this, 'register_post_type' ] );
			add_action( 'admin_footer', [ $this, 'admin_templates' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'crafto_menu_admin_script' ] );
			add_action( 'template_include', [ $this, 'set_post_type_template' ] );

			$this->edit_redirect();

			foreach ( $this->crafto_menu_tabs() as $tab ) {

				$ajax_action   = $tab['action'];
				$ajax_callback = $tab['callback'];

				add_action( 'wp_ajax_' . $ajax_action, [ $this, $ajax_callback ] );
				add_action( 'wp_ajax_nopriv_' . $ajax_action, [ $this, $ajax_callback ] );
			}
		}

		/**
		 * Add Crafto admin menu script.
		 */
		public function crafto_menu_admin_script() {
			global $pagenow;

			if ( 'nav-menus.php' !== $pagenow ) {
				return;
			}

			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );

			wp_register_style(
				'crafto-mega-menu-style',
				CRAFTO_ADDONS_MEGAMENU_URI . '/assets/admin/mega-menu-style.css',
				[],
				CRAFTO_ADDONS_PLUGIN_VERSION
			);
			wp_enqueue_style( 'crafto-mega-menu-style' );

			if ( is_rtl() ) {
				wp_register_style(
					'crafto-mega-menu-rtl',
					CRAFTO_ADDONS_MEGAMENU_URI . '/assets/admin/mega-menu-style-rtl.css',
					[],
					CRAFTO_ADDONS_PLUGIN_VERSION
				);
				wp_enqueue_style( 'crafto-mega-menu-rtl' );
			}

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
				'feather',
				CRAFTO_ADDONS_VENDORS_CSS_URI . '/feather-icons.css',
				[],
				CRAFTO_ADDONS_PLUGIN_VERSION
			);

			wp_enqueue_style( 'feather' );

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
				'fontawesome',
				CRAFTO_ADDONS_VENDORS_CSS_URI . '/fontawesome.min.css',
				[],
				'7.1.0'
			);
			wp_enqueue_style( 'fontawesome' );

			wp_register_script(
				'crafto-mega-menu-script',
				CRAFTO_ADDONS_MEGAMENU_URI . '/assets/admin/mega-menu-script.js',
				[
					'jquery',
					'wp-util',
					'crafto-select2',
				],
				CRAFTO_ADDONS_PLUGIN_VERSION,
				true
			);

			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'crafto-mega-menu-script' );

			wp_localize_script(
				'crafto-mega-menu-script',
				'CraftoMegamenu',
				array(
					'currentMenuId' => $this->get_selected_menu_id(),
					'tabs'          => $this->crafto_menu_tabs(),
					'i18n'          => array(
						'placeholder'          => esc_html__( 'Select Menu Item Icon', 'crafto-addons' ),
						'menulogourl'          => esc_url( CRAFTO_ADDONS_MEGAMENU_URI . '/assets/images/crafto-mega-menu-builder.svg' ),
						'saveLabel'            => esc_html__( 'Save Menu Settings', 'crafto-addons' ),
						'triggerLabel'         => esc_html__( 'Settings', 'crafto-addons' ),
						'leaveEditor'          => esc_html__( 'Are you sure you want to leave this panel? The changes you made may be lost.', 'crafto-addons' ),
						'megaMenuAlertMessage' => esc_html__( 'Please enable `Crafto Menu` settings for current location', 'crafto-addons' ),
						'selectMegamenu'       => esc_html__( 'Select Mega Menu Style', 'crafto-addons' ),
					),
					'editURL'       => add_query_arg(
						array(
							'crafto-open-editor' => 1,
							'item'               => '%id%',
							'menu'               => '%menuid%',
						),
						esc_url( admin_url( '/' ) )
					),
				)
			);
		}

		/**
		 * Add Crafto menu tabs.
		 */
		public function crafto_menu_tabs() {

			return apply_filters(
				'crafto-menu-settings-tabs',
				array(
					'content'    => array(
						'label'        => esc_html__( 'Item Content', 'crafto-addons' ),
						'template'     => false,
						'templateFile' => false,
						'action'       => 'crafto_menu_tab_content',
						'callback'     => 'get_tab_content',
						'data'         => array(),
						'depthFrom'    => 0,
						'depthTo'      => 1,
					),
					'icon'       => array(
						'label'        => esc_html__( 'Item Icon', 'crafto-addons' ),
						'template'     => false,
						'templateFile' => false,
						'action'       => 'crafto_menu_tab_icon',
						'callback'     => 'get_tab_icon',
						'data'         => array(),
						'depthFrom'    => 0,
						'depthTo'      => 100,
					),
					'item_label' => array(
						'label'        => esc_html__( 'Item Label', 'crafto-addons' ),
						'template'     => false,
						'templateFile' => false,
						'action'       => 'crafto_menu_tab_item_label',
						'callback'     => 'get_tab_item_label',
						'data'         => array(),
						'depthFrom'    => 0,
						'depthTo'      => 100,
					),
				)
			);
		}

		/**
		 * Add Crafto admin menu script.
		 */
		public function get_tab_content() {

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error(
					array(
						'message' => esc_html__( 'You are not allowed to do this', 'crafto-addons' ),
					)
				);
			}
			$menu_id = $this->get_requested_menu_id();
			?>
			<div class="crafto-content-tab-wrap content-tab-field-control">
				<?php
				$enable_mega_submenu   = get_post_meta( $menu_id, '_enable_mega_submenu', true );
				$disable_megamenu_link = get_post_meta( $menu_id, '_disable_megamenu_link', true );
				$mega_menu_style_meta  = get_post_meta( $menu_id, '_mega_menu_style', true );
				$mega_menu_style       = array(
					'default'    => esc_html__( 'Fixed Width', 'crafto-addons' ),
					'full-width' => esc_html__( 'Full Width', 'crafto-addons' ),
				);

				$d_none     = ( 'yes' === $enable_mega_submenu ) ? '' : ' display-none';
				$fulld_none = ( 'full-width' === $mega_menu_style_meta ) ? '' : ' display-none';

				$crafto_enable_header     = crafto_builder_option( 'crafto_enable_header', '1' );
				$crafto_header_section_id = function_exists( 'crafto_check_header_template_exist' ) ? crafto_check_header_template_exist() : '';
				$megamenu_hover_color     = get_post_meta( $menu_id, '_megamenu_hover_color', true );

				$flag = false;
				if ( '1' === $crafto_enable_header ) {
					if ( ! empty( $crafto_header_section_id ) && crafto_post_exists( $crafto_header_section_id ) ) {
						$flag = true;
					}
				}

				if ( $flag ) {
					?>
					<div class="crafto-content-tab-wrap-box">
						<span class="title">
							<?php echo esc_html__( 'Enable Mega Menu', 'crafto-addons' ); ?>
						</span>
						<label for="enable_mega_submenu" class="menu-checkbox-switch">
							<input type="checkbox" name="enable_mega_submenu" id="enable_mega_submenu" class="enable-mega-submenu" value="yes" <?php if ( isset( $enable_mega_submenu ) ) checked( $enable_mega_submenu, 'yes' ); // phpcs:ignore ?> data-current-nav-menu="<?php echo esc_attr( $this->get_selected_menu_id() ); ?>"/>
						</label>
					</div>
					<div class="crafto-content-tab-wrap-box menu-content-tb<?php echo esc_attr( $d_none ); ?>">
						<span class="title">
							<?php echo esc_html__( 'Disable Link (Toggle Only)', 'crafto-addons' ); ?>
						</span>
						<label for="disable_megamenu_link" class="menu-checkbox-switch">
							<input type="checkbox" name="disable_megamenu_link" id="disable_megamenu_link" class="disable-megamenu-link" value="yes" <?php if ( isset( $disable_megamenu_link ) ) checked( $disable_megamenu_link, 'yes' ); // phpcs:ignore ?> data-current-nav-menu="<?php echo esc_attr( $this->get_selected_menu_id() ); ?>"/>
						</label>
					</div>
					<div class="crafto-content-tab-wrap-box menu-content-tb<?php echo esc_attr( $d_none ); ?>">
						<span class="title">
							<?php echo esc_html__( 'Choose Mega Menu Style', 'crafto-addons' ); ?>
						</span>
						<select id="select_mega_menu" class="select-mega-menu" name="select_mega_menu">
							<?php
							foreach ( $mega_menu_style as $key => $val ) {
								$selected = ( $key === $mega_menu_style_meta ) ? ' selected="selected"' : '';
								?>
								<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $val ); ?></option>
								<?php
							}
							?>
						</select>
					</div>
					<div class="crafto-content-tab-wrap-box menu-content-tb<?php echo esc_attr( $d_none ); ?>">
						<label class="title">
							<?php echo esc_html__( 'Mega Menu Item Content', 'crafto-addons' ); ?>
						</label>
						<button id="mega_menu_item_content" class="crafto-menu-editor button button-primary button-large">
							<?php echo esc_html__( 'Edit with Elementor', 'crafto-addons' ); ?>
						</button>
					</div>
					<div class="crafto-content-tab-wrap-box crafto-megamenu-hover-color<?php echo esc_attr( $fulld_none ) . esc_attr( $d_none ); ?>">
						<label class="title">
							<?php echo esc_html__( 'Header Background Color on Menu Hover', 'crafto-addons' ); ?>
						</label>
						<input id="crafto_megamenu_hover_color" class="crafto_megamenu_hover_color" type="text" name="crafto_megamenu_hover_color" value="<?php echo esc_attr( $megamenu_hover_color ); ?>" />
					</div>
					<?php
				} else {
					?>
					<div class="warning-box">
						<?php
						$crafto_secion_builder_url = sprintf(
							'%s <a target="_blank" href="%s">%s</a> %s',
							esc_html__( 'To use the mega menu, first create a header and set display condition that determine where and how header is displayed.', 'crafto-addons' ),
							admin_url() . 'edit.php?post_type=themebuilder&template_type=header',
							esc_html__( 'Click here', 'crafto-addons' ),
							esc_html__( 'to manage the header.', 'crafto-addons' )
						);
						echo $crafto_secion_builder_url; // phpcs:ignore
						?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			die();
		}

		/**
		 * Menu item custom fields
		 */
		public function get_tab_icon() {
			$menu_id                 = $this->get_requested_menu_id();
			$menu_item_icon          = get_post_meta( $menu_id, '_menu_item_icon', true );
			$menu_item_icon_position = get_post_meta( $menu_id, '_menu_item_icon_position', true );
			$menu_item_image_id      = get_post_meta( $menu_id, '_menu_item_svg_icon_image', true );
			$menu_item_image_src     = wp_get_attachment_url( $menu_item_image_id );
			$cls_hidden              = ! empty( $menu_item_image_id ) ? '' : ' hidden';
			?>
			<div class="crafto-icon-tab-wrap content-tab-field-control">
				<div class="crafto-icon-container crafto-content-tab-wrap-box">
					<label for="menu-item-icon" class="title">
						<?php echo esc_html__( 'Select Menu Icon', 'crafto-addons' ); ?>
					</label>
					<?php
					$crafto_fontawesome_solid = crafto_fontawesome_solid();
					$crafto_fontawesome_reg   = crafto_fontawesome_reg();
					$crafto_fontawesome_brand = crafto_fontawesome_brand();
					$crafto_fontawesome_light = crafto_fontawesome_light();
					$crafto_et_line_icons     = crafto_et_line_icons();
					$crafto_themify_icons     = crafto_themify_icons();
					$crafto_simple_icons      = crafto_simple_icons();
					$crafto_icons_mind        = crafto_icons_mind();
					$crafto_bootstrap_icons   = crafto_bootstrap_icons();
					$crafto_feather_icons     = crafto_feather_icons();
					?>
					<select id="menu-item-icon" class="crafto-menu-icons" name="menu-item-icon">
						<option></option>
						<?php
						if ( ! empty( $crafto_fontawesome_solid ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Font Awesome Solid Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_fontawesome_solid as $val ) {
									$selected = ( 'fa-solid ' . $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="fa-solid <?php echo esc_attr( $val ); ?>" value="fa-solid <?php echo esc_attr( $val ); ?>">fa-solid <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_fontawesome_reg ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Font Awesome Regular Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_fontawesome_reg as $val ) {
									$selected = ( 'fa-regular ' . $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="fa-regular <?php echo esc_attr( $val ); ?>" value="fa-regular <?php echo esc_attr( $val ); ?>">fa-regular <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_fontawesome_brand ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Font Awesome Brand Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_fontawesome_brand as $val ) {
									$selected = ( 'fa-brands ' . $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="fa-brands <?php echo esc_attr( $val ); ?>" value="fa-brands <?php echo esc_attr( $val ); ?>">fa-brands <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_fontawesome_light ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Font Awesome Light Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_fontawesome_light as $val ) {
									$selected = ( 'fa-light ' . $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="fa-light <?php echo esc_attr( $val ); ?>" value="fa-light <?php echo esc_attr( $val ); ?>">fa-light <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_et_line_icons ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'ET Line Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_et_line_icons as $val ) {
									$selected = ( $val === $menu_item_icon ) ? ' selected="selected"' : ''; ?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="<?php echo esc_attr( $val ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_themify_icons ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Themify Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_themify_icons as $val ) {
									$selected = ( $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="<?php echo esc_attr( $val ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_simple_icons ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Simple Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_simple_icons as $val ) {
									$selected = ( $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="<?php echo esc_attr( $val ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_icons_mind ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Icons Mind Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_icons_mind as $val ) {
									$selected = ( $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="<?php echo esc_attr( $val ); ?>" value="<?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_bootstrap_icons ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Bootstrap Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_bootstrap_icons as $val ) {
									$selected = ( 'bi ' . $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="bi <?php echo esc_attr( $val ); ?>" value="bi <?php echo esc_attr( $val ); ?>">bi <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}

						if ( ! empty( $crafto_feather_icons ) ) {
							?>
							<optgroup label="<?php echo esc_attr__( 'Feather Icon', 'crafto-addons' ); ?>">
								<?php
								foreach ( $crafto_feather_icons as $val ) {
									$selected = ( 'feather ' . $val === $menu_item_icon ) ? ' selected="selected"' : '';
									?>
									<option <?php echo esc_attr( $selected ); ?> data="<?php echo esc_attr( $menu_item_icon ); ?> value, <?php echo esc_attr( $val ); ?> val, id=<?php echo esc_attr( $menu_id ); ?>" data-icon="feather <?php echo esc_attr( $val ); ?>" value="feather <?php echo esc_attr( $val ); ?>">feather <?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
									<?php
								}
								?>
							</optgroup>
							<?php
						}
						?>
					</select>
				</div>
				<div class="crafto-icon-container crafto-content-tab-wrap-box">
					<label for="crafto_upload_button" class="title">
						<?php echo esc_html__( 'Upload Image', 'crafto-addons' ); ?>
					</label>
					<input name="upload_field" class="upload_field" type="hidden" value="<?php echo esc_attr( $menu_item_image_id ); ?>" />
					<input class="crafto_upload_button" id="crafto_upload_button" type="button" value="<?php echo esc_attr__( 'Browse', 'crafto-addons' ); ?>" />
					<span class="crafto_remove_button button<?php echo esc_attr( $cls_hidden ); ?>"><?php echo esc_html__( 'Remove', 'crafto-addons' ); ?></span>
					<img class="upload_image_screenshort" src="<?php echo esc_url( $menu_item_image_src ); ?>" />
				</div>
				<div class="crafto-icon-container crafto-content-tab-wrap-box">
					<label for="menu-item-icon-position" class="title">
						<?php echo esc_html__( 'Icon Position', 'crafto-addons' ); ?>
					</label>
					<?php
					$menu_item_icon_position_arr = array(
						'before' => esc_html__( 'Before', 'crafto-addons' ),
						'after'  => esc_html__( 'After', 'crafto-addons' ),
					);
					?>
					<select id="menu-item-icon-position" class="menu-item-icon-position" name="menu-item-icon-position">
						<?php
						foreach ( $menu_item_icon_position_arr as $key => $val ) {
							$selected = ( $key === $menu_item_icon_position ) ? ' selected="selected"' : '';
							?>
							<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $key ); ?>"><?php echo htmlspecialchars( $val ); // phpcs:ignore ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
			<?php
			die();
		}
		/**
		 * Menu item custom fields
		 */
		public function get_tab_item_label() {
			$menu_id                  = $this->get_requested_menu_id();
			$menu_item_label          = get_post_meta( $menu_id, '_menu_item_label', true );
			$menu_item_label_color    = get_post_meta( $menu_id, '_menu_item_label_color', true );
			$menu_item_label_bg_color = get_post_meta( $menu_id, '_menu_item_label_bg_color', true );
			?>
			<div class="crafto-label-tab-wrap content-label-field-control">
				<div class="crafto-label-container crafto-content-tab-wrap-box">
					<label for="menu-item-label" class="title">
						<?php echo esc_html__( 'Label', 'crafto-addons' ); ?>
					</label>
					<input id="menu-item-label" class="menu-item-label" type="text" name="menu-item-label" value="<?php echo esc_attr( $menu_item_label ); ?>" />
				</div>
				<div class="crafto-label-container crafto-content-tab-wrap-box">
					<label for="menu-item-label-color" class="title">
						<?php echo esc_html__( 'Label Color', 'crafto-addons' ); ?>
					</label>
					<input id="menu-item-label-color" class="menu-item-label-color" type="text" name="menu-item-label-color" value="<?php echo esc_attr( $menu_item_label_color ); ?>" />
				</div>
				<div class="crafto-label-container crafto-content-tab-wrap-box">
					<label for="menu-item-label-text-color" class="title">
						<?php echo esc_html__( 'Label Background Color', 'crafto-addons' ); ?>
					</label>
					<input id="menu-item-label-bg-color" class="menu-item-label-bg-color" type="text" name="menu-item-label-bg-color" value="<?php echo esc_attr( $menu_item_label_bg_color ); ?>" />
				</div>
			</div>
			<?php
			die();
		}

		/**
		 * Print templates
		 */
		public function admin_templates() {
			$screen = get_current_screen();

			if ( 'nav-menus' !== $screen->base ) {
				return;
			}

			if ( ! is_crafto_theme_activated() ) {
				return;
			}

			$templates = array(
				'menu-trigger'  => 'menu-trigger.html',
				'popup-wrapper' => 'popup-wrapper.html',
				'popup-tabs'    => 'popup-tabs.html',
				'editor-frame'  => 'editor-frame.html',
			);
			$this->print_templates_array( $templates );
		}

		/**
		 * Print templates array
		 *
		 * @param array $templates List of templates to print.
		 */
		public function print_templates_array( $templates = array() ) {
			if ( empty( $templates ) ) {
				return;
			}

			foreach ( $templates as $id => $file ) {

				$file = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'templates/' . $file;

				if ( ! file_exists( $file ) ) {
					continue;
				}
				ob_start();
				include $file;
				$content = ob_get_clean();
				printf( '<script type="text/html" id="tmpl-%1$s">%2$s</script>', esc_attr( $id ), $content ); // phpcs:ignore
			}
		}

		/**
		 * Register custom post type - `Crafto Mega menu`
		 */
		public function register_post_type() {
			$labels = array(
				'name'          => esc_html__( 'Mega Menu Items', 'crafto-addons' ),
				'singular_name' => esc_html__( 'Mega Menu Item', 'crafto-addons' ),
				'add_new'       => esc_html__( 'Add New Mega Menu Item', 'crafto-addons' ),
				'add_new_item'  => esc_html__( 'Add New Mega Menu Item', 'crafto-addons' ),
				'edit_item'     => esc_html__( 'Edit Mega Menu Item', 'crafto-addons' ),
				'menu_name'     => esc_html__( 'Mega Menu Items', 'crafto-addons' ),
			);

			$args = array(
				'labels'              => $labels,
				'hierarchical'        => false,
				'description'         => 'description',
				'taxonomies'          => array(),
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => false,
				'show_in_admin_bar'   => true,
				'menu_position'       => null,
				'menu_icon'           => null,
				'show_in_nav_menus'   => false,
				'publicly_queryable'  => true,
				'exclude_from_search' => true,
				'has_archive'         => false,
				'query_var'           => true,
				'can_export'          => true,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'supports'            => array(
					'title',
					'thumbnail',
					'elementor',
					'author',
				),
			);
			register_post_type( 'crafto-mega-menu', $args );
		}

		/**
		 * Flush rules.
		 */
		public function apply_flush_rules() {
			global $wp_rewrite;

			// Flush the rules and tell it to write htaccess.
			$wp_rewrite->flush_rules( true );
		}

		/**
		 * Edit Redirect - `Crafto Mega menu`
		 */
		public function edit_redirect() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			if ( empty( $_REQUEST['crafto-open-editor'] ) ) { // phpcs:ignore
				return;
			}

			if ( empty( $_REQUEST['item'] ) ) { // phpcs:ignore
				return;
			}

			if ( empty( $_REQUEST['menu'] ) ) { // phpcs:ignore
				return;
			}

			$menu_id      = intval( $_REQUEST['menu'] ); // phpcs:ignore
			$menu_item_id = intval( $_REQUEST['item'] ); // phpcs:ignore
			$mega_menu_id = get_post_meta( $menu_item_id, '_crafto_menu_item', true );

			if ( ! $mega_menu_id ) {

				$mega_menu_id = wp_insert_post(
					array(
						'post_title'  => 'mega-item-' . $menu_item_id,
						'post_status' => 'publish',
						'post_type'   => 'crafto-mega-menu',
					)
				);

				update_post_meta( $menu_item_id, '_crafto_menu_item', $mega_menu_id );
			}

			$edit_link = add_query_arg(
				array(
					'post'        => $mega_menu_id,
					'action'      => 'elementor',
					'context'     => 'crafto-addons',
					'parent_menu' => $menu_id,
				),
				admin_url( 'post.php' )
			);
			wp_safe_redirect( $edit_link );
			die();
		}

		/**
		 * Post type templates array
		 *
		 * @param array $template List of templates to print.
		 */
		public function set_post_type_template( $template ) {
			if ( is_singular( $this->post_type ) ) {
				$template = trailingslashit( plugin_dir_path( __FILE__ ) ) . 'templates/blank.php';
			}
			return $template;
		}

		/**
		 * Select id
		 */
		public function get_selected_menu_id() {
			if ( null !== $this->current_menu_id ) {
				return $this->current_menu_id;
			}

			$nav_menus            = wp_get_nav_menus( array( 'orderby' => 'name' ) );
			$menu_count           = count( $nav_menus );
			$nav_menu_selected_id = isset( $_REQUEST['menu'] ) ? (int) $_REQUEST['menu'] : 0; // phpcs:ignore
			$add_new_screen       = ( isset( $_GET['menu'] ) && 0 === $_GET['menu'] ) ? true : false; // phpcs:ignore

			$this->current_menu_id = $nav_menu_selected_id;

			// If we have one theme location, and zero menus, we take them right into editing their first menu.
			$page_count = wp_count_posts( 'page' );

			$one_theme_location_no_menus = ( 1 === count( get_registered_nav_menus() ) && ! $add_new_screen && empty( $nav_menus ) && ! empty( $page_count->publish ) ) ? true : false;

			// Get recently edited nav menu.
			$recently_edited = absint( get_user_option( 'nav_menu_recently_edited' ) );
			if ( empty( $recently_edited ) && is_nav_menu( $this->current_menu_id ) ) {
				$recently_edited = $this->current_menu_id;
			}

			// Use $recently_edited if none are selected.
			if ( empty( $this->current_menu_id ) && ! isset( $_GET['menu'] ) && is_nav_menu( $recently_edited ) ) { // phpcs:ignore
				$this->current_menu_id = $recently_edited;
			}

			// On deletion of menu, if another menu exists, show it.
			if ( ! $add_new_screen && 0 < $menu_count && isset( $_GET['action'] ) && 'delete' == $_GET['action'] ) { // phpcs:ignore
				$this->current_menu_id = $nav_menus[0]->term_id;
			}

			// Set $this->current_menu_id to 0 if no menus.
			if ( $one_theme_location_no_menus ) {
				$this->current_menu_id = 0;
			} elseif ( empty( $this->current_menu_id ) && ! empty( $nav_menus ) && ! $add_new_screen ) {
				// if we have no selection yet, and we have menus, set to the first one in the list.
				$this->current_menu_id = $nav_menus[0]->term_id;
			}

			return $this->current_menu_id;
		}

		/**
		 * Requested menu id.
		 */
		public function get_requested_menu_id() {
			$menu_id = isset( $_REQUEST['menu_id'] ) ? absint( $_REQUEST['menu_id'] ) : false; // phpcs:ignore

			if ( ! $menu_id ) {
				wp_send_json_error(
					array(
						'message' => esc_html__( 'Incorrect input data', 'crafto-addons' ),
					)
				);
			}
			return $menu_id;
		}
	}
}
