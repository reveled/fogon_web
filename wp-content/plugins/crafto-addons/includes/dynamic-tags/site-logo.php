<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for site logo.
 *
 * @package Crafto
 */

// If class `Site_Logo` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Site_Logo' ) ) {
	/**
	 * Define `Site_Logo` class.
	 */
	class Site_Logo extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'site-logo';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Site Logo', 'crafto-addons' );
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
			$custom_logo_url = get_theme_mod( 'crafto_logo' );

			$custom_logo_id = '';
			if ( ! empty( $custom_logo_url ) ) {
				$custom_logo_id = attachment_url_to_postid( $custom_logo_url );
			}

			$url = $custom_logo_id ? $custom_logo_url : \Elementor\Utils::get_placeholder_image_src();

			return [
				'id'  => $custom_logo_id,
				'url' => $url,
			];
		}
	}
}
