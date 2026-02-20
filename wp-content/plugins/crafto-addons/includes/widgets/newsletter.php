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
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for Newsletter.
 *
 * @package Crafto
 */

// If class `Newsletter` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Newsletter' ) ) {
	/**
	 * Define `Newsletter` class.
	 */
	class Newsletter extends Widget_Base {
		/**
		 * Retrieve the list of scripts the newsletter widget depended on.
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
				return [ 'crafto-newsletter' ];
			}
		}
		/**
		 * Retrieve the list of styles the newsletter widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$newsletter_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$newsletter_styles[] = 'crafto-widgets-rtl';
				} else {
					$newsletter_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$newsletter_styles[] = 'crafto-newsletter-rtl';
				}
				$newsletter_styles[] = 'crafto-newsletter';
			}
			return $newsletter_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-newsletter';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Newsletter', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/newsletter/';
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
				'subscribe',
				'newsletter',
				'mail',
				'email form',
				'mailchimp',
				'subscription form',
			];
		}

		/**
		 * Register newsletter widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_newsletter_form',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'crafto_newsletter_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'newsletter-style-1',
					'options'            => [
						'newsletter-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'newsletter-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'newsletter-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_newsletter_list_id',
				[
					'label'       => esc_html__( 'List ID', 'crafto-addons' ),
					'description' => esc_html__( 'Select the list from mailchimp to add emails. The API Key of the Mailchimp should be added in Theme Options', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => '0',
					'options'     => $this->get_mailchimp_lists(),
				]
			);
			$this->add_control(
				'crafto_newsletter_tags',
				[
					'label'       => esc_html__( 'Tags', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'default'     => '',
					'placeholder' => esc_html__( 'Newsletter,Footer', 'crafto-addons' ),
					'description' => esc_html__( 'Tags are labels you create to help organize your contacts. You can define multiple tags with comma(,)', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_newsletter_name_field',
				[
					'label'        => esc_html__( 'Enable Name Field?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'ld-sf--has-name',
					'default'      => '',
					'condition'    => [
						'crafto_newsletter_style' => [
							'newsletter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_newsletter_placeholder_text',
				[
					'label'       => esc_html__( 'Input Placeholder', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Enter your email address', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Enter your email address', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_newsletter_placeholder_nametext',
				[
					'label'       => esc_html__( 'Placehoder Name', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Enter your name', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Enter your name', 'crafto-addons' ),
					'condition'   => [
						'crafto_newsletter_name_field' => 'ld-sf--has-name',
					],
				]
			);
			$this->add_control(
				'crafto_newsletter_gdpr',
				[
					'label'        => esc_html__( 'Enable GDPR Checkbox', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_newsletter_gdpr_text',
				[
					'label'       => esc_html__( 'Privacy Agreement Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'rows'        => 4,
					'default'     => esc_html__( 'I accept the terms and conditions.', 'crafto-addons' ),
					'placeholder' => esc_html__( 'I accept the terms and conditions.', 'crafto-addons' ),
					'condition'   => [
						'crafto_newsletter_gdpr' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_button_section',
				[
					'label' => esc_html__( 'Submit Button', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);
			$this->add_control(
				'crafto_newsletter_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'default'          => [
						'value'   => 'feather icon-feather-mail',
						'library' => 'solid',
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->add_control(
				'crafto_newsletter_icon_align',
				[
					'label'   => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'left'  => [
							'title' => esc_html__( 'left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default' => 'left',
				]
			);
			$this->add_control(
				'crafto_newsletter_btn_label',
				[
					'label'       => esc_html__( 'Button Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Subscribe', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Subscribe', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_newsletter_field_style',
				[
					'label' => esc_html__( 'Fields', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_newsletter_input_box_typography',
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newsletter-text',
				]
			);
			$this->add_control(
				'crafto_newsletter_input_box_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newsletter-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_newsletter_input_box_placeholder_color',
				[
					'label'     => esc_html__( 'Placeholder Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newsletter-text::placeholder' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_newsletter_input_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newsletter-text',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_newsletter_input_shadow',
					'selector'  => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newsletter-text',
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_newsletter_input_border',
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newsletter-text',
				]
			);
			$this->add_responsive_control(
				'newsletter_input_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newsletter-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_newsletter_input_padding',
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
						'{{WRAPPER}} .newsletter-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_newsletter_input_margin',
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
						'{{WRAPPER}} .newsletter-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_newsletter_gdpr_style',
				[
					'label' => esc_html__( 'GDPR', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_gdpr_typography',
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newslleter-gdpr',
				]
			);
			$this->add_control(
				'crafto_gdpr_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form .newslleter-gdpr' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_newsletter_button_style',
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
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button .submit-text',
				]
			);
			$this->add_responsive_control(
				'crafto_submit_button_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button .submit-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button .submit-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_submit_button_icon_spacing',
				[
					'label'      => esc_html__( 'Icon Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-left i, {{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-left svg' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-right i, {{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-right svg' => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-left i, .rtl {{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-left svg' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-right i, .rtl {{WRAPPER}} .newsletter-form-wrapper .submit-icon.icon-right svg' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_submit_button_width',
				[
					'label'      => esc_html__( 'Button Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_submit_button_height',
				[
					'label'      => esc_html__( 'Button Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_newsletter_style' => [
							'newsletter-style-2',
						],
					],
				]
			);
			$this->start_controls_tabs( 'newsletter_submit_button_tabs' );
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
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_normal_submit_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_submit_button_icon_color',
					'selector'       => '{{WRAPPER}} .crafto-newsletter-form button i, {{WRAPPER}} .crafto-newsletter-form button svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
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
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_hover_submit_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button:hover',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_submit_button_hover_icon_color',
					'selector'       => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button:hover i, {{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button:hover svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_submit_button_hover_transition',
				[
					'label'       => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'custom',
					],
					'default'     => [
						'size' => 0.3,
						'unit' => 's',
					],
					'range'       => [
						's' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'render_type' => 'ui',
					'selectors'   =>
					[
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button'     => 'transition-duration: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button i' => 'transition-duration: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_button_icon_divider',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_submit_button_text_shadow',
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button .submit-text',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_submit_button_box_shadow',
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_submit_submit_border',
					'selector' => '{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button',
				]
			);
			$this->add_responsive_control(
				'crafto_submit_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_submit_button_padding',
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
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_submit_button_margin',
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
						'{{WRAPPER}} .newsletter-form-wrapper .crafto-newsletter-form button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render newsletter widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings         = $this->get_settings_for_display();
			$newsletter_style = ( isset( $settings['crafto_newsletter_style'] ) && ! empty( $settings['crafto_newsletter_style'] ) ) ? $settings['crafto_newsletter_style'] : 'newsletter-style-1';
			$placeholder_text = ( isset( $settings['crafto_newsletter_placeholder_text'] ) && $settings['crafto_newsletter_placeholder_text'] ) ? $settings['crafto_newsletter_placeholder_text'] : '';
			$name_text        = ( isset( $settings['crafto_newsletter_placeholder_nametext'] ) && $settings['crafto_newsletter_placeholder_nametext'] ) ? $settings['crafto_newsletter_placeholder_nametext'] : '';
			$enable_gdpr      = ( isset( $settings['crafto_newsletter_gdpr'] ) && $settings['crafto_newsletter_gdpr'] ) ? $settings['crafto_newsletter_gdpr'] : '';
			$gdpr_text        = ( isset( $settings['crafto_newsletter_gdpr_text'] ) && $settings['crafto_newsletter_gdpr_text'] ) ? $settings['crafto_newsletter_gdpr_text'] : '';
			$list_id          = ( isset( $settings['crafto_newsletter_list_id'] ) && $settings['crafto_newsletter_list_id'] ) ? $settings['crafto_newsletter_list_id'] : '';
			$tags             = ( isset( $settings['crafto_newsletter_tags'] ) && $settings['crafto_newsletter_tags'] ) ? $settings['crafto_newsletter_tags'] : '';
			$email_id         = 'email_' . uniqid();

			$this->add_render_attribute(
				'newsletter_attr',
				'class',
				[
					'newsletter-form-wrapper',
					$newsletter_style,
				]
			);
			?>
			<div <?php $this->print_render_attribute_string( 'newsletter_attr' ); ?>>
				<form class="crafto-newsletter-form" method="post" action="<?php the_permalink(); ?>">
					<?php
					switch ( $newsletter_style ) {
						case 'newsletter-style-1':
						case 'newsletter-style-2':
							?>
							<div class="newsletter-wrap">
								<label for="<?php echo esc_attr( $email_id ); ?>" class="screen-reader-text">
									<?php echo esc_html__( 'Email', 'crafto-addons' ); ?>
								</label>
								<input id="<?php echo esc_attr( $email_id ); ?>" name="email" type="email" class="newsletter-text newsletter-email required" placeholder="<?php echo esc_attr( $placeholder_text ); ?>" value=""/>
								<?php $this->get_submit_button(); ?>
							</div>
							<?php
							if ( 'yes' === $enable_gdpr ) {
								?>
								<div class="newsletter-checkbox">
									<input type="checkbox" name="newsleter_gdpr" id="newsleter_gdpr" class="newsletter-gdpr required">
									<label class="newslleter-gdpr" for="newsleter_gdpr">
										<?php echo esc_html( $gdpr_text ); ?>
									</label>
								</div>
								<?php
							}
							break;
						case 'newsletter-style-3':
							?>
							<div class="newsletter-wrap">
								<?php
								if ( $settings['crafto_newsletter_name_field'] ) {
									?>
									<label for="fname" class="screen-reader-text">
										<?php echo esc_html__( 'First Name', 'crafto-addons' ); ?>
									</label>
									<input id="fname" name="fname" type="text" class="newsletter-text newsletter-name" placeholder="<?php echo esc_attr( $name_text ); ?>" />
									<?php
								}
								?>
								<label for="<?php echo esc_attr( $email_id ); ?>" class="screen-reader-text">
									<?php echo esc_html__( 'Email', 'crafto-addons' ); ?>
								</label>
								<input id="<?php echo esc_attr( $email_id ); ?>" name="email" type="email" class="newsletter-text newsletter-email required" placeholder="<?php echo esc_attr( $placeholder_text ); ?>" value=""/>
								<?php
								if ( 'yes' === $enable_gdpr ) {
									?>
									<div class="newsletter-checkbox">
										<input type="checkbox" name="newsleter_gdpr" id="newsleter_gdpr" class="newsletter-gdpr required">
										<label class="newslleter-gdpr" for="newsleter_gdpr">
											<?php echo esc_html( $gdpr_text ); ?>
										</label>
									</div>
									<?php
								}
								$this->get_submit_button();
								?>
							</div>
							<?php
							break;
					}
					?>
					<input type="hidden" class="newsletter-list-id" name="list_id" value="<?php echo esc_attr( $list_id ); ?>">
					<?php
					if ( ! empty( $tags ) ) {
						?>
						<input type="hidden" class="newsletter-tags" name="tags" value="<?php echo esc_attr( $tags ); ?>">
						<?php
					}
					wp_nonce_field( 'crafto-mailchimp-form', '_wpnonce_' . uniqid(), true, false );
					?>
				</form>
				<div class="newsletter-response"></div>
			</div>	
			<?php
		}

		/**
		 * Submit Button
		 */
		public function get_submit_button() {

			$settings      = $this->get_settings_for_display();
			$migrated      = isset( $settings['__fa4_migrated']['crafto_newsletter_icon'] );
			$is_new        = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$btn_label     = ( isset( $settings['crafto_newsletter_btn_label'] ) && ! empty( $settings['crafto_newsletter_btn_label'] ) ) ? $settings['crafto_newsletter_btn_label'] : '';
			$icon_position = ( isset( $settings['crafto_newsletter_icon_align'] ) && ! empty( $settings['crafto_newsletter_icon_align'] ) ) ? 'icon-' . $settings['crafto_newsletter_icon_align'] : '';
			?>
			<button type="submit" class="newsletter-submit" title="<?php echo esc_html__( 'Newsletter', 'crafto-addons' ); ?>">
				<?php
				if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_newsletter_icon']['value'] ) ) {
					?>
					<span class="submit-icon <?php echo $icon_position; // phpcs:ignore ?>">
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings['crafto_newsletter_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['crafto_newsletter_icon']['value'] ) && ! empty( $settings['crafto_newsletter_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings['crafto_newsletter_icon']['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
						?>
					</span>
					<?php
				}
				if ( ! empty( $icon ) ) {
					?>
					<span class="submit-icon <?php echo $icon_position; // phpcs:ignore ?>">
						<i class="<?php echo $icon; // phpcs:ignore ?>"></i>

					</span>
					<?php
				}
				if ( ! empty( $btn_label ) ) {
					?>
					<span class="submit-text">
						<?php echo esc_html( $btn_label ); ?>
					</span>
					<?php
				}
				?>				
				<span class="newsletter-spinner">
					<span class="d-block">
						<?php echo esc_html__( 'Sending', 'crafto-addons' ); ?>
					</span>
				</span>
			</button>
			<?php
		}

		/**
		 * Get MailChimp Lists IDs
		 *
		 * @return array
		 */
		public function get_mailchimp_lists() {

			if ( ! class_exists( 'Crafto_MailChimp' ) ) {
				return array();
			}
			$api_key = get_theme_mod( 'crafto_mailchimp_access_api_key', '' );
			if ( empty( $api_key ) || strpos( $api_key, '-' ) === false ) {
				return array();
			}

			$mailchimp = new \Crafto_MailChimp( $api_key );

			$lists = $mailchimp->get( 'lists' );
			$items = [ '0' => 'Select List' ];
			if ( is_array( $lists ) && ! is_wp_error( $lists ) ) {
				foreach ( $lists as $list ) {
					if ( is_array( $list ) ) {
						foreach ( $list as $l ) {
							if ( isset( $l['name'] ) && isset( $l['id'] ) ) {
								$items[ strval( $l['id'] ) ] = $l['name'];
							}
						}
					}
				}
			}
			return $items;
		}
	}
}
