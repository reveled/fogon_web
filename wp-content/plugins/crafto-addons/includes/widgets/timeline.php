<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for process step.
 *
 * @package Crafto
 */

// If class `Timeline` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Timeline' ) ) {
	/**
	 * Define `Timeline` class.
	 */
	class Timeline extends Widget_Base {
		/**
		 * Retrieve the list of styles the process step widget depended on.
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
				return [ 'crafto-timeline-widget' ];
			}
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve timeline widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-timeline';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve timeline widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Timeline', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve timeline widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-time-line crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/timeline/';
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
				'step flow',
				'history',
				'event',
				'steps',
				'story',
				'workflow',
				'tracking',
			];
		}

		/**
		 * Register timeline widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_timeline',
				[
					'label' => esc_html__( 'Timeline', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_timeline_year',
				[
					'label'       => esc_html__( 'Year', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( '2024', 'crafto-addons' ),
					'separator'   => 'none',
				]
			);
			$repeater->add_control(
				'crafto_timeline_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'separator'   => 'none',
				]
			);
			$repeater->add_control(
				'crafto_timeline_description',
				[
					'label'      => esc_html__( 'Description', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => true,
					'default'    => esc_html__( 'Lorem ipsum amet consectetur adipiscing', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_timeline',
				[
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_timeline_title'       => esc_html__( 'Title #1', 'crafto-addons' ),
							'crafto_timeline_description' => esc_html__( 'Lorem ipsum amet consectetur adipiscing', 'crafto-addons' ),
						],
						[
							'crafto_timeline_title'       => esc_html__( 'Title #2', 'crafto-addons' ),
							'crafto_timeline_description' => esc_html__( 'Lorem ipsum amet consectetur adipiscing', 'crafto-addons' ),
						],
						[
							'crafto_timeline_title'       => esc_html__( 'Title #3', 'crafto-addons' ),
							'crafto_timeline_description' => esc_html__( 'Lorem ipsum amet consectetur adipiscing', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_timeline_title }}}',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_content_settings',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_timeline_title_size',
				[
					'label'   => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
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
					'default' => 'div',
				]
			);
			$this->add_control(
				'crafto_timeline_year_postion',
				[
					'label'   => esc_html__( 'Year Position', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'year-up',
					'options' => [
						'year-up'     => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'year-middle' => [
							'title' => esc_html__( 'Middle', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'year-down'   => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
				]
			);
			$this->add_control(
				'crafto_display_separator',
				[
					'label'        => esc_html__( 'Enable Steps', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_timeline_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_general_aligment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options'     => [
						'start'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors'   => [
						'{{WRAPPER}} .timeline-item, {{WRAPPER}} .timeline-item .timeline-item-box' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_content_bottom_spacer',
				[
					'label'      => esc_html__( 'Bottom Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_timeline_year_style',
				[
					'label' => esc_html__( 'Year', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_timeline_year_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .timeline-box .timeline-item-year .timeline-year',
				]
			);
			$this->add_control(
				'crafto_timeline_year_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .timeline-box .timeline-year' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_timeline_number_type',
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
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_timeline_year',
					'selector'       => '{{WRAPPER}} .timeline-item-year .timeline-year',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_timeline_number_type' => 'stroke',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_year_margin_bottom',
				[
					'label'     => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'unit' => 'px',
					],
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .timeline-box .timeline-item-year' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_timeline_year_postion' => [
							'year-up',
							'year-middle',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_year_margin_top',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-item-year' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_timeline_year_postion' => 'year-down',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_timeline_title_style',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_timeline_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .timeline-box .timeline-title',
				]
			);
			$this->add_control(
				'crafto_timeline_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .timeline-box .timeline-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_title_width',
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
							'max' => 200,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-title' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_title_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_timeline_content_style',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_timeline_content_typography',
					'selector' => '{{WRAPPER}} .timeline-box .timeline-content',
				]
			);
			$this->add_control(
				'crafto_timeline_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .timeline-box .timeline-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_content_width',
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
							'max' => 200,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-content' => 'width: {{SIZE}}{{UNIT}}; display: inline-block',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_timeline_box_style',
				[
					'label' => esc_html__( 'Step', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_timeline_box_bfr_heading',
				[
					'label' => esc_html__( 'Outer Circle', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_box_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-box-bfr' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_timeline_box_tabs'
			);
			$this->start_controls_tab(
				'crafto_timeline_box_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_timeline_box_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .timeline-box .timeline-box-bfr',
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_timeline_box_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_timeline_box_hover_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .timeline-box .timeline-item:hover .timeline-box-bfr',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_timeline_box_shadow',
					'selector' => '{{WRAPPER}} .timeline-box .timeline-box-bfr',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_timeline_box_border',
					'selector' => '{{WRAPPER}} .timeline-box .timeline-box-bfr',
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_box_bfr_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-box-bfr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'crafto_timeline_box_afr_heading',
				[
					'label'     => esc_html__( 'Inner Circle', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_afr_box_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 25,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-box-afr' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_timeline_afr_box_tabs'
			);
			$this->start_controls_tab(
				'crafto_timeline_box_afr_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_timeline_afr_box_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .timeline-box .timeline-box-afr',
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_timeline_afr_box_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_timeline_box_afr_hover_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .timeline-box .timeline-item:hover .timeline-box-afr',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_timeline_box_afr_shadow',
					'selector' => '{{WRAPPER}} .timeline-style-1 .timeline-box-afr',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_timeline_box_afr_border',
					'selector' => '{{WRAPPER}} .timeline-box .timeline-box-afr',
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_box_afr_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .timeline-box .timeline-box-afr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_timeline_box_afr_bfr_margin',
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
						'{{WRAPPER}} .timeline-box .timeline-item-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_timeline_separator_style_section',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_display_separator' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_timeline_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .timeline-box .timeline-separator' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render timeline widget output on the frontend.
		 * Make sure value does no exceed 100%.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( empty( $settings['crafto_timeline'] ) ) {
				return;
			}

			$crafto_timeline_year_postion = ( isset( $settings['crafto_timeline_year_postion'] ) && $settings['crafto_timeline_year_postion'] ) ? $settings['crafto_timeline_year_postion'] : '';
			$crafto_display_separator     = ( isset( $settings['crafto_display_separator'] ) && $settings['crafto_display_separator'] ) ? $settings['crafto_display_separator'] : '';
			$crafto_timeline_number_type  = ( isset( $settings['crafto_timeline_number_type'] ) && $settings['crafto_timeline_number_type'] ) ? $settings['crafto_timeline_number_type'] : '';

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'timeline-box',
					'timeline-style-1',
					$crafto_timeline_year_postion,
				]
			);
			$this->add_render_attribute(
				'timeline_year',
				'class',
				[
					'timeline-year',
				]
			);
			if ( 'stroke' === $crafto_timeline_number_type ) {
				$this->add_render_attribute(
					'timeline_year',
					'class',
					[
						'text-stroke',
					]
				);
			}
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				foreach ( $settings['crafto_timeline'] as $index => $item ) {
					?>
					<div class="timeline-item">
						<?php
						if ( ! empty( $item['crafto_timeline_year'] ) ) {
							?>
							<div class="timeline-item-year">
								<span <?php $this->print_render_attribute_string( 'timeline_year' ); ?>>
								<?php echo esc_html( $item['crafto_timeline_year'] ); ?>
								</span>
							</div>
							<?php
						}
						if ( 'yes' === $crafto_display_separator ) {
							?>
							<div class="timeline-item-box">
								<span class="timeline-item-box-bfr timeline-separator"></span>
								<span class="timeline-box-bfr">
									<span class="timeline-box-afr"></span>
								</span>
							</div>
							<?php
						}
						$this->render_timeline_content_block( $item );
						?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
		/**
		 * Render Timeline Content block.
		 *
		 * @access protected
		 *
		 * @param mixed $item The item to be rendered in the timeline.
		 */
		protected function render_timeline_content_block( $item ) {
			if ( ! empty( $item['crafto_timeline_title'] ) || ! empty( $item['crafto_timeline_description'] ) ) {
				?>
				<div class="timeline-content">
					<?php
					if ( ! empty( $item['crafto_timeline_title'] ) ) {
						?>
						<<?php echo $this->get_settings( 'crafto_timeline_title_size' ); // phpcs:ignore ?> class="timeline-title">
							<?php echo esc_html( $item['crafto_timeline_title'] ); ?>
						</<?php echo $this->get_settings( 'crafto_timeline_title_size' ); // phpcs:ignore ?>>
						<?php
					}
					if ( ! empty( $item['crafto_timeline_description'] ) ) {
						?>
						<div class="timeline-description">
							<?php echo sprintf( '%s', wp_kses_post( $item['crafto_timeline_description'] ) ); // phpcs:ignore?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
		}
	}
}
