<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for Breadcrumb.
 *
 * @package Crafto
 */
// If class `Crafto_Breadcrumb` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Breadcrumb' ) ) {

	class Breadcrumb extends Widget_Base {
		/**
		 * Retrieve the list of styles the breadcrumb widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-breadcrumb-widget' ];
			}
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-breadcrumb';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Breadcrumb', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-chevron-right';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/crafto-breadcrumb/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return string Widget categories.
		 */
		public function get_categories() {
			return [
				'crafto',
			];
		}

		/**
		 * Register breadcrumb widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_breadcrumb_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_breadcrumb_separator',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'icon-feather-chevron-right',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->add_responsive_control(
				'crafto_breadcrumb_alignment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'left',
					'options'              => [
						'left'   => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .breadcrumb-container' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_breadcrumb_html_tag',
				[
					'label'   => esc_html__( 'HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'p'    => 'p',
						'nav'  => 'nav',
						'span' => 'span',
						'div'  => 'div',
					],
					'default' => 'div',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_breadcrumb_style_section',
				[
					'label' => esc_html__( 'Breadcrumb', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_breadcrumb_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-breadcrumb span, {{WRAPPER}} .crafto-breadcrumb span a',
				]
			);
			$this->start_controls_tabs(
				'crafto_breadcrumb_tabs'
			);
			$this->start_controls_tab(
				'crafto_breadcrumb_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_breadcrumb_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-breadcrumb span, {{WRAPPER}} .crafto-breadcrumb span a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_breadcrumb_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_breadcrumb_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-breadcrumb span a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_breadcrumb_separator_heading',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-breadcrumb  i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-breadcrumb svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_breadcrumb_separator_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-breadcrumb i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .crafto-breadcrumb svg' => 'width: {{SIZE}}{{UNIT}}; height:auto;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_breadcrumb_separator_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-breadcrumb i, {{WRAPPER}} .crafto-breadcrumb svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_breadcrumb_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .breadcrumb-container',
					'fields_options' => [
						'background' => [
							'separator' => 'before',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_page_breadcrumb_border',
					'default'  => '1px',
					'selector' => '{{WRAPPER}} .breadcrumb-container',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_breadcrumb_box_shadow',
					'selector' => '{{WRAPPER}} .breadcrumb-container',
				]
			);
			$this->add_responsive_control(
				'crafto_breadcrumb_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .breadcrumb-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_breadcrumb_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .breadcrumb-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}
		/**
		 * Render breadcrumb widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();
			$tag      = $this->get_settings( 'crafto_breadcrumb_html_tag' );

			$icon     = '';
			$migrated = isset( $settings['__fa4_migrated']['crafto_breadcrumb_separator'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_breadcrumb_separator'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_breadcrumb_separator']['value'] ) && ! empty( $settings['crafto_breadcrumb_separator']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $settings['crafto_breadcrumb_separator']['value'] ) . '" aria-hidden="true"></i>';
			}

			$this->add_render_attribute(
				'breadcrumb',
				[
					'class' => [
						'crafto-breadcrumb',
					],
				],
			);
			?>
			<div class="breadcrumb-container">
				<<?php echo esc_attr( $tag ); ?> <?php $this->print_render_attribute_string( 'breadcrumb' ); ?>>
					<?php echo $this->crafto_breadcrumb( $icon ); // phpcs:ignore ?>
				</<?php echo esc_attr( $tag ); ?>>
			</div>
				<?php
		}

		/**
		 * Outputs a full breadcrumb trail with support for pages, CPTs, WooCommerce, archives, and more.
		 *
		 * Each item is inside a <span>, linked if not the current page.
		 * Separator icon is inserted between items.
		 *
		 * @param string $icon Separator icon HTML.
		 * @return string Breadcrumb HTML.
		 */
		public function crafto_breadcrumb( $icon ) {
			$items = [];

			$items[] = [
				'title' => esc_html__( 'Home', 'crafto-addons' ),
				'url'   => home_url( '/' ),
			];

			if ( function_exists( 'is_woocommerce_activated' ) && is_woocommerce_activated() ) {

				if ( is_shop() ) {
					$shop_id = wc_get_page_id( 'shop' );
					if ( $shop_id && get_post_status( $shop_id ) === 'publish' ) {
						$items[] = [
							'title' => get_the_title( $shop_id ),
							'url'   => '',
						];
					}
				}

				if ( is_product_category() ) {
					$shop_id = wc_get_page_id( 'shop' );
					if ( $shop_id && get_post_status( $shop_id ) === 'publish' ) {
						$items[] = [
							'title' => get_the_title( $shop_id ),
							'url'   => get_permalink( $shop_id ),
						];
					}
					$term = get_queried_object();
					if ( $term && ! is_wp_error( $term ) ) {
						$ancestors = get_ancestors( $term->term_id, 'product_cat' );
						$ancestors = array_reverse( $ancestors );
						foreach ( $ancestors as $ancestor_id ) {
							$ancestor = get_term( $ancestor_id, 'product_cat' );
							$items[] = [
								'title' => $ancestor->name,
								'url'   => get_term_link( $ancestor ),
							];
						}
						$items[] = [
							'title' => $term->name,
							'url'   => '',
						];
					}
				}

				if ( is_product() ) {
					$shop_id = wc_get_page_id( 'shop' );
					if ( $shop_id && get_post_status( $shop_id ) === 'publish' ) {
						$items[] = [
							'title' => get_the_title( $shop_id ),
							'url'   => get_permalink( $shop_id ),
						];
					}
					global $post;
					$product_cats = wp_get_post_terms( $post->ID, 'product_cat' );
					if ( ! empty( $product_cats ) && ! is_wp_error( $product_cats ) ) {
						$main_cat  = $product_cats[0];
						$ancestors = get_ancestors( $main_cat->term_id, 'product_cat' );
						$ancestors = array_reverse( $ancestors );
						foreach ( $ancestors as $ancestor_id ) {
							$ancestor = get_term( $ancestor_id, 'product_cat' );
							$items[] = [
								'title' => $ancestor->name,
								'url'   => get_term_link( $ancestor ),
							];
						}
						$items[] = [
							'title' => $main_cat->name,
							'url'   => get_term_link( $main_cat ),
						];
					}
					$items[] = [
						'title' => get_the_title(),
						'url'   => '',
					];
				}
			}

			if ( is_archive() || is_search() || is_404() ) {

				if ( is_home() ) {
					$items[] = [
						'title' => get_the_title( get_option( 'page_for_posts' ) ),
						'url'   => '',
					];
				} elseif ( is_post_type_archive() ) {
					$obj = get_post_type_object( get_post_type() );
					if ( $obj ) {
						$items[] = [
							'title' => $obj->labels->name,
							'url'   => '',
						];
					}
				} elseif ( is_category() || is_tag() || is_tax() ) {
					$term = get_queried_object();
					if ( $term && ! is_wp_error( $term ) ) {
						$ancestors = get_ancestors( $term->term_id, $term->taxonomy );
						$ancestors = array_reverse( $ancestors );
						foreach ( $ancestors as $ancestor_id ) {
							$ancestor = get_term( $ancestor_id, $term->taxonomy );
							$items[] = [
								'title' => $ancestor->name,
								'url'   => get_term_link( $ancestor ),
							];
						}
						$items[] = [
							'title' => $term->name,
							'url'   => '',
						];
					}
				} elseif ( is_search() ) {
					$items[] = [
						'title' => esc_html__( 'Search results for: ', 'crafto-addons' ) . get_search_query(),
						'url'   => '',
					];
				} elseif ( is_404() ) {
					$items[] = [
						'title' => esc_html__( '404 Not Found', 'crafto-addons' ),
						'url'   => '',
					];
				}
			}

			if ( is_singular( 'page' ) ) {
				$seen_titles = wp_list_pluck( $items, 'title' );
				$ancestors   = get_post_ancestors( get_the_ID() );
				$ancestors   = array_reverse( $ancestors );
				foreach ( $ancestors as $ancestor_id ) {
					$title = get_the_title( $ancestor_id );
					if ( in_array( $title, $seen_titles, true ) ) {
						continue;
					}
					$items[] = [
						'title' => $title,
						'url'   => get_permalink( $ancestor_id ),
					];
					$seen_titles[] = $title;
				}
			}

			if ( is_singular() && ! is_page() ) {
				$post_type = get_post_type();
				$obj       = get_post_type_object( $post_type );

				if ( $obj && $obj->has_archive ) {
					$archive_title = $obj->labels->name;
					$archive_link  = get_post_type_archive_link( $post_type );

					$already_added = false;
					foreach ( $items as $item ) {
						if ( $item['title'] === $archive_title || $item['url'] === $archive_link ) {
							$already_added = true;
							break;
						}
					}

					if ( ! $already_added ) {
						$items[] = [
							'title' => $archive_title,
							'url'   => $archive_link,
						];
					}
				} else {
					$taxonomies = get_object_taxonomies( $post_type );
					if ( ! empty( $taxonomies ) ) {
						foreach ( $taxonomies as $taxonomy ) {
							$terms = get_the_terms( get_the_ID(), $taxonomy );
							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
								$main_term = $terms[0];
								$ancestors = get_ancestors( $main_term->term_id, $taxonomy );
								$ancestors = array_reverse( $ancestors );

								foreach ( $ancestors as $ancestor_id ) {
									$ancestor = get_term( $ancestor_id, $taxonomy );
									$items[] = [
										'title' => $ancestor->name,
										'url'   => get_term_link( $ancestor ),
									];
								}

								$items[] = [
									'title' => $main_term->name,
									'url'   => get_term_link( $main_term ),
								];
								break;
							}
						}
					}
				}
			}

			if ( is_singular() ) {
				$ancestors = get_post_ancestors( get_the_ID() );
				$ancestors = array_reverse( $ancestors );
				foreach ( $ancestors as $ancestor_id ) {
					$items[] = [
						'title' => get_the_title( $ancestor_id ),
						'url'   => get_permalink( $ancestor_id ),
					];
				}
				$items[] = [
					'title' => get_the_title(),
					'url'   => '',
				];
			}

			$seen_titles = [];

			$items = array_filter( $items, function( $item ) use ( &$seen_titles ) {
					if ( in_array( $item['title'], $seen_titles, true ) ) {
						return false;
					}
					$seen_titles[] = $item['title'];
					return true;
				}
			);
			return $this->build_breadcrumb_output( $items, $icon );
		}

		/**
		 * Generates HTML for breadcrumb items with optional separator icon.
		 *
		 * @param array  $items Breadcrumb items.
		 * @param string $icon  Separator icon HTML.
		 * @return string       Breadcrumb HTML output.
		 */
		private function build_breadcrumb_output( $items, $icon ) {
			$output     = '';
			$last_index = count( $items ) - 1;

			foreach ( $items as $index => $item ) {
				if ( $index > 0 ) {
					$output .= '<span class="breadcrumb-separator">' . $icon . '</span>';
				}

				if ( ! empty( $item['url'] ) && $index !== $last_index ) {
					$output .= '<span><a href="' . esc_url( $item['url'] ) . '">' . esc_html( $item['title'] ) . '</a></span>';
				} else {
					$output .= '<span class="breadcrumb_last">' . esc_html( $item['title'] ) . '</span>';
				}
			}
			return $output;
		}
	}
}
