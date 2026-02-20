<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for post meta.
 *
 * @package Crafto
 */

// If class `Post_Meta` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Meta' ) ) {
	/**
	 * Define `Post_Meta` class.
	 */
	class Post_Meta extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-meta';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Meta', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-meta-data crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-meta/';
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
				'post',
				'taxonomy',
				'tag',
				'author',
				'term',
				'category',
				'blog',
				'single',
				'meta',
			];
		}

		/**
		 * Register post meta widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_post_meta',
				[
					'label' => esc_html__( 'Meta', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'In Preview, post meta details are dummy, while the original post meta information is retrieved from the relevant post.', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_post_meta_type',
				[
					'label'   => esc_html__( 'Post Meta', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'author',
					'options' => [
						'author'        => esc_html__( 'Author', 'crafto-addons' ),
						'date'          => esc_html__( 'Date', 'crafto-addons' ),
						'time'          => esc_html__( 'Time', 'crafto-addons' ),
						'terms'         => esc_html__( 'Terms', 'crafto-addons' ),
						'comment-count' => esc_html__( 'Comment', 'crafto-addons' ),
					],
				]
			);
			$repeater->add_control(
				'crafto_post_meta_before',
				[
					'label'   => esc_html__( 'Before', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$repeater->add_control(
				'crafto_post_meta_after',
				[
					'label'   => esc_html__( 'After', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$repeater->add_responsive_control(
				'crafto_author_display',
				[
					'label'     => esc_html__( 'Display Type', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'name',
					'options'   => [
						'name'   => esc_html__( 'Name', 'crafto-addons' ),
						'both'   => esc_html__( 'Avatar & Name', 'crafto-addons' ),
						'avatar' => esc_html__( 'Avatar', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_post_meta_type' => 'author',
					],
				]
			);
			$repeater->add_control(
				'crafto_date_format',
				[
					'label'     => esc_html__( 'Date Format', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => [
						'default' => 'Default',
						'0'       => _x( 'March 6, 2018 (F j, Y)', 'Date Format', 'crafto-addons' ),
						'1'       => '2018-03-06 (Y-m-d)',
						'2'       => '03/06/2018 (m/d/Y)',
						'3'       => '06/03/2018 (d/m/Y)',
						'custom'  => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_post_meta_type' => 'date',
					],
				]
			);
			$repeater->add_control(
				'crafto_custom_date_format',
				[
					'label'       => esc_html__( 'Custom Date Format', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'F j, Y',
					'condition'   => [
						'crafto_post_meta_type' => 'date',
						'crafto_date_format'    => 'custom',
					],
					'description' => sprintf(
						'%1$s <a target="_blank" href="%2$s" rel="noopener noreferrer">%3$s</a> %4$s',
						esc_html__( 'Date format should be like F j, Y', 'crafto-addons' ),
						esc_url( 'https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples' ),
						esc_html__( 'click here', 'crafto-addons' ),
						esc_html__( 'to see other date formats.', 'crafto-addons' )
					),
				]
			);
			$repeater->add_control(
				'crafto_time_format',
				[
					'label'     => esc_html__( 'Time Format', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => [
						'default' => 'Default',
						'0'       => '3:31 pm (g:i a)',
						'1'       => '3:31 PM (g:i A)',
						'2'       => '15:31 (H:i)',
						'custom'  => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_post_meta_type' => 'time',
					],
				]
			);
			$repeater->add_control(
				'crafto_custom_time_format',
				[
					'label'       => esc_html__( 'Custom Time Format', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'g:i a',
					'placeholder' => 'g:i a',
					'condition'   => [
						'crafto_post_meta_type' => 'time',
						'crafto_time_format'    => 'custom',
					],
					'description' => sprintf(
						/* translators: %s: Allowed time letters (see: http://php.net/manual/en/function.time.php). */
						__( 'Use the letters: %s', 'crafto-addons' ),
						'g G H i a A'
					),
				]
			);
			$repeater->add_control(
				'crafto_taxonomy',
				[
					'label'       => esc_html__( 'Taxonomy', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'default'     => [],
					'options'     => $this->get_taxonomies(),
					'condition'   => [
						'crafto_post_meta_type' => 'terms',
					],
				]
			);
			$repeater->add_control(
				'crafto_icon_type',
				[
					'label'   => esc_html__( 'Icon Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'custom'  => esc_html__( 'Custom', 'crafto-addons' ),
					],
				]
			);
			$repeater->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'conditions'       => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_post_meta_type',
										'operator' => '===',
										'value'    => 'date',
									],
									[
										'name'     => 'crafto_icon_type',
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_post_meta_type',
										'operator' => '===',
										'value'    => 'time',
									],
									[
										'name'     => 'crafto_icon_type',
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_post_meta_type',
										'operator' => '===',
										'value'    => 'terms',
									],
									[
										'name'     => 'crafto_icon_type',
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_post_meta_type',
										'operator' => '===',
										'value'    => 'category',
									],
									[
										'name'     => 'crafto_icon_type',
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_post_meta_type',
										'operator' => '===',
										'value'    => 'tags',
									],
									[
										'name'     => 'crafto_icon_type',
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_post_meta_type',
										'operator' => '===',
										'value'    => 'comment-count',
									],
									[
										'name'     => 'crafto_icon_type',
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_post_meta_type',
										'operator' => '===',
										'value'    => 'author',
									],
									[
										'name'     => 'crafto_author_display',
										'operator' => '===',
										'value'    => 'name',
									],
									[
										'name'     => 'crafto_icon_type',
										'operator' => '===',
										'value'    => 'custom',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_post_meta_type_obj',
				[
					'label'         => esc_html__( 'Post Meta Items', 'crafto-addons' ),
					'type'          => Controls_Manager::REPEATER,
					'show_label'    => false,
					'fields'        => $repeater->get_controls(),
					'default'       => [
						[
							'crafto_post_meta_type' => 'author',
						],
					],
					'title_field'   => '<span style="text-transform: capitalize">{{{ crafto_post_meta_type }}}</span>',
					'prevent_empty' => false,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_post_meta_list_style_section',
				[
					'label' => esc_html__( 'List', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				],
			);
			$this->add_responsive_control(
				'crafto_space_between',
				[
					'label'      => esc_html__( 'margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-single-post-meta ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_icon_style_section',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_size',
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
							'max' => 200,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} i'   => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_title_style_section',
				[
					'label' => esc_html__( 'Post Meta', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				],
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .crafto-single-post-meta a, {{WRAPPER}} .post-meta-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_post_meta_title_tab'
			);
			$this->start_controls_tab(
				'crafto_post_meta_title_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-single-post-meta a, {{WRAPPER}} .post-meta-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_post_meta_title_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-single-post-meta a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_indent',
				[
					'label'      => esc_html__( 'Indent', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-single-post-meta ul li i' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .crafto-single-post-meta ul li i' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_before_style_section',
				[
					'label' => esc_html__( 'Before', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_text_before_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .text-before',
				]
			);
			$this->add_control(
				'crafto_text_before_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .text-before' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_after_style_section',
				[
					'label' => esc_html__( 'After', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_text_after_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .text-after',
				]
			);
			$this->add_control(
				'crafto_text_after_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .text-after' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post meta widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$crafto_author     = '';
			$crafto_author_url = '';
			$crafto_author_img = '';
			$crafto_author_alt = '';
			$settings          = $this->get_settings_for_display();
			$crafto_author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
			$crafto_author     = get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) );
			$crafto_author_alt = get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) ) ? get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) ) : esc_html__( 'Author', 'crafto-addons' );
			$crafto_author_img = get_avatar( get_the_author_meta( 'ID' ), '30', '', $crafto_author_alt );

			if ( ! empty( $settings['crafto_post_meta_type_obj'] ) ) {
				?>
				<div class="crafto-single-post-meta">
					<ul class="crafto-post-details-meta">
						<?php
						foreach ( $settings['crafto_post_meta_type_obj'] as $item ) {

							$migrated                  = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
							$is_new                    = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
							$crafto_post_meta_type     = ! empty( $item['crafto_post_meta_type'] ) && isset( $item['crafto_post_meta_type'] ) ? $item['crafto_post_meta_type'] : '';
							$crafto_post_meta_before   = ! empty( $item['crafto_post_meta_before'] ) && isset( $item['crafto_post_meta_before'] ) ? $item['crafto_post_meta_before'] : '';
							$crafto_post_meta_after    = ! empty( $item['crafto_post_meta_after'] ) && isset( $item['crafto_post_meta_after'] ) ? $item['crafto_post_meta_after'] : '';
							$crafto_author_display     = ! empty( $item['crafto_author_display'] ) && isset( $item['crafto_author_display'] ) ? $item['crafto_author_display'] : '';
							$crafto_custom_date_format = ! empty( $item['crafto_custom_date_format'] ) && isset( $item['crafto_custom_date_format'] ) ? $item['crafto_custom_date_format'] : '';
							$crafto_custom_time_format = ! empty( $item['crafto_custom_time_format'] ) && isset( $item['crafto_custom_time_format'] ) ? $item['crafto_custom_time_format'] : '';
							$crafto_icon_type          = ! empty( $item['crafto_icon_type'] ) && isset( $item['crafto_icon_type'] ) ? $item['crafto_icon_type'] : '';

							$crafto_icon = '';
							if ( $is_new || $migrated ) {
								ob_start();
								Icons_Manager::render_icon( $item['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
								$crafto_icon .= ob_get_clean();
							} elseif ( isset( $item['crafto_selected_icon']['value'] ) && ! empty( $item['crafto_selected_icon']['value'] ) ) {
								ob_start();
								?>
								<i class="<?php echo esc_attr( $item['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
								<?php
								$crafto_icon .= ob_get_clean();
							}

							$before_txt = ( $crafto_post_meta_before ) ? '<span class="text-before">' . esc_html( $crafto_post_meta_before ) . '</span>' : '';
							$after_txt  = ( $crafto_post_meta_before ) ? '<span class="text-after">' . esc_html( $crafto_post_meta_after ) . '</span>' : '';
							?>
							<li>
								<?php
								switch ( $crafto_post_meta_type ) {
									case 'author':
									default:
										switch ( $crafto_author_display ) {
											case 'name':
												if ( 'custom' === $crafto_icon_type ) {
													echo sprintf( '%s', $crafto_icon ); // phpcs:ignore
												} else {
													?>
													<i class="feather icon-feather-user"></i>
													<?php
												}
												echo sprintf( '%s', $before_txt ); // phpcs:ignore
												?>												
												<a href="<?php echo esc_url( $crafto_author_url ); ?>"><?php echo esc_html( $crafto_author ); ?></a>
												<?php
												echo sprintf( '%s', $after_txt ); // phpcs:ignore
												break;
											case 'both':
												?>
												<a href="<?php echo esc_url( $crafto_author_url ); ?>">
												<?php
												if ( ! empty( $crafto_author_img ) ) {
													?>
													<span class="crafto-author-avatar"><?php echo $crafto_author_img; // phpcs:ignore ?></span>
													<?php
												} else {
													?>
													<span class="crafto-author-avatar">
														<img src="<?php echo Utils::get_placeholder_image_src(); // phpcs:ignore ?>" alt="<?php echo esc_attr__( 'author', 'crafto-addons' ); ?>">
														</span>
													<?php
												}
												?>
												</a>
												<?php
												echo sprintf( '%s', $before_txt ); // phpcs:ignore
												?>
												<a href="<?php echo esc_url( $crafto_author_url ); ?>"><?php echo esc_html( $crafto_author ); ?></a>
												<?php
												echo sprintf( '%s', $after_txt ); // phpcs:ignore
												break;
											case 'avatar':
												echo sprintf( '%s', $before_txt ); // phpcs:ignore

												if ( ! empty( $crafto_author_img ) ) {
													?>
													<span class="crafto-author-avatar"><?php echo $crafto_author_img; // phpcs:ignore ?></span>
													<?php
												} else {
													?>
													<span class="crafto-author-avatar">
														<img src="<?php echo Utils::get_placeholder_image_src(); // phpcs:ignore ?>" alt="<?php echo esc_attr__( 'author', 'crafto-addons' ); ?>">
													</span>
													<?php
												}
												echo sprintf( '%s', $after_txt ); // phpcs:ignore
												break;
										}
										break;
									case 'date':
										if ( 'custom' === $crafto_icon_type ) {
											echo sprintf( '%s', $crafto_icon ); // phpcs:ignore
										} else {
											?>
											<i class="feather icon-feather-calendar"></i>
											<?php
										}

										$crafto_custom_date_format = empty( $item['crafto_custom_date_format'] ) ? 'F j, Y' : $item['crafto_custom_date_format'];

										$format_options = [
											'default' => 'F j, Y',
											'0'       => 'F j, Y',
											'1'       => 'Y-m-d',
											'2'       => 'm/d/Y',
											'3'       => 'd/m/Y',
											'custom'  => $crafto_custom_date_format,
										];

										$item['text'] = get_the_time( $format_options[ $item['crafto_date_format'] ] );

										echo sprintf( '%s', $before_txt ); // phpcs:ignore
										?>
										<span class="post-meta-title"><?php echo get_the_time( $format_options[ $item['crafto_date_format'] ] ); // phpcs:ignore ?></span>
										<?php
										echo sprintf( '%s', $after_txt ); // phpcs:ignore
										break;
									case 'time':
										if ( 'custom' === $crafto_icon_type ) {
											echo sprintf( '%s', $crafto_icon ); // phpcs:ignore
										} else {
											?>
											<i class="feather icon-feather-clock"></i>
											<?php
										}

										$crafto_custom_time_format = empty( $item['crafto_custom_time_format'] ) ? 'g:i a' : $item['crafto_custom_time_format'];

										$format_options    = [
											'default' => 'g:i a',
											'0'       => 'g:i a',
											'1'       => 'g:i A',
											'2'       => 'H:i',
											'custom'  => $crafto_custom_time_format,
										];
										$item_data['text'] = get_the_time( $format_options[ $item['crafto_time_format'] ] );

										echo sprintf( '%s', $before_txt ); // phpcs:ignore
										?>
										<span class="post-meta-title"><?php echo get_the_time( $format_options[ $item['crafto_time_format'] ] ); // phpcs:ignore ?></span>
										<?php
										echo sprintf( '%s', $after_txt ); // phpcs:ignore
										break;
									case 'terms':
										if ( 'custom' === $crafto_icon_type ) {
											echo sprintf( '%s', $crafto_icon ); // phpcs:ignore
										} else {
											?>
											<i class="feather icon-feather-box"></i>
											<?php
										}
										$item['itemprop'] = 'about';
										$taxonomy         = $item['crafto_taxonomy'];

										echo sprintf( '%s', $before_txt ); // phpcs:ignore
										?>
										<span class="post-meta-title">
											<?php
											if ( crafto_is_editor_mode() ) { // phpcs:ignore
												echo esc_html__( 'Uncategorized', 'crafto-addons' );
											} elseif ( ! empty( $taxonomy ) ) {
													$terms_arr = array();
													$terms     = wp_get_post_terms( get_the_ID(), $taxonomy );
												if ( ! empty( $terms ) ) {
													foreach ( $terms as $term ) {
															$terms_arr[] = $term->name;
													}
														$terms_str = implode( ', ', $terms_arr );

														echo $terms_str; // phpcs:ignore
												}
											} else {
													$terms_arr = array();
												foreach ( ( get_the_category() ) as $category ) {
														echo $category->cat_name . ', '; // phpcs:ignore;
														$terms_arr[] = $category->cat_name;
												}
													$terms_str = implode( ', ', $terms_arr );
													echo $terms_str; // phpcs:ignore
											}
											?>
										</span>
										<?php
										echo sprintf( '%s', $after_txt ); // phpcs:ignore
										break;
									case 'comment-count':
										?>
										<span class="crafto-comment-count">
											<?php
											if ( 'custom' === $crafto_icon_type ) {
												echo sprintf( '%s', $crafto_icon ); // phpcs:ignore
											} else {
												?>
												<i class="fa-regular fa-comment"></i>
												<?php
											}
											echo sprintf( '%s', $before_txt ); // phpcs:ignore
											?>
											<span class="post-meta-title">
												<span class="comment-count">0 </span><span class="comment-text"><?php echo esc_html__( 'Comment', 'crafto-addons' ); ?></span>
											</span>
											<?php
											echo sprintf( '%s', $after_txt ); // phpcs:ignore
											?>
										</span>
										<?php
										break;
								}
								?>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php
			}
		}
		/**
		 * Return get taxonomies.
		 *
		 * @access protected
		 */
		protected function get_taxonomies() {
			$taxonomies = get_taxonomies(
				[
					'show_in_nav_menus' => true,
				],
				'objects'
			);

			$options = [
				'' => esc_html__( 'Choose', 'crafto-addons' ),
			];

			foreach ( $taxonomies as $taxonomy ) {
				$options[ $taxonomy->name ] = $taxonomy->label;
			}

			return $options;
		}
	}
}
