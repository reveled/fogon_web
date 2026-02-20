<?php
namespace CraftoAddons\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 *
 * Crafto Animation Group Control ( For Container, Column, Section, Widget Adv.)
 *
 * @package Crafto
 */

// If class `Crafto_Common_Animation_Group` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {

	/**
	 * Define Crafto_Common_Animation_Group class
	 */
	class Crafto_Common_Animation_Group {

		/**
		 * Scrolling Animation Content Fields.
		 *
		 * @since 1.0
		 * @param object $element Fields data.
		 * @access public
		 */
		public static function add_scrolling_animation_controls( $element ) {

			$element->start_controls_section(
				'crafto_advanced_tab_style',
				[
					'label' => esc_html__( 'Scrolling Animation', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				]
			);
			$element->add_control(
				'crafto_animation_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',

				]
			);

			$element->start_controls_tabs(
				'crafto_animation_tabs',
				[
					'condition' => [
						'crafto_animation_settings' => 'yes',
					],
				]
			);
			$element->start_controls_tab(
				'crafto_scrolling_up',
				[
					'label'     => esc_html__( 'Animate From', 'crafto-addons' ),
					'condition' => [
						'crafto_animation_settings' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_scrolling_up_translate_x',
				[
					'label'      => esc_html__( 'Translate X', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_translate_y',
				[
					'label'      => esc_html__( 'Translate Y', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_translate_z',
				[
					'label'      => esc_html__( 'Translate Z', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_scale_x',
				[
					'label'      => esc_html__( 'Scale', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_rotation',
				[
					'label'      => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'deg',
					],
					'range'      => [
						'deg' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'unit' => 'deg',
						'size' => 0,
					],
					'condition'  => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_filter_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'condition' => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_filter_blur',
				[
					'label'     => esc_html__( 'Blur', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 10,
							'step' => 1,
						],
					],
					'condition' => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_translate3d_tx',
				[
					'label'      => esc_html__( 'Translate3d X', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_translate3d_ty',
				[
					'label'      => esc_html__( 'Translate3d Y', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_up_translate3d_tz',
				[
					'label'      => esc_html__( 'Translate3d Z', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->end_controls_tab();
			$element->start_controls_tab(
				'crafto_scrolling_down',
				[
					'label'     => esc_html__( 'Animate To', 'crafto-addons' ),
					'condition' => [
						'crafto_animation_settings' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_scrolling_down_translate_x',
				[
					'label'      => esc_html__( 'Translate X', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_translate_y',
				[
					'label'      => esc_html__( 'Translate Y', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_translate_z',
				[
					'label'      => esc_html__( 'Translate Z', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_scale_x',
				[
					'label'      => esc_html__( 'Scale', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_rotation',
				[
					'label'      => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'deg',
					],
					'range'      => [
						'deg' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'unit' => 'deg',
						'size' => 0,
					],
					'condition'  => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_filter_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'condition' => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_filter_blur',
				[
					'label'     => esc_html__( 'Blur', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 10,
							'step' => 1,
						],
					],
					'condition' => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_translate3d_tx',
				[
					'label'      => esc_html__( 'Translate3d X', 'crafto-addons' ),
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
						'size' => -50,
					],
					'condition'  => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_translate3d_ty',
				[
					'label'      => esc_html__( 'Translate3d Y', 'crafto-addons' ),
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
						'size' => -50,
					],
					'condition'  => [
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_scrolling_down_translate3d_tz',
				[
					'label'      => esc_html__( 'Translate3d Z', 'crafto-addons' ),
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
						'crafto_animation_settings' => 'yes',
					],

				]
			);
			$element->end_controls_tab();
			$element->end_controls_tabs();
			$element->end_controls_section();
		}

		/**
		 *  Crafto Animation Fields.
		 *
		 * @since 1.0
		 * @param object $element Fields data.
		 * @access public
		 */
		public static function add_entrance_animation_controls( $element ) {

			$element->start_controls_section(
				'crafto_advanced_animation_tab_style',
				[
					'label' => esc_html__( 'Entrance Animation', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				]
			);
			$element->add_control(
				'crafto_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',

				]
			);
			$element->add_control(
				'crafto_ent_apply',
				[
					'label'       => esc_html__( 'Play Animations', 'crafto-addons' ),
					'type'        => Controls_Manager::BUTTON,
					'button_type' => 'success',
					'text'        => esc_html__( 'Play', 'crafto-addons' ),
					'event'       => 'crafto_apply',
					'condition'   => [
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_settings_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->start_popover();

			$element->add_control(
				'crafto_ent_anim_opt_ease',
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
						'crafto_ent_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_item_by_item',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_ent_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_duration',
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
						'crafto_ent_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_stagger',
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
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_ent_settings_popover' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_start_delay',
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
						'size' => 0,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_ent_settings_popover' => 'yes',
					],

				]
			);
			$element->end_popover();
			$element->start_controls_tabs(
				'crafto_entrance_animation_tabs',
				[
					'condition' => [
						'crafto_ent_settings' => 'yes',
					],
				]
			);
			$element->start_controls_tab(
				'crafto_entrance_animation_up',
				[
					'label'     => esc_html__( 'Animate From', 'crafto-addons' ),
					'condition' => [
						'crafto_ent_settings' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Translate', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Translate X', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Translate Y', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Translate Z', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_x_zoom',
				[
					'label'      => esc_html__( 'Zoom', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Rotate X', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Rotate Y', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Rotate Z', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Perspective', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Scale', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_scale_x_start',
				[
					'label'      => esc_html__( 'Scale X', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_scale_y_start',
				[
					'label'      => esc_html__( 'Scale Y', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_clippath_x',
				[
					'label'      => esc_html__( 'ClipPath', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->end_controls_tab();
			$element->start_controls_tab(
				'crafto_entrance_animation_down',
				[
					'label'     => esc_html__( 'Animate To', 'crafto-addons' ),
					'condition' => [
						'crafto_ent_settings' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'Translate', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'Translate X', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'Translate Y', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'Translate Z', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_y_zoom',
				[
					'label'      => esc_html__( 'Zoom', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'Rotate X', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'Rotate Y', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'Rotate Z', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'Perspective', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'Scale', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_scale_x_end',
				[
					'label'      => esc_html__( 'Scale X', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_scale_y_end',
				[
					'label'      => esc_html__( 'Scale Y', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->add_control(
				'crafto_ent_anim_opt_clippath_y',
				[
					'label'      => esc_html__( 'ClipPath', 'crafto-addons' ),
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
						'crafto_ent_settings' => 'yes',
					],

				]
			);
			$element->end_controls_tab();
			$element->end_controls_tabs();
			$element->end_controls_section();
		}

		/**
		 *  Add float animation content fields
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public static function add_float_animation_controls( $element ) {
			$element->start_controls_section(
				'crafto_float_animation_tab_style',
				[
					'label' => esc_html__( 'Floating & Rotate Animation', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				]
			);

			$element->add_control(
				'crafto_floating_effects_show',
				[
					'label'              => esc_html__( 'Enable Floating', 'crafto-addons' ),
					'type'               => Controls_Manager::SWITCHER,
					'label_on'           => esc_html__( 'On', 'crafto-addons' ),
					'label_off'          => esc_html__( 'Off', 'crafto-addons' ),
					'default'            => '',
					'return_value'       => 'yes',
					'frontend_available' => true,
				]
			);
			$element->add_control(
				'crafto_float_animation',
				[
					'label'       => esc_html__( 'Animation', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'float',
					'label_block' => true,
					'options'     => [
						'float'  => esc_html__( 'Floating', 'crafto-addons' ),
						'rotate' => esc_html__( 'Rotate', 'crafto-addons' ),
					],
					'condition'   => [
						'crafto_floating_effects_show' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_float_animation_delay',
				[
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 0,
						'unit' => 'ms',
					],
					'condition'   => [
						'crafto_floating_effects_show' => 'yes',
						'crafto_float_animation'       => 'float',
					],
					'render_type' => 'template',
					'selectors'   => [
						'{{WRAPPER}}.animation-float' => '--float-delay: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$element->add_control(
				'crafto_float_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 2000,
						'unit' => 'ms',
					],
					'condition'   => [
						'crafto_floating_effects_show' => 'yes',
						'crafto_float_animation'       => 'float',
					],
					'render_type' => 'template',
					'selectors'   => [
						'{{WRAPPER}}.animation-float' => '--float-duration: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$element->add_control(
				'crafto_float_easing',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'linear',
					'options'   => [
						'linear'      => esc_html__( 'linear', 'crafto-addons' ),
						'ease'        => esc_html__( 'ease', 'crafto-addons' ),
						'ease-in'     => esc_html__( 'easeIn', 'crafto-addons' ),
						'ease-out'    => esc_html__( 'easeOut', 'crafto-addons' ),
						'ease-in-out' => esc_html__( 'easeInOut', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}}.animation-float' => '--float-animation-ease: {{VALUE}}',
					],
					'condition' => [
						'crafto_floating_effects_show' => 'yes',
						'crafto_float_animation'       => 'float',
					],
				]
			);
			$element->add_control(
				'crafto_floating_effects_rotate_infinite',
				[
					'label'              => esc_html__( 'Infinite Rotate', 'crafto-addons' ),
					'type'               => Controls_Manager::SWITCHER,
					'default'            => 'yes',
					'return_value'       => 'yes',
					'frontend_available' => true,
					'selectors'          => [
						'{{WRAPPER}} .elementor-widget-container > *' => 'animation: rotation var(--crafto-rotate-duration, 2000ms) linear infinite;animation-delay: var(--crafto-rotate-delay, 0);',
					],
					'prefix_class'       => 'crafto-floating-effect-infinite--',
					'condition'          => [
						'crafto_floating_effects_show' => 'yes',
						'crafto_float_animation'       => 'rotate',
					],
				]
			);
			$element->add_control(
				'crafto_floating_effects_rotate_duration',
				[
					'label'              => esc_html__( 'Duration', 'crafto-addons' ),
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
						'{{WRAPPER}}' => '--crafto-rotate-duration: {{SIZE}}{{UNIT}};',
					],
					'condition'          => [
						'crafto_floating_effects_show' => 'yes',
						'crafto_float_animation'       => 'rotate',
						'crafto_floating_effects_rotate_infinite' => 'yes',
					],
				]
			);

			$element->add_control(
				'crafto_floating_effects_rotate_delay',
				[
					'label'              => esc_html__( 'Delay', 'crafto-addons' ),
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
						'{{WRAPPER}}' => '--crafto-rotate-delay: {{SIZE}}{{UNIT}};',
					],
					'condition'          => [
						'crafto_floating_effects_show' => 'yes',
						'crafto_float_animation'       => 'rotate',
						'crafto_floating_effects_rotate_infinite' => 'yes',
					],
				]
			);
			$element->end_controls_section();
		}

		/**
		 * Width Expand Animation Content Fields.
		 *
		 * @since 1.0
		 * @param object $element Fields data.
		 * @access public
		 */
		public static function add_width_expand_animation_controls( $element ) {
			$element->start_controls_section(
				'crafto_width_expand_tab_style',
				[
					'label' => esc_html__( 'Width Expand Animation', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				]
			);
			$element->add_control(
				'crafto_expand_animation_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$element->start_controls_tabs( 'crafto_expand_animation_tabs' );
			$element->start_controls_tab(
				'crafto_animate_from',
				[
					'label'     => esc_html__( 'Animate From', 'crafto-addons' ),
					'condition' => [
						'crafto_expand_animation_settings' => 'yes',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_bottomtop_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => '',
					],
					'condition'  => [
						'crafto_expand_animation_settings' => 'yes',
					],
				]
			);
			$element->end_controls_tab();
			$element->start_controls_tab(
				'crafto_animate_to',
				[
					'label'     => esc_html__( 'Animate To', 'crafto-addons' ),
					'condition' => [
						'crafto_expand_animation_settings' => 'yes',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_center_top_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => '',
					],
					'condition'  => [
						'crafto_expand_animation_settings' => 'yes',
					],
				]
			);
			$element->end_controls_tab();
			$element->end_controls_tabs();
			$element->end_controls_section();
		}

		/**
		 *  Return Custom Animation.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public static function render_custom_animation( $element ) {
			/* START Scrolling Animation */
			$crafto_scrolling_up_values_opacity   = [];
			$crafto_scrolling_up_values_blur      = [];
			$crafto_scrolling_down_values_blur    = [];
			$crafto_scrolling_down_values_opacity = [];
			$crafto_scrolling_up_values           = [];
			$crafto_scrolling_down_values         = [];

			$crafto_enable_scroll_anim = $element->get_settings( 'crafto_animation_settings' );

			// Bottom Top values.
			$crafto_scrolling_up_translate_x     = $element->get_settings( 'crafto_scrolling_up_translate_x' );
			$crafto_scrolling_up_translate_x_val = ( ! empty( $crafto_scrolling_up_translate_x['size'] ) && isset( $crafto_scrolling_up_translate_x['size'] ) ) ? $crafto_scrolling_up_translate_x['size'] : 0;

			$crafto_scrolling_up_translate_y     = $element->get_settings( 'crafto_scrolling_up_translate_y' );
			$crafto_scrolling_up_translate_y_val = ( ! empty( $crafto_scrolling_up_translate_y['size'] ) && isset( $crafto_scrolling_up_translate_y['size'] ) ) ? $crafto_scrolling_up_translate_y['size'] : 0;

			$crafto_scrolling_up_translate_z     = $element->get_settings( 'crafto_scrolling_up_translate_z' );
			$crafto_scrolling_up_translate_z_val = ( ! empty( $crafto_scrolling_up_translate_z['size'] ) && isset( $crafto_scrolling_up_translate_z['size'] ) ) ? $crafto_scrolling_up_translate_z['size'] : 0;

			$crafto_scrolling_up_rotation     = $element->get_settings( 'crafto_scrolling_up_rotation' );
			$crafto_scrolling_up_rotation_val = ( ! empty( $crafto_scrolling_up_rotation['size'] ) && isset( $crafto_scrolling_up_rotation['size'] ) ) ? $crafto_scrolling_up_rotation['size'] : 0;

			$crafto_scrolling_up_filter_opacity     = $element->get_settings( 'crafto_scrolling_up_filter_opacity' );
			$crafto_scrolling_up_filter_opacity_val = ( ! empty( $crafto_scrolling_up_filter_opacity['size'] ) && isset( $crafto_scrolling_up_filter_opacity['size'] ) ) ? $crafto_scrolling_up_filter_opacity['size'] : '';

			$crafto_scrolling_up_filter_blur     = $element->get_settings( 'crafto_scrolling_up_filter_blur' );
			$crafto_scrolling_up_filter_blur_val = ( ! empty( $crafto_scrolling_up_filter_blur['size'] ) && isset( $crafto_scrolling_up_filter_blur['size'] ) ) ? $crafto_scrolling_up_filter_blur['size'] : '';

			$crafto_scrolling_up_scale_x     = $element->get_settings( 'crafto_scrolling_up_scale_x' );
			$crafto_scrolling_up_scale_x_val = ( ! empty( $crafto_scrolling_up_scale_x['size'] ) && isset( $crafto_scrolling_up_scale_x['size'] ) ) ? $crafto_scrolling_up_scale_x['size'] : '';

			$crafto_scrolling_up_translate3d_tx     = $element->get_settings( 'crafto_scrolling_up_translate3d_tx' );
			$crafto_scrolling_up_translate3d_tx_val = ( ! empty( $crafto_scrolling_up_translate3d_tx['size'] ) && isset( $crafto_scrolling_up_translate3d_tx['size'] ) ) ? $crafto_scrolling_up_translate3d_tx['size'] : 0;

			$crafto_scrolling_up_translate3d_ty     = $element->get_settings( 'crafto_scrolling_up_translate3d_ty' );
			$crafto_scrolling_up_translate3d_ty_val = ( ! empty( $crafto_scrolling_up_translate3d_ty['size'] ) && isset( $crafto_scrolling_up_translate3d_ty['size'] ) ) ? $crafto_scrolling_up_translate3d_ty['size'] : 0;

			$crafto_scrolling_up_translate3d_tz     = $element->get_settings( 'crafto_scrolling_up_translate3d_tz' );
			$crafto_scrolling_up_translate3d_tz_val = ( ! empty( $crafto_scrolling_up_translate3d_tz['size'] ) && isset( $crafto_scrolling_up_translate3d_tz['size'] ) ) ? $crafto_scrolling_up_translate3d_tz['size'] : 0;

			// Top Bottom values.
			$crafto_scrolling_down_translate_x     = $element->get_settings( 'crafto_scrolling_down_translate_x' );
			$crafto_scrolling_down_translate_x_val = ( ! empty( $crafto_scrolling_down_translate_x['size'] ) && isset( $crafto_scrolling_down_translate_x['size'] ) ) ? $crafto_scrolling_down_translate_x['size'] : 0;

			$crafto_scrolling_down_translate_y     = $element->get_settings( 'crafto_scrolling_down_translate_y' );
			$crafto_scrolling_down_translate_y_val = ( ! empty( $crafto_scrolling_down_translate_y['size'] ) && isset( $crafto_scrolling_down_translate_y['size'] ) ) ? $crafto_scrolling_down_translate_y['size'] : 0;

			$crafto_scrolling_down_translate_z     = $element->get_settings( 'crafto_scrolling_down_translate_z' );
			$crafto_scrolling_down_translate_z_val = ( ! empty( $crafto_scrolling_down_translate_z['size'] ) && isset( $crafto_scrolling_down_translate_z['size'] ) ) ? $crafto_scrolling_down_translate_z['size'] : 0;

			$crafto_scrolling_down_rotation     = $element->get_settings( 'crafto_scrolling_down_rotation' );
			$crafto_scrolling_down_rotation_val = ( ! empty( $crafto_scrolling_down_rotation['size'] ) && isset( $crafto_scrolling_down_rotation['size'] ) ) ? $crafto_scrolling_down_rotation['size'] : 0;

			$crafto_scrolling_down_filter_opacity     = $element->get_settings( 'crafto_scrolling_down_filter_opacity' );
			$crafto_scrolling_down_filter_opacity_val = ( ! empty( $crafto_scrolling_down_filter_opacity['size'] ) && isset( $crafto_scrolling_down_filter_opacity['size'] ) ) ? $crafto_scrolling_down_filter_opacity['size'] : '';

			$crafto_scrolling_down_filter_blur     = $element->get_settings( 'crafto_scrolling_down_filter_blur' );
			$crafto_scrolling_down_filter_blur_val = ( ! empty( $crafto_scrolling_down_filter_blur['size'] ) && isset( $crafto_scrolling_down_filter_blur['size'] ) ) ? $crafto_scrolling_down_filter_blur['size'] : '';

			$crafto_scrolling_down_scale_x     = $element->get_settings( 'crafto_scrolling_down_scale_x' );
			$crafto_scrolling_down_scale_x_val = ( ! empty( $crafto_scrolling_down_scale_x['size'] ) && isset( $crafto_scrolling_down_scale_x['size'] ) ) ? $crafto_scrolling_down_scale_x['size'] : '';

			$crafto_scrolling_down_translate3d_tx     = $element->get_settings( 'crafto_scrolling_down_translate3d_tx' );
			$crafto_scrolling_down_translate3d_tx_val = ( ! empty( $crafto_scrolling_down_translate3d_tx['size'] ) && isset( $crafto_scrolling_down_translate3d_tx['size'] ) ) ? $crafto_scrolling_down_translate3d_tx['size'] : 0;

			$crafto_scrolling_down_translate3d_ty     = $element->get_settings( 'crafto_scrolling_down_translate3d_ty' );
			$crafto_scrolling_down_translate3d_ty_val = ( ! empty( $crafto_scrolling_down_translate3d_ty['size'] ) && isset( $crafto_scrolling_down_translate3d_ty['size'] ) ) ? $crafto_scrolling_down_translate3d_ty['size'] : 0;

			$crafto_scrolling_down_translate3d_tz     = $element->get_settings( 'crafto_scrolling_down_translate3d_tz' );
			$crafto_scrolling_down_translate3d_tz_val = ( ! empty( $crafto_scrolling_down_translate3d_tz['size'] ) && isset( $crafto_scrolling_down_translate3d_tz['size'] ) ) ? $crafto_scrolling_down_translate3d_tz['size'] : 0;

			if ( 'yes' === $crafto_enable_scroll_anim ) {

				if ( $crafto_scrolling_up_translate_x_val !== $crafto_scrolling_down_translate_x_val ) {
					$crafto_scrolling_up_values['x']   = 'translateX(' . $crafto_scrolling_up_translate_x_val . $crafto_scrolling_up_translate_x['unit'] . ')';
					$crafto_scrolling_down_values['x'] = 'translateX(' . $crafto_scrolling_down_translate_x_val . $crafto_scrolling_down_translate_x['unit'] . ')';
				}

				if ( $crafto_scrolling_up_translate_y_val !== $crafto_scrolling_down_translate_y_val ) {
					$crafto_scrolling_up_values['y']   = 'translateY(' . $crafto_scrolling_up_translate_y_val . $crafto_scrolling_up_translate_y['unit'] . ')';
					$crafto_scrolling_down_values['y'] = 'translateY(' . $crafto_scrolling_down_translate_y_val . $crafto_scrolling_down_translate_y['unit'] . ')';
				}

				if ( $crafto_scrolling_up_translate_z_val !== $crafto_scrolling_down_translate_z_val ) {
					$crafto_scrolling_up_values['z']   = 'translateZ(' . $crafto_scrolling_up_translate_z_val . $crafto_scrolling_up_translate_z['unit'] . ')';
					$crafto_scrolling_down_values['z'] = 'translateZ(' . $crafto_scrolling_down_translate_z_val . $crafto_scrolling_down_translate_z['unit'] . ')';
				}

				if ( $crafto_scrolling_up_rotation_val !== $crafto_scrolling_down_rotation_val ) {
					$crafto_scrolling_up_values['rotate']   = 'rotate(' . (int) $crafto_scrolling_up_rotation_val . $crafto_scrolling_up_rotation['unit'] . ')';
					$crafto_scrolling_down_values['rotate'] = 'rotate(' . (int) $crafto_scrolling_down_rotation_val . $crafto_scrolling_up_rotation['unit'] . ')';
				}

				if ( ! empty( $crafto_scrolling_up_scale_x_val ) || ! empty( $crafto_scrolling_down_scale_x_val ) ) {
					$crafto_scrolling_up_values['scale']   = 'scale(' . (float) $crafto_scrolling_up_scale_x_val . ')';
					$crafto_scrolling_down_values['scale'] = 'scale(' . (float) $crafto_scrolling_down_scale_x_val . ')';
				}
				if ( $crafto_scrolling_up_translate3d_tx_val !== $crafto_scrolling_down_translate3d_tx_val || $crafto_scrolling_up_translate3d_ty_val !== $crafto_scrolling_down_translate3d_ty_val || $crafto_scrolling_up_translate3d_tz_val !== $crafto_scrolling_down_translate3d_tz_val ) {

					$crafto_scrolling_up_values['3d']   = 'translate3d(' . $crafto_scrolling_up_translate3d_tx_val . $crafto_scrolling_up_translate3d_tx['unit'] . ',' . $crafto_scrolling_up_translate3d_ty_val . $crafto_scrolling_up_translate3d_ty['unit'] . ',' . $crafto_scrolling_up_translate3d_tz_val . $crafto_scrolling_up_translate3d_tz['unit'] . ')';
					$crafto_scrolling_down_values['3d'] = 'translate3d(' . $crafto_scrolling_down_translate3d_tx_val . $crafto_scrolling_down_translate3d_tx['unit'] . ',' . $crafto_scrolling_down_translate3d_ty_val . $crafto_scrolling_down_translate3d_ty['unit'] . ',' . $crafto_scrolling_down_translate3d_tz_val . $crafto_scrolling_down_translate3d_tz['unit'] . ')';
				}

				if ( $crafto_scrolling_up_filter_opacity_val !== $crafto_scrolling_down_filter_opacity_val ) {
					$crafto_scrolling_up_values_opacity['opacity']   = 'opacity(' . (float) $crafto_scrolling_up_filter_opacity_val . ');';
					$crafto_scrolling_down_values_opacity['opacity'] = 'opacity(' . (float) $crafto_scrolling_down_filter_opacity_val . ');';
				}

				if ( $crafto_scrolling_up_filter_blur_val !== $crafto_scrolling_down_filter_blur_val ) {
					$crafto_scrolling_up_values_blur['blur']   = 'blur(' . (float) $crafto_scrolling_up_filter_blur_val . $crafto_scrolling_up_filter_blur['unit'] . ');';
					$crafto_scrolling_down_values_blur['blur'] = 'blur(' . (float) $crafto_scrolling_down_filter_blur_val . $crafto_scrolling_down_filter_blur['unit'] . ');';
				}
			}

			$crafto_scrolling_up   = ! empty( $crafto_scrolling_up_values ) ? $crafto_scrolling_up_values : [];
			$crafto_scrolling_down = ! empty( $crafto_scrolling_down_values ) ? $crafto_scrolling_down_values : [];

			/* Start Scrolling Up Animation */
			if ( ! empty( $crafto_scrolling_up_values_opacity ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'data-bottom-top' => ( $crafto_scrolling_up_values_opacity ? 'filter: ' . implode( ' ', $crafto_scrolling_up_values_opacity ) : '' ),
						],
					]
				);
			}
			if ( ! empty( $crafto_scrolling_up_values_blur ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'data-bottom-top' => ( $crafto_scrolling_up_values_blur ? 'filter: ' . implode( ' ', $crafto_scrolling_up_values_blur ) : '' ),
						],
					]
				);
			}
			if ( ! empty( $crafto_scrolling_up ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'data-bottom-top' => ( $crafto_scrolling_up ? 'transform: ' . implode( ' ', $crafto_scrolling_up ) : '' ),
						],
					]
				);
			}
			/* End Scrolling Up Animation */

			/* Start Scrolling Down Animation */
			if ( ! empty( $crafto_scrolling_down_values_opacity ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'data-top-bottom' => ( $crafto_scrolling_down_values_opacity ? 'filter: ' . implode( ' ', $crafto_scrolling_down_values_opacity ) : '' ),
						],
					]
				);
			}
			if ( ! empty( $crafto_scrolling_down_values_blur ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'data-top-bottom' => ( $crafto_scrolling_down_values_blur ? 'filter: ' . implode( ' ', $crafto_scrolling_down_values_blur ) : '' ),
						],
					]
				);
			}
			if ( ! empty( $crafto_scrolling_down ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'data-top-bottom' => ( $crafto_scrolling_down ? 'transform: ' . implode( ' ', $crafto_scrolling_down ) : '' ),
						],
					]
				);
			}
			/* End Scrolling Down Animation */

			/* START Anime Animation */

			$crafto_ent_values          = [];
			$enable_animation           = $element->get_settings( 'crafto_ent_settings' );
			$ent_settings_duration      = ( isset( $element->get_settings( 'crafto_ent_anim_opt_duration' )['size'] ) ) ? $element->get_settings( 'crafto_ent_anim_opt_duration' )['size'] : '';
			$ent_settings_start_delay   = ( isset( $element->get_settings( 'crafto_ent_anim_opt_start_delay' )['size'] ) ) ? $element->get_settings( 'crafto_ent_anim_opt_start_delay' )['size'] : '';
			$ent_settings_stagger       = ( isset( $element->get_settings( 'crafto_ent_anim_opt_stagger' )['size'] ) ) ? $element->get_settings( 'crafto_ent_anim_opt_stagger' )['size'] : '';
			$ent_settings_easing        = $element->get_settings( 'crafto_ent_anim_opt_ease' );
			$ent_settings_elements      = $element->get_settings( 'crafto_ent_anim_item_by_item' );
			$ent_settings_opacity_x     = $element->get_settings( 'crafto_ent_anim_opt_x_opacity' );
			$ent_settings_opacity_y     = $element->get_settings( 'crafto_ent_anim_opt_y_opacity' );
			$ent_settings_zoom_x        = $element->get_settings( 'crafto_ent_anim_opt_x_zoom' );
			$ent_settings_zoom_y        = $element->get_settings( 'crafto_ent_anim_opt_y_zoom' );
			$ent_settings_perspective_x = $element->get_settings( 'crafto_ent_anim_opt_perspective_x' );
			$ent_settings_perspective_y = $element->get_settings( 'crafto_ent_anim_opt_perspective_y' );
			$ent_settings_rotatex_x     = $element->get_settings( 'crafto_ent_anim_opt_rotation_xx' );
			$ent_settings_rotatex_y     = $element->get_settings( 'crafto_ent_anim_opt_rotation_xy' );
			$ent_settings_rotatey_x     = $element->get_settings( 'crafto_ent_anim_opt_rotation_yx' );
			$ent_settings_rotatey_y     = $element->get_settings( 'crafto_ent_anim_opt_rotation_yy' );
			$ent_settings_rotatez_x     = $element->get_settings( 'crafto_ent_anim_opt_rotation_zx' );
			$ent_settings_rotatez_y     = $element->get_settings( 'crafto_ent_anim_opt_rotation_zy' );
			$ent_settings_transalte_x   = $element->get_settings( 'crafto_ent_anim_opt_translate_x' );
			$ent_settings_transalte_y   = $element->get_settings( 'crafto_ent_anim_opt_translate_y' );
			$ent_settings_transalte_xx  = $element->get_settings( 'crafto_ent_anim_opt_translate_xx' );
			$ent_settings_transalte_xy  = $element->get_settings( 'crafto_ent_anim_opt_translate_xy' );
			$ent_settings_transalte_yx  = $element->get_settings( 'crafto_ent_anim_opt_translate_yx' );
			$ent_settings_transalte_yy  = $element->get_settings( 'crafto_ent_anim_opt_translate_yy' );
			$ent_settings_transalte_zx  = $element->get_settings( 'crafto_ent_anim_opt_translate_zx' );
			$ent_settings_transalte_zy  = $element->get_settings( 'crafto_ent_anim_opt_translate_zy' );
			$ent_settings_scale_x       = $element->get_settings( 'crafto_ent_anim_opt_scale_x' );
			$ent_settings_scale_y       = $element->get_settings( 'crafto_ent_anim_opt_scale_y' );
			$ent_settings_scale_y_start = $element->get_settings( 'crafto_ent_anim_opt_scale_y_start' );
			$ent_settings_scale_y_end   = $element->get_settings( 'crafto_ent_anim_opt_scale_y_end' );
			$ent_settings_clippath_x    = $element->get_settings( 'crafto_ent_anim_opt_clippath_x' );
			$ent_settings_clippath_y    = $element->get_settings( 'crafto_ent_anim_opt_clippath_y' );

			if ( 'yes' === $enable_animation ) {

				if ( ! empty( $ent_settings_duration ) ) {
					$crafto_ent_values['duration'] = (float) ( $ent_settings_duration );
				}

				if ( ! empty( $ent_settings_start_delay ) ) {
					$crafto_ent_values['delay'] = (float) ( $ent_settings_start_delay );
				}

				if ( ! empty( $ent_settings_stagger ) ) {
					$crafto_ent_values['staggervalue'] = (float) ( $ent_settings_stagger );
				}

				if ( 'none' !== $ent_settings_easing ) {
					$crafto_ent_values['easing'] = $ent_settings_easing;
				}

				// Widget Advance Tab Target.
				$target_id = '.elementor-element-' . $element->get_id() . '.entrance-animation';
				if ( 'yes' === $ent_settings_elements ) {
					if ( 'crafto-accordion' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .elementor-accordion > .elementor-accordion-item';
					} elseif ( 'crafto-process-step' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .process-step-box > .process-step-item';
					} elseif ( 'crafto-icon-box' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .crafto-icon-box-wrapper';
					} elseif ( 'crafto-media-gallery' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > ul > li > a > .portfolio-box, ' . $target_id . ' > .elementor-widget-container > ul > li > .portfolio-box';
					} elseif ( 'crafto-lists' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > ul > li';
					} elseif ( 'crafto-sliding-box' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .sliding-box > .sliding-box-main';
					} elseif ( 'crafto-blog-list' === $element->get_name() || 'crafto-archive-blog' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > ul > .grid-item > .blog-post';
					} elseif ( 'crafto-video-button' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .video-button-wrap';
					} elseif ( 'crafto-tabs' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .crafto-tabs > ul > li, ' . $target_id . ' > .elementor-widget-container > .crafto-tabs > .crafto-container-wrap > ul > li';
					} elseif ( 'crafto-timeline' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .timeline-box > .timeline-item';
					} elseif ( 'crafto-property' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .property-wrapper > ul > li > .property-details-content-wrap';
					} elseif ( 'crafto-portfolio' === $element->get_name() || 'crafto-archive-portfolio' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .filter-content > ul > li > .portfolio-box-wrap, ' . $target_id . ' > .elementor-widget-container > .filter-content > .portfolio-justified-gallery > .grid-item > .anime-wrap';
					} elseif ( 'crafto-tours' === $element->get_name() || 'crafto-archive-tours' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .tours-packages-wrapper > ul > li > .tours-box-content-wrap';
					} elseif ( 'crafto-social-icons' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .social-icons-wrapper > ul > li';
					} elseif ( 'crafto-product-taxonomy' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > ul > li > .categories-box';
					} elseif ( 'crafto-post-taxonomy' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .post-taxonomy-list > ul > li';
					} elseif ( 'crafto-product-list' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > ul > li > .shop-box';
					} elseif ( 'crafto-image-gallery' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > ul > li > .gallery-box';
					} elseif ( 'crafto-text-rotator' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . ' > .elementor-widget-container > .crafto-text-rotator > .text-rotate-title, ' . $target_id . ' > .elementor-widget-container > .crafto-text-rotator > .text-rotator';
					} elseif ( 'crafto-content-slider' === $element->get_name() ) {
						$crafto_ent_values['targets'] = $target_id . '.el-content-carousel-style-7 > .elementor-widget-container > .content-carousel-content-box > .carousel-content > .content-box > .heading, ' . $target_id . '.el-content-carousel-style-7 > .elementor-widget-container > .content-carousel-content-box > .carousel-content > .content-box > .content, ' . $target_id . '.el-content-carousel-style-7 > .elementor-widget-container > .content-carousel-content-box > .carousel-content > .content-box > .crafto-button-wrapper';
					}
				}

				// Container Advance Tab Item By Item Target.
				if ( 'yes' === $ent_settings_elements && $element->get_name() === 'container' ) {
					switch ( $element->get_name() ) {
						case 'container':
							$crafto_ent_values['targets'] = $target_id . '> .e-child,' . $target_id . '> .e-con-inner > .e-con-full.e-child,' . $target_id . '> .elementor-widget,' . $target_id . '> .e-con-inner > .elementor-widget';
							break;
					}
				}

				if ( ! empty( $ent_settings_opacity_x ) && ! empty( $ent_settings_opacity_y ) && $ent_settings_opacity_x !== $ent_settings_opacity_y ) {
					$crafto_ent_values['opacity'] = [ (float) $ent_settings_opacity_x['size'], (float) $ent_settings_opacity_y['size'] ];
				}

				if ( ! empty( $ent_settings_zoom_x ) && ! empty( $ent_settings_zoom_y ) && $ent_settings_zoom_x !== $ent_settings_zoom_y ) {
					$crafto_ent_values['zoom'] = [ (float) $ent_settings_zoom_x['size'], (float) $ent_settings_zoom_y['size'] ];
				}

				if ( ! empty( $ent_settings_perspective_x['size'] ) && ! empty( $ent_settings_perspective_y['size'] ) && ( 0 !== $ent_settings_perspective_x['size'] ) && ( 0 !== $ent_settings_perspective_y['size'] ) ) {
					$crafto_ent_values['perspective'] = [ (int) $ent_settings_perspective_x['size'], (int) $ent_settings_perspective_y['size'] ];
				}

				if ( ! empty( $ent_settings_rotatex_x ) && ! empty( $ent_settings_rotatex_y ) && $ent_settings_rotatex_x !== $ent_settings_rotatex_y ) {
					$crafto_ent_values['rotateX'] = [ (int) $ent_settings_rotatex_x['size'], (int) $ent_settings_rotatex_y['size'] ];
				}

				if ( ! empty( $ent_settings_rotatey_x ) && ! empty( $ent_settings_rotatey_y ) && $ent_settings_rotatey_x !== $ent_settings_rotatey_y ) {
					$crafto_ent_values['rotateY'] = [ (int) $ent_settings_rotatey_x['size'], (int) $ent_settings_rotatey_y['size'] ];
				}

				if ( ! empty( $ent_settings_rotatez_x ) && ! empty( $ent_settings_rotatez_y ) && $ent_settings_rotatez_x !== $ent_settings_rotatez_y ) {
					$crafto_ent_values['rotateZ'] = [ (int) $ent_settings_rotatez_x['size'], (int) $ent_settings_rotatez_y['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_x ) && ! empty( $ent_settings_transalte_y ) && $ent_settings_transalte_x !== $ent_settings_transalte_y ) {
					$crafto_ent_values['translate'] = [ (float) $ent_settings_transalte_x['size'], (float) $ent_settings_transalte_y['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_xx ) && ! empty( $ent_settings_transalte_xy ) && $ent_settings_transalte_xx !== $ent_settings_transalte_xy ) {
					$crafto_ent_values['translateX'] = [ (float) $ent_settings_transalte_xx['size'], (float) $ent_settings_transalte_xy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_yx ) && ! empty( $ent_settings_transalte_yy ) && $ent_settings_transalte_yx !== $ent_settings_transalte_yy ) {
					$crafto_ent_values['translateY'] = [ (float) $ent_settings_transalte_yx['size'], (float) $ent_settings_transalte_yy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_zx ) && ! empty( $ent_settings_transalte_zy ) && $ent_settings_transalte_zx !== $ent_settings_transalte_zy ) {
					$crafto_ent_values['translateZ'] = [ (float) $ent_settings_transalte_zx['size'], (float) $ent_settings_transalte_zy['size'] ];
				}

				if ( ! empty( $ent_settings_scale_x ) && ! empty( $ent_settings_scale_y ) && $ent_settings_scale_x !== $ent_settings_scale_y ) {
					$crafto_ent_values['scale'] = [ (float) $ent_settings_scale_x['size'], (float) $ent_settings_scale_y['size'] ];
				}

				if ( ! empty( $ent_settings_scale_y_start ) && ! empty( $ent_settings_scale_y_end ) && $ent_settings_scale_y_start !== $ent_settings_scale_y_end ) {
					$crafto_ent_values['scaleY'] = [ (float) $ent_settings_scale_y_start['size'], (float) $ent_settings_scale_y_end['size'] ];
				}

				if ( ! empty( $ent_settings_clippath_x ) && ! empty( $ent_settings_clippath_y ) && $ent_settings_clippath_x !== $ent_settings_clippath_y ) {
					$crafto_ent_values['clipPath'] = [ 'inset(' . (float) $ent_settings_clippath_x['top'] . 'px ' . (float) $ent_settings_clippath_x['right'] . 'px ' . (float) $ent_settings_clippath_x['bottom'] . 'px ' . (float) $ent_settings_clippath_x['left'] . 'px)', 'inset(' . (float) $ent_settings_clippath_y['top'] . 'px ' . (float) $ent_settings_clippath_y['right'] . 'px ' . (float) $ent_settings_clippath_y['bottom'] . 'px ' . (float) $ent_settings_clippath_y['left'] . 'px)' ];
				}
			}

			$crafto_anime_animation = ! empty( $crafto_ent_values ) ? $crafto_ent_values : [];
			if ( ! empty( $crafto_anime_animation ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'class'      => 'entrance-animation',
							'data-anime' => wp_json_encode( $crafto_anime_animation ),
						],
					]
				);
			}
			/* END Anime Animation */
		}

		/**
		 * Float Animation.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public static function crafto_render_float_custom_animation( $element ) {
			$crafto_float_animation = $element->get_settings( 'crafto_float_animation' );
			$enable_float_effect    = $element->get_settings( 'crafto_floating_effects_show' );

			if ( 'yes' === $enable_float_effect ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'class' => [
								'has-float',
								'animation-' . $crafto_float_animation,
							],
						],
					]
				);
			}
		}

		/**
		 * Width Expand Animation.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public static function crafto_render_expand_width_animation( $element ) {
			$crafto_custom_centertop_width    = '';
			$crafto_scrolling_up_values_width = '';
			$crafto_centertop_width           = $element->get_settings( 'crafto_center_top_width' );
			$crafto_bottomtop_width           = $element->get_settings( 'crafto_bottomtop_width' );

			if ( ! empty( $crafto_centertop_width ) && ! empty( $crafto_centertop_width['size'] ) ) {
				$crafto_custom_centertop_width = 'width: ' . $crafto_centertop_width['size'] . $crafto_centertop_width['unit'];
			}
			if ( ! empty( $crafto_bottomtop_width ) && ! empty( $crafto_bottomtop_width['size'] ) ) {
				$crafto_scrolling_up_values_width = 'width: ' . $crafto_bottomtop_width['size'] . $crafto_bottomtop_width['unit'];
			}

			/* Start Scrolling Center Animation */
			if ( ! empty( $crafto_scrolling_up_values_width ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'data-bottom-top' => $crafto_scrolling_up_values_width,
						],
					]
				);
			}

			if ( ! empty( $crafto_custom_centertop_width ) ) {
				$element->add_render_attribute(
					[
						'_wrapper' => [
							'class'           => [
								'mx-auto',
							],
							'data-center-top' => $crafto_custom_centertop_width,
						],
					]
				);
			}
			/* End Scrolling Center Animation */
		}
	}
}
