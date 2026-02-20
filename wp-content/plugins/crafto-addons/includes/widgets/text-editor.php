<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Box_Shadow;

/**
 *
 * Crafto widget for Text Editor.
 *
 * @package Crafto
 */

// If class `Text_Editor` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Text_Editor' ) ) {
	/**
	 * Define `Text_Editor` class.
	 */
	class Text_Editor extends Widget_Base {
		/**
		 * Retrieve the list of scripts the Text Editor widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$text_editor_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$text_editor_scripts[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
				if ( '0' === $crafto_disable_all_animation ) {
					if ( crafto_disable_module_by_key( 'appear' ) ) {
						$text_editor_scripts[] = 'appear';
					}

					if ( crafto_disable_module_by_key( 'anime' ) ) {
						$text_editor_scripts[] = 'anime';
						$text_editor_scripts[] = 'splitting';
						$text_editor_scripts[] = 'animation';
					}
				}
				$text_editor_scripts[] = 'crafto-text-editor';
			}
			return $text_editor_scripts;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-text-editor';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Text Editor', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-text crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/text-editor/';
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
				'text',
				'text editor',
				'editor',
				'content',
				'paragraph',
				'html',
				'wysiwyg',
				'rich text',
				'text block',
				'text content',
				'typography',
				'text widget',
				'description',
				'formatted text',
				'custom text',
				'elementor editor',
				'text section',
			];
		}

		/**
		 * Register Text Editor widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_text_editor_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_text_editor',
				[
					'label'      => esc_html__( 'Text', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => true,
					'default'    => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ) . '</p>',
				]
			);
			$this->add_control(
				'drop_cap',
				[
					'label'        => esc_html__( 'Enable Drop Cap', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_text_editor_entrance_animation',
				[
					'label' => esc_html__( 'Split Text Animation', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_content_ent_heading_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_ent_play',
				[
					'label'       => esc_html__( 'Play Animations', 'crafto-addons' ),
					'type'        => Controls_Manager::BUTTON,
					'button_type' => 'success',
					'text'        => esc_html__( 'Play', 'crafto-addons' ),
					'event'       => 'crafto_apply',
					'render_type' => 'none',
					'condition'   => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_settings_split_type',
				[
					'label'       => esc_html__( 'Splitting Type', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'lines',
					'render_type' => 'none',
					'options'     => [
						'lines' => esc_html__( 'Lines', 'crafto-addons' ),
						'words' => esc_html__( 'Words', 'crafto-addons' ),
						'chars' => esc_html__( 'Characters', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_heading_ease',
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
						'crafto_content_ent_heading_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'size' => 500,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_content_ent_heading_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_stagger',
				[
					'label'       => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_start_delay',
				[
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_heading_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_opt_translate',
				[
					'label'       => esc_html__( 'Translate', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_x',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translatex',
				[
					'label'       => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_xx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_xy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translatey',
				[
					'label'       => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_yx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_yy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translatez',
				[
					'label'       => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_zx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_translate_zy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_heading_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_opacity',
				[
					'label'       => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_x_opacity',
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
						'crafto_content_ent_heading_anim_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_y_opacity',
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
						'crafto_content_ent_heading_anim_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_heading_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_opt_rotatex',
				[
					'label'       => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_rotation_xx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_rotation_xy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_content_ent_heading_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotatey',
				[
					'label'       => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_rotation_yx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
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
						'crafto_content_ent_heading_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_rotation_yy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_content_ent_heading_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotatez',
				[
					'label'     => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_rotation_zx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_rotation_zy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_heading_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_perspective',
				[
					'label'       => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_perspective_x',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'before',
					'condition'  => [
						'crafto_content_ent_heading_anim_perspective_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_perspective_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
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
					'separator'   => 'before',
					'condition'  => [
						'crafto_content_ent_heading_anim_perspective_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_heading_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_heading_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_scale',
				[
					'label'       => esc_html__( 'Scale', 'crafto-addons' ),
					'type'        => Controls_Manager::HEADING,
					'separator'   => 'before',
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_scale_x',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
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
						'crafto_content_ent_heading_anim_scale_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_heading_anim_opt_scale_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
						'crafto_content_ent_heading_anim_scale_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_text_editor_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_text_editor_alignment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'left',
					'options'              => [
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
					'selectors' => [
						'{{WRAPPER}} .text-editor-content' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .text-editor-content',
				]
			);
			$this->add_control(
				'crafto_text_editor_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .text-editor-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_text_editors_content_style'
			);
			$this->start_controls_tab(
				'crafto_text_editor_content_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_text_editor_link_color',
				[
					'label'     => esc_html__( 'Link Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .text-editor-content a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_text_editors_content_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_text_editor_hover_link_color',
				[
					'label'     => esc_html__( 'Link Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .text-editor-content a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_text_editor_content_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => '',
						'unit' => 'px',
					],
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 500,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .text-editor-content' => 'width: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_text_editor_content_margin',
				[
					'label'     => esc_html__( 'Bottom Spacing', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => '',
						'unit' => 'px',
					],
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .text-editor-content p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_editor_box_padding',
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
						'{{WRAPPER}} .text-editor-content, {{WRAPPER}} .text-editor-content ol, {{WRAPPER}} .text-editor-content ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_editor_box_margin',
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
						'{{WRAPPER}} .text-editor-content, {{WRAPPER}} .text-editor-content ol, {{WRAPPER}} .text-editor-content ul' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_drop_cap',
				[
					'label'     => esc_html__( 'Drop Cap', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'drop_cap' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_drop_cap_typography',
					'selector' => '{{WRAPPER}} .elementor-drop-cap-letter',
					'exclude'  => [
						'letter_spacing',
					],
				]
			);

			$this->add_control(
				'crafto_drop_cap_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'default'      => 'default',
					'prefix_class' => 'elementor-drop-cap-view-',
				]
			);
			$this->add_control(
				'crafto_drop_cap_primary_color',
				[
					'label'     => esc_html__( 'Letter Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap, {{WRAPPER}}.elementor-drop-cap-view-default .elementor-drop-cap, {{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap-letter' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_drop_cap_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-drop-cap-view-stacked .elementor-drop-cap' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_drop_cap_view' => 'stacked',
					],
				]
			);

			$this->add_control(
				'crafto_drop_cap_letter_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_drop_cap_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_crafto_drop_cap_letter_shadow',
					'selector' => '{{WRAPPER}} .elementor-drop-cap',
				]
			);

			$this->add_responsive_control(
				'crafto_drop_cap_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-drop-cap-view-framed .elementor-drop-cap' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_drop_cap_view' => [
							'framed',
						],
					],
				]
			);
			$this->add_control(
				'crafto_drop_cap_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ '%', 'px', 'custom' ],
					'default'    => [
						'unit' => '%',
					],
					'range'      => [
						'%' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-drop-cap' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_drop_cap_view!' => 'default',
					],
				]
			);
			$this->add_control(
				'crafto_drop_cap_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 300,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-drop-cap' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_drop_cap_view!' => 'default',
					],
				]
			);

			$this->add_control(
				'crafto_drop_cap_space',
				[
					'label'     => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 10,
					],
					'range'     => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors' => [
						'body:not(.rtl) {{WRAPPER}} .elementor-drop-cap' => 'margin-right: {{SIZE}}{{UNIT}};',
						'body.rtl {{WRAPPER}} .elementor-drop-cap'       => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Render Text Editor widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings      = $this->get_settings_for_display();
			$content       = ( isset( $settings['crafto_text_editor'] ) && $settings['crafto_text_editor'] ) ? $settings['crafto_text_editor'] : '';
			$content_anime = $this->render_heading_anime_animation( $this, 'content' );

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'text-editor',
				]
			);

			if ( 'yes' === $settings['drop_cap'] ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					[
						'elementor-drop-cap-yes',
					]
				);
			}

			$this->add_render_attribute(
				'content_block_content',
				[
					'class' => 'text-editor-content',
				],
			);
			if ( ! empty( $content_anime ) && '[]' !== $content_anime ) {
				$this->add_render_attribute(
					'content_block_content',
					[
						'class'      => 'entrance-animation',
						'data-anime' => $content_anime,
					],
				);
			}
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'content_block_content' ); ?>>
					<?php echo sprintf( '%s', wp_kses_post( $content ) ); // phpcs:ignore ?>
				</div>
			</div>
			<?php
		}

		
		/**
		 * Render heading widget output in the editor.
		 *
		 * Written as a Backbone JavaScript template and used to generate the live preview.
		 *
		 * @since 2.9.0
		 * @access protected
		 */
		protected function content_template() {
			?>
			<# 
			const content = settings.crafto_text_editor || '';
			const ent_values = {};
			const crafto_animation_settings = settings.crafto_content_ent_heading_settings;
			const ent_heading_ease = settings.crafto_content_ent_heading_ease || '';
			const ent_settings_split_type = settings.crafto_content_ent_settings_split_type || '';
			const ent_heading_start_delay = settings.crafto_content_ent_heading_start_delay?.size || 0;
			const ent_heading_duration = settings.crafto_content_ent_heading_anim_opt_duration?.size || 0;
			const ent_heading_stagger = settings.crafto_content_ent_heading_anim_stagger?.size || 0;
			const ent_heading_opacity_x = settings.crafto_content_ent_heading_anim_opt_x_opacity?.size || 0;
			const ent_heading_opacity_y = settings.crafto_content_ent_heading_anim_opt_y_opacity?.size || 0;
			const ent_heading_perspective_x = settings.crafto_content_ent_heading_anim_opt_perspective_x?.size || 0;
			const ent_heading_perspective_y = settings.crafto_content_ent_heading_anim_opt_perspective_y?.size || 0;
			const ent_heading_rotatex_xx = settings.crafto_content_ent_heading_anim_opt_rotation_xx?.size || 0;
			const ent_heading_rotatex_xy = settings.crafto_content_ent_heading_anim_opt_rotation_xy?.size || 0;
			const ent_heading_rotatey_yx = settings.crafto_content_ent_heading_anim_opt_rotation_yx?.size || 0;
			const ent_heading_rotatey_yy = settings.crafto_content_ent_heading_anim_opt_rotation_yy?.size || 0;
			const ent_heading_rotatez_zx = settings.crafto_content_ent_heading_anim_opt_rotation_zx?.size || 0;
			const ent_heading_rotatez_zy = settings.crafto_content_ent_heading_anim_opt_rotation_zy?.size || 0;
			const ent_heading_translate_x = settings.crafto_content_ent_heading_anim_opt_translate_x?.size || 0;
			const ent_heading_translate_y = settings.crafto_content_ent_heading_anim_opt_translate_y?.size || 0;
			const ent_heading_translate_xx = settings.crafto_content_ent_heading_anim_opt_translate_xx?.size || 0;
			const ent_heading_translate_xy = settings.crafto_content_ent_heading_anim_opt_translate_xy?.size || 0;
			const ent_heading_translate_yx = settings.crafto_content_ent_heading_anim_opt_translate_yx?.size || 0;
			const ent_heading_translate_yy = settings.crafto_content_ent_heading_anim_opt_translate_yy?.size || 0;
			const ent_heading_translate_zx = settings.crafto_content_ent_heading_anim_opt_translate_zx?.size || 0;
			const ent_heading_translate_zy = settings.crafto_content_ent_heading_anim_opt_translate_zy?.size || 0;
			const ent_heading_scale_x = settings.crafto_content_ent_heading_anim_opt_scale_x?.size || 0;
			const ent_heading_scale_y = settings.crafto_content_ent_heading_anim_opt_scale_y?.size || 0;

			if ( 'yes' === crafto_animation_settings ) {
				ent_values['el'] = ent_settings_split_type;

				if ( ent_heading_ease !== 'none' ) {
					ent_values['easing'] = ent_heading_ease;
				}

				if ( ent_heading_start_delay ) {
					ent_values['delay'] = parseFloat(ent_heading_start_delay);
				}

				if ( ent_heading_duration ) {
					ent_values['duration'] = parseFloat(ent_heading_duration);
				}

				if ( ent_heading_stagger ) {
					ent_values['staggervalue'] = parseFloat(ent_heading_stagger);
				}

				if ( ent_heading_opacity_x && ent_heading_opacity_y || ent_heading_opacity_x !== ent_heading_opacity_y ) {
					ent_values['opacity'] = [parseFloat(ent_heading_opacity_x), parseFloat(ent_heading_opacity_y)];
				}

				if (ent_heading_perspective_x && ent_heading_perspective_y || ent_heading_perspective_x !== ent_heading_perspective_y) {
					ent_values['perspective'] = [parseFloat(ent_heading_perspective_x), parseFloat(ent_heading_perspective_y)];
				}

				if ( ent_heading_rotatex_xx && ent_heading_rotatex_xy || ent_heading_rotatex_xx !== ent_heading_rotatex_xy ) {
					ent_values['rotateX'] = [parseInt(ent_heading_rotatex_xx), parseInt(ent_heading_rotatex_xy)];
				}

				if ( ent_heading_rotatey_yx && ent_heading_rotatey_yy || ent_heading_rotatey_yx !== ent_heading_rotatey_yy ) {
					ent_values['rotateY'] = [parseInt(ent_heading_rotatey_yx), parseInt(ent_heading_rotatey_yy)];
				}

				if ( ent_heading_rotatez_zx && ent_heading_rotatez_zy || ent_heading_rotatez_zx !== ent_heading_rotatez_zy ) {
					ent_values['rotateZ'] = [parseInt(ent_heading_rotatez_zx), parseInt(ent_heading_rotatez_zy)];
				}

				if ( ent_heading_translate_x && ent_heading_translate_y || ent_heading_translate_x !== ent_heading_translate_y ) {
					ent_values['translate'] = [parseFloat(ent_heading_translate_x), parseFloat(ent_heading_translate_y)];
				}

				if ( ent_heading_translate_xx && ent_heading_translate_xy || ent_heading_translate_xx !== ent_heading_translate_xy ) {
					ent_values['translateX'] = [parseFloat(ent_heading_translate_xx), parseFloat(ent_heading_translate_xy)];
				}

				if ( ent_heading_translate_yx && ent_heading_translate_yy || ent_heading_translate_yx !== ent_heading_translate_yy ) {
					ent_values['translateY'] = [parseFloat(ent_heading_translate_yx), parseFloat(ent_heading_translate_yy)];
				}

				if ( ent_heading_translate_zx && ent_heading_translate_zy || ent_heading_translate_zx !== ent_heading_translate_zy ) {
					ent_values['translateZ'] = [parseFloat(ent_heading_translate_zx), parseFloat(ent_heading_translate_zy)];
				}

				if ( ent_heading_scale_x && ent_heading_scale_y || ent_heading_scale_x !== ent_heading_scale_y ) {
					ent_values['scale'] = [parseFloat(ent_heading_scale_x), parseFloat(ent_heading_scale_y)];
				}
			}

			const data_anime = ent_values;

			const mainWrap = {
				'class': 'text-editor',
			};
			const dropcapWrap = {
				'class': 'elementor-drop-cap-yes',
			};
			const contentWrap = {
				'class': 'text-editor-content',
			};
			const animeWrap = {
				'class': 'entrance-animation',
				'data-anime':  JSON.stringify( data_anime ),
			};

			view.addRenderAttribute( 'wrapper', mainWrap );
			if ( 'yes' === settings.drop_cap ) {
				view.addRenderAttribute( 'wrapper', dropcapWrap );
			}
			view.addRenderAttribute( 'content_block_content', contentWrap );

			if ( JSON.stringify(data_anime) !== '{}' ) {
				view.addRenderAttribute( 'content_block_content', animeWrap );
			}

			let content_html = '';

			content_html += '<div ' + view.getRenderAttributeString('wrapper') + '>';
			content_html += '<div ' + view.getRenderAttributeString('content_block_content') + '>';
			content_html += content;
			content_html += '</div>';
			content_html += '</div>';

			print( content_html );
			#>
			<?php
		}

		/**
		 * Render animation effect frontend
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public function render_heading_anime_animation( $element, $data_type = 'primary' ) {
			$prefix = 'crafto_' . $data_type . '_';
			// Data Anime Values.
			$crafto_animation_settings = $element->get_settings( $prefix . 'ent_heading_settings' );
			$ent_heading_ease          = $element->get_settings( $prefix . 'ent_heading_ease' );
			$ent_settings_split_type   = $element->get_settings( $prefix . 'ent_settings_split_type' );
			$ent_heading_start_delay   = isset( $element->get_settings( $prefix . 'ent_heading_start_delay' )['size'] ) ? $element->get_settings( $prefix . 'ent_heading_start_delay' )['size'] : '';
			$ent_heading_duration      = isset( $element->get_settings( $prefix . 'ent_heading_anim_opt_duration' )['size'] ) ? $element->get_settings( $prefix . 'ent_heading_anim_opt_duration' )['size'] : '';
			$ent_heading_stagger       = isset( $element->get_settings( $prefix . 'ent_heading_anim_stagger' )['size'] ) ? $element->get_settings( $prefix . 'ent_heading_anim_stagger' )['size'] : '';
			$ent_heading_opacity_x     = $element->get_settings( $prefix . 'ent_heading_anim_opt_x_opacity' );
			$ent_heading_opacity_y     = $element->get_settings( $prefix . 'ent_heading_anim_opt_y_opacity' );
			$ent_heading_perspective_x = $element->get_settings( $prefix . 'ent_heading_anim_opt_perspective_x' );
			$ent_heading_perspective_y = $element->get_settings( $prefix . 'ent_heading_anim_opt_perspective_y' );
			$ent_heading_rotatex_xx    = $element->get_settings( $prefix . 'ent_heading_anim_opt_rotation_xx' );
			$ent_heading_rotatex_xy    = $element->get_settings( $prefix . 'ent_heading_anim_opt_rotation_xy' );
			$ent_heading_rotatey_yx    = $element->get_settings( $prefix . 'ent_heading_anim_opt_rotation_yx' );
			$ent_heading_rotatey_yy    = $element->get_settings( $prefix . 'ent_heading_anim_opt_rotation_yy' );
			$ent_heading_rotatez_zx    = $element->get_settings( $prefix . 'ent_heading_anim_opt_rotation_zx' );
			$ent_heading_rotatez_zy    = $element->get_settings( $prefix . 'ent_heading_anim_opt_rotation_zy' );
			$ent_heading_transalte_x   = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_x' );
			$ent_heading_transalte_y   = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_y' );
			$ent_heading_transalte_xx  = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_xx' );
			$ent_heading_transalte_xy  = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_xy' );
			$ent_heading_transalte_yx  = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_yx' );
			$ent_heading_transalte_yy  = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_yy' );
			$ent_heading_transalte_zx  = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_zx' );
			$ent_heading_transalte_zy  = $element->get_settings( $prefix . 'ent_heading_anim_opt_translate_zy' );
			$ent_heading_scale_x       = $element->get_settings( $prefix . 'ent_heading_anim_opt_scale_x' );
			$ent_heading_scale_y       = $element->get_settings( $prefix . 'ent_heading_anim_opt_scale_y' );

			$ent_values = [];
			if ( 'yes' === $crafto_animation_settings ) {
				$ent_values['el'] = $ent_settings_split_type;

				if ( 'none' !== $ent_heading_ease ) {
					$ent_values['easing'] = $ent_heading_ease;
				}

				if ( ! empty( $ent_heading_start_delay ) ) {
					$ent_values['delay'] = (float) ( $ent_heading_start_delay );
				}

				if ( ! empty( $ent_heading_duration ) ) {
					$ent_values['duration'] = (float) ( $ent_heading_duration );
				}

				if ( ! empty( $ent_heading_stagger ) ) {
					$ent_values['staggervalue'] = (float) ( $ent_heading_stagger );
				}

				if ( ! empty( $ent_heading_opacity_x ) && ! empty( $ent_heading_opacity_y ) && $ent_heading_opacity_x !== $ent_heading_opacity_y ) {
					$ent_values['opacity'] = [ (float) $ent_heading_opacity_x['size'], (float) $ent_heading_opacity_y['size'] ];
				}

				if ( ! empty( $ent_heading_perspective_x ) && ! empty( $ent_heading_perspective_y ) && $ent_heading_perspective_x !== $ent_heading_perspective_y ) {
					$ent_values['perspective'] = [ (float) $ent_heading_perspective_x['size'], (float) $ent_heading_perspective_y['size'] ];
				}

				if ( ! empty( $ent_heading_rotatex_xx ) && ! empty( $ent_heading_rotatex_xy ) && $ent_heading_rotatex_xx !== $ent_heading_rotatex_xy ) {
					$ent_values['rotateX'] = [ (int) $ent_heading_rotatex_xx['size'], (int) $ent_heading_rotatex_xy['size'] ];
				}

				if ( ! empty( $ent_heading_rotatey_yx ) && ! empty( $ent_heading_rotatey_yy ) && $ent_heading_rotatey_yx !== $ent_heading_rotatey_yy ) {
					$ent_values['rotateY'] = [ (int) $ent_heading_rotatey_yx['size'], (int) $ent_heading_rotatey_yy['size'] ];
				}

				if ( ! empty( $ent_heading_rotatez_zx ) && ! empty( $ent_heading_rotatez_zy ) && $ent_heading_rotatez_zx !== $ent_heading_rotatez_zy ) {
					$ent_values['rotateZ'] = [ (int) $ent_heading_rotatez_zx['size'], (int) $ent_heading_rotatez_zy['size'] ];
				}

				if ( ! empty( $ent_heading_transalte_x ) && ! empty( $ent_heading_transalte_y ) && $ent_heading_transalte_x !== $ent_heading_transalte_y ) {
					$ent_values['translate'] = [ (float) $ent_heading_transalte_x['size'], (float) $ent_heading_transalte_y['size'] ];
				}

				if ( ! empty( $ent_heading_transalte_xx ) && ! empty( $ent_heading_transalte_xy ) && $ent_heading_transalte_xx !== $ent_heading_transalte_xy ) {
					$ent_values['translateX'] = [ (float) $ent_heading_transalte_xx['size'], (float) $ent_heading_transalte_xy['size'] ];
				}

				if ( ! empty( $ent_heading_transalte_yx ) && ! empty( $ent_heading_transalte_yy ) && $ent_heading_transalte_yx !== $ent_heading_transalte_yy ) {
					$ent_values['translateY'] = [ (float) $ent_heading_transalte_yx['size'], (float) $ent_heading_transalte_yy['size'] ];
				}

				if ( ! empty( $ent_heading_transalte_zx ) && ! empty( $ent_heading_transalte_zy ) && $ent_heading_transalte_zx !== $ent_heading_transalte_zy ) {
					$ent_values['translateZ'] = [ (float) $ent_heading_transalte_zx['size'], (float) $ent_heading_transalte_zy['size'] ];
				}

				if ( ! empty( $ent_heading_scale_x ) && ! empty( $ent_heading_scale_y ) && $ent_heading_scale_x !== $ent_heading_scale_y ) {
					$ent_values['scale'] = [ (float) $ent_heading_scale_x['size'], (float) $ent_heading_scale_y['size'] ];
				}
			}

			$data_anime = ! empty( $ent_values ) ? $ent_values : [];
			return wp_json_encode( $data_anime );
		}
	}
}
