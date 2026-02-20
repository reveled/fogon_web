<?php
namespace CraftoAddons\Dynamic_Tags;

use Elementor\Core\DynamicTags\Tag;
use CraftoAddons\plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Crafto dynamic tag for page title.
 *
 * @package Crafto
 */

// If class `Page_Title` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Dynamic_Tags\Page_Title' ) ) {
	/**
	 * Define `Page_Title` class.
	 */
	class Page_Title extends Tag {

		/**
		 * Retrieve the name.
		 *
		 * @access public
		 * @return string name.
		 */
		public function get_name() {
			return 'page-title';
		}

		/**
		 * Retrieve the title.
		 *
		 * @access public
		 *
		 * @return string title.
		 */
		public function get_title() {
			return esc_html__( 'Page Title', 'crafto-addons' );
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
		 * Register page title controls.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->add_control(
				'include_context',
				[
					'label' => esc_html__( 'Include Context', 'crafto-addons' ),
					'type'  => 'switcher',
				]
			);

			$this->add_control(
				'show_home_title',
				[
					'label' => esc_html__( 'Show Home Title', 'crafto-addons' ),
					'type'  => 'switcher',
				]
			);
		}

		/**
		 * Render page title.
		 *
		 * @access public
		 */
		public function render() {
			if ( is_home() && 'yes' !== $this->get_settings( 'show_home_title' ) ) {
				return;
			}

			if ( \Elementor\Plugin::$instance->common ) {
				$current_action_data = \Elementor\Plugin::$instance->common->get_component( 'ajax' )->get_current_action_data();

				if ( $current_action_data && 'render_tags' === $current_action_data['action'] ) {
					// Override the global $post for the render.
					query_posts( // phpcs:ignore WordPress.WP.DiscouragedFunctions.query_posts_query_posts
						[
							'p'         => get_the_ID(),
							'post_type' => 'any',
						]
					);
				}
			}

			$include_context = 'yes' === $this->get_settings( 'include_context' );

			$title = Plugin::get_page_title( $include_context );

			echo wp_kses_post( $title );
		}
	}
}
