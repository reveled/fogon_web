<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for site title.
 *
 * @package Crafto
 */

// If class `Site_Title` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Site_Title' ) ) {
	/**
	 * Define `Site_Title` class.
	 */
	class Site_Title extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'site-title';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Site Title', 'crafto-addons' );
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
		 * Render site title.
		 *
		 * @access public
		 */
		public function render() {
			echo wp_kses_post( get_bloginfo() );
		}
	}
}
