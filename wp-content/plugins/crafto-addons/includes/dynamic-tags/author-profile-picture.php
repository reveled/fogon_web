<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for author profile picture.
 *
 * @package Crafto
 */

// If class `Author_Profile_Picture` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Author_Profile_Picture' ) ) {
	/**
	 * Define `Author_Profile_Picture` class.
	 */
	class Author_Profile_Picture extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'author-profile-picture';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Author Profile Picture', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
		}

		/**
		 * @param array $options The arguments array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			global $authordata;

			if ( isset( $authordata->ID ) ) {
				return [
					'id'  => '',
					'url' => get_avatar_url( (int) get_the_author_meta( 'ID' ) ),
				];
			}

			$author = get_userdata( get_post()->post_author );

			return [
				'id'  => '',
				'url' => get_avatar_url( $author ),
			];
		}
	}
}
