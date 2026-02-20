<?php
namespace CraftoAddons\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Base;

// If class `Text_Gradient_Background` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Controls\Groups\Text_Gradient_Background' ) ) {

	/**
	 * Crafto Text Gradient Background control.
	 *
	 * A base control for creating background control. Displays input fields to define
	 * the background color, background gradient.
	 *
	 * @package Crafto
	 */
	class Text_Gradient_Background extends Group_Control_Base {

		/**
		 * Fields.
		 *
		 * Holds all the background control fields.
		 *
		 * @access protected
		 * @static
		 *
		 * @var array Background control fields.
		 */
		protected static $fields;

		/**
		 * Background Types.
		 *
		 * Holds all the available background types.
		 *
		 * @access private
		 * @static
		 *
		 * @var array
		 */
		private static $background_types;

		/**
		 * Retrieve type.
		 *
		 * Get background control type.
		 *
		 * @access public
		 * @static
		 *
		 * @return string Control type.
		 */
		public static function get_type() {
			return 'text-gradient-background';
		}

		/**
		 * Retrieve background types.
		 *
		 * Gat available background types.
		 *
		 * @access public
		 * @static
		 *
		 * @return array Available background types.
		 */
		public static function get_background_types() {
			if ( null === self::$background_types ) {
				self::$background_types = self::init_background_types();
			}

			return self::$background_types;
		}

		/* TODO: rename to `default_background_types()` */
		/**
		 * Default background types.
		 *
		 * Retrieve background control initial types.
		 *
		 * @access private
		 * @static
		 *
		 * @return array Default background types.
		 */
		private static function init_background_types() {
			return [
				'solid'    => [
					'title' => _x( 'Solid', 'Text Text Background Control', 'crafto-addons' ),
					'icon'  => 'eicon-paint-brush',
				],
				'gradient' => [
					'title' => _x( 'Gradient', 'Text Text Background Control', 'crafto-addons' ),
					'icon'  => 'eicon-barcode',
				],
			];
		}

		/**
		 * Init fields.
		 *
		 * Initialize text background control fields.
		 *
		 * @access public
		 *
		 * @return array Control fields.
		 */
		public function init_fields() {
			$fields = [];

			$fields['background'] = [
				'label'       => _x( 'Text Color', 'Text Background Control', 'crafto-addons' ),
				'type'        => 'choose',
				'label_block' => false,
				'render_type' => 'ui',
			];

			$fields['color'] = [
				'label'      => _x( 'Color', 'Text Background Control', 'crafto-addons' ),
				'type'       => 'color',
				'responsive' => true,
				'default'    => '',
				'title'      => _x( 'Background Color', 'Text Background Control', 'crafto-addons' ),
				'selectors'  => [
					'{{SELECTOR}}' => 'color: {{VALUE}}; fill:{{VALUE}}',
				],
				'condition'  => [
					'background' => [
						'solid',
						'gradient',
					],
				],
			];

			$fields['color_stop'] = [
				'label'       => _x( 'Location', 'Text Background Control', 'crafto-addons' ),
				'type'        => 'slider',
				'size_units'  => [
					'%',
				],
				'default'     => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'   => [
					'background' => [
						'gradient',
					],
				],
				'of_type'     => 'gradient',
			];

			$fields['color_b'] = [
				'label'       => _x( 'Second Color', 'Text Background Control', 'crafto-addons' ),
				'type'        => 'color',
				'default'     => '#f2295b',
				'render_type' => 'ui',
				'condition'   => [
					'background' => [
						'gradient',
					],
				],
				'of_type'     => 'gradient',
			];

			$fields['color_b_stop'] = [
				'label'       => _x( 'Location', 'Text Background Control', 'crafto-addons' ),
				'type'        => 'slider',
				'size_units'  => [
					'%',
				],
				'default'     => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'   => [
					'background' => [
						'gradient',
					],
				],
				'of_type'     => 'gradient',
			];

			$fields['gradient_type'] = [
				'label'       => _x( 'Type', 'Text Background Control', 'crafto-addons' ),
				'type'        => 'select',
				'options'     => [
					'linear' => _x( 'Linear', 'Text Background Control', 'crafto-addons' ),
					'radial' => _x( 'Radial', 'Text Background Control', 'crafto-addons' ),
				],
				'default'     => 'linear',
				'render_type' => 'ui',
				'condition'   => [
					'background' => [
						'gradient',
					],
				],
				'of_type'     => 'gradient',
			];

			$fields['gradient_angle'] = [
				'label'      => _x( 'Angle', 'Text Background Control', 'crafto-addons' ),
				'type'       => 'slider',
				'size_units' => [
					'deg',
				],
				'default'    => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range'      => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors'  => [
					'{{SELECTOR}}' => 'background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
				],
				'condition'  => [
					'background'    => [
						'gradient',
					],
					'gradient_type' => 'linear',
				],
				'of_type'    => 'gradient',
			];

			$fields['gradient_position'] = [
				'label'     => _x( 'Position', 'Text Background Control', 'crafto-addons' ),
				'type'      => 'select',
				'options'   => [
					'center center' => _x( 'Center Center', 'Text Background Control', 'crafto-addons' ),
					'center left'   => _x( 'Center Left', 'Text Background Control', 'crafto-addons' ),
					'center right'  => _x( 'Center Right', 'Text Background Control', 'crafto-addons' ),
					'top center'    => _x( 'Top Center', 'Text Background Control', 'crafto-addons' ),
					'top left'      => _x( 'Top Left', 'Text Background Control', 'crafto-addons' ),
					'top right'     => _x( 'Top Right', 'Text Background Control', 'crafto-addons' ),
					'bottom center' => _x( 'Bottom Center', 'Text Background Control', 'crafto-addons' ),
					'bottom left'   => _x( 'Bottom Left', 'Text Background Control', 'crafto-addons' ),
					'bottom right'  => _x( 'Bottom Right', 'Text Background Control', 'crafto-addons' ),
				],
				'default'   => 'center center',
				'selectors' => [
					'{{SELECTOR}}' => 'background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{color.VALUE}} {{color_stop.SIZE}}{{color_stop.UNIT}}, {{color_b.VALUE}} {{color_b_stop.SIZE}}{{color_b_stop.UNIT}})',
				],
				'condition' => [
					'background'    => [
						'gradient',
					],
					'gradient_type' => 'radial',
				],
				'of_type'   => 'gradient',
			];

			return $fields;
		}

		/**
		 * Retrieve child default args.
		 *
		 * Get the default arguments for all the child controls for a specific group
		 * control.
		 *
		 * @access protected
		 *
		 * @return array Default arguments for all the child controls.
		 */
		protected function get_child_default_args() {
			return [
				'types' => [
					'solid',
					'gradient',
				],
			];
		}

		/**
		 * Filter fields.
		 *
		 * Filter which controls to display, using `include`, `exclude`, `condition`
		 * and `of_type` arguments.
		 *
		 * @access protected
		 *
		 * @return array Control fields.
		 */
		protected function filter_fields() {
			$fields = parent::filter_fields();

			$args = $this->get_args();

			foreach ( $fields as &$field ) {
				if ( isset( $field['of_type'] ) && ! in_array( $field['of_type'], $args['types'], true ) ) {
					unset( $field );
				}
			}

			return $fields;
		}

		/**
		 * Prepare fields.
		 *
		 * Process text background control fields before adding them to `add_control()`.
		 *
		 * @access protected
		 *
		 * @param array $fields Text background control fields.
		 *
		 * @return array Processed fields.
		 */
		protected function prepare_fields( $fields ) {
			$args = $this->get_args();

			$background_types = self::get_background_types();

			$choose_types = [];

			foreach ( $args['types'] as $type ) {
				if ( isset( $background_types[ $type ] ) ) {
					$choose_types[ $type ] = $background_types[ $type ];
				}
			}

			$fields['background']['options'] = $choose_types;

			return parent::prepare_fields( $fields );
		}

		/**
		 * Retrieve default options.
		 *
		 * @access protected
		 */
		protected function get_default_options() {
			return [
				'popover' => false,
			];
		}
	}
}
