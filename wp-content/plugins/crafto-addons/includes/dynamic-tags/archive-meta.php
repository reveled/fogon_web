<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for archive meta.
 *
 * @package Crafto
 */

// If class `Archive_Meta` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Archive_Meta' ) ) {
	/**
	 * Define `Archive_Meta` class.
	 */
	class Archive_Meta extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'archive-meta';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Archive Meta', 'crafto-addons' );
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
		 * Retrieve the panel template.
		 *
		 * @access public
		 *
		 * @return string template key.
		 */
		public function get_panel_template() {
			return ' ({{{ key }}})';
		}

		/**
		 * Retrieve the panel template settings.
		 *
		 * @access public
		 *
		 * @return string template key.
		 */
		public function get_panel_template_setting_key() {
			return 'key';
		}

		/**
		 * Register archive meta controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'key',
				[
					'label' => esc_html__( 'Meta Key', 'crafto-addons' ),
				]
			);
		}

		/**
		 * Render archive meta.
		 *
		 * @access public
		 */
		public function render() {
			$key = $this->get_settings( 'key' );

			if ( empty( $key ) ) {
				return;
			}

			$value = '';

			if ( is_category() || is_tax() ) {
				$value = get_term_meta( get_queried_object_id(), $key, true );
			} elseif ( is_author() ) {
				$value = get_user_meta( get_queried_object_id(), $key, true );
			}

			echo wp_kses_post( $value );
		}
	}
}
