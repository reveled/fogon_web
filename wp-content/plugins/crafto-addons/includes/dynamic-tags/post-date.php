<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post date.
 *
 * @package Crafto
 */

// If class `Post_Date` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_Date' ) ) {
	/**
	 * Define `Post_Date` class.
	 */
	class Post_Date extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-date';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Post Date', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'post';
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
		 * Register post date fields controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'type',
				[
					'label'   => esc_html__( 'Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'post_date_gmt'     => esc_html__( 'Post Published', 'crafto-addons' ),
						'post_modified_gmt' => esc_html__( 'Post Modified', 'crafto-addons' ),
					],
					'default' => 'post_date_gmt',
				]
			);
			$this->add_control(
				'format',
				[
					'label'   => esc_html__( 'Format', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'F j, Y'  => gmdate( 'F j, Y' ),
						'Y-m-d'   => gmdate( 'Y-m-d' ),
						'm/d/Y'   => gmdate( 'm/d/Y' ),
						'd/m/Y'   => gmdate( 'd/m/Y' ),
						'human'   => esc_html__( 'Human Readable', 'crafto-addons' ),
						'custom'  => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'default' => 'default',
				]
			);
			$this->add_control(
				'custom_format',
				[
					'label'       => esc_html__( 'Custom Format', 'crafto-addons' ),
					'default'     => '',
					'description' => sprintf( '<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank" rel="noopener noreferrer">%s</a>', esc_html__( 'Documentation on date and time formatting', 'crafto-addons' ) ),
					'condition'   => [
						'format' => 'custom',
					],
				]
			);
		}

		/**
		 * Render post date fields.
		 *
		 * @access public
		 */
		public function render() {
			$date_type = $this->get_settings( 'type' );
			$format    = $this->get_settings( 'format' );

			if ( 'human' === $format ) {
				/* translators: %s: Human readable date/time. */
				$value = sprintf( '%1$s %2$s', human_time_diff( strtotime( get_post()->{$date_type} ) ), __( 'ago', 'crafto-addons' ) );
			} else {
				switch ( $format ) {
					case 'default':
						$date_format = '';
						break;
					case 'custom':
						$date_format = $this->get_settings( 'custom_format' );
						break;
					default:
						$date_format = $format;
						break;
				}

				if ( 'post_date_gmt' === $date_type ) {
					$value = get_the_date( $date_format );
				} else {
					$value = get_the_modified_date( $date_format );
				}
			}
			echo wp_kses_post( $value );
		}
	}
}
