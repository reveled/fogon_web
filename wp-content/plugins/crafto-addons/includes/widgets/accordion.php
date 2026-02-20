<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Classes\Elementor_Templates;

/**
 *
 * Crafto widget for accordion.
 *
 * @package Crafto
 */

// If class `Accordion` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Accordion' ) ) {
	/**
	 * Define `Accordion` class.
	 */
	class Accordion extends Widget_Base {

		/**
		 * Retrieve the list of scripts the accordian widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-accordion-widget' ];
			}
		}

		/**
		 * Retrieve the list of styles the accordion widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$accordion_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$accordion_styles[] = 'crafto-widgets-rtl';
				} else {
					$accordion_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$accordion_styles[] = 'crafto-accordion-rtl-widget';
				}
				$accordion_styles[] = 'crafto-accordion-widget';
			}
			return $accordion_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve accordion widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-accordion';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve accordion widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Accordion', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve accordion widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-accordion crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/accordion/';
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
				'accordion',
				'tabs',
				'toggle',
				'faq',
				'expandable',
			];
		}

		/**
		 * Register accordion widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_accordion_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'accordion-style-1',
					'options'            => [
						'accordion-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'accordion-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'accordion-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_accordion_active',
				[
					'label'        => esc_html__( 'Active First Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_title',
				[
					'label' => esc_html__( 'Accordion', 'crafto-addons' ),
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_accordian_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'show_label'  => true,
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_accordian_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => '',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$repeater->add_control(
				'crafto_accordion_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Accordion Title', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
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
			$repeater->add_control(
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
			$repeater->add_control(
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
			$repeater->add_control(
				'crafto_item_icon',
				[
					'label'            => esc_html__( 'Content Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => '',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$repeater->add_control(
				'crafto_accordian_event_time',
				[
					'label'       => esc_html__( 'Time', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'show_label'  => true,
					'label_block' => true,
					'default'     => esc_html__( '12:00:00', 'crafto-addons' ),
					'description' => esc_html__( 'Applicable in style 3 only.', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tabs',
				[
					'label'       => esc_html__( 'Accordion Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_accordian_number' => esc_html__( '01', 'crafto-addons' ),
							'crafto_accordion_title'  => esc_html__( 'Accordion #1', 'crafto-addons' ),
							'crafto_item_content'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
						],
						[
							'crafto_accordian_number' => esc_html__( '02', 'crafto-addons' ),
							'crafto_accordion_title'  => esc_html__( 'Accordion #2', 'crafto-addons' ),
							'crafto_item_content'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
						],
						[
							'crafto_accordian_number' => esc_html__( '03', 'crafto-addons' ),
							'crafto_accordion_title'  => esc_html__( 'Accordion #3', 'crafto-addons' ),
							'crafto_item_content'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_accordion_title }}}',
				]
			);
			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Expander Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'separator'        => 'before',
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fa-solid fa-plus',
						'library' => 'fa-solid',
					],
					'recommended'      => [
						'fa-solid'   => [
							'chevron-down',
							'angle-down',
							'angle-double-down',
							'caret-down',
							'caret-square-down',
						],
						'fa-regular' => [
							'caret-square-down',
						],
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->add_control(
				'crafto_selected_active_icon',
				[
					'label'            => esc_html__( 'Expander Active Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon_active',
					'default'          => [
						'value'   => 'fa-solid fa-minus',
						'library' => 'fa-solid',
					],
					'recommended'      => [
						'fa-solid'   => [
							'chevron-up',
							'angle-up',
							'angle-double-up',
							'caret-up',
							'caret-square-up',
						],
						'fa-regular' => [
							'caret-square-up',
						],
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_title_html_tag',
				[
					'label'     => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'  => 'H1',
						'h2'  => 'H2',
						'h3'  => 'H3',
						'h4'  => 'H4',
						'h5'  => 'H5',
						'h6'  => 'H6',
						'div' => 'div',
					],
					'default'   => 'div',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_faq_schema',
				[
					'label'        => esc_html__( 'Enable FAQ Schema', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'separator'    => 'before',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_title_style',
				[
					'label' => esc_html__( 'Accordion Item', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->start_controls_tabs( 'crafto_accordion_background_tabs' );
			$this->start_controls_tab(
				'crafto_accordion_item_background_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_accordion_item_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-accordion-item',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_accordion_box_shadow_normal',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-accordion-item',
				]
			);
			$this->add_responsive_control(
				'crafto_accordion_item_padding',
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
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_accordion_item_background_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_accordion_active_item_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-accordion-item.elementor-item-active',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_accordion_box_shadow_active',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-item-active',
				]
			);
			$this->add_responsive_control(
				'crafto_accordion_active_item_padding',
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
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-item.elementor-item-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_accordion_item_border',
					'selector'       => '{{WRAPPER}} .elementor-accordion .elementor-accordion-item:not(:last-child)',
					'separator'      => 'before',
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_accordion_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_accordion_margin',
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
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_accordion_number_style_section',
				[
					'label' => esc_html__( 'Number', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_accordion_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-title .number',
				]
			);
			$this->add_control(
				'crafto_accordion_number_type',
				[
					'label'   => esc_html__( 'Title Type', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'normal' => [
							'title' => esc_html__( 'Normal', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter-bold',
						],
						'stroke' => [
							'title' => esc_html__( 'Stroke', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter',
						],
					],
					'default' => 'normal',
				]
			);
			$this->start_controls_tabs( 'crafto_accordion_number_tabs' );
			$this->start_controls_tab(
				'crafto_accordion_number_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_accordion_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_accordion_number_bg_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .elementor-accordion .elementor-tab-title .number',
					'condition' => [
						'crafto_accordion_style!' => [
							'accordion-style-2',
							'accordion-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_accordion_number_text_stroke',
					'selector'       => '{{WRAPPER}} .number',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_accordion_number_type' => 'stroke',
						'crafto_accordion_style!'      => [
							'accordion-style-1',
							'accordion-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_number_width',
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
							'min'  => 0,
							'max'  => 75,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .number' => 'width: {{SIZE}}{{UNIT}};height:{{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_accordion_style!' => [
							'accordion-style-2',
							'accordion-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_number_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_accordion_style' => [
							'accordion-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_number_padding',
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
						'{{WRAPPER}} .number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_accordion_number_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_accordion_number_active_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_accordion_number_active_bg_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .number',
					'condition' => [
						'crafto_accordion_style!' => [
							'accordion-style-2',
							'accordion-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_accordion_number_active_stroke',
					'selector'       => '{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .number',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_accordion_number_type' => 'stroke',
						'crafto_accordion_style!'      => [
							'accordion-style-1',
							'accordion-style-3',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_accordion_icon_style',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_accordion_style!' => [
							'accordion-style-3',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_accordion_tabs'
			);
			$this->start_controls_tab(
				'crafto_accordion_color_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_accordion_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_color_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_icon_color_active',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_accordion_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 14,
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 75,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .icon svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .icon' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-accordion .elementor-tab-title .icon' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_event_time',
				[
					'label'     => esc_html__( 'Event Time and Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_accordion_style' => [
							'accordion-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_event_time_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time',
				]
			);
			$this->add_responsive_control(
				'crafto_event_time_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_accordion_event_time'
			);
			$this->start_controls_tab(
				'crafto_event_time_color_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_event_time_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_event_time_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_event_time_active',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .event-time' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_event_time_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 14,
					],
					'range'      => [
						'px' => [
							'min' => 6,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time svg' => 'width: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_event_time_spacing',
				[
					'label'      => esc_html__( 'Icon Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time i' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time svg' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time i, .rtl {{WRAPPER}} .elementor-accordion .elementor-tab-title .event-time svg' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_toggle_style_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-title',
				]
			);
			$this->start_controls_tabs( 'crafto_accordion_title_tabs' );
			$this->start_controls_tab(
				'crafto_accordion_title_normal_tab',
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
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title'                 => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .title'          => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-icon' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_title_border',
					'selector'       => '{{WRAPPER}} .elementor-accordion .elementor-tab-title',
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_title_padding',
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
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_accordion_title_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_tab_active_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active'                 => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .title'          => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .elementor-icon' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_section_active_accordion_title_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-item .elementor-tab-title.elementor-active' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_title_border_border!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_section_active_accordion_title_padding',
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
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-item .elementor-tab-title.elementor-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_toggle_style_icon',
				[
					'label'     => esc_html__( 'Expander Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_selected_icon[value]!' => '',
					],
				]
			);

			$this->add_control(
				'crafto_icon_align',
				[
					'label'   => esc_html__( 'Alignment', 'crafto-addons' ),
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
			$this->add_responsive_control(
				'crafto_icon_width',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
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
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  =>
					[
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_space_left',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-icon.elementor-accordion-icon-left' => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-accordion .elementor-accordion-icon.elementor-accordion-icon-left' => 'margin-inline-start: {{SIZE}}{{UNIT}};'
					],
					'condition'  => [
						'crafto_icon_align' => [
							'left',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_space_right',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-icon.elementor-accordion-icon-right' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-accordion .elementor-accordion-icon.elementor-accordion-icon-right' => 'margin-inline-end: {{SIZE}}{{UNIT}};'
					],
					'condition'  => [
						'crafto_icon_align' => [
							'right',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_accordion_title_icon_tabs' );
			$this->start_controls_tab(
				'crafto_accordion_title_icon_normal_tab',
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
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon i:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon svg'      => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_color_background',
				[
					'label'     => esc_html__( 'Background', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-icon-closed' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_accordion_title_icon_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_icon_active_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .elementor-accordion-icon i:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .elementor-accordion-icon svg'      => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_active_color_background',
				[
					'label'     => esc_html__( 'Background', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-accordion-icon-opened' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_icon_border',
					'selector'       => '{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon',
					'separator'      => 'before',
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_toggle_style_content',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-content .panel-tab-content',
				]
			);
			$this->add_control(
				'crafto_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-accordion .elementor-tab-content .panel-tab-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_width',
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
							'min' => 10,
							'max' => 100,
						],
						'%'  => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .panel-tab-content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_content_border',
					'selector'       => '{{WRAPPER}} .elementor-accordion .elementor-tab-content .panel-tab-content',
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_content_padding',
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
						'{{WRAPPER}} .elementor-accordion .elementor-tab-content .panel-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_margin',
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
						'{{WRAPPER}} .elementor-accordion .elementor-tab-content .panel-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_content_icon',
				[
					'label' => esc_html__( 'Content Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_description_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tab-item-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .tab-item-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_description_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 80,
					],
					'range'      => [
						'px' => [
							'min' => 0,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .tab-item-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tab-item-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.05,
						],
					],
					'default'    => [
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .tab-item-icon' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_description_icon_margin',
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
						'{{WRAPPER}} .tab-item-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render accordion widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                     = $this->get_settings_for_display();
			$active_tab                   = $settings['crafto_accordion_active'];
			$crafto_accordion_style       = ( isset( $settings['crafto_accordion_style'] ) && $settings['crafto_accordion_style'] ) ? $settings['crafto_accordion_style'] : 'accordion-style-1';
			$crafto_accordion_number_type = ( isset( $settings['crafto_accordion_number_type'] ) && ! empty( $settings['crafto_accordion_number_type'] ) ) ? $settings['crafto_accordion_number_type'] : '';

			if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
				// @todo: remove when deprecated
				// added as bc in 2.6
				// add old default
				$settings['icon']              = 'fa fa-plus';
				$settings['icon_active']       = 'fa fa-minus';
				$settings['crafto_icon_align'] = $this->get_settings( 'crafto_icon_align' );
			}

			$migrated = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$id_int   = $this->get_id_int();

			$this->add_render_attribute(
				'wrapper',
				[
					'class' => [
						'elementor-accordion',
						$crafto_accordion_style,
					],
				],
			);

			if ( 'yes' === $active_tab ) {
				$this->add_render_attribute(
					'wrapper',
					[
						'class' => [
							'elementor-default-active-yes',
						],
					],
				);
			}

			$this->add_render_attribute(
				'number',
				[
					'class' => [
						'number',
					],
				],
			);
			if ( 'stroke' === $crafto_accordion_number_type ) {
				$this->add_render_attribute(
					'number',
					'class',
					[
						'text-stroke',
					]
				);
			}
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$has_icon = ( ! $is_new || ! empty( $settings['crafto_selected_icon']['value'] ) );
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				foreach ( $settings['crafto_tabs'] as $index => $item ) {
					$first_item              = ( 0 === $index && '' !== $active_tab ) ? 'elementor-item-active' : '';
					$aria_expanded           = ( 0 === $index && '' !== $active_tab ) ? 'true' : 'false';
					$active_content          = ( 0 === $index && '' !== $active_tab ) ? 'elementor-active' : '';
					$tab_count               = $index + 1;
					$tab_number_setting_key  = $this->get_repeater_setting_key( 'crafto_tab_panel_number', 'crafto_tabs', $index );
					$tab_title_setting_key   = $this->get_repeater_setting_key( 'crafto_tab_panel_title', 'crafto_tabs', $index );
					$tab_content_setting_key = $this->get_repeater_setting_key( 'crafto_tab_panel_content', 'crafto_tabs', $index );
					$tab_icon_setting_key    = $this->get_repeater_setting_key( 'crafto_tab_panel_icon', 'crafto_tabs', $index );

					$migrated1 = isset( $item['__fa4_migrated']['crafto_item_icon'] );
					$is_new1   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

					$migrated_icon = isset( $item['__fa4_migrated']['crafto_accordian_icon'] );
					$is_new_icon   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

					$this->add_render_attribute(
						$tab_number_setting_key,
						[
							'id'              => 'elementor-accordion-number-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
							'class'           => [
								'elementor-number-content',
							],
							'data-tab'        => esc_attr( $tab_count ),
							'role'            => 'region',
							'aria-labelledby' => 'elementor-accordion-title-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
						],
					);

					$this->add_render_attribute(
						$tab_title_setting_key,
						[
							'id'            => 'elementor-accordion-title-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
							'class'         => [
								'elementor-tab-title',
								'elementor-repeater-item-' . $item['_id'],
								$active_content,
							],
							'data-tab'      => esc_attr( $tab_count ),
							'role'          => 'button',
							'aria-expanded' => $aria_expanded,
							'aria-controls' => 'elementor-accordion-content-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
						],
					);

					$this->add_render_attribute(
						$tab_content_setting_key,
						[
							'id'              => 'elementor-accordion-content-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
							'class'           => [
								'elementor-tab-content',
								$active_content,
							],
							'data-tab'        => esc_attr( $tab_count ),
							'role'            => 'region',
							'aria-labelledby' => 'elementor-accordion-title-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
						],
					);

					$this->add_render_attribute(
						$tab_icon_setting_key,
						[
							'id'              => 'elementor-accordion-icon-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
							'class'           => [
								'elementor-tab-icon',
							],
							'data-tab'        => esc_attr( $tab_count ),
							'role'            => 'region',
							'aria-labelledby' => 'elementor-accordion-title-' . esc_attr( $id_int ) . esc_attr( $tab_count ),
						],
					);

					if ( ! empty( $item['crafto_accordion_title'] ) || ! empty( $item['crafto_item_content'] ) ) {
						?>
						<div class="elementor-accordion-item <?php echo $first_item; // phpcs:ignore ?>">
							<<?php echo esc_attr( $settings['crafto_title_html_tag'] ); ?> <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>>
							<?php
							if ( $has_icon ) {
								?>
								<span class="elementor-accordion-icon elementor-accordion-icon-<?php echo esc_attr( $settings['crafto_icon_align'] ); ?>" aria-hidden="true">
									<?php
									if ( $is_new || $migrated ) {
										?>
										<span class="elementor-accordion-icon-closed elementor-icon">
											<?php Icons_Manager::render_icon( $settings['crafto_selected_icon'] ); ?>
										</span>
										<span class="elementor-accordion-icon-opened elementor-icon">
											<?php Icons_Manager::render_icon( $settings['crafto_selected_active_icon'] ); ?>
										</span>
										<?php
									} else {
										if ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
											?>
											<i class="elementor-accordion-icon-closed <?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>"></i>
											<?php
										}
										if ( isset( $settings['crafto_selected_active_icon']['value'] ) && ! empty( $settings['crafto_selected_active_icon']['value'] ) ) {
											?>
											<i class="elementor-accordion-icon-opened <?php echo esc_attr( $settings['crafto_selected_active_icon']['value'] ); ?>"></i>
											<?php
										}
									}
									?>
								</span>
								<?php
							}
							if ( ! empty( $item['crafto_accordian_number'] ) ) {
								?>
								<div <?php $this->print_render_attribute_string( 'number' ); ?>>
									<?php echo sprintf( '%s', esc_html( $item['crafto_accordian_number'] ) ); // phpcs:ignore.?>
								</div>
								<?php
							}

							if ( ! empty( $item['crafto_accordian_icon']['value'] ) && 'accordion-style-3' !== $crafto_accordion_style ) {
								?>
								<div class="icon">
									<?php
									if ( $is_new_icon || $migrated_icon ) {
										Icons_Manager::render_icon( $item['crafto_accordian_icon'], [ 'aria-hidden' => 'true' ] );
									}
									?>
								</div>
								<?php
							}

							if ( ! empty( $item['crafto_accordian_event_time'] ) && 'accordion-style-3' === $crafto_accordion_style ) {
								?>
								<span class="event-time">
									<?php
									if ( $is_new_icon || $migrated_icon ) {
										Icons_Manager::render_icon( $item['crafto_accordian_icon'], [ 'aria-hidden' => 'true' ] );
									}
									echo sprintf( '%s', esc_html( $item['crafto_accordian_event_time'] ) ); // phpcs:ignore.
									?>
								</span>
								<?php
							}

							if ( 'accordion-style-3' === $crafto_accordion_style ) {
								?>
								<span><?php echo sprintf( '%s', esc_html( $item['crafto_accordion_title'] ) ); // phpcs:ignore. ?></span>
								<?php
							}

							if ( ! empty( $item['crafto_accordion_title'] ) && 'accordion-style-3' !== $crafto_accordion_style ) {
								?>
								<div class="title"><?php echo sprintf( '%s', esc_html( $item['crafto_accordion_title'] ) ); // phpcs:ignore. ?></div>
								<?php
							}
							?>
							</<?php echo esc_attr( $settings['crafto_title_html_tag'] ); ?>>
							<div <?php $this->print_render_attribute_string( $tab_content_setting_key ); ?>>
								<div class="panel-tab-content">
									<?php
									if ( 'template' === $item['crafto_item_content_type'] ) {
										if ( '0' !== $item['crafto_item_template_id'] ) {
											$template_content = \Crafto_Addons_Extra_Functions::crafto_get_builder_content_for_display( $item['crafto_item_template_id'] );
											if ( ! empty( $template_content ) ) {
												if ( Plugin::$instance->editor->is_edit_mode() ) {
													$edit_url = add_query_arg(
														array(
															'elementor' => '',
														),
														get_permalink( $item['crafto_item_template_id'] )
													);
													echo sprintf( '<div class="edit-template-with-light-box elementor-template-edit-cover" data-template-edit-link="%s"><i aria-hidden="true" class="eicon-edit"></i><span>%s</span></div>', esc_url( $edit_url ), esc_html__( 'Edit Template', 'crafto-addons' ) ); // phpcs:ignore.
												}
												echo sprintf( '%s', $template_content ); // phpcs:ignore
											} else {
												echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
											}
										} else {
											echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
										}
									} else {
										echo sprintf( '%s', $this->parse_text_editor( $item['crafto_item_content'] ) ); // phpcs:ignore
									}
									?>
								</div>
								<?php
								if ( ! empty( $item['icon'] ) || ! empty( $item['crafto_item_icon']['value'] ) ) {
									?>
									<span class="tab-item-icon">
										<?php
										if ( $is_new1 || $migrated1 ) {
											Icons_Manager::render_icon( $item['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
										} elseif ( isset( $item['crafto_item_icon']['value'] ) && ! empty( $item['crafto_item_icon']['value'] ) ) {
											?>
											<i class="<?php echo esc_attr( $item['crafto_item_icon']['value'] ); ?>" aria-hidden="true"></i>
											<?php
										}
										?>
									</span>
									<?php
								}
								?>
							</div>
						</div>
						<?php
					}
				}
				if ( isset( $settings['crafto_faq_schema'] ) && 'yes' === $settings['crafto_faq_schema'] ) {
					$json = [
						'@context'   => 'https://schema.org',
						'@type'      => 'FAQPage',
						'mainEntity' => [],
					];

					foreach ( $settings['crafto_tabs'] as $index => $item ) {
						$json['mainEntity'][] = [
							'@type'          => 'Question',
							'name'           => wp_strip_all_tags( $item['crafto_accordion_title'] ),
							'acceptedAnswer' => [
								'@type' => 'Answer',
								'text'  => $this->parse_text_editor( $item['crafto_item_content'] ),
							],
						];
					}
					?>
					<script type="application/ld+json"><?php echo wp_json_encode( $json ); ?></script>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
