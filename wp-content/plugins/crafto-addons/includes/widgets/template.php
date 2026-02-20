<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;  // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use CraftoAddons\Classes\Elementor_Templates;

/**
 *
 * Crafto widget for Template.
 *
 * @package Crafto
 */

// If class `Template` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Template' ) ) {
	/**
	 * Define `Template` class.
	 */
	class Template extends Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve Template widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-template';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve Template widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Template', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve Template widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-document-file crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/template/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 *
		 * @return string Widget categories.
		 */
		public function get_categories() {
			return [
				'crafto',
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
				'elementor',
				'template',
				'library',
				'block',
				'page',
			];
		}

		/**
		 * Register Template widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_assistant_general',
				[
					'label' => esc_html__( 'Template', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_item_template_id',
				[
					'label'       => esc_html__( 'Choose Template', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT2,
					'default'     => '0',
					'options'     => Elementor_Templates::get_elementor_templates_options(),
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render Template widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function render() {

			$settings = $this->get_settings_for_display();
			if ( '0' !== $settings['crafto_item_template_id'] ) {
				$template_content = \Crafto_Addons_Extra_Functions::crafto_get_builder_content_for_display( $settings['crafto_item_template_id'] );
				if ( ! empty( $template_content ) ) {
					if ( Plugin::$instance->editor->is_edit_mode() ) {
						$edit_url = add_query_arg(
							array(
								'elementor' => '',
							),
							get_permalink( $settings['crafto_item_template_id'] )
						);
						echo sprintf( '<div class="edit-template-with-light-box elementor-template-edit-cover" data-template-edit-link="%s"><i aria-hidden="true" class="eicon-edit"></i><span>%s</span></div>', esc_url( $edit_url ), esc_html__( 'Edit Template', 'crafto-addons' ) ); // phpcs:ignore.
					}
					echo sprintf( '%s', $template_content ); // phpcs:ignore
				} else {
					echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
				}
			} else {
				echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
			}
		}
	}
}
