<?php
namespace CraftoAddons\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


use Elementor\Group_Control_Base;
use Elementor\Controls_Manager;

// If class `Column_Group_Control` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Controls\Groups\Column_Group_Control' ) ) {
	/**
	 * Crafto Column Group Control
	 *
	 * @package Crafto
	 */
	class Column_Group_Control extends Group_Control_Base {

		/**
		 * Fields.
		 *
		 * Holds all the column group control fields.
		 *
		 * @access protected
		 * @static
		 *
		 * @var array column group control fields.
		 */
		protected static $fields;

		/**
		 * Retrieve type.
		 *
		 * Get column group control type.
		 *
		 * @access public
		 * @static
		 *
		 * @return string Control type.
		 */
		public static function get_type() {
			return 'column-group-control';
		}

		/**
		 * Init fields.
		 *
		 * Initialize column group control fields.
		 *
		 * @access public
		 *
		 * @return array Control fields.
		 */
		public function init_fields() {

			$fields = [];

			$fields['crafto_larger_desktop_column'] = [
				'label'       => _x( 'Larger Desktop', 'Larger Desktop Column', 'crafto-addons' ),
				'description' => esc_html__( '( 1600px and up )', 'crafto-addons' ),
				'type'        => 'select',
				'options'     => [
					'grid-1col' => '1',
					'grid-2col' => '2',
					'grid-3col' => '3',
					'grid-4col' => '4',
					'grid-5col' => '5',
					'grid-6col' => '6',
				],
				'default'     => 'grid-3col',
			];

			$fields['crafto_large_desktop_column'] = [
				'label'       => _x( 'Large Desktop', 'Large Desktop Column', 'crafto-addons' ),
				'description' => esc_html__( '( 1200px and up )', 'crafto-addons' ),
				'type'        => 'select',
				'options'     => [
					''             => esc_html__( 'Default', 'crafto-addons' ),
					'xl-grid-1col' => '1',
					'xl-grid-2col' => '2',
					'xl-grid-3col' => '3',
					'xl-grid-4col' => '4',
					'xl-grid-5col' => '5',
					'xl-grid-6col' => '6',
				],
			];

			$fields['crafto_desktop_column'] = [
				'label'       => _x( 'Desktop', 'Desktop Column', 'crafto-addons' ),
				'description' => esc_html__( '( 992px and up )', 'crafto-addons' ),
				'type'        => 'select',
				'options'     => [
					''             => esc_html__( 'Default', 'crafto-addons' ),
					'lg-grid-1col' => '1',
					'lg-grid-2col' => '2',
					'lg-grid-3col' => '3',
					'lg-grid-4col' => '4',
					'lg-grid-5col' => '5',
					'lg-grid-6col' => '6',
				],
			];

			$fields['crafto_tablet_column'] = [
				'label'       => _x( 'Tablet', 'Tablet Column', 'crafto-addons' ),
				'description' => esc_html__( '( 768px and up )', 'crafto-addons' ),
				'type'        => 'select',
				'options'     => [
					''             => esc_html__( 'Default', 'crafto-addons' ),
					'md-grid-1col' => '1',
					'md-grid-2col' => '2',
					'md-grid-3col' => '3',
					'md-grid-4col' => '4',
					'md-grid-5col' => '5',
					'md-grid-6col' => '6',
				],
			];

			$fields['crafto_landscape_phone_column'] = [
				'label'       => _x( 'Landscape Phone', 'Landscape Phone Column', 'crafto-addons' ),
				'description' => esc_html__( '( 576px and up )', 'crafto-addons' ),
				'type'        => 'select',
				'options'     => [
					''             => esc_html__( 'Default', 'crafto-addons' ),
					'sm-grid-1col' => '1',
					'sm-grid-2col' => '2',
					'sm-grid-3col' => '3',
					'sm-grid-4col' => '4',
				],
			];

			$fields['crafto_portrait_phone_column'] = [
				'label'       => _x( 'Portrait Phone', 'Portrait Phone Column', 'crafto-addons' ),
				'description' => esc_html__( '( 0px and up )', 'crafto-addons' ),
				'type'        => 'select',
				'options'     => [
					''             => esc_html__( 'Default', 'crafto-addons' ),
					'xs-grid-1col' => '1',
					'xs-grid-2col' => '2',
					'xs-grid-3col' => '3',
				],
			];

			return $fields;
		}

		/**
		 * Retrieve default options.
		 *
		 * @access protected
		 */
		protected function get_default_options() {
			return [
				'popover' => [
					'starter_title' => _x( 'Number of Columns', 'Column Group Control', 'crafto-addons' ),
				],
			];
		}
	}
}
