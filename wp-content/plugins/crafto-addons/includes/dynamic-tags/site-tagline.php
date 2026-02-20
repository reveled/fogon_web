<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for site tagline.
 *
 * @package Crafto
 */

// If class `Site_Tagline` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Site_Tagline' ) ) {
	/**
	 * Define `Site_Tagline` class.
	 */
	class Site_Tagline extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'site-tagline';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Site Tagline', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
		}

		/**
		 * Render site tagline.
		 *
		 * @access public
		 */
		public function render() {
			echo wp_kses_post( get_bloginfo( 'description' ) );
		}
	}
}
