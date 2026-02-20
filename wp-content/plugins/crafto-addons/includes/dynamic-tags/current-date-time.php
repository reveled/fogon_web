<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for request parameter.
 *
 * @package Crafto
 */

// If class `Current_Date_Time` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Current_Date_Time' ) ) {
	/**
	 * Define `Current_Date_Time` class.
	 */
	class Current_Date_Time extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'current-date-time';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Current Date Time', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'site';
		}

		/**
		 * Retrieve the categories.
		 *
		 * @access public
		 *
		 * @return string categories.
		 */
		public function get_categories() {
			return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
		}

		/**
		 * Register current date controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'date_format',
				[
					'label'   => esc_html__( 'Date Format', 'crafto-addons' ),
					'type'    => 'select',
					'options' => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						''        => esc_html__( 'None', 'crafto-addons' ),
						'F j, Y'  => gmdate( 'F j, Y' ),
						'Y-m-d'   => gmdate( 'Y-m-d' ),
						'm/d/Y'   => gmdate( 'm/d/Y' ),
						'd/m/Y'   => gmdate( 'd/m/Y' ),
						'custom'  => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'default' => 'default',
				]
			);

			$this->add_control(
				'time_format',
				[
					'label'     => esc_html__( 'Time Format', 'crafto-addons' ),
					'type'      => 'select',
					'options'   => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						''        => esc_html__( 'None', 'crafto-addons' ),
						'g:i a'   => gmdate( 'g:i a' ),
						'g:i A'   => gmdate( 'g:i A' ),
						'H:i'     => gmdate( 'H:i' ),
					],
					'default'   => 'default',
					'condition' => [
						'date_format!' => 'custom',
					],
				]
			);

			$this->add_control(
				'custom_format',
				[
					'label'       => esc_html__( 'Custom Format', 'crafto-addons' ),
					'default'     => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
					'description' => sprintf(
						'<a href="https://wordpress.org/documentation/article/customize-date-and-time-format/" target="_blank" rel="noopener noreferrer">%s</a>',
						esc_html__( 'Documentation on date and time formatting', 'crafto-addons' )
					),
					'condition'   => [
						'date_format' => 'custom',
					],
				]
			);
		}

		/**
		 * Render current date.
		 *
		 * @access public
		 */
		public function render() {
			$settings = $this->get_settings();

			if ( 'custom' === $settings['date_format'] ) {
				$format = $settings['custom_format'];

				echo wp_kses_post( date_i18n( $format ) );
				return;
			}

			$date_format = $settings['date_format'];
			$time_format = $settings['time_format'];
			$format      = '';

			if ( 'default' === $date_format ) {
				$date_format = get_option( 'date_format' );
			}

			if ( 'default' === $time_format ) {
				$time_format = get_option( 'time_format' );
			}

			$has_date = false;

			if ( $date_format ) {
				$format   = $date_format;
				$has_date = true;
			}

			if ( $time_format ) {
				$format .= $has_date ? ' ' . $time_format : $time_format;
			}

			echo wp_kses_post( date_i18n( $format ) );
		}
	}
}
