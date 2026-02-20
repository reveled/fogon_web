<?php
/**
 * Page Options Controls & Features
 *
 * @package Crafto
 */

namespace CraftoAddons\Classes;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Sticky_Footer_Options` doesn't exist yet.
if ( ! class_exists( 'CraftoAddons\Classes\Sticky_Footer_Options' ) ) {

	/**
	 * Define Sticky_Footer_Options class
	 */
	class Sticky_Footer_Options {
		/**
		 * Constructor
		 */
		public function __construct() {
			/** Page options hook */
			add_filter( 'elementor/documents/register_controls', [ $this, 'crafto_add_sticky_footer_settings' ] );
			add_filter( 'body_class', [ $this, 'add_or_remove_body_class' ] ); // Add or remove class.
		}

		/**
		 * Crafto Page Options.
		 *
		 * @since 1.0
		 * @param object $documents Column data.
		 * @access public
		 */
		public function crafto_add_sticky_footer_settings( $documents ) {

			$documents->start_controls_section(
				'document_sticky_page_options_style_section',
				[
					'label' => esc_html__( 'Page Options', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$documents->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_sticky_page_options_background_color',
					'types'    => [
						'classic',
						'gradient',
					],
					'selector' => 'div.crafto-main-content-wrap',
				]
			);
			$documents->add_responsive_control(
				'crafto_sticky_page_options_overflows_settings',
				[
					'label'     => esc_html__( 'Overflow', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''        => esc_html__( 'Default', 'crafto-addons' ),
						'hidden'  => esc_html__( 'Hidden', 'crafto-addons' ),
						'visible' => esc_html__( 'Visible', 'crafto-addons' ),
						'none'    => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'html' => 'overflow-x: {{VALUE}}',
						'body' => 'overflow-x: {{VALUE}}',
					],
				]
			);
			$documents->add_control(
				'crafto_enable_adaptive_bg_color',
				[
					'label'        => esc_html__( 'Enable Adaptive Background Color', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$documents->end_controls_section();
		}

		/**
		 * Add or Remove class based on the Adaptive Background setting.
		 *
		 * @param array $classes The existing body classes.
		 * @return array Modified body classes.
		 */
		public function add_or_remove_body_class( $classes ) {
			$page_id = get_the_ID();

			if ( $page_id ) {
				// Get the current document object.
				$current_doc = \Elementor\Plugin::instance()->documents->get( $page_id );

				// Early return if no document is found.
				if ( ! $current_doc ) {
					return $classes;
				}

				// Retrieve the specific setting value.
				$adaptive_background = $current_doc->get_settings( 'crafto_enable_adaptive_bg_color' );

				// Check if the adaptive background setting is enabled and modify the body classes accordingly.
				if ( 'yes' === $adaptive_background ) {
					$classes[] = 'adaptive-bg-color-enabled'; // Add the class.
				} else {
					// If the option is off, make sure the class is not present.
					$classes = array_diff( $classes, [ 'adaptive-bg-color-enabled' ] ); // Remove the class if it exists.
				}
			}

			return $classes;
		}
	}
}
