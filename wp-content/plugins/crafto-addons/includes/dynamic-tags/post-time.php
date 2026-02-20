<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post time.
 *
 * @package Crafto
 */

// If class `Post_Time` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_Time' ) ) {
	/**
	 * Define `Post_Time` class.
	 */
	class Post_Time extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-time';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Post Time', 'crafto-addons' );
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
		 * Register post time controls.
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
						'g:i a'   => gmdate( 'g:i a' ),
						'g:i A'   => gmdate( 'g:i A' ),
						'H:i'     => gmdate( 'H:i' ),
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
		 * Render post time.
		 *
		 * @access public
		 */
		public function render() {
			$time_type = $this->get_settings( 'type' );
			$format    = $this->get_settings( 'format' );

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

			if ( 'post_date_gmt' === $time_type ) {
				$value = get_the_time( $date_format );
			} else {
				$value = get_the_modified_time( $date_format );
			}

			echo wp_kses_post( $value );
		}
	}
}
