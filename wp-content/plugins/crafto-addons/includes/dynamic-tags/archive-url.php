<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for archive URL.
 *
 * @package Crafto
 */

// If class `Archive_URL` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Archive_URL' ) ) {
	/**
	 * Define `Archive_URL` class.
	 */
	class Archive_URL extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'archive-url';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Archive URL', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY ];
		}

		/**
		 * Retrieve the panel template settings.
		 *
		 * @access public
		 *
		 * @return string template url.
		 */
		public function get_panel_template() {
			return ' ({{ url }})';
		}

		/**
		 * @param array $options array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			if ( is_category() || is_tag() || is_tax() ) {
				return get_term_link( get_queried_object() );
			}

			if ( is_author() ) {
				return get_author_posts_url( get_queried_object_id() );
			}

			if ( is_year() ) {
				return get_year_link( get_query_var( 'year' ) );
			}

			if ( is_month() ) {
				return get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
			}

			if ( is_day() ) {
				return get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
			}

			return get_post_type_archive_link( get_post_type() );
		}
	}
}
