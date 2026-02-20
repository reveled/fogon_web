<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post gallery.
 *
 * @package Crafto
 */

// If class `Post_Gallery` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_Gallery' ) ) {
	/**
	 * Define `Post_Gallery` class.
	 */
	class Post_Gallery extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-gallery';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Post Image Attachments', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::GALLERY_CATEGORY ];
		}

		/**
		 * @param array $options Array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			$images = get_attached_media( 'image' );

			$value = [];

			foreach ( $images as $image ) {
				$value[] = [
					'id' => $image->ID,
				];
			}

			return $value;
		}
	}
}
