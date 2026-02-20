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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget Flip box.
 *
 * @package Crafto
 */

// If class `Flip_Box` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Flip_Box' ) ) {
	/**
	 * Define `Flip_Box` class.
	 */
	class Flip_Box extends Widget_Base {
		/**
		 * Retrieve the list of styles the flip box widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-flip-box' ];
			}
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve flip box widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-flip-box';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve flip box widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Rotate Box', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve flip box widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-flip-box crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/rotate-box/';
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
				'image',
				'flip',
				'box',
				'fancy',
				'transform',
				'flip box',
				'flip card',
				'content flip',
				'info box',
			];
		}

		/**
		 * Get button sizes.
		 *
		 * Retrieve an array of button sizes for the flip box widget.
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
		 * Register flip box widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_flip_box_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_flip_box_styles',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'flip-box-style-1',
					'options' => [
						'flip-box-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'flip-box-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
				]
			);
			$this->end_controls_section();
			// START of FRONT SIDE section.
			$this->start_controls_section(
				'crafto_flip_box_front_content_section',
				[
					'label' => esc_html__( 'Front Side', 'crafto-addons' ),
				]
			);
			$this->start_controls_tabs( 'crafto_flip_box_frontside_tabs' );
			$this->start_controls_tab(
				'crafto_flip_box_front_side_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_flip_box_carousel_use_image',
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
				'crafto_flip_box_item_image',
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
						'crafto_flip_box_carousel_use_image' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'condition' => [
						'crafto_flip_box_carousel_use_image' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => '',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_flip_box_carousel_use_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_content_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Add title here', 'crafto-addons' ),
					'label_block' => true,
					'separator'   => 'before',
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_title_size',
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
					'default' => 'div',
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_content_description_text',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXTAREA,
					'dynamic'   => [
						'active' => true,
					],
					'separator' => 'none',
					'rows'      => 10,
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_content_sub_description_text',
				[
					'label'     => esc_html__( 'Sub Description', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXTAREA,
					'dynamic'   => [
						'active' => true,
					],
					'separator' => 'none',
					'rows'      => 10,
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_flip_box_front_side_background_tab',
				[
					'label' => esc_html__( 'Background', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_flip_image_box_front_background',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'image'      => [
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							],
						],
					],
					'selector'       =>
						'{{WRAPPER}} .flip-front-side',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->end_controls_section();
			// End of FRONT SIDE section.

			// START of BACK SIDE section.
			$this->start_controls_section(
				'crafto_flip_box_back_content_section',
				[
					'label' => esc_html__( 'Back Side', 'crafto-addons' ),
				]
			);
			$this->start_controls_tabs( 'crafto_flip_box_backside_tabs' );
			$this->start_controls_tab(
				'crafto_flip_box_back_side_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_use_image',
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
				'crafto_flip_box_back_item_image',
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
						'crafto_flip_box_back_side_use_image' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_back_thumbnail',
					'default'   => 'full',
					'condition' => [
						'crafto_flip_box_back_side_use_image' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => '',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_flip_box_back_side_use_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_content_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Add title here', 'crafto-addons' ),
					'label_block' => true,
					'separator'   => 'before',
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_title_size',
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
					'default' => 'div',
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_content_description_text',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXTAREA,
					'dynamic'   => [
						'active' => true,
					],
					'separator' => 'none',
					'rows'      => 10,
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_button_heading',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_button_style',
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
			$this->add_control(
				'crafto_flip_box_back_side_content_button_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Click Here', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Click Here', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_content_button_link',
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
			$this->add_control(
				'crafto_flip_box_back_side_content_button_size',
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
				'crafto_back_icon_align',
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
						'crafto_button_style!' => [
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
						'crafto_icon_shape_style!' => 'default',
						'crafto_button_style!'     => [
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
						'crafto_back_icon_align!' => 'switch',
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
						'crafto_button_style' => 'expand-border',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_button_hover_animation',
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
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_flip_box_back_side_background_tab',
				[
					'label' => esc_html__( 'Background', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_flip_image_box_overlay_background',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'image'      => [
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							],
						],
					],
					'selector'       => '{{WRAPPER}} .flip-back-side ',
				]
			);
			// End of back_content_tabs.
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			// End of BACK SIDE section.

			// START of Settings section.
			$this->start_controls_section(
				'crafto_flip_box_settings_section',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_flip_box_effect',
				[
					'label'        => esc_html__( 'Flip Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'flip',
					'options'      => [
						'flip'     => esc_html__( 'Flip', 'crafto-addons' ),
						'slide'    => esc_html__( 'Slide', 'crafto-addons' ),
						'push'     => esc_html__( 'Push', 'crafto-addons' ),
						'zoom-in'  => esc_html__( 'Zoom In', 'crafto-addons' ),
						'zoom-out' => esc_html__( 'Zoom Out', 'crafto-addons' ),
						'fade'     => esc_html__( 'Fade', 'crafto-addons' ),
					],
					'prefix_class' => 'elementor-flip-box--effect-',
				]
			);
			$this->add_control(
				'crafto_flip_box_direction',
				[
					'label'        => esc_html__( 'Flip Direction', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'right',
					'options'      => [
						'left'  => esc_html__( 'Right to Left', 'crafto-addons' ),
						'right' => esc_html__( 'Left to Right', 'crafto-addons' ),
						'up'    => esc_html__( 'Bottom to Top', 'crafto-addons' ),
						'down'  => esc_html__( 'Top to Bottom', 'crafto-addons' ),
					],
					'condition'    => [
						'crafto_flip_box_effect!' => [
							'fade',
							'zoom-in',
							'zoom-out',
							'push',
						],
					],
					'prefix_class' => 'elementor-flip-box--direction-',
				]
			);
			$this->add_control(
				'crafto_flip_box_3d',
				[
					'label'        => esc_html__( 'Enable 3D Depth', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'elementor-flip-box-3d',
					'default'      => '',
					'prefix_class' => '',
					'condition'    => [
						'crafto_flip_box_effect' => 'flip',
					],
				]
			);
			$this->end_controls_section();
			// End of Settings section.

			// START of GENERAL Style section.
			$this->start_controls_section(
				'crafto_flip_box_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 100,
							'max' => 600,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
						'vh' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'size_units' => [
						'px',
						'%',
						'vh',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .flip-box-wrapper.flip-box-style-1, {{WRAPPER}} .flip-box-style-2.flip-box-wrapper .flip-inner-wrap' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .flip-box' => 'border-radius: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_flip_box_shadow',
					'selector'  => '{{WRAPPER}} .flip-box-style-1 .flip-box',
					'condition' => [
						'crafto_flip_box_styles' => [
							'flip-box-style-1',
						],
					],
				]
			);
			$this->end_controls_section();
			// End of GENERAL section.
			// START of FRONT SIDE Style section.
			$this->start_controls_section(
				'crafto_flip_box_front_side_style_section',
				[
					'label' => esc_html__( 'Front Side', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_content_alignment',
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
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .flip-front-side .flip-box-front, {{WRAPPER}} .flip-box-title, {{WRAPPER}} .flip-box-front .flip-box-front-inner' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_content_v_alignment',
				[
					'label'     => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => '',
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center'     => [
							'title' => esc_html__( 'Middle', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .flip-front-side .flip-box-front' => 'justify-content: {{VALUE}};',
					],
					'condition' => [
						'crafto_flip_box_styles' => [
							'flip-box-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_flip_front_border',
					'selector'  => '{{WRAPPER}} .flip-front-side',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_content_padding',
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
						'{{WRAPPER}} .flip-front-side .flip-box-front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_overlay',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_flip_box_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .flip-front-side .flip-front-box-overlay',
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .flip-front-side .flip-front-box-overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_text_icon',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_flip_box_carousel_use_image' => '',
						'crafto_flip_box_icon[value]!' => '',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_image_icon',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_flip_box_carousel_use_image' => 'yes',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_flip_box_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .flip-front-side .flip-box-front i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .flip-front-side .flip-box-front svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_flip_box_carousel_use_image!' => 'yes',
						'crafto_flip_box_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .flip-front-side .elementor-icon, .flip-front-side .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_carousel_use_image' => '',
						'crafto_flip_box_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_svg_icon_width',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px'  => [
							'min' => 0,
							'max' => 100,
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
						'.flip-front-side .flip-box-front-inner img' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_carousel_use_image' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_icon_spacing',
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
						'{{WRAPPER}} .flip-front-side .elementor-icon, .flip-front-side .flip-box-front-inner img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_icon[value]!' => '',
						'crafto_flip_box_carousel_use_image' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_image_spacing',
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
						'{{WRAPPER}} .flip-front-side .flip-box-front-inner img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_carousel_use_image' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_heading_title',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'separator' => 'before',
					'condition' => [
						'crafto_flip_box_front_side_content_title!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_flip_box_front_side_title_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .flip-front-side .title, {{WRAPPER}} .flip-box-title .title',
					'condition' => [
						'crafto_flip_box_front_side_content_title!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .flip-front-side .title, {{WRAPPER}} .flip-box-title .title' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_flip_box_front_side_content_title!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_title_spacing',
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
						'{{WRAPPER}} .flip-front-side .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_styles' => [
							'flip-box-style-1',
						],
						'crafto_flip_box_front_side_content_title!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fip_box_title_margin',
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
						'{{WRAPPER}} .flip-box-title .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_styles' => [
							'flip-box-style-2',
						],
						'crafto_flip_box_front_side_content_title!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_heading_description',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'separator' => 'before',
					'condition' => [
						'crafto_flip_box_front_side_content_description_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_flip_box_front_side_description_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector'  => '{{WRAPPER}} .flip-front-side .description',
					'condition' => [
						'crafto_flip_box_front_side_content_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .flip-front-side .description' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_flip_box_front_side_content_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_description_spacing',
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
						'{{WRAPPER}} .flip-front-side .description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_front_side_content_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_description_width',
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
							'max'  => 100,
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
						'{{WRAPPER}} .flip-front-side .description' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_front_side_content_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_heading_sub_description',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Sub Description', 'crafto-addons' ),
					'separator' => 'before',
					'condition' => [
						'crafto_flip_box_front_side_content_sub_description_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_flip_box_front_side_sub_description_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector'  => '{{WRAPPER}} .flip-front-side .sub-description',
					'condition' => [
						'crafto_flip_box_front_side_content_sub_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_front_side_sub_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .flip-front-side .sub-description' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_flip_box_front_side_content_sub_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_sub_description_spacing',
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
						'{{WRAPPER}} .flip-front-side .sub-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_front_side_content_sub_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_front_side_sub_description_width',
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
							'max'  => 100,
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
						'{{WRAPPER}} .flip-front-side .sub-description' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_front_side_content_sub_description_text!' => '',
					],
				]
			);
			$this->end_controls_section();
			// End of FRONT SIDE Style section.

			// START of BACK SIDE Style section.
			$this->start_controls_section(
				'crafto_flip_box_back_side_style_section',
				[
					'label' => esc_html__( 'Back Side', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_content_alignment',
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
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .flip-back-side .flip-box-back, {{WRAPPER}} .flip-box-back .flip-box-back-inner' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_content_v_alignment',
				[
					'label'     => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => '',
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center'     => [
							'title' => esc_html__( 'Middle', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .flip-back-side .flip-box-back' => 'justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_flip_back_border',
					'selector'       => '{{WRAPPER}} .flip-back-side',
					'separator'      => 'before',
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
						'color'  => [
							'responsive' => true,
						],
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
				'crafto_flip_box_back_side_content_padding',
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
						'{{WRAPPER}} .flip-back-side .flip-box-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);$this->add_control(
				'crafto_flip_box_back_side_overlay',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_flip_box_back_overlay',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .flip-back-side .flip-back-box-overlay',
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .flip-back-side .flip-back-box-overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_icon',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_flip_box_back_side_use_image' => '',
						'crafto_flip_box_back_icon[value]!' => '',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_image_icon',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_flip_box_back_side_use_image' => 'yes',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_flip_box_back_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .flip-back-side .elementor-icon, {{WRAPPER}} .flip-box-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .flip-back-side .elementor-icon, {{WRAPPER}} .flip-box-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_flip_box_back_side_use_image' => '',
						'crafto_flip_box_back_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .flip-back-side .elementor-icon, .flip-back-side .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .flip-box-back-inner img' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_back_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_image_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .flip-back-side .elementor-icon, .flip-back-side .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .flip-box-back-inner img' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_back_side_use_image' => 'yes',
						'crafto_flip_box_back_icon[value]' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_icon_spacing',
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
						'{{WRAPPER}} .flip-back-side .elementor-icon, .flip-back-side .flip-box-back-inner img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_back_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_image_spacing',
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
						'{{WRAPPER}} .flip-back-side .elementor-icon, .flip-back-side .flip-box-back-inner img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_back_side_use_image' => 'yes',
						'crafto_flip_box_back_icon[value]' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_heading_title',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'separator' => 'before',
					'condition' => [
						'crafto_flip_box_back_side_content_title!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_flip_box_back_side_title_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .flip-back-side .title',
					'condition' => [
						'crafto_flip_box_back_side_content_title!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .flip-back-side .title' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_flip_box_back_side_content_title!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_title_spacing',
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
						'{{WRAPPER}} .flip-back-side .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_back_side_content_title!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_heading_description',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'separator' => 'before',
					'condition' => [
						'crafto_flip_box_back_side_content_description_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_flip_box_back_side_description_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector'  => '{{WRAPPER}} .flip-back-side .description',
					'condition' => [
						'crafto_flip_box_back_side_content_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .flip-back-side .description' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_flip_box_back_side_content_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_description_spacing',
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
						'{{WRAPPER}} .flip-back-side .description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_back_side_content_description_text!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_description_width',
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
							'max'  => 100,
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
						'{{WRAPPER}} .flip-back-side .description' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_flip_box_back_side_content_description_text!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_heading_button',
				[
					'type'      => Controls_Manager::HEADING,
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_flip_box_back_side_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_flip_box_back_side_button_text_shadow',
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);

			$this->start_controls_tabs( 'crafto_flip_box_back_side_tabs_button_style' );
			$this->start_controls_tab(
				'crafto_flip_box_back_side_tab_button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_button_text_color',
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
				'crafto_flip_box_back_side_button_svg_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_selected_back_icon[library]' => 'svg',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_flip_box_back_side_button_icon_color',
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
					'name'      => 'crafto_flip_box_back_side_button_background_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-animation-btn-expand-ltr .btn-hover-animation',
					'condition' => [
						'crafto_button_style!' => [
							'border',
							'double-border',
							'underline',
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
						'crafto_button_style!'    => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style' => [
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
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_back_side_button_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-button',

				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_flip_box_back_side_tab_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_button_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-content-wrapper, {{WRAPPER}} .elementor-button:hover .elementor-button-content-wrapper, {{WRAPPER}} a.elementor-button:focus .elementor-button-content-wrapper, {{WRAPPER}} .elementor-button:focus .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_flip_box_back_side_button_hover_svg_icon_color',
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
					'name'           => 'crafto_flip_box_back_side_button_hover_icon_color',
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
					'name'           => 'crafto_flip_box_back_side_button_background_hover_color',
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
						'crafto_button_style!' => [
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
						'crafto_button_style!'    => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style' => [
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
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_flip_box_back_side_button_hover_box_shadow',
					'selector' => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_flip_box_back_side_button_border',
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
			$this->add_control(
				'crafto_flip_box_back_side_button_border_radius',
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
						'crafto_button_style!' => [
							'underline',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_flip_box_back_side_underline_height',
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
			$this->add_responsive_control(
				'crafto_flip_box_back_side_button_padding',
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
			// End of BACK SIDE Style section.
		}

		/**
		 * Render flip box widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings        = $this->get_settings_for_display();
			$flip_box_styles = ( isset( $settings['crafto_flip_box_styles'] ) && $settings['crafto_flip_box_styles'] ) ? $settings['crafto_flip_box_styles'] : 'flip-box-style-1';

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'flip-box-wrapper',
							$flip_box_styles,
						],
					],
				]
			);
			$this->add_render_attribute(
				[
					'front-main' => [
						'class' => [
							'flip-box',
							'flip-front-side',
						],
					],
				]
			);
			$this->add_render_attribute(
				[
					'back-main' => [
						'class' => [
							'flip-box',
							'flip-back-side',
						],
					],
				]
			);
			switch ( $flip_box_styles ) {
				case 'flip-box-style-1':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<?php $this->crafto_flip_front_back_data(); ?>
					</div>
					<?php
					break;
				case 'flip-box-style-2':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="flip-inner-wrap">
						<?php $this->crafto_flip_front_back_data(); ?>
						</div>
						<div class="flip-box-title">
						<?php
						$crafto_front_side_content_title = ( isset( $settings['crafto_flip_box_front_side_content_title'] ) && $settings['crafto_flip_box_front_side_content_title'] ) ? $settings['crafto_flip_box_front_side_content_title'] : '';
						if ( $crafto_front_side_content_title ) {
							?>
							<<?php echo $this->get_settings( 'crafto_flip_box_front_side_title_size' ); // phpcs:ignore ?> class="title">
								<?php echo esc_html( $crafto_front_side_content_title ); ?>
							</<?php echo $this->get_settings( 'crafto_flip_box_front_side_title_size' ); // phpcs:ignore ?>>
							<?php
						}
						?>
						</div>
					</div>
					<?php
					break;
			}
		}

		/**
		 * Retrieve the flip front/ back data.
		 *
		 * @access public
		 */
		public function crafto_flip_front_back_data() {
			$settings                                  = $this->get_settings_for_display();
			$crafto_front_side_content_title           = ( isset( $settings['crafto_flip_box_front_side_content_title'] ) && $settings['crafto_flip_box_front_side_content_title'] ) ? $settings['crafto_flip_box_front_side_content_title'] : '';
			$crafto_front_side_content_description     = ( isset( $settings['crafto_flip_box_front_side_content_description_text'] ) && $settings['crafto_flip_box_front_side_content_description_text'] ) ? $settings['crafto_flip_box_front_side_content_description_text'] : '';
			$crafto_front_side_content_sub_description = ( isset( $settings['crafto_flip_box_front_side_content_sub_description_text'] ) && $settings['crafto_flip_box_front_side_content_sub_description_text'] ) ? $settings['crafto_flip_box_front_side_content_sub_description_text'] : '';
			$crafto_back_side_content_title            = ( isset( $settings['crafto_flip_box_back_side_content_title'] ) && $settings['crafto_flip_box_back_side_content_title'] ) ? $settings['crafto_flip_box_back_side_content_title'] : '';
			$crafto_back_side_content_description      = ( isset( $settings['crafto_flip_box_back_side_content_description_text'] ) && $settings['crafto_flip_box_back_side_content_description_text'] ) ? $settings['crafto_flip_box_back_side_content_description_text'] : '';
			?>
			<div <?php $this->print_render_attribute_string( 'front-main' ); ?>>
				<div class="flip-front-box-overlay"></div>
				<div class="flip-box-front">
					<div class="flip-box-front-inner">
						<?php
						$this->front_flip_box_icon();
						if ( 'flip-box-style-1' === $settings['crafto_flip_box_styles'] ) {
							if ( $crafto_front_side_content_title ) {
								?>
								<<?php echo $this->get_settings( 'crafto_flip_box_front_side_title_size' ); // phpcs:ignore ?> class="title">
									<?php echo esc_html( $crafto_front_side_content_title ); ?>
								</<?php echo $this->get_settings( 'crafto_flip_box_front_side_title_size' ); // phpcs:ignore ?>>
								<?php
							}
						}
						if ( $crafto_front_side_content_description ) {
							?>
							<span class="description">
								<?php echo sprintf( '%s', wp_kses_post( $crafto_front_side_content_description ) ); // phpcs:ignore ?>
							</span>
							<?php
						}
						if ( $crafto_front_side_content_sub_description ) {
							?>
							<span class="sub-description">
								<?php echo sprintf( '%s', wp_kses_post( $crafto_front_side_content_sub_description ) ); // phpcs:ignore ?>
							</span>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<div <?php $this->print_render_attribute_string( 'back-main' ); ?>>
				<div class="flip-back-box-overlay"></div>
				<div class="flip-box-back">
					<div class="flip-box-back-inner">
						<?php
						$this->front_flip_box_back_icon();
						if ( $crafto_back_side_content_title ) {
							?>
							<<?php echo $this->get_settings( 'crafto_flip_box_back_side_title_size' ); // phpcs:ignore ?> class="title">
								<?php echo esc_html( $crafto_back_side_content_title ); ?>
							</<?php echo $this->get_settings( 'crafto_flip_box_back_side_title_size' ); // phpcs:ignore ?>>
							<?php
						}
						if ( $crafto_back_side_content_description ) {
							?>
							<span class="description">
								<?php echo sprintf( '%s', wp_kses_post( $crafto_back_side_content_description ) ); // phpcs:ignore ?>
							</span>
							<?php
						}
						$this->crafto_get_button();
						?>
					</div>
				</div>
			</div>
			<?php
		}
		/**
		 * Retrieve the button.
		 *
		 * @access public
		 */
		public function crafto_get_button() {
			$settings                  = $this->get_settings_for_display();
			$button_hover_animation    = $settings['crafto_flip_box_back_side_button_hover_animation'];
			$button_text               = ( isset( $settings['crafto_flip_box_back_side_content_button_text'] ) && $settings['crafto_flip_box_back_side_content_button_text'] ) ? $settings['crafto_flip_box_back_side_content_button_text'] : '';
			$has_button_icon           = ! empty( $settings['icon'] );
			$crafto_back_icon_align    = $settings['crafto_back_icon_align'];
			$crafto_button_style       = $this->get_settings( 'crafto_button_style' );
			$crafto_icon_shape_style   = $this->get_settings( 'crafto_icon_shape_style' );
			$crafto_selected_back_icon = $this->get_settings( 'crafto_selected_back_icon' );

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

			$this->add_render_attribute(
				[
					'button' => [
						'class' => [
							'elementor-button',
							'btn-icon-' . $settings['crafto_back_icon_align'],
						],
						'role'  => 'button',
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

			if ( 'btn-reveal-icon' === $button_hover_animation && 'left' === $crafto_back_icon_align ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-reveal-icon-left',
						],
					],
				);
			}

			if ( ! $has_button_icon && ! empty( $settings['crafto_selected_back_icon']['value'] ) ) {
				$has_button_icon = true;
			}

			$is_new        = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_migrated = isset( $settings['__fa4_migrated']['crafto_selected_back_icon'] );
			if ( ! $is_new && empty( $settings['crafto_back_icon_align'] ) ) {
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
						],
					],
				],
			);

			if ( 'btn-switch-icon' !== $button_hover_animation && $settings['crafto_back_icon_align'] ) {
				$this->add_render_attribute(
					[
						'icon-align' => [
							'class' => [
								'elementor-align-icon-' . $settings['crafto_back_icon_align'],
							],
						],
					],
				);
			}

			if ( ! empty( $settings['crafto_flip_box_back_side_content_button_link']['url'] ) ) {
				$this->add_link_attributes( 'button', $settings['crafto_flip_box_back_side_content_button_link'] );
				if ( '' === $crafto_button_style || 'border' === $crafto_button_style ) {
					if ( ! empty( $crafto_selected_back_icon['value'] ) ) {
						$this->add_render_attribute( 'button', 'class', $crafto_icon_shape_style );
					}
				}
				$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
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
				if ( '' === $crafto_button_style || 'border' === $crafto_button_style ) {
					$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $button_hover_animation );
				}
				if ( in_array( $button_hover_animation, $hover_animation_effect_array, true ) ) {
					$custom_animation_class = 'btn-custom-effect';

					if ( ! in_array( $button_hover_animation, array( 'btn-switch-icon', 'btn-switch-text' ), true ) ) {
						$custom_animation_div = '<span class="btn-hover-animation"></span>';
					}
				}
			}
			if ( 'expand-border' === $crafto_button_style ) {
				$custom_animation_div = '<span class="btn-hover-animation"></span>';
			}
			$this->add_render_attribute( 'button', 'class', [ $custom_animation_class ] );

			if ( ! empty( $settings['crafto_flip_box_back_side_content_button_size'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['crafto_flip_box_back_side_content_button_size'] );
			}
			if ( 'btn-switch-text' === $button_hover_animation && $settings['crafto_flip_box_back_side_content_button_text'] ) {
				$this->add_render_attribute(
					[
						'btn_text' => [
							'data-btn-text' => wp_strip_all_tags( $settings['crafto_flip_box_back_side_content_button_text'] ),
						],
					],
				);
			}

			if ( ! empty( $button_text ) ) {
				ob_start();
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

						if ( 'btn-switch-icon' === $button_hover_animation ) {
							if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_selected_back_icon']['value'] ) ) :
								?>
								<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
									<?php
									if ( $is_new || $icon_migrated ) {
										Icons_Manager::render_icon( $settings['crafto_selected_back_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( isset( $settings['crafto_selected_back_icon']['value'] ) && ! empty( $settings['crafto_selected_back_icon']['value'] ) ) {
										?>
										<i class="<?php echo esc_attr( $settings['crafto_selected_back_icon']['value'] ); ?>" aria-hidden="true"></i>
										<?php
									}
									?>
								</span>
								<?php
							endif;
						}
						?>
					</div>
					<?php
						echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
					?>
					</a>
				</div>
				<?php
				$output = ob_get_contents();
				ob_get_clean();
				echo sprintf( '%s', $output ); // phpcs:ignore
			}
		}
		/**
		 * Retrieve the front icon.
		 *
		 * @access public
		 */
		public function front_flip_box_icon() {

			$settings      = $this->get_settings_for_display();
			$has_icon      = ! empty( $settings['icon'] );
			$is_new        = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_migrated = isset( $settings['__fa4_migrated']['crafto_flip_box_icon'] );
			if ( ! $has_icon && ! empty( $settings['crafto_flip_box_icon']['value'] ) ) {
				$has_icon = true;
			}

			if ( ! empty( $settings['crafto_flip_box_item_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_flip_box_item_image']['id'] ) ) {
				$settings['crafto_flip_box_item_image']['id'] = '';
			}
			if ( ! empty( $has_icon ) && ( '' === $settings['crafto_flip_box_carousel_use_image'] ) ) {
				?>
				<span class="elementor-icon">
					<?php
					if ( $is_new || $icon_migrated ) {
						Icons_Manager::render_icon( $settings['crafto_flip_box_icon'] );
					} elseif ( isset( $settings['crafto_flip_box_icon']['value'] ) && ! empty( $settings['crafto_flip_box_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['crafto_flip_box_icon']['value'] ) . '"></i>';
					}
					?>
				</span>
				<?php
			} elseif ( isset( $settings['crafto_flip_box_item_image'] ) && isset( $settings['crafto_flip_box_item_image']['id'] ) && ! empty( $settings['crafto_flip_box_item_image']['id'] ) ) {
					crafto_get_attachment_html( $settings['crafto_flip_box_item_image']['id'], $settings['crafto_flip_box_item_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			} elseif ( isset( $settings['crafto_flip_box_item_image'] ) && isset( $settings['crafto_flip_box_item_image']['url'] ) && ! empty( $settings['crafto_flip_box_item_image']['url'] ) ) {
					crafto_get_attachment_html( $settings['crafto_flip_box_item_image']['id'], $settings['crafto_flip_box_item_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			}
		}
		/**
		 * Retrieve the Back icon.
		 *
		 * @access public
		 */
		public function front_flip_box_back_icon() {

			$settings      = $this->get_settings_for_display();
			$has_icon      = ! empty( $settings['icon'] );
			$is_new        = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_migrated = isset( $settings['__fa4_migrated']['crafto_flip_box_back_icon'] );
			if ( ! $has_icon && ! empty( $settings['crafto_flip_box_back_icon']['value'] ) ) {
				$has_icon = true;
			}
			if ( ! empty( $settings['crafto_flip_box_back_item_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_flip_box_back_item_image']['id'] ) ) {
				$settings['crafto_flip_box_back_item_image']['id'] = '';
			}
			if ( ! empty( $has_icon ) && ( '' === $settings['crafto_flip_box_carousel_use_image'] ) ) {
				?>
				<span class="elementor-icon">
					<?php
					if ( $is_new || $icon_migrated ) {
						Icons_Manager::render_icon( $settings['crafto_flip_box_back_icon'] );
					} elseif ( isset( $settings['crafto_flip_box_back_icon']['value'] ) && ! empty( $settings['crafto_flip_box_back_icon']['value'] ) ) {
						echo '<i class="' . esc_attr( $settings['crafto_flip_box_back_icon']['value'] ) . '"></i>';
					}
					?>
				</span>
				<?php
			} elseif ( isset( $settings['crafto_flip_box_back_item_image'] ) && isset( $settings['crafto_flip_box_back_item_image']['id'] ) && ! empty( $settings['crafto_flip_box_back_item_image']['id'] ) ) {
					crafto_get_attachment_html( $settings['crafto_flip_box_back_item_image']['id'], $settings['crafto_flip_box_back_item_image']['url'], $settings['crafto_back_thumbnail_size'] );
			} elseif ( isset( $settings['crafto_flip_box_back_item_image'] ) && isset( $settings['crafto_flip_box_back_item_image']['url'] ) && ! empty( $settings['crafto_flip_box_back_item_image']['url'] ) ) {
					crafto_get_attachment_html( $settings['crafto_flip_box_back_item_image']['id'], $settings['crafto_flip_box_back_item_image']['url'], $settings['crafto_back_thumbnail_size'] );
			}
		}
	}
}
