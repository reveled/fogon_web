<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Button_Group_Control;

/**
 * Crafto widget for feature box carousel.
 *
 * @package Crafto
 */

// If class `Feature_Box_Carousel` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Feature_Box_Carousel' ) ) {
	/**
	 * Define `Feature_Box_Carousel` class.
	 */
	class Feature_Box_Carousel extends Widget_Base {
		/**
		 * Retrieve the list of scripts the feature box carousel widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$feature_box_carousel_scripts = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$feature_box_carousel_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$feature_box_carousel_scripts[] = 'swiper';

					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$feature_box_carousel_scripts[] = 'crafto-magic-cursor';
					}
				}
				$feature_box_carousel_scripts[] = 'crafto-default-carousel';
			}
			return $feature_box_carousel_scripts;
		}
		/**
		 * Retrieve the list of styles the feature box carousel widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$feature_box_carousel_styles  = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$feature_box_carousel_styles[] = 'crafto-widgets-rtl';
				} else {
					$feature_box_carousel_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$feature_box_carousel_styles = [
						'swiper',
						'nav-pagination',
					];

					if ( is_rtl() ) {
						$feature_box_carousel_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$feature_box_carousel_styles[] = 'crafto-magic-cursor';
					}
				}

				if ( is_rtl() ) {
					$feature_box_carousel_styles[] = 'crafto-feature-box-carousel-rtl';
				}
				$feature_box_carousel_styles[] = 'crafto-heading-widget';
				$feature_box_carousel_styles[] = 'crafto-feature-box-carousel';
			}
			return $feature_box_carousel_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-feature-box-carousel';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Feature Box Carousel', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-slider-album crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/feature-box-carousel/';
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
				'image',
				'photo',
				'visual',
				'slide',
				'carousel',
				'slider',
				'content',
				'box slider',
			];
		}

		/**
		 * Register feature box carousel widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_feature_box_carousel_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_layout_type',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'feature-box-carousel-style-1',
					'options' => [
						'feature-box-carousel-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'feature-box-carousel-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'feature-box-carousel-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'feature-box-carousel-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'feature-box-carousel-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
						'feature-box-carousel-style-6' => esc_html__( 'Style 6', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_heading',
				[
					'label'       => esc_html__( 'Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write heading', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'feature_box_carousel_heading_description',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<div style ="font-style:normal">To add the highlighted text use shortcode like:<br/><br/> <span style="font-weight:bold">[crafto_highlight]</span> Your Text <span style="font-weight:bold">[/crafto_highlight]</span></div>', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition'       => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_header_size',
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
					'default'   => 'h3',
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_subheading',
				[
					'label'       => esc_html__( 'Subheading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write subheading here', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_description',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Enter your description', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Enter your description', 'crafto-addons' ),
					'rows'        => 10,
					'condition'   => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_enable_separator_effect',
				[
					'label'        => esc_html__( 'Enable Grow Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_carousel_content_section',
				[
					'label' => esc_html__( 'Slides', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs( 'crafto_feature_box_carousel_tabs' );
			$repeater->start_controls_tab(
				'crafto_feature_box_carousel_background_tab',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_slide_background',
				[
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
				'crafto_image_link',
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
					'description' => esc_html__( 'Applicable in style 6 only.', 'crafto-addons' ),
					'condition'   => [
						'crafto_feature_box_carousel_slide_background[url]!' => '',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_feature_box_carousel_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_use_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fa-solid fa-star',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_feature_box_carousel_use_image' => '',
					],
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_image',
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
						'crafto_feature_box_carousel_use_image' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_title_link',
				[
					'label'       => esc_html__( 'Title Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_subtitle',
				[
					'label'       => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Write subtitle here', 'crafto-addons' ),
					'description' => esc_html__( 'Applicable in style 3 and style 5 only.', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_content',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'crafto-addons' ),
					'description' => esc_html__( 'Applicable in style 4 and style 6 only.', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_enable_label',
				[
					'label'        => esc_html__( 'Add Label?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'description'  => esc_html__( 'Applicable in style 3, style 5 and style 6 only.', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_label_selected_icon',
				[
					'label'            => esc_html__( 'Label Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_enable_label' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_label_title',
				[
					'label'       => esc_html__( 'Label Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_enable_label' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_label_link',
				[
					'label'       => esc_html__( 'Label Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
					'condition'   => [
						'crafto_enable_label' => 'yes',
					],
				]
			);
			Button_Group_Control::repeater_button_content_fields(
				$repeater,
				[
					'id'          => 'primary',
					'default'     => esc_html__( 'Click here', 'crafto-addons' ),
					'description' => esc_html__( 'Applicable in style 3, style 5 and style 6 only.', 'crafto-addons' ),
				],
			);

			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_feature_box_carousel_link_tab',
				[
					'label' => esc_html__( 'Iconbox', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_link_enable',
				[
					'label'        => esc_html__( 'Enable Link', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'description'  => esc_html__( 'Applicable in style 1, style 2 and style 5 only.', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
					'condition'   => [
						'crafto_feature_box_carousel_link_enable!' => '',
					],

				]
			);
			$repeater->add_control(
				'crafto_feature_box_carousel_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_feature_box_carousel_link_enable!' => '',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'crafto_feature_box_carousel',
				[
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => [
						[
							'crafto_feature_box_carousel_item_image' => Utils::get_placeholder_image_src(),
							'crafto_feature_box_carousel_title'      => esc_html__( 'Write title here', 'crafto-addons' ),
						],
						[
							'crafto_feature_box_carousel_item_image' => Utils::get_placeholder_image_src(),
							'crafto_feature_box_carousel_title'      => esc_html__( 'Write title here', 'crafto-addons' ),
						],
						[
							'crafto_feature_box_carousel_item_image' => Utils::get_placeholder_image_src(),
							'crafto_feature_box_carousel_title'      => esc_html__( 'Write title here', 'crafto-addons' ),
						],
						[
							'crafto_feature_box_carousel_item_image' => Utils::get_placeholder_image_src(),
							'crafto_feature_box_carousel_title'      => esc_html__( 'Write title here', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();
			Button_Group_Control::repeater_button_setting_fields(
				$this,
				[
					'id'    => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->start_controls_section(
				'crafto_feature_box_carousel_content_settings',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_title_size',
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
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'crafto_thumbnail',
					'default' => 'full',
					'exclude' => [
						'custom',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_carousel_settings_section',
				[
					'label' => esc_html__( 'Carousel Settings', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_slides_to_show',
				[
					'label'   => esc_html__( 'Slides Per View', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 3,
					],
					'range'   => [
						'px' => [
							'min'  => 1,
							'max'  => 10,
							'step' => 1,
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_items_spacing',
				[
					'label'      => esc_html__( 'Items Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 30,
					],
					'condition'  => [
						'crafto_slides_to_show[size]!' => '1',
					],
				]
			);
			$this->add_control(
				'crafto_autoplay',
				[
					'label'        => esc_html__( 'Enable Autoplay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_autoplay_speed',
				[
					'label'     => esc_html__( 'Autoplay Delay', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 3000,
					'condition' => [
						'crafto_autoplay' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_pause_on_hover',
				[
					'label'        => esc_html__( 'Enable Pause on Hover', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_autoplay' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_infinite',
				[
					'label'        => esc_html__( 'Enable Infinite Loop', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_speed',
				[
					'label'   => esc_html__( 'Effect Speed', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 500,
				]
			);
			$this->add_control(
				'crafto_rtl',
				[
					'label'   => esc_html__( 'RTL', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'ltr',
					'options' => [
						''    => esc_html__( 'Default', 'crafto-addons' ),
						'ltr' => esc_html__( 'Left', 'crafto-addons' ),
						'rtl' => esc_html__( 'Right', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_allowtouchmove',
				[
					'label'        => esc_html__( 'Enable Allow Touch Move', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_slider_cursor',
				[
					'label'        => esc_html__( 'Enable Magic Cursor', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
					'description'  => esc_html__( 'You can configure magic cursor from Appearance > Customize > Advanced Theme Options > Magic Cursor Settings.', 'crafto-addons' ),
					'condition'    => [
						'crafto_allowtouchmove' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_slider_navigation',
				[
					'label' => esc_html__( 'Navigation', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_navigation',
				[
					'label'              => esc_html__( 'Enable Navigation', 'crafto-addons' ),
					'type'               => Controls_Manager::SWITCHER,
					'default'            => '',
					'return_value'       => 'yes',
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_previous_arrow_icon',
				[
					'label'            => esc_html__( 'Previous Arrow', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-angle-left',
						'library' => 'fa-solid',
					],
					'condition'        => [
						'crafto_navigation' => 'yes',
					],
					'skin'             => 'inline',
				]
			);
			$this->add_control(
				'crafto_next_arrow_icon',
				[
					'label'            => esc_html__( 'Next Arrow', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-angle-right',
						'library' => 'fa-solid',
					],
					'condition'        => [
						'crafto_navigation' => 'yes',
					],
					'skin'             => 'inline',
				]
			);
			$this->add_control(
				'crafto_navigation_v_alignment',
				[
					'label'     => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'middle',
					'options'   => [
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
					'condition' => [
						'crafto_navigation' => 'yes',
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_arrows_icon_shape_style',
				[
					'label'     => esc_html__( 'Shape Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'nav-icon-circle',
					'options'   => [
						''                => esc_html__( 'None', 'crafto-addons' ),
						'nav-icon-square' => esc_html__( 'Square', 'crafto-addons' ),
						'nav-icon-circle' => esc_html__( 'Round', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_navigation' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_pagination_options',
				[
					'label' => esc_html__( 'Pagination', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_pagination',
				[
					'label'              => esc_html__( 'Enable Pagination', 'crafto-addons' ),
					'type'               => Controls_Manager::SWITCHER,
					'default'            => '',
					'return_value'       => 'yes',
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_pagination_style',
				[
					'label'     => esc_html__( 'Pagination Type', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'dots',
					'options'   => [
						'dots'   => esc_html__( 'Dots', 'crafto-addons' ),
						'number' => esc_html__( 'Numbers', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_pagination' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_pagination_dots_style',
				[
					'label'     => esc_html__( 'Dots Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'dots-style-1',
					'options'   => [
						'dots-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'dots-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'dots-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'dots',
					],
				]
			);
			$this->add_control(
				'crafto_pagination_number_style',
				[
					'label'     => esc_html__( 'Number Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'number-style-1',
					'options'   => [
						'number-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'number-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'number-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'number',
					],
				]
			);
			$this->add_control(
				'crafto_pagination_direction',
				[
					'label'        => esc_html__( 'Orientation', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'horizontal',
					'options'      => [
						'horizontal' => [
							'title' => esc_html__( 'Horizontal', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-h',
						],
						'vertical'   => [
							'title' => esc_html__( 'Vertical', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-v',
						],
					],
					'prefix_class' => 'pagination-direction-',
					'condition'    => [
						'crafto_pagination' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pagination_h_align',
				[
					'label'     => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
						'left'   => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'condition' => [
						'crafto_pagination'           => 'yes',
						'crafto_pagination_direction' => 'horizontal',
					],
				]
			);
			$this->add_control(
				'crafto_vertical_position',
				[
					'label'        => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'right',
					'options'      => [
						'left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'toggle'       => true,
					'prefix_class' => 'pagination-vertical-',
					'condition'    => [
						'crafto_pagination'           => 'yes',
						'crafto_pagination_direction' => 'vertical',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_carousel_genaral_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_genaral_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_box_shadow',
					'selector' => '{{WRAPPER}} .feature-box-carousel-wrap',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_border',
					'selector' => '{{WRAPPER}} .feature-box-carousel-wrap',
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_padding',
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
						'{{WRAPPER}} .feature-box-carousel-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_content_carousel_padding',
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
						'{{WRAPPER}} .feature-box-carousel-style-6 .feature-box-carousel-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_content_carousel_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-style-5.swiper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_title_box_heading',
				[
					'label'     => esc_html__( 'Title Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_title_box_width',
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
						'{{WRAPPER}} .feature-carousel-title-box' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_slider_box_min_width',
				[
					'label'      => esc_html__( 'Min Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'default'    => [
						'unit' => '%',
						'size' => 100,
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
						'{{WRAPPER}} .feature-carousel-swiper-box' => 'min-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_title_padding',
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
						'{{WRAPPER}} .feature-carousel-title-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_title_box_margin',
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
						'{{WRAPPER}} .feature-carousel-title-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_bottom_border_heading',
				[
					'label'     => esc_html__( 'Bottom Border', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_feature_box_carousel_bottom_border',
					'selector'  => '{{WRAPPER}} .crafto-button-wrapper',
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_bottom_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-button-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_carousel_heading_style_section',
				[
					'label'     => esc_html__( 'Heading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_heading_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .heading',
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_heading_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .heading' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_heading_width',
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
							'max' => 250,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .heading' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_heading_margin',
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
						'{{WRAPPER}} .heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_separator_style',
				[
					'label'     => esc_html__( 'Highlight', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_feature_heading_separator_typography',
					'selector'  => '{{WRAPPER}} .heading .separator',
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_heading_highlight_title_color',
					'selector'       => '{{WRAPPER}} .feature-carousel-title-box .heading .separator',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_heading_title_separator_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .heading .no-shadow-animation .separator, {{WRAPPER}} .heading .horizontal-separator',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Highlight  Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_heading_title_separator_thickness',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => '1',
					],
					'range'      => [
						'px' => [
							'min'  => 1,
							'max'  => 50,
							'step' => 1,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .heading.no-shadow-animation .separator, {{WRAPPER}} .heading .horizontal-separator' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .no-shadow-animation .separator' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_heading_title_separator_margin',
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
						'{{WRAPPER}} .heading.no-shadow-animation .separator, {{WRAPPER}} .heading .horizontal-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_carousel_subheading_style_section',
				[
					'label'     => esc_html__( 'Subheading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_subheading_typography',
					'selector' => '{{WRAPPER}} .subheading',
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_subheading_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .subheading' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_subheading_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .subheading',
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_subheading_width',
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
							'max' => 250,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .subheading' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_subheading_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .subheading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_subheading_padding',
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
						'{{WRAPPER}} .subheading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_subheading_margin',
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
						'{{WRAPPER}} .subheading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_feature_box_carousel_subheading_display_settings',
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
						'{{WRAPPER}} .subheading' => 'display: {{VALUE}}',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_carousel_description_style_section',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_description_typography',
					'selector' => '{{WRAPPER}} .feature-carousel-title-box p',
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-carousel-title-box p' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_description_width',
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
							'max' => 250,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-carousel-title-box p' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_feature_box_carousel_description_padding',
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
						'{{WRAPPER}} .feature-carousel-title-box p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_description_margin',
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
						'{{WRAPPER}} .feature-carousel-title-box p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_carousel_icon_style',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .elementor-icon, {{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_icon_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-wrap .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_feature_carousel_icon_style'
			);
			$this->start_controls_tab(
				'crafto_feature_carousel_icon_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .elementor-icon'     => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-carousel-wrap .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_carousel_icon_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_icon_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-style-4 .feature-box-carousel-wrap:hover .elementor-icon'     => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-carousel-style-4 .feature-box-carousel-wrap:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_feature_box_carousel_icon_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_icon_margin',
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
						'{{WRAPPER}} .elementor-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_icon_style_image',
				[
					'label'     => esc_html__( 'Image Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_feature_icon_image_size',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
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
						'{{WRAPPER}} .feature-box-carousel-inner img, {{WRAPPER}} .feature-box-carousel-style-4 .icon-image img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_image_w_h_size',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
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
						'{{WRAPPER}} .feature-box-carousel-inner img, {{WRAPPER}} .feature-box-carousel-style-4 .icon-image img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_icon_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-inner img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_icon_padding',
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
						'{{WRAPPER}} .feature-box-carousel-inner img, {{WRAPPER}} .feature-box-carousel-style-4 .icon-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_icon_margin',
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
						'{{WRAPPER}} .feature-box-carousel-inner img, {{WRAPPER}} .feature-box-carousel-style-4 .icon-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-3',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_carousel_subtitle_style_section',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_carousel_subtitle_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-subtitle',
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_subtitle_width',
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
							'min' => 100,
							'max' => 500,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-subtitle' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_subtitle_margin',
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
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_carousel_title_style_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_carousel_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .feature-box-carousel-title, {{WRAPPER}} .feature-box-carousel-content .feature-box-carousel-title, {{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-title a',
				]
			);
			$this->start_controls_tabs(
				'crafto_feature_box_carousel_title_tabs'
			);
			$this->start_controls_tab(
				'crafto_feature_box_carousel_title_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-title, {{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-title a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_box_carousel_title_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-title a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_feature_box_carousel_title_separator',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_title_width',
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
							'min' => 100,
							'max' => 500,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-title, {{WRAPPER}} .feature-box-carousel-content .feature-box-carousel-title, {{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-title a' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_title_margin',
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
						'{{WRAPPER}} .feature-box-carousel-title, {{WRAPPER}} .feature-box-carousel-content .feature-box-carousel-title, {{WRAPPER}} .feature-box-carousel-wrap .feature-box-carousel-title a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_content_style_section',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-4',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .feature-box-carousel-wrap .feature-box-content',
				]
			);
			$this->add_control(
				'crafto_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_width',
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
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_content_margin',
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
						'{{WRAPPER}} .feature-box-carousel-wrap .feature-box-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type' =>
						[
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->end_controls_section();

			Button_Group_Control::button_style_fields(
				$this,
				[
					'id'      => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => esc_html__( 'Click here', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-4',
						],
					],
				]
			);
			$this->start_controls_section(
				'crafto_feature_box_carousel_label_style_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_feature_carousel_label_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .feature-box-carousel-wrap .label-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_feature_carousel_label_text_tab'
			);
			$this->start_controls_tab(
				'crafto_feature_carousel_label_text_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_carousel_label_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .label-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_feature_box_carousel_style_label_box_bgcolor',
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
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .feature-box-carousel-style-3 .feature-box-carousel-wrap .label-box, {{WRAPPER}} .feature-box-carousel-style-5 .feature-box-carousel-label .label-title, {{WRAPPER}} .feature-box-carousel-style-6 .feature-box-carousel-label',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_carousel_label_text_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_carousel_label_text_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap a:hover .label-title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_feature_carousel_style_label_hover_background',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
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
					'selector'       => '{{WRAPPER}} .feature-box-carousel-wrap a:hover .feature-box-carousel-label',
					'condition'      => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_feature_carousel_label_box_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-3',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_feature_box_carousel_label_box_shadow',
					'selector'  => '{{WRAPPER}} .feature-box-carousel-wrap .label-box',
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
							'feature-box-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_label_box_border',
					'selector' => '{{WRAPPER}} .feature-box-carousel-wrap .label-box, {{WRAPPER}} .feature-box-carousel-style-5 .feature-box-carousel-label .label-title, {{WRAPPER}} .feature-box-carousel-style-6 .feature-box-carousel-label',
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_label_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-wrap .label-box, {{WRAPPER}} .feature-box-carousel-style-5 .feature-box-carousel-label .label-title, {{WRAPPER}} .feature-box-carousel-style-6 .feature-box-carousel-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_box_carousel_label_box_padding',
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
						'{{WRAPPER}} .feature-box-carousel-wrap .label-box, {{WRAPPER}} .feature-box-carousel-style-6 .feature-box-carousel-wrap .label-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_carousel_label_icon_box',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs(
				'crafto_feature_carousel_label_icon_style'
			);
			$this->start_controls_tab(
				'crafto_feature_carousel_label_icon_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => 'feature-box-carousel-style-6',
					],
				]
			);
			$this->add_control(
				'crafto_feature_carousel_style_label_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .label-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-carousel-wrap .label-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_feature_carousel_style_label_icon_background',
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
					'selector'  => '{{WRAPPER}} .feature-box-carousel-wrap .label-icon',
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_carousel_label_icon_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => 'feature-box-carousel-style-6',
					],
				]
			);
			$this->add_control(
				'crafto_feature_carousel_label_hover_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap a:hover .label-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-carousel-wrap a:hover .label-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => 'feature-box-carousel-style-6',
					],
				],
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_feature_carousel_label_icon_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => 'feature-box-carousel-style-6',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_carousel_label_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-wrap .label-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .feature-box-carousel-wrap .label-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_carousel_label_shape_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-wrap .label-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_label_border',
					'selector' => '{{WRAPPER}} .feature-box-carousel-wrap .label-icon',
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_label_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-wrap .label-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_feature_box_carousel_link',
				[
					'label'     => esc_html__( 'Iconbox', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-1',
							'feature-box-carousel-style-2',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_carousel_content_icon_size',
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
						'{{WRAPPER}} .feature-box-carousel-inner .read-more-icon i, {{WRAPPER}} .feature-box-carousel-inner .read-more-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_carousel_content_icon_w_h_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .feature-box-carousel-inner .read-more-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_feature_box_carousel_button_style' );
			$this->start_controls_tab(
				'crafto_feature_box_carousel_link_normal_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_icon_color_normal',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap .read-more-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-carousel-wrap .read-more-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_feature_carousel_link_background',
					'types'    => [
						'classic',
						'gradient',
					],
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a .read-more-icon, {{WRAPPER}} .read-more-icon',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_feature_box_carousel_link_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_box_carousel_icon_color_hover',
				[
					'label'     => esc_html__( 'Hover Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap:hover .read-more-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .feature-box-carousel-wrap:hover .read-more-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_feature_carousel_link_hover',
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
					'selector'  => '{{WRAPPER}} .feature-box-carousel-wrap:hover a .read-more-icon, {{WRAPPER}} .feature-box-carousel-wrap:hover .read-more-icon',
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_feature_carousel_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .feature-box-carousel-wrap:hover a .read-more-icon' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => [
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_feature_box_carousel_link_border',
					'selector'  => '{{WRAPPER}} .read-more-icon',
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_link_box_shadow',
					'selector' => '{{WRAPPER}} .read-more-icon',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_feature_box_carousel_overlay',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type!' => 'feature-box-carousel-style-6',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_feature_box_carousel_overlay_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .bg-overlay',
				]
			);
			$this->add_responsive_control(
				'crafto_overlay_bg_opacity',
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
					'selectors'  => [
						'{{WRAPPER}} .bg-overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_image_overlay',
				[
					'label'     => esc_html__( 'Image Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_feature_box_carousel_layout_type' => [
							'feature-box-carousel-style-4',
							'feature-box-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_image_overlay_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .image-overlay',
				]
			);
			$this->add_responsive_control(
				'crafto_overlay_opacity',
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
					'selectors'  => [
						'{{WRAPPER}} .image-overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_navigation',
				[
					'label'     => esc_html__( 'Navigation', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_navigation' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_arrows_position',
				[
					'label'        => esc_html__( 'Position', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'inside',
					'options'      => [
						'inside'  => esc_html__( 'Inside', 'crafto-addons' ),
						'outside' => esc_html__( 'Outside', 'crafto-addons' ),
					],
					'prefix_class' => 'elementor-arrows-position-',
					'condition'    => [
						'crafto_navigation' => 'yes',
						'crafto_feature_box_carousel_layout_type' => 'feature-box-carousel-style-4',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_arrows_nav_position',
				[
					'label'      => esc_html__( 'Navigation Icon Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-element .feature-box-carousel-style-1 .swiper, {{WRAPPER}}.elementor-element .feature-box-carousel-style-5 .swiper, {{WRAPPER}}.elementor-element .feature-box-carousel-style-6 .swiper' => 'padding-top: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.elementor-element .feature-box-carousel-style-2 .elementor-swiper-button, {{WRAPPER}}.elementor-element .feature-box-carousel-style-3 .elementor-swiper-button' => 'top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation' => 'yes',
						'crafto_feature_box_carousel_layout_type!' => 'feature-box-carousel-style-4',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_arrows_custom_position',
				[
					'label'      => esc_html__( 'Navigation Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => -550,
							'max' => 550,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper.elementor-arrows-position-custom .elementor-swiper-button.elementor-swiper-button-prev' => 'left: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .swiper.elementor-arrows-position-custom .elementor-swiper-button.elementor-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation' => 'yes',
						'crafto_feature_box_carousel_layout_type' => 'feature-box-carousel-style-4',
					],
				]
			);
			$this->add_control(
				'crafto_arrows_right',
				[
					'label'      => esc_html__( 'Space Between Navigations', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .feature-box-carousel-style-1 .elementor-swiper-button.elementor-swiper-button-prev, 
						{{WRAPPER}} .feature-box-carousel-style-5 .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .feature-box-carousel-style-6 .elementor-swiper-button.elementor-swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .feature-box-carousel-style-2 .elementor-swiper-button.elementor-swiper-button-next,
						{{WRAPPER}} .feature-box-carousel-style-3 .elementor-swiper-button.elementor-swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .feature-box-carousel-style-2 .elementor-swiper-button.elementor-swiper-button-prev, .rtl {{WRAPPER}} .feature-box-carousel-style-3 .elementor-swiper-button.elementor-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .feature-box-carousel-style-5 .elementor-swiper-button-next, .rtl {{WRAPPER}} .feature-box-carousel-style-6 .elementor-swiper-button.elementor-swiper-button-next, .rtl {{WRAPPER}} .feature-box-carousel-style-1 .elementor-swiper-button.elementor-swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation' => 'yes',
						'crafto_feature_box_carousel_layout_type!' => 'feature-box-carousel-style-4',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_arrows_box_size',
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
						'{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_navigation' => 'yes',
					],
					'default'   => [
						'unit' => 'px',
						'size' => 45,
					],
				]
			);
			$this->add_control(
				'crafto_arrows_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 40,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev i, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-widget-container .elementor-swiper-button.elementor-swiper-button-prev svg, {{WRAPPER}} .elementor-widget-container .elementor-swiper-button.elementor-swiper-button-next svg' => 'width: {{SIZE}}{{UNIT}}; height: auto',
					],
					'condition' => [
						'crafto_navigation' => 'yes',
					],
					'default'   => [
						'unit' => 'px',
						'size' => 16,
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_navigation_box_shadow',
					'selector' => '{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_arrows_box_border_style',
					'selector'       => '{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next',
					'condition'      => [
						'crafto_navigation'               => 'yes',
						'crafto_arrows_icon_shape_style!' => '',
					],
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_arrows_box_style' );
				$this->start_controls_tab(
					'crafto_arrows_box_normal_style',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_navigation' => 'yes',
						],
					]
				);

				$this->add_control(
					'crafto_arrows_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}.elementor-element .swiper .elementor-swiper-button, {{WRAPPER}}.elementor-element .swiper .elementor-swiper-button i' => 'color: {{VALUE}};',
							'{{WRAPPER}}.elementor-element .swiper .elementor-swiper-button svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							'crafto_navigation' => 'yes',
						],
					]
				);

				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_arrows_background_color',
						'types'     => [ 'classic', 'gradient' ],
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next',
						'condition' => [
							'crafto_navigation' => 'yes',
							'crafto_arrows_icon_shape_style!' => '',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_arrows_box_hover_style',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_navigation' => 'yes',
						],
					]
				);
				$this->add_control(
					'crafto_arrows_hover_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}.elementor-element .swiper .elementor-swiper-button:hover, {{WRAPPER}}.elementor-element .swiper .elementor-swiper-button:hover i' => 'color: {{VALUE}};',
							'{{WRAPPER}}.elementor-element .swiper .elementor-swiper-button:hover svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							'crafto_navigation' => 'yes',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_arrows_background_hover_color',
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
						'selector'  => '{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next:hover',
						'condition' => [
							'crafto_navigation' => 'yes',
							'crafto_arrows_icon_shape_style!' => '',
						],
					]
				);
				$this->add_control(
					'crafto_arrows_border_hover_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next:hover' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_navigation' => 'yes',
							'crafto_arrows_icon_shape_style!' => '',
						],
					]
				);
				$this->add_control(
					'crafto_navigation_hover_opacity',
					[
						'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
						'type'      => Controls_Manager::SLIDER,
						'range'     => [
							'px' => [
								'max'  => 1,
								'min'  => 0.10,
								'step' => 0.01,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .swiper .elementor-swiper-button.swiper-button-disabled, {{WRAPPER}} .swiper .elementor-swiper-button.swiper-button-disabled:hover, {{WRAPPER}} .swiper .elementor-swiper-button:hover' => 'opacity: {{SIZE}};',
						],
						'condition' => [
							'crafto_navigation' => 'yes',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_pagination',
				[
					'label'     => esc_html__( 'Pagination', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_pagination' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_dots_position',
				[
					'label'        => esc_html__( 'Position', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'outside',
					'options'      => [
						'outside' => esc_html__( 'Outside', 'crafto-addons' ),
						'inside'  => esc_html__( 'Inside', 'crafto-addons' ),
					],
					'prefix_class' => 'elementor-pagination-position-',
					'condition'    => [
						'crafto_pagination' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_dots_inside_spacing',
				[
					'label'     => esc_html__( 'Pagination Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-pagination-position-inside .swiper .swiper-pagination-bullets.swiper-pagination-horizontal, {{WRAPPER}}.elementor-pagination-position-inside .swiper.number-style-3 .swiper-pagination-wrapper' => 'bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.elementor-pagination-position-outside .swiper' => 'padding-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'crafto_pagination'           => 'yes',
						'crafto_pagination_direction' => 'horizontal',
					],
				]
			);
			$this->add_control(
				'crafto_dots_vertical_inside_spacing',
				[
					'label'     => esc_html__( 'Vertical Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .swiper .swiper-pagination, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .number-style-3 .swiper-pagination-wrapper ' => 'right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.pagination-direction-vertical.pagination-vertical-left .swiper .swiper-pagination, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-left .number-style-3 .swiper-pagination-wrapper' => 'left: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'crafto_pagination'           => 'yes',
						'crafto_dots_position'        => 'inside',
						'crafto_pagination_direction' => 'vertical',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_dots_direction_vh',
				[
					'label'      => esc_html__( 'Space Between Pagination', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.pagination-direction-vertical .swiper-pagination .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-left .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.pagination-direction-horizontal .swiper-pagination .swiper-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_number_style!' => 'number-style-3',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_dots_border',
					'default'        => '1px',
					'selector'       => '{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet',
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_dots_style!'   => 'dots-style-2',
						'crafto_pagination_number_style!' => [
							'number-style-2',
							'number-style-3',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_dots_tabs',
				[
					'condition' => [
						'crafto_pagination' => 'yes',
					],
				]
			);
			$this->start_controls_tab(
				'crafto_dots_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_number_font_size',
				[
					'label'     => esc_html__( 'Font Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 20,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet, {{WRAPPER}} .number-style-3 .swiper-pagination-wrapper .number-prev, {{WRAPPER}} .number-style-3 .swiper-pagination-wrapper .number-next, {{WRAPPER}} .number-style-1 .swiper-pagination.swiper-numbers .swiper-pagination-bullet' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'number',

					],
				]
			);
			$this->add_control(
				'crafto_dots_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 20,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'        => 'yes',
						'crafto_pagination_style!' => 'number',
					],
					'default'   => [
						'unit' => 'px',
						'size' => 12,
					],
				]
			);
			$this->add_control(
				'crafto_number_size',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination.swiper-numbers .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'              => 'yes',
						'crafto_pagination_style!'       => 'dots',
						'crafto_pagination_number_style' => 'number-style-1',
					],
					'default'   => [
						'unit' => 'px',
						'size' => 45,
					],
				]
			);
			$this->add_control(
				'crafto_dots_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:not(.swiper-pagination-bullet-active), {{WRAPPER}} .swiper-pagination.swiper-numbers .swiper-pagination-bullet:not(.swiper-pagination-bullet-active), {{WRAPPER}} .number-style-3 .swiper-pagination-wrapper .number-prev, {{WRAPPER}} .number-style-3 .swiper-pagination-wrapper .number-next' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'number',

					],
				]
			);
			$this->add_control(
				'crafto_dots_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet:not(.swiper-pagination-bullet-active)' => 'background: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'             => 'yes',
						'crafto_pagination_style'       => 'dots',
						'crafto_pagination_dots_style!' => 'dots-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_number_progerss_normal_color',
				[
					'label'     => esc_html__( 'Progress Bar Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .number-style-3 .swiper-pagination-wrapper .swiper-pagination-progressbar' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'              => 'yes',
						'crafto_pagination_style'        => 'number',
						'crafto_pagination_number_style' => 'number-style-3',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_dots_active_tab',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_dots_active_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 20,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'        => 'yes',
						'crafto_pagination_style!' => 'number',
					],
				]
			);
			$this->add_control(
				'crafto_number_active_size',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 5,
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination.swiper-numbers .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'              => 'yes',
						'crafto_pagination_style!'       => 'dots',
						'crafto_pagination_number_style' => 'number-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_dots_active_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active, {{WRAPPER}} .swiper-pagination.swiper-numbers .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_style!'        => 'dots',
						'crafto_pagination_number_style!' => 'number-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_dots_active_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active, {{WRAPPER}} .dots-style-3 .swiper-pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_number_style!' => [
							'number-style-2',
							'number-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_number_progerss_active_color',
				[
					'label'     => esc_html__( 'Track Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .number-style-3 .swiper-pagination-wrapper .swiper-pagination-progressbar-fill, {{WRAPPER}} .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet:after' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'              => 'yes',
						'crafto_pagination_style'        => 'number',
						'crafto_pagination_number_style' => [
							'number-style-2',
							'number-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_active_border_width',
				[
					'label'     => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .swiper.dots-style-2 .swiper-pagination-bullet:before' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'            => 'yes',
						'crafto_pagination_dots_style' => 'dots-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_dots_active_border',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active, {{WRAPPER}} .swiper.dots-style-2 .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .swiper.dots-style-2 .swiper-pagination-bullet:hover:before' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_number_style!' => [
							'number-style-2',
							'number-style-3',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render feature box carousel widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( empty( $settings['crafto_feature_box_carousel'] ) ) {
				return;
			}

			$slides      = [];
			$layout_type = $this->get_settings( 'crafto_feature_box_carousel_layout_type' );

			$crafto_heading_title = $this->get_settings( 'crafto_feature_box_carousel_heading' );

			switch ( $layout_type ) {
				case 'feature-box-carousel-style-1':
					ob_start();
					foreach ( $settings['crafto_feature_box_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);
						if ( ! empty( $item['crafto_feature_box_carousel_slide_background'] ) || ! empty( $item['crafto_feature_box_carousel_title'] ) || ! empty( $item['crafto_feature_box_carousel_icon'] ) ||
						! empty( $item['crafto_feature_box_carousel_link'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<figure class="feature-box-carousel-wrap">
									<?php
									if ( ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! wp_attachment_is_image( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
										$item['crafto_feature_box_carousel_slide_background']['id'] = '';
									}
									if ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
										crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									} elseif ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['url'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['url'] ) ) {
										crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									}
									?>
									<figcaption class="feature-box-carousel-inner">
										<?php
										$this->crafto_start_anchor( $item );
										if ( 'none' !== $item['crafto_feature_box_carousel_use_image'] ) {
											$this->crafto_get_feature_icon_image( $item );
										}

										if ( ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
											echo '<span class="screen-reader-text">' . esc_html( $item['crafto_feature_box_carousel_title'] ) . '</span>';
										}

										$this->crafto_end_anchor( $item );
										?>
										<div class="feature-box-carousel-content">
											<<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?> class="feature-box-carousel-title">
												<?php
												$this->crafto_title_start_anchor( $item );
												if ( ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
													echo esc_html( $item['crafto_feature_box_carousel_title'] );
												}
												$this->crafto_title_end_anchor( $item );
												?>
											</<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?>>
											<?php $this->crafto_get_link_icon( $item ); ?>
										</div>
										<div class="bg-overlay"></div>
									</figcaption>
								</figure>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'feature-box-carousel-style-2':
					ob_start();
					foreach ( $settings['crafto_feature_box_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);

						if ( ! empty( $item['crafto_feature_box_carousel_slide_background'] ) || ! empty( $item['crafto_feature_box_carousel_title'] ) || ! empty( $item['crafto_feature_box_carousel_icon'] ) ||
						! empty( $item['crafto_feature_box_carousel_link'] ) ) { ?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<figure class="feature-box-carousel-wrap">
									<?php
									if ( ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! wp_attachment_is_image( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
										$item['crafto_feature_box_carousel_slide_background']['id'] = '';
									}
									if ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
										crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									} elseif ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['url'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['url'] ) ) {
										crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									}
									?>
									<figcaption class="feature-box-carousel-inner">
										<?php
										$this->crafto_start_anchor( $item );
										if ( 'none' !== $item['crafto_feature_box_carousel_use_image'] ) {
											$this->crafto_get_feature_icon_image( $item );
										}
										$this->crafto_end_anchor( $item );
										?>
										<div class="feature-box-carousel-content">
											<<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?> class="feature-box-carousel-title">
												<?php
												$this->crafto_title_start_anchor( $item );
												if ( ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
													echo esc_html( $item['crafto_feature_box_carousel_title'] );
												}
												$this->crafto_title_end_anchor( $item );
												?>
											</<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?>>
											<?php $this->crafto_get_link_icon( $item ); ?>
										</div>
										<div class="bg-overlay"></div>
									</figcaption>
								</figure>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'feature-box-carousel-style-3':
					ob_start();
					foreach ( $settings['crafto_feature_box_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$button_key  = 'button_' . $index;
						$label_key   = 'label_' . $index;

						if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
							$this->add_render_attribute( $label_key, 'class', 'label-link' );
							$this->add_link_attributes( $label_key, $item['crafto_feature_box_carousel_label_link'] );
						}

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);
						if ( ! empty( $item['crafto_feature_box_carousel_slide_background'] ) || ! empty( $item['crafto_feature_box_carousel_title'] ) || ! empty( $item['crafto_feature_box_carousel_icon'] ) || ! empty( $item['crafto_feature_box_carousel_label_selected_icon'] ) || ! empty( $item['crafto_feature_box_carousel_label_title'] ) || ! empty( $item['crafto_feature_box_carousel_subtitle'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<figure class="feature-box-carousel-wrap">
									<?php
									if ( ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! wp_attachment_is_image( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
										$item['crafto_feature_box_carousel_slide_background']['id'] = '';
									}
									if ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
										crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									} elseif ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['url'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['url'] ) ) {
										crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									}
									?>
									<div class="bg-overlay"></div>
									<?php
									if ( ! empty( $item['crafto_feature_box_carousel_label_title'] ) ) {
										if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
											?>
											<a <?php $this->print_render_attribute_string( $label_key ); ?>>
											<?php
										}
										?>
										<div class="label-box">
											<?php
											$this->crafto_get_label_icon( $item );
											if ( ! empty( $item['crafto_feature_box_carousel_label_title'] ) ) {
												?>
												<span class="label-title">
													<?php
													if ( ! empty( $item['crafto_feature_box_carousel_label_title'] ) ) {
														echo esc_html( $item['crafto_feature_box_carousel_label_title'] );
													}
													?>
												</span>
												<?php
											}
											?>
										</div>
										<?php
										if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
											?>
											</a>
											<?php
										}
									}
									?>
									<figcaption class="feature-box-carousel-inner">
										<?php
										if ( 'none' !== $item['crafto_feature_box_carousel_use_image'] ) {
											$this->crafto_get_feature_icon_image( $item );
										}
										?>
										<<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?> class="feature-box-carousel-title">
											<?php
											$this->crafto_title_start_anchor( $item );
											if ( ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
												echo esc_html( $item['crafto_feature_box_carousel_title'] );
											}
											$this->crafto_title_end_anchor( $item );
											?>
										</<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?>>
										<span class="feature-box-carousel-subtitle">
											<?php
											if ( ! empty( $item['crafto_feature_box_carousel_subtitle'] ) ) {
												echo $item['crafto_feature_box_carousel_subtitle']; // phpcs:ignore
											}
											?>
										</span>
										<?php Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key ); ?>
									</figcaption>
								</figure>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'feature-box-carousel-style-4':
					ob_start();
					foreach ( $settings['crafto_feature_box_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);
						if ( ! empty( $item['crafto_feature_box_carousel_slide_background'] ) || ! empty( $item['crafto_feature_box_carousel_title'] ) || ! empty( $item['crafto_feature_box_carousel_content'] ) || ! empty( $item['crafto_feature_box_carousel_icon'] ) ||
						! empty( $item['crafto_feature_box_carousel_link'] ) ) { ?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<figure class="feature-box-carousel-wrap">
									<div class="feature-box-image-wrap">
										<?php
										if ( ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! wp_attachment_is_image( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
											$item['crafto_feature_box_carousel_slide_background']['id'] = '';
										}
										if ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
											crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										} elseif ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['url'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['url'] ) ) {
											crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										}
										$this->crafto_start_anchor( $item );
										if ( 'none' !== $item['crafto_feature_box_carousel_use_image'] ) {
											if ( $item['crafto_feature_box_carousel_image'] ) {
												?>
												<div class="icon-image">
													<?php
													$this->crafto_get_feature_icon_image( $item );
													?>
												</div>
												<?php
											} else {
												$this->crafto_get_feature_icon_image( $item );
											}
										}
										$this->crafto_end_anchor( $item );
										?>
										<div class="image-overlay"></div>
									</div>
									<div class="bg-overlay"></div>
									<figcaption class="feature-box-carousel-inner">
										<div class="feature-box-carousel-content">
											<<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?> class="feature-box-carousel-title">
												<?php
												$this->crafto_title_start_anchor( $item );
												if ( ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
													echo esc_html( $item['crafto_feature_box_carousel_title'] );
												}
												$this->crafto_title_end_anchor( $item );
												?>
											</<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?>>
											<div class="feature-box-content">
												<?php
												if ( ! empty( $item['crafto_feature_box_carousel_content'] ) ) {
													echo $item['crafto_feature_box_carousel_content']; // phpcs:ignore
												}
												?>
											</div>
										</div>
									</figcaption>
								</figure>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'feature-box-carousel-style-5':
					ob_start();
					foreach ( $settings['crafto_feature_box_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$button_key  = 'button_' . $index;
						$label_key   = 'label_' . $index;

						if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
							$this->add_render_attribute( $label_key, 'class', 'label-link' );
							$this->add_link_attributes( $label_key, $item['crafto_feature_box_carousel_label_link'] );
						}

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);
						if ( ! empty( $item['crafto_feature_box_carousel_slide_background'] ) || ! empty( $item['crafto_feature_box_carousel_title'] ) || ! empty( $item['crafto_feature_box_carousel_content'] ) || ! empty( $item['crafto_feature_box_carousel_icon'] ) ||
						! empty( $item['crafto_feature_box_carousel_link'] ) || ! empty( $item['crafto_feature_box_carousel_label_title'] ) || ! empty( $item['crafto_feature_box_carousel_label_selected_icon'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<figure class="feature-box-carousel-wrap">
									<div class="feature-box-image-wrap">
										<?php
										if ( ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! wp_attachment_is_image( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
											$item['crafto_feature_box_carousel_slide_background']['id'] = '';
										}
										if ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
											crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										} elseif ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['url'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['url'] ) ) {
											crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										}
										?>
										<div class="image-overlay"></div>
									</div>
									<div class="bg-overlay"></div>
									<figcaption class="feature-box-carousel-inner">
										<div class="feature-box-carousel-label">
											<?php
											if ( ! empty( $item['crafto_feature_box_carousel_label_title'] ) ) {
												?>
												<span class="label-title">
													<?php
													if ( ! empty( $item['crafto_feature_box_carousel_label_title'] ) ) {
														echo esc_html( $item['crafto_feature_box_carousel_label_title'] );
													}
													?>
												</span>
												<?php
											}
											if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
												?>
												<a <?php $this->print_render_attribute_string( $label_key ); ?>>
												<?php
											}
											$this->crafto_get_label_icon( $item );
											if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
												?>
												</a>
												<?php
											}
											?>
										</div>
										<div class="feature-box-carousel-content">
											<div class="feature-box-carousel-content-wrap">
												<<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?> class="feature-box-carousel-title">
													<?php
													$this->crafto_title_start_anchor( $item );
													if ( ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
														echo esc_html( $item['crafto_feature_box_carousel_title'] );
													}
													$this->crafto_title_end_anchor( $item );
													?>
												</<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?>>
												<span class="feature-box-carousel-subtitle">
													<?php
													if ( ! empty( $item['crafto_feature_box_carousel_subtitle'] ) ) {
														echo $item['crafto_feature_box_carousel_subtitle']; // phpcs:ignore
													}
													?>
												</span>
												<?php
												Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
												?>
											</div>
											<?php $this->crafto_get_link_icon( $item ); // phpcs:ignore ?>
										</div>
									</figcaption>	
								</figure>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'feature-box-carousel-style-6':
					ob_start();

					foreach ( $settings['crafto_feature_box_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$button_key  = 'button_' . $index;
						$label_key   = 'label_' . $index;
						$image_key   = 'image_' . $index;
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);
						if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
							$this->add_render_attribute( $label_key, 'class', 'label-link' );
							$this->add_link_attributes( $label_key, $item['crafto_feature_box_carousel_label_link'] );
						}

						// Link on Image.
						$img_alt = '';
						if ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
							$img_alt = get_post_meta( $item['crafto_feature_box_carousel_slide_background']['id'], '_wp_attachment_image_alt', true );
							if ( empty( $img_alt ) ) {
								$img_alt = esc_attr( get_the_title( $item['crafto_feature_box_carousel_slide_background']['id'] ) );
							}
						}

						if ( ! empty( $item['crafto_image_link']['url'] ) ) {
							$this->add_link_attributes( $image_key, $item['crafto_image_link'] );
							$this->add_render_attribute( $image_key, 'class', 'image-link' );
							$this->add_render_attribute( $image_key, 'aria-label', $img_alt );
						}
						// End Link on Image.
						if ( ! empty( $item['crafto_feature_box_carousel_slide_background'] ) || ! empty( $item['crafto_feature_box_carousel_title'] ) || ! empty( $item['crafto_feature_box_carousel_content'] ) || ! empty( $item['crafto_feature_box_carousel_label_title'] ) || ! empty( $item['crafto_feature_box_carousel_label_selected_icon'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<figure class="feature-box-carousel-wrap">
									<div class="feature-box-image-wrap">
									<a <?php $this->print_render_attribute_string( $image_key ); ?>>
										<?php
										if ( ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! wp_attachment_is_image( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
											$item['crafto_feature_box_carousel_slide_background']['id'] = '';
										}
										if ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['id'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['id'] ) ) {
											crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										} elseif ( isset( $item['crafto_feature_box_carousel_slide_background'] ) && isset( $item['crafto_feature_box_carousel_slide_background']['url'] ) && ! empty( $item['crafto_feature_box_carousel_slide_background']['url'] ) ) {
											crafto_get_attachment_html( $item['crafto_feature_box_carousel_slide_background']['id'], $item['crafto_feature_box_carousel_slide_background']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										}
										?>
										</a>
									<?php
									if ( ! empty( $item['crafto_feature_box_carousel_label_title'] ) ) {
										if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
											?>
											<a <?php $this->print_render_attribute_string( $label_key ); ?>>
											<?php
										}
										?>
										<div class="feature-box-carousel-label">
											<?php
											$this->crafto_get_label_icon( $item );
											if ( ! empty( $item['crafto_feature_box_carousel_label_title'] ) ) {
												?>
												<span class="label-title">
													<?php echo esc_html( $item['crafto_feature_box_carousel_label_title'] ); ?>
												</span>
												<?php
											}
											?>
										</div>
										<?php
										if ( ! empty( $item['crafto_feature_box_carousel_label_link']['url'] ) ) {
											?>
											</a>
											<?php
										}
									}
									?>
									</div>
									<figcaption class="feature-box-carousel-inner">
										<div class="feature-box-carousel-content">
											<<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?> class="feature-box-carousel-title">
												<?php
												$this->crafto_title_start_anchor( $item );
												if ( ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
													echo esc_html( $item['crafto_feature_box_carousel_title'] );
												}
												$this->crafto_title_end_anchor( $item );
												?>
											</<?php echo $this->get_settings( 'crafto_feature_box_carousel_title_size' ); // phpcs:ignore ?>>
											<?php
											if ( ! empty( $item['crafto_feature_box_carousel_content'] ) ) {
												?>
												<div class="feature-box-content"><?php echo $item['crafto_feature_box_carousel_content']; // phpcs:ignore ?></div>
												<?php
											}
											?>
										</div>
										<?php
										Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
										?>
									</figcaption>
								</figure>
							</div>
							<?php
						}
					}

					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
			}

			$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_slider_cursor           = $this->get_settings( 'crafto_slider_cursor' );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
			$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
			$crafto_pagination_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );

			$sliderconfig = array(
				'navigation'                 => $crafto_navigation,
				'pagination'                 => $crafto_pagination,
				'pagination_style'           => $crafto_pagination_style,
				'number_style'               => $crafto_pagination_number_style,
				'autoplay'                   => $this->get_settings( 'crafto_autoplay' ),
				'effect'                     => 'slide',
				'autoplay_speed'             => $this->get_settings( 'crafto_autoplay_speed' ),
				'pause_on_hover'             => $this->get_settings( 'crafto_pause_on_hover' ),
				'loop'                       => $this->get_settings( 'crafto_infinite' ),
				'speed'                      => $this->get_settings( 'crafto_speed' ),
				'image_spacing'              => $this->get_settings( 'crafto_items_spacing' ),
				'navigation_dynamic_bullets' => $this->get_settings( 'crafto_navigation_dynamic_bullets' ),
				'allowtouchmove'             => $this->get_settings( 'crafto_allowtouchmove' ),
			);

			$slider_viewport = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
			$sliderconfig    = array_merge( $sliderconfig, $slider_viewport );
			$magic_cursor    = '';
			$allowtouchmove  = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}
			$this->add_render_attribute(
				[
					'carousel'         => [
						'class' => [
							'swiper-wrapper',
						],
					],
					'carousel-wrapper' => [
						'class'            => [
							'swiper',
							$layout_type,
							$crafto_slider_cursor,
							$magic_cursor,
						],
						'data-settings'    => wp_json_encode( $sliderconfig ),
						'data-layout-type' => $layout_type,
					],
				]
			);
			if ( ! empty( $crafto_rtl ) ) {
				$this->add_render_attribute(
					'carousel-wrapper',
					'dir',
					$crafto_rtl,
				);
			}
			if ( 'yes' === $this->get_settings( 'crafto_image_stretch' ) ) {
				$this->add_render_attribute(
					'carousel',
					'class',
					'swiper-image-stretch',
				);
			}
			$this->add_render_attribute(
				'carousel_title_box',
				[
					'class' => [
						'feature-carousel-title-box',
					],
				],
			);
			$this->add_render_attribute(
				'carousel_wrap',
				[
					'class' => [
						'feature-carousel-swiper-box',
					],
				]
			);
			$this->add_render_attribute(
				'title',
				[
					'class' => [
						'heading',
					],
				]
			);

			if ( ! empty( $crafto_heading_title ) && has_shortcode( $crafto_heading_title, 'crafto_highlight' ) ) {
				if ( 'yes' === $settings['crafto_enable_separator_effect'] ) {
					$this->add_render_attribute(
						'title',
						[
							'class'                => [
								'shadow-animation slider-shadow-animation',
							],
							'data-animation-delay' => 700,
						]
					);
				} else {
					$this->add_render_attribute(
						'title',
						[
							'class' => [
								'no-shadow-animation',
							],
						]
					);
				}
			}

			$this->add_render_attribute(
				[
					'carousel-wrapper' => [
						'class' => [
							$crafto_arrows_icon_shape_style,
						],
					],
				]
			);
			if ( 'feature-box-carousel-style-4' === $layout_type && ! empty( $crafto_navigation_v_alignment ) ) {
				$this->add_render_attribute(
					[
						'carousel-wrapper' => [
							'class' => [
								'navigation-' . $crafto_navigation_v_alignment,
							],
						],
					]
				);
			}

			if ( ! empty( $crafto_pagination_h_alignment ) ) {
				$this->add_render_attribute(
					[
						'carousel-wrapper' => [
							'class' => [
								'pagination-' . $crafto_pagination_h_alignment,
							],
						],
					]
				);
			}
			if ( '' !== $crafto_arrows_icon_shape_style ) {
				$this->add_render_attribute(
					[
						'carousel-wrapper' => [
							'class' => [
								$crafto_arrows_icon_shape_style,
							],
						],
					]
				);
			}
			if ( 'dots' === $crafto_pagination_style ) {
				$pagination_style = $crafto_pagination_dots_style;
			} else {
				$pagination_style = $crafto_pagination_number_style;
			}
			$this->add_render_attribute(
				[
					'carousel-wrapper' => [
						'class' => [
							'elementor-arrows-position-custom',
							$pagination_style,
						],
					],
				]
			);
			if ( 'feature-box-carousel-style-4' !== $layout_type ) {
				?>
				<div class="feature-box-carousel-wrapper <?php echo esc_html( $layout_type ); ?>">
				<div <?php $this->print_render_attribute_string( 'carousel_title_box' ); ?>>
					<?php
					if ( 'feature-box-carousel-style-5' === $layout_type ) {
						?>
						<div class="featurebox-heading-wrapper">
						<?php
					}
					if ( ! empty( $settings['crafto_feature_box_carousel_subheading'] ) ) {
						?>
						<div class="subheading"><?php echo esc_html( $settings['crafto_feature_box_carousel_subheading'] ); ?></div>
						<?php
					}

					if ( ! empty( $crafto_heading_title ) ) {
						if ( has_shortcode( $crafto_heading_title, 'crafto_highlight' ) ) {
							if ( 'yes' === $settings['crafto_enable_separator_effect'] ) {
								$crafto_heading_title = str_replace( '[crafto_highlight]', '<span class="separator">', $crafto_heading_title );
								$crafto_heading_title = str_replace( '[/crafto_highlight]', '<span class="separator-animation horizontal-separator"></span></span>', $crafto_heading_title );
							} else {
								$crafto_heading_title = str_replace( '[crafto_highlight]', '<span class="separator">', $crafto_heading_title );
								$crafto_heading_title = str_replace( '[/crafto_highlight]', '</span>', $crafto_heading_title );
							}
						}
					}

					if ( ! empty( $crafto_heading_title ) ) {
						$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['crafto_header_size'], $this->get_render_attribute_string( 'title' ), $crafto_heading_title );

						printf( '%s', $title_html ); // phpcs:ignore
					}

					if ( 'feature-box-carousel-style-5' === $layout_type ) {
						?>
						</div>
						<?php
					}
					if ( 'feature-box-carousel-style-1' === $layout_type || 'feature-box-carousel-style-2' === $layout_type || 'feature-box-carousel-style-3' === $layout_type || 'feature-box-carousel-style-5' === $layout_type || 'feature-box-carousel-style-6' === $layout_type && ! empty( $settings['crafto_feature_box_carousel_description'] ) ) {
						?>
						<p><?php echo sprintf( '%s', $settings['crafto_feature_box_carousel_description'] );  // phpcs:ignore ?></p>
						<?php
					}
					?>
				</div>
				<?php
			}
			if ( 'feature-box-carousel-style-2' === $layout_type || 'feature-box-carousel-style-3' === $layout_type ) {
				?>
				<div <?php $this->print_render_attribute_string( 'carousel_wrap' ); ?>>
				<?php
			}
			?>
			<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
					<?php echo implode( '', $slides ); // phpcs:ignore ?>
				</div>
				<?php
				if ( 1 < $slides ) {
					$this->swiper_pagination();
				}
				?>
			</div>
			<?php
			if ( 'feature-box-carousel-style-2' === $layout_type || 'feature-box-carousel-style-3' === $layout_type ) {
				?>
				</div>
				<?php
			}
			if ( 'feature-box-carousel-style-4' !== $layout_type ) {
				?>
				</div>
				<?php
			}
		}

		/**
		 * Return icon for label
		 *
		 * @param array $item data.
		 */
		public function crafto_get_label_icon( $item ) {
			$icon     = '';
			$migrated = isset( $item['__fa4_migrated']['crafto_feature_box_carousel_label_selected_icon'] );
			$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $item['crafto_feature_box_carousel_label_selected_icon'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $item['crafto_feature_box_carousel_label_selected_icon']['value'] ) && ! empty( $item['crafto_feature_box_carousel_label_selected_icon']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $item['crafto_feature_box_carousel_label_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			$crafto_feature_box_carousel_title = esc_attr__( 'click this', 'crafto-addons' );
			if ( isset( $item['crafto_feature_box_carousel_title'] ) && ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
				$crafto_feature_box_carousel_title = esc_attr( $item['crafto_feature_box_carousel_title'] );
			}

			if ( ! empty( $icon ) ) {
				?>
				<div class="label-icon">
					<?php printf( '%s', $icon ); // phpcs:ignore ?>
				</div>
				<span class="screen-reader-text"><?php echo esc_html( $crafto_feature_box_carousel_title ); ?></span>
				<?php
			}
		}
		/**
		 * Return icon or image
		 *
		 * @param array $item data.
		 */
		public function crafto_get_feature_icon_image( $item ) {
			$settings = $this->get_settings_for_display();
			$icon     = '';
			$migrated = isset( $item['__fa4_migrated']['crafto_feature_box_carousel_icon'] );
			$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $item['crafto_feature_box_carousel_icon'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $item['crafto_feature_box_carousel_icon']['value'] ) && ! empty( $item['crafto_feature_box_carousel_icon']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $item['crafto_feature_box_carousel_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			if ( ! empty( $item['crafto_feature_box_carousel_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_feature_box_carousel_image']['id'] ) ) {
				$item['crafto_feature_box_carousel_image']['id'] = '';
			}
			if ( isset( $item['crafto_feature_box_carousel_image'] ) && isset( $item['crafto_feature_box_carousel_image']['id'] ) && ! empty( $item['crafto_feature_box_carousel_image']['id'] ) ) {
				crafto_get_attachment_html( $item['crafto_feature_box_carousel_image']['id'], $item['crafto_feature_box_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			} elseif ( isset( $item['crafto_feature_box_carousel_image'] ) && isset( $item['crafto_feature_box_carousel_image']['url'] ) && ! empty( $item['crafto_feature_box_carousel_image']['url'] ) ) {
				crafto_get_attachment_html( $item['crafto_feature_box_carousel_image']['id'], $item['crafto_feature_box_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			}
			if ( ! empty( $icon ) && ( '' === $item['crafto_feature_box_carousel_use_image'] ) ) {
				?>
				<div class="elementor-icon">
					<?php printf( '%s', $icon ); // phpcs:ignore ?>
				</div>
				<?php
			}
		}
		/**
		 * Return icon for link
		 *
		 * @param array $item data.
		 */
		public function crafto_get_link_icon( $item ) {
			$icon     = '';
			$migrated = isset( $item['__fa4_migrated']['crafto_feature_box_carousel_selected_icon'] );
			$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $item['crafto_feature_box_carousel_selected_icon'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $item['crafto_feature_box_carousel_selected_icon']['value'] ) && ! empty( $item['crafto_feature_box_carousel_selected_icon']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $item['crafto_feature_box_carousel_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
			if ( ! empty( $item['crafto_feature_box_carousel_link'] ) ) {
				$this->crafto_start_anchor( $item );
				if ( ! empty( $icon ) && isset( $item['crafto_feature_box_carousel_selected_icon'] ) ) {
					?>
					<div class="read-more-icon">
						<?php printf( '%s', $icon ); // phpcs:ignore ?>
					</div>
					<?php
				} else {
					?>
					<div class="read-more-icon">
						<i class="bi bi-arrow-right-short"></i>
					</div>
					<?php
				}

				$crafto_feature_box_carousel_title = esc_attr__( 'click this', 'crafto-addons' );
				if ( isset( $item['crafto_feature_box_carousel_title'] ) && ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
					$crafto_feature_box_carousel_title = esc_attr( $item['crafto_feature_box_carousel_title'] );
				}
				?>
				<span class="screen-reader-text"><?php echo esc_html( $crafto_feature_box_carousel_title ); ?></span>
				<?php
				$this->crafto_end_anchor( $item );
			}
		}

		/**
		 *
		 * Return start anchor tag
		 *
		 * @param array $item data.
		 */
		public function crafto_start_anchor( $item ) {
			$crafto_feature_box_carousel_title = esc_attr__( 'click this', 'crafto-addons' );
			if ( isset( $item['crafto_feature_box_carousel_title'] ) && ! empty( $item['crafto_feature_box_carousel_title'] ) ) {
				$crafto_feature_box_carousel_title = esc_attr( $item['crafto_feature_box_carousel_title'] );
			}

			if ( ! empty( $item['crafto_feature_box_carousel_link'] ) ) {
				?>
				<a href="<?php echo $item['crafto_feature_box_carousel_link']['url']; ?>" class="feature-box-carousel-link" aria-label="<?php echo $crafto_feature_box_carousel_title; // phpcs:ignore  ?>">
				<?php
			}
		}
		/**
		 * Return end anchor tag
		 *
		 * @param array $item data.
		 */
		public function crafto_end_anchor( $item ) {
			if ( ! empty( $item['crafto_feature_box_carousel_link'] ) ) {
				?>
				</a>
				<?php
			}
		}
		/**
		 *
		 * Return title start anchor tag
		 *
		 * @param array $item data.
		 */
		public function crafto_title_start_anchor( $item ) {
			if ( ! empty( $item['crafto_feature_box_carousel_title_link']['url'] ) ) {
				?>
				<a href="<?php echo $item['crafto_feature_box_carousel_title_link']['url']; // phpcs:ignore ?>">
				<?php
			}
		}
		/**
		 * Return title end anchor tag
		 *
		 * @param array $item data.
		 */
		public function crafto_title_end_anchor( $item ) {
			if ( ! empty( $item['crafto_feature_box_carousel_title_link']['url'] ) ) {
				?>
				</a>
				<?php
			}
		}
		/**
		 * Return swiper pagination.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function swiper_pagination() {
			$settings                       = $this->get_settings_for_display();
			$previous_arrow_icon            = '';
			$next_arrow_icon                = '';
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$previous_icon_migrated         = isset( $settings['__fa4_migrated']['crafto_previous_arrow_icon'] );
			$next_icon_migrated             = isset( $settings['__fa4_migrated']['crafto_next_arrow_icon'] );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );
			if ( isset( $settings['crafto_previous_arrow_icon'] ) && ! empty( $settings['crafto_previous_arrow_icon'] ) ) {
				if ( $is_new || $previous_icon_migrated ) {
					ob_start();
						Icons_Manager::render_icon( $settings['crafto_previous_arrow_icon'], [ 'aria-hidden' => 'true' ] );
					$previous_arrow_icon .= ob_get_clean();
				} elseif ( isset( $settings['crafto_previous_arrow_icon']['value'] ) && ! empty( $settings['crafto_previous_arrow_icon']['value'] ) ) {
					$previous_arrow_icon .= '<i class="' . esc_attr( $settings['crafto_previous_arrow_icon']['value'] ) . '" aria-hidden="true"></i>';
				}
			}
			if ( isset( $settings['crafto_next_arrow_icon'] ) && ! empty( $settings['crafto_next_arrow_icon'] ) ) {
				if ( $is_new || $next_icon_migrated ) {
					ob_start();
						Icons_Manager::render_icon( $settings['crafto_next_arrow_icon'], [ 'aria-hidden' => 'true' ] );
					$next_arrow_icon .= ob_get_clean();
				} elseif ( isset( $settings['crafto_next_arrow_icon']['value'] ) && ! empty( $settings['crafto_next_arrow_icon']['value'] ) ) {
					$next_arrow_icon .= '<i class="' . esc_attr( $settings['crafto_next_arrow_icon']['value'] ) . '" aria-hidden="true"></i>';
				}
			}
			if ( 'yes' === $crafto_navigation ) {
				if ( 'feature-box-carousel-style-1' === $settings['crafto_feature_box_carousel_layout_type'] ) {
					?>
					<div class="feature-box-nav">
						<div class="elementor-swiper-button elementor-swiper-button-prev">
							<?php
							if ( ! empty( $previous_arrow_icon ) ) {
								echo sprintf( '%s', $previous_arrow_icon ); // phpcs:ignore
							}
							?>
							<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'crafto-addons' ); ?></span>
						</div>
						<div class="elementor-swiper-button elementor-swiper-button-next">
							<?php
							if ( ! empty( $next_arrow_icon ) ) {
								echo sprintf( '%s', $next_arrow_icon ); // phpcs:ignore
							}
							?>
							<span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'crafto-addons' ); ?></span>
						</div>
					</div>
					<?php
				} else {
					?>
					<div class="elementor-swiper-button elementor-swiper-button-prev">
						<?php
						if ( ! empty( $previous_arrow_icon ) ) {
							echo sprintf( '%s', $previous_arrow_icon ); // phpcs:ignore
						}
						?>
						<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'crafto-addons' ); ?></span>
					</div>
					<div class="elementor-swiper-button elementor-swiper-button-next">
						<?php
						if ( ! empty( $next_arrow_icon ) ) {
							echo sprintf( '%s', $next_arrow_icon ); // phpcs:ignore
						}
						?>
						<span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'crafto-addons' ); ?></span>
					</div>
					<?php
				}
			}
			if ( 'yes' === $crafto_pagination && 'dots' === $crafto_pagination_style ) {
				?>
				<div class="swiper-pagination"></div>
				<?php
			}
			if ( 'yes' === $crafto_pagination && 'number' === $crafto_pagination_style && 'number-style-3' !== $crafto_pagination_number_style ) {
				?>
					<div class="swiper-pagination swiper-pagination-clickable swiper-numbers"></div>
				<?php
			}
			if ( 'yes' === $crafto_pagination && 'number' === $crafto_pagination_style && 'number-style-3' === $crafto_pagination_number_style ) {
				?>
				<div class="swiper-pagination-wrapper">
					<div class="number-prev"></div>
					<div class="swiper-pagination"></div>
					<div class="number-next"></div>
				</div>
				<?php
			}
		}
	}
}
