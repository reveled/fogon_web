<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post comments URL.
 *
 * @package Crafto
 */

// If class `Comments_URL` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Comments_URL' ) ) {
	/**
	 * Define `Comments_URL` class.
	 */
	class Comments_URL extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'comments-url';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Comments URL', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'comment';
		}

		/**
		 * Retrieve the categories.
		 *
		 * @access public
		 *
		 * @return string categories.
		 */
		public function get_categories() {
			return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY ];
		}

		/**
		 * @param array $options array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			return get_comments_link();
		}
	}
}
