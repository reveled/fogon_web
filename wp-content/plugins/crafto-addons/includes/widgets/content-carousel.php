<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use CraftoAddons\Controls\Groups\Button_Group_Control;

/**
 *
 * Crafto widget for Content Carousel.
 *
 * @package Crafto
 */

// If class `Content_Carousel` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Content_Carousel' ) ) {
	/**
	 * Define `Content_Carousel` class.
	 */
	class Content_Carousel extends Widget_Base {
		/**
		 * Retrieve the list of scripts the content carousel widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$content_carousel_scripts     = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$content_carousel_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$content_carousel_scripts   = [
							'anime',
							'appear',
							'splitting',
							'animation',
							'crafto-fancy-text-effect',
						];

						$content_carousel_scripts[] = 'crafto-magic-cursor';
					}
					$content_carousel_scripts[] = 'swiper';
				}
				$content_carousel_scripts[] = 'crafto-default-carousel';
			}
			return $content_carousel_scripts;
		}

		/**
		 * Retrieve the list of styles the content carousel widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$content_carousel_styles      = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
			if ( crafto_disable_module_by_key( 'swiper' ) ) {
				$content_carousel_styles = [
					'swiper',
					'nav-pagination',
				];

				if ( is_rtl() ) {
					$content_carousel_styles[] = 'nav-pagination-rtl';
				}

				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'magic-cursor' ) ) {
					$content_carousel_styles[] = 'crafto-magic-cursor';
				}
			}

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$content_carousel_styles[] = 'crafto-widgets-rtl';
				} else {
					$content_carousel_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$content_carousel_styles[] = 'crafto-content-slider-rtl';
				}
				$content_carousel_styles[] = 'crafto-heading-widget';
				$content_carousel_styles[] = 'crafto-content-slider';
			}
			return $content_carousel_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-content-slider';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Content Carousel', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/content-carousel/';
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
				'slider',
				'content slider',
				'media slider',
			];
		}

		/**
		 * Register content carousel widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_content_carousel_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_carousel_slide_styles',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'content-carousel-style-1',
					'options'            => [
						'content-carousel-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'content-carousel-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'content-carousel-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'content-carousel-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'content-carousel-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
						'content-carousel-style-6' => esc_html__( 'Style 6', 'crafto-addons' ),
						'content-carousel-style-7' => esc_html__( 'Style 7', 'crafto-addons' ),
					],
					'render_type'        => 'template',
					'prefix_class'       => 'el-',
					'frontend_available' => true,
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_image_carousel',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);

			$this->add_control(
				'crafto_carousel_heading',
				[
					'label'       => esc_html__( 'Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write heading here', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_carousel_subheading',
				[
					'label'       => esc_html__( 'Subheading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write subheading here', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_carousel_content',
				[
					'label'       => esc_html__( 'Content', 'crafto-addons' ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Lorem ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->end_controls_section();
			Button_Group_Control::button_content_fields(
				$this,
				[
					'id'      => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => esc_html__( 'Click here', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				],
			);
			$this->start_controls_section(
				'crafto_section_content_carousel_repeater1',
				[
					'label'     => esc_html__( 'Slides', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$repeater1 = new Repeater();
			$repeater1->add_control(
				'crafto_carousel_image1',
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
			$this->add_control(
				'crafto_carousel_slider1',
				[
					'label'      => esc_html__( 'Slides', 'crafto-addons' ),
					'show_label' => false,
					'type'       => Controls_Manager::REPEATER,
					'fields'     => $repeater1->get_controls(),
					'default'    => [
						[
							'crafto_carousel_image1' => Utils::get_placeholder_image_src(),

						],
						[
							'crafto_carousel_image1' => Utils::get_placeholder_image_src(),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_content_carousel_repeater',
				[
					'label'     => esc_html__( 'Slides', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs(
				'crafto_carousel_image_tabs'
			);
			$repeater->start_controls_tab(
				'crafto_carousel_image_background_tab',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_carousel_image',
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
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_carousel_image_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
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
				'crafto_item_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'bi bi-briefcase',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_item_use_image' => '',
					],
					'description'      => esc_html__( 'Not Applicable in style 4 only.', 'crafto-addons' ),
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
					'description' => esc_html__( 'Not Applicable in style 4 only.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_carousel_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'description' => esc_html__( 'Applicable in style 5 only.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_carousel_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_carousel_title_message',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<div style ="font-style:normal">To add the highlighted text use shortcode like:<br/><br/> <span style="font-weight:bold">[crafto_highlight]</span> Your Text <span style="font-weight:bold">[/crafto_highlight]</span></div>', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$repeater->add_control(
				'crafto_title_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_carousel_subtitle',
				[
					'label'       => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write subtitle here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_carousel_description',
				[
					'label'   => esc_html__( 'Description', 'crafto-addons' ),
					'type'    => Controls_Manager::WYSIWYG,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Lorem Ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
				]
			);
			Button_Group_Control::repeater_button_content_fields(
				$repeater,
				[
					'id'          => 'button',
					'label'       => esc_html__( 'Button', 'crafto-addons' ),
					'default'     => esc_html__( 'Click here', 'crafto-addons' ),
					'description' => esc_html__( 'Not Applicable in style 5 only.', 'crafto-addons' ),
				],
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();

			$this->add_control(
				'crafto_carousel_slider',
				[
					'label'      => esc_html__( 'Carousel Items', 'crafto-addons' ),
					'show_label' => false,
					'type'       => Controls_Manager::REPEATER,
					'fields'     => $repeater->get_controls(),
					'default'    => [
						[
							'crafto_carousel_title'       => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_carousel_subtitle'    => esc_html__( 'Write subtitle here', 'crafto-addons' ),
							'crafto_carousel_description' => esc_html__( 'Lorem Ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
							'crafto_carousel_image'       => Utils::get_placeholder_image_src(),

						],
						[
							'crafto_carousel_title'       => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_carousel_subtitle'    => esc_html__( 'Write subtitle here', 'crafto-addons' ),
							'crafto_carousel_description' => esc_html__( 'Lorem Ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
							'crafto_carousel_image'       => Utils::get_placeholder_image_src(),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_carousel_content_setting',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_header_size',
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

			Button_Group_Control::repeater_button_setting_fields(
				$this,
				[
					'id'    => 'button',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-7',
						],
					],
				]
			);

			$this->start_controls_section(
				'crafto_section_image_carousel_setting',
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
						'size' => 1,
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 10,
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
					'dynamic'   => [
						'active' => true,
					],
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
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_slides_to_show[size]!' => '1',
					],
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
					'label'     => esc_html__( 'Fade Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none'  => esc_html__( 'None', 'crafto-addons' ),
						'both'  => esc_html__( 'Both Side', 'crafto-addons' ),
						'right' => esc_html__( 'Right Side', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-4',
						],
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
						'crafto_navigation'             => 'yes',
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_navigation_h_align',
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
						'crafto_navigation'            => 'yes',
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-2',
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
				'crafto_section_style_general',
				[
					'label'     => esc_html__( 'General', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_carousel_general_padding',
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
						'{{WRAPPER}} .content-carousel-style-1 .content-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
					'condition'  => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_carousel_general_margin',
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
						'{{WRAPPER}} .content-carousel-style-1 .content-slider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_carousel_title_box_heading',
				[
					'label'     => esc_html__( 'Content Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_title_width',
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
					'default'    => [
						'unit' => '%',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .carousel-content' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_carousel_title_border',
					'selector'       => '{{WRAPPER}} .content-box',
					'condition'      => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-7',
						],
					],
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_title_padding',
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
						'{{WRAPPER}} .carousel-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_carousel_slider_box_heading',
				[
					'label'     => esc_html__( 'Image Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_slider_box_width',
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
						'%'  =>
						[
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-carousel-wrapper, {{WRAPPER}} .el-content-carousel-style-7 .content-carousel-wrapper' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_slider_box_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'vh',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
						'%'  =>
						[
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .content-carousel-style-7' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_slider_box_min_width',
				[
					'label'      => esc_html__( 'Min Width', 'crafto-addons' ),
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
						'{{WRAPPER}} .content-carousel-wrapper' => 'min-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_slider_box_padding',
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
						'{{WRAPPER}} .content-carousel-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_slider_box_margin',
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
						'{{WRAPPER}} .content-carousel-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label'     => esc_html__( 'Slides', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_slides_text_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'left',
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
					'selectors' => [
						'{{WRAPPER}} .swiper-slide' => 'text-align: {{VALUE}}',
					],
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_content_box_style_tabs' );
				$this->start_controls_tab(
					'crafto_content_box_style_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_carousel_slide_styles!' => [
								'content-carousel-style-1',
								'content-carousel-style-2',
								'content-carousel-style-4',
								'content-carousel-style-6',
							],
						],
					],
				);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_content_box_background_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .swiper-slide .content-box, {{WRAPPER}} .content-carousel-style-4 .swiper-slide, {{WRAPPER}} .content-carousel-style-6 .swiper-slide',
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_box_highlight_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-5',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_box_style_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_content_box_hover_background_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .swiper-slide .content-box:hover, {{WRAPPER}} .content-carousel-style-4 .carousel-content-wrap:hover, {{WRAPPER}} .content-carousel-style-6 .swiper-slide:hover, {{WRAPPER}} .content-carousel-style-5 .swiper-slide:hover .content-box',
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_box_hover_highlight_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-5',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_content_carousel_shadow',
					'selector' => '{{WRAPPER}} .content-box, {{WRAPPER}} .content-carousel-style-4 .swiper-slide, {{WRAPPER}} .content-carousel-style-5 .swiper-slide, {{WRAPPER}} .content-carousel-style-6 .swiper-slide',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_content_box_border',
					'selector'       => '{{WRAPPER}} .content-carousel-wrapper .content-slider, {{WRAPPER}} .content-carousel-style-4 .swiper-slide, {{WRAPPER}} .content-carousel-style-5 .content-slider, {{WRAPPER}} .content-carousel-style-6 .swiper-slide',
					'condition'      => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
						],
					],
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-carousel-wrapper .content-slider, {{WRAPPER}} .content-carousel-style-4 .swiper-slide, {{WRAPPER}} .content-carousel-style-5 .content-slider, {{WRAPPER}} .content-carousel-style-6 .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_box_carousel_padding',
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
						'{{WRAPPER}} .content-carousel-style-5 .content-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_carousel_box_heading',
				[
					'label'     => esc_html__( 'Content Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_content_box_content_width',
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
						'{{WRAPPER}} .content-box, {{WRAPPER}} .content-carousel-style-6 .content-wrap' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-4',
							'content-carousel-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_box_padding',
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
						'{{WRAPPER}} .swiper-slide .content-box, {{WRAPPER}} .content-carousel-style-4 .swiper-slide, {{WRAPPER}} .content-carousel-style-6 .swiper-slide .content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_carousel_box_iamge',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_box_image_width',
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
						'{{WRAPPER}} .content-carousel-style-6 .content-image' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_carousel_content_box_background_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .carousel-content-wrap',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_carousel_padding',
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
						'{{WRAPPER}} .carousel-content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-4',
						],
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_carousel_heading_style_section',
				[
					'label'     => esc_html__( 'Heading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_carousel_heading_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .heading',
				]
			);
			$this->add_control(
				'crafto_carousel_heading_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .heading' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_heading_width',
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
						'{{WRAPPER}} .heading' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_heading_margin',
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
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_carousel_subheading_style_section',
				[
					'label'     => esc_html__( 'Subheading', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_carousel_subheading_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .subheading',
				]
			);
			$this->add_control(
				'crafto_carousel_subheading_color',
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
					'name'     => 'crafto_carousel_subheading_background',
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
				'crafto_carousel_subheading_width',
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
						'{{WRAPPER}} .subheading' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_subheading_border_radius',
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
				'crafto_carousel_subheading_padding',
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
				'crafto_carousel_subheading_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
					],
					'selectors'  => [
						'{{WRAPPER}} .subheading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_subheading_display_settings',
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
				'crafto_carousel_content_heading_style_section',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_carousel_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .content',
				]
			);
			$this->add_control(
				'crafto_carousel_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_content_width',
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
						'{{WRAPPER}} .content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_content_margin',
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
						'{{WRAPPER}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_content_image',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-5',
							'content-carousel-style-6',
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
			$this->start_controls_tabs( 'crafto_icon_style_tabs' );
				$this->start_controls_tab(
					'crafto_icon_style_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_carousel_slide_styles!' => [
								'content-carousel-style-1',
								'content-carousel-style-2',
								'content-carousel-style-6',
							],
						],
					],
				);
				$this->add_control(
					'crafto_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}.elementor-view-default .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-framed .elementor-icon i' => 'color: {{VALUE}};',
							'{{WRAPPER}}.elementor-view-default .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg, {{WRAPPER}}.elementor-view-framed .elementor-icon svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_primary_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => [
							'crafto_view' => 'stacked',
						],
						'selectors' => [
							'{{WRAPPER}}.elementor-view-stacked .elementor-icon'  => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_secondary_color',
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
					'crafto_icon_border_radius',
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
					'crafto_icon_style_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_carousel_slide_styles!' => [
								'content-carousel-style-1',
								'content-carousel-style-2',
								'content-carousel-style-6',
							],
						],
					]
				);
				$this->add_control(
					'crafto_hover_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}.elementor-view-default:hover .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon i' => 'color: {{VALUE}};',
							'{{WRAPPER}}.elementor-view-default:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							'crafto_carousel_slide_styles!' => [
								'content-carousel-style-1',
								'content-carousel-style-2',
								'content-carousel-style-6',
							],
						],
					]
				);
				$this->add_control(
					'crafto_hover_primary_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_view' => 'stacked',
							'crafto_carousel_slide_styles!' => [
								'content-carousel-style-1',
								'content-carousel-style-2',
								'content-carousel-style-6',
							],
						],
					]
				);
				$this->add_control(
					'crafto_hover_secondary_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'condition' => [
							'crafto_view' => [
								'framed',
							],
							'crafto_carousel_slide_styles!' => [
								'content-carousel-style-1',
								'content-carousel-style-2',
								'content-carousel-style-6',
							],
						],
						'selectors' => [
							'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon'  => 'border-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_icon_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-6',
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
						'px' => [
							'min' => 6,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon, {{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_shape_size',
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
				'crafto_icon_margin',
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
						'{{WRAPPER}} .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}}',
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
				'crafto_content_image_w_size',
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
						'size' => 25,
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .content-box img, {{WRAPPER}} .content-carousel-style-5 .content-wrap img, {{WRAPPER}} .content-carousel-style-6 .content-wrap img' => 'width: {{SIZE}}{{UNIT}};',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_content_image_h_size',
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
							'min'  => 0,
							'max'  => 300,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .content-box img, {{WRAPPER}} .content-carousel-style-2 .content-box img, {{WRAPPER}} .content-carousel-style-5 .content-wrap img, {{WRAPPER}} .content-carousel-style-6 .content-wrap img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_image_spacing',
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
						'{{WRAPPER}} .swiper-slide .content-box img, {{WRAPPER}} .content-carousel-style-6 .content-wrap img' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .content-carousel-style-5 .content-slider .content-wrap img' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .content-carousel-style-5 .content-slider .content-wrap .elementor-icon svg' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_content_image_box_shadow',
					'selector'  => '{{WRAPPER}} .swiper-slide .content-box img, {{WRAPPER}} .content-carousel-style-6 .content-wrap img',
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-5',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_content_image_border',
					'selector'       => '{{WRAPPER}} .swiper-slide .content-box img, {{WRAPPER}} .content-carousel-style-6 .content-wrap img',
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-5',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_content_background_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_carousel_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min' => 100,
							'max' => 1000,
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
						'{{WRAPPER}} .cover-background:not(.content-carousel-style-3 .cover-background), {{WRAPPER}} .cover-background img ' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_carousel_image_position',
				[
					'label'     => esc_html__( 'Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
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
					'selectors' => [
						'{{WRAPPER}} .cover-background' => 'background-position: {{VALUE}};',
					],
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_carousel_image_attachment',
				[
					'label'     => esc_html__( 'Attachment', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''       => esc_html__( 'Default', 'crafto-addons' ),
						'scroll' => esc_html__( 'Scroll', 'crafto-addons' ),
						'fixed'  => esc_html__( 'Fixed', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .cover-background' => 'background-attachment: {{VALUE}};',
					],
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_carousel_image_repeat',
				[
					'label'     => esc_html__( 'Repeat', 'crafto-addons' ),
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
						'{{WRAPPER}} .cover-background' => 'background-repeat: {{VALUE}};',
					],
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_carousel_image_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
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
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .box-image, {{WRAPPER}} .content-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_content_carousel_number',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-5',
						],
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
					'selector' => '{{WRAPPER}} .sliding-box .overlay-content .number, {{WRAPPER}} .content-carousel-style-5 .content-slider .content-image .slide-number',
				]
			);
			$this->add_control(
				'crafto_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .sliding-box .overlay-content .number, {{WRAPPER}} .sliding-box .overlay-content .number a, {{WRAPPER}} .content-carousel-style-5 .content-slider .content-image .slide-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_carousel_title',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_heading_style_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .slide-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_carousel_title_style'
			);
			$this->start_controls_tab(
				'crafto_content_carousel_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .slide-title a, {{WRAPPER}} .slide-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_carousel_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-carousel-style-5 .content-slider:hover .slide-title, {{WRAPPER}} .content-carousel-style-5 .content-slider:hover .slide-title a, {{WRAPPER}} .slide-title a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_title_spacing',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
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
						'{{WRAPPER}} .slide-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'separator'  => 'before',
				]
			);
			$this->add_control(
				'crafto_heading_style_highlight',
				[
					'label'     => esc_html__( 'Highlight', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_content_heading_separator_typography',
					'selector'  => '{{WRAPPER}} .slide-title .separator, {{WRAPPER}} .content-highlights',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
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
				]
			);
			$this->start_controls_tabs(
				'crafto_content_carousel_highlight_style'
			);
			$this->start_controls_tab(
				'crafto_content_carousel_highlight_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles' => 'content-carousel-style-5',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_heading_separator_colors',
					'selector'       => '{{WRAPPER}} .slide-title .separator, {{WRAPPER}} .content-highlights',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_carousel_slide_styles' => 'content-carousel-style-5',
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
					'selector'       => '{{WRAPPER}} .slide-title .horizontal-separator',
					'condition'      => [
						'crafto_enable_separator_effect' => 'yes',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Separator Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_carousel_highlight_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles' => 'content-carousel-style-5',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_highlight_color_hover',
					'selector'       => '{{WRAPPER}} .content-box:hover .slide-title .separator, {{WRAPPER}} .content-box:hover .content-highlights',
					'condition'      => [
						'crafto_carousel_slide_styles' => 'content-carousel-style-5',
					],
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
					'name'           => 'crafto_heading_title_hover_separator_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .content-box:hover .slide-title .horizontal-separator',
					'condition'      => [
						'crafto_enable_separator_effect' => 'yes',
						'crafto_carousel_slide_styles'   => 'content-carousel-style-5',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Separator Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_content_carousel_highlight_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_carousel_slide_styles' => 'content-carousel-style-5',
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
						'{{WRAPPER}} .slide-title .horizontal-separator, {{WRAPPER}} .content-highlights' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_enable_separator_effect' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_content_highlighted_border',
					'selector'  => '{{WRAPPER}} .slide-title .separator, {{WRAPPER}} .content-highlights',
					'condition' => [
						'crafto_enable_separator_effect!' => 'yes',
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
						'{{WRAPPER}} .slide-title .horizontal-separator, {{WRAPPER}} .content-highlights' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_enable_separator_effect' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_carousel_subtitle',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_subtitle_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .slide-subtitle',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_carousel_subtitle'
			);
			$this->start_controls_tab(
				'crafto_content_carousel_subtitle_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .slide-subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_carousel_subtitle_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_subtitle_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-carousel-style-5 .content-slider:hover .slide-subtitle' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_content_carousel_subtitle_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_subtitle_bg_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .slide-subtitle',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_subtitle_box_shadow',
					'selector'  => '{{WRAPPER}} .slide-subtitle',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_subtitle_spacing',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
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
						'{{WRAPPER}} .slide-subtitle:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_subtitle_box_border',
					'selector'       => '{{WRAPPER}} .slide-subtitle',
					'condition'      => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_subtitle_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .slide-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_subtitle_padding',
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
						'{{WRAPPER}} .slide-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_carousel_description',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_description_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .slide-description',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_carousel_description'
			);
			$this->start_controls_tab(
				'crafto_content_carousel_description_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .slide-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_carousel_description_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_description_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-carousel-style-5 .content-slider:hover .slide-description' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_content_carousel_description_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-1',
							'content-carousel-style-2',
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-6',
							'content-carousel-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_description_width',
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
						'{{WRAPPER}} .slide-description' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_description_spacing',
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
						'{{WRAPPER}} .slide-description' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();

			// Content button style.
			Button_Group_Control::button_style_fields(
				$this,
				[
					'id'    => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
							'content-carousel-style-7',
						],
					],
				]
			);

			// Slide button style.
			Button_Group_Control::button_style_fields(
				$this,
				[
					'id'    => 'button',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-3',
							'content-carousel-style-4',
							'content-carousel-style-5',
							'content-carousel-style-7',
						],
					],
				],
			);

			// For Carousel Slide Style 4.
			$this->start_controls_section(
				'crafto_section_style_slide_button',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_button_typography_opt',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .content-carousel-style-4 .crafto-button-wrapper .elementor-button',
				]
			);

			$this->add_control(
				'crafto_button_text_color_opt',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-carousel-style-4 .crafto-button-wrapper .elementor-button, {{WRAPPER}} .content-carousel-style-4 .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_button_bg_color_opt',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .content-carousel-style-4  a.elementor-button',
				]
			);
			$this->add_control(
				'crafto_button_box_size_opt',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 100,
							'max' => 200,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .content-carousel-style-4 .crafto-button-wrapper .elementor-button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_overlay',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_slide_overlay_enable',
				[
					'label'        => esc_html__( 'Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_slide_background_overlay',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .swiper-slide .box-image .slide-overlay, {{WRAPPER}} .content-carousel-style-5 .swiper-slide .content-slider .slide-overlay',
					'condition' => [
						'crafto_slide_overlay_enable!' => '',
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
						'crafto_navigation'             => 'yes',
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-2',
							'content-carousel-style-3',
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
						'crafto_navigation'             => 'yes',
						'crafto_carousel_slide_styles!' => [
							'content-carousel-style-2',
							'content-carousel-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_arrows_position_top',
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
						'{{WRAPPER}}.elementor-element .content-carousel-style-3 .elementor-swiper-button' => 'top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation'            => 'yes',
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 245,
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
						'.rtl {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next, .rtl {{WRAPPER}}.elementor-pagination-position-outside .elementor-swiper-button.elementor-swiper-button-next' => 'right: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_navigation'            => 'yes',
						'crafto_carousel_slide_styles' => [
							'content-carousel-style-3',
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
					'default'   => [
						'unit' => 'px',
						'size' => 25,
					],
				]
			);
			$this->add_responsive_control(
				'crafto_horizontal_spacer',
				[
					'label'      => esc_html__( 'Horizontal Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-pagination-position-inside .swiper.pagination-left:not(.number-style-3) .swiper-pagination.swiper-pagination-horizontal, {{WRAPPER}}.elementor-pagination-position-outside .swiper.pagination-left:not(.number-style-3) .swiper-pagination.swiper-pagination-horizontal, {{WRAPPER}}.elementor-pagination-position-inside .swiper.pagination-left.number-style-3 .swiper-pagination-wrapper, {{WRAPPER}}.elementor-pagination-position-outside .swiper.pagination-left.number-style-3 .swiper-pagination-wrapper' => 'padding-left: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.elementor-pagination-position-inside .swiper.pagination-right:not(.number-style-3) .swiper-pagination.swiper-pagination-horizontal, {{WRAPPER}}.elementor-pagination-position-outside .swiper.pagination-right:not(.number-style-3) .swiper-pagination.swiper-pagination-horizontal, {{WRAPPER}}.elementor-pagination-position-inside .swiper.pagination-right.number-style-3 .swiper-pagination-wrapper, {{WRAPPER}}.elementor-pagination-position-outside .swiper.pagination-right.number-style-3 .swiper-pagination-wrapper' => 'padding-right: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_pagination'           => 'yes',
						'crafto_pagination_direction' => 'horizontal',
						'crafto_pagination_h_align'   => [
							'left',
							'right',
						],
					],
					'default'    => [
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
		 * Render content carousel widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$slides   = [];
			$settings = $this->get_settings_for_display();

			$crafto_carousel_slide_styles = ( isset( $settings['crafto_carousel_slide_styles'] ) && $settings['crafto_carousel_slide_styles'] ) ? $settings['crafto_carousel_slide_styles'] : 'content-carousel-style-1';
			$is_new                       = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			switch ( $crafto_carousel_slide_styles ) {
				case 'content-carousel-style-1':
					foreach ( $settings['crafto_carousel_slider'] as $index => $item ) {
						$image_url      = '';
						$wrapper_key    = 'wrapper_' . $index;
						$img_key        = 'img_' . $index;
						$title_link_key = 'title_link_' . $index;
						$button_key     = 'button_' . $index;

						if ( ! empty( $item['crafto_carousel_image']['id'] ) ) {
							$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['crafto_carousel_image']['id'], 'crafto_thumbnail', $settings );
						} elseif ( ! empty( $item['crafto_carousel_image']['url'] ) ) {
							$image_url = $item['crafto_carousel_image']['url'];
						}

						$image_url = ( $image_url ) ? 'background-image: url("' . esc_url( $image_url ) . '"); background-repeat: no-repeat;' : '';

						$this->add_render_attribute(
							$img_key,
							[
								'class' => [
									'col',
									'cover-background',
									'content-image',
								],
								'style' => $image_url,
							],
						);
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'swiper-slide',
									'elementor-repeater-item-' . $item['_id'],
								],
							],
						);

						$icon     = '';
						$migrated = isset( $item['__fa4_migrated']['crafto_item_icon'] );
						$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

						if ( $is_new || $migrated ) {
							ob_start();
								Icons_Manager::render_icon( $item['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
							$icon .= ob_get_clean();
						} elseif ( isset( $item['crafto_item_icon']['value'] ) && ! empty( $item['crafto_item_icon']['value'] ) ) {
							$icon .= '<i class="' . esc_attr( $item['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
						}

						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
							<div class="row content-slider">
								<div class="col-sm-6 content-box">
									<?php
									if ( 'none' !== $item['crafto_item_use_image'] ) {
										if ( ! empty( $item['crafto_thumb_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_thumb_image']['id'] ) ) {
											$item['crafto_thumb_image']['id'] = '';
										}
										if ( ! empty( $icon ) && ( '' === $item['crafto_item_use_image'] ) ) {
											?>
											<div class="elementor-icon">
												<?php printf( '%s', $icon ); // phpcs:ignore ?>
											</div>
											<?php
										} elseif ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['id'] ) && ! empty( $item['crafto_thumb_image']['id'] ) ) {
												crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										} elseif ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['url'] ) && ! empty( $item['crafto_thumb_image']['url'] ) ) {
												crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										}
									}

									if ( $item['crafto_carousel_subtitle'] ) {
										?>
										<div class="slide-subtitle"><?php echo esc_html( $item['crafto_carousel_subtitle'] ); ?></div>
										<?php
									}

									if ( ! empty( $item['crafto_title_link']['url'] ) ) {
										$this->add_link_attributes( $title_link_key, $item['crafto_title_link'] );
									}

									echo $this->crafto_get_separator( $item, $index ); // phpcs:ignore

									if ( ! empty( $item['crafto_carousel_description'] ) ) {
										?>
										<div class="slide-description">
											<?php echo sprintf( '%s', wp_kses_post( $item['crafto_carousel_description'] ) ); // phpcs:ignore ?>
										</div>
										<?php
									}
									Button_Group_Control::repeater_render_button_content( $this, $item, 'button', $button_key ); // phpcs:ignore
									?>
								</div>
								<div <?php $this->print_render_attribute_string( $img_key ); // phpcs:ignore ?>></div>
							</div>
						</div>
						<?php
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'content-carousel-style-2':
					foreach ( $settings['crafto_carousel_slider'] as $index => $item ) {
						$image_url      = '';
						$index          = ++$index;
						$wrapper_key    = 'wrapper_' . $index;
						$img_key        = 'img_' . $index;
						$title_link_key = 'title_link_' . $index;
						$button_key     = 'button_' . $index;

						if ( ! empty( $item['crafto_carousel_image']['id'] ) ) {
							$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['crafto_carousel_image']['id'], 'crafto_thumbnail', $settings );
						} elseif ( ! empty( $item['crafto_carousel_image']['url'] ) ) {
							$image_url = $item['crafto_carousel_image']['url'];
						}

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'swiper-slide',
									'elementor-repeater-item-' . $item['_id'],
								],
							]
						);

						$image_url = ( ! empty( $image_url ) ) ? 'background-image: url(' . esc_url( $image_url ) . '); background-repeat: no-repeat;' : '';

						$this->add_render_attribute(
							$img_key,
							[
								'class' => [
									'cover-background',
									'content-image',
								],
								'style' => $image_url,
							]
						);

						$icon     = '';
						$migrated = isset( $item['__fa4_migrated']['crafto_item_icon'] );
						$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

						if ( $is_new || $migrated ) {
							ob_start();
								Icons_Manager::render_icon( $item['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
							$icon .= ob_get_clean();
						} elseif ( isset( $item['crafto_item_icon']['value'] ) && ! empty( $item['crafto_item_icon']['value'] ) ) {
							$icon .= '<i class="' . esc_attr( $item['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
						}

						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); // phpcs:ignore ?>>
							<div <?php $this->print_render_attribute_string( $img_key ); // phpcs:ignore ?>></div>
							<div class="content-box">
								<?php
								if ( 'none' !== $item['crafto_item_use_image'] ) {
									if ( ! empty( $icon ) && ( '' === $item['crafto_item_use_image'] ) ) {
										?>
										<div>
											<div class="elementor-icon">
												<?php printf( '%s', $icon ); // phpcs:ignore ?>
											</div>
										</div>
										<?php
									} else {
										?>
											<div>
												<?php
												if ( ! empty( $item['crafto_thumb_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_thumb_image']['id'] ) ) {
													$item['crafto_thumb_image']['id'] = '';
												}
												if ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['id'] ) && ! empty( $item['crafto_thumb_image']['id'] ) ) {
													crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
												} elseif ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['url'] ) && ! empty( $item['crafto_thumb_image']['url'] ) ) {
													crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
												}
												?>
											</div>
											<?php
									}
								}
								if ( $item['crafto_carousel_subtitle'] ) {
									?>
									<div class="slide-subtitle"><?php echo esc_html( $item['crafto_carousel_subtitle'] ); ?></div>
									<?php
								}

								if ( ! empty( $item['crafto_title_link']['url'] ) ) {
									$this->add_link_attributes( $title_link_key, $item['crafto_title_link'] );
								}

								echo $this->crafto_get_separator( $item, $index ); // phpcs:ignore

								if ( $item['crafto_carousel_description'] ) {
									?>
									<div class="slide-description">
										<?php echo sprintf( '%s', wp_kses_post( $item['crafto_carousel_description'] ) ); // phpcs:ignore ?>
									</div>
									<?php
								}
								Button_Group_Control::repeater_render_button_content( $this, $item, 'button', $button_key );
								?>
							</div>
						</div>
						<?php
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'content-carousel-style-3':
					foreach ( $settings['crafto_carousel_slider1'] as $index => $item ) {
						$image_url   = '';
						$index       = ++$index;
						$wrapper_key = 'wrapper_' . $index;
						$img_key     = 'img_' . $index;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'swiper-slide',
									'cover-background',
									'content-image',
									'elementor-repeater-item-' . $item['_id'],
								],
							]
						);
						ob_start();
						?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
							<?php
							if ( ! empty( $item['crafto_carousel_image1']['id'] ) && ! wp_attachment_is_image( $item['crafto_carousel_image1']['id'] ) ) {
								$item['crafto_carousel_image1']['id'] = '';
							}
							if ( isset( $item['crafto_carousel_image1'] ) && isset( $item['crafto_carousel_image1']['id'] ) && ! empty( $item['crafto_carousel_image1']['id'] ) ) {
								crafto_get_attachment_html( $item['crafto_carousel_image1']['id'], $item['crafto_carousel_image1']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $item['crafto_carousel_image1'] ) && isset( $item['crafto_carousel_image1']['url'] ) && ! empty( $item['crafto_carousel_image1']['url'] ) ) {
								crafto_get_attachment_html( $item['crafto_carousel_image1']['id'], $item['crafto_carousel_image1']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							?>
							</div>
							<?php
							$slides[] = ob_get_contents();
							ob_end_clean();
					}
					break;
				case 'content-carousel-style-4':
					foreach ( $settings['crafto_carousel_slider'] as $index => $item ) {
						$image_url      = '';
						$wrapper_key    = 'wrapper_' . $index;
						$img_key        = 'img_' . $index;
						$title_link_key = 'title_link_' . $index;
						$button_key     = 'button_' . $index;
						$is_new         = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'swiper-slide',
									'elementor-repeater-item-' . $item['_id'],
								],
							],
						);

						$icon     = '';
						$migrated = isset( $item['__fa4_migrated']['crafto_item_icon'] );
						$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

						if ( $is_new || $migrated ) {
							ob_start();
								Icons_Manager::render_icon( $item['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
							$icon .= ob_get_clean();
						} elseif ( isset( $item['crafto_item_icon']['value'] ) && ! empty( $item['crafto_item_icon']['value'] ) ) {
							$icon .= '<i class="' . esc_attr( $item['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
						}

						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
							<div class="box-image">
							<?php
							if ( ! empty( $item['crafto_carousel_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_carousel_image']['id'] ) ) {
								$item['crafto_carousel_image']['id'] = '';
							}
							if ( isset( $item['crafto_carousel_image'] ) && isset( $item['crafto_carousel_image']['id'] ) && ! empty( $item['crafto_carousel_image']['id'] ) ) {
								crafto_get_attachment_html( $item['crafto_carousel_image']['id'], $item['crafto_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $item['crafto_carousel_image'] ) && isset( $item['crafto_carousel_image']['url'] ) && ! empty( $item['crafto_carousel_image']['url'] ) ) {
								crafto_get_attachment_html( $item['crafto_carousel_image']['id'], $item['crafto_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							?>
								<?php
								if ( 'yes' === $settings['crafto_slide_overlay_enable'] ) {
									?>
									<div class="slide-overlay"></div>
									<?php
								}
								?>
								<?php
								Button_Group_Control::repeater_render_button_content( $this, $item, 'button', $button_key );
								?>
							</div>
							<div class="carousel-content-wrap">
								<?php
								if ( $item['crafto_carousel_subtitle'] ) {
									?>
									<div class="slide-subtitle"><?php echo esc_html( $item['crafto_carousel_subtitle'] ); ?></div>
									<?php
								}

								if ( ! empty( $item['crafto_title_link']['url'] ) ) {
									$this->add_link_attributes( $title_link_key, $item['crafto_title_link'] );
								}

								echo $this->crafto_get_separator( $item, $index ); // phpcs:ignore

								if ( $item['crafto_carousel_description'] ) {
									?>
									<div class="slide-description">
										<?php echo sprintf( '%s', wp_kses_post( $item['crafto_carousel_description'] ) ); // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
							</div>
						</div>
						<?php
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'content-carousel-style-5':
					foreach ( $settings['crafto_carousel_slider'] as $index => $item ) {
						$image_url      = '';
						$wrapper_key    = 'wrapper_' . $index;
						$img_key        = 'img_' . $index;
						$title_link_key = 'title_link_' . $index;
						$button_key     = 'button_' . $index;

						if ( ! empty( $item['crafto_carousel_image']['id'] ) ) {
							$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['crafto_carousel_image']['id'], 'crafto_thumbnail', $settings );
						} elseif ( ! empty( $item['crafto_carousel_image']['url'] ) ) {
							$image_url = $item['crafto_carousel_image']['url'];
						}

						$image_url = ( $image_url ) ? 'background-image: url(' . esc_url( $image_url ) . '); background-repeat: no-repeat;' : '';

						$this->add_render_attribute(
							$img_key,
							[
								'class' => [
									'col-sm-6',
									'cover-background',
									'content-image',
								],
								'style' => $image_url,
							],
						);
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'swiper-slide',
									'elementor-repeater-item-' . $item['_id'],
								],
							],
						);

						$icon     = '';
						$migrated = isset( $item['__fa4_migrated']['crafto_item_icon'] );
						$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

						if ( $is_new || $migrated ) {
							ob_start();
								Icons_Manager::render_icon( $item['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
							$icon .= ob_get_clean();
						} elseif ( isset( $item['crafto_item_icon']['value'] ) && ! empty( $item['crafto_item_icon']['value'] ) ) {
							$icon .= '<i class="' . esc_attr( $item['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
						}

						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
							<div class="row content-slider">
								<div class="col-sm-6 content-box">
									<div class="content-wrap">
										<?php
										if ( 'none' !== $item['crafto_item_use_image'] ) {
											if ( ! empty( $icon ) && ( '' === $item['crafto_item_use_image'] ) ) {
												?>
												<div>
													<div class="elementor-icon">
														<?php printf( '%s', $icon ); // phpcs:ignore ?>
													</div>
												</div>
												<?php
											} else {
												?>
												<div>
													<?php
													if ( ! empty( $item['crafto_thumb_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_thumb_image']['id'] ) ) {
														$item['crafto_thumb_image']['id'] = '';
													}
													if ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['id'] ) && ! empty( $item['crafto_thumb_image']['id'] ) ) {
														crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
													} elseif ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['url'] ) && ! empty( $item['crafto_thumb_image']['url'] ) ) {
														crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
													}
													?>
												</div>
												<?php
											}
										}

										if ( $item['crafto_carousel_subtitle'] ) {
											?>
											<div class="slide-subtitle"><?php echo esc_html( $item['crafto_carousel_subtitle'] ); ?></div>
											<?php
										}

										if ( ! empty( $item['crafto_title_link']['url'] ) ) {
											$this->add_link_attributes( $title_link_key, $item['crafto_title_link'] );
										}

										echo $this->crafto_get_separator( $item, $index ); // phpcs:ignore

										if ( ! empty( $item['crafto_carousel_description'] ) ) {
											?>
											<div class="slide-description">
												<?php echo sprintf( '%s', wp_kses_post( $item['crafto_carousel_description'] ) ); // phpcs:ignore ?>
											</div>
											<?php
										}
										?>
									</div>
									<?php
									if ( 'yes' === $settings['crafto_slide_overlay_enable'] ) {
										?>
										<div class="slide-overlay"></div>
										<?php
									}
									?>
								</div>
								<div <?php $this->print_render_attribute_string( $img_key ); ?>>
									<?php
									if ( $item['crafto_carousel_number'] ) {
										?>
										<span class="slide-number"><?php echo esc_html( $item['crafto_carousel_number'] ); ?></span>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<?php
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'content-carousel-style-6':
					foreach ( $settings['crafto_carousel_slider'] as $index => $item ) {
						$image_url      = '';
						$wrapper_key    = 'wrapper_' . $index;
						$img_key        = 'img_' . $index;
						$title_link_key = 'title_link_' . $index;
						$title_key      = 'title_' . $index;
						$button_key     = 'button_' . $index;
						$this->add_render_attribute(
							$img_key,
							[
								'class' => [
									'content-image',
								],
							],
						);
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'swiper-slide',
									'elementor-repeater-item-' . $item['_id'],
								],
							],
						);

						if ( ! empty( $item['crafto_title_link']['url'] ) ) {
							$this->add_link_attributes( $title_link_key, $item['crafto_title_link'] );
						}

						$this->add_render_attribute(
							$title_key,
							[
								'class' => [
									'slide-title',
								],
							]
						);

						$icon     = '';
						$migrated = isset( $item['__fa4_migrated']['crafto_item_icon'] );

						if ( $is_new || $migrated ) {
							ob_start();
								Icons_Manager::render_icon( $item['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
							$icon .= ob_get_clean();
						} elseif ( isset( $item['crafto_item_icon']['value'] ) && ! empty( $item['crafto_item_icon']['value'] ) ) {
							$icon .= '<i class="' . esc_attr( $item['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
						}

						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div <?php $this->print_render_attribute_string( $img_key ); ?>>
								<?php
								if ( ! empty( $item['crafto_carousel_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_carousel_image']['id'] ) ) {
									$item['crafto_carousel_image']['id'] = '';
								}
								if ( isset( $item['crafto_carousel_image'] ) && isset( $item['crafto_carousel_image']['id'] ) && ! empty( $item['crafto_carousel_image']['id'] ) ) {
									crafto_get_attachment_html( $item['crafto_carousel_image']['id'], $item['crafto_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
								} elseif ( isset( $item['crafto_carousel_image'] ) && isset( $item['crafto_carousel_image']['url'] ) && ! empty( $item['crafto_carousel_image']['url'] ) ) {
									crafto_get_attachment_html( $item['crafto_carousel_image']['id'], $item['crafto_carousel_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
								}
								?>
								</div>
								<div class="content-wrap">
								<?php
								if ( 'none' !== $item['crafto_item_use_image'] ) {
									if ( ! empty( $icon ) && ( '' === $item['crafto_item_use_image'] ) ) {
										?>
										<div>
											<div class="elementor-icon">
												<?php printf( '%s', $icon ); // phpcs:ignore ?>
											</div>
										</div>
										<?php
									} else {
										?>
										<div>
											<?php
											if ( ! empty( $item['crafto_thumb_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_thumb_image']['id'] ) ) {
												$item['crafto_thumb_image']['id'] = '';
											}
											if ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['id'] ) && ! empty( $item['crafto_thumb_image']['id'] ) ) {
												crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
											} elseif ( isset( $item['crafto_thumb_image'] ) && isset( $item['crafto_thumb_image']['url'] ) && ! empty( $item['crafto_thumb_image']['url'] ) ) {
												crafto_get_attachment_html( $item['crafto_thumb_image']['id'], $item['crafto_thumb_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
											}
											?>
										</div>
										<?php
									}
								}

								if ( $item['crafto_carousel_subtitle'] ) {
									?>
									<div class="slide-subtitle"><?php echo esc_html( $item['crafto_carousel_subtitle'] ); ?></div>
									<?php
								}

								echo $this->crafto_get_separator( $item, $index ); // phpcs:ignore

								if ( ! empty( $item['crafto_carousel_description'] ) ) {
									?>
									<div class="slide-description">
										<?php echo sprintf( '%s', wp_kses_post( $item['crafto_carousel_description'] ) ); // phpcs:ignore ?>
									</div>
									<?php
								}
								Button_Group_Control::repeater_render_button_content( $this, $item, 'button', $button_key );
								?>
							</div>
						</div>
						<?php
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'content-carousel-style-7':
					foreach ( $settings['crafto_carousel_slider1'] as $index => $item ) {
						$image_url   = '';
						$index       = ++$index;
						$wrapper_key = 'wrapper_' . $index;
						$img_key     = 'img_' . $index;

						if ( ! empty( $item['crafto_carousel_image1']['id'] ) ) {
							$image_url = Group_Control_Image_Size::get_attachment_image_src( $item['crafto_carousel_image1']['id'], 'crafto_thumbnail', $settings );
						} elseif ( ! empty( $item['crafto_carousel_image1']['url'] ) ) {
							$image_url = $item['crafto_carousel_image1']['url'];
						}
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'swiper-slide',
									'cover-background',
									'content-image',
									'elementor-repeater-item-' . $item['_id'],
								],
							]
						);
						$bg_style_attr = ! empty( $image_url ) ? 'style="background-image: url(\'' . esc_url( $image_url ) . '\');"' : '';
						ob_start();
						if ( ! empty( $image_url ) ) {
							?>
							<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
								<div class="bg-img" <?php echo $bg_style_attr; //phpcs:ignore ?>></div>
							</div>
							<?php
						}
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
			}

			if ( empty( $slides ) ) {
				return;
			}

			$slides_counts = ( ! empty( $settings['crafto_carousel_slider1'] ) ) ? count( $settings['crafto_carousel_slider1'] ) : 0;
			$slides_count  = ( ! empty( $settings['crafto_carousel_slider'] ) ) ? count( $settings['crafto_carousel_slider'] ) : 0;

			$crafto_slide_styles            = $this->get_settings( 'crafto_carousel_slide_styles' );
			$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
			$crafto_slider_cursor           = $this->get_settings( 'crafto_slider_cursor' );
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
				'navigation'       => $crafto_navigation,
				'pagination'       => $crafto_pagination,
				'pagination_style' => $crafto_pagination_style,
				'number_style'     => $crafto_pagination_number_style,
				'autoplay'         => $this->get_settings( 'crafto_autoplay' ),
				'autoplay_speed'   => $this->get_settings( 'crafto_autoplay_speed' ),
				'pause_on_hover'   => $this->get_settings( 'crafto_pause_on_hover' ),
				'loop'             => $this->get_settings( 'crafto_infinite' ),
				'speed'            => $this->get_settings( 'crafto_speed' ),
				'effect'           => $this->get_settings( 'crafto_effect' ),
				'image_spacing'    => $this->get_settings( 'crafto_items_spacing' ),
				'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
				'minheight'        => $this->get_settings( 'crafto_minheight' ),
			);

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
				],
			);

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

			$slide_options  = array();
			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}

			switch ( $crafto_slide_styles ) {
				case 'content-carousel-style-1':
					$slide_options = array(
						'centered_slides' => $this->get_settings( 'crafto_centered_slides' ),
					);
					break;
			}

			$slide_settings_arr = array_merge( $sliderconfig, $slide_options );

			$this->add_render_attribute(
				[
					'carousel-wrapper'       => [
						'class'         => [
							$crafto_slide_styles,
							'swiper',
							$crafto_slider_cursor,
							$magic_cursor,
						],
						'data-settings' => wp_json_encode( $slide_settings_arr ),
					],
					'carousel'               => [
						'class' => [
							'swiper-wrapper',
						],
					],
					'carousel-wrapper-inner' => [
						'class' => [
							'content-carousel-content-box',
						],
					],
				],
			);

			if ( ! empty( $crafto_rtl ) ) {
				$this->add_render_attribute( 'carousel-wrapper', 'dir', $crafto_rtl );
			}

			if ( 'yes' === $this->get_settings( 'crafto_image_stretch' ) ) {
				$this->add_render_attribute(
					'carousel',
					'class',
					'swiper-image-stretch',
				);
			}

			switch ( $this->get_settings( 'crafto_feather_shadow' ) ) {
				case 'both':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow' );
					break;
				case 'right':
					$this->add_render_attribute( 'carousel-wrapper', 'class', 'feather-shadow-right' );
					break;
			}

			$this->add_render_attribute(
				'carousel_content',
				[
					'class' => [
						'carousel-content',
					],
				],
			);

			$this->add_render_attribute(
				'carousel_wrapper',
				[
					'class' => [
						'content-carousel-wrapper',
					],
				],
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
			if ( 'content-carousel-style-2' === $crafto_slide_styles ) {
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
			if ( 'content-carousel-style-3' === $crafto_slide_styles ) {
				?>
				<div <?php $this->print_render_attribute_string( 'carousel-wrapper-inner' ); ?>>
					<div <?php $this->print_render_attribute_string( 'carousel_content' ); ?>>
						<?php
						if ( ! empty( $settings['crafto_carousel_subheading'] ) ) {
							?>
							<div class="subheading"><?php echo esc_html( $settings['crafto_carousel_subheading'] ); ?></div>
							<?php
						}
						if ( ! empty( $settings['crafto_carousel_heading'] ) ) {
							?>
							<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> class="heading"><?php echo esc_html( $settings['crafto_carousel_heading'] ); ?>
							</<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
							<?php
						}
						if ( ! empty( $settings['crafto_carousel_content'] ) ) {
							?>
							<div class="content">
								<?php echo sprintf( '%s', wp_kses_post( $settings['crafto_carousel_content'] ) ); // phpcs:ignore ?>
							</div>
							<?php
						}
						Button_Group_Control::render_button_content( $this, 'primary' );
						?>
					</div>
					<div <?php $this->print_render_attribute_string( 'carousel_wrapper' ); ?>>
				<?php
			}
			if ( 'content-carousel-style-7' === $crafto_slide_styles ) {
				if ( ! empty( $settings['crafto_carousel_subheading'] ) || ! empty( $settings['crafto_carousel_heading'] ) || ! empty( $settings['crafto_carousel_content'] ) ) {
					?>
					<div <?php $this->print_render_attribute_string( 'carousel-wrapper-inner' ); ?>>
						<div <?php $this->print_render_attribute_string( 'carousel_content' ); ?>>
							<?php
							if ( ! empty( $settings['crafto_carousel_subheading'] ) ) {
								?>
								<div class="vertical-title">
								<div class="subheading fancy-text-rotator" data-fancy-text='{"opacity": [0, 1], "translateY": [50, 0], "filter": ["blur(20px)", "blur(0px)"], "string": ["<?php echo esc_html( $settings['crafto_carousel_subheading'] ); ?>"], "duration": 400, "delay": 0, "speed": 50, "easing": "easeOutQuad"}'><?php echo esc_html( $settings['crafto_carousel_subheading'] ); ?></div>
								</div>
								<?php
							}
							?>
							<div class="content-box">
								<?php
								if ( ! empty( $settings['crafto_carousel_heading'] ) ) {
									?>
									<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> class="heading"><?php echo esc_html( $settings['crafto_carousel_heading'] ); ?>
									</<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
									<?php
								}
								if ( ! empty( $settings['crafto_carousel_content'] ) ) {
									?>
									<div class="content">
										<?php echo sprintf( '%s', wp_kses_post( $settings['crafto_carousel_content'] ) ); // phpcs:ignore ?>
									</div>
									<?php
								}
								Button_Group_Control::render_button_content( $this, 'primary' );
								?>
							</div>
						</div>
						<div <?php $this->print_render_attribute_string( 'carousel_wrapper' ); ?>>
					<?php
				}
			}
			?>
			<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
					<?php echo implode( '', $slides ); // phpcs:ignore ?>
				</div>
				<?php
				if ( 1 < $slides_count || 1 < $slides_counts ) {
					get_swiper_pagination( $settings ); // phpcs:ignore
				}
				?>
			</div>
			<?php
			if ( 'content-carousel-style-3' === $crafto_slide_styles || 'content-carousel-style-7' === $crafto_slide_styles ) {
				?>
				</div>
				</div>
				<?php
			}
		}

		/**
		 * Return icon image
		 *
		 * @param array $item data.
		 * @param array $index data.
		 */
		public function crafto_get_separator( $item, $index ) {

			$crafto_carousel_separator      = '';
			$settings                       = $this->get_settings_for_display();
			$crafto_carousel_title          = ( isset( $item['crafto_carousel_title'] ) && ! empty( $item['crafto_carousel_title'] ) ) ? $item['crafto_carousel_title'] : '';
			$crafto_enable_separator_effect = ( isset( $settings['crafto_enable_separator_effect'] ) && $settings['crafto_enable_separator_effect'] ) ? $settings['crafto_enable_separator_effect'] : '';
			$title_link_key                 = 'title_link_' . $index;

			if ( $crafto_carousel_title ) {
				if ( 'yes' === $crafto_enable_separator_effect ) {
					?>
					<<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?> class="slide-title slider-shadow-animation shadow-animation" data-animation-delay="700">
					<?php
				} else {
					?>
					<<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?> class="slide-title no-animation">
					<?php
				}
				if ( ! empty( $item['crafto_title_link']['url'] ) ) {
					?>
					<a <?php $this->print_render_attribute_string( $title_link_key ); ?>>
					<?php
				}
				if ( has_shortcode( $crafto_carousel_title, 'crafto_highlight' ) ) {
					if ( 'yes' === $crafto_enable_separator_effect ) {
						$crafto_carousel_title = str_replace( '[crafto_highlight]', '<span class="separator">', $crafto_carousel_title );
						$crafto_carousel_title = str_replace( '[/crafto_highlight]', '<span class="separator-animation horizontal-separator"></span></span>', $crafto_carousel_title );
					} else {
						$crafto_carousel_title = str_replace( '[crafto_highlight]', '<span class="separator">', $crafto_carousel_title );
						$crafto_carousel_title = str_replace( '[/crafto_highlight]', '</span>', $crafto_carousel_title );
					}
				}
				echo sprintf( '%s', $crafto_carousel_title ); // phpcs:ignore
				if ( ! empty( $item['crafto_title_link']['url'] ) ) {
					?>
					</a>
					<?php
				}
				?>
				</<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>>
				<?php
			}
			return $crafto_carousel_separator;
		}
	}
}
