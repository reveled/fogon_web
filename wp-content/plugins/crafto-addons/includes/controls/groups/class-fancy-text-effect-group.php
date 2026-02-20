<?php
namespace CraftoAddons\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Crafto fancy text effect group control.
 *
 * A base control for creating animation control.
 *
 * @package Crafto
 */

// If class `Crafto_Fancy_Text_Effect_Group` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Controls\Groups\Crafto_Fancy_Text_Effect_Group' ) ) {

	/**
	 * Define Crafto_Fancy_Text_Effect_Group class
	 */
	class Crafto_Fancy_Text_Effect_Group {

		/**
		 * Fancy Text Animation Content Fields.
		 *
		 * @since 1.0
		 * @param object $element Fields data.
		 * @param string $data_type Fields data.
		 * @param array  $condition_arr widget arguments.
		 * @access public
		 */
		public static function add_fancy_text_content_fields( $element, $data_type = 'primary', $condition_arr = [] ) {

			$prefix = 'crafto_' . $data_type . '_';

			$element->add_control(
				$prefix . 'data_fancy_text_settings',
				[
					'label'        => esc_html__( 'Enable Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => $element->get_name() === 'crafto-text-rotator' ? 'yes' : '',
					'condition'    => isset( $condition_arr['condition'] ) ? $condition_arr['condition'] : '',

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_effect',
				[
					'label'     => esc_html__( 'Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'wave',
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
						$prefix . 'data_fancy_text_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
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
						$prefix . 'data_fancy_text_settings_effect' => 'custom',
						$prefix . 'data_fancy_text_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_colors',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffe400',
					'condition' => [
						$prefix . 'data_fancy_text_settings_effect' => 'slide',
						$prefix . 'data_fancy_text_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_settings_effect' => 'custom',
						$prefix . 'data_fancy_text_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_speed',
				[
					'label'      => esc_html__( 'Speed', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'data_fancy_text_settings' => 'yes',
						$prefix . 'data_fancy_text_settings_effect' => 'custom',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'data_fancy_text_opacity_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_opacity_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'data_fancy_text_settings' => 'yes',
						$prefix . 'data_fancy_text_settings_effect' => 'custom',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_translate_x',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_translate_settings_popover' => 'yes',
					],
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
					'separator'  => 'after',
					'condition'  => [
						$prefix . 'data_fancy_text_translate_settings_popover' => 'yes',
					],
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_translate_y',
				[
					'label'     => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_translate_settings_popover' => 'yes',
					],
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
					'separator'  => 'after',
					'condition'  => [
						$prefix . 'data_fancy_text_translate_settings_popover' => 'yes',
					],
				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'data_fancy_text_settings' => 'yes',
						$prefix . 'data_fancy_text_settings_effect' => 'custom',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_rotate',
				[
					'label'     => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_x_rotate',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_y_rotate',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_filter_settings_popover',
				[
					'label'        => esc_html__( 'Blur', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'data_fancy_text_settings' => 'yes',
						$prefix . 'data_fancy_text_settings_effect' => 'custom',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_blur',
				[
					'label'     => esc_html__( 'Blur', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_x_filter',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_filter_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_y_filter',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						$prefix . 'data_fancy_text_filter_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_clippath_settings_popover',
				[
					'label'        => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'data_fancy_text_settings' => 'yes',
						$prefix . 'data_fancy_text_settings_effect' => 'custom',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'data_fancy_text_clippath',
				[
					'label'     => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_x_clippath',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
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
						$prefix . 'data_fancy_text_clippath_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'data_fancy_text_settings_y_clippath',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
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
						$prefix . 'data_fancy_text_clippath_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
		}

		/**
		 * Return Data Fancy Text Animation.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public static function render_fancy_text_animation( $element, $data_type = 'primary' ) {
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
