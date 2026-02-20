<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget for post author box.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_post_template() ) {
	return;
}

// If class `Post_Author_Box` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Author_Box' ) ) {
	/**
	 * Define `Post_Author_Box` class.
	 */
	class Post_Author_Box extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-author-box';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Author Box', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-info-box crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-author-box/';
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
				'crafto-single',
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
				'author',
				'post',
				'info',
				'bio',
				'meta',
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
				'xs'     => esc_html__( 'Extra Small', 'crafto-addons' ),
				'sm'     => esc_html__( 'Small', 'crafto-addons' ),
				'md'     => esc_html__( 'Medium', 'crafto-addons' ),
				'lg'     => esc_html__( 'Large', 'crafto-addons' ),
				'xl'     => esc_html__( 'Extra Large', 'crafto-addons' ),
				'custom' => esc_html__( 'Custom', 'crafto-addons' ),
			];
		}

		/**
		 * Register post author box widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'These are dummy author details; the original author information is taken from the relevant post.', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'crafto_button_text',
				[
					'label'   => esc_html__( 'Text', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'All author posts', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_button_style',
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
				'crafto_button_size',
				[
					'label'          => esc_html__( 'Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'md',
					'options'        => self::get_button_sizes(),
					'style_transfer' => true,
				]
			);
			$this->add_responsive_control(
				'crafto_button_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px'  => [
							'min' => 0,
							'max' => 500,
						],
						'%'   => [
							'min' => 0,
							'max' => 100,
						],
						'em'  => [
							'min' => 0,
							'max' => 100,
						],
						'rem' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_button_size' => 'custom',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_button_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px'  => [
							'min' => 0,
							'max' => 500,
						],
						'%'   => [
							'min' => 0,
							'max' => 100,
						],
						'em'  => [
							'min' => 0,
							'max' => 100,
						],
						'rem' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_button_size' => 'custom',
					],
				]
			);
			$this->add_control(
				'crafto_selected_icon',
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
				'crafto_icon_align',
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
						'crafto_selected_icon[value]!' => '',
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
						'crafto_selected_icon[value]!' => '',
						'crafto_button_style!'         => [
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
						'crafto_selected_icon[value]!' => '',
						'crafto_icon_shape_style!'     => 'default',
						'crafto_button_style!'         => [
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
					],
					'condition'  => [
						'crafto_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_indent',
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
						'crafto_selected_icon[value]!'   => '',
						'crafto_icon_align!'             => 'switch',
						'crafto_button_hover_animation!' => 'btn-switch-icon',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_icon_box_shadow',
					'selector'  => '{{WRAPPER}} .elementor-align-icon-right',
					'condition' => [
						'crafto_icon_shape_style!' => 'default',
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
						'crafto_button_style' => 'expand-border',
					],
				]
			);
			$this->add_control(
				'crafto_button_css_id',
				[
					'label'       => esc_html__( 'Button ID', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'crafto-addons' ),
					'description' => sprintf(
						/* translators: 1: <code> 2: </code>. */
						esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows %1$sA-z 0-9%2$s & underscore chars without spaces.', 'crafto-addons' ),
						'<code>',
						'</code>'
					),
					'separator'   => 'before',
				]
			);
			$this->add_control(
				'crafto_enable_animation',
				[
					'label'        => esc_html__( 'Enable Zoom Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_button_hover_animation',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						'crafto_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_author_box_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_author_box_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .crafto-author-box',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_author_box_shadow',
					'selector' => '{{WRAPPER}} .crafto-author-box',
				]
			);
			$this->add_responsive_control(
				'crafto_author_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-author-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_box_margin',
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
						'{{WRAPPER}} .crafto-author-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_box_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'em',
						'%',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-author-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_author_image',
				[
					'label' => esc_html__( 'Avatar', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_author_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .author-title',
				]
			);
			$this->start_controls_tabs( 'crafto_title_style_tabs' );
				$this->start_controls_tab(
					'crafto_title_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
			$this->add_control(
				'crafto_author_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .author-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_title_style_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_author_title_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .author-title:hover' => 'color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_section_style_author_avatar',
				[
					'label'     => esc_html__( 'Avatar', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_avatar_icon_size',
				[
					'label'   => esc_html__( 'Size', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'range'   => [
						'px' => [
							'min' => 0,
							'max' => 400,
						],
					],
					'default' => [
						'size' => 120,
					],
				]
			);
			$this->add_control(
				'crafto_author_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .author-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_author_content',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_author_text_align',
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
						'{{WRAPPER}} .author-content-meta' => 'text-align: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_author_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .author-description',
				]
			);
			$this->add_control(
				'crafto_author_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .author-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_content_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => '',
						'unit' => 'px',
					],
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 500,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .author-description' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_content_spacing',
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
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .author-description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_author_button',
				[
					'label' => esc_html__( 'Button', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_author_button_display',
				[
					'label'     => esc_html__( 'Display', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''             => esc_html__( 'Default', 'crafto-addons' ),
						'block'        => esc_html__( 'Block', 'crafto-addons' ),
						'inline'       => esc_html__( 'Inline', 'crafto-addons' ),
						'inline-block' => esc_html__( 'Inline Block', 'crafto-addons' ),
						'none'         => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} a.elementor-button' => 'display: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_author_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);
			$this->start_controls_tabs( 'crafto_tabs_button_style' );
			$this->start_controls_tab(
				'crafto_tab_author_button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'     => 'crafto_author_button_text_color',
					'selector' => '{{WRAPPER}} .elementor-button-content-wrapper',
				]
			);
			$this->add_responsive_control(
				'crafto_button_svg_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-button-icon svg, {{WRAPPER}} .btn-icon-round .elementor-button-icon svg, {{WRAPPER}} .btn-icon-circle .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_selected_icon[library]' => 'svg',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_button_icon_color',
					'selector'       => '{{WRAPPER}} .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-round .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-circle .elementor-button-icon i, {{WRAPPER}} .elementor-button-icon svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_selected_icon[library]!' => 'svg',
						'crafto_selected_icon[value]!'   => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto__author_button_border_color',
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
					'name'           => 'crafto_author_button_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-animation-btn-expand-ltr .btn-hover-animation',
					'condition'      => [
						'crafto_button_style!' => [
							'border',
							'double-border',
							'underline',
						],
					],
					'fields_options' => [
						'color' => [
							'responsive' => true,
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_author_button_shape_background_color',
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
						'crafto_button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style'      => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						'crafto_selected_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_author_button_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-button',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tab_author_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'     => 'crafto_author_button_hover_text_color',
					'selector' => '{{WRAPPER}} a.elementor-button:hover .elementor-button-content-wrapper, {{WRAPPER}} a.elementor-button:focus .elementor-button-content-wrapper',
				]
			);
			$this->add_responsive_control(
				'crafto_button_hover_svg_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-icon svg, {{WRAPPER}}  a.elementor-button:hover .btn-icon-round .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_selected_icon[library]' => 'svg',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_button_hover_icon_color',
					'selector'       => '{{WRAPPER}} a.elementor-button:hover i, {{WRAPPER}} a.elementor-button:focus i, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-round:hover .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-circle:hover .elementor-button-icon i',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_selected_icon[library]!' => 'svg',
						'crafto_selected_icon[value]!'   => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_button_hover_border_color',
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
					'name'           => 'crafto_author_button_hover_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'condition'      => [
						'crafto_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
					'fields_options' => [
						'color' => [
							'responsive' => true,
						],
					],
					'selector'       => '{{WRAPPER}} a:not(.elementor-animation-btn-slide-up, .elementor-animation-btn-slide-down, .elementor-animation-btn-slide-left, .elementor-animation-btn-slide-right ).elementor-button:hover, {{WRAPPER}} a:not(.elementor-animation-btn-slide-up, .elementor-animation-btn-slide-down, .elementor-animation-btn-slide-left, .elementor-animation-btn-slide-right ).elementor-button:focus, {{WRAPPER}} a.elementor-animation-btn-slide-down .btn-hover-animation, {{WRAPPER}} a.elementor-animation-btn-slide-up .btn-hover-animation, {{WRAPPER}} a.elementor-animation-btn-slide-left .btn-hover-animation, {{WRAPPER}} a.elementor-animation-btn-slide-up .btn-hover-animation, {{WRAPPER}} a.elementor-animation-btn-slide-right .btn-hover-animation, {{WRAPPER}} a.elementor-animation-btn-slide-up .btn-hover-animation',
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
						'crafto_button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style'      => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						'crafto_selected_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_author_button_hover_box_shadow',
					'selector' => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus',
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
						'crafto_button_style' => [
							'underline',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_author_button_border',
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
						'crafto_button_style!' => [
							'double-border',
							'underline',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button:not(.elementor-animation-btn-expand-ltr), {{WRAPPER}} a.elementor-button.elementor-animation-btn-expand-ltr .btn-hover-animation, {{WRAPPER}} .btn-double-border::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_button_style!' => [
							'underline',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_button_text_padding',
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
						'{{WRAPPER}} a.elementor-button:not(.btn-double-border), {{WRAPPER}} a.btn-double-border .elementor-button-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post author box widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                      = $this->get_settings_for_display();
			$crafto_button_style           = $this->get_settings( 'crafto_button_style' );
			$crafto_icon_align             = $this->get_settings( 'crafto_icon_align' );
			$crafto_enable_animation       = $this->get_settings( 'crafto_enable_animation' );
			$crafto_button_hover_animation = $this->get_settings( 'crafto_button_hover_animation' );
			$crafto_icon_shape_style       = $this->get_settings( 'crafto_icon_shape_style' );

			$crafto_avatar_icon_size = $this->get_settings( 'crafto_avatar_icon_size' );
			$crafto_selected_icon    = $this->get_settings( 'crafto_selected_icon' );
			$crafto_avatar_icon_size = ( isset( $crafto_avatar_icon_size['size'] ) && ! empty( $crafto_avatar_icon_size['size'] ) ) ? $crafto_avatar_icon_size['size'] : '';

			$author_id 		   = get_post_field( 'post_author', get_the_ID() );
			$crafto_author_url = get_author_posts_url( $author_id );

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'elementor-button-wrapper',
							'crafto-button-wrapper',
						],
					],
				],
			);

			if ( 'yes' === $crafto_enable_animation ) {
				$this->add_render_attribute(
					[
						'wrapper' => [
							'class' => 'animation-zoom',
						],
					],
				);
			}
			$this->add_render_attribute(
				[
					'button' => [
						'class' => [
							'elementor-button',
							'btn-icon-' . $settings['crafto_icon_align'],
						],
						'role'  => 'button',
						'href'  => $crafto_author_url,
					],
				],
			);
			if ( 'double-border' === $crafto_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-double-border',
						],
					],
				);
			}
			if ( 'border' === $crafto_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-border',
						],
					],
				);
			}
			if ( 'underline' === $crafto_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-underline',
						],
					],
				);
			}
			if ( 'expand-border' === $crafto_button_style ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'elementor-animation-btn-expand-ltr',
						],
					],
				);
			}
			if ( 'btn-reveal-icon' === $crafto_button_hover_animation && 'left' === $crafto_icon_align ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-reveal-icon-left',
						],
					],
				);
			}

			if ( '' === $crafto_button_style || 'border' === $crafto_button_style ) {
				if ( ! empty( $crafto_selected_icon['value'] ) ) {
					$this->add_render_attribute( 'button', 'class', $crafto_icon_shape_style );
				}
			}

			if ( ! empty( $settings['crafto_button_css_id'] ) ) {
				$this->add_render_attribute( 'button', 'id', $settings['crafto_button_css_id'] );
			}

			if ( ! empty( $settings['crafto_button_size'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['crafto_button_size'] );
			}

			/* Button hover animation */
			$custom_animation_class       = '';
			$custom_animation_div         = '';
			$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();

			if ( ! empty( $hover_animation_effect_array ) && ! empty( $crafto_button_hover_animation ) ) {
				if ( '' === $crafto_button_style || 'border' === $crafto_button_style ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $crafto_button_hover_animation );
				}
				if ( in_array( $crafto_button_hover_animation, $hover_animation_effect_array, true ) ) {
					$custom_animation_class = 'btn-custom-effect';

					if ( ! in_array( $crafto_button_hover_animation, array( 'btn-switch-icon', 'btn-switch-text' ), true ) ) {
						$custom_animation_div = '<span class="btn-hover-animation"></span>';
					}
				}
			}

			if ( 'expand-border' === $crafto_button_style ) {
				$custom_animation_div = '<span class="btn-hover-animation"></span>';
			}
			$this->add_render_attribute( 'button', 'class', $custom_animation_class );

			if ( crafto_is_editor_mode() ) {
				$alt = esc_html__( 'Author Avatar', 'crafto-addons' ); // phpcs:ignore
				$post_thumbanail = sprintf(
					'<img src="%1$s" alt="%2$s" width="' . $crafto_avatar_icon_size . '" height="' . $crafto_avatar_icon_size . '"/>',
					Utils::get_placeholder_image_src(),
					$alt // phpcs:ignore
				);
				?>
				<div class="crafto-author-box">
					<div class="avtar-image-meta text-center">
						<a href="<?php echo esc_url( trailingslashit( get_home_url() ) ); ?>" class="author-avatar">
							<?php echo $post_thumbanail; // phpcs:ignore ?>
						</a>
						<a href="<?php echo esc_url( trailingslashit( get_home_url() ) ); ?>" class="author-title">
							<?php echo esc_html__( 'Author', 'crafto-addons' ); ?>
						</a>
					</div>
					<div class="author-content-meta">
						<?php echo '<p class="author-description">This is a dummy text to demonstration purposes. It will be replaced with the author description. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi scelerisque luctus velit. Etiam quis quam. Duis viverra diam non justo.</p>'; // phpcs:ignore ?>
						<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
							<a <?php $this->print_render_attribute_string( 'button' ); ?>>
								<?php
									$this->render_button_text();
									echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
								?>
							</a>
						</div>
					</div>
				</div>
				<?php
			} else {

				$crafto_author_decription = get_the_author_meta( 'description', get_post_field( 'post_author', get_the_ID() ) );
				$crafto_display_name      = get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) );
				$crafto_user_email        = get_the_author_meta( 'user_email', get_post_field( 'post_author', get_the_ID() ) );
				$crafto_author_alt        = $crafto_display_name ? $crafto_display_name : esc_html__( 'Author', 'crafto-addons' );

				if ( (bool) $crafto_author_decription ) { // phpcs:ignore

					/**
					 * Filter to modify author avatar size
					 *
					 * @since 1.0
					 */
					$crafto_author_avatar_size = apply_filters( 'crafto_author_avatar_size', $crafto_avatar_icon_size );
					?>
					<div class="crafto-author-box">
						<div class="avtar-image-meta">
							<a href="<?php echo esc_url( $crafto_author_url ); ?>" class="author-avatar">
								<?php echo get_avatar( $crafto_user_email, $crafto_author_avatar_size, '', $crafto_author_alt ); ?>
							</a>
							<a href="<?php echo esc_url( $crafto_author_url ); ?>" class="author-title">
								<?php echo esc_html( $crafto_author_alt ); ?>
							</a>
						</div>
						<div class="author-content-meta">
							<p class="author-description"><?php echo esc_html( $crafto_author_decription ); ?></p>
							<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
								<a <?php $this->print_render_attribute_string( 'button' ); ?>>	
									<?php
									$this->render_button_text();
									echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
									?>
								</a>
							</div>
						</div>
					</div>
					<?php
				}
			}
		}

		/**
		 * Render button widget text.
		 *
		 * @access protected
		 */
		protected function render_button_text() {
			$settings                      = $this->get_settings_for_display();
			$crafto_button_hover_animation = $settings['crafto_button_hover_animation'];
			$migrated                      = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new                        = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! $is_new && empty( $settings['crafto_icon_align'] ) ) {
				// @todo: remove when deprecated
				// added as bc in 2.6
				// old default
				$settings['crafto_icon_align'] = $this->get_settings( 'crafto_icon_align' );
			}

			$this->add_render_attribute(
				[
					'content-wrapper'    => [
						'class' => 'elementor-button-content-wrapper',
					],
					'icon-align'         => [
						'class' => [
							'elementor-button-icon',
						],
					],
					'crafto_button_text' => [
						'class' => 'elementor-button-text',
					],
				],
			);

			if ( 'btn-switch-icon' !== $crafto_button_hover_animation && $settings['crafto_icon_align'] ) {
				$this->add_render_attribute(
					[
						'icon-align' => [
							'class' => [
								'elementor-align-icon-' . $settings['crafto_icon_align'],
							],
						],
					],
				);
			}

			if ( 'btn-switch-text' === $crafto_button_hover_animation && $settings['crafto_button_text'] ) {
				$this->add_render_attribute(
					[
						'crafto_button_text' => [
							'data-btn-text' => wp_strip_all_tags( $settings['crafto_button_text'] ),
						],
					],
				);
			}

			$this->add_inline_editing_attributes( 'crafto_button_text', 'none' );
			?>
			<div <?php $this->print_render_attribute_string( 'content-wrapper' ); ?>>
				<?php
				if ( ! empty( $settings['crafto_button_text'] ) ) {
					?>
					<span <?php $this->print_render_attribute_string( 'crafto_button_text' ); ?>><?php echo esc_html( $settings['crafto_button_text'] ); ?></span>
					<?php
				}

				if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_selected_icon']['value'] ) ) {
					?>
					<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
						?>
					</span>
					<?php
				}

				if ( 'btn-switch-icon' === $crafto_button_hover_animation ) {
					if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_selected_icon']['value'] ) ) {
						?>
						<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
							} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
								?>
								<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
								<?php
							}
							?>
						</span>
						<?php
					}
				}
				?>
			</div>
			<?php
		}
	}
}
