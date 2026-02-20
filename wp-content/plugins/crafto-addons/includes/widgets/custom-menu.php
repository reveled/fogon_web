<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use CraftoAddons\Classes\Menu_List_Frontend_Walker;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for Custom Menu
 *
 * @package Crafto
 */

// If class `Custom Menu` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Custom_Menu' ) ) {
	/**
	 * Define `Primary Menu` class.
	 */
	class Custom_Menu extends Widget_Base {
		/**
		 * Retrieve the list of scripts the Custom Menu widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'sticky-kit' ) ) {
					$scripts[] = 'sticky-kit';
				}
				$scripts[] = 'crafto-simple-menu-widget';
			}
			return $scripts;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-custom-menu';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Custom Menu', 'crafto-addons' );
		}

		/**
		 * Retrieve the Widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-menu-toggle crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/custom-menu/';
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
				'list',
				'menu items',
				'nav menu',
				'custom navigation',
			];
		}

		/**
		 * Register Custom Menu widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_custom_menu_section_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_custom_menu_source',
				[
					'label'   => esc_html__( 'Data Source', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'wp_menus',
					'options' => [
						'wp_menus' => esc_html__( 'WP Menus', 'crafto-addons' ),
						'custom'   => esc_html__( 'Custom', 'crafto-addons' ),
					],
				]
			);
			$menus = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore
			$this->add_control(
				'crafto_custom_menu',
				[
					'label'     => esc_html__( 'Select Menu', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => ! empty( $menus ) ? array_keys( $menus )[0] : '',
					'options'   => $menus, // phpcs:ignore
					'condition' => [
						'crafto_custom_menu_source' => 'wp_menus',
					],
				]
			);
			$this->add_control(
				'crafto_custom_menu_heading',
				[
					'label'     => esc_html__( 'Custom Menu Items', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_custom_menu_source' => 'custom',
					],
					'separator' => 'before',
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'crafto_custom_menu_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Item', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_custom_menu_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => '#',
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_custom_menu_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
				]
			);

			$repeater->add_control(
				'crafto_custom_menu_icon_alignment',
				[
					'label'   => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'left-icon'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'right-icon' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default' => 'left-icon',
					'toggle'  => false,
				]
			);
			$repeater->add_control(
				'crafto_custom_menu_badge',
				[
					'label'       => esc_html__( 'Badge', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'crafto_custom_menu_badge_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .menu-badge' => 'color: {{VALUE}};',
					],
				]
			);

			$repeater->add_control(
				'crafto_custom_menu_badge_bg_color',
				[
					'label'     => esc_html__( 'Background color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .menu-badge:before' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_custom_menu_items',
				[
					'label'       => esc_html__( 'Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'show_label'  => false,
					'default'     => [
						[
							'crafto_custom_menu_label' => esc_html__( 'Item 1', 'crafto-addons' ),
						],
						[
							'crafto_custom_menu_label' => esc_html__( 'Item 2', 'crafto-addons' ),
						],
						[
							'crafto_custom_menu_label' => esc_html__( 'Item 3', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_custom_menu_label }}}',
					'condition'   => [
						'crafto_custom_menu_source' => 'custom',
					],
				]
			);
			$this->add_control(
				'crafto_custom_menu_view',
				[
					'label'   => esc_html__( 'Layout', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'default' => 'traditional',
					'options' => [
						'traditional' => [
							'title' => esc_html__( 'Default', 'crafto-addons' ),
							'icon'  => 'eicon-editor-list-ul',
						],
						'inline'      => [
							'title' => esc_html__( 'Inline', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-h',
						],
					],
				]
			);
			$this->add_control(
				'crafto_custom_menu_separator_line',
				[
					'label'        => esc_html__( 'Enable Separator Line', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_custom_menu_view' => 'traditional',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_custom_menu_style_section',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_custom_menu_items_text_alignment',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-link, {{WRAPPER}} .crafto-custom-menu-wrapper' => 'justify-content: {{VALUE}};',
					],
					'condition' => [
						'crafto_custom_menu_view' => 'inline',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_custom_menu_list_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} ul.crafto-custom-menu-wrapper li a, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a',
				]
			);

			$this->start_controls_tabs( 'crafto_custom_menu_list_colors' );
				$this->start_controls_tab(
					'crafto_custom_menu_list_colors_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_custom_menu_list_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a' => 'color: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_custom_menu_list_colors_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_custom_menu_list_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a:hover, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a:hover, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a:hover, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_custom_menu_hvr_effect',
					[
						'label'        => esc_html__( 'Slide On Hover', 'crafto-addons' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
						'label_off'    => esc_html__( 'No', 'crafto-addons' ),
						'return_value' => 'yes',
						'default'      => '',
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_custom_menu_list_padding',
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
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_control(
				'crafto_custom_menu_separator_line_heading',
				[
					'label'     => esc_html__( 'Separator Line', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_custom_menu_separator_line' => 'yes',
						'crafto_custom_menu_view' => 'traditional',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_custom_menu_separator_line_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li, {{WRAPPER}} .crafto-wp-menus-wrapper ul li, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_custom_menu_separator_line' => 'yes',
						'crafto_custom_menu_view' => 'traditional',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_custom_menu_separator_line_thickness',
				[
					'label'     => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li, {{WRAPPER}} .crafto-wp-menus-wrapper ul li, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_custom_menu_separator_line' => 'yes',
						'crafto_custom_menu_view' => 'traditional',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_custom_menu_style_badges',
				[
					'label'      => esc_html__( 'Badges', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_custom_menu_badges_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label',
				]
			);
			$this->add_responsive_control(
				'crafto_custom_menu_badges_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_custom_menu_source' => 'wp_menus',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_custom_menu_badges_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_custom_menu_source' => 'wp_menus',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_custom_menu_badges_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-badge, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a .menu-item-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_custom_menu_display',
				[
					'label'     => esc_html__( 'Display', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''             => esc_html__( 'Default', 'crafto-addons' ),
						'block'        => esc_html__( 'Block', 'crafto-addons' ),
						'inline-block' => esc_html__( 'Inline Block', 'crafto-addons' ),
						'none'         => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-custom-menu-wrapper li a .menu-badge' => 'display: {{VALUE}}',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_custom_menu_style_icon',
				[
					'label'      => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);

			$this->add_responsive_control(
				'crafto_custom_menu_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 40,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon svg, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a img, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a img' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_custom_menu_icon_width',
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
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i, {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon svg, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg, {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon img, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a img, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon img, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_custom_menu_icon_colors' );
				$this->start_controls_tab(
					'crafto_custom_menu_icon_colors_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_custom_menu_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i' => 'color: {{VALUE}};',
							'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon > svg, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon > svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_custom_menu_icon_colors_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_custom_menu_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a:hover .menu-icon i, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a:hover i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a:hover .menu-icon i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a:hover i' => 'color: {{VALUE}};',
							'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a:hover .menu-icon svg, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a:hover svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a:hover .menu-icon svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'craftocustom_menu_icon_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i, {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon svg, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg, {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon img, {{WRAPPER}} .crafto-wp-menus-wrapper ul li a img, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a i, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a svg, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} ul.crafto-custom-menu-wrapper li a .menu-icon img, header .navbar .navbar-nav li .megamenu-content {{WRAPPER}} .crafto-wp-menus-wrapper ul li a img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
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
			$args                              = [];
			$class                             = '';
			$settings                          = $this->get_settings_for_display();
			$crafto_custom_menu_source         = $settings['crafto_custom_menu_source'];
			$crafto_custom_menu_separator_line = $settings['crafto_custom_menu_separator_line'];

			if ( 'yes' === $crafto_custom_menu_separator_line ) {
				$class = 'separator-line-yes';
			} elseif ( 'yes' === $settings['crafto_custom_menu_hvr_effect'] ) {
				$class = 'slide-on-hover';
			} elseif ( 'inline' === $settings['crafto_custom_menu_view'] ) {
				$class = 'menu-inline-items';
			}

			if ( 'wp_menus' === $crafto_custom_menu_source ) {
				$defaults_args = array(
					'menu' => $settings['crafto_custom_menu'],
				);

				/**
				 * Apply filters to add menu items list argument
				 *
				 * @since 1.0
				 */
				if ( class_exists( 'CraftoAddons\Classes\Menu_List_Frontend_Walker' ) ) {
					$args = apply_filters(
						'crafto_menu_list_items_args',
						array(
							'container'   => 'ul',
							'items_wrap'  => '<ul id="%1$s" class="%2$s crafto-navigation-link">%3$s</ul>',
							'before'      => '',
							'after'       => '',
							'link_before' => '',
							'link_after'  => '',
							'fallback_cb' => false,
							'walker'      => new Menu_List_Frontend_Walker(),
						)
					);
				}

				$args = array_merge( $defaults_args, $args );
				?>
				<div class="crafto-wp-menus-wrapper <?php echo esc_attr( $class ); ?>">
					<?php wp_nav_menu( $args ); ?>
				</div>
				<?php
			} else {
				?>
				<ul class="crafto-custom-menu-wrapper <?php echo esc_attr( $class ); ?>">
					<?php
					foreach ( $settings['crafto_custom_menu_items'] as $index => $item ) {
						$menu_item_key     = 'crafto_menu_list_' . $index;
						$migration_allowed = Icons_Manager::is_migration_allowed();

						$this->add_render_attribute(
							$menu_item_key,
							'class',
							[
								'custom-menu-list-item',
								'elementor-repeater-item-' . $item['_id'],
							]
						);
						if ( ! empty( $item['crafto_custom_menu_link']['url'] ) ) {
							?>
							<li <?php $this->print_render_attribute_string( $menu_item_key ); ?>>
								<?php
								$link_key = 'crafto_link_' . $index;
								$this->add_link_attributes( $link_key, $item['crafto_custom_menu_link'] );
								?>
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
									<?php
									$migrated = isset( $item['__fa4_migrated']['crafto_custom_menu_icon'] );
									$is_new   = ! isset( $item['icon'] ) && $migration_allowed;

									if ( ! empty( $settings['icon'] ) || ! empty( $item['crafto_custom_menu_icon']['value'] ) ) {
										?>
										<span class="menu-icon <?php echo $item['crafto_custom_menu_icon_alignment']; // Phpcs:ignore ?>">
											<?php
											if ( $is_new || $migrated ) {
												Icons_Manager::render_icon( $item['crafto_custom_menu_icon'], [ 'aria-hidden' => 'true' ] );
											} elseif ( isset( $item['crafto_custom_menu_icon']['value'] ) && ! empty( $item['crafto_custom_menu_icon']['value'] ) ) {
												?>
												<i class="<?php echo esc_attr( $item['crafto_custom_menu_icon']['value'] ); ?>" aria-hidden="true"></i>
												<?php
											}
											?>
										</span>
										<?php
									}
									echo esc_html( $item['crafto_custom_menu_label'] );

									if ( ! empty( $item['crafto_custom_menu_badge'] ) ) {
										?>
										<span class="menu-badge"><?php echo esc_html( $item['crafto_custom_menu_badge'] ); ?></span>
										<?php
									}
									?>
								</a>
							</li>
							<?php
						}
					}
					?>
				</ul>
				<?php
			}
		}
	}
}
