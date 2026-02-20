<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post excerpt
 *
 * @package Crafto
 */

// If class `Post_Excerpt` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_Excerpt' ) ) {
	/**
	 * Define `Post_Excerpt` class.
	 */
	class Post_Excerpt extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-excerpt';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Post Excerpt', 'crafto-addons' );
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
		 * Render post excerpt.
		 *
		 * @access public
		 */
		public function render() {
			// Allow only a real `post_excerpt` and not the trimmed `post_content` from the `get_the_excerpt` filter.
			$post = get_post();

			if ( ! $post || empty( $post->post_excerpt ) ) {
				return;
			}

			echo wp_kses_post( $post->post_excerpt );
		}
	}
}
