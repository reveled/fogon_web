<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Tag as Tag;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for post terms.
 *
 * @package Crafto
 */

// If class `Post_Terms` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Post_Terms' ) ) {
	/**
	 * Define `Post_Terms` class.
	 */
	class Post_Terms extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'post-terms';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Post Terms', 'crafto-addons' );
		}

		/**
		 * Retrieve the group.
		 *
		 * @access public
		 *
		 * @return string group.
		 */
		public function get_group() {
			return 'post';
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
		 * Register post terms controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$taxonomies = get_object_taxonomies(
				get_post_type(),
				'objects',
			);

			$options = [];

			foreach ( $taxonomies as $taxonomy => $object ) {
				$options[ $taxonomy ] = $object->label;
			}

			$this->add_control(
				'taxonomy',
				[
					'label'   => esc_html__( 'Taxonomy', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $options,
					'default' => 'category',
				]
			);

			$this->add_control(
				'separator',
				[
					'label'   => esc_html__( 'Separator', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'default' => ', ',
				]
			);
		}

		/**
		 * Render post terms.
		 *
		 * @access public
		 */
		public function render() {
			$settings = $this->get_settings();

			$value = get_the_term_list( get_the_ID(), $settings['taxonomy'], '', $settings['separator'] );

			echo wp_kses_post( $value );
		}
	}
}
