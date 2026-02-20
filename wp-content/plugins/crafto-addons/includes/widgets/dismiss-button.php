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
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for dismiss button.
 *
 * @package Crafto
 */

// If class `Dismiss_Button` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Dismiss_Button' ) ) {
	/**
	 * Define `Dismiss_Button` class.
	 */
	class Dismiss_Button extends Widget_Base {
		/**
		 * Retrieve the list of scripts the popup widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$dismiss_button_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$dismiss_button_scripts[] = 'crafto-widgets';
			} else {

				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$dismiss_button_scripts[] = 'magnific-popup';
				}
				$dismiss_button_scripts[] = 'crafto-popup-widget';
			}

			return $dismiss_button_scripts;
		}

		/**
		 * Retrieve the list of styles the popup widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$dismiss_button_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$dismiss_button_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$dismiss_button_styles[] = 'magnific-popup';
				}
				$dismiss_button_styles[] = 'crafto-popup-widget';
			}
			return $dismiss_button_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve popup widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-dismiss-button';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve popup widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Dismiss Button', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve popup widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-button crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/dismiss-button/';
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
			];
		}

		/**
		 * Get button sizes.
		 *
		 * Retrieve an array of button sizes for the button widget.
		 *
		 * @access public
		 * @static
		 *
		 * @return array An array containing button sizes.
		 */
		public static function get_button_sizes() {
			return [
				'xs' => esc_html__( 'Extra Small', 'crafto-addons' ),
				'sm' => esc_html__( 'Small', 'crafto-addons' ),
				'md' => esc_html__( 'Medium', 'crafto-addons' ),
				'lg' => esc_html__( 'Large', 'crafto-addons' ),
				'xl' => esc_html__( 'Extra Large', 'crafto-addons' ),
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
				'lightbox',
				'magnific',
				'popup',
				'close',
				'hide',
				'popup',
			];
		}

		/**
		 * Register popup widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_button',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_dismiss_button_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''              => esc_html__( 'Solid', 'crafto-addons' ),
						'border'        => esc_html__( 'Border', 'crafto-addons' ),
						'double-border' => esc_html__( 'Double Border', 'crafto-addons' ),
						'underline'     => esc_html__( 'Underline', 'crafto-addons' ),
						'expand-border' => esc_html__( 'Expand Width', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_dismiss_button_text',
				[
					'label'   => esc_html__( 'Text', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Dismiss', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_dismiss_button_size',
				[
					'label'          => esc_html__( 'Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'xs',
					'options'        => self::get_button_sizes(),
					'style_transfer' => true,
				]
			);
			$this->add_control(
				'crafto_selected_back_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'recommended'      => [
						'fa-solid' => [
							'angle-left',
							'angle-right',
							'long-arrow-alt-left',
							'long-arrow-alt-right',
						],
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
				]
			);
			$this->add_control(
				'crafto_button_icon_align',
				[
					'label'     => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'left'  => [
							'title' => esc_html__( 'left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default'   => 'right',
					'condition' => [
						'crafto_selected_back_icon[value]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_icon_shape_style',
				[
					'label'     => esc_html__( 'Icon Shape Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => [
						'default'         => esc_html__( 'Default', 'crafto-addons' ),
						'btn-icon-round'  => esc_html__( 'Round Edge', 'crafto-addons' ),
						'btn-icon-circle' => esc_html__( 'Circle', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_selected_back_icon[value]!' => '',
						'crafto_dismiss_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_shape_size',
				[
					'label'      => esc_html__( 'Icon Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .btn-icon-round .elementor-button-icon, {{WRAPPER}} .btn-icon-circle .elementor-button-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_selected_back_icon[value]!' => '',
						'crafto_icon_shape_style!'     => 'default',
						'crafto_dismiss_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-animation-btn-switch-icon .elementor-button-icon'  => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_selected_back_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_back_icon_indent',
				[
					'label'      => esc_html__( 'Icon Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_button_icon_align!' => 'switch',
						'crafto_selected_back_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_expand_width',
				[
					'label'      => esc_html__( 'Expand Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-button-wrapper .btn-hover-animation'  => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_dismiss_button_style' => 'expand-border',
					],
				]
			);
			$this->add_control(
				'crafto_dismiss_button_hover_animation',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						'crafto_dismiss_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_dismiss_heading_button',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_dismiss_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_back_side_button_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-button',
				]
			);

			$this->start_controls_tabs( 'crafto_button_style' );
			$this->start_controls_tab(
				'crafto_dismiss_button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_dismiss_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.elementor-button .elementor-button-content-wrapper, {{WRAPPER}} .elementor-button .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_dismiss_button_svg_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_selected_back_icon[library]' => 'svg',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_dismiss_button_icon_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} a.elementor-button i',
					'condition'      => [
						'crafto_selected_back_icon[library]!' => 'svg',
						'crafto_selected_back_icon[value]!'   => '',
					],
				]
			);
			$this->add_control(
				'crafto_button_double_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-double-border, {{WRAPPER}} .btn-double-border::after, {{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-animation-btn-expand-ltr .btn-hover-animation' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_button_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-animation-btn-expand-ltr .btn-hover-animation',
					'condition'      => [
						'crafto_dismiss_button_style!' => [
							'border',
							'double-border',
							'underline',
						],
					],
					'fields_options' => [
						'background' => [
							'frontend_available' => true,
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_button_shape_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-round .elementor-button-icon, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-circle .elementor-button-icon ',
					'condition'      => [
						'crafto_dismiss_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style'      => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						'crafto_selected_back_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tab_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_button_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-content-wrapper, {{WRAPPER}} .elementor-button:hover .elementor-button-content-wrapper, {{WRAPPER}} a.elementor-button:focus .elementor-button-content-wrapper, {{WRAPPER}} .elementor-button:focus .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_button_hover_svg_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_selected_back_icon[library]' => 'svg',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_dismiss_button_hover_icon_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} a.elementor-button:hover i, {{WRAPPER}} a.elementor-button:focus i',
					'condition'      => [
						'crafto_selected_back_icon[library]!' => 'svg',
						'crafto_selected_back_icon[value]!'   => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_button_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover'                                                         => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:focus'                                                         => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.btn-double-border:hover'                                       => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.btn-double-border:hover:after'                                 => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.btn-double-border:focus'                                       => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.elementor-animation-btn-expand-ltr:hover .btn-hover-animation' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .btn-double-border:hover, {{WRAPPER}} .btn-double-border:hover:after'             => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_dismiss_button_background_hover_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus',
					'fields_options' => [
						'background' => [
							'frontend_available' => true,
						],
					],
					'condition'      => [
						'crafto_dismiss_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_button_hover_shape_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-round:hover .elementor-button-icon, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-circle:hover .elementor-button-icon',
					'condition'      => [
						'crafto_dismiss_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style'      => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						'crafto_selected_back_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_dismiss_button_hover_transition',
				[
					'label'       => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 0.6,
						'unit' => 's',
					],
					'range'       => [
						's' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'transition-duration: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_button_underline_height',
				[
					'label'     => esc_html__( 'Border Thickness', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-underline' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_dismiss_button_style' => [
							'underline',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_dismiss_button_border',
					'selector'       => '{{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-animation-btn-expand-ltr .btn-hover-animation',
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
						'color'  => [
							'responsive' => true,
						],
					],
					'exclude'        => [
						'color',
					],
					'condition'      => [
						'crafto_dismiss_button_style!' => [
							'double-border',
							'underline',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_dismiss_button_style!' => [
							'underline',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_dismiss_button_padding',
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
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Retrieve the button.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                    = $this->get_settings_for_display();
			$button_hover_animation      = $settings['crafto_dismiss_button_hover_animation'];
			$button_text                 = ( isset( $settings['crafto_dismiss_button_text'] ) && $settings['crafto_dismiss_button_text'] ) ? $settings['crafto_dismiss_button_text'] : '';
			$has_button_icon             = ! empty( $settings['icon'] );
			$crafto_back_icon_align      = $settings['crafto_button_icon_align'];
			$crafto_dismiss_button_style = $this->get_settings( 'crafto_dismiss_button_style' );
			$crafto_icon_shape_style     = $this->get_settings( 'crafto_icon_shape_style' );
			$crafto_selected_back_icon   = $this->get_settings( 'crafto_selected_back_icon' );

			$this->add_render_attribute(
				[
					'btn_wrapper' => [
						'class' => [
							'elementor-button-wrapper',
							'crafto-button-wrapper',
						],
					],
				],
			);
			$this->add_render_attribute(
				[
					'btn_text' => [
						'class' => [
							'elementor-button-text',
						],
					],
				],
			);

			if ( 'double-border' === $crafto_dismiss_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-double-border',
						],
					],
				);
			}

			if ( 'border' === $crafto_dismiss_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-border',
						],
					],
				);
			}

			if ( 'underline' === $crafto_dismiss_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-underline',
						],
					],
				);
			}

			if ( 'expand-border' === $crafto_dismiss_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'elementor-animation-btn-expand-ltr',
						],
					],
				);
			}

			if ( ! $has_button_icon && ! empty( $settings['crafto_selected_back_icon']['value'] ) ) {
				$has_button_icon = true;
			}

			$is_new        = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_migrated = isset( $settings['__fa4_migrated']['crafto_selected_back_icon'] );
			if ( ! $is_new && empty( $settings['crafto_button_icon_align'] ) ) {
				// @todo: remove when deprecated
				// added as bc in 2.6
				// old default
				$settings['crafto_back_icon_align'] = $crafto_back_icon_align;
			}

			$this->add_render_attribute(
				[
					'icon-align' => [
						'class' => [
							'elementor-button-icon',
							'elementor-align-icon-' . $settings['crafto_button_icon_align'],
						],
					],
				],
			);
			if ( '' === $crafto_dismiss_button_style || 'border' === $crafto_dismiss_button_style ) {
				if ( ! empty( $crafto_selected_back_icon['value'] ) ) {
					$this->add_render_attribute( 'button', 'class', $crafto_icon_shape_style );
				}
			}
			$this->add_render_attribute(
				[
					'btn_div_wrapper' => [
						'class' => [
							'elementor-button-content-wrapper',
						],
					],
				],
			);

			/* Custom button hover effect */
			$custom_animation_class       = '';
			$custom_animation_div         = '';
			$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();
			if ( ! empty( $hover_animation_effect_array ) && ! empty( $button_hover_animation ) ) {
				if ( '' === $crafto_dismiss_button_style || 'border' === $crafto_dismiss_button_style ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $button_hover_animation );
				}
				if ( in_array( $button_hover_animation, $hover_animation_effect_array, true ) ) {
					$custom_animation_class = 'btn-custom-effect';
				}
			}
			if ( 'expand-border' === $crafto_dismiss_button_style ) {
				$custom_animation_div = '<span class="btn-hover-animation"></span>';
			}
			$this->add_render_attribute( 'button', 'class', [ $custom_animation_class ] );
			$this->add_render_attribute( 'button', 'class', 'elementor-button' );
			$this->add_render_attribute( 'button', 'class', 'popup-modal-dismiss' );
			$this->add_render_attribute( 'button', 'role', 'button' );

			if ( ! empty( $settings['crafto_dismiss_button_size'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['crafto_dismiss_button_size'] );
			}
			if ( 'btn-switch-text' === $button_hover_animation && $settings['crafto_dismiss_button_text'] ) {
				$this->add_render_attribute(
					[
						'btn_text' => [
							'data-btn-text' => wp_strip_all_tags( $settings['crafto_dismiss_button_text'] ),
						],
					],
				);
			}

			if ( ! empty( $button_text ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'btn_wrapper' ); ?>>
					<a <?php $this->print_render_attribute_string( 'button' ); ?>>
						<div <?php $this->print_render_attribute_string( 'btn_div_wrapper' ); ?>>
							<span <?php $this->print_render_attribute_string( 'btn_text' ); ?>>
								<?php echo esc_html( $button_text ); ?>
							</span>
							<?php
							if ( $has_button_icon ) {
								?>
								<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
									<?php
									if ( $is_new || $icon_migrated ) {
										Icons_Manager::render_icon( $settings['crafto_selected_back_icon'] );
									} elseif ( isset( $settings['crafto_selected_back_icon']['value'] ) && ! empty( $settings['crafto_selected_back_icon']['value'] ) ) {
										?>
										<i class="<?php echo esc_attr( $settings['crafto_selected_back_icon']['value'] ); ?>"></i>
										<?php
									}
									?>
								</span>
								<?php
							}
							?>
						</div>
						<?php echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore ?>
					</a>
				</div>
				<?php
			}
		}
	}
}
