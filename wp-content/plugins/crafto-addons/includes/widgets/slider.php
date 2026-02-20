<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Button_Group_Control;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget for slider.
 *
 * @package Crafto
 */

// If class `Slider` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Slider' ) ) {
	/**
	 * Define `Slider` class.
	 */
	class Slider extends Widget_Base {
		/**
		 * Retrieve the list of scripts the slider widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$slider_scripts = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$slider_scripts[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$slider_scripts[] = 'swiper';
					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$slider_scripts[] = 'crafto-magic-cursor';
					}
				}

				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$slider_scripts[] = 'imagesloaded';
				}

				if ( '0' === $crafto_disable_all_animation ) {
					if ( crafto_disable_module_by_key( 'appear' ) ) {
						$slider_scripts[] = 'appear';
					}

					if ( crafto_disable_module_by_key( 'anime' ) ) {
						$slider_scripts[] = 'anime';
						$slider_scripts[] = 'splitting';
						$slider_scripts[] = 'crafto-fancy-text-effect';
					}
				}
				$slider_scripts[] = 'crafto-slider-widget';
			}

			return $slider_scripts;
		}

		/**
		 * Retrieve the list of styles the slider widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$slider_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$slider_styles[] = 'crafto-vendors-rtl';
				} else {
					$slider_styles[] = 'crafto-vendors';
				}
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$slider_styles[] = 'swiper';
					$slider_styles[] = 'nav-pagination';

					if ( is_rtl() ) {
						$slider_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$slider_styles[] = 'crafto-magic-cursor';
					}
				}

				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					$slider_styles[] = 'splitting';
				}

				if ( is_rtl() ) {
					$slider_styles[] = 'crafto-slider-rtl-widget';
				}
				$slider_styles[] = 'crafto-slider-widget';
			}

			return $slider_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-slider';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Slider', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
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
			return 'https://crafto.themezaa.com/documentation/slider/';
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
				'slide',
				'carousel',
				'slider',
				'hero',
				'banner',
			];
		}

		/**
		 * Register slider widget controls.
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
				'crafto_carousel_slide_styles',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'slider-style-1',
					'options'            => [
						'slider-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'slider-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'slider-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_image_carousel',
				[
					'label'     => esc_html__( 'Slides', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles!' => [
							'slider-style-2',
						],
					],
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs(
				'crafto_carousel_image_tabs',
			);
			$repeater->start_controls_tab(
				'crafto_carousel_image_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_carousel_title',
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
				'crafto_slider_carousel_description',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<div style ="font-style:normal">To add the highlighted text use shortcode like:<br/><br/> <span style="font-weight:bold">[crafto_highlight]</span> Your Text <span style="font-weight:bold">[/crafto_highlight]</span></div>', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$repeater->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Link On Title', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_carousel_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write Number here', 'crafto-addons' ),
					'label_block' => true,
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
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write description here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_carousel_splash_text',
				[
					'label'       => esc_html__( 'Splash Text', 'crafto-addons' ),
					'type'        => Controls_Manager::WYSIWYG,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write splash text here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_carousel_content_image_background',
				[
					'label'       => esc_html__( 'Background Image', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'dynamic'     => [
						'active' => true,
					],
					'description' => esc_html__( 'Applicable in style 3 only.', 'crafto-addons' ),
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_carousel_button_tab',
				[
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
			);

			Button_Group_Control::repeater_button_content_fields(
				$repeater,
				[
					'id'      => 'primary',
					'label'   => esc_html__( 'Primary Button', 'crafto-addons' ),
					'default' => esc_html__( 'Click here', 'crafto-addons' ),
				],
			);

			Button_Group_Control::repeater_button_content_fields(
				$repeater,
				[
					'id'      => 'secondary',
					'label'   => esc_html__( 'Secondary Button', 'crafto-addons' ),
					'default' => esc_html__( 'Click here', 'crafto-addons' ),
				],
			);

			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'crafto_carousel_image_background_tab',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
				]
			);

			$repeater->add_control(
				'crafto_carousel_image_background',
				[
					'label'   => esc_html__( 'Desktop Image', 'crafto-addons' ),
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
				'crafto_carousel_image_background_mobile',
				[
					'label'   => esc_html__( 'Mobile Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();

			$this->add_control(
				'crafto_carousel_slider',
				[
					'label'       => esc_html__( 'Slider Items', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_carousel_title'    => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_carousel_number'   => esc_html__( '01', 'crafto-addons' ),
							'crafto_carousel_subtitle' => esc_html__( 'Write subtitle here', 'crafto-addons' ),
						],
						[
							'crafto_carousel_title'    => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_carousel_number'   => esc_html__( '02', 'crafto-addons' ),
							'crafto_carousel_subtitle' => esc_html__( 'Write subtitle here', 'crafto-addons' ),
						],
					],
					'condition'   => [
						'crafto_carousel_slide_styles!' => [
							'slider-style-2',
						],
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_property_image_carousel',
				[
					'label'     => esc_html__( 'Slides', 'crafto-addons' ),
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$repeater1 = new Repeater();
			$repeater1->start_controls_tabs(
				'crafto_carousel_image_tabs',
			);
			$repeater1->start_controls_tab(
				'crafto_carousel_image_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$repeater1->add_control(
				'crafto_carousel_title',
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
			$repeater1->add_control(
				'crafto_slider_carousel_description',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( __( '<div style ="font-style:normal">To add the highlighted text use shortcode like:<br/><br/> <span style="font-weight:bold">[crafto_highlight]</span> Your Text <span style="font-weight:bold">[/crafto_highlight]</span></div>', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$repeater1->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Link On Title', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				],
			);
			$repeater1->add_control(
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
			$repeater1->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'recommended'      =>
					[
						'fa-solid' => [
							'angle-left',
							'angle-right',
							'long-arrow-alt-left',
							'long-arrow-alt-right',
						],
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'default'          => [
						'value'   => 'fab fa-ello',
						'library' => 'fa-brands',
					],
				]
			);
			$repeater1->add_control(
				'crafto_icon_description',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write description here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater1->add_control(
				'crafto_second_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'recommended'      =>
					[
						'fa-solid' => [
							'angle-left',
							'angle-right',
							'long-arrow-alt-left',
							'long-arrow-alt-right',
						],
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'default'          => [
						'value'   => 'fab fa-ello',
						'library' => 'fa-brands',
					],
				]
			);
			$repeater1->add_control(
				'crafto_second_icon_description',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write description here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater1->add_control(
				'crafto_third_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'recommended'      =>
					[
						'fa-solid' => [
							'angle-left',
							'angle-right',
							'long-arrow-alt-left',
							'long-arrow-alt-right',
						],
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'default'          => [
						'value'   => 'fab fa-ello',
						'library' => 'fa-brands',
					],
				]
			);
			$repeater1->add_control(
				'crafto_third_icon_description',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write description here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater1->add_control(
				'crafto_property_description',
				[
					'label'       => esc_html__( 'Property Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write description here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater1->add_control(
				'crafto_property_price',
				[
					'label'       => esc_html__( 'Price', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( '$150', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater1->end_controls_tab();

			$repeater1->start_controls_tab(
				'crafto_carousel_buttons_tab',
				[
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
			);

			Button_Group_Control::repeater_button_content_fields(
				$repeater1,
				[
					'id'      => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => esc_html__( 'Click here', 'crafto-addons' ),
				],
			);
			Button_Group_Control::repeater_button_content_fields(
				$repeater1,
				[
					'id'      => 'secondary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => esc_html__( 'Click here', 'crafto-addons' ),
				],
			);

			$repeater1->end_controls_tab();

			$repeater1->start_controls_tab(
				'crafto_carousel_image_background_tab',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
				]
			);
			$repeater1->add_control(
				'crafto_carousel_repeater1_image_background',
				[
					'label'   => esc_html__( 'Desktop Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);

			$repeater1->add_control(
				'crafto_carousel_repeater1_image_background_mobile',
				[
					'label'   => esc_html__( 'Mobile Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$repeater1->end_controls_tab();
			$repeater1->end_controls_tabs();

			$this->add_control(
				'crafto_property_carousel_slider',
				[
					'label'       => esc_html__( 'Slider Items', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater1->get_controls(),
					'default'     => [
						[
							'crafto_carousel_title'    => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_carousel_subtitle' => esc_html__( 'Write subtitle here', 'crafto-addons' ),
							'crafto_selected_icon'     => [
								'value'   => 'fab fa-ello',
								'library' => 'fa-brands',
							],
						],
						[
							'crafto_carousel_title'    => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_carousel_subtitle' => esc_html__( 'Write subtitle here', 'crafto-addons' ),
						],
					],
					'condition'   => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$this->end_controls_section();
			Button_Group_Control::repeater_button_setting_fields(
				$this,
				[
					'id'    => 'primary',
					'label' => esc_html__( 'Primary Button', 'crafto-addons' ),
				],
			);

			Button_Group_Control::repeater_button_setting_fields(
				$this,
				[
					'id'    => 'secondary',
					'label' => esc_html__( 'Secondary Button', 'crafto-addons' ),
				],
			);
			$this->start_controls_section(
				'crafto_content_setting',
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
				'crafto_title_animation',
				[
					'label' => esc_html__( 'Title Effect', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_title_data_fancy_text_settings',
				[
					'label'        => esc_html__( 'Enable Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_effect',
				[
					'label'     => esc_html__( 'Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'wave',
					'options'   => [
						'wave'        => esc_html__( 'Wave', 'crafto-addons' ),
						'smooth-wave' => esc_html__( 'Smooth Wave', 'crafto-addons' ),
						'curve'       => esc_html__( 'Curve', 'crafto-addons' ),
						'rotate'      => esc_html__( 'Rotate', 'crafto-addons' ),
						'slide'       => esc_html__( 'Slide', 'crafto-addons' ),
						'jump'        => esc_html__( 'Jump', 'crafto-addons' ),
						'zoom'        => esc_html__( 'Zoom', 'crafto-addons' ),
						'rubber-band' => esc_html__( 'Rubber Band', 'crafto-addons' ),
						'fade'        => esc_html__( 'Fade', 'crafto-addons' ),
						'custom'      => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_colors',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffe400',
					'condition' => [
						'crafto_title_data_fancy_text_settings_effect' => 'slide',
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						's' => [
							'min'  => 10,
							'max'  => 3000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 's',
					],
					'condition'  => [
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						's' => [
							'min'  => 3000,
							'max'  => 10000,
							'step' => 100,
						],
					],
					'default'    => [
						'unit' => 's',
					],
					'condition'  => [
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_speed',
				[
					'label'      => esc_html__( 'Speed', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 500,
							'step' => 5,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_translate_x',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_translate_y',
				[
					'label'     => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_rotate',
				[
					'label'     => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_rotate',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_rotate',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_filter_settings_popover',
				[
					'label'        => esc_html__( 'Blur', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_blur',
				[
					'label'     => esc_html__( 'Blur', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_filter',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_filter',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_clippath_settings_popover',
				[
					'label'        => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_clippath',
				[
					'label'     => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_clippath',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 1,
						],
					],
					'condition'  => [
						'crafto_title_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_clippath',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 1,
						],
					],
					'condition'  => [
						'crafto_title_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_animation',
				[
					'label' => esc_html__( 'Entrance Animation', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_entrance_animation',
				[
					'label'     => esc_html__( 'Title Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'crafto_title_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_title_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_title_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_title_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_title_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_title_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_title_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_title_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->add_control(
				'crafto_subtitle_data_anime_animation',
				[
					'label'     => esc_html__( 'Subtitle Text Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'crafto_subtitle_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',					
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_subtitle_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_subtitle_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_subtitle_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_subtitle_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_subtitle_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_subtitle_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->add_control(
				'crafto_splash_data_anime_animation',
				[
					'label'     => esc_html__( 'Splash Text Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-1',
					],
				]
			);

			$this->add_control(
				'crafto_splash_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-1',
					],
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_splash_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_splash_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_splash_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_splash_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_splash_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_splash_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_splash_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_splash_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_splash_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_splash_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_splash_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_splash_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_splash_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_splash_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_splash_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_splash_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_splash_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_splash_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_splash_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_splash_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_splash_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_splash_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_splash_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_splash_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_splash_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();


			$this->add_control(
				'crafto_description_data_anime_animation',
				[
					'label'     => esc_html__( 'Description Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'crafto_description_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_description_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_description_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_description_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_description_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_description_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_description_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_description_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_description_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_description_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_description_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_description_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_description_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_description_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_description_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_description_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_description_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_description_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_description_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_description_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_description_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_description_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_description_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_description_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_description_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_description_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_description_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_description_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();



			$this->add_control(
				'crafto_number_data_anime_animation',
				[
					'label'     => esc_html__( 'Number Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-1',
					],
				]
			);

			$this->add_control(
				'crafto_number_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-1',
					],
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_number_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_number_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_number_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_number_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_number_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_number_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_number_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_number_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_number_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_number_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_number_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_number_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_number_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_number_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_number_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_number_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_number_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_number_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_number_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_number_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_number_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_number_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_number_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_number_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_number_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_number_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_number_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();


			$this->add_control(
				'crafto_button_data_anime_animation',
				[
					'label'     => esc_html__( 'Button Text Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'crafto_button_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_button_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_button_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_button_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_button_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_button_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_button_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_button_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_button_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_button_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_button_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_button_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_button_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_button_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_button_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_button_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_button_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_button_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_button_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_button_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_button_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_button_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_button_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_button_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_button_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_button_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_button_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_button_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->add_control(
				'crafto_image_data_anime_animation',
				[
					'label'     => esc_html__( 'Image Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-1',
					],
				]
			);

			$this->add_control(
				'crafto_image_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-1',
					],
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_image_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_image_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_image_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_image_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_image_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_image_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_image_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_image_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_image_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_image_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_image_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_image_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_image_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_image_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_image_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_image_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_image_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_image_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_image_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_image_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_image_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_image_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_image_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_image_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_image_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_image_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_image_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();



			$this->add_control(
				'crafto_content_box_data_anime_animation',
				[
					'label'     => esc_html__( 'Content Box Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-2',
					],
				]
			);

			$this->add_control(
				'crafto_content-box_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-2',
					],
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content-box_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_content-box_ent_settings_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_content-box_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_content-box_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_settings_start_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_content-box_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_content-box_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_stagger',
				[
					'label'      => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content-box_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_translate_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content-box_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_x_opacity',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_y_opacity',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content-box_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotation_xx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotation_xy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_content-box_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotation_yx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotation_yy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'  => 'after',
					'condition'  => [
						'crafto_content-box_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotation_zx',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_rotation_zy',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content-box_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_perspective_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_perspective_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content-box_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content-box_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_scale_x',
				[
					'label'      => esc_html__( 'Start', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content-box_ent_anim_opt_scale_y',
				[
					'label'      => esc_html__( 'End', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_content-box_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();



			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_carousel_setting',
				[
					'label' => esc_html__( 'Slider Settings', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'           => 'crafto_thumbnail',
					'default'        => 'full',
					'exclude'        => [
						'custom',
					],
					'separator'      => 'none',
					'fields_options' => [
						'size' => [
							'label' => esc_html__( 'Image Resolution for Desktop', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'           => 'crafto_thumbnail_mobile',
					'default'        => 'medium',
					'exclude'        => [
						'custom',
					],
					'separator'      => 'none',
					'fields_options' => [
						'size' => [
							'label' => esc_html__( 'Image Resolution for Device', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slider_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 2000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper' => 'height: {{SIZE}}{{UNIT}} !important',
					],
				]
			);
			$this->add_control(
				'crafto_full_screen',
				[
					'label'        => esc_html__( 'Full Screen Height', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
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
					'default'   => 5000,
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
					'default'      => '',
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
					'default'      => 'no',
					'return_value' => 'yes',

				]
			);
			$this->add_control(
				'crafto_mousewheel',
				[
					'label'        => esc_html__( 'Enable Mousewheel', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_parallax',
				[
					'label'        => esc_html__( 'Enable Parallax', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_slide_parallax_amount',
				[
					'label'     => esc_html__( 'Swiper Amount', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 1000,
					'condition' => [
						'crafto_parallax' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_slide_parallax_container_amount',
				[
					'label'     => esc_html__( 'Swiper Container Amount', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 100,
					'condition' => [
						'crafto_parallax' => 'yes',
					],
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
				'crafto_direction',
				[
					'label'        => esc_html__( 'Direction', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'horizontal',
					'options'      => [
						'horizontal' => esc_html__( 'Horizontal', 'crafto-addons' ),
						'vertical'   => esc_html__( 'Vertical', 'crafto-addons' ),
					],
					'prefix_class' => 'pagination-direction-',
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
						'crafto_pagination' => 'yes',
						'crafto_direction'  => 'horizontal',
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
					'prefix_class' => 'pagination-vertical-',
					'toggle'       => true,
					'condition'    => [
						'crafto_pagination' => 'yes',
						'crafto_direction'  => 'vertical',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_content_max_width',
				[
					'label'      => esc_html__( 'Content Block Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-text-middle-main, {{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal .swiper-pagination-bullets.swiper-pagination-horizontal, {{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.number-style-3 .swiper-pagination-wrapper' => 'max-width: {{SIZE}}{{UNIT}} !important;',
					],
					'condition'  => [
						'crafto_carousel_slide_styles!' => 'slider-style-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_width',
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
							'min' => 0,
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-style-3 .content-box-wrap' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => 'slider-style-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_box_width',
				[
					'label'      => esc_html__( 'Image Box Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-style-3 .image-box-wrap' => 'width: {{SIZE}}{{UNIT}} !important;',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => 'slider-style-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slides_vertical_position',
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
						'{{WRAPPER}} .slider-text-middle-main' => 'justify-content: {{VALUE}};',
					],
					'default'   => 'center',
				]
			);
			$this->add_responsive_control(
				'crafto_slides_horizontal_position',
				[
					'label'     => esc_html__( 'Horizontal Align', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .slider-text-middle-main' => 'align-content: {{VALUE}}; align-items: {{VALUE}};',
					],
					'default'   => 'center',
				]
			);
			$this->add_responsive_control(
				'crafto_slides_text_align',
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
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .slider-text-middle-main' => 'text-align: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slides_padding',
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
						'{{WRAPPER}} .slider-text-middle-main' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_carousel_overlay',
				[
					'label' => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_section_style_carousel_overlay',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .swiper-slide .bg-overlay',
				]
			);
			$this->add_control(
				'crafto_bg_opacity',
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
						'{{WRAPPER}} .swiper-slide .bg-overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_carousel_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .swiper-slide .slider-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_title_styles_tabs'
			);
				$this->start_controls_tab(
					'crafto_normal_title_style',
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
							'{{WRAPPER}} .swiper-slide .slider-title, {{WRAPPER}} .swiper-slide .slider-title a' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_hover_title_style',
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
							'{{WRAPPER}} .swiper-slide .slider-title a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_title_separator',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_title_text_shadow',
					'selector' => '{{WRAPPER}} .swiper-slide .slider-title',
				]
			);
			$this->add_responsive_control(
				'crafto_title_max_width',
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
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .slider-title' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_margin',
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
						'{{WRAPPER}} .swiper-slide .slider-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_slider_separator_style',
				[
					'label'     => esc_html__( 'Highlight', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_separator_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .separator',
				]
			);
			$this->add_control(
				'crafto_slide_title_colors',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .separator' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_carousel_subtitle',
				[
					'label' => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_subtitle_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .swiper-slide .slider-subtitle',
				]
			);
			$this->add_control(
				'crafto_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .slider-subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_subtitle_opacity',
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
						'{{WRAPPER}} .swiper:not(.slider-style-1) .swiper-slide .slider-subtitle, {{WRAPPER}} .slider-style-1 .swiper-slide .slider-subtitle-anime' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_subtitle_margin',
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
						'{{WRAPPER}} .swiper-slide .slider-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_slider_subtitle_border',
					'selector'  => '{{WRAPPER}} .swiper-slide .slider-subtitle',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'slider-style-1',
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
							'slider-style-1',
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
					'selector' => '{{WRAPPER}} .swiper-slide .crafto-slider-description',
				]
			);
			$this->add_control(
				'crafto_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .crafto-slider-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_description_max_width',
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
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .crafto-slider-description' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_description_margin',
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
						'{{WRAPPER}} .swiper-slide .crafto-slider-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_slider_description_link_style',
				[
					'label'     => esc_html__( 'Description Link', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs(
				'crafto_description_link_styles_tabs'
			);
			$this->start_controls_tab(
				'crafto_normal_description_link_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_slider_description_link_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .crafto-slider-description a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_hover_description_link_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_slider_description_link_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .crafto-slider-description:hover a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_description_link_separator',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_slider_description_link_border',
					'selector' => '{{WRAPPER}} .swiper-slide .crafto-slider-description a',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_carousel_splash_text',
				[
					'label'     => esc_html__( 'Splash Text', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'slider-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_splash_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .swiper-slide .crafto-splash-text',
				]
			);
			$this->add_control(
				'crafto_splash_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .crafto-splash-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_splash_text_max_width',
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
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide .crafto-splash-text' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_splash_text_margin',
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
						'{{WRAPPER}} .swiper-slide .crafto-splash-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_slider_splash_text_link_style',
				[
					'label'     => esc_html__( 'Splash Text Link', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs(
				'crafto_splash_text_link_styles_tabs'
			);
			$this->start_controls_tab(
				'crafto_normal_splash_text_link_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_slider_splash_text_link_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .crafto-splash-text a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_hover_splash_text_link_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_slider_splash_text_link_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .crafto-splash-text:hover a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_slider_splash_text_link_border',
					'selector' => '{{WRAPPER}} .swiper-slide .crafto-splash-text a',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_carousel_number',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'slider-style-1',
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
					'selector' => '{{WRAPPER}} .swiper-slide .number',
				]
			);
			$this->add_control(
				'crafto_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .swiper-slide .number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_number_opacity',
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
						'{{WRAPPER}} .swiper-slide .number' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_number_margin',
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
						'{{WRAPPER}} .swiper-slide .number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_info_box',
				[
					'label'     => esc_html__( 'Info Box', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_carousel_slide_styles' => 'slider-style-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slide_box_width',
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
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-style-2 .content-wrapper' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_slide_box_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .slider-style-2 .content-wrapper',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_slide_box_border',
					'selector'  => '{{WRAPPER}} .slider-style-2 .content-wrapper',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slide_box_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-style-2 .content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slide_box_padding',
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
						'{{WRAPPER}} .slider-style-2 .content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_slider_info_box_column_headig',
				[
					'label'     => esc_html__( 'Info Box Column', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_meta_icon_box_width',
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
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .slider-style-2 .content-wrapper .content-icon-wrap' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'           => 'crafto_meta_content_typography',
					'global'         => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'fields_options' => [
						'typography' => [
							'label' => esc_html__( 'Primary Typography', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .slider-style-2 .content-wrapper .icon-description, {{WRAPPER}} .slider-style-2 .content-wrapper .content-wrap .property-description',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_primary_content_colors',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .slider-style-2 .content-wrapper .icon-description, {{WRAPPER}} .slider-style-2 .content-wrapper .content-wrap .property-description',
				]
			);
			$this->add_control(
				'crafto_icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 150,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .slider-style-2 .content-wrapper .elementor-icon-list-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_width',
				[
					'label'     => esc_html__( 'SVG Icon Width', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 150,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .slider-style-2 .content-wrapper .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .slider-style-2 .content-wrapper .elementor-icon-list-icon' => 'color: {{VALUE}};',
						'{{WRAPPER}} .slider-style-2 .content-wrapper .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_icon_box_border',
					'selector'  => '{{WRAPPER}} .slider-style-2 .content-wrapper .content-icon',
					'condition' => [
						'crafto_carousel_slide_styles' => [
							'slider-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_box_padding',
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
						'{{WRAPPER}} .slider-style-2 .content-wrapper .content-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'after',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'           => 'crafto_secondary_content_typography',
					'global'         => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'fields_options' => [
						'typography' => [
							'label' => esc_html__( 'Secondary Typography', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .slider-style-2 .content-wrapper .content-wrap .price',
				]
			);
			$this->add_control(
				'crafto_secondary_content_colors',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .slider-style-2 .content-wrapper .content-wrap .price' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_primary_content_margin',
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
						'{{WRAPPER}} .slider-style-2 .content-wrapper .content-wrap .property-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_padding',
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
						'{{WRAPPER}} .slider-style-2 .content-wrapper .content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			Button_Group_Control::button_style_fields(
				$this,
				[
					'id'    => 'primary',
					'label' => esc_html__( 'Primary Button', 'crafto-addons' ),
				],
			);

			Button_Group_Control::button_style_fields(
				$this,
				[
					'id'    => 'secondary',
					'label' => esc_html__( 'Secondary Button', 'crafto-addons' ),
				],
			);
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
			$this->add_responsive_control(
				'crafto_dots_inside_spacing',
				[
					'label'     => esc_html__( 'Pagination Vertical Spacer', 'crafto-addons' ),
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
						'crafto_pagination' => 'yes',
						'crafto_direction'  => 'horizontal',
					],
				]
			);
			$this->add_responsive_control(
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
						'crafto_pagination'    => 'yes',
						'crafto_dots_position' => 'inside',
						'crafto_direction'     => 'vertical',
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
						'{{WRAPPER}}.pagination-direction-vertical .swiper-pagination .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-left .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical .swiper-pagination-bullets.swiper-numbers .swiper-pagination-bullet' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.pagination-center .swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet, 
						{{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.pagination-left .swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet, 
						{{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.pagination-right .swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet, 
						{{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.pagination-left.dots-style-2 .swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet, 
						{{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.pagination-right.dots-style-2 .swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet, 
						{{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.pagination-left.number-style-2 .swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet, 
						{{WRAPPER}}.elementor-widget-crafto-slider .swiper.horizontal.pagination-right.number-style-2 .swiper-pagination-bullets.swiper-pagination-horizontal .swiper-pagination-bullet' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination'               => 'yes',
						'crafto_pagination_number_style!' => 'number-style-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pagination_padding',
				[
					'label'     => esc_html__( 'Pagination Horizontal Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .swiper .swiper-pagination, {{WRAPPER}} .swiper .swiper-pagination-wrapper, {{WRAPPER}} .swiper.horizontal.slider-style-3 .swiper-pagination' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'crafto_pagination'         => 'yes',
						'crafto_direction'          => 'horizontal',
						'crafto_pagination_h_align' => [
							'left',
							'right',
						],

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
							'max' => 30,
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
		 * Render slider widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$slides                                 = [];
			$slides_count                           = '';
			$settings                               = $this->get_settings_for_display();
			$slide_styles                           = $this->get_settings( 'crafto_carousel_slide_styles' );
			$crafto_parallax                        = $this->get_settings( 'crafto_parallax' );
			$crafto_slide_parallax_amount           = $this->get_settings( 'crafto_slide_parallax_amount' );
			$crafto_slide_parallax_container_amount = $this->get_settings( 'crafto_slide_parallax_container_amount' );
			$slider_subtitle_anime_animation        = $this->render_anime_animation( $this, 'subtitle' );
			$slider_button_anime_animation          = $this->render_anime_animation( $this, 'button' );
			$slider_number_anime_animation          = $this->render_anime_animation( $this, 'number' );
			$slider_description_anime_animation     = $this->render_anime_animation( $this, 'description' );
			$slider_content_box_anime_animation     = $this->render_anime_animation( $this, 'content-box' );
			$slider_image_anime_animation           = $this->render_anime_animation( $this, 'image' );
			$slider_splash_anime_animation          = $this->render_anime_animation( $this, 'splash' );

			$is_mobile = isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/(android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT'] ); // phpcs:ignore

			$this->add_render_attribute(
				[
					'slider-subtitle' => [
						'class' => 'slider-subtitle',
					],
				]
			);

			if ( ! empty( $slider_subtitle_anime_animation ) && '[]' !== $slider_subtitle_anime_animation ) {
				$this->add_render_attribute(
					[
						'slider-subtitle' => [
							'class'      => 'has-anime-effect',
							'data-anime' => $slider_subtitle_anime_animation,
						],
					]
				);
			}

			$this->add_render_attribute(
				'slider-text-middle',
				[
					'class' => 'slider-text-middle-main',
				]
			);

			if ( 'yes' === $crafto_parallax ) {
				$this->add_render_attribute(
					'slider-text-middle',
					[
						'data-swiper-parallax' => $crafto_slide_parallax_container_amount,
					]
				);
			}

			if ( 'yes' === $crafto_parallax ) {
				$this->add_render_attribute(
					'slider-parallax',
					[
						'class'                 => [
							'cover-background',
							'overflow-hidden',
							'parallax-slide',
						],
						' data-swiper-parallax' => $crafto_slide_parallax_amount,
					]
				);
			}
			$this->add_render_attribute(
				[
					'slider-button' => [
						'class' => 'crafto-slider-buttons',
					],
				]
			);

			if ( ! empty( $slider_button_anime_animation ) && '[]' !== $slider_button_anime_animation ) {
				$this->add_render_attribute(
					[
						'slider-button' => [
							'class'      => 'has-anime-effect',
							'data-anime' => $slider_button_anime_animation,
						],
					]
				);
			}

			$this->add_render_attribute(
				[
					'slider-number' => [
						'class' => 'number',
					],
				]
			);

			if ( ! empty( $slider_number_anime_animation ) && '[]' !== $slider_number_anime_animation ) {
				$this->add_render_attribute(
					[
						'slider-number' => [
							'class'      => 'has-anime-effect',
							'data-anime' => $slider_number_anime_animation,
						],
					]
				);
			}

			$this->add_render_attribute(
				[
					'splash-text' => [
						'class' => 'crafto-splash-text',
					],
				]
			);

			if ( ! empty( $slider_splash_anime_animation ) && '[]' !== $slider_splash_anime_animation ) {
				$this->add_render_attribute(
					[
						'splash-text' => [
							'class'      => 'has-anime-effect',
							'data-anime' => $slider_splash_anime_animation,
						],
					]
				);
			}

			$this->add_render_attribute(
				[
					'slider-description' => [
						'class' => 'crafto-slider-description',
					],
				]
			);

			if ( ! empty( $slider_description_anime_animation ) && '[]' !== $slider_description_anime_animation ) {
				$this->add_render_attribute(
					[
						'slider-description' => [
							'class'      => 'has-anime-effect',
							'data-anime' => $slider_description_anime_animation,
						],
					]
				);
			}

			$this->add_render_attribute(
				[
					'slider-content-box' => [
						'class' => 'content-wrapper',
					],
				]
			);

			if ( ! empty( $slider_content_box_anime_animation ) && '[]' !== $slider_content_box_anime_animation ) {
				$this->add_render_attribute(
					[
						'slider-content-box' => [
							'class'      => 'has-anime-effect',
							'data-anime' => $slider_content_box_anime_animation,
						],
					]
				);
			}

			switch ( $slide_styles ) {
				case 'slider-style-1':
					foreach ( $settings['crafto_carousel_slider'] as $index => $item ) {
						$index       = ++$index;
						$wrapper_key = 'wrapper_' . $index;
						$button_key  = 'button_' . $index;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);

						if ( '' === $crafto_parallax && '[]' === $slider_image_anime_animation ) {
							$this->add_render_attribute(
								$wrapper_key,
								[
									'class' => [
										'cover-background',
										'overflow-hidden',
									],
								]
							);
						}
						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
							<?php
							if ( 'yes' === $crafto_parallax ) {
								?>
								<div <?php $this->print_render_attribute_string( 'slider-parallax' ); ?>>
								<?php
							}

							if ( Plugin::$instance->editor->is_edit_mode() ) {
								?>
								<div class="desktop-img d-none d-md-block">
									<?php
									$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									?>
								</div>
								<div class="mobile-img d-block d-md-none">
									<?php
									if ( ! empty( $item['crafto_carousel_image_background_mobile']['url'] ) ) {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background_mobile']['id'], $item['crafto_carousel_image_background_mobile']['url'], $settings['crafto_thumbnail_mobile_size'], $index ); // phpcs:ignore
									} else {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									}
									?>
								</div>
								<?php
							} elseif ( $is_mobile ) {
								?>
								<div class="mobile-img">
									<?php
									if ( ! empty( $item['crafto_carousel_image_background_mobile']['url'] ) ) {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background_mobile']['id'], $item['crafto_carousel_image_background_mobile']['url'], $settings['crafto_thumbnail_mobile_size'], $index ); // phpcs:ignore
									} else {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									}
									?>
								</div>
								<?php
							} else {
								?>
								<div class="desktop-img">
									<?php
									$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									?>
								</div>
								<?php
							}
							?>
							<div class="bg-overlay"></div>
							<div <?php $this->print_render_attribute_string( 'slider-text-middle' ); ?>>
								<?php
								$this->slider_content_subtitle( $index, $item );
								$this->slider_content_title( $index, $item );
								if ( ! empty( $item['crafto_carousel_description'] ) ) {
									?>
									<div <?php $this->print_render_attribute_string( 'slider-description' ); ?>>
										<?php printf( '%s', $item['crafto_carousel_description'] ); // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
								<div <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
									<?php
									Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
									Button_Group_Control::repeater_render_button_content( $this, $item, 'secondary', $button_key );
									?>
								</div>
								<?php
								if ( ! empty( $item['crafto_carousel_splash_text'] ) ) {
									?>
									<div <?php $this->print_render_attribute_string( 'splash-text' ); ?>>
										<?php printf( '%s', $item['crafto_carousel_splash_text'] ); // phpcs:ignore ?> 
									</div>
									<?php
								}
								if ( ! empty( $item['crafto_carousel_number'] ) ) {
									?>
									<span <?php $this->print_render_attribute_string( 'slider-number' ); ?>>
										<?php echo esc_html( $item['crafto_carousel_number'] ); ?>
									</span>
									<?php
								}
								?>
							</div>
							<?php
							if ( 'yes' === $crafto_parallax ) {
								?>
								</div>
								<?php
							}
							?>
						</div>
						<?php
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'slider-style-2':
					foreach ( $settings['crafto_property_carousel_slider'] as $index => $item ) {
						$migrated        = isset( $item['__fa4_migrated']['crafto_selected_icon'] );
						$is_new          = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
						$second_migrated = isset( $item['__fa4_migrated']['crafto_second_selected_icon'] );
						$is_second_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
						$third_migrated  = isset( $item['__fa4_migrated']['crafto_third_selected_icon'] );
						$is_third_new    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

						$index       = ++$index;
						$wrapper_key = 'wrapper_' . $index;
						$button_key  = 'button_' . $index;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);
						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'cover-background',
									'overflow-hidden',
								],
							]
						);
						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
							<?php
							if ( Plugin::$instance->editor->is_edit_mode() ) {
								?>
								<div class="desktop-img d-none d-md-block">
									<?php
									$this->crafto_get_slider_attachment( $item['crafto_carousel_repeater1_image_background']['id'], $item['crafto_carousel_repeater1_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									?>
								</div>
								<div class="mobile-img d-block d-md-none">
									<?php
									if ( ! empty( $item['crafto_carousel_repeater1_image_background_mobile']['url'] ) ) {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_repeater1_image_background_mobile']['id'], $item['crafto_carousel_repeater1_image_background_mobile']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									} else {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_repeater1_image_background']['id'], $item['crafto_carousel_repeater1_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									}
									?>
								</div>
								<?php
							} elseif ( $is_mobile ) {
								?>
								<div class="mobile-img">
									<?php
									if ( ! empty( $item['crafto_carousel_repeater1_image_background_mobile']['url'] ) ) {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_repeater1_image_background_mobile']['id'], $item['crafto_carousel_repeater1_image_background_mobile']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									} else {
										$this->crafto_get_slider_attachment( $item['crafto_carousel_repeater1_image_background']['id'], $item['crafto_carousel_repeater1_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									}
									?>
								</div>
								<?php
							} else {
								?>
								<div class="desktop-img">
									<?php
									$this->crafto_get_slider_attachment( $item['crafto_carousel_repeater1_image_background']['id'], $item['crafto_carousel_repeater1_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
									?>
								</div>
								<?php
							}
							?>
							<div class="bg-overlay"></div>
							<div class="slider-text-middle-main">
								<?php
								$this->slider_content_subtitle( $index, $item );
								$this->slider_content_title( $index, $item );
								?>
								<div <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
									<?php
									Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
									Button_Group_Control::repeater_render_button_content( $this, $item, 'secondary', $button_key );
									?>
								</div>
							</div>
							<div <?php $this->print_render_attribute_string( 'slider-content-box' ); ?>>
								<div class="content-icon-wrap">
									<?php
									if ( ! empty( $item['crafto_selected_icon']['value'] ) || ! empty( $item['crafto_icon_description'] ) ) {
										?>
										<div class="content-icon">
											<span class="elementor-icon-list-icon">
												<?php
												if ( $is_new || $migrated ) {
													Icons_Manager::render_icon( $item['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
												} elseif ( isset( $item['crafto_selected_icon']['value'] ) && ! empty( $item['crafto_selected_icon']['value'] ) ) {
													?>
													<i class="<?php echo esc_attr( $item['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
													<?php
												}
												?>
											</span>
											<div class="icon-description">
												<?php echo esc_html( $item['crafto_icon_description'] ); ?>
											</div>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_second_selected_icon']['value'] ) || ! empty( $item['crafto_second_icon_description'] ) ) {
										?>
										<div class="content-icon">
											<span class="elementor-icon-list-icon">
												<?php
												if ( $is_second_new || $second_migrated ) {
													Icons_Manager::render_icon( $item['crafto_second_selected_icon'], [ 'aria-hidden' => 'true' ] );
												} elseif ( isset( $item['crafto_second_selected_icon']['value'] ) && ! empty( $item['crafto_second_selected_icon']['value'] ) ) {
													?>
													<i class="<?php echo esc_attr( $item['crafto_second_selected_icon'] ); ?>" aria-hidden="true"></i>
													<?php
												}
												?>
											</span>
											<div class="icon-description">
												<?php echo esc_html( $item['crafto_second_icon_description'] ); ?>
											</div>
										</div>
										<?php
									}
									if ( ! empty( $item['crafto_third_selected_icon']['value'] ) || ! empty( $item['crafto_third_icon_description'] ) ) {
										?>
										<div class="content-icon">
											<span class="elementor-icon-list-icon">
												<?php
												if ( $is_third_new || $third_migrated ) {
													Icons_Manager::render_icon( $item['crafto_third_selected_icon'], [ 'aria-hidden' => 'true' ] );
												} elseif ( isset( $item['crafto_third_selected_icon']['value'] ) && ! empty( $item['crafto_third_selected_icon']['value'] ) ) {
													?>
													<i class="<?php echo esc_attr( $item['crafto_third_selected_icon'] ); ?>" aria-hidden="true"></i>
													<?php
												}
												?>
											</span>
											<div class="icon-description">
												<?php echo esc_html( $item['crafto_third_icon_description'] ); ?>
											</div>
										</div>
										<?php
									}
									?>
								</div>
								<?php
								if ( ! empty( $item['crafto_property_description'] ) || ! empty( $item['crafto_property_price'] ) ) {
									?>
									<div class="content-wrap">
										<?php
										if ( ! empty( $item['crafto_property_description'] ) ) {
											?>
											<div class="property-description">
												<?php echo esc_html( $item['crafto_property_description'] ); ?>
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_property_price'] ) ) {
											?>
											<div class="price">
												<?php echo esc_html( $item['crafto_property_price'] ); ?>
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
						$slides[] = ob_get_contents();
						ob_end_clean();
					}
					break;
				case 'slider-style-3':
					foreach ( $settings['crafto_carousel_slider'] as $index => $item ) {
						$index       = ++$index;
						$wrapper_key = 'wrapper_' . $index;
						$button_key  = 'button_' . $index;

						$this->add_render_attribute(
							$wrapper_key,
							[
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'swiper-slide',
								],
							]
						);

						if ( '' === $crafto_parallax && '[]' === $slider_image_anime_animation ) {
							$this->add_render_attribute(
								$wrapper_key,
								[
									'class' => [
										'cover-background',
										'overflow-hidden',
									],
								]
							);
						}

						ob_start();
						?>
						<div <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
							<div class="row">
								<?php
								if ( 'yes' === $crafto_parallax ) {
									?>
									<div <?php $this->print_render_attribute_string( 'slider-parallax' ); ?>>
									<?php
								}
								?>
								<div class="col-6 content-box-wrap">
									<?php
									if ( ! empty( $item['crafto_carousel_content_image_background']['url'] ) ) {
										?>
										<div class="content-bg-image">
											<?php
											$this->crafto_get_slider_attachment( $item['crafto_carousel_content_image_background']['id'], $item['crafto_carousel_content_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
											?>
										</div>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'slider-text-middle' ); ?>>
										<?php
										$this->slider_content_subtitle( $index, $item );
										$this->slider_content_title( $index, $item );
										if ( ! empty( $item['crafto_carousel_description'] ) ) {
											?>
											<div <?php $this->print_render_attribute_string( 'slider-description' ); ?>>
												<?php printf( '%s', $item['crafto_carousel_description'] ); // phpcs:ignore ?>
											</div>
											<?php
										}
										?>
										<div <?php $this->print_render_attribute_string( 'slider-button' ); ?>>
											<?php
											Button_Group_Control::repeater_render_button_content( $this, $item, 'primary', $button_key );
											Button_Group_Control::repeater_render_button_content( $this, $item, 'secondary', $button_key );
											?>
										</div>
										<?php
										if ( ! empty( $item['crafto_carousel_splash_text'] ) ) {
											?>
											<div <?php $this->print_render_attribute_string( 'splash-text' ); ?>>
												<?php printf( '%s', $item['crafto_carousel_splash_text'] ); // phpcs:ignore ?> 
											</div>
											<?php
										}
										if ( ! empty( $item['crafto_carousel_number'] ) ) {
											?>
											<span <?php $this->print_render_attribute_string( 'slider-number' ); ?>>
												<?php echo esc_html( $item['crafto_carousel_number'] ); ?>
											</span>
											<?php
										}
										?>
									</div>
								</div>
								<div class="col-6 image-box-wrap">
									<?php
									if ( Plugin::$instance->editor->is_edit_mode() ) {
										?>
										<div class="desktop-img d-none d-md-block">
											<?php
											$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
											?>
										</div>
										<div class="mobile-img d-block d-md-none">
											<?php
											if ( ! empty( $item['crafto_carousel_image_background_mobile']['url'] ) ) {
												$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background_mobile']['id'], $item['crafto_carousel_image_background_mobile']['url'], $settings['crafto_thumbnail_mobile_size'], $index ); // phpcs:ignore
											} else {
												$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
											}
											?>
										</div>
										<?php
									} elseif ( $is_mobile ) {
										?>
										<div class="mobile-img">
											<?php
											if ( ! empty( $item['crafto_carousel_image_background_mobile']['url'] ) ) {
												$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background_mobile']['id'], $item['crafto_carousel_image_background_mobile']['url'], $settings['crafto_thumbnail_mobile_size'], $index ); // phpcs:ignore
											} else {
												$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
											}
											?>
										</div>
										<?php
									} else {
										?>
										<div class="desktop-img">
											<?php
											$this->crafto_get_slider_attachment( $item['crafto_carousel_image_background']['id'], $item['crafto_carousel_image_background']['url'], $settings['crafto_thumbnail_size'], $index ); // phpcs:ignore
											?>
										</div>
										<?php
									}
									?>
									<div class="bg-overlay"></div>
								</div>
								<?php
								if ( 'yes' === $crafto_parallax ) {
									?>
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
			}

			if ( empty( $slides ) ) {
				return;
			}
			$crafto_full_screen = '';
			if ( 'slider-style-2' === $slide_styles ) {
				$slides_count = count( $settings['crafto_property_carousel_slider'] );
			} else {
				$slides_count = count( $settings['crafto_carousel_slider'] );
			}

			$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
			$crafto_slider_cursor           = $this->get_settings( 'crafto_slider_cursor' );
			$crafto_direction               = $this->get_settings( 'crafto_direction' );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
			$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
			$crafto_pagination_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );

			$data_settings = array(
				'navigation'       => $crafto_navigation,
				'pagination'       => $crafto_pagination,
				'pagination_style' => $crafto_pagination_style,
				'number_style'     => $crafto_pagination_number_style,
				'loop'             => $this->get_settings( 'crafto_infinite' ),
				'parallax'         => $this->get_settings( 'crafto_parallax' ),
				'autoplay'         => $this->get_settings( 'crafto_autoplay' ),
				'autoplay_speed'   => $this->get_settings( 'crafto_autoplay_speed' ),
				'pause_on_hover'   => $this->get_settings( 'crafto_pause_on_hover' ),
				'effect'           => $this->get_settings( 'crafto_effect' ),
				'speed'            => $this->get_settings( 'crafto_speed' ),
				'direction'        => $this->get_settings( 'crafto_direction' ),
				'mousewheel'       => $this->get_settings( 'crafto_mousewheel' ),
				'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
				'content_width'    => $this->get_settings( 'crafto_content_max_width' ),
			);

			$crafto_effect = $this->get_settings( 'crafto_effect' );

			$effect = [
				'fade',
				'flip',
				'cube',
				'cards',
				'coverflow',
			];

			if ( '1' === $this->get_settings( 'crafto_slides_to_show' ) && in_array( $crafto_effect, $effect, true ) ) {
				$data_settings['effect'] = $crafto_effect;
			}

			$data_settings['direction'] = $this->get_settings( 'crafto_direction' );

			$this->add_render_attribute(
				[
					'carousel-wrapper' => [
						'class' =>
						[
							'slider-vertical',
						],
					],
				],
			);

			if ( ! empty( $crafto_rtl ) ) {
				$this->add_render_attribute( 'carousel-wrapper', 'dir', $crafto_rtl );
			}

			if ( 'yes' === $this->get_settings( 'crafto_image_stretch' ) ) {
				$this->add_render_attribute( 'carousel', 'class', 'swiper-image-stretch' );
			}

			if ( 'yes' === $this->get_settings( 'crafto_full_screen' ) ) {
				$crafto_full_screen = 'full-screen-slide';
			}

			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}

			$this->add_render_attribute(
				[
					'carousel-wrapper' => [
						'class'         => [
							'swiper',
							'swiper-container-initialized',
							$crafto_full_screen,
							$slide_styles,
							$magic_cursor,
							$crafto_direction,
						],
						'data-settings' => wp_json_encode( $data_settings ),
					],
					'carousel'         => [
						'class' => 'swiper-wrapper',
					],
				]
			);
			if ( 'yes' === $crafto_parallax ) {
				$this->add_render_attribute(
					[
						'carousel-wrapper' => [
							'class' => [
								'parallax-slider',
							],
						],
					]
				);
			}
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
			?>
			<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
					<?php echo implode( '', $slides ); // phpcs:ignore ?>
				</div>
				<?php
				if ( 1 < $slides_count ) { // phpcs:ignore
					get_swiper_pagination( $settings );
				}
				?>
			</div>
			<?php
		}

		/**
		 * @param string $index get the index.
		 * @param string $item get the item.
		 * Start div tag for tab title.
		 */
		public function slider_content_title( $index, $item ) {
			$fancy_text_values                 = [];
			$slider_fancy_text_animation       = '';
			$data_fancy_text                   = '';
			$slide_title                       = 'slide_title_' . $index;
			$index                             = ++$index;
			$title_key                         = 'title_' . $index;
			$crafto_carousel_title             = isset( $item['crafto_carousel_title'] ) && ! empty( $item['crafto_carousel_title'] ) ? $item['crafto_carousel_title'] : '';
			$settings                          = $this->get_settings_for_display();
			$slider_title_fancy_text_animation = $this->render_fancy_text_animation( $this, 'title' );
			$slider_title_anime_animation      = $this->render_anime_animation( $this, 'title' );

			if ( ! empty( $item['crafto_link']['url'] ) ) {
				$this->add_render_attribute(
					$title_key,
					[
						'href' => $item['crafto_link']['url'],
					]
				);
			}

			if ( $crafto_carousel_title ) {
				if ( has_shortcode( $crafto_carousel_title, 'crafto_highlight' ) ) {
					$crafto_carousel_title = str_replace( '[crafto_highlight]', '<span class="separator">', $crafto_carousel_title );
					$crafto_carousel_title = str_replace( '[/crafto_highlight]', '<span class="separator-animation horizontal-separator"></span></span>', $crafto_carousel_title );
				}
			}

			if ( ! empty( $slider_title_fancy_text_animation ) ) {

				$get_slider_title_effect     = wp_json_encode( $slider_title_fancy_text_animation );
				$fancy_text_values['string'] = [ $crafto_carousel_title ];
				$data_fancy_text             = ! empty( $fancy_text_values ) ? wp_json_encode( $fancy_text_values ) : '';
				$slider_fancy_text_animation = wp_json_encode( array_merge( json_decode( $data_fancy_text, true ), json_decode( $get_slider_title_effect, true ) ) );
			}

			$this->add_render_attribute(
				[
					$slide_title => [
						'class' => [
							'slider-title',
						],
					],
				]
			);
			if ( ! empty( $slider_fancy_text_animation ) ) {
				$this->add_render_attribute(
					[
						$slide_title => [
							'data-fancy-text' => $slider_fancy_text_animation,
							'class'           => [
								'slide-text-rotator',
							],
						],
					]
				);
			}
			if ( ! empty( $slider_title_anime_animation ) && '[]' !== $slider_title_anime_animation ) {
				$this->add_render_attribute(
					[
						$slide_title => [
							'class'      => 'has-anime-effect',
							'data-anime' => $slider_title_anime_animation,
						],
					]
				);
			}

			if ( ! empty( $crafto_carousel_title ) ) {
				?>
				<<?php Utils::print_validated_html_tag( $settings['crafto_header_size'] ); ?> <?php $this->print_render_attribute_string( $slide_title ); ?>>
					<?php
					if ( ! empty( $item['crafto_link']['url'] ) ) {
						?>
						<a <?php $this->print_render_attribute_string( $title_key ); ?>>
							<?php printf( '%s', $crafto_carousel_title ); // phpcs:ignore ?>
						</a>
						<?php
					} else {
						printf( '%s', $crafto_carousel_title ); // phpcs:ignore
					}
					?>
				</<?php Utils::print_validated_html_tag( $settings['crafto_header_size'] ); ?>>
				<?php
			}
		}

		/**
		 * @param string $index get the index.
		 * @param string $item get the item.
		 * Start div tag for tab title.
		 */
		public function slider_content_subtitle( $index, $item ) {
			$slide_styles = $this->get_settings( 'crafto_carousel_slide_styles' );

			$this->add_render_attribute(
				[
					'slider-subtitle' => [
						'class' => 'slider-subtitle',
					],
				]
			);

			if ( 'slider-style-1' === $slide_styles ) {
				if ( ! empty( $item['crafto_carousel_subtitle'] ) ) {
					?>
					<div <?php $this->print_render_attribute_string( 'slider-subtitle' ); ?>>
						<span class="slider-subtitle-anime">
							<?php echo esc_html( $item['crafto_carousel_subtitle'] ); ?>
						</span>
					</div>
					<?php
				}
			} elseif ( ! empty( $item['crafto_carousel_subtitle'] ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'slider-subtitle' ); ?>>
					<?php echo esc_html( $item['crafto_carousel_subtitle'] ); ?>
				</div>
				<?php
			}
		}

		/**
		 * Generate HTML for an attachment image.
		 *
		 * @param mixed $attachment_id Attachment ID.
		 * @param mixed $attachment_url Attachment URL.
		 * @param mixed $attachment_size Attachment size.
		 * @param mixed $index Index of the attachment (if applicable).
		 */
		public function crafto_get_slider_attachment( $attachment_id, $attachment_url, $attachment_size, $index ) {
			$crafto_image = '';
			// If attachment ID and URL are provided.
			if ( ! empty( $attachment_id ) && '' !== $attachment_url ) {
				$thumbnail_id = $attachment_id;

				// Get image data (alt, title, and sizes).
				$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
				$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
				$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
				$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

				// Get image data.
				$image_array                  = wp_get_attachment_image_src( $attachment_id, $attachment_size );
				$crafto_image_url             = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';
				$slider_image_anime_animation = $this->render_anime_animation( $this, 'image' );

				if ( ! empty( $slider_image_anime_animation ) && '[]' !== $slider_image_anime_animation ) {
					$default_attr = array(
						'src'        => esc_url( $crafto_image_url ),
						'class'      => 'swiper-slide-image has-anime-effect',
						'alt'        => esc_attr( $crafto_image_alt ),
						'title'      => esc_attr( $crafto_image_title ),
						'data-anime' => $slider_image_anime_animation,
					);
				} else {
					$default_attr = array(
						'src'   => esc_url( $crafto_image_url ),
						'class' => 'swiper-slide-image',
						'alt'   => esc_attr( $crafto_image_alt ),
						'title' => esc_attr( $crafto_image_title ),
					);
				}

				$img_loading  = ( 1 === $index ) ? array( 'fetchpriority' => 'high' ) : array( 'loading' => 'lazy' );
				$default_attr = array_merge( $img_loading, $default_attr );
				$crafto_image = wp_get_attachment_image( $thumbnail_id, $attachment_size, '', $default_attr );

			} elseif ( ! empty( $attachment_url ) ) {
				// Placeholder image if URL is available but no attachment ID.
				$crafto_image_url = $attachment_url;
				$crafto_image_alt = esc_attr__( 'Placeholder Image', 'crafto-addons' );
				$crafto_image     = sprintf(
					'<img src="%1$s" alt="%2$s" />',
					esc_url( $crafto_image_url ),
					esc_attr( $crafto_image_alt )
				);
			}

			// Output the image HTML.
			echo sprintf( '%s', $crafto_image ); // phpcs:ignore
		}

		/**
		 * Render animation effect frontend
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public function render_anime_animation( $element, $data_type = 'primary' ) {
			$prefix = 'crafto_' . $data_type . '_';
			// Data Anime Values.
			$crafto_animation_settings  = $element->get_settings( $prefix . 'ent_settings' );
			$ent_settings_ease          = $element->get_settings( $prefix . 'ent_settings_ease' );
			$ent_settings_elements      = $element->get_settings( $prefix . 'ent_settings_elements' );
			$ent_settings_start_delay   = ( isset( $element->get_settings( $prefix . 'ent_settings_start_delay' )['size'] ) ) ? $element->get_settings( $prefix . 'ent_settings_start_delay' )['size'] : '';
			$ent_settings_duration      = ( isset( $element->get_settings( $prefix . 'ent_anim_opt_duration' )['size'] ) ) ? $element->get_settings( $prefix . 'ent_anim_opt_duration' )['size'] : '';
			$ent_settings_stagger           = ( isset( $element->get_settings( $prefix . 'ent_anim_stagger' )['size'] ) ) ? $element->get_settings( $prefix . 'ent_anim_stagger' )['size'] : '';
			$ent_settings_opacity_x     = $element->get_settings( $prefix . 'ent_anim_opt_x_opacity' );
			$ent_settings_opacity_y     = $element->get_settings( $prefix . 'ent_anim_opt_y_opacity' );
			$ent_settings_perspective_x = $element->get_settings( $prefix . 'ent_anim_opt_perspective_x' );
			$ent_settings_perspective_y = $element->get_settings( $prefix . 'ent_anim_opt_perspective_y' );
			$ent_settings_rotatex_xx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_xx' );
			$ent_settings_rotatex_xy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_xy' );
			$ent_settings_rotatey_yx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_yx' );
			$ent_settings_rotatey_yy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_yy' );
			$ent_settings_rotatez_zx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_zx' );
			$ent_settings_rotatez_zy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_zy' );
			$ent_settings_transalte_x   = $element->get_settings( $prefix . 'ent_anim_opt_translate_x' );
			$ent_settings_transalte_y   = $element->get_settings( $prefix . 'ent_anim_opt_translate_y' );
			$ent_settings_transalte_xx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_xx' );
			$ent_settings_transalte_xy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_xy' );
			$ent_settings_transalte_yx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_yx' );
			$ent_settings_transalte_yy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_yy' );
			$ent_settings_transalte_zx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_zx' );
			$ent_settings_transalte_zy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_zy' );
			$ent_settings_scale_x       = $element->get_settings( $prefix . 'ent_anim_opt_scale_x' );
			$ent_settings_scale_y       = $element->get_settings( $prefix . 'ent_anim_opt_scale_y' );

			$ent_values = [];
			if ( 'yes' === $crafto_animation_settings ) {
				if ( 'yes' === $ent_settings_elements ) {
					$ent_values['el'] = 'childs';
				}

				if ( 'none' !== $ent_settings_ease ) {
					$ent_values['easing'] = $ent_settings_ease;
				}



				if ( ! empty( $ent_settings_start_delay ) ) {
					$ent_values['delay'] = (float) ( $ent_settings_start_delay );
				}

				if ( ! empty( $ent_settings_duration ) ) {
					$ent_values['duration'] = (float) ( $ent_settings_duration );
				}

				if ( ! empty( $ent_settings_stagger ) ) {
					$ent_values['staggervalue'] = (float) ( $ent_settings_stagger );
				}

				if ( ! empty( $ent_settings_opacity_x ) && ! empty( $ent_settings_opacity_y ) && $ent_settings_opacity_x !== $ent_settings_opacity_y ) {
					$ent_values['opacity'] = [ (float) $ent_settings_opacity_x['size'], (float) $ent_settings_opacity_y['size'] ];
				}

				if ( ! empty( $ent_settings_perspective_x ) && ! empty( $ent_settings_perspective_y ) && ( 0 !== $ent_settings_perspective_x['size'] ) && ( 0 !== $ent_settings_perspective_y['size'] ) ) {
					$ent_values['perspective'] = [ (float) $ent_settings_perspective_x['size'], (float) $ent_settings_perspective_y['size'] ];
				}

				if ( ! empty( $ent_settings_rotatex_xx ) && ! empty( $ent_settings_rotatex_xy ) && $ent_settings_rotatex_xx !== $ent_settings_rotatex_xy ) {
					$ent_values['rotateX'] = [ (int) $ent_settings_rotatex_xx['size'], (int) $ent_settings_rotatex_xy['size'] ];
				}

				if ( ! empty( $ent_settings_rotatey_yx ) && ! empty( $ent_settings_rotatey_yy ) && $ent_settings_rotatey_yx !== $ent_settings_rotatey_yy ) {
					$ent_values['rotateY'] = [ (int) $ent_settings_rotatey_yx['size'], (int) $ent_settings_rotatey_yy['size'] ];
				}

				if ( ! empty( $ent_settings_rotatez_zx ) && ! empty( $ent_settings_rotatez_zy ) && $ent_settings_rotatez_zx !== $ent_settings_rotatez_zy ) {
					$ent_values['rotateZ'] = [ (int) $ent_settings_rotatez_zx['size'], (int) $ent_settings_rotatez_zy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_x ) && ! empty( $ent_settings_transalte_y ) && $ent_settings_transalte_x !== $ent_settings_transalte_y ) {
					$ent_values['translate'] = [ (float) $ent_settings_transalte_x['size'], (float) $ent_settings_transalte_y['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_xx ) && ! empty( $ent_settings_transalte_xy ) && $ent_settings_transalte_xx !== $ent_settings_transalte_xy ) {
					$ent_values['translateX'] = [ (float) $ent_settings_transalte_xx['size'], (float) $ent_settings_transalte_xy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_yx ) && ! empty( $ent_settings_transalte_yy ) && $ent_settings_transalte_yx !== $ent_settings_transalte_yy ) {
					$ent_values['translateY'] = [ (float) $ent_settings_transalte_yx['size'], (float) $ent_settings_transalte_yy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_zx ) && ! empty( $ent_settings_transalte_zy ) && $ent_settings_transalte_zx !== $ent_settings_transalte_zy ) {
					$ent_values['translateZ'] = [ (float) $ent_settings_transalte_zx['size'], (float) $ent_settings_transalte_zy['size'] ];
				}

				if ( ! empty( $ent_settings_scale_x ) && ! empty( $ent_settings_scale_y ) && $ent_settings_scale_x !== $ent_settings_scale_y ) {
					$ent_values['scale'] = [ (float) $ent_settings_scale_x['size'], (float) $ent_settings_scale_y['size'] ];
				}
			}

			$data_anime = ! empty( $ent_values ) ? $ent_values : [];
			
			return wp_json_encode( $data_anime );
		}

		/**
		 * Return Data Fancy Text Animation.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public function render_fancy_text_animation( $element, $data_type = 'primary' ) {
			$prefix = 'crafto_' . $data_type . '_';
			// Data Fancy Text Values.
			$crafto_fancy_text_animation_enable    = $element->get_settings( $prefix . 'data_fancy_text_settings' );
			$data_fancy_text_settings_colors       = $element->get_settings( $prefix . 'data_fancy_text_settings_colors' );
			$data_fancy_text_settings_effect       = $element->get_settings( $prefix . 'data_fancy_text_settings_effect' );
			$data_fancy_text_settings_ease         = $element->get_settings( $prefix . 'data_fancy_text_settings_ease' );
			$data_fancy_text_settings_start_delay  = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_start_delay' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_start_delay' )['size'] : '';
			$data_fancy_text_settings_duration     = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_duration' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_duration' )['size'] : '';
			$data_fancy_text_settings_speed        = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_speed' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_speed' )['size'] : '';
			$data_fancy_text_settings_x_opacity    = $element->get_settings( $prefix . 'data_fancy_text_settings_x_opacity' );
			$data_fancy_text_settings_y_opacity    = $element->get_settings( $prefix . 'data_fancy_text_settings_y_opacity' );
			$data_fancy_text_settings_translate_xx = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_xx' );
			$data_fancy_text_settings_translate_xy = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_xy' );
			$data_fancy_text_settings_translate_yx = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_yx' );
			$data_fancy_text_settings_translate_yy = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_yy' );
			$data_fancy_text_settings_x_filter     = $element->get_settings( $prefix . 'data_fancy_text_settings_x_filter' );
			$data_fancy_text_settings_y_filter     = $element->get_settings( $prefix . 'data_fancy_text_settings_y_filter' );
			$data_fancy_text_settings_x_clippath   = $element->get_settings( $prefix . 'data_fancy_text_settings_x_clippath' );
			$data_fancy_text_settings_y_clippath   = $element->get_settings( $prefix . 'data_fancy_text_settings_y_clippath' );
			$data_fancy_text_settings_x_rotate     = $element->get_settings( $prefix . 'data_fancy_text_settings_x_rotate' );
			$data_fancy_text_settings_y_rotate     = $element->get_settings( $prefix . 'data_fancy_text_settings_y_rotate' );

			$fancy_text_value_arr = [];
			if ( 'yes' === $crafto_fancy_text_animation_enable ) {
				if ( 'custom' !== $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['effect'] = $data_fancy_text_settings_effect;
				}

				if ( 'wave' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'up';
				}

				if ( 'rubber-band' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'left';
				}

				if ( 'slide' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'right';
				}

				if ( 'smooth-wave' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'down';
				}

				if ( 'none' !== $data_fancy_text_settings_ease ) {
					$fancy_text_value_arr['easing'] = $data_fancy_text_settings_ease;
				}

				if ( ! empty( $data_fancy_text_settings_colors ) && 'slide' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['color'] = $data_fancy_text_settings_colors;
				}

				if ( ! empty( $data_fancy_text_settings_duration ) ) {
					$fancy_text_value_arr['duration'] = (float) ( $data_fancy_text_settings_duration );
				}

				if ( ! empty( $data_fancy_text_settings_speed ) ) {
					$fancy_text_value_arr['speed'] = (float) ( $data_fancy_text_settings_speed );
				}

				if ( 'custom' === $data_fancy_text_settings_effect ) {

					if ( ! empty( $data_fancy_text_settings_start_delay ) ) {
						$fancy_text_value_arr['delay'] = (float) ( $data_fancy_text_settings_start_delay );
					}

					if ( ! empty( $data_fancy_text_settings_x_opacity ) && ! empty( $data_fancy_text_settings_y_opacity ) && $data_fancy_text_settings_x_opacity !== $data_fancy_text_settings_y_opacity ) {
						$fancy_text_value_arr['opacity'] = [ (float) $data_fancy_text_settings_x_opacity['size'], (float) $data_fancy_text_settings_y_opacity['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_x_rotate ) && ! empty( $data_fancy_text_settings_y_rotate ) && $data_fancy_text_settings_x_rotate !== $data_fancy_text_settings_y_rotate ) {
						$fancy_text_value_arr['rotate'] = [ (int) $data_fancy_text_settings_x_rotate['size'], (int) $data_fancy_text_settings_y_rotate['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_translate_xx ) && ! empty( $data_fancy_text_settings_translate_xy ) && $data_fancy_text_settings_translate_xx !== $data_fancy_text_settings_translate_xy ) {
						$fancy_text_value_arr['translateX'] = [ (float) $data_fancy_text_settings_translate_xx['size'], (float) $data_fancy_text_settings_translate_xy['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_translate_yx ) && ! empty( $data_fancy_text_settings_translate_yy ) && $data_fancy_text_settings_translate_yx !== $data_fancy_text_settings_translate_yy ) {
						$fancy_text_value_arr['translateY'] = [ (float) $data_fancy_text_settings_translate_yx['size'], (float) $data_fancy_text_settings_translate_yy['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_x_filter ) && ! empty( $data_fancy_text_settings_y_filter ) && $data_fancy_text_settings_x_filter !== $data_fancy_text_settings_y_filter ) {
						$fancy_text_value_arr['filter'] = [ 'blur(' . (float) $data_fancy_text_settings_x_filter['size'] . 'px)', 'blur(' . (float) $data_fancy_text_settings_y_filter['size'] . 'px)' ];
					}

					if ( ! empty( $data_fancy_text_settings_x_clippath ) && ! empty( $data_fancy_text_settings_y_clippath ) && $data_fancy_text_settings_x_clippath !== $data_fancy_text_settings_y_clippath ) {
						$fancy_text_value_arr['clipPath'] = [ 'inset(' . (float) $data_fancy_text_settings_x_clippath['top'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['right'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['bottom'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['left'] . 'px)', 'inset(' . (float) $data_fancy_text_settings_y_clippath['top'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['right'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['bottom'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['left'] . 'px)' ];
					}
				}
			}

			$data_fancy_text = ! empty( $fancy_text_value_arr ) ? $fancy_text_value_arr : [];
			return $data_fancy_text;
		}
	}
}
