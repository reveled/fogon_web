<?php
/**
 * Theme Builder Elementor Canvas
 *
 * @package Crafto
 */

namespace CraftoAddons\Theme_Builder\Classes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Theme_Builder_Admin` doesn't exists yet.
if ( ! class_exists( 'Theme_Builder_Admin' ) ) {

	/**
	 * Define Theme_Builder_Admin class
	 */
	class Theme_Builder_Admin {

		public $post_type = 'themebuilder';

		/**
		 * Theme Builder constructor.
		 *
		 * Initializing the Elementor modules manager.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'crafto_themebuilder_post_type_init' ) );
			add_action( 'template_redirect', array( $this, 'crafto_themebuilder_block_template_frontend' ) );
			add_filter( 'single_template', array( $this, 'crafto_themebuilder_load_canvas_template' ) );
			add_filter( 'manage_themebuilder_posts_columns', array( $this, 'crafto_themebuilder_set_columns_fields' ) );
			add_action( 'manage_themebuilder_posts_custom_column', array( $this, 'crafto_themebuilder_render_column_fields' ), 10, 2 );
			add_filter( 'manage_edit-themebuilder_sortable_columns', array( $this, 'crafto_themebuilder_sortable_columns' ) );
			add_filter( 'views_edit-themebuilder', array( $this, 'crafto_themebuilder_admin_print_tabs' ) );
			add_filter( 'pre_get_posts', array( $this, 'crafto_themebuilder_make_sortable' ) );
		}

		/**
		 * Theme Builder Admin Print Tabs.
		 *
		 * @param array $views data.
		 */
		public function crafto_themebuilder_admin_print_tabs( $views ) {
			if ( is_admin() && isset( $_GET['post_type'] ) && $this->post_type === $_GET['post_type'] ) { // phpcs:ignore.
				$template_type = array(
					'all'               => esc_html__( 'All', 'crafto-addons' ),
					'mini-header'       => esc_html__( 'Top Bar', 'crafto-addons' ),
					'header'            => esc_html__( 'Header', 'crafto-addons' ),
					'footer'            => esc_html__( 'Footer', 'crafto-addons' ),
					'custom-title'      => esc_html__( 'Page Title', 'crafto-addons' ),
					'archive'           => esc_html__( 'Post Archive', 'crafto-addons' ),
					'single'            => esc_html__( 'Post Single', 'crafto-addons' ),
					'archive-portfolio' => esc_html__( 'Portfolio Archive', 'crafto-addons' ),
					'single-portfolio'  => esc_html__( 'Portfolio Single', 'crafto-addons' ),
					'archive-property'  => esc_html__( 'Property Archive', 'crafto-addons' ),
					'single-properties' => esc_html__( 'Property Single', 'crafto-addons' ),
					'archive-tours'     => esc_html__( 'Tour Archive', 'crafto-addons' ),
					'single-tours'      => esc_html__( 'Tour Single', 'crafto-addons' ),
					'404_page'          => esc_html__( '404', 'crafto-addons' ),
					'promo_popup'       => esc_html__( 'Popup', 'crafto-addons' ),
					'side_icon'         => esc_html__( 'Side Icon', 'crafto-addons' ),
				);

				$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );
				if ( '1' === $crafto_disable_portfolio ) {
					unset( $template_type['archive-portfolio'] );
					unset( $template_type['single-portfolio'] );
				}

				$crafto_disable_property = get_theme_mod( 'crafto_disable_property', '0' );
				if ( '1' === $crafto_disable_property ) {
					unset( $template_type['single-properties'] );
					unset( $template_type['archive-property'] );
				}

				$crafto_disable_tours = get_theme_mod( 'crafto_disable_tours', '0' );
				if ( '1' === $crafto_disable_tours ) {
					unset( $template_type['archive-tours'] );
					unset( $template_type['single-tours'] );
				}
				?>
				<div class="crafto-nav-tabs nav-tab-wrapper">
					<?php
					$counter = 1;
					foreach ( $template_type as $key => $type ) {
						$current_tab = ( 1 === $counter ) ? ' nav-tab-active' : '';
						if ( isset( $_GET['template_type'] ) && ! empty( $_GET['template_type'] ) ) { // phpcs:ignore.
							$current_tab = ( $_GET['template_type'] === $key ) ? ' nav-tab-active' : '';// phpcs:ignore.
						}

						echo sprintf( // phpcs:ignore
							'<a href="%s" class="%s">%s</a>',
							esc_url(
								add_query_arg(
									array(
										'post_type'     => $this->post_type,
										'template_type' => $key,
									),
									'edit.php'
								)
							),
							'nav-tab' . esc_attr( $current_tab ),
							esc_html( $type )
						);
						++$counter;
					}
					?>
				</div>
				<?php
				return $views;
			}
		}

		/**
		 * Theme Builder - Register Post Type.
		 */
		public function crafto_themebuilder_post_type_init() {
			$logo_url = CRAFTO_ADDONS_INCLUDES_URI . '/assets/images/crafto-logo.svg';
			$labels   = array(
				'name'               => esc_html__( 'Theme Builder', 'crafto-addons' ),
				'singular_name'      => esc_html__( 'Theme Builder', 'crafto-addons' ),
				'menu_name'          => esc_html__( 'Theme Builder', 'crafto-addons' ),
				'name_admin_bar'     => esc_html__( 'Theme Builder', 'crafto-addons' ),
				'add_new'            => esc_html__( 'Add New', 'crafto-addons' ),
				'add_new_item'       => esc_html__( 'Add New Template', 'crafto-addons' ),
				'new_item'           => esc_html__( 'New Template', 'crafto-addons' ),
				'edit_item'          => esc_html__( 'Edit Template', 'crafto-addons' ),
				'view_item'          => esc_html__( 'View Template', 'crafto-addons' ),
				'all_items'          => esc_html__( 'All Templates', 'crafto-addons' ),
				'search_items'       => esc_html__( 'Search Template', 'crafto-addons' ),
				'parent_item_colon'  => esc_html__( 'Parent Template:', 'crafto-addons' ),
				'not_found'          => esc_html__( 'No template found', 'crafto-addons' ),
				'not_found_in_trash' => esc_html__( 'No templates found in trash', 'crafto-addons' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'menu_position'       => 2,
				'menu_icon'           => $logo_url,
				'exclude_from_search' => true,
				'rewrite'             => false,
				'supports'            => array(
					'title',
					'elementor',
					'author',
					'comments',
				),
			);

			register_post_type( 'themebuilder', $args );
		}

		/**
		 * Theme Builder - Render blocked on frontent
		 */
		public function crafto_themebuilder_block_template_frontend() {
			if ( is_singular( $this->post_type ) && ! current_user_can( 'edit_posts' ) ) {
				wp_safe_redirect( site_url(), 301 );
				wp_die();
			}
		}

		/**
		 * Load Theme Builder Canvas Template.
		 *
		 * @param array $single_template data.
		 */
		public function crafto_themebuilder_load_canvas_template( $single_template ) {
			global $post;

			if ( $this->post_type === $post->post_type ) {

				$elementor_2_0_canvas = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

				if ( file_exists( $elementor_2_0_canvas ) ) {

					return $elementor_2_0_canvas;

				} else {

					return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
				}
			}

			return $single_template;
		}

		/**
		 * Set Theme Builder Column Fields.
		 *
		 * @param array $columns Column name.
		 */
		public function crafto_themebuilder_set_columns_fields( $columns ) {
			$date_column = $columns['date'];

			unset( $columns['date'] );

			$columns['template_type'] = esc_html__( 'Template type', 'crafto-addons' );

			if ( isset( $_GET['template_type'] ) && ( 'archive' === $_GET['template_type'] || 'archive-portfolio' === $_GET['template_type'] || 'archive-property' === $_GET['template_type'] || 'archive-tours' === $_GET['template_type'] ) ) { // phpcs:ignore.
				$columns['archive_type'] = esc_html__( 'Archive type', 'crafto-addons' );
			}

			if ( isset( $_GET['template_type'] ) && ( 'mini-header' === $_GET['template_type'] || 'header' === $_GET['template_type'] || 'footer' === $_GET['template_type'] ) ) { // phpcs:ignore.
				$columns['sticky_type'] = esc_html__( 'Sticky type', 'crafto-addons' );
			}

			if ( isset( $_GET['template_type'] ) && ( 'mini-header' === $_GET['template_type'] || 'header' === $_GET['template_type'] || 'footer' === $_GET['template_type'] || 'custom-title' === $_GET['template_type'] ) ) { // phpcs:ignore.
				$columns['display_style'] = esc_html__( 'Display On', 'crafto-addons' );
			}

			if ( isset( $_GET['template_type'] ) && ( 'single' === $_GET['template_type'] || 'single-portfolio' === $_GET['template_type'] || 'single-properties' === $_GET['template_type'] || 'single-tours' === $_GET['template_type'] ) ) { // phpcs:ignore.
				$columns['single_type'] = esc_html__( 'Display On', 'crafto-addons' );
			}

			$columns['date'] = $date_column;

			return $columns;
		}

		/**
		 * Set Theme Builder Column Fields.
		 *
		 * @param array $column Column name.
		 *
		 * @param array $post_id Post ID.
		 */
		public function crafto_themebuilder_render_column_fields( $column, $post_id ) {
			global $post;

			$template_type = get_post_meta( $post->ID, '_crafto_theme_builder_template', true );
			switch ( $column ) {
				case 'template_type':
					$template_label = ( $template_type ) ? \Crafto_Builder_Helper::crafto_get_template_type_by_key( $template_type ) : '-';
					if ( ! empty( $template_type ) ) {
						$out[] = sprintf(
							'<a href="%s">%s</a>',
							esc_url(
								add_query_arg(
									array(
										'post_type'     => $this->post_type,
										'template_type' => $template_type,
									),
									'edit.php'
								)
							),
							$template_label
						);
						echo join( ', ', $out ); // phpcs:ignore
					} else {
						printf( '%s', esc_html__( 'N/A', 'crafto-addons' ) );
					}
					break;
				case 'sticky_type':
					if ( 'mini-header' === $template_type ) {
						$sticky_type = crafto_meta_box_values( 'crafto_mini_header_sticky_type' );
					} elseif ( 'header' === $template_type ) {
						$sticky_type = crafto_meta_box_values( 'crafto_header_sticky_type' );
					} else {
						$sticky_type = crafto_meta_box_values( 'crafto_footer_sticky_type' );
					}

					if ( $sticky_type && ( 'mini-header' === $template_type || 'header' === $template_type ) ) {
						$sticky_label = \Crafto_Builder_Helper::crafto_get_header_sticky_type_by_key( $sticky_type );
					} elseif ( $sticky_type && ( 'footer' === $template_type ) ) {
						$sticky_label = \Crafto_Builder_Helper::crafto_get_footer_sticky_type_by_key( $sticky_type );
					} else {
						$sticky_label = esc_html__( 'N/A', 'crafto-addons' );
					}
					echo sprintf( '%s', $sticky_label ); // phpcs:ignore
					break;
				case 'display_style':
					$display_type_mini_header = crafto_meta_box_values( 'crafto_mini_header_display_type' );
					$display_type_header      = crafto_meta_box_values( 'crafto_header_display_type' );
					$display_type_footer      = crafto_meta_box_values( 'crafto_footer_display_type' );
					$display_type_page_title  = crafto_meta_box_values( 'crafto_custom_title_display_type' );

					if ( $display_type_mini_header && ( 'mini-header' === $template_type ) ) {
						$display_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_mini_header_display_type_by_key() as $key => $option ) {
							if ( is_array( $display_type_mini_header ) && in_array( $key, $display_type_mini_header, true ) ) {
								$display_label_arr[] = $option;
							}
						}
						$display_label = implode( ', ', $display_label_arr );
					} elseif ( $display_type_header && ( 'header' === $template_type ) ) {
						$display_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_header_display_type_by_key() as $key => $option ) {
							if ( is_array( $display_type_header ) && in_array( $key, $display_type_header, true ) ) {
								$display_label_arr[] = $option;
							}
						}
						$display_label = implode( ', ', $display_label_arr );
					} elseif ( $display_type_footer && ( 'footer' === $template_type ) ) {
						$display_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_footer_display_type_by_key() as $key => $option ) {
							if ( is_array( $display_type_footer ) && in_array( $key, $display_type_footer, true ) ) {
								$display_label_arr[] = $option;
							}
						}
						$display_label = implode( ', ', $display_label_arr );
					} elseif ( $display_type_page_title && ( 'custom-title' === $template_type ) ) {
						$display_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_custom_title_display_type_by_key() as $key => $option ) {
							if ( is_array( $display_type_page_title ) && in_array( $key, $display_type_page_title, true ) ) {
								$display_label_arr[] = $option;
							}
						}
						$display_label = implode( ', ', $display_label_arr );
					} else {
						$display_label = esc_html__( 'N/A', 'crafto-addons' );
					}
					echo sprintf( '%s', $display_label ); // phpcs:ignore
					break;
				case 'archive_type':
					$template_archive_type           = crafto_meta_box_values( 'crafto_template_archive_style' );
					$template_archive_portfolio_type = crafto_meta_box_values( 'crafto_template_archive_portfolio_style' );
					$template_archive_property_type  = crafto_meta_box_values( 'crafto_template_archive_property_style' );
					$template_archive_tours_type     = crafto_meta_box_values( 'crafto_template_archive_tours_style' );
					if ( $template_archive_type && 'archive' === $template_type ) {
						$archive_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_archive_style_by_key() as $key => $option ) {
							if ( is_array( $template_archive_type ) && in_array( $key, $template_archive_type, true ) ) {
								$archive_label_arr[] = $option;
							}
						}
						$archive_label = implode( ', ', $archive_label_arr );
					} elseif ( $template_archive_portfolio_type && 'archive-portfolio' === $template_type ) {
						$archive_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_archive_portfolio_style_by_key() as $key => $option ) {
							if ( is_array( $template_archive_portfolio_type ) && in_array( $key, $template_archive_portfolio_type, true ) ) {
								$archive_label_arr[] = $option;
							}
						}
						$archive_label = implode( ', ', $archive_label_arr );
					} elseif ( $template_archive_property_type && 'archive-property' === $template_type ) {
						$archive_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_archive_property_style_by_key() as $key => $option ) {
							if ( is_array( $template_archive_property_type ) && in_array( $key, $template_archive_property_type, true ) ) {
								$archive_label_arr[] = $option;
							}
						}
						$archive_label = implode( ', ', $archive_label_arr );
					} elseif ( $template_archive_tours_type && 'archive-tours' === $template_type ) {
						$archive_label_arr = array();

						foreach ( \Crafto_Builder_Helper::crafto_get_archive_tours_style_by_key() as $key => $option ) {
							if ( is_array( $template_archive_tours_type ) && in_array( $key, $template_archive_tours_type, true ) ) {
								$archive_label_arr[] = $option;
							}
						}
						$archive_label = implode( ', ', $archive_label_arr );
					} else {
						$archive_label = esc_html__( 'N/A', 'crafto-addons' );
					}

					echo sprintf( '%s', $archive_label ); // phpcs:ignore
					break;
				case 'single_type':
					// Post Include / Exclude get meta.
					$crafto_include_post = get_post_meta( $post->ID, '_crafto_template_specific_post', true );
					$crafto_exclude_post = get_post_meta( $post->ID, '_crafto_template_specific_exclude_post', true );

					// Portfolio Include / Exclude get meta.
					$crafto_include_portfolio = get_post_meta( $post->ID, '_crafto_template_specific_portfolio', true );
					$crafto_exclude_portfolio = get_post_meta( $post->ID, '_crafto_template_specific_exclude_portfolio', true );

					$crafto_include_properties = get_post_meta( $post->ID, '_crafto_template_specific_properties', true );
					$crafto_exclude_properties = get_post_meta( $post->ID, '_crafto_template_specific_exclude_properties', true );

					$crafto_include_tours = get_post_meta( $post->ID, '_crafto_template_specific_tours', true );
					$crafto_exclude_tours = get_post_meta( $post->ID, '_crafto_template_specific_exclude_tours', true );

					$include_single_label     = '';
					$exclude_single_label     = '';
					$include_single_label_arr = [];
					$exclude_single_label_arr = [];
					if ( 'single' === $template_type ) {
						if ( $crafto_include_post ) {

							$custom_post_type     = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
							$custom_post_type_arr = [];
							if ( $custom_post_type ) {
								foreach ( $custom_post_type as $post_type_name ) {
									$post_type_slug  = $post_type_name['name'];
									$post_type_label = $post_type_name['label'];

									$custom_post_type_slug = 'single-' . esc_html( $post_type_slug ) . '-all';

									$custom_post_type_arr[ $custom_post_type_slug ] = 'All Single ' . esc_html( $post_type_label );
								}
							}

							foreach ( $crafto_include_post as $id ) {
								if ( 'all-single' === $id ) {
									$include_single_label_arr[] = esc_attr__( 'All Single Posts', 'crafto-addons' );
								} elseif ( ! empty( $custom_post_type_arr ) && array_key_exists( $id, $custom_post_type_arr ) ) {
									$include_single_label_arr[] = $custom_post_type_arr[ $id ];
								} elseif ( get_post( $id ) ) {
									$include_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
									$term                       = get_term( $id );
									$include_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}

							if ( ! empty( $include_single_label_arr ) ) {
								$include_single_label = implode( ', ', $include_single_label_arr );
							} else {
								$include_single_label = esc_html__( 'All Single', 'crafto-addons' );
							}
						}

						if ( $crafto_exclude_post ) {
							foreach ( $crafto_exclude_post as $id ) {
								if ( get_post( $id ) ) {
									$exclude_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
									$term                       = get_term( $id );
									$exclude_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}
							if ( ! empty( $exclude_single_label_arr ) ) {
								$exclude_single_label = implode( ', ', $exclude_single_label_arr );
							}
						}
					} elseif ( 'single-portfolio' === $template_type ) {
						if ( $crafto_include_portfolio ) {
							foreach ( $crafto_include_portfolio as $id ) {
								if ( 'all-single' === $id ) {
									$include_single_label_arr[] = esc_attr__( 'All Single Portfolio', 'crafto-addons' );
								} elseif ( get_post( $id ) ) {
										$include_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
										$term                       = get_term( $id );
										$include_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}
						}

						if ( ! empty( $include_single_label_arr ) ) {
							$include_single_label = implode( ', ', $include_single_label_arr );
						} else {
							$include_single_label = esc_html__( 'All Single Portfolio', 'crafto-addons' );
						}

						if ( $crafto_exclude_portfolio ) {
							foreach ( $crafto_exclude_portfolio as $id ) {
								if ( get_post( $id ) ) {
									$exclude_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
									$term                       = get_term( $id );
									$exclude_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}
							if ( ! empty( $exclude_single_label_arr ) ) {
								$exclude_single_label = implode( ', ', $exclude_single_label_arr );
							}
						}
					} elseif ( $crafto_include_properties && 'single-properties' === $template_type ) {
						if ( $crafto_include_properties ) {
							foreach ( $crafto_include_properties as $id ) {
								if ( 'all-single' === $id ) {
									$include_single_label_arr[] = esc_attr__( 'All Single Property', 'crafto-addons' );
								} elseif ( get_post( $id ) ) {
										$include_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
										$term                       = get_term( $id );
										$include_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}
						}

						if ( ! empty( $include_single_label_arr ) ) {
							$include_single_label = implode( ', ', $include_single_label_arr );
						} else {
							$include_single_label = esc_html__( 'All Single Property', 'crafto-addons' );
						}

						if ( $crafto_exclude_properties ) {
							foreach ( $crafto_exclude_properties as $id ) {
								if ( get_post( $id ) ) {
									$exclude_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
									$term                       = get_term( $id );
									$exclude_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}
							if ( ! empty( $exclude_single_label_arr ) ) {
								$exclude_single_label = implode( ', ', $exclude_single_label_arr );
							}
						}
					} elseif ( $crafto_include_tours && 'single-tours' === $template_type ) {
						if ( $crafto_include_tours ) {
							foreach ( $crafto_include_tours as $id ) {
								if ( 'all-single' === $id ) {
									$include_single_label_arr[] = esc_attr__( 'All Single Tour', 'crafto-addons' );
								} elseif ( get_post( $id ) ) {
										$include_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
										$term                       = get_term( $id );
										$include_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}
						}

						if ( ! empty( $include_single_label_arr ) ) {
							$include_single_label = implode( ', ', $include_single_label_arr );
						} else {
							$include_single_label = esc_html__( 'All Single Tour', 'crafto-addons' );
						}

						if ( $crafto_exclude_tours ) {
							foreach ( $crafto_exclude_tours as $id ) {
								if ( get_post( $id ) ) {
									$exclude_single_label_arr[] = get_the_title( $id );
								} elseif ( get_term( $id ) && ! is_wp_error( get_term( $id ) ) ) {
									$term                       = get_term( $id );
									$exclude_single_label_arr[] = esc_attr( $term->name ) . ' (' . esc_attr( $term->taxonomy ) . ')';
								}
							}
							if ( ! empty( $exclude_single_label_arr ) ) {
								$exclude_single_label = implode( ', ', $exclude_single_label_arr );
							}
						}
					} else {
						$include_single_label = esc_html__( 'All Single', 'crafto-addons' );
					}
					echo sprintf( '<strong>%1$s</strong> %2$s', esc_html__( 'Include:', 'crafto-addons' ), $include_single_label ); // phpcs:ignore
					echo '<br>';
					echo sprintf( '<strong>%1$s</strong> %2$s', esc_html__( 'Exclude:', 'crafto-addons' ), $exclude_single_label ); // phpcs:ignore
					break;
			}
		}

		/**
		 * Set Theme Builder Make Sortable.
		 *
		 * @param \WP_Query $query Query.
		 */
		public function crafto_themebuilder_make_sortable( $query ) {
			global $pagenow, $typenow;

			if ( 'themebuilder' === $typenow && ( 'edit.php' === $pagenow || 'post.php' === $pagenow ) ) {
				if ( ! empty( $_GET['template_type'] ) && 'all' !== $_GET['template_type'] ) { // phpcs:ignore
					$query->query_vars['meta_key']   = '_crafto_theme_builder_template';// phpcs:ignore
					$query->query_vars['meta_value'] = $_GET['template_type']; // phpcs:ignore
				} else {
					$meta_query = array( 'relation' => 'AND' );
					$orderby    = $query->get( 'orderby' );
					if ( 'themebuilder_template_type' === $orderby ) {
						$query->set( 'meta_key', '_crafto_theme_builder_template' );
						$query->set( 'orderby', 'meta_value' );
					}

					$crafto_disable_portfolio = get_theme_mod( 'crafto_disable_portfolio', '0' );

					if ( isset( $_GET['post_type'] ) && 'themebuilder' === $_GET['post_type'] && '1' === $crafto_disable_portfolio ) { // phpcs:ignore
						$meta_query[] = array(
							'key'     => '_crafto_theme_builder_template',
							'value'   => array( 'archive-portfolio' ),
							'compare' => '!=',
						);
						$meta_query[] = array(
							'key'     => '_crafto_theme_builder_template',
							'value'   => array( 'single-portfolio' ),
							'compare' => '!=',
						);
					}

					$crafto_disable_property = get_theme_mod( 'crafto_disable_property', '0' );

					if ( isset( $_GET['post_type'] ) && 'themebuilder' === $_GET['post_type'] && '1' === $crafto_disable_property ) { // phpcs:ignore
						$meta_query[] = array(
							'key'     => '_crafto_theme_builder_template',
							'value'   => array( 'single-properties' ),
							'compare' => '!=',
						);
						$meta_query[] = array(
							'key'     => '_crafto_theme_builder_template',
							'value'   => array( 'archive-property' ),
							'compare' => '!=',
						);
					}

					$crafto_disable_tours = get_theme_mod( 'crafto_disable_tours', '0' );

					if ( isset( $_GET['post_type'] ) && 'themebuilder' === $_GET['post_type'] && '1' === $crafto_disable_tours ) { // phpcs:ignore
						$meta_query[] = array(
							'key'     => '_crafto_theme_builder_template',
							'value'   => array( 'single-tours' ),
							'compare' => '!=',
						);
						$meta_query[] = array(
							'key'     => '_crafto_theme_builder_template',
							'value'   => array( 'archive-tours' ),
							'compare' => '!=',
						);
					}
					$query->set( 'meta_query', $meta_query );
				}
			}
		}

		/**
		 * Theme Builder sortable columns.
		 *
		 * @param array $cols template column data.
		 */
		public function crafto_themebuilder_sortable_columns( $cols ) {
			$cols['template_type'] = 'themebuilder_template_type';
			return $cols;
		}
	} // End of Class.
} // End of Class Exists.
