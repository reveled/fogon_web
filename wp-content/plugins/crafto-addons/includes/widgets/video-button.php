<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget for video button.
 *
 * @package Crafto
 */

// If class `Video_Button` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Video_Button' ) ) {
	/**
	 * Define `Video_Button` class.
	 */
	class Video_Button extends Widget_Base {
		/**
		 * Retrieve the list of scripts the video button widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$video_button_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$video_button_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$video_button_scripts[] = 'magnific-popup';
				}
				$video_button_scripts[] = 'crafto-video-button-widget';
			}
			return $video_button_scripts;
		}

		/**
		 * Retrieve the list of styles the video button widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$video_button_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$video_button_styles[] = 'crafto-widgets-rtl';
				} else {
					$video_button_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$video_button_styles[] = 'magnific-popup';
				}

				if ( is_rtl() ) {
					$video_button_styles[] = 'crafto-video-button-rtl';
				}
				$video_button_styles[] = 'crafto-video-button';
			}
			return $video_button_styles;
		}
		/**
		 * Get Widget Name.
		 *
		 * Retrieve Video Button Name.
		 *
		 * access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-video-button';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve video button widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Video Button', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve video button widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-play crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/video-button/';
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
				'button',
				'video',
				'link',
				'popup',
				'light-box',
			];
		}

		/**
		 * Register video button widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_video_button_image_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_video_button_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'video-button-style-1',
					'options' => [
						'video-button-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'video-button-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'video-button-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'video-button-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'video-button-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_video_button_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Play', 'crafto-addons' ),
					'condition'   => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
					'separator'   => 'before',
				]
			);
			$this->add_control(
				'crafto_video_link',
				[
					'label'       => esc_html__( 'Video URL', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
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
					'return_value' => 'yes',
					'separator'    => 'before',
					'condition'    => [
						'crafto_video_button_style' => [
							'video-button-style-1',
							'video-button-style-2',
							'video-button-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_item_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-play',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_item_use_image'     => '',
						'crafto_video_button_style' => [
							'video-button-style-1',
							'video-button-style-2',
							'video-button-style-4',
						],
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
					'condition' => [
						'crafto_item_use_image'     => 'yes',
						'crafto_video_button_style' => [
							'video-button-style-1',
							'video-button-style-2',
							'video-button-style-4',
						],
					],
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
					'separator' => 'none',
					'condition' => [
						'crafto_item_use_image'     => 'yes',
						'crafto_video_button_style' => [
							'video-button-style-1',
							'video-button-style-2',
							'video-button-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_video_button_image',
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
						'crafto_video_button_style' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_rotate_infinite',
				[
					'label'              => esc_html__( 'Enable Infinite Rotate', 'crafto-addons' ),
					'type'               => Controls_Manager::SWITCHER,
					'default'            => 'yes',
					'return_value'       => 'yes',
					'frontend_available' => true,
					'selectors'          => [
						'{{WRAPPER}} .animation-rotation' => 'animation: rotation var(--crafto-rotate-duration, 2000ms) linear infinite;animation-delay: var(--crafto-rotate-delay, 0);',
					],
					'prefix_class'       => 'crafto-floating-effect-infinite--',
					'condition'          => [
						'crafto_video_button_style' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_rotate_duration',
				[
					'label'              => sprintf(
						/* translators: %s: Duration */
						esc_html__( 'Duration %s', 'crafto-addons' ),
						'<small>(ms)</small>'
					),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => [
						's',
						'ms',
						'custom',
					],
					'range'              => [
						'ms' => [
							'min'  => 0,
							'max'  => 50000,
							'step' => 100,
						],
					],
					'default'            => [
						'unit' => 'ms',
						'size' => 2000,
					],
					'frontend_available' => true,
					'selectors'          => [
						'{{WRAPPER}} .animation-rotation' => '--crafto-rotate-duration: {{SIZE}}{{UNIT}};',
					],
					'condition'          => [
						'crafto_rotate_infinite'    => 'yes',
						'crafto_video_button_style' => [
							'video-button-style-5',
						],
					],
				]
			);

			$this->add_control(
				'crafto_rotate_delay',
				[
					'label'              => sprintf(
						/* translators: %s: Delay */
						esc_html__( 'Delay %s', 'crafto-addons' ),
						'<small>(ms)</small>'
					),
					'type'               => Controls_Manager::SLIDER,
					'size_units'         => [
						's',
						'ms',
						'custom',
					],
					'range'              => [
						'ms' => [
							'min'  => 0,
							'max'  => 5000,
							'step' => 100,
						],
					],
					'default'            => [
						'unit' => 'ms',
					],
					'frontend_available' => true,
					'selectors'          => [
						'{{WRAPPER}} .animation-rotation' => '--crafto-rotate-delay: {{SIZE}}{{UNIT}};',
					],
					'condition'          => [
						'crafto_rotate_infinite'    => 'yes',
						'crafto_video_button_style' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_round_image',
				[
					'label'     => esc_html__( 'Video Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_video_button_style' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_image_fetch_priority',
				[
					'label'     => esc_html__( 'Fetch Priority', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none' => esc_html__( 'Default', 'crafto-addons' ),
						'high' => esc_html__( 'High', 'crafto-addons' ),
						'low'  => esc_html__( 'Low', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_item_use_image'     => 'yes',
						'crafto_video_button_style' => [
							'video-button-style-1',
							'video-button-style-2',
							'video-button-style-4',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_position',
				[
					'label'     => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'video-icon-left',
					'options'   => [
						'video-icon-left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'video-icon-top'   => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'video-icon-right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'condition' => [
						'crafto_video_button_title!' => '',
						'crafto_video_button_style'  => [
							'video-button-style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_position',
				[
					'label'     => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'video-icon-left',
					'options'   => [
						'video-icon-left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'video-icon-right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'condition' => [
						'crafto_video_button_title!' => '',
						'crafto_video_button_style'  => [
							'video-button-style-2',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_video_button_section_settings',
				[
					'label'     => esc_html__( 'Settings', 'crafto-addons' ),
					'condition' => [
						'crafto_video_button_style' => [
							'video-button-style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_enable_animation',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_video_button_style' => 'video-button-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_video_button_animation',
				[
					'label'     => esc_html__( 'Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'animation-sonar',
					'options'   => [
						'animation-sonar' => esc_html__( 'Ripple', 'crafto-addons' ),
						'animation-zoom'  => esc_html__( 'Zoom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_animation'   => 'yes',
						'crafto_video_button_style' => 'video-button-style-1',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_video_button_icon_section_style',
				[
					'label'     => esc_html__( 'General', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_video_title_style_heading',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-3',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_video_button_title_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .video-title',
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_video_button_title_tabs',
				[
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-3',
							'video-button-style-5',
						],
					],
				]
			);
			$this->start_controls_tab(
				'crafto_video_button_title_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_video_button_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_video_button_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_video_button_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-icon-box:hover .video-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_video_icon_divider',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-3',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_video_icon_style_heading',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-3',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_button_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .video-icon, {{WRAPPER}} .video-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .video-icon img, {{WRAPPER}} .video-icon svg' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_video_button_style!' => [
							'video-button-style-3',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_button_icon_box_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 20,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .video-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .video-icon-sonar-bfr' => 'height: calc( {{SIZE}}{{UNIT}} + 50px ); width: calc( {{SIZE}}{{UNIT}} + 50px )',
					],
					'condition'  => [
						'crafto_video_button_style!' => [
							'video-button-style-2',
							'video-button-style-4',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_icon_margin',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .video-icon-left .video-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .video-icon-top .video-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .video-icon-right .video-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .video-icon-left .video-icon' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .video-icon-right .video-icon' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_video_button_style' => [
							'video-button-style-1',
							'video-button-style-2',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_video_button_icon_tabs' );

			$this->start_controls_tab(
				'crafto_video_button_icon_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_video_button_box_shadow',
					'selector'  => '{{WRAPPER}} .video-button-style-1 .video-icon, .video-button-style-2 .video-icon-box, {{WRAPPER}} .video-button-style-3 .video-icon, {{WRAPPER}} .video-button-style-4 .video-icon',
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_video_button_icon_title_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_video_button_style' => [
							'video-button-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_video_button_icon_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .video-icon i, {{WRAPPER}} .video-icon svg',
					'condition'      => [
						'crafto_item_use_image'      => '',
						'crafto_video_button_style!' => [
							'video-button-style-3',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_video_button_icon_bg_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .video-button-style-1 .video-icon, {{WRAPPER}} .video-button-style-2 .video-icon-box, {{WRAPPER}} .video-button-style-3 .video-icon, {{WRAPPER}} .video-button-style-4 .video-icon',
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_video_button_icon_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_video_button_hover_box_shadow',
					'selector'  => '{{WRAPPER}} .video-button-style-1 .video-icon:hover, .video-button-style-2 .video-icon-box:hover, {{WRAPPER}} .video-button-style-3 .video-icon:hover, {{WRAPPER}} .video-button-style-4 .video-icon:hover',
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_video_button_icon_title_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-icon-box:hover .video-title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_video_button_style' => [
							'video-button-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_video_button_icon_hover_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .video-icon-box:hover .video-icon i, {{WRAPPER}} .video-icon-box:hover .video-icon svg',
					'condition'      => [
						'crafto_item_use_image'      => '',
						'crafto_video_button_style!' => [
							'video-button-style-3',
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_video_button_icon_hover_bg_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .video-button-style-1 .video-icon-box:hover .video-icon, {{WRAPPER}} .video-button-style-2 .video-icon-box:hover, {{WRAPPER}} .video-button-style-3 .video-icon-box:hover .video-icon, {{WRAPPER}} .video-button-style-4 .video-icon-box:hover .video-icon',
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_video_button_icon_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-button-style-1 .video-icon-box:hover .video-icon, {{WRAPPER}} .video-button-style-3 .video-icon-box:hover .video-icon, {{WRAPPER}} .video-button-style-4 .video-icon-box:hover .video-icon' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .video-button-style-2 .video-icon-box:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_video_button_style!' => [
							'video-button-style-4',
							'video-button-style-5',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_video_button_box_border',
					'selector'       => '{{WRAPPER}} .video-button-style-1 .video-icon, {{WRAPPER}} .video-button-style-2 .video-icon-box, {{WRAPPER}} .video-button-style-3 .video-icon, {{WRAPPER}} .video-button-style-4 .video-icon',
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
					],
					'condition'      => [
						'crafto_video_button_style!' => [
							'video-button-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_button_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .video-button-style-2 .video-icon-box, {{WRAPPER}} .video-button-style-3 .video-icon, {{WRAPPER}} .video-button-style-4 .video-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_video_button_style!' => [
							'video-button-style-1',
							'video-button-style-5',
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_video_button_icon_padding',
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
						'{{WRAPPER}} .video-button-style-2 .video-icon-box, {{WRAPPER}} .video-button-style-4 .video-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_video_button_style' => [
							'video-button-style-2',
							'video-button-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_video_button_sonar_style_heading',
				[
					'label'     => esc_html__( 'Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_video_button_style' => [
							'video-button-style-1',
						],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'label'          => esc_html__( 'Ripple Background', 'crafto-addons' ),
					'name'           => 'crafto_video_button_icon_bg_animation_color',
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
							'label' => esc_html__( 'Ripple Background', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_video_button_style' => [
							'video-button-style-1',
						],
					],
					'selector'       => '{{WRAPPER}} .video-icon-sonar .video-icon-sonar-bfr',
				]
			);
			$this->add_responsive_control(
				'crafto_sonar_animation_border',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'condition'  => [
						'crafto_video_button_style' => [
							'video-button-style-1',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .video-icon-sonar .video-icon-sonar-bfr' => 'border-style: solid; border-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'crafto_sonar_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-icon-sonar .video-icon-sonar-bfr' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_video_button_style' => [
							'video-button-style-1',
						],
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render video button widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings          = $this->get_settings_for_display();
			$crafto_video_link = $this->get_settings( 'crafto_video_link' );
			$migrated          = isset( $settings['__fa4_migrated']['crafto_item_icon'] );
			$is_new            = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$video_link        = ( isset( $settings['crafto_video_link'] ) && $settings['crafto_video_link'] ) ? $settings['crafto_video_link'] : '';
			$fetch_priority    = isset( $settings['crafto_image_fetch_priority'] ) && ! empty( $settings['crafto_image_fetch_priority'] ) ? $settings['crafto_image_fetch_priority'] : 'none';

			$icon = '';
			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
				$icon = ob_get_clean();
			} elseif ( isset( $settings['crafto_item_icon']['value'] ) && ! empty( $settings['crafto_item_icon']['value'] ) ) {
				$icon = '<i class="' . esc_attr( $settings['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			$crafto_item_image = '';
			if ( ! empty( $settings['crafto_item_image']['id'] ) ) {
				$thumbnail_id       = $settings['crafto_item_image']['id'];
				$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
				$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
				$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
				$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

				$image_array           = wp_get_attachment_image_src( $settings['crafto_item_image']['id'], $settings['crafto_thumbnail_size'] );
				$crafto_item_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';

				$default_attr = array(
					'class' => 'hover-switch-image',
					'title' => esc_attr( $crafto_image_title ),
				);

				if ( 'none' !== $fetch_priority ) {
					$default_attr['fetchpriority'] = esc_attr( $fetch_priority );
				}

				$crafto_item_image = wp_get_attachment_image( $thumbnail_id, $settings['crafto_thumbnail_size'], '', $default_attr );
			} elseif ( ! empty( $settings['crafto_item_image']['url'] ) ) {
				$crafto_item_image_url = $settings['crafto_item_image']['url'];
				$crafto_item_image_alt = esc_attr__( 'Placeholder Image', 'crafto-addons' );
				$crafto_item_image     = sprintf( '<img src="%1$s" alt="%2$s" />', esc_url( $crafto_item_image_url ), esc_attr( $crafto_item_image_alt ) );
			}

			$crafto_round_image = '';
			if ( ! empty( $settings['crafto_round_image']['id'] ) ) {
				$thumbnail_id       = $settings['crafto_round_image']['id'];
				$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
				$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
				$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
				$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

				$image_array            = wp_get_attachment_image_src( $settings['crafto_round_image']['id'], 'full' );
				$crafto_round_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';

				$default_attr = array(
					'class' => 'rounded-image',
					'title' => esc_attr( $crafto_image_title ),
				);

				if ( 'none' !== $fetch_priority ) {
					$default_attr['fetchpriority'] = esc_attr( $fetch_priority );
				}

				$crafto_round_image = wp_get_attachment_image( $thumbnail_id, 'full', '', $default_attr );
			} elseif ( ! empty( $settings['crafto_round_image']['url'] ) ) {
				$crafto_round_image_url = $settings['crafto_round_image']['url'];
				$crafto_image_alt       = esc_attr__( 'Placeholder Image', 'crafto-addons' );
				$crafto_round_image     = sprintf( '<img class="rounded-image" src="%1$s" alt="%2$s" />', esc_url( $crafto_round_image_url ), esc_attr( $crafto_image_alt ) );
			}

			$crafto_video_button_image = '';
			if ( ! empty( $settings['crafto_video_button_image']['id'] ) ) {
				$thumbnail_id       = $settings['crafto_video_button_image']['id'];
				$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
				$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
				$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
				$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

				$image_array                   = wp_get_attachment_image_src( $settings['crafto_video_button_image']['id'], 'full' );
				$crafto_video_button_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';

				$default_attr = array(
					'class' => 'animation-rotation',
					'title' => esc_attr( $crafto_image_title ),
				);

				if ( 'none' !== $fetch_priority ) {
					$default_attr['fetchpriority'] = esc_attr( $fetch_priority );
				}

				$crafto_video_button_image = wp_get_attachment_image( $thumbnail_id, 'full', '', $default_attr );
			} elseif ( ! empty( $settings['crafto_video_button_image']['url'] ) ) {
				$crafto_video_button_image_url = $settings['crafto_video_button_image']['url'];
				$crafto_image_alt              = esc_attr__( 'Placeholder Image', 'crafto-addons' );
				$crafto_video_button_image     = sprintf( '<img class="animation-rotation" src="%1$s" alt="%2$s" />', esc_url( $crafto_video_button_image_url ), esc_attr( $crafto_image_alt ) );
			}

			if ( ! empty( $video_link ) ) {
				$this->add_render_attribute(
					[
						'url' => [
							'class' => [
								'video-icon-box',
							],
							'title' => esc_html__( 'Video Play', 'crafto-addons' ),
						],
					],
				);
				$this->add_link_attributes( 'url', $settings['crafto_video_link'] );
			}

			$animation = ( 'yes' === $settings['crafto_enable_animation'] && 'animation-zoom' === $settings['crafto_video_button_animation'] ) ? $settings['crafto_video_button_animation'] : '';

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'video-button-wrap',
							$settings['crafto_video_button_style'],
						],
					],
				],
			);

			if ( $settings['crafto_position'] ) {
				$this->add_render_attribute(
					[
						'wrapper' => [
							'class' => [
								$settings['crafto_position'],
							],
						],
					],
				);
			}
			if ( $settings['crafto_icon_position'] ) {
				$this->add_render_attribute(
					[
						'wrapper' => [
							'class' => [
								$settings['crafto_icon_position'],
							],
						],
					],
				);
			}
			if ( $animation ) {
				$this->add_render_attribute(
					[
						'wrapper' => [
							'class' => $animation,
						],
					],
				);
			}

			$this->add_render_attribute(
				[
					'icon_sonar' => [
						'class' => [
							'video-icon-sonar-bfr',
						],
					],
				],
			);

			if ( isset( $crafto_video_link ) && ! empty( $crafto_video_link ) ) {
				$this->add_render_attribute(
					'url',
					'class',
					[
						'popup-youtube',
					]
				);
			}

			if ( ! empty( $crafto_item_image ) || ! empty( $icon ) || ! empty( $settings['crafto_video_button_title'] ) || ! empty( $crafto_round_image ) || ! empty( $crafto_video_button_image ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<a <?php $this->print_render_attribute_string( 'url' ); ?>>
					<?php
					switch ( $settings['crafto_video_button_style'] ) {
						case 'video-button-style-1':
							?>
							<span class="video-icon">
								<?php
								echo filter_var( $settings['crafto_item_use_image'], FILTER_VALIDATE_BOOLEAN ) ? $crafto_item_image : $icon; // phpcs:ignore
								if ( 'yes' === $settings['crafto_enable_animation'] && 'animation-sonar' === $settings['crafto_video_button_animation'] ) {
									?>
									<span class="video-icon-sonar">
										<span <?php $this->print_render_attribute_string( 'icon_sonar' ); ?>></span>
									</span>
									<?php
								}
								?>
							</span>
							<?php
							break;
						case 'video-button-style-2':
							?>
							<span class="video-icon">
								<?php
								echo filter_var( $settings['crafto_item_use_image'], FILTER_VALIDATE_BOOLEAN ) ? $crafto_item_image : $icon; // phpcs:ignore ?>
							</span>
							<?php
							break;
						case 'video-button-style-3':
							?>
							<span class="video-icon">
								<?php
								if ( ! empty( $settings['crafto_video_button_title'] ) ) {
									echo sprintf( '<span class="video-title">%1$s</span>', $settings[ 'crafto_video_button_title' ] ); // phpcs:ignore
								}
								?>
							</span>
							<?php
							break;
						case 'video-button-style-4':
							?>
							<span class="video-icon">
								<?php
								echo sprintf( '<span class="video-title">%1$s</span>', $settings[ 'crafto_video_button_title' ] ); // phpcs:ignore
								echo filter_var( $settings['crafto_item_use_image'], FILTER_VALIDATE_BOOLEAN ) ? $crafto_item_image : $icon; // phpcs:ignore
								echo filter_var( $settings['crafto_item_use_image'], FILTER_VALIDATE_BOOLEAN ) ? $crafto_item_image : $icon; // phpcs:ignore
								?>
							</span>
							<?php
							break;
						case 'video-button-style-5':
							if ( ! empty( $crafto_video_button_image ) || ! empty( $crafto_round_image ) ) {
								?>
								<span class="video-icon">
									<?php
									echo $crafto_video_button_image; // phpcs:ignore
									echo $crafto_round_image; // phpcs:ignore
									?>
								</span>
								<?php
							}
							break;
					}

					if ( ! empty( $settings['crafto_video_button_title'] ) && 'video-button-style-3' !== $settings['crafto_video_button_style'] && 'video-button-style-4' !== $settings['crafto_video_button_style'] && 'video-button-style-5' !== $settings['crafto_video_button_style'] ) {
						echo sprintf( '<span class="video-title">%1$s</span>', $settings[ 'crafto_video_button_title' ] ); // phpcs:ignore
					}
					?>
					<div class="screen-reader-text"><?php echo esc_html__( 'Video Play Button', 'crafto-addons' ); ?></div>
					</a>
				</div>
				<?php
			}
		}
	}
}
