<?php
namespace CraftoAddons\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// If class `Button_Group_Control` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Controls\Groups\Button_Group_Control' ) ) {

	/**
	 * Crafto button group control.
	 *
	 * A base control for creating button control.
	 *
	 * @package Crafto
	 */

	/**
	 * Define Button_Group_Control class
	 */
	class Button_Group_Control {

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
		 *
		 * Define button_content_fields.
		 *
		 * @param object $element Widget data.
		 * @param array  $args Button args.
		 * @param array  $conditions Widget conditions.
		 * @access public
		 */
		public static function button_content_fields( $element, $args, $conditions = [] ) {

			$type     = ( isset( $args['id'] ) && ! empty( $args['id'] ) ) ? $args['id'] : 'primary';
			$label    = ( isset( $args['label'] ) && ! empty( $args['label'] ) ) ? $args['label'] : esc_html__( 'Button', 'crafto-addons' );
			$default  = ( isset( $args['default'] ) && ! empty( $args['default'] ) ) ? $args['default'] : '';
			$repeater = ( isset( $args['repeat'] ) && ! empty( $args['repeat'] ) ) ? $args['repeat'] : 'no';

			$prefix = 'crafto_' . $type . '_';

			if ( 'no' === $repeater ) {
				$element->start_controls_section(
					$prefix . '_button_section',
					[
						'label'     => $label,
						'condition' => isset( $conditions['condition'] ) ? $conditions['condition'] : '',
					]
				);
			}

			if ( 'yes' === $repeater ) {
				$element->add_control(
					$prefix . '_button_heading',
					[
						'label'     => $label,
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
			}

			$element->add_control(
				$prefix . 'button_style',
				[
					'label'   => esc_html__( 'Style', 'crafto-addons' ),
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

			$element->add_control(
				$prefix . 'button_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => $default,
					'placeholder' => esc_html__( 'Click here', 'crafto-addons' ),
				]
			);
			$element->add_control(
				$prefix . 'button_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
				]
			);
			$element->add_control(
				$prefix . 'button_size',
				[
					'label'          => esc_html__( 'Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'xs',
					'options'        => self::get_button_sizes(),
					'style_transfer' => true,
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_width',
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
							'max'  => 1000,
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
						'{{WRAPPER}} a.' . $prefix . 'button' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$element->add_control(
				$prefix . 'selected_icon',
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
			$element->add_control(
				$prefix . 'button_icon_align',
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
						$prefix . 'selected_icon[value]!' => '',
					],
				]
			);
			$element->add_control(
				$prefix . 'icon_shape_style',
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
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'icon_shape_size',
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
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'icon_shape_style!'     => 'default',
						$prefix . 'button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_icon_indent',
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
						'{{WRAPPER}} .' . $prefix . 'button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .' . $prefix . 'button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .' . $prefix . 'button .elementor-align-icon-right' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .' . $prefix . 'button .elementor-align-icon-left'  => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'button_icon_align!'    => 'switch',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 15,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$prefix . 'selected_icon[value]!' => '',
					],
				]
			);
			$element->add_control(
				$prefix . 'button_expand_width',
				[
					'label'      => esc_html__( 'Expand Width', 'crafto-addons' ),
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
						'{{WRAPPER}} .elementor-animation-btn-expand-ltr .btn-hover-animation' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'button_style'          => 'expand-border',
					],
				]
			);
			$element->add_control(
				$prefix . 'button_css_id',
				[
					'label'       => esc_html__( 'Button ID', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'crafto-addons' ),
					'label_block' => false,
					'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'crafto-addons' ),
					'separator'   => 'before',
				]
			);
			$element->add_control(
				$prefix . 'button_hover_animation',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						$prefix . 'button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);

			if ( 'no' === $repeater ) {
				$element->end_controls_section();
			}
		}

		/**
		 *
		 * Define button_content_fields.
		 *
		 * @param object $element Widget data.
		 * @param array  $args Button args.
		 * @param array  $conditions Widget conditions.
		 * @access public
		 */
		public static function repeater_button_content_fields( $element, $args, $conditions = [] ) {

			$type        = ( isset( $args['id'] ) && ! empty( $args['id'] ) ) ? $args['id'] : 'button_alt';
			$label       = ( isset( $args['label'] ) && ! empty( $args['label'] ) ) ? $args['label'] : esc_html__( 'Button', 'crafto-addons' );
			$description = ( isset( $args['description'] ) && ! empty( $args['description'] ) ) ? $args['description'] : '';
			$default     = ( isset( $args['default'] ) && ! empty( $args['default'] ) ) ? $args['default'] : '';
			$repeater    = ( isset( $args['repeat'] ) && ! empty( $args['repeat'] ) ) ? $args['repeat'] : 'no';
			$prefix      = 'crafto_' . $type . '_';

			$element->add_control(
				$prefix . '_button_heading',
				[
					'label' => $label,
					'type'  => Controls_Manager::HEADING,
				]
			);

			if ( ! empty( $description ) ) {
				$element->add_control(
					'important_note',
					[
						'label'           => esc_html__( 'Important Note', 'crafto-addons' ),
						'type'            => \Elementor\Controls_Manager::RAW_HTML,
						'raw'             => $description,
						'content_classes' => 'elementor-control-field-description',
						'show_label'      => false,
					]
				);
			}

			$element->add_control(
				$prefix . 'button_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => $default,
					'placeholder' => esc_html__( 'Click here', 'crafto-addons' ),
				]
			);
			$element->add_control(
				$prefix . 'button_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
				]
			);
		}

		/**
		 *
		 * Define button_content_fields.
		 *
		 * @param object $element Widget data.
		 * @param array  $args Button args.
		 * @param array  $conditions Widget conditions.
		 * @access public
		 */
		public static function repeater_button_setting_fields( $element, $args, $conditions = [] ) {

			$type    = ( isset( $args['id'] ) && ! empty( $args['id'] ) ) ? $args['id'] : 'button_alt';
			$label   = ( isset( $args['label'] ) && ! empty( $args['label'] ) ) ? $args['label'] : esc_html__( 'Button', 'crafto-addons' );
			$default = ( isset( $args['default'] ) && ! empty( $args['default'] ) ) ? $args['default'] : '';
			$prefix  = 'crafto_' . $type . '_';

			$element->start_controls_section(
				$prefix . '_button_section',
				[
					'label'     => $label,
					'condition' => isset( $conditions['condition'] ) ? $conditions['condition'] : '',
				]
			);

			$element->add_control(
				$prefix . 'button_style',
				[
					'label'   => esc_html__( 'Style', 'crafto-addons' ),
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
			$element->add_control(
				$prefix . 'button_size',
				[
					'label'          => esc_html__( 'Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'xs',
					'options'        => self::get_button_sizes(),
					'style_transfer' => true,
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_width',
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
							'max'  => 1000,
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
						'{{WRAPPER}} a.' . $prefix . 'button' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$element->add_control(
				$prefix . 'selected_icon',
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
			$element->add_control(
				$prefix . 'button_icon_align',
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
						$prefix . 'selected_icon[value]!' => '',
					],
				]
			);
			$element->add_control(
				$prefix . 'icon_shape_style',
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
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'icon_shape_size',
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
						'{{WRAPPER}} a.' . $prefix . 'button.btn-icon-round .elementor-button-icon, {{WRAPPER}} a.' . $prefix . 'button.btn-icon-circle .elementor-button-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'icon_shape_style!'     => 'default',
						$prefix . 'button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_icon_indent',
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
						'{{WRAPPER}} .' . $prefix . 'button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .' . $prefix . 'button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .swiper-rtl .' . $prefix . 'button .elementor-align-icon-right, .rtl {{WRAPPER}} div:not(.swiper) .' . $prefix . 'button .elementor-align-icon-right' => ' margin-inline-start: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .swiper-rtl .' . $prefix . 'button .elementor-align-icon-left, .rtl {{WRAPPER}} div:not(.swiper) .' . $prefix . 'button .elementor-align-icon-left'  => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'button_icon_align!'    => 'switch',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 15,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .' . $prefix . 'button .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$prefix . 'selected_icon[value]!' => '',
					],
				]
			);
			$element->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => $prefix . 'icon_box_shadow',
					'selector'  => '{{WRAPPER}} .' . $prefix . 'button .elementor-button-icon',
					'condition' => [
						$prefix . 'icon_shape_style!' => 'default',
					],
				]
			);
			$element->add_control(
				$prefix . 'button_expand_width',
				[
					'label'      => esc_html__( 'Expand Width', 'crafto-addons' ),
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
						'{{WRAPPER}} .' . $prefix . 'button.elementor-animation-btn-expand-ltr .btn-hover-animation' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'selected_icon[value]!' => '',
						$prefix . 'button_style'          => 'expand-border',
					],
				]
			);
			$element->add_control(
				$prefix . 'button_css_id',
				[
					'label'       => esc_html__( 'Button ID', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'crafto-addons' ),
					'label_block' => false,
					'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'crafto-addons' ),
					'separator'   => 'before',
				]
			);
			$element->add_control(
				$prefix . 'button_hover_animation',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						$prefix . 'button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
				]
			);
			$element->end_controls_section();
		}

		/**
		 *
		 * Define button_style_fields.
		 *
		 * @param object $element Widget Object.
		 * @param string $args Button args.
		 * @param array  $conditions Button conditions.
		 * @access public
		 */
		public static function button_style_fields( $element, $args, $conditions = [] ) {

			$type   = ( isset( $args['id'] ) && ! empty( $args['id'] ) ) ? $args['id'] : 'primary';
			$label  = ( isset( $args['label'] ) && ! empty( $args['label'] ) ) ? $args['label'] : esc_html__( 'Button', 'crafto-addons' );
			$prefix = 'crafto_' . $type . '_';

			$element->start_controls_section(
				$prefix . 'section_style',
				[
					'label'     => $label,
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => isset( $conditions['condition'] ) ? $conditions['condition'] : '',
				]
			);
			$element->add_responsive_control(
				$prefix . 'display',
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
						'{{WRAPPER}} .' . $prefix . 'button' => 'display: {{VALUE}}',
					],
					'separator' => 'before',
				]
			);
			$element->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => $prefix . 'typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} a.' . $prefix . 'button, {{WRAPPER}} .' . $prefix . 'button',
				]
			);
			$element->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => $prefix . 'button_text_shadow',
					'selector' => '{{WRAPPER}} a.' . $prefix . 'button, {{WRAPPER}} .' . $prefix . 'button',
				]
			);

			$element->start_controls_tabs( $prefix . 'button_tabs' );

			$element->start_controls_tab(
				$prefix . 'button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$element->add_control(
				$prefix . 'button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.' . $prefix . 'button .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$element->add_control(
				$prefix . 'button_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.' . $prefix . 'button i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button svg'  => 'fill: {{VALUE}};',
					],
					'condition' => [
						$prefix . 'selected_icon[value]!' => '',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_double_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.' . $prefix . 'button.btn-double-border, {{WRAPPER}}  a.' . $prefix . 'button.btn-double-border::after, {{WRAPPER}}  a.' . $prefix . 'button.elementor-button, {{WRAPPER}}  a.' . $prefix . 'button.elementor-animation-btn-expand-ltr .btn-hover-animation' => 'border-color: {{VALUE}};',
					],
				]
			);
			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => $prefix . 'button_background_color',
					'types'     => [
						'classic',
						'gradient',
					],
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} a.' . $prefix . 'button, {{WRAPPER}} a.' . $prefix . 'button.elementor-animation-btn-expand-ltr .btn-hover-animation',
					'condition' => [
						$prefix . 'button_style!' => [
							'border',
							'double-border',
							'underline',
						],
					],
				]
			);
			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => $prefix . 'button_shape_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .crafto-button-wrapper a.' . $prefix . 'button.elementor-button.btn-icon-round .elementor-button-icon, {{WRAPPER}} .crafto-button-wrapper a.' . $prefix . 'button.elementor-button.btn-icon-circle .elementor-button-icon ',
					'condition'      => [
						$prefix . 'button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
						$prefix . 'icon_shape_style'      => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						$prefix . 'selected_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$element->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => $prefix . 'button_box_shadow',
					'selector' => '{{WRAPPER}} .' . $prefix . 'button',
				]
			);
			$element->end_controls_tab();
			$element->start_controls_tab(
				$prefix . 'button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$element->add_control(
				$prefix . 'button_hover_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.' . $prefix . 'button:hover .elementor-button-content-wrapper' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button:focus .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$element->add_control(
				$prefix . 'button_hover_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.' . $prefix . 'button:hover i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button:focus i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button:focus i, {{WRAPPER}} .crafto-button-wrapper a.' . $prefix . 'button.elementor-button.btn-icon-round:hover .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper a.' . $prefix . 'button.elementor-button.btn-icon-circle:hover .elementor-button-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button:hover svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						$prefix . 'selected_icon[value]!' => '',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.' . $prefix . 'button:hover'                                                         => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button:focus'                                                         => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button.btn-double-border:hover'                                       => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button.btn-double-border:hover:after'                                 => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button.btn-double-border:focus'                                       => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button.elementor-animation-btn-expand-ltr:hover .btn-hover-animation' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.' . $prefix . 'button.btn-double-border:hover, {{WRAPPER}} a.' . $prefix . 'button.btn-double-border:hover:after'                  => 'border-color: {{VALUE}} !important;',
					],
				]
			);
			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => $prefix . 'button_hover_background_color',
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
					'condition'      => [
						$prefix . 'button_style!' => [
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
					'selector'       => '{{WRAPPER}} a.' . $prefix . 'button:hover, {{WRAPPER}} a.' . $prefix . 'button:focus',
				]
			);
			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => $prefix . 'button_hover_shape_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .crafto-button-wrapper a.' . $prefix . 'button.elementor-button.btn-icon-round:hover .elementor-button-icon, {{WRAPPER}} .crafto-button-wrapper a.' . $prefix . 'button.elementor-button.btn-icon-circle:hover .elementor-button-icon',
					'condition'      => [
						$prefix . 'button_style!'         => [
							'double-border',
							'underline',
							'expand-border',
						],
						$prefix . 'icon_shape_style'      => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						$prefix . 'selected_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$element->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => $prefix . 'button_hover_box_shadow',
					'selector' => '{{WRAPPER}} .' . $prefix . 'button:hover',
				]
			);
			$element->end_controls_tab();
			$element->end_controls_tabs();
			$element->add_responsive_control(
				$prefix . 'button_underline_height',
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
						'{{WRAPPER}} .crafto-button-wrapper .' . $prefix . 'button.btn-underline' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						$prefix . 'button_style' => [
							'underline',
						],
					],
				]
			);
			$element->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => $prefix . 'border',
					'selector'       => '{{WRAPPER}} .' . $prefix . 'button, {{WRAPPER}} .' . $prefix . 'button .elementor-animation-btn-expand-ltr .btn-hover-animation',
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
						$prefix . 'button_style!' => [
							'double-border',
							'underline',
						],
					],
				]
			);
			$element->add_control(
				$prefix . 'button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
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
						'{{WRAPPER}} a.' . $prefix . 'button, {{WRAPPER}} a.' . $prefix . 'button::after' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'button_style!' => [
							'underline',
						],
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_padding',
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
						'{{WRAPPER}} .' . $prefix . 'button:not(.btn-double-border), {{WRAPPER}} a.btn-double-border .elementor-button-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'button_margin',
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
						'{{WRAPPER}} .' . $prefix . 'button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$element->end_controls_section();
		}

		/**
		 *
		 * Define render button_content.
		 *
		 * @param object $element Widget data.
		 * @param string $type Widget arguments.
		 * @access public
		 */
		public static function render_button_content( $element, $type = 'primary' ) {

			$settings                = $element->get_settings_for_display();
			$prefix                  = 'crafto_' . $type . '_';
			$button_style            = $settings[ $prefix . 'button_style' ];
			$button_hover_animation  = $settings[ $prefix . 'button_hover_animation' ];
			$button_icon_align       = $settings[ $prefix . 'button_icon_align' ];
			$crafto_icon_shape_style = $settings[ $prefix . 'icon_shape_style' ];

			$element->add_render_attribute(
				[
					$prefix . 'btn_wrapper' => [
						'class' => [
							'elementor-button-wrapper',
							'crafto-button-wrapper',
							'crafto-' . $type . '-wrapper',
						],
					],
				]
			);

			/* Button hover animation */
			$custom_animation_class       = '';
			$custom_animation_div         = '';
			$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();

			if ( ! empty( $hover_animation_effect_array ) || ! empty( $settings[ $prefix . 'button_hover_animation' ] ) ) {
				if ( '' === $button_style || 'border' === $button_style ) {
					$element->add_render_attribute( $prefix . 'button', 'class', 'elementor-animation-' . $button_hover_animation );
					$element->add_render_attribute( $prefix . 'button', 'class', $crafto_icon_shape_style );
				}
				if ( in_array( $button_hover_animation, $hover_animation_effect_array, true ) ) {
					$custom_animation_class = 'btn-custom-effect';
					if ( ! in_array( $button_hover_animation, array( 'btn-switch-icon', 'btn-switch-text' ), true ) ) {
						$custom_animation_div = '<span class="btn-hover-animation"></span>';
					}
				}
			}
			$element->add_render_attribute( $prefix . 'button', 'class', $custom_animation_class );

			if ( 'btn-reveal-icon' === $button_hover_animation && 'left' === $button_icon_align ) {
				$element->add_render_attribute( $prefix . 'button', 'class', 'btn-reveal-icon-left' );
			}

			if ( 'border' === $button_style ) {
				$element->add_render_attribute( $prefix . 'button', 'class', 'btn-border' );
			}

			if ( 'double-border' === $button_style ) {
				$element->add_render_attribute( $prefix . 'button', 'class', 'btn-double-border' );
			}

			if ( 'underline' === $button_style ) {
				$element->add_render_attribute( $prefix . 'button', 'class', 'btn-underline' );
			}

			if ( 'expand-border' === $button_style ) {
				$element->add_render_attribute( $prefix . 'button', 'class', 'elementor-animation-btn-expand-ltr' );
			}

			if ( ! empty( $settings[ $prefix . 'button_link' ]['url'] ) ) {
				$element->add_render_attribute( $prefix . 'button', 'class', 'elementor-button-link' );
				$element->add_render_attribute( $prefix . 'button', 'href', $settings[ $prefix . 'button_link' ]['url'] );

				if ( $settings[ $prefix . 'button_link' ]['is_external'] ) {
					$element->add_render_attribute( $prefix . 'button', 'target', '_blank' );
				}

				if ( $settings[ $prefix . 'button_link' ]['nofollow'] ) {
					$element->add_render_attribute( $prefix . 'button', 'rel', 'nofollow' );
				}
			}

			if ( ! empty( $settings[ $prefix . 'button_size' ] ) ) {
				$element->add_render_attribute( $prefix . 'button', 'class', 'elementor-size-' . $settings[ $prefix . 'button_size' ] );
			}

			$element->add_render_attribute( $prefix . 'button', 'class', [ 'elementor-button', $prefix . 'button', 'btn-icon-' . $settings[ $prefix . 'button_icon_align' ] ] );
			$element->add_render_attribute( $prefix . 'button', 'role', 'button' );

			if ( 'expand-border' === $button_style ) {
				$custom_animation_div = '<span class="btn-hover-animation"></span>';
			}

			if ( $settings[ $prefix . 'button_text' ] || ( ! empty( $settings['icon'] ) || ! empty( $settings[ $prefix . 'selected_icon' ]['value'] ) ) ) {
				?>
				<div <?php $element->print_render_attribute_string( $prefix . 'btn_wrapper' ); ?>>
					<a <?php $element->print_render_attribute_string( $prefix . 'button' ); ?>>
						<?php
						self::button_render_text( $element, $type );
						echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
						?>
					</a>
				</div>
				<?php
			}
		}

		/**
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @param object $element Widget data.
		 * @param string $type Widget arguments.
		 * @access public
		 */
		public static function button_render_text( $element, $type = 'primary' ) {

			$prefix   = 'crafto_' . $type . '_';
			$settings = $element->get_settings_for_display();
			$migrated = isset( $settings['__fa4_migrated'][ $prefix . 'selected_icon' ] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! $is_new && empty( $settings[ $prefix . 'selected_icon_align' ] ) ) {
				$settings[ $prefix . 'button_icon_align' ] = $element->get_settings( $prefix . 'button_icon_align' );
			}

			$button_hover_animation = $settings[ $prefix . 'button_hover_animation' ];

			$element->add_render_attribute(
				[
					$prefix . 'content-wrapper' => [
						'class' => 'elementor-button-content-wrapper',
					],
					$prefix . 'icon-align'      => [
						'class' => [
							'elementor-button-icon',
						],
					],
					$prefix . 'text'            => [
						'class' => 'elementor-button-text',
					],
				]
			);

			if ( 'btn-switch-icon' !== $button_hover_animation && $settings[ $prefix . 'button_icon_align' ] ) {
				$element->add_render_attribute(
					[
						$prefix . 'icon-align' => [
							'class' => [
								'elementor-align-icon-' . $settings[ $prefix . 'button_icon_align' ],
							],
						],
					],
				);
			}

			if ( 'btn-switch-text' === $button_hover_animation ) {
				$element->add_render_attribute(
					[
						$prefix . 'text' => [
							'data-btn-text' => wp_strip_all_tags( $settings[ $prefix . 'button_text' ] ),
						],
					],
				);
			}
			?>
			<span <?php $element->print_render_attribute_string( $prefix . 'content-wrapper' ); ?>>
				<?php
				if ( ! empty( $settings[ $prefix . 'button_text' ] ) ) {
					?>
					<span <?php $element->print_render_attribute_string( $prefix . 'text' ); ?>>
						<?php
						echo sprintf( '%s', esc_html( $settings[ $prefix . 'button_text' ] ) ); // phpcs:ignore
						?>
					</span>
					<?php
				}

				if ( ! empty( $settings['icon'] ) || ! empty( $settings[ $prefix . 'selected_icon' ]['value'] ) ) {
					?>
					<span <?php $element->print_render_attribute_string( $prefix . 'icon-align' ); ?>>
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings[ $prefix . 'selected_icon' ], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['selected_icon']['value'] ) && ! empty( $settings['selected_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings[ $prefix . 'selected_icon' ]['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
						?>
					</span>
					<?php
				}

				if ( 'btn-switch-icon' === $button_hover_animation ) {
					if ( ! empty( $settings[ $prefix . 'selected_icon' ] ) || ! empty( $settings[ $prefix . 'selected_icon' ]['value'] ) ) {
						?>
						<span <?php $element->print_render_attribute_string( $prefix . 'icon-align' ); ?>>
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings[ $prefix . 'selected_icon' ], [ 'aria-hidden' => 'true' ] );
							} elseif ( isset( $settings['selected_icon']['value'] ) && ! empty( $settings['selected_icon']['value'] ) ) {
								?>
								<i class="<?php echo esc_attr( $settings[ $prefix . 'selected_icon' ]['value'] ); ?>" aria-hidden="true"></i>
								<?php
							}
							?>
						</span>
						<?php
					}
				}
				?>
			</span>
			<span class="screen-reader-text"><?php echo esc_html__( 'Read More', 'crafto-addons' ); ?></span>
			<?php
		}

		/**
		 * Render Button HTML for repeater fields.
		 *
		 * @param object $element Widget data.
		 * @param array  $item Get slider data.
		 * @param string $type Widget arguments.
		 * @param string $button_key Widget arguments.
		 * @access public
		 */
		public static function repeater_render_button_content( $element, $item, $type = 'primary', $button_key = '1' ) {

			$settings                = $element->get_settings_for_display();
			$prefix                  = 'crafto_' . $type . '_';
			$btn_key                 = $button_key . $prefix . 'button';
			$btn_wrapper_key         = $button_key . $prefix . 'btn_wrapper';
			$button_style            = isset( $settings[ $prefix . 'button_style' ] ) && ! empty( $settings[ $prefix . 'button_style' ] ) ? $settings[ $prefix . 'button_style' ] : '';
			$button_hover_animation  = isset( $settings[ $prefix . 'button_hover_animation' ] ) && ! empty( $settings[ $prefix . 'button_hover_animation' ] ) ? $settings[ $prefix . 'button_hover_animation' ] : '';
			$button_icon_align       = isset( $settings[ $prefix . 'button_icon_align' ] ) && ! empty( $settings[ $prefix . 'button_icon_align' ] ) ? $settings[ $prefix . 'button_icon_align' ] : '';
			$crafto_icon_shape_style = isset( $settings[ $prefix . 'icon_shape_style' ] ) && ! empty( $settings[ $prefix . 'icon_shape_style' ] ) ? $settings[ $prefix . 'icon_shape_style' ] : '';

			$element->add_render_attribute(
				[
					$btn_wrapper_key => [
						'class' => [
							'elementor-button-wrapper',
							'crafto-button-wrapper',
							'crafto-' . $type . '-wrapper',
						],
					],
				]
			);

			if ( 'btn-reveal-icon' === $button_hover_animation && 'right' === $button_icon_align ) {
				$element->add_render_attribute( $btn_key, 'class', 'btn-reveal-icon-right' );
			}

			if ( 'border' === $button_style ) {
				$element->add_render_attribute( $btn_key, 'class', 'btn-border' );
			}

			if ( 'double-border' === $button_style ) {
				$element->add_render_attribute( $btn_key, 'class', 'btn-double-border' );
			}

			if ( 'underline' === $button_style ) {
				$element->add_render_attribute( $btn_key, 'class', 'btn-underline' );
			}

			if ( 'expand-border' === $button_style ) {
				$element->add_render_attribute( $btn_key, 'class', 'elementor-animation-btn-expand-ltr' );
			}

			if ( ! empty( $item[ $prefix . 'button_link' ]['url'] ) ) {
				if ( '' === $button_style || 'border' === $button_style ) {
					$element->add_render_attribute( $btn_key, 'class', $crafto_icon_shape_style );
				}
				$element->add_render_attribute( $btn_key, 'class', 'elementor-button-link' );
				$element->add_render_attribute( $btn_key, 'href', $item[ $prefix . 'button_link' ]['url'] );

				if ( $item[ $prefix . 'button_link' ]['is_external'] ) {
					$element->add_render_attribute( $btn_key, 'target', '_blank' );
				}

				if ( $item[ $prefix . 'button_link' ]['nofollow'] ) {
					$element->add_render_attribute( $btn_key, 'rel', 'nofollow' );
				}
			}

			$element->add_render_attribute( $btn_key, 'class', [ 'elementor-button', $prefix . 'button' ] );
			$element->add_render_attribute( $btn_key, 'role', 'button' );

			if ( ! empty( $settings[ $prefix . 'button_css_id' ] ) ) {
				$element->add_render_attribute( $btn_key, 'id', $settings[ $prefix . 'button_css_id' ] );
			}

			if ( ! empty( $settings[ $prefix . 'button_size' ] ) ) {
				$element->add_render_attribute( $btn_key, 'class', 'elementor-size-' . $settings[ $prefix . 'button_size' ] );
			}

			if ( ! empty( $settings[ $prefix . 'button_icon_align' ] ) ) {
				$element->add_render_attribute( $btn_key, 'class', [ 'elementor-button', 'btn-icon-' . $settings[ $prefix . 'button_icon_align' ] ] );
			}

			/* Button hover animation */
			$custom_animation_class       = '';
			$custom_animation_div         = '';
			$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();

			if ( ! empty( $hover_animation_effect_array ) || ! empty( $settings[ $prefix . 'button_hover_animation' ] ) ) {
				if ( '' === $button_style || 'border' === $button_style ) {
					$element->add_render_attribute( $btn_key, 'class', 'elementor-animation-' . $button_hover_animation );
				}
				if ( in_array( $button_hover_animation, $hover_animation_effect_array, true ) ) {
					$custom_animation_class = 'btn-custom-effect';
					if ( ! in_array( $button_hover_animation, array( 'btn-switch-icon', 'btn-switch-text' ), true ) ) {
						$custom_animation_div = '<span class="btn-hover-animation"></span>';
					}
				}
			}

			if ( 'expand-border' === $button_style ) {
				$custom_animation_div = '<span class="btn-hover-animation"></span>';
			}

			$element->add_render_attribute( $btn_key, 'class', $custom_animation_class );

			if ( $item[ $prefix . 'button_text' ] || ( ! empty( $settings[ $prefix . 'selected_icon' ] && ! empty( $settings[ $prefix . 'selected_icon' ]['value'] ) ) ) ) {
				?>
				<div <?php $element->print_render_attribute_string( $btn_wrapper_key ); ?>>
					<a <?php $element->print_render_attribute_string( $btn_key ); ?>>
						<?php
						self::repeater_button_render_text( $element, $item, $type, $button_key );
						echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
						?>
					</a>
				</div>
				<?php
			}
		}

		/**
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @param object $element Widget data.
		 * @param array  $item Get slider data.
		 * @param string $type Button type.
		 * @param string $button_key Button Key.
		 * @access public
		 */
		public static function repeater_button_render_text( $element, $item, $type = 'primary', $button_key = 'button_' ) {

			$settings               = $element->get_settings_for_display();
			$prefix                 = 'crafto_' . $type . '_';
			$migrated               = isset( $settings['__fa4_migrated'][ $prefix . 'selected_icon' ] );
			$is_new                 = empty( $settings[ $prefix . 'icon' ] ) && Icons_Manager::is_migration_allowed();
			$button_hover_animation = isset( $settings[ $prefix . 'button_hover_animation' ] ) && ! empty( $settings[ $prefix . 'button_hover_animation' ] ) ? $settings[ $prefix . 'button_hover_animation' ] : '';
			$button_icon_align      = isset( $settings[ $prefix . 'button_icon_align' ] ) && ! empty( $settings[ $prefix . 'button_icon_align' ] ) ? $settings[ $prefix . 'button_icon_align' ] : '';

			if ( ! $is_new && empty( $button_icon_align ) ) {
				$button_icon_align = $element->get_settings( $prefix . 'button_icon_align' );
			}

			$btn_txt_key     = $button_key . $prefix . 'text';
			$btn_icon_key    = $button_key . $prefix . 'icon-align';
			$btn_wrapper_key = $button_key . $prefix . 'content-wrapper';

			$element->add_render_attribute(
				[
					$btn_wrapper_key => [
						'class' => 'elementor-button-content-wrapper',
					],
					$btn_icon_key    => [
						'class' => [
							'elementor-button-icon',
						],
					],
					$btn_txt_key     => [
						'class' => 'elementor-button-text',
					],
				]
			);

			if ( 'btn-switch-icon' !== $button_hover_animation ) {
				$element->add_render_attribute(
					[
						$btn_icon_key => [
							'class' => [
								'elementor-align-icon-' . $button_icon_align,
							],
						],
					],
				);
			}
			if ( 'btn-switch-text' === $button_hover_animation ) {
				$element->add_render_attribute(
					[
						$btn_txt_key => [
							'data-btn-text' => wp_strip_all_tags( $item[ $prefix . 'button_text' ] ),
						],
					],
				);
			}
			?>
			<span <?php $element->print_render_attribute_string( $btn_wrapper_key ); ?>>
				<?php
				if ( ! empty( $item[ $prefix . 'button_text' ] ) ) {
					?>
					<span <?php $element->print_render_attribute_string( $btn_txt_key ); ?>>
						<?php echo sprintf( '%s', esc_html( $item[ $prefix . 'button_text' ] ) ); // phpcs:ignore ?>
					</span>
					<?php
				}

				if ( ! empty( $settings[ $prefix . 'selected_icon' ] ) && ! empty( $settings[ $prefix . 'selected_icon' ]['value'] ) ) {
					?>
					<span <?php $element->print_render_attribute_string( $btn_icon_key ); ?>>
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings[ $prefix . 'selected_icon' ], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['selected_icon']['value'] ) && ! empty( $settings['selected_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings[ $prefix . 'selected_icon' ]['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
						?>
					</span>
					<?php
				}

				if ( 'btn-switch-icon' === $button_hover_animation ) {
					if ( ! empty( $settings[ $prefix . 'selected_icon' ] ) && ! empty( $settings[ $prefix . 'selected_icon' ]['value'] ) ) {
						?>
						<span <?php $element->print_render_attribute_string( $btn_icon_key ); ?>>
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings[ $prefix . 'selected_icon' ], [ 'aria-hidden' => 'true' ] );
							} elseif ( isset( $settings['selected_icon']['value'] ) && ! empty( $settings['selected_icon']['value'] ) ) {
								?>
								<i class="<?php echo esc_attr( $settings[ $prefix . 'selected_icon' ]['value'] ); ?>" aria-hidden="true"></i>
								<?php
							}
							?>
						</span>
						<?php
					}
				}
				?>
			</span>
			<?php
		}
	}
}
