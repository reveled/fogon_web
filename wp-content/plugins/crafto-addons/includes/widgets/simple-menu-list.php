<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Classes\Menu_List_Frontend_Walker;

/**
 *
 * Crafto widget for Menu List Items
 *
 * @package Crafto
 */

// If class `Simple_Menu_List` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Simple_Menu_List' ) ) {
	/**
	 * Define `Simple_Menu_List` class.
	 */
	class Simple_Menu_List extends Widget_Base {

		/**
		 * Retrieve the list of scripts the Simple Menu widget depended on.
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
			return 'crafto-menu-list-items';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Simple Menu List', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/simple-menu-list/';
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
				'simple',
				'list',
				'menu items',
			];
		}

		/**
		 * Register menu list items widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_menu_list_items_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_menu_list_items_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$menus = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore
			$this->add_control(
				'crafto_menu_list_items_menu',
				[
					'label'       => esc_html__( 'Select Menu', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'default'     => ! empty( $menus ) ? array_keys( $menus )[0] : '', // phpcs:ignore
					'options'     => $menus, // phpcs:ignore
				]
			);
			$this->add_control(
				'crafto_icon_enable',
				[
					'label'        => esc_html__( 'Enable Common Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'default'          => [
						'value'   => 'fas fa-arrow-right',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'fa4compatibility' => 'icon',
					'condition'        => [
						'crafto_icon_enable' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_menu_view',
				[
					'label'        => esc_html__( 'Orientation', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'vertical',
					'options'      => [
						'vertical'   => [
							'title' => esc_html__( 'Default', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-v',
						],
						'horizontal' => [
							'title' => esc_html__( 'Inline', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-h',
						],
					],
					'prefix_class' => 'elementor-menu-view-',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_menu_title_style_section',
				[
					'label'      => esc_html__( 'Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_menu_list_items_title[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_title_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'   => [
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
						'right' => is_rtl() ? 'end' : 'right',
					],
					'default'              => '',
					'selectors' => [
						'{{WRAPPER}} .title' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-navigation-wrapper .title',
				]
			);
			$this->add_control(
				'crafto_menu_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-wrapper .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_title_spacing',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-wrapper .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_list_items_style_section',
				[
					'label'      => esc_html__( 'Menu Container', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_alignment',
				[
					'label'       => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => '',
					'options'     => [
						'flex-start' => [
							'title' => esc_html__( 'Start', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'End', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'condition'   => [
						'crafto_menu_view' => 'vertical',
					],
					'selectors'   => [
						'{{WRAPPER}} .crafto-navigation-link li a' => 'justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_text_alignment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => '',
					'options'     => [
						'start'  => [
							'title' => esc_html__( 'Start', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'End', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'condition'   => [
						'crafto_menu_view' => 'horizontal',
					],
					'selectors'   => [
						'{{WRAPPER}} .crafto-navigation-link' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_height',
				[
					'label'      => esc_html__( 'Container Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-wrapper' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_menu_list_items_container_background',
					'selector'       => '{{WRAPPER}} .crafto-navigation-wrapper',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_menu_list_items_container_shadow',
					'selector' => '{{WRAPPER}} .crafto-navigation-wrapper',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_menu_list_items_container_border',
					'selector' => '{{WRAPPER}} .crafto-navigation-wrapper',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_container_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_container_padding',
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
						'{{WRAPPER}} .crafto-navigation-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_menu_list_items_section_top_menu_style',
				[
					'label'      => esc_html__( 'First Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_top_menu_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a',
				]
			);

			$this->start_controls_tabs( 'navigation_link_top_menu_state_tabs' );
				$this->start_controls_tab(
					'crafto_menu_list_items_top_menu',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_top_menu_text_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_menu_list_items_top_menu_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_top_menu_text_color_hover',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a:hover .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a:hover svg' => 'fill: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'crafto_menu_item_hvr_effect',
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
				$this->start_controls_tab(
					'crafto_menu_list_items_top_menu_active',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_top_menu_text_color_active',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-item > a'     => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-parent > a'   => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-item a .menu-item-icon'     => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-parent a .menu-item-icon'   => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-ancestor a .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.active > a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-item a svg'     => 'fill: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-parent a svg'   => 'fill: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-ancestor a svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_menu_list_items_top_border',
				[
					'label'      => esc_html__( 'Separator Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'condition'  => [
						'crafto_menu_view' => 'vertical',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'separator'  => 'before',
				]
			);

			$this->add_responsive_control(
				'crafto_menu_list_items_border_top_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_menu_view' => 'vertical',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_top_menu_padding',
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
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_top_menu_margin',
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
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_list_items_top_menu_icon_title',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_top_menu_icon_size',
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
						'{{WRAPPER}} .crafto-navigation-link li a .menu-item-icon' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .crafto-navigation-link li a svg, {{WRAPPER}} .crafto-navigation-link li a img' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_top_menu_icon_margin',
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
						'{{WRAPPER}} .crafto-navigation-link li a .menu-item-icon, {{WRAPPER}} .crafto-navigation-link li a svg, {{WRAPPER}} .crafto-navigation-link li a img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_list_section_badges_heading',
				[
					'label'     => esc_html__( 'Badges', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_list_badges_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-navigation-link li a .menu-item-label',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_badges_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-link li a .menu-item-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_badges_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-link li a .menu-item-label' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_badges_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-link li a .menu-item-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_menu_list_items_section_sub_menu_style',
				[
					'label'      => esc_html__( 'Second Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_list_items_sub_menu_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a',
				]
			);
			$this->start_controls_tabs( 'crafto_menu_list_items_sub_menu_state_tabs' );
				$this->start_controls_tab(
					'crafto_menu_list_items_sub_menu',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_sub_menu_text_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_menu_list_items_sub_menu_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_sub_menu_text_color_hover',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a:hover .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a:hover svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_menu_list_items_sub_menu_active',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_sub_menu_text_color_active',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.current-menu-item > a'                => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.item-depth-1.current-menu-parent > a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.current-menu-ancestor > a'            => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.current-menu-item > a .menu-item-icon'                => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.item-depth-1.current-menu-parent > a .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.current-menu-ancestor > a .menu-item-icon'            => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.current-menu-item > a svg '                => 'fill: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.item-depth-1.current-menu-parent > a svg' => 'fill: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li.current-menu-ancestor > a svg'            => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_menu_list_items_border_sub_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link li ul > li > a' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_menu_list_items_sub_menu_padding',
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
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_sub_menu_margin',
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
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_menu_list_items_section_sub_menu_third_style',
				[
					'label'      => esc_html__( 'Third Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_list_items_sub_menu_third_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li a',
				]
			);
			$this->start_controls_tabs( 'crafto_menu_list_items_sub_menu_third_state_tabs' );
				$this->start_controls_tab(
					'crafto_menu_list_items_sub_menu_third',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_sub_menu_third_text_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li a .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li a svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_menu_list_items_sub_menu_third_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_sub_menu_third_text_color_hover',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li > a:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li > a:hover .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li > a:hover svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_menu_list_items_sub_menu_third_active',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_menu_list_items_sub_menu_third_text_color_active',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-item > a'     => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-parent > a'   => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-ancestor > a' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-item > a .menu-item-icon'     => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-parent > a .menu-item-icon'   => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-ancestor > a .menu-item-icon' => 'color: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-item > a svg'     => 'fill: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-parent > a svg'   => 'fill: {{VALUE}};',
								'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li.current-menu-ancestor > a svg' => 'fill: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_menu_list_items_border_sub_menu_third_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li a' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_sub_menu_third_padding',
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
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_list_items_sub_menu_third_margin',
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
						'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li > ul > li > ul li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_icon_style_section',
				[
					'label'      => esc_html__( 'Common Icon', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_icon_enable' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_size',
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
						'{{WRAPPER}} .crafto-navigation-wrapper ul li a .submenu-icon-content i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .crafto-navigation-wrapper ul li a .submenu-icon-content svg' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->start_controls_tabs( 'icon_colors' );
				$this->start_controls_tab(
					'crafto_icon_colors_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-wrapper ul li a .submenu-icon-content i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .crafto-navigation-wrapper ul li a .submenu-icon-content svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_icon_colors_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-wrapper ul li a:hover .submenu-icon-content i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .crafto-navigation-wrapper ul li a:hover .submenu-icon-content svg' => 'fill: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_icon_colors_active',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_icon_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-item a .submenu-icon-content i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .crafto-navigation-wrapper .crafto-navigation-link > li.current-menu-item a .submenu-icon-content svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
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
			$args        = array();
			$settings    = $this->get_settings_for_display();
			$crafto_menu = $this->get_settings( 'crafto_menu_list_items_menu' );
			$menus_array = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore

			$migrated = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new   = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			$icon = '';
			if ( $is_new || $migrated ) {
				ob_start();
				?>
					<?php Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php
				$icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				ob_start();
				?>
					<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
				<?php
				$icon .= ob_get_clean();
			}

			if ( ! isset( $crafto_menu ) || 0 === count( $menus_array ) ) {
				return;
			}

			if ( ! $crafto_menu && ! empty( $menus_array ) ) {
				$menus_array = array_keys( $menus_array );
				$crafto_menu = $menus_array[0];
			}

			$defaults_args = array(
				'menu' => $crafto_menu,
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
						'items_wrap'  => '<ul id="%1$s" class="%2$s crafto-navigation-link crafto-simple-menu">%3$s</ul>',
						'before'      => '',
						'after'       => '',
						'link_before' => '',
						'link_after'  => $icon,
						'fallback_cb' => false,
						'walker'      => new Menu_List_Frontend_Walker(),
					)
				);
			}
			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'crafto-navigation-wrapper',
						],
					],
				],
			);
			if ( 'yes' === $settings['crafto_menu_item_hvr_effect'] ) {
				$this->add_render_attribute(
					[
						'wrapper' => [
							'class' => [
								'slide-on-hover',
							],
						],
					],
				);
			}
			$args = array_merge( $defaults_args, $args );
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				if ( $this->get_settings( 'crafto_menu_list_items_title' ) ) {
					?>
					<div class="title"><?php echo esc_html( $this->get_settings( 'crafto_menu_list_items_title' ) ); ?></div><?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php
				}
				?>
				<?php wp_nav_menu( $args ); ?>
			</div>
			<?php
		}
	}
}
