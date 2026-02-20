<?php
namespace CraftoAddons\Classes;

use CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

/**
 * Extend Section Features
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Section_Extended` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Section_Extended' ) ) {

	/**
	 * Define Section_Extended class
	 */
	class Section_Extended {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'crafto_scrolling_animation_section_tab' ], 10, 2 );
			add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'crafto_entrance_animation_section_tab' ], 10, 2 );
			add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'crafto_float_animation_section_tab' ], 10, 2 );
			add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'crafto_width_expand_animation_section_tab' ], 10, 2 );
			add_action( 'elementor/element/container/section_layout/after_section_end', [ $this, 'crafto_add_section_crafto_settings_tab' ], 10, 2 );

			add_action( 'elementor/frontend/container/before_render', [ $this, 'crafto_before_section_render' ], 10, 2 );
			add_action( 'elementor/frontend/container/before_render', [ $this, 'crafto_before_float_animation_render' ], 10, 2 );
			add_action( 'elementor/frontend/container/before_render', [ $this, 'crafto_expand_width_animation_render' ], 10, 2 );

			add_action( 'elementor/element/container/section_background/before_section_end', [ $this, 'crafto_blur_section_tab' ], 10, 2 );
			add_action( 'elementor/element/container/section_shape_divider/before_section_end', [ $this, 'crafto_additional_color_render' ], 10, 2 );

		}
		/**
		 * Custom Color Shapes
		 *
		 * @since 1.0
		 * @param object $control_stack Widget data.
		 * @access public
		 */
		public function crafto_additional_color_render( $control_stack ) {
			// Bottom.
			$control_stack->start_injection(
				[
					'at' => 'before',
					'of' => 'shape_divider_bottom_width',
				]
			);

			$control_stack->add_control(
				'crafto_custom_shape_bottom_color2',
				[
					'label'     => esc_html__( 'Color 2', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-shape-bottom .elementor-shape-fill:nth-child(2)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
					],
					'condition' => [
						'shape_divider_bottom!' => '',
					],
				]
			);

			$control_stack->end_injection();

			// Top.
			$control_stack->start_injection(
				[
					'at' => 'before',
					'of' => 'shape_divider_top_width',
				]
			);

			$control_stack->add_control(
				'crafto_custom_shape_top_color2',
				[
					'label'     => esc_html__( 'Color 2', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-shape-top .elementor-shape-fill:nth-child(2)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
					],
					'condition' => [
						'shape_divider_top!' => '',
					],
				]
			);

			$control_stack->end_injection();

			// Bottom shape animation.
			$control_stack->start_injection(
				[
					'at' => 'after',
					'of' => 'shape_divider_bottom_above_content',
				]
			);

			$control_stack->end_injection();

			// Top shape animation.
			$control_stack->start_injection(
				[
					'at' => 'after',
					'of' => 'shape_divider_top_above_content',
				]
			);

			$control_stack->end_injection();
		}

		/**
		 *  Crafto Animation Options ( Scrolling Animation )
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_scrolling_animation_section_tab( $element ) {
			if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
				Crafto_Common_Animation_Group::add_scrolling_animation_controls( $element );
			}
		}

		/**
		 *  Crafto Advanced Section.
		 *
		 * @since 1.0
		 * @param object $element Sticky Bar on Home Page Onlyt Section data.
		 * @access public
		 */
		public function crafto_add_section_crafto_settings_tab( $element ) {

			global $post;

			$element->start_controls_section(
				'crafto_advanced_settings_tab_style',
				[
					'label' => esc_html__( 'Section Options', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_LAYOUT,
				]
			);
			$element->add_control(
				'crafto_position_settings',
				[
					'label'     => esc_html__( 'Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''         => esc_html__( 'Default', 'crafto-addons' ),
						'relative' => esc_html__( 'Relative', 'crafto-addons' ),
						'absolute' => esc_html__( 'Absolute', 'crafto-addons' ),
						'inherit'  => esc_html__( 'Inherit', 'crafto-addons' ),
						'initial'  => esc_html__( 'Initial', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}}' => 'position: {{VALUE}}',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_overflows_settings',
				[
					'label'     => esc_html__( 'Overflow', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''        => esc_html__( 'Default', 'crafto-addons' ),
						'hidden'  => esc_html__( 'Hidden', 'crafto-addons' ),
						'visible' => esc_html__( 'Visible', 'crafto-addons' ),
						'none'    => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}}' => '--overflow: {{VALUE}}',
					],
				]
			);

			if ( 'themebuilder' !== get_post_type() ) {
				$element->add_control(
					'crafto_position',
					[
						'label'        => esc_html__( 'Luminosity', 'crafto-addons' ),
						'type'         => Controls_Manager::CHOOSE,
						'description'  => esc_html__( 'When the sticky bar is enabled from the header template, it will automatically toggle between light and dark color modes based on the scroll position for improved visibility and user experience.', 'crafto-addons' ),
						'default'      => 'light',
						'options'      => [
							'dark'  => [
								'title' => esc_html__( 'Dark', 'crafto-addons' ),
								'icon'  => 'fa fa-moon',
							],
							'light' => [
								'title' => esc_html__( 'Light', 'crafto-addons' ),
								'icon'  => 'fa fa-sun',
							],
						],
						'prefix_class' => 'section-',
						'toggle'       => true,
						'separator'    => 'before',
					]
				);
			}
			$element->add_control(
				'crafto_verticalbar_block',
				[
					'label'        => esc_html__( 'Enable Sticky Bar', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'separator'    => 'before',
				],
			);
			$element->add_control(
				'crafto_enable_home_verticalbar',
				[
					'label'        => esc_html__( 'Sticky Bar on Home Page Only', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_verticalbar_block' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_verticalbar_position',
				[
					'label'     => esc_html__( 'Sticky Bar Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => '',
					'options'   => [
						'left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-arrow-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-arrow-right',
						],
					],
					'toggle'    => true,
					'condition' => [
						'crafto_verticalbar_block' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_tablet_verticalbar_block',
				[
					'label'        => esc_html__( 'Hide Sticky Bar on Tablet', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_verticalbar_block' => 'yes',
					],
				],
			);
			$element->add_control(
				'crafto_sticky_settings',
				[
					'label'        => esc_html__( 'Enable Sticky Section', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'prefix_class' => 'position-',
					'return_value' => 'sticky',
					'separator'    => 'before',
				]
			);
			$element->add_responsive_control(
				'crafto_sticky_top',
				[
					'label'      => esc_html__( 'Sticky Offset', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%', 'custom' ],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 300,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.position-sticky' => 'top: {{SIZE}}{{UNIT}}; position: sticky !important;',
					],
					'condition'  => [
						'crafto_sticky_settings' => 'sticky',
					],
				]
			);
			$element->add_control(
				'fullscreen',
				[
					'label'        => esc_html__( 'Enable Fullscreen Section', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'prefix_class' => 'full-',
					'return_value' => 'screen',
					'separator'    => 'before',
				]
			);
			$element->add_responsive_control(
				'crafto_section_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.full-screen' => 'height: {{SIZE}}{{UNIT}} !important;',
					],
					'condition'  => [
						'fullscreen' => 'screen',
					],
				]
			);

			$element->add_control(
				'fullscreen_mobile',
				[
					'label'        => esc_html__( 'Enable Fullscreen Section in Mobile', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'prefix_class' => 'full-mobile-',
					'return_value' => 'screen',
				]
			);
			$element->add_control(
				'crafto_magic_cursor',
				[
					'label'        => esc_html__( 'Enable Magic Cursor', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'separator'    => 'before',
				]
			);
			$element->add_control(
				'crafto_magic_cursor_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'.magic-cursor-wrapper.magic-round-cursor #ball-cursor' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_magic_cursor' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_top_space',
				[
					'label'        => esc_html__( 'Prevent Content Overlap', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'prefix_class' => 'top-',
					'return_value' => 'space',
					'description'  => esc_html__( 'Adds space to prevent content from overlapping the header. Changes will be reflected in the preview only after the page reload.', 'crafto-addons' ),
					'separator'    => 'before',
				]
			);
			$element->end_controls_section();

			$element->start_controls_section(
				'crafto_scroll_to_down_tab',
				[
					'label' => esc_html__( 'Scroll to Down Section', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_LAYOUT,
				]
			);
			$element->add_control(
				'crafto_scroll_to_down',
				[
					'label'        => esc_html__( 'Enable Scroll to Down Section', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$element->add_control(
				'crafto_scroll_to_down_style_types',
				[
					'label'     => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => [
						'default'            => esc_html__( 'Default', 'crafto-addons' ),
						'scroll-down-type-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'scroll-down-type-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_target_id',
				[
					'label'          => esc_html__( 'Target id', 'crafto-addons' ),
					'type'           => Controls_Manager::TEXT,
					'default'        => 'my-id',
					'placeholder'    => 'my-id',
					'title'          => esc_html__( 'Add your target id WITHOUT the Hash(#) key. e.g: my-id', 'crafto-addons' ),
					'label_block'    => false,
					'style_transfer' => false,
					'condition'      => [
						'crafto_scroll_to_down' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Choose Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-arrow-down',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_scroll_to_down' => 'yes',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_selected_icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 300,
						],
					],
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}} .scroll-to-next i, {{WRAPPER}} .scroll-to-next svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_selected_icon_width',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 300,
						],
					],
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
						'crafto_scroll_to_down_style_types' => [
							'default',
							'scroll-down-type-2',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .scroll-to-next a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$element->start_controls_tabs( 'crafto_scroll' );
			$element->start_controls_tab(
				'crafto_scroll_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_scroll_to_down_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .scroll-to-next i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .scroll-to-next svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
						'crafto_scroll_to_down_style_types' => [
							'default',
							'scroll-down-type-1',
							'scroll-down-type-2',
						],
					],
				]
			);
			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_scroll_to_down_bg_color',
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
					'selector'       => '{{WRAPPER}} .scroll-to-next a',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_scroll_to_down' => 'yes',
						'crafto_scroll_to_down_style_types' => [
							'default',
							'scroll-down-type-2',
						],
					],
				]
			);
			$element->end_controls_tab();

			$element->start_controls_tab(
				'crafto_scroll_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
					],
				]
			);
			$element->add_control(
				'crafto_scroll_to_down_hover_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .scroll-to-next a:hover i, {{WRAPPER}} .scroll-to-next a:hover svg' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
						'crafto_scroll_to_down_style_types' => [
							'default',
							'scroll-down-type-1',
							'scroll-down-type-2',
						],
					],
				]
			);
			$element->add_control(
				'crafto_scroll_to_down_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_scroll_to_down_border_border!' => '',
						'crafto_scroll_to_down' => 'yes',
						'crafto_scroll_to_down_style_types' => [
							'default',
							'scroll-down-type-2',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .scroll-to-next a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_scroll_to_down_hover_bg_color',
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
					'selector'       => '{{WRAPPER}} .scroll-to-next a:hover',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_scroll_to_down' => 'yes',
						'crafto_scroll_to_down_style_types' => [
							'default',
							'scroll-down-type-2',
						],
					],
				]
			);
			$element->end_controls_tab();
			$element->end_controls_tabs();
			$element->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_scroll_to_down_box_shadow',
					'selector'  => '{{WRAPPER}} .scroll-to-next a',
					'condition' => [
						'crafto_scroll_to_down' => 'yes',
						'crafto_scroll_to_down_style_types' => [
							'default',
							'scroll-down-type-2',
						],
					],
				]
			);
			$element->end_controls_section();
		}
		/**
		 *  Crafto Blur option.
		 *
		 * @since 1.0
		 * @param object $element Section data.
		 * @access public
		 */
		public function crafto_blur_section_tab( $element ) {
			$element->add_control(
				'crafto_parallax',
				[
					'label'        => esc_html__( 'Enable Parallax', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'parallax',
				]
			);

			$element->add_control(
				'crafto_parallax_ratio',
				[
					'label'     => esc_html__( 'Parallax Ratio', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'unit' => 'px',
						'size' => 0.5,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1.5,
							'step' => 0.1,
						],
					],
					'condition' => [
						'crafto_parallax' => 'parallax',
					],
				]
			);
			$element->add_control(
				'crafto_blur',
				[
					'label'        => esc_html__( 'Enable Glass Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$element->add_control(
				'crafto_blur_value',
				[
					'label'     => esc_html__( 'Blur Value', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'unit' => 'px',
						'size' => 5,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 10,
							'step' => 1,
						],
					],
					'condition' => [
						'crafto_blur' => 'yes',
					],
					'selectors' => [
						'{{WRAPPER}}' => 'backdrop-filter: blur({{SIZE}}{{UNIT}})',
					],
				]
			);
		}
		/**
		 * Crafto Animation Options ( Anime(JS) Animation )
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_entrance_animation_section_tab( $element ) {
			if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
				Crafto_Common_Animation_Group::add_entrance_animation_controls( $element );
			}
		}
		/**
		 * Crafto Float Animation Options.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_float_animation_section_tab( $element ) {
			if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
				Crafto_Common_Animation_Group::add_float_animation_controls( $element );
			}
		}

		/**
		 *  Crafto Animation Options ( Width Expand Animation )
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_width_expand_animation_section_tab( $element ) {
			if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
				Crafto_Common_Animation_Group::add_width_expand_animation_controls( $element );
			}
		}

		/**
		 *  Crafto Advanced Section.
		 *
		 * @since 1.0
		 * @param object $element Section data.
		 * @access public
		 */
		public function crafto_before_section_render( $element ) {
			if ( 'container' === $element->get_name() ) {
				if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
					Crafto_Common_Animation_Group::render_custom_animation( $element );
				}

				$crafto_parallax       = $element->get_settings( 'crafto_parallax' );
				$crafto_parallax_ratio = $element->get_settings( 'crafto_parallax_ratio' );

				if ( 'parallax' === $crafto_parallax ) {
					$crafto_parallax_ratio = ( isset( $crafto_parallax_ratio['size'] ) && ! empty( $crafto_parallax_ratio['size'] ) ) ? $crafto_parallax_ratio['size'] : 0.5;

					$crafto_parallax_config = array(
						'parallax_ratio' => $crafto_parallax_ratio,
						'parallax'       => $crafto_parallax,
					);

					$element->add_render_attribute(
						'_wrapper',
						[
							'data-parallax-section-settings' => wp_json_encode( $crafto_parallax_config ),
						]
					);

					$element->add_render_attribute(
						'_wrapper',
						[
							'class' => 'has-parallax-background',
							'data-parallax-background-ratio' => $crafto_parallax_ratio,
						]
					);
				}

				// Section scroll to down data attributes.
				$settings                          = $element->get_settings_for_display();
				$crafto_scroll_to_down             = $element->get_settings( 'crafto_scroll_to_down' );
				$crafto_scroll_to_down_style_types = $element->get_settings( 'crafto_scroll_to_down_style_types' );
				$crafto_target_id                  = $element->get_settings( 'crafto_target_id' );
				$migrated                          = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
				$is_new                            = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

				$crafto_icon = '';
				if ( $is_new || $migrated ) {
					ob_start();
						Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
					$crafto_icon .= ob_get_clean();
				} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
					ob_start();
					?>
					<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
					<?php
					$crafto_icon .= ob_get_clean();
				}

				if ( 'yes' === $crafto_scroll_to_down ) {
					$crafto_scroll_to_down_config = array(
						'scroll_to_down'     => $crafto_scroll_to_down,
						'scroll_style_types' => $crafto_scroll_to_down_style_types,
						'scroll_target_id'   => $crafto_target_id,
						'scroll_icon'        => $crafto_icon,
					);

					$element->add_render_attribute(
						'_wrapper',
						'data-scroll-to-down-settings',
						wp_json_encode( $crafto_scroll_to_down_config )
					);
				}

				$crafto_magic_cursor = $element->get_settings( 'crafto_magic_cursor' );
				$crafto_cursor       = '';

				if ( 'yes' === $crafto_magic_cursor ) {
					$crafto_cursor = 'magic-cursor round-cursor';
				}

				$element->add_render_attribute(
					'_wrapper',
					[
						'class' => $crafto_cursor,
					]
				);
			}

			$crafto_verticalbar_block       = $element->get_settings( 'crafto_verticalbar_block' );
			$crafto_verticalbar_position    = $element->get_settings( 'crafto_verticalbar_position' );
			$crafto_enable_home_verticalbar = $element->get_settings( 'crafto_enable_home_verticalbar' );

			if ( 'yes' === $crafto_verticalbar_block ) {
				if ( is_front_page() && 'yes' === $crafto_enable_home_verticalbar ) {
					$verticalbar = [
						'verticalbar-wrap',
						'shadow-animation',
					];
				} else {
					$verticalbar = [
						'verticalbar-none',
					];
				}
				if ( 'yes' !== $crafto_enable_home_verticalbar ) {
					$verticalbar = [
						'verticalbar-wrap',
						'shadow-animation',
					];
				}

				if ( ! empty( $verticalbar ) ) {
					$element->add_render_attribute(
						'_wrapper',
						[
							'class'                => $verticalbar,
							'data-animation-delay' => 100,
						]
					);
				}
			}
			if ( ! empty( $crafto_verticalbar_position ) ) {
				$element->add_render_attribute(
					'_wrapper',
					[
						'class' => 'verticalbar-position-' . $crafto_verticalbar_position,
					]
				);
			}
			$crafto_tablet_verticalbar_block = $element->get_settings( 'crafto_tablet_verticalbar_block' );

			if ( 'yes' === $crafto_tablet_verticalbar_block ) {
				$element->add_render_attribute(
					'_wrapper',
					[
						'class' => [
							'hide-sticky-tablet',
						],
					]
				);
			}
		}

		/**
		 *  Crafto render float.
		 *
		 * @since 1.0
		 * @param object $element Section data.
		 * @access public
		 */
		public function crafto_before_float_animation_render( $element ) {
			if ( 'container' === $element->get_name() ) {
				if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
					Crafto_Common_Animation_Group::crafto_render_float_custom_animation( $element );
				}
			}
		}

		/**
		 *  Crafto render expad width.
		 *
		 * @since 1.0
		 * @param object $element Section data.
		 * @access public
		 */
		public function crafto_expand_width_animation_render( $element ) {
			if ( 'container' === $element->get_name() ) {
				if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
					Crafto_Common_Animation_Group::crafto_render_expand_width_animation( $element );
				}
			}
		}
	}
}
