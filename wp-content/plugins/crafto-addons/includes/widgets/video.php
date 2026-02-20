<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
/**
 *
 * Crafto widget for video.
 *
 * @package Crafto
 */

// If class `Video` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Video' ) ) {

	/**
	 *
	 * Define Class `Video`
	 */
	class Video extends Widget_Base {
		/**
		 * Retrieve the list of scripts the video widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$video_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$video_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'fitvids' ) ) {
					$video_scripts[] = 'jquery.fitvids';
				}
				$video_scripts[] = 'crafto-video-widget';
			}
			return $video_scripts;
		}
		/**
		 * Retrieve the list of styles the video widget depended on.
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
				return [
					'crafto-video-button',
					'crafto-video-widget',
				];
			}
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-video';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Video', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-youtube crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/video/';
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
				'video',
				'media',
				'vimeo',
				'youtube',
				'iframe',
				'mp4',
				'external',
				'link',
			];
		}

		/**
		 * Register video widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_video_type',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_video_source',
				[
					'label'   => esc_html__( 'Video Source Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'youtube',
					'options' => [
						'youtube'    => esc_html__( 'YouTube', 'crafto-addons' ),
						'vimeo'      => esc_html__( 'Vimeo', 'crafto-addons' ),
						'selfhosted' => esc_html__( 'Self-Hosted', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_video_youtube_link',
				[
					'label'       => esc_html__( 'Video URL', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => esc_url( 'https://www.youtube.com/watch?v=XHOmBV4js_E' ),
					'condition'   => [
						'crafto_video_source' => 'youtube',
					],
				]
			);
			$this->add_control(
				'crafto_backgrond_enable_video',
				[
					'label'        => esc_html__( 'Enable Background Video', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_video_source' => 'youtube',
					],
				]
			);
			$this->add_control(
				'crafto_video_vimeo_link',
				[
					'label'       => esc_html__( 'Video URL', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => esc_url( 'https://vimeo.com/235215203' ),
					'condition'   => [
						'crafto_video_source' => 'vimeo',
					],
				]
			);
			$this->add_control(
				'crafto_video_enable_external_url',
				[
					'label'        => esc_html__( 'Enable External URL', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_video_source' => 'selfhosted',
					],
				]
			);
			$this->add_control(
				'crafto_video_selfhosted_external_link',
				[
					'label'       => esc_html__( 'Choose Video', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'media_types' => [
						'video',
					],
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'crafto_video_source'              => 'selfhosted',
						'crafto_video_enable_external_url' => '',
					],
				]
			);
			$this->add_control(
				'crafto_video_selfhosted_link',
				[
					'label'       => esc_html__( 'Enter Your URL', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_video_source'              => 'selfhosted',
						'crafto_video_enable_external_url' => 'yes',
					],
				]
			);

			$this->add_control(
				'crafto_selfhosted_poster_image',
				[
					'label'     => esc_html__( 'Poster Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_video_source' => 'selfhosted',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_video_play_icon',
				[
					'label'     => esc_html__( 'Video Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_video_source' => 'selfhosted',
					],
				]
			);

			$this->add_control(
				'crafto_video_enable_play_image',
				[
					'label'        => esc_html__( 'Used Image', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_control(
				'crafto_video_select_play_icon',
				[
					'label'            => esc_html__( 'Select Play Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-play',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_video_enable_play_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_video_select_play_image',
				[
					'label'     => esc_html__( 'Play Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_video_enable_play_image' => 'yes',
					],
				]
			);

			$this->add_control(
				'crafto_video_select_pause_icon',
				[
					'label'            => esc_html__( 'Select Pause Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-pause',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'separator'        => 'before',
					'condition'        => [
						'crafto_video_enable_play_image' => '',
						'crafto_video_select_play_icon[value]!' => '',
					],
				]
			);

			$this->add_control(
				'crafto_video_select_pause_image',
				[
					'label'     => esc_html__( 'Pause Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_video_enable_play_image' => 'yes',
					],
				]
			);

			$this->add_control(
				'crafto_video_enable_animation',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'separator'    => 'before',
					'condition'    => [
						'crafto_video_select_play_icon[value]!' => '',
					],
				]
			);

			$this->add_control(
				'crafto_video_icon_animation',
				[
					'label'     => esc_html__( 'Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'animation-sonar',
					'options'   => [
						'animation-sonar' => esc_html__( 'Ripple', 'crafto-addons' ),
						'animation-zoom'  => esc_html__( 'Zoom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_video_select_play_icon[value]!' => '',
						'crafto_video_enable_animation' => 'yes',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_video_option_section',
				[
					'label' => esc_html__( 'Video Settings', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_video_player_control',
				[
					'label'        => esc_html__( 'Enable Player Controls', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_video_autoplay',
				[
					'label'        => esc_html__( 'Enable Autoplay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'conditions'   => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_video_source',
										'operator' => '===',
										'value'    => 'youtube',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_video_source',
										'operator' => '===',
										'value'    => 'vimeo',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_video_source',
										'operator' => '===',
										'value'    => 'selfhosted',
									],
									[
										'name'     => 'crafto_video_select_play_icon[value]',
										'operator' => '===',
										'value'    => '',
									],
								],
							],
						],
					],
				]
			);

			$this->add_control(
				'crafto_video_mute',
				[
					'label'        => esc_html__( 'Enable Mute', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_control(
				'crafto_video_loop',
				[
					'label'        => esc_html__( 'Enable Loop', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_control(
				'crafto_video_rel',
				[
					'label'     => esc_html__( 'Suggested Videos', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''    => esc_html__( 'Current Video Channel', 'crafto-addons' ),
						'yes' => esc_html__( 'Any Video', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_video_source' => 'youtube',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_video_icon_general_section_style',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_video_source' => 'selfhosted',
						'crafto_video_select_play_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_icon_size',
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
						'{{WRAPPER}} .video-icon img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_video_icon_box_size',
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
							'max' => 250,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .video-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .video-icon-sonar-bfr' => 'height: calc( {{SIZE}}{{UNIT}} + 50px ); width: calc( {{SIZE}}{{UNIT}} + 50px )',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_play_icon_margin',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
							'min' => -15,
							'max' => 15,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .video-icon-box .video-icon i, {{WRAPPER}} .video-icon img, {{WRAPPER}} .video-icon svg' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_video_icon_tabs' );

			$this->start_controls_tab(
				'crafto_video_icon_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_video_icon_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .video-icon i, {{WRAPPER}} .video-icon svg',
					'condition'      => [
						'crafto_video_enable_play_image' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_video_icon_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .video-icon-wrap .video-icon',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_video_button_icon_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
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
						'crafto_video_enable_play_image' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_video_button_icon_hover_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .video-icon-wrap .video-icon-box:hover .video-icon',
				]
			);
			$this->add_control(
				'crafto_video_button_icon_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-icon-wrap .video-icon-box:hover .video-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_video_sonar_style_heading',
				[
					'label'     => esc_html__( 'Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_video_enable_animation' => 'yes',
						'crafto_video_icon_animation'   => 'animation-sonar',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'label'          => esc_html__( 'Ripple Background', 'crafto-addons' ),
					'name'           => 'crafto_video_icon_bg_animation_color',
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
					'selector'       => '{{WRAPPER}} .video-icon-sonar .video-icon-sonar-bfr',
					'condition'      => [
						'crafto_video_enable_animation' => 'yes',
						'crafto_video_icon_animation'   => 'animation-sonar',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_sonar_animation_border',
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
					'selectors'  => [
						'{{WRAPPER}} .video-icon-sonar .video-icon-sonar-bfr' => 'border-style: solid; border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_video_enable_animation' => 'yes',
						'crafto_video_icon_animation'   => 'animation-sonar',
					],
				]
			);
			$this->add_control(
				'crafto_video_sonar_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .video-icon-sonar .video-icon-sonar-bfr' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_video_enable_animation' => 'yes',
						'crafto_video_icon_animation'   => 'animation-sonar',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_video_sonar_animation_opacity',
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
						'{{WRAPPER}} .video-icon-sonar .video-icon-sonar-bfr' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_video_enable_animation' => 'yes',
						'crafto_video_icon_animation'   => 'animation-sonar',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_video_button_box_border',
					'selector'  => '{{WRAPPER}} .video-icon-wrap .video-icon',
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_video_button_hover_box_shadow',
					'selector' => '{{WRAPPER}} .video-icon-wrap .video-icon',
				]
			);
			$this->add_responsive_control(
				'crafto_video_button_icon_margin',
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
						'{{WRAPPER}} .video-icon-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_self_video_style',
				[
					'label'     => esc_html__( 'Self Hosted Video', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_video_source' => 'selfhosted',
					],
				]
			);
			$this->add_responsive_control(
				'self_video_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'em',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 800,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .html-video-wrapper' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'self_video_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .html-video-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'self_video_box_shadow',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .html-video-wrapper',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render video widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings        = $this->get_settings_for_display();
			$video_source    = $this->get_settings( 'crafto_video_source' );
			$youtube_link    = $this->get_settings( 'crafto_video_youtube_link' );
			$vimeo_link      = $this->get_settings( 'crafto_video_vimeo_link' );
			$selfhosted_link = $this->get_settings( 'crafto_video_selfhosted_external_link' );
			$external_link   = $this->get_settings( 'crafto_video_selfhosted_link' );

			$poster_image     = $settings['crafto_selfhosted_poster_image'];
			$controls         = $settings['crafto_video_player_control'];
			$autoplay         = $settings['crafto_video_autoplay'];
			$mute             = $settings['crafto_video_mute'];
			$loop             = $settings['crafto_video_loop'];
			$crafto_video_rel = '';

			if ( 'yes' === $settings['crafto_video_rel'] ) {
				$crafto_video_rel = 1;
			} else {
				$crafto_video_rel = 0;
			}

			$cookie_name_array       = [];
			$cookie_blog             = 'crafto_gdpr_cookie' . ( is_multisite() ? '-' . get_current_blog_id() : '' );
			$crafto_gdpr_enable      = get_theme_mod( 'crafto_gdpr_enable', '0' );
			$crafto_iframe_enable    = get_theme_mod( 'crafto_iframe_enable', '1' );
			$crafto_gdpr_iframe_text = get_theme_mod( 'crafto_gdpr_iframe_text', esc_html__( 'This website uses YouTube/Vimeo service to provide video content streaming.', 'crafto-addons' ) );

			if ( isset( $_COOKIE[ $cookie_blog ] ) && ! empty( $_COOKIE[ $cookie_blog ] ) ) {
				$cookie_name_array = explode( ',', $_COOKIE[ $cookie_blog ] ); // phpcs:ignore
			}

			$should_enable_iframe =
					'0' === $crafto_iframe_enable ||
					( ! empty( $cookie_name_array ) && in_array( 'iframe', $cookie_name_array, true ) );

			if ( $should_enable_iframe || '0' === $crafto_gdpr_enable || \Crafto_Addons_Extra_Functions::is_crafto_elementor_editor_preview_mode() ) {
				$is_new         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
				$migrated_play  = isset( $settings['__fa4_migrated']['crafto_video_select_play_icon'] );
				$migrated_pause = isset( $settings['__fa4_migrated']['crafto_video_select_pause_icon'] );

				$icon_play = '';
				if ( $is_new || $migrated_play ) {
					ob_start();
						Icons_Manager::render_icon(
							$settings['crafto_video_select_play_icon'],
							[
								'aria-hidden' => 'true',
								'class'       => 'play-icon',
							]
						);
						$icon_play .= ob_get_clean();
				} elseif ( isset( $settings['crafto_video_select_play_icon']['value'] ) && ! empty( $settings['crafto_video_select_play_icon']['value'] ) ) {
					$icon_play = '<i class="play-icon ' . esc_attr( $settings['crafto_video_select_play_icon']['value'] ) . '" aria-hidden="true"></i>';
				}

				$icon_pause = '';
				if ( $is_new || $migrated_pause ) {
					ob_start();
					Icons_Manager::render_icon(
						$settings['crafto_video_select_pause_icon'],
						[
							'aria-hidden' => 'true',
							'class'       => 'pause-icon',
						]
					);
					$icon_pause .= ob_get_clean();
				} elseif ( isset( $settings['crafto_video_select_pause_icon']['value'] ) && ! empty( $settings['crafto_video_select_pause_icon']['value'] ) ) {
					$icon_pause = '<i class="pause-icon ' . esc_attr( $settings['crafto_video_select_pause_icon']['value'] ) . '" aria-hidden="true"></i>';
				}

				$crafto_play_image = '';
				if ( ! empty( $settings['crafto_video_select_play_image']['id'] ) ) {
					$thumbnail_id       = $settings['crafto_video_select_play_image']['id'];
					$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
					$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
					$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
					$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

					$image_array           = wp_get_attachment_image_src( $settings['crafto_video_select_play_image']['id'], 'full' );
					$crafto_play_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';

					$default_attr = array(
						'class' => 'play-icon',
						'title' => esc_attr( $crafto_image_title ),
					);

					$crafto_play_image = wp_get_attachment_image( $thumbnail_id, 'full', '', $default_attr );

				} elseif ( ! empty( $settings['crafto_video_select_play_image']['url'] ) ) {
					$crafto_play_image_url = $settings['crafto_video_select_play_image']['url'];
					$crafto_image_alt      = esc_attr__( 'Placeholder Image', 'crafto-addons' );
					$crafto_play_image     = sprintf( '<img class="play-icon" src="%1$s" alt="%2$s" />', esc_url( $crafto_play_image_url ), esc_attr( $crafto_image_alt ) );
				}

				$crafto_pause_image = '';
				if ( ! empty( $settings['crafto_video_select_pause_image']['id'] ) ) {
					$thumbnail_id       = $settings['crafto_video_select_pause_image']['id'];
					$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
					$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
					$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
					$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

					$image_array            = wp_get_attachment_image_src( $settings['crafto_video_select_pause_image']['id'], 'full' );
					$crafto_pause_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';

					$default_attr = array(
						'class' => 'pause-icon',
						'title' => esc_attr( $crafto_image_title ),
					);

					$crafto_pause_image = wp_get_attachment_image( $thumbnail_id, 'full', '', $default_attr );

				} elseif ( ! empty( $settings['crafto_video_select_pause_image']['url'] ) ) {
					$crafto_pause_image_url = $settings['crafto_video_select_pause_image']['url'];
					$crafto_image_alt       = esc_attr__( 'Placeholder Image', 'crafto-addons' );
					$crafto_pause_image     = sprintf( '<img class="pause-icon" src="%1$s" alt="%2$s" />', esc_url( $crafto_pause_image_url ), esc_attr( $crafto_image_alt ) );
				}

				$animation = ( 'yes' === $settings['crafto_video_enable_animation'] && 'animation-zoom' === $settings['crafto_video_icon_animation'] ) ? $settings['crafto_video_icon_animation'] : '';
				$this->add_render_attribute(
					[
						'animation_zoom' => [
							'class' => [
								'video-play',
								'video-icon-box',
							],
						],
					],
				);
				if ( $animation ) {
					$this->add_render_attribute(
						[
							'animation_zoom' => [
								'class' => [
									$animation,
								],
							],
						],
					);
				}
				$this->add_render_attribute(
					[
						'wrapper' => [
							'class' => [
								'html-video-play video-icon-wrap',
							],
						],
					],
				);
				$data_settings = array(
					'enable_bg_video' => $this->get_settings( 'crafto_backgrond_enable_video' ),
				);

				if ( 'yes' === $settings['crafto_backgrond_enable_video'] ) {
					$this->add_render_attribute(
						[
							'fit_video' => [
								'class'         => [
									'bg-video-wrapper',
								],
								'data-settings' => wp_json_encode( $data_settings ),
							],
						],
					);
				}
				if ( '' === $settings['crafto_backgrond_enable_video'] ) {
					$this->add_render_attribute(
						[
							'fit_video' => [
								'class' => [
									'fit-videos',
								],
							],
						],
					);
				}

				if ( 'selfhosted' === $video_source ) {
					$player_control = ( '' !== $controls ) ? ' controls' : '';
					$player_mute    = ( '' !== $mute ) ? ' muted' : '';
					$player_loop    = ( '' !== $loop ) ? ' loop' : '';

					$player_autoplay = '';
					if (
						'' !== $autoplay &&
						( ( isset( $settings['crafto_video_select_play_icon']['value'] ) && empty( $settings['crafto_video_select_play_icon']['value'] ) ) || empty( $crafto_play_image ) )
					) {
						$player_autoplay = ' autoplay';
					}
				} else {
					$player_control  = ( '' !== $controls ) ? 1 : 0;
					$player_autoplay = ( '' !== $autoplay ) ? 1 : 0;
					$player_mute     = ( '' !== $mute ) ? 1 : 0;
					$player_loop     = ( '' !== $loop ) ? 1 : 0;
				}

				if ( 'selfhosted' === $video_source ) {
					$selfhosted_url = '';

					if ( 'yes' === $settings['crafto_video_enable_external_url'] ) {
						if ( ! empty( $external_link ) ) {
							$selfhosted_url = $external_link;
						}
					} elseif ( ! empty( $selfhosted_link['url'] ) ) {
						$selfhosted_url = $selfhosted_link['url'];
					}
					if ( ! empty( $selfhosted_url ) ) {
						$poster_img = isset( $poster_image['url'] ) && ! empty( $poster_image['url'] ) ? ' poster="' . esc_url( $poster_image['url'] ) . '"' : '';
						?>
						<div class="html-video-wrapper">
							<video class="video-bg html-video video-play-icon" playsinline <?php echo esc_attr( $player_control ) . esc_attr( $player_mute ) . esc_attr( $player_loop . esc_attr( $player_autoplay ) ); ?><?php echo sprintf( '%s', $poster_img ); // phpcs:ignore ?>>
								<source type="video/mp4" src="<?php echo esc_url( $selfhosted_url ); ?>">
								<source type="video/webm" src="<?php echo esc_url( $selfhosted_url ); ?>">
							</video>
							<?php
							if ( ! empty( $settings['crafto_video_select_play_icon']['value'] ) || ! empty( $crafto_play_image ) ) {
								?>
								<div <?php $this->print_render_attribute_string( 'wrapper' ); ?> >
									<button type="button" <?php $this->print_render_attribute_string( 'animation_zoom' ); ?> >
										<span class="video-icon">
											<?php
											echo filter_var( $settings['crafto_video_enable_play_image'], FILTER_VALIDATE_BOOLEAN ) ? $crafto_play_image : $icon_play; // phpcs:ignore
											echo filter_var( $settings['crafto_video_enable_play_image'], FILTER_VALIDATE_BOOLEAN ) ? $crafto_pause_image : $icon_pause; // phpcs:ignore
											if ( 'yes' === $settings['crafto_video_enable_animation'] && 'animation-sonar' === $settings['crafto_video_icon_animation'] ) {
												?>
												<span class="video-icon-sonar">
													<span class="video-icon-sonar-bfr"></span>
												</span>
												<span class="screen-reader-text"><?php echo esc_html__( 'Video Play Button', 'crafto-addons' ); ?></span>
												<?php
											}
											?>
										</span>
									</button>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
				} elseif ( 'vimeo' === $video_source && ! empty( $vimeo_link ) ) {
					preg_match( '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/', $vimeo_link, $output_array );
					$background_video = ( ! empty( $vimeo_link ) ) ? ' <iframe width="540" height="315" frameborder="0" allowfullscreen mozallowfullscreen webkitallowfullscreen src="https://player.vimeo.com/video/' . esc_attr( $output_array[5] ) . '?controls=' . $player_control . '&autoplay=' . $player_autoplay . '&muted=' . $player_mute . '&loop=' . $player_loop . '&autopause=0"></iframe>' : '';
					?>
					<div class="fit-videos">
						<?php echo $background_video; // phpcs:ignore ?>
					</div>
					<?php
				} elseif ( ! empty( $youtube_link ) ) {
						preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_link, $match );
						$background_video = ( ! empty( $youtube_link ) ) ? ' <iframe width="540" height="315" frameborder="0" allowfullscreen mozallowfullscreen webkitallowfullscreen src="https://www.youtube.com/embed/' . esc_attr( $match[1] ) . '?controls=' . $player_control . '&playsinline=0&autoplay=' . $player_autoplay . '&mute=' . $player_mute . '&loop=' . $player_loop . '&playlist=' . esc_attr( $match[1] ) . '&rel=' . $crafto_video_rel . '"></iframe>' : '';
					?>
						<div <?php $this->print_render_attribute_string( 'fit_video' ); ?>>
							<?php echo $background_video; // phpcs:ignore ?>
						</div>
					<?php
				}
			} else {
				?>
				<div class="crafto-gdpr-no-consent-inner">
					<div class="crafto-gdpr-no-consent-notice-text"><?php echo esc_html( $crafto_gdpr_iframe_text ); ?></div>
				</div>
				<?php
			}
		}
	}
}
