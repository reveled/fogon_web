<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for text rotator.
 *
 * @package Crafto
 */

// If class `Text_Rotator` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Text_Rotator' ) ) {
	/**
	 * Define `Text_Rotator` class.
	 */
	class Text_Rotator extends Widget_Base {
		/**
		 * Retrieve the list of scripts the text rotator widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$text_rotator_scripts = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$text_rotator_scripts[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
				if ( '0' === $crafto_disable_all_animation ) {
					if ( crafto_disable_module_by_key( 'appear' ) ) {
						$text_rotator_scripts[] = 'appear';
					}

					if ( crafto_disable_module_by_key( 'anime' ) ) {
						$text_rotator_scripts[] = 'anime';
						$text_rotator_scripts[] = 'splitting';
						$text_rotator_scripts[] = 'crafto-fancy-text-effect';
					}
				}
				$text_rotator_scripts[] = 'crafto-text-rotator';
			}
			return $text_rotator_scripts;
		}
		/**
		 * Retrieve the list of scripts the text rotator widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_style_depends() {
			$text_rotator_style = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$text_rotator_style[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					$text_rotator_style[] = 'splitting';
				}
			}
			return $text_rotator_style;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve text rotator widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-text-rotator';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve text rotator widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Text Rotator', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve text rotator widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-animation-text crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/text-rotator/';
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
				'rotate',
				'flip',
				'animation',
				'effect',
				'text motion',
				'headline',
				'animated text',
			];
		}

		/**
		 * Register text rotator widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_text_rotate_content_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_text_rotate_title',
				[
					'label'       => esc_html__( 'Before Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => 'Design made',
					'label_block' => true,
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_text_rotate_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_text_rotate_items',
				[
					'label'       => esc_html__( 'Rotator Text', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_text_rotate_text' => esc_html__( 'simple', 'crafto-addons' ),
						],
						[
							'crafto_text_rotate_text' => esc_html__( 'creative', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_text_rotate_text }}}',
				]
			);
			$this->add_control(
				'crafto_text_rotate_last_text',
				[
					'label'       => esc_html__( 'After Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => 'for you.',
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_text_rotate_header_size',
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
					'default' => 'h2',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_heading_vertical_text',
				[
					'label' => esc_html__( 'Vertical Text', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_vertical_direction',
				[
					'label'        => esc_html__( 'Enable Vertical Text', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'prefix_class' => 'elementor-title-',
					'return_value' => 'vertical-text',
				]
			);
			$this->add_responsive_control(
				'crafto_vertical_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min'  => 1,
							'max'  => 1000,
							'step' => 1,
						],
						'%'  => [
							'min'  => 1,
							'max'  => 100,
							'step' => 1,
						],
					],
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-title-vertical-text' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_vertical_direction' => 'vertical-text',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_text_rotate_text_animation',
				[
					'label' => esc_html__( 'Effects', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_primary_data_fancy_text_settings',
				[
					'label'        => esc_html__( 'Enable Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_effect',
				[
					'label'       => esc_html__( 'Effect', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'wave',
					'options'   => [
						'wave'        => esc_html__( 'Wave', 'crafto-addons' ),
						'smooth-wave' => esc_html__( 'Smooth Wave', 'crafto-addons' ),
						'curve'       => esc_html__( 'Curve', 'crafto-addons' ),
						'rotate'      => esc_html__( 'Rotate', 'crafto-addons' ),
						'slide'       => esc_html__( 'Slide', 'crafto-addons' ),
						'jump'        => esc_html__( 'Jump', 'crafto-addons' ),
						'zoom'        => esc_html__( 'Zoom', 'crafto-addons' ),
						'rubber-band' => esc_html__( 'Rubber Band', 'crafto-addons' ),
						'fade'        => esc_html__( 'Fade', 'crafto-addons' ),
						'custom'      => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_ease',
				[
					'label'       => esc_html__( 'Easing', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_primary_data_fancy_text_settings_effect' => 'custom',
						'crafto_primary_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_colors',
				[
					'label'       => esc_html__( 'Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'default'     => '#ffe400',
					'condition'   => [
						'crafto_primary_data_fancy_text_settings_effect' => 'slide',
						'crafto_primary_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_start_delay',
				[
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						's' => [
							'min'  => 10,
							'max'  => 3000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 's',
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_settings_effect' => 'custom',
						'crafto_primary_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						's' => [
							'min'  => 3000,
							'max'  => 10000,
							'step' => 100,
						],
					],
					'default'    => [
						'unit' => 's',
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_speed',
				[
					'label'       => esc_html__( 'Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 500,
							'step' => 5,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
						'crafto_primary_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_x_opacity',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_y_opacity',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
						'crafto_primary_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_translate_x',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_translate_xx',
				[
					'label'         => esc_html__( 'Start', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_translate_xy',
				[
					'label'         => esc_html__( 'End', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'     => 'after',
					'condition'  => [
						'crafto_primary_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_translate_y',
				[
					'label'     => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_translate_yx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_translate_yy',
				[
					'label'         => esc_html__( 'End', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'     => 'after',
					'condition'  => [
						'crafto_primary_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
						'crafto_primary_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_rotate',
				[
					'label'     => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_x_rotate',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_y_rotate',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_filter_settings_popover',
				[
					'label'        => esc_html__( 'Blur', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
						'crafto_primary_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_blur',
				[
					'label'     => esc_html__( 'Blur', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_x_filter',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_y_filter',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_clippath_settings_popover',
				[
					'label'        => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_data_fancy_text_settings' => 'yes',
						'crafto_primary_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_data_fancy_text_clippath',
				[
					'label'     => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_x_clippath',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 1,
						],
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_data_fancy_text_settings_y_clippath',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 1,
						],
					],
					'condition'  => [
						'crafto_primary_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_alignment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
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
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'toggle'               => false,
					'selectors' => [
						'{{WRAPPER}} .crafto-text-rotator' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_vertical_direction' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_vertical_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Start', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'End', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}}.elementor-title-vertical-text' => 'align-self: {{VALUE}};',
					],
					'condition' => [
						'crafto_vertical_direction' => 'vertical-text',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_general_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-text-rotator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_general_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-text-rotator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_text_rotate_title_style_section',
				[
					'label' => esc_html__( 'Before/After Text', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_text_rotate_title_type',
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
					'name'           => 'crafto_stroke_text_rotate_title_color',
					'selector'       => '{{WRAPPER}} .text-rotate-title, {{WRAPPER}} .rotate-title-last-text',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_text_rotate_title_type' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_text_rotate_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .text-rotate-title, {{WRAPPER}} .rotate-title-last-text',
				]
			);
			$this->add_control(
				'crafto_text_rotate_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .text-rotate-title, {{WRAPPER}} .rotate-title-last-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_text_rotate_title_shadow',
					'selector' => '{{WRAPPER}} .text-rotate-title, {{WRAPPER}} .rotate-title-last-text',
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_title_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .text-rotate-title, {{WRAPPER}} .rotate-title-last-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_title_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .text-rotate-title, {{WRAPPER}} .rotate-title-last-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_title_display_settings',
				[
					'label'     => esc_html__( 'Display', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''             => esc_html__( 'Default', 'crafto-addons' ),
						'block'        => esc_html__( 'Block', 'crafto-addons' ),
						'inline'       => esc_html__( 'Inline', 'crafto-addons' ),
						'inline-block' => esc_html__( 'Inline Block', 'crafto-addons' ),
						'initial'      => esc_html__( 'Initial', 'crafto-addons' ),
						'none'         => esc_html__( 'None', 'crafto-addons' ),
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .text-rotate-title, {{WRAPPER}} .rotate-title-last-text' => 'display: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_text_rotate_style_section',
				[
					'label' => esc_html__( 'Rotating Text', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_text_rotate_text_type',
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
					'name'           => 'crafto_stroke_text_rotate_text_color',
					'selector'       => '{{WRAPPER}} .text-rotator',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_text_rotate_text_type' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_text_rotate_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .text-rotator',
				]
			);
			$this->add_control(
				'crafto_text_rotate_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .text-rotator' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_text_rotate_shadow',
					'selector' => '{{WRAPPER}} .text-rotator',
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_width',
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
							'min' => 0,
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .text-rotator' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .text-rotator' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .text-rotator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_rotate_display_settings',
				[
					'label'     => esc_html__( 'Display', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''             => esc_html__( 'Default', 'crafto-addons' ),
						'block'        => esc_html__( 'Block', 'crafto-addons' ),
						'inline'       => esc_html__( 'Inline', 'crafto-addons' ),
						'inline-block' => esc_html__( 'Inline Block', 'crafto-addons' ),
						'initial'      => esc_html__( 'Initial', 'crafto-addons' ),
						'none'         => esc_html__( 'None', 'crafto-addons' ),
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .text-rotator' => 'display: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render text rotator widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                      = $this->get_settings_for_display();
			$data_fancy_text               = [];
			$text_rotate_title_string      = [];
			$crafto_text_rotate_title      = ( isset( $settings['crafto_text_rotate_title'] ) && ! empty( $settings['crafto_text_rotate_title'] ) ) ? $settings['crafto_text_rotate_title'] : '';
			$crafto_text_rotate_last_text  = ( isset( $settings['crafto_text_rotate_last_text'] ) && ! empty( $settings['crafto_text_rotate_last_text'] ) ) ? $settings['crafto_text_rotate_last_text'] : '';
			$crafto_text_rotate_title_type = ( isset( $settings['crafto_text_rotate_title_type'] ) && ! empty( $settings['crafto_text_rotate_title_type'] ) ) ? $settings['crafto_text_rotate_title_type'] : '';
			$crafto_text_rotate_text_type  = ( isset( $settings['crafto_text_rotate_text_type'] ) && ! empty( $settings['crafto_text_rotate_text_type'] ) ) ? $settings['crafto_text_rotate_text_type'] : '';
			$item_by_item                  = $settings['crafto_ent_anim_item_by_item'];
			$item_by_item_tag              = 'yes' === $item_by_item ? 'div' : 'span';
			$crafto_text_rotate_animation  = $this->render_fancy_text_animation( $this, 'primary' );

			$fancy_text_animation = '';
			if ( ! empty( $crafto_text_rotate_animation ) ) {
				foreach ( $settings['crafto_text_rotate_items'] as $item ) {
					$crafto_text_rotator_title = $item['crafto_text_rotate_text'];
					$data_fancy_text[]         = ! empty( $crafto_text_rotator_title ) ? $crafto_text_rotator_title : '';
				}

				$crafto_text_rotate_animation       = wp_json_encode( $crafto_text_rotate_animation );
				$text_rotate_title_string['string'] = $data_fancy_text;
				$fancy_text_animation               = wp_json_encode( array_merge( $text_rotate_title_string, json_decode( $crafto_text_rotate_animation, true ) ) );
			}

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'crafto-text-rotator',
				]
			);

			$this->add_render_attribute(
				'text_rotate_title',
				'class',
				[
					'text-rotate-title',
				]
			);
			if ( 'stroke' === $crafto_text_rotate_title_type ) {
				$this->add_render_attribute(
					'text_rotate_title',
					'class',
					[
						'text-stroke',
					]
				);
			}

			$this->add_render_attribute(
				'rotate_title_last_text',
				'class',
				[
					'rotate-title-last-text',
				]
			);
			if ( 'stroke' === $crafto_text_rotate_title_type ) {
				$this->add_render_attribute(
					'rotate_title_last_text',
					'class',
					[
						'text-stroke',
					]
				);
			}

			if ( ! empty( $fancy_text_animation ) ) {
				$this->add_render_attribute(
					[
						'text_rotator_title' => [
							'class'           =>
							[
								'text-rotator',
							],
							'data-fancy-text' => $fancy_text_animation,
						],
					]
				);
			}

			if ( 'stroke' === $crafto_text_rotate_text_type ) {
				$this->add_render_attribute(
					'text_rotator_title',
					'class',
					[
						'text-stroke',
					]
				);
			}
			?>
			<<?php Utils::print_validated_html_tag( $settings['crafto_text_rotate_header_size'] ); ?> <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				if ( ! empty( $crafto_text_rotate_title ) ) {
					?>
					<<?php echo esc_html( $item_by_item_tag ); ?> <?php $this->print_render_attribute_string( 'text_rotate_title' ); ?>>
						<?php echo esc_html( $crafto_text_rotate_title ); ?>
					</<?php echo esc_html( $item_by_item_tag ); ?>>
					<?php
				}
				?>
				<<?php echo esc_html( $item_by_item_tag ); ?> <?php $this->print_render_attribute_string( 'text_rotator_title' ); ?>>
					<?php
					foreach ( $settings['crafto_text_rotate_items'] as $item ) {
						$crafto_text_rotator_title = $item['crafto_text_rotate_text'];
						if ( isset( $crafto_text_rotator_title ) && ! empty( $crafto_text_rotator_title ) ) {
							echo sprintf( '%s', $crafto_text_rotator_title ); // phpcs:ignore
						}
					}
					?>
				</<?php echo esc_html( $item_by_item_tag ); ?>>
				<?php
				if ( ! empty( $crafto_text_rotate_last_text ) ) {
					?>
					<<?php echo esc_html( $item_by_item_tag ); ?> <?php $this->print_render_attribute_string( 'rotate_title_last_text' ); ?>>
						<?php echo esc_html( $crafto_text_rotate_last_text ); ?>
					</<?php echo esc_html( $item_by_item_tag ); ?>>
					<?php
				}
				?>
				</<?php Utils::print_validated_html_tag( $settings['crafto_text_rotate_header_size'] ); ?>>
			<?php
		}

		/**
		 * Return Data Fancy Text Animation.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public function render_fancy_text_animation( $element, $data_type = 'primary' ) {
			$prefix = 'crafto_' . $data_type . '_';
			// Data Fancy Text Values.
			$crafto_fancy_text_animation_enable    = $element->get_settings( $prefix . 'data_fancy_text_settings' );
			$data_fancy_text_settings_colors       = $element->get_settings( $prefix . 'data_fancy_text_settings_colors' );
			$data_fancy_text_settings_effect       = $element->get_settings( $prefix . 'data_fancy_text_settings_effect' );
			$data_fancy_text_settings_ease         = $element->get_settings( $prefix . 'data_fancy_text_settings_ease' );
			$data_fancy_text_settings_start_delay  = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_start_delay' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_start_delay' )['size'] : '';
			$data_fancy_text_settings_duration     = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_duration' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_duration' )['size'] : '';
			$data_fancy_text_settings_speed        = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_speed' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_speed' )['size'] : '';
			$data_fancy_text_settings_x_opacity    = $element->get_settings( $prefix . 'data_fancy_text_settings_x_opacity' );
			$data_fancy_text_settings_y_opacity    = $element->get_settings( $prefix . 'data_fancy_text_settings_y_opacity' );
			$data_fancy_text_settings_translate_xx = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_xx' );
			$data_fancy_text_settings_translate_xy = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_xy' );
			$data_fancy_text_settings_translate_yx = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_yx' );
			$data_fancy_text_settings_translate_yy = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_yy' );
			$data_fancy_text_settings_x_filter     = $element->get_settings( $prefix . 'data_fancy_text_settings_x_filter' );
			$data_fancy_text_settings_y_filter     = $element->get_settings( $prefix . 'data_fancy_text_settings_y_filter' );
			$data_fancy_text_settings_x_clippath   = $element->get_settings( $prefix . 'data_fancy_text_settings_x_clippath' );
			$data_fancy_text_settings_y_clippath   = $element->get_settings( $prefix . 'data_fancy_text_settings_y_clippath' );
			$data_fancy_text_settings_x_rotate     = $element->get_settings( $prefix . 'data_fancy_text_settings_x_rotate' );
			$data_fancy_text_settings_y_rotate     = $element->get_settings( $prefix . 'data_fancy_text_settings_y_rotate' );

			$fancy_text_value_arr = [];
			if ( 'yes' === $crafto_fancy_text_animation_enable ) {
				if ( 'custom' !== $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['effect'] = $data_fancy_text_settings_effect;
				}

				if ( 'wave' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'up';
				}

				if ( 'rubber-band' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'left';
				}

				if ( 'slide' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'right';
				}

				if ( 'smooth-wave' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'down';
				}

				if ( 'none' !== $data_fancy_text_settings_ease ) {
					$fancy_text_value_arr['easing'] = $data_fancy_text_settings_ease;
				}

				if ( ! empty( $data_fancy_text_settings_colors ) && 'slide' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['color'] = $data_fancy_text_settings_colors;
				}

				if ( ! empty( $data_fancy_text_settings_duration ) ) {
					$fancy_text_value_arr['duration'] = (float) ( $data_fancy_text_settings_duration );
				}

				if ( ! empty( $data_fancy_text_settings_speed ) ) {
					$fancy_text_value_arr['speed'] = (float) ( $data_fancy_text_settings_speed );
				}

				if ( 'custom' === $data_fancy_text_settings_effect ) {

					if ( ! empty( $data_fancy_text_settings_start_delay ) ) {
						$fancy_text_value_arr['delay'] = (float) ( $data_fancy_text_settings_start_delay );
					}

					if ( ! empty( $data_fancy_text_settings_x_opacity ) && ! empty( $data_fancy_text_settings_y_opacity ) && $data_fancy_text_settings_x_opacity !== $data_fancy_text_settings_y_opacity ) {
						$fancy_text_value_arr['opacity'] = [ (float) $data_fancy_text_settings_x_opacity['size'], (float) $data_fancy_text_settings_y_opacity['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_x_rotate ) && ! empty( $data_fancy_text_settings_y_rotate ) && $data_fancy_text_settings_x_rotate !== $data_fancy_text_settings_y_rotate ) {
						$fancy_text_value_arr['rotate'] = [ (int) $data_fancy_text_settings_x_rotate['size'], (int) $data_fancy_text_settings_y_rotate['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_translate_xx ) && ! empty( $data_fancy_text_settings_translate_xy ) && $data_fancy_text_settings_translate_xx !== $data_fancy_text_settings_translate_xy ) {
						$fancy_text_value_arr['translateX'] = [ (float) $data_fancy_text_settings_translate_xx['size'], (float) $data_fancy_text_settings_translate_xy['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_translate_yx ) && ! empty( $data_fancy_text_settings_translate_yy ) && $data_fancy_text_settings_translate_yx !== $data_fancy_text_settings_translate_yy ) {
						$fancy_text_value_arr['translateY'] = [ (float) $data_fancy_text_settings_translate_yx['size'], (float) $data_fancy_text_settings_translate_yy['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_x_filter ) && ! empty( $data_fancy_text_settings_y_filter ) && $data_fancy_text_settings_x_filter !== $data_fancy_text_settings_y_filter ) {
						$fancy_text_value_arr['filter'] = [ 'blur(' . (float) $data_fancy_text_settings_x_filter['size'] . 'px)', 'blur(' . (float) $data_fancy_text_settings_y_filter['size'] . 'px)' ];
					}

					if ( ! empty( $data_fancy_text_settings_x_clippath ) && ! empty( $data_fancy_text_settings_y_clippath ) && $data_fancy_text_settings_x_clippath !== $data_fancy_text_settings_y_clippath ) {
						$fancy_text_value_arr['clipPath'] = [ 'inset(' . (float) $data_fancy_text_settings_x_clippath['top'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['right'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['bottom'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['left'] . 'px)', 'inset(' . (float) $data_fancy_text_settings_y_clippath['top'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['right'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['bottom'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['left'] . 'px)' ];
					}
				}
			}

			$data_fancy_text = ! empty( $fancy_text_value_arr ) ? $fancy_text_value_arr : [];
			return $data_fancy_text;
		}
	}
}
