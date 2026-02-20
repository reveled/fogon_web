<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Classes\Left_Menu_Frontend_Walker;

/**
 *
 * Crafto widget for Left Menu.
 *
 * @package Crafto
 */

// If class `Left_Menu` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Left_Menu' ) ) {
	/**
	 * Define `Left_Menu` class.
	 */
	class Left_Menu extends Widget_Base {
		/**
		 * Retrieve the list of scripts the Left Menu widget depended on.
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
				$scripts[] = 'crafto-left-menu';
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
			return 'crafto-left-menu';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Left Menu', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-navigation-vertical crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/left-menu/';
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
				'nav',
				'navigation',
				'sidebar',
				'side',
				'vertical',
				'sticky',
			];
		}

		/**
		 * Register Left Menu widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_left_menu_general_section',
				[
					'label' => esc_html__( 'Menu', 'crafto-addons' ),
				]
			);

			$menus = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore

			$this->add_control(
				'crafto_menu',
				[
					'label'   => esc_html__( 'Select Menu', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => ! empty( $menus ) ? array_keys( $menus )[0] : '',
					'options' => $menus,  // phpcs:ignore
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
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > a',
				]
			);
			$this->start_controls_tabs( 'menu_top_menu_state_tabs' );
			$this->start_controls_tab(
				'crafto_menu_top_menu',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_menu_top_menu_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > a'                        => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > span.menu-toggle::before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > span.menu-toggle::after'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > a:before'                 => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_top_menu_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > a > i' => 'color: {{VALUE}};',
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
			$this->add_control(
				'crafto_menu_top_menu_text_color_hover',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0:hover > a'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0:hover > a:before' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_top_menu_icon_color_hover',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0:hover > a > i' => 'color: {{VALUE}};',
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
			$this->add_control(
				'crafto_menu_top_menu_text_color_active',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-item > a, {{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-parent > a, {{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-ancestor > a'                      => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-item > a:before, {{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-parent > a:before, {{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-ancestor > a:before' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_top_menu_icon_color_active',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-item > a > i, {{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-parent > a > i, {{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0.current-menu-ancestor > a > i' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .crafto-left-menu-wrap li.item-depth-0 > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_menu_section_sub_menu_style',
				[
					'label'      => esc_html__( 'Second Level', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_sub_menu_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1 > a',
				]
			);
			$this->start_controls_tabs( 'crafto_menu_sub_menu_state_tabs' );
			$this->start_controls_tab(
				'crafto_menu_sub_menu',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1 > a'                        => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1 > span.menu-toggle::before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1 > span.menu-toggle::after'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1 > a > i' => 'color: {{VALUE}};',
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
			$this->add_control(
				'crafto_menu_sub_menu_text_color_hover',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1:hover > a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_icon_color_hover',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1:hover > a > i' => 'color: {{VALUE}};',
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
			$this->add_control(
				'crafto_menu_sub_menu_text_color_active',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1.current-menu-item > a, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1.current-menu-parent > a, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1.current-menu-ancestor > a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_icon_color_active',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1.current-menu-item > a > i, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1.current-menu-parent > a > i, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1.current-menu-ancestor > a > i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
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
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1 > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
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
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li.item-depth-1 > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_sub_menu_third_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li > a',
				]
			);
			$this->start_controls_tabs( 'crafto_menu_sub_menu_third_state_tabs' );
			$this->start_controls_tab(
				'crafto_menu_sub_menu_third',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_third_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li > a'                        => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li > span.menu-toggle::before' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li > span.menu-toggle::after'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_third_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li > a > i' => 'color: {{VALUE}};',
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
			$this->add_control(
				'crafto_menu_sub_menu_third_text_color_hover',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li:hover > a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_third_icon_color_hover',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li:hover > a > i' => 'color: {{VALUE}};',
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
			$this->add_control(
				'crafto_menu_sub_menu_third_text_color_active',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li.current-menu-item > a, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li.current-menu-parent > a, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li.current-menu-ancestor > a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_sub_menu_third_icon_color_active',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li.current-menu-item > a > i, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li.current-menu-parent > a > i, {{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li.current-menu-ancestor > a > i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_menu_sub_menu_third_padding',
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
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_sub_menu_third_margin',
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
						'{{WRAPPER}} .crafto-left-menu ul.sub-menu-item > li > ul.sub-menu-item > li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render left menu widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @param array $instance Widget data.
		 *
		 * @access protected
		 */
		protected function render( $instance = [] ) {
			$args        = [];
			$crafto_menu = $this->get_settings( 'crafto_menu' );
			$menus_array = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore

			if ( ! isset( $crafto_menu ) || 0 === count( $menus_array ) ) {
				return;
			}

			if ( ! $crafto_menu ) {
				if ( empty( $menus_array ) ) {
					return;
				} else {
					$menus_array = array_keys( $menus_array );
					$crafto_menu = $menus_array[0];
				}
			} else {
				$crafto_menu = $crafto_menu;
			}

			$defaults_args = array(
				'menu' => $crafto_menu,
			);

			$this->add_render_attribute(
				[
					'navigation-wrapper' => [
						'class' => [
							'crafto-left-menu-wrap navbar-expand-lg navbar-container',
						],
					],
				]
			);

			if ( class_exists( 'CraftoAddons\Classes\Left_Menu_Frontend_Walker' ) ) {
				$args = apply_filters(
					'crafto_left_menu_frontend_args',
					array(
						'container'   => 'ul',
						'items_wrap'  => '<ul id="%1$s" class="%2$s alt-font crafto-left-menu" role="menu">%3$s</ul>',
						'before'      => '',
						'after'       => '',
						'link_before' => '',
						'link_after'  => '',
						'fallback_cb' => false,
						'walker'      => new Left_Menu_Frontend_Walker(),
					)
				);
			}

			$args = array_merge( $defaults_args, $args );
			?>
			<div <?php $this->print_render_attribute_string( 'navigation-wrapper' ); // phpcs:ignore ?>>
				<div id="navbarLeftNav" class="crafto-left-menu-wrapper navbar-collapse collapse" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
					<?php wp_nav_menu( $args ); ?>
				</div>
			</div>
			<?php
		}
	}
}
