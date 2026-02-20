<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 *
 * Crafto widget for particle effect.
 *
 * @package Crafto
 */

// If class `Particle_Effect` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Particle_Effect' ) ) {
	/**
	 * Define `Particle_Effect` class.
	 */
	class Particle_Effect extends Widget_Base {
		/**
		 * Retrieve the list of scripts the particle effect widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$particles_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$particles_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'particles' ) ) {
					$particles_scripts[] = 'crafto-particle-effect-widget';
				}
			}
			return $particles_scripts;
		}

		/**
		 * Retrieve the list of styles the particle effect widget depended on.
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
				return [ 'crafto-particle-effect-widget' ];
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
			return 'crafto-particle-effect';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Particle Effect', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-page-transition crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/particle-effect/';
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
				'visuals',
				'animation',
				'motion background',
				'canvas effect',
				'background animation',
			];
		}
		/**
		 * Register particle effect widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'general_section',
				array(
					'label' => esc_html__( 'Particles', 'crafto-addons' ),
				)
			);
			$this->add_control(
				'crafto_as_bg',
				[
					'label'        => esc_html__( 'Use As Background?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_control(
				'crafto_visible_on_hover',
				[
					'label'        => esc_html__( 'Visible When Hovering Parent Column?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_height',
				[
					'label'       => esc_html__( 'Height', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'render_type' => 'template',
					'size_units'  => [
						'px',
						'vh',
						'custom',
					],
					'range'       => [
						'px' => [
							'min' => 100,
							'max' => 3000,
						],
						'vh' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'     => [
						'unit' => 'px',
						'size' => 500,
					],
					'selectors'   => [
						'{{WRAPPER}} .particle-wrapper' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_Particles_section',
				array(
					'label' => esc_html__( 'Particles Options', 'crafto-addons' ),
				)
			);
			$this->add_control(
				'crafto_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Number Of The Particles', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_enable_density',
				[
					'label'        => esc_html__( 'Enable Density?', 'crafto-addons' ),
					'description'  => esc_html__( 'Will Enable Density Factor', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_density',
				[
					'label'       => esc_html__( 'Density', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'Density Of The Particles', 'crafto-addons' ),
					'condition'   => array(
						'crafto_enable_density' => 'yes',
					),
				]
			);
			$this->add_control(
				'crafto_color_type',
				[
					'label'   => esc_html__( 'Color Variations', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'single_color',
					'options' => [
						'single_color' => esc_html__( 'Single Color', 'crafto-addons' ),
						'multi_color'  => esc_html__( 'Multi Color', 'crafto-addons' ),
						'random_color' => esc_html__( 'Random Color', 'crafto-addons' ),
					],
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_scolor',
				[
					'label'   => esc_html__( 'Color', 'crafto-addons' ),
					'type'    => Controls_Manager::COLOR,
					'default' => '#232323',
				]
			);
			$this->add_control(
				'crafto_multi_color_values',
				[
					'label'       => esc_html__( 'Multi Colors', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'title_field' => '{{{ crafto_scolor }}}',
					'condition'   => [
						'crafto_color_type' => 'multi_color',
					],
				]
			);
			$this->add_control(
				'crafto_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#232323',
					'condition' => [
						'crafto_color_type' => 'single_color',
					],
				]
			);
			$this->add_control(
				'crafto_shape_type',
				[
					'label'       => esc_html__( 'Shape Type', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'multiple'    => true,
					'options'     => [
						'circle'   => esc_html__( 'Circle', 'crafto-addons' ),
						'edge'     => esc_html__( 'Edge', 'crafto-addons' ),
						'triangle' => esc_html__( 'Triangle', 'crafto-addons' ),
						'polygon'  => esc_html__( 'Polygon', 'crafto-addons' ),
						'star'     => esc_html__( 'Star', 'crafto-addons' ),
						'image'    => esc_html__( 'Image', 'crafto-addons' ),
					],
					'default'     => [
						'circle',
					],
					'separator'   => 'before',
				]
			);
			$this->add_control(
				'crafto_nb_sides',
				[
					'label'       => esc_html__( 'Polygon Number Sides', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Polygons Number Sides', 'crafto-addons' ),
					'condition'   => [
						'crafto_shape_type' => 'polygon',
					],
				]
			);
			$this->add_control(
				'crafto_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'condition' => [
						'crafto_shape_type' => 'image',
					],
				]
			);
			$this->add_control(
				'crafto_image_width',
				[
					'label'       => esc_html__( 'Image Width', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Image Width', 'crafto-addons' ),
					'condition'   => [
						'crafto_shape_type' => 'image',
					],
				]
			);
			$this->add_control(
				'crafto_image_height',
				[
					'label'       => esc_html__( 'Image Height', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Add Image Height', 'crafto-addons' ),
					'condition'   => [
						'crafto_shape_type' => 'image',
					],
				]
			);
			$this->add_control(
				'crafto_stroke_width',
				[
					'label'       => esc_html__( 'Stroke Width', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 2', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_stroke_color',
				[
					'label'     => esc_html__( 'Stroke Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#232323',
					'condition' => [
						'crafto_stroke_width!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_size',
				[
					'label'       => esc_html__( 'Size', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 20', 'crafto-addons' ),
					'separator'   => 'before',
				]
			);
			$this->add_control(
				'crafto_enable_random_size',
				[
					'label'        => esc_html__( 'Enable Random Size', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_enable_anim_size',
				[
					'label'        => esc_html__( 'Enable Animation Size', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_anim_size_speed',
				[
					'label'       => esc_html__( 'Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 80', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_anim_size' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_anim_size_min',
				[
					'label'      => esc_html__( 'Min Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 0.1,
					],
					'condition'  => [
						'crafto_enable_anim_size' => 'yes',
					],
				],
			);
			$this->add_control(
				'crafto_enable_anim_size_sync',
				[
					'label'        => esc_html__( 'Enable Animation Sync', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_enable_anim_size' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.05,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 0.5,
					],
					'separator'  => 'before',
				]
			);
			$this->add_control(
				'crafto_enable_random_opacity',
				[
					'label'        => esc_html__( 'Enable Random Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_enable_anim_opacity',
				[
					'label'        => esc_html__( 'Enable Animation Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_anim_opacity_speed',
				[
					'label'       => esc_html__( 'Animation Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 3', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_anim_opacity' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_anim_opacity_min',
				[
					'label'      => esc_html__( 'Min Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.05,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 0.1,
					],
					'condition'  => [
						'crafto_enable_anim_opacity' => 'yes',
					],
				],
			);
			$this->add_control(
				'crafto_enable_anim_sync',
				[
					'label'        => esc_html__( 'Enable Animation Sync', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_enable_anim_opacity' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_line_linked',
				[
					'label'        => esc_html__( 'Enable Linked Line', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'separator'    => 'before',

				]
			);
			$this->add_control(
				'crafto_line_distance',
				[
					'label'       => esc_html__( 'Distance', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 300', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_line_linked' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_line_color',
				[
					'label'     => esc_html__( 'Line Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#232323',
					'condition' => [
						'crafto_enable_line_linked' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_line_opacity',
				[
					'label'      => esc_html__( 'Min Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.05,
						],
					],
					'condition'  => [
						'crafto_enable_line_linked' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_line_width',
				[
					'label'       => esc_html__( 'Line Width', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 2', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_line_linked' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_move',
				[
					'label'        => esc_html__( 'Enable Move', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_move_speed',
				[
					'label'       => esc_html__( 'Move Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 12', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_move_direction',
				[
					'label'     => esc_html__( 'Move Direction', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none'         => esc_html__( 'None', 'crafto-addons' ),
						'top'          => esc_html__( 'Top', 'crafto-addons' ),
						'top-right'    => esc_html__( 'Top Right', 'crafto-addons' ),
						'right'        => esc_html__( 'Right', 'crafto-addons' ),
						'bottom-right' => esc_html__( 'Bottom Right', 'crafto-addons' ),
						'bottom'       => esc_html__( 'Bottom', 'crafto-addons' ),
						'bottom-left'  => esc_html__( 'Bottom Left', 'crafto-addons' ),
						'left'         => esc_html__( 'Left', 'crafto-addons' ),
						'top-left'     => esc_html__( 'Top Left', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_random_move',
				[
					'label'        => esc_html__( 'Enable Random Move', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_enable_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_straight_move',
				[
					'label'        => esc_html__( 'Enable Straight Move', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_enable_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_move_out_mode',
				[
					'label'     => esc_html__( 'Out Mode', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bounce',
					'options'   => [
						'out'    => esc_html__( 'Out', 'crafto-addons' ),
						'bounce' => esc_html__( 'Bounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_bounce_move',
				[
					'label'        => esc_html__( 'Enable Bounce', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_enable_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_attract_move',
				[
					'label'        => esc_html__( 'Enable Attract', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_enable_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_move_attract_rotatex',
				[
					'label'       => esc_html__( 'Attract Rotate X', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 3000', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_attract_move' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_move_attract_rotatey',
				[
					'label'       => esc_html__( 'Attract Rotate Y', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 1500', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_attract_move' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_content_section',
				[
					'label' => esc_html__( 'Interactivity', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_detect_on',
				[
					'label'   => esc_html__( 'Detect on', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''       => esc_html__( 'None', 'crafto-addons' ),
						'canvas' => esc_html__( 'Canvas', 'crafto-addons' ),
						'window' => esc_html__( 'Window', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_enable_onhover',
				[
					'label'        => esc_html__( 'Enable On Hover Events', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_onhover_mode',
				[
					'label'     => esc_html__( 'On Hover Mode', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'grab',
					'options'   => [
						'grab'    => esc_html__( 'Grab', 'crafto-addons' ),
						'bubble'  => esc_html__( 'Bubble', 'crafto-addons' ),
						'repulse' => esc_html__( 'Repulse', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_onhover' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_onclick',
				[
					'label'        => esc_html__( 'Enable On Click Event', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_onclick_mode',
				[
					'label'     => esc_html__( 'On Click Mode', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'push',
					'options'   => [
						'push'    => esc_html__( 'Push', 'crafto-addons' ),
						'remove'  => esc_html__( 'Remove', 'crafto-addons' ),
						'bubble'  => esc_html__( 'Bubble', 'crafto-addons' ),
						'repulse' => esc_html__( 'Repulse', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_onclick' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_enable_inter_resize',
				[
					'label'        => esc_html__( 'Enable Resize', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_modes_grab_distance',
				[
					'label'       => esc_html__( 'Grab Distance', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '',
					'placeholder' => esc_html__( 'e.g. 100', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_grab_opacity',
				[
					'label'      => esc_html__( 'Grab Line Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.05,
						],
					],
				]
			);
			$this->add_control(
				'crafto_modes_bubble_distance',
				[
					'label'       => esc_html__( 'Bubble Distance', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 100', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_bubble_size',
				[
					'label'       => esc_html__( 'Bubble Size', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 80', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_bubble_duration',
				[
					'label'       => esc_html__( 'Bubble Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Second (e.g. 2)', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_bubble_speed',
				[
					'label'       => esc_html__( 'Bubble Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 3', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_bubble_opacity',
				[
					'label'      => esc_html__( 'Bubble Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
				],
			);
			$this->add_control(
				'crafto_modes_repulse_distance',
				[
					'label'       => esc_html__( 'Repulse Distance', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 200', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_repulse_duration',
				[
					'label'       => esc_html__( 'Repulse Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Second (e.g. 1.2)', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_push_particles_nb',
				[
					'label'       => esc_html__( 'Push Particles Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 4', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_modes_remove_particles_nb',
				[
					'label'       => esc_html__( 'Remove Particles Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'e.g. 4', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_retina_section',
				[
					'label' => esc_html__( 'Retina', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'crafto_retina_detect',
				[
					'label'        => esc_html__( 'Enable Retina Detect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render particle effect widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function getAsBg() {

			$settings = $this->get_settings_for_display();

			if ( ! $settings ['crafto_as_bg'] ) {
				return;
			}
			return 'particles-as-bg particles-overlay';
		}

		/**
		 * Render particle effect widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		public function get_visible_on_hover() {

			$settings = $this->get_settings_for_display();

			if ( ! $settings['crafto_visible_on_hover'] ) {
				return;
			}
			return 'visible-on-column-hover';
		}

		/**
		 * Render particle effect widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			$data               = '';
			$particle_opts      = [];
			$interactivity_opts = [];
			$number_opts        = [];
			$shape_opts         = [];
			$stroke_opts        = [];
			$image_opts         = [];
			$opacity_opts       = [];
			$particle_opts      = [];
			$opacity_anim_opts  = [];
			$size_opts          = [];
			$size_anim_opts     = [];
			$line_linked_opts   = [];
			$move_opts          = [];
			$move_attract_opts  = [];
			$events_opts        = [];
			$modes_opts         = [];
			$bubble_opts        = [];
			$repulse_opts       = [];
			$density_opts       = [];

			$settings                         = $this->get_settings_for_display();
			$crafto_enable_density            = $this->get_settings( 'crafto_enable_density' );
			$crafto_opacity                   = $this->get_settings( 'crafto_opacity' );
			$crafto_enable_random_opacity     = $this->get_settings( 'crafto_enable_random_opacity' );
			$crafto_enable_anim_opacity       = $this->get_settings( 'crafto_enable_anim_opacity' );
			$crafto_anim_opacity_min          = $this->get_settings( 'crafto_anim_opacity_min' );
			$crafto_enable_random_size        = $this->get_settings( 'crafto_enable_random_size' );
			$crafto_enable_anim_size          = $this->get_settings( 'crafto_enable_anim_size' );
			$crafto_anim_size_min             = $this->get_settings( 'crafto_anim_size_min' );
			$crafto_enable_anim_size_sync     = $this->get_settings( 'crafto_enable_anim_size_sync' );
			$crafto_enable_line_linked        = $this->get_settings( 'crafto_enable_line_linked' );
			$crafto_line_opacity              = $this->get_settings( 'crafto_line_opacity' );
			$crafto_enable_move               = $this->get_settings( 'crafto_enable_move' );
			$crafto_move_direction            = $this->get_settings( 'crafto_move_direction' );
			$crafto_enable_onhover            = $this->get_settings( 'crafto_enable_onhover' );
			$crafto_enable_random_move        = $this->get_settings( 'crafto_enable_random_move' );
			$crafto_enable_straight_move      = $this->get_settings( 'crafto_enable_straight_move' );
			$crafto_enable_onclick            = $this->get_settings( 'crafto_enable_onclick' );
			$crafto_enable_bounce_move        = $this->get_settings( 'crafto_enable_bounce_move' );
			$crafto_enable_inter_resize       = $this->get_settings( 'crafto_enable_inter_resize' );
			$crafto_retina_detect             = $this->get_settings( 'crafto_retina_detect' );
			$crafto_as_bg                     = $this->get_settings( 'crafto_as_bg' );
			$crafto_enable_attract_move       = $this->get_settings( 'crafto_enable_attract_move' );
			$crafto_modes_grab_opacity        = $this->get_settings( 'crafto_modes_grab_opacity' );
			$crafto_onhover_mode              = $this->get_settings( 'crafto_onhover_mode' );
			$crafto_onclick_mode              = $this->get_settings( 'crafto_onclick_mode' );
			$crafto_number                    = ( isset( $settings['crafto_number'] ) && ! empty( $settings['crafto_number'] ) ) ? $settings['crafto_number'] : 70;
			$crafto_modes_repulse_distance    = $this->get_settings( 'crafto_modes_repulse_distance' );
			$crafto_multi_color_values        = $this->get_settings( 'crafto_multi_color_values' );
			$crafto_color_type                = $this->get_settings( 'crafto_color_type' );
			$crafto_shape_type                = $this->get_settings( 'crafto_shape_type' );
			$crafto_stroke_width              = $this->get_settings( 'crafto_stroke_width' );
			$crafto_stroke_color              = $this->get_settings( 'crafto_stroke_color' );
			$crafto_nb_sides                  = ( isset( $settings['crafto_nb_sides'] ) && ! empty( $settings['crafto_nb_sides'] ) ) ? $settings['crafto_nb_sides'] : 5;
			$crafto_image                     = $this->get_settings( 'crafto_image' );
			$crafto_image_width               = $this->get_settings( 'crafto_image_width' );
			$crafto_image_height              = $this->get_settings( 'crafto_image_height' );
			$crafto_anim_opacity_speed        = $this->get_settings( 'crafto_anim_opacity_speed' );
			$crafto_size                      = $this->get_settings( 'crafto_size' );
			$crafto_line_distance             = $this->get_settings( 'crafto_line_distance' );
			$crafto_anim_size_speed           = ( isset( $settings['crafto_anim_size_speed'] ) && ! empty( $settings['crafto_anim_size_speed'] ) ) ? $settings['crafto_anim_size_speed'] : 80;
			$crafto_line_color                = $this->get_settings( 'crafto_line_color' );
			$crafto_line_width                = $this->get_settings( 'crafto_line_width' );
			$crafto_move_speed                = $this->get_settings( 'crafto_move_speed' );
			$crafto_move_attract_rotatex      = $this->get_settings( 'crafto_move_attract_rotatex' );
			$crafto_move_attract_rotatey      = $this->get_settings( 'crafto_move_attract_rotatey' );
			$crafto_modes_grab_distance       = $this->get_settings( 'crafto_modes_grab_distance' );
			$crafto_modes_bubble_distance     = $this->get_settings( 'crafto_modes_bubble_distance' );
			$crafto_modes_bubble_size         = $this->get_settings( 'crafto_modes_bubble_size' );
			$crafto_modes_bubble_duration     = $this->get_settings( 'crafto_modes_bubble_duration' );
			$crafto_modes_repulse_duration    = $this->get_settings( 'crafto_modes_repulse_duration' );
			$crafto_modes_push_particles_nb   = $this->get_settings( 'crafto_modes_push_particles_nb' );
			$crafto_modes_remove_particles_nb = $this->get_settings( 'crafto_modes_remove_particles_nb' );
			$crafto_density                   = $this->get_settings( 'crafto_density' );
			$crafto_color                     = $this->get_settings( 'crafto_color' );
			$crafto_enable_anim_sync          = $this->get_settings( 'crafto_enable_anim_sync' );
			$crafto_move_out_mode             = $this->get_settings( 'crafto_move_out_mode' );
			$crafto_detect_on                 = $this->get_settings( 'crafto_detect_on' );
			$crafto_modes_bubble_speed        = $this->get_settings( 'crafto_modes_bubble_speed' );
			$crafto_modes_bubble_opacity      = $this->get_settings( 'crafto_modes_bubble_opacity' );

			if ( ! empty( $crafto_number ) ) {
				$number_opts['value'] = (int) $crafto_number;
			}

			if ( $crafto_enable_density ) {
				$density_opts['enable'] = true;
			}

			if ( ! empty( $crafto_density ) ) {
				$density_opts['value_area'] = (int) $crafto_density;
			}

			if ( ! empty( $density_opts ) ) {
				$number_opts['density'] = $density_opts;
			}

			// Number of elements.
			if ( ! empty( $number_opts ) ) {
				$particle_opts['number'] = $number_opts;
			}

			// Background Color.
			if ( 'single_color' === $crafto_color_type ) {
				if ( ! empty( $crafto_color ) ) {
					$particle_opts['color'] = array( 'value' => $crafto_color );
				}
			} elseif ( 'multi_color' === $crafto_color_type ) {
				$colors    = [];
				$color_arr = $crafto_multi_color_values;
				if ( ! empty( $color_arr ) ) {
					foreach ( $color_arr as $color ) {
						if ( isset( $color['crafto_scolor'] ) && ! empty( $color['crafto_scolor'] ) ) {
							$colors[] = $color['crafto_scolor'];
						}
					}
				}
				if ( ! empty( $colors ) ) {
					$particle_opts['color'] = array( 'value' => $colors );
				}
			} else {
				$particle_opts['color'] = array( 'value' => 'random' );
			}

			// Shape options.
			if ( ! empty( $crafto_shape_type ) ) {
				$shape_arr          = $crafto_shape_type;
				$shape_opts['type'] = $shape_arr;
			}

			if ( ! empty( $crafto_stroke_width ) ) {
				$stroke_opts['width'] = (int) $crafto_stroke_width;
			}

			if ( ! empty( $crafto_stroke_color ) ) {
				$stroke_opts['color'] = $crafto_stroke_color;
			}

			if ( ! empty( $stroke_opts ) ) {
				$shape_opts['stroke'] = $stroke_opts;
			}

			if ( ! empty( $crafto_nb_sides ) ) {
				$shape_opts['polygon'] = array( 'nb_sides' => (int) $crafto_nb_sides );
			}

			if ( ! empty( $crafto_image ) ) {
				$url               = wp_get_attachment_image_url( $crafto_image['id'], 'full', false );
				$image_opts['src'] = esc_url( $url );
			}

			if ( ! empty( $crafto_image_width ) ) {
				$image_opts['width'] = (int) $crafto_image_width;
			}

			if ( ! empty( $crafto_image_height ) ) {
				$image_opts['height'] = (int) $crafto_image_height;
			}

			if ( ! empty( $image_opts ) ) {
				$shape_opts['image'] = $image_opts;
			}

			if ( ! empty( $shape_opts ) ) {
				$particle_opts['shape'] = $shape_opts;
			}

			// Opacity values.
			if ( '1' !== $crafto_opacity ) {
				$opacity_opts['value'] = (float) $crafto_opacity['size'];
			}

			if ( 'yes' === $crafto_enable_random_opacity ) {
				$opacity_opts['random'] = true;
			} else {
				$opacity_opts['random'] = false;
			}

			if ( 'yes' === $crafto_enable_anim_opacity ) {
				$opacity_anim_opts['enable'] = true;
			} else {
				$opacity_anim_opts['enable'] = false;
			}

			if ( ! empty( $crafto_anim_opacity_min ) ) {
				$opacity_anim_opts['opacity_min'] = (float) $crafto_anim_opacity_min;
			}

			if ( ! empty( $crafto_anim_opacity_speed ) ) {
				$opacity_anim_opts['speed'] = (int) $crafto_anim_opacity_speed;
			}

			if ( 'yes' === $crafto_enable_anim_sync ) {
				$opacity_anim_opts['sync'] = true;
			} else {
				$opacity_anim_opts['sync'] = false;
			}

			if ( ! empty( $opacity_anim_opts ) ) {
				$opacity_opts['anim'] = $opacity_anim_opts;
			}

			if ( ! empty( $opacity_opts ) ) {
				$particle_opts['opacity'] = $opacity_opts;
			}
			// Size values.
			if ( ! empty( $crafto_size ) ) {
				$size_opts['value'] = (int) $crafto_size;
			}

			if ( $crafto_enable_random_size ) {
				$size_opts['random'] = true;
			}

			if ( 'yes' === $crafto_enable_anim_size ) {
				$size_anim_opts['enable'] = true;
			} else {
				$size_anim_opts['enable'] = false;
			}

			if ( ! empty( $crafto_anim_size_min ) ) {
				$size_anim_opts['size_min'] = (float) $crafto_anim_size_min['size'];
			}

			if ( ! empty( $crafto_anim_size_speed ) ) {
				$size_anim_opts['speed'] = (int) $crafto_anim_size_speed;
			}

			if ( 'yes' === $crafto_enable_anim_size_sync ) {
				$size_anim_opts['sync'] = true;
			} else {
				$size_anim_opts['sync'] = false;
			}

			if ( ! empty( $size_anim_opts ) ) {
				$size_opts['anim'] = $size_anim_opts;
			}
			if ( ! empty( $size_opts ) ) {
				$particle_opts['size'] = $size_opts;
			}

			// Linked line.
			if ( $crafto_enable_line_linked ) {
				$line_linked_opts['enable'] = true;
			} else {
				$line_linked_opts['enable'] = false;
			}

			if ( ! empty( $crafto_line_opacity ) ) {
				$line_linked_opts['opacity'] = (float) $crafto_line_opacity['size'];
			}

			if ( ! empty( $crafto_line_distance ) ) {
				$line_linked_opts['distance'] = (int) $crafto_line_distance;
			}
			if ( ! empty( $crafto_line_color ) ) {
				$line_linked_opts['color'] = $crafto_line_color;
			}
			if ( ! empty( $crafto_line_width ) ) {
				$line_linked_opts['width'] = (int) $crafto_line_width;
			}
			if ( ! empty( $line_linked_opts ) ) {
				$particle_opts['line_linked'] = $line_linked_opts;
			}
			// Move values.
			if ( $crafto_enable_move ) {
				$move_opts['enable'] = true;
			}
			if ( ! empty( $crafto_move_direction ) ) {
				$move_opts['direction'] = $crafto_move_direction;
			}
			if ( ! empty( $crafto_move_speed ) ) {
				$move_opts['speed'] = (float) $crafto_move_speed;
			}
			if ( $crafto_enable_random_move ) {
				$move_opts['random'] = true;
			} else {
				$move_opts['random'] = false;
			}

			if ( $crafto_enable_straight_move ) {
				$move_opts['straight'] = true;
			} else {
				$move_opts['straight'] = false;
			}

			if ( $crafto_move_out_mode ) {
				$move_opts['out_mode'] = $crafto_move_out_mode;
			}
			if ( $crafto_enable_bounce_move ) {
				$move_opts['bounce'] = true;
			} else {
				$move_opts['bounce'] = false;
			}
			if ( $crafto_enable_attract_move ) {
				$move_attract_opts['enable'] = true;
			} else {
				$move_attract_opts['enable'] = false;
			}
			if ( ! empty( $crafto_move_attract_rotatex ) ) {
				$move_attract_opts['rotateX'] = (int) $crafto_move_attract_rotatex;
			}
			if ( ! empty( $crafto_move_attract_rotatey ) ) {
				$move_attract_opts['rotateY'] = (int) $crafto_move_attract_rotatey;
			}
			if ( ! empty( $move_attract_opts ) ) {
				$move_opts['attract'] = $move_attract_opts;
			}
			if ( ! empty( $move_opts ) ) {
				$particle_opts['move'] = $move_opts;
			}
			$options['particles'] = $particle_opts;
			if ( ! empty( $crafto_detect_on ) ) {
				$interactivity_opts['detect_on'] = $crafto_detect_on;
			}
			if ( $crafto_enable_onhover ) {
				$onhover_arr            = explode( ',', $crafto_onhover_mode );
				$events_opts['onhover'] = array(
					'enable' => true,
					'mode'   => $onhover_arr,
				);
			} else {
				$onhover_arr            = explode( ',', $crafto_onhover_mode );
				$events_opts['onhover'] = array(
					'enable' => false,
					'mode'   => $onhover_arr,
				);
			}

			if ( $crafto_enable_onclick ) {
				$crafto_onclick_arr     = explode( ',', $crafto_onclick_mode );
				$events_opts['onclick'] = array(
					'enable' => true,
					'mode'   => $crafto_onclick_arr,
				);
			} else {
				$crafto_onclick_arr     = explode( ',', $crafto_onclick_mode );
				$events_opts['onclick'] = array(
					'enable' => false,
					'mode'   => $crafto_onclick_arr,
				);
			}

			if ( $crafto_enable_inter_resize ) {
				$events_opts['resize'] = true;
			} else {
				$events_opts['resize'] = false;
			}

			if ( ! empty( $events_opts ) ) {
				$interactivity_opts['events'] = $events_opts;
			}

			if ( ! empty( $crafto_modes_grab_distance ) ) {
				$modes_opts['grab'] = array(
					'distance'    => (int) $crafto_modes_grab_distance,
					'line_linked' => array( 'opacity' => $crafto_modes_grab_opacity['size'] ),
				);
			}
			if ( ! empty( $crafto_modes_bubble_distance ) ) {
				$bubble_opts['distance'] = (int) $crafto_modes_bubble_distance;
			}
			if ( ! empty( $crafto_modes_bubble_size ) ) {
				$bubble_opts['size'] = (int) $crafto_modes_bubble_size;
			}
			if ( ! empty( $crafto_modes_bubble_duration ) ) {
				$bubble_opts['duration'] = (float) $crafto_modes_bubble_duration;
			}

			if ( ! empty( $crafto_modes_bubble_speed ) ) {
				$bubble_opts['speed'] = (float) $crafto_modes_bubble_speed;
			}

			if ( ! empty( $crafto_modes_bubble_opacity ) ) {
				$bubble_opts['opacity'] = (float) $crafto_modes_bubble_opacity['size'];
			}

			if ( ! empty( $bubble_opts ) ) {
				$modes_opts['bubble'] = $bubble_opts;
			}

			if ( ! empty( $crafto_modes_repulse_distance ) ) {
				$repulse_opts['distance'] = (int) $crafto_modes_repulse_distance;
			}

			if ( ! empty( $crafto_modes_repulse_duration ) ) {
				$repulse_opts['duration'] = (float) $crafto_modes_repulse_duration;
			}

			if ( ! empty( $repulse_opts ) ) {
				$modes_opts['repulse'] = $repulse_opts;
			}

			if ( ! empty( $crafto_modes_push_particles_nb ) ) {
				$modes_opts['push'] = array( 'particles_nb' => (int) $crafto_modes_push_particles_nb );
			}

			if ( ! empty( $crafto_modes_remove_particles_nb ) ) {
				$modes_opts['remove'] = array( 'particles_nb' => (int) $crafto_modes_remove_particles_nb );
			}

			if ( ! empty( $modes_opts ) ) {
				$interactivity_opts['modes'] = $modes_opts;
			}
			$options['interactivity'] = $interactivity_opts;

			if ( $crafto_retina_detect ) {
				$options['retina_detect'] = true;
			}

			if ( $crafto_as_bg ) {
				$options['asBG'] = true;
			}

			if ( ! empty( $options ) ) {
				$data = 'data-particles-options=\'' . wp_json_encode( $options ) . '\'';
			}

			$this->add_render_attribute(
				'wrapper',
				[
					'id'    => 'particles-style-' . uniqid(),
					'class' => [
						'particle-wrapper',
						'has-particle-effect',
						$this->get_visible_on_hover(),
					],
				]
			);

			if ( ! empty( $this->getAsBg() ) ) {
				$this->add_render_attribute(
					'wrapper',
					[
						'class' => [
							$this->getAsBg(),
						],
					]
				);
			}
			?>
			<div class="crafto-particles-container">
				<div <?php $this->print_render_attribute_string( 'wrapper' ); ?> <?php echo $data; // phpcs:ignore ?>></div>
			</div>
			<?php
		}
	}
}
