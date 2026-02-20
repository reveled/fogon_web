<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use CraftoAddons\Classes\Simple_Navigation_Frontend_Walker;

/**
 *
 * Crafto widget for classic menu
 *
 * @package Crafto
 */

// If class `Classic_Menu` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Classic_Menu' ) ) {
	/**
	 * Define `Classic_Menu` class.
	 */
	class Classic_Menu extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-simple-navigation';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Classic Menu', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/classic-menu/';
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
				'nav',
				'navigation',
				'simple',
				'site',
				'header',
			];
		}

		/**
		 * Register the widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_menu_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title',
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
				'crafto_menu',
				[
					'label'       => esc_html__( 'Select Menu', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'default'     => ! empty( $menus ) ? array_keys( $menus )[0] : '',
					'options'     => $menus, // phpcs:ignore
				]
			);
			$this->add_control(
				'crafto_menu_animation_arrow_hide_show',
				[
					'label'        => esc_html__( 'Enable Arrow on Hover', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_section_menu_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_icon_vertical_alignment',
				[
					'label'        => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'middle',
					'options'      => [
						'top'    => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'middle' => [
							'title' => esc_html__( 'Middle', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'prefix_class' => 'elementor%s-vertical-align-',
					'toggle'       => true,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_simple_menu_typography',
					'selector' => '{{WRAPPER}} .crafto-navigation-menu li > a',
				]
			);
			$this->start_controls_tabs( 'menu_top_menu_state_tabs' );
			$this->start_controls_tab(
				'crafto_menu_simple_menu',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_menu_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-menu li > a, {{WRAPPER}} .crafto-navigation-menu li > a:before' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_menu_simple_menu_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_menu_text_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-menu li > a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_simple_menu_background_color_hover',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .simple-navigation-menu li > a:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_menu_simple_menu_active',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_menu_text_color_active',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-menu li.current-menu-item > a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_menu_simple_menu_border',
				[
					'label'      => esc_html__( 'Border Thickness', 'crafto-addons' ),
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
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-menu li a' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'separator'  => 'before',
				]
			);

			$this->add_responsive_control(
				'crafto_menu_simple_menu_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-menu li a' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_menu_simple_menu_padding',
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
						'{{WRAPPER}} .crafto-navigation-menu li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_menu_margin',
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
						'{{WRAPPER}} .crafto-navigation-menu li > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'crafto_simple_menu_description_heading',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_simple_menu_description_typography',
					'selector' => '{{WRAPPER}} .crafto-navigation-menu li .submenu-icon-content p',
				]
			);

			$this->start_controls_tabs( 'simple_menu_description_tabs' );
				$this->start_controls_tab(
					'crafto_simple_menu_description',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_simple_menu_description_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-menu li .submenu-icon-content p' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_simple_menu_description_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_simple_menu_description_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-menu li:hover .submenu-icon-content p' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_simple_menu_description_margin',
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
						'{{WRAPPER}} .crafto-navigation-menu li .submenu-icon-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_menu_section_menu_title_style',
				[
					'label'      => esc_html__( 'Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_title!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_simple_menu_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .title',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_menu_simple_menu_title_color',
					'selector'       => '{{WRAPPER}} .title',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
						'color'      => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_menu_simple_menu_title_text_shadow',
					'selector' => '{{WRAPPER}} .title',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_menu_title_margin',
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
						'{{WRAPPER}} .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_simple_menu_icon_style',
				[
					'label'      => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_menu_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 40,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-menu li > a > i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .crafto-navigation-menu li > a > img, {{WRAPPER}} .crafto-navigation-menu li > a > svg' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_simple_menu_icon_width',
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
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-menu li > a > i, {{WRAPPER}} .crafto-navigation-menu li > a > img, {{WRAPPER}} .crafto-navigation-menu li > a > svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'menu_simple_menu_icon_style_tabs' );
				$this->start_controls_tab(
					'crafto_simple_menu_icon',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);

				$this->add_responsive_control(
					'crafto_simple_menu_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-menu li > a > i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .crafto-navigation-menu li > a > svg' => 'color: {{VALUE}}; fill: {{VALUE}}; -webkit-text-fill-color: initial;',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_simple_menu_icon_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$this->add_responsive_control(
					'crafto_simple_menu_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-menu li:hover > a > i, {{WRAPPER}} .crafto-navigation-menu li.current-menu-item:hover > a > i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .crafto-navigation-menu li:hover > a > svg, {{WRAPPER}} .crafto-navigation-menu li.current-menu-item:hover > a > svg' => 'color: {{VALUE}}; fill: {{VALUE}}; -webkit-text-fill-color: initial;',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_simple_menu_icon_active',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);

				$this->add_responsive_control(
					'crafto_simple_menu_icon_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-navigation-menu li.current-menu-item > a > i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .crafto-navigation-menu li.current-menu-item > a > svg' => 'color: {{VALUE}}; fill: {{VALUE}}; -webkit-text-fill-color: initial;',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_simple_menu_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-menu li > a > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_menu_icon_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-menu li > a > i, {{WRAPPER}} .crafto-navigation-menu li > a > img, {{WRAPPER}} .crafto-navigation-menu li > a > svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_simple_menu_style_badges',
				[
					'label'      => esc_html__( 'Badges', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_simple_menu_badges_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-navigation-menu li .menu-item-label',
				]
			);
			$this->add_responsive_control(
				'crafto_simple_menu_badges_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-menu li .menu-item-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_simple_menu_badges_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-navigation-menu li .menu-item-label' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_simple_menu_badges_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-menu li .menu-item-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_menu_animation_arrow_style',
				[
					'label'      => esc_html__( 'Arrow', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_menu_animation_arrow_hide_show' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_menu_simple_animation_arrow_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 30,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-navigation-menu li a:before' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render classic menu widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @param array $instance Widget data.
		 *
		 * @access protected
		 */
		protected function render( $instance = [] ) {
			$args                   = [];
			$class                  = '';
			$settings               = $this->get_settings_for_display();
			$crafto_menu            = $settings['crafto_menu'];
			$crafto_arrow_hide_show = $settings['crafto_menu_animation_arrow_hide_show'];
			$menus_array            = function_exists( 'get_menus_list' ) ? get_menus_list() : []; // phpcs:ignore

			if ( 'yes' === $crafto_arrow_hide_show ) {
				$class = 'animation-arrow-show';
			}

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

			if ( class_exists( 'CraftoAddons\Classes\Simple_Navigation_Frontend_Walker' ) ) {
				$args = apply_filters(
					'crafto_simple_menu_navigation_args',
					array(
						'container'   => 'ul',
						'items_wrap'  => '<ul id="%1$s" class="%2$s crafto-navigation-menu simple-navigation-menu ' . $class . '" role="menu">%3$s</ul>',
						'before'      => '',
						'after'       => '',
						'link_before' => '',
						'link_after'  => '',
						'fallback_cb' => false,
						'walker'      => new Simple_Navigation_Frontend_Walker(),
					)
				);
			}

			$args = array_merge( $defaults_args, $args );

			if ( $this->get_settings( 'crafto_title' ) ) {
				?>
				<div class="title"><?php echo esc_html( $this->get_settings( 'crafto_title' ) ); ?></div>
				<?php
			}
			wp_nav_menu( $args );
		}
	}
}
