<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto widget for lottie.
 *
 * @package Crafto
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Typography;

// If class `Lottie` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Lottie' ) ) {
	/**
	 * Define `Lottie` class.
	 */
	class Lottie extends \Elementor\Widget_Base {
		/**
		 * Retrieve the list of scripts the lottie widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$lottie_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$lottie_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'lottie' ) ) {
					$lottie_scripts[] = 'lottie';
				}
				$lottie_scripts[] = 'crafto-lottie-animation';
			}
			return $lottie_scripts;
		}
		/**
		 * Retrieve the list of styles the lottie animation widget depended on.
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
					'crafto-lottie-animation',
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
			return 'crafto-lottie';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Lottie Animation', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-lottie crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/lottie-animation/';
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
				'lottie',
				'JSON',
				'vector',
				'motion graphics',
				'creative animations',
				'looping animation',
				'web animation',
				'json animation',
			];
		}

		/**
		 * Register lottie widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_content_section',
				[
					'label' => esc_html__( 'Lottie Animation', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'crafto_lottie_source',
				[
					'label'   => esc_html__( 'Source', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'media_file',
					'options' => [
						'media_file'   => esc_html__( 'Media File', 'crafto-addons' ),
						'external_url' => esc_html__( 'External URL', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_lottie_media',
				[
					'label'       => esc_html__( 'Upload JSON File', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'dynamic'     => [
						'active' => true,
					],
					'media_types' => [
						'application/json',
					],
					'condition'   => [
						'crafto_lottie_source' => 'media_file',
					],
				]
			);
			$this->add_control(
				'crafto_animation_url',
				[
					'label'       => esc_html__( 'External URL', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_lottie_source' => 'external_url',
					],
				]
			);

			$this->add_control(
				'crafto_caption_source',
				[
					'label'     => esc_html__( 'Caption', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none'    => esc_html__( 'None', 'crafto-addons' ),
						'title'   => esc_html__( 'Title', 'crafto-addons' ),
						'caption' => esc_html__( 'Caption', 'crafto-addons' ),
						'custom'  => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_lottie_source!'     => 'external_url',
						'crafto_lottie_media[url]!' => '',
					],
				]
			);

			$this->add_control(
				'crafto_caption',
				[
					'label'       => esc_html__( 'Custom Caption', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'render_type' => 'none',
					'conditions'  => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'  => 'crafto_caption_source',
								'value' => 'custom',
							],
							[
								'name'  => 'crafto_lottie_source',
								'value' => 'external_url',
							],
						],
					],
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_link_to',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'render_type' => 'none',
					'default'     => 'none',
					'options'     => [
						'none'   => esc_html__( 'None', 'crafto-addons' ),
						'custom' => esc_html__( 'Custom URL', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_custom_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'render_type' => 'none',
					'placeholder' => esc_html__( 'Enter your URL', 'crafto-addons' ),
					'condition'   => [
						'crafto_link_to' => 'custom',
					],
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => '',
					],
					'show_label'  => false,
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'settings',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_trigger',
				[
					'label'   => esc_html__( 'Trigger', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'arriving_to_viewport',
					'options' => [
						'arriving_to_viewport' => esc_html__( 'Viewport', 'crafto-addons' ),
						'on_click'             => esc_html__( 'On Click', 'crafto-addons' ),
						'on_hover'             => esc_html__( 'On Hover', 'crafto-addons' ),
						'bind_to_scroll'       => esc_html__( 'Scroll', 'crafto-addons' ),
						'none'                 => esc_html__( 'None', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_renderer',
				[
					'label'     => esc_html__( 'Render Type', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'svg',
					'options'   => [
						'svg'    => esc_html__( 'SVG', 'crafto-addons' ),
						'canvas' => esc_html__( 'Canvas', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_trigger!' => 'none',
					],
				]
			);

			$this->add_control(
				'crafto_effects_relative_to',
				[
					'label'       => esc_html__( 'Effects Relative To', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'render_type' => 'none',
					'condition'   => [
						'crafto_trigger' => 'bind_to_scroll',
					],
					'default'     => 'viewport',
					'options'     => [
						'viewport' => esc_html__( 'Viewport', 'crafto-addons' ),
						'page'     => esc_html__( 'Entire Page', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_on_hover_out',
				[
					'label'       => esc_html__( 'On Hover Out', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'render_type' => 'none',
					'condition'   => [
						'crafto_trigger' => 'on_hover',
					],
					'default'     => 'default',
					'options'     => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'reverse' => esc_html__( 'Reverse', 'crafto-addons' ),
						'pause'   => esc_html__( 'Pause', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_viewport',
				[
					'label'       => esc_html__( 'Viewport', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'render_type' => 'none',
					'conditions'  => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'crafto_trigger',
								'operator' => '===',
								'value'    => 'arriving_to_viewport',
							],
							[
								'name'     => 'crafto_trigger',
								'operator' => '===',
								'value'    => 'bind_to_scroll',
							],
						],
					],
					'default'     => [
						'sizes' => [
							'start' => 0,
							'end'   => 100,
						],
						'unit'  => '%',
					],
					'labels'      => [
						esc_html__( 'Bottom', 'crafto-addons' ),
						esc_html__( 'Top', 'crafto-addons' ),
					],
					'scales'      => 1,
					'handles'     => 'range',
				]
			);

			$this->add_control(
				'crafto_lottie_speed',
				[
					'label'       => esc_html__( 'Play Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'render_type' => 'none',
					'condition'   => [
						'crafto_trigger!' => [
							'bind_to_scroll',
							'none',
						],
					],
					'default'     => [
						'size' => 1,
					],
					'range'       => [
						'px' => [
							'min'  => 0.1,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_start_point',
				[
					'label'       => esc_html__( 'Start Point', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'render_type' => 'none',
					'default'     => [
						'size' => 0,
						'unit' => '%',
					],
					'size_units'  => [
						'%',
					],
					'conditions'  => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'crafto_trigger',
								'operator' => '===',
								'value'    => 'on_click',
							],
						],
					],
				]
			);

			$this->add_control(
				'crafto_end_point',
				[
					'label'       => esc_html__( 'End Point', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'render_type' => 'none',
					'default'     => [
						'size' => 100,
						'unit' => '%',
					],
					'size_units'  => [
						'%',
					],
					'conditions'  => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'crafto_trigger',
								'operator' => '===',
								'value'    => 'on_click',
							],
						],
					],
				]
			);

			$this->add_control(
				'crafto_reverse_animation',
				[
					'label'        => esc_html__( 'Reverse', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'render_type'  => 'none',
					'conditions'   => [
						'relation' => 'and',
						'terms'    => [
							[
								'name'     => 'crafto_trigger',
								'operator' => '!==',
								'value'    => 'bind_to_scroll',
							],
							[
								'name'     => 'crafto_trigger',
								'operator' => '!==',
								'value'    => 'on_hover',
							],
							[
								'name'     => 'crafto_trigger',
								'operator' => '!==',
								'value'    => 'none',
							],
						],
					],
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_lottie_loop',
				[
					'label'        => esc_html__( 'Loop', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'render_type'  => 'none',
					'condition'    => [
						'crafto_trigger!' => [
							'bind_to_scroll',
							'none',
						],
					],
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_control(
				'crafto_number_of_times',
				[
					'label'       => esc_html__( 'Times', 'crafto-addons' ),
					'type'        => Controls_Manager::NUMBER,
					'render_type' => 'none',
					'conditions'  => [
						'relation' => 'and',
						'terms'    => [
							[
								'name'     => 'crafto_trigger',
								'operator' => '!==',
								'value'    => 'bind_to_scroll',
							],
							[
								'name'     => 'crafto_lottie_loop',
								'operator' => '===',
								'value'    => 'yes',
							],
							[
								'name'     => 'crafto_trigger',
								'operator' => '!==',
								'value'    => 'none',
							],
						],
					],
					'min'         => 0,
					'step'        => 1,
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_lottie_style',
				[
					'label' => esc_html__( 'Lottie', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_lottie_align',
				[
					'label'        => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
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
					'prefix_class' => 'elementor%s-align-',
					'default'      => 'center',
				]
			);
			$this->add_responsive_control(
				'crafto_lottie_width',
				[
					'label'          => esc_html__( 'Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'size_units'     => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'default'        => [
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'range'          => [
						'%'   => [
							'min' => 1,
							'max' => 100,
						],
						'px'  => [
							'min' => 1,
							'max' => 1000,
						],
						'em'  => [
							'max' => 100,
						],
						'rem' => [
							'max' => 100,
						],
						'vw'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'      => [
						'{{WRAPPER}} .lottie-animation-wrapper' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_lottie_space',
				[
					'label'          => esc_html__( 'Max Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'size_units'     => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'default'        => [
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'range'          => [
						'%'   => [
							'min' => 1,
							'max' => 100,
						],
						'px'  => [
							'min' => 1,
							'max' => 1000,
						],
						'em'  => [
							'max' => 100,
						],
						'rem' => [
							'max' => 100,
						],
						'vw'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'      => [
						'{{WRAPPER}} .lottie-animation-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->start_controls_tabs(
				'image_effects',
			);

			$this->start_controls_tab(
				'crafto_lottie_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_lottie_opacity',
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
						'{{WRAPPER}} .lottie-animation-wrapper' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'     => 'crafto_lottie_css_filters',
					'selector' => '{{WRAPPER}} .lottie-animation-wrapper',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_lottie_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_lottie_opacity_hover',
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
						'{{WRAPPER}} .lottie-animation-wrapper:hover' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_control(
				'crafto_lottie_hover_transition',
				[
					'label'     => esc_html__( 'Transition Duration', 'crafto-addons' ) . ' (s)',
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .lottie-animation-wrapper' => 'transition: {{SIZE}}s',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'     => 'crafto_lottie_css_filters_hover',
					'selector' => '{{WRAPPER}} .lottie-animation-wrapper:hover',
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_caption',
				[
					'label'     => esc_html__( 'Caption', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_caption_source!' => 'none',
					],
				]
			);

			$this->add_control(
				'crafto_lottie_caption_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
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
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .lottie-caption' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_lottie_caption_typography',
					'selector' => '{{WRAPPER}} .lottie-caption',
				]
			);

			$this->add_control(
				'crafto_lottie_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .lottie-caption' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_lottie_caption_space',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px'  => [
							'max' => 100,
						],
						'em'  => [
							'max' => 10,
						],
						'rem' => [
							'max' => 10,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .lottie-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Render lottie widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 *
		 * @access protected
		 */
		protected function render() {

			$settings       = $this->get_settings_for_display();
			$lottie_caption = '';
			$external_url   = ( isset( $settings['crafto_animation_url']['url'] ) && $settings['crafto_animation_url']['url'] ) ? $settings['crafto_animation_url']['url'] : '';
			$media_url      = ( isset( $settings['crafto_lottie_media']['url'] ) && $settings['crafto_lottie_media']['url'] ) ? $settings['crafto_lottie_media']['url'] : '';
			$source_url     = ( isset( $settings['crafto_lottie_source'] ) && $settings['crafto_lottie_source'] ) ? $settings['crafto_lottie_source'] : '';
			$loop           = 'yes' === $settings['crafto_lottie_loop'] ? 'true' : 'false';
			$speed          = ( isset( $settings['crafto_lottie_speed']['size'] ) && $settings['crafto_lottie_speed']['size'] ) ? $settings['crafto_lottie_speed']['size'] : '';
			$animation_url  = 'external_url' === $source_url ? $external_url : $media_url;
			$caption        = ( isset( $settings['crafto_caption_source'] ) && $settings['crafto_caption_source'] ) ? $settings['crafto_caption_source'] : '';
			$trigger        = ( isset( $settings['crafto_trigger'] ) && $settings['crafto_trigger'] ) ? $settings['crafto_trigger'] : '';
			$renderer       = ( isset( $settings['crafto_renderer'] ) && $settings['crafto_renderer'] ) ? $settings['crafto_renderer'] : '';
			$viewport_start = ( isset( $settings['crafto_viewport']['sizes']['start'] ) && $settings['crafto_viewport']['sizes']['start'] ) ? $settings['crafto_viewport']['sizes']['start'] : '';
			$viewport_end   = ( isset( $settings['crafto_viewport']['sizes']['end'] ) && $settings['crafto_viewport']['sizes']['end'] ) ? $settings['crafto_viewport']['sizes']['end'] : '';
			$times          = ( isset( $settings['crafto_number_of_times'] ) && $settings['crafto_number_of_times'] ) ? $settings['crafto_number_of_times'] : '';
			$start_point    = ( isset( $settings['crafto_start_point']['size'] ) && $settings['crafto_start_point']['size'] ) ? $settings['crafto_start_point']['size'] : '';
			$end_point      = ( isset( $settings['crafto_end_point']['size'] ) && $settings['crafto_end_point']['size'] ) ? $settings['crafto_end_point']['size'] : '';
			$relative_to    = ( isset( $settings['crafto_effects_relative_to'] ) && $settings['crafto_effects_relative_to'] ) ? $settings['crafto_effects_relative_to'] : '';
			$reverse        = ( isset( $settings['crafto_reverse_animation'] ) && $settings['crafto_reverse_animation'] ) ? $settings['crafto_reverse_animation'] : '';
			$hover_out      = ( isset( $settings['crafto_on_hover_out'] ) && $settings['crafto_on_hover_out'] ) ? $settings['crafto_on_hover_out'] : '';

			$lottieconfig = array(
				'lottie_loop'    => $loop,
				'speed'          => $speed,
				'trigger'        => $trigger,
				'renderer'       => $renderer,
				'viewport_start' => $viewport_start,
				'viewport_end'   => $viewport_end,
				'number_of_time' => $times,
				'start_point'    => $start_point,
				'end_point'      => $end_point,
				'relative_to'    => $relative_to,
				'reverse'        => $reverse,
				'hover_out'      => $hover_out,
			);

			if ( ! empty( $settings['crafto_custom_link']['url'] ) && 'custom' === $settings['crafto_link_to'] ) {
				$this->add_link_attributes( 'url', $settings['crafto_custom_link'] );
			}

			if ( ( ( 'media_file' === $source_url && 'none' !== $caption ) && 'custom' === $caption ) || ( 'external_url' === $source_url && '' !== $settings['crafto_caption'] ) ) {
				$lottie_caption = $settings['crafto_caption'];
			} elseif ( 'caption' === $settings['crafto_caption_source'] ) {
				$lottie_caption = wp_get_attachment_caption( $settings['crafto_lottie_media']['id'] );
			} elseif ( 'title' === $settings['crafto_caption_source'] ) {
				$lottie_caption = get_the_title( $settings['crafto_lottie_media']['id'] );
			}

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class'         => [
							'lottie-animation-wrapper',
						],
						'data-settings' => wp_json_encode( $lottieconfig ),
					],
				]
			);

			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				if ( ! empty( $settings['crafto_custom_link']['url'] ) ) {
					?>
					<a <?php $this->print_render_attribute_string( 'url' ); ?>>
					<?php
				}
				?>
				<div class="lottie-animation" data-animation-url="<?php echo esc_url( $animation_url ); ?>"></div>
				<?php
				if ( ! empty( $settings['crafto_custom_link']['url'] ) ) {
					?>
					</a>
					<?php
				}
				?>
				<div class="lottie-caption"><?php echo esc_html( $lottie_caption ); ?></div>
			</div>
			<?php
		}
	}
}
