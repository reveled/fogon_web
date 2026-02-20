<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for testimonial carousel.
 *
 * @package Crafto
 */

// If class `Testimonial_Carousel` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Testimonial_Carousel' ) ) {
	/**
	 * Define `Testimonial_Carousel` class.
	 */
	class Testimonial_Carousel extends Widget_Base {
		/**
		 * Retrieve the list of scripts the testmonial carousel widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$testimonial_carousel_scripts = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$testimonial_carousel_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$testimonial_carousel_scripts[] = 'swiper';

					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$testimonial_carousel_scripts[] = 'crafto-magic-cursor';
					}
				}
				$testimonial_carousel_scripts[] = 'crafto-testimonial-carousel';
			}
			return $testimonial_carousel_scripts;
		}

		/**
		 * Retrieve the list of styles the testmonial carousel widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$testimonial_carousel_styles  = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$testimonial_carousel_styles[] = 'crafto-widgets-rtl';
				} else {
					$testimonial_carousel_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$testimonial_carousel_styles[] = 'swiper';
					$testimonial_carousel_styles[] = 'nav-pagination';

					if ( is_rtl() ) {
						$testimonial_carousel_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$testimonial_carousel_styles[] = 'crafto-magic-cursor';
					}
				}

				if ( is_rtl() ) {
					$testimonial_carousel_styles[] = 'crafto-star-rating-rtl';
					$testimonial_carousel_styles[] = 'crafto-testimonial-carousel-rtl';
				}
				$testimonial_carousel_styles[] = 'crafto-slider-widget';
				$testimonial_carousel_styles[] = 'crafto-star-rating';
				$testimonial_carousel_styles[] = 'crafto-testimonial-carousel';
			}
			return $testimonial_carousel_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-testimonial-carousel';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Testimonial Carousel', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/testimonial-carousel/';
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
				'slider',
				'review',
				'author',
				'feedback',
				'user',
			];
		}

		/**
		 * Register testimonial carousel widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_testimonial_carousel_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_layout_type',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'testimonial-carousel-style-1',
					'options'            => [
						'testimonial-carousel-style-1'  => esc_html__( 'Style 1', 'crafto-addons' ),
						'testimonial-carousel-style-2'  => esc_html__( 'Style 2', 'crafto-addons' ),
						'testimonial-carousel-style-3'  => esc_html__( 'Style 3', 'crafto-addons' ),
						'testimonial-carousel-style-4'  => esc_html__( 'Style 4', 'crafto-addons' ),
						'testimonial-carousel-style-5'  => esc_html__( 'Style 5', 'crafto-addons' ),
						'testimonial-carousel-style-6'  => esc_html__( 'Style 6', 'crafto-addons' ),
						'testimonial-carousel-style-7'  => esc_html__( 'Style 7', 'crafto-addons' ),
						'testimonial-carousel-style-8'  => esc_html__( 'Style 8', 'crafto-addons' ),
						'testimonial-carousel-style-9'  => esc_html__( 'Style 9', 'crafto-addons' ),
						'testimonial-carousel-style-10' => esc_html__( 'Style 10', 'crafto-addons' ),
						'testimonial-carousel-style-11' => esc_html__( 'Style 11', 'crafto-addons' ),
						'testimonial-carousel-style-12' => esc_html__( 'Style 12', 'crafto-addons' ),
						'testimonial-carousel-style-13' => esc_html__( 'Style 13', 'crafto-addons' ),
						'testimonial-carousel-style-14' => esc_html__( 'Style 14', 'crafto-addons' ),
						'testimonial-carousel-style-15' => esc_html__( 'Style 15', 'crafto-addons' ),
						'testimonial-carousel-style-16' => esc_html__( 'Style 16', 'crafto-addons' ),
						'testimonial-carousel-style-17' => esc_html__( 'Style 17', 'crafto-addons' ),
						'testimonial-carousel-style-18' => esc_html__( 'Style 18', 'crafto-addons' ),
					],
					'render_type'        => 'template',
					'prefix_class'       => 'el-',
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'crafto_testimonial_carousel_heading',
				[
					'label'       => esc_html__( 'Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write heading here', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_control(
				'testimonial_carousel_heading_description',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<div style ="font-style:normal">To add the highlighted text use shortcode like:<br/><br/> <span style="font-weight:bold">[crafto_highlight]</span> Your Text <span style="font-weight:bold">[/crafto_highlight]</span></div>', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition'       => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
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
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_subheading',
				[
					'label'       => esc_html__( 'Subheading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write subheading here', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => '4.80',
					'condition'   => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-18',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_star_rating',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'dynamic'   => [
						'active' => true,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.5,
						],
					],
					'default'   => [
						'size' => 4,
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-18',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_slide_content',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::WYSIWYG,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Lorem ipsum is simply dummy text of the printing and typesetting industry.', 'crafto-addons' ),
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_testimonial_carousel_content_section',
				[
					'label' => esc_html__( 'Slides', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs(
				'crafto_testimonial_carousel_tabs'
			);
			$repeater->start_controls_tab(
				'crafto_testimonial_carousel_image_tab',
				[
					'label' => esc_html__( 'Avatar', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_image',
				[
					'label'   => esc_html__( 'Avatar', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_testimonial_carousel_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write Title Here...', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_content',
				[
					'label'   => esc_html__( 'Content', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo. Sed do eiusmod tem', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_testimonial_highlight_description',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<div style ="font-style:normal">To add the highlighted text use shortcode like:<br/><br/> <span style="font-weight:bold">[crafto_highlight]</span> Your Text <span style="font-weight:bold">[/crafto_highlight]</span></div>', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_name',
				[
					'label'       => esc_html__( 'Name', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'John Doe', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_position',
				[
					'label'       => esc_html__( 'Position', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'description' => esc_html__( 'Not applicable in style 13 and style 15.', 'crafto-addons' ),
					'label_block' => true,
					'default'     => esc_html__( 'Designer', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_date',
				[
					'label'       => esc_html__( 'Date', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '25-05-2050',
					'description' => esc_html__( 'Applicable in style 4 only.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_rating_star',
				[
					'label'   => esc_html__( 'Rating', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'dynamic' => [
						'active' => true,
					],
					'range'   => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.5,
						],
					],
					'default' => [
						'size' => 4,
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_testimonial_carousel_icon_tab',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_testimonial_carousel_use_image',
				[
					'label'       => esc_html__( 'Image', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Applicable in style 5, style 8 and style 11 only.', 'crafto-addons' ),
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'crafto_testimonial_carousel',
				[
					'label'   => esc_html__( 'Carousel Items', 'crafto-addons' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => [
						[
							'crafto_testimonial_carousel_image'    => Utils::get_placeholder_image_src(),
							'crafto_testimonial_carousel_content'  => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua lorem ipsum dolor sit amet.', 'crafto-addons' ),
							'crafto_testimonial_carousel_name'     => esc_html__( 'Lindsay Swanson', 'crafto-addons' ),
							'crafto_testimonial_carousel_position' => esc_html__( 'Creative Director', 'crafto-addons' ),
						],
						[
							'crafto_testimonial_carousel_image'    => Utils::get_placeholder_image_src(),
							'crafto_testimonial_carousel_content'  => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua lorem ipsum dolor sit amet.', 'crafto-addons' ),
							'crafto_testimonial_carousel_name'     => esc_html__( 'Bryan Johnson', 'crafto-addons' ),
							'crafto_testimonial_carousel_position' => esc_html__( 'HR Manager', 'crafto-addons' ),
						],
						[
							'crafto_testimonial_carousel_image'    => Utils::get_placeholder_image_src(),
							'crafto_testimonial_carousel_content'  => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua lorem ipsum dolor sit amet.', 'crafto-addons' ),
							'crafto_testimonial_carousel_name'     => esc_html__( 'Matthew Taylor', 'crafto-addons' ),
							'crafto_testimonial_carousel_position' => esc_html__( 'Office Manager', 'crafto-addons' ),
						],
						[
							'crafto_testimonial_carousel_image'    => Utils::get_placeholder_image_src(),
							'crafto_testimonial_carousel_content'  => esc_html__( 'Lorem ipsum dolor sit amet consectetur adipiscing elit, do eiusmod tempor incididunt ut labore et dolore magna aliqua lorem ipsum dolor sit amet.', 'crafto-addons' ),
							'crafto_testimonial_carousel_name'     => esc_html__( 'Shoko mugikura', 'crafto-addons' ),
							'crafto_testimonial_carousel_position' => esc_html__( 'Sales Manager', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_testimonial_carousel_content',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
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
			$this->add_control(
				'crafto_carousel_enable_icon',
				[
					'label'        => esc_html__( 'Enable Rating', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_star_style',
				[
					'label'        => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'star_fontawesome' => esc_html__( 'Font Awesome', 'crafto-addons' ),
						'star_unicode'     => esc_html__( 'Unicode', 'crafto-addons' ),
						'star_bootstrap'   => esc_html__( 'Bootstrap', 'crafto-addons' ),
					],
					'default'      => 'star_bootstrap',
					'render_type'  => 'template',
					'prefix_class' => 'elementor--star-style-',
					'condition'    => [
						'crafto_carousel_enable_icon' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_unmarked_star_style',
				[
					'label'        => esc_html__( 'Unmarked Style', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'solid'   => [
							'title' => esc_html__( 'Solid', 'crafto-addons' ),
							'icon'  => 'eicon-star',
						],
						'outline' => [
							'title' => esc_html__( 'Outline', 'crafto-addons' ),
							'icon'  => 'eicon-star-o',
						],
					],
					'prefix_class' => 'elementor-star-',
					'default'      => 'solid',
					'condition'    => [
						'crafto_carousel_enable_icon' => 'yes',
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-16',
						],
					],
				]
			);
			$this->add_control(
				'crafto_carousel_image_floating_effects_show',
				[
					'label'              => esc_html__( 'Enable Image Floating Effect', 'crafto-addons' ),
					'type'               => Controls_Manager::SWITCHER,
					'default'            => '',
					'return_value'       => 'yes',
					'frontend_available' => true,
					'condition'          => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-5',
					],
				]
			);
			$this->add_control(
				'crafto_image_float_delay',
				[
					'label'       => esc_html__( 'Float Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'unit' => 's',
						'size' => 0.5,
					],
					'render_type' => 'template',
					'selectors'   => [
						'{{WRAPPER}} .animation-float' => '--float-delay: {{VALUE}}{{UNIT}}',
					],
					'condition'   => [
						'crafto_carousel_image_floating_effects_show' => 'yes',
					],
				]
			);

			$duration_label = sprintf( '%s %s',  esc_html__( 'Float Duration', 'crafto-addons' ), '<small>(ms)</small>' ); // phpcs:ignore

			$this->add_control(
				'crafto_image_float_duration',
				[
					'label'       => $duration_label,
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 2,
						'unit' => 's',
					],
					'render_type' => 'template',
					'selectors'   => [
						'{{WRAPPER}} .animation-float' => '--float-duration: {{SIZE}}{{UNIT}}',
					],
					'condition'   => [
						'crafto_carousel_image_floating_effects_show' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_image_float_easing',
				[
					'label'     => esc_html__( 'Float Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'linear',
					'options'   => [
						'linear'      => esc_html__( 'linear', 'crafto-addons' ),
						'ease'        => esc_html__( 'ease', 'crafto-addons' ),
						'ease-in'     => esc_html__( 'easeIn', 'crafto-addons' ),
						'ease-out'    => esc_html__( 'easeOut', 'crafto-addons' ),
						'ease-in-out' => esc_html__( 'easeInOut', 'crafto-addons' ),
						'custom_ease' => esc_html__( 'Custom ease', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .animation-float' => '--float-animation-ease: {{VALUE}}',
					],
					'condition' => [
						'crafto_carousel_image_floating_effects_show' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_image_float_custom_ease',
				[
					'label'     => esc_html__( 'Custom Float Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .animation-float' => '--float-animation-ease: {{VALUE}}',
					],
					'condition' => [
						'crafto_image_float_easing' => 'custom_ease',
						'crafto_carousel_image_floating_effects_show' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_testimonial_carousel_settings_section',
				[
					'label' => esc_html__( 'Carousel Settings', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_slides_to_show',
				[
					'label'     => esc_html__( 'Slides Per View', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 3,
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 5,
							'step' => 1,
						],
					],
					'condition' => [
						'crafto_effect' => 'slide',
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
						'crafto_effect'                => 'slide',
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
					'label'     => esc_html__( 'Autoplay Speed', 'crafto-addons' ),
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
				'crafto_centered_slides',
				[
					'label'        => esc_html__( 'Enable Center Slide', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-10',
					],
				]
			);
			$this->add_control(
				'crafto_coverflow_effect_slides',
				[
					'label'        => esc_html__( 'Enable Coverflow Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'condition'    => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-10',
					],
				]
			);
			$this->add_control(
				'crafto_autoheight',
				[
					'label'        => esc_html__( 'Enable Auto Height', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_minheight',
				[
					'label'        => esc_html__( 'Enable Equal Height', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'no',
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
						'slide' => esc_html__( 'Slide', 'crafto-addons' ),
						'fade'  => esc_html__( 'Fade', 'crafto-addons' ),
						'flip'  => esc_html__( 'Flip', 'crafto-addons' ),
						'cube'  => esc_html__( 'Cube', 'crafto-addons' ),
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
						'none'  => esc_html__( 'None', 'crafto-addons' ),
						'both'  => esc_html__( 'Both Side', 'crafto-addons' ),
						'left'  => esc_html__( 'Left Side', 'crafto-addons' ),
						'right' => esc_html__( 'Right Side', 'crafto-addons' ),
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
						'value'   => 'fa-solid fa-angle-left',
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
						'value'   => 'fa-solid fa-angle-right',
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
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-2',
							'testimonial-carousel-style-5',
							'testimonial-carousel-style-7',
							'testimonial-carousel-style-9',
							'testimonial-carousel-style-10',
							'testimonial-carousel-style-11',
							'testimonial-carousel-style-12',
							'testimonial-carousel-style-14',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_control(
				'crafto_navigation_h_align',
				[
					'label'     => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'left',
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
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-1',
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
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-14',
					],
				]
			);
			$this->add_control(
				'crafto_navigation_prev_text',
				[
					'label'       => esc_html__( 'Prev Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Prev', 'crafto-addons' ),
					'condition'   => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-14',
					],
				]
			);
			$this->add_control(
				'crafto_navigation_next_text',
				[
					'label'       => esc_html__( 'Next Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Next', 'crafto-addons' ),
					'condition'   => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-14',
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
					'label'       => esc_html__( 'Pagination Type', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'dots',
					'options'     => [
						'dots'   => esc_html__( 'Dots', 'crafto-addons' ),
						'number' => esc_html__( 'Numbers', 'crafto-addons' ),
						'thumb'  => esc_html__( 'Thumb', 'crafto-addons' ),
					],
					'description' => esc_html__( 'Thumb style is applicable for style 11 only.', 'crafto-addons' ),
					'condition'   => [
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
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => [
							'dots',
							'number',
						],
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
						'crafto_pagination_style'     => [
							'dots',
							'number',
						],
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
						'crafto_pagination_style'     => [
							'dots',
							'number',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_testimonial_carousel_genaral_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_aligment',
				[
					'label'       => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options'     => [
						'start'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors'   => [
						'{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-11, .testimonial-carousel-style-17) .testimonials-wrapper, {{WRAPPER}} .testimonial-carousel-style-11 .carousel-content-wrap, {{WRAPPER}} .testimonial-carousel-style-13 .testimonials-wrapper .testimonial-name-icon, {{WRAPPER}} .testimonial-carousel-style-15 .testimonials-wrapper .testimonial-name-icon, {{WRAPPER}} .testimonial-carousel-style-17 .testimonials-wrapper .carousel-content-wrap' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
					],
					'condition'   => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-5',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-7',
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-9',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_testimonial_carousel_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .testimonials-wrapper',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_testimonial_carousel_shadow',
					'selector'  => '{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-10) .testimonials-wrapper, {{WRAPPER}} .testimonial-carousel-style-10 .swiper-slide.swiper-slide-active',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_testimonial_carousel_border',
					'selector'  => '{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-10) .testimonials-wrapper, {{WRAPPER}} .testimonial-carousel-style-10 .swiper-slide',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-10) .testimonials-wrapper, {{WRAPPER}} .testimonial-carousel-style-10 .swiper-slide, {{WRAPPER}} .testimonial-carousel-style-10 .testimonials-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_padding',
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
						'{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-17, .testimonial-carousel-style-7, .testimonial-carousel-style-8) .testimonials-wrapper, {{WRAPPER}} .testimonial-carousel-style-17 .carousel-content-wrap, {{WRAPPER}} .testimonial-carousel-style-7 .content-box, {{WRAPPER}}.el-testimonial-carousel-style-8 .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_swiper_carousel_bottom_container',
				[
					'label'     => esc_html__( 'Metadata Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-7',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_swiper_bottom_container',
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
						'{{WRAPPER}} .testimonial-carousel-style-7 .testimonial-name-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-7',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_swiper_carousel_heading',
				[
					'label'     => esc_html__( 'Carousel Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-1',
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_swiper_offset',
				[
					'label'      => esc_html__( 'Offset', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'vw',
						'custom',
					],
					'range'      =>
					[
						'px' => [
							'max'  => 100,
							'min'  => -100,
							'step' => 1,
						],
						'vw' => [
							'max'  => 50,
							'min'  => -50,
							'step' => 1,
						],
						'%'  => [
							'max'  => 1,
							'min'  => 100,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-carousel-wrap .testimonial-carousel-style-4' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .testimonials-carousel-wrap .testimonial-carousel-style-4' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-4',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_slider_box_min_width',
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
						'{{WRAPPER}} .testimonials-carousel-wrap' => 'min-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_swiper_carousel_padding',
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
						'{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-7, .testimonial-carousel-style-11 ).swiper, {{WRAPPER}} .testimonial-carousel-style-7 .swiper-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-1',
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_swiper_slide',
				[
					'label'     => esc_html__( 'Swiper Slide', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-16',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_testimonial_swiper_tabs'
			);
			$this->start_controls_tab(
				'crafto_normal_testimonial_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-16',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_swiper_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      =>
					[
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-style-16 .swiper-slide' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-16',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_testimonial_hover_style',
				[
					'label'     => esc_html__( 'Active', 'crafto-addons' ),
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-16',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_swiper_active_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      =>
					[
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-style-16 .swiper-slide-active' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-16',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_testimonial_carousel_title_box_heading',
				[
					'label'     => esc_html__( 'Heading Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_title_box_aligment',
				[
					'label'       => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options'     => [
						'start'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors'   => [
						'{{WRAPPER}} .carousel-title-box' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
					],
					'condition'   => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_title_width',
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
						'{{WRAPPER}} .carousel-title-box' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_title_padding',
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
						'{{WRAPPER}} .carousel-title-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_name_icon',
				[
					'label'     => esc_html__( 'Author Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-8',
					],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_separator_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-name-icon' => 'border-left-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-8',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_marquee_separator_spacing',
				[
					'label'      => esc_html__( 'Separator Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-name-icon' => 'border-left-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-8',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_general_width',
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
						'{{WRAPPER}} .swiper.testimonial-carousel-style-8' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-8',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_heading_style_section',
				[
					'label'     => esc_html__( 'Heading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_heading_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .heading',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_heading_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .heading' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_heading_width',
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
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_heading_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
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
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_heading_separator_style',
				[
					'label'     => esc_html__( 'Highlight', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_heading_separator_colors',
					'selector'       => '{{WRAPPER}} .heading .separator',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_heading_separator_weight',
				[
					'label'     => esc_html__( 'Weight', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''       => esc_html__( 'Default', 'crafto-addons' ),
						'100'    => esc_html__( '100', 'crafto-addons' ),
						'200'    => esc_html__( '200', 'crafto-addons' ),
						'300'    => esc_html__( '300', 'crafto-addons' ),
						'400'    => esc_html__( '400', 'crafto-addons' ),
						'500'    => esc_html__( '500', 'crafto-addons' ),
						'600'    => esc_html__( '600', 'crafto-addons' ),
						'700'    => esc_html__( '700', 'crafto-addons' ),
						'800'    => esc_html__( '800', 'crafto-addons' ),
						'900'    => esc_html__( '900', 'crafto-addons' ),
						'normal' => esc_html__( 'Normal', 'crafto-addons' ),
						'bold'   => esc_html__( 'Bold', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .heading .separator' => 'font-weight: {{VALUE}};',
					],
				],
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_testimonial_highlighted_border',
					'selector' => '{{WRAPPER}} .heading .separator',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_testimonial_carousel_subheading_style_section',
				[
					'label'     => esc_html__( 'Subheading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_subheading_typography',
					'selector' => '{{WRAPPER}} .subheading',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_testimonial_carousel_subheading_color',
					'selector'       => '{{WRAPPER}} .subheading',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_subheading_background',
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
				'crafto_testimonial_carousel_subheading_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
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
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .subheading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-18',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_subheading_border',
					'selector'  => '{{WRAPPER}} .subheading',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-18',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_subheading_border_radius',
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
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-18',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_subheading_padding',
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
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-18',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_description_style',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-18',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_description_typography',
					'selector' => '{{WRAPPER}} .carousel-content-box',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .carousel-content-box' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_description_width',
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
							'max' => 200,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .carousel-content-box' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_carousel_over_all_rating',
				[
					'label'     => esc_html__( 'Overall Rating', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-18',
					],
				]
			);
			$this->add_control(
				'crafto_over_all_rating_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon i:not(.elementor-star-empty):before' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_over_all_rating_unmarked_color',
				[
					'label'     => esc_html__( 'Unmarked Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon i:after, {{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon i.elementor-star-empty:before, {{WRAPPER}}.elementor--star-style-star_unicode .testimonial-carousel-rating-box .elementor-star-rating i' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_over_all_rating_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon',
				]
			);
			$this->add_control(
				'crafto_testimonial_over_all_rating_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 30,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_testimonial_over_all_rating_border',
					'selector' => '{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon',
				]
			);
			$this->add_responsive_control(
				'crafto_review_testimonial_over_all_rating_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_over_all_rating_padding',
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
						'{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_over_all_rating_space',
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
						'{{WRAPPER}} .testimonial-carousel-rating-box .review-star-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_number_style_section',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .testimonial-carousel-number',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-carousel-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_number_margin',
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
						'{{WRAPPER}} .testimonial-carousel-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_overall_rating_subheading',
				[
					'label'     => esc_html__( 'Subheading', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_overall_rating_subheading_typography',
					'selector' => '{{WRAPPER}} .subheading',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_testimonial_overall_rating_subheading_color',
					'selector'       => '{{WRAPPER}} .subheading',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_image_style_section',
				[
					'label'     => esc_html__( 'Avatar', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-11',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_aligment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => '',
					'options'              => [
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
						'{{WRAPPER}} .testimonials-carousel-image-box' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-5',
					],
				]
			);
			$this->add_control(
				'crafto_bg_image_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
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
						'{{WRAPPER}} .testimonials-carousel-image-box' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);
			$this->add_control(
				'crafto_bg_img_position',
				[
					'label'     => esc_html__( 'Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''              => esc_html__( 'Default', 'crafto-addons' ),
						'center center' => esc_html__( 'Center Center', 'crafto-addons' ),
						'center left'   => esc_html__( 'Center Left', 'crafto-addons' ),
						'center right'  => esc_html__( 'Center Right', 'crafto-addons' ),
						'top center'    => esc_html__( 'Top Center', 'crafto-addons' ),
						'top left'      => esc_html__( 'Top Left', 'crafto-addons' ),
						'top right'     => esc_html__( 'Top Right', 'crafto-addons' ),
						'bottom center' => esc_html__( 'Bottom Center', 'crafto-addons' ),
						'bottom left'   => esc_html__( 'Bottom Left', 'crafto-addons' ),
						'bottom right'  => esc_html__( 'Bottom Right', 'crafto-addons' ),
						'initial'       => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .testimonials-carousel-image-box' => 'background-position: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_bg_img_xpos',
				[
					'label'      => esc_html__( 'X Position', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'default'    => [
						'size' => 0,
					],
					'range'      => [
						'px' => [
							'min' => -800,
							'max' => 800,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%'  => [
							'min' => -100,
							'max' => 100,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-carousel-image-box' => 'background-position-x: {{SIZE}}{{UNIT}} {{crafto_bg_img_xpos.SIZE}}{{crafto_bg_img_xpos.UNIT}}',
					],
					'condition'  => [
						'crafto_bg_img_position' => 'initial',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_bg_img_ypos',
				[
					'label'      => esc_html__( 'Y Position', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'default'    => [
						'size' => 0,
					],
					'range'      => [
						'px' => [
							'min' => -800,
							'max' => 800,
						],
						'em' => [
							'min' => -100,
							'max' => 100,
						],
						'%'  => [
							'min' => -100,
							'max' => 100,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}' => 'background-position-y: {{crafto_bg_img_ypos.SIZE}}{{crafto_bg_img_ypos.UNIT}} {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_bg_img_position' => 'initial',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);

			$this->add_control(
				'crafto_bg_img_attachment',
				[
					'label'     => esc_html_x( 'Attachment', 'Background Control', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''       => esc_html__( 'Default', 'crafto-addons' ),
						'scroll' => esc_html_x( 'Scroll', 'Background Control', 'crafto-addons' ),
						'fixed'  => esc_html_x( 'Fixed', 'Background Control', 'crafto-addons' ),
					],
					'selectors' => [
						'(desktop+){{WRAPPER}} .testimonials-carousel-image-box' => 'background-attachment: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);
			$this->add_control(
				'crafto_bg_img_attachment_alert',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-control-field-description',
					'raw'             => esc_html__( 'Note: Attachment Fixed works only on desktop.', 'crafto-addons' ),
					'separator'       => 'none',
					'condition'       => [
						'crafto_bg_img_attachment' => 'fixed',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_bg_img_repeat',
				[
					'label'     => esc_html_x( 'Repeat', 'Background Control', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''          => esc_html__( 'Default', 'crafto-addons' ),
						'no-repeat' => esc_html__( 'No-repeat', 'crafto-addons' ),
						'repeat'    => esc_html__( 'Repeat', 'crafto-addons' ),
						'repeat-x'  => esc_html__( 'Repeat-x', 'crafto-addons' ),
						'repeat-y'  => esc_html__( 'Repeat-y', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .testimonials-carousel-image-box' => 'background-repeat: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_bg_img_size',
				[
					'label'     => esc_html__( 'Display Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''        => esc_html__( 'Default', 'crafto-addons' ),
						'auto'    => esc_html__( 'Auto', 'crafto-addons' ),
						'cover'   => esc_html__( 'Cover', 'crafto-addons' ),
						'contain' => esc_html__( 'Contain', 'crafto-addons' ),
						'initial' => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .cover-background' => 'background-size: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-17',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 175,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-carousel-image-box img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-5',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_width',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
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
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-carousel-image-box img' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-5',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_width_size',
				[
					'label'      => esc_html__( 'Image Container Width', 'crafto-addons' ),
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
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-carousel-image-box' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-5',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_testimonial_carousel_image_border',
					'selector'  => '{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-5) .testimonials-carousel-image-box, {{WRAPPER}} .testimonial-carousel-style-5 .testimonials-carousel-image-box img',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-17',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-carousel-image-box, {{WRAPPER}} .testimonials-carousel-image-box img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-17',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_right_spacing',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-8) .testimonials-carousel-image-box, {{WRAPPER}} .testimonial-carousel-style-8 .testimonials-carousel-image-warp' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-10',
							'testimonial-carousel-style-12',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_testimonial_carousel_image_box_shadow',
					'selector'  => '{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-5) .testimonials-carousel-image-box, {{WRAPPER}} .testimonial-carousel-style-5 .testimonials-carousel-image-box img',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-17',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_title_style_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .testimonial-carousel-title',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-carousel-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_title_box_width',
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
						'{{WRAPPER}} .testimonial-carousel-title' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_title_box_margin',
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
						'{{WRAPPER}} .testimonial-carousel-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_name_style_section',
				[
					'label' => esc_html__( 'Name', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_name_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .testimonial-carousel-name',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_testimonial_carousel_name_color',
					'selector'       => '{{WRAPPER}} .testimonial-carousel-name',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_position_style_section',
				[
					'label'     => esc_html__( 'Position', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_position_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .testimonial-carousel-position',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_testimonial_carousel_position_color',
					'selector'       => '{{WRAPPER}} .testimonial-carousel-position',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_content_style_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_content_typography',
					'selector' => '{{WRAPPER}} .testimonial-carousel-content',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-carousel-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_testimonial_content_border',
					'selector'  => '{{WRAPPER}} .content-box',
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-7',
							'testimonial-carousel-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_content_size',
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
							'max' => 200,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_content_margin',
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
						'{{WRAPPER}} .testimonial-carousel-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_highlighted_content_style',
				[
					'label'     => esc_html__( 'Highlight', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_highlighted_content_typography',
					'selector' => '{{WRAPPER}} .content-highlights',
				]
			);
			$this->add_control(
				'crafto_highlighted_content_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-highlights' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_highlighted_border',
					'selector' => '{{WRAPPER}} .content-highlights',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_testimonial_icon',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_enable_icon' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-review i:not(.elementor-star-empty):before, {{WRAPPER}} .rating-icon-singular .elementor-star-rating i:before' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_review_stars_unmarked_color',
				[
					'label'     => esc_html__( 'Unmarked Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-review i:after, {{WRAPPER}} .testimonial-review i.elementor-star-empty:before, {{WRAPPER}}.elementor--star-style-star_unicode .testimonial-review i' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-16',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_review_stars_bg_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .testimonial-review, {{WRAPPER}} .rating-icon-singular',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-9',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-16',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 30,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-review i, {{WRAPPER}} .rating-icon-singular i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_testimonial_icon_border',
					'selector'  => '{{WRAPPER}} .rating-icon-singular',
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-16',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_review_testimonial_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-review, {{WRAPPER}} .rating-icon-singular' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-9',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-16',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_review_testimonial_carousel_padding',
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
						'{{WRAPPER}} .testimonial-review, {{WRAPPER}} .rating-icon-singular' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-9',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-16',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_icon_space',
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
						'{{WRAPPER}} .testimonial-carousel:not(.testimonial-carousel-style-9) .testimonial-review i, {{WRAPPER}} .rating-icon-singular i, {{WRAPPER}} .testimonial-carousel-style-9 .testimonial-review' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_number_rating_heading',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-16',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_testimonial_number_rating_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .rating-icon-singular, {{WRAPPER}} .star-rating-number',
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-16',
						],
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_testimonial_number_rating_color',
					'selector'       => '{{WRAPPER}} .star-rating-number, {{WRAPPER}} .rating-icon-singular',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-16',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_testimonial_date',
				[
					'label'     => esc_html__( 'Date', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-4',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_date_typography',
					'selector' => '{{WRAPPER}} .review-date',
				]
			);
			$this->add_control(
				'crafto_testimonial_carousel_date_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .review-date' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_datebox_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .review-date',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_testimonial_carousel_date_border',
					'selector' => '{{WRAPPER}} .review-date',
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_date_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .review-date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_date_padding',
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
						'{{WRAPPER}} .review-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_carousel_icon_style_section',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-5',
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_icon_width_size',
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
							'max' => 200,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-style-8 .testimonials-carousel-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .testimonial-carousel-style-11 .testimonials-rounded-icon img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .testimonial-carousel-style-5 .testimonials-carousel-icon-box img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_icon_height_size',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
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
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-style-5 .testimonials-carousel-icon-box img' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_icon_right_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-carousel-style-11 .testimonials-rounded-icon, {{WRAPPER}} .testimonial-carousel-style-5 .testimonials-carousel-icon-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_image_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} testimonial-carousel-style-8 .testimonials-carousel-icon-box, {{WRAPPER}} .testimonial-carousel-style-11 .testimonials-rounded-icon img'     => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_testimonial_carousel_image_icon_box_shadow',
					'selector'  => '{{WRAPPER}} .testimonials-carousel-icon-box',
					'condition' => [
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-5',
						],
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
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_testimonial_showtext_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .swiper .slider-custom-text-prev, {{WRAPPER}} .swiper .slider-custom-text-next',
					'condition' => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-14',
						],
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
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-2',
							'testimonial-carousel-style-5',
							'testimonial-carousel-style-7',
							'testimonial-carousel-style-9',
							'testimonial-carousel-style-10',
							'testimonial-carousel-style-11',
							'testimonial-carousel-style-12',
							'testimonial-carousel-style-14',
							'testimonial-carousel-style-17',
						],
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
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-2',
							'testimonial-carousel-style-5',
							'testimonial-carousel-style-7',
							'testimonial-carousel-style-9',
							'testimonial-carousel-style-10',
							'testimonial-carousel-style-11',
							'testimonial-carousel-style-12',
							'testimonial-carousel-style-14',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_arrows_nav_position',
				[
					'label'      => esc_html__( 'Navigation Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-element .elementor-swiper-button' => 'top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type!' => [
							'testimonial-carousel-style-1',
							'testimonial-carousel-style-2',
							'testimonial-carousel-style-5',
							'testimonial-carousel-style-7',
							'testimonial-carousel-style-8',
							'testimonial-carousel-style-9',
							'testimonial-carousel-style-10',
							'testimonial-carousel-style-11',
							'testimonial-carousel-style-12',
							'testimonial-carousel-style-14',
							'testimonial-carousel-style-16',
							'testimonial-carousel-style-17',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_arrows_nav_bottom',
				[
					'label'      => esc_html__( 'Navigation Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-element .swiper' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					],
					'default'    => [
						'unit' => 'px',
						'size' => 60,
					],
					'condition'  => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-1',
							'testimonial-carousel-style-16',
						],
					],
				]
			);
			$this->add_responsive_control(
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
						'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}}.elementor-pagination-position-outside .elementor-swiper-button.elementor-swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-element .swiper .elementor-swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-8',
					],
				]
			);
			$this->add_control(
				'crafto_arrows_left',
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
						'{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next, {{WRAPPER}}.elementor-pagination-position-outside .elementor-swiper-button.elementor-swiper-button-next' => 'left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, .rtl {{WRAPPER}}.elementor-pagination-position-outside .elementor-swiper-button.elementor-swiper-button-prev' => 'right: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-3',
							'testimonial-carousel-style-4',
							'testimonial-carousel-style-6',
							'testimonial-carousel-style-13',
							'testimonial-carousel-style-15',
							'testimonial-carousel-style-16',
							'testimonial-carousel-style-18',
						],
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
						'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-14',
					],
					'default'   => [
						'unit' => 'px',
						'size' => 45,
					],
				]
			);
			$this->add_control(
				'crafto_showtext_box_size',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-crafto-testimonial-carousel .swiper.nav-icon-circle.testimonial-carousel-style-14 .elementor-swiper-button' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_navigation' => 'yes',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-14',
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
					'default'   => [
						'unit' => 'px',
						'size' => 16,
					],
					'selectors' => [
						'{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev i, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-widget-container .elementor-swiper-button.elementor-swiper-button-prev svg, {{WRAPPER}} .elementor-widget-container .elementor-swiper-button.elementor-swiper-button-next svg' => 'width: {{SIZE}}{{UNIT}}; height: auto',
					],
					'condition' => [
						'crafto_navigation' => 'yes',
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
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
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
						'selector'  => '{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next',
						'condition' => [
							'crafto_navigation' => 'yes',
							'crafto_arrows_icon_shape_style!' => '',
							'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-14',
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
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
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
							'crafto_testimonial_carousel_layout_type!' => 'testimonial-carousel-style-14',
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
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => [
							'dots',
							'number',
						],
					],
				]
			);
			$this->add_control(
				'crafto_dots_spacing',
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
						'{{WRAPPER}}.elementor-pagination-position-outside .swiper' => 'padding-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'crafto_pagination'           => 'yes',
						'crafto_dots_position'        => 'outside',
						'crafto_pagination_direction' => 'horizontal',
						'crafto_pagination_style'     => [
							'dots',
							'number',
						],
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
					],
					'condition' => [
						'crafto_pagination'           => 'yes',
						'crafto_dots_position'        => 'inside',
						'crafto_pagination_style'     => [
							'dots',
							'number',
						],
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
						'crafto_pagination_style'     => [
							'dots',
							'number',
						],
						'crafto_pagination_direction' => 'vertical',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_dots_direction_horizontal',
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
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_direction'     => 'horizontal',
						'crafto_pagination_style'         => [
							'dots',
							'number',
						],
						'crafto_pagination_number_style!' => 'number-style-3',

					],
				]
			);
			$this->add_responsive_control(
				'crafto_dots_direction_vertical',
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
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-left .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_direction'     => 'vertical',
						'crafto_pagination_style'         => [
							'dots',
							'number',
						],
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
						'crafto_pagination_style!'        => 'thumb',
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
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => [
							'dots',
							'number',
						],
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
						'crafto_pagination'        => 'yes',
						'crafto_pagination_style!' => [
							'dots',
							'thumb',
						],

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
					'default'   => [
						'size' => 12,
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'        => 'yes',
						'crafto_pagination_style!' => [
							'number',
							'thumb',
						],
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
					'default'   => [
						'size' => 45,
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination.swiper-numbers .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_pagination'              => 'yes',
						'crafto_pagination_style!'       => [
							'dots',
							'thumb',
						],
						'crafto_pagination_number_style' => 'number-style-1',
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
						'crafto_pagination'        => 'yes',
						'crafto_pagination_style!' => [
							'dots',
							'thumb',
						],
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
						'crafto_pagination_style!'       => [
							'thumb',
							'dots',
						],
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
						'crafto_pagination_style!' => [
							'number',
							'thumb',
						],
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
						'crafto_pagination_style!'       => [
							'dots',
							'thumb',
						],
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
						'crafto_pagination_style!'        => [
							'dots',
							'thumb',
						],
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
						'crafto_pagination_style!'       => [
							'thumb',
							'dots',
						],
						'crafto_pagination_number_style' => [
							'number-style-2',
							'number-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_active_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper.dots-style-2 .swiper-pagination-bullet.swiper-pagination-bullet-active:before, {{WRAPPER}} .swiper.dots-style-2 .swiper-pagination-bullet:hover:before' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'            => 'yes',
						'crafto_pagination_dots_style' => 'dots-style-2',
						'crafto_pagination_style!'     => [
							'number',
							'thumb',
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
						'crafto_pagination_style'      => [
							'dots',
							'number',
							'thumb',
						],
					],
				]
			);
			$this->add_control(
				'crafto_dots_active_border',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_style'         => [
							'dots',
							'number',
						],
						'crafto_pagination_dots_style!'   => 'dots-style-2',
						'crafto_pagination_number_style!' => [
							'number-style-2',
							'number-style-3',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_thumb_spacing',
				[
					'label'     => esc_html__( 'Pagination Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'default'   => [
						'size' => 100,
					],
					'selectors' => [
						'{{WRAPPER}}.el-testimonial-carousel-style-11 .swiper' => 'padding-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => [
							'thumb',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_thumb_direction_horizontal',
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
						'{{WRAPPER}} .slider-custom-image-pagination > span' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'thumb',
						'crafto_testimonial_carousel_layout_type' => [
							'testimonial-carousel-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_thumb_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
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
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 50,
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-custom-image-pagination > span' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'thumb',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-11',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_testimonial_carousel_thumb_border',
					'selector'  => '{{WRAPPER}} .slider-custom-image-pagination > span',
					'condition' => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'thumb',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-11',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_carousel_thumb_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-custom-image-pagination > span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination'       => 'yes',
						'crafto_pagination_style' => 'thumb',
						'crafto_testimonial_carousel_layout_type' => 'testimonial-carousel-style-11',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render testimonial carousel widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings = $this->get_settings_for_display();

			if ( empty( $settings['crafto_testimonial_carousel'] ) ) {
				return;
			}

			$slides              = [];
			$layout_type         = $this->get_settings( 'crafto_testimonial_carousel_layout_type' );
			$enable_float_effect = $this->get_settings( 'crafto_carousel_image_floating_effects_show' );

			switch ( $layout_type ) {
				case 'testimonial-carousel-style-1':
				case 'testimonial-carousel-style-2':
				case 'testimonial-carousel-style-3':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( 'testimonial-carousel-style-2' === $layout_type ) {
										$this->get_rating_icon( $item );
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$this->get_testimonial_carousel_content( $item );
									?>
									<div class="content-box">
										<?php
										if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
											?>
											<div class="testimonials-carousel-image-box">
												<?php $this->get_testimonial_carousel_image( $item ); ?>
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) ) {
											?>
											<div class="testimonial-name-icon">
												<?php
												$this->get_testimonial_carousel_name( $item );
												$this->get_testimonial_carousel_position( $item );
												if ( 'testimonial-carousel-style-1' === $layout_type || 'testimonial-carousel-style-3' === $layout_type ) {
													$this->get_rating_icon( $item );
												}
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
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-4':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_date'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) ) {
										?>
										<div class="content-box">
											<?php
											if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
												?>
												<div class="testimonials-carousel-image-box">
													<?php $this->get_testimonial_carousel_image( $item ); ?>
												</div>
												<?php
											}
											if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) ) {
												?>
												<div class="testimonial-name-icon">
													<?php
													$this->get_testimonial_carousel_name( $item );
													$this->get_testimonial_carousel_position( $item );
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title alt-font">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$this->get_testimonial_carousel_content( $item );
									if ( ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_date'] ) ) {
										?>
										<div class="testimonial-carousel-footer">
											<?php $this->get_rating_icon( $item );
											if ( ! empty( $item['crafto_testimonial_carousel_date'] ) ) {
												?>
												<div class="review-date">
													<?php echo $item['crafto_testimonial_carousel_date']; // phpcs:ignore ?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-5':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
										if ( 'yes' === $enable_float_effect ) {
											?>
											<div class="testimonials-carousel-image-box has-float animation-float">
												<?php $this->get_testimonial_carousel_image( $item ); ?>
											</div>
											<?php
										} else {
											?>
											<div class="testimonials-carousel-image-box">
												<?php $this->get_testimonial_carousel_image( $item ); ?>
											</div>
											<?php
										}
									}
									if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) ) {
										?>
										<div class="carousel-content-wrap">
											<?php
											if ( ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) ) {
												?>
												<div class="testimonials-carousel-icon-box">
													<?php $this->get_testimonial_carousel_icon_image( $item ); ?>
												</div>
												<div class="testimonial-carousel-title">
													<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
												</div>
												<?php
											}
											$this->get_testimonial_carousel_content( $item );
											if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) ) {
												?>
												<div class="testimonial-name-icon">
													<?php
													$this->get_testimonial_carousel_name( $item );
													$this->get_testimonial_carousel_position( $item );
													$this->get_rating_icon( $item );
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-6':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$icon_html   = '';
						$rating      = (float) $item['crafto_testimonial_carousel_rating_star']['size'] > 5 ? 5 : $item['crafto_testimonial_carousel_rating_star']['size'];
						$result      = ( $rating ) ? number_format_i18n( $rating, 1 ) : 0;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $result ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $result ) ) {
										?>
										<div class="testimonials-author-meta">
											<?php
											if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
												?>
												<div class="testimonials-carousel-image-box">
													<?php $this->get_testimonial_carousel_image( $item ); ?>
												</div>
												<?php
											}
											if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) ) {
												?>
												<div class="testimonial-name-icon">
													<?php
													$this->get_testimonial_carousel_name( $item );
													$this->get_testimonial_carousel_position( $item );
													?>
												</div>
												<?php
											}
											if ( ! empty( $result ) ) {
												?>
												<div class="rating-icon-singular">
													<?php
													$icon = '';
													if ( 'yes' === $this->get_settings( 'crafto_carousel_enable_icon' ) ) {
														if ( 'star_unicode' === $this->get_settings( 'crafto_testimonial_carousel_star_style' ) ) {
															$icon = '&#9733;';
														}
													}
													if ( $rating ) {
														$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
													}
													if ( ! empty( $result ) ) {
														?>
														<div class="elementor-star-rating"><?php echo $icon_html; // phpcs:ignore ?></div>
														<?php
														echo esc_html( $result );
													}
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$this->get_testimonial_carousel_content( $item );
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-7':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="content-box">
											<?php
											if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
												?>
												<div class="testimonials-carousel-image-box">
													<?php $this->get_testimonial_carousel_image( $item ); ?>
												</div>
												<?php
											}
											if ( ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) ) {
												?>
												<div class="carousel-content-wrap">
													<?php
													if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
														?>
														<div class="testimonial-carousel-title">
															<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
														</div>
														<?php
													}
													$this->get_testimonial_carousel_content( $item );
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) ) {
										?>
										<div class="testimonial-name-icon">
											<?php
											$this->get_testimonial_carousel_name( $item );
											$this->get_testimonial_carousel_position( $item );
											$this->get_rating_icon( $item );
											?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-8':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) ) {
										?>
										<div class="content-box">
											<?php
											if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) ) {
												?>
												<div class="testimonials-carousel-image-warp">
													<?php
													if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
														?>
														<div class="testimonials-carousel-image-box">
															<?php $this->get_testimonial_carousel_image( $item ); ?>
														</div>
														<?php
													}
													if ( ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) ) {
														?>
														<div class="testimonials-carousel-icon-box">
															<?php $this->get_testimonial_carousel_icon_image( $item ); ?>
														</div>
														<?php
													}
													?>
												</div>
												<?php
											}
											if ( ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) ) {
												?>
												<div class="carousel-content-wrap">
													<?php
													if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
														?>
														<div class="testimonial-carousel-title">
															<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
														</div>
														<?php
													}
													$this->get_testimonial_carousel_content( $item );
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
									}
									?>
								</div>
								<?php
								if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) ) {
									?>
									<div class="testimonial-name-icon">
										<?php
										$this->get_testimonial_carousel_name( $item );
										$this->get_testimonial_carousel_position( $item );
										$this->get_rating_icon( $item );
										?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-9':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<div class="content-box">
										<?php
										if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
											?>
											<div class="testimonials-carousel-image-box">
												<?php $this->get_testimonial_carousel_image( $item ); ?>
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) ) {
											?>
											<div class="carousel-content-wrap">
												<?php
												if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
													?>
													<div class="testimonial-carousel-title">
														<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
													</div>
													<?php
												}
												$this->get_testimonial_carousel_content( $item );
												if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) ) {
													?>
													<div class="testimonial-name-icon">
														<?php
														$this->get_rating_icon( $item );
														if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) ) {
															?>
															<div class="position-wrapper">
																<?php
																$this->get_testimonial_carousel_name( $item );
																$this->get_testimonial_carousel_position( $item );
																?>
															</div>
															<?php
														}
														?>
													</div>
													<?php
												}
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
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-10':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
										?>
										<div class="testimonials-carousel-image-box">
											<?php $this->get_testimonial_carousel_image( $item ); ?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$this->get_testimonial_carousel_content( $item );
									$this->get_testimonial_carousel_name( $item );
									$this->get_testimonial_carousel_position( $item );
									$this->get_rating_icon( $item );
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-11':
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							],
						);

						ob_start();
						if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<div class="carousel-content-wrap testimonials-carousel-icon-box">
										<?php
										if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
											?>
											<div class="avtar-image">
												<?php $this->get_testimonial_carousel_image( $item, array( 'testimonial-image' ) ); ?>
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) ) {
											?>
											<div class="testimonials-rounded-icon">
												<span>
													<?php $this->get_testimonial_carousel_icon_image( $item ); ?>
												</span>
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
											?>
											<div class="testimonial-carousel-title">
												<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
											</div>
											<?php
										}
										$this->get_testimonial_carousel_content( $item );
										$this->get_rating_icon( $item );
										$this->get_testimonial_carousel_name( $item );
										$this->get_testimonial_carousel_position( $item );
										?>
									</div>
								</div>
							</div>
							<?php
						}

						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'testimonial-carousel-style-12':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
										?>
										<div class="testimonials-carousel-image-box">
											<span>
												<?php $this->get_testimonial_carousel_image( $item ); ?>
											</span>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) ) {
										?>
										<div class="testimonial-carousel-content">
											<?php
											$crafto_highlight_content = str_replace( '[crafto_highlight]', '<span class="content-highlights">', $item['crafto_testimonial_carousel_content'] );
											$crafto_highlight_content = str_replace( '[/crafto_highlight]', '</span>', $crafto_highlight_content );
											echo sprintf( '%s', $crafto_highlight_content ); // phpcs:ignore
											?>
											<span class="testimonial-carousel-name">
												<?php echo esc_html( $item['crafto_testimonial_carousel_name'] ); ?>
											</span>
											<?php $this->get_testimonial_carousel_position( $item ); ?>
										</div>
										<?php
									}
									$this->get_rating_icon( $item );
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-13':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<div class="content-box">
										<?php
										if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
											?>
											<div class="col-md-5 testimonials-carousel-image-box">
												<?php $this->get_testimonial_carousel_image( $item ); ?>
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) ) {
											?>
											<div class="col-md-7 testimonial-name-icon">
												<?php
												if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
													?>
													<div class="testimonial-carousel-title">
														<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
													</div>
													<?php
												}
												$this->get_testimonial_carousel_content( $item );
												$this->get_rating_icon( $item );
												$this->get_testimonial_carousel_name( $item );
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
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-14':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) || ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
										?>
										<div class="testimonials-carousel-image-box">
											<?php $this->get_testimonial_carousel_image( $item ); ?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$this->get_testimonial_carousel_content( $item );
									$this->get_testimonial_carousel_name( $item );
									$this->get_testimonial_carousel_position( $item );
									$this->get_rating_icon( $item );
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-15':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
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

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<div class="content-box">
										<?php
										if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
											?>
											<div class="testimonials-carousel-image-box">
												<?php $this->get_testimonial_carousel_image( $item ); ?>
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
											?>
											<div class="col-md-7 testimonial-name-icon">
												<?php
												if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
													?>
													<div class="testimonial-carousel-title">
														<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
													</div>
													<?php
												}
												$this->get_testimonial_carousel_content( $item );
												$this->get_rating_icon( $item );
												$this->get_testimonial_carousel_name( $item );
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
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-16':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
						$wrapper_key = 'wrapper_' . $index;
						$icon        = '&#xE934;';
						$icon_html   = '';
						$rating      = (float) $item['crafto_testimonial_carousel_rating_star']['size'] > 5 ? 5 : $item['crafto_testimonial_carousel_rating_star']['size'];
						$result      = ( $rating ) ? number_format_i18n( $rating, 1 ) : 0;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);

						if ( ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $result ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $result ) ) {
										?>
										<div class="name-rating-wrap">
											<?php
											if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) ) {
												?>
												<div class="testimonial-position-wrap">
													<?php
													$this->get_testimonial_carousel_name( $item );
													$this->get_testimonial_carousel_position( $item );
													?>
												</div>
												<?php
											}
											if ( ! empty( $result ) ) {
												?>
												<div class="rating-icon-singular">
													<?php
													$icon = '';
													if ( 'yes' === $this->get_settings( 'crafto_carousel_enable_icon' ) ) {
														if ( 'star_unicode' === $this->get_settings( 'crafto_testimonial_carousel_star_style' ) ) {
															$icon = '&#9733;';
														}
													}
													if ( $rating ) {
														$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
													}
													if ( ! empty( $result ) ) {
														?>
														<div class="elementor-star-rating"><?php echo $icon_html; // phpcs:ignore ?></div>
														<?php
														echo esc_html( $result );
													}
													?>
												</div>
												<?php
											}
											?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$this->get_testimonial_carousel_content( $item );
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
										?>
										<div class="testimonials-carousel-image-box">
											<?php $this->get_testimonial_carousel_image( $item ); ?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-17':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
						$crafto_image_url       = '';
						$wrapper_key            = 'wrapper_' . $index;
						$carousel_image_box_key = 'carousel_image_box_' . $index;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);

						if ( '' !== $item['crafto_testimonial_carousel_image']['id'] && ! empty( $item['crafto_testimonial_carousel_image']['id'] ) ) {
							$crafto_image_url = Group_Control_Image_Size::get_attachment_image_src( $item['crafto_testimonial_carousel_image']['id'], 'crafto_thumbnail', $settings );
						} elseif ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
							$crafto_image_url = $item['crafto_testimonial_carousel_image']['url'];
						}

						$crafto_image_url = ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) ? 'background-image: url(' . $item['crafto_testimonial_carousel_image']['url'] . ');' : '';

						$this->add_render_attribute(
							$carousel_image_box_key,
							[
								'class' => [
									'testimonials-carousel-image-box',
								],
								'style' => $crafto_image_url,
							]
						);

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
										?>
										<div <?php $this->print_render_attribute_string( $carousel_image_box_key ); ?>></div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="carousel-content-wrap">
											<?php $this->get_rating_icon( $item );
											if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
												?>
												<div class="testimonial-carousel-title">
													<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
												</div>
												<?php
											}
											$this->get_testimonial_carousel_content( $item );
											$this->get_testimonial_carousel_name( $item );
											$this->get_testimonial_carousel_position( $item );
											?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
				case 'testimonial-carousel-style-18':
					ob_start();
					foreach ( $settings['crafto_testimonial_carousel'] as $index => $item ) {
						$crafto_image_url = '';
						$wrapper_key      = 'wrapper_' . $index;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);

						if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) || ! empty( $item['crafto_testimonial_carousel_name'] ) || ! empty( $item['crafto_testimonial_carousel_position'] ) || ! empty( $item['crafto_testimonial_carousel_content'] ) || ! empty( $item['crafto_testimonial_carousel_rating_star']['size'] ) || ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="testimonials-wrapper">
									<?php
									if ( ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
										?>
										<div class="testimonials-carousel-image-box">
											<?php $this->get_testimonial_carousel_image( $item ); ?>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_testimonial_carousel_title'] ) ) {
										?>
										<div class="testimonial-carousel-title">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_testimonial_carousel_title'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$crafto_highlight_content = str_replace( '[crafto_highlight]', '<span class="content-highlights">', $item['crafto_testimonial_carousel_content'] );
									$crafto_highlight_content = str_replace( '[/crafto_highlight]', '</span>', $crafto_highlight_content );
									if ( ! empty( $crafto_highlight_content ) ) {
										?>
										<div class="testimonial-carousel-content">
											<?php echo sprintf( '%s', $crafto_highlight_content ); // phpcs:ignore ?>
										</div>
										<?php
									}
									$this->get_rating_icon( $item );
									if ( ! empty( $item['crafto_testimonial_carousel_name'] ) ) {
										?>
										<span class="testimonial-carousel-name">
											<?php echo esc_html( $item['crafto_testimonial_carousel_name'] ); ?>
										</span>
										<?php
									}
									$this->get_testimonial_carousel_position( $item ); ?>
								</div>
							</div>
							<?php
						}
					}
					$slides[] = ob_get_contents();
					ob_end_clean();
					break;
			}

			if ( empty( $slides ) ) {
				return;
			}

			$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
			$crafto_slider_cursor           = $this->get_settings( 'crafto_slider_cursor' );
			$crafto_prev_text               = $this->get_settings( 'crafto_navigation_prev_text' );
			$crafto_next_text               = $this->get_settings( 'crafto_navigation_next_text' );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
			$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
			$crafto_pagination_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );
			$crafto_navigation_h_align      = $this->get_settings( 'crafto_navigation_h_align' );

			$sliderconfig = array(
				'navigation'                 => $crafto_navigation,
				'pagination'                 => $crafto_pagination,
				'pagination_style'           => $crafto_pagination_style,
				'number_style'               => $crafto_pagination_number_style,
				'autoplay'                   => $this->get_settings( 'crafto_autoplay' ),
				'autoplay_speed'             => $this->get_settings( 'crafto_autoplay_speed' ),
				'pause_on_hover'             => $this->get_settings( 'crafto_pause_on_hover' ),
				'loop'                       => $this->get_settings( 'crafto_infinite' ),
				'effect'                     => $this->get_settings( 'crafto_effect' ),
				'speed'                      => $this->get_settings( 'crafto_speed' ),
				'image_spacing'              => $this->get_settings( 'crafto_items_spacing' ),
				'autoheight'                 => $this->get_settings( 'crafto_autoheight' ),
				'minheight'                  => $this->get_settings( 'crafto_minheight' ),
				'allowtouchmove'             => $this->get_settings( 'crafto_allowtouchmove' ),
				'navigation_dynamic_bullets' => $this->get_settings( 'crafto_navigation_dynamic_bullets' ),
			);

			$slider_viewport = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
			$sliderconfig    = array_merge( $sliderconfig, $slider_viewport );
			$crafto_effect   = $this->get_settings( 'crafto_effect' );

			$effect = [
				'fade',
				'flip',
				'cube',
			];

			if ( '1' === $this->get_settings( 'crafto_slides_to_show' )['size'] && in_array( $crafto_effect, $effect, true ) ) {
				$sliderconfig['effect'] = $crafto_effect;
			}

			if ( 'testimonial-carousel-style-10' === $layout_type ) {
				$sliderconfig['centered_slides'] = $this->get_settings( 'crafto_centered_slides' );
				$sliderconfig['coverflowEffect'] = $this->get_settings( 'crafto_coverflow_effect_slides' );
			}

			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
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
							'testimonial-carousel',
							$layout_type,
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
			if ( 'testimonial-carousel-style-1' === $layout_type ) {
				if ( ! empty( $crafto_navigation_h_align ) ) {
					$this->add_render_attribute(
						[
							'carousel-wrapper' => [
								'class' => [
									'navigation-' . $crafto_navigation_h_align,
								],
							],
						]
					);
				}
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
			$crafto_prev_text = ( $crafto_prev_text ) ? $crafto_prev_text : esc_html__( 'Previous', 'crafto-addons' );
			$crafto_next_text = ( $crafto_next_text ) ? $crafto_next_text : esc_html__( 'Next', 'crafto-addons' );

			switch ( $this->get_settings( 'crafto_feather_shadow' ) ) {
				case 'both':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow' );
					break;
				case 'right':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow-right' );
					break;
				case 'left':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow-left' );
					break;
			}
			$this->add_render_attribute(
				'carousel_title_box',
				[
					'class' => 'carousel-title-box',
				],
			);

			$this->add_render_attribute(
				'carousel_wrap',
				[
					'class' => 'testimonials-carousel-wrap',
				],
			);
			if ( 'testimonial-carousel-style-3' === $layout_type || 'testimonial-carousel-style-6' === $layout_type || 'testimonial-carousel-style-13' === $layout_type ) {
				if ( ! empty( $settings['crafto_testimonial_carousel_subheading'] ) || ! empty( $settings['crafto_testimonial_carousel_heading'] ) || ! empty( $settings['crafto_testimonial_carousel_slide_content'] ) ) {
					?>
					<div class="testimonial-carousel-wrapper">
						<div <?php $this->print_render_attribute_string( 'carousel_title_box' ); ?>>
							<?php
							if ( ! empty( $settings['crafto_testimonial_carousel_subheading'] ) ) {
								?>
								<div class="subheading"><?php echo esc_html( $settings['crafto_testimonial_carousel_subheading'] ); ?></div>
								<?php
							}

							$crafto_heading_title = $this->get_settings( 'crafto_testimonial_carousel_heading' );
							if ( ! empty( $crafto_heading_title ) ) {
								if ( has_shortcode( $settings['crafto_testimonial_carousel_heading'], 'crafto_highlight' ) ) {
									$crafto_heading_title = str_replace( '[crafto_highlight]', '<span class="separator">', $crafto_heading_title );
									$crafto_heading_title = str_replace( '[/crafto_highlight]', '</span>', $crafto_heading_title );
								}
							}
							?>
							<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> class="heading">
							<?php printf( '%s', $crafto_heading_title ); // phpcs:ignore ?>
							</<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
							<?php
							if ( ! empty( $settings['crafto_testimonial_carousel_slide_content'] ) ) {
								?>
								<div class="carousel-content-box">
									<?php echo sprintf( '%s', wp_kses_post( $settings['crafto_testimonial_carousel_slide_content'] ) ); // phpcs:ignore ?>
								</div>
								<?php
							}
							?>
						</div>
					<?php
				}
			}
			if ( 'testimonial-carousel-style-4' === $layout_type || 'testimonial-carousel-style-15' === $layout_type ) {
				if ( ! empty( $settings['crafto_testimonial_carousel_subheading'] ) || ! empty( $settings['crafto_testimonial_carousel_heading'] ) || ! empty( $settings['crafto_testimonial_carousel_slide_content'] ) ) {
					?>
					<div class="testimonial-carousel-wrapper">
						<div <?php $this->print_render_attribute_string( 'carousel_title_box' ); ?>>
							<?php
							if ( ! empty( $settings['crafto_testimonial_carousel_subheading'] ) ) {
								?>
								<div class="subheading"><?php echo esc_html( $settings['crafto_testimonial_carousel_subheading'] ); ?></div>
								<?php
							}

							$crafto_heading_title = $this->get_settings( 'crafto_testimonial_carousel_heading' );
							if ( ! empty( $crafto_heading_title ) ) {
								if ( has_shortcode( $settings['crafto_testimonial_carousel_heading'], 'crafto_highlight' ) ) {
									$crafto_heading_title = str_replace( '[crafto_highlight]', '<span class="separator">', $crafto_heading_title );
									$crafto_heading_title = str_replace( '[/crafto_highlight]', '</span>', $crafto_heading_title );
								}
							}
							?>
							<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> class="heading">
							<?php printf( '%s', $crafto_heading_title ); // phpcs:ignore ?>
							</<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
							<?php
							if ( ! empty( $settings['crafto_testimonial_carousel_slide_content'] ) ) {
								?>
								<div class="carousel-content-box">
									<?php echo sprintf( '%s', wp_kses_post( $settings['crafto_testimonial_carousel_slide_content'] ) ); // phpcs:ignore ?>
								</div>
								<?php
							}
							?>
						</div>
					<?php
				}
			}
			if ( 'testimonial-carousel-style-18' === $layout_type ) {
				?>
				<div class="testimonial-carousel-wrapper">
					<div <?php $this->print_render_attribute_string( 'carousel_title_box' ); ?>>
						<?php
						if ( ! empty( $settings['crafto_testimonial_carousel_heading'] ) ) {
							?>
							<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> class="heading"><?php echo esc_html( $settings['crafto_testimonial_carousel_heading'] ); ?>
							</<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
							<?php
						}
						?>
						<div class="testimonial-carousel-content-box">
							<?php
							if ( ! empty( $settings['crafto_testimonial_carousel_number'] ) ) {
								?>
								<div class="testimonial-carousel-number">
									<?php echo $settings['crafto_testimonial_carousel_number']; // phpcs:ignore ?>
								</div>
								<?php
							}
							?>
							<div class="testimonial-carousel-rating-box">
								<?php
								$icon           = '';
								$icon_html      = '';
								$rating         = (float) $settings['crafto_testimonial_carousel_star_rating']['size'] > 5 ? 5 : $settings['crafto_testimonial_carousel_star_rating']['size'];
								$floored_rating = ( $rating ) ? (int) $rating : 0;
								$result         = ( $rating ) ? number_format_i18n( $rating, 1 ) : 0;

								if ( 'yes' === $this->get_settings( 'crafto_carousel_enable_icon' ) ) {
									if ( 'star_unicode' === $settings['crafto_testimonial_carousel_star_style'] ) {
										$icon = '&#9733;';
										if ( 'outline' === $settings['crafto_testimonial_carousel_unmarked_star_style'] ) {
											$icon = '&#9734;';
										}
									}
								}
								if ( $rating ) {
									for ( $stars = 1; $stars <= 5; $stars++ ) {
										if ( $stars <= $floored_rating ) {
											$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
										} elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
											$icon_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">' . $icon . '</i>';
										} else {
											$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
										}
									}
								}
								if ( ! empty( $result ) ) {
									?>
									<div class="review-star-icon">
										<div class="elementor-star-rating"><?php echo $icon_html; // phpcs:ignore ?></div>
									</div>
									<?php
								}
								if ( ! empty( $settings['crafto_testimonial_carousel_subheading'] ) ) {
									?>
									<span class="subheading"><?php echo esc_html( $settings['crafto_testimonial_carousel_subheading'] ); ?></span>
									<?php
								}
								?>
							</div>
						</div>
						<?php
						if ( ! empty( $settings['crafto_testimonial_carousel_slide_content'] ) ) {
							?>
							<div class="carousel-content-box">
								<?php echo sprintf( '%s', wp_kses_post( $settings['crafto_testimonial_carousel_slide_content'] ) ); // phpcs:ignore ?>
							</div>
							<?php
						}
						?>
					</div>
				<?php
			}
			if ( 'testimonial-carousel-style-3' === $layout_type || 'testimonial-carousel-style-4' === $layout_type || 'testimonial-carousel-style-6' === $layout_type || 'testimonial-carousel-style-13' === $layout_type || 'testimonial-carousel-style-15' === $layout_type || 'testimonial-carousel-style-18' === $layout_type ) {
				?>
				<div <?php $this->print_render_attribute_string( 'carousel_wrap' ); ?>>
				<?php
			}
			?>
			<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
					<?php echo implode( '', $slides ); // phpcs:ignore ?>
				</div>
				<?php $this->swiper_pagination(); ?>
			</div>
			<?php
			if ( 'testimonial-carousel-style-3' === $layout_type || 'testimonial-carousel-style-4' === $layout_type || 'testimonial-carousel-style-6' === $layout_type || 'testimonial-carousel-style-13' === $layout_type || 'testimonial-carousel-style-15' === $layout_type || 'testimonial-carousel-style-18' === $layout_type ) {
				if ( ! empty( $settings['crafto_testimonial_carousel_subheading'] ) || ! empty( $settings['crafto_testimonial_carousel_heading'] ) || ! empty( $settings['crafto_testimonial_carousel_slide_content'] ) ) {
					?>
					</div>
					<?php
				}
				?>
				</div>
				<?php
			}
		}

		/**
		 *  Return author name.
		 *
		 * @since 1.0
		 * @access protected
		 * @param array $item Widget data.
		 */
		protected function get_testimonial_carousel_name( $item ) {

			if ( ! empty( $item['crafto_testimonial_carousel_name'] ) ) {
				?>
				<div class="testimonial-carousel-name">
					<?php echo $item['crafto_testimonial_carousel_name']; // phpcs:ignore ?>
				</div>
				<?php
			}
		}

		/**
		 *  Return author position.
		 *
		 * @since 1.0
		 * @access protected
		 * @param array $item Widget data.
		 */
		protected function get_testimonial_carousel_position( $item ) {

			if ( ! empty( $item['crafto_testimonial_carousel_position'] ) ) {
				?>
				<span class="testimonial-carousel-position">
					<?php echo esc_html( $item['crafto_testimonial_carousel_position'] ); ?>
				</span>
				<?php
			}
		}

		/**
		 *  Return carousel content.
		 *
		 * @since 1.0
		 * @access protected
		 * @param array $item Widget data.
		 */
		protected function get_testimonial_carousel_content( $item ) {

			if ( ! empty( $item['crafto_testimonial_carousel_content'] ) ) {
				?>
				<div class="testimonial-carousel-content">
					<?php
					$crafto_highlight_content = str_replace( '[crafto_highlight]', '<span class="content-highlights">', $item['crafto_testimonial_carousel_content'] );
					$crafto_highlight_content = str_replace( '[/crafto_highlight]', '</span>', $crafto_highlight_content );
					echo sprintf( '%s', $crafto_highlight_content ); // phpcs:ignore
					?>
				</div>
				<?php
			}
		}

		/**
		 * Retrieve Rating Icon
		 *
		 * @since 1.0
		 * @access protected
		 * @param array $item Widget data.
		 */
		protected function get_rating_icon( $item ) {

			$layout_type = $this->get_settings( 'crafto_testimonial_carousel_layout_type' );
			$icon        = '';

			if ( 'yes' === $this->get_settings( 'crafto_carousel_enable_icon' ) ) {
				if ( 'star_unicode' === $this->get_settings( 'crafto_testimonial_carousel_star_style' ) ) {
					$icon = '&#9733;';

					if ( 'outline' === $this->get_settings( 'crafto_testimonial_carousel_unmarked_star_style' ) ) {
						$icon = '&#9734;';
					}
				}
			}
			$icon_html      = '';
			$rating         = (float) $item['crafto_testimonial_carousel_rating_star']['size'] > 5 ? 5 : $item['crafto_testimonial_carousel_rating_star']['size'];
			$floored_rating = ( $rating ) ? (int) $rating : 0;
			$result         = ( $rating ) ? number_format_i18n( $rating, 1 ) : 0;
			if ( 'yes' === $this->get_settings( 'crafto_carousel_enable_icon' ) ) {
				if ( $rating ) {
					for ( $stars = 1; $stars <= 5; $stars++ ) {
						if ( $stars <= $floored_rating ) {
							$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
						} elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
							$icon_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">' . $icon . '</i>';
						} else {
							$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
						}
					}
				}

				if ( ! empty( $result ) ) {
					if ( 'testimonial-carousel-style-17' === $layout_type ) {
						?>
						<div>
						<?php
					}
					?>
					<div class="review-star-icon testimonial-review">
						<?php
						if ( 'testimonial-carousel-style-4' === $layout_type && ! empty( $result ) ) {
							?>
							<div class="star-rating-number"><?php echo $result; // phpcs:ignore ?></div>
							<?php
						}
						?>
						<div class="elementor-star-rating"><?php echo $icon_html; // phpcs:ignore ?></div>
					</div>
					<?php
					if ( 'testimonial-carousel-style-17' === $layout_type ) {
						?>
						</div>
						<?php
					}
				}
			}
		}

		/**
		 *  Return Carousel Image.
		 *
		 * @since 1.0
		 * @param array $item Widget data.
		 * @access public
		 */
		public function get_testimonial_carousel_image( $item ) {

			$settings  = $this->get_settings_for_display();
			$has_image = ! empty( $item['crafto_testimonial_carousel_image'] );

			if ( ! $has_image && ! empty( $item['crafto_testimonial_carousel_image']['id'] ) ) {
				$has_image = true;
			}
			if ( ! empty( $item['crafto_testimonial_carousel_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_testimonial_carousel_image']['id'] ) ) {
				$item['crafto_testimonial_carousel_image']['id'] = '';
			}
			if ( isset( $item['crafto_testimonial_carousel_image'] ) && isset( $item['crafto_testimonial_carousel_image']['id'] ) && ! empty( $item['crafto_testimonial_carousel_image']['id'] ) ) {
				crafto_get_attachment_html( $item['crafto_testimonial_carousel_image']['id'], $item['crafto_testimonial_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			} elseif ( isset( $item['crafto_testimonial_carousel_image'] ) && isset( $item['crafto_testimonial_carousel_image']['url'] ) && ! empty( $item['crafto_testimonial_carousel_image']['url'] ) ) {
				crafto_get_attachment_html( $item['crafto_testimonial_carousel_image']['id'], $item['crafto_testimonial_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			}
		}

		/**
		 *  Return Carousel Image.
		 *
		 * @since 1.0
		 * @param array $item Widget data.
		 * @access public
		 */
		public function get_testimonial_carousel_icon_image( $item ) {

			$settings = $this->get_settings_for_display();
			if ( ! empty( $item['crafto_testimonial_carousel_use_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_testimonial_carousel_use_image']['id'] ) ) {
				$item['crafto_testimonial_carousel_use_image']['id'] = '';
			}
			if ( isset( $item['crafto_testimonial_carousel_use_image'] ) && isset( $item['crafto_testimonial_carousel_use_image']['id'] ) && ! empty( $item['crafto_testimonial_carousel_use_image']['id'] ) ) {
				crafto_get_attachment_html( $item['crafto_testimonial_carousel_use_image']['id'], $item['crafto_testimonial_carousel_use_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			} elseif ( isset( $item['crafto_testimonial_carousel_use_image'] ) && isset( $item['crafto_testimonial_carousel_use_image']['url'] ) && ! empty( $item['crafto_testimonial_carousel_use_image']['url'] ) ) {
				crafto_get_attachment_html( $item['crafto_testimonial_carousel_use_image']['id'], $item['crafto_testimonial_carousel_use_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			}
		}

		/**
		 * Return swiper pagination.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function swiper_pagination() {
			$previous_arrow_icon            = '';
			$next_arrow_icon                = '';
			$settings                       = $this->get_settings_for_display();
			$crafto_prev_text               = $this->get_settings( 'crafto_navigation_prev_text' );
			$crafto_next_text               = $this->get_settings( 'crafto_navigation_next_text' );
			$crafto_prev_next_check         = $this->get_settings( 'crafto_navigation_arrow_prev_next_text' );
			$slides_count                   = ( $settings['crafto_testimonial_carousel'] ) ? count( $settings['crafto_testimonial_carousel'] ) : 0;
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$previous_icon_migrated         = isset( $settings['__fa4_migrated']['crafto_previous_arrow_icon'] );
			$next_icon_migrated             = isset( $settings['__fa4_migrated']['crafto_next_arrow_icon'] );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );

			if ( ( 'yes' === $crafto_prev_next_check && 'yes' === $crafto_navigation ) ) {
				$this->add_render_attribute( 'carousel-wrapper', 'class', 'prev-next-navigation' );
			}
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
			if ( 1 < $slides_count ) {
				if ( 'yes' === $crafto_navigation ) {
					if ( 'testimonial-carousel-style-1' === $settings['crafto_testimonial_carousel_layout_type'] ) {
						?>
						<div class="navigation-wrapper">
							<div class="elementor-swiper-button elementor-swiper-button-prev">
								<?php if ( ! empty( $previous_arrow_icon ) ) {
									echo sprintf( '%s', $previous_arrow_icon ); // phpcs:ignore
								} ?>
								<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'crafto-addons' ); ?></span>
							</div>
							<div class="elementor-swiper-button elementor-swiper-button-next">
								<?php if ( ! empty( $next_arrow_icon ) ) {
									echo sprintf( '%s', $next_arrow_icon ); // phpcs:ignore
								}  ?>
								<span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'crafto-addons' ); ?></span>
							</div>
						</div>
						<?php
					} else {
						if ( 'testimonial-carousel-style-14' === $settings['crafto_testimonial_carousel_layout_type'] ) {
							?>
							<div class="elementor-swiper-button elementor-swiper-button-prev">
								<?php
									echo sprintf( '%s', $previous_arrow_icon ); // phpcs:ignore
								?>
								<span class="slider-custom-text-prev"><?php echo esc_html( $crafto_prev_text ); ?></span>
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
							<?php
						}
						if ( 'testimonial-carousel-style-14' === $settings['crafto_testimonial_carousel_layout_type'] ) {
							?>
							<div class="elementor-swiper-button elementor-swiper-button-next">
								<?php
									echo sprintf( '%s', $next_arrow_icon ); // phpcs:ignore
								?>
								<span class="slider-custom-text-next"><?php echo esc_html( $crafto_next_text ); ?></span>
							</div>
							<?php
						} else {
							?>
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
				if ( 'yes' === $crafto_pagination && 'thumb' === $crafto_pagination_style && 'testimonial-carousel-style-11' === $settings['crafto_testimonial_carousel_layout_type'] ) {
					?>
					<div class="slider-custom-image-pagination"></div>
					<?php
				}
			}
		}
	}
}
