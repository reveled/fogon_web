<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

/**
 *
 * Crafto widget for Left Menu Toggle Menu.
 *
 * @package Crafto
 */

// If class `Left_Menu_Toggle` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Left_Menu_Toggle' ) ) {
	/**
	 * Crafto `Left_Menu_Toggle` class.
	 */
	class Left_Menu_Toggle extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-left-menu-toggle';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Left Menu Toggle', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-menu-bar crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/left-menu-toggle/';
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
				'menu',
				'nav',
				'navigation',
				'hamburger',
				'toggle',
			];
		}
		/**
		 * Register Left Menu Toggle widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_hamburger_menu_settings_section',
				[
					'label' => esc_html__( 'Close Icon', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_toggle_icon_text',
				[
					'label'       => esc_html__( 'Toggle Icon with Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Add menu word with toggle icon.', 'crafto-addons' ),
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_left_menu_container_style_section',
				[
					'label'      => esc_html__( 'Toggle Style', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_control(
				'crafto_left_menu_toggle_color',
				[
					'label'     => esc_html__( 'Toggle Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-toggler-line' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_menu_toggle_icon_text_heading',
				[
					'label'     => esc_html__( 'Toggle Icon with Text', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_mobile_toggle_text_typography',
					'selector' => '{{WRAPPER}} .toggle-menu-word',
				]
			);
			$this->add_control(
				'crafto_menu_mobile_toggle_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .toggle-menu-word' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_toggle_text_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .toggle-menu-word' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_left_menu_toggle_close_icon_style_section',
				[
					'label' => esc_html__( 'Close Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->start_controls_tabs( 'crafto_left_menu_toggle_close_icon_tabs_styles' );
				$this->start_controls_tab(
					'crafto_left_menu_toggle_close_icon_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_left_menu_toggle_close_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.navbar-collapse-show {{WRAPPER}} .navbar-toggler-line' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_left_menu_toggle_close_icon_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_left_menu_toggle_close_icon_color_hover',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.navbar-collapse-show {{WRAPPER}} .navbar-toggler:hover .navbar-toggler-line, .navbar-collapse-show {{WRAPPER}} .navbar-toggler:focus .navbar-toggler-line' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render Left menu toggle widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();
			?>
			<!-- Start navbar toggler -->
			<?php
			if ( isset( $settings['crafto_toggle_icon_text'] ) && ! empty( $settings['crafto_toggle_icon_text'] ) ) {
				echo '<div class="toggle-menu-word alt-font">' . esc_html( $settings['crafto_toggle_icon_text'] ) . '</div>';
			}
			?>
			<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarLeftNav" aria-controls="navbarLeftNav" aria-label="<?php echo esc_html__( 'Toggle navigation', 'crafto-addons' ); ?>">
				<span class="navbar-toggler-line"></span>
				<span class="navbar-toggler-line"></span>
				<span class="navbar-toggler-line"></span>
				<span class="navbar-toggler-line"></span>
			</button>
			<!-- End navbar toggler -->
			<?php
		}
	}
}
