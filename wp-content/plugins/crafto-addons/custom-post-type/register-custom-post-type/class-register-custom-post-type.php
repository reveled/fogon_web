<?php
/**
 * Register custom post type
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CraftoAddons\Classes\Crafto_Register_Custom_Post_Type' ) ) {
	/**
	 * Define Crafto_Register_Custom_Post_Type class
	 */
	class Crafto_Register_Custom_Post_Type {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'crafto_register_post_type_menu' ), 10 );
			add_action( 'init', array( $this, 'crafto_process_post_type' ), 20 );
			add_action( 'init', array( $this, 'crafto_create_custom_post_types' ), 30 );
			add_filter( 'crafto_post_type_slug_exists', array( $this, 'crafto_check_existing_post_type_slugs' ), 10, 3 );
			add_filter( 'crafto_post_type_slug_exists', array( $this, 'crafto_updated_post_type_slug_exists' ), 11, 3 );
			add_action( 'admin_init', array( $this, 'crafto_flush_rewrite_rules' ) );
			add_action( 'wp_ajax_delete_custom_post_type', array( $this, 'crafto_delete_custom_post_type_callback' ) );
		}

		/**
		 * Add Menu Custom Post Type.
		 */
		public function crafto_register_post_type_menu() {
			add_submenu_page(
				'crafto-theme-setup',
				esc_html__( 'Post Types', 'crafto-addons' ),
				esc_html__( 'Post Types', 'crafto-addons' ),
				'manage_options',
				'crafto-theme-post-types',
				array( $this, 'crafto_theme_post_types_callback' ),
				4
			);
		}

		/**
		 * Add Custom Post types Menu.
		 */
		public function crafto_theme_post_types_callback() {
			/* Check current user permission */
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'crafto-addons' ) );
			}

			$post_type_page        = isset ( $_GET['page'] ) && ! empty( $_GET['page'] ) ? $_GET['page'] : ''; // phpcs:ignore
			$post_type_page_action = isset ( $_GET['action'] ) && ! empty( $_GET['action'] ) ? $_GET['action'] : ''; // phpcs:ignore
			$post_type_status      = 'new';

			if ( 'crafto-theme-post-types' === $post_type_page && empty( $post_type_page_action ) ) {
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

				$post_type_table_heads = [
					esc_html__( 'Post Type Name', 'crafto-addons' ),
					esc_html__( 'Post Type Slug', 'crafto-addons' ),
					esc_html__( 'Action', 'crafto-addons' ),
				];

				$post_types = $this->crafto_get_post_type_data();
				?>
				<div class="wrap crafto-post-types-listings">
					<h1 class="wp-heading-inline"><?php echo esc_html__( 'Custom Post Types List', 'crafto-addons' ); ?></h1>
					<?php
					if ( $crafto_is_theme_license_active ) {
						?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=crafto-theme-post-types&action=add' ) ); ?>" class="page-title-action"><?php echo esc_html__( 'Add New Post Type', 'crafto-addons' ); ?></a>
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
					<div class="crafto-posttype-search-wrapper">
						<input type="text" id="crafto-posttype-search" placeholder="<?php echo esc_attr__( 'Search Post Types...', 'crafto-addons' ); ?>" />
					</div>
					<div class="crafto-posttype-list-table">
						<div class="crafto-posttype-list-table-heading">
							<div class="crafto-list-table-heading">
							<?php
							foreach ( $post_type_table_heads as $head ) {
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
						if ( ! empty( $post_types ) ) {
							?>
							<div class="crafto-posttype-list-table-items">
								<?php
								foreach ( $post_types as $post_type => $post_type_settings ) {
									$strings    = [];
									$supports   = [];
									$taxonomies = [];
									$archive    = '';
									foreach ( $post_type_settings as $settings_key => $settings_value ) {
										if ( 'labels' === $settings_key ) {
											continue;
										}

										if ( is_string( $settings_value ) ) {
											$strings[ $settings_key ] = $settings_value;
										} else {
											if ( 'supports' === $settings_key ) {
												$supports[ $settings_key ] = $settings_value;
											}

											if ( 'taxonomies' === $settings_key ) {
												$taxonomies[ $settings_key ] = $settings_value;

												// In case they are not associated from the post type settings.
												if ( empty( $taxonomies['taxonomies'] ) ) {
													$taxonomies['taxonomies'] = get_object_taxonomies( $post_type );
												}
											}
										}
										$archive = get_post_type_archive_link( $post_type );
									}

									$edit_path          = 'admin.php?page=crafto-theme-post-types&action=edit&crafto_post_type=' . $post_type;
									$delete_path        = 'admin.php?page=crafto-theme-post-types&action=delete&crafto_post_type=' . $post_type;
									$post_type_link_url = is_network_admin() ? network_admin_url( $edit_path ) : admin_url( $edit_path );
									$delete_post_url    = is_network_admin() ? network_admin_url( $delete_path ) : admin_url( $delete_path );
									?>
									<div class="crafto-list-table-items">
										<div class="crafto-list-table-item name">
											<a href="<?php echo $post_type_link_url; // phpcs:ignore ?>"><?php echo esc_html( $post_type_settings['label'] ); ?></a>
										</div>
										<div class="crafto-list-table-item slug"><?php echo esc_html( $post_type ); ?></div>
										<div class="crafto-list-table-item actions">
											<div>
												<?php
												printf(
													'<a href="%s">%s</a>',
													esc_attr( $post_type_link_url ),
													sprintf(
														/* translators: %s: Post type slug */
														esc_html__( 'Edit', 'crafto-addons' ),
													),
												);
												?>
												<span>&nbsp;|&nbsp;</span>
												<?php
												printf(
													'<a class="delete-post" data-posttype="' . esc_attr( $post_type ) . '" href="%s">%s</a>',
													esc_attr( $delete_post_url ),
													sprintf(
														/* translators: %s: Post type slug */
														esc_html__( 'Delete', 'crafto-addons' ),
													),
												);
												?>
											</div>
										</div>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						} else {
							?>
							<div class="crafto-list-table-items">
								<div class="crafto-list-table-item not-found">
									<span><?php echo esc_html__( 'You haven\'t registered any post types yet.', 'crafto-addons' ); ?></span>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}

			/* ADD FORM */
			$post_type_deleted = apply_filters( 'crafto_post_type_deleted', false );
			if ( 'crafto-theme-post-types' === $post_type_page && ! empty( $post_type_page_action ) ) {
				if ( 'edit' === $post_type_page_action ) {
					$post_type_status = 'edit';
					$post_types       = $this->crafto_get_post_type_data();
					if ( isset ( $_GET['crafto_post_type'] ) && ! empty( $_GET['crafto_post_type'] ) ) { // phpcs:ignore.
						$post_type_deleted = $_GET['crafto_post_type']; // phpcs:ignore.
					}

					$selected_post_type = $this->crafto_get_current_post_type( $post_type_deleted );
					if ( $selected_post_type && array_key_exists( $selected_post_type, $post_types ) ) {
						$current = $post_types[ $selected_post_type ];
					}
				}
				?>
				<div class="wrap crafto-post-types-listings">
					<?php
					if ( 'edit' === $post_type_page_action ) {
						?>
						<h1 class="wp-heading-inline"><?php echo esc_html__( 'Edit Post Type', 'crafto-addons' ); ?></h1>
						<?php
					} else {
						?>
						<h1 class="wp-heading-inline"><?php echo esc_html__( 'Add New Post Type', 'crafto-addons' ); ?></h1>
						<?php
					}
					?>
				</div>
				<form class="posttypesform" method="post" action="">
					<div class="registered-post-type-main-wrapper">
						<div class="registered-post-type-main-left">
							<div class="general-settings-wrapper">
								<div class="main-title active">									
									<h3><?php echo esc_html__( 'General Settings', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-type-fields">
								<?php
								$this->crafto_ui(
									isset( $current ) ? $current : '',
									'name',
									sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Post Type Slug', 'crafto-addons' ) ),
									'text',
									'crafto_custom_post_type',
									'',
									esc_html__( 'The post type name/slug, used for various queries related to post type content.', 'crafto-addons' ),
									''
								);

								$this->crafto_ui(
									isset( $current ) ? $current : '',
									'label',
									sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Plural Label', 'crafto-addons' ) ),
									'text',
									'crafto_custom_post_type',
									'',
									esc_html__( 'Used for the post type admin menu item.', 'crafto-addons' ),
									esc_html__( '(e.g. Teams)', 'crafto-addons' )
								);

								$this->crafto_ui(
									isset( $current ) ? $current : '',
									'singular_label',
									sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Singular Label', 'crafto-addons' ) ),
									'text',
									'crafto_custom_post_type',
									'',
									esc_html__( 'Used when a singular label is needed.', 'crafto-addons' ),
									esc_html__( '(e.g. Team)', 'crafto-addons' )
								);
								?>
								</div>
							</div>
							<div class="additional-settings-wrapper">
								<div class="main-title">
									<h3><?php echo esc_html__( 'Additional Label', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-type-fields">
									<?php
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'description',
										esc_html__( 'Post Type Description', 'crafto-addons' ),
										'text',
										'crafto_custom_post_type',
										'',
										esc_html__( 'Describe the purpose of your custom post type.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'menu_name',
										esc_html__( 'Menu Name', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Custom admin menu name for your custom post type.', 'crafto-addons' ),
										esc_html__( '(e.g. Teams)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'all_items',
										esc_html__( 'All Items', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the post type admin submenu.', 'crafto-addons' ),
										esc_html__( '(e.g. All Teams)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'add_new',
										esc_html__( 'Add New', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the post type admin submenu.', 'crafto-addons' ),
										esc_html__( '(e.g. Add New)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'add_new_item',
										esc_html__( 'Add New Item', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used at the top of the post editor screen for a new post type post.', 'crafto-addons' ),
										esc_html__( '(e.g. Add New Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'edit_item',
										esc_html__( 'Edit Item', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used at the top of the post editor screen for an existing post type post.', 'crafto-addons' ),
										esc_html__( '(e.g. Edit Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'new_item',
										esc_html__( 'New Item', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Post type label used in the admin menu.', 'crafto-addons' ),
										esc_html__( '(e.g. New Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'view_item',
										esc_html__( 'View Item', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Appears in the admin bar when viewing a published post of this post type.', 'crafto-addons' ),
										esc_html__( '(e.g. View Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'view_items',
										esc_html__( 'View Items', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the admin bar when viewing editor screen for a published post in the post type.', 'crafto-addons' ),
										esc_html__( '(e.g. View Teams)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'search_items',
										esc_html__( 'Search Item', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used as the text for the search button on the post type list screen.', 'crafto-addons' ),
										esc_html__( '(e.g. Search Teams)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'not_found',
										esc_html__( 'Not Found', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used when there are no posts to display on the post type list screen.', 'crafto-addons' ),
										esc_html__( '(e.g. No Teams Found)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'not_found_in_trash',
										esc_html__( 'Not Found in Trash', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used when there are no posts to display on the post type list screen.', 'crafto-addons' ),
										esc_html__( '(e.g. No Teams Found in Trash)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'parent',
										esc_html__( 'Parent', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used for hierarchical types that need a colon.', 'crafto-addons' ),
										esc_html__( '(e.g. Parent Team:)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'featured_image',
										esc_html__( 'Featured Image', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used as the "Featured Image" phrase for the post type.', 'crafto-addons' ),
										esc_html__( '(e.g. Featured Image for This Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'set_featured_image',
										esc_html__( 'Set Featured Image', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used as the "Set Featured Image" phrase for the post type.', 'crafto-addons' ),
										esc_html__( '(e.g. Set Featured Image for This Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'remove_featured_image',
										esc_html__( 'Remove Featured Image', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used as the "Remove Featured Image" phrase for the post type.', 'crafto-addons' ),
										esc_html__( '(e.g. Remove Featured Image for This Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'use_featured_image',
										esc_html__( 'Use Featured Image', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Label for using an image as a Featured Image.', 'crafto-addons' ),
										esc_html__( '(e.g. Use as Featured Image for This Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'archives',
										esc_html__( 'Archives', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Post type archive label used in nav menus.', 'crafto-addons' ),
										esc_html__( '(e.g. Team Archives)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'insert_into_item',
										esc_html__( 'Insert into Item', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used as the "Insert into Post" or "Insert into Page" phrase for the post type.', 'crafto-addons' ),
										esc_html__( '(e.g. Insert into Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'uploaded_to_this_item',
										esc_html__( 'Uploaded to This Team', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used as the "Uploaded to This Post" or "Uploaded to This Page" phrase for the post type.', 'crafto-addons' ),
										esc_html__( '(e.g. Uploaded to This Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'filter_items_list',
										esc_html__( 'Filter Items List', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Screen reader text for the filter links heading on the post type listing screen.', 'crafto-addons' ),
										esc_html__( '(e.g. Filter Teams List)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'items_list_navigation',
										esc_html__( 'Items List Navigation', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Screen reader text for the pagination heading on the post type listing screen.', 'crafto-addons' ),
										esc_html__( '(e.g. Teams List Navigation)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'items_list',
										esc_html__( 'Items List', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Screen reader text for the items list heading on the post type listing screen.', 'crafto-addons' ),
										esc_html__( '(e.g. Teams List)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'attributes',
										esc_html__( 'Attributes', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used for the title of the post attributes meta box.', 'crafto-addons' ),
										esc_html__( '(e.g. Teams Attributes)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'name_admin_bar',
										esc_html__( '"New" Menu in Admin Bar', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the "New" section of the Admin Menu Bar. Default is the "Singular Name" label.', 'crafto-addons' ),
										esc_html__( '(e.g. Team)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'item_published',
										esc_html__( 'Item Published', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the editor notice after publishing a post. Default: "Post published." / "Page published."', 'crafto-addons' ),
										esc_html__( '(e.g. Team published.)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'item_published_privately',
										esc_html__( 'Item Published Privately', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the editor notice after publishing a private post. Default "Post published privately." / "Page published privately."', 'crafto-addons' ),
										esc_html__( '(e.g. Team published privately.)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'item_reverted_to_draft',
										esc_html__( 'Item Reverted to Draft', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the editor notice after reverting a post to draft. Default: "Post reverted to draft." / "Page reverted to draft."', 'crafto-addons' ),
										esc_html__( '(e.g. Team reverted to draft.)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'item_trashed',
										esc_html__( 'Item Trashed', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used when an item is moved to Trash. Default: "Post trashed." / "Page trashed."', 'crafto-addons' ),
										esc_html__( '(e.g. Team trashed.)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'item_scheduled',
										esc_html__( 'Item Scheduled', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the editor notice after scheduling a post to be published at a later date. Default: "Post scheduled." / "Page scheduled."', 'crafto-addons' ),
										esc_html__( '(e.g. Team scheduled.)', 'crafto-addons' )
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'item_updated',
										esc_html__( 'Item Updated', 'crafto-addons' ),
										'text',
										'crafto_labels',
										'',
										esc_html__( 'Used in the editor notice after updating a post. Default: "Post updated." / "Page updated."', 'crafto-addons' ),
										esc_html__( '(e.g. Team updated.)', 'crafto-addons' )
									);
									?>
								</div>
							</div>

							<div class="advance-settings-wrapper">
								<div class="main-title">
									<h3><?php echo esc_html__( 'Advance Settings', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-type-fields">
									<?php
									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'public',
										esc_html__( 'Public', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True in Custom Post Type UI) Determines whether posts of this type should be visible in the admin UI and publicly queryable.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'publicly_queryable',
										esc_html__( 'Publicly Queryable', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Determines whether queries for this post type can be performed on the front end as part of parse_request().', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'show_ui',
										esc_html__( 'Show UI', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Controls whether WordPress should generate a default user interface for managing this post type in the admin panel.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'show_in_nav_menus',
										esc_html__( 'Show in Nav Menus', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Determines whether this post type can be selected and added to WordPress navigation menus.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'delete_with_user',
										esc_html__( 'Delete with User', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'false',
										esc_html__( '(Default: False) Specifies whether posts of this type should be deleted when the associated user is removed.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'show_in_rest',
										esc_html__( 'Show in REST API', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Determines whether this post type data should be accessible via the WordPress REST API.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'has_archive',
										esc_html__( 'Has Archive', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Determines whether the post type will have an archive page accessible via a post type archive URL.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'exclude_from_search',
										esc_html__( 'Exclude From Search', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'false',
										esc_html__( '(Default: False) Determines whether posts of this post type should be excluded from front-end search results, including taxonomy term archives.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'hierarchical',
										esc_html__( 'Hierarchical', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'false',
										esc_html__( '(Default: False) Defines whether the post type can have parent-child relationships. At least one published content item is required to select a parent.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'can_export',
										esc_html__( 'Can Export', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'false',
										esc_html__( '(Default: False) Determines whether this post type can be exported.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'capability_type',
										esc_html__( 'Capability Type', 'crafto-addons' ),
										'text',
										'crafto_custom_post_type',
										'post',
										esc_html__( 'Specifies the post type used for checking read, edit, and delete capabilities. A second, comma-separated value can be used for the plural version.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'rewrite',
										esc_html__( 'Rewrite', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Controls whether WordPress should enable URL rewriting for this post type.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'rewrite_slug',
										esc_html__( 'Custom Rewrite Slug', 'crafto-addons' ),
										'text',
										'crafto_custom_post_type',
										'',
										esc_html__( '(Default: Post Type Slug) Defines a custom slug to be used instead of the default post type slug.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'rewrite_withfront',
										esc_html__( 'With Front', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Determines if the permalink structure should be prepended with the front base.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'query_var',
										esc_html__( 'Query Var', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Sets the query_var key for this post type, allowing it to be queried via a URL parameter.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'show_in_menu',
										esc_html__( 'Show in Menu', 'crafto-addons' ),
										'select',
										'crafto_custom_post_type',
										'true',
										esc_html__( '(Default: True) Controls whether the post type appears in the WordPress admin menu and defines where it should be displayed.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'menu_position',
										esc_html__( 'Menu Position', 'crafto-addons' ),
										'text',
										'crafto_custom_post_type',
										'',
										esc_html__( 'Range of menu_position 5-100. The position in the menu order the post type should appear. show_in_menu must be true.', 'crafto-addons' ),
										''
									);

									$this->crafto_ui(
										isset( $current ) ? $current : '',
										'menu_icon',
										esc_html__( 'Menu Icon', 'crafto-addons' ),
										'text',
										'crafto_custom_post_type',
										'',
										'<a href="https://developer.wordpress.org/resource/dashicons/" target="_blank" rel="noopener">Dashicon class name</a> to use for icon.',
										''
									);
									?>
									<div class="field-control">
										<div class="filed-checkbox">
											<h4><?php echo esc_html__( 'Supports', 'crafto-addons' ); ?></h4>
											<?php
											$support_array = array(
												'title'    => esc_html__( 'Title', 'crafto-addons' ),
												'editor'   => esc_html__( 'Editor', 'crafto-addons' ),
												'thumbnail' => esc_html__( 'Featured Image', 'crafto-addons' ),
												'excerpt'  => esc_html__( 'Excerpt', 'crafto-addons' ),
												'author'   => esc_html__( 'Author', 'crafto-addons' ),
												'page-attributes' => esc_html__( 'Page Attributes', 'crafto-addons' ),
												'trackbacks' => esc_html__( 'Trackbacks', 'crafto-addons' ),
												'custom-fields' => esc_html__( 'Custom Fields', 'crafto-addons' ),
												'comments' => esc_html__( 'Comments', 'crafto-addons' ),
												'revisions' => esc_html__( 'Revisions', 'crafto-addons' ),
												'post-formats' => esc_html__( 'Post Formats', 'crafto-addons' ),
											);

											$i = 1;
											foreach ( $support_array as $key => $value ) {
												$selected_checkbox = '';
												$select_checked = ( isset( $current ) && ! empty( $current['supports'] ) && is_array( $current['supports'] ) && in_array( $key, $current['supports'], true ) ) ? 'true' : 'false'; // phpcs:ignore.
												if ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) { // phpcs:ignore.
													$selected_checkbox = ! empty( $select_checked ) && 'true' === $select_checked ? 'checked="checked"' : '';
												} else {
													if ( 5 >= $i ) {
														$selected_checkbox = 'checked="checked"';
													}
												}
												?>
												<div>
													<input type="checkbox" id="<?php echo 'excerpt' === $key ? 'excerpts' : esc_attr( $key ); ?>" name="crafto_supports[]" value="<?php echo esc_attr( $key ); ?>" <?php echo esc_attr( $selected_checkbox ); ?>>
													<label for="<?php echo 'excerpt' === $key ? 'excerpts' : esc_attr( $key ); ?>"><?php echo esc_attr( $value ); ?></label>
												</div>
												<?php
												$i++;
											}
											?>
										</div>
									</div>
									<div class="field-control">
										<div class="filed-checkbox">
											<h4><?php echo esc_html__( 'Taxonomies', 'crafto-addons' ); ?></h4>
											<?php
											$args = [
												'public' => true,
											];

											$add_taxes = apply_filters( 'crafto_get_taxonomies_for_post_types', get_taxonomies( $args, 'objects' ), $args );
											unset( $add_taxes['nav_menu'], $add_taxes['post_format'] );

											foreach ( $add_taxes as $add_tax ) {
												$core_label = in_array( $add_tax->name, [ 'category', 'post_tag' ], true ) ? esc_html__( '( Default WP )', 'crafto-addons' ) : '';

												$select_checked = ( isset( $current ) && ! empty( $current['taxonomies'] ) && is_array( $current['taxonomies'] ) && in_array( $add_tax->name, $current['taxonomies'], true ) ) ? 'true' : 'false'; // phpcs:ignore.
												$selected_checkbox = ! empty( $select_checked ) && 'true' === $select_checked ? 'checked="checked"' : '';
												?>
												<div>
													<input type="checkbox" id="<?php echo esc_attr( $add_tax->name ); ?>" name="crafto_addon_taxes[]" value="<?php echo esc_attr( $add_tax->name ); ?>" <?php echo esc_attr( $selected_checkbox ); ?>>
													<label for="<?php echo esc_attr( $add_tax->name ); ?>"><?php echo esc_attr( $add_tax->label ) . ' ' . esc_attr( $core_label ); ?></label>
												</div>
												<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="registered-post-type-main-right">
							<div class="submit-btn-wrapper">
								<?php
								wp_nonce_field( 'crafto_addedit_post_type_nonce_action', 'crafto_addedit_post_type_nonce_field' );
								if ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) { // phpcs:ignore.
									?>
									<input type="submit" class="button-primary" name="crafto_submit" value="<?php echo esc_attr( apply_filters( 'crafto_post_type_submit_edit', esc_attr__( 'Update Post Type', 'crafto-addons' ) ) ); ?>">
									<input type="submit" class="button-secondary crafto-delete-top" name="crafto_delete" id="crafto_submit_delete" value="<?php echo esc_attr( apply_filters( 'crafto_post_type_submit_delete', esc_attr__( 'Delete Post Type', 'crafto-addons' ) ) ); ?>">
									<?php
								} else {
									?>
									<input type="submit" class="button-primary" name="crafto_submit" value="<?php echo esc_attr( apply_filters( 'crafto_post_type_submit_add', esc_attr__( 'Add Post Type', 'crafto-addons' ) ) ); ?>">
									<?php
								}
								if ( ! empty( $current ) ) {
									?>
									<input type="hidden" name="crafto_original" id="crafto_original" value="<?php echo esc_attr( $current['name'] ); ?>">
									<?php
								}
								?>
								<input type="hidden" name="crafto_type_status" id="crafto_type_status" value="<?php echo esc_attr( $post_type_status ); ?>">
							</div>
						</div>
					</div>
				</form>
				<?php
			}
		}

		/**
		 * Save and deletion of post type data.
		 */
		public function crafto_process_post_type() {
			if ( wp_doing_ajax() ) {
				return;
			}

			if ( ! is_admin() ) {
				return;
			}

			if ( ! empty( $_GET ) && isset( $_GET['page'] ) && 'crafto-theme-post-types' !== $_GET['page'] ) {
				return;
			}

			if ( ! empty( $_POST ) ) {
				$result = '';
				if ( isset( $_POST['crafto_submit'] ) ) {
					check_admin_referer( 'crafto_addedit_post_type_nonce_action', 'crafto_addedit_post_type_nonce_field' );
					$data   = $this->crafto_filtered_post_type_post_global();
					$result = $this->crafto_update_post_type( $data );
				} elseif ( isset( $_POST['crafto_delete'] ) ) {
					check_admin_referer( 'crafto_addedit_post_type_nonce_action', 'crafto_addedit_post_type_nonce_field' );

					$filtered_data = filter_input( INPUT_POST, 'crafto_custom_post_type', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );
					$result        = $this->crafto_delete_post_type( $filtered_data );
					add_filter( 'crafto_post_type_deleted', '__return_true' );
				}

				if ( $result ) {
					if ( is_callable( "crafto_{$result}_admin_notice" ) ) {
						add_action( 'admin_notices', "crafto_{$result}_admin_notice" );
					}
				}
				if ( ! empty( $_GET ) && isset( $_GET['crafto_post_type'] ) ) {
					if ( isset( $_POST['crafto_delete'] ) && ! in_array( $_GET['crafto_post_type'], $this->crafto_get_post_type_slugs(), true ) ) { // phpcs:ignore.
						wp_safe_redirect(
							add_query_arg(
								[
									'page' => 'crafto-theme-post-types',
								],
								admin_url( 'admin.php?page=crafto-theme-post-types' )
							)
						);
					}
				}
			}
		}

		/**
		 * Register our users' custom post types.
		 *
		 * @internal
		 */
		public function crafto_create_custom_post_types() {
			$cpts = get_option( 'crafto_register_post_types', [] );
			/**
			 * Filters an override array of post type data to be registered instead of our saved option.
			 *
			 * @param array $value Default override value.
			 */
			$cpts_override = apply_filters( 'crafto_post_types_override', [] );

			if ( empty( $cpts ) && empty( $cpts_override ) ) {
				return;
			}

			// Assume good intent, and we're also not wrecking the option so things are always reversable.
			if ( is_array( $cpts_override ) && ! empty( $cpts_override ) ) {
				$cpts = $cpts_override;
			}

			/**
			 * Fires before the start of the post type registrations.
			 *
			 * @param array $cpts Array of post types to register.
			 */
			do_action( 'crafto_pre_register_post_types', $cpts );

			if ( is_array( $cpts ) ) {
				foreach ( $cpts as $post_type ) {

					if ( ! is_string( $post_type['name'] ) ) {
						$post_type['name'] = (string) $post_type['name'];
					}
					/**
					 * Filters whether or not to skip registration of the current iterated post type.
					 *
					 * Dynamic part of the filter name is the chosen post type slug.
					 *
					 * @param bool  $value     Whether or not to skip the post type.
					 * @param array $post_type Current post type being registered.
					 */
					if ( (bool) apply_filters( "crafto_disable_{$post_type['name']}_cpt", false, $post_type ) ) {
						continue;
					}

					/**
					 * Filters whether or not to skip registration of the current iterated post type.
					 *
					 * @since 1.7.0
					 *
					 * @param bool  $value     Whether or not to skip the post type.
					 * @param array $post_type Current post type being registered.
					 */
					if ( (bool) apply_filters( 'crafto_disable_cpt', false, $post_type ) ) {
						continue;
					}

					$this->crafto_register_single_post_type( $post_type );
				}
			}

			/**
			 * Fires after the completion of the post type registrations.
			 *
			 * @since 1.3.0
			 *
			 * @param array $cpts Array of post types registered.
			 */
			do_action( 'crafto_post_register_post_types', $cpts );
		}

		/**
		 * Checks if we are trying to register an already registered post type slug.
		 *
		 * @param bool   $slug_exists    Whether or not the post type slug exists. Optional. Default false.
		 * @param string $post_type_slug The post type slug being saved. Optional. Default empty string.
		 * @param array  $post_types     Array of Crafto-registered post types. Optional.
		 * @return bool
		 */
		public function crafto_check_existing_post_type_slugs( $slug_exists = false, $post_type_slug = '', $post_types = [] ) {

			// If true, then we'll already have a conflict, let's not re-process.
			if ( true === $slug_exists ) {
				return $slug_exists;
			}

			if ( ! is_array( $post_types ) ) {
				return $slug_exists;
			}

			// Check if Crafto has already registered this slug.
			if ( array_key_exists( strtolower( $post_type_slug ), $post_types ) ) {
				return true;
			}

			// Check if we're registering a reserved post type slug.
			if ( in_array( $post_type_slug, $this->crafto_reserved_post_types(), true ) ) { // phpcs:ignore.
				return true;
			}

			// Check if other plugins have registered non-public this same slug.
			$public = get_post_types(
				[
					'_builtin' => false,
					'public'   => true,
				]
			);

			$private = get_post_types(
				[
					'_builtin' => false,
					'public'   => false,
				]
			);

			$registered_post_types = array_merge( $public, $private );
			if ( in_array( $post_type_slug, $registered_post_types, true ) ) { // phpcs:ignore.
				return true;
			}

			// If we're this far, it's false.
			return $slug_exists;
		}

		/**
		 * Handles slug_exist checks for cases of editing an existing post type.
		 *
		 * @param bool   $slug_exists    Current status for exist checks.
		 * @param string $post_type_slug Post type slug being processed.
		 * @param array  $post_types     Crafto post types.
		 * @return bool
		 */
		public function crafto_updated_post_type_slug_exists( $slug_exists, $post_type_slug = '', $post_types = [] ) {
			// phpcs:ignore
			if ( ( ! empty( $_POST['crafto_type_status'] ) && 'edit' === $_POST['crafto_type_status'] ) && ! in_array( $post_type_slug, $this->crafto_reserved_post_types(), true  ) && ( ! empty( $_POST['crafto_original'] ) && $post_type_slug === $_POST['crafto_original'] ) ) {
				$slug_exists = false;
			}

			return $slug_exists;
		}

		/* EXTRA FUNCTION */

		/**
		 * Fetch our Crafto post types option.
		 *
		 * @return mixed
		 */
		public function crafto_get_post_type_data() {
			return apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
		}

		/**
		 * Get the selected post type from the $_POST global.
		 *
		 * @param bool $post_type_selected Whether or not a post type was recently. Optional. Default false.
		 * @return bool|string $value False on no result, sanitized post type if set.
		 */
		public function crafto_get_current_post_type( $post_type_selected = false ) {

			$type = false;

			if ( ! empty( $_GET ) && isset( $_GET['crafto_post_type'] ) ) { // phpcs:ignore.
				$type = sanitize_text_field( wp_unslash( $_GET['crafto_post_type'] ) ); // phpcs:ignore.
			} else {
				$post_types = $this->crafto_get_post_type_data();
				if ( ! empty( $post_types ) ) {
					// Will return the first array key.
					$type = key( $post_types );
				}
			}

			/**
			 * Filters the current post type to edit.
			 *
			 * @since 1.3.0
			 *
			 * @param string $type Post type slug.
			 */
			return apply_filters( 'crafto_current_post_type', $type );
		}

		/**
		 * Return an array of names that users should not or can not use for post type names.
		 *
		 * @return array $value Array of names that are recommended against.
		 */
		public function crafto_reserved_post_types() {
			$reserved = [
				'action',
				'attachment',
				'author',
				'custom_css',
				'customize_changeset',
				'fields',
				'nav_menu_item',
				'oembed_cache',
				'order',
				'page',
				'post',
				'post_type',
				'revision',
				'sidebars',
				'theme',
				'themes',
				'user_request',
				'wp_block',
				'wp_global_styles',
				'wp_navigation',
				'wp_template',
				'wp_template_part',
			];

			/**
			 * Filters the list of reserved post types to check against.
			 *
			 * 3rd party plugin authors could use this to prevent duplicate post types.
			 *
			 * @since 1.0.0
			 *
			 * @param array $value Array of post type slugs to forbid.
			 */
			$custom_reserved = apply_filters( 'crafto_reserved_post_types', [] );

			if ( is_string( $custom_reserved ) && ! empty( $custom_reserved ) ) {
				$reserved[] = $custom_reserved;
			} elseif ( is_array( $custom_reserved ) && ! empty( $custom_reserved ) ) {
				foreach ( $custom_reserved as $slug ) {
					$reserved[] = $slug;
				}
			}

			return $reserved;
		}

		/**
		 * Return an array of all post type slugs from Custom Post Type UI.
		 *
		 * @return array Crafto post type slugs.
		 */
		public function crafto_get_post_type_slugs() {
			$post_types = get_option( 'crafto_register_post_types' );
			if ( ! empty( $post_types ) ) {
				return array_keys( $post_types );
			}
			return [];
		}

		/**
		 * Sanitize and filter the $_POST global and return a reconstructed array of the parts we need.
		 *
		 * Used for when managing post types.
		 *
		 * @return array
		 */
		public function crafto_filtered_post_type_post_global() {
			$filtered_data = [];

			$default_arrays = [
				'crafto_custom_post_type',
				'crafto_labels',
				'crafto_supports',
				'crafto_addon_taxes',
			];

			$third_party_items_arrays = apply_filters(
				'crafto_filtered_post_type_post_global_arrays',
				(array) [] // phpcs:ignore.
			);

			$items_arrays = array_merge( $default_arrays, $third_party_items_arrays );
			foreach ( $items_arrays as $item ) {
				$first_result = filter_input( INPUT_POST, $item, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );

				if ( $first_result ) {
					$filtered_data[ $item ] = $first_result;
				}
			}

			$default_strings = [
				'crafto_original',
				'crafto_type_status',
			];

			$third_party_items_strings = apply_filters(
				'crafto_filtered_post_type_post_global_strings',
				(array) [] // phpcs:ignore.
			);

			$items_string = array_merge( $default_strings, $third_party_items_strings );
			foreach ( $items_string as $item ) {
				$second_result = filter_input( INPUT_POST, $item, FILTER_SANITIZE_SPECIAL_CHARS );
				if ( $second_result ) {
					$filtered_data[ $item ] = $second_result;
				}
			}

			return $filtered_data;
		}

		/**
		 * Returns error message for if trying to register existing post type.
		 *
		 * @return string
		 */
		public function crafto_slug_matches_post_type() {
			return sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( 'Please choose a different post type name. %s is already registered.', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			);
		}

		/**
		 * Returns error message for if trying to register post type with matching page slug.
		 *
		 * @return string
		 */
		public function crafto_slug_matches_page() {
			$slug         = crafto_get_object_from_post_global();
			$matched_slug = get_page_by_path(
				crafto_get_object_from_post_global()
			);
			if ( $matched_slug instanceof WP_Post ) {
				$slug = sprintf(
					/* translators: Placeholders are just for HTML markup that doesn't need translated */
					'<a href="%s">%s</a>',
					get_edit_post_link( $matched_slug->ID ),
					crafto_get_object_from_post_global()
				);
			}

			return sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( 'Please choose a different post type name. %s matches an existing page slug, which can cause conflicts.', 'crafto-addons' ),
				$slug
			);
		}

		/**
		 * Add to or update our Crafto option with new data.
		 *
		 * @internal
		 *
		 * @param array $data Array of post type data to update. Optional.
		 * @return bool|string False on failure, string on success.
		 */
		public function crafto_update_post_type( $data = [] ) {

			// They need to provide a name.
			if ( empty( $data['crafto_custom_post_type']['name'] ) ) {
				return crafto_admin_notices( 'error', '', false, esc_html__( 'Please provide a post type name', 'crafto-addons' ) );
			}

			// Clean up $_POST data.
			foreach ( $data as $key => $value ) {
				if ( is_string( $value ) ) {
					$data[ $key ] = sanitize_text_field( $value );
				} else {
					array_map( 'sanitize_text_field', $data[ $key ] );
				}
			}

			// Check if they didn't put quotes in the name or rewrite slug.
			if ( false !== strpos( $data['crafto_custom_post_type']['name'], '\'' ) ||
				false !== strpos( $data['crafto_custom_post_type']['name'], '\"' ) ||
				false !== strpos( $data['crafto_custom_post_type']['rewrite_slug'], '\'' ) ||
				false !== strpos( $data['crafto_custom_post_type']['rewrite_slug'], '\"' ) ) {

				add_filter( 'crafto_custom_error_message', array( $this, 'crafto_slug_has_quotes' ) );
				return 'error';
			}

			$post_types = $this->crafto_get_post_type_data();

			/**
			 * Check if we already have a post type of that name.
			 *
			 * @param bool   $value Assume we have no conflict by default.
			 * @param string $value Post type slug being saved.
			 * @param array  $post_types Array of existing post types from Crafto.
			 */
			$slug_exists = apply_filters( 'crafto_post_type_slug_exists', false, $data['crafto_custom_post_type']['name'], $post_types );
			if ( true === $slug_exists ) {
				add_filter( 'crafto_custom_error_message', array( $this, 'crafto_slug_matches_post_type' ) );
				return 'error';
			}
			if ( 'new' === $data['crafto_type_status'] ) {
				$slug_as_page = $this->crafto_check_page_slugs( $data['crafto_custom_post_type']['name'] );
				if ( true === $slug_as_page ) {
					add_filter( 'crafto_custom_error_message', array( $this, 'crafto_slug_matches_page' ) );
					return 'error';
				}
			}

			if ( empty( $data['crafto_addon_taxes'] ) || ! is_array( $data['crafto_addon_taxes'] ) ) {
				$data['crafto_addon_taxes'] = [];
			}

			if ( empty( $data['crafto_supports'] ) || ! is_array( $data['crafto_supports'] ) ) {
				$data['crafto_supports'] = [];
			}

			if ( empty( $data['crafto_labels'] ) || ! is_array( $data['crafto_labels'] ) ) {
				$data['crafto_labels'] = [];
			}

			foreach ( $data['crafto_labels'] as $key => $label ) {
				if ( empty( $label ) ) {
					unset( $data['crafto_labels'][ $key ] );
				}

				$label = str_replace( '"', '', htmlspecialchars_decode( $label ) );
				$label = htmlspecialchars( $label, ENT_QUOTES );
				$label = trim( $label );
				if ( 'parent' === $key ) {
					$data['crafto_labels']['parent_item_colon'] = stripslashes_deep( $label );
				} else {
					$data['crafto_labels'][ $key ] = stripslashes_deep( $label );
				}
			}

			$menu_icon = trim( $data['crafto_custom_post_type']['menu_icon'] );
			if ( '' === $data['crafto_custom_post_type']['menu_icon'] ) {
				$menu_icon = null;
			}

			$label = ucwords( str_replace( '_', ' ', $data['crafto_custom_post_type']['name'] ) );
			if ( ! empty( $data['crafto_custom_post_type']['label'] ) ) {
				$label = str_replace( '"', '', htmlspecialchars_decode( $data['crafto_custom_post_type']['label'] ) );
				$label = htmlspecialchars( stripslashes( $label ), ENT_QUOTES );
			}

			$singular_label = ucwords( str_replace( '_', ' ', $data['crafto_custom_post_type']['name'] ) );
			if ( ! empty( $data['crafto_custom_post_type']['singular_label'] ) ) {
				$singular_label = str_replace( '"', '', htmlspecialchars_decode( $data['crafto_custom_post_type']['singular_label'] ) );
				$singular_label = htmlspecialchars( stripslashes( $singular_label ), ENT_QUOTES );
			}

			// global afterwards here.
			$description = wp_kses_post( stripslashes_deep( $_POST['crafto_custom_post_type']['description'] ) ); // phpcs:ignore.

			$name            = trim( $data['crafto_custom_post_type']['name'] );
			$capability_type = trim( $data['crafto_custom_post_type']['capability_type'] );
			$rewrite_slug    = trim( $data['crafto_custom_post_type']['rewrite_slug'] );
			$menu_position   = trim( $data['crafto_custom_post_type']['menu_position'] );

			$post_types[ $this->sanitize_post_type_slug( $data['crafto_custom_post_type']['name'] ) ] = [
				'name'                => $this->sanitize_post_type_slug( $name ),
				'label'               => $label,
				'singular_label'      => $singular_label,
				'description'         => $description,
				'public'              => self::crafto_display_boolean( $data['crafto_custom_post_type']['public'] ),
				'publicly_queryable'  => self::crafto_display_boolean( $data['crafto_custom_post_type']['publicly_queryable'] ),
				'show_ui'             => self::crafto_display_boolean( $data['crafto_custom_post_type']['show_ui'] ),
				'show_in_nav_menus'   => self::crafto_display_boolean( $data['crafto_custom_post_type']['show_in_nav_menus'] ),
				'delete_with_user'    => self::crafto_display_boolean( $data['crafto_custom_post_type']['delete_with_user'] ),
				'show_in_rest'        => self::crafto_display_boolean( $data['crafto_custom_post_type']['show_in_rest'] ),
				'has_archive'         => self::crafto_display_boolean( $data['crafto_custom_post_type']['has_archive'] ),
				'exclude_from_search' => self::crafto_display_boolean( $data['crafto_custom_post_type']['exclude_from_search'] ),
				'capability_type'     => $capability_type,
				'hierarchical'        => self::crafto_display_boolean( $data['crafto_custom_post_type']['hierarchical'] ),
				'can_export'          => self::crafto_display_boolean( $data['crafto_custom_post_type']['can_export'] ),
				'rewrite'             => self::crafto_display_boolean( $data['crafto_custom_post_type']['rewrite'] ),
				'rewrite_slug'        => $rewrite_slug,
				'rewrite_withfront'   => self::crafto_display_boolean( $data['crafto_custom_post_type']['rewrite_withfront'] ),
				'query_var'           => self::crafto_display_boolean( $data['crafto_custom_post_type']['query_var'] ),
				'menu_position'       => $menu_position,
				'show_in_menu'        => self::crafto_display_boolean( $data['crafto_custom_post_type']['show_in_menu'] ),
				'menu_icon'           => $menu_icon,
				'supports'            => $data['crafto_supports'],
				'taxonomies'          => $data['crafto_addon_taxes'],
				'labels'              => $data['crafto_labels'],
			];

			/**
			 * Filters final data to be saved right before saving post type data.
			 *
			 * @since 1.6.0
			 *
			 * @param array  $post_types Array of final post type data to save.
			 * @param string $name       Post type slug for post type being saved.
			 */
			$post_types = apply_filters( 'crafto_pre_save_post_type', $post_types, $name );

			/**
			 * Filters whether or not 3rd party options were saved successfully within post type add/update.
			 *
			 * @since 1.3.0
			 *
			 * @param bool  $value      Whether or not someone else saved successfully. Default false.
			 * @param array $post_types Array of our updated post types data.
			 * @param array $data       Array of submitted post type to update.
			 */
			if ( false === ( $success = apply_filters( 'crafto_post_type_update_save', false, $post_types, $data ) ) ) { // phpcs:ignore.
				$success = update_option( 'crafto_register_post_types', $post_types );
			}

			/**
			 * Fires after a post type is updated to our saved options.
			 *
			 * @since 1.0.0
			 *
			 * @param array $data Array of post type data that was updated.
			 */
			do_action( 'crafto_after_update_post_type', $data );

			// Used to help flush rewrite rules on init.
			set_transient( 'crafto_flush_rewrite_rules', 'true', 5 * 60 );

			if ( isset( $success ) && 'new' === $data['crafto_type_status'] ) {
				return 'add_success';
			}
			return 'update_success';
		}

		/**
		 * Helper function to register the actual post_type.
		 *
		 * @internal
		 *
		 * @param array $post_type Post type array to register. Optional.
		 * @return null Result of register_post_type.
		 */
		public function crafto_register_single_post_type( $post_type = [] ) {

			/**
			 * Filters the map_meta_cap value.
			 *
			 * @param bool   $value     True.
			 * @param string $name      Post type name being registered.
			 * @param array  $post_type All parameters for post type registration.
			 */

			$post_type_name_slug       = $this->sanitize_post_type_slug( $post_type['name'] );
			$post_type['map_meta_cap'] = apply_filters( 'crafto_map_meta_cap', true, $post_type_name_slug, $post_type );

			if ( empty( $post_type['supports'] ) ) {
				$post_type['supports'] = [];
			}

			/**
			 * Filters custom supports parameters for 3rd party plugins.
			 *
			 * @param array  $value     Empty array to add supports keys to.
			 * @param string $name      Post type slug being registered.
			 * @param array  $post_type Array of post type arguments to be registered.
			 */
			$user_supports_params = apply_filters( 'crafto_user_supports_params', [], $post_type_name_slug, $post_type );

			if ( is_array( $user_supports_params ) && ! empty( $user_supports_params ) ) {
				if ( is_array( $post_type['supports'] ) ) {
					$post_type['supports'] = array_merge( $post_type['supports'], $user_supports_params );
				} else {
					$post_type['supports'] = [ $user_supports_params ];
				}
			}

			if ( isset( $post_type['supports'] ) && is_array( $post_type['supports'] ) && in_array( 'none', $post_type['supports'], true ) ) {
				$post_type['supports'] = false;
			}

			$labels = [
				'name'          => $post_type['label'],
				'singular_name' => $post_type['singular_label'],
			];

			$preserved        = self::crafto_get_preserved_keys( 'post_types' );
			$preserved_labels = self::crafto_get_preserved_labels();
			foreach ( $post_type['labels'] as $key => $label ) {

				if ( ! empty( $label ) ) {
					if ( 'parent' === $key ) {
						$labels['parent_item_colon'] = $label;
					} else {
						$labels[ $key ] = $label;
					}
				} elseif ( empty( $label ) && in_array( $key, $preserved, true ) ) {
					$singular_or_plural = ( in_array( $key, array_keys( $preserved_labels['post_types']['plural'] ), true ) ) ? 'plural' : 'singular'; // phpcs:ignore.
					$label_plurality    = ( 'plural' === $singular_or_plural ) ? $post_type['label'] : $post_type['singular_label'];
					$labels[ $key ]     = sprintf( $preserved_labels['post_types'][ $singular_or_plural ][ $key ], $label_plurality );
				}
			}

			$has_archive = isset( $post_type['has_archive'] ) ? self::crafto_get_display_boolean( $post_type['has_archive'] ) : false;

			$show_in_menu = self::crafto_get_display_boolean( $post_type['show_in_menu'] );

			$rewrite = self::crafto_get_display_boolean( $post_type['rewrite'] );
			if ( false !== $rewrite ) {
				// Core converts to an empty array anyway, so safe to leave this instead of passing in boolean true.
				$rewrite         = [];
				$rewrite['slug'] = ! empty( $post_type['rewrite_slug'] ) ? $post_type['rewrite_slug'] : $post_type_name_slug;

				$rewrite['with_front'] = true; // Default value.
				if ( isset( $post_type['rewrite_withfront'] ) ) {
					$rewrite['with_front'] = 'false' === self::crafto_display_boolean( $post_type['rewrite_withfront'] ) ? false : true;
				}
			}

			$menu_icon            = ! empty( $post_type['menu_icon'] ) ? $post_type['menu_icon'] : null;
			$register_meta_box_cb = ! empty( $post_type['register_meta_box_cb'] ) ? $post_type['register_meta_box_cb'] : null;

			if ( in_array( $post_type['query_var'], [ 'true', 'false', '0', '1' ], true ) ) {
				$post_type['query_var'] = self::crafto_get_display_boolean( $post_type['query_var'] );
			}

			$menu_position = null;
			if ( ! empty( $post_type['menu_position'] ) ) {
				$menu_position = (int) $post_type['menu_position'];
			}

			$delete_with_user = null;
			if ( ! empty( $post_type['delete_with_user'] ) ) {
				$delete_with_user = self::crafto_get_display_boolean( $post_type['delete_with_user'] );
			}

			$capability_type = 'post';
			if ( ! empty( $post_type['capability_type'] ) ) {
				$capability_type = $post_type['capability_type'];
				if ( false !== strpos( $post_type['capability_type'], ',' ) ) {
					$caps = array_map( 'trim', explode( ',', $post_type['capability_type'] ) );
					if ( count( $caps ) > 2 ) {
						$caps = array_slice( $caps, 0, 2 );
					}
					$capability_type = $caps;
				}
			}

			$public = self::crafto_get_display_boolean( $post_type['public'] );
			if ( ! empty( $post_type['exclude_from_search'] ) ) {
				$exclude_from_search = self::crafto_get_display_boolean( $post_type['exclude_from_search'] );
			} else {
				$exclude_from_search = false === $public;
			}

			$queryable = ( ! empty( $post_type['publicly_queryable'] ) && isset( $post_type['publicly_queryable'] ) ) ? self::crafto_get_display_boolean( $post_type['publicly_queryable'] ) : $public;

			if ( empty( $post_type['show_in_nav_menus'] ) ) {
				$post_type['show_in_nav_menus'] = $public;
			}

			if ( empty( $post_type['show_in_rest'] ) ) {
				$post_type['show_in_rest'] = false;
			}

			$can_export = null;
			if ( ! empty( $post_type['can_export'] ) ) {
				$can_export = self::crafto_get_display_boolean( $post_type['can_export'] );
			}

			$args = [
				'labels'               => $labels,
				'description'          => $post_type['description'],
				'public'               => self::crafto_get_display_boolean( $post_type['public'] ),
				'publicly_queryable'   => $queryable,
				'show_ui'              => self::crafto_get_display_boolean( $post_type['show_ui'] ),
				'show_in_nav_menus'    => self::crafto_get_display_boolean( $post_type['show_in_nav_menus'] ),
				'has_archive'          => $has_archive,
				'show_in_menu'         => $show_in_menu,
				'delete_with_user'     => $delete_with_user,
				'show_in_rest'         => self::crafto_get_display_boolean( $post_type['show_in_rest'] ),
				'exclude_from_search'  => $exclude_from_search,
				'capability_type'      => $capability_type,
				'map_meta_cap'         => $post_type['map_meta_cap'],
				'hierarchical'         => self::crafto_get_display_boolean( $post_type['hierarchical'] ),
				'can_export'           => $can_export,
				'rewrite'              => $rewrite,
				'menu_position'        => $menu_position,
				'menu_icon'            => $menu_icon,
				'register_meta_box_cb' => $register_meta_box_cb,
				'query_var'            => $post_type['query_var'],
				'supports'             => $post_type['supports'],
				'taxonomies'           => $post_type['taxonomies'],
			];

			/**
			 * Filters the arguments used for a post type right before registering.
			 *
			 * @param array  $args      Array of arguments to use for registering post type.
			 * @param string $value     Post type slug to be registered.
			 * @param array  $post_type Original passed in values for post type.
			 */
			$args = apply_filters( 'crafto_pre_register_post_type', $args, $post_type_name_slug, $post_type );

			return register_post_type( $post_type_name_slug, $args );
		}

		/**
		 * Delete our custom post type from the array of post types.
		 *
		 * @param array $data $_POST values. Optional.
		 * @return bool|string False on failure, string on success.
		 */
		public function crafto_delete_post_type( $data = [] ) {

			// Pass double data into last function despite matching values.
			if ( is_string( $data ) && $this->crafto_get_post_type_exists( $data, $data ) ) {
				$slug         = $data;
				$data         = [];
				$data['name'] = $slug;
			}

			if ( empty( $data['name'] ) ) {
				return crafto_admin_notices( 'error', '', false, esc_html__( 'Please provide a post type to delete', 'crafto-addons' ) );
			}

			/**
			 * Fires before a post type is deleted from our saved options.
			 *
			 * @param array $data Array of post type data we are deleting.
			 */
			do_action( 'crafto_before_delete_post_type', $data );

			$post_types = $this->crafto_get_post_type_data();

			if ( array_key_exists( strtolower( $data['name'] ), $post_types ) ) {

				unset( $post_types[ $data['name'] ] );

				/**
				 * Filters whether or not 3rd party options were saved successfully within post type deletion.
				 *
				 * @param bool  $value      Whether or not someone else saved successfully. Default false.
				 * @param array $post_types Array of our updated post types data.
				 * @param array $data       Array of submitted post type to update.
				 */
				if ( false === ( $success = apply_filters( 'crafto_post_type_delete_type', false, $post_types, $data ) ) ) { // phpcs:ignore.
					$success = update_option( 'crafto_register_post_types', $post_types );
				}
			}

			/**
			 * Fires after a post type is deleted from our saved options.
			 *
			 * @param array $data Array of post type data that was deleted.
			 */
			do_action( 'crafto_after_delete_post_type', $data );

			// Used to help flush rewrite rules on init.
			set_transient( 'crafto_flush_rewrite_rules', 'true', 5 * 60 );

			if ( isset( $success ) ) {
				return 'delete_success';
			}
			return 'delete_fail';
		}

		/**
		 * Checks if a post type is already registered.
		 *
		 * @param string       $slug Post type slug to check. Optional. Default empty string.
		 * @param array|string $data Post type data being utilized. Optional.
		 * @return mixed
		 */
		public function crafto_get_post_type_exists( $slug = '', $data = [] ) {

			/**
			 * Filters the boolean value for if a post type exists for 3rd parties.
			 *
			 * @param string       $slug Post type slug to check.
			 * @param array|string $data Post type data being utilized.
			 */
			return apply_filters( 'crafto_get_post_type_exists', post_type_exists( $slug ), $data );
		}

		/**
		 * Return html of post types ui.
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
		public static function crafto_ui( $current, $key, $label, $type, $group, $default_select, $description, $placeholder ) {
			$ui_html = '';

			switch ( $type ) {
				case 'select':
					$selected = isset( $current ) && ! empty( $current ) ? self::crafto_display_boolean( $current[ $key ] ) : $default_select; // Default Set true.
					$select   = 'true' === $selected ? '1' : '0';

					$ui_html .= '<div class="field-control">';
					$ui_html .= '<div class="left-part"><label for="' . esc_attr( $key ) . '"> ' . $label . ' </label>'; // phpcs:ignore.
					$ui_html .= '<p class="crafto-field-description description"> ' . $description . ' </p></div>'; // phpcs:ignore.
					$ui_html .= '<div class="right-part"><select id="' . esc_attr( $key ) . '" name="' . esc_attr( $group ) . '[' . esc_attr( $key ) . ']">';
					$ui_html .= '<option value="0"' . ( '0' === $select ? ' selected="selected"' : '' ) . '>' . esc_html__( 'False', 'crafto-addons' ) . '</option>';
					$ui_html .= '<option value="1"' . ( '1' === $select ? ' selected="selected"' : '' ) . '>' . esc_html__( 'True', 'crafto-addons' ) . '</option>';
					$ui_html .= '</select></div>';
					$ui_html .= '</div>';
					break;
				case 'text':
					$required_aria  = 'false';
					$required_field = '';
					$disabled       = '';
					$tabindex       = '';
					if ( 'crafto_custom_post_type' === $group || 'crafto_labels' === $group ) {
						if ( 'crafto_custom_post_type' === $group ) {
							$text_box_value = isset( $current[ $key ] ) ? esc_attr( $current[ $key ] ) : $default_select;
							if ( 'singular_label' === $key || 'label' === $key || 'name' === $key ) {
								$required_aria  = 'true';
								$required_field = 'required';
							}
							if ( ! empty( $text_box_value ) && 'name' === $key ) {
								$disabled = 'disabled';
								$tabindex = ' tabindex="-1"';
							}
						} else {
							$text_box_value = isset( $current['labels'][ $key ] ) ? esc_attr( $current['labels'][ $key ] ) : $default_select;
						}
					}
					if ( 'crafto_custom_tax' === $group || 'crafto_tax_labels' === $group ) {
						if ( 'crafto_custom_tax' === $group ) {
							$text_box_value = isset( $current[ $key ] ) ? esc_attr( $current[ $key ] ) : $default_select;
							if ( 'singular_label' === $key || 'label' === $key || 'name' === $key ) {
								$required_aria  = 'true';
								$required_field = 'required';
							}
							if ( ! empty( $text_box_value ) && 'name' === $key ) {
								$disabled = 'disabled';
								$tabindex = ' tabindex="-1"';
							}
						} else {
							$text_box_value = isset( $current['labels'][ $key ] ) ? esc_attr( $current['labels'][ $key ] ) : $default_select;
						}
					}

					$placeholder = ! empty( $placeholder ) ? $placeholder : '';

					$ui_html .= '<div class="field-control">';
					$ui_html .= '<div class="left-part"><label for="' . esc_attr( $key ) . '"> ' . $label . ' </label>';
					$ui_html .= '<p class="crafto-field-description description"> ' . $description . ' </p></div>'; // phpcs:ignore.
					$ui_html .= '<div class="right-part"><input type="text" id="' . esc_attr( $key ) . '" name="' . esc_attr( $group ) . '[' . esc_attr( $key ) . ']" value="' . esc_html( $text_box_value ) . '" aria-required="' . esc_attr( $required_aria ) . '" placeholder="' . esc_attr( $placeholder ) . '" class="' . esc_attr( $disabled ) . '" ' . $tabindex . $required_field . ' >';
					$ui_html .= '</div></div>';
					break;
				default:
					$ui_html .= esc_html__( 'No tag found', 'crafto-addons' );
			}

			echo sprintf( '%1$s', $ui_html ); // phpcs:ignore
		}

		/**
		 * Return string versions of boolean values.
		 *
		 * @param string $bool_text String boolean value.
		 * @return string standardized boolean text.
		 */
		public static function crafto_display_boolean( $bool_text ) {
			$bool_text = (string) $bool_text;
			if ( empty( $bool_text ) || '0' === $bool_text || 'false' === $bool_text ) {
				return 'false';
			}

			return 'true';
		}

		/**
		 * Return boolean status depending on passed in value.
		 *
		 * @param mixed $bool_text text to compare to typical boolean values.
		 * @return bool Which bool value the passed in value was.
		 */
		public static function crafto_get_display_boolean( $bool_text ) {
			$bool_text = (string) $bool_text;
			if ( empty( $bool_text ) || '0' === $bool_text || 'false' === $bool_text ) {
				return false;
			}

			return true;
		}

		/**
		 * Return array of keys needing preserved.
		 *
		 * @param string $type Type to return. Either 'post_types' or 'taxonomies'. Optional. Default empty string.
		 * @return array Array of keys needing preservered for the requested type.
		 */
		public static function crafto_get_preserved_keys( $type = '' ) {
			$preserved_labels = [
				'post_types' => [
					'add_new_item',
					'edit_item',
					'new_item',
					'view_item',
					'view_items',
					'all_items',
					'search_items',
					'not_found',
					'not_found_in_trash',
				],
				'taxonomies' => [
					'search_items',
					'popular_items',
					'all_items',
					'parent_item',
					'parent_item_colon',
					'edit_item',
					'update_item',
					'add_new_item',
					'new_item_name',
					'separate_items_with_commas',
					'add_or_remove_items',
					'choose_from_most_used',
				],
			];
			return ! empty( $type ) ? $preserved_labels[ $type ] : [];
		}

		/**
		 * Returns an array of translated labels, ready for use with sprintf().
		 *
		 * Replacement for crafto_get_preserved_label for the sake of performance.
		 *
		 * @return array
		 */
		public static function crafto_get_preserved_labels() {
			return [
				'post_types' => [
					'singular' => [
						/* translators: %s is the `Add` label of custom post type */
						'add_new_item' => esc_html__( 'Add New %s', 'crafto-addons' ),
						/* translators: %s is the `Edit` label of custom post type */
						'edit_item'    => esc_html__( 'Edit %s', 'crafto-addons' ),
						/* translators: %s is the `New` label of custom post type */
						'new_item'     => esc_html__( 'New %s', 'crafto-addons' ),
						/* translators: %s is the `View` label of custom post type */
						'view_item'    => esc_html__( 'View %s', 'crafto-addons' ),
					],
					'plural'   => [
						/* translators: %s is the `View` label of custom post type */
						'view_items'         => esc_html__( 'View %s', 'crafto-addons' ),
						/* translators: %s is the `All` label of custom post type */
						'all_items'          => esc_html__( 'All %s', 'crafto-addons' ),
						/* translators: %s is the `Search` label of custom post type */
						'search_items'       => esc_html__( 'Search %s', 'crafto-addons' ),
						/* translators: %s is the `No found` label of custom post type */
						'not_found'          => esc_html__( 'No %s found.', 'crafto-addons' ),
						/* translators: %s is the `No found in trash` label of custom post type */
						'not_found_in_trash' => esc_html__( 'No %s found in trash.', 'crafto-addons' ),
					],
				],
				'taxonomies' => [
					'singular' => [
						/* translators: %s is the `Parent` label of custom post type */
						'parent_item'       => esc_html__( 'Parent %s', 'crafto-addons' ),
						/* translators: %s is the `Parent Colon` label of custom post type */
						'parent_item_colon' => esc_html__( 'Parent %s:', 'crafto-addons' ),
						/* translators: %s is the `Edit` label of custom post type */
						'edit_item'         => esc_html__( 'Edit %s', 'crafto-addons' ),
						/* translators: %s is the `Update` label of custom post type */
						'update_item'       => esc_html__( 'Update %s', 'crafto-addons' ),
						/* translators: %s is the `Add new` label of custom post type */
						'add_new_item'      => esc_html__( 'Add new %s', 'crafto-addons' ),
						/* translators: %s is the `New` label of custom post type */
						'new_item_name'     => esc_html__( 'New %s name', 'crafto-addons' ),
					],
					'plural'   => [
						/* translators: %s is the `Search` label of custom post type */
						'search_items'               => esc_html__( 'Search %s', 'crafto-addons' ),
						/* translators: %s is the `Popular` label of custom post type */
						'popular_items'              => esc_html__( 'Popular %s', 'crafto-addons' ),
						/* translators: %s is the `All` label of custom post type */
						'all_items'                  => esc_html__( 'All %s', 'crafto-addons' ),
						/* translators: %s is the `Separator` label of custom post type */
						'separate_items_with_commas' => esc_html__( 'Separate %s with commas', 'crafto-addons' ),
						/* translators: %s is the `Add or Remove` label of custom post type */
						'add_or_remove_items'        => esc_html__( 'Add or remove %s', 'crafto-addons' ),
						/* translators: %s is the `Most Used` label of custom post type */
						'choose_from_most_used'      => esc_html__( 'Choose from the most used %s', 'crafto-addons' ),
					],
				],
			];
		}

		/**
		 * Checks if the slug matches any existing page slug.
		 *
		 * @param string $post_type_slug The post type slug being saved. Optional. Default empty string.
		 * @return bool Whether or not the slug exists.
		 */
		public function crafto_check_page_slugs( $post_type_slug = '' ) {
			$page = get_page_by_path( $post_type_slug );

			if ( null === $page ) {
				return false;
			}

			if ( is_object( $page ) && ( true === $page instanceof WP_Post ) ) {
				return true;
			}

			return false;
		}

		/**
		 * Checks if the slug matches any existing page slug.
		 *
		 * @param string $post_type_name The post type slug being saved. Optional. Default empty string.
		 */
		public function sanitize_post_type_slug( $post_type_name ) {

			$slug = strtolower( $post_type_name );

			$slug = str_replace( ' ', '_', $slug );

			$slug = preg_replace( '/[^a-z0-9_\-]/', '', $slug );

			$slug = substr( $slug, 0, 20 );

			return $slug;
		}

		/* EXTRA FUNCTION */

		/**
		 * Conditionally flushes rewrite rules if we have reason to.
		 */
		public function crafto_flush_rewrite_rules() {

			if ( wp_doing_ajax() ) {
				return;
			}

			$flush_it = get_transient( 'crafto_flush_rewrite_rules' );
			if ( 'true' === $flush_it ) {
				flush_rewrite_rules( false );
				// So we only run this once.
				delete_transient( 'crafto_flush_rewrite_rules' );
			}
		}

		/**
		 * Custom Post Type Delete Handler.
		 */
		public function crafto_delete_custom_post_type_callback() {
			$rediect_url    = $_POST['redirect_url']; // phpcs:ignore
			$post_type_slug = $_POST['posttype_slug']; // phpcs:ignore

			$success = '';
			if ( '' !== $rediect_url && '' !== $post_type_slug ) {
				$post_types = $this->crafto_get_post_type_data();

				if ( array_key_exists( strtolower( $post_type_slug ), $post_types ) ) {

					unset( $post_types[ $post_type_slug ] );

					$success = update_option( 'crafto_register_post_types', $post_types );
				}
			}

			if ( $success ) {
				wp_send_json_success(
					array(
						'message' => esc_html__( 'success', 'crafto-addons' ),
					)
				);
			} else {
				wp_send_json_error(
					array(
						'message' => esc_html__( 'error', 'crafto-addons' ),
					)
				);
			}
		}
	}

	new Crafto_Register_Custom_Post_Type();
}
