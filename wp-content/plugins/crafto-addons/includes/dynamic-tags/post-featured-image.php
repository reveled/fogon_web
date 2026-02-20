<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post featured image.
 *
 * @package Crafto
 */

// If class `Post_Featured_Image` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_Featured_Image' ) ) {
	/**
	 * Define `Post_Featured_Image` class.
	 */
	class Post_Featured_Image extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-featured-image';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Featured Image', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'media';
		}

		/**
		 * Retrieve the categories.
		 *
		 * @access public
		 *
		 * @return string categories.
		 */
		public function get_categories() {
			return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
		}

		/**
		 * Retrive image.
		 *
		 * @access public
		 */
		public function get_image() {
			$thumbnail_id = get_post_thumbnail_id();

			if ( $thumbnail_id && ! empty( wp_get_attachment_image_src( $thumbnail_id, 'full' )[0] ) ) {
				return [
					'id'  => $thumbnail_id,
					'url' => wp_get_attachment_image_src( $thumbnail_id, 'full' )[0],
				];
			}

			return false;
		}

		/**
		 * Retrive fallback.
		 *
		 * @access public
		 */
		public function get_fallback() {
			return $this->get_settings( 'fallback' );
		}

		/**
		 * @param array $options Array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			$image_data = $this->get_image();

			if ( false === $image_data ) {
				$image_data = $this->get_fallback();
			}

			return $image_data;
		}

		/**
		 * Register post featured image controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'fallback',
				[
					'label' => __( 'Fallback', 'crafto-addons' ),
					'type'  => 'media',
				]
			);
		}
	}
}
