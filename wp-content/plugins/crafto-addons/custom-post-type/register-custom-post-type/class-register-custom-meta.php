<?php
/**
 * Register custom meta
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CraftoAddons\Classes\Crafto_Register_Custom_Meta' ) ) {
	/**
	 * Define Crafto_Register_Custom_Meta class
	 */
	class Crafto_Register_Custom_Meta {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'crafto_register_meta_menu' ), 10 );
			add_action( 'admin_init', array( $this, 'crafto_show_custom_meta_boxes' ), 10 );
			add_action( 'admin_init', array( $this, 'crafto_process_post_meta' ), 20 );
			add_action( 'wp_ajax_delete_custom_meta', array( $this, 'crafto_delete_custom_meta_callback' ) );
			add_action( 'admin_notices', array( $this, 'crafto_success_admin_notice' ) );
			add_action( 'admin_notices', array( $this, 'crafto_show_meta_error_notice' ) );
		}

		/**
		 * Show Custom Meta Boxes
		 */
		public function crafto_show_custom_meta_boxes() {
			$custom_meta_for = get_option( 'crafto_register_post_meta', [] );
			if ( ! empty( $custom_meta_for ) ) {
				foreach ( $custom_meta_for as $custom_meta_for_val ) {
					$select_meta_for = isset( $custom_meta_for_val['meta_for'] ) && ! empty( $custom_meta_for_val['meta_for'] ) ? $custom_meta_for_val['meta_for'] : '';
					if ( 'taxonomy' === $select_meta_for ) {
						if ( is_array( $custom_meta_for_val['taxonomies_for'] ) ) {
							foreach ( $custom_meta_for_val['taxonomies_for'] as $taxonomy ) {
								add_action( $taxonomy . '_edit_form_fields', array( $this, 'crafto_taxonomy_edit_meta_field' ), 10 );
								add_action( $taxonomy . '_add_form_fields', array( $this, 'crafto_taxonomy_add_meta_field' ), 10 );

								add_action( 'edited_' . $taxonomy, array( $this, 'custom_taxonomy_save_data' ), 10 );
								add_action( 'create_' . $taxonomy, array( $this, 'custom_taxonomy_save_data' ), 10 );
							}
						}
					} elseif ( 'post' === $select_meta_for ) {
						add_action( 'add_meta_boxes', array( $this, 'custom_meta_box_setup' ) );
						add_action( 'save_post', array( $this, 'custom_meta_box_save_data' ) );

					} elseif ( 'user' === $select_meta_for ) {
						if ( 'edit-profile' === $custom_meta_for_val['visible_at'] ) {
							add_action( 'show_user_profile', array( $this, 'add_custom_user_meta_fields' ) );
							add_action( 'personal_options_update', array( $this, 'save_custom_user_meta_fields' ) );
							add_action( 'edit_user_profile', array( $this, 'add_custom_user_meta_fields' ) );
							add_action( 'edit_user_profile_update', array( $this, 'save_custom_user_meta_fields' ) );
						} else {
							add_action( 'edit_user_profile', array( $this, 'add_custom_user_meta_fields' ) );
							add_action( 'edit_user_profile_update', array( $this, 'save_custom_user_meta_fields' ) );
						}
					}
				}
			}
		}

		/**
		 * Add Menu Custom Post Meta.
		 */
		public function crafto_register_meta_menu() {
			add_submenu_page(
				'crafto-theme-setup',
				esc_html__( 'Meta Boxes', 'crafto-addons' ),
				esc_html__( 'Meta Boxes', 'crafto-addons' ),
				'manage_options',
				'crafto-theme-meta-box',
				array( $this, 'crafto_theme_meta_box_callback' ),
				6
			);
		}

		/**
		 * Add Meta Menu.
		 */
		public function crafto_theme_meta_box_callback() {
			/* Check current user permission */
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'crafto-addons' ) );
			}

			$meta_page   = isset( $_GET['page'] ) && ! empty( $_GET['page'] ) ? $_GET['page'] : ''; // phpcs:ignore
			$meta_action = isset( $_GET['action'] ) && ! empty( $_GET['action'] ) ? $_GET['action'] : ''; // phpcs:ignore
			$meta_status = 'new';

			if ( 'crafto-theme-meta-box' === $meta_page && empty( $meta_action ) ) {

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

				$meta_table_heads = [
					esc_html__( 'Meta Boxes', 'crafto-addons' ),
					esc_html__( 'Meta Fields', 'crafto-addons' ),
					esc_html__( 'Show On', 'crafto-addons' ),
					esc_html__( 'Action', 'crafto-addons' ),
				];

				$meta_type = $this->crafto_get_post_meta_type();
				if ( ! is_array( $meta_type ) ) {
					return;
				}
				?>
				<div class="wrap crafto-taxonomies-listings">
					<h1 class="wp-heading-inline"><?php echo esc_html__( 'Meta Boxes List', 'crafto-addons' ); ?></h1>
					<?php
					if ( $crafto_is_theme_license_active ) {
						?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=crafto-theme-meta-box&action=add' ) ); ?>" class="page-title-action"><?php echo esc_html__( 'Add New Metabox', 'crafto-addons' ); ?></a>
						<?php
					}
					?>
				</div>
				<div class="crafto-list-table-wrap">
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
					<div class="crafto-metatype-list-table">
						<div class="crafto-metatype-list-table-heading">
							<div class="crafto-list-table-heading taxonomie-col-4">
								<?php
								foreach ( $meta_table_heads as $head ) {
									?>
									<div class="crafto-list-table-heading-cell">
										<?php echo esc_html( $head ); ?>
									</div>
									<?php
								}
								?>
							</div>
						</div>
						<?php
						if ( ! empty( $meta_type ) ) {
							?>
							<div class="crafto-metatype-list-table-items">
								<?php
								// Group meta items by title first.
								$grouped_meta = [];

								foreach ( $meta_type as $index => $meta_type_val ) {
									$title = isset( $meta_type_val['title'] ) ? $meta_type_val['title'] : '';

									$grouped_meta[ $title ][] = [
										'index' => $index,
										'meta'  => $meta_type_val,
									];
								}

								// Render grouped rows.
								foreach ( $grouped_meta as $title => $items ) {
									$first = true;

									foreach ( $items as $item ) {
										$index    = $item['index'];
										$meta_key = $item['meta'];

										$edit_path   = 'admin.php?page=crafto-theme-meta-box&action=edit&meta_id=meta-' . $index;
										$delete_path = 'admin.php?page=crafto-theme-meta-box&action=delete&meta_id=meta-' . $index;

										$post_type_link_url = is_network_admin() ? network_admin_url( $edit_path ) : admin_url( $edit_path );
										$delete_post_url    = is_network_admin() ? network_admin_url( $delete_path ) : admin_url( $delete_path );
										?>
										<div class="crafto-list-table-items <?php echo $first ? 'meta-title' : 'empty-title'; ?>">
											<div class="crafto-list-table-item name">
												<?php echo $first ? esc_html( $title ) : ''; ?>
											</div>
											<div class="crafto-list-table-item label">
												<?php echo esc_html( $meta_key['meta_label'] ); ?>
											</div>
											<div class="crafto-list-table-item slug">
												<?php
												if ( 'post' === $meta_key['meta_for'] ) {
													$post_type_list = [];
													$show_on        = isset( $meta_key['post_type_for'] ) && ! empty( $meta_key['post_type_for'] ) ? $meta_key['post_type_for'] : [ 'post' ];
													if ( is_string( $show_on ) ) {
														$show_on = [ $show_on ];
													}
													foreach ( $show_on as $show_on_value ) {
														$obj = get_post_type_object( $show_on_value );
														if ( ! empty( $obj ) ) {
															$post_type_list[] = $obj->labels->name;
														}
													}
													echo implode( ', ', $post_type_list ); // phpcs:ignore.
												} elseif ( 'taxonomy' === $meta_key['meta_for'] ) {
													$taxonomies_list = [];
													$show_on         = isset( $meta_key['taxonomies_for'] ) && ! empty( $meta_key['taxonomies_for'] ) ? $meta_key['taxonomies_for'] : [ 'category' ];
													if ( is_string( $show_on ) ) {
														$show_on = [ $show_on ];
													}
													foreach ( $show_on as $show_on_value ) {
														$obj = get_taxonomy( $show_on_value );
														if ( ! empty( $obj ) ) {
															$taxonomies_list[] = $obj->labels->name;
														}
													}
													echo implode( ', ', $taxonomies_list ); // phpcs:ignore.
												} else {
													$visible_at_options = [
														'edit'         => esc_html__( 'Edit User', 'crafto-addons' ),
														'edit-profile' => esc_html__( 'Edit User & Profile', 'crafto-addons' ),
													];

													$visible_at = isset( $meta_key['visible_at'] ) ? $meta_key['visible_at'] : '';

													if ( ! empty( $visible_at ) && isset( $visible_at_options[ $visible_at ] ) ) {
														echo esc_html( $visible_at_options[ $visible_at ] );
													}
												}
												?>
											</div>
											<div class="crafto-list-table-item actions">
												<div>
													<?php
													printf(
														'<a href="%s">%s</a>',
														esc_attr( $post_type_link_url ),
														esc_html__( 'Edit', 'crafto-addons' )
													);
													printf(
														'<a class="delete-post-meta" data-metatype="%s" href="%s">%s</a>',
														esc_attr( $meta_key['meta_label'] ),
														esc_attr( $delete_post_url ),
														esc_html__( 'Delete', 'crafto-addons' )
													);
													?>
												</div>
											</div>
										</div>
										<?php
										$first = false; // Don't show the title again in this group.
									}
								}
								?>
							</div>
							<?php
						} else {
							?>
							<div class="crafto-list-table-items">
								<div class="crafto-list-table-item not-found">
									<span><?php echo esc_html__( 'You haven\'t created any meta fields yet.', 'crafto-addons' ); ?></span>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}

			/* Add Form For Meta */
			$meta_deleted = apply_filters( 'crafto_meta_deleted', false );

			if ( 'crafto-theme-meta-box' === $meta_page && ! empty( $meta_action ) ) {
				if ( 'edit' === $meta_action ) {
					$meta_status = 'edit';

					$meta_val = $this->crafto_get_post_meta_type();

					$meta_deleted = $_GET['meta_id'] ?? null; // phpcs:ignore.

					$selected_meta = $this->crafto_get_current_meta( $meta_deleted );

					// Search for selected meta in meta_val.
					$current = null;
					foreach ( $meta_val as $meta_item ) {
						if ( 'meta-' . $meta_item['id'] === $selected_meta ) {
							$current = $meta_item;
							break;
						}
					}
				}
				?>
				<div class="wrap crafto-taxonomies-listings">
					<?php
					if ( 'edit' === $meta_action ) {
						?>
						<h1 class="wp-heading-inline"><?php echo esc_html__( 'Edit Meta Box', 'crafto-addons' ); ?></h1>
						<?php
					} else {
						?>
						<h1 class="wp-heading-inline"><?php echo esc_html__( 'Add New Meta Box', 'crafto-addons' ); ?></h1>
						<?php
					}
					?>
				</div>
				<form class="metaui" method="post" action="">
					<div class="registered-post-type-main-wrapper">
						<div class="registered-post-meta-main-left">
							<div class="general-settings-wrapper">
								<div class="main-title active">
									<h3><?php echo esc_html__( 'General Settings', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-meta-fields">
									<?php
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'select_existing_meta',
										esc_html__( 'Select / Add Meta', 'crafto-addons' ),
										'select_meta',
										'crafto_custom_meta',
										'',
										esc_html__( 'Create a new meta field or choose from existing ones to include in this meta box.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'title',
										sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Meta Box Title', 'crafto-addons' ) ),
										'text',
										'crafto_custom_meta',
										'',
										esc_html__( 'Enter the meta box title that will appear at the top of the meta box on the post edit screen. Please avoid special characters. For example, "Page Settings".', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'meta_for',
										esc_html__( 'Meta Box For', 'crafto-addons' ),
										'select',
										'crafto_custom_meta',
										'',
										esc_html__( 'Choose the target content type where this meta box will be added—Posts, Taxonomies, or User profiles.', 'crafto-addons' ),
										''
									);
									?>
								</div>
							</div>
							<div class="visiblity-settings-wrapper">
								<div class="main-title active">
									<h3><?php echo esc_html__( 'Visiblity Conditions', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-type-visiblity">
									<?php
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'post_type_for',
										esc_html__( 'Enable for Post Types', 'crafto-addons' ),
										'multiselect',
										'crafto_custom_meta',
										'',
										esc_html__( 'Select one or more post types where this meta box should appear in the post editor.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'taxonomies_for',
										esc_html__( 'Enable for Taxonomies', 'crafto-addons' ),
										'tax_multiselect',
										'crafto_custom_meta',
										'',
										esc_html__( 'Select taxonomies where this meta box should be displayed.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'visible_at',
										esc_html__( 'Visible At', 'crafto-addons' ),
										'select_user',
										'crafto_custom_meta',
										'',
										esc_html__( 'If selected "Edit User" meta fields will be visible only for website administrator on Edit User page, if "Edit User & Profile" - fields also will be visible at user Profile page and can be edited by user.', 'crafto-addons' ),
										''
									);
									?>
								</div>
							</div>
							<div class="meta-fields-wrapper">
								<div class="main-title active">
									<h3><?php echo esc_html__( 'Meta Fields', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-type-meta-field">
									<?php
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'meta_label',
										sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Label', 'crafto-addons' ) ),
										'text',
										'crafto_custom_meta',
										'',
										esc_html__( 'Displayed as the field label in the post edit screen.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'meta_slug',
										sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Name/ID', 'crafto-addons' ) ),
										'text',
										'crafto_custom_meta',
										'',
										esc_html__( 'The meta field name/key/ID under which the field will be stored in the database. It should contain only Latin letters, numbers, and _ characters.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'field_type',
										esc_html__( 'Field Type', 'crafto-addons' ),
										'select_field',
										'crafto_custom_meta',
										'',
										esc_html__( 'Select how this meta field should appear in the post edit screen (e.g., text, checkbox, select).', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'option_value',
										esc_html__( 'Bulk Options', 'crafto-addons' ),
										'textarea',
										'crafto_custom_meta',
										'',
										esc_html__( 'Enter each option using the format value::Label, and separate multiple options with commas. For example: value1::Label1,value2::Label2.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'select_value',
										esc_html__( 'Bulk Options', 'crafto-addons' ),
										'textarea',
										'crafto_custom_meta',
										'',
										esc_html__( 'Enter each option using the format value::Label, and separate multiple options with commas. For example: value1::Label1,value2::Label2.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'radio_value',
										esc_html__( 'Bulk Options', 'crafto-addons' ),
										'textarea',
										'crafto_custom_meta',
										'',
										esc_html__( 'Enter each option using the format value::Label, and separate multiple options with commas. For example: value1::Label1,value2::Label2.', 'crafto-addons' ),
										''
									);
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'description',
										esc_html__( 'Description', 'crafto-addons' ),
										'text',
										'crafto_custom_meta',
										'',
										esc_html__( 'This text appears as a description for the meta field in the post edit screen.', 'crafto-addons' ),
										''
									);
									?>
								</div>
							</div>
						</div>
						<div class="registered-post-type-main-right">
							<div class="submit-btn-wrapper">
								<?php
								wp_nonce_field( 'crafto_addedit_meta_nonce_action', 'crafto_addedit_meta_nonce_field' );
								if ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) { // phpcs:ignore.
									?>
									<input type="submit" class="button-primary" name="crafto_meta_submit" value="<?php echo esc_attr( apply_filters( 'crafto_meta_submit_edit', esc_attr__( 'Update Meta Box', 'crafto-addons' ) ) ); ?>">
									<input type="submit" class="button-secondary crafto-delete-bottom" name="crafto_delete_meta_val" id="crafto_submit_delete" value="<?php echo esc_attr( apply_filters( 'crafto_meta_submit_delete', esc_attr__( 'Delete Meta Box', 'crafto-addons' ) ) ); ?>">
									<?php
								} else {
									?>
									<input type="submit" class="button-primary crafto-meta-submit" name="crafto_meta_submit" value="<?php echo esc_attr( apply_filters( 'crafto_meta_submit_add', esc_attr__( 'Add Meta Box', 'crafto-addons' ) ) ); ?>" />
									<?php
								}
								if ( ! empty( $current ) ) {
									?>
									<input type="hidden" name="crafto_meta_original" id="crafto_meta_original" value="<?php echo esc_attr( 'meta-' . $current['id'] ); ?>"/>
									<?php
								}
								?>
								<input type="hidden" name="crafto_meta_status" id="crafto_meta_status" value="<?php echo esc_attr( $meta_status ); ?>" />
							</div>
						</div>
					</div>
				</form>
				<?php
			}
		}

		/**
		 * Fetch our crafto meta option.
		 *
		 * @return mixed
		 */
		public function crafto_get_post_meta_type() {
			return apply_filters( 'crafto_get_post_meta_type', get_option( 'crafto_register_post_meta', array() ) );
		}
		/**
		 * Return html of meta ui.
		 *
		 * @param  mixed  $current array of current post type.
		 * @param  string $key String value.
		 * @param  string $label String value.
		 * @param  string $type String value.
		 * @param  string $group String value.
		 * @param  string $default_select String value.
		 * @param  string $description String value.
		 * @param  string $placeholder String value.
		 */
		public function crafto_ui( $current, $key, $label, $type, $group, $default_select, $description, $placeholder ) {
			$ui_html   = '';
			$meta_type = $this->crafto_get_post_meta_type();

			switch ( $type ) {
				case 'select':
				case 'select_user':
				case 'select_field':
				case 'select_meta':
					// Common setup.
					$ui_html .= '<div class="field-control ' . esc_attr( $key ) . '">';
					$ui_html .= '<div class="left-part"><label for="' . esc_attr( $key ) . '"> ' . $label . ' </label>'; // phpcs:ignore.
					$ui_html .= '<p class="crafto-field-description description"> ' . $description . ' </p></div>'; // phpcs:ignore.

					// Generate options based on the type.
					$ui_html .= '<div class="right-part">';
					$ui_html .= '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $group ) . '[' . esc_attr( $key ) . ']">';
					// Determine the options dynamically.
					if ( 'select_user' === $type ) {
						// Options specific to 'select_user'.
						$options = [
							'edit'         => esc_html__( 'Edit User', 'crafto-addons' ),
							'edit-profile' => esc_html__( 'Edit User & Profile', 'crafto-addons' ),
						];
					} elseif ( 'select' === $type ) {
						// Options specific to 'select'.
						$options = [
							'post'     => esc_html__( 'Post', 'crafto-addons' ),
							'taxonomy' => esc_html__( 'Taxonomy', 'crafto-addons' ),
							'user'     => esc_html__( 'User', 'crafto-addons' ),
						];
					} elseif ( 'select_meta' === $type ) {
						// phpcs:ignore
						if ( 'add' === $_GET['action'] ) {
							$options['add_meta'] = esc_html__( 'Add New Meta', 'crafto-addons' );
						}

						foreach ( $meta_type as $val ) {
							$existing_title             = $val['title'];
							$options[ $existing_title ] = esc_html( $existing_title );
						}
					} else {
						// Options specific to 'select_field'.
						$options = [
							'text'        => esc_html__( 'Text', 'crafto-addons' ),
							'date'        => esc_html__( 'Date', 'crafto-addons' ),
							'time'        => esc_html__( 'Time', 'crafto-addons' ),
							'textarea'    => esc_html__( 'Textarea', 'crafto-addons' ),
							'whysiwyg'    => esc_html__( 'WYSIWYG', 'crafto-addons' ),
							'checkbox'    => esc_html__( 'Checkbox', 'crafto-addons' ),
							'number'      => esc_html__( 'Number', 'crafto-addons' ),
							'file'        => esc_html__( 'Media', 'crafto-addons' ),
							'select'      => esc_html__( 'Select', 'crafto-addons' ),
							'radio'       => esc_html__( 'Radio', 'crafto-addons' ),
							'colorpicker' => esc_html__( 'Colorpicker', 'crafto-addons' ),
							'iconpicker'  => esc_html__( 'Iconpicker', 'crafto-addons' ),
							'switcher'    => esc_html__( 'Switcher', 'crafto-addons' ),
						];
					}

					// Retrieve the saved value for the current field.
					$selected_value = isset( $current[ $key ] ) ? $current[ $key ] : '';

					foreach ( $options as $value => $text ) {
						$selected_attr = $value === $selected_value ? ' selected="selected"' : '';
						$ui_html      .= '<option value="' . esc_attr( $value ) . '"' . $selected_attr . '>' . esc_html( $text ) . '</option>';
					}
					$ui_html .= '</select>';
					$ui_html .= '</div>';
					$ui_html .= '</div>';
					break;
				case 'text':
					$required_aria  = 'false';
					$required_field = '';
					$disabled       = '';
					if ( 'meta_label' === $key || 'meta_slug' === $key || 'title' === $key ) {
						$required_aria  = 'true';
						$required_field = 'required';
					}

					$title_value_field_id = 'id_' . sanitize_title_with_dashes( $key );

					$placeholder = ! empty( $placeholder ) ? $placeholder : '';

					if ( isset( $current[ $key ] ) && 'add_meta' !== $current[ $key ] ) {
						if ( 'title' === $key ) {
							foreach ( $meta_type as $title_val ) {
								if ( is_array( $title_val ) && isset( $title_val['select_existing_meta'] ) ) {
									$text_box_value = $title_val['select_existing_meta'];
								}
							}
						}
					}

					$text_box_value = isset( $current[ $key ] ) ? esc_attr( $current[ $key ] ) : $default_select;

					if ( ! empty( $text_box_value ) && 'meta_slug' === $key ) {
						$disabled = 'disabled';
					}

					$ui_html .= '<div class="field-control" id="' . esc_attr( $title_value_field_id ) . '">';
					$ui_html .= '<div class="left-part"><label for="' . esc_attr( $key ) . '"> ' . $label . ' </label>';
					$ui_html .= '<p class="crafto-field-description description"> ' . $description . ' </p></div>'; // phpcs:ignore.
					$ui_html .= '<div class="right-part"><input type="text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $group ) . '[' . esc_attr( $key ) . ']" value="' . esc_html( $text_box_value ) . '" aria-required="' . esc_attr( $required_aria ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="' . esc_attr( $disabled ) . '" ' . $required_field . ' >';
					$ui_html .= '</div></div>';
					break;
				case 'multiselect':
					$ui_html .= '<div class="field-control ' . esc_attr( $key ) . '">';
					$ui_html .= '<div class="left-part"><label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label>';
					$ui_html .= '<p class="crafto-field-description description">' . esc_html( $description ) . '</p></div>';

					$ui_html .= '<div class="right-part">';
					$ui_html .= '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $group ) . '[' . esc_attr( $key ) . '][]" multiple="multiple" class="custom-meta-multiselect">';

					$selected_values = isset( $current[ $key ] ) && ! empty( $current[ $key ] ) ? (array) $current[ $key ] : [ 'post' ];

					// Fetch custom post types.
					$custom_post_types = crafto_get_post_types();

					foreach ( $custom_post_types as $post_type_slug => $post_type_object ) {
						// Exclude the 'attachment' post type.
						$selected_attr = in_array( $post_type_slug, $selected_values, true ) ? ' selected="selected"' : '';

						$ui_html .= '<option value="' . esc_attr( $post_type_slug ) . '"' . $selected_attr . '>' . esc_html( $post_type_object ) . '</option>';
					}

					$ui_html .= '</select>';
					$ui_html .= '</div></div>';
					break;
				case 'tax_multiselect':
					$ui_html .= '<div class="field-control ' . esc_attr( $key ) . '">';
					$ui_html .= '<div class="left-part"><label for="' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label>';
					$ui_html .= '<p class="crafto-field-description description">' . esc_html( $description ) . '</p></div>';

					$ui_html .= '<div class="right-part">';
					$ui_html .= '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $group ) . '[' . esc_attr( $key ) . '][]" multiple="multiple" class="custom-meta-multiselect">';

					$selected_values = isset( $current[ $key ] ) && ! empty( $current[ $key ] ) ? (array) $current[ $key ] : [ 'category' ];

					// Fetch taxonomies (including categories, tags, and custom taxonomies).
					$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );

					foreach ( $taxonomies as $taxonomy_slug => $taxonomy_object ) {
						if ( 'post_format' === $taxonomy_slug ) {
							continue;
						}
						// Display taxonomy slug as option value.
						$selected_attr = in_array( $taxonomy_slug, $selected_values, true ) ? ' selected="selected"' : '';
						$ui_html      .= '<option value="' . esc_attr( $taxonomy_slug ) . '"' . $selected_attr . '>' . esc_html( $taxonomy_object->labels->name ) . '</option>';
					}

					$ui_html .= '</select>';
					$ui_html .= '</div></div>';
					break;
				case 'textarea':
					$text_box_value = $default_select;
					// Handle custom meta group.
					$text_box_value = isset( $current[ $key ] ) ? $current[ $key ] : $text_box_value;
					// Sanitize and format the text_box_value with newlines preserved.
					$text_box_value = isset( $text_box_value ) ? $text_box_value : '';
					$text_box_value = esc_textarea( $text_box_value );

					// Create the field's unique ID and placeholder.
					$textarea_value_field_id = 'id_' . sanitize_title_with_dashes( $key );

					// HTML output for the textarea.
					$ui_html .= '<div class="field-control ' . esc_attr( $key ) . '" id="' . esc_attr( $textarea_value_field_id ) . '">';
					$ui_html .= '<div class="left-part"><label for="' . esc_attr( $key ) . '"> ' . esc_html( $label ) . ' </label>';
					$ui_html .= '<p class="crafto-field-description description"> ' . esc_html( $description ) . ' </p></div>';
					$ui_html .= '<div class="right-part">';
					$ui_html .= '<textarea id="' . esc_attr( $key ) . '" name="' . esc_attr( $group ) . '[' . esc_attr( $key ) . ']" >';
					$ui_html .= $text_box_value;
					$ui_html .= '</textarea>';
					$ui_html .= '</div></div>';
					break;
			}

			echo sprintf( '%1$s', $ui_html ); // phpcs:ignore
		}

		/**
		 * Handle the save and deletion of metabox data.
		 */
		public function crafto_process_post_meta() {
			// Handling form submission (POST request).
			if ( isset( $_POST['crafto_meta_submit'] ) ) { // phpcs:ignore
				// Nonce check for security.
				check_admin_referer( 'crafto_addedit_meta_nonce_action', 'crafto_addedit_meta_nonce_field' );

				// Get meta data from the form submission.
				$meta_data = isset( $_POST['crafto_custom_meta'] ) ? $_POST['crafto_custom_meta'] : array(); // phpcs:ignore.

				// Sanitize inputs.
				if ( 'add_meta' === $meta_data['select_existing_meta'] ) {
					$select_existing_meta = isset( $meta_data['select_existing_meta'] ) ? $meta_data['title'] : '';
				} else {
					$select_existing_meta = isset( $meta_data['select_existing_meta'] ) ? sanitize_text_field( $meta_data['select_existing_meta'] ) : '';
				}

				$title          = isset( $meta_data['title'] ) ? sanitize_text_field( $meta_data['title'] ) : '';
				$meta_for       = isset( $meta_data['meta_for'] ) ? sanitize_text_field( $meta_data['meta_for'] ) : '';
				$label          = isset( $meta_data['meta_label'] ) ? sanitize_text_field( $meta_data['meta_label'] ) : '';
				$post_type_for  = isset( $meta_data['post_type_for'] ) && is_array( $meta_data['post_type_for'] ) ? array_map( 'sanitize_text_field', $meta_data['post_type_for'] ) : 'post';
				$taxonomies_for = isset( $meta_data['taxonomies_for'] ) && is_array( $meta_data['taxonomies_for'] ) ? array_map( 'sanitize_text_field', $meta_data['taxonomies_for'] ) : '';
				$visible_at     = isset( $meta_data['visible_at'] ) ? sanitize_text_field( $meta_data['visible_at'] ) : '';
				$slug           = isset( $meta_data['meta_slug'] ) ? sanitize_text_field( $meta_data['meta_slug'] ) : '';
				$description    = isset( $meta_data['description'] ) ? sanitize_text_field( $meta_data['description'] ) : '';
				$field_type     = isset( $meta_data['field_type'] ) ? sanitize_text_field( $meta_data['field_type'] ) : '';
				$option_value   = isset( $meta_data['option_value'] ) ? sanitize_text_field( $meta_data['option_value'] ) : '';
				$select_value   = isset( $meta_data['select_value'] ) ? sanitize_text_field( $meta_data['select_value'] ) : '';
				$radio_value    = isset( $meta_data['radio_value'] ) ? sanitize_text_field( $meta_data['radio_value'] ) : '';

				// Check if meta_for exists to update or add new.
				if ( ! empty( $meta_for ) ) {
					// Retrieve current meta data.
					$current_meta_data = get_option( 'crafto_register_post_meta', array() );

					foreach ( $current_meta_data as $index => $meta_item ) {
						// Skip current if editing.
						if ( ! empty( $_GET['meta_id'] ) && 'meta-' . $index === $_GET['meta_id'] ) {
							continue;
						}

						if ( isset( $meta_item['meta_label'] ) && $meta_item['meta_label'] === $label ) {
							// Set transient and redirect to show error.
							set_transient( 'crafto_meta_error_notice', $meta_item['meta_label'], 30 );
							wp_safe_redirect( admin_url( 'admin.php?page=crafto-theme-meta-box' ) );
							exit;
						}
					}

					$meta_updated    = false;
					$meta_for_exists = false;
					$new_index       = null; // Initialize the new index variable.

					// Loop through the existing meta data to find the one that needs updating.
					foreach ( $current_meta_data as $index => $meta_item ) {
						if ( ! empty( $_GET['meta_id'] ) ) { // phpcs:ignore
							if ( 'meta-' . $index === $_GET['meta_id'] ) { // phpcs:ignore.
								// Update the meta data fields.
								$current_meta_data[ $index ] = array(
									'id'                   => $index,
									'title'                => $title,
									'meta_for'             => $meta_for,
									'meta_label'           => $label,
									'meta_slug'            => $slug,
									'description'          => $description,
									'post_type_for'        => $post_type_for,
									'taxonomies_for'       => $taxonomies_for,
									'visible_at'           => $visible_at,
									'field_type'           => $field_type,
									'option_value'         => $option_value,
									'select_value'         => $select_value,
									'radio_value'          => $radio_value,
									'select_existing_meta' => $select_existing_meta,
								);
								// Set the update flag to true.
								$meta_updated = true;
								// Mark meta_for as existing.
								$meta_for_exists = true;
								break;
							}
						}
					}

					// If no existing meta_for entry is found, add new entry.
					if ( ! $meta_for_exists ) {
						$max_id = ! empty( $current_meta_data ) ? max( array_column( $current_meta_data, 'id' ) ) : 0;
						// Set the new index to be the next available ID.
						$new_index                       = $max_id + 1;
						$current_meta_data[ $new_index ] = [
							'id'                   => $new_index,
							'title'                => $title,
							'meta_for'             => $meta_for,
							'meta_label'           => $label,
							'meta_slug'            => $slug,
							'description'          => $description,
							'post_type_for'        => $post_type_for,
							'taxonomies_for'       => $taxonomies_for,
							'visible_at'           => $visible_at,
							'field_type'           => $field_type,
							'option_value'         => $option_value,
							'select_value'         => $select_value,
							'radio_value'          => $radio_value,
							'select_existing_meta' => $select_existing_meta,
						];

						$meta_updated = true;
					}

					// Save the updated or new data back to the options table.
					if ( $meta_updated ) {
						update_option( 'crafto_register_post_meta', $current_meta_data );
					}

					// After update or addition, redirect accordingly.
					if ( $meta_for_exists ) {
						// Update: Redirect with the existing title.
						$edit_path = 'admin.php?page=crafto-theme-meta-box'; // phpcs:ignore.
					} else {
						// New entry: Redirect with the new index.
						$edit_path = 'admin.php?page=crafto-theme-meta-box';
					}

					$result = crafto_get_object_from_post_global();
					if ( $result ) {
						set_transient( 'crafto_meta_success_notice', $result, 30 );
					}

					if ( $meta_for_exists ) {
						$check_status = 'update_success';
					} else {
						$check_status = 'add_success';
					}
					set_transient( 'crafto_meta_status', $check_status );

					wp_safe_redirect( admin_url( $edit_path ) );
					exit;
				}
			}

			// Handling delete request from POST (form submit).
			if ( ( isset( $_POST['crafto_delete_meta_val'] ) || ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && isset( $_GET['meta_id'] ) ) ) ) { // phpcs:ignore
				// For POST method (form submission).
				if ( isset( $_POST['crafto_delete_meta_val'] ) ) { // phpcs:ignore
					check_admin_referer( 'crafto_addedit_meta_nonce_action', 'crafto_addedit_meta_nonce_field' );
					// Sanitize inputs.
					$filtered_data  = isset( $_POST['crafto_custom_meta'] ) ?  $_GET['meta_id'] : array(); // phpcs:ignore.
					$custom_meta_id = $filtered_data;
				} elseif ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && isset( $_GET['meta_id'] ) ) { // phpcs:ignore
					$custom_meta_id = $_GET['meta_id']; // phpcs:ignore.
				}

				if ( ! empty( $custom_meta_id ) ) {
					// Call the delete function.
					$result = $this->crafto_delete_meta( array( 'id' => $custom_meta_id ) );

					// Redirect based on the result.
					if ( 'delete_success' === $result ) {
						wp_safe_redirect( add_query_arg( 'deleted', 'true', admin_url( 'admin.php?page=crafto-theme-meta-box' ) ) );
						exit;
					} else {
						wp_safe_redirect( add_query_arg( 'deleted', 'false', admin_url( 'admin.php?page=crafto-theme-meta-box' ) ) );
						exit;
					}
				}
			}
		}

		/**
		 * Returns error message for if trying to register existing metabox.
		 */
		public function crafto_show_meta_error_notice() {
			$duplicate_label = get_transient( 'crafto_meta_error_notice' );
			if ( $duplicate_label ) {
				delete_transient( 'crafto_meta_error_notice' );

				echo sprintf(
					/* translators: %1$s is the error */

					/* translators: %2$s is the error message */

					/* translators: %3$s is the error message */

					/* translators: %4$s is the error message */
					'<div class="notice notice-error"><p><strong>%1$s</strong> %2$s %3$s %4$s</p></div>',
					esc_html__( 'Error:', 'crafto-addons' ),
					esc_html__( 'Please choose a different meta field label name.', 'crafto-addons' ),
					esc_html( $duplicate_label ),
					esc_html__( 'is already registered.', 'crafto-addons' ),
				);
			}
		}
		/**
		 * Display success message.
		 */
		public function crafto_success_admin_notice() {
			$status      = get_transient( 'crafto_meta_status' );
			$meta_result = get_transient( 'crafto_meta_success_notice' );

			if ( 'add_success' === $status ) {
				echo sprintf(
					/* translators: %1$s is the success */

					/* translators: %2$s is the success message */
					'<div class="notice notice-success"><p>%1$s %2$s</p></div>',
					esc_html( $meta_result ),
					esc_html__( ' has been successfully added', 'crafto-addons' ),
				);

			} elseif ( 'update_success' === $status ) {
				echo sprintf(
					/* translators: %1$s is the success */

					/* translators: %2$s is the success message */
					'<div class="notice notice-success"><p>%1$s %2$s</p></div>',
					esc_html( $meta_result ),
					esc_html__( ' has been successfully updated', 'crafto-addons' ),
				);
			}

			delete_transient( 'crafto_meta_status' );
			delete_transient( 'crafto_meta_success_notice' );
		}

		/**
		 * Delete our custom meta from the array of meta.
		 *
		 * @param array $data The data to delete. Expected to have a 'title' field.
		 * @return bool|string False on failure, string on success.
		 */
		public function crafto_delete_meta( $data = [] ) {
			if ( empty( $data['id'] ) ) {
				return 'delete_fail';
			}

			do_action( 'crafto_before_delete_meta', $data );
			$meta_data = get_option( 'crafto_register_post_meta', array() );

			foreach ( $meta_data as $key => $meta ) {
				if ( 'meta-' . $meta['id'] === $data['id'] ) {
					unset( $meta_data[ $key ] );
					break;
				}
			}

			$success = update_option( 'crafto_register_post_meta', $meta_data );
			if ( ! $success ) {
				return 'delete_fail';
			}

			do_action( 'crafto_after_delete_meta', $data );

			return 'delete_success';
		}

		/**
		 * Get current meta.
		 */
		public function crafto_get_current_meta() {
			$meta = false;
			if ( ! empty( $_GET ) && isset( $_GET['meta_id'] ) ) { // phpcs:ignore.
				$meta = sanitize_text_field( wp_unslash( $_GET['meta_id'] ) ); // phpcs:ignore.
			} else {
				$meta = $this->crafto_get_post_meta_type();
				if ( ! empty( $meta ) ) {
					// Will return the first array key.
					$meta = key( $meta );
				}
			}

			/**
			 * Filters the current meta to edit.
			 *
			 * @param string $meta meta_slug.
			 */
			return apply_filters( 'crafto_current_meta', $meta );
		}

		/**
		 * Save meta value.
		 *
		 * @param mixed $post_id array of current post type.
		 */
		public function custom_meta_box_save_data( $post_id ) {
			// Check if nonce is set and valid.
			if ( ! isset( $_POST['crafto_custom_meta_box_nonce_field'] ) || ! wp_verify_nonce( $_POST['crafto_custom_meta_box_nonce_field'], 'crafto_custom_meta_box_nonce' ) ) { // phpcs:ignore.
				return $post_id;
			}

			// Don't save if autosave or revision.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			// Check if the current user has permission to edit the post.
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}

			// Retrieve meta data array.
			$meta_data = get_option( 'crafto_register_post_meta', array() );

			// Loop through meta fields and save each value.
			foreach ( $meta_data as $meta_val ) {
				$meta_key = $meta_val['meta_slug'];

				if ( 'whysiwyg' === $meta_val['field_type'] ) {
					// Check and save the editor content.
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore
						// Sanitize the content before saving.
						$content = wp_kses_post( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.
						update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, $content );
					}
				} elseif ( 'file' === $meta_val['field_type'] ) {
					// Check if the image is selected via the media uploader.
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) && ! empty( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore
						$image_url = $_POST[ 'crafto_custom_meta_' . $meta_key ]; // phpcs:ignore.

						// Get the attachment ID from the image URL.
						$attachment_id = attachment_url_to_postid( $image_url );

						if ( $attachment_id ) {
							// Save the attachment ID in the custom meta field.
							update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, $attachment_id );
						}
					} else {
						delete_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key );
					}
				} elseif ( 'date' === $meta_val['field_type'] || 'time' === $meta_val['field_type'] ) {
					// Handle date field.
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore
						$date_value = sanitize_text_field( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.

						// Optionally, validate the date format, for example: 'Y-m-d'.
						if ( strtotime( $date_value ) ) {
							update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, $date_value );
						}
					}
				} elseif ( 'textarea' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore
						$textarea_value = sanitize_textarea_field( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.
						update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, $textarea_value );
					}
				} elseif ( 'colorpicker' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore
						$meta_value = $_POST[ 'crafto_custom_meta_' . $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = sanitize_hex_color( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.

						update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, $meta_value );
					}
				} elseif ( 'switcher' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) {
						// Ensure to sanitize the array of values.
						if ( 'yes' === $_POST[ 'crafto_custom_meta_' . $meta_key ] ) { // phpcs:ignore.
							update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, 'yes' );
						} else {
							update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, 'no' );
						}
					}
				} elseif ( 'iconpicker' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore
						$meta_value = $_POST[ 'crafto_custom_meta_' . $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = sanitize_text_field( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.

						// Ensure to sanitize the array of values.
						update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, $meta_value );
					}
				} else {
					// Handle other field types.
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore
						$meta_value = $_POST[ 'crafto_custom_meta_' . $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = array_map( 'sanitize_text_field', (array) $meta_value );
						update_post_meta( $post_id, 'crafto_custom_meta_' . $meta_key, $meta_value );
					}
				}
			}
			return $post_id;
		}

		/**
		 * Custom meta setup.
		 */
		public function custom_meta_box_setup() {
			$meta_data = get_option( 'crafto_register_post_meta', array() );
			foreach ( $meta_data as $meta_val ) {
				if ( 'post' === $meta_val['meta_for'] ) {
					$title = $meta_val['title'];

					$clean_title = preg_replace( '/[^a-zA-Z\s]/', '', $title );

					// Replace multiple spaces with single space (optional cleanup).
					$clean_title = preg_replace( '/\s+/', ' ', $clean_title );

					// Trim and replace spaces with underscores.
					$title_slug = str_replace( ' ', '_', trim( $clean_title ) );

					// Pass meta key as a parameter.
					add_meta_box(
						'crafto_meta_' . $title_slug,
						$meta_val['title'],
						[ $this, 'custom_meta_box_callback' ],
						$meta_val['post_type_for'],
						'normal',
						'high',
						[ 'meta_key' => $meta_val['title'] ], // phpcs:ignore.
					);
				}
			}
		}

		/**
		 * Custom meta callback.
		 *
		 * @param mixed $post array of current post type.
		 * @param mixed $meta_box array of current post type.
		 */
		public function custom_meta_box_callback( $post, $meta_box ) {
			wp_nonce_field( 'crafto_custom_meta_box_nonce', 'crafto_custom_meta_box_nonce_field' );

			// Retrieve the specific meta key for the current meta box.
			$meta_key = isset( $meta_box['args']['meta_key'] ) ? $meta_box['args']['meta_key'] : '';

			if ( ! empty( $meta_key ) ) {
				// Get the meta data for the current meta box.
				$meta_data = get_option( 'crafto_register_post_meta', [] );

				// Find the current meta box label based on the meta key.
				foreach ( $meta_data as $meta_val ) {
					if ( in_array( get_post_type(), $meta_val['post_type_for'], true ) && $meta_val['title'] === $meta_key && 'post' === $meta_val['meta_for'] ) {
						// Get the current meta value for the post.
						$meta_value = get_post_meta( $post->ID, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

						// Handle WYSIWYG editor.
						if ( 'whysiwyg' === $meta_val['field_type'] ) {
							// If the value is an array, convert it to a string (the editor needs a single string).
							if ( is_array( $meta_value ) ) {
								$meta_value = implode( ', ', $meta_value );
							}

							// If empty, initialize the value as empty string.
							if ( empty( $meta_value ) ) {
								$meta_value = '';
							}
						}
						?>
						<div class="custom-meta-wrap">
							<div class="custom-meta-left-part">
								<label for="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>"><?php echo esc_html( $meta_val['meta_label'] ); ?></label>
								<?php
								if ( ! empty( $meta_val['description'] ) ) {
									?>
									<p><?php echo esc_html( $meta_val['description'] ); ?></p>
									<?php
								}
								?>
							</div>
							<div class="custom-meta-right-part">
								<?php
								if ( 'textarea' === $meta_val['field_type'] ) {
									?>
									<textarea id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" rows="4" cols="50">
										<?php
										if ( ! empty( $meta_value ) ) {
											echo esc_html( $meta_value );
										}
										?>
									</textarea>
									<?php
								} elseif ( 'whysiwyg' === $meta_val['field_type'] ) {
									// Handle current meta value.
									$content       = html_entity_decode( $meta_value );
									$editor_id     = 'meta_editor_' . esc_attr( $meta_val['meta_slug'] );
									$textarea_name = 'crafto_custom_meta_' . esc_attr( $meta_val['meta_slug'] );

									$settings = [
										'textarea_name' => $textarea_name,
										'media_buttons' => true,
										'textarea_rows' => 10,
										'teeny'         => true,
										'tinymce'       => true,
										'quicktags'     => true,
									];

									ob_start();
									wp_editor( $content, $editor_id, $settings );
									$editor_html = ob_get_clean();

									// Add custom class to wrapper div.
									$custom_wrapper_class = 'crafto-editor-wrapper';

									$editor_html = str_replace(
										'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap',
										'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap ' . $custom_wrapper_class,
										$editor_html
									);

									echo $editor_html; // phpcs:ignore

								} elseif ( 'file' === $meta_val['field_type'] ) {
									// Retrieve the saved attachment ID.
									$attachment_id = get_post_meta( $post->ID, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

									if ( $attachment_id ) {
										// Get the URL of the attachment (image).
										$image_url = wp_get_attachment_url( $attachment_id );
										?>
										<div class="custom-media" data-post-id="<?php echo $post->ID; ?>" data-meta-key="<?php echo esc_attr( $meta_val['meta_slug'] ); // phpcs:ignore. ?>">
											<img class="custom-upload-media-image" src="<?php echo esc_url( $image_url ) ? esc_url( $image_url ) : esc_url( CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/placeholder.png' ); ?>" alt="<?php echo esc_attr__( 'Image', 'crafto-addons' ); ?>" width="100" />
											<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $image_url ); ?>" />
											<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Change Image', 'crafto-addons' ); ?></button>
											<button type="button" class="remove-image-button button"><?php echo esc_html__( 'Remove Image', 'crafto-addons' ); ?></button> <!-- Remove button -->
										</div>
										<?php
									} else {
										?>
										<div class="custom-media">
											<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" />
											<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Upload Image', 'crafto-addons' ); ?></button>
										</div>
										<?php
									}
								} elseif ( 'date' === $meta_val['field_type'] ) {
									?>
									<input name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="custom-meta-datepicker" value="<?php echo esc_attr( $meta_value ); ?>" placeholder="<?php echo esc_attr__( 'Enter Your Date', 'crafto-addons' ); ?>" />
									<?php
								} elseif ( 'time' === $meta_val['field_type'] ) {
									?>
									<input type="time" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" placeholder="<?php echo esc_attr__( 'Enter Your Time', 'crafto-addons' ); ?>" />
									<?php
								} elseif ( 'checkbox' === $meta_val['field_type'] ) {
									$checkbox_selected_value = $meta_val['option_value'];
									$checkbox_options        = explode( ',', $checkbox_selected_value );

									if ( ! is_array( $meta_value ) ) {
										$meta_value = []; // Ensure it's an array to avoid errors.
									}

									// Loop through each option.
									foreach ( $checkbox_options as $checkbox_option ) {
										// Split each "value::label" by the "::".
										$checkbox_option_parts = explode( '::', $checkbox_option );

										if ( count( $checkbox_option_parts ) === 2 ) {
											$value = esc_attr( $checkbox_option_parts[0] );
											$label = esc_attr( $checkbox_option_parts[1] );

											// Check if this value is in the saved values array.
											$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';
											?>
											<input type="checkbox" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>[]" 
												id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
												value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore ?> />
											<?php
											if ( ! empty( $label ) ) {
												?>
												<span><?php echo esc_html( $label ); ?></span>
												<?php
											}
										}
									}
								} elseif ( 'radio' === $meta_val['field_type'] ) {

									if ( ! is_array( $meta_value ) ) {
										$meta_value = []; // Ensure it's an array to avoid errors.
									}

									$radio_selected_value = $meta_val['radio_value'];
									$radio_options        = explode( ',', $radio_selected_value );

									// Loop through each option.
									foreach ( $radio_options as $radio_option ) {
										// Split each "value::label" by the "::".
										$radio_option_parts = explode( '::', $radio_option );

										if ( count( $radio_option_parts ) === 2 ) {
											$value = esc_attr( $radio_option_parts[0] );
											$label = esc_attr( $radio_option_parts[1] );

											// Check if this value is the saved value.
											$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';
											?>
											<input type="radio" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>_<?php echo esc_attr( $value ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore ?> />
											<?php
											if ( ! empty( $label ) ) {
												?>
												<span><?php echo esc_html( $label ); ?></span>
												<?php
											}
										}
									}
								} elseif ( 'select' === $meta_val['field_type'] ) {
									?>
									<select name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
										<?php

										if ( ! is_array( $meta_value ) ) {
											$meta_value = []; // Ensure it's an array to avoid errors.
										}

										$custom_selected_value = $meta_val['select_value'];

										$options = explode( ',', $custom_selected_value );

										// Loop through each option.
										foreach ( $options as $option ) {
											// Split each "value::label" by the "::".
											$option_parts = explode( '::', $option );

											if ( count( $option_parts ) === 2 ) {
												$value = esc_attr( $option_parts[0] );
												$label = esc_attr( $option_parts[1] );

												// Check if this option is the selected one.
												$selected = in_array( $value, $meta_value, true ) ? 'selected' : '';

												// Output each option with the value and label.
												echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>'; // phpcs:ignore
											}
										}
										?>
									</select>
									<?php
								} elseif ( 'colorpicker' === $meta_val['field_type'] ) {
									?>
									<input type="text" class="crafto-color-picker" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ? $meta_value : '#000000' ); ?>" />
									<?php
								} elseif ( 'switcher' === $meta_val['field_type'] ) {
									?>
									<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="no">
									<label class="meta-switcher">
										<input type="checkbox" 
											id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
											name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
											value="yes" 
											<?php echo ( 'yes' === $meta_value ) ? 'checked' : ''; ?> />
										<span class="slider round"></span>
									</label>
									<?php
								} elseif ( 'iconpicker' === $meta_val['field_type'] ) {
									?>
									<!-- Icon Picker Popup (Hidden by default) -->
									<select id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="crafto-iconpicker" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
										<option></option>
										<?php
										$fontawesome_reg_icon   = crafto_fontawesome_reg();
										$fontawesome_solid_icon = crafto_fontawesome_solid();
										$fontawesome_brand_icon = crafto_fontawesome_brand();
										$fontawesome_light_icon = crafto_fontawesome_light();

										if ( ! empty( $fontawesome_solid_icon ) ) {
											?>
											<optgroup label="<?php echo esc_attr__( 'Font Awesome Solid Icon', 'crafto-addons' ); ?>">
												<?php
												// Loop through each available icon and set the selected icon.
												foreach ( $fontawesome_solid_icon as $val ) {
													$selected = ( 'fa-solid ' . $val === $meta_value ) ? 'selected' : '';
													?>
													<option <?php echo esc_attr( $selected ); ?> value="fa-solid <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-solid ' . $val ); // phpcs:ignore ?></option>
													<?php
												}
												?>
											</optgroup>
											<?php
										}
										if ( ! empty( $fontawesome_reg_icon ) ) {
											?>
											<optgroup label="<?php echo esc_attr__( 'Font Awesome Regular Icon', 'crafto-addons' ); ?>">
												<?php
												// Loop through each available icon and set the selected icon.
												foreach ( $fontawesome_reg_icon as $val ) {
													$selected = ( 'fa-regular ' . $val === $meta_value ) ? 'selected' : '';
													?>
													<option <?php echo esc_attr( $selected ); ?> value="fa-regular <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-regular ' . $val ); // phpcs:ignore ?></option>
													<?php
												}
												?>
											</optgroup>
											<?php
										}
										if ( ! empty( $fontawesome_brand_icon ) ) {
											?>
											<optgroup label="<?php echo esc_attr__( 'Font Awesome Brand Icon', 'crafto-addons' ); ?>">
												<?php
												// Loop through each available icon and set the selected icon.
												foreach ( $fontawesome_brand_icon as $val ) {
													$selected = ( 'fa-brands ' . $val === $meta_value ) ? 'selected' : '';
													?>
													<option <?php echo esc_attr( $selected ); ?> value="fa-brands <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-brands ' . $val ); // phpcs:ignore ?></option>
													<?php
												}
												?>
											</optgroup>
											<?php
										}
										if ( ! empty( $fontawesome_light_icon ) ) {
											?>
											<optgroup label="<?php echo esc_attr__( 'Font Awesome Light Icon', 'crafto-addons' ); ?>">
												<?php
												// Loop through each available icon and set the selected icon.
												foreach ( $fontawesome_light_icon as $val ) {
													$selected = ( 'fa-light ' . $val === $meta_value ) ? 'selected' : '';
													?>
													<option <?php echo esc_attr( $selected ); ?> value="fa-light <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-light ' . $val ); // phpcs:ignore ?></option>
													<?php
												}
												?>
											</optgroup>
											<?php
										}
										?>
									</select>
									<?php
								} else {
									?>
									<input type="<?php echo esc_html( $meta_val['field_type'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( ( '' === $meta_value ) ? $meta_value : $meta_value[0] ); ?>" placeholder="<?php echo esc_attr__( 'Enter Your Text', 'crafto-addons' ); ?>" />
									<?php
								}
								?>
							</div>
						</div>
						<?php
					}
				}
			}
		}

		/**
		 * Save category taxonomy meta
		 *
		 * @param object $term_id Taxonomy id.
		 */
		public function custom_taxonomy_save_data( $term_id ) {
			// Retrieve meta data array.
			$meta_data = get_option( 'crafto_register_post_meta', [] );

			// Loop through meta fields and save each value.
			foreach ( $meta_data as $meta_val ) {

				$meta_key = $meta_val['meta_slug'];

				if ( 'whysiwyg' === $meta_val['field_type'] ) {
					// Check and save the editor content.
					if ( isset( $_POST['crafto_custom_meta_' . $meta_key] ) ) { // phpcs:ignore.
						// Sanitize the content before saving.
						$content = wp_kses_post( $_POST['crafto_custom_meta_' . $meta_key] ); // phpcs:ignore.
						update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, $content );
					}
				} elseif ( 'file' === $meta_val['field_type'] ) {
					// Check if the image is selected via the media uploader.
					if ( isset( $_POST['crafto_custom_meta_' . $meta_key] ) && ! empty( $_POST['crafto_custom_meta_' . $meta_key] ) ) { // phpcs:ignore.
						$image_url = $_POST['crafto_custom_meta_' . $meta_key]; // phpcs:ignore.

						// Get the attachment ID from the image URL.
						$attachment_id = attachment_url_to_postid( $image_url );

						if ( $attachment_id ) {
							// Save the attachment ID in the custom meta field.
							update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, $attachment_id );
						}
					} else {
						delete_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key );
					}
				} elseif ( 'date' === $meta_val['field_type'] || 'time' === $meta_val['field_type'] ) {
					// Handle date field.
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore.
						$date_value = sanitize_text_field( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.

						// Optionally, validate the date format, for example: 'Y-m-d'.
						if ( strtotime( $date_value ) ) {
							update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, $date_value );
						}
					}
				} elseif ( 'textarea' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore.
						$textarea_value = sanitize_textarea_field( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.
						update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, $textarea_value );
					}
				} elseif ( 'colorpicker' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore.
						$meta_value = $_POST[ 'crafto_custom_meta_' . $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = sanitize_hex_color( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.

						update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, $meta_value );
					}
				} elseif ( 'switcher' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore.
						// Ensure to sanitize the array of values.
						if ( isset( $_POST['crafto_custom_meta_' . $meta_key] ) && 'yes' === $_POST['crafto_custom_meta_' . $meta_key] ) { // phpcs:ignore.
							update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, 'yes' );
						} else {
							update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, 'no' );
						}
					}
				} elseif ( 'iconpicker' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore.
						$meta_value = $_POST[ 'crafto_custom_meta_' . $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = sanitize_text_field( $_POST[ 'crafto_custom_meta_' . $meta_key ] ); // phpcs:ignore.

						// Ensure to sanitize the array of values.
						update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, $meta_value );
					}
				} else {
					// Handle other field types.
					if ( isset( $_POST[ 'crafto_custom_meta_' . $meta_key ] ) ) { // phpcs:ignore.
						$meta_value = $_POST[ 'crafto_custom_meta_' . $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = array_map( 'sanitize_text_field', (array) $meta_value );
						update_term_meta( $term_id, 'crafto_custom_meta_' . $meta_key, $meta_value );
					}
				}
			}
		}

		/**
		 * Add taxonomy meta fields.
		 *
		 * @param object $term Terms Objects.
		 */
		public function crafto_taxonomy_add_meta_field( $term ) {
			wp_nonce_field( 'crafto_custom_meta_box_nonce', 'crafto_custom_meta_box_nonce_field' );
			global $post;
			// Retrieve the specific meta key for the current meta box.
			$meta_data = get_option( 'crafto_register_post_meta', [] );

			foreach ( $meta_data as $meta_val ) {
				$taxonomy     = isset( $_GET['taxonomy'] ) ? sanitize_key( $_GET['taxonomy'] ) : ''; // phpcs:ignore
				$taxonomy_obj = get_taxonomy( $taxonomy );
				if ( in_array( $taxonomy_obj->name, $meta_val['taxonomies_for'], true ) && $meta_val['title'] && 'taxonomy' === $meta_val['meta_for'] ) {
					// Get the current meta value for the post.
					$current_term_id = is_object( $term ) && property_exists( $term, 'term_id' ) ? $term->term_id : '';
					$meta_value      = get_term_meta( $current_term_id, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

					// Handle WYSIWYG editor.
					if ( 'whysiwyg' === $meta_val['field_type'] ) {
						// If the value is an array, convert it to a string (the editor needs a single string).
						if ( is_array( $meta_value ) ) {
							$meta_value = implode( ', ', $meta_value );
						}

						// If empty, initialize the value as empty string.
						if ( empty( $meta_value ) ) {
							$meta_value = '';
						}
					}
					?>
					<div class="form-field">
						<div class="custom-meta-wrap">
							<label for="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>"><?php echo esc_html( $meta_val['meta_label'] ); ?></label>
							<?php
							if ( 'textarea' === $meta_val['field_type'] ) {
								?>
								<textarea id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" rows="4" cols="50">
									<?php
									if ( ! empty( $meta_value ) ) {
										echo esc_html( $meta_value );
									}
									?>
								</textarea>
								<?php
							} elseif ( 'whysiwyg' === $meta_val['field_type'] ) {
								// Handle current meta value.
								$content       = html_entity_decode( $meta_value );
								$editor_id     = 'meta_editor_' . esc_attr( $meta_val['meta_slug'] );
								$textarea_name = 'crafto_custom_meta_' . esc_attr( $meta_val['meta_slug'] );

								$settings = [
									'textarea_name' => $textarea_name,
									'media_buttons' => true,
									'textarea_rows' => 10,
									'teeny'         => true,
									'tinymce'       => true,
									'quicktags'     => true,
								];

								ob_start();
								wp_editor( $content, $editor_id, $settings );
								$editor_html = ob_get_clean();

								// Add custom class to wrapper div.
								$custom_wrapper_class = 'crafto-editor-wrapper';

								$editor_html = str_replace(
									'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap',
									'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap ' . $custom_wrapper_class,
									$editor_html
								);

								echo $editor_html; // phpcs:ignore
							} elseif ( 'file' === $meta_val['field_type'] ) {
								if ( is_object( $term ) && isset( $term->term_id ) ) {
									$term_id = $term->term_id;
								} else {
									$term_id = $term; // Assume it's an ID.
								}
								// Retrieve the saved attachment ID.
								$attachment_id = get_term_meta( $term_id, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

								if ( $attachment_id ) {
									// Get the URL of the attachment (image).
									$image_url = wp_get_attachment_url( $attachment_id );
									?>
									<div class="custom-media" data-post-id="<?php echo $term_id; ?>" data-meta-key="<?php echo esc_attr( $meta_val['meta_slug'] ); // phpcs:ignore. ?>">
										<img class="custom-upload-media-image" src="<?php echo esc_url( $image_url ) ? esc_url( $image_url ) : esc_url( CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/placeholder.png' ); ?>" alt="<?php echo esc_attr__( 'Image', 'crafto-addons' ); ?>" width="100" />
										<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $image_url ); ?>" />
										<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Change Image', 'crafto-addons' ); ?></button>
										<button type="button" class="remove-image-button button"><?php echo esc_html__( 'Remove Image', 'crafto-addons' ); ?></button> <!-- Remove button -->
									</div>
									<?php
								} else {
									?>
									<div class="custom-media">
										<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" />
										<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Upload Image', 'crafto-addons' ); ?></button>
									</div>
									<?php
								}
							} elseif ( 'date' === $meta_val['field_type'] ) {
								?>
								<input name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="custom-meta-datepicker" value="<?php echo esc_attr( $meta_value ); ?>" />
								<?php
							} elseif ( 'time' === $meta_val['field_type'] ) {
								?>
								<input type="time" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
								<?php
							} elseif ( 'checkbox' === $meta_val['field_type'] ) {
								$checkbox_selected_value = $meta_val['option_value'];
								$checkbox_options        = explode( ',', $checkbox_selected_value );

								if ( ! is_array( $meta_value ) ) {
									$meta_value = []; // Ensure it's an array to avoid errors.
								}

								// Loop through each option.
								foreach ( $checkbox_options as $checkbox_option ) {
									// Split each "value::label" by the "::".
									$checkbox_option_parts = explode( '::', $checkbox_option );

									if ( count( $checkbox_option_parts ) === 2 ) {
										$value = esc_attr( $checkbox_option_parts[0] );
										$label = esc_attr( $checkbox_option_parts[1] );

										// Check if this value is in the saved values array.
										$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';
										?>
										<div class="meta-checkbox">
											<input type="checkbox" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>[]" 
												id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
												value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore. ?> />
											<?php
											if ( ! empty( $label ) ) {
												?>
												<span><?php echo esc_html( $label ); ?></span>
												<?php
											}
											?>
										</div>
										<?php
									}
								}
							} elseif ( 'radio' === $meta_val['field_type'] ) {

								if ( ! is_array( $meta_value ) ) {
									$meta_value = []; // Ensure it's an array to avoid errors.
								}

								$radio_selected_value = $meta_val['radio_value'];
								$radio_options        = explode( ',', $radio_selected_value );

								// Loop through each option.
								foreach ( $radio_options as $radio_option ) {
									// Split each "value::label" by the "::".
									$radio_option_parts = explode( '::', $radio_option );

									if ( count( $radio_option_parts ) === 2 ) {
										$value = esc_attr( $radio_option_parts[0] );
										$label = esc_attr( $radio_option_parts[1] );

										// Check if this value is the saved value.
										$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';
										?>
										<div class="meta-radio-button">
											<input type="radio" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>_<?php echo esc_attr( $value ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore. ?> />
											<?php
											if ( ! empty( $label ) ) {
												?>
												<span><?php echo esc_html( $label ); ?></span>
												<?php
											}
											?>
										</div>
										<?php
									}
								}
							} elseif ( 'select' === $meta_val['field_type'] ) {
								?>
								<select name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
									<?php

									if ( ! is_array( $meta_value ) ) {
										$meta_value = []; // Ensure it's an array to avoid errors.
									}

									$custom_selected_value = $meta_val['select_value'];

									$options = explode( ',', $custom_selected_value );

									// Loop through each option.
									foreach ( $options as $option ) {
										// Split each "value::label" by the "::".
										$option_parts = explode( '::', $option );

										if ( count( $option_parts ) === 2 ) {
											$value = esc_attr( $option_parts[0] );
											$label = esc_attr( $option_parts[1] );

											// Check if this option is the selected one.
											$selected = in_array( $value, $meta_value, true ) ? 'selected' : '';

											// Output each option with the value and label.
											echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>'; // phpcs:ignore
										}
									}
									?>
								</select>
								<?php
							} elseif ( 'colorpicker' === $meta_val['field_type'] ) {
								?>
								<input type="text" class="crafto-color-picker" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ? $meta_value : '#000000' ); ?>" />
								<?php
							} elseif ( 'switcher' === $meta_val['field_type'] ) {
								?>
								<label class="meta-switcher">
									<input type="checkbox" 
										id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
										name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
										value="yes" 
										<?php echo ( $meta_value === 'yes' ) ? 'checked' : ''; // phpcs:ignore ?> />
									<span class="slider round"></span>
								</label>
								<?php
							} elseif ( 'iconpicker' === $meta_val['field_type'] ) {
								?>
								<!-- Icon Picker Popup (Hidden by default) -->
								<select id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="crafto-iconpicker" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
									<option></option>
									<?php
									$fontawesome_reg_icon   = crafto_fontawesome_reg();
									$fontawesome_solid_icon = crafto_fontawesome_solid();
									$fontawesome_brand_icon = crafto_fontawesome_brand();
									$fontawesome_light_icon = crafto_fontawesome_light();

									if ( ! empty( $fontawesome_solid_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Solid Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_solid_icon as $val ) {
												$selected = ( 'fa-solid ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-solid <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-solid ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									if ( ! empty( $fontawesome_reg_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Regular Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_reg_icon as $val ) {
												$selected = ( 'fa-regular ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-regular <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-regular ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									if ( ! empty( $fontawesome_brand_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Brand Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_brand_icon as $val ) {
												$selected = ( 'fa-brands ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-brands <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-brands ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									if ( ! empty( $fontawesome_light_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Light Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_light_icon as $val ) {
												$selected = ( 'fa-light ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-light <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-light ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									?>
								</select>
								<?php
							} else {
								?>
								<input type="<?php echo esc_html( $meta_val['field_type'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ? $meta_value[0] : '' ); ?>" />
								<?php
							}
							if ( ! empty( $meta_val['description'] ) ) {
								?>
								<p><?php echo esc_html( $meta_val['description'] ); ?></p>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				}
			}
		}

		/**
		 * Edit taxonomy meta fields.
		 *
		 * @param object $term Terms Objects.
		 */
		public function crafto_taxonomy_edit_meta_field( $term ) {
			wp_nonce_field( 'crafto_custom_meta_box_nonce', 'crafto_custom_meta_box_nonce_field' );

			// Retrieve the specific meta key for the current meta box.
			$meta_data = get_option( 'crafto_register_post_meta', [] );
			// Find the current meta box label based on the meta key.
			foreach ( $meta_data as $meta_val ) {
				$edit_taxonomy     = isset( $_GET['taxonomy'] ) ? sanitize_key( $_GET['taxonomy'] ) : ''; // phpcs:ignore
				$edit_taxonomy_obj = get_taxonomy( $edit_taxonomy );

				if ( in_array( $edit_taxonomy_obj->name, $meta_val['taxonomies_for'], true ) && $meta_val['title'] && 'taxonomy' === $meta_val['meta_for'] ) {
					// Get the current meta value for the post.
					$current_term_id = is_object( $term ) && property_exists( $term, 'term_id' ) ? $term->term_id : '';
					$meta_value      = get_term_meta( $current_term_id, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

					// Handle WYSIWYG editor.
					if ( 'whysiwyg' === $meta_val['field_type'] ) {
						// If the value is an array, convert it to a string (the editor needs a single string).
						if ( is_array( $meta_value ) ) {
							$meta_value = implode( ', ', $meta_value );
						}

						// If empty, initialize the value as empty string.
						if ( empty( $meta_value ) ) {
							$meta_value = '';
						}
					}
					?>
					<tr class="form-field">
						<th scope="row" valign="top">
							<label for="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>"><?php echo esc_html( $meta_val['meta_label'] ); ?></label>
						</th>
						<td>
							<?php
							if ( 'textarea' === $meta_val['field_type'] ) {
								?>
								<textarea id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" rows="4" cols="50">
									<?php
									if ( ! empty( $meta_value ) ) {
										echo esc_html( $meta_value );
									}
									?>
								</textarea>
								<?php
							} elseif ( 'whysiwyg' === $meta_val['field_type'] ) {
								// Handle current meta value.
								$content       = html_entity_decode( $meta_value );
								$editor_id     = 'meta_editor_' . esc_attr( $meta_val['meta_slug'] );
								$textarea_name = 'crafto_custom_meta_' . esc_attr( $meta_val['meta_slug'] );

								$settings = [
									'textarea_name' => $textarea_name,
									'media_buttons' => true,
									'textarea_rows' => 10,
									'teeny'         => true,
									'tinymce'       => true,
									'quicktags'     => true,
								];

								ob_start();
								wp_editor( $content, $editor_id, $settings );
								$editor_html = ob_get_clean();

								// Add custom class to wrapper div.
								$custom_wrapper_class = 'crafto-editor-wrapper';

								$editor_html = str_replace(
									'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap',
									'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap ' . $custom_wrapper_class,
									$editor_html
								);

								echo $editor_html; // phpcs:ignore
							} elseif ( 'file' === $meta_val['field_type'] ) {
								// Retrieve the saved attachment ID.
								$attachment_id = get_term_meta( $term->term_id, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );
								if ( $attachment_id ) {
									// Get the URL of the attachment (image).
									$image_url = wp_get_attachment_url( $attachment_id );
									?>
									<div class="custom-media" data-post-id="<?php echo $term->term_id; ?>" data-meta-key="<?php echo esc_attr( $meta_val['meta_slug'] ); // phpcs:ignore. ?>">
										<img class="custom-upload-media-image" src="<?php echo esc_url( $image_url ) ? esc_url( $image_url ) : esc_url( CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/placeholder.png' ); ?>" alt="<?php echo esc_attr__( 'Image', 'crafto-addons' ); ?>" width="100" />
										<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $image_url ); ?>" />
										<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Change Image', 'crafto-addons' ); ?></button>
										<button type="button" class="remove-image-button button"><?php echo esc_html__( 'Remove Image', 'crafto-addons' ); ?></button> <!-- Remove button -->
									</div>
									<?php
								} else {
									?>
									<div class="custom-media">
										<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" />
										<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Upload Image', 'crafto-addons' ); ?></button>
									</div>
									<?php
								}
							} elseif ( 'date' === $meta_val['field_type'] ) {
								?>
								<input name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="custom-meta-datepicker" value="<?php echo esc_attr( $meta_value ); ?>" />
								<?php
							} elseif ( 'time' === $meta_val['field_type'] ) {
								?>
								<input type="time" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
								<?php
							} elseif ( 'checkbox' === $meta_val['field_type'] ) {
								$checkbox_selected_value = $meta_val['option_value'];
								$checkbox_options        = explode( ',', $checkbox_selected_value );

								if ( ! is_array( $meta_value ) ) {
									$meta_value = []; // Ensure it's an array to avoid errors.
								}

								// Loop through each option.
								foreach ( $checkbox_options as $checkbox_option ) {
									// Split each "value::label" by the "::".
									$checkbox_option_parts = explode( '::', $checkbox_option );

									if ( count( $checkbox_option_parts ) === 2 ) {
										$value = esc_attr( $checkbox_option_parts[0] );
										$label = esc_attr( $checkbox_option_parts[1] );

										// Check if this value is in the saved values array.
										$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';
										?>
										<div class="meta-checkbox">
											<input type="checkbox" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>[]" 
												id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
												value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore. ?> />
											<?php
											if ( ! empty( $label ) ) {
												?>
												<span><?php echo esc_html( $label ); ?></span>
												<?php
											}
											?>
										</div>
										<?php
									}
								}
							} elseif ( 'radio' === $meta_val['field_type'] ) {

								if ( ! is_array( $meta_value ) ) {
									$meta_value = []; // Ensure it's an array to avoid errors.
								}

								$radio_selected_value = $meta_val['radio_value'];
								$radio_options        = explode( ',', $radio_selected_value );

								// Loop through each option.
								foreach ( $radio_options as $radio_option ) {
									// Split each "value::label" by the "::".
									$radio_option_parts = explode( '::', $radio_option );
									if ( count( $radio_option_parts ) === 2 ) {
										$value = esc_attr( $radio_option_parts[0] );
										$label = esc_attr( $radio_option_parts[1] );

										// Check if this value is the saved value.
										$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';

										?>
										<div class="meta-radio-button">
											<input type="radio" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>_<?php echo esc_attr( $value ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore. ?> />
											<?php
											if ( ! empty( $label ) ) {
												?>
												<span><?php echo esc_html( $label ); ?></span>
												<?php
											}
											?>
										</div>
										<?php
									}
								}
							} elseif ( 'select' === $meta_val['field_type'] ) {
								?>
								<select name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
									<?php
									if ( ! is_array( $meta_value ) ) {
										$meta_value = []; // Ensure it's an array to avoid errors.
									}

									$custom_selected_value = $meta_val['select_value'];

									$options = explode( ',', $custom_selected_value );

									// Loop through each option.
									foreach ( $options as $option ) {
										// Split each "value::label" by the "::".
										$option_parts = explode( '::', $option );

										if ( count( $option_parts ) === 2 ) {
											$value = esc_attr( $option_parts[0] );
											$label = esc_attr( $option_parts[1] );

											// Check if this option is the selected one.
											$selected = in_array( $value, $meta_value, true ) ? 'selected' : '';

											// Output each option with the value and label.
											echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>'; // phpcs:ignore
										}
									}
									?>
								</select>
								<?php
							} elseif ( 'colorpicker' === $meta_val['field_type'] ) {
								?>
								<input type="text" class="crafto-color-picker" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ? $meta_value : '#000000' ); ?>" />
								<?php
							} elseif ( 'switcher' === $meta_val['field_type'] ) {
								?>
								<label class="meta-switcher">
									<input type="checkbox" 
										id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
										name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
										value="yes" 
										<?php echo ( $meta_value === 'yes' ) ? 'checked' : ''; // phpcs:ignore ?> />
									<span class="slider round"></span>
								</label>
								<?php
							} elseif ( 'iconpicker' === $meta_val['field_type'] ) {
								?>
								<!-- Icon Picker Popup (Hidden by default) -->
								<select id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="crafto-iconpicker" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
									<option></option>
									<?php
									$fontawesome_reg_icon   = crafto_fontawesome_reg();
									$fontawesome_solid_icon = crafto_fontawesome_solid();
									$fontawesome_brand_icon = crafto_fontawesome_brand();
									$fontawesome_light_icon = crafto_fontawesome_light();

									if ( ! empty( $fontawesome_solid_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Solid Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_solid_icon as $val ) {
												$selected = ( 'fa-solid ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-solid <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-solid ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									if ( ! empty( $fontawesome_reg_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Regular Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_reg_icon as $val ) {
												$selected = ( 'fa-regular ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-regular <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-regular ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									if ( ! empty( $fontawesome_brand_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Brand Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_brand_icon as $val ) {
												$selected = ( 'fa-brands ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-brands <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-brands ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									if ( ! empty( $fontawesome_light_icon ) ) {
										?>
										<optgroup label="<?php echo esc_attr__( 'Font Awesome Light Icon', 'crafto-addons' ); ?>">
											<?php
											// Loop through each available icon and set the selected icon.
											foreach ( $fontawesome_light_icon as $val ) {
												$selected = ( 'fa-light ' . $val === $meta_value ) ? 'selected' : '';
												?>
												<option <?php echo esc_attr( $selected ); ?> value="fa-light <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-light ' . $val ); // phpcs:ignore ?></option>
												<?php
											}
											?>
										</optgroup>
										<?php
									}
									?>
								</select>
								<?php
							} else {
								?>
								<input type="<?php echo esc_html( $meta_val['field_type'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ? $meta_value[0] : '' ); ?>" />
								<?php
							}
							if ( ! empty( $meta_val['description'] ) ) {
								?>
								<p><?php echo esc_html( $meta_val['description'] ); ?></p>
								<?php
							}
							?>
						</td>
					</tr>
					<?php
				}
			}
		}
		/**
		 * Add user meta fields.
		 *
		 * @param object $user Terms Objects.
		 */
		public function add_custom_user_meta_fields( $user ) {
			wp_nonce_field( 'crafto_custom_meta_box_nonce', 'crafto_custom_meta_box_nonce_field' );

			// Retrieve the specific meta key for the current meta box.
			$meta_data = get_option( 'crafto_register_post_meta', array() );
			?>
			<h2><?php echo esc_html__( 'Crafto Custom Meta', 'crafto-addons' ); ?></h2>
			<table class="form-table">
				<tbody>
					<?php
					// Find the current meta box label based on the meta key.
					foreach ( $meta_data as $meta_val ) {
						if ( isset( $meta_val['meta_for'] ) && 'user' === $meta_val['meta_for'] ) {
							// Get the current meta value for the post.
							$meta_value = get_user_meta( $user->ID, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

							// Handle WYSIWYG editor.
							if ( 'whysiwyg' === $meta_val['field_type'] ) {
								// If the value is an array, convert it to a string (the editor needs a single string).
								if ( is_array( $meta_value ) ) {
									$meta_value = implode( ', ', $meta_value );
								}

								// If empty, initialize the value as empty string.
								if ( empty( $meta_value ) ) {
									$meta_value = '';
								}
							}
							if ( ! function_exists( 'is_user_edit_page' ) ) {
								/**
								 * Check user page.
								 */
								function is_user_edit_page() {
									global $pagenow;

									if ( 'profile.php' === $pagenow ) {
										return [ 'edit-profile' ];
									} elseif ( 'user-edit.php' === $pagenow ) {
										return [ 'edit-profile', 'edit' ];
									}
									return false;
								}
							}

							$page_type  = is_user_edit_page();
							$visible_at = $meta_val['visible_at'];
							if ( is_array( $page_type ) && in_array( $visible_at, $page_type, true ) ) {
								?>
								<tr class="form-field">
									<th>
										<label for="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>"><?php echo esc_html( $meta_val['meta_label'] ); ?></label>
									</th>
									<td>
										<?php
										if ( 'textarea' === $meta_val['field_type'] ) {
											?>
											<textarea id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" rows="4" cols="50">
												<?php
												if ( ! empty( $meta_value ) ) {
													echo esc_html( $meta_value );
												}
												?>
											</textarea>
											<?php
										} elseif ( 'whysiwyg' === $meta_val['field_type'] ) {
											// Handle current meta value.
											$content       = html_entity_decode( $meta_value );
											$editor_id     = 'meta_editor_' . esc_attr( $meta_val['meta_slug'] );
											$textarea_name = 'crafto_custom_meta_' . esc_attr( $meta_val['meta_slug'] );

											$settings = [
												'textarea_name' => $textarea_name,
												'media_buttons' => true,
												'textarea_rows' => 10,
												'teeny'   => true,
												'tinymce' => true,
												'quicktags' => true,
											];

											ob_start();
											wp_editor( $content, $editor_id, $settings );
											$editor_html = ob_get_clean();

											// Add custom class to wrapper div.
											$custom_wrapper_class = 'crafto-editor-wrapper';

											$editor_html = str_replace(
												'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap',
												'id="wp-' . $editor_id . '-wrap" class="wp-core-ui wp-editor-wrap ' . $custom_wrapper_class,
												$editor_html
											);

											echo $editor_html; // phpcs:ignore
										} elseif ( 'file' === $meta_val['field_type'] ) {
											// Retrieve the saved attachment ID.
											$attachment_id = get_user_meta( $user->ID, 'crafto_custom_meta_' . $meta_val['meta_slug'], true );

											if ( $attachment_id ) {
												// Get the URL of the attachment (image).
												$image_url = wp_get_attachment_url( $attachment_id );
												?>
												<div class="custom-media" data-post-id="<?php echo $user->ID; ?>" data-meta-key="<?php echo esc_attr( $meta_val['meta_slug'] ); // phpcs:ignore. ?>">
													<img class="custom-upload-media-image" src="<?php echo esc_url( $image_url ) ? esc_url( $image_url ) : esc_url( CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/placeholder.png' ); ?>" alt="<?php echo esc_attr__( 'Image', 'crafto-addons' ); ?>" width="100" />
													<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $image_url ); ?>" />
													<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Change Image', 'crafto-addons' ); ?></button>
													<button type="button" class="remove-image-button button"><?php echo esc_html__( 'Remove Image', 'crafto-addons' ); ?></button> <!-- Remove button -->
												</div>
												<?php
											} else {
												?>
												<div class="custom-media">
													<input type="hidden" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" />
													<button type="button" class="upload-image-button button"><?php echo esc_html__( 'Upload Image', 'crafto-addons' ); ?></button>
												</div>
												<?php
											}
										} elseif ( 'date' === $meta_val['field_type'] ) {
											?>
											<input name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="custom-meta-datepicker" value="<?php echo esc_attr( $meta_value ); ?>" />
											<?php
										} elseif ( 'time' === $meta_val['field_type'] ) {
											?>
											<input type="time" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" />
											<?php
										} elseif ( 'checkbox' === $meta_val['field_type'] ) {
											$checkbox_selected_value = $meta_val['option_value'];
											$checkbox_options        = explode( ',', $checkbox_selected_value );

											if ( ! is_array( $meta_value ) ) {
												$meta_value = []; // Ensure it's an array to avoid errors.
											}

											// Loop through each option.
											foreach ( $checkbox_options as $checkbox_option ) {
												// Split each "value::label" by the "::".
												$checkbox_option_parts = explode( '::', $checkbox_option );

												if ( count( $checkbox_option_parts ) === 2 ) {
													$value = esc_attr( $checkbox_option_parts[0] );
													$label = esc_attr( $checkbox_option_parts[1] );

													// Check if this value is in the saved values array.
													$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';
													?>
													<div class="meta-checkbox">
														<input type="checkbox" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>[]" 
															id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
															value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore. ?> />
														<?php
														if ( ! empty( $label ) ) {
															?>
															<span><?php echo esc_html( $label ); ?></span>
															<?php
														}
														?>
													</div>
													<?php
												}
											}
										} elseif ( 'radio' === $meta_val['field_type'] ) {

											if ( ! is_array( $meta_value ) ) {
												$meta_value = []; // Ensure it's an array to avoid errors.
											}

											$radio_selected_value = $meta_val['radio_value'];
											$radio_options        = explode( ',', $radio_selected_value );

											// Loop through each option.
											foreach ( $radio_options as $radio_option ) {
												// Split each "value::label" by the "::".
												$radio_option_parts = explode( '::', $radio_option );

												if ( count( $radio_option_parts ) === 2 ) {
													$value = esc_attr( $radio_option_parts[0] );
													$label = esc_attr( $radio_option_parts[1] );

													// Check if this value is the saved value.
													$is_checked = in_array( $value, $meta_value, true ) ? 'checked' : '';
													?>
													<div class="meta-radio-button">
														<input type="radio" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>_<?php echo esc_attr( $value ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo $is_checked; // phpcs:ignore ?> />
														<?php
														if ( ! empty( $label ) ) {
															?>
															<span><?php echo esc_html( $label ); ?></span>
															<?php
														}
														?>
													</div>
													<?php
												}
											}
										} elseif ( 'select' === $meta_val['field_type'] ) {
											?>
											<select name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
												<?php

												if ( ! is_array( $meta_value ) ) {
													$meta_value = []; // Ensure it's an array to avoid errors.
												}

												$custom_selected_value = $meta_val['select_value'];

												$options = explode( ',', $custom_selected_value );

												// Loop through each option.
												foreach ( $options as $option ) {
													// Split each "value::label" by the "::".
													$option_parts = explode( '::', $option );

													if ( count( $option_parts ) === 2 ) {
														$value = esc_attr( $option_parts[0] );
														$label = esc_attr( $option_parts[1] );

														// Check if this option is the selected one.
														$selected = in_array( $value, $meta_value, true ) ? 'selected' : '';
														// Output each option with the value and label.
														echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>'; // phpcs:ignore
													}
												}
												?>
											</select>
											<?php
										} elseif ( 'colorpicker' === $meta_val['field_type'] ) {
											?>
											<input type="text" class="crafto-color-picker" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ? $meta_value : '#000000' ); ?>" />
											<?php
										} elseif ( 'switcher' === $meta_val['field_type'] ) {
											?>
											<label class="meta-switcher">
												<input type="checkbox" 
													id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
													name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" 
													value="yes" 
													<?php echo ( 'yes' === $meta_value ) ? 'checked' : ''; ?> />
												<span class="slider round"></span>
											</label>
											<?php
										} elseif ( 'iconpicker' === $meta_val['field_type'] ) {
											?>
											<!-- Icon Picker Popup (Hidden by default) -->
											<select id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" class="crafto-iconpicker" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>">
												<option></option>
												<?php
												$fontawesome_reg_icon   = crafto_fontawesome_reg();
												$fontawesome_solid_icon = crafto_fontawesome_solid();
												$fontawesome_brand_icon = crafto_fontawesome_brand();
												$fontawesome_light_icon = crafto_fontawesome_light();

												if ( ! empty( $fontawesome_solid_icon ) ) {
													?>
													<optgroup label="<?php echo esc_attr__( 'Font Awesome Solid Icon', 'crafto-addons' ); ?>">
														<?php
														// Loop through each available icon and set the selected icon.
														foreach ( $fontawesome_solid_icon as $val ) {
															$selected = ( 'fa-solid ' . $val === $meta_value ) ? 'selected' : '';
															?>
															<option <?php echo esc_attr( $selected ); ?> value="fa-solid <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-solid ' . $val ); // phpcs:ignore ?></option>
															<?php
														}
														?>
													</optgroup>
													<?php
												}

												if ( ! empty( $fontawesome_reg_icon ) ) {
													?>
													<optgroup label="<?php echo esc_attr__( 'Font Awesome Regular Icon', 'crafto-addons' ); ?>">
														<?php
														// Loop through each available icon and set the selected icon.
														foreach ( $fontawesome_reg_icon as $val ) {
															$selected = ( 'fa-regular ' . $val === $meta_value ) ? 'selected' : '';
															?>
															<option <?php echo esc_attr( $selected ); ?> value="fa-regular <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-regular ' . $val ); // phpcs:ignore ?></option>
															<?php
														}
														?>
													</optgroup>
													<?php
												}

												if ( ! empty( $fontawesome_brand_icon ) ) {
													?>
													<optgroup label="<?php echo esc_attr__( 'Font Awesome Brand Icon', 'crafto-addons' ); ?>">
														<?php
														// Loop through each available icon and set the selected icon.
														foreach ( $fontawesome_brand_icon as $val ) {
															$selected = ( 'fa-brands ' . $val === $meta_value ) ? 'selected' : '';
															?>
															<option <?php echo esc_attr( $selected ); ?> value="fa-brands <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-brands ' . $val ); // phpcs:ignore ?></option>
															<?php
														}
														?>
													</optgroup>
													<?php
												}

												if ( ! empty( $fontawesome_light_icon ) ) {
													?>
													<optgroup label="<?php echo esc_attr__( 'Font Awesome Light Icon', 'crafto-addons' ); ?>">
														<?php
														// Loop through each available icon and set the selected icon.
														foreach ( $fontawesome_light_icon as $val ) {
															$selected = ( 'fa-light ' . $val === $meta_value ) ? 'selected' : '';
															?>
															<option <?php echo esc_attr( $selected ); ?> value="fa-light <?php echo esc_attr( $val ); ?>"><?php echo htmlspecialchars( 'fa-light ' . $val ); // phpcs:ignore ?></option>
															<?php
														}
														?>
													</optgroup>
													<?php
												}
												?>
											</select>
											<?php
										} else {
											?>
											<input type="<?php echo esc_html( $meta_val['field_type'] ); ?>" name="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" id="crafto_custom_meta_<?php echo esc_attr( $meta_val['meta_slug'] ); ?>" value="<?php echo esc_attr( $meta_value ? $meta_value[0] : '' ); ?>" />
											<?php
										}

										if ( ! empty( $meta_val['description'] ) ) {
											?>
											<p><?php echo esc_html( $meta_val['description'] ); ?></p>
											<?php
										}
										?>
									</td>
								</tr>
								<?php
							}
						}
					}
					?>
				</tbody>
			</table>
			<?php
		}

		/**
		 * Save user meta fields.
		 *
		 * @param object $user_id User Objects.
		 */
		public function save_custom_user_meta_fields( $user_id ) {
			// Loop through the meta data options to save values.
			$meta_data = get_option( 'crafto_register_post_meta', array() );

			foreach ( $meta_data as $meta_val ) {

				$meta_key = 'crafto_custom_meta_' . $meta_val['meta_slug'];

				// Save the value based on field type.
				if ( 'whysiwyg' === $meta_val['field_type'] ) {
					// Check and save the editor content.
					if ( isset( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						// Sanitize the content before saving.
						$content = wp_kses_post( $_POST[ $meta_key ] ); // phpcs:ignore.
						update_user_meta( $user_id, $meta_key, $content );
					}
				} elseif ( 'file' === $meta_val['field_type'] ) {
					// Check if the image is selected via the media uploader.
					if ( isset( $_POST[ $meta_key ] ) && ! empty( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						$image_url = $_POST[ $meta_key ]; // phpcs:ignore.

						// Get the attachment ID from the image URL.
						$attachment_id = attachment_url_to_postid( $image_url );

						if ( $attachment_id ) {
							// Save the attachment ID in the custom meta field.
							update_user_meta( $user_id, $meta_key, $attachment_id );
						}
					} else {
						delete_post_meta( $user_id, $meta_key );
					}
				} elseif ( 'date' === $meta_val['field_type'] || 'time' === $meta_val['field_type'] ) {
					// Handle date field.
					if ( isset( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						$date_value = sanitize_text_field( $_POST[ $meta_key ] ); // phpcs:ignore.

						// Optionally, validate the date format, for example: 'Y-m-d'.
						if ( strtotime( $date_value ) ) {
							update_user_meta( $user_id, $meta_key, $date_value );
						}
					}
				} elseif ( 'textarea' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						$textarea_value = sanitize_textarea_field( $_POST[ $meta_key ] ); // phpcs:ignore.
						update_user_meta( $user_id, $meta_key, $textarea_value );
					}
				} elseif ( 'colorpicker' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						$meta_value = $_POST[ $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = sanitize_hex_color( $_POST[ $meta_key ] ); // phpcs:ignore.

						update_user_meta( $user_id, $meta_key, $meta_value );
					}
				} elseif ( 'switcher' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						// Ensure to sanitize the array of values.
						if ( isset( $_POST[ $meta_key ] ) && 'yes' === $_POST[ $meta_key ] ) { // phpcs:ignore.
							update_user_meta( $user_id, $meta_key, 'yes' );
						} else {
							update_user_meta( $user_id, $meta_key, 'no' );
						}
					}
				} elseif ( 'iconpicker' === $meta_val['field_type'] ) {
					if ( isset( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						$meta_value = $_POST[ $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = sanitize_text_field( $_POST[ $meta_key ] ); // phpcs:ignore.

						// Ensure to sanitize the array of values.
						update_user_meta( $user_id, $meta_key, $meta_value );
					}
				} else {
					// Handle other field types.
					if ( isset( $_POST[ $meta_key ] ) ) { // phpcs:ignore.
						$meta_value = $_POST[ $meta_key ]; // phpcs:ignore.
						// Ensure to sanitize the array of values.
						$meta_value = array_map( 'sanitize_text_field', (array) $meta_value );
						update_user_meta( $user_id, $meta_key, $meta_value );
					}
				}
			}
		}

		/**
		 * Custom Meta Delete Handler.
		 */
		public function crafto_delete_custom_meta_callback() {
			$redirect_url = $_POST['redirect_url']; // phpcs:ignore
			$meta_label   = $_POST['meta_field']; // phpcs:ignore

			if ( empty( $redirect_url ) || empty( $meta_label ) ) {
				wp_send_json_error(
					array(
						'message' => esc_html__( 'Missing parameters', 'crafto-addons' ),
					)
				);
			}

			$meta  = $this->crafto_get_post_meta_type();
			$found = false;

			foreach ( $meta as $key => $meta_val ) {
				if ( isset( $meta_val['meta_label'] ) && $meta_val['meta_label'] === $meta_label ) {
					unset( $meta[ $key ] );
					$found = true;
					break;
				}
			}

			if ( $found ) {

				$success = update_option( 'crafto_register_post_meta', $meta );
				if ( $success ) {
					wp_send_json_success(
						array(
							'message' => esc_html__( 'Success', 'crafto-addons' ),
						)
					);
				} else {
					wp_send_json_error(
						array(
							'message' => esc_html__( 'Update option failed', 'crafto-addons' ),
						)
					);
				}
			}

			wp_send_json_error(
				array(
					'message' => esc_html__( 'Meta field not found', 'crafto-addons' ),
				)
			);
		}
	}

	new Crafto_Register_Custom_Meta();
}
