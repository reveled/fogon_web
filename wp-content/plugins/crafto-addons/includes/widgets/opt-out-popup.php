<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for Prevent Opt Popup.
 *
 * @package Crafto
 */

// If class `Opt_Out_Popup` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Opt_Out_Popup' ) ) {
	/**
	 * Define `Opt_Out_Popup` class.
	 */
	class Opt_Out_Popup extends Widget_Base {
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-prevent-opt-popup';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Opt-out Popup', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-mail crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/opt-out-popup/';
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
				'crafto-header',
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
				'subscribe',
				'newsletter',
				'mail',
				'popup',
				'gdpr',
				'exit intent',
			];
		}

		/**
		 * Register Prevent Opt Popup widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_prevent_text_tab',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_prevent_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_newsletter_prevent_text_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_newsletter_prevent_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .popup-prevent-text',
				]
			);
			$this->add_control(
				'crafto_newsletter_prevent_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .popup-prevent-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_newsletter_prevent_text_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .popup-prevent-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render Prevent Opt Popup widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings             = $this->get_settings_for_display();
			$crafto_prevent_label = ( isset( $settings['crafto_prevent_text'] ) && ! empty( $settings['crafto_prevent_text'] ) ) ? $settings['crafto_prevent_text'] : esc_html__( 'Don\'t show this popup again', 'crafto-addons' );

			$crafto_prevent_checkbox = '<label class="crafto-show-popup popup-prevent-text"><input type="checkbox" class="crafto-promo-show-popup" id="crafto-promo-show-popup">' . esc_html( $crafto_prevent_label ) . '</label>';

			echo sprintf( '%s', $crafto_prevent_checkbox ); // phpcs:ignore
		}
	}
}
