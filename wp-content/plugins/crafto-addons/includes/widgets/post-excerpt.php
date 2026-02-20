<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/**
 * Crafto widget for post excerpt.
 *
 * @package Crafto
 */

// If class `Post_Excerpt` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Excerpt' ) ) {
	/**
	 * Define `Post_Excerpt` class.
	 */
	class Post_Excerpt extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-excerpt';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Excerpt', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-excerpt crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-excerpt/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return array Widget categories.
		 */
		public function get_categories() {
			return [
				'crafto-single',
			];
		}
		/**
		 * Get widget keywords.
		 *
		 * Retrieve the list of keywords the widget belongs to.
		 *
		 * @access public
		 *
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'excerpt',
				'summary',
				'intro',
				'short',
				'content',
				'description',
				'paragraph',
				'details',
			];
		}

		/**
		 * Register post excerpt widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_content_section',
				[
					'label' => esc_html__( 'Excerpt', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'This is dummy content, the original post excerpt are pulled from relevant post.', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post excerpt widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$post_excerpt = \Elementor\Plugin::instance();
			$editor       = $post_excerpt->editor;
			$is_edit_mode = $editor->is_edit_mode();

			if ( ! $is_edit_mode && ! is_preview() && ! is_singular( 'themebuilder' ) ) {
				the_excerpt();
			} else {
				echo 'This is a dummy text to demonstration purposes. It will be replaced with the post content/excerpt. <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi scelerisque luctus velit. Etiam quis quam. Duis viverra diam non justo.';
			}
		}
	}
}
