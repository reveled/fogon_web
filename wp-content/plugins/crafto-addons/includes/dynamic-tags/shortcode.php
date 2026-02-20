<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for shortcode.
 *
 * @package Crafto
 */

// If class `Shortcode` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Shortcode' ) ) {
	/**
	 * Define `Shortcode` class.
	 */
	class Shortcode extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'shortcode';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Shortcode', 'crafto-addons' );
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
			return [
				\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::URL_CATEGORY,
				\Elementor\Modules\DynamicTags\Module::POST_META_CATEGORY,
			];
		}

		/**
		 * Register shortcode controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'shortcode',
				[
					'label' => esc_html__( 'Shortcode', 'crafto-addons' ),
					'type'  => 'textarea',
				]
			);
		}

		/**
		 * Retrive shortcode.
		 *
		 * @access public
		 */
		public function get_shortcode() {
			$settings = $this->get_settings();

			if ( empty( $settings['shortcode'] ) ) {
				return '';
			}

			return $settings['shortcode'];
		}

		/**
		 * Render shortcode.
		 *
		 * @access public
		 */
		public function render() {
			$shortcode = $this->get_shortcode();

			if ( empty( $shortcode ) ) {
				return;
			}

			echo do_shortcode( $shortcode );
		}
	}
}
