<?php
namespace CraftoAddons\Classes;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

/**
 * Full Screen Controls & Features
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Mobile_Modern_Menu_Options` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Mobile_Modern_Menu_Options' ) ) {

	/**
	 * Define Mobile_Modern_Menu_Options class
	 */
	class Mobile_Modern_Menu_Options {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_filter( 'elementor/documents/register_controls', [ $this, 'mobile_modern_menu_settings' ] );
		}

		/**
		 *  Crafto Full Screen Menu Options.
		 *
		 * @since 1.0
		 * @param object $items Column data.
		 * @access public
		 */
		public function mobile_modern_menu_settings( $items ) {
			$items->start_controls_section(
				'crafto_modern_menu_style_section',
				[
					'label' => esc_html__( 'Mobile Modern Menu', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);
			$items->add_control(
				'crafto_modern_top_menu_heading',
				[
					'label' => esc_html__( 'Top Menu', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$items->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_modern_menu_typography',
					'selector' => '[data-mobile-nav-style=modern] .navbar-modern-inner .navbar-nav .nav-item .nav-link',
				]
			);

			$items->start_controls_tabs( 'modern_menu_tabs' );

				$items->start_controls_tab(
					'crafto_modern_menu_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$items->add_control(
					'crafto_modern_menu_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'[data-mobile-nav-style=modern] .navbar-modern-inner .navbar-nav .nav-item .nav-link,[data-mobile-nav-style=modern] .navbar-modern-inner .navbar-nav .nav-item .dropdown-toggle, [data-mobile-nav-style=modern] .navbar-modern-inner .nav-item i' => 'color: {{VALUE}};',
						],
					]
				);

				$items->end_controls_tab();

				$items->start_controls_tab(
					'crafto_modern_menu_active_tab',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);

				$items->add_control(
					'crafto_modern_menu_text_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'[data-mobile-nav-style=modern] .navbar-modern-inner .navbar-nav>.nav-item.current-menu-item>.nav-link,[data-mobile-nav-style=modern] .navbar-modern-inner .navbar-nav>.nav-item.current-menu-ancestor>.nav-link,[data-mobile-nav-style=modern] .navbar-modern-inner .navbar-nav>.nav-item.active .nav-link,[data-mobile-nav-style=modern] .navbar-modern-inner .navbar-nav>.nav-item>a.active, [data-mobile-nav-style=modern] .navbar-modern-inner .navbar-modern-inner .navbar-nav .nav-item.current-menu-item .dropdown-toggle' => 'color: {{VALUE}};',
						],
					]
				);
				$items->end_controls_tab();
			$items->end_controls_tabs();
			$items->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_modern_menu_border',
					'selector' => '[data-mobile-nav-style=modern] .navbar-nav>.nav-item',
				]
			);
			$items->add_responsive_control(
				'crafto_modern_menu_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'[data-mobile-nav-style=modern] .navbar-nav>.nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$items->add_control(
				'crafto_modern_sub_menu_heading',
				[
					'label'     => esc_html__( '2nd Level', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$items->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_modern_sub_menu_typography',
					'selector' => 'body[data-mobile-nav-style=modern] .navbar-modern-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item>a',
				]
			);

			$items->start_controls_tabs( 'modern_sub_menu_tabs' );

				$items->start_controls_tab(
					'crafto_modern_sub_menu_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$items->add_control(
					'crafto_modern_sub_menu_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=modern] .navbar-modern-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item>a' => 'color: {{VALUE}};',
						],
					]
				);

				$items->end_controls_tab();

				$items->start_controls_tab(
					'crafto_modern_sub_menu_active_tab',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);

				$items->add_control(
					'crafto_modern_sub_menu_text_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=modern] .navbar-modern-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item.current-menu-item>a' => 'color: {{VALUE}};',
						],
					]
				);
				$items->end_controls_tab();
			$items->end_controls_tabs();

			$items->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_modern_sub_menu_border',
					'selector' => 'body[data-mobile-nav-style=modern] .navbar-modern-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item',
				]
			);
			$items->add_responsive_control(
				'crafto_modern_sub_menu_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'body[data-mobile-nav-style=modern] .navbar-modern-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$items->add_control(
				'crafto_modern_sub_menu_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.05,
						],
					],
					'default'    => [
						'unit' => 'px',
					],
					'selectors'  => [
						'body[data-mobile-nav-style=modern] .navbar-modern-inner .dropdown-menu.megamenu-content li, [data-mobile-nav-style=modern] .navbar-modern-inner .nav-item.dropdown.simple-dropdown .dropdown-menu .dropdown .dropdown-menu' => 'opacity: {{SIZE}};',
					],
				]
			);
			$items->add_control(
				'crafto_modern_sub_menu_drop_down_icon_heading',
				[
					'label'     => esc_html__( 'Dropdown Menu Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$items->add_responsive_control(
				'craftodrop_down_icon_margin',
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
						'body[data-mobile-nav-style=modern] .navbar-modern-inner .nav-item i.dropdown-toggle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$items->end_controls_section();
		}
	}
}
