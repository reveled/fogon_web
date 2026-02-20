<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for Feature box.
 *
 * @package Crafto
 */

// If class `Feature_Box` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Feature_Box' ) ) {
	/**
	 * Define `Feature_Box` class.
	 */
	class Feature_Box extends Widget_Base {
		/**
		 * Retrieve the list of styles the Feature box widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$feature_box_styles  = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$feature_box_styles[] = 'crafto-widgets-rtl';
				} else {
					$feature_box_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$feature_box_styles[] = 'crafto-feature-box-rtl';
				}
				$feature_box_styles[] = 'crafto-feature-box';
			}
			return $feature_box_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-feature-box';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Feature Box', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/feature-box/';
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
				'content',
				'info',
				'benefit',
				'service',
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
		 * Register feature box widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_feature_box_settings_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),

				]
			);
			$this->add_control(
				'crafto_feature_box_styles',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'feature-box-style-1',
					'options' => [
						'feature-box-style-1'  => esc_html__( 'Style 1', 'crafto-addons' ),
						'feature-box-style-2'  => esc_html__( 'Style 2', 'crafto-addons' ),
						'feature-box-style-3'  => esc_html__( 'Style 3', 'crafto-addons' ),
						'feature-box-style-4'  => esc_html__( 'Style 4', 'crafto-addons' ),
						'feature-box-style-5'  => esc_html__( 'Style 5', 'crafto-addons' ),
						'feature-box-style-6'  => esc_html__( 'Style 6', 'crafto-addons' ),
						'feature-box-style-7'  => esc_html__( 'Style 7', 'crafto-addons' ),
						'feature-box-style-8'  => esc_html__( 'Style 8', 'crafto-addons' ),
						'feature-box-style-9'  => esc_html__( 'Style 9', 'crafto-addons' ),
						'feature-box-style-10' => esc_html__( 'Style 10', 'crafto-addons' ),
						'feature-box-style-11' => esc_html__( 'Style 11', 'crafto-addons' ),
						'feature-box-style-12' => esc_html__( 'Style 12', 'crafto-addons' ),
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_title_section',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_feature_box_hover_title',
				[
					'label'       => esc_html__( 'Hover Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'condition'   => [
						'crafto_feature_box_styles' => [
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_title_link',
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
					'condition'   => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_header_title_size',
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
				'crafto_enable_separator_effect',
				[
					'label'        => esc_html__( 'Glow Line Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_feature_box_styles' => [
							'feature-box-style-11',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_label_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( '20k', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_subtitle_section',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-5',
							'feature-box-style-10',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_subtitle',
				[
					'label'       => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write subtitle here', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_image_section',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_trainer_image',
				[
					'label'   => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_trainer_image_thumbnail',
					'default'   => 'full',
					'exclude'   => [
						'custom',
					],
					'separator' => 'none',
					'condition' => [
						'crafto_trainer_image[url]!' => '',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_number_section',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-1',
							'feature-box-style-3',
							'feature-box-style-8',
							'feature-box-style-11',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( '01', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_content_section',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-7',
							'feature-box-style-10',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_content',
				[
					'label'      => esc_html__( 'Content', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'show_label' => true,
					'dynamic'    => [
						'active' => true,
					],
					'default'    => esc_html__( 'Lorem ipsum simply dummy text printing typesetting.', 'crafto-addons' ),
				],
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_icon_image_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_icon_number',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => esc_html__( '5', 'crafto-addons' ),
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_custom_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_feature_box_styles!' => 'feature-box-style-10',
					],
				]
			);

			$this->add_control(
				'crafto_icons',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					),
					'condition'        => [
						'crafto_custom_image' => '',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);

			$this->add_control(
				'crafto_image',
				[
					'label'     => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_custom_image!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'large',
					'separator' => 'none',
					'condition' => [
						'crafto_custom_image!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_icon_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'default',
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'condition'    => [
						'crafto_custom_image'        => '',
						'crafto_icons[library]!'     => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-9',
							'feature-box-style-10',
							'feature-box-style-11',
						],
					],
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
						'crafto_icon_view!'          => 'default',
						'crafto_custom_image'        => '',
						'crafto_icons[library]!'     => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-9',
							'feature-box-style-10',
							'feature-box-style-11',
						],
					],
					'prefix_class' => 'elementor-shape-',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_text_section',
				[
					'label'     => esc_html__( 'Feature Text', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-3',
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_text',
				[
					'label'       => esc_html__( 'Feature Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write text here', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_text_size',
				[
					'label'     => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
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
					'default'   => 'span',
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-9',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_button_section',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-5',
							'feature-box-style-8',
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_button_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Click here', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'Click here', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_feature_box_button_link',
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
				'crafto_feature_box_button_size',
				[
					'label'          => esc_html__( 'Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'md',
					'options'        => self::get_button_sizes(),
					'style_transfer' => true,
				]
			);

			$this->add_responsive_control(
				'crafto_feature_box_button_width',
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
						'crafto_feature_box_button_size' => 'custom',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_button_height',
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
						'crafto_feature_box_button_size' => 'custom',
					],
				]
			);

			$this->add_control(
				'crafto_feature_box_button_selected_icon',
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
			$this->add_responsive_control(
				'crafto_feature_box_button_icon_size',
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
						'crafto_feature_box_button_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_button_icon_align',
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
						'crafto_feature_box_button_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_button_icon_indent',
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
						'crafto_feature_box_button_selected_icon[value]!' => '',
						'crafto_feature_box_button_icon_align!'           => 'switch',
					],
				]
			);

			$this->add_control(
				'crafto_feature_box_button_css_id',
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
				'crafto_feature_box_button_hover_animation',
				[
					'label' => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_text_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'left'    => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'  => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-justify',
						],
					],
					'selectors_dictionary' => [
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .feature-box' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-1',
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-10',
						],
					],
				],
			);
			$this->add_responsive_control(
				'crafto_feature_box_align_position',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'start'  => [
							'title' => esc_html__( 'left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .feature-box:not(.feature-box-style-12), {{WRAPPER}} .feature-box.feature-box-style-4 .feature-box-wrap, {{WRAPPER}} .feature-box.feature-box-style-4 .content-slide, {{WRAPPER}} .feature-box.feature-box-style-5 .feature-box-wrap, {{WRAPPER}} .feature-box.feature-box-style-5 .feature-box-hover>div, {{WRAPPER}} .feature-box.feature-box-style-12 .feature-box-wrap, {{WRAPPER}} .feature-box.feature-box-style-12 .feature-box-hover-wrap' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-9',
							'feature-box-style-10',
						],
					],
				]
			);

			$this->start_controls_tabs(
				'crafto_feature_box_tabs',
			);
			$this->start_controls_tab(
				'crafto_feature_box_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-4',
							'feature-box-style-8',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_feature_box_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .feature-box, {{WRAPPER}} .trainer-feature-wrap, {{WRAPPER}} .feature-box-style-10, {{WRAPPER}} .trainer-feature-wrap',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_feature_box_shadow',
					'selector' => '{{WRAPPER}} .feature-box, {{WRAPPER}} .trainer-feature-wrap,{{WRAPPER}} .feature-box-style-10, {{WRAPPER}} .trainer-feature-wrap',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_box_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-4',
							'feature-box-style-8',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_feature_box_background_hover',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .feature-box:not(.feature-box-style-4):hover, {{WRAPPER}} .trainer-feature-wrap:hover, {{WRAPPER}} .feature-box-style-12.feature-box:hover .feature-box-hover-wrap, {{WRAPPER}} .feature-box-style-4.feature-box:hover .feature-box-overlay',
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-4',
							'feature-box-style-8',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_feature_hover_box_shadow',
					'selector' => '{{WRAPPER}} .feature-box:hover, {{WRAPPER}} .trainer-feature-wrap:hover, {{WRAPPER}} .feature-box-style-12.feature-box:hover .feature-box-hover-wrap',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_feature_box_general_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-4',
							'feature-box-style-8',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_general_width',
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
							'max' => 400,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 190,
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-style-1' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_feature_box_border',
					'selector' => '{{WRAPPER}} .feature-box:not(.feature-box-style-10), {{WRAPPER}} .feature-box.feature-box-style-10 .trainer-feature-wrap',
				]
			);
			$this->add_control(
				'crafto_feature_box_normal_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_trainer_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .trainer-feature-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-10',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_padding',
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
						'{{WRAPPER}} .feature-box:not(.feature-box-style-9, .feature-box-style-5, .feature-box-style-10), {{WRAPPER}} .trainer-feature-wrap .content-wrap, {{WRAPPER}} .feature-box-style-9 .feature-box-content-wrap, {{WRAPPER}} .feature-box.feature-box-style-5 .feature-box-wrap, {{WRAPPER}} .feature-box.feature-box-style-12 .feature-box-hover-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-4',
							'feature-box-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_margin',
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
						'{{WRAPPER}} .feature-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_heading',
				[
					'label'     => esc_html__( 'Hover Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-4',
							'feature-box-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_content_slide_padding',
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
						'{{WRAPPER}} .content-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-4',
							'feature-box-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_hover_heading',
				[
					'label'     => esc_html__( 'Hover Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_content_hover_padding',
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
						'{{WRAPPER}} .feature-box .feature-box-hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_bottom_button_heading',
				[
					'label'     => esc_html__( 'Feature Text Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-8',
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_feature_bottom_button_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .feature-bottom-buttom',
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_feature_box_content_border',
					'selector'  => '{{WRAPPER}} .content-wrap, {{WRAPPER}} .feature-box-style-9 .feature-bottom-text',
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-8',
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_content_box_padding',
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
						'{{WRAPPER}} figcaption, {{WRAPPER}} .feature-box-style-8 .content-wrap, {{WRAPPER}} .feature-box-style-9 .feature-bottom-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-8',
							'feature-box-style-9',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_label_style_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-7',
						],
						'crafto_feature_box_label!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_box_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .feature-box-label',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_label_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .feature-box-label',
				]
			);
			$this->add_control(
				'crafto_feature_box_label_number_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-wrap .feature-box-label' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_title_style_section',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
						],
						'crafto_feature_box_title!'  => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_box_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .feature-box .feature-box-title, {{WRAPPER}} .feature.box .feature-box-title a',
				]
			);
			$this->start_controls_tabs(
				'crafto_feature_box_title_style'
			);
			$this->start_controls_tab(
				'crafto_feature_box_title_normal_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box:not(.feature-box-style-12) .feature-box-title, {{WRAPPER}} .feature-box:not(.feature-box-style-12) .feature-box-title a:not(:hover), {{WRAPPER}} .feature-box.feature-box-style-12 .feature-box-wrap .feature-box-title, {{WRAPPER}} .feature-box.feature-box-style-12 .feature-box-wrap .feature-box-title a:not(:hover)' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_box_title_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box .title-link:hover, {{WRAPPER}} .feature-box-style-7 .title-link:hover .feature-box-title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-3',
							'feature-box-style-4',
							'feature-box-style-6',
							'feature-box-style-7',
							'feature-box-style-8',
							'feature-box-style-9',
							'feature-box-style-10',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_hover_title_color',
				[
					'label'     => esc_html__( 'Box Hover Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box:hover .feature-box-title, {{WRAPPER}} .feature-box:hover .feature-box-title a:not(:hover)' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-3',
							'feature-box-style-5',
							'feature-box-style-6',
							'feature-box-style-7',
							'feature-box-style-9',
							'feature-box-style-10',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_title_hover_transition',
				[
					'label'      => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'default'    => [
						'size' => 0.3,
						'unit' => 's',
					],
					'range'      => [
						's' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box .title-link' => 'transition-duration: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-2',
							'feature-box-style-3',
							'feature-box-style-4',
							'feature-box-style-6',
							'feature-box-style-7',
							'feature-box-style-9',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_feature_box_title_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_title_margin',
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
						'{{WRAPPER}} .feature-box .feature-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_separator_style',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_enable_separator_effect' => 'yes',
						'crafto_feature_box_styles'      => [
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_feature_box_separator_color',
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .feature-box-title .title-separator',
					'condition' => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_enable_separator_effect' => 'yes',
						'crafto_feature_box_styles'      => [
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_separator_thickness',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => '2',
					],
					'range'      => [
						'px' => [
							'min'  => 1,
							'max'  => 10,
							'step' => 1,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-title .title-separator' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_enable_separator_effect' => 'yes',
						'crafto_feature_box_styles'      => [
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_separator_opacity',
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
						'{{WRAPPER}} .feature-box-title .title-separator' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_enable_separator_effect' => 'yes',
						'crafto_feature_box_styles'      => [
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_separator_margin',
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
						'{{WRAPPER}} .feature-box-title .title-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_title_link[url]!' => '',
						'crafto_enable_separator_effect' => 'yes',
						'crafto_feature_box_styles'      => [
							'feature-box-style-11',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_number_style_section',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-2',
							'feature-box-style-4',
							'feature-box-style-5',
							'feature-box-style-6',
							'feature-box-style-7',
							'feature-box-style-9',
							'feature-box-style-10',
						],
						'crafto_feature_box_number!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_number_type',
				[
					'label'     => esc_html__( 'Number Type', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'normal' => [
							'title' => esc_html__( 'Normal', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter-bold',
						],
						'stroke' => [
							'title' => esc_html__( 'Stroke', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter',
						],
					],
					'default'   => 'normal',
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-3',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_number_color',
					'selector'       => '{{WRAPPER}} .feature-box-hover-wrap .number, {{WRAPPER}} .feature-box .number',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_feature_box_number_type' => 'stroke',
						'crafto_feature_box_styles!'     => [
							'feature-box-style-3',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .number',
				]
			);
			$this->add_control(
				'crafto_content_block_number_color',
				[
					'label'                      => esc_html__( 'Color', 'crafto-addons' ),
					'type'                       => Controls_Manager::COLOR,
					'default'                    => '',
					'selectors'                  => [
						'{{WRAPPER}} .feature-box-hover-wrap .number, {{WRAPPER}} .feature-box .number' => 'color: {{VALUE}};',
					],
					'crafto_feature_box_styles!' => [
						'feature-box-style-2',
						'feature-box-style-4',
						'feature-box-style-5',
						'feature-box-style-6',
						'feature-box-style-7',
						'feature-box-style-9',
						'feature-box-style-10',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_number_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .number' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-3',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_number_height',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .number' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_feature_box_number_border',
					'selector'  => '{{WRAPPER}} .number',
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_number_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_number_margin',
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
						'{{WRAPPER}} .number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-3',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_subtitle_style_section',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles'    => [
							'feature-box-style-5',
							'feature-box-style-10',
							'feature-box-style-12',
						],
						'crafto_feature_box_subtitle!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_subtitle_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .content-wrap .feature-box-subtitle, {{WRAPPER}} .feature-box-wrap .feature-box-subtitle',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_blocks_subtitle_style'
			);
			$this->start_controls_tab(
				'crafto_content_block_subtitle_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .content-wrap .feature-box-subtitle, {{WRAPPER}} .feature-box-wrap .feature-box-subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_blocks_subtitle_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_subtitle_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .content-wrap:hover .feature-box-subtitle, {{WRAPPER}} .feature-box-wrap:hover .feature-box-subtitle' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_content_subtitle_max_width',
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
							'max' => 600,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .content-wrap .feature-box-subtitle, {{WRAPPER}} .feature-box-wrap .feature-box-subtitle' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-10',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_content_style_section',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles!'  => [
							'feature-box-style-7',
							'feature-box-style-10',
							'feature-box-style-11',
						],
						'crafto_feature_box_content!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .feature-box-content, {{WRAPPER}} .feature-box-content-wrap',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_blocks_content_style'
			);
			$this->start_controls_tab(
				'crafto_content_block_number_content_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-8',
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-content,{{WRAPPER}} .feature-box-content-wrap' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_blocks_content_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-5',
							'feature-box-style-8',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_blocks_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-content:hover, {{WRAPPER}} .feature-box-style-2.feature-box:hover .feature-box-content, {{WRAPPER}} .feature-box-content-wrap:hover, {{WRAPPER}} .feature-box-style-9:hover .feature-box-content' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-5',
							'feature-box-style-8',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_content_icon_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_icon_max_width',
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
							'max' => 600,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-content' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_content_margin',
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
						'{{WRAPPER}} .feature-box-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-1',
							'feature-box-style-3',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_text_style_section',
				[
					'label'     => esc_html__( 'Feature Text', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-3',
							'feature-box-style-9',
						],
						'crafto_feature_box_text!'  => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_box_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .feature-text, {{WRAPPER}} .feature-bottom-text .feature-text',
				]
			);
			$this->start_controls_tabs(
				'crafto_feature_box_text_style'
			);
			$this->start_controls_tab(
				'crafto_feature_box_text_normal_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-text, {{WRAPPER}} .feature-bottom-text .feature-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_box_text_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_hover_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-text:hover, {{WRAPPER}} .feature-bottom-text .feature-text:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-9',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_feature_box_text_border',
					'selector'  => '{{WRAPPER}} .feature-box .feature-text',
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-9',
						],
					],
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_text_margin',
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
						'{{WRAPPER}} .feature-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_style_section',
				[
					'label'     => esc_html__( 'Bubble', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-bubble' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_separator_height',
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
							'max' => 400,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-bubble' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_separator_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 400,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-bubble' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_feature_box_margin',
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
						'{{WRAPPER}} .feature-box-bubble' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_icon_image_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-1',
							'feature-box-style-3',
							'feature-box-style-9',
							'feature-box-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_box_scale',
				[
					'label'        => esc_html__( 'Enable Icon Scaling', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_feature_box_styles' => [
							'feature-box-style-6',
						],
					],
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
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-icon img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_shape_size',
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
							'max' => 300,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-8',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_rotate',
				[
					'label'     => esc_html__( 'Rotate Shape', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 0,
						'unit' => 'deg',
					],
					'selectors' => [
						'{{WRAPPER}} .feature-box .elementor-icon:before' => 'transform: rotate({{SIZE}}{{UNIT}});',
					],
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-6',
						],
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
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-4',
							'feature-box-style-5',
							'feature-box-style-6',
							'feature-box-style-7',
							'feature-box-style-11',
							'feature-box-style-12',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}} .feature-box .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_icon_box_shadow',
					'selector'  => '{{WRAPPER}} .feature-box .elementor-icon',
					'condition' => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-8',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->start_controls_tabs( 'icon_bg_tabs' );
			$this->start_controls_tab(
				'crafto_icon_bg_color_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image'       => 'yes',
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_bg_normal_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image'       => 'yes',
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_bg_color_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image'       => 'yes',
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_bg_hover_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image'       => 'yes',
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
						],
					],
					'selectors' => [
						'{{WRAPPER}}:hover .elementor-icon'     => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->start_controls_tabs( 'icon_tabs' );
			$this->start_controls_tab(
				'crafto_icon_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'           => 'stacked',
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-11',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'     => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image'       => '',
						'crafto_feature_box_styles' => [
							'feature-box-style-6',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .feature-box-style-6 .elementor-icon:before'     => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_framed_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'           => 'framed',
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-11',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 5,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_icon_view'           => 'framed',
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'%',
						'px',
						'custom',
					],
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
						'crafto_icon_view!'          => 'default',
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_icons_opacitys',
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
						'{{WRAPPER}} .feature-box-style-6 .elementor-icon:before' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-6',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_colors_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_hover_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-12',
						],
					],
					'selectors' => [
						'{{WRAPPER}}:hover .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_hover_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'           => 'stacked',
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-11',
							'feature-box-style-12',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon'     => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'           => [
							'framed',
						],
						'crafto_custom_image'        => '',
						'crafto_feature_box_styles!' => [
							'feature-box-style-5',
							'feature-box-style-6',
							'feature-box-style-8',
							'feature-box-style-11',
							'feature-box-style-12',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_icon_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      =>
					[
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
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-4',
							'feature-box-style-5',
							'feature-box-style-6',
							'feature-box-style-7',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box:not(.feature-box-style-6):hover .elementor-icon, {{WRAPPER}} .feature-box-style-6:hover .elementor-icon:before' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_elementor_icon_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-9',
						],
						'crafto_icons[library]!'    => '',
					],
				]
			);
			$this->add_control(
				'crafto__icon_size',
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
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-icon img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_elementor_icon_size',
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
							'max' => 300,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-style-9 .elementor-icon::after' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto__icon_space',
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
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'(mobile){{WRAPPER}} .feature-box .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'icon_tab' );
			$this->start_controls_tab(
				'crafto_icon_color_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .feature-box-style-9 .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-style-9 .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_color_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image' => '',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_icon_hover_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .feature-box-style-9:hover .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-style-9:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_elementor_icon_box_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .feature-box-style-9 .elementor-icon::after',
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_elementor_icon_border',
					'selector'  => '{{WRAPPER}} .feature-box-style-9 .elementor-icon::after',
					'separator' => 'before',
					'condition' => [
						'crafto_icon_view' => 'framed',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_elementor_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-style-9 .elementor-icon::after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_icon_view' => 'framed',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_button_style_section',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_styles' => [
							'feature-box-style-2',
							'feature-box-style-5',
							'feature-box-style-8',
							'feature-box-style-9',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_box_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_feature_box_button_text_shadow',
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_feature_box_hover_color',
					'selector'       => '{{WRAPPER}} .feature-box-style-2.feature-box:hover a.elementor-button',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Box Hover Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-2',
							'feature-box-style-5',
							'feature-box-style-8',
							'feature-box-style-9',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_feature_box_tabs_button_style' );
			$this->start_controls_tab(
				'crafto_tab_feature_box_button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'     => 'crafto_feature_box_button_text_color',
					'selector' => '{{WRAPPER}} .elementor-button-content-wrapper',
				]
			);
			$this->add_control(
				'crafto_feature_button_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-button-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_button_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_feature_box_button_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_feature_box_button_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-button',

				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tab_feature_box_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'     => 'crafto_feature_box_text_hover_color',
					'selector' => '{{WRAPPER}} a.elementor-button:hover .elementor-button-content-wrapper, {{WRAPPER}} a.elementor-button:focus .elementor-button-content-wrapper, {{WRAPPER}}:hover .feature-box-style-2 a.elementor-button .elementor-button-content-wrapper, {{WRAPPER}}:focus .feature-box-style-2 a.elementor-button .elementor-button-content-wrapper',
				]
			);
			$this->add_control(
				'crafto_feature_box_button_hover_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}}:hover .feature-box:not(.feature-box-style-5) a.elementor-button i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-style-5 a.elementor-button:hover i, {{WRAPPER}} .feature-box-style-5 a.elementor-button:focus i' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:focus i' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_button_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_feature_box_button_background_hover_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} a.elementor-button .btn-hover-animation',
				],
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_feature_box_button_hover_box_shadow',
					'selector' => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus',
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_button_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:focus' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_feature_box_button_border',
					'selector'       => '{{WRAPPER}} .elementor-button',
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_button_text_padding',
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
						'{{WRAPPER}} a.elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_button_margin',
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
						'{{WRAPPER}} a.elementor-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_styles!' => [
							'feature-box-style-9',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_image_icon_width',
				[
					'label'      => esc_html__( 'Image', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_image_icon_size',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 20,
							'max' => 250,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-style-10 .feature-icon-wrap' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_icon_number_style',
				[
					'label'      => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_feature_box_styles' => [
							'feature-box-style-10',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .star-ratting-review, {{WRAPPER}} .feature-box-style-10 .star-ratting-review .elementor-icon',
				]
			);
			$this->add_control(
				'crafto_feature_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .star-ratting-review .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .star-ratting-review .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_feature_number_color',
				[
					'label'     => esc_html__( 'Number Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .star-ratting-review' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_feature_number_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .star-ratting-review' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_number_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .star-ratting-review' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_number_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .star-ratting-review' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_number_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .star-ratting-review' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render feature box widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings              = $this->get_settings_for_display();
			$feature_box_styles    = ( isset( $settings['crafto_feature_box_styles'] ) && $settings['crafto_feature_box_styles'] ) ? $settings['crafto_feature_box_styles'] : 'feature-box-style-1';
			$title                 = ( isset( $settings['crafto_feature_box_title'] ) && $settings['crafto_feature_box_title'] ) ? $settings['crafto_feature_box_title'] : '';
			$label                 = ( isset( $settings['crafto_feature_box_label'] ) && $settings['crafto_feature_box_label'] ) ? $settings['crafto_feature_box_label'] : '';
			$subtitle              = ( isset( $settings['crafto_feature_box_subtitle'] ) && $settings['crafto_feature_box_subtitle'] ) ? $settings['crafto_feature_box_subtitle'] : '';
			$feature_box_number    = ( isset( $settings['crafto_feature_box_number'] ) && $settings['crafto_feature_box_number'] ) ? $settings['crafto_feature_box_number'] : '';
			$feature_box_content   = ( isset( $settings['crafto_feature_box_content'] ) && $settings['crafto_feature_box_content'] ) ? $settings['crafto_feature_box_content'] : '';
			$feature_box_text      = ( isset( $settings['crafto_feature_box_text'] ) && $settings['crafto_feature_box_text'] ) ? $settings['crafto_feature_box_text'] : '';
			$crafto_icon_box_scale = '';
			$triner_background     = $this->get_background_image( 'crafto_trainer_image', 'crafto_trainer_image_thumbnail' );

			if ( 'yes' === $settings['crafto_icon_box_scale'] ) {
				$crafto_icon_box_scale = 'icon-scale-off';
			}

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'feature-box',
					$feature_box_styles,
					$crafto_icon_box_scale,
				]
			);
			$this->add_render_attribute(
				[
					'trainer_image' => [
						'class' => [
							'feature-icon-wrap',
						],
						'style' => $triner_background,
					],
				]
			);
			if ( ! empty( $settings['crafto_feature_box_button_link']['url'] ) ) {
				$this->add_link_attributes( '_buttonlink', $settings['crafto_feature_box_button_link'] );
				$this->add_render_attribute( '_buttonlink', 'class', 'btn-link' );
			}

			$this->add_render_attribute( 'feature_box_text', 'class', 'feature-box-text' );
			$this->add_render_attribute( 'feature_box_hover', 'class', 'feature-box-hover' );
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				switch ( $feature_box_styles ) {
					case 'feature-box-style-1':
						if ( ! empty( $feature_box_number ) || ! empty( $feature_box_content ) ) {
							$this->render_feature_box_number();
							$this->render_feature_box_content();
							echo '<div class="feature-box-bubble"></div>';
						}
						break;
					case 'feature-box-style-2':
						$this->feature_box_render_icon();
						$this->render_feature_box_title();
						$this->render_feature_box_content();
						$this->render_feature_box_button();
						break;
					case 'feature-box-style-3':
						$this->render_feature_box_number();
						$this->render_feature_box_title();
						$this->render_feature_box_content();

						if ( ! empty( $feature_box_text ) ) {
							?><<?php echo $this->get_settings( 'crafto_text_size' ); // phpcs:ignore ?> class="feature-text">
							<?php echo esc_html( $feature_box_text ); ?>
							</<?php echo $this->get_settings( 'crafto_text_size' ); // phpcs:ignore ?>>
							<?php
						}
						break;
					case 'feature-box-style-4':
						?>
						<div class="content-slide">
							<?php $this->feature_box_render_icon(); ?>
							<div class="feature-box-wrap">
								<?php
								$this->render_feature_box_title();
								$this->render_feature_box_content();
								?>
							</div>
							<div class="feature-box-overlay"></div>
						</div>
						<?php
						break;
					case 'feature-box-style-5':
						?>
						<div class="content-slide">
							<div class="feature-box-wrap">
								<?php $this->feature_box_render_icon(); ?>
								<?php
								$this->render_feature_box_title();
								if ( ! empty( $subtitle ) ) {
									?>
									<p class="feature-box-subtitle"><?php echo esc_html( $subtitle ); ?></p>
									<?php
								}
								?>
							</div>
							<div <?php $this->print_render_attribute_string( 'feature_box_hover' ); ?>>
								<div <?php $this->print_render_attribute_string( 'feature_box_content' ); ?>>
									<?php $this->render_feature_box_content(); ?>
									<?php $this->render_feature_box_button(); ?>
								</div>
							</div>
							<div class="feature-box-overlay"></div>
						</div>
						<?php
						break;
					case 'feature-box-style-6':
						?>
						<div class="content-slide">
							<?php $this->feature_box_render_icon(); ?>
							<div class="feature-box-wrap">
								<?php
								$this->render_feature_box_title();
								$this->render_feature_box_content();
								?>
							</div>
						</div>
						<?php
						break;
					case 'feature-box-style-7':
						$this->add_render_attribute( 'feature_box_title', 'class', 'feature-box-title' );
						if ( ! empty( $settings['crafto_feature_box_title_link']['url'] ) ) {
							$this->add_link_attributes( '_link', $settings['crafto_feature_box_title_link'] );
							$this->add_render_attribute( '_link', 'class', 'title-link' );
						}
						if ( ! empty( $settings['crafto_feature_box_title_link']['url'] ) ) {
							?>
							<a <?php $this->print_render_attribute_string( '_link' ); ?>>
							<?php
						}
						?>
						<div class="feature-box-wrap">
							<div class="feature-box-label">
								<?php echo esc_html( $label ); ?>
							</div>
							<?php $this->feature_box_render_icon(); ?>
						</div>
						<<?php echo $this->get_settings( 'crafto_header_title_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'feature_box_title' ); ?>>
							<?php echo esc_html( $title ); ?>
						</<?php echo $this->get_settings( 'crafto_header_title_size'); // phpcs:ignore ?>>
						<?php
						if ( ! empty( $settings['crafto_feature_box_title_link']['url'] ) ) {
							?>
							</a>
							<?php
						}
						break;
					case 'feature-box-style-8':
						if ( ! empty( $settings['crafto_icons']['value'] ) || ! empty( $settings['crafto_custom_image'] ) ) {
							?>
							<div class="feature-icon-wrap">
								<?php
								$this->feature_box_render_icon();
								?>
							</div>
							<?php
						}
						?>
						<div class="content-wrap">
							<?php
							$this->render_feature_box_title();
							$this->render_feature_box_content();
							?>
						</div>
						<?php
						$this->render_feature_box_number();
						$this->render_feature_box_button();
						break;
					case 'feature-box-style-9':
						?>
						<div class="feature-box-content-wrap">
							<?php
							$this->feature_box_render_icon();
							$this->render_feature_box_title();
							$this->render_feature_box_content();
							?>
						</div>
						<div class="feature-box-bottom-wrap">
							<div class="feature-bottom-text">
								<?php
								if ( ! empty( $feature_box_text ) ) {
									?><<?php echo $this->get_settings( 'crafto_text_size' ); // phpcs:ignore ?> class="feature-text">
									<?php echo esc_html( $feature_box_text ); ?>
									</<?php echo $this->get_settings( 'crafto_text_size' ); // phpcs:ignore ?>>
									<?php
								}
								?>
							</div>
							<div class="feature-bottom-buttom">
							<?php $this->render_feature_box_button(); ?>
							</div>
						</div>
						<?php
						break;
					case 'feature-box-style-10':
						$feature_box_number = ( isset( $settings['crafto_feature_icon_number'] ) && $settings['crafto_feature_icon_number'] ) ? $settings['crafto_feature_icon_number'] : '';
						$result             = ( $feature_box_number ) ? number_format_i18n( $feature_box_number, 1 ) : 0;
						if ( ! empty( $result ) ) {
							?>
							<div class="star-ratting-review">
							<?php $this->feature_box_render_icon(); ?>
								<?php echo esc_html( $result ); ?>
							</div>
							<?php
						}
						?>
						<div class="trainer-feature-wrap">
							<div <?php $this->print_render_attribute_string( 'trainer_image' ); ?>></div>
							<div class="content-wrap">
								<?php
								$this->render_feature_box_title();
								if ( ! empty( $subtitle ) ) {
									?>
									<p class="feature-box-subtitle"><?php echo esc_html( $subtitle ); ?></p>
									<?php
								}
								?>
							</div>
						</div>
						<?php
						break;
					case 'feature-box-style-11':
						?>
						<div class="feature-icon-wrap">
							<div class="image-number-wrap">
								<?php
								$this->feature_box_render_icon();
								$this->render_feature_box_number();
								?>
							</div>
							<?php
							$this->render_feature_box_title();
							?>
						</div>
						<?php
						break;
					case 'feature-box-style-12':
						?>
						<div class="feature-box-wrap">
							<?php
							$this->feature_box_render_icon();
							$this->render_feature_box_title();
							if ( ! empty( $subtitle ) ) {
								?>
								<p class="feature-box-subtitle"><?php echo esc_html( $subtitle ); ?></p>
								<?php
							}
							?>
						</div>
						<div class="feature-box-hover-wrap">
							<?php
							$this->render_feature_box_number();
							$this->render_feature_box_content();
							$this->render_feature_box_hover_title();
							?>
						</div>
						<?php
						break;
				}
				?>
			</div>
			<?php
		}

		/**
		 * Render Feature Box widget title.
		 *
		 * @access protected
		 */
		protected function render_feature_box_title() {
			$settings                       = $this->get_settings_for_display();
			$title                          = ( isset( $settings['crafto_feature_box_title'] ) && $settings['crafto_feature_box_title'] ) ? $settings['crafto_feature_box_title'] : '';
			$crafto_enable_separator_effect = $this->get_settings( 'crafto_enable_separator_effect' );

			$this->add_render_attribute( 'feature_box_title', 'class', 'feature-box-title' );
			if ( ! empty( $settings['crafto_feature_box_title_link']['url'] ) ) {
				$this->add_link_attributes( '_link', $settings['crafto_feature_box_title_link'] );
				$this->add_render_attribute( '_link', 'class', 'title-link' );
			}

			if ( ! empty( $title ) ) {
				?>
				<<?php echo $this->get_settings( 'crafto_header_title_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'feature_box_title' ); ?>>
				<?php
				if ( ! empty( $settings['crafto_feature_box_title_link']['url'] ) ) {
					?>
					<a <?php $this->print_render_attribute_string( '_link' ); ?>>
						<?php echo esc_html( $title );
						if ( 'yes' === $crafto_enable_separator_effect ) {
							?>
							<span class="title-separator"></span>
							<?php
						}
						?>
					</a>
					<?php
				} else {
					echo esc_html( $title );
					if ( 'yes' === $crafto_enable_separator_effect ) {
						?>
						<span class="title-separator"></span>
						<?php
					}
				}
				?>
				</<?php echo $this->get_settings( 'crafto_header_title_size'); // phpcs:ignore ?>>
				<?php
			}
		}

		/**
		 * Render Feature Box widget hover title.
		 *
		 * @access protected
		 */
		protected function render_feature_box_hover_title() {
			$settings = $this->get_settings_for_display();
			$title    = ( isset( $settings['crafto_feature_box_hover_title'] ) && $settings['crafto_feature_box_hover_title'] ) ? $settings['crafto_feature_box_hover_title'] : '';

			$this->add_render_attribute( 'feature_box_hover_title', 'class', 'feature-box-title' );
			if ( ! empty( $settings['crafto_feature_box_title_link']['url'] ) ) {
				$this->add_link_attributes( '_link', $settings['crafto_feature_box_title_link'] );
				$this->add_render_attribute( '_link', 'class', 'title-link' );
			}

			if ( ! empty( $title ) ) {
				?>
				<<?php echo $this->get_settings( 'crafto_header_title_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'feature_box_title' ); ?>>
					<?php echo esc_html( $title ); ?>
				</<?php echo $this->get_settings( 'crafto_header_title_size'); // phpcs:ignore ?>>
				<?php
			}
		}

		/**
		 *
		 * Render Feature Box widget content.
		 *
		 * @access protected
		 */
		protected function render_feature_box_content() {
			$settings            = $this->get_settings_for_display();
			$feature_box_content = ( isset( $settings['crafto_feature_box_content'] ) && $settings['crafto_feature_box_content'] ) ? $settings['crafto_feature_box_content'] : '';

			$this->add_render_attribute( 'feature_box_content', 'class', 'feature-box-content' );

			if ( ! empty( $feature_box_content ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'feature_box_content' ); ?>>
					<?php echo sprintf( '%s', wp_kses_post( $feature_box_content ) ); // phpcs:ignore ?>
				</div>
				<?php
			}
		}

		/**
		 * Render Feature Box widget number.
		 *
		 * @access protected
		 */
		protected function render_feature_box_number() {
			$settings                       = $this->get_settings_for_display();
			$feature_box_number             = ( isset( $settings['crafto_feature_box_number'] ) && $settings['crafto_feature_box_number'] ) ? $settings['crafto_feature_box_number'] : '';
			$crafto_feature_box_number_type = ( isset( $settings['crafto_feature_box_number_type'] ) && ! empty( $settings['crafto_feature_box_number_type'] ) ) ? $settings['crafto_feature_box_number_type'] : '';

			$this->add_render_attribute( 'feature_box_number', 'class', 'number' );
			if ( 'stroke' === $crafto_feature_box_number_type ) {
				$this->add_render_attribute( 'feature_box_number', 'class', 'text-stroke' );
			}

			if ( ! empty( $feature_box_number ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'feature_box_number' ); ?>>
					<?php echo esc_html( $feature_box_number ); ?>
				</div>
				<?php
			}
		}
		/**
		 * Render button widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render_feature_box_button() {
			$settings                      = $this->get_settings_for_display();
			$crafto_icon_align             = $this->get_settings( 'crafto_feature_box_button_icon_align' );
			$crafto_button_hover_animation = $this->get_settings( 'crafto_feature_box_button_hover_animation' );

			$this->add_render_attribute(
				[
					'button' => [
						'class' => [
							'elementor-button',
							'btn-icon-' . $crafto_icon_align,
						],
						'role'  => 'button',
					],
				],
			);

			if ( 'btn-reveal-icon' === $crafto_button_hover_animation && 'left' === $crafto_icon_align ) {
				$this->add_render_attribute(
					[
						'button' => [
							'class' => 'btn-reveal-icon-left',
						],
					],
				);
			}

			if ( ! empty( $settings['crafto_feature_box_button_link']['url'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-button-link' );
				$this->add_link_attributes( 'button', $settings['crafto_feature_box_button_link'] );
			} else {
				$this->add_render_attribute( 'button', 'href', '#' );
			}

			if ( ! empty( $settings['crafto_feature_box_button_css_id'] ) ) {
				$this->add_render_attribute( 'button', 'id', $settings['crafto_feature_box_button_css_id'] );
			}

			if ( ! empty( $settings['crafto_feature_box_button_size'] ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-size-' . $settings['crafto_feature_box_button_size'] );
			}

			/* Button hover animation */
			$custom_animation_class       = '';
			$custom_animation_div         = '';
			$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();

			if ( ! empty( $hover_animation_effect_array ) && ! empty( $crafto_button_hover_animation ) ) {
				$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . $crafto_button_hover_animation );
				if ( in_array( $crafto_button_hover_animation, $hover_animation_effect_array, true ) ) {
					$custom_animation_class = 'btn-custom-effect';

					if ( ! in_array( $crafto_button_hover_animation, array( 'btn-switch-icon', 'btn-switch-text' ), true ) ) {
						$custom_animation_div = '<span class="btn-hover-animation"></span>';
					}
				}
			}
			$this->add_render_attribute( 'button', 'class', $custom_animation_class );
			if ( ! empty( $settings['crafto_feature_box_button_text'] ) || ! empty( $settings['crafto_feature_box_button_selected_icon']['value'] ) ) {
				?>
				<a <?php $this->print_render_attribute_string( 'button' ); ?>>
					<?php
					$this->feature_box_button_text();
					echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
					?>
				</a>
				<?php
			}
		}

		/**
		 *
		 * Render button widget text.
		 *
		 * @access protected
		 */
		protected function feature_box_button_text() {
			$settings                      = $this->get_settings_for_display();
			$crafto_button_hover_animation = $settings['crafto_feature_box_button_hover_animation'];
			$migrated                      = isset( $settings['__fa4_migrated']['crafto_feature_box_button_selected_icon'] );
			$is_new                        = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! $is_new && empty( $settings['crafto_feature_box_button_icon_align'] ) ) {
				// @todo: remove when deprecated
				// added as bc in 2.6
				// old default
				$settings['crafto_feature_box_button_icon_align'] = $this->get_settings( 'crafto_feature_box_button_icon_align' );
			}

			$this->add_render_attribute(
				[
					'content-wrapper'                => [
						'class' => 'elementor-button-content-wrapper',
					],
					'icon-align'                     => [
						'class' => [
							'elementor-button-icon',
						],
					],
					'crafto_feature_box_button_text' => [
						'class' => 'elementor-button-text',
					],
				],
			);

			if ( 'btn-switch-icon' !== $crafto_button_hover_animation && $settings['crafto_feature_box_button_icon_align'] ) {
				$this->add_render_attribute(
					[
						'icon-align' => [
							'class' => [
								'elementor-align-icon-' . $settings['crafto_feature_box_button_icon_align'],
							],
						],
					],
				);
			}

			if ( 'btn-switch-text' === $crafto_button_hover_animation && $settings['crafto_feature_box_button_text'] ) {
				$this->add_render_attribute(
					[
						'crafto_feature_box_button_text' => [
							'data-btn-text' => wp_strip_all_tags( $settings['crafto_feature_box_button_text'] ),
						],
					],
				);
			}

			$this->add_inline_editing_attributes( 'crafto_feature_box_button_text', 'none' );
			?>
			<div <?php $this->print_render_attribute_string( 'content-wrapper' ); ?>>
				<?php
				if ( ! empty( $settings['crafto_feature_box_button_text'] ) ) {
					?>
					<span <?php $this->print_render_attribute_string( 'crafto_feature_box_button_text' ); ?>><?php echo esc_html( $settings['crafto_feature_box_button_text'] ); ?></span>
					<?php
				}

				if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_feature_box_button_selected_icon']['value'] ) ) {
					?>
					<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings['crafto_feature_box_button_selected_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['crafto_feature_box_button_selected_icon']['value'] ) && ! empty( $settings['crafto_feature_box_button_selected_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings['crafto_feature_box_button_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
						?>
					</span>
					<?php
				}
				if ( 'btn-switch-icon' === $crafto_button_hover_animation ) {
					if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_feature_box_button_selected_icon']['value'] ) ) {
						?>
						<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings['crafto_feature_box_button_selected_icon'], [ 'aria-hidden' => 'true' ] );
							} elseif ( isset( $settings['crafto_feature_box_button_selected_icon']['value'] ) && ! empty( $settings['crafto_feature_box_button_selected_icon']['value'] ) ) {
								?>
								<i class="<?php echo esc_attr( $settings['crafto_feature_box_button_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
								<?php
							}
							?>
						</span>
						<?php
					}
				}
				?>
			</div>
			<span class="screen-reader-text"><?php echo esc_html__( 'Read More', 'crafto-addons' ); ?></span>
			<?php
		}

		/**
		 *
		 * Render icon widget text.
		 *
		 * @access protected
		 */
		protected function feature_box_render_icon() {
			$settings = $this->get_settings_for_display();
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );

			$migrated = isset( $settings['__fa4_migrated']['crafto_icons'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! empty( $settings['crafto_icons']['value'] ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'icon-wrapper' ); // phpcs:ignore ?>>
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $settings['crafto_icons'], [ 'aria-hidden' => 'true' ] );
					} elseif ( isset( $settings['crafto_icons']['value'] ) && ! empty( $settings['crafto_icons']['value'] ) ) {
						$this->add_render_attribute( 'icon', 'class', $settings['icon']['value'] );
						$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
						?>
						<i <?php $this->print_render_attribute_string( 'icon' ); // phpcs:ignore ?>></i>
						<?php
					}
					?>
				</div>
				<?php
			} elseif ( ! empty( $settings['crafto_custom_image'] ) ) {
				?>
				<div class="elementor-icon">
					<?php
					if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
						$settings['crafto_image']['id'] = '';
					}
					if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					}
					?>
				</div>
				<?php
			}
		}
		/**
		 * @param string $image_type to get image type.
		 * @param string $thumbnail to get thumbnail type.
		 * @access public
		 */
		public function get_background_image( $image_type, $thumbnail ) {
			$settings = $this->get_settings_for_display();
			if ( ! empty( $settings[ $image_type ]['id'] ) ) {
				$crafto_feature_box_image_url = Group_Control_Image_Size::get_attachment_image_src( $settings[ $image_type ]['id'], $thumbnail, $settings );
			} elseif ( ! empty( $settings[ $image_type ]['url'] ) ) {
				$crafto_feature_box_image_url = $settings[ $image_type ]['url'];
			}
			$background = ( ! empty( $crafto_feature_box_image_url ) ) ? 'background-image:url(' . esc_url( $crafto_feature_box_image_url ) . ');' : '';
			return $background;
		}
	}
}
