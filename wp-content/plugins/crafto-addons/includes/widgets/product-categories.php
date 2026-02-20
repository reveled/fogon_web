<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for Product Categories.
 *
 * @package Crafto
 */


if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// If class `Product_Categories` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Product_Categories' ) ) {
	/**
	 * Define `Product_Categories` class.
	 */
	class Product_Categories extends Widget_Base {
		/**
		 * Retrieve the list of styles the product categories widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$product_taxonomy_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$product_taxonomy_styles[] = 'crafto-widgets-rtl';
				} else {
					$product_taxonomy_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$product_taxonomy_styles[] = 'crafto-product-taxonomy-rtl-widget';
				}
				$product_taxonomy_styles[] = 'crafto-product-taxonomy-widget';
			}
			return $product_taxonomy_styles;
		}

		/**
		 * Retrieve the list of scripts the product categories widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$product_categories_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$product_categories_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$product_categories_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$product_categories_scripts[] = 'isotope';
				}
				$product_categories_scripts[] = 'crafto-product-taxonomy-widget';
			}
			return $product_categories_scripts;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-product-taxonomy';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Product Categories', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-product-categories crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/product-categories/';
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
				'product',
				'taxonomy',
				'term',
				'category',
				'woocommerce categories',
			];
		}

		/**
		 * Register product categories widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_product_taxonomy_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_product_taxonomy_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'product-taxonomy-style-1',
					'options'            => [
						'product-taxonomy-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'product-taxonomy-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'product-taxonomy-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'product-taxonomy-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
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
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_columns_gap',
				[
					'label'      => esc_html__( 'Columns Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
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
						'{{WRAPPER}} ul.product-taxonomy-list li.product-taxonomy-item, {{WRAPPER}} ul.product-taxonomy-list li.grid-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.product-taxonomy-list'    => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_taxonomy_bottom_spacing',
				[
					'label'      => esc_html__( 'Bottom Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} ul.product-taxonomy-list li.product-taxonomy-item, {{WRAPPER}} ul.product-taxonomy-list li.grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_product_taxonomy_per_page',
				[
					'label'   => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [
						'active' => true,
					],
					'default' => 6,
				]
			);
			$this->add_control(
				'crafto_enable_masonry',
				[
					'label'        => esc_html__( 'Enable Masonry Layout', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-2',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_categories_content_data',
				[
					'label' => esc_html__( 'Data', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_orderby',
				[
					'label'   => esc_html__( 'Order by', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'title',
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
				'crafto_order',
				[
					'label'   => esc_html__( 'Sort By', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'ASC',
					'options' => [
						'DESC' => esc_html__( 'Descending', 'crafto-addons' ),
						'ASC'  => esc_html__( 'Ascending', 'crafto-addons' ),
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
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'product_cat' ) : [], // phpcs:ignore
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_categories_extra_option',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_show_thumbs',
				[
					'label'        => esc_html__( 'Enable Thumbnail', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_product_taxonomy_style!' => [
							'product-taxonomy-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_thumbnail',
				[
					'label'          => esc_html__( 'Image Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'full',
					'options'        => function_exists( 'crafto_get_thumbnail_image_sizes' ) ? crafto_get_thumbnail_image_sizes() : [],
					'style_transfer' => true,
					'condition'      => [
						'crafto_show_thumbs' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_show_product_count',
				[
					'label'        => esc_html__( 'Enable Counter', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_product_taxonomy_style' => [
							'product-taxonomy-style-1',
							'product-taxonomy-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_text',
				[
					'label'       => esc_html__( 'Button Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'View Collection', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Button text here', 'crafto-addons' ),
					'condition'   => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-2',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_grid_preloader',
				[
					'label' => esc_html__( 'Preloader', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_section_enable_grid_preloader',
				[
					'label'        => esc_html__( 'Enable Preloader', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_section_grid_preloader_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .grid-loading::after' => 'background: {{VALUE}};',
					],
					'condition' => [
						'crafto_section_enable_grid_preloader' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_product_taxonomy_iconbox_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_product_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
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
					'selectors_dictionary' => [
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .product-taxonomy-style-4 .categories-box' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-4',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_taxonomy_iconbox_margin',
				[
					'label'      => esc_html__( 'Space Between Image and Title', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .image-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_taxonomy_image_style',
				[
					'label'      => esc_html__( 'Image', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_product_display_settings',
				[
					'label'     => esc_html__( 'Display', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''             => esc_html__( 'Default', 'crafto-addons' ),
						'block'        => esc_html__( 'Block', 'crafto-addons' ),
						'inline'       => esc_html__( 'Inline', 'crafto-addons' ),
						'inline-block' => esc_html__( 'Inline Block', 'crafto-addons' ),
						'none'         => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .product-taxonomy-style-4 .categories-box .image-box' => 'display: {{VALUE}}',
					],
					'condition' => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-4',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_taxonomy_Image_width',
				[
					'label'       => esc_html__( 'Width', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'%',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 800,
							'min' => 1,
						],
						'%'  => [
							'max' => 100,
							'min' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .image-box img' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_taxonomy_Image_height',
				[
					'label'       => esc_html__( 'Height', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'%',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 800,
							'min' => 1,
						],
						'%'  => [
							'max' => 100,
							'min' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .image-box img' => 'height: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_taxonomy_Image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .product-taxonomy-style-4 .image-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_product_taxonomy_style' => [
							'product-taxonomy-style-4',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_taxonomy_count_style',
				[
					'label'      => esc_html__( 'Counter', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_product_taxonomy_style' => [
							'product-taxonomy-style-1',
							'product-taxonomy-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_taxonomy_count_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .count-circle',
				]
			);
			$this->add_control(
				'crafto_taxonomy_count_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .count-circle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_taxonomy_count_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .count-circle' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_taxonomy_count_width',
				[
					'label'       => esc_html__( 'Width', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 60,
							'min' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .count-circle' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_taxonomy_count_height',
				[
					'label'       => esc_html__( 'Height', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 60,
							'min' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .count-circle' => 'height: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_taxonomy_count_border',
					'selector'  => '{{WRAPPER}} .count-circle',
					'condition' => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_taxonomy_count_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .count-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_taxonomy_count_padding',
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
						'{{WRAPPER}} .count-circle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_taxonomy_title_style',
				[
					'label'      => esc_html__( 'Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_taxonomy_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .categories-box .category',
				]
			);
			$this->start_controls_tabs( 'crafto_taxonomy_title_tabs' );
				$this->start_controls_tab(
					'crafto_taxonomy_title_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_product_taxonomy_style!' => 'product-taxonomy-style-2',
						],
					]
				);
				$this->add_control(
					'crafto_taxonomy_title_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .categories-box .category' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_icon_background_color',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} .categories-box .category',
						'condition' => [
							'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'crafto_taxonomy_title_border',
						'selector'  => '{{WRAPPER}} .categories-box .category',
						'condition' => [
							'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_taxonomy_title_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [
							'px',
							'%',
							'custom',
						],
						'selectors'  => [
							'{{WRAPPER}} .categories-box .category' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_taxonomy_title_padding',
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
							'{{WRAPPER}} .categories-box .category' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_taxonomy_title_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_product_taxonomy_style!' => 'product-taxonomy-style-2',
						],
					]
				);
				$this->add_control(
					'crafto_taxonomy_title_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .grid-item:hover .categories-box .category, {{WRAPPER}} .product-taxonomy-style-4 .categories-box .category span.hover i' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_product_taxonomy_style!' => 'product-taxonomy-style-2',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_icon_hover_background_color',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} .categories-box .category:hover',
						'condition' => [
							'crafto_product_taxonomy_style' => 'product-taxonomy-style-3',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_taxonomy_category_style',
				[
					'label'      => esc_html__( 'Hover Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_taxonomy_category_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .category-title',
				]
			);
			$this->start_controls_tabs( 'crafto_taxonomy_category_tabs' );
				$this->start_controls_tab(
					'crafto_taxonomy_category_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_taxonomy_category_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .category-title' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_taxonomy_category_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_taxonomy_category_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .category-title:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_taxonomy_category_style_heading',
				[
					'label'     => esc_html__( 'Title Big Letter', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_taxonomy_big_letter_category_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .category-big-letter',
				]
			);
			$this->add_control(
				'crafto_taxonomy_big_letter_category_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .category-big-letter' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_taxonomy_button_text_style',
				[
					'label'      => esc_html__( 'Button Text', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_product_taxonomy_style' => 'product-taxonomy-style-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_taxonomy_button_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .category-button',
				]
			);
			$this->add_control(
				'crafto_taxonomy_button_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .category-button' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}
		/**
		 * Render product taxonomy widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                      = $this->get_settings_for_display();
			$crafto_thumbnail              = $this->get_settings( 'crafto_thumbnail' );
			$crafto_product_taxonomy_style = $this->get_settings( 'crafto_product_taxonomy_style' );
			$crafto_categories_list        = $this->get_settings( 'crafto_categories_list' );
			$crafto_taxonomy_per_page      = $this->get_settings( 'crafto_product_taxonomy_per_page' );
			$crafto_show_thumbs            = $this->get_settings( 'crafto_show_thumbs' );
			$crafto_show_product_count     = $this->get_settings( 'crafto_show_product_count' );
			$crafto_orderby                = $this->get_settings( 'crafto_orderby' );
			$crafto_order                  = $this->get_settings( 'crafto_order' );
			$crafto_enable_masonry         = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';
			$crafto_button_text            = ( isset( $settings['crafto_button_text'] ) && $settings['crafto_button_text'] ) ? $settings['crafto_button_text'] : '';

			$items_list    = '';
			$product_count = '';

			/* Column Settings */
			$crafto_column_desktop_column = ! empty( $settings['crafto_column_settings'] ) ? $settings['crafto_column_settings'] : '3';
			$crafto_column_class_list     = '';
			$crafto_column_ratio          = '';

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

			$crafto_column_class   = array();
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';

			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );

			// END No. of Column.

			$items_list = get_terms(
				array(
					'taxonomy'   => 'product_cat',
					'slug'       => $crafto_categories_list,
					'number'     => $crafto_taxonomy_per_page,
					'hide_empty' => true,
					'orderby'    => $crafto_orderby,
					'order'      => $crafto_order,
				)
			);

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'product-taxonomy-list',
							'grid',
							'yes' === $settings['crafto_section_enable_grid_preloader'] ? 'grid-loading' : '',
							$crafto_column_class_list,
							$crafto_product_taxonomy_style,
						],
					],
				]
			);

			if ( 'product-taxonomy-style-2' === $crafto_product_taxonomy_style ) {
				if ( 'yes' === $crafto_enable_masonry ) {
					$this->add_render_attribute(
						[
							'wrapper' => [
								'class' => [
									'grid-masonry',
								],
							],
						]
					);
				} else {
					$this->add_render_attribute(
						'wrapper',
						'class',
						'no-masonry'
					);
				}
			}

			if ( is_array( $items_list ) && ! empty( $items_list ) ) {
				?>
				<ul <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<?php
					if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
						if ( 'yes' === $crafto_enable_masonry ) {
							?>
							<li class="grid-sizer d-none p-0 m-0"></li>
							<?php
						}
					}

					$product_count = '';
					$index         = 0;

					if ( 'product-taxonomy-style-2' === $crafto_product_taxonomy_style ) {
						$this->add_render_attribute(
							'inner_wrapper_key',
							[
								'class' => [
									'grid-item',
									'grid-gutter',
								],
							]
						);
					} else {
						$this->add_render_attribute(
							'inner_wrapper_key',
							[
								'class' => [
									'grid-item',
									'product-taxonomy-item',
								],
							]
						);
					}
					foreach ( $items_list as $category ) {
						if ( 0 === $index % $crafto_column_ratio ) {
							$grid_count = 1;
						}

						$parent_count     = $category->count;
						$child_count      = 0;
						$child_categories = get_categories(
							array(
								'child_of'   => $category->term_id,
								'hide_empty' => false,
							)
						);
						foreach ( $child_categories as $child_category ) {
							$child_count += $child_category->count;
						}
						$parent_product_count = ( $parent_count < 10 ) ? '0' . $parent_count : $parent_count;
						$child_product_count  = ( $child_count < 10 ) ? '0' . $child_count : $child_count;

						$category_link = get_category_link( $category->term_id );
						if ( $parent_count > 0 ) {
							$product_count = '<span>' . esc_html( $parent_product_count ) . '</span>';
						} elseif ( $child_count > 0 ) {
							$product_count = '<span>' . esc_html( $child_product_count ) . '</span>';
						}

						$image_id = get_term_meta( $category->term_id, 'thumbnail_id', true );

						$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
						$image_key    = 'image_' . $index;
						$img_alt      = '';
						$img_alt      = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
						if ( empty( $img_alt ) ) {
							$img_alt = esc_attr( get_the_title( $thumbnail_id ) );
						}
						$this->add_render_attribute( $image_key, 'class', 'image-link' );
						$this->add_render_attribute( $image_key, 'aria-label', $img_alt );

						switch ( $crafto_product_taxonomy_style ) {
							case 'product-taxonomy-style-1':
								if ( ! empty( $category->name ) ) {
									?>
									<li <?php $this->print_render_attribute_string( 'inner_wrapper_key' ); ?>>
										<div class="categories-box">
											<?php
											if ( ! empty( $image_id ) ) {
												$thumbnail_id       = $image_id;
												$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
												$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
												$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
												$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';
												$crafto_img_attr    = array(
													'title' => $crafto_image_title,
													'alt' => $crafto_image_alt,
												);
												?>
												<div class="image-box">
													<?php
													if ( 'yes' === $crafto_show_thumbs ) {
														?>
														<a href="<?php echo esc_url( $category_link ); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
															<?php
															$image_html = wp_get_attachment_image( $image_id, $crafto_thumbnail, '', $crafto_img_attr, 'full' );

															if ( ! $image_html ) {
																$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
																$image_html          = '<img src="' . esc_url( $default_placeholder ) . '" alt="' . esc_attr__( 'Placeholder Image', 'crafto-addons' ) . '">';
															}

															echo $image_html; // phpcs:ignore
															?>
														</a>
														<?php
													}
													if ( 'yes' === $crafto_show_product_count ) {
														?>
														<div class="count-circle"><?php echo sprintf( '%s', $product_count ); // phpcs:ignore ?></div>
														<?php
													}
													?>
												</div>
												<?php
											} else {
												$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
												?>
												<div class="image-box">
													<a href="<?php echo esc_url( $category_link ); ?>">
														<img src="<?php echo esc_url( $default_placeholder ); ?>" alt="<?php echo esc_attr__( 'Default Category Image', 'crafto-addons' ); ?>">
													</a>
													<?php
													if ( 'yes' === $crafto_show_product_count ) {
														?>
														<div class="count-circle"><?php echo sprintf( '%s', $product_count ); // phpcs:ignore ?></div>
														<?php
													}
													?>
												</div>
												<?php
											}
											?>
											<a class="category" rel="category tag" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $category->name ); ?></a>
										</div>
									</li>
									<?php
								}
								break;
							case 'product-taxonomy-style-2':
								if ( ! empty( $category->name ) ) {
									?>
									<li <?php $this->print_render_attribute_string( 'inner_wrapper_key' ); ?>>
										<div class="categories-box">
											<?php
											if ( ! empty( $image_id ) ) {
												$thumbnail_id       = $image_id;
												$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
												$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
												$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
												$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';
												$crafto_img_attr    = array(
													'title' => $crafto_image_title,
													'alt' => $crafto_image_alt,
												);
												?>
												<div class="image-box">
													<?php
													if ( 'yes' === $crafto_show_thumbs ) {
														?>
														<a href="<?php echo esc_url( $category_link ); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
															<?php
															$image_html = wp_get_attachment_image( $image_id, $crafto_thumbnail, '', $crafto_img_attr, 'full' );
															if ( ! $image_html ) {
																$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
																$image_html          = '<img src="' . esc_url( $default_placeholder ) . '" alt="' . esc_attr__( 'Placeholder Image', 'crafto-addons' ) . '">';
															}
															echo $image_html; // phpcs:ignore 
															?>
														</a>
														<?php
													}
													?>
												</div>
												<div class="category"><?php echo esc_html( $category->name ); ?></div>
												<div class="category-hover-content">
													<h3 class="category-title"><?php echo esc_html( $category->name ); ?><span class="category-big-letter"><?php echo esc_html( $category->name[0] ); ?></span></h3>
													<a class="category-button" rel="category tag" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $crafto_button_text ); ?></a>
												</div>
												<?php
											} else {
												$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
												?>
												<div class="image-box">
													<a href="<?php echo esc_url( $category_link ); ?>">
														<img src="<?php echo esc_url( $default_placeholder ); ?>" alt="<?php echo esc_attr__( 'Default Category Image', 'crafto-addons' ); ?>">
													</a>
												</div>
												<div class="category"><?php echo esc_html( $category->name ); ?></div>
												<div class="category-hover-content">
													<h3 class="category-title"><?php echo esc_html( $category->name ); ?><span class="category-big-letter"><?php echo esc_html( $category->name[0] ); ?></span></h3>
													<a class="category-button" rel="category tag" href="<?php echo esc_url( $category_link ); ?>"><?php echo esc_html( $crafto_button_text ); ?></a>
												</div>
												<?php
											}
											?>
										</div>
									</li>
									<?php
								}
								break;
							case 'product-taxonomy-style-3':
								if ( ! empty( $category->name ) ) {
									?>
									<li <?php $this->print_render_attribute_string( 'inner_wrapper_key' ); ?>>
										<div class="categories-box">
											<?php
											if ( ! empty( $image_id ) ) {
												$thumbnail_id       = $image_id;
												$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
												$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
												$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
												$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';
												$crafto_img_attr    = array(
													'title' => $crafto_image_title,
													'alt' => $crafto_image_alt,
												);
												?>
												<div class="image-box">
													<?php
													if ( 'yes' === $crafto_show_product_count ) {
														?>
														<div class="count-circle"><?php echo sprintf( '%s', $product_count ); // phpcs:ignore ?><?php echo ( '01' === $child_count . $parent_count ) ? esc_html__( 'ITEM', 'crafto-addons' ) : esc_html__( 'ITEMS', 'crafto-addons' ); ?></div>
														<?php
													}
													if ( 'yes' === $crafto_show_thumbs ) {
														?>
														<a href="<?php echo esc_url( $category_link ); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
															<?php
															$image_html = wp_get_attachment_image( $image_id, $crafto_thumbnail, '', $crafto_img_attr, 'full' );
															if ( ! $image_html ) {
																$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
																$image_html          = '<img src="' . esc_url( $default_placeholder ) . '" alt="' . esc_attr__( 'Placeholder Image', 'crafto-addons' ) . '">';
															}
															echo $image_html; // phpcs:ignore 
															?>
														</a>
														<?php
													}
													?>
												</div>
												<a class="category" rel="category tag" href="<?php echo esc_url( $category_link ); ?>">
													<span><?php echo esc_html( $category->name ); ?></span>
													<span class="hover"><?php echo esc_html( $category->name ); ?></span>
												</a>
												<?php
											} else {
												$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
												?>
												<div class="image-box">
													<a href="<?php echo esc_url( $category_link ); ?>">
														<img src="<?php echo esc_url( $default_placeholder ); ?>" alt="<?php echo esc_attr__( 'Default Category Image', 'crafto-addons' ); ?>">
													</a>
													<?php
													if ( 'yes' === $crafto_show_product_count ) {
														?>
														<div class="count-circle"><?php echo sprintf( '%s', $product_count ); // phpcs:ignore ?><?php echo ( '01' === $child_count . $parent_count ) ? esc_html__( 'ITEM', 'crafto-addons' ) : esc_html__( 'ITEMS', 'crafto-addons' ); ?></div>
														<?php
													}
													?>
												</div>
												<a class="category" rel="category tag" href="<?php echo esc_url( $category_link ); ?>">
													<span><?php echo esc_html( $category->name ); ?></span>
													<span class="hover"><?php echo esc_html( $category->name ); ?></span>
												</a>
												<?php
											}
											?>
										</div>
									</li>
									<?php
								}
								break;
							case 'product-taxonomy-style-4':
								if ( ! empty( $category->name ) ) {
									?>
									<li <?php $this->print_render_attribute_string( 'inner_wrapper_key' ); ?>>
										<div class="categories-box">
											<?php
											if ( ! empty( $image_id ) ) {
												$thumbnail_id       = $image_id;
												$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
												$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
												$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
												$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';
												$crafto_img_attr    = array(
													'title' => $crafto_image_title,
													'alt' => $crafto_image_alt,
												);
												?>
												<div class="image-box">
													<?php
													if ( 'yes' === $crafto_show_thumbs ) {
														?>
														<a href="<?php echo esc_url( $category_link ); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
														<?php
														$image_html = wp_get_attachment_image( $image_id, $crafto_thumbnail, '', $crafto_img_attr, 'full' );
														if ( ! $image_html ) {
															$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
															$image_html          = '<img src="' . esc_url( $default_placeholder ) . '" alt="' . esc_attr__( 'Placeholder Image', 'crafto-addons' ) . '">';
														}
														echo $image_html; // phpcs:ignore 
														?>
														</a>
														<?php
													}
													?>
												</div>
												<a class="category" rel="category tag" href="<?php echo esc_url( $category_link ); ?>">
													<span><?php echo esc_html( $category->name ); ?></span>
													<span class="hover"><i class="fa-solid fa-arrow-right"></i></span>
												</a>
												<?php
											} else {
												$default_placeholder = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/placeholder.png';
												?>
												<div class="image-box">
													<a href="<?php echo esc_url( $category_link ); ?>">
														<img src="<?php echo esc_url( $default_placeholder ); ?>" alt="<?php echo esc_attr__( 'Default Category Image', 'crafto-addons' ); ?>">
													</a>
												</div>
												<a class="category" rel="category tag" href="<?php echo esc_url( $category_link ); ?>">
													<span><?php echo esc_html( $category->name ); ?></span>
													<span class="hover"><i class="fa-solid fa-arrow-right"></i></span>
												</a>
												<?php
											}
											?>
										</div>
									</li>
									<?php
								}
								break;
						}
						++$index;
						++$grid_count;
					}
					?>
				</ul>
				<?php
			}
		}
	}
}
