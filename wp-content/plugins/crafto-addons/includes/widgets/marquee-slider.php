<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for marquee slider.
 *
 * @package Crafto
 */

// If class `Marquee_Slider` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Marquee_Slider' ) ) {
	/**
	 * Define `Marquee_Slider` class.
	 */
	class Marquee_Slider extends Widget_Base {
		/**
		 * Retrieve the list of scripts the marquee slider widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$marquee_slider_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$marquee_slider_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$marquee_slider_scripts[] = 'swiper';
				}
				$marquee_slider_scripts[] = 'crafto-marquee-slider';
			}
			return $marquee_slider_scripts;
		}
		/**
		 * Retrieve the list of styles the marquee slider widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$marquee_slider_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$marquee_slider_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$marquee_slider_styles[] = 'swiper';
				}

				if ( is_rtl() ) {
					$marquee_slider_styles[] = 'crafto-marquee-slider-rtl';
				}
				$marquee_slider_styles[] = 'crafto-marquee-slider';
			}
			return $marquee_slider_styles;
		}
		/**
		 * Get widget name.
		 *
		 * Retrieve marquee slider widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-marquee-slider';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve marquee slider widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Marquee Slider', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve marquee slider widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-nested-carousel crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/marquee-slider/';
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
				'image',
				'photo',
				'visual',
				'carousel',
				'slider',
				'marquee',
			];
		}

		/**
		 * Register marquee slider widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_text_carousel',
				[
					'label' => esc_html__( 'Slides', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_marquee_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write Title here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_marquee_highlight_title',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<div style ="font-style:normal">To add the highlighted text use shortcode like:<br/><br/> <span style="font-weight:bold">[crafto_highlight]</span> Your Text <span style="font-weight:bold">[/crafto_highlight]</span></div>', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$repeater->add_control(
				'crafto_marquee_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$repeater->add_control(
				'crafto_marquee_title_type',
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
			$repeater->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_marquee_title_color',
					'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}}.swiper-slide .title',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_marquee_title_type' => 'stroke',
					],
				]
			);
			$repeater->add_control(
				'crafto_marquee_title_color_separate',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}.swiper-slide .title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_marquee_title_type' => 'normal',
					],
				]
			);

			$this->add_control(
				'crafto_marquee_slider',
				[
					'label'       => esc_html__( 'Slider Items', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_marquee_title' => esc_html__( 'Write Title Here', 'crafto-addons' ),
						],
						[
							'crafto_marquee_title' => esc_html__( 'Write Title Here', 'crafto-addons' ),
						],
						[
							'crafto_marquee_title' => esc_html__( 'Write Title Here', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto__marquee_setting',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_marquee_slider_title_size',
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
					'default' => 'h1',
				]
			);
			$this->add_control(
				'crafto_marquee_slider_separator',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_carousel_settings_section',
				[
					'label' => esc_html__( 'Slider Settings', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_items_spacing',
				[
					'label'      => esc_html__( 'Items Spacing', 'crafto-addons' ),
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
					'default'    => [
						'unit' => 'px',
						'size' => 30,
					],
				]
			);
			$this->add_control(
				'crafto_pause_on_hover',
				[
					'label'        => esc_html__( 'Enable Pause on Hover', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_speed',
				[
					'label'   => esc_html__( 'Effect Speed', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 8000,
				]
			);
			$this->add_control(
				'crafto_feather_shadow',
				[
					'label'   => esc_html__( 'Fade Effect', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'  => esc_html__( 'None', 'crafto-addons' ),
						'both'  => esc_html__( 'Both Side', 'crafto-addons' ),
						'right' => esc_html__( 'Right Side', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_rtl',
				[
					'label'   => esc_html__( 'RTL', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'ltr',
					'options' => [
						''    => esc_html__( 'Default', 'crafto-addons' ),
						'ltr' => esc_html__( 'Left', 'crafto-addons' ),
						'rtl' => esc_html__( 'Right', 'crafto-addons' ),
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_marquee_section_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_marquee_title_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .elementor-widget-container',
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_general_padding',
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
						'{{WRAPPER}} .marquee-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_marquee_slide_section_style',
				[
					'label' => esc_html__( 'Slide Settings', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_marquee_box_background',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Box Background Type', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .marquee-slider .swiper-slider',
				]
			);
			$this->add_control(
				'crafto_marquee_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .marquee-slider .swiper-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_box_padding',
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
						'{{WRAPPER}} .marquee-slider .swiper-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_marquee_box_shadow',
					'selector' => '{{WRAPPER}} .marquee-slider .swiper-slider',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_marquee_style_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_marquee_type',
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
					'name'           => 'crafto_marquee_stroke_title_color',
					'selector'       => '{{WRAPPER}} .swiper-slide .title',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_marquee_type' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_marquee_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .swiper-slide .title',
				]
			);
			$this->add_control(
				'crafto_marquee_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .title, {{WRAPPER}} .swiper-slide .title a' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_marquee_type!' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_marquee_title_border',
					'selector' => '{{WRAPPER}} .swiper-slide .title',
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_margin',
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
						'{{WRAPPER}} .swiper-slide .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_padding',
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
						'{{WRAPPER}} .swiper-slide .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_marquee_highlighted_style',
				[
					'label'     => esc_html__( 'Highlight', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_marquee_highlighted_title_typography',
					'selector' => '{{WRAPPER}} .title-highlights',
				]
			);
			$this->add_control(
				'crafto_marquee_highlighted_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .title-highlights' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_marquee_highlighted_title_border',
					'selector' => '{{WRAPPER}} .title-highlights',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_marquee_icon_style',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_marquee_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slider i:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .swiper-slider svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_icon_size',
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
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slider i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .swiper-slider svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_icon_margin',
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
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slider i, {{WRAPPER}} .swiper-slider svg' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .swiper-slider i, .rtl {{WRAPPER}} .swiper-slider svg' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_marquee_separator',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_marquee_slider_separator' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_marquee_separator_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .swiper-slide .marquee-slide-separator',
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_separator_width',
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
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .marquee-slide-separator' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_separator_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
					'default'    => [
						'unit' => 'px',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .marquee-slide-separator' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_marquee_separator_box_border',
					'selector' => '{{WRAPPER}} .swiper-slide .marquee-slide-separator',
				]
			);
			$this->add_control(
				'crafto_marquee_separator_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .marquee-slide-separator' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render marquee slider widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$slides                 = [];
			$settings               = $this->get_settings_for_display();
			$crafto_separator       = $this->get_settings( 'crafto_marquee_slider_separator' );
			$crafto_title_separator = ( 'yes' === $crafto_separator ) ? '<span class="marquee-slide-separator"></span>' : '';
			$migrated               = isset( $settings['__fa4_migrated']['crafto_marquee_icon'] );
			$is_new                 = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_marquee_type    = ( isset( $settings['crafto_marquee_type'] ) && ! empty( $settings['crafto_marquee_type'] ) ) ? $settings['crafto_marquee_type'] : '';
			$marquee_title          = '';

			$this->add_render_attribute( 'swiper_slider', 'class', 'swiper-slider' );
			if ( 'stroke' === $crafto_marquee_type ) {
				$this->add_render_attribute( 'swiper_slider', 'class', 'title-stroke' );
			}
			foreach ( $settings['crafto_marquee_slider'] as $index => $item ) {
				$index                     = ++$index;
				$wrapper_key               = 'wrapper_' . $index;
				$marquee_title             = 'marquee_title_' . $index;
				$crafto_marquee_title_type = ( isset( $item['crafto_marquee_title_type'] ) && ! empty( $item['crafto_marquee_title_type'] ) ) ? $item['crafto_marquee_title_type'] : '';

				$this->add_render_attribute(
					$wrapper_key,
					[
						'class' => [
							'elementor-repeater-item-' . $item['_id'],
							'swiper-slide',
							'slider-width-auto',
						],
					]
				);

				$this->add_render_attribute( $marquee_title, 'class', 'title' );
				if ( 'stroke' === $crafto_marquee_title_type ) {
					$this->add_render_attribute( $marquee_title, 'class', 'text-stroke' );
				}

				ob_start();
				?>
				<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
					<div <?php $this->print_render_attribute_string( 'swiper_slider' ); ?>>
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $item['crafto_marquee_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $item['crafto_marquee_icon']['value'] ) && ! empty( $item['crafto_marquee_icon']['value'] ) ) {
							echo '<i class="' . esc_attr( $item['crafto_marquee_icon']['value'] ) . '" aria-hidden="true"></i>';
						}
						if ( ! empty( $item['crafto_marquee_title'] ) ) {
							?>
							<<?php echo $this->get_settings( 'crafto_marquee_slider_title_size' ); ?> <?php $this->print_render_attribute_string( $marquee_title ); // phpcs:ignore ?>>
								<?php
								$crafto_highlight_content = str_replace( '[crafto_highlight]', '<span class="title-highlights">', $item['crafto_marquee_title'] );
								$crafto_highlight_content = str_replace( '[/crafto_highlight]', '</span>', $crafto_highlight_content );
								echo sprintf( '%s', $crafto_title_separator . $crafto_highlight_content ); // phpcs:ignore
								?>
							</<?php echo $this->get_settings( 'crafto_marquee_slider_title_size' ); // phpcs:ignore ?>>
							<?php
						}
						?>
					</div>
				</div>
				<?php
				$slides[] = ob_get_contents();
				ob_end_clean();
			}
			if ( empty( $slides ) ) {
				return;
			}
			$crafto_rtl   = $this->get_settings( 'crafto_rtl' );
			$sliderconfig = array(
				'pause_on_hover'   => $this->get_settings( 'crafto_pause_on_hover' ),
				'speed'            => $this->get_settings( 'crafto_speed' ),
				'image_spacing'    => $this->get_settings( 'crafto_items_spacing' ),
				'slider_separator' => $this->get_settings( 'crafto_marquee_slider_separator' ),
			);

			$slider_viewport = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
			$sliderconfig    = array_merge( $sliderconfig, $slider_viewport );

			$this->add_render_attribute(
				[
					'carousel'         => [
						'class' => [
							'swiper-wrapper',
							'marquee-slide',
						],
					],
					'carousel-wrapper' => [
						'class'         => [
							'swiper',
							'marquee-slider',
						],
						'data-settings' => wp_json_encode( $sliderconfig ),
					],
				]
			);
			if ( ! empty( $crafto_rtl ) ) {
				$this->add_render_attribute(
					'carousel-wrapper',
					'dir',
					$crafto_rtl,
				);
			}
			switch ( $this->get_settings( 'crafto_feather_shadow' ) ) {
				case 'both':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow' );
					break;
				case 'right':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow-right' );
					break;
			}
			?>
			<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
					<?php echo implode( ' ', $slides ); // phpcs:ignore ?>
				</div>
			</div>
			<?php
		}
	}
}
