<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Classes\Mega_Menu_Frontend_Walker;

/**
 *
 * Crafto widget for Primary Menu
 *
 * @package Crafto
 */

// If class `Primary Menu` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Primary_Menu' ) ) {
	/**
	 * Define `Primary Menu` class.
	 */
	class Primary_Menu extends Widget_Base {
		/**
		 * Retrieve the list of scripts the Mega Menu widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-mega-menu-widget' ];
			}
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-mega-menu';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Primary Menu', 'crafto-addons' );
		}

		/**
		 * Retrieve the Widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-nav-menu crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/primary-menu/';
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
				'nav',
				'navigation',
				'simple',
				'list',
				'menu items',
				'main menu',
				'header menu',
				'site menu',
				'mega menu',
			];
		}

		/**
		 * Register Mega Menu widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_menu_section_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$menus = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore
			$this->add_control(
				'crafto_menu',
				[
					'label'   => esc_html__( 'Select Menu', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ! empty( $menus ) ? array_keys( $menus )[0] : '',
					'options' => $menus, // phpcs:ignore
				]
			);
			$this->add_control(
				'crafto_toggle_icon_text',
				[
					'label'       => esc_html__( 'Toggle Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'crafto_toggle_text_align',
				[
					'label'     => esc_html__( 'Label Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'right',
					'toggle'    => false,
					'options'   => [
						'left'  => [
							'title' => esc_html__( 'Start', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'End', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'condition' => [
						'crafto_toggle_icon_text!' => '',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_menu_section_top_menu_style',
				[
					'label'      => esc_html__( 'First Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_top_menu_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link',
				]
			);
			$this->start_controls_tabs( 'crafto_menu_top_menu_state_tabs' );
			$this->start_controls_tab(
				'crafto_menu_top_menu',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_top_menu_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > .dropdown-toggle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_top_menu_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_menu_top_menu_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_top_menu_text_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li:hover > .nav-link' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li > .nav-link:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_top_menu_icon_color_hover',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link:hover > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link:hover > i'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li:hover > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li:hover > span.nav-link > i'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link:hover > svg, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link:hover > svg'        => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li:hover > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav > li:hover > span.nav-link > svg'        => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_menu_top_menu_active',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_top_menu_text_color_active',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item > a.active'             => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.current-menu-item > a, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.current-menu-item > span.nav-link'             => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.current-menu-ancestor > a, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.current-menu-ancestor > span.nav-link'             => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > a, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > span.nav-link'             => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > a, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > span.nav-link'      => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > a, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > span.nav-link'         => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > a, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > span.nav-link'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown > a.active, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown > sapn.nav-link.active' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_top_menu_icon_color_active',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > span.nav-link > i'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-item > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-item > span.nav-link > i'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-ancestor > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-ancestor > span.nav-link > i'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.active > i'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > span.nav-link > i'           => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > span.nav-link > i'    => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > span.nav-link > i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown > a.active > i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > span.nav-link > svg'        => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-item > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-item > span.nav-link > svg'        => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-ancestor > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav > li.current-menu-ancestor > span.nav-link > svg'        => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.active > svg'        => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > span.nav-link > svg'           => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > span.nav-link > svg'    => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > span.nav-link > svg' => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown > a.active > svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_menu_top_menu_padding',
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
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_top_menu_margin',
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
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_section_icon_top_menu_heading',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_section_icon_top_menu_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 40,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > img, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > img, {{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > svg' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_section_icon_top_menu_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > i, {{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > img, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > img, {{WRAPPER}} .navbar-collapse .navbar-nav > li > a.nav-link > svg, {{WRAPPER}} .navbar-collapse .navbar-nav > li > span.nav-link > svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_section_badges_heading',
				[
					'label'     => esc_html__( 'Badges', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_badges_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .navbar-collapse .navbar-nav li a.nav-link .menu-item-label, {{WRAPPER}} .navbar-collapse .navbar-nav li span.nav-link .menu-item-label',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_badges_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li a.nav-link .menu-item-label, {{WRAPPER}} .navbar-collapse .navbar-nav li span.nav-link .menu-item-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_badges_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li a.nav-link .menu-item-label, {{WRAPPER}} .navbar-collapse .navbar-nav li span.nav-link .menu-item-label' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_badges_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li a.nav-link .menu-item-label, {{WRAPPER}} .navbar-collapse .navbar-nav li span.nav-link .menu-item-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			/** 2nd Level ( Simple Submenu ) */

			$this->start_controls_section(
				'crafto_menu_section_simple_sub_menu_style',
				[
					'label'      => esc_html__( 'Second Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);

			$this->add_responsive_control(
				'crafto_menu_mega_sub_menu_list_size',
				[
					'label'      => esc_html__( 'Sub Menu Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 300,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu' => 'width: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_menu_sub_menu_simple_background',
					'types'    => [
						'classic',
						'gradient',
					],
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown ul.sub-menu',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_menu_sub_menu_simple_border',
					'selector' => '{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown ul.sub-menu',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_simple_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown ul.sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_simple_padding',
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
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown ul.sub-menu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_simple_margin',
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
						'{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown ul.sub-menu' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_menu_sub_menu_simple_shadow',
					'selector' => '{{WRAPPER}} .navbar-collapse .navbar-nav .nav-item.simple-dropdown ul.sub-menu',
				]
			);
			$this->add_control(
				'crafto_menu_mega_sub_menu_list_heading',
				[
					'label'     => esc_html__( 'Items Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_responsive_control(
				'crafto_menu_mega_sub_menu_list_padding',
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
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_heading',
				[
					'label'     => esc_html__( 'Submenu Items', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_sub_menu_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li span.handler',
				]
			);
			$this->start_controls_tabs( 'crafto_menu_sub_menu_state_tabs' );
			$this->start_controls_tab(
				'crafto_menu_sub_menu',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > a' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > span.handler' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > a > i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > a > svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_menu_sub_menu_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_text_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li:hover > a' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li:hover > span.handler' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_icon_color_hover',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li:hover > a i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li:hover > a svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_padding_left',
				[
					'label'      => esc_html__( 'Padding Left', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li:hover > a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li ul li:hover > a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li ul li ul li:hover > a' => 'padding-left: {{SIZE}}{{UNIT}}',
						'.rtl {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li:hover > a, .rtl {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li ul li:hover > a, .rtl {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li ul li ul li:hover > a' => 'padding-inline-start: {{SIZE}}{{UNIT}}; padding-left: 0;',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_menu_sub_menu_active',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_text_color_active',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li.current-menu-item > a' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li.current-menu-ancestor > a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_icon_color_active',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li.current-menu-item > a i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li.current-menu-ancestor > a i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li.current-menu-item > a svg' => 'fill: {{VALUE}};',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li.current-menu-ancestor > a svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_menu_sub_menu_border',
					'selector'  => '{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_padding',
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
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_margin',
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
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_section_icon_sub_menu_size_heading',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_section_icon_sub_menu_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 40,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a svg, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a img' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_sub_menu_size',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a i, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a svg, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_section_icon_sub_menu_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a i, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a svg, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu li a img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_section_sub_menu_third_style',
				[
					'label'      => esc_html__( 'Third Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
				$this->start_controls_tabs( 'crafto_menu_sub_menu_third_state_tabs' );
					$this->start_controls_tab(
						'crafto_menu_sub_menu_third',
						[
							'label' => esc_html__( 'Normal', 'crafto-addons' ),
						]
					);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_third_text_color',
							[
								'label'     => esc_html__( 'Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > span.handler' => 'color: {{VALUE}};',
								],
							]
						);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_third_icon_color',
							[
								'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > a > svg' => 'fill: {{VALUE}};',
								],
							]
						);
					$this->end_controls_tab();
					$this->start_controls_tab(
						'crafto_menu_sub_menu_third_hover',
						[
							'label' => esc_html__( 'Hover', 'crafto-addons' ),
						]
					);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_third_text_color_hover',
							[
								'label'     => esc_html__( 'Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li:hover > a, {{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li:hover > span.handler' => 'color: {{VALUE}};',
								],
							]
						);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_third_icon_color_hover',
							[
								'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li:hover > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li:hover > a > svg' => 'fill: {{VALUE}};',
								],
							]
						);
					$this->end_controls_tab();
					$this->start_controls_tab(
						'crafto_menu_sub_menu_third_active',
						[
							'label' => esc_html__( 'Active', 'crafto-addons' ),
						]
					);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_third_text_color_active',
							[
								'label'     => esc_html__( 'Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-item > a, {{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-item > span.handler' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > a, {{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > span.handler' => 'color: {{VALUE}};',
								],
							]
						);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_third_icon_color_active',
							[
								'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-item > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-item > a > svg' => 'fill: {{VALUE}};',
									'{{WRAPPER}} .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > a > svg' => 'fill: {{VALUE}};',
								],
							]
						);
					$this->end_controls_tab();
				$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_section_sub_menu_fourth_style',
				[
					'label'      => esc_html__( 'Fourth Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
				$this->start_controls_tabs( 'crafto_menu_sub_menu_fourth_state_tabs' );
					$this->start_controls_tab(
						'crafto_menu_sub_menu_fourth',
						[
							'label' => esc_html__( 'Normal', 'crafto-addons' ),
						]
					);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_fourth_text_color',
							[
								'label'     => esc_html__( 'Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li > a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li > span.handler' => 'color: {{VALUE}};',
								],
							]
						);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_fourth_icon_color',
							[
								'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li > a > svg' => 'fill: {{VALUE}};',
								],
							]
						);
					$this->end_controls_tab();
					$this->start_controls_tab(
						'crafto_menu_sub_menu_fourth_hover',
						[
							'label' => esc_html__( 'Hover', 'crafto-addons' ),
						]
					);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_fourth_text_color_hover',
							[
								'label'     => esc_html__( 'Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li:hover > a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li > span.handler' => 'color: {{VALUE}};',
								],
							]
						);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_fourth_icon_color_hover',
							[
								'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li:hover > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li:hover > a > svg' => 'fill: {{VALUE}};',
								],
							]
						);
					$this->end_controls_tab();
					$this->start_controls_tab(
						'crafto_menu_sub_menu_fourth_active',
						[
							'label' => esc_html__( 'Active', 'crafto-addons' ),
						]
					);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_fourth_text_color_active',
							[
								'label'     => esc_html__( 'Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-item > a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-item > span.handler' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > a, {{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > span.handler' => 'color: {{VALUE}};',

								],
							]
						);
						$this->add_responsive_control(
							'crafto_menu_sub_menu_fourth_icon_color_active',
							[
								'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
								'type'      => Controls_Manager::COLOR,
								'selectors' => [
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-item > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > a > i' => 'color: {{VALUE}};',
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-item > a > svg' => 'fill: {{VALUE}};',
									'{{WRAPPER}} .navbar-collapse .navbar-nav li.simple-dropdown ul.sub-menu > li > ul.sub-menu > li > ul.sub-menu > li.current-menu-ancestor > a > svg' => 'fill: {{VALUE}};',

								],
							]
						);
					$this->end_controls_tab();
				$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_section_mobile_style',
				[
					'label' => esc_html__( 'Toggle', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_menu_mobile_toggle_color',
				[
					'label'     => esc_html__( 'Toggle Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .navbar-toggler-line' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_toggle_margin',
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
						'{{WRAPPER}} .navbar-toggler' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_toggle_icon_text_heading',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
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
		}

		/**
		 * Render simple navigation widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$menu_type = '';
			$args      = [];
			$settings  = $this->get_settings_for_display();
			$navbar_id = 'navbarLeftNav_' . uniqid();

			if ( 'themebuilder' === get_post_type( get_the_ID() ) ) {
				$menu_type = get_post_meta( get_the_ID(), '_crafto_template_header_style', true );
			} else {
				$crafto_header_section_id = function_exists( 'crafto_header_section_id' ) ? crafto_header_section_id() : '';
				$menu_type                = get_post_meta( $crafto_header_section_id, '_crafto_template_header_style', true );
			}
			$menu_type   = ( ! empty( $menu_type ) ) ? $menu_type : 'standard';
			$menus_array = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore

			if ( ! isset( $settings['crafto_menu'] ) || 0 === count( $menus_array ) ) {
				return;
			}

			if ( ! $settings['crafto_menu'] ) {
				if ( empty( $menus_array ) ) {
					return;
				} else {
					$menus_array = array_keys( $menus_array );
					$crafto_menu = $menus_array[0];
				}
			} else {
				$crafto_menu = $settings['crafto_menu'];
			}

			$defaults_args = array(
				'menu' => $crafto_menu,
			);

			if ( class_exists( 'CraftoAddons\Classes\Mega_Menu_Frontend_Walker' ) ) {
				$args = apply_filters(
					'crafto_mega_menu_frontend_args',
					array(
						'container'   => 'ul',
						'items_wrap'  => '<ul id="%1$s" class="%2$s alt-font navbar-nav">%3$s</ul>',
						'before'      => '',
						'after'       => '',
						'link_before' => '',
						'link_after'  => '',
						'fallback_cb' => false,
						'walker'      => new Mega_Menu_Frontend_Walker(),
					)
				);
			}

			$args = array_merge( $defaults_args, $args );
			if ( 'left' === $settings['crafto_toggle_text_align'] && isset( $settings['crafto_toggle_icon_text'] ) && ! empty( $settings['crafto_toggle_icon_text'] ) ) {
				echo '<div class="toggle-menu-word alt-font text-' . $settings['crafto_toggle_text_align'] . '">' . esc_html( $settings['crafto_toggle_icon_text'] ) . '</div>'; // phpcs:ignore
			}
			?>
			<button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $navbar_id ); ?>" aria-controls="<?php echo esc_attr( $navbar_id ); ?>" aria-label="<?php echo esc_attr__( 'Toggle navigation', 'crafto-addons' ); ?>" aria-expanded="false">
				<span class="navbar-toggler-line"></span>
				<span class="navbar-toggler-line"></span>
				<span class="navbar-toggler-line"></span>
				<span class="navbar-toggler-line"></span>
			</button>
			<?php
			if ( 'right' === $settings['crafto_toggle_text_align'] && isset( $settings['crafto_toggle_icon_text'] ) && ! empty( $settings['crafto_toggle_icon_text'] ) ) {
				echo '<div class="toggle-menu-word alt-font text-' . esc_attr( $settings['crafto_toggle_text_align'] ) . '">' . esc_html( $settings['crafto_toggle_icon_text'] ) . '</div>'; // phpcs:ignore
			}
			?>
			<div id="<?php echo esc_attr( $navbar_id ); ?>" class="collapse navbar-collapse" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
				<?php wp_nav_menu( $args ); ?>
			</div>
			<?php
		}
	}
}
