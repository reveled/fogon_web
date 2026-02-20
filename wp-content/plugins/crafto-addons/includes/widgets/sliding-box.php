<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Button_Group_Control;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget for Sliding Box.
 *
 * @package Crafto
 */

// If class `Sliding_Box` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Sliding_Box' ) ) {
	/**
	 * Define `Sliding_Box` class.
	 */
	class Sliding_Box extends Widget_Base {
		/**
		 * Retrieve the list of scripts the sliding box widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-sliding-box-widget' ];
			}
		}

		/**
		 * Retrieve the list of styles the sliding box widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$sliding_box_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$sliding_box_styles[] = 'crafto-widgets-rtl';
				} else {
					$sliding_box_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$sliding_box_styles[] = 'crafto-sliding-box-rtl-widget';
				}
				$sliding_box_styles[] = 'crafto-sliding-box-widget';
			}
			return $sliding_box_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve Sliding widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-sliding-box';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve sliding box widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Sliding Box', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve sliding box widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-slider-push crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/sliding-box/';
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
				'number',
				'image',
				'carousel',
				'slider',
				'flip box',
			];
		}

		/**
		 * Register sliding box widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_image_carousel_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_sliding_box_styles',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'crafto-sliding-box-styles-1',
					'options'            => [
						'crafto-sliding-box-styles-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'crafto-sliding-box-styles-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'crafto-sliding-box-styles-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs(
				'crafto_sliding_box_tabs',
			);
			$repeater->add_control(
				'crafto_sliding_box_image',
				[
					'label'   => esc_html__( 'Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);
			$repeater->add_control(
				'crafto_sliding_box_title',
				[
					'label'       => esc_html__( 'Image Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Add title here', 'crafto-addons' ),
					'description' => esc_html__( 'Not applicable in style 3.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_sliding_box_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( '01', 'crafto-addons' ),
					'description' => esc_html__( 'Not applicable in style 3.', 'crafto-addons' ),
				]
			);

			$repeater->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					],
					'description'      => esc_html__( 'Not applicable in style 3.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_sliding_box_heading',
				[
					'label'       => esc_html__( 'Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Add heading here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_sliding_box_subheading',
				[
					'label'       => esc_html__( 'Subheading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Add subheading here', 'crafto-addons' ),
					'label_block' => true,
					'description' => esc_html__( 'Applicable in style 3 only.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_sliding_box_content',
				[
					'label'       => esc_html__( 'Content', 'crafto-addons' ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_time_icon',
				[
					'label'            => esc_html__( 'Time Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'description'      => esc_html__( 'Applicable in style 2 only.', 'crafto-addons' ),
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'feather icon-feather-clock',
						'library' => 'feather',
					],
				]
			);
			$repeater->add_control(
				'crafto_sliding_box_time',
				[
					'label'       => esc_html__( 'Time', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Applicable in style 2 only.', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Add time here', 'crafto-addons' ),
					'label_block' => true,
				]
			);

			Button_Group_Control::repeater_button_content_fields(
				$repeater,
				[
					'id'    => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
			);

			$repeater->end_controls_tabs();
			$this->add_control(
				'crafto_sliding_box',
				[
					'label'       => esc_html__( 'Sliding Box Items', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_sliding_box_heading' => esc_html__( 'Add heading here', 'crafto-addons' ),
							'crafto_sliding_box_number'  => esc_html__( '1', 'crafto-addons' ),
							'crafto_sliding_box_content' => esc_html__( 'Lorem ipsum dolor sit amet.', 'crafto-addons' ),
						],
						[
							'crafto_sliding_box_heading' => esc_html__( 'Add heading here', 'crafto-addons' ),
							'crafto_sliding_box_number'  => esc_html__( '2', 'crafto-addons' ),
							'crafto_sliding_box_content' => esc_html__( 'Lorem ipsum dolor sit amet.', 'crafto-addons' ),
						],
						[
							'crafto_sliding_box_heading' => esc_html__( 'Add heading here', 'crafto-addons' ),
							'crafto_sliding_box_number'  => esc_html__( '3', 'crafto-addons' ),
							'crafto_sliding_box_content' => esc_html__( 'Lorem ipsum dolor sit amet.', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_image_content_settings',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'exclude'   => [
						'custom',
					],
					'separator' => 'none',
				]
			);
			$this->add_control(
				'crafto_sliding_box_title_size',
				[
					'label'   => esc_html__( 'Image Heading Title HTML Tag', 'crafto-addons' ),
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
				'crafto_sliding_box_heading_size',
				[
					'label'   => esc_html__( 'Heading Title HTML Tag', 'crafto-addons' ),
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
			$this->end_controls_section();

			Button_Group_Control::repeater_button_setting_fields(
				$this,
				[
					'id'    => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
			);

			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_aligment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
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
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end' : 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .sliding-box-content' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_content_title_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .sliding-box-content',
					'condition' => [
						'crafto_sliding_box_styles' => [
							'crafto-sliding-box-styles-1',
							'crafto-sliding-box-styles-2',
						],
					],
				]
			);

			$this->add_control(
				'crafto_content_title_background',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-sliding-box-styles-3 .sliding-box-content::after' => 'border-right-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-sliding-box-styles-3 .sliding-box-content'        => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_sliding_box_styles' => [
							'crafto-sliding-box-styles-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_sliding_box_shadow',
					'selector' => '{{WRAPPER}} .sliding-box-item',
				]
			);
			$this->add_responsive_control(
				'crafto_content_title_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .sliding-box-item' => 'height: {{SIZE}}{{UNIT}} !important',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_sliding_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .sliding-box-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_sliding_box_padding',
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
						'{{WRAPPER}} .sliding-box-item .sliding-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_sliding_box_styles' => [
							'crafto-sliding-box-styles-1',
							'crafto-sliding-box-styles-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_sliding_box_title',
				[
					'label'     => esc_html__( 'Image Heading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_sliding_box_styles!' => 'crafto-sliding-box-styles-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_sliding_box_vertical_position',
				[
					'label'     => esc_html__( 'Vertical Align', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
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
						'{{WRAPPER}} .sliding-box .overlay-content, {{WRAPPER}} .sliding-box .overlay-time' => 'justify-content: {{VALUE}};',
					],
					'default'   => 'center',
					'condition' => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .title',
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box .overlay-content .title, {{WRAPPER}} .sliding-box .overlay-content .title a, {{WRAPPER}} .sliding-box .overlay-time .title, {{WRAPPER}} .sliding-box .overlay-time .title a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_sliding_box_title_spacing',
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
						'{{WRAPPER}} .sliding-box .overlay-content .title, {{WRAPPER}} .sliding-box .overlay-time .title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_sliding_image_box_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .sliding-box-img .overlay-time',
					'condition' => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_sliding_title_width',
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
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .sliding-box-img .overlay-time' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-2',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_sliding_content',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .sliding-box .sliding-box-content .content',
				]
			);
			$this->add_control(
				'crafto_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box .sliding-box-content .content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_spacing',
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
						'{{WRAPPER}} .sliding-box .sliding-box-content .content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-1',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_sliding_box_icon',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_sliding_box_styles!' => 'crafto-sliding-box-styles-3',
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
					'default'      => 'default',
					'prefix_class' => 'elementor-view-',
				]
			);
			$this->add_control(
				'crafto_icon_shape',
				[
					'label'        => esc_html__( 'Shape', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => esc_html__( 'Circle', 'crafto-addons' ),
						'square' => esc_html__( 'Square', 'crafto-addons' ),
					],
					'default'      => 'circle',
					'condition'    => [
						'crafto_view!' => 'default',
					],
					'prefix_class' => 'elementor-shape-',
				]
			);
			$this->add_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 6,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_padding',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 0,
							'max' => 80,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => 'default',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_icon_spacing',
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
						'{{WRAPPER}} .sliding-box .elementor-icon:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->start_controls_tabs( 'icon_tabs' );

			$this->start_controls_tab(
				'crafto_icon_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default .elementor-icon i, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-framed .elementor-icon i'     => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon svg'      => 'fill: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'     => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_view' => 'stacked',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'     => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_view' => 'framed',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_sliding_box_icon_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view' => [
							'framed',
						],
					],
				]
			);
			$this->add_control(
				'crafto_sliding_box_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ '%', 'px', 'custom' ],
					'default'    => [
						'unit' => '%',
					],
					'range'      => [
						'%' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => 'default',
					],
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_icon_colors_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_hover_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon i, {{WRAPPER}}.elementor-view-default:hover .elementor-icon i, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-default:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_hover_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_view'               => 'stacked',
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_view' => 'framed',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_sliding_heading',
				[
					'label' => esc_html__( 'Heading', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_heading_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .sliding-box .sliding-box-content .heading',
				]
			);
			$this->add_control(
				'crafto_heading_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box .sliding-box-content .heading, {{WRAPPER}} .sliding-box .sliding-box-content .heading a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_heading_spacing',
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
						'{{WRAPPER}} .sliding-box .sliding-box-content .heading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_sliding_subheading',
				[
					'label'     => esc_html__( 'Subheading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-3',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_subeading_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .sliding-box .sliding-box-content .subheading',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_subeading_color',
					'selector'       => '{{WRAPPER}} .sliding-box .sliding-box-content .subheading',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_subeading_spacing',
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
						'{{WRAPPER}} .sliding-box .sliding-box-content .subheading:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_sliding_number',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_sliding_box_styles!' => 'crafto-sliding-box-styles-3',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .sliding-box .overlay-content .number, {{WRAPPER}} .sliding-box .overlay-time .number',
				]
			);
			$this->add_control(
				'crafto_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box .overlay-content .number, {{WRAPPER}} .sliding-box .overlay-content .number a, {{WRAPPER}} .sliding-box .overlay-time .number, {{WRAPPER}} .sliding-box .overlay-time .number a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_sliding_box_time_title',
				[
					'label'     => esc_html__( 'Time', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_sliding_box_styles' => 'crafto-sliding-box-styles-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_time_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .sliding-box-content .sliding-content-time .sliding-box-timing',
				]
			);
			$this->add_control(
				'crafto_title_time_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box-content .sliding-content-time .sliding-box-timing' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_sliding_box_timing_icon',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_time_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box-content .sliding-content-time i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .sliding-box-content .sliding-content-time svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_time_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 6,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .sliding-box-content .sliding-content-time i, {{WRAPPER}} .sliding-box-content .sliding-content-time svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'crafto_sliding_box_timing_separator',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_sliding_image_box_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box-content .sliding-content-time' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_sliding_image_box_width',
				[
					'label'      => esc_html__( 'Separator Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'unit' => 'px',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .sliding-box-content .sliding-content-time' => 'border-width: {{SIZE}}{{UNIT}};',
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
				'crafto_section_style_sliding_box_overlay',
				[
					'label' => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_section_style_sliding_box_overlay',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .sliding-box .overlay',
				]
			);
			$this->add_control(
				'crafto_section_style_sliding_box_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .sliding-box .overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render sliding box widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                  = $this->get_settings_for_display();
			$crafto_sliding_box_styles = ( isset( $settings['crafto_sliding_box_styles'] ) && $settings['crafto_sliding_box_styles'] ) ? $settings['crafto_sliding_box_styles'] : 'crafto-sliding-box-styles-1';

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'sliding-box',
							$crafto_sliding_box_styles,
						],
					],
				]
			);

			switch ( $crafto_sliding_box_styles ) {
				case 'crafto-sliding-box-styles-1':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
						<?php
						foreach ( $settings['crafto_sliding_box'] as $index => $item ) {

							$index            = ++$index;
							$wrapper_key      = 'wrapper_' . $index;
							$main_wrapper_key = 'main_wrapper_' . $index;
							$button_key       = 'button_' . $index;

							$migrated = isset( $item['__fa4_migrated']['crafto_selected_icon'] );
							$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

							$this->add_render_attribute(
								$main_wrapper_key,
								[
									'class' => [
										'elementor-repeater-item-' . $item['_id'],
										'sliding-box-main',
									],
								]
							);
							$this->add_render_attribute(
								$wrapper_key,
								[
									'class' => [
										'sliding-box-item',
										2 === $index ? 'active' : '',
									],
								]
							);
							?>
							<div <?php $this->print_render_attribute_string( $main_wrapper_key ); ?>>
								<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
									<div class="sliding-box-img">
										<?php
										$this->get_sliding_box_image( $item );
										if ( ! empty( $item['crafto_sliding_box_title'] ) || ! empty( $item['crafto_sliding_box_number'] ) ) {
											?>
											<div class="overlay-content">
												<?php
												if ( ! empty( $item['crafto_sliding_box_title'] ) ) {
													?>
													<<?php echo $this->get_settings( 'crafto_sliding_box_title_size' ); // phpcs:ignore ?> class="title">
														<?php echo esc_html( $item['crafto_sliding_box_title'] ); ?>
													</<?php echo $this->get_settings( 'crafto_sliding_box_title_size' ); // phpcs:ignore ?>>
													<?php
												}
												if ( ! empty( $item['crafto_sliding_box_number'] ) ) {
													?>
													<span class="number">
														<?php echo esc_html( $item['crafto_sliding_box_number'] ); ?>
													</span>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>
										<div class="overlay"></div>
									</div>
									<div class="sliding-box-content">
										<?php
										if ( ! empty( $item['crafto_selected_icon']['value'] ) || ! empty( $item['crafto_sliding_box_heading'] ) || ! empty( $item['crafto_sliding_box_content'] ) ) {
											?>
											<div class="sliding-box-content-hover">
												<?php
												if ( ! empty( $item['crafto_selected_icon']['value'] ) ) {
													?>
													<div class="elementor-icon">
														<?php
														if ( $is_new || $migrated ) {
															Icons_Manager::render_icon( $item['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
														} elseif ( isset( $item['crafto_selected_icon']['value'] ) && ! empty( $item['crafto_selected_icon']['value'] ) ) {
															?>
															<i class="<?php echo esc_attr( $item['crafto_selected_icon'] ); ?>" aria-hidden="true"></i>
															<?php
														}
														?>
													</div>
													<?php
												}
												if ( ! empty( $item['crafto_sliding_box_heading'] ) ) {
													?>
													<<?php echo $this->get_settings( 'crafto_sliding_box_heading_size' ); // phpcs:ignore ?> class="heading">
														<?php echo esc_html( $item['crafto_sliding_box_heading'] ); ?>
													</<?php echo $this->get_settings( 'crafto_sliding_box_heading_size' ); // phpcs:ignore ?>>
													<?php
												}
												if ( ! empty( $item['crafto_sliding_box_content'] ) ) {
													?>
													<div class="content">
														<?php echo sprintf( '%s', wp_kses_post( $item['crafto_sliding_box_content'] ) ); // phpcs:ignore?>
													</div>
													<?php
												}
												Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
												?>
											</div>
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					break;
				case 'crafto-sliding-box-styles-2':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
						<?php
						foreach ( $settings['crafto_sliding_box'] as $index => $item ) {

							$index            = ++$index;
							$wrapper_key      = 'wrapper_' . $index;
							$button_key       = 'button_' . $index;
							$main_wrapper_key = 'main_wrapper_' . $index;

							$migrated = isset( $item['__fa4_migrated']['crafto_selected_icon'] );
							$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

							$time_migrated = isset( $item['__fa4_migrated']['crafto_time_icon'] );
							$time_is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

							$this->add_render_attribute(
								$main_wrapper_key,
								[
									'class' => [
										'elementor-repeater-item-' . $item['_id'],
										'sliding-box-main',
									],
								]
							);
							$this->add_render_attribute(
								$wrapper_key,
								[
									'class' => [
										'sliding-box-item',
										2 === $index ? 'active' : '',
									],
								]
							);
							?>
							<div <?php $this->print_render_attribute_string( $main_wrapper_key ); ?>>
								<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
									<div class="sliding-box-img">
										<?php
										$this->get_sliding_box_image( $item );
										if ( ! empty( $item['crafto_sliding_box_title'] ) || ! empty( $item['crafto_sliding_box_number'] ) ) {
											?>
											<div class="overlay-time">
												<?php
												if ( ! empty( $item['crafto_sliding_box_number'] ) ) {
													?>
													<span class="number">
														<?php echo esc_html( $item['crafto_sliding_box_number'] ); ?>
													</span>
													<?php
												}
												if ( ! empty( $item['crafto_sliding_box_title'] ) ) {
													?>
													<<?php echo $this->get_settings( 'crafto_sliding_box_title_size' ); // phpcs:ignore ?> class="title">
														<?php echo esc_html( $item['crafto_sliding_box_title'] ); ?>
													</<?php echo $this->get_settings( 'crafto_sliding_box_title_size' ); // phpcs:ignore ?>>
													<?php
												}
												?>
											</div>
											<?php
										}
										?>
										<div class="overlay"></div>
									</div>
									<div class="sliding-box-content">
										<?php
										if ( ! empty( $item['crafto_selected_icon']['value'] ) || ! empty( $item['crafto_time_icon']['value'] ) || ! empty( $item['crafto_sliding_box_heading'] ) || ! empty( $item['crafto_sliding_box_content'] ) || ! empty( $item['crafto_sliding_box_time'] ) ) {
											?>
											<div class="sliding-box-content-hover">
												<?php
												if ( ! empty( $item['crafto_selected_icon']['value'] ) ) {
													?>
													<div class="elementor-icon">
														<?php
														if ( $is_new || $migrated ) {
															Icons_Manager::render_icon( $item['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
														} elseif ( isset( $item['crafto_selected_icon']['value'] ) && ! empty( $item['crafto_selected_icon']['value'] ) ) {
															?>
															<i class="<?php echo esc_attr( $item['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
															<?php
														}
														?>
													</div>
													<?php
												}
												if ( ! empty( $item['crafto_sliding_box_heading'] ) ) {
													?>
													<<?php echo $this->get_settings( 'crafto_sliding_box_heading_size' ); // phpcs:ignore ?> class="heading">
														<?php echo esc_html( $item['crafto_sliding_box_heading'] ); ?>
													</<?php echo $this->get_settings( 'crafto_sliding_box_heading_size' ); // phpcs:ignore ?>>
													<?php
												}

												if ( ! empty( $item['crafto_sliding_box_content'] ) ) {
													?>
													<div class="content">
														<?php echo sprintf( '%s', wp_kses_post( $item['crafto_sliding_box_content'] ) ); // phpcs:ignore?>
													</div>
													<?php
												}
												Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
												?>
												<div class="sliding-content-time">
													<?php
													if ( ! empty( $item['crafto_time_icon']['value'] ) ) {
														?>
														<?php
														if ( $time_is_new || $time_migrated ) {
															Icons_Manager::render_icon( $item['crafto_time_icon'], [ 'aria-hidden' => 'true' ] );
														} elseif ( isset( $item['crafto_time_icon']['value'] ) && ! empty( $item['crafto_time_icon']['value'] ) ) {
															?>
															<i class="<?php echo esc_attr( $item['crafto_time_icon'] ); ?>" aria-hidden="true"></i>
															<?php
														}
														?>
														<?php
													}
													?>
													<span class="sliding-box-timing">
														<?php echo sprintf( '%s', wp_kses_post( $item['crafto_sliding_box_time'] ) ); // phpcs:ignore?>
													</span>
												</div>
											</div>
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					break;
				case 'crafto-sliding-box-styles-3':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); // phpcs:ignore ?>>
						<?php
						foreach ( $settings['crafto_sliding_box'] as $index => $item ) {
							$index            = ++$index;
							$wrapper_key      = 'wrapper_' . $index;
							$main_wrapper_key = 'main_wrapper_' . $index;
							$button_key       = 'button_' . $index;

							$this->add_render_attribute(
								$main_wrapper_key,
								[
									'class' => [
										'elementor-repeater-item-' . $item['_id'],
										'sliding-box-main',
									],
								]
							);
							$this->add_render_attribute(
								$wrapper_key,
								[
									'class' => [
										'sliding-box-item',
										2 === $index ? 'active' : '',
									],
								]
							);
							?>
							<div <?php $this->print_render_attribute_string( $main_wrapper_key ); ?>>
								<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
									<div class="sliding-box-img">
										<?php $this->get_sliding_box_image( $item ); ?>
										<div class="overlay"></div>
									</div>
									<div class="sliding-box-content">
										<?php
										if ( ! empty( $item['crafto_selected_icon']['value'] ) || ! empty( $item['crafto_sliding_box_heading'] ) || ! empty( $item['crafto_sliding_box_subheading'] ) || ! empty( $item['crafto_sliding_box_content'] ) ) {
											?>
											<div class="sliding-box-content-hover">
												<?php
												if ( ! empty( $item['crafto_sliding_box_subheading'] ) ) {
													?>
													<span class="subheading">
														<?php echo esc_html( $item['crafto_sliding_box_subheading'] ); ?>
													</span>
													<?php
												}
												if ( ! empty( $item['crafto_sliding_box_heading'] ) ) {
													?>
													<<?php echo $this->get_settings( 'crafto_sliding_box_heading_size' ); // phpcs:ignore ?> class="heading">
														<?php echo esc_html( $item['crafto_sliding_box_heading'] ); ?>
													</<?php echo $this->get_settings( 'crafto_sliding_box_heading_size' ); // phpcs:ignore ?>>
													<?php
												}
												if ( ! empty( $item['crafto_sliding_box_content'] ) ) {
													?>
													<div class="content">
														<?php echo sprintf( '%s', wp_kses_post( $item['crafto_sliding_box_content'] ) ); // phpcs:ignore?>
													</div>
													<?php
												}
												Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
												?>
											</div>
											<?php
										}
										?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					break;
			}
		}
		/**
		 *  Return Sliding box Image.
		 *
		 * @since 1.0
		 * @param array $item Widget data.
		 * @access public
		 */
		public function get_sliding_box_image( $item ) {
			$settings = $this->get_settings_for_display();
			if ( ! empty( $item['crafto_sliding_box_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_sliding_box_image']['id'] ) ) {
				$item['crafto_sliding_box_image']['id'] = '';
			}

			if ( isset( $item['crafto_sliding_box_image'] ) && isset( $item['crafto_sliding_box_image']['id'] ) && ! empty( $item['crafto_sliding_box_image']['id'] ) ) {
				crafto_get_attachment_html( $item['crafto_sliding_box_image']['id'], $item['crafto_sliding_box_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			} elseif ( isset( $item['crafto_sliding_box_image'] ) && isset( $item['crafto_sliding_box_image']['url'] ) && ! empty( $item['crafto_sliding_box_image']['url'] ) ) {
				crafto_get_attachment_html( $item['crafto_sliding_box_image']['id'], $item['crafto_sliding_box_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			}
		}
	}
}
