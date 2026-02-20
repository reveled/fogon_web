<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post url.
 *
 * @package Crafto
 */

// If class `Post_URL` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_URL' ) ) {
	/**
	 * Define `Post_URL` class.
	 */
	class Post_URL extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-url';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Post URL', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY ];
		}

		/**
		 * @param array $options Array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			return get_permalink();
		}
	}
}
