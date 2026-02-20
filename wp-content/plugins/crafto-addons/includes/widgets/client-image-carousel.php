<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Box_Shadow;

/**
 *
 * Crafto widget for Client Image Carousel.
 *
 * @package Crafto
 */

// If class `Client_Image_Carousel` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Client_Image_Carousel' ) ) {
	/**
	 * Define `Client_Image_Carousel` Class.
	 */
	class Client_Image_Carousel extends Widget_Base {

		/**
		 * Retrieve the list of scripts the client image carousel widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$client_image_carousel_scripts = [];
			$crafto_disable_all_animation  = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$client_image_carousel_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$client_image_carousel_scripts[] = 'swiper';

					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$client_image_carousel_scripts[] = 'crafto-magic-cursor';
					}
				}
				$client_image_carousel_scripts[] = 'crafto-default-carousel';
			}

			return $client_image_carousel_scripts;
		}

		/**
		 * Retrieve the list of styles the client image carousel widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$client_image_carousel_styles = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$client_image_carousel_styles[] = 'crafto-widgets-rtl';
				} else {
					$client_image_carousel_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$client_image_carousel_styles = [
						'swiper',
						'nav-pagination',
					];

					if ( is_rtl() ) {
						$client_image_carousel_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'magic-cursor' ) ) {
						$client_image_carousel_styles[] = 'crafto-magic-cursor';
					}
				}
				$client_image_carousel_styles[] = 'client-image-carousel';
			}
			return $client_image_carousel_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-client-image-carousel';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Client Image Carousel', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/client-image-carousel/';
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
				'slider',
				'logo',
				'partner',
				'sponsor',
				'brand',
			];
		}

		/**
		 * Register client image carousel widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_client_image_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_client_image_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'client-image-carousel-1',
					'options'            => [
						'client-image-carousel-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'client-image-carousel-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_image_carousel_image_section',
				[
					'label' => esc_html__( 'Slides', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs(
				'crafto_client_image_tabs'
			);
			$repeater->start_controls_tab(
				'crafto_client_image_tab',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_image',
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
				'crafto_image_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_client_image_icon_tab',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
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
			$repeater->add_control(
				'crafto_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'ti ti-crown',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_item_use_image' => '',
					],
					'description'      => esc_html__( 'Applicable in style 2 only.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_thumb_image',
				[
					'label'       => esc_html__( 'Image', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition'   => [
						'crafto_item_use_image' => 'yes',
					],
					'description' => esc_html__( 'Not Applicable in style 2 only.', 'crafto-addons' ),
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'slides',
				[
					'label'      => esc_html__( 'Slides', 'crafto-addons' ),
					'show_label' => false,
					'type'       => Controls_Manager::REPEATER,
					'fields'     => $repeater->get_controls(),
					'default'    => [
						[
							'crafto_image' => Utils::get_placeholder_image_src(),
						],
						[
							'crafto_image' => Utils::get_placeholder_image_src(),
						],
						[
							'crafto_image' => Utils::get_placeholder_image_src(),
						],
						[
							'crafto_image' => Utils::get_placeholder_image_src(),
						],
						[
							'crafto_image' => Utils::get_placeholder_image_src(),
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_setting',
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
				'crafto_image_stretch',
				[
					'label'        => esc_html__( 'Enable Image Stretch', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_brand_logo_carousel_setting',
				[
					'label' => esc_html__( 'Carousel Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_slide_width_auto',
				[
					'label'        => esc_html__( 'Enable Auto Columns Width', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'slider-width-auto',
				]
			);
			$this->add_responsive_control(
				'crafto_slide_spacing',
				[
					'label'      => esc_html__( 'Items Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .swiper .swiper-wrapper .swiper-slide' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_slide_width_auto' => 'slider-width-auto',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slides_to_show',
				[
					'label'     => esc_html__( 'Slides Per View', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 4,
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 10,
							'step' => 1,
						],
					],
					'condition' => [
						'crafto_effect'            => 'slide',
						'crafto_slide_width_auto!' => 'slider-width-auto',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_items_spacing',
				[
					'label'      => esc_html__( 'Image Spacing', 'crafto-addons' ),
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
						'crafto_slide_width_auto'      => '',
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
				'crafto_effect',
				[
					'label'   => esc_html__( 'Effect', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'slide',
					'options' => [
						'slide'     => esc_html__( 'Slide', 'crafto-addons' ),
						'fade'      => esc_html__( 'Fade', 'crafto-addons' ),
						'flip'      => esc_html__( 'Flip', 'crafto-addons' ),
						'cube'      => esc_html__( 'Cube', 'crafto-addons' ),
						'cards'     => esc_html__( 'Cards', 'crafto-addons' ),
						'coverflow' => esc_html__( 'Coverflow', 'crafto-addons' ),
					],
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
				'crafto_feather_shadow',
				[
					'label'   => esc_html__( 'Fade Effect', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none'   => esc_html__( 'None', 'crafto-addons' ),
						'both'   => esc_html__( 'Both Side', 'crafto-addons' ),
						'right'  => esc_html__( 'Right Side', 'crafto-addons' ),
						'bottom' => esc_html__( 'Bottom Side', 'crafto-addons' ),
					],
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
					'return_value' => 'yes',
					'description'  => esc_html__( 'You can configure magic cursor from Appearance > Customize > Advanced Theme Options > Magic Cursor Settings.', 'crafto-addons' ),
					'condition'    => [
						'crafto_allowtouchmove' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_blog_post_slider_navigation',
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
					'toggle'       => true,
					'prefix_class' => 'pagination-direction-',
					'condition'    => [
						'crafto_pagination' => 'yes',
					],
				]
			);
			$this->add_control(
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
					'toggle'    => true,
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
				'crafto_image_carousel_general_style_section',
				[
					'label'     => esc_html__( 'General', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_client_image_style' => [
							'client-image-carousel-1',
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_image_carousel_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
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
						'{{WRAPPER}} .swiper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_image_carousel_margin',
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
						'{{WRAPPER}} .swiper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_image_style',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_client_image_style' => [
							'client-image-carousel-1',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_image_styles_tabs' );
			$this->start_controls_tab(
				'crafto_image_carousel_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_image_carousel_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'max'  => 1,
							'step' => 0.01,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide img' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_carousel_width',
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
							'max' => 500,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_carousel_height',
				[
					'label'      => esc_html__( 'Max Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'em',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 800,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide img' => 'max-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_client_image_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],

				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_image_box_shadow',
					'selector' => '{{WRAPPER}} .swiper-slide img',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_image_carousel_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'     => 'crafto_image_carousel_css_filters_hover',
					'selector' => '{{WRAPPER}} .swiper-slide img:hover',
				]
			);
			$this->add_control(
				'crafto_image_carousel_hover_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'max'  => 1,
							'step' => 0.01,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide img:hover' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_background_image_style',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_client_image_style' => [
							'client-image-carousel-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_client_background_image_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .client-image-carousel-2 .crafto-client-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'crafto_client_image_style' => [
							'client-image-carousel-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_heading_style_icons',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-client-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-client-icon svg' => 'fill: {{VALUE}};',
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
						'px' => [
							'min' => 6,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-client-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .crafto-client-icon svg' => 'width: {{SIZE}}{{UNIT}}; height:auto;',
					],
				]
			);
			$this->add_control(
				'crafto_heading_style_image',
				[
					'label'     => esc_html__( 'Image Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_icon_width',
				[
					'label'          => esc_html__( 'Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'size_units'     => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'range'          => [
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
						'vw' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'      => [
						'{{WRAPPER}} .crafto-client-icon img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_client_image_overlay_style',
				[
					'label'      => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_client_image_style' => [
							'client-image-carousel-2',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_client_image_overlay',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Overlay Color', 'crafto-addons' ),
						],
					],
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .client-image-overlay',
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
						'{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev i, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next i'                                             => 'font-size: {{SIZE}}{{UNIT}};',
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
							'{{WRAPPER}}.elementor-element .swiper .elementor-swiper-button:hover svg, {{WRAPPER}}.elementor-element .swiper .elementor-swiper-button:focus svg' => 'fill: {{VALUE}};',
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
					'default'      => 'inside',
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
			$this->add_responsive_control(
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
					'default'   => [
						'unit' => 'px',
						'size' => 25,
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
		 * Render client image carousel widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$slides                    = [];
			$slides_count              = '';
			$settings                  = $this->get_settings_for_display();
			$crafto_slider_cursor      = $this->get_settings( 'crafto_slider_cursor' );
			$crafto_client_image_style = ( isset( $settings['crafto_client_image_style'] ) && $settings['crafto_client_image_style'] ) ? $settings['crafto_client_image_style'] : 'client-image-carousel-1';
			if ( empty( $settings['slides'] ) ) {
				return;
			}
			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}

			$crafto_slide_width_auto = $this->get_settings( 'crafto_slide_width_auto' );

			foreach ( $settings['slides'] as $index => $item ) {

				$icon_alt    = '';
				$wrapper_key = 'wrapper_' . $index;
				$link_key    = 'link_' . $index;
				if ( 'client-image-carousel-1' === $crafto_client_image_style ) {
					$img_alt = '';
					if ( isset( $item['crafto_image'] ) && isset( $item['crafto_image']['id'] ) && ! empty( $item['crafto_image']['id'] ) ) {
						$img_alt = get_post_meta( $item['crafto_image']['id'], '_wp_attachment_image_alt', true );

						if ( empty( $img_alt ) ) {
							$img_alt = esc_attr( get_the_title( $item['crafto_image']['id'] ) );
						}
						$this->add_render_attribute( $link_key, 'aria-label', $img_alt );
					}
				}
				if ( isset( $item['crafto_icon'] ) && isset( $item['crafto_icon']['id'] ) && ! empty( $item['crafto_icon']['id'] ) ) {
					$icon_alt = get_post_meta( $item['crafto_icon']['id'], '_wp_attachment_image_alt', true );

					if ( empty( $icon_alt ) ) {
						$icon_alt = esc_attr( get_the_title( $item['crafto_icon']['id'] ) );
					}
					$this->add_render_attribute( $link_key, 'aria-label', $icon_alt );
				}

				if ( ! empty( $item['crafto_image_link']['url'] ) ) {
					$this->add_link_attributes( $link_key, $item['crafto_image_link'] );
					$this->add_render_attribute( $link_key, 'class', 'image-link' );
				}

				$this->add_render_attribute(
					$wrapper_key,
					[
						'class' => [
							'elementor-repeater-item-' . esc_attr( $item['_id'] ),
							'swiper-slide',
							$crafto_slide_width_auto,
							$magic_cursor,
						],
					]
				);
				ob_start();
				?>
					<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
						<?php
						if ( 'client-image-carousel-1' === $crafto_client_image_style ) { // phpcs:ignore
							if ( ! empty( $item['crafto_image_link']['url'] ) ) {
								?>
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
									<?php
										$this->crafto_client_image( $item );
									?>
								</a>
								<?php
							} else {
								$this->crafto_client_image( $item );
							}
						} else {
							?>
							<div class="crafto-client-image">
							<?php
								$this->crafto_client_image( $item );
							?>
							<div class="client-image-overlay"></div>
								<div class="crafto-client-icon">
									<?php
									if ( ! empty( $item['crafto_image_link']['url'] ) ) {
										?>
										<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<?php
												$this->crafto_client_icon( $item );
											?>
										</a>
										<?php
									} else {
										$this->crafto_client_icon( $item );
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					$slides[] = ob_get_contents();
					ob_end_clean();
			}

			if ( empty( $slides ) ) {
				return;
			}
			$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
			$slides_count                   = count( $settings['slides'] );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
			$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
			$crafto_navigation_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );
			$sliderconfig                   = [
				'navigation'       => $crafto_navigation,
				'pagination'       => $crafto_pagination,
				'pagination_style' => $crafto_pagination_style,
				'number_style'     => $crafto_pagination_number_style,
				'autoplay'         => $this->get_settings( 'crafto_autoplay' ),
				'autoplay_speed'   => $this->get_settings( 'crafto_autoplay_speed' ),
				'pause_on_hover'   => $this->get_settings( 'crafto_pause_on_hover' ),
				'loop'             => $this->get_settings( 'crafto_infinite' ),
				'effect'           => $this->get_settings( 'crafto_effect' ),
				'speed'            => $this->get_settings( 'crafto_speed' ),
				'image_spacing'    => $this->get_settings( 'crafto_items_spacing' ),
				'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
				'auto_slide'       => $this->get_settings( 'crafto_slide_width_auto' ),
			];

			$slider_viewport = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
			$sliderconfig    = array_merge( $sliderconfig, $slider_viewport );
			$crafto_effect   = $this->get_settings( 'crafto_effect' );

			$effect = [
				'fade',
				'flip',
				'cube',
				'cards',
				'coverflow',
			];

			if ( '1' === $this->get_settings( 'crafto_slides_to_show' )['size'] && in_array( $crafto_effect, $effect, true ) ) {
				$sliderconfig['effect'] = $crafto_effect;
			}

			$this->add_render_attribute(
				[
					'carousel'         => [
						'class' => [
							'swiper-wrapper',
							'marquee-slide',
						],
					],
					'carousel-wrapper' => [
						'class'         => [
							'swiper',
							'marquee-slider',
							$crafto_client_image_style,
						],
						'data-settings' => wp_json_encode( $sliderconfig ),
					],
				]
			);
			$this->add_render_attribute(
				[
					'carousel-wrapper' => [
						'class' => [
							$crafto_arrows_icon_shape_style,
						],
					],
				]
			);
			if ( ! empty( $crafto_navigation_v_alignment ) ) {
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
			if ( ! empty( $crafto_navigation_h_alignment ) ) {
				$this->add_render_attribute(
					[
						'carousel-wrapper' => [
							'class' => [
								'pagination-' . $crafto_navigation_h_alignment,
							],
						],
					]
				);
			}
			if ( ! empty( $crafto_rtl ) ) {
				$this->add_render_attribute( 'carousel-wrapper', 'dir', $crafto_rtl );
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
			switch ( $this->get_settings( 'crafto_feather_shadow' ) ) {
				case 'both':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow' );
					break;
				case 'right':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow-right' );
					break;
				case 'bottom':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow-bottom' );
					break;
			}
			if ( 'yes' === $this->get_settings( 'crafto_image_stretch' ) ) {
				$this->add_render_attribute( 'carousel', 'class', 'swiper-image-stretch' );
			}
			?>
			<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
					<?php echo implode( '', $slides ); // phpcs:ignore ?>
				</div>
				<?php
				if ( 1 < $slides_count ) {
					get_swiper_pagination( $settings ); // phpcs:ignore
				}
				?>
			</div>
			<?php
		}
		/**
		 * Retrive Client image html.
		 *
		 * @param array $item data.
		 */
		public function crafto_client_image( $item ) {
			$settings = $this->get_settings_for_display();
			if ( ! empty( $item['crafto_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_image']['id'] ) ) {
				$item['crafto_image']['id'] = '';
			}
			if ( isset( $item['crafto_image'] ) && isset( $item['crafto_image']['id'] ) && ! empty( $item['crafto_image']['id'] ) ) {
				crafto_get_attachment_html( $item['crafto_image']['id'], $item['crafto_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			} elseif ( isset( $item['crafto_image'] ) && isset( $item['crafto_image']['url'] ) && ! empty( $item['crafto_image']['url'] ) ) {
				crafto_get_attachment_html( $item['crafto_image']['id'], $item['crafto_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			}
		}
		/**
		 * Retrive client icon html.
		 *
		 * @param array $item data.
		 */
		public function crafto_client_icon( $item ) {
			$icon     = '';
			$migrated = isset( $item['__fa4_migrated']['crafto_icon'] );
			$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
			$settings = $this->get_settings_for_display();

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $item['crafto_icon'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $item['crafto_icon']['value'] ) && ! empty( $item['crafto_icon']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $item['crafto_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
			if ( 'none' !== $item['crafto_item_use_image'] ) {
				if ( ! empty( $icon ) && ( '' === $item['crafto_item_use_image'] ) ) {
					?>
					<div class="elementor-icon">
						<?php printf( '%s', $icon ); // phpcs:ignore ?>
					</div>
					<?php
				} else {
					if ( ! empty( $item['crafto_thumb_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_thumb_image']['id'] ) ) {
						$item['crafto_thumb_image']['id'] = '';
					}
					if ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['id'] ) && ! empty( $item['crafto_thumb_image']['id'] ) ) {
						crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					} elseif ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['url'] ) && ! empty( $item['crafto_thumb_image']['url'] ) ) {
						crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					}
				}
			}
		}
	}
}
