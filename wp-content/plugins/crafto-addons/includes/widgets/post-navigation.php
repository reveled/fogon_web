<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for post navigation.
 *
 * @package Crafto
 */

// If class `Post_Navigation` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Navigation' ) ) {
	/**
	 * Define `Post_Navigation` class.
	 */
	class Post_Navigation extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-navigation';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Navigation', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-navigation crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-navigation/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return array Widget categories.
		 */
		public function get_categories() {
			return [
				'crafto-single',
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
				'prev',
				'next',
				'pagination',
				'link',
			];
		}

		/**
		 * Render post navigation widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_post_navigation_content',
				[
					'label' => esc_html__( 'Post Navigation', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_navigation_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'style-1',
					'options' => [
						'style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_post_type_source',
				[
					'label'   => esc_html__( 'Source', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'post',
					'options' => crafto_get_post_types(),
				]
			);

			$this->add_control(
				'crafto_post_navigation_type',
				[
					'label'     => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'latest',
					'options'   => [
						'latest'   => esc_html__( 'Latest', 'crafto-addons' ),
						'category' => esc_html__( 'Category', 'crafto-addons' ),
						'tag'      => esc_html__( 'Tag', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_navigation_style' => [
							'style-2',
						],
						'crafto_post_type_source' => [
							'post',
							'portfolio',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_label',
				[
					'label'        => esc_html__( 'Enable Label', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'crafto_prev_label',
				[
					'label'     => esc_html__( 'Previous Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Prev Project', 'crafto-addons' ),
					'condition' => [
						'crafto_show_label' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_prev_icon',
				[
					'label'            => esc_html__( 'Previous Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'feather icon-feather-arrow-left',
						'library' => 'feather-solid',
					],
					'recommended'      => [
						'fa-solid'   => [
							'angle-left',
							'caret-square-left',
						],
						'fa-regular' => [
							'caret-square-left',
						],
					],
					'condition'        => [
						'crafto_navigation_style' => [
							'style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_next_label',
				[
					'label'     => esc_html__( 'Next Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Next Project', 'crafto-addons' ),
					'condition' => [
						'crafto_show_label' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_next_icon',
				[
					'label'            => esc_html__( 'Next Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'feather icon-feather-arrow-right',
						'library' => 'feather-solid',
					],
					'recommended'      => [
						'fa-solid'   => [
							'angle-right',
							'caret-square-right',
						],
						'fa-regular' => [
							'caret-square-right',
						],
					],
					'condition'        => [
						'crafto_navigation_style' => [
							'style-1',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_nav_general_style_section',
				[
					'label'     => esc_html__( 'General', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_navigation_style' => [
							'style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_border_thickness_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-post-navigation' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_border_width',
				[
					'label'      => esc_html__( 'Border Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .single-post-navigation' => 'border-top-width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_nav_icon_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_navigation_style' => [
							'style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_navigation_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-nav-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .blog-nav-link i'   => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_icon_style_tabs' );
				$this->start_controls_tab(
					'crafto_icon_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-nav-link svg' => 'fill: {{VALUE}};',
						'{{WRAPPER}} .blog-nav-link i'   => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_icon_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-nav-link a:hover svg' => 'fill: {{VALUE}};',
						'{{WRAPPER}} .blog-nav-link a:hover i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_title_style_section',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_navigation_style' => [
							'style-2',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .portfolio-title',
				]
			);
			$this->start_controls_tabs( 'crafto_title_style_tabs' );
				$this->start_controls_tab(
					'crafto_title_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .portfolio-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_title_style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .fancy-box-item:hover .portfolio-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_prev_text_style_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_label' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_label_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .blog-nav-link a, {{WRAPPER}} .prev-link-text, {{WRAPPER}} .next-link-text',
				]
			);
			$this->start_controls_tabs( 'crafto_prev_text_style_tabs' );
				$this->start_controls_tab(
					'crafto_prev_text_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
			$this->add_control(
				'crafto_prev_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-nav-link a, {{WRAPPER}} .prev-link-text, {{WRAPPER}} .next-link-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_prev_text_style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_prev_text_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-nav-link a:hover, {{WRAPPER}} .fancy-box-item:hover .prev-link-text, {{WRAPPER}} .fancy-box-item:hover .next-link-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Crafto single post navigation.
		 */
		protected function render() {

			$settings                = $this->get_settings_for_display();
			$crafto_post_type_source = $this->get_settings( 'crafto_post_type_source' );
			$crafto_navigation_style = $this->get_settings( 'crafto_navigation_style' );
			$crafto_post_nav_type    = $this->get_settings( 'crafto_post_navigation_type' );
			$crafto_show_label       = $this->get_settings( 'crafto_show_label' );

			$output           = '';
			$crafto_post_prev = '';
			$crafto_post_next = '';
			$crafto_prev_icon = '';
			$crafto_next_icon = '';

			if ( 'yes' === $crafto_show_label ) {
				$crafto_post_prev  = ( isset( $settings['crafto_prev_label'] ) && ! empty( $settings['crafto_prev_label'] ) ) ? $settings['crafto_prev_label'] : esc_html__( 'Prev Post', 'crafto-addons' ); // phpcs:ignore
				$crafto_post_next  = ( isset( $settings['crafto_next_label'] ) && ! empty( $settings['crafto_next_label'] ) ) ? $settings['crafto_next_label'] : esc_html__( 'Next Post', 'crafto-addons' ); // phpcs:ignore
			}

			$is_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$migrated  = isset( $settings['__fa4_migrated']['crafto_prev_icon'] );
			$migrated1 = isset( $settings['__fa4_migrated']['crafto_next_icon'] );

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_prev_icon'], [ 'aria-hidden' => 'true' ] );
				$crafto_prev_icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_prev_icon']['value'] ) && ! empty( $settings['crafto_prev_icon']['value'] ) ) {
				$crafto_prev_icon .= '<i class="' . esc_attr( $settings['crafto_prev_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			if ( $is_new || $migrated1 ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_next_icon'], [ 'aria-hidden' => 'true' ] );
				$crafto_next_icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_next_icon']['value'] ) && ! empty( $settings['crafto_next_icon']['value'] ) ) {
				$crafto_next_icon .= '<i class="' . esc_attr( $settings['crafto_next_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			switch ( $crafto_navigation_style ) {
				case 'style-1':
				default:
					$crafto_prev_url = get_previous_post_link( '%link', $crafto_prev_icon . $crafto_post_prev ); // phpcs:ignore
					$crafto_next_url = get_next_post_link( '%link', $crafto_post_next . $crafto_next_icon ); // phpcs:ignore

					ob_start();
					// Previous Link.
					if ( ! empty( $crafto_prev_url ) ) {
						?>
						<div class="blog-nav-link blog-nav-link-prev">
							<span class="screen-reader-text"><?php echo esc_html__( 'Previous page', 'crafto-addons' ); ?></span>
							<?php printf( '%s', $crafto_prev_url ); // phpcs:ignore ?>
						</div>
						<?php
					}

					// Next Link.
					if ( ! empty( $crafto_next_url ) ) {
						?>
						<div class="blog-nav-link blog-nav-link-next">
							<span class="screen-reader-text"><?php echo esc_html__( 'Next page', 'crafto-addons' ); ?></span>
							<?php printf( '%s', $crafto_next_url ); // phpcs:ignore ?>
						</div>
						<?php
					}

					$output .= ob_get_contents();
					ob_end_clean();
					?>
					<div class="single-post-navigation">
						<?php echo sprintf( '%s', $output ); // phpcs:ignore ?>
					</div>
					<?php
					break;
				case 'style-2':
					if ( in_array( $crafto_post_type_source, [ 'post', 'portfolio' ], true ) && in_array( $crafto_post_nav_type, [ 'category', 'tag' ], true ) ) {
						$taxonomy_name = '';
						switch ( $crafto_post_type_source ) {
							case 'post':
							default:
								if ( 'category' === $crafto_post_nav_type ) {
									$taxonomy_name = 'category';
								}

								if ( 'tag' === $crafto_post_nav_type ) {
									$taxonomy_name = 'post_tag';
								}
								break;
							case 'portfolio':
								if ( 'category' === $crafto_post_nav_type ) {
									$taxonomy_name = 'portfolio-category';
								}

								if ( 'tag' === $crafto_post_nav_type ) {
									$taxonomy_name = 'portfolio-tags';
								}
								break;
						}

						$terms = get_the_terms( get_the_ID(), $taxonomy_name );

						if ( empty( $terms ) || is_wp_error( $terms ) ) {
							return;
						}

						$args = [
							'post_type'      => $crafto_post_type_source,
							'posts_per_page' => -1,
							'fields'         => 'ids',
							// phpcs:ignore
							'tax_query'      => [
								[
									'taxonomy' => $taxonomy_name,
									'terms'    => [ $terms[0]->term_id ],
									'field'    => 'term_id',
								],
							],
						];

						$post_ids = get_posts( $args );

						// Get and echo previous and next post in the same category.
						$current_index = array_search( get_the_ID(), $post_ids, true );

						if ( false !== $current_index ) {
							$nextid = $post_ids[ $current_index - 1 ] ?? '';
							$previd = $post_ids[ $current_index + 1 ] ?? '';
						}
					} else {
						$prev_post = get_previous_post();
						$next_post = get_next_post();

						$previd = $prev_post ? $prev_post->ID : '';
						$nextid = $next_post ? $next_post->ID : '';
					}

					$this->add_render_attribute(
						'nav-link-wrap',
						[
							'class' => [
								'col-md',
								'fancy-box-item',
								'px-0',
							],
						],
					);

					$this->add_render_attribute(
						'nav-link',
						[
							'class' => [
								'd-flex',
								'h-100',
								'align-items-center',
								'justify-content-center',
								'justify-content-lg-between',
								'justify-content-md-start',
							],
						],
					);
					?>
					<div class="portfolio-navigation-wrapper">
						<div class="row row-cols-1 justify-content-center">
							<?php
							if ( ! empty( $previd ) ) {
								$this->add_render_attribute(
									'nav-link-wrap',
									[
										'class' => [
											'nav-link-prev',
										],
									],
								);

								$this->add_render_attribute(
									'nav-link',
									[
										'rel'  => 'prev',
										'href' => esc_url( get_permalink( $previd ) ),
									],
								);
								?>
								<div <?php $this->print_render_attribute_string( 'nav-link-wrap' ); ?>>
									<a <?php $this->print_render_attribute_string( 'nav-link' ); ?>>
										<?php $this->crafto_get_post_thumbnail( $previd ); ?>
										<div class="next-previous-navigation">
											<span class="separator"></span>
											<span class="prev-link-text">
												<?php printf( '%s', $crafto_post_prev ); // phpcs:ignore ?>
											</span>
										</div>
										<?php $this->crafto_get_post_title( $previd ); ?>
									</a>
								</div>
								<?php
							}

							if ( ! empty( $nextid ) ) {
								$this->add_render_attribute(
									'nav-link-wrap',
									[
										'class' => [
											'nav-link-next',
										],
									],
								);
								$this->add_render_attribute(
									'nav-link',
									[
										'rel'  => 'next',
										'href' => esc_url( get_permalink( $nextid ) ),
									],
								);
								?>
								<div <?php $this->print_render_attribute_string( 'nav-link-wrap' ); ?>>
									<a <?php $this->print_render_attribute_string( 'nav-link' ); ?>>
										<?php $this->crafto_get_post_thumbnail( $nextid ); ?>
										<?php $this->crafto_get_post_title( $nextid ); ?>
										<div class="next-previous-navigation">
											<span class="next-link-text">
												<?php printf( '%s', $crafto_post_next ); // phpcs:ignore ?>
											</span>
											<span class="separator"></span>
										</div>
									</a>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
					break;
			}
		}

		/**
		 * Return post title.
		 *
		 * @param int $id Get ID.
		 * @access public
		 */
		public function crafto_get_post_title( $id ) {
			?>
			<div class="portfolio-title"><?php echo esc_html( get_the_title( $id ) ); ?></div>
			<?php
		}

		/**
		 * Return post thumbnail image.
		 *
		 * @param int $id Get ID.
		 * @access public
		 */
		public function crafto_get_post_thumbnail( $id ) {
			if ( has_post_thumbnail() ) {
				$crafto_post_post_thumbnail = get_the_post_thumbnail_url( $id );
				$crafto_post_post_thumbnail = ( ! empty( $crafto_post_post_thumbnail ) ) ? ' style="background-image: url(' . esc_url( $crafto_post_post_thumbnail ) . ');"' : '';
			} else {
				$crafto_post_post_thumbnail = ' style="background-image: url(' . esc_url( Utils::get_placeholder_image_src() ) . ');"';
			}
			?>
			<div class="cover-background"<?php echo $crafto_post_post_thumbnail; // phpcs:ignore ?>></div>
			<?php
		}
	}
}
