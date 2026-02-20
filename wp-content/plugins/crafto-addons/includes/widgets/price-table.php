<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use CraftoAddons\Classes\Elementor_Templates;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Button_Group_Control;

/**
 *
 * Crafto widget for price table.
 *
 * @package Crafto
 */

// If class `Price_Table` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Price_Table' ) ) {
	/**
	 * Define `Price_Table` class.
	 */
	class Price_Table extends Widget_Base {
		/**
		 * Retrieve the list of styles the Price table widget depended on.
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
				return [ 'crafto-price-table' ];
			}
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve price table widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-price-table';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve price table widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Price Table', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve price table widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-price-table crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/price-table/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return string Widget categories.
		 */
		public function get_categories() {
			return array(
				'crafto',
			);
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
				'list',
				'plans',
				'packages',
				'pricing plan',
			];
		}

		/**
		 * Register price table widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_item_content_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_item_content_type',
				[
					'label'       => esc_html__( 'Content Type', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'editor',
					'options'     => [
						'template' => esc_html__( 'Template', 'crafto-addons' ),
						'editor'   => esc_html__( 'Editor', 'crafto-addons' ),
					],
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_item_template_id',
				[
					'label'       => esc_html__( 'Choose Template', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT2,
					'default'     => '0',
					'options'     => Elementor_Templates::get_elementor_templates_options(),
					'condition'   => [
						'crafto_item_content_type' => 'template',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_item_use_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_item_content_type' => 'editor',
					],
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
					'condition'        => [
						'crafto_item_use_image'    => '',
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_item_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_item_use_image'    => 'yes',
						'crafto_item_content_type' => 'editor',
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
					'condition'    => [
						'crafto_item_use_image'    => '',
						'crafto_item_content_type' => 'editor',
					],
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
					'default'      => 'circle',
					'condition'    => [
						'crafto_view!'             => 'default',
						'crafto_item_use_image'    => '',
						'crafto_item_content_type' => 'editor',
					],
					'prefix_class' => 'elementor-shape-',
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'exclude'   => [
						'custom',
					],
					'condition' => [
						'crafto_item_use_image'    => 'yes',
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Title', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_title_size',
				[
					'label'     => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default'   => 'div',
					'condition' => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_subtitle',
				[
					'label'       => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);

			$this->add_control(
				'crafto_price_table_price',
				[
					'label'       => esc_html__( 'Price', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( '$100', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'monthly', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_control(
				'crafto_item_content',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'type'      => Controls_Manager::WYSIWYG,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
					'condition' => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->end_controls_section();

			Button_Group_Control::button_content_fields(
				$this,
				[
					'type'    => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => '',
					'repeat'  => 'no',
				],
				[
					'condition' => [
						'crafto_item_content_type' => 'editor',
					],
				],
			);

			$this->start_controls_section(
				'crafto_price_table_section_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_box_alignment',
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
					'default'     => 'center',
					'selectors'   => [
						'{{WRAPPER}} .pricing-table' => 'text-align: {{VALUE}}',
					],
					'condition'   => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_price_table_box_bg_color',
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
					'selector'  => '{{WRAPPER}} .pricing-table',
					'condition' => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_price_table_box_border',
					'selector'  => '{{WRAPPER}} .pricing-table',
					'condition' => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_box_padding',
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
						'{{WRAPPER}} .pricing-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_box_margin',
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
						'{{WRAPPER}} .pricing-table' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_price_table_box_shadow',
					'selector'  => '{{WRAPPER}} .pricing-table',
					'condition' => [
						'crafto_item_content_type' => 'editor',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_price_table_section_label_style',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_content_type'  => 'editor',
						'crafto_price_table_label!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_table_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .pricing-table .popular-label',
				]
			);
			$this->add_control(
				'crafto_price_table_label_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pricing-table .popular-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_price_table_label_bg_color',
					'types'    => [
						'classic',
						'gradient',
					],
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .pricing-table .popular-label',
				]
			);
			$this->add_control(
				'crafto_price_table_label_position',
				[
					'label'     => esc_html__( 'Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''         => esc_html__( 'Default', 'crafto-addons' ),
						'absolute' => esc_html__( 'Absolute', 'crafto-addons' ),
						'fixed'    => esc_html__( 'Fixed', 'crafto-addons' ),
						'relative' => esc_html__( 'Relative', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .pricing-table .popular-label' => 'position: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_label_padding',
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
						'{{WRAPPER}} .pricing-table .popular-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_label_margin',
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
						'{{WRAPPER}} .pricing-table .popular-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_price_table_box_icon_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_content_type'   => 'editor',
						'crafto_item_icon[library]!' => '',
					],
				]
			);
			$this->start_controls_tabs( 'icon_colors' );

			$this->start_controls_tab(
				'crafto_price_table_icon_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_item_use_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_item_use_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-framed .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg, {{WRAPPER}}.elementor-view-framed .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_primary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_item_use_image' => '',
						'crafto_view'           => 'stacked',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_item_use_image' => '',
						'crafto_view'           => 'framed',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_icon_border_width',
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
				'crafto_price_table_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ '%', 'px', 'custom' ],
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
				'crafto_price_table_icon_colors_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_item_use_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_hover_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_item_use_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon i:before, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon i, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_hover_primary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_item_use_image' => '',
						'crafto_view'           => 'stacked',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_icon_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_item_use_image' => '',
						'crafto_view'           => 'framed',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 60,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_item_use_image' => '',
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
							'max' => 120,
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
						'crafto_item_use_image' => '',
						'crafto_view!'          => 'default',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_icon_image_size',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
						'%'  => [
							'max' => 100,
							'min' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .pricing-table img' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_item_use_image' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_icon_margin',
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
						'{{WRAPPER}} .elementor-icon, {{WRAPPER}} .pricing-table img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_price_table_section_title_style',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_content_type'  => 'editor',
						'crafto_price_table_title!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_table_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .pricing-table .title',
				]
			);
			$this->add_control(
				'crafto_price_table_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pricing-table .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_title_margin',
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
					'selectors'  => [
						'{{WRAPPER}} .pricing-table .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_price_table_section_subtitle_style',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_content_type'     => 'editor',
						'crafto_price_table_subtitle!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_table_subtitle_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .pricing-table .subtitle',
				]
			);
			$this->add_control(
				'crafto_price_table_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pricing-table .subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_subtitle_margin',
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
					'selectors'  => [
						'{{WRAPPER}} .pricing-table .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_price_table_section_price_style',
				[
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_content_type'  => 'editor',
						'crafto_price_table_price!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_table_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .pricing-table .price',
				]
			);
			$this->add_control(
				'crafto_price_table_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pricing-table .price' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_price_margin',
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
					'selectors'  => [
						'{{WRAPPER}} .pricing-table .price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_price_table_section_duration_style',
				[
					'label'     => esc_html__( 'Duration', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_content_type'     => 'editor',
						'crafto_price_table_duration!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_table_duration_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .pricing-table .duration',
				]
			);
			$this->add_control(
				'crafto_price_table_duration_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pricing-table .duration' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_table_duration_margin',
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
					'selectors'  => [
						'{{WRAPPER}} .pricing-table .duration' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_price_table_section_content_style',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_content_type' => 'editor',
						'crafto_item_content!'     => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_item_content_alignment',
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
					'default'     => '',
					'selectors'   => [
						'{{WRAPPER}} .pricing-table .pricing-body' => 'text-align: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_item_content_typography',
					'selector' => '{{WRAPPER}} .pricing-table .pricing-body',
				]
			);
			$this->add_control(
				'crafto_item_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pricing-table .pricing-body' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_item_content_margin',
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
					'selectors'  => [
						'{{WRAPPER}} .pricing-table .pricing-body' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_price_table_border_heading',
				[
					'label'     => esc_html__( 'Only for <ul> element', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_price_table_border_ul_li',
					'selector' => '{{WRAPPER}} .pricing-table .pricing-body ul li',
				]
			);
			$this->end_controls_section();
			Button_Group_Control::button_style_fields(
				$this,
				[
					'type'  => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_item_content_type' => 'editor',
					],
				],
			);
		}

		/**
		 * Render price table widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                 = $this->get_settings_for_display();
			$crafto_item_content_type = ( isset( $settings['crafto_item_content_type'] ) && $settings['crafto_item_content_type'] ) ? $settings['crafto_item_content_type'] : '';
			$crafto_item_template_id  = ( isset( $settings['crafto_item_template_id'] ) && $settings['crafto_item_template_id'] ) ? $settings['crafto_item_template_id'] : '';
			$crafto_item_content      = ( isset( $settings['crafto_item_content'] ) && $settings['crafto_item_content'] ) ? $settings['crafto_item_content'] : '';
			$crafto_label             = ( isset( $settings['crafto_price_table_label'] ) && $settings['crafto_price_table_label'] ) ? $settings['crafto_price_table_label'] : '';
			$crafto_title             = ( isset( $settings['crafto_price_table_title'] ) && $settings['crafto_price_table_title'] ) ? $settings['crafto_price_table_title'] : '';
			$crafto_subtitle          = ( isset( $settings['crafto_price_table_subtitle'] ) && $settings['crafto_price_table_subtitle'] ) ? $settings['crafto_price_table_subtitle'] : '';
			$crafto_price             = ( isset( $settings['crafto_price_table_price'] ) && $settings['crafto_price_table_price'] ) ? $settings['crafto_price_table_price'] : '';
			$crafto_duration          = ( isset( $settings['crafto_price_table_duration'] ) && $settings['crafto_price_table_duration'] ) ? $settings['crafto_price_table_duration'] : '';
			$migrated                 = isset( $settings['__fa4_migrated']['crafto_item_icon'] );
			$is_new                   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon                     = '';

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
				$icon = ob_get_clean();
			} elseif ( isset( $settings['crafto_item_icon']['value'] ) && ! empty( $settings['crafto_item_icon']['value'] ) ) {
				$icon = '<i class="' . esc_attr( $settings['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
			?>

			<div class="pricing-table">
				<?php
				if ( 'editor' === $crafto_item_content_type && ( ! empty( $crafto_label ) || ! empty( $crafto_title ) || ! empty( $crafto_subtitle ) || ! empty( $crafto_price ) || ! empty( $crafto_duration ) ) ) {
					?>
					<div class="pricing-header">
						<?php
						if ( ! empty( $crafto_label ) ) {
							?>
							<div class="popular-label">
								<?php echo esc_html( $crafto_label ); ?>
							</div>
							<?php
						}

						if ( ! empty( $settings['crafto_item_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_item_image']['id'] ) ) {
							$settings['crafto_item_image']['id'] = '';
						}
						if ( ! empty( $icon ) && ( '' === $settings['crafto_item_use_image'] ) ) {
							?>
							<div class="elementor-icon">
								<?php printf( '%s', $icon ); // phpcs:ignore ?>
							</div>
							<?php
						} elseif ( isset( $settings['crafto_item_image'] ) && isset( $settings['crafto_item_image']['id'] ) && ! empty( $settings['crafto_item_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_item_image']['id'], $settings['crafto_item_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_item_image'] ) && isset( $settings['crafto_item_image']['url'] ) && ! empty( $settings['crafto_item_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_item_image']['id'], $settings['crafto_item_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}

						if ( ! empty( $crafto_title ) ) {
							?>
							<<?php echo $this->get_settings( 'crafto_price_table_title_size' ); // phpcs:ignore ?> class="title">
								<?php echo esc_html( $crafto_title ); ?>
							</<?php echo $this->get_settings( 'crafto_price_table_title_size' ); // phpcs:ignore ?>>
							<?php
						}

						if ( ! empty( $crafto_subtitle ) ) {
							?>
							<div class="subtitle">
								<?php echo esc_html( $crafto_subtitle ); ?>
							</div>
							<?php
						}

						if ( ! empty( $crafto_price ) ) {
							?>
							<div class="price">
								<?php echo esc_html( $crafto_price ); ?>
							</div>
							<?php
						}

						if ( ! empty( $crafto_duration ) ) {
							?>
							<span class="duration">
								<?php echo esc_html( $crafto_duration ); ?>
							</span>
							<?php
						}
						?>
					</div>
					<?php
				}

				if ( 'template' === $crafto_item_content_type ) {
					if ( '0' !== $crafto_item_template_id ) {
						$template_content = \Crafto_Addons_Extra_Functions::crafto_get_builder_content_for_display( $crafto_item_template_id );
						if ( ! empty( $template_content ) ) {
							if ( Plugin::$instance->editor->is_edit_mode() ) {
								$edit_url = add_query_arg(
									array(
										'elementor' => '',
									),
									get_permalink( $crafto_item_template_id )
								);
								echo sprintf( '<div class="edit-template-with-light-box elementor-template-edit-cover" data-template-edit-link="%s"><i aria-hidden="true" class="eicon-edit"></i><span>%s</span></div>', esc_url( $edit_url ), esc_html__( 'Edit Template', 'crafto-addons' ) ); // phpcs:ignore
							}
							echo sprintf( '%s', $template_content ); // phpcs:ignore
						} else {
							echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
						}
					} else {
						echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
					}
				} else {
					?>
					<div class="pricing-body">
						<?php echo sprintf( '%s', $this->parse_text_editor( $crafto_item_content ) ); // phpcs:ignore ?>
					</div>
					<?php
				}
				if ( 'editor' === $crafto_item_content_type ) {
					?>
					<div class="pricing-footer">
						<?php Button_Group_Control::render_button_content( $this, 'primary' ); ?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
