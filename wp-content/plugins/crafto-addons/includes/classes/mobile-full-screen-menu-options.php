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

// If class `Mobile_Full_Screen_Menu_Options` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Mobile_Full_Screen_Menu_Options' ) ) {

	/**
	 * Define Mobile_Full_Screen_Menu_Options class
	 */
	class Mobile_Full_Screen_Menu_Options {
		/**
		 * Constructor
		 */
		public function __construct() {

			add_filter( 'elementor/documents/register_controls', [ $this, 'mobile_full_screen_menu_settings' ] );
		}

		/**
		 *  Crafto Full Screen Menu Options.
		 *
		 * @since 1.0
		 * @param object $items Column data.
		 * @access public
		 */
		public function mobile_full_screen_menu_settings( $items ) {
			$items->start_controls_section(
				'document_full_screen_menu_style_section',
				[
					'label' => esc_html__( 'Mobile Full Screen Menu', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);
			$items->add_responsive_control(
				'crafto_full_screen_menu_alignment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'label_block'          => false,
					'options'     => [
						'left'   => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors'   => [
						'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav' => 'text-align: {{VALUE}};',
					],
				]
			);
			$items->add_control(
				'crafto_full_top_menu_heading',
				[
					'label'     => esc_html__( 'Top Menu', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$items->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_full_screen_menu_typography',
					'selector' => 'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav .nav-item .nav-link',
				]
			);

			$items->start_controls_tabs( 'full_screen_menu_tabs' );

				$items->start_controls_tab(
					'crafto_full_screen_menu_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$items->add_responsive_control(
					'crafto_full_screen_menu_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav .nav-item .nav-link,body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav .nav-item .dropdown-toggle' => 'color: {{VALUE}};',
						],
					]
				);

				$items->end_controls_tab();

				$items->start_controls_tab(
					'crafto_full_screen_menu_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$items->add_responsive_control(
					'crafto_full_screen_menu_text_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav .nav-item .nav-link:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$items->end_controls_tab();

				$items->start_controls_tab(
					'crafto_full_screen_menu_active_tab',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);

				$items->add_responsive_control(
					'crafto_full_screen_menu_text_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav .nav-item.current-menu-item .nav-link, body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav .nav-item.current-menu-item .dropdown-toggle' => 'color: {{VALUE}};',
						],
					]
				);
				$items->end_controls_tab();

			$items->end_controls_tabs();
			$items->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_full_screen_menu_border',
					'selector' => 'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav>.nav-item',
				]
			);
			$items->add_control(
				'crafto_full_screen_menu_text_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
					],
					'selectors'  => [
						'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .navbar-nav>.nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$items->add_control(
				'crafto_full_screen_sub_menu_heading',
				[
					'label'     => esc_html__( '2nd Level', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$items->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_full_screen_sub_menu_typography',
					'selector' => 'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item>a',
				]
			);
			$items->start_controls_tabs( 'full_screen_sub_menu_tabs' );

				$items->start_controls_tab(
					'crafto_full_screen_sub_menu_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$items->add_responsive_control(
					'crafto_full_screen_sub_menu_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item>a' => 'color: {{VALUE}};',
						],
					]
				);

				$items->end_controls_tab();

				$items->start_controls_tab(
					'crafto_full_screen_sub_menu_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$items->add_responsive_control(
					'crafto_full_screen_sub_menu_text_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item>a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$items->end_controls_tab();

				$items->start_controls_tab(
					'crafto_full_screen_sub_menu_active_tab',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);

				$items->add_responsive_control(
					'crafto_full_screen_sub_menu_text_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item.current-menu-item>a' => 'color: {{VALUE}};',
						],
					]
				);
				$items->end_controls_tab();

			$items->end_controls_tabs();
			$items->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_full_screen_sub_menu_border',
					'selector' => 'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item.current-menu-item>a',
				]
			);
			$items->add_control(
				'crafto_full_screen_sub_menu_text_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
					],
					'selectors'  => [
						'body[data-mobile-nav-style=full-screen-menu] .navbar-full-screen-menu-inner .nav-item.dropdown.simple-dropdown .dropdown-menu>.menu-item>a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$items->end_controls_section();
		}
	}
}
