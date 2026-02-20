<?php
namespace CraftoAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Crafto widget for Mini Cart.
 *
 * @package Crafto
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// If class `Cart` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Cart' ) ) {

	class Cart extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-woocommerce-mini-cart';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Mini Cart', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-cart crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/mini-cart/';
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
				'crafto',
				'crafto-header',
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
				'bag',
				'shop',
				'shopping',
				'woocommerce',
				'mini',
				'summary',
				'ecommerce',
			];
		}

		/**
		 * Register the widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_menu_icon_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_item_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'icon-feather-shopping-bag',
						'library' => 'feather',
					],
				]
			);
			$this->add_control(
				'crafto_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'default'      => 'default',
					'prefix_class' => 'elementor-view-',
				]
			);
			$this->add_control(
				'crafto_icon_shape',
				[
					'label'        => esc_html__( 'Shape', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => esc_html__( 'Circle', 'crafto-addons' ),
						'square' => esc_html__( 'Square', 'crafto-addons' ),
					],
					'condition'    => [
						'crafto_view!' => 'default',
					],
					'default'      => 'circle',
					'prefix_class' => 'elementor-shape-',
				]
			);

			$this->add_control(
				'crafto_mini_cart_icon_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_mini_cart_icon_align',
				[
					'label'   => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'right',
					'toggle'  => false,
					'options' => [
						'left'  => [
							'title' => esc_html__( 'Start', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'End', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_separator_general_style_section',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_control(
				'crafto_alignment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'label_block'          => false,
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
					'selectors'   => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_mini_cart_icon_section',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 40,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_max_width',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => 'default',
					],
				]
			);
			$this->start_controls_tabs( 'icon_colors' );

			$this->start_controls_tab(
				'crafto_mini_cart_icon_colors_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_mini_cart_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-framed .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg, {{WRAPPER}}.elementor-view-framed .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_mini_cart_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => 'stacked',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_mini_cart_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_mini_cart_icon_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view' => [
							'framed',
						],
					],
				]
			);
			$this->add_control(
				'crafto_mini_cart_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'%',
						'px',
						'custom',
					],
					'default'    => [
						'unit' => '%',
					],
					'range'      => [
						'%' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => 'default',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_mini_cart_icon_colors_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_mini_cart_hover_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_mini_cart_hover_primary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => 'stacked',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_mini_cart_icon_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_mini_cart_icon_text_heading',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_mini_cart_icon_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_mini_cart_icon_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-top-cart-wrapper .icon-text',
				]
			);
			$this->start_controls_tabs(
				'crafto_mini_cart_icon_text_tabs',
			);
				$this->start_controls_tab(
					'crafto_mini_cart_icon_text_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_mini_cart_icon_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-top-cart-wrapper .icon-text' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
					$this->start_controls_tab(
						'crafto_mini_cart_icon_text_hover_tab',
						[
							'label' => esc_html__( 'Hover', 'crafto-addons' ),
						],
					);
					$this->add_control(
						'crafto_mini_cart_icon_text_hvr_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-top-cart-wrapper:hover .icon-text' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_mini_cart_style',
				[
					'label' => esc_html__( 'Mini Cart', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_mini_cart_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .widget_shopping_cart_content .crafto-mini-cart-content-wrap' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_mini_cart_box_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .widget_shopping_cart_content .crafto-mini-cart-content-wrap' => 'min-width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_mini_cart_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .widget_shopping_cart_content .crafto-mini-cart-content-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_mini_cart_shadow',
					'selector' => '{{WRAPPER}} .widget_shopping_cart_content .crafto-mini-cart-content-wrap',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_empty_mini_cart_style',
				[
					'label' => esc_html__( 'Empty Cart', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_empty_mini_cart_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .woocommerce-mini-cart__empty-message .crafto-no-cart-icon' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_empty_mini_cart_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
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
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .woocommerce-mini-cart__empty-message .crafto-no-cart-icon'   => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_empty_mini_cart_text_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Text', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_empty_mini_cart_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .woocommerce-mini-cart__empty-message .empty-cart-text',
				]
			);
			$this->add_control(
				'crafto_empty_mini_cart_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .woocommerce-mini-cart__empty-message .empty-cart-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_mini_cart_product_tabs_style',
				[
					'label' => esc_html__( 'Products', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_heading_product_title_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_mini_cart_product_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .cart_list li .product-detail a',
				]
			);
			$this->start_controls_tabs( 'crafto_mini_cart_product_title_tabs' );
			$this->start_controls_tab( 'crafto_mini_cart_product_title_normal_tab', [ 'label' => esc_html__( 'Normal', 'crafto-addons' ) ] );
			$this->add_control(
				'crafto_mini_cart_product_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cart_list li .product-detail a' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_mini_cart_product_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_mini_cart_product_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .cart_list li .product-detail a:hover' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'crafto_heading_product_price_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_mini_cart_product_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-top-cart-wrapper .cart_list li .product-detail .quantity, {{WRAPPER}} .crafto-top-cart-wrapper .cart_list li .product-detail .amount',
				]
			);
			$this->add_control(
				'crafto_mini_cart_product_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .cart_list li .product-detail .quantity, {{WRAPPER}} .crafto-top-cart-wrapper .cart_list li .product-detail .amount' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'crafto_heading_product_separator_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_mini_cart_separator_style',
				[
					'label'     => esc_html__( 'Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''       => esc_html__( 'None', 'crafto-addons' ),
						'solid'  => esc_html__( 'Solid', 'crafto-addons' ),
						'double' => esc_html__( 'Double', 'crafto-addons' ),
						'dotted' => esc_html__( 'Dotted', 'crafto-addons' ),
						'dashed' => esc_html__( 'Dashed', 'crafto-addons' ),
						'groove' => esc_html__( 'Groove', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .cart_list li' => 'border-bottom-style: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_mini_cart_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .cart_list li' => 'border-color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_mini_cart_separator_width',
				[
					'label'     => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .cart_list li' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_heading_remove_item_icon_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Remove Item Icon', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_mini_cart_remove_item_icon_typography',
					'selector' => '{{WRAPPER}} .woocommerce-mini-cart-item .remove_from_cart_button',
				]
			);
			$this->add_control(
				'crafto_mini_cart_remove_item_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .woocommerce-mini-cart-item .remove_from_cart_button' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_heading_subtotal_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Subtotal', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_mini_cart_subtotal_typography',
					'selector' => '{{WRAPPER}} .crafto-top-cart-wrapper .woocommerce-mini-cart__total strong, {{WRAPPER}} .crafto-top-cart-wrapper .woocommerce-mini-cart__total .amount',
				]
			);
			$this->add_control(
				'crafto_mini_cart_subtotal_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .total strong, {{WRAPPER}} .crafto-top-cart-wrapper .total .amount' => 'color: {{VALUE}}',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_mini_cart_style_buttons',
				[
					'label' => esc_html__( 'Buttons', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_mini_cart_buttons_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .crafto-top-cart-wrapper .buttons a',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_mini_cart_border_radius',
				[
					'label'     => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a' => 'border-radius: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_mini_cart_button_padding',
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
						'{{WRAPPER}} .min-cart-total .woocommerce-mini-cart__buttons .button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_view_cart_button_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'View Cart', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs( 'crafto_view_cart_buttons' );
			$this->start_controls_tab( 'crafto_view_cart_buttons_normal_colors', [ 'label' => esc_html__( 'Normal', 'crafto-addons' ) ] );
			$this->add_control(
				'crafto_view_cart_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_view_cart_button_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab( 'crafto_view_cart_buttons_hover_colors', [ 'label' => esc_html__( 'Hover', 'crafto-addons' ) ] );
			$this->add_control(
				'crafto_view_cart_button_text_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_view_cart_button_background_hover_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_view_cart_button_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_view_cart_border',
					'selector' => '{{WRAPPER}} .crafto-top-cart-wrapper .buttons a',
				]
			);
			$this->add_control(
				'crafto_heading_checkout_button_style',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Checkout', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs( 'crafto_checkout_buttons' );
			$this->start_controls_tab( 'crafto_checkout_buttons_normal_colors', [ 'label' => esc_html__( 'Normal', 'crafto-addons' ) ] );
			$this->add_control(
				'crafto_checkout_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a.checkout' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_checkout_button_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a.checkout' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab( 'crafto_checkout_buttons_hover_colors', [ 'label' => esc_html__( 'Hover', 'crafto-addons' ) ] );
			$this->add_control(
				'crafto_checkout_button_text_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a.checkout:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_checkout_button_background_hover_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a.checkout:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_checkout_button_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-top-cart-wrapper .buttons a.checkout:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_checkout_border',
					'selector' => '{{WRAPPER}} .crafto-top-cart-wrapper .buttons a.checkout',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render mini cart widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                   = $this->get_settings_for_display();
			$migrated                   = isset( $settings['__fa4_migrated']['crafto_item_icon'] );
			$is_new                     = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon                       = '';
			$mini_cart_html             = '';
			$crafto_mini_cart_icon_text = ( isset( $settings['crafto_mini_cart_icon_text'] ) && $settings['crafto_mini_cart_icon_text'] ) ? $settings['crafto_mini_cart_icon_text'] : '';
			$icon_align                 = ! empty( $settings['crafto_mini_cart_icon_align'] ) ? $settings['crafto_mini_cart_icon_align'] : 'left';

			if ( null === WC()->cart ) {
				return;
			}

			$option_name   = 'elementor_use_mini_cart_template';
			$new_value_no  = 'no';
			$new_value_yes = 'no';

			if ( get_option( $option_name ) !== false ) {
				update_option( $option_name, $new_value_no );
			} else {
				$autoload = 'no';
				add_option( $option_name, $new_value_no, '', $autoload );
			}

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
				$icon = ob_get_clean();
			} elseif ( isset( $settings['crafto_item_icon']['value'] ) && ! empty( $settings['crafto_item_icon']['value'] ) ) {
				$icon = '<i class="' . esc_attr( $settings['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			ob_start();
			$mini_cart_html .= '<div class="crafto-cart-top-counter cart-top-counter icon-' . $icon_align . '">';
			if ( $crafto_mini_cart_icon_text ) {
				$mini_cart_html .= '<span class="icon-text">' . $crafto_mini_cart_icon_text . '</span>';
			}
			if ( $icon ) {
				$mini_cart_html .= '<div class="elementor-icon">' . $icon . '</div>';
			}

			$mini_cart_html .= '</div>';

			$crafto_header_section_id = function_exists( 'crafto_header_section_id' ) ? crafto_header_section_id() : '';
			if ( $crafto_header_section_id ) {
				update_post_meta( $crafto_header_section_id, '_crafto_mini_cart_html', $mini_cart_html );
			} else {
				update_post_meta( get_the_ID(), '_crafto_mini_cart_html', $mini_cart_html );
			}
			$mini_cart_html .= ob_get_clean();
			?>
			<div class="widget_shopping_cart_content">
				<?php wc_get_template( 'cart/mini-cart.php' ); ?>
			</div>
			<?php
			if ( get_option( $option_name ) !== false ) {
				update_option( $option_name, $new_value_yes );
			} else {
				$autoload = 'no';
				add_option( $option_name, $new_value_yes, '', $autoload );
			}
		}
	}
}
