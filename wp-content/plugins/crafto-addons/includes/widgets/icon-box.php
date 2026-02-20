<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Button_Group_Control;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget for icon box.
 *
 * @package Crafto
 */

// If class 'Icon_Box' doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Icon_Box' ) ) {
	/**
	 * Define 'Icon_Box' class.
	 */
	class Icon_Box extends Widget_Base {
		/**
		 * Retrieve the list of styles the icon box widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$icon_box_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$icon_box_styles[] = 'crafto-vendors-rtl';
				} else {
					$icon_box_styles[] = 'crafto-vendors';
				}
			} else {
				if ( is_rtl() ) {
					$icon_box_styles[] = 'crafto-icon-box-rtl-widget';
				}
				$icon_box_styles[] = 'crafto-icon-box-widget';
			}
			return $icon_box_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve icon box widget name.
		 */
		public function get_name() {
			return 'crafto-icon-box';
		}

		/**
		 * Get widget title.
		 * Retrieve icon box widget title.
		 *
		 * @access public
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Icon Box', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 * Retrieve icon box widget icon.
		 *
		 * @access public
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-icon-box crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/icon-box/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
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
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [				
				'text',
				'info',
				'service',
			];
		}

		/**
		 * Register icon box widget controls.
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_icon',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_item_use_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
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
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_item_use_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_item_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_item_use_image' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'condition' => [
						'crafto_item_use_image' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'condition'    => [
						'crafto_item_use_image' => '',
					],
					'default'      => 'default',
					'prefix_class' => 'elementor-view-',
				]
			);

			$this->add_control(
				'crafto_shape',
				[
					'label'        => esc_html__( 'Shape', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => esc_html__( 'Circle', 'crafto-addons' ),
						'square' => esc_html__( 'Square', 'crafto-addons' ),
					],
					'default'      => 'circle',
					'condition'    => [
						'crafto_view!'                 => 'default',
						'crafto_selected_icon[value]!' => '',
						'crafto_item_use_image[value]' => '',
					],
					'prefix_class' => 'elementor-shape-',
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
					'condition'    => [
						'crafto_selected_icon[value]!'  => '',
						'crafto_item_use_image[value]!' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_title_text',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'This is the heading', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Enter your title', 'crafto-addons' ),
					'description' => esc_html__( 'Use || to break the word in new line.', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_flash_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_description_text',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'show_label'  => true,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Enter your description', 'crafto-addons' ),
					'rows'        => 10,
					'separator'   => 'none',
				]
			);
			$this->add_control(
				'crafto_enable_box_link',
				[
					'label'        => esc_html__( 'Enable Full Box Link', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
					'separator'    => 'before',
				]
			);
			$this->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Title Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_box_link' => '',
					],
				]
			);
			$this->add_control(
				'crafto_box_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_enable_box_link' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_title_size',
				[
					'label'   => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default' => 'h3',
				]
			);
			$this->end_controls_section();

			Button_Group_Control::button_content_fields(
				$this,
				[
					'id'      => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => '',
					'repeat'  => 'no',
				],
			);
			$this->start_controls_section(
				'crafto_section_style_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_position',
				[
					'label'          => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'           => Controls_Manager::CHOOSE,
					'default'        => 'top',
					'mobile_default' => '',
					'options'        => [
						'left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'top'   => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'prefix_class'   => 'elementor%s-position-',
					'toggle'         => true,
					'conditions'     => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'crafto_selected_icon[value]',
								'operator' => '!==',
								'value'    => '',
							],
							[
								'name'     => 'crafto_item_use_image',
								'operator' => '===',
								'value'    => 'yes',
							],
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_vertical_alignment',
				[
					'label'        => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'top',
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
					'conditions'   => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_selected_icon[value]',
										'operator' => '!==',
										'value'    => '',
									],
									[
										'name'     => 'crafto_position',
										'operator' => '!==',
										'value'    => 'top',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_item_use_image',
										'operator' => '===',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_position',
										'operator' => '!==',
										'value'    => 'top',
									],
								],
							],
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
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
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-icon-box-wrapper, {{WRAPPER}} .crafto-image-box-wrapper'  => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_box_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-icon-box-wrapper, {{WRAPPER}} .crafto-image-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_icon',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_selected_icon[value]!' => '',
						'crafto_item_use_image'        => '',
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
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_icon_color',
					'selector'       => '{{WRAPPER}}.elementor-view-default .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-framed .elementor-icon i, {{WRAPPER}}.elementor-view-default .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg, {{WRAPPER}}.elementor-view-framed .elementor-icon svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'stacked',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => [
							'default',
							'stacked',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => [
							'default',
						],
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
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_hover_icon_color',
					'selector'       => '{{WRAPPER}}.elementor-view-default:hover .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon i, {{WRAPPER}}.elementor-view-default:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_hover_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'stacked',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_hover_animation',
				[
					'label' => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_icon_box_separator',
				[
					'type' => Controls_Manager::DIVIDER,
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
							'min' => 6,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_max_width',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => 'default',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_space',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 15,
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}' => '--icon-box-icon-margin: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-top .elementor-icon-box-icon ' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-left .elementor-icon-box-icon ' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-right .elementor-icon-box-icon ' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_rotate',
				[
					'label'      => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'deg',
						'grad',
						'rad',
						'turn',
						'custom',
					],
					'default'    => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_icon_box_shadow',
					'selector'  => '{{WRAPPER}} .elementor-icon',
					'condition' => [
						'crafto_view!' => 'default',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_use_image' => 'yes',
					],
				]
			);

			$this->add_control(
				'crafto_heading_image_box',
				[
					'label' => esc_html__( 'Image Box', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_image_box_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .crafto-image-box-wrapper .crafto-image-box-img',
				]
			);
			$this->add_responsive_control(
				'crafto_image_box_size',
				[
					'label'          => esc_html__( 'Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => '',
						'unit' => 'px',
					],
					'tablet_default' => [
						'unit' => 'px',
					],
					'mobile_default' => [
						'unit' => 'px',
					],
					'size_units'     => [
						'px',
						'custom',
					],
					'selectors'      => [
						'{{WRAPPER}} .crafto-image-box-wrapper .crafto-image-box-img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_space',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 15,
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-position-right .crafto-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.elementor-position-left .crafto-image-box-img'  => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.elementor-position-top .crafto-image-box-img'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-left .crafto-image-box-img'  => 'margin-inline-end: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-right .crafto-image-box-img' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_image_box_border',
					'selector' => '{{WRAPPER}} .crafto-image-box-wrapper .crafto-image-box-img',
				]
			);
			$this->add_responsive_control(
				'crafto_image_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-image-box-wrapper .crafto-image-box-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_image_size',
				[
					'label'          => esc_html__( 'Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => '',
						'unit' => 'px',
					],
					'tablet_default' => [
						'unit' => 'px',
					],
					'mobile_default' => [
						'unit' => 'px',
					],
					'size_units'     => [
						'px',
						'custom',
					],
					'selectors'      => [
						'{{WRAPPER}} .crafto-image-box-wrapper .crafto-image-box-img img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_height_size',
				[
					'label'          => esc_html__( 'Height', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => '',
						'unit' => 'px',
					],
					'tablet_default' => [
						'unit' => 'px',
					],
					'mobile_default' => [
						'unit' => 'px',
					],
					'size_units'     => [
						'px',
						'custom',
					],
					'selectors'      => [
						'{{WRAPPER}} .crafto-image-box-wrapper .crafto-image-box-img img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_content',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_heading_title',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_title_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_title_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title, {{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a',
					'condition' => [
						'crafto_title_text!' => '',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_title_styles_tabs' );
			$this->start_controls_tab(
				'crafto_title_color_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_title_text!' => '',
						'crafto_link[url]!'  => '',
					],
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_title_text!' => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_title_hover_color_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_title_text!' => '',
						'crafto_link[url]!'  => '',
					],
				]
			);
			$this->add_control(
				'crafto_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_link[url]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_title_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title a:hover'   => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_link[url]!' => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_icon_title_divider',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_title_text!' => '',
						'crafto_link[url]!'  => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_bottom_space',
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
						'{{WRAPPER}} .elementor-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_title_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_width',
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
							'min'  => 0,
							'max'  => 500,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-box-title span, {{WRAPPER}} .elementor-icon-box-title a' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_title_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_title_border',
					'selector'  => '{{WRAPPER}} .elementor-icon-box-title a',
					'condition' => [
						'crafto_link[url]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_display_settings',
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
						'{{WRAPPER}} .elementor-icon-box-title' => 'display: {{VALUE}}',
					],
					'condition' => [
						'crafto_title_text!' => '',
						'crafto_title_size'  => 'span',
					],
				]
			);
			$this->add_control(
				'crafto_flash_text_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_heading_flash_lable',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_flash_typography',
					'selector'  => '{{WRAPPER}} .flash-lable',
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->start_controls_tabs( 'label_colors' );
			$this->start_controls_tab(
				'crafto_label_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flash_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .flash-lable' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_flash_background_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .flash-lable',
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_hover_colors',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flash_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-crafto-icon-box:hover .flash-lable' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_flash_background_hover_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}}.elementor-widget-crafto-icon-box:hover .flash-lable',
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_icon_box_label_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_label_shape_size',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-crafto-icon-box .flash-lable' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_label_flash_shadow',
					'selector'  => '{{WRAPPER}} .flash-lable',
					'separator' => 'before',
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_flash_border',
					'selector'  => '{{WRAPPER}} .flash-lable',
					'condition' => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flash_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .flash-lable' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flash_padding',
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
						'{{WRAPPER}} .flash-lable' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flash_margin',
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
						'{{WRAPPER}} .flash-lable' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flash_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_description_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_title_text!'       => '',
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_heading_description',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_description_typography',
					'selector'  => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description',
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_description_styles_tabs' );

			$this->start_controls_tab(
				'crafto_description_color_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_description_link_color',
				[
					'label'     => esc_html__( 'Link Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description a' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_description_hover_color_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_description_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-crafto-icon-box:hover .elementor-icon-box-description' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_description_link_hover_color',
				[
					'label'     => esc_html__( 'Link Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description a:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'description_hr',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_description_width',
				[
					'label'      => esc_html__( 'Content Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_description_bottom_space',
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
						'{{WRAPPER}} .elementor-icon-box-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_description_text!' => '',
					],
				]
			);
			$this->end_controls_section();
			Button_Group_Control::button_style_fields(
				$this,
				[
					'id'    => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
			);
			$this->start_controls_section(
				'crafto_iconbox_verticalbar_style',
				[
					'label' => esc_html__( 'Sticky Bar', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_iconbox_verticalbar_block',
					'selector' => '{{WRAPPER}} .verticalbar-wrap',
				]
			);
			$this->add_control(
				'crafto_iconbox_default_veticalbar_color',
				[
					'label'     => esc_html__( 'Default Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'.verticalbar-wrap .elementor-widget-crafto-icon-box .elementor-icon, .verticalbar-wrap .elementor-widget-crafto-icon-box .elementor-icon-box-title, .verticalbar-wrap .elementor-icon-box-description a'  => 'color: {{VALUE}} !important;',
						'.verticalbar-wrap .elementor-widget-crafto-icon-box .elementor-icon-box-description a' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_iconbox_verticalbar_highlight_color',
				[
					'label'       => esc_html__( 'Highlight Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'default'     => '',
					'selectors'   => [
						'.verticalbar-wrap.verticalbar-highlight .elementor-widget-crafto-icon-box .elementor-icon, .verticalbar-wrap.verticalbar-highlight .elementor-widget-crafto-icon-box .elementor-icon-box-title, .verticalbar-wrap.verticalbar-highlight .elementor-widget-crafto-icon-box .elementor-icon-box-description a' => 'color: {{VALUE}} !important;',
						'.verticalbar-wrap.verticalbar-highlight .elementor-widget-crafto-icon-box .elementor-icon-box-description a' => 'border-color: {{VALUE}};',
					],
					'description' => esc_html__( 'This will be applicable in header only.', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render icon box widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings  = $this->get_settings_for_display();
			$icon_tag  = 'span';
			$has_icon  = ! empty( $settings['icon'] );
			$animation = ( 'yes' === $settings['crafto_enable_animation'] ) ? 'animation-zoom' : '';

			$this->add_render_attribute(
				'icon',
				'class',
				[
					'elementor-icon',
					'elementor-animation-' . $settings['crafto_hover_animation'],
				]
			);

			if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
				$settings['icon'] = 'fa fa-star';
			}

			if ( ! empty( $settings['crafto_link']['url'] ) ) {
				$icon_tag = 'a';
				$this->add_link_attributes( 'crafto_link', $settings['crafto_link'] );
				$this->add_render_attribute( 'crafto_link', 'title', $settings['crafto_link']['url'] );
			}

			if ( $has_icon ) {
				$this->add_render_attribute( 'i', 'class', $settings['icon'] );
				$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
			}

			$icon_attributes = $this->get_render_attribute_string( 'icon' );
			$link_attributes = $this->get_render_attribute_string( 'crafto_link' );

			$this->add_render_attribute( 'crafto_description_text', 'class', 'elementor-icon-box-description' );

			$this->add_inline_editing_attributes( 'crafto_title_text', 'none' );
			$this->add_inline_editing_attributes( 'crafto_description_text' );

			if ( ! $has_icon && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				$has_icon = true;
			}

			$migrated = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new   = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $has_icon ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					[
						'elementor-icon-box-wrapper',
						'crafto-icon-box-wrapper',
					],
				);
				$this->add_render_attribute(
					'inner_wrapper',
					'class',
					[
						'elementor-icon-box-icon',
						$animation,
					],
				);
			} else {
				$this->add_render_attribute(
					'wrapper',
					'class',
					[
						'crafto-image-box-wrapper',
					],
				);
				$this->add_render_attribute(
					'inner_wrapper',
					'class',
					[
						'crafto-image-box-img',
					],
				);
			}

			$icon = '';
			ob_start();
			if ( ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				?>
				<<?php echo implode( ' ', [ $icon_tag, $icon_attributes, $link_attributes ] ); // phpcs:ignore ?>>
				<?php
			}
			if ( $is_new || $migrated ) {
				Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
			} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				echo '<i class="' . esc_attr( $settings['crafto_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
			if ( ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				?>
				</<?php echo $icon_tag; // phpcs:ignore ?>>
				<?php
			}
			$icon .= ob_get_clean();

			$crafto_title_text = isset( $settings['crafto_title_text'] ) && ! empty( $settings['crafto_title_text'] ) ? str_replace( '||', '<br />', $settings['crafto_title_text'] ) : '';
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				if ( 'yes' === $settings['crafto_enable_box_link'] ) {
					$this->add_link_attributes( '_boxlink', $settings['crafto_box_link'] );
					$this->add_render_attribute( '_boxlink', 'class', 'box-link' );
					if ( ! empty( $settings['crafto_box_link']['url'] ) ) {
						?>
						<a <?php $this->print_render_attribute_string( '_boxlink' ); ?>>
							<span class="screen-reader-text"><?php echo esc_html( $crafto_title_text ? $crafto_title_text : __( 'Read More', 'crafto-addons' ) ); ?></span>
						</a>
						<?php
					}
				}
				if ( ! empty( $settings['crafto_selected_icon']['value'] ) || ! empty( $settings['crafto_item_image'] ) ) {
					?>
					<div <?php $this->print_render_attribute_string( 'inner_wrapper' ); ?>>
						<?php
						if ( 'yes' === $settings['crafto_item_use_image'] ) {
							if ( ! empty( $settings['crafto_item_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_item_image']['id'] ) ) {
								$settings['crafto_item_image']['id'] = '';
							}
							if ( isset( $settings['crafto_item_image'] ) && isset( $settings['crafto_item_image']['id'] ) && ! empty( $settings['crafto_item_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_item_image']['id'], $settings['crafto_item_image']['url'], $settings['crafto_thumbnail_size'] );
							} elseif ( isset( $settings['crafto_item_image'] ) && isset( $settings['crafto_item_image']['url'] ) && ! empty( $settings['crafto_item_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_item_image']['id'], $settings['crafto_item_image']['url'], $settings['crafto_thumbnail_size'] );
							}
						} else {
							echo $icon; // phpcs:ignore
						}
						?>
					</div>
					<?php
				}
				if ( ! empty( $settings['crafto_flash_text'] ) ) {
					?>
					<div class="flash-lable">
						<?php echo esc_html( $settings['crafto_flash_text'] ); ?>
					</div>
					<?php
				}
				?>
				<div class="elementor-icon-box-content">
					<?php
					if ( ! empty( $crafto_title_text ) ) {
						?>
						<<?php echo $settings['crafto_title_size']; // phpcs:ignore ?> class="elementor-icon-box-title">
							<<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); $this->print_render_attribute_string( 'crafto_title_text' ); // phpcs:ignore ?>>
							<?php echo sprintf( '%s', wp_kses_post( $crafto_title_text ) ); // phpcs:ignore?>
							</<?php echo $icon_tag; // phpcs:ignore ?>>
						</<?php echo $settings['crafto_title_size']; // phpcs:ignore ?>>
						<?php
					}
					if ( ! Utils::is_empty( $settings['crafto_description_text'] ) ) :
						?>
						<p <?php $this->print_render_attribute_string( 'crafto_description_text' ); ?>>
							<?php echo sprintf( '%s', $settings['crafto_description_text'] );// phpcs:ignore ?>
						</p>
						<?php
					endif;
					Button_Group_Control::render_button_content( $this, 'primary' );
					?>
				</div>
			</div>
			<?php
		}

		/**
		 * Icon box widget backend elementor preview.
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
			<#
			var icon_tag = 'span';
			var icon_tag_a   = 'span';
			var has_icon = settings.crafto_selected_icon && settings.crafto_selected_icon.value;
			var animation = ( 'yes' === settings.crafto_enable_animation ) ? 'animation-zoom' : '';

			// button START
			const button_style = settings.crafto_primary_button_style;
			const button_hover_animation = settings.crafto_primary_button_hover_animation;
			const button_icon_align = settings.crafto_primary_button_icon_align;
			const icon_shape_style = settings.crafto_primary_icon_shape_style;

			view.addRenderAttribute( 'crafto_primary_btn_wrapper', 'class', [
				'elementor-button-wrapper',
				'crafto-button-wrapper',
				'crafto-primary-wrapper',
			]);

			var custom_animation_class       = '';
			var custom_animation_div         = '';
			const hover_animation_effect_array = [
				'btn-slide-up',
				'btn-slide-down',
				'btn-slide-left',
				'btn-slide-right',
				'btn-switch-icon',
				'btn-switch-text',
				'btn-reveal-icon',
			];

			if ( '' == button_style || 'border' == button_style ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'elementor-animation-' + button_hover_animation,
					icon_shape_style,
				]);
			}

			if ( button_hover_animation ) {
				if ( hover_animation_effect_array.includes( button_hover_animation ) ) {
					custom_animation_class = 'btn-custom-effect';
					if ( !['btn-switch-icon', 'btn-switch-text'].includes( button_hover_animation ) ) {
						custom_animation_div = '<span class="btn-hover-animation"></span>';
					}
				}
			}
			view.addRenderAttribute( 'crafto_primary_button', 'class', [
				custom_animation_class,
			]);

			if ( 'btn-reveal-icon' == button_hover_animation && 'left' === button_icon_align ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'btn-reveal-icon-left',
				]);
			}

			if ( 'border' == button_style ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'btn-border',
				]);
			}

			if ( 'double-border' == button_style ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'btn-double-border',
				]);
			}

			if ( 'underline' == button_style ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'btn-underline',
				]);
			}

			if ( 'expand-border' == button_style ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'elementor-animation-btn-expand-ltr',
				]);
			}

			if ( settings.crafto_primary_button_link.url ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'elementor-button-link',
				]);

				view.addRenderAttribute( 'crafto_primary_button', 'href', [
					settings.crafto_primary_button_link.url,
				]);

				if ( settings.crafto_primary_button_link.is_external ) {
					view.addRenderAttribute( 'crafto_primary_button', 'target', [
						'_blank',
					]);
				}

				if ( settings.crafto_primary_button_link.nofollow ) {
					view.addRenderAttribute( 'crafto_primary_button', 'rel', [
						'nofollow',
					]);
				}
			}

			if ( settings.crafto_primary_button_size ) {
				view.addRenderAttribute( 'crafto_primary_button', 'class', [
					'elementor-size-' + settings.crafto_primary_button_size,
				]);
			}

			view.addRenderAttribute( 'crafto_primary_button', 'class', [
				'elementor-button',
				'crafto_primary_button',
				'btn-icon-' + button_icon_align,
			]);

			view.addRenderAttribute( 'crafto_primary_button', 'role', [
				'button',
			]);

			if ( 'expand-border' == button_style ) {
				custom_animation_div = '<span class="btn-hover-animation"></span>';
			}

			view.addRenderAttribute({
				[`crafto_primary_content-wrapper`]: {
					class: 'elementor-button-content-wrapper',
				},
				[`crafto_primary_icon-align`]: {
					class: [
						'elementor-button-icon',
					],
				},
				[`crafto_primary_text`]: {
					class: 'elementor-button-text',
				},
			});

			if ( 'btn-switch-icon' != button_hover_animation && settings.crafto_primary_button_icon_align ) {
				view.addRenderAttribute({
					[`crafto_primary_icon-align`]: {
						class: [
							'elementor-align-icon-' + settings.crafto_primary_button_icon_align,
						],
					},
				});
			}

			if ( 'btn-switch-text' === button_hover_animation ) {
				view.addRenderAttribute({
					[`crafto_primary_text`]: {
						'data-btn-text': settings.crafto_primary_button_text,
					},
				});
			}

			var iconbuttonHTML = elementor.helpers.renderIcon( view, settings.crafto_primary_selected_icon, { 'aria-hidden': true }, 'i', 'object' );
			var buttonmigrated = elementor.helpers.isIconMigrated( settings, 'crafto_primary_selected_icon' );

			// button END

			if ( settings.crafto_link && settings.crafto_link.url ) {
				icon_tag_a = 'a';
				view.addRenderAttribute( 'crafto_link', 'href', settings.crafto_link.url );
				view.addRenderAttribute( 'crafto_link', 'title', settings.crafto_link.url );
			}

			var iconHTML = elementor.helpers.renderIcon( view, settings.crafto_selected_icon, { 'aria-hidden': true }, 'i', 'object' );
			var migrated = elementor.helpers.isIconMigrated( settings, 'crafto_selected_icon' );

			if ( has_icon && settings.crafto_item_use_image === '' ) {
				view.addRenderAttribute( 'wrapper', 'class', [
					'elementor-icon-box-wrapper',
					'crafto-icon-box-wrapper',
				]);

				view.addRenderAttribute( 'inner_wrapper', 'class', [
					'elementor-icon-box-icon',
					animation,
				]);
			} else {
				view.addRenderAttribute( 'wrapper', 'class', [
					'crafto-image-box-wrapper'
				]);

				view.addRenderAttribute( 'inner_wrapper', 'class', [
					'crafto-image-box-img',
				]);
			}
			#>
			<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
				<# if ( settings.crafto_item_use_image === 'yes' ) { #>
					<div {{{ view.getRenderAttributeString( 'inner_wrapper' ) }}}>
						<img src="{{ settings.crafto_item_image.url }}" alt="{{ settings.crafto_item_image.alt || '' }}" class="swiper-slide-image" />
					</div>
				<# } else {
					if ( iconHTML && iconHTML.rendered && ( !settings.icon || migrated ) ) {
						#>
						<div {{{ view.getRenderAttributeString( 'inner_wrapper' ) }}}>
							<{{{ icon_tag }}} class="elementor-icon">
								{{{ elementor.helpers.sanitize( iconHTML.value ) }}}
							</{{{ icon_tag }}}>
						</div>
						<#
					} else {
						#>
						<{{{ icon_tag }}} {{{ view.getRenderAttributeString('crafto_link') }}} {{{ view.getRenderAttributeString('icon') }}}>
						<div {{{ view.getRenderAttributeString( 'inner_wrapper' ) }}}>
							<{{{ icon_tag }}} class="elementor-icon">
								<# if ( settings.crafto_selected_icon ) { #>
									<i class="{{ settings.crafto_selected_icon.value }}" aria-hidden="true"></i>
								<# } #>
							</{{{ icon_tag }}}>
						</div>
						<#
					}
				} #>

				<# if ( settings.crafto_flash_text ) { #>
					<div class="flash-lable">
						{{{ settings.crafto_flash_text }}}
					</div>
				<# } #>

				<div class="elementor-icon-box-content">
					<# if ( settings.crafto_title_text ) { #>
						<{{{ settings.crafto_title_size }}} class="elementor-icon-box-title">
							<{{{ icon_tag_a }}} {{{ view.getRenderAttributeString( 'crafto_link' ) }}} >
								{{{ settings.crafto_title_text.replace(/\|\|/g, '<br />') }}}
							</{{{ icon_tag_a }}} >
						</{{{ settings.crafto_title_size }}}>
					<# } #>

					<# if ( settings.crafto_description_text ) { #>
						<p class="elementor-icon-box-description">
							{{{ settings.crafto_description_text }}}
						</p>
					<# } #>

					<# if ( settings.crafto_primary_button_text || settings.icon || settings.crafto_primary_selected_icon.value ) { #>
						<div {{{ view.getRenderAttributeString( 'crafto_primary_btn_wrapper' ) }}} >
							<a {{{ view.getRenderAttributeString( 'crafto_primary_button' ) }}} >
							<span {{{ view.getRenderAttributeString( 'crafto_primary_content-wrapper' ) }}} >

								<# if ( settings.crafto_primary_button_text ) { #>
									<span {{{ view.getRenderAttributeString( 'crafto_primary_text' ) }}} >
										{{{ settings.crafto_primary_button_text }}}
									</span>
								<# } #>

								<# if ( settings.crafto_primary_selected_icon.value ) {  #>
								<span {{{ view.getRenderAttributeString( 'crafto_primary_icon-align' ) }}} >
									<# if ( iconbuttonHTML && iconbuttonHTML.rendered && iconbuttonHTML.value ) { #>
											{{{ elementor.helpers.sanitize( iconbuttonHTML.value ) }}}
									<# } else { #>
										<i class="{{{ settings.crafto_primary_selected_icon.value }}}" aria-hidden="true"></i>
									<# } #>
								</span>
								<# } #>

								<# if ( 'btn-switch-icon' == button_hover_animation ) {  #>
									<# if ( settings.crafto_primary_selected_icon.value ) {  #>
									<span {{{ view.getRenderAttributeString( 'crafto_primary_icon-align' ) }}} >
										<# if ( iconbuttonHTML && iconbuttonHTML.rendered && iconbuttonHTML.value ) { #>
											{{{ elementor.helpers.sanitize( iconbuttonHTML.value ) }}}
										<# } else { #>
											<i class="{{{ settings.crafto_primary_selected_icon.value }}}" aria-hidden="true"></i>
										<# } #>
									</span>
									<# } #>
								<# } #>
							</span>
							{{{ custom_animation_div }}}
							</a>
						</div>
					<# } #>
				</div>
			</div>
			<?php
		}
	}
}
