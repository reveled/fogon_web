<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Data_Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for author url.
 *
 * @package Crafto
 */

// If class `Author_URL` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Author_URL' ) ) {
	/**
	 * Define `Author_URL` class.
	 */
	class Author_URL extends Data_Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'author-url';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Author URL', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY ];
		}

		/**
		 * Retrieve the panel template settings.
		 *
		 * @access public
		 *
		 * @return string template key.
		 */
		public function get_panel_template_setting_key() {
			return 'url';
		}

		/**
		 * Register author url controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'url',
				[
					'label'   => esc_html__( 'URL', 'crafto-addons' ),
					'type'    => 'select',
					'default' => 'archive',
					'options' => [
						'archive' => esc_html__( 'Author Archive', 'crafto-addons' ),
						'website' => esc_html__( 'Author Website', 'crafto-addons' ),
					],
				]
			);
		}

		/**
		 * @param array $options array.
		 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
		 */
		public function get_value( array $options = [] ) {
			if ( 'archive' === $this->get_settings( 'url' ) ) {
				global $authordata;

				if ( $authordata ) {
					return get_author_posts_url( $authordata->ID, $authordata->user_nicename );
				}
			}

			return get_the_author_meta( 'url' );
		}
	}
}
