<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for product list.
 *
 * @package Crafto
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

// If class `Product_List` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Product_List' ) ) {
	class Product_List extends Widget_Base {
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-product-list';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Product list', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-list crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/product-list/';
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
				'woocommerce',
				'wc',
				'shop',
				'store',
				'product',
				'archive',
				'e-commerce',
			];
		}

		/**
		 * Retrieve the list of styles the product list widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$product_list_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$product_list_styles[] = 'crafto-widgets-rtl';
				} else {
					$product_list_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$product_list_styles[] = 'crafto-product-list-rtl-widget';
				}
				$product_list_styles[] = 'crafto-product-list-widget';
			}
			return $product_list_styles;
		}

		/**
		 * Retrieve the list of scripts the product list widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$product_list_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$product_list_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$product_list_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$product_list_scripts[] = 'isotope';
				}

				if ( crafto_disable_module_by_key( 'infinite-scroll' ) ) {
					$product_list_scripts[] = 'infinite-scroll';
				}
				$product_list_scripts[] = 'crafto-wishlist';
				$product_list_scripts[] = 'crafto-product-list-widget';
			}
			return $product_list_scripts;
		}

		/**
		 * Register product list widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_product_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_product_style',
				[
					'label'     => esc_html__( 'Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'shop-boxed',
					'options'   => [
						'shop-boxed'    => esc_html__( 'Boxed', 'crafto-addons' ),
						'shop-standard' => esc_html__( 'Standard', 'crafto-addons' ),
					],
					'separator' => 'after',
				]
			);
			$this->add_responsive_control(
				'crafto_column_settings',
				[
					'label'   => esc_html__( 'Number of Columns', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 3,
					],
					'range'   => [
						'px' => [
							'min'  => 1,
							'max'  => 6,
							'step' => 1,
						],
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
						'custom',
					],
					'default'    => [
						'size' => 10,
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} ul.shop-wrapper li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.products'        => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_bottom_spacing',
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
						'{{WRAPPER}} ul.shop-wrapper li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_product_per_page',
				[
					'label'   => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'default' => 12,
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
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_content_data',
				[
					'label' => esc_html__( 'Data', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_orderby',
				[
					'label'   => esc_html__( 'Order By', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'date',
					'options' => [
						'date'       => esc_html__( 'Date', 'crafto-addons' ),
						'title'      => esc_html__( 'Title', 'crafto-addons' ),
						'price'      => esc_html__( 'Price', 'crafto-addons' ),
						'popularity' => esc_html__( 'Popularity', 'crafto-addons' ),
						'rating'     => esc_html__( 'Rating', 'crafto-addons' ),
						'rand'       => esc_html__( 'Random', 'crafto-addons' ),
						'menu_order' => esc_html__( 'Menu Order', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_order',
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
				'crafto_post_type_selection',
				[
					'label'   => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'product_cat',
					'options' => [
						'product_cat' => esc_html__( 'Categories', 'crafto-addons' ),
						'product_tag' => esc_html__( 'Tags', 'crafto-addons' ),
						'sale'        => esc_html__( 'Sale', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_product_categories_list',
				[
					'label'       => esc_html__( 'Categories', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_product_category_array(),
					'condition'   => [
						'crafto_post_type_selection' => 'product_cat',
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
					'options'     => $this->crafto_product_tags_array(),
					'condition'   => [
						'crafto_post_type_selection' => 'product_tag',
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
				'crafto_include_product_ids',
				[
					'label'       => esc_html__( 'Include Product', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_get_product_array(),
					'description' => esc_html__( 'You can use this option to add certain products from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'include',
					],
				]
			);
			$this->add_control(
				'crafto_exclude_product_ids',
				[
					'label'       => esc_html__( 'Exclude Product', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_get_product_array(),
					'description' => esc_html__( 'You can use this option to remove certain products from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'exclude',
					],
				]
			);
			$this->add_control(
				'crafto_product_offset',
				[
					'label'   => esc_html__( 'Offset', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_product_content_extra_option',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_product_show_title',
				[
					'label'        => esc_html__( 'Enable Title', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_product_show_price',
				[
					'label'        => esc_html__( 'Enable Price', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_product_show_wishlist_icon',
				[
					'label'        => esc_html__( 'Enable Wishlist', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_product_show_cart_icon',
				[
					'label'        => esc_html__( 'Enable Cart', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_product_show_quick_view_icon',
				[
					'label'        => esc_html__( 'Enable Quick View', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_product_show_compare_icon',
				[
					'label'        => esc_html__( 'Enable Compare', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_pagination',
				[
					'label'      => esc_html__( 'Pagination', 'crafto-addons' ),
					'show_label' => false,
				]
			);
			$this->add_control(
				'crafto_pagination',
				[
					'label'   => esc_html__( 'Pagination', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''                           => esc_html__( 'None', 'crafto-addons' ),
						'number-pagination'          => esc_html__( 'Number', 'crafto-addons' ),
						'next-prev-pagination'       => esc_html__( 'Next / Previous', 'crafto-addons' ),
						'infinite-scroll-pagination' => esc_html__( 'Infinite Scroll', 'crafto-addons' ),
						'load-more-pagination'       => esc_html__( 'Load More', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_pagination_next_label',
				[
					'label'     => esc_html__( 'Next Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'NEXT', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_next_icon',
				[
					'label'                  => esc_html__( 'Next Icon', 'crafto-addons' ),
					'type'                   => Controls_Manager::ICONS,
					'fa4compatibility'       => 'icon',
					'default'                => [
						'value'   => 'feather icon-feather-arrow-right',
						'library' => 'feather-solid',
					],
					'recommended'            => [
						'fa-solid'   => [
							'angle-right',
							'caret-square-right',
						],
						'fa-regular' => [
							'caret-square-right',
						],
					],
					'skin'                   => 'inline',
					'exclude_inline_options' => 'svg',
					'label_block'            => false,
					'condition'              => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_prev_label',
				[
					'label'     => esc_html__( 'Previous Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'PREV', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_prev_icon',
				[
					'label'                  => esc_html__( 'Previous Icon', 'crafto-addons' ),
					'type'                   => Controls_Manager::ICONS,
					'fa4compatibility'       => 'icon',
					'default'                => [
						'value'   => 'feather icon-feather-arrow-left',
						'library' => 'feather-solid',
					],
					'recommended'            => [
						'fa-solid'   => [
							'angle-left',
							'caret-square-left',
						],
						'fa-regular' => [
							'caret-square-left',
						],
					],
					'skin'                   => 'inline',
					'exclude_inline_options' => 'svg',
					'label_block'            => false,
					'condition'              => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_load_more_button_label',
				[
					'label'       => esc_html__( 'Button Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Load more', 'crafto-addons' ),
					'render_type' => 'template',
					'condition'   => [
						'crafto_pagination' => 'load-more-pagination',
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
				'crafto_product_section_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_product_general_alignment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options'     => [
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
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors'   => [
						'{{WRAPPER}} ul.shop-wrapper li' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_product_box_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.shop-wrapper.shop-boxed li .shop-box' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_product_style' => 'shop-boxed',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_product_box_border',
					'selector'  => '{{WRAPPER}} ul.shop-wrapper.shop-boxed li .shop-box',
					'exclude'   => [
						'color',
					],
					'condition' => [
						'crafto_product_style' => 'shop-boxed',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_product_box_tabs',
				[
					'condition' => [
						'crafto_product_style' => 'shop-boxed',
					],
				]
			);
				$this->start_controls_tab(
					'crafto_product_box_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);

				$this->add_control(
					'crafto_product_box_border_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.shop-wrapper.shop-boxed li .shop-box' => 'border-color: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_product_box_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_product_style' => 'shop-boxed',
						],
					],
				);
				$this->add_control(
					'crafto_product_box_hover_border_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.shop-wrapper.shop-boxed li .shop-box:hover' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_product_style' => 'shop-boxed',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_product_box_hover_shadow',
					'selector'  => '{{WRAPPER}} ul.shop-wrapper.shop-boxed li .shop-box:hover',
					'condition' => [
						'crafto_product_style' => 'shop-boxed',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_product_content_box_padding',
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
						'{{WRAPPER}} ul.shop-wrapper li .shop-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_icons_style',
				[
					'label'      => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_product_show_wishlist_icon',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_product_show_cart_icon',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_product_show_quick_view_icon',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_product_show_compare_icon',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_product_icons_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.shop-wrapper li .shop-hover a, {{WRAPPER}} ul.shop-wrapper li .shop-hover .button, {{WRAPPER}} ul.shop-wrapper li .shop-hover .added_to_cart' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_product_icons_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.shop-wrapper li .shop-hover a, {{WRAPPER}} ul.shop-wrapper li .shop-hover .button, {{WRAPPER}} ul.shop-wrapper li .shop-hover .added_to_cart' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_icons_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} ul.shop-wrapper li .shop-hover a, {{WRAPPER}} ul.shop-wrapper li .shop-hover .button, {{WRAPPER}} ul.shop-wrapper li .shop-hover .added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_cart_button_style',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_product_style'          => 'shop-standard',
						'crafto_product_show_cart_icon' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_product_cart_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} ul.shop-wrapper.shop-standard li .shop-buttons-wrap a',
				]
			);
			$this->add_control(
				'crafto_product_cart_button_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.shop-wrapper.shop-standard li .shop-buttons-wrap a' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_product_cart_button_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.shop-wrapper.shop-standard li .shop-buttons-wrap a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_product_cart_button_shadow',
					'selector' => '{{WRAPPER}} ul.shop-wrapper.shop-standard li .shop-buttons-wrap a',
				],
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_product_cart_button_border',
					'selector' => '{{WRAPPER}} ul.shop-wrapper.shop-standard li .shop-buttons-wrap a',
				]
			);
			$this->add_responsive_control(
				'crafto_product_cart_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} ul.shop-wrapper.shop-standard li .shop-buttons-wrap a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_product_cart_button_padding',
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
						'{{WRAPPER}} ul.shop-wrapper.shop-standard li .shop-buttons-wrap a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_title_style',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_product_show_title' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_product_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} ul.shop-wrapper li .shop-footer .product-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_product_title_tabs',
			);
			$this->start_controls_tab(
				'crafto_product_title_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_product_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.shop-wrapper li .shop-footer .product-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_product_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
				$this->add_control(
					'crafto_product_title_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.shop-wrapper li .shop-footer .product-title:hover' => 'color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_product_title_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'separator'  => 'before',
					'selectors'  => [
						'{{WRAPPER}} ul.shop-wrapper li .shop-footer .product-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_price_style',
				[
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_product_show_price' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_product_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .shop-footer .price-wrap bdi, {{WRAPPER}} .shop-footer .price-wrap del',
				]
			);
			$this->add_control(
				'crafto_product_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .shop-footer .price-wrap bdi, {{WRAPPER}} .shop-footer .price-wrap del' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_sale_price_style',
				[
					'label'      => esc_html__( 'Sale Price', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_product_sale_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .shop-footer .price-wrap ins .woocommerce-Price-amount bdi',
				]
			);
			$this->add_control(
				'crafto_product_sale_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .shop-footer .price-wrap ins .woocommerce-Price-amount bdi' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_product_section_overlay_style',
				[
					'label' => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_product_overlay_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'types'          => [
						'classic',
						'gradient',
					],
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} ul.shop-wrapper li .shop-box:hover .product-overlay',
				]
			);
			$this->add_control(
				'crafto_product_image_hover_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} ul.shop-wrapper li .shop-box:hover .product-overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_pagination_style',
				[
					'label'      => esc_html__( 'Pagination', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_pagination',
										'operator' => '===',
										'value'    => 'number-pagination',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_pagination',
										'operator' => '===',
										'value'    => 'next-prev-pagination',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_pagination',
										'operator' => '===',
										'value'    => 'load-more-pagination',
									],
								],
							],
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pagination_alignment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => 'center',
					'options'     => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors'   => [
						'{{WRAPPER}} .crafto-pagination' => 'display: flex; justify-content: {{VALUE}};',
					],
					'condition'   => [
						'crafto_pagination' => 'number-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_pagination_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .page-numbers li .page-numbers, {{WRAPPER}} .new-post a , {{WRAPPER}} .old-post a',
					'condition' => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_pagination_tabs',
			);
				$this->start_controls_tab(
					'crafto_pagination_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					]
				);
				$this->add_control(
					'crafto_pagination_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers , {{WRAPPER}} .new-post a , {{WRAPPER}} .old-post a' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_pagination_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					],
				);
				$this->add_control(
					'crafto_pagination_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers:hover, {{WRAPPER}} .new-post a:hover , {{WRAPPER}} .old-post a:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_pagination_bg_hover_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-pagination .page-numbers li a.next:hover, {{WRAPPER}} .crafto-pagination .page-numbers li a.prev:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_pagination_bg_hover_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers:hover, {{WRAPPER}} .new-post a:hover , {{WRAPPER}} .old-post a:hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_pagination_active_tab',
					[
						'label'     => esc_html__( 'Active', 'crafto-addons' ),
						'condition' => [
							'crafto_pagination' => 'number-pagination',
						],
					],
				);
				$this->add_control(
					'crafto_pagination_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers.current' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => 'number-pagination',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_pagination_bg_active_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-pagination .page-numbers li .page-numbers.current' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_pagination_border',
					'selector'  => '{{WRAPPER}} .post-pagination, {{WRAPPER}} .crafto-pagination',
					'condition' => [
						'crafto_pagination' => 'next-prev-pagination',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pagination_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .page-numbers li a i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'number-pagination',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_pagination_space',
				[
					'label'      => esc_html__( 'Space Between', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .page-numbers li' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .page-numbers li' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'number-pagination',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_pagination_margin',
				[
					'label'      => esc_html__( 'Top Space', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-pagination, {{WRAPPER}} .post-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);

			// load more button style.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				],
			);
			$this->start_controls_tabs( 'crafto_tabs_button_style' );
			$this->start_controls_tab(
				'crafto_tab_button_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_control(
				'crafto_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_background_color',
					'types'     => [
						'classic',
						'gradient',
					],
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tab_button_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_control(
				'crafto_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-pagination .view-more-button:hover, {{WRAPPER}} .post-pagination .view-more-button:focus'         => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_button_background_hover_color',
					'types'     => [
						'classic',
						'gradient',
					],
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button:hover, {{WRAPPER}} .post-pagination .view-more-button:focus',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);

			$this->add_control(
				'crafto_button_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-pagination .view-more-button:hover, {{WRAPPER}} .post-pagination .view-more-button:focus' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				],
			);
			$this->add_control(
				'crafto_load_more_button_hover_transition',
				[
					'label'       => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'transition-duration: {{SIZE}}s',
					],
					'condition'   => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_border',
					'selector'       => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition'      => [
						'crafto_pagination' => 'load-more-pagination',
					],
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_button_box_shadow',
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'em',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Register product lis widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function render() {
			global $woocommerce_loop, $crafto_product_unique_id;

			$product_infinite_scroll_classes     = '';
			$settings                            = $this->get_settings_for_display();
			$crafto_product_style                = $this->get_settings( 'crafto_product_style' );
			$crafto_product_per_page             = $this->get_settings( 'crafto_product_per_page' );
			$crafto_product_offset               = $this->get_settings( 'crafto_product_offset' );
			$crafto_post_type_selection          = $this->get_settings( 'crafto_post_type_selection' );
			$crafto_product_categories_list      = $this->get_settings( 'crafto_product_categories_list' );
			$crafto_product_tags_list            = $this->get_settings( 'crafto_product_tags_list' );
			$crafto_include_product_ids          = $this->get_settings( 'crafto_include_product_ids' );
			$crafto_exclude_product_ids          = $this->get_settings( 'crafto_exclude_product_ids' );
			$crafto_orderby                      = $this->get_settings( 'crafto_orderby' );
			$crafto_order                        = $this->get_settings( 'crafto_order' );
			$product_pagination_type             = ( isset( $settings['crafto_pagination'] ) && $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';
			$crafto_enable_masonry               = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';
			$product_show_title                  = ( isset( $settings['crafto_product_show_title'] ) && $settings['crafto_product_show_title'] ) ? $settings['crafto_product_show_title'] : '';
			$product_show_price                  = ( isset( $settings['crafto_product_show_price'] ) && $settings['crafto_product_show_price'] ) ? $settings['crafto_product_show_price'] : '';
			$crafto_product_show_wishlist_icon   = ( isset( $settings['crafto_product_show_wishlist_icon'] ) && $settings['crafto_product_show_wishlist_icon'] ) ? $settings['crafto_product_show_wishlist_icon'] : '';
			$crafto_product_show_cart_icon       = ( isset( $settings['crafto_product_show_cart_icon'] ) && $settings['crafto_product_show_cart_icon'] ) ? $settings['crafto_product_show_cart_icon'] : '';
			$crafto_product_show_quick_view_icon = ( isset( $settings['crafto_product_show_quick_view_icon'] ) && $settings['crafto_product_show_quick_view_icon'] ) ? $settings['crafto_product_show_quick_view_icon'] : '';
			$crafto_product_show_compare_icon    = ( isset( $settings['crafto_product_show_compare_icon'] ) && $settings['crafto_product_show_compare_icon'] ) ? $settings['crafto_product_show_compare_icon'] : '';
			$crafto_column_desktop_column        = ! empty( $settings['crafto_column_settings'] ) ? $settings['crafto_column_settings'] : '3';
			$crafto_column_ratio                 = '';

			$crafto_product_unique_id = ! empty( $crafto_product_unique_id ) ? $crafto_product_unique_id : 1;
			$crafto_product_id        = 'crafto-product';
			$crafto_product_id       .= '-' . $crafto_product_unique_id;
			++$crafto_product_unique_id;

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

			$crafto_column_class      = array();
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';
			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );

			$datasettings = [
				'pagination_type' => $product_pagination_type,
			];

			$this->add_render_attribute(
				'wrapper',
				[
					'data-uniqueid'         => $crafto_product_id,
					'class'                 => [
						'products',
						$crafto_product_id,
						$crafto_product_style,
						'yes' === $settings['crafto_section_enable_grid_preloader'] ? 'grid-loading' : '',
						'shop-wrapper',
						'grid',
						$crafto_column_class_list,
						$product_pagination_type,
					],
					'data-product-settings' => wp_json_encode( $datasettings ),
				]
			);

			if ( 'yes' === $crafto_enable_masonry ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					'grid-masonry'
				);
			} else {
				$this->add_render_attribute(
					'wrapper',
					'class',
					'no-masonry'
				);
			}

			$this->add_render_attribute(
				'inner_wrapper_key',
				[
					'class' => [
						'grid-gutter',
						'grid-item',
						$product_infinite_scroll_classes,
					],
				]
			);

			$crafto_product_per_page        = ( ! empty( $crafto_product_per_page ) ) ? $crafto_product_per_page : -1;
			$crafto_product_categories_list = ( ! empty( $crafto_product_categories_list ) ) ? $crafto_product_categories_list : array();
			$crafto_product_tags_list       = ( ! empty( $crafto_product_tags_list ) ) ? $crafto_product_tags_list : array();

			if ( 'product_tag' === $crafto_post_type_selection ) {
				$categories_to_display_ids = ( ! empty( $crafto_product_tags_list ) ) ? $crafto_product_tags_list : array();
			} else {
				$categories_to_display_ids = ( ! empty( $crafto_product_categories_list ) ) ? $crafto_product_categories_list : array();
			}

			if ( 'product_cat' === $crafto_post_type_selection || 'product_tag' === $crafto_post_type_selection ) {
				// If no categories are chosen or "All categories", we need to load all available categories.
				if ( ! is_array( $categories_to_display_ids ) || 0 === count( $categories_to_display_ids ) ) {

					$terms = get_terms( $crafto_post_type_selection );

					if ( ! is_array( $categories_to_display_ids ) ) {
						$categories_to_display_ids = array();
					}
					foreach ( $terms as $term ) {
						$categories_to_display_ids[] = $term->slug;
					}
				} else {
					$categories_to_display_ids = array_values( $categories_to_display_ids );
				}
			}

			$woocommerce_loop['columns'] = $this->get_settings( 'crafto_product_column_type' );

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$query_args = array(
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true,
				'post_type'           => 'product',
				'posts_per_page'      => intval( $crafto_product_per_page ), // phpcs:ignore
				'paged'               => $paged,
			);

			if ( ! empty( $crafto_product_offset ) ) {
				$query_args['offset'] = $crafto_product_offset;
			}

			$query_args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore
			$query_args['tax_query']  = []; // phpcs:ignore

			if ( ! empty( $crafto_orderby ) && ! empty( $crafto_order ) ) {

				$ordering_args         = WC()->query->get_catalog_ordering_args( $crafto_orderby, $crafto_order );
				$query_args['orderby'] = $crafto_orderby;
				$query_args['order']   = $crafto_order;
			}

			if ( ! empty( $crafto_include_product_ids ) ) {
				$crafto_include_product_ids = array_merge( $crafto_include_product_ids );
			}

			if ( ! empty( $crafto_exclude_product_ids ) ) {
				$crafto_exclude_product_ids = array_merge( $crafto_exclude_product_ids );
			}

			if ( ! empty( $crafto_include_product_ids ) ) {
				$query_args['post__in'] = $crafto_include_product_ids;
			}

			if ( ! empty( $crafto_exclude_product_ids ) ) {
				$query_args['post__not_in'] = $crafto_exclude_product_ids;
			}

			if ( $ordering_args['meta_key'] ) {
				$query_args['meta_key'] = $ordering_args['meta_key']; // phpcs:ignore
			}
			if ( 'product_cat' === $crafto_post_type_selection || 'product_tag' === $crafto_post_type_selection ) {

				if ( ! empty( $categories_to_display_ids ) ) {
					$query_args['tax_query'][] = [
						[
							'taxonomy' => $crafto_post_type_selection,
							'field'    => 'slug',
							'terms'    => $categories_to_display_ids,
							'operator' => 'IN',
						],
					];
				}
			} elseif ( 'sale' === $crafto_post_type_selection ) {

				$post__in = wc_get_product_ids_on_sale();

				$query_args['post__in'] = $post__in;
				remove_action( 'pre_get_posts', [ WC()->query, 'product_query' ] );
			}

			$query_args['tax_query'][] = [
				'taxonomy' => 'product_visibility',
				'field'    => 'slug',
				'terms'    => 'exclude-from-catalog', // Possibly 'exclude-from-search' too.
				'operator' => 'NOT IN',
			];

			$the_query = new \WP_Query( $query_args );

			if ( $the_query->have_posts() ) {
				?>
				<ul <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<?php
					if ( 'yes' === $crafto_enable_masonry ) {
						?>
						<li class="grid-sizer d-none p-0 m-0"></li>
						<?php
					}
					$index = 0;
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						if ( 0 === $index % $crafto_column_ratio ) {
							$grid_count = 1;
						}

						switch ( $crafto_product_style ) {
							case 'shop-boxed':
								?>
								<li <?php $this->print_render_attribute_string( 'inner_wrapper_key' ); ?>>
									<div class="shop-box">
										<div class="shop-image">
											<a href="<?php the_permalink(); ?>">
												<?php
												woocommerce_show_product_loop_sale_flash();
												woocommerce_template_loop_product_thumbnail();
												?>
												<div class="product-overlay"></div>
											</a>
											<?php
											if ( 'yes' === $crafto_product_show_wishlist_icon || 'yes' === $crafto_product_show_cart_icon || 'yes' === $crafto_product_show_quick_view_icon || 'yes' === $crafto_product_show_compare_icon ) {
												?>
												<div class="shop-hover" data-tooltip-position="top">
													<?php
													if ( 'yes' === $crafto_product_show_cart_icon ) {
														woocommerce_template_loop_add_to_cart();
													}
													if ( 'yes' === $crafto_product_show_quick_view_icon ) {
														crafto_addons_template_loop_product_quick_view();
													}
													if ( 'yes' === $crafto_product_show_wishlist_icon ) {
														crafto_addons_template_loop_product_wishlist();
													}
													if ( 'yes' === $crafto_product_show_compare_icon ) {
														crafto_addons_template_loop_product_compare();
													}
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
										if ( 'yes' === $product_show_title || 'yes' === $product_show_price ) {
											?>
											<div class="shop-footer">
												<?php
												if ( 'yes' === $product_show_title ) {
													?>
													<a class="product-title" href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
													<?php
												}

												if ( 'yes' === $product_show_price ) {
													?>
													<div class="price-wrap"><?php woocommerce_template_loop_price(); ?></div>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>
									</div>
								</li>
								<?php
								break;
							case 'shop-standard':
								?>
								<li class="grid-item">
									<div class="shop-box">
										<div class="shop-image">
											<a href="<?php the_permalink(); ?>">
												<?php
												woocommerce_show_product_loop_sale_flash();
												woocommerce_template_loop_product_thumbnail();
												?>
												<div class="product-overlay"></div>
											</a>
											<?php
											if ( 'yes' === $crafto_product_show_cart_icon ) {
												?>
												<div class="shop-buttons-wrap">
													<?php
													woocommerce_template_loop_add_to_cart();
													?>
												</div>
												<?php
											}
											if ( 'yes' === $crafto_product_show_wishlist_icon || 'yes' === $crafto_product_show_quick_view_icon || 'yes' === $crafto_product_show_compare_icon ) {
												?>
												<div class="shop-hover" data-tooltip-position="left">
													<?php
													if ( 'yes' === $crafto_product_show_quick_view_icon ) {
														crafto_addons_template_loop_product_quick_view();
													}
													if ( 'yes' === $crafto_product_show_wishlist_icon ) {
														crafto_addons_template_loop_product_wishlist();
													}
													if ( 'yes' === $crafto_product_show_compare_icon ) {
														crafto_addons_template_loop_product_compare();
													}
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
										if ( 'yes' === $product_show_title || 'yes' === $product_show_price ) {
											?>
											<div class="shop-footer">
												<?php
												if ( 'yes' === $product_show_title ) {
													?>
													<a class="product-title" href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
													<?php
												}

												if ( 'yes' === $product_show_price ) {
													?>
													<div class="price-wrap"><?php woocommerce_template_loop_price(); ?></div>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>
									</div>
								</li>
								<?php
								break;
						}
						++$index;
						++$grid_count;
					}
					get_next_posts_page_link( $the_query->max_num_pages );
					?>
				</ul>
				<?php
				crafto_post_pagination( $the_query, $settings );
				wp_reset_postdata();
			}
		}

		/**
		 * Return product categories array.
		 */
		public function crafto_product_category_array() {
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

		/**
		 * Return product tags array.
		 */
		public function crafto_product_tags_array() {
			$tags_array = [];

			$tags = get_terms(
				[
					'taxonomy'   => 'product_tag',
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
				]
			);

			if ( ! is_wp_error( $tags ) && ! empty( $tags ) ) {
				foreach ( $tags as $tag ) {
					$tags_array[ $tag->slug ] = $tag->name;
				}
			}
			return $tags_array;
		}

		/**
		 * Return Product array
		 */
		public function crafto_get_product_array() {
			global $wpdb;
			// phpcs:ignore
			$results = $wpdb->get_results( "
				SELECT ID, post_title
				FROM {$wpdb->posts}
				WHERE post_type = 'product'
				AND post_status = 'publish'
				ORDER BY post_title ASC
			", OBJECT_K ); // phpcs:ignore

			$post_array = [];

			if ( ! empty( $results ) ) {
				foreach ( $results as $id => $row ) {
					$post_array[ $id ] = $row->post_title ? $row->post_title : esc_html__( '(no title)', 'crafto-addons' );
				}
			}

			return $post_array;
		}
	}
}
