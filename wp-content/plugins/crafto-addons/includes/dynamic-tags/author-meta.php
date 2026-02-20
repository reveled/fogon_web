<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for author meta.
 *
 * @package Crafto
 */

// If class `Author_Meta` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Author_Meta' ) ) {
	/**
	 * Define `Author_Meta` class.
	 */
	class Author_Meta extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'author-meta';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Author Meta', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'author';
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
		 * Retrieve the panel template settings.
		 *
		 * @access public
		 *
		 * @return string template key.
		 */
		public function get_panel_template_setting_key() {
			return 'key';
		}

		/**
		 * Register author meta controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'key',
				[
					'label' => esc_html__( 'Meta Key', 'crafto-addons' ),
				]
			);
		}

		/**
		 * Render author meta.
		 *
		 * @access public
		 */
		public function render() {
			$key = $this->get_settings( 'key' );
			if ( empty( $key ) ) {
				return;
			}

			$value = get_the_author_meta( $key );

			echo wp_kses_post( $value );
		}
	}
}
