<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for archive description.
 *
 * @package Crafto
 */

// If class `Archive_Description` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Archive_Description' ) ) {
	/**
	 * Define `Archive_Description` class.
	 */
	class Archive_Description extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'archive-description';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Archive Description', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'archive';
		}

		/**
		 * Retrieve the categories.
		 *
		 * @access public
		 *
		 * @return string categories.
		 */
		public function get_categories() {
			return [
				'text',
			];
		}

		/**
		 * Render archive descrption.
		 *
		 * @access public
		 */
		public function render() {
			echo wp_kses_post( get_the_archive_description() );
		}
	}
}
