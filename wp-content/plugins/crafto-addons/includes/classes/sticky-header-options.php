<?php
/**
 * Sticky Header Controls & Features
 *
 * @package Crafto
 */

namespace CraftoAddons\Classes;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Sticky_Header_Options` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Sticky_Header_Options' ) ) {

	/**
	 * Define Sticky_Header_Options class
	 */
	class Sticky_Header_Options {
		/**
		 * Constructor
		 */
		public function __construct() {
			/** STICKY HEADER hook */
			add_filter( 'elementor/documents/register_controls', [ $this, 'crafto_add_sticky_header_settings' ] );
			/** STICKY MINI HEADER hook */
			add_filter( 'elementor/documents/register_controls', [ $this, 'crafto_add_sticky_mini_header_settings' ] );
		}

		/**
		 *  Crafto Sticky Header Options.
		 *
		 * @since 1.0
		 * @param object $documents Column data.
		 * @access public
		 */
		public function crafto_add_sticky_header_settings( $documents ) {

			$documents->start_controls_section(
				'document_sticky_header_style_section',
				[
					'label' => esc_html__( 'Sticky Header Style', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$documents->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_sticky_header_typography',
					'selector' => '.sticky .header-common-wrapper .navbar-collapse .navbar-nav > li > a.nav-link, .sticky.sticky-active .header-common-wrapper .navbar-collapse .navbar-nav > li > a.nav-link i, .sticky .header-common-wrapper .navbar-collapse .navbar-nav > li > span.nav-link, .sticky.sticky-active .header-common-wrapper .navbar-collapse .navbar-nav > li > span.nav-link i',
				]
			);

			$documents->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_sticky_header_background_color',
					'types'          => [
						'classic',
						'gradient',
					],
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'color' => [
							'responsive' => true,
						],
					],
					'selector'       => 'header.sticky.sticky-active .header-common-wrapper > .elementor > .elementor-element, header.sticky.sticky-active .header-reverse .header-common-wrapper > .elementor > .elementor-element, header.sticky.sticky-active .header-reverse.glass-effect, header.sticky .reverse-back-scroll.glass-effect, header.sticky.sticky-active .always-fixed.glass-effect, header.sticky.sticky-active .responsive-sticky.glass-effect',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_header_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'header.sticky.sticky-active .header-common-wrapper > .elementor > .elementor-element' => 'border-bottom-style: solid; border-bottom-color: {{VALUE}};',
					],
					'separator' => 'before',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_header_border_width',
				[
					'label'     => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors' => [
						'header.sticky.sticky-active .header-common-wrapper > .elementor > .elementor-element' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_sticky_header_box_shadow',
					'selector' => 'header.sticky.sticky-active .header-common-wrapper',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_header_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-nav > li > a' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li > a.nav-link, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li > span.nav-link' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li .dropdown-toggle' => 'color: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_text_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav li:hover .nav-link'        => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav li .nav-link:hover'        => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li > a.nav-link:hover, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li > span.nav-link:hover' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu:hover > a' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown:hover > a' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu:hover > a.nav-link > i, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu:hover > span.nav-link > i' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown:hover > li .dropdown-toggle'  => 'color: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_active_tab',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_text_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li > a.nav-link.active, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li > span.nav-link.active' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item > a.active'             => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.current-menu-item > a, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.current-menu-item > span.nav-link'             => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.current-menu-ancestor > a, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.current-menu-ancestor > span.nav-link'             => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li.current-menu-item > a.nav-link, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li.current-menu-item > span.nav-link' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li.current-menu-ancestor > a.nav-link, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav > li.current-menu-ancestor > span.nav-link' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > a, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item > span.nav-link'             => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > a, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item > span.nav-link'      => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > a, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-ancestor > span.nav-link'         => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > a, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor > span.nav-link'  => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item  > a.nav-link > i, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.megamenu.current-menu-item  > span.nav-link > i'           => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item  > a.nav-link > i, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-item  > span.nav-link > i'    => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor  > a.nav-link > i, .sticky.sticky-active .header-common-wrapper.standard .navbar-collapse .navbar-nav .nav-item.simple-dropdown.current-menu-ancestor  > span.nav-link > i' => 'color: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();

			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_header_site_logo_heading',
				[
					'label'     => esc_html__( 'Site Logo Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_header_site_logo_padding',
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
						'header.sticky .header-common-wrapper .elementor-widget-crafto-site-logo .navbar-brand' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$documents->add_control(
				'crafto_sticky_header_hamburger_icon_heading',
				[
					'label'     => esc_html__( 'Hamburger Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_hamburger_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_header_hamburger_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_hamburger_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .navbar-toggler .navbar-toggler-line' => 'background-color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .push-button .toggle-menu-inner > span' => 'background-color: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_hamburger_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_hamburger_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .push-button:hover .toggle-menu-inner > span' => 'background-color: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();
			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_header_search_icon_heading',
				[
					'label'     => esc_html__( 'Search Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$documents->add_responsive_control(
				'crafto_sticky_header_search_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'.sticky.sticky-active .header-common-wrapper .search-form-icon .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_search_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_header_search_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_search_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-default .elementor-icon i:before, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-stacked .elementor-icon i, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-framed .elementor-icon i' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-default .elementor-icon svg, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-stacked .elementor-icon svg, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-framed .elementor-icon svg'  => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_search_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'header.sticky.sticky-active .header-common-wrapper .search-form-wrapper .search-form-icon .icon-text' => 'color: {{VALUE}} !important;',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_search_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_search_icon_hover_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-default:hover .elementor-icon i:before, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-stacked:hover .elementor-icon i, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-framed:hover .elementor-icon i' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-default:hover .elementor-icon svg, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-stacked:hover .elementor-icon svg, .sticky.sticky-active .header-common-wrapper .elementor-element:not(.verticalbar-wrap) .elementor-view-framed:hover .elementor-icon svg'  => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_search_text_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'body header.sticky.sticky-active .header-common-wrapper .search-form-wrapper .search-form-icon:hover .icon-text' => 'color: {{VALUE}} !important;',
						],
					]
				);
				$documents->end_controls_tab();
			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_header_mini_cart_icon_heading',
				[
					'label'     => esc_html__( 'Mini cart Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_header_mini_cart_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'.sticky.sticky-active .header-common-wrapper .cart-top-counter, header.sticky.sticky-active .widget_shopping_cart_content .crafto-top-cart-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
						'header.sticky.sticky-active .widget_shopping_cart_content .crafto-top-cart-wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_mini_cart_icon_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_header_mini_cart_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_mini_cart_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .top-cart-wrapper .cart-icon, header.sticky.sticky-active .elementor-widget-crafto-woocommerce-mini-cart .widget_shopping_cart_content .crafto-top-cart-wrapper i:before' => 'color: {{VALUE}};',
							'header.sticky.sticky-active .elementor-widget-crafto-woocommerce-mini-cart .widget_shopping_cart_content .crafto-top-cart-wrapper svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_mini_cart_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_mini_cart_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .top-cart-wrapper:hover .cart-icon, header.sticky.sticky-active .elementor-widget-crafto-woocommerce-mini-cart:hover .widget_shopping_cart_content .crafto-top-cart-wrapper i:before' => 'color: {{VALUE}};',
							'header.sticky.sticky-active .elementor-widget-crafto-woocommerce-mini-cart:hover .widget_shopping_cart_content .crafto-top-cart-wrapper svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();
			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_header_social_icon_heading',
				[
					'label'     => esc_html__( 'Social Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_header_social_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'.sticky.sticky-active .header-common-wrapper.standard .social-icons-wrapper ul li a.elementor-social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_social_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_header_social_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_social_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .social-icons-wrapper ul li a.elementor-social-icon i' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .social-icons-wrapper ul li a.elementor-social-icon svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_social_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_social_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .social-icons-wrapper ul li a.elementor-social-icon:hover i' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .social-icons-wrapper ul li a.elementor-social-icon:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();

			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_header_icon_box_heading',
				[
					'label'     => esc_html__( 'Icon Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_icon_box_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_header_icon_box_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box .elementor-icon i:before' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box .elementor-icon svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_icon_box_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_icon_box_hover_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box:hover .elementor-icon i:before' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box:hover .elementor-icon svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();

			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_header_general_heading',
				[
					'label'     => esc_html__( 'General style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_general_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_header_general_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_general_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box .elementor-icon-box-title a, .sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box .elementor-icon-box-title, .sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box .elementor-icon-box-description, .sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box .elementor-icon-box-description a, .sticky.sticky-active .header-common-wrapper.standard .crafto-primary-title, .sticky.sticky-active .header-common-wrapper.standard .crafto-primary-title a, .sticky.sticky-active .header-common-wrapper.standard .text-editor-content, .sticky.sticky-active .header-common-wrapper.standard .text-editor-content a' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box .elementor-icon svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_general_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_general_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box:hover .elementor-icon-box-title a, .sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box:hover .elementor-icon-box-description, .sticky.sticky-active .header-common-wrapper.standard .elementor-element:not(.verticalbar-wrap) .elementor-widget-crafto-icon-box:hover .elementor-icon-box-description a, .sticky.sticky-active .header-common-wrapper.standard .crafto-primary-title a:hover, .sticky.sticky-active .header-common-wrapper.standard .text-editor-content a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();
			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_header_button_heading',
				[
					'label'     => esc_html__( 'Button style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_sticky_header_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '.sticky.sticky-active .header-common-wrapper.standard a.elementor-button, .sticky .header-common-wrapper.standard .elementor-button',
				]
			);

			$documents->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_sticky_header_button_text_shadow',
					'selector' => '.sticky.sticky-active .header-common-wrapper.standard a.elementor-button, .sticky .header-common-wrapper.standard .elementor-button',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_header_tabs_button_style' );

				$documents->start_controls_tab(
					'crafto_sticky_header_tab_button_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_control(
					'crafto_sticky_header_button_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button .elementor-button-content-wrapper, .sticky .header-common-wrapper.standard .elementor-button' => 'color: {{VALUE}};',
						],
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_header_button_svg_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button .elementor-button-content-wrapper i, .sticky .header-common-wrapper.standard .elementor-button i' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button .elementor-button-content-wrapper svg, .sticky .header-common-wrapper.standard .elementor-button .elementor-button-content-wrapper svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'     => 'crafto_sticky_header_button_background_color',
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
						'selector' => '.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:not(.hvr-btn-expand-ltr), .sticky.sticky-active .header-common-wrapper.standard a.elementor-button.btn-custom-effect:before, .sticky.sticky-active .header-common-wrapper.standard a.elementor-button.hvr-btn-expand-ltr:before',
					]
				);

				$documents->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'           => 'crafto_sticky_header_button_box_shadow',
						'selector'       => '.sticky.sticky-active .header-common-wrapper.standard .elementor-button',
						'fields_options' => [
							'box_shadow' => [
								'responsive' => true,
							],
						],
					]
				);

				$documents->add_control(
					'crafto_sticky_header_button_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [
							'px',
							'%',
						],
						'selectors'  => [
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:not(.btn-custom-effect), .sticky.sticky-active .header-common-wrapper.standard a.elementor-button.btn-custom-effect:not(.hvr-btn-expand-ltr), .sticky.sticky-active .header-common-wrapper.standard a.elementor-button.hvr-btn-expand-ltr:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_header_tab_button_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_control(
					'crafto_sticky_header_button_text_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:hover .elementor-button-content-wrapper, .sticky.sticky-active .header-common-wrapper.standard .elementor-button:hover .elementor-button-content-wrapper, .sticky.sticky-active .header-common-wrapper.standard a.elementor-button:focus .elementor-button-content-wrapper, .sticky.sticky-active .header-common-wrapper.standard .elementor-button:focus .elementor-button-content-wrapper' => 'color: {{VALUE}};',
						],
					]
				);
				$documents->add_control(
					'crafto_button_hover_svg_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:hover .elementor-button-content-wrapper i, .sticky .header-common-wrapper.standard .elementor-button:hover i' => 'color: {{VALUE}};',
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:hover .elementor-button-content-wrapper svg, .sticky .header-common-wrapper.standard .elementor-button:hover .elementor-button-content-wrapper svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'     => 'crafto_sticky_header_button_background_hover_color',
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
						'selector' => '.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:not(.hvr-btn-expand-ltr):hover, .sticky.sticky-active .header-common-wrapper.standard a.elementor-button.btn-custom-effect:not(.hvr-btn-expand-ltr):hover:before',
					]
				);

				$documents->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'     => 'crafto_sticky_header_button_hover_box_shadow',
						'selector' => '.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:hover, .sticky.sticky-active .header-common-wrapper.standard .elementor-button:hover, .sticky.sticky-active .header-common-wrapper.standard a.elementor-button:focus, .sticky.sticky-active .header-common-wrapper.standard .elementor-button:focus',
					]
				);

				$documents->add_control(
					'crafto_sticky_header_button_hover_border_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:hover, .sticky.sticky-active .header-common-wrapper.standard .elementor-button:hover, .sticky.sticky-active .header-common-wrapper.standard a.elementor-button:focus, .sticky.sticky-active .header-common-wrapper.standard .elementor-button:focus' => 'border-color: {{VALUE}};',
						],
					]
				);
				$documents->add_control(
					'crafto_sticky_header_button_hover_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [
							'px',
							'%',
						],
						'selectors'  => [
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button:hover, .sticky.sticky-active .header-common-wrapper.standard .elementor-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$documents->end_controls_tab();
				$documents->end_controls_tabs();

				$documents->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'           => 'crafto_sticky_header_button_border',
						'selector'       => '.sticky.sticky-active .header-common-wrapper.standard .elementor-button',
						'fields_options' => [
							'border' => [
								'separator' => 'before',
							],
						],
					]
				);
				$documents->add_control(
					'crafto_sticky_header_button_text_padding',
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
							'.sticky.sticky-active .header-common-wrapper.standard a.elementor-button, .sticky.sticky-active .header-common-wrapper.standard .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
			$documents->end_controls_section();
		}
		/**
		 *  Crafto Mini Header Options.
		 *
		 * @since 1.0
		 * @param object $documents Column data.
		 * @access public
		 */
		public function crafto_add_sticky_mini_header_settings( $documents ) {

			$documents->start_controls_section(
				'document_sticky_mini_header_style_section',
				[
					'label' => esc_html__( 'Sticky Top Bar Style', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$documents->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_sticky_mini_header_typography',
					'selector' => '.sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-primary-title, .sticky .mini-header-main-wrapper .elementor-widget-crafto-text-editor .text-editor-content, .sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-primary-title a',
				]
			);

			$documents->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_sticky_mini_header_background_color',
					'types'          => [
						'classic',
						'gradient',
					],
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'color' => [
							'responsive' => true,
						],
					],
					'selector'       => 'header.sticky .mini-header-main-wrapper > .elementor > .elementor-element, header.sticky .header-reverse .mini-header-main-wrapper > .elementor > .elementor-element',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_mini_header_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'header.sticky .mini-header-main-wrapper > .elementor > .elementor-element' => 'border-bottom-style: solid; border-bottom-color: {{VALUE}};',
					],
					'separator' => 'before',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_mini_header_border_width',
				[
					'label'     => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors' => [
						'header.sticky .mini-header-main-wrapper > .elementor > .elementor-element' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->add_control(
				'crafto_sticky_mini_header_hamburger_icon_heading',
				[
					'label'     => esc_html__( 'Hamburger Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_mini_header_hamburger_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_hamburger_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_hamburger_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .navbar-toggler .navbar-toggler-line' => 'background-color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .push-button .toggle-menu-inner > span' => 'background-color: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_hamburger_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_hamburger_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .push-button:hover .toggle-menu-inner > span' => 'background-color: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_mini_header_search_icon_heading',
				[
					'label'     => esc_html__( 'Search Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$documents->add_responsive_control(
				'crafto_sticky_mini_header_search_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'.sticky .mini-header-main-wrapper .search-form-icon .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_mini_header_search_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_search_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_search_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .elementor-view-default .elementor-icon i:before, .sticky .mini-header-main-wrapper .elementor-view-stacked .elementor-icon i, .sticky .mini-header-main-wrapper .elementor-view-framed .elementor-icon i' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-view-default .elementor-icon svg, .sticky .mini-header-main-wrapper .elementor-view-stacked .elementor-icon svg, .sticky .mini-header-main-wrapper .elementor-view-framed .elementor-icon svg'  => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_search_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .search-form-wrapper .search-form-icon .icon-text' => 'color: {{VALUE}} !important;',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_search_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_search_icon_hover_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .elementor-view-default:hover .elementor-icon i:before, .sticky .mini-header-main-wrapper .elementor-view-stacked:hover .elementor-icon i, .sticky .mini-header-main-wrapper .elementor-view-framed:hover .elementor-icon i' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-view-default:hover .elementor-icon svg, .sticky .mini-header-main-wrapper .elementor-view-stacked:hover .elementor-icon svg, .sticky .mini-header-main-wrapper .elementor-view-framed:hover .elementor-icon svg'  => 'fill: {{VALUE}};',
						],
					]
				);
				$documents->add_responsive_control(
					'crafto_sticky_mini_header_search_text_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .search-form-wrapper .search-form-icon:hover .icon-text' => 'color: {{VALUE}} !important;',
						],
					]
				);
				$documents->end_controls_tab();

			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_mini_header_mini_cart_icon_heading',
				[
					'label'     => esc_html__( 'Mini Cart Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_mini_header_mini_cart_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'.sticky .mini-header-main-wrapper .cart-top-counter, header.sticky .mini-header-main-wrapper .widget_shopping_cart_content .crafto-top-cart-wrapper i' => 'font-size: {{SIZE}}{{UNIT}};',
						'.sticky. .mini-header-main-wrapper .widget_shopping_cart_content .crafto-top-cart-wrapper svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_mini_header_mini_cart_icon_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_mini_cart_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_mini_cart_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .top-cart-wrapper .cart-icon, .sticky .mini-header-main-wrapper .elementor-widget-crafto-woocommerce-mini-cart .widget_shopping_cart_content .crafto-top-cart-wrapper i:before' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-woocommerce-mini-cart .widget_shopping_cart_content .crafto-top-cart-wrapper svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_mini_cart_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_mini_cart_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .top-cart-wrapper:hover .cart-icon, header.sticky .mini-header-main-wrapper .elementor-widget-crafto-woocommerce-mini-cart:hover .widget_shopping_cart_content .crafto-top-cart-wrapper i:before' => 'color: {{VALUE}};',
							'header.sticky .mini-header-main-wrapper .elementor-widget-crafto-woocommerce-mini-cart:hover .widget_shopping_cart_content .crafto-top-cart-wrapper svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();

			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_mini_header_social_icon_heading',
				[
					'label'     => esc_html__( 'Social Icon Style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->add_responsive_control(
				'crafto_sticky_mini_header_social_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'.sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon, .sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon .social-icon-text' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_mini_header_social_icon_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_social_icon_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_social_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon i, .sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon .social-icon-text' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_social_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_social_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon:hover i, .sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon:hover .social-icon-text' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .social-icons-wrapper ul li a.elementor-social-icon:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();
			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_mini_header_general_heading',
				[
					'label'     => esc_html__( 'General style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_mini_header_general_tabs' );

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_general_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_general_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-primary-title, .sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-primary-title a' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-secondary-title, .sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-secondary-title a' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .text-editor-content' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-title, .sticky .mini-header-main-wrapper .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-title a' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-icon-box.elementor-view-default .elementor-icon' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-icon-box .elementor-icon-box-content .elementor-icon-box-title, .sticky .mini-header-main-wrapper .elementor-widget-crafto-icon-box .elementor-icon-box-content .elementor-icon-box-title a' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-icon-box.elementor-view-default .elementor-icon' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-icon .elementor-icon' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .crafto-heading.no-shadow-animation .crafto-primary-title .separator' => 'border-color: {{VALUE}};',
						],
					]
				);

				$documents->end_controls_tab();

				$documents->start_controls_tab(
					'crafto_sticky_mini_header_general_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$documents->add_responsive_control(
					'crafto_sticky_mini_header_general_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-primary-title a:hover' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-heading .crafto-secondary-title a:hover' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .text-editor-content a:hover' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .crafto-primary-title a:hover' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-title a:hover' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .elementor-widget-crafto-icon-box .elementor-icon-box-content .elementor-icon-box-title a:hover' => 'color: {{VALUE}};',
							'.sticky .mini-header-main-wrapper .crafto-heading.no-shadow-animation .crafto-primary-title a:hover .separator' => 'border-color: {{VALUE}};',
						],
					]
				);
				$documents->end_controls_tab();
			$documents->end_controls_tabs();

			$documents->add_control(
				'crafto_sticky_mini_header_button_heading',
				[
					'label'     => esc_html__( 'Button style', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$documents->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_sticky_mini_header_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '.sticky .mini-header-main-wrapper a.elementor-button, .sticky .mini-header-main-wrapper .elementor-button',
				]
			);

			$documents->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_sticky_mini_header_button_text_shadow',
					'selector' => '.sticky .mini-header-main-wrapper a.elementor-button, .sticky .mini-header-main-wrapper .elementor-button',
				]
			);

			$documents->start_controls_tabs( 'crafto_sticky_mini_header_tabs_button_style' );

			$documents->start_controls_tab(
				'crafto_sticky_mini_header_tab_button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);

			$documents->add_control(
				'crafto_sticky_mini_header_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'.sticky .mini-header-main-wrapper a.elementor-button, .sticky .mini-header-main-wrapper .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
					],
				]
			);

			$documents->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_sticky_mini_header_button_background_color',
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
					'selector' => '.sticky .mini-header-main-wrapper a.elementor-button:not(.hvr-btn-expand-ltr), .sticky .mini-header-main-wrapper a.elementor-button.btn-custom-effect:before, .sticky .mini-header-main-wrapper a.elementor-button.hvr-btn-expand-ltr:before',
				]
			);

			$documents->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'           => 'crafto_sticky_mini_header_button_box_shadow',
					'selector'       => '.sticky .mini-header-main-wrapper .elementor-button',
					'fields_options' => [
						'box_shadow' => [
							'responsive' => true,
						],
					],
				]
			);

			$documents->add_control(
				'crafto_sticky_mini_header_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
					],
					'selectors'  => [
						'.sticky .mini-header-main-wrapper a.elementor-button:not(.btn-custom-effect), .sticky .mini-header-main-wrapper a.elementor-button.btn-custom-effect:not(.hvr-btn-expand-ltr), .sticky .mini-header-main-wrapper a.elementor-button.hvr-btn-expand-ltr:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$documents->end_controls_tab();

			$documents->start_controls_tab(
				'crafto_sticky_mini_header_tab_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);

			$documents->add_control(
				'crafto_sticky_mini_header_button_text_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'.sticky .mini-header-main-wrapper a.elementor-button:hover, .sticky .mini-header-main-wrapper .elementor-button:hover, .sticky .mini-header-main-wrapper a.elementor-button:focus, .sticky .mini-header-main-wrapper .elementor-button:focus' => 'color: {{VALUE}};',
						'.sticky .mini-header-main-wrapper a.elementor-button:hover svg, .sticky .mini-header-main-wrapper .elementor-button:hover svg, .sticky .mini-header-main-wrapper a.elementor-button:focus svg, .sticky .mini-header-main-wrapper .elementor-button:focus svg' => 'fill: {{VALUE}};',
					],
				]
			);

			$documents->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_sticky_mini_header_button_background_hover_color',
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
					'selector' => '.sticky .mini-header-main-wrapper a.elementor-button:not(.hvr-btn-expand-ltr):hover, .sticky .mini-header-main-wrapper a.elementor-button.btn-custom-effect:not(.hvr-btn-expand-ltr):hover:before',
				]
			);

			$documents->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_sticky_mini_header_button_hover_box_shadow',
					'selector' => '.sticky .mini-header-main-wrapper a.elementor-button:hover, .sticky .mini-header-main-wrapper .elementor-button:hover, .sticky .mini-header-main-wrapper a.elementor-button:focus, .sticky .mini-header-main-wrapper .elementor-button:focus',
				]
			);

			$documents->add_control(
				'crafto_sticky_mini_header_button_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'.sticky .mini-header-main-wrapper a.elementor-button:hover, .sticky .mini-header-main-wrapper .elementor-button:hover, .sticky .mini-header-main-wrapper a.elementor-button:focus, .sticky .mini-header-main-wrapper .elementor-button:focus' => 'border-color: {{VALUE}};',
					],
				]
			);
			$documents->add_control(
				'crafto_sticky_mini_header_button_hover_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
					],
					'selectors'  => [
						'.sticky .mini-header-main-wrapper a.elementor-button:hover, .sticky .mini-header-main-wrapper .elementor-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$documents->end_controls_tab();
			$documents->end_controls_tabs();

			$documents->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_sticky_mini_header_button_border',
					'selector'       => '.sticky .mini-header-main-wrapper .elementor-button',
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
					],
				]
			);
			$documents->add_control(
				'crafto_sticky_mini_header_button_text_padding',
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
						'.sticky .mini-header-main-wrapper a.elementor-button, .sticky .mini-header-main-wrapper .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$documents->end_controls_section();
		}
	}
}
