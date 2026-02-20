<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;
use CraftoAddons\plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for archive title.
 *
 * @package Crafto
 */

// If class `Archive_Title` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Archive_Title' ) ) {
	/**
	 * Define `Archive_Title` class.
	 */
	class Archive_Title extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'archive-title';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Archive Title', 'crafto-addons' );
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
			return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
		}

		/**
		 * Register archive title controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'include_context',
				[
					'label'   => esc_html__( 'Include Context', 'crafto-addons' ),
					'type'    => 'switcher',
					'default' => 'yes',
				]
			);
		}

		/**
		 * Render archive title.
		 *
		 * @access public
		 */
		public function render() {
			$include_context = 'yes' === $this->get_settings( 'include_context' );

			$page_title = Plugin::get_page_title( $include_context );

			echo wp_kses_post( $page_title );
		}
	}
}
