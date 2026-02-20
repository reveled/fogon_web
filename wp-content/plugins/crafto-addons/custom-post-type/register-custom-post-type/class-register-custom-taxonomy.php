<?php
/**
 * Register custom taxonomy
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CraftoAddons\Classes\Crafto_Register_Custom_Taxonomy' ) ) {
	/**
	 * Define Crafto_Register_Custom_Taxonomy class
	 */
	class Crafto_Register_Custom_Taxonomy {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'crafto_register_taxonomy_menu' ), 10 );
			add_action( 'init', array( $this, 'crafto_process_taxonomy' ), 20 );
			add_action( 'init', array( $this, 'crafto_create_custom_taxonomies' ), 30 );
			add_filter( 'crafto_taxonomy_slug_exists', array( $this, 'crafto_check_existing_taxonomy_slugs' ), 10, 3 );
			add_filter( 'crafto_taxonomy_slug_exists', array( $this, 'crafto_updated_taxonomy_slug_exists' ), 11, 3 );
			add_action( 'wp_ajax_delete_custom_taxonomies', array( $this, 'crafto_delete_custom_taxonomies_callback' ) );
		}

		/**
		 * Add Menu Custom Post Taxonomy.
		 */
		public function crafto_register_taxonomy_menu() {
			add_submenu_page(
				'crafto-theme-setup',
				esc_html__( 'Taxonomies', 'crafto-addons' ),
				esc_html__( 'Taxonomies', 'crafto-addons' ),
				'manage_options',
				'crafto-theme-taxonomies',
				array( $this, 'crafto_theme_taxonomies_callback' ),
				5
			);
		}

		/**
		 * Add Taxonomies Menu.
		 */
		public function crafto_theme_taxonomies_callback() {
			/* Check current user permission */
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'crafto-addons' ) );
			}

			$taxonomies_page   = isset ( $_GET['page'] ) && ! empty( $_GET['page'] ) ? $_GET['page'] : '';  // phpcs:ignore
			$taxonomies_action = isset ( $_GET['action'] ) && ! empty( $_GET['action'] ) ? $_GET['action'] : ''; // phpcs:ignore
			$taxonomies_status = 'new';

			if ( 'crafto-theme-taxonomies' === $taxonomies_page && empty( $taxonomies_action ) ) {

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

				$taxonomies_table_heads = [
					esc_html__( 'Taxonomies', 'crafto-addons' ),
					esc_html__( 'Taxonomies Slug', 'crafto-addons' ),
					esc_html__( 'Post Types', 'crafto-addons' ),
					esc_html__( 'Action', 'crafto-addons' ),
				];

				$taxonomies = $this->crafto_get_taxonomy_data();
				?>
				<div class="wrap crafto-taxonomies-listings">
					<h1 class="wp-heading-inline"><?php echo esc_html__( 'Custom Taxonomies List', 'crafto-addons' ); ?></h1>
					<?php
					if ( $crafto_is_theme_license_active ) {
						?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=crafto-theme-taxonomies&action=add' ) ); ?>" class="page-title-action"><?php echo esc_html__( 'Add New Taxonomy', 'crafto-addons' ); ?></a>
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
						<input type="text" id="crafto-posttype-search" placeholder="<?php esc_attr_e( 'Search Taxonomies...', 'crafto-addons' ); ?>" />
					</div>
					<div class="crafto-posttype-list-table">
						<div class="crafto-posttype-list-table-heading">
							<div class="crafto-list-table-heading taxonomie-col-4">
							<?php
							foreach ( $taxonomies_table_heads as $head ) {
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
						if ( ! empty( $taxonomies ) ) {
							?>
							<div class="crafto-posttype-list-table-items">
								<?php
								foreach ( $taxonomies as $taxonomy => $taxonomy_settings ) {
									$strings      = [];
									$object_types = [];
									foreach ( $taxonomy_settings as $settings_key => $settings_value ) {
										if ( 'labels' === $settings_key ) {
											continue;
										}

										if ( is_string( $settings_value ) ) {
											$strings[ $settings_key ] = $settings_value;
										} else {
											if ( 'object_types' === $settings_key ) {
												$object_types[ $settings_key ] = $settings_value;

												// In case they are not associated from the post type settings.
												if ( empty( $object_types['object_types'] ) ) {
													$types                        = get_taxonomy( $taxonomy );
													$object_types['object_types'] = $types->object_type;
												}
											}
										}
									}

									$edit_path           = 'admin.php?page=crafto-theme-taxonomies&action=edit&crafto_taxonomies=' . $taxonomy;
									$delete_path         = 'admin.php?page=crafto-theme-taxonomies&action=delete&crafto_taxonomies=' . $taxonomy;
									$taxonomy_link_url   = is_network_admin() ? network_admin_url( $edit_path ) : admin_url( $edit_path );
									$delete_taxonomy_url = is_network_admin() ? network_admin_url( $delete_path ) : admin_url( $delete_path );
									?>
									<div class="crafto-list-table-items">
										<div class="crafto-list-table-item name"><a href="<?php echo $taxonomy_link_url; // phpcs:ignore ?>"><?php echo esc_html( $taxonomy_settings['label'] ); ?></a></div>
										<div class="crafto-list-table-item slug"><?php echo esc_html( $taxonomy ); ?></div>
										<div class="crafto-list-table-item postypeslug">
											<?php
											$post_type_list = [];
											if ( ! empty( $object_types['object_types'] ) ) {
												foreach ( $object_types['object_types'] as $type ) {
													$obj = get_post_type_object( $type );
													if ( ! empty( $obj ) ) {
														$post_type_list[] = $obj->labels->singular_name;
													}
												}
											}
											if ( ! empty( $post_type_list ) ) {
												echo implode( ', ', $post_type_list ); // phpcs:ignore
											}
											?>
										</div>
										<div class="crafto-list-table-item actions">
											<div>
												<?php
												printf(
													'<a href="%s">%s</a>',
													esc_attr( $taxonomy_link_url ),
													sprintf(
														/* translators: %s: Post type slug */
														esc_html__( 'Edit', 'crafto-addons' ),
													),
												);
												?>
												<span>&nbsp;|&nbsp;</span>
												<?php
												printf(
													'<a class="delete-taxonomies" data-taxonomies="' . esc_attr( $taxonomy ) . '" href="%s">%s</a>',
													esc_attr( $delete_taxonomy_url ),
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
									<span><?php echo esc_html__( 'You haven\'t registered any taxonomies yet.', 'crafto-addons' ); ?></span>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}

			/* ADD FORM FOR Taxonomies */
			$taxonomy_deleted = apply_filters( 'crafto_taxonomy_deleted', false );
			if ( 'crafto-theme-taxonomies' === $taxonomies_page && ! empty( $taxonomies_action ) ) {
				if ( 'edit' === $taxonomies_action ) {

					$taxonomies_status = 'edit';

					$taxonomies = $this->crafto_get_taxonomy_data();

					if ( isset ( $_GET['crafto_taxonomies'] ) && ! empty( $_GET['crafto_taxonomies'] ) ) { // phpcs:ignore.
						$taxonomy_deleted = $_GET['crafto_taxonomies']; // phpcs:ignore.
					}

					$selected_taxonomy = $this->crafto_get_current_taxonomy( $taxonomy_deleted );

					if ( $selected_taxonomy && array_key_exists( $selected_taxonomy, $taxonomies ) ) {
						$current = $taxonomies[ $selected_taxonomy ];
					}
				}
				?>

				<div class="wrap crafto-taxonomies-listings">
					<?php
					if ( 'edit' === $taxonomies_action ) {
						?>
						<h1 class="wp-heading-inline"><?php echo esc_html__( 'Edit Taxonomy', 'crafto-addons' ); ?></h1>
						<?php
					} else {
						?>
						<h1 class="wp-heading-inline"><?php echo esc_html__( 'Add New Taxonomy', 'crafto-addons' ); ?></h1>
						<?php
					}
					?>
				</div>

				<form class="taxonomiesui" method="post" action="">
					<div class="registered-post-type-main-wrapper">
						<div class="registered-post-type-main-left">
							<div class="general-settings-wrapper">
								<div class="main-title active">
									<h3><?php echo esc_html__( 'General Settings', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-type-fields">
									<?php
									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'name',
										sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Taxonomy Slug', 'crafto-addons' ) ),
										'text',
										'crafto_custom_tax',
										'',
										esc_html__( 'The unique identifier used for taxonomy-related queries and content retrieval.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'label',
										sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Plural Label', 'crafto-addons' ) ),
										'text',
										'crafto_custom_tax',
										'',
										esc_html__( 'Used for the taxonomy admin menu item.', 'crafto-addons' ),
										esc_html__( '(e.g. Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'singular_label',
										sprintf( '%1$s<span class="required">*</span>', esc_html__( 'Singular Label', 'crafto-addons' ) ),
										'text',
										'crafto_custom_tax',
										'',
										esc_html__( 'Used when a singular label is needed.', 'crafto-addons' ),
										esc_html__( '(e.g. Department)', 'crafto-addons' )
									);

									?>
									<div class="field-control">
										<div class="filed-checkbox">
											<h4><?php echo esc_html__( 'Attach Custom Post Type', 'crafto-addons' ); ?><span class="required">*</span></h4>
											<?php
											$post_types = crafto_get_post_types();
											if ( ! empty( $post_types ) ) {
												foreach ( $post_types as $post_type_slug => $post_type_label ) {
													$select_checked = ( isset( $current ) && ! empty( $current['object_types'] ) && is_array( $current['object_types'] ) && in_array( $post_type_slug, $current['object_types'] ) ) ? 'true' : 'false'; // phpcs:ignore.
													$selected_checkbox = ! empty( $select_checked ) && 'true' === $select_checked ? 'checked="checked"' : '';
													?>
													<div>
														<input type="checkbox" id="<?php echo esc_attr( $post_type_slug ); ?>" name="crafto_post_types[]" value="<?php echo esc_attr( $post_type_slug ); ?>" <?php echo esc_attr( $selected_checkbox ); ?>>
														<label for="<?php echo esc_attr( $post_type_slug ); ?>"><?php echo esc_attr( $post_type_label ); ?></label>
													</div>
													<?php
												}
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="additional-settings-wrapper">
								<div class="main-title">
									<h3><?php echo esc_html__( 'Additional Label', 'crafto-addons' ); ?></h3>
								</div>
								<div class="registered-post-type-fields">
									<?php
									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'description',
										esc_html__( 'Description', 'crafto-addons' ),
										'text',
										'crafto_custom_tax',
										'',
										esc_html__( 'Describe what your taxonomy is used for.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'all_items',
										esc_html__( 'All Items', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Used as tab text when showing all terms for hierarchical taxonomy while editing post.', 'crafto-addons' ),
										esc_html__( '(e.g. All Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'edit_item',
										esc_html__( 'Edit Item', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Used at the top of the term editor screen for an existing taxonomy term.', 'crafto-addons' ),
										esc_html__( '(e.g. Edit Department)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'view_item',
										esc_html__( 'View Item', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Used in the admin bar when viewing editor screen for an existing taxonomy term.', 'crafto-addons' ),
										esc_html__( '(e.g. View Department)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'update_item',
										esc_html__( 'Update Item Name', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Custom taxonomy label used in the admin menu for displaying taxonomies.', 'crafto-addons' ),
										esc_html__( '(e.g. Update Department Name)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'add_new_item',
										esc_html__( 'Add New Item', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Used at the top of the term editor screen and button text for a new taxonomy term.', 'crafto-addons' ),
										esc_html__( '(e.g. Add New Department)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'new_item_name',
										esc_html__( 'New Item Name', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Custom taxonomy label used in the admin menu for displaying taxonomies.', 'crafto-addons' ),
										esc_html__( '(e.g. New Department Name)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'parent_item',
										esc_html__( 'Parent Item', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Custom taxonomy label used in the admin menu for displaying taxonomies.', 'crafto-addons' ),
										esc_html__( '(e.g. Parent Department)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'parent_item_colon',
										esc_html__( 'Parent Item Colon', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Custom taxonomy label used in the admin menu for displaying hierarchical taxonomies, typically followed by a colon.', 'crafto-addons' ),
										esc_html__( '(e.g. Parent Item:)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'search_items',
										esc_html__( 'Search Items', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										'',
										esc_html__( 'Custom taxonomy label used in the admin menu for searching taxonomy terms.', 'crafto-addons' ),
										esc_html__( '(e.g. Search Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'popular_items',
										esc_html__( 'Popular Items', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Custom taxonomy label used in the admin menu for displaying popular taxonomy terms.', 'crafto-addons' ),
										esc_html__( '(e.g. Popular Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'separate_items_with_commas',
										esc_html__( 'Separate Items with Commas', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Custom taxonomy label used in the admin menu for entering multiple taxonomy terms separated by commas.', 'crafto-addons' ),
										esc_html__( '(e.g. Separate Departments with Commas)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'add_or_remove_items',
										esc_html__( 'Add or Remove Items', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Custom taxonomy label used in the admin menu for adding or removing taxonomy terms.', 'crafto-addons' ),
										esc_html__( '(e.g. Add or Remove Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'choose_from_most_used',
										esc_html__( 'Choose From Most Used', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'The text displayed via clicking ‘Choose from the most used items’ in the taxonomy meta box when no items are available.', 'crafto-addons' ),
										esc_html__( '(e.g. Choose from the most used Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'not_found',
										esc_html__( 'Not found', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Used when indicating that there are no terms in the given taxonomy within the meta box and taxonomy list table.', 'crafto-addons' ),
										esc_html__( '(e.g. No Departments Found)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'no_terms',
										esc_html__( 'No terms', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Used when indicating that there are no terms in the given taxonomy associated with an object.', 'crafto-addons' ),
										esc_html__( '(e.g. No Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'items_list_navigation',
										esc_html__( 'Items List Navigation', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Screen reader text for the pagination heading on the term listing screen.', 'crafto-addons' ),
										esc_html__( '(e.g. Departments List Navigation)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'items_list',
										esc_html__( 'Items List', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Screen reader text for the items list heading on the term listing screen.', 'crafto-addons' ),
										esc_html__( '(e.g. Departments List)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'back_to_items',
										esc_html__( 'Back to Items', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'The text displayed after a term has been updated for a link back to main index.', 'crafto-addons' ),
										esc_html__( '(e.g. &larr; Back to Departments)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'name_field_description',
										esc_html__( 'Term Name Field Description', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Description for the Name field on Edit Tags screen.', 'crafto-addons' ),
										esc_html__( '(e.g. "The name is how it appears on your site.")', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'parent_field_description',
										esc_html__( 'Term Parent Field Description', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Description for the Parent field on Edit Tags screen.', 'crafto-addons' ),
										esc_html__( '(e.g. "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.")', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'slug_field_description',
										esc_html__( 'Term Slug Field Description', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Description for the Slug field on Edit Tags screen.', 'crafto-addons' ),
										esc_html__( '(e.g. "The « slug » is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens."', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'desc_field_description',
										esc_html__( 'Term Description Field Description', 'crafto-addons' ),
										'text',
										'crafto_tax_labels',
										null,
										esc_html__( 'Description for the Description field on Edit Tags screen.', 'crafto-addons' ),
										esc_html__( '(e.g. "The description is not prominent by default; however, some themes may show it."', 'crafto-addons' )
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
									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'public',
										esc_html__( 'Public', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'publicly_queryable',
										esc_html__( 'Public Queryable', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether or not the taxonomy should be publicly queryable.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'hierarchical',
										esc_html__( 'Hierarchical', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether the taxonomy can have parent-child relationships. "True" gives checkboxes, "False" gives text input.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'show_ui',
										esc_html__( 'Show UI', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether to generate a default UI for managing this custom taxonomy.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'show_in_menu',
										esc_html__( 'Show in Menu', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether to show the taxonomy in the admin menu.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'show_in_nav_menus',
										esc_html__( 'Show in Nav Menus', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether to make the taxonomy available for selection in navigation menus.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'query_var',
										esc_html__( 'Query Var', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Sets the query_var key for this taxonomy.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'rewrite',
										esc_html__( 'Rewrite', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether or not WordPress should use rewrites for this taxonomy.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'rewrite_slug',
										esc_html__( 'Custom Rewrite Slug', 'crafto-addons' ),
										'text',
										'crafto_custom_tax',
										'',
										esc_html__( 'Custom taxonomy rewrite slug', 'crafto-addons' ),
										esc_html__( '(Default: Taxonomy Name)', 'crafto-addons' )
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'rewrite_withfront',
										esc_html__( 'Rewrite With Front', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Should the permastruct be prepended with the front base.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'rewrite_hierarchical',
										esc_html__( 'Rewrite Hierarchical', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'false',
										esc_html__( '(Default: False) Should the permastruct allow hierarchical urls.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'show_admin_column',
										esc_html__( 'Show Admin Column', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: True) Whether to allow automatic creation of taxonomy columns on associated post-types.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'show_in_rest',
										esc_html__( 'Show in REST API', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Custom Post Type UI Default: True) Determines whether this taxonomy data should be available in the WP REST API.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'show_tagcloud',
										esc_html__( 'Show in Tag Cloud', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: Inherited from "Show UI") Determines whether the taxonomy should be listed in the Tag Cloud Widget controls.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'show_in_quick_edit',
										esc_html__( 'Show in Quick/Bulk Edit Panel', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'true',
										esc_html__( '(Default: False) Determines whether the taxonomy should be available in the quick and bulk edit panels.', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'sort',
										esc_html__( 'Sort', 'crafto-addons' ),
										'select',
										'crafto_custom_tax',
										'false',
										esc_html__( 'Specifies whether terms in this taxonomy should be sorted in the order they are provided to wp_set_object_terms().', 'crafto-addons' ),
										''
									);

									Crafto_Register_Custom_Post_Type::crafto_ui(
										isset( $current ) ? $current : '',
										'default_term',
										esc_html__( 'Default Term', 'crafto-addons' ),
										'text',
										'crafto_custom_tax',
										'',
										esc_html__( 'Default term to be used for the taxonomy.', 'crafto-addons' ),
										''
									);
									?>
								</div>
							</div>
						</div>
						<div class="registered-post-type-main-right">
							<div class="submit-btn-wrapper">
								<?php
								wp_nonce_field( 'crafto_addedit_taxonomy_nonce_action', 'crafto_addedit_taxonomy_nonce_field' );
								if ( ! empty( $_GET ) && ! empty( $_GET['action'] ) && 'edit' === $_GET['action'] ) { // phpcs:ignore.
									?>
									<input type="submit" class="button-primary" name="crafto_submit" value="<?php echo esc_attr( apply_filters( 'crafto_taxonomy_submit_edit', esc_attr__( 'Update Taxonomy', 'crafto-addons' ) ) ); ?>">
									<input type="submit" class="button-secondary crafto-delete-bottom" name="crafto_delete" id="crafto_submit_delete" value="<?php echo esc_attr( apply_filters( 'crafto_taxonomy_submit_delete', esc_attr__( 'Delete Taxonomy', 'crafto-addons' ) ) ); ?>">
									<?php
								} else {
									?>
									<input type="submit" class="button-primary crafto-taxonomy-submit" name="crafto_submit" value="<?php echo esc_attr( apply_filters( 'crafto_taxonomy_submit_add', esc_attr__( 'Add Taxonomy', 'crafto-addons' ) ) ); ?>" />
									<?php
								}
								if ( ! empty( $current ) ) {
									?>
									<input type="hidden" name="crafto_tax_original" id="crafto_tax_original" value="<?php echo esc_attr( $current['name'] ); ?>">
									<?php
								}
								?>
								<input type="hidden" name="crafto_tax_status" id="crafto_tax_status" value="<?php echo esc_attr( $taxonomies_status ); ?>" />
							</div>
						</div>
					</div>
				</form>
				<?php
			}
		}

		/**
		 * Handle the save and deletion of taxonomy data.
		 */
		public function crafto_process_taxonomy() {

			if ( wp_doing_ajax() ) {
				return;
			}

			if ( ! is_admin() ) {
				return;
			}

			if ( ! empty( $_GET ) && isset( $_GET['page'] ) && 'crafto-theme-taxonomies' !== $_GET['page'] ) {
				return;
			}

			if ( ! empty( $_POST ) ) {
				$result = '';
				if ( isset( $_POST['crafto_submit'] ) ) {
					check_admin_referer( 'crafto_addedit_taxonomy_nonce_action', 'crafto_addedit_taxonomy_nonce_field' );
					$data   = $this->crafto_filtered_taxonomy_post_global();
					$result = $this->crafto_update_taxonomy( $data );
				} elseif ( isset( $_POST['crafto_delete'] ) ) {
					check_admin_referer( 'crafto_addedit_taxonomy_nonce_action', 'crafto_addedit_taxonomy_nonce_field' );

					$filtered_data = filter_input( INPUT_POST, 'crafto_custom_tax', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY );
					$result        = $this->crafto_delete_taxonomy( $filtered_data );
					add_filter( 'crafto_taxonomy_deleted', '__return_true' );
				}

				if ( $result && is_callable( "crafto_{$result}_admin_notice" ) ) {
					add_action( 'admin_notices', "crafto_{$result}_admin_notice" );
				}

				if ( ! empty( $_GET ) && isset( $_GET['crafto_taxonomies'] ) ) {
					if ( isset( $_POST['crafto_delete'] ) && ! in_array( $_GET['crafto_taxonomies'], $this->crafto_get_taxonomy_slugs() ) ) { // phpcs:ignore.
						wp_safe_redirect(
							add_query_arg(
								[ 'page' => 'crafto-theme-taxonomies' ],
								admin_url( 'admin.php?page=crafto-theme-taxonomies' )
							)
						);
					}
				}
			}
		}

		/**
		 * Register our users' custom taxonomies.
		 *
		 * @internal
		 */
		public function crafto_create_custom_taxonomies() {
			$taxes = get_option( 'crafto_register_taxonomies', [] );
			/**
			 * Filters an override array of taxonomy data to be registered instead of our saved option.
			 *
			 * @param array $value Default override value.
			 */
			$taxes_override = apply_filters( 'crafto_taxonomies_override', [] );

			if ( empty( $taxes ) && empty( $taxes_override ) ) {
				return;
			}

			// Assume good intent, and we're also not wrecking the option so things are always reversable.
			if ( is_array( $taxes_override ) && ! empty( $taxes_override ) ) {
				$taxes = $taxes_override;
			}

			/**
			 * Fires before the start of the taxonomy registrations.
			 *
			 * @param array $taxes Array of taxonomies to register.
			 */
			do_action( 'crafto_pre_register_taxonomies', $taxes );

			if ( is_array( $taxes ) ) {
				foreach ( $taxes as $tax ) {

					if ( ! is_string( $tax['name'] ) ) {
						$tax['name'] = (string) $tax['name'];
					}
					/**
					 * Filters whether or not to skip registration of the current iterated taxonomy.
					 *
					 * Dynamic part of the filter name is the chosen taxonomy slug.
					 *
					 * @param bool  $value Whether or not to skip the taxonomy.
					 * @param array $tax   Current taxonomy being registered.
					 */
					if ( (bool) apply_filters( "crafto_disable_{$tax['name']}_tax", false, $tax ) ) {
						continue;
					}

					/**
					 * Filters whether or not to skip registration of the current iterated taxonomy.
					 *
					 * @param bool  $value Whether or not to skip the taxonomy.
					 * @param array $tax   Current taxonomy being registered.
					 */
					if ( (bool) apply_filters( 'crafto_disable_tax', false, $tax ) ) {
						continue;
					}

					$this->crafto_register_single_taxonomy( $tax );
				}
			}

			/**
			 * Fires after the completion of the taxonomy registrations.
			 *
			 * @param array $taxes Array of taxonomies registered.
			 */
			do_action( 'crafto_post_register_taxonomies', $taxes );
		}

		/**
		 * Checks if we are trying to register an already registered taxonomy slug.
		 *
		 * @param bool   $slug_exists   Whether or not the post type slug exists. Optional. Default false.
		 * @param string $taxonomy_slug The post type slug being saved. Optional. Default empty string.
		 * @param array  $taxonomies    Array of Crafto-registered post types. Optional.
		 *
		 * @return bool
		 */
		public function crafto_check_existing_taxonomy_slugs( $slug_exists = false, $taxonomy_slug = '', $taxonomies = [] ) {

			// If true, then we'll already have a conflict, let's not re-process.
			if ( true === $slug_exists ) {
				return $slug_exists;
			}

			if ( ! is_array( $taxonomies ) ) {
				return $slug_exists;
			}

			// Check if Crafto has already registered this slug.
			if ( array_key_exists( strtolower( $taxonomy_slug ), $taxonomies ) ) { // phpcs:ignore.
				return true;
			}

			// Check if we're registering a reserved post type slug.
			if ( in_array( $taxonomy_slug, $this->crafto_reserved_taxonomies() ) ) { // phpcs:ignore.
				return true;
			}

			// Check if other plugins have registered this same slug.
			$public  = get_taxonomies(
				[
					'_builtin' => false,
					'public'   => true,
				]
			);
			$private = get_taxonomies(
				[
					'_builtin' => false,
					'public'   => false,
				]
			);

			$registered_taxonomies = array_merge( $public, $private );
			if ( in_array( $taxonomy_slug, $registered_taxonomies, true ) ) {
				return true;
			}

			// If we're this far, it's false.
			return $slug_exists;
		}

		/**
		 * Handles slug_exist checks for cases of editing an existing taxonomy.
		 *
		 * @param bool   $slug_exists   Current status for exist checks.
		 * @param string $taxonomy_slug Taxonomy slug being processed.
		 * @param array  $taxonomies    Crafto taxonomies.
		 * @return bool
		 */
		public function crafto_updated_taxonomy_slug_exists( $slug_exists, $taxonomy_slug = '', $taxonomies = [] ) {
			if (
				( ! empty( $_POST['crafto_tax_status'] ) && 'edit' === $_POST['crafto_tax_status'] ) && // phpcs:ignore WordPress.Security.NonceVerification
				! in_array( $taxonomy_slug, $this->crafto_reserved_taxonomies(), true ) && // phpcs:ignore WordPress.Security.NonceVerification
				( ! empty( $_POST['crafto_tax_original'] ) && $taxonomy_slug === $_POST['crafto_tax_original'] ) // phpcs:ignore WordPress.Security.NonceVerification
			) {
				$slug_exists = false;
			}
			return $slug_exists;
		}

		/* EXTRA FUNCTION */

		/**
		 * Fetch our Crafto taxonomies option.
		 *
		 * @return mixed
		 */
		public function crafto_get_taxonomy_data() {
			return apply_filters( 'crafto_get_taxonomy_data', get_option( 'crafto_register_taxonomies', [] ), get_current_blog_id() );
		}

		/**
		 * Get the selected taxonomy from the $_POST global.
		 *
		 * @internal
		 *
		 * @param bool $taxonomy_deleted Whether or not a taxonomy was recently deleted. Optional. Default false.
		 * @return bool|string False on no result, sanitized taxonomy if set.
		 */
		public function crafto_get_current_taxonomy( $taxonomy_deleted = false ) {

			$tax = false;

			if ( ! empty( $_GET ) && isset( $_GET['crafto_taxonomies'] ) ) { // phpcs:ignore.
				$tax = sanitize_text_field( wp_unslash( $_GET['crafto_taxonomies'] ) ); // phpcs:ignore.
			} else {
				$taxonomies = $this->crafto_get_taxonomy_data();
				if ( ! empty( $taxonomies ) ) {
					// Will return the first array key.
					$tax = key( $taxonomies );
				}
			}

			/**
			 * Filters the current taxonomy to edit.
			 *
			 * @param string $tax Taxonomy slug.
			 */
			return apply_filters( 'crafto_current_taxonomy', $tax );
		}

		/**
		 * Return an array of names that users should not or can not use for taxonomy names.
		 *
		 * @return array $value Array of names that are recommended against.
		 */
		public function crafto_reserved_taxonomies() {

			$reserved = [
				'action',
				'attachment',
				'attachment_id',
				'author',
				'author_name',
				'calendar',
				'cat',
				'category',
				'category__and',
				'category__in',
				'category__not_in',
				'category_name',
				'comments_per_page',
				'comments_popup',
				'cpage',
				'custom',
				'customize_messenger_channel',
				'customized',
				'date',
				'day',
				'debug',
				'embed',
				'error',
				'exact',
				'feed',
				'fields',
				'hour',
				'include',
				'link_category',
				'm',
				'minute',
				'monthnum',
				'more',
				'name',
				'nav_menu',
				'nonce',
				'nopaging',
				'offset',
				'order',
				'orderby',
				'output',
				'p',
				'page',
				'page_id',
				'paged',
				'pagename',
				'pb',
				'perm',
				'post',
				'post__in',
				'post__not_in',
				'post_format',
				'post_mime_type',
				'post_status',
				'post_tag',
				'post_type',
				'posts',
				'posts_per_archive_page',
				'posts_per_page',
				'preview',
				'robots',
				's',
				'search',
				'search_terms',
				'second',
				'sentence',
				'showposts',
				'static',
				'status',
				'subpost',
				'subpost_id',
				'tag',
				'tag__and',
				'tag__in',
				'tag__not_in',
				'tag_id',
				'tag_slug__and',
				'tag_slug__in',
				'taxonomy',
				'tb',
				'term',
				'terms',
				'theme',
				'themes',
				'title',
				'type',
				'types',
				'w',
				'withcomments',
				'withoutcomments',
				'year',
			];

			/**
			 * Filters the list of reserved post types to check against.
			 * 3rd party plugin authors could use this to prevent duplicate post types.
			 *
			 * @param array $value Array of post type slugs to forbid.
			 */
			$custom_reserved = apply_filters( 'crafto_reserved_taxonomies', [] );

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
		 * Return an array of all taxonomy slugs from Custom Post Type UI.
		 *
		 * @return array Crafto taxonomy slugs.
		 */
		public function crafto_get_taxonomy_slugs() {
			$taxonomies = get_option( 'crafto_register_taxonomies' );
			if ( ! empty( $taxonomies ) ) {
				return array_keys( $taxonomies );
			}
			return [];
		}

		/**
		 * Sanitize and filter the $_POST global and return a reconstructed array of the parts we need.
		 *
		 * Used for when managing taxonomies.
		 *
		 * @return array
		 */
		public function crafto_filtered_taxonomy_post_global() {
			$filtered_data = [];

			$default_arrays = [
				'crafto_custom_tax',
				'crafto_tax_labels',
				'crafto_post_types',
			];

			$third_party_items_arrays = apply_filters(
				'crafto_filtered_taxonomy_post_global_arrays',
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
				'crafto_tax_original',
				'crafto_tax_status',
			];

			$third_party_items_strings = apply_filters(
				'crafto_filtered_taxonomy_post_global_strings',
				(array) [] // phpcs:ignore.
			);

			$items_strings = array_merge( $default_strings, $third_party_items_strings );
			foreach ( $items_strings as $item ) {
				$second_result = filter_input( INPUT_POST, $item, FILTER_SANITIZE_SPECIAL_CHARS );
				if ( $second_result ) {
					$filtered_data[ $item ] = $second_result;
				}
			}

			return $filtered_data;
		}

		/**
		 * Returns error message for if trying to register existing taxonomy.
		 *
		 * @return string
		 */
		public function crafto_slug_matches_taxonomy() {
			return sprintf(
				/* translators: Placeholders are just for HTML markup that doesn't need translated */
				esc_html__( 'Please choose a different taxonomy name. %s is already registered.', 'crafto-addons' ),
				crafto_get_object_from_post_global()
			);
		}

		/**
		 * Returns error message for if not providing a post type to associate taxonomy to.
		 *
		 * @return string
		 */
		public function crafto_empty_cpt_on_taxonomy() {
			return esc_html__( 'Please provide a post type to attach to.', 'crafto-addons' );
		}

		/**
		 * Add to or update our Crafto option with new data.
		 *
		 * @param array $data Array of taxonomy data to update. Optional.
		 * @return bool|string False on failure, string on success.
		 */
		public function crafto_update_taxonomy( $data = [] ) {

			/**
			 * Fires before a taxonomy is updated to our saved options.
			 *
			 * @param array $data Array of taxonomy data we are updating.
			 */
			do_action( 'crafto_before_update_taxonomy', $data );

			// They need to provide a name.
			if ( empty( $data['crafto_custom_tax']['name'] ) ) {
				return crafto_admin_notices( 'error', '', false, esc_html__( 'Please provide a taxonomy name', 'crafto-addons' ) );
			}

			// Maybe a little harsh, but we shouldn't be saving THAT frequently.
			delete_option( "default_term_{$data['crafto_custom_tax']['name']}" );

			if ( empty( $data['crafto_post_types'] ) ) {
				add_filter( 'crafto_custom_error_message', array( $this, 'crafto_empty_cpt_on_taxonomy' ) );
				return 'error';
			}

			foreach ( $data as $key => $value ) {
				if ( is_string( $value ) ) {
					$data[ $key ] = sanitize_text_field( $value );
				} else {
					array_map( 'sanitize_text_field', $data[ $key ] );
				}
			}

			if ( false !== strpos( $data['crafto_custom_tax']['name'], '\'' ) ||
				false !== strpos( $data['crafto_custom_tax']['name'], '\"' ) ||
				false !== strpos( $data['crafto_custom_tax']['rewrite_slug'], '\'' ) ||
				false !== strpos( $data['crafto_custom_tax']['rewrite_slug'], '\"' ) ) {

				add_filter( 'crafto_custom_error_message', array( $this, 'crafto_slug_has_quotes' ) );
				return 'error';
			}

			$taxonomies = $this->crafto_get_taxonomy_data();

			/**
			 * Check if we already have a post type of that name.
			 *
			 * @param bool   $value      Assume we have no conflict by default.
			 * @param string $value      Post type slug being saved.
			 * @param array  $post_types Array of existing post types from Crafto.
			 */
			$slug_exists = apply_filters( 'crafto_taxonomy_slug_exists', false, $data['crafto_custom_tax']['name'], $taxonomies );
			if ( true === $slug_exists ) {
				add_filter( 'crafto_custom_error_message', array( $this, 'crafto_slug_matches_taxonomy' ) );
				return 'error';
			}

			if ( empty( $data['crafto_tax_labels'] ) || ! is_array( $data['crafto_tax_labels'] ) ) {
				$data['crafto_tax_labels'] = [];
			}

			foreach ( $data['crafto_tax_labels'] as $key => $label ) {
				if ( empty( $label ) ) {
					unset( $data['crafto_tax_labels'][ $key ] );
				}
				$label                             = str_replace( '"', '', htmlspecialchars_decode( $label ) );
				$label                             = htmlspecialchars( $label, ENT_QUOTES );
				$label                             = trim( $label );
				$data['crafto_tax_labels'][ $key ] = stripslashes_deep( $label );
			}

			$label = ucwords( str_replace( '_', ' ', $data['crafto_custom_tax']['name'] ) );
			if ( ! empty( $data['crafto_custom_tax']['label'] ) ) {
				$label = str_replace( '"', '', htmlspecialchars_decode( $data['crafto_custom_tax']['label'] ) );
				$label = htmlspecialchars( stripslashes( $label ), ENT_QUOTES );
			}

			$name = trim( $data['crafto_custom_tax']['name'] );

			$singular_label = ucwords( str_replace( '_', ' ', $data['crafto_custom_tax']['name'] ) );
			if ( ! empty( $data['crafto_custom_tax']['singular_label'] ) ) {
				$singular_label = str_replace( '"', '', htmlspecialchars_decode( $data['crafto_custom_tax']['singular_label'] ) );
				$singular_label = htmlspecialchars( stripslashes( $singular_label ) );
			}
			$description          = stripslashes_deep( $data['crafto_custom_tax']['description'] );
			$rewrite_slug         = trim( $data['crafto_custom_tax']['rewrite_slug'] );
			$show_quickpanel_bulk = ! empty( $data['crafto_custom_tax']['show_in_quick_edit'] ) ? Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['show_in_quick_edit'] ) : '';
			$default_term         = trim( $data['crafto_custom_tax']['default_term'] );

			$taxonomies[ $this->sanitize_taxonomy_slug( $data['crafto_custom_tax']['name'] ) ] = [
				'name'                 => $this->sanitize_taxonomy_slug( $name ),
				'label'                => $label,
				'singular_label'       => $singular_label,
				'description'          => $description,
				'public'               => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['public'] ),
				'publicly_queryable'   => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['publicly_queryable'] ),
				'hierarchical'         => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['hierarchical'] ),
				'show_ui'              => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['show_ui'] ),
				'show_in_menu'         => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['show_in_menu'] ),
				'show_in_nav_menus'    => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['show_in_nav_menus'] ),
				'query_var'            => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['query_var'] ),
				'rewrite'              => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['rewrite'] ),
				'rewrite_slug'         => $rewrite_slug,
				'rewrite_withfront'    => $data['crafto_custom_tax']['rewrite_withfront'],
				'rewrite_hierarchical' => $data['crafto_custom_tax']['rewrite_hierarchical'],
				'show_admin_column'    => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['show_admin_column'] ),
				'show_in_rest'         => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['show_in_rest'] ),
				'show_tagcloud'        => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['show_tagcloud'] ),
				'sort'                 => Crafto_Register_Custom_Post_Type::crafto_display_boolean( $data['crafto_custom_tax']['sort'] ),
				'show_in_quick_edit'   => $show_quickpanel_bulk,
				'labels'               => $data['crafto_tax_labels'],
				'default_term'         => $default_term,
			];

			$taxonomies[ $this->sanitize_taxonomy_slug( $data['crafto_custom_tax']['name'] ) ]['object_types'] = $data['crafto_post_types'];

			/**
			 * Filters final data to be saved right before saving taxoomy data.
			 *
			 * @param array  $taxonomies Array of final taxonomy data to save.
			 * @param string $name       Taxonomy slug for taxonomy being saved.
			 */
			$taxonomies = apply_filters( 'crafto_pre_save_taxonomy', $taxonomies, $name );

			/**
			 * Filters whether or not 3rd party options were saved successfully within taxonomy add/update.
			 *
			 * @param bool  $value      Whether or not someone else saved successfully. Default false.
			 * @param array $taxonomies Array of our updated taxonomies data.
			 * @param array $data       Array of submitted taxonomy to update.
			 */
			if ( false === ( $success = apply_filters( 'crafto_taxonomy_update_save', false, $taxonomies, $data ) ) ) { // phpcs:ignore.
				$success = update_option( 'crafto_register_taxonomies', $taxonomies );
			}

			/**
			 * Fires after a taxonomy is updated to our saved options.
			 *
			 * @param array $data Array of taxonomy data that was updated.
			 */
			do_action( 'crafto_after_update_taxonomy', $data );

			// Used to help flush rewrite rules on init.
			set_transient( 'crafto_flush_rewrite_rules', 'true', 5 * 60 );

			if ( isset( $success ) && 'new' === $data['crafto_tax_status'] ) {
				return 'add_success';
			}

			return 'update_success';
		}

		/**
		 * Helper function to register the actual taxonomy.
		 *
		 * @param array $taxonomy Taxonomy array to register. Optional.
		 * @return null Result of register_taxonomy.
		 */
		public function crafto_register_single_taxonomy( $taxonomy = [] ) {

			$labels = [
				'name'          => $taxonomy['label'],
				'singular_name' => $taxonomy['singular_label'],
			];

			$taxonomy_name_slug = $this->sanitize_taxonomy_slug( $taxonomy['name'] );

			$description = '';
			if ( ! empty( $taxonomy['description'] ) ) {
				$description = $taxonomy['description'];
			}

			$preserved        = Crafto_Register_Custom_Post_Type::crafto_get_preserved_keys( 'taxonomies' );
			$preserved_labels = Crafto_Register_Custom_Post_Type::crafto_get_preserved_labels();
			foreach ( $taxonomy['labels'] as $key => $label ) {

				if ( ! empty( $label ) ) {
					$labels[ $key ] = $label;
				} elseif ( empty( $label ) && in_array( $key, $preserved, true ) ) {
					$singular_or_plural = ( in_array( $key, array_keys( $preserved_labels['taxonomies']['plural'] ) ) ) ? 'plural' : 'singular'; // phpcs:ignore.
					$label_plurality    = ( 'plural' === $singular_or_plural ) ? $taxonomy['label'] : $taxonomy['singular_label'];
					$labels[ $key ]     = sprintf( $preserved_labels['taxonomies'][ $singular_or_plural ][ $key ], $label_plurality );
				}
			}

			$rewrite = Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['rewrite'] );
			if ( false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['rewrite'] ) ) {
				$rewrite               = [];
				$rewrite['slug']       = ! empty( $taxonomy['rewrite_slug'] ) ? $taxonomy['rewrite_slug'] : $taxonomy_name_slug;
				$rewrite['with_front'] = true;
				if ( isset( $taxonomy['rewrite_withfront'] ) ) {
					$rewrite['with_front'] = ( 'false' === Crafto_Register_Custom_Post_Type::crafto_display_boolean( $taxonomy['rewrite_withfront'] ) ) ? false : true;
				}
				$rewrite['hierarchical'] = false;
				if ( isset( $taxonomy['rewrite_hierarchical'] ) ) {
					$rewrite['hierarchical'] = ( 'true' === Crafto_Register_Custom_Post_Type::crafto_display_boolean( $taxonomy['rewrite_hierarchical'] ) ) ? true : false;
				}
			}

			if ( in_array( $taxonomy['query_var'], [ 'true', 'false', '0', '1' ], true ) ) {
				$taxonomy['query_var'] = Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['query_var'] );
			}

			$public             = ( ! empty( $taxonomy['public'] ) && false === Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['public'] ) ) ? false : true;
			$publicly_queryable = ( ! empty( $taxonomy['publicly_queryable'] ) && false === Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['publicly_queryable'] ) ) ? false : true;
			if ( empty( $taxonomy['publicly_queryable'] ) ) {
				$publicly_queryable = $public;
			}

			$show_admin_column = ( ! empty( $taxonomy['show_admin_column'] ) && false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_admin_column'] ) ) ? true : false;

			$show_in_menu = ( ! empty( $taxonomy['show_in_menu'] ) && false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_in_menu'] ) ) ? true : false;

			if ( empty( $taxonomy['show_in_menu'] ) ) {
				$show_in_menu = Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_ui'] );
			}

			$show_in_nav_menus = ( ! empty( $taxonomy['show_in_nav_menus'] ) && false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_in_nav_menus'] ) ) ? true : false;
			if ( empty( $taxonomy['show_in_nav_menus'] ) ) {
				$show_in_nav_menus = $public;
			}

			$show_tagcloud = ( ! empty( $taxonomy['show_tagcloud'] ) && false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_tagcloud'] ) ) ? true : false;
			if ( empty( $taxonomy['show_tagcloud'] ) ) {
				$show_tagcloud = Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_ui'] );
			}

			$show_in_rest = ( ! empty( $taxonomy['show_in_rest'] ) && false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_in_rest'] ) ) ? true : false;

			$show_in_quick_edit = ( ! empty( $taxonomy['show_in_quick_edit'] ) && false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_in_quick_edit'] ) ) ? true : false;

			$sort = ( ! empty( $taxonomy['sort'] ) && false !== Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['sort'] ) ) ? true : false;

			$default_term = null;
			if ( ! empty( $taxonomy['default_term'] ) ) {
				$term_parts = explode( ',', $taxonomy['default_term'] );
				if ( ! empty( $term_parts[0] ) ) {
					$default_term['name'] = trim( $term_parts[0] );
				}
				if ( ! empty( $term_parts[1] ) ) {
					$default_term['slug'] = trim( $term_parts[1] );
				}
				if ( ! empty( $term_parts[2] ) ) {
					$default_term['description'] = trim( $term_parts[2] );
				}
			}

			$args = [
				'labels'             => $labels,
				'label'              => $taxonomy['label'],
				'description'        => $description,
				'public'             => $public,
				'publicly_queryable' => $publicly_queryable,
				'hierarchical'       => Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['hierarchical'] ),
				'show_ui'            => Crafto_Register_Custom_Post_Type::crafto_get_display_boolean( $taxonomy['show_ui'] ),
				'show_in_menu'       => $show_in_menu,
				'show_in_nav_menus'  => $show_in_nav_menus,
				'show_tagcloud'      => $show_tagcloud,
				'query_var'          => $taxonomy['query_var'],
				'rewrite'            => $rewrite,
				'show_admin_column'  => $show_admin_column,
				'show_in_rest'       => $show_in_rest,
				'show_in_quick_edit' => $show_in_quick_edit,
				'sort'               => $sort,
				'default_term'       => $default_term,
			];

			$object_type = ! empty( $taxonomy['object_types'] ) ? $taxonomy['object_types'] : '';

			/**
			 * Filters the arguments used for a taxonomy right before registering.
			 *
			 * @param array  $args        Array of arguments to use for registering taxonomy.
			 * @param string $value       Taxonomy slug to be registered.
			 * @param array  $taxonomy    Original passed in values for taxonomy.
			 * @param array  $object_type Array of chosen post types for the taxonomy.
			 */
			$args = apply_filters( 'crafto_pre_register_taxonomy', $args, $taxonomy_name_slug, $taxonomy, $object_type );

			return register_taxonomy( $taxonomy_name_slug, $object_type, $args );
		}

		/**
		 * Delete our custom taxonomy from the array of taxonomies.
		 *
		 * @param array $data The $_POST values. Optional.
		 * @return bool|string False on failure, string on success.
		 */
		public function crafto_delete_taxonomy( $data = [] ) {

			if ( is_string( $data ) && taxonomy_exists( $data ) ) {
				$slug         = $data;
				$data         = [];
				$data['name'] = $slug;
			}

			// Check if they selected one to delete.
			if ( empty( $data['name'] ) ) {
				return crafto_admin_notices( 'error', '', false, esc_html__( 'Please provide a taxonomy to delete', 'crafto-addons' ) );
			}

			/**
			 * Fires before a taxonomy is deleted from our saved options.
			 *
			 * @param array $data Array of taxonomy data we are deleting.
			 */
			do_action( 'crafto_before_delete_taxonomy', $data );

			$taxonomies = $this->crafto_get_taxonomy_data();

			if ( array_key_exists( strtolower( $data['name'] ), $taxonomies ) ) {

				unset( $taxonomies[ $data['name'] ] );

				/**
				 * Filters whether or not 3rd party options were saved successfully within taxonomy deletion.
				 *
				 * @param bool  $value      Whether or not someone else saved successfully. Default false.
				 * @param array $taxonomies Array of our updated taxonomies data.
				 * @param array $data       Array of submitted taxonomy to update.
				 */
				if ( false === ( $success = apply_filters( 'crafto_taxonomy_delete_tax', false, $taxonomies, $data ) ) ) { // phpcs:ignore.
					$success = update_option( 'crafto_register_taxonomies', $taxonomies );
				}
			}
			delete_option( "default_term_{$data['name']}" );

			/**
			 * Fires after a taxonomy is deleted from our saved options.
			 *
			 * @param array $data Array of taxonomy data that was deleted.
			 */
			do_action( 'crafto_after_delete_taxonomy', $data );

			// Used to help flush rewrite rules on init.
			set_transient( 'crafto_flush_rewrite_rules', 'true', 5 * 60 );

			if ( isset( $success ) ) {
				return 'delete_success';
			}
			return 'delete_fail';
		}

		/**
		 * Checks if a taxonomy is already registered.
		 *
		 * @param string       $slug Taxonomy slug to check. Optional. Default empty string.
		 * @param array|string $data Taxonomy data being utilized. Optional.
		 *
		 * @return mixed
		 */
		public function crafto_get_taxonomy_exists( $slug = '', $data = [] ) {

			/**
			 * Filters the boolean value for if a taxonomy exists for 3rd parties.
			 *
			 * @param string       $slug Taxonomy slug to check.
			 * @param array|string $data Taxonomy data being utilized.
			 */
			return apply_filters( 'crafto_get_taxonomy_exists', taxonomy_exists( $slug ), $data );
		}

		/**
		 * Checks if the slug matches any existing page slug.
		 *
		 * @param string $taxonomy_name The post type slug being saved. Optional. Default empty string.
		 */
		public function sanitize_taxonomy_slug( $taxonomy_name ) {

			$slug = strtolower( $taxonomy_name );

			$slug = str_replace( ' ', '_', $slug );

			$slug = preg_replace( '/[^a-z0-9_\-]/', '', $slug );

			$slug = substr( $slug, 0, 20 );

			return $slug;
		}

		/**
		 * Custom Post Type Delete Handler.
		 */
		public function crafto_delete_custom_taxonomies_callback() {
			$rediect_url    = $_POST['redirect_url']; // phpcs:ignore
			$taxonomies_slug = $_POST['taxonomies_slug']; // phpcs:ignore

			$success = '';
			if ( '' !== $rediect_url && '' !== $taxonomies_slug ) {
				$taxonomies = $this->crafto_get_taxonomy_data();

				if ( array_key_exists( strtolower( $taxonomies_slug ), $taxonomies ) ) {

					unset( $taxonomies[ $taxonomies_slug ] );

					$success = update_option( 'crafto_register_taxonomies', $taxonomies );

					delete_option( "default_term_{$taxonomies_slug}" );
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

		/* EXTRA FUNCTION */
	}

	new Crafto_Register_Custom_Taxonomy();
}
