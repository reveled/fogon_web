<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for Minimal Portfolio.
 *
 * @package Crafto
 */

// If class `Minimal_Portfolio` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Minimal_Portfolio' ) ) {
	/**
	 * Define `Minimal_Portfolio` class.
	 */
	class Minimal_Portfolio extends Widget_Base {
		/**
		 * Retrieve the list of scripts the Minimal Portfolio widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$minimal_portfolio_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$minimal_portfolio_scripts[] = 'crafto-widgets';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					$minimal_portfolio_scripts[] = 'anime';
				}
				$minimal_portfolio_scripts[] = 'crafto-minimal-portfolio';
			}
			return $minimal_portfolio_scripts;
		}

		/**
		 * Retrieve the list of styles the crafto Minimal Portfolio depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @since 1.3.0
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$minimal_portfolio_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$minimal_portfolio_styles[] = 'crafto-widgets-rtl';
				} else {
					$minimal_portfolio_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$minimal_portfolio_styles[] = 'crafto-minimal-portfolio-rtl';
				}
				$minimal_portfolio_styles[] = 'crafto-minimal-portfolio';
			}
			return $minimal_portfolio_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-minimal-portfolio';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Minimal Portfolio', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-posts-grid crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/minimal-portfolio/';
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
		 * Get widget keywords.
		 *
		 * Retrieve the list of keywords the widget belongs to.
		 *
		 * @access public
		 *
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'image',
				'projects',
				'portfolio',
				'work showcase',
				'minimal design',
			];
		}

		/**
		 * Register Minimal Portfolio widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_minimal_portfolio_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),

				]
			);
			$this->add_control(
				'crafto_portfolio_orderby',
				[
					'label'   => esc_html__( 'Order By', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'date',
					'options' => [
						'date'          => esc_html__( 'Date', 'crafto-addons' ),
						'ID'            => esc_html__( 'ID', 'crafto-addons' ),
						'author'        => esc_html__( 'Author', 'crafto-addons' ),
						'title'         => esc_html__( 'Title', 'crafto-addons' ),
						'modified'      => esc_html__( 'Modified', 'crafto-addons' ),
						'rand'          => esc_html__( 'Random', 'crafto-addons' ),
						'comment_count' => esc_html__( 'Comment count', 'crafto-addons' ),
						'menu_order'    => esc_html__( 'Menu order', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_order',
				[
					'label'   => esc_html__( 'Sort By', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'DESC',
					'options' => [
						'DESC' => esc_html__( 'Descending', 'crafto-addons' ),
						'ASC'  => esc_html__( 'Ascending', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_type_selection',
				[
					'label'   => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'portfolio-category',
					'options' => [
						'portfolio-category' => esc_html__( 'Category', 'crafto-addons' ),
						'portfolio-tags'     => esc_html__( 'Tags', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_categories_list',
				[
					'label'       => esc_html__( 'Categories', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'portfolio-category' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_portfolio_type_selection' => 'portfolio-category',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_tags_list',
				[
					'label'       => esc_html__( 'Tags', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_tags_list' ) ? crafto_get_tags_list( 'portfolio-tags' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_portfolio_type_selection' => 'portfolio-tags',
					],
				]
			);
			$this->add_control(
				'crafto_include_exclude_post_ids',
				[
					'label'   => esc_html__( 'Include/Exclude', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'include',
					'options' => [
						'include' => esc_html__( 'Include', 'crafto-addons' ),
						'exclude' => esc_html__( 'Exclude', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_include_portfolio_ids',
				[
					'label'       => esc_html__( 'Include Portfolio', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_portfolio_array' ) ? crafto_get_portfolio_array() : [],
					'description' => esc_html__( 'You can use this option to add certain portfolios from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'include',
					],
				]
			);
			$this->add_control(
				'crafto_exclude_portfolio_ids',
				[
					'label'       => esc_html__( 'Exclude Portfolio', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_portfolio_array' ) ? crafto_get_portfolio_array() : [],
					'description' => esc_html__( 'You can use this option to remove certain portfolios from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'exclude',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_post_per_page',
				[
					'label'   => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 8,
				]
			);
			$this->add_control(
				'crafto_minimal_portfolio_offset',
				[
					'label'   => esc_html__( 'Offset', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
				]
			);
			$this->add_control(
				'crafto_portfolio_show_post_subtitle',
				[
					'label'        => esc_html__( 'Enable Subtitle', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_section_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_padding',
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
						'{{WRAPPER}} .portfolio-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_margin',
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
						'{{WRAPPER}} .portfolio-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_section_title_style',
				[
					'label'      => esc_html__( 'Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_portfolio_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .portfolio-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_portfolio_title_tabs',
			);
				$this->start_controls_tab(
					'crafto_portfolio_title_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'           => 'crafto_portfolio_title_color',
						'selector'       => '{{WRAPPER}} .portfolio-title',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Color', 'crafto-addons' ),
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_portfolio_title_padding',
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
							'{{WRAPPER}} .portfolio-minimal-wrapper .portfolio-item .portfolio-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
			$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_portfolio_title_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_portfolio_title_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .portfolio-title:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_portfolio_title_hover_padding',
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
							'{{WRAPPER}} .portfolio-item:hover .portfolio-title, {{WRAPPER}} .portfolio-item.active .portfolio-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_portfolio_hover_title',
				[
					'label'     => esc_html__( 'Hover Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_portfolio_hover_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .hover-title',
				]
			);
			$this->add_control(
				'crafto_portfolio_hover_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .hover-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portfolio_section_subtitle_style',
				[
					'label'      => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_show_post_subtitle' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_portfolio_subtitle_typography',
					'selector' => '{{WRAPPER}} .portfolio-minimal-wrapper .subtitle',
				]
			);
			$this->add_control(
				'crafto_portfolio_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .portfolio-minimal-wrapper .subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}


		/**
		 * Render Minimal Portfolio widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                        = $this->get_settings_for_display();
			$crafto_include_portfolio_ids    = $this->get_settings( 'crafto_include_portfolio_ids' );
			$crafto_exclude_portfolio_ids    = $this->get_settings( 'crafto_exclude_portfolio_ids' );
			$portfolio_type_selection        = ( isset( $settings['crafto_portfolio_type_selection'] ) && $settings['crafto_portfolio_type_selection'] ) ? $settings['crafto_portfolio_type_selection'] : 'portfolio-category';
			$portfolio_categories_list       = ( isset( $settings['crafto_portfolio_categories_list'] ) && $settings['crafto_portfolio_categories_list'] ) ? $settings['crafto_portfolio_categories_list'] : array();
			$portfolio_tags_list             = ( isset( $settings['crafto_portfolio_tags_list'] ) && $settings['crafto_portfolio_tags_list'] ) ? $settings['crafto_portfolio_tags_list'] : array();
			$portfolio_post_per_page         = ( isset( $settings['crafto_portfolio_post_per_page'] ) && $settings['crafto_portfolio_post_per_page'] ) ? $settings['crafto_portfolio_post_per_page'] : -1;
			$crafto_minimal_portfolio_offset = ( isset( $settings['crafto_minimal_portfolio_offset'] ) && $settings['crafto_minimal_portfolio_offset'] ) ? $settings['crafto_minimal_portfolio_offset'] : '';
			$portfolio_show_post_subtitle    = ( isset( $settings['crafto_portfolio_show_post_subtitle'] ) && $settings['crafto_portfolio_show_post_subtitle'] ) ? $settings['crafto_portfolio_show_post_subtitle'] : '';
			$portfolio_orderby               = ( isset( $settings['crafto_portfolio_orderby'] ) && $settings['crafto_portfolio_orderby'] ) ? $settings['crafto_portfolio_orderby'] : '';
			$portfolio_order                 = ( isset( $settings['crafto_portfolio_order'] ) && $settings['crafto_portfolio_order'] ) ? $settings['crafto_portfolio_order'] : '';
			if ( 'portfolio-tags' === $portfolio_type_selection ) {
				$categories_to_display_ids = ( ! empty( $portfolio_tags_list ) ) ? $portfolio_tags_list : array();
			} else {
				$categories_to_display_ids = ( ! empty( $portfolio_categories_list ) ) ? $portfolio_categories_list : array();
			}

			// If no categories are chosen or "All categories", we need to load all available categories.
			if ( ! is_array( $categories_to_display_ids ) || count( $categories_to_display_ids ) === 0 ) {

				$terms = get_terms( $portfolio_type_selection );

				if ( ! is_array( $categories_to_display_ids ) ) {
					$categories_to_display_ids = array();
				}
				foreach ( $terms as $term ) {
					$categories_to_display_ids[] = $term->slug;
				}
			} else {
				$categories_to_display_ids = array_values( $categories_to_display_ids );
			}

			$query_args = array(
				'post_type'      => 'portfolio',
				'post_status'    => 'publish',
				'posts_per_page' => intval( $portfolio_post_per_page ), // phpcs:ignore
				'no_found_rows'  => true,
			);

			if ( ! empty( $crafto_minimal_portfolio_offset ) ) {
				$query_args['offset'] = $crafto_minimal_portfolio_offset;
			}

			if ( ! empty( $categories_to_display_ids ) ) {
				$query_args['tax_query'] = [ // phpcs:ignore
					[
						'taxonomy' => $portfolio_type_selection,
						'field'    => 'slug',
						'terms'    => $categories_to_display_ids,
					],
				];
			}

			if ( ! empty( $crafto_include_portfolio_ids ) ) {
				$crafto_include_portfolio_ids = array_merge( $crafto_include_portfolio_ids );
			}

			if ( ! empty( $crafto_include_portfolio_ids ) ) {
				$query_args['post__in'] = $crafto_include_portfolio_ids;
			}

			if ( ! empty( $crafto_exclude_portfolio_ids ) ) {
				$crafto_exclude_portfolio_ids = array_merge( $crafto_exclude_portfolio_ids );
			}

			if ( ! empty( $crafto_exclude_portfolio_ids ) ) {
				$query_args['post__not_in'] = $crafto_exclude_portfolio_ids;
			}

			if ( ! empty( $portfolio_orderby ) ) {
				$query_args['orderby'] = $portfolio_orderby;
			}

			if ( ! empty( $portfolio_order ) ) {
				$query_args['order'] = $portfolio_order;
			}

			$the_query = new \WP_Query( $query_args );

			if ( $the_query->have_posts() ) {
				?>
				<div class="portfolio-minimal-wrapper">
					<nav class="portfolio-box">
						<?php
						$counter = 1;
						$index   = 0;
						while ( $the_query->have_posts() ) :
							$the_query->the_post();

							$unique_id             = 'distortion-filter' . $index;
							$inner_wrap_key        = 'inner_wrap_' . $index;
							$custom_link_key       = 'custom_link_' . $index;
							$custom_link_key       = 'custom_link_' . $index;
							$crafto_subtitle       = crafto_post_meta( 'crafto_subtitle' );
							$has_post_format       = crafto_post_meta( 'crafto_portfolio_post_type' );
							$portfolio_link_target = crafto_post_meta( 'crafto_portfolio_link_target' );
							$color                 = crafto_post_meta( 'crafto_single_portfolio_item_hover_color' );

							if ( 'link' === $has_post_format || has_post_format( 'link', get_the_ID() ) ) {
								$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_external_link' );
								$portfolio_link_target   = crafto_post_meta( 'crafto_portfolio_link_target' );
								$portfolio_external_link = ( ! empty( $portfolio_external_link ) ) ? $portfolio_external_link : '#';
								$portfolio_link_target   = ( ! empty( $portfolio_link_target ) ) ? $portfolio_link_target : '_self';
							} elseif ( 'video' === $has_post_format || has_post_format( 'video', get_the_ID() ) ) {
								$portfolio_video_type = crafto_post_meta( 'crafto_portfolio_video_type' );
								if ( 'self' === $portfolio_video_type ) {
									$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_video_mp4' );
								} else {
									$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_external_video' );
								}
							} else {
								$portfolio_external_link = get_permalink();
								$portfolio_link_target   = '_self';
							}

							$this->add_render_attribute(
								$custom_link_key,
								[
									'class'  => [
										'menu-item-text',
									],
									'href'   => $portfolio_external_link,
									'target' => $portfolio_link_target,
								],
							);

							$crafto_subtitle = ( $crafto_subtitle ) ? str_replace( '||', '<br />', $crafto_subtitle ) : '';

							if ( has_post_thumbnail() ) {
								$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
							} else {
								$featured_img_url = Utils::get_placeholder_image_src();
							}

							$this->add_render_attribute(
								'portfolio_image',
								[
									'class' => [
										'hover-reveal-img',
									],
								],
							);
							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class'    => [
										'portfolio-item',
									],
									'data-img' => esc_url( $featured_img_url ),
								],
							);
							if ( 0 === $index ) {
								$this->add_render_attribute(
									$inner_wrap_key,
									[
										'class' => [
											'active',
										],
									],
								);
							}
							if ( '' !== $color ) {
								$this->add_render_attribute(
									$inner_wrap_key,
									[
										'data-bg' => $color,
									],
								);
							}
							?>
							<div <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
								<div class="portfolio-title-wrapper">
									<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
										<div class="portfolio-title"><?php the_title(); ?></div>
									</a>
									<?php
									if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
										?>
										<span class="subtitle">
											<span>
												<?php echo esc_html( $crafto_subtitle ); ?>
											</span>
										</span>
										<?php
									}
									?>
									<div class="hover-title">
										<?php the_title(); ?>
									</div>
								</div>
								<?php

								if ( ! empty( $featured_img_url ) ) {
									?>
									<div class="svg-wrapper">
										<svg class="distort" width="960" height="980" viewBox="0 0 960 980">
											<filter id="<?php echo esc_attr( $unique_id ); ?>">
												<feTurbulence type="fractalNoise" baseFrequency="0.01 0.003" numOctaves="5" seed="2" stitchTiles="noStitch" x="0%" y="0%" width="100%" height="100%" result="noise"></feTurbulence>
												<feDisplacementMap in="SourceGraphic" in2="noise" scale="0.3" xChannelSelector="R" yChannelSelector="B" x="0%" y="0%" width="100%" height="100%" filterUnits="userSpaceOnUse"></feDisplacementMap>
											</filter>
											<g filter="url(#<?php echo esc_attr( $unique_id ); ?>)">
												<image class="distort__img" x="80" y="0" xlink:href="<?php echo esc_url( $featured_img_url ); ?>" height="980" width="960"></image>
											</g>
										</svg>
									</div>
								</div>
									<?php
								}
								++$index;
								++$counter;
						endwhile;

						wp_reset_postdata();
						?>
					</nav>
				</div>
				<?php
			}
		}
	}
}
