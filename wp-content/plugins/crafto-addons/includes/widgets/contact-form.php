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

/**
 * Crafto widget for contact form.
 *
 * @package Crafto
 */

// If class `Contact Form` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Contact_Form' ) ) {
	/**
	 * Define `Contact Form` class.
	 */
	class Contact_Form extends Widget_Base {

		/**
		 * Retrieve the list of styles the contact form widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$contact_form_style = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$contact_form_style[] = 'crafto-widgets-rtl';
				} else {
					$contact_form_style[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$contact_form_style[] = 'crafto-contact-rtl-widget';
				}
				$contact_form_style[] = 'crafto-contact-widget';
			}
			return $contact_form_style;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-contact-form';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Contact Form 7', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-mail crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/contact-form-7/';
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
				'contact form 7',
				'cf7',
				'integration',
				'contact us',
			];
		}

		/**
		 * Register contact form widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_content',
				[
					'label' => esc_html__( 'Contact Form', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_contact_form_id',
				[
					'label'       => esc_html__( 'Select Form', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'options'     => $this->get_contact_form_list(),
					'default'     => '0',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_contact_form_style',
				[
					'label' => esc_html__( 'Form', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_contact_form_section_background',
					'selector' => '{{WRAPPER}} .contact-form-wrapper',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_contact_form_field_style',
				[
					'label' => esc_html__( 'Fields', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_heading_style_label',
				[
					'label' => esc_html__( 'Label', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_contact_form_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .wpcf7-form label',
				]
			);
			$this->add_control(
				'crafto_contact_form_label_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_ontact_form_label_text_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 25,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .wpcf7-form label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_style_input_separator',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control(
				'crafto_heading_style_input',
				[
					'label' => esc_html__( 'Input', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_contact_form_input_box_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"],
						{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"],
						{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"],
						{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"],
						{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"],
						{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"],
						{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea,
						{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select',
				]
			);
			$this->add_control(
				'crafto_contact_form_input_box_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'   => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_input_box_placeholder_color',
				[
					'label'     => esc_html__( 'Placeholder Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]::-webkit-input-placeholder'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]::-moz-placeholder'            => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:-ms-input-placeholder'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]::-moz-placeholder'           => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:-ms-input-placeholder'       => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]::-webkit-input-placeholder'    => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]::-moz-placeholder'             => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:-ms-input-placeholder'         => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]::-moz-placeholder'          => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:-ms-input-placeholder'      => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]::-webkit-input-placeholder'    => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]::-moz-placeholder'             => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:-ms-input-placeholder'         => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]::-webkit-input-placeholder'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]::-moz-placeholder'            => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:-ms-input-placeholder'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::-webkit-input-placeholder'              => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea::-moz-placeholder'                       => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:-ms-input-placeholder'                   => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'                                    => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_input_box_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .input-wrapper i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_input_box_background',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'   => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->start_controls_tabs( 'crafto_contact_form_border_tabs' );
			$this->start_controls_tab(
				'crafto_content_active_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_contact_form_input_box_shadow',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_contact_form_input_border',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"], {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea',
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_border_focus_tab',
				[
					'label' => esc_html__( 'Focus', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_contact_form_input_focus_box_shadow',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_contact_form_input_focus_border',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]:focus, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select, {{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea:focus',
				]
			);

			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_contact_form_input_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]'   => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]'  => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]'    => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]'    => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]'   => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'         => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'              => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_contact_form_input_box_padding',
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
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="text"]'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="email"]'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="url"]'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="number"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="tel"]'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap input[type*="date"]'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap .wpcf7-select'         => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea'              => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_contact_form_input_box_margin',
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
						'{{WRAPPER}} .input-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_style_textarea_separator',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control(
				'crafto_heading_style_textarea',
				[
					'label' => esc_html__( 'Textarea', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_contact_form_textarea_resize',
				[
					'label'     => esc_html__( 'Resize', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'vertical',
					'options'   => [
						'none'       => esc_html__( 'None', 'crafto-addons' ),
						'horizontal' => esc_html__( 'Horizontal', 'crafto-addons' ),
						'vertical'   => esc_html__( 'Vertical', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'resize: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_textarea_box_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-form-control-wrap textarea' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_Text_style_separator',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control(
				'crafto_Text_style_label',
				[
					'label' => esc_html__( 'Info Text', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_responsive_control(
				'crafto_text_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'start'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .contact-form-text' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_contact_form_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .wpcf7-form .contact-form-text, {{WRAPPER}}.elementor-widget-crafto-contact-form .wpcf7-form label .wpcf7-list-item-label',
				]
			);
			$this->add_control(
				'crafto_contact_form_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .contact-form-text, {{WRAPPER}}.elementor-widget-crafto-contact-form .wpcf7-form label .wpcf7-list-item-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_contact_form_text_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'default'    => [
						'unit' => '%',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .wpcf7-form .contact-form-text, {{WRAPPER}} .wpcf7-checkbox .wpcf7-list-item .wpcf7-list-item-label' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_contact_form_text_margin',
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
						'{{WRAPPER}} .wpcf7-form .contact-form-text, {{WRAPPER}} .wpcf7-checkbox input[type=checkbox]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			/* Submit button panel style tab*/
			$this->start_controls_section(
				'crafto_contact_form_button_style',
				[
					'label' => esc_html__( 'Submit Button', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_submit_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
				]
			);
			$this->add_control(
				'crafto_submit_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit, {{WRAPPER}} .wpcf7-form .contact-wpcf7-spinner' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_submit_button_box_shadow',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
				]
			);
			$this->start_controls_tabs( 'crafto_contact_form_submit_button_tabs' );
			$this->start_controls_tab(
				'crafto_submit_button_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_submit_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit, {{WRAPPER}} .contact-modern-only-icon .contact-wpcf7-spinner i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit, {{WRAPPER}} .contact-modern-only-icon .contact-wpcf7-spinner svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_submit_button_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_submit_submit_border',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_submit_button_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_submit_button_hover_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover, {{WRAPPER}} .contact-modern-only-icon .contact-wpcf7-spinner:hover i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_submit_button_hover_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_submit_button_hover_border',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit:hover',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_submit_button_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_submit_button_active_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit:active, {{WRAPPER}} .wpcf7-form .wpcf7-submit:focus' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_submit_button_active_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit:active' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit:focus'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_submit_button_active_border',
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-submit:active, {{WRAPPER}} .wpcf7-form .wpcf7-submit:focus',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_submit_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_submit_padding',
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
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_submit_margin',
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
						'{{WRAPPER}} .wpcf7-form .wpcf7-submit, {{WRAPPER}} .wpcf7-form .contact-wpcf7-spinner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_contact_form_messages_style',
				[
					'label' => esc_html__( 'Messages', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_contact_form_messages_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .wpcf7-form .wpcf7-response-output',
				]
			);
			$this->add_control(
				'crafto_heading_success_messages_input',
				[
					'label'     => esc_html__( 'Success Message', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_contact_form_success_messages_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7 form.sent .wpcf7-response-output' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_success_messages_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7 form.sent .wpcf7-response-output' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_error_messages_input',
				[
					'label'     => esc_html__( 'Error Message', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_contact_form_error_messages_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-validation-errors'       => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-acceptance-missing'      => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form.invalid .wpcf7-response-output' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_error_messages_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-validation-errors'       => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-acceptance-missing'      => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form.invalid .wpcf7-response-output' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_spam_messages_input',
				[
					'label'     => esc_html__( 'Spam/Blocked Message', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_contact_form_spam_messages_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-spam-blocked' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_spam_messages_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-spam-blocked' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_aborted_messages_input',
				[
					'label'     => esc_html__( 'Aborted Message', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_contact_form_aborted_messages_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-aborted'      => 'color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-mail-sent-ng' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_aborted_messages_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .wpcf7-form .wpcf7-aborted'      => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .wpcf7-form .wpcf7-mail-sent-ng' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_contact_form_messages_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .wpcf7-response-output' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_contact_form_alert_text_style',
				[
					'label' => esc_html__( 'Alert', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_contact_form_alert_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .form-not-available',
				]
			);
			$this->add_control(
				'crafto_contact_form_alert_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .form-not-available' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_contact_form_alert_background',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .form-not-available' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render contact form widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();
			$this->add_render_attribute( 'form_attr', 'class', 'contact-form-wrapper' );
			$form_slug = sanitize_title( $settings['crafto_contact_form_id'] );
			$form_id   = $this->get_contact_form_id_by_slug( $form_slug );
			?>
			<div <?php $this->print_render_attribute_string( 'form_attr' ); ?>>
				<?php
				if ( ! empty( $form_id ) ) {
					$this->add_render_attribute( 'shortcode', 'id', $form_id );
					$shortcode = sprintf( '[contact-form-7 %s]', $this->get_render_attribute_string( 'shortcode' ) );
					echo do_shortcode( $shortcode );
				} else {
					?>
					<div class="form-not-available alert alert-warning">
						<?php echo esc_html__( 'Please Select contact form.', 'crafto-addons' ); ?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}

		/**
		 *
		 * Retrieve the contact form 7 form list.
		 *
		 * @access public
		 */
		public function get_contact_form_list() {
			$contact_form_list = [
				'0' => '— ' . esc_html__( 'Select', 'crafto-addons' ) . ' —',
			];

			// Get contact forms list.
			$args = [
				'post_type'      => 'wpcf7_contact_form',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
			];

			$post_ids = get_posts( array_merge( $args, [ 'fields' => 'ids' ] ) );

			if ( ! empty( $post_ids ) ) {
				$posts = get_posts( array_merge( $args, [ 'post__in' => $post_ids, 'orderby' => 'title' ] ) );

				foreach ( $posts as $post ) {
					$contact_form_list[ $post->post_name ] = esc_html( $post->post_title );
				}
			} else {
				$contact_form_list['0'] = esc_html__( 'Form not found', 'crafto-addons' );
			}

			return $contact_form_list;
		}

		/**
		 *
		 * Retrieve the contact form 7 from IDs.
		 *
		 * @param mixed $slug contact form 7 slug.
		 * @access public
		 */
		public function get_contact_form_id_by_slug( $slug ) {
			$form = get_page_by_path( $slug, OBJECT, 'wpcf7_contact_form' );
			return $form ? $form->ID : 0;
		}
	}
}
