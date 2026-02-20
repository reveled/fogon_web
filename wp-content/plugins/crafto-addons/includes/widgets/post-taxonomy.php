<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for Post Taxonomy.
 *
 * @package Crafto
 */

// If class `Post_Taxonomy` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Taxonomy' ) ) {
	/**
	 * Define `Post_Taxonomy` class.
	 */
	class Post_Taxonomy extends Widget_Base {
		/**
		 * Retrieve the list of styles the post taxonomy widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$post_taxonomy_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$post_taxonomy_styles[] = 'crafto-widgets-rtl';
				} else {
					$post_taxonomy_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$post_taxonomy_styles[] = 'crafto-post-taxonomy-rtl-widget';
				}
				$post_taxonomy_styles[] = 'crafto-post-taxonomy-widget';
			}
			return $post_taxonomy_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-taxonomy';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Taxonomy', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/post-taxonomy/';
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
				'crafto-single',
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
		 * Register post taxonomy widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_post_taxonomy_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_post_taxonomy_styles',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'post-taxonomy-style-1',
					'options' => [
						'post-taxonomy-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'post-taxonomy-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'post-taxonomy-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'post-taxonomy-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
					],
				]
			);

			$taxonomy_source = [
				'post'      => esc_html__( 'Post', 'crafto-addons' ),
				'portfolio' => esc_html__( 'Portfolio', 'crafto-addons' ),
			];

			if ( is_woocommerce_activated() ) {
				$taxonomy_source['product'] = esc_html__( 'Product', 'crafto-addons' );
			}

			$this->add_control(
				'crafto_post_taxonomy_source',
				[
					'label'   => esc_html__( 'Source', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'post',
					'options' => $taxonomy_source,
				]
			);
			$this->add_control(
				'crafto_post_taxonomy_selection',
				[
					'label'   => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'categories',
					'options' => [
						'categories' => esc_html__( 'Categories', 'crafto-addons' ),
						'tags'       => esc_html__( 'Tags', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_taxonomy_scope',
				[
					'label'   => esc_html__( 'Taxonomy Scope', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'all',
					'options' => [
						'all'     => esc_html__( 'All', 'crafto-addons' ),
						'current' => esc_html__( 'Current', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_categories_list',
				[
					'label'       => esc_html__( 'Categories', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'category' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_post_taxonomy_selection' => 'categories',
						'crafto_post_taxonomy_source'    => 'post',
						'crafto_taxonomy_scope'          => 'all',
					],
				]
			);
			$this->add_control(
				'crafto_tags_list',
				[
					'label'       => esc_html__( 'Tags', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_tags_list' ) ? crafto_get_tags_list( 'post_tag' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_post_taxonomy_selection' => 'tags',
						'crafto_post_taxonomy_source'    => 'post',
						'crafto_taxonomy_scope'          => 'all',
					],
				]
			);

			if ( is_woocommerce_activated() ) {
				$this->add_control(
					'crafto_product_cat_list',
					[
						'label'       => esc_html__( 'Categories', 'crafto-addons' ),
						'type'        => Controls_Manager::SELECT2,
						'multiple'    => true,
						'label_block' => true,
						'options'     => $this->crafto_get_products_list(),
						'condition'   => [
							'crafto_post_taxonomy_selection' => 'categories',
							'crafto_post_taxonomy_source' => 'product',
							'crafto_taxonomy_scope'       => 'all',
						],
					]
				);
				$this->add_control(
					'crafto_product_tags_list',
					[
						'label'       => esc_html__( 'Tags', 'crafto-addons' ),
						'type'        => Controls_Manager::SELECT2,
						'multiple'    => true,
						'label_block' => true,
						'options'     => function_exists( 'crafto_get_tags_list' ) ? crafto_get_tags_list( 'product_tag' ) : [], // phpcs:ignore
						'condition'   => [
							'crafto_post_taxonomy_selection' => 'tags',
							'crafto_post_taxonomy_source' => 'product',
							'crafto_taxonomy_scope'       => 'all',
						],
					]
				);
			}

			$this->add_responsive_control(
				'crafto_column_settings',
				[
					'label'     => esc_html__( 'Number of Columns', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 3,
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 6,
							'step' => 1,
						],
					],
					'condition' => [
						'crafto_post_taxonomy_styles' => 'post-taxonomy-style-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_columns_gap',
				[
					'label'      => esc_html__( 'Columns Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'default'    => [
						'size' => 15,
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-taxonomy-style-2 li'   => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_taxonomy_styles' => 'post-taxonomy-style-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_bottom_spacing',
				[
					'label'      => esc_html__( 'Bottom Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-taxonomy-style-2 li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_taxonomy_styles' => 'post-taxonomy-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_post_taxonomy_number',
				[
					'label'   => esc_html__( 'Number Of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 5,
				]
			);
			$this->add_control(
				'crafto_post_taxonomy_icon',
				[
					'label'            => esc_html__( 'Hover Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'fas fa-arrow-right-long',
						'library' => 'fa-solid',
					],
					'condition'        => [
						'crafto_post_taxonomy_styles' => 'post-taxonomy-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_count',
				[
					'label'        => esc_html__( 'Enable Post Count', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_post_taxonomy_styles!' => [
							'post-taxonomy-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_post_taxonomy_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_post_taxonomy_align',
				[
					'label'        => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'    => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'  => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-justify',
						],
					],
					'prefix_class' => 'elementor%s-align-',
					'default'      => '',
					'condition'    => [
						'crafto_post_taxonomy_styles'    => 'post-taxonomy-style-1',
						'crafto_post_taxonomy_selection' => 'tags',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_post_taxonomy_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .post-taxonomy-list a',
				]
			);
			$this->start_controls_tabs( 'crafto_style_tabs' );
				$this->start_controls_tab(
					'crafto_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_post_taxonomy_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .post-taxonomy-list a' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_post_taxonomy_background',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} .post-taxonomy-list a',
						'condition' => [
							'crafto_post_taxonomy_selection' => 'tags',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'      => 'crafto_post_taxonomy_shadow',
						'selector'  => '{{WRAPPER}} .post-taxonomy-list a',
						'condition' => [
							'crafto_post_taxonomy_selection' => 'tags',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'crafto_post_taxononmy_border',
						'default'   => '1px',
						'selector'  => '{{WRAPPER}} .post-taxonomy-list a',
						'condition' => [
							'crafto_post_taxonomy_selection' => 'tags',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_style_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_post_taxonomy_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .post-taxonomy-list a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_post_taxonomy_hover_background',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} .post-taxonomy-list a:hover',
						'condition' => [
							'crafto_post_taxonomy_selection' => 'tags',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'      => 'crafto_post_taxonomy_hover_shadow',
						'selector'  => '{{WRAPPER}} .post-taxonomy-list a:hover',
						'condition' => [
							'crafto_post_taxonomy_selection' => 'tags',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'crafto_post_taxononmy_hover_border',
						'default'   => '1px',
						'selector'  => '{{WRAPPER}} .post-taxonomy-list a:hover',
						'condition' => [
							'crafto_post_taxonomy_selection' => 'tags',
						],
					]
				);
				$this->end_controls_tab();
				$this->end_controls_tabs();
				$this->add_responsive_control(
					'crafto_post_taxonomy_padding',
					[
						'label'      => esc_html__( 'Padding', 'crafto-addons' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'separator'  => 'before',
						'size_units' => [
							'px',
							'em',
							'%',
							'rem',
							'custom',
						],
						'selectors'  => [
							'{{WRAPPER}} .post-taxonomy-list ul:not(.post-taxonomy-style-2) li a, {{WRAPPER}}  .post-taxonomy-style-2 .category-title ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_post_taxonomy_styles!' => [
								'post-taxonomy-style-4',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_post_taxonomy_margin',
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
							'{{WRAPPER}} .post-taxonomy-list ul:not(.post-taxonomy-style-3, .post-taxonomy-style-4) li a, {{WRAPPER}} .post-taxonomy-list .post-taxonomy-style-3 li, {{WRAPPER}} .post-taxonomy-list .post-taxonomy-style-4 li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_post_taxonomy_styles!' => [
								'post-taxonomy-style-2',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_post_taxonomy_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [
							'px',
							'%',
							'custom',
						],
						'selectors'  => [
							'{{WRAPPER}} .post-taxonomy-list a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_post_taxonomy_selection' => 'tags',
						],
					]
				);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_post_taxonomy_number_style',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_taxonomy_selection' => 'categories',
						'crafto_post_taxonomy_styles!'   => 'post-taxonomy-style-3',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_post_taxonomy_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .post-taxonomy-list span',
				]
			);
			$this->add_control(
				'crafto_post_taxonomy_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .post-taxonomy-list span' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_post_taxonomy_number_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .post-taxonomy-style-2 .count-circle',
					'condition' => [
						'crafto_post_taxonomy_styles!' => [
							'post-taxonomy-style-1',
							'post-taxonomy-style-4',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_taxonomy_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_taxonomy_icon[value]!' => '',
						'crafto_post_taxonomy_styles' => 'post-taxonomy-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_post_taxonomy_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .category-icon i'   => 'color: {{VALUE}}',
						'{{WRAPPER}} .category-icon svg' => 'fill: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_taxonomy_icon_size',
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
							'max' => 60,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .category-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .category-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_taxonomy_icon_padding',
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
						'{{WRAPPER}} .category-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_taxonomy_image_box_overlay',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_taxonomy_styles' => [
							'post-taxonomy-style-2',
							'post-taxonomy-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_post_taxonomy_image_box_overlay_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .overlay',
				]
			);
			$this->add_control(
				'crafto_post_taxonomy_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post taxonomy widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                       = $this->get_settings_for_display();
			$crafto_post_taxonomy_styles    = $this->get_settings( 'crafto_post_taxonomy_styles' );
			$crafto_post_taxonomy_source    = $this->get_settings( 'crafto_post_taxonomy_source' );
			$crafto_post_taxonomy_selection = $this->get_settings( 'crafto_post_taxonomy_selection' );
			$crafto_show_post_count         = $this->get_settings( 'crafto_show_post_count' );
			$crafto_categories_list         = $this->get_settings( 'crafto_categories_list' );
			$crafto_tags_list               = $this->get_settings( 'crafto_tags_list' );

			if ( is_woocommerce_activated() ) {
				$crafto_product_cat_list  = $this->get_settings( 'crafto_product_cat_list' );
				$crafto_product_tags_list = $this->get_settings( 'crafto_product_tags_list' );
			}

			$number               = ( isset( $settings['crafto_post_taxonomy_number'] ) && $settings['crafto_post_taxonomy_number'] ) ? $settings['crafto_post_taxonomy_number'] : '';
			$post_taxonomy_styles = ( isset( $settings['crafto_post_taxonomy_styles'] ) && $settings['crafto_post_taxonomy_styles'] ) ? $settings['crafto_post_taxonomy_styles'] : 'post-taxonomy-style-1';
			$taxonomy_scope       = ( isset( $settings['crafto_taxonomy_scope'] ) && $settings['crafto_taxonomy_scope'] ) ? $settings['crafto_taxonomy_scope'] : 'all';

			/* Column Settings */
			$crafto_column_desktop_column = ! empty( $settings['crafto_column_settings'] ) ? $settings['crafto_column_settings'] : '3';
			$crafto_column_class_list     = '';
			$crafto_column_ratio          = '';

			if ( 'post-taxonomy-style-2' === $crafto_post_taxonomy_styles ) {
				switch ( $crafto_column_desktop_column ) {
					case '1':
						$crafto_column_ratio = 1;
						break;
					case '2':
						$crafto_column_ratio = 2;
						break;
					case '3':
					default:
						$crafto_column_ratio = 3;
						break;
					case '4':
						$crafto_column_ratio = 4;
						break;
					case '5':
						$crafto_column_ratio = 5;
						break;
					case '6':
						$crafto_column_ratio = 6;
						break;
				}
			}

			$crafto_column_class      = [];
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';
			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );

			$migrated = isset( $settings['__fa4_migrated']['crafto_blockquote_icon'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			$items_list = [];
			$slug_list  = '';
			$taxonomy   = '';

			// Detect correct taxonomy.
			switch ( $crafto_post_taxonomy_source ) {
				case 'post':
					if ( 'tags' === $crafto_post_taxonomy_selection ) {
						$taxonomy  = 'post_tag';
						$slug_list = $crafto_tags_list;
					} else {
						$taxonomy  = 'category';
						$slug_list = $crafto_categories_list;
					}
					break;

				case 'portfolio':
					if ( 'tags' === $crafto_post_taxonomy_selection ) {
						$taxonomy  = 'portfolio-tags';
						$slug_list = ''; // You can set one if needed.
					} else {
						$taxonomy  = 'portfolio-category';
						$slug_list = ''; // You can set one if needed.
					}
					break;

				case 'product':
					if ( is_woocommerce_activated() ) {
						if ( 'tags' === $crafto_post_taxonomy_selection ) {
							$taxonomy  = 'product_tag';
							$slug_list = $crafto_product_tags_list;
						} else {
							$taxonomy  = 'product_cat';
							$slug_list = $crafto_product_cat_list;
						}
					}
					break;
			}

			if ( crafto_is_editor_mode() ) {
				$args = array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
					'number'     => $number,
				);

				if ( ! empty( $slug_list ) ) {
					$args['slug'] = $slug_list;
				}

				$items_list = get_terms( $args );
			} else {
				$current_post_id = get_the_ID();
				if ( 'current' === $taxonomy_scope && $current_post_id && $taxonomy ) {
					$items_list = wp_get_post_terms( $current_post_id, $taxonomy );
				} else {
					// All terms.
					$args = array(
						'taxonomy'   => $taxonomy,
						'hide_empty' => false,
						'number'     => $number,
					);

					if ( ! empty( $slug_list ) ) {
						$args['slug'] = $slug_list;
					}

					$items_list = get_terms( $args );
				}
			}

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'post-taxonomy-list',
							$crafto_post_taxonomy_selection,
						],
					],
				]
			);

			$this->add_render_attribute(
				'inner_wrapper_key',
				[
					'class' => [
						'grid',
						$post_taxonomy_styles,
						$crafto_column_class_list,
					],
				]
			);

			if ( is_array( $items_list ) && ! empty( $items_list ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<ul <?php $this->print_render_attribute_string( 'inner_wrapper_key' ); ?>>
						<?php
						$post_count = '';
						foreach ( $items_list as $category ) {
							$category_link = get_category_link( $category->term_id );
							$post_count    = ( $category->count < 10 ) ? 0 . $category->count : $category->count;
							$post_count    = '<span>' . esc_html( $post_count ) . '</span>';
							$image_id      = get_term_meta( $category->term_id, 'crafto_archive_title_bg_image', true );
							$image_url     = wp_get_attachment_url( $image_id );

							switch ( $post_taxonomy_styles ) {
								case 'post-taxonomy-style-1':
									if ( ! empty( $category->name ) ) {
										?>
										<li>
											<a rel="category tag" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category->name ); ?>
											<?php
											if ( 'yes' === $crafto_show_post_count ) {
												echo sprintf( '%s', $post_count ); // phpcs:ignore 
											}
											?>
											</a>
										</li>
										<?php
									}
									break;
								case 'post-taxonomy-style-2':
									if ( ! empty( $category->name ) ) {
										?>
										<li>
											<div class="categories-box">
												<div class="categories-image">
													<a href="<?php echo esc_url( $category_link ); ?>">
														<?php
														$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
														if ( '' === $alt ) {
															$alt = get_the_title( $image_id );
														}

														$params = [
															'alt' => $alt,
														];

														$image_html = wp_get_attachment_image( $image_id, 'full', false, $params );

														if ( $image_html ) {
															echo sprintf( '%s', $image_html ); // phpcs:ignore
														} else {
															echo '<img src="' . esc_url( Utils::get_placeholder_image_src() ) . '" alt="' . esc_attr__( 'Placeholder', 'crafto-addons' ) . '">';
														}
														?>
														<div class="overlay"></div>
													</a>
												</div>
												<div class="category-title">
													<a class="category" rel="category tag" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category->name ); ?></a>
													<?php
													if ( 'yes' === $crafto_show_post_count ) {
														?>
														<div class="count-circle"><?php echo sprintf( '%s', $post_count ); // phpcs:ignore ?></div>
														<?php
													}
													?>
												</div>
											</div>
										</li>
										<?php
									}
									break;
								case 'post-taxonomy-style-3':
									if ( ! empty( $category->name ) ) {
										$bg_image_url  = ! empty( $image_url ) ? $image_url : Utils::get_placeholder_image_src();
										$bg_style_attr = ' style="background-image: url(\'' . esc_url( $bg_image_url ) . '\');"';
										?>
										<li class="blog-post-images cover-background"<?php echo $bg_style_attr; //phpcs:ignore ?>>
											<div class="overlay"></div>
											<div class="categories-box">
												<div class="category-title">
													<a class="category" rel="category tag" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category->name ); ?>
														<span class="category-icon">
															<?php
															if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_post_taxonomy_icon']['value'] ) ) {
																if ( $is_new || $migrated ) {
																	Icons_Manager::render_icon( $settings['crafto_post_taxonomy_icon'], [ 'aria-hidden' => 'true' ] );
																} elseif ( isset( $settings['crafto_post_taxonomy_icon']['value'] ) && ! empty( $settings['crafto_post_taxonomy_icon']['value'] ) ) {
																	?>
																	<i class="<?php echo esc_attr( $settings['crafto_post_taxonomy_icon']['value'] ); ?>" aria-hidden="true"></i>
																		<?php
																}
															}
															?>
														</span>
													</a>
												</div>
											</div>
										</li>
										<?php
									}
									break;
								case 'post-taxonomy-style-4':
									if ( ! empty( $category->name ) ) {
										?>
										<li>
											<a rel="category tag" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category->name ); ?></a>
											<?php
											if ( 'yes' === $crafto_show_post_count ) {
												echo sprintf( '%s', $post_count ); // phpcs:ignore 
											}
											?>
										</li>
										<?php
									}
									break;
							}
						}
						?>
					</ul>
				</div>
				<?php
			}
		}

		/**
		 * Return product_cat array.
		 */
		public function crafto_get_products_list() {
			$categories_array = [];

			$categories = get_terms(
				[
					'taxonomy'   => 'product_cat',
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
				]
			);

			if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					$categories_array[ $category->slug ] = $category->name;
				}
			}
			return $categories_array;
		}
	}
}
