<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for user profile picture.
 *
 * @package Crafto
 */

// If class `User_Profile_Picture` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\User_Profile_Picture' ) ) {
	/**
	 * Define `User_Profile_Picture` class.
	 */
	class User_Profile_Picture extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'user-profile-picture';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'User Profile Picture', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::IMAGE_CATEGORY ];
		}

		/**
		 * @param array $options Array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			return [
				'id'  => '',
				'url' => get_avatar_url( get_current_user_id() ),
			];
		}
	}
}
