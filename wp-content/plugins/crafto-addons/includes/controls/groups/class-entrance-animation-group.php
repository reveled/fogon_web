<?php
namespace CraftoAddons\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 *
 * Crafto Entrnace Animation Group Control ( In Widget )
 *
 * @package Crafto
 */

// If class `Crafto_Entrance_Animation_Group` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Controls\Groups\Crafto_Entrance_Animation_Group' ) ) {

	/**
	 * Define Crafto_Entrance_Animation_Group class
	 */
	class Crafto_Entrance_Animation_Group {

		/**
		 * Anime Animation Content Fields.
		 *
		 * @since 1.0
		 * @param object $element Fields data.
		 * @param string $data_type Fields data.
		 * @param array  $condition_arr widget arguments.
		 * @access public
		 */
		public static function add_anime_content_fields( $element, $data_type = 'primary', $condition_arr = [] ) {

			$prefix = 'crafto_' . $data_type . '_';

			$element->add_control(
				$prefix . 'ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => isset( $condition_arr['condition'] ) ? $condition_arr['condition'] : '',

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'ent_settings' => 'yes',
					],

				]
			);
			$element->start_popover();

			$element->add_control(
				$prefix . 'ent_settings_ease',
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
						$prefix . 'ent_anim_opt_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						$prefix . 'ent_anim_opt_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						$prefix . 'ent_anim_opt_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						$prefix . 'ent_anim_opt_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						$prefix . 'ent_anim_opt_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'ent_settings' => 'yes',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_x',
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
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_y',
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
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_xx',
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
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_xy',
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
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_yx',
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
						'size' => 50,
					],
					'condition'  => [
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_yy',
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
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_zx',
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
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_translate_zy',
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
					'condition'  => [
						$prefix . 'ent_anim_translate_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'ent_settings' => 'yes',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_x_opacity',
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
						$prefix . 'ent_anim_opacity_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_y_opacity',
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
						$prefix . 'ent_anim_opacity_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'ent_settings' => 'yes',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						$prefix . 'ent_anim_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						$prefix . 'ent_anim_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_rotate_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'ent_settings' => 'yes',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_perspective_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_perspective_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->add_control(
				$prefix . 'ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						$prefix . 'ent_settings' => 'yes',
					],

				]
			);
			$element->start_popover();
			$element->add_control(
				$prefix . 'ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_scale_opt_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				$prefix . 'ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						$prefix . 'ent_anim_scale_opt_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
		}

		/**
		 * Render animation effect frontend
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public static function render_anime_animation( $element, $data_type = 'primary' ) {
			$prefix = 'crafto_' . $data_type . '_';
			// Data Anime Values.
			$crafto_animation_settings  = $element->get_settings( $prefix . 'ent_settings' );
			$ent_settings_ease          = $element->get_settings( $prefix . 'ent_settings_ease' );
			$ent_settings_elements      = $element->get_settings( $prefix . 'ent_settings_elements' );
			$ent_settings_start_delay   = ( isset( $element->get_settings( 'ent_settings_start_delay' )['size'] ) ) ? $element->get_settings( 'ent_settings_start_delay' )['size'] : '';
			$ent_settings_duration      = ( isset( $element->get_settings( 'ent_anim_opt_duration' )['size'] ) ) ? $element->get_settings( 'ent_anim_opt_duration' )['size'] : '';
			$ent_settings_stagger       = ( isset( $element->get_settings( 'ent_anim_stagger' )['size'] ) ) ? $element->get_settings( 'ent_anim_stagger' )['size'] : '';
			$ent_settings_opacity_x     = $element->get_settings( $prefix . 'ent_anim_opt_x_opacity' );
			$ent_settings_opacity_y     = $element->get_settings( $prefix . 'ent_anim_opt_y_opacity' );
			$ent_settings_perspective_x = $element->get_settings( $prefix . 'ent_anim_opt_perspective_x' );
			$ent_settings_perspective_y = $element->get_settings( $prefix . 'ent_anim_opt_perspective_y' );
			$ent_settings_rotatex_xx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_xx' );
			$ent_settings_rotatex_xy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_xy' );
			$ent_settings_rotatey_yx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_yx' );
			$ent_settings_rotatey_yy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_yy' );
			$ent_settings_rotatez_zx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_zx' );
			$ent_settings_rotatez_zy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_zy' );
			$ent_settings_transalte_x   = $element->get_settings( $prefix . 'ent_anim_opt_translate_x' );
			$ent_settings_transalte_y   = $element->get_settings( $prefix . 'ent_anim_opt_translate_y' );
			$ent_settings_transalte_xx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_xx' );
			$ent_settings_transalte_xy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_xy' );
			$ent_settings_transalte_yx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_yx' );
			$ent_settings_transalte_yy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_yy' );
			$ent_settings_transalte_zx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_zx' );
			$ent_settings_transalte_zy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_zy' );
			$ent_settings_scale_x       = $element->get_settings( $prefix . 'ent_anim_opt_scale_x' );
			$ent_settings_scale_y       = $element->get_settings( $prefix . 'ent_anim_opt_scale_y' );

			$ent_values = [];
			if ( 'yes' === $crafto_animation_settings ) {
				if ( 'yes' === $ent_settings_elements ) {
					$ent_values['el'] = 'childs';
				}

				if ( 'none' !== $ent_settings_ease ) {
					$ent_values['easing'] = $ent_settings_ease;
				}

				if ( ! empty( $ent_settings_start_delay ) ) {
					$ent_values['delay'] = (float) ( $ent_settings_start_delay );
				}

				if ( ! empty( $ent_settings_duration ) ) {
					$ent_values['duration'] = (float) ( $ent_settings_duration );
				}

				if ( ! empty( $ent_settings_stagger ) ) {
					$ent_values['staggervalue'] = (float) ( $ent_settings_stagger );
				}

				if ( ! empty( $ent_settings_opacity_x ) && ! empty( $ent_settings_opacity_y ) && $ent_settings_opacity_x !== $ent_settings_opacity_y ) {
					$ent_values['opacity'] = [ (float) $ent_settings_opacity_x['size'], (float) $ent_settings_opacity_y['size'] ];
				}

				if ( ! empty( $ent_settings_perspective_x ) && ! empty( $ent_settings_perspective_y ) && ( 0 !== $ent_settings_perspective_x['size'] ) && ( 0 !== $ent_settings_perspective_y['size'] ) ) {
					$ent_values['perspective'] = [ (float) $ent_settings_perspective_x['size'], (float) $ent_settings_perspective_y['size'] ];
				}

				if ( ! empty( $ent_settings_rotatex_xx ) && ! empty( $ent_settings_rotatex_xy ) && $ent_settings_rotatex_xx !== $ent_settings_rotatex_xy ) {
					$ent_values['rotateX'] = [ (int) $ent_settings_rotatex_xx['size'], (int) $ent_settings_rotatex_xy['size'] ];
				}

				if ( ! empty( $ent_settings_rotatey_yx ) && ! empty( $ent_settings_rotatey_yy ) && $ent_settings_rotatey_yx !== $ent_settings_rotatey_yy ) {
					$ent_values['rotateY'] = [ (int) $ent_settings_rotatey_yx['size'], (int) $ent_settings_rotatey_yy['size'] ];
				}

				if ( ! empty( $ent_settings_rotatez_zx ) && ! empty( $ent_settings_rotatez_zy ) && $ent_settings_rotatez_zx !== $ent_settings_rotatez_zy ) {
					$ent_values['rotateZ'] = [ (int) $ent_settings_rotatez_zx['size'], (int) $ent_settings_rotatez_zy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_x ) && ! empty( $ent_settings_transalte_y ) && $ent_settings_transalte_x !== $ent_settings_transalte_y ) {
					$ent_values['translate'] = [ (float) $ent_settings_transalte_x['size'], (float) $ent_settings_transalte_y['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_xx ) && ! empty( $ent_settings_transalte_xy ) && $ent_settings_transalte_xx !== $ent_settings_transalte_xy ) {
					$ent_values['translateX'] = [ (float) $ent_settings_transalte_xx['size'], (float) $ent_settings_transalte_xy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_yx ) && ! empty( $ent_settings_transalte_yy ) && $ent_settings_transalte_yx !== $ent_settings_transalte_yy ) {
					$ent_values['translateY'] = [ (float) $ent_settings_transalte_yx['size'], (float) $ent_settings_transalte_yy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_zx ) && ! empty( $ent_settings_transalte_zy ) && $ent_settings_transalte_zx !== $ent_settings_transalte_zy ) {
					$ent_values['translateZ'] = [ (float) $ent_settings_transalte_zx['size'], (float) $ent_settings_transalte_zy['size'] ];
				}

				if ( ! empty( $ent_settings_scale_x ) && ! empty( $ent_settings_scale_y ) && $ent_settings_scale_x !== $ent_settings_scale_y ) {
					$ent_values['scale'] = [ (float) $ent_settings_scale_x['size'], (float) $ent_settings_scale_y['size'] ];
				}
			}

			$data_anime = ! empty( $ent_values ) ? $ent_values : [];

			return wp_json_encode( $data_anime );
		}
	}
}
