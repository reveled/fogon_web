<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use CraftoAddons\Controls\Groups\Button_Group_Control;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for image carousel.
 *
 * @package Crafto
 */

// If class `Image_Carousel` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Image_Carousel' ) ) {
	/**
	 * Define `Image_Carousel` class.
	 */
	class Image_Carousel extends Widget_Base {
		/**
		 * Retrieve the list of scripts the Image Carousel widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$image_carousel_scripts       = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$image_carousel_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$image_carousel_scripts[] = 'swiper';
					
					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$image_carousel_scripts[] = 'crafto-magic-cursor';
					}
				}

				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$image_carousel_scripts[] = 'magnific-popup';
					$image_carousel_scripts[] = 'crafto-lightbox-gallery';
				}
				$image_carousel_scripts[] = 'crafto-default-carousel';
			}
			return $image_carousel_scripts;
		}

		/**
		 * Retrieve the list of styles the Image Carousel widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$image_carousel_styles        = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( crafto_disable_module_by_key( 'swiper' ) ) {
				$image_carousel_styles = [
					'swiper',
					'nav-pagination',
				];

				if ( is_rtl() ) {
					$image_carousel_styles[] = 'nav-pagination-rtl';
				}
				
				if ( '0' === $crafto_disable_all_animation ) {
					$image_carousel_styles[] = 'crafto-magic-cursor';
				}
			}

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$image_carousel_styles[] = 'crafto-widgets-rtl';
				} else {
					$image_carousel_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$image_carousel_styles[] = 'crafto-image-carousel-rtl-widget';
				}
				$image_carousel_styles[] = 'crafto-image-carousel-widget';
			}
			return $image_carousel_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve image carousel widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-image-carousel';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve image carousel widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Image Carousel', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve image carousel widget icon.
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
			return 'https://crafto.themezaa.com/documentation/image-carousel/';
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
				'photo',
				'visual',
				'carousel',
				'slider',
				'photo carousel',
				'media slider',
				'gallery slider',
			];
		}

		/**
		 * Register image carousel widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_image_carousel',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_image_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'image-carousel-1',
					'options'            => [
						'image-carousel-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'image-carousel-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'image-carousel-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'render_type'        => 'template',
					'prefix_class'       => 'el-',
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_carousel',
				[
					'label'      => esc_html__( 'Add Images', 'crafto-addons' ),
					'type'       => Controls_Manager::GALLERY,
					'show_label' => false,
					'dynamic'    => [
						'active' => true,
					],
					'default'    => [
						[
							'id'  => 0,
							'url' => Utils::get_placeholder_image_src(),
						],
						[
							'id'  => 0,
							'url' => Utils::get_placeholder_image_src(),
						],
						[
							'id'  => 0,
							'url' => Utils::get_placeholder_image_src(),
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_show',
				[
					'label'              => esc_html__( 'Enable Content', 'crafto-addons' ),
					'type'               => Controls_Manager::SWITCHER,
					'label_off'          => esc_html__( 'No', 'crafto-addons' ),
					'label_on'           => esc_html__( 'Yes', 'crafto-addons' ),
					'default'            => 'no',
					'return_value'       => 'yes',
					'frontend_available' => true,
					'condition'          => [
						'crafto_image_style' => [
							'image-carousel-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_direction',
				[
					'label'        => esc_html__( 'Content Position', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'left',
					'options'      => [
						'left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-arrow-left',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-arrow-right',
						],
					],
					'condition'    => [
						'crafto_image_style'  => 'image-carousel-1',
						'crafto_content_show' => 'yes',
					],
					'prefix_class' => 'elementor-content-',
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
					'label'     => esc_html__( 'Image Stretch', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'no',
					'options'   => [
						'no'  => esc_html__( 'No', 'crafto-addons' ),
						'yes' => esc_html__( 'Yes', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_content_show!' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_link_to',
				[
					'label'     => esc_html__( 'Link', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'none',
					'options'   => [
						'none'   => esc_html__( 'None', 'crafto-addons' ),
						'file'   => esc_html__( 'Media File', 'crafto-addons' ),
						'custom' => esc_html__( 'Custom URL', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_content_show!' => 'yes',
						'crafto_image_style!'  => [
							'image-carousel-3',
						],
					],
				]
			);

			$this->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_link_to'       => 'custom',
						'crafto_content_show!' => 'yes',
						'crafto_image_style!'  => [
							'image-carousel-3',
						],
					],
					'show_label'  => false,
				]
			);

			$this->add_control(
				'crafto_open_lightbox',
				[
					'label'     => esc_html__( 'Lightbox', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'no',
					'options'   => [
						'yes' => esc_html__( 'Yes', 'crafto-addons' ),
						'no'  => esc_html__( 'No', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_link_to'       => 'file',
						'crafto_content_show!' => 'yes',
						'crafto_image_style!'  => [
							'image-carousel-3',
						],
					],
				]
			);

			$this->add_control(
				'crafto_caption_type',
				[
					'label'     => esc_html__( 'Caption', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						''            => esc_html__( 'None', 'crafto-addons' ),
						'title'       => esc_html__( 'Title', 'crafto-addons' ),
						'caption'     => esc_html__( 'Caption', 'crafto-addons' ),
						'description' => esc_html__( 'Description', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_content_show!' => 'yes',
						'crafto_image_style!'  => [
							'image-carousel-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_content',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'condition' => [
						'crafto_image_style'  => 'image-carousel-1',
						'crafto_content_show' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_image_carousel_heading',
				[
					'label'       => esc_html__( 'Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Heading goes here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_image_carousel_title_link',
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
				'crafto_image_carousel_subheading',
				[
					'label'       => esc_html__( 'Subheading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Subheading goes here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_image_carousel_description',
				[
					'label'      => esc_html__( 'Description', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => true,
				]
			);
			$this->add_control(
				'crafto_image_price_heading',
				[
					'label'       => esc_html__( 'Price', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( '$100', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_image_carousel_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Per night', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$this->end_controls_section();

			Button_Group_Control::button_content_fields(
				$this,
				[
					'type'    => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => '',
					'repeat'  => 'no',
				],
				[
					'condition' => [
						'crafto_image_style'  => 'image-carousel-1',
						'crafto_content_show' => 'yes',
					],
				],
			);
			$this->start_controls_section(
				'crafto_image_icon_section',
				[
					'label'     => esc_html__( 'Hover Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_image_style' => 'image-carousel-2',
					],
				]
			);
			$this->add_control(
				'crafto_image_icon',
				[
					'label'        => esc_html__( 'Enable Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_image_select_icon',
				[
					'label'            => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'icon-feather-search',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_image_icon' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_image_overlay_section',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'condition' => [
						'crafto_image_style' => 'image-carousel-2',
					],
				]
			);
			$this->add_control(
				'crafto_image_enable_overlay',
				[
					'label'        => esc_html__( 'Enable Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_additional_options',
				[
					'label' => esc_html__( 'Carousel Settings', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_slide_vertical_position',
				[
					'label'      => esc_html__( 'Vertical Align', 'crafto-addons' ),
					'type'       => Controls_Manager::CHOOSE,
					'options'    => [
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
					'selectors'  => [
						'{{WRAPPER}} .swiper-wrapper' => 'align-items: {{VALUE}};',
					],
					'default'    => 'flex-start',
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_image_style',
										'operator' => '!==',
										'value'    => 'image-carousel-3',
									],
									[
										'name'     => 'crafto_content_show',
										'operator' => '!==',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_image_style',
										'operator' => '===',
										'value'    => 'image-carousel-2',
									],
								],
							],
						],
					],
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
					'condition'    => [
						'crafto_content_show!' => 'yes',
					],
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
						'crafto_effect'            => 'slide',
						'crafto_slide_width_auto!' => 'slider-width-auto',
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
				'crafto_centeredslides',
				[
					'label'        => esc_html__( 'Enable Centered Slides', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
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
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_slide_opacity',
				[
					'label'      => esc_html__( 'Slide Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_control(
				'crafto_slide_grayscale',
				[
					'label'      => esc_html__( 'Grayscale', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'%',
						'custom',
					],
					'range'      => [
						'%' => [
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide:not(.swiper-slide-active)' => 'filter: grayscale({{SIZE}}%) !important;',
						'{{WRAPPER}} .swiper-slide.swiper-slide-active' => 'filter: grayscale(0%) !important;',
					],
					'condition'  => [
						'crafto_image_style' => 'image-carousel-1',
					],
				]
			);
			$this->add_control(
				'crafto_active_slide_opacity',
				[
					'label'      => esc_html__( 'Active Slide Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-slide.swiper-slide-active' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-images-carousel-wrapper.image-carousel-3' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_image_style' => 'image-carousel-3',
					],
				]
			);
			$this->add_control(
				'crafto_carousel_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-widget-crafto-image-carousel.elementor-content-left .elementor-widget-container, {{WRAPPER}}.elementor-widget-crafto-image-carousel.elementor-content-right .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_image_style'  => 'image-carousel-1',
						'crafto_content_show' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_content',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_image_style'  => 'image-carousel-1',
						'crafto_content_show' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_content_general_color',
					'selector'  => '{{WRAPPER}} .image-carousel-wrapper',
					'condition' => [
						'crafto_content_show' => 'yes',
						'crafto_image_style'  => 'image-carousel-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_content_general_border',
					'selector'  => '{{WRAPPER}} .image-carousel-wrapper',
					'condition' => [
						'crafto_content_show' => 'yes',
						'crafto_image_style'  => 'image-carousel-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_general_width',
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
					'condition'  => [
						'crafto_content_show' => 'yes',
						'crafto_image_style'  => 'image-carousel-1',
					],
					'selectors'  => [
						'{{WRAPPER}} .image-carousel-wrapper' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_general_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_show' => 'yes',
						'crafto_image_style'  => 'image-carousel-1',
					],
				]
			);
			$this->add_control(
				'crafto_carousel_title',
				[
					'label'     => esc_html__( 'Heading', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_image_style' => [
							'image-carousel-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_carousel_title_typography',
					'selector'  => '{{WRAPPER}} .heading',
					'condition' => [
						'crafto_image_style' => [
							'image-carousel-1',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_image_carousel_title_tabs',
				[
					'conditions' => [
						'terms' => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_image_style',
										'operator' => '===',
										'value'    => 'image-carousel-1',
									],
									[
										'name'     => 'crafto_image_carousel_title_link[url]',
										'operator' => '!==',
										'value'    => '',
									],
								],
							],
						],
					],
				]
			);
			$this->start_controls_tab(
				'crafto_image_carousel_title_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_title_link[url]!' => '',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_carousel_title_color',
					'selector'       => '{{WRAPPER}} .heading, {{WRAPPER}} .heading a',
					'conditions'     => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_image_style',
										'operator' => '===',
										'value'    => 'image-carousel-1',
									],
									[
										'name'     => 'crafto_image_carousel_title_link[url]',
										'operator' => '!==',
										'value'    => '',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_image_style',
										'operator' => '===',
										'value'    => 'image-carousel-1',
									],
								],
							],
						],
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_image_carousel_title_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_title_link[url]!' => '',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_carousel_title_hover_color',
					'selector'       => '{{WRAPPER}} .heading a:hover',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_title_link[url]!' => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_carousel_title_margin',
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
					'condition'  => [
						'crafto_image_style' => 'image-carousel-1',
					],
				]
			);
			$this->add_control(
				'crafto_carousel_subtitle',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_subheading!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_carousel_subtitle_typography',
					'selector'  => '{{WRAPPER}} .subheading',
					'condition' => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_subheading!' => '',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_carousel_subtitle_color',
					'selector'       => '{{WRAPPER}} .subheading',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_subheading!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_carousel_description',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_description!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_carousel_description_typography',
					'selector'  => '{{WRAPPER}} .description',
					'condition' => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_description!' => '',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_carousel_description_color',
					'selector'       => '{{WRAPPER}} .description',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_image_style' => 'image-carousel-1',
						'crafto_image_carousel_description!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_carousel_price',
				[
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_image_style'          => 'image-carousel-1',
						'crafto_image_price_heading!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_carousel_price_typography',
					'selector'  => '{{WRAPPER}} .price',
					'condition' => [
						'crafto_image_style'          => 'image-carousel-1',
						'crafto_image_price_heading!' => '',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_carousel_price_color',
					'selector'       => '{{WRAPPER}} .price',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_image_style'          => 'image-carousel-1',
						'crafto_image_price_heading!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_caption_separator_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .image-carousel-wrapper .price-content-box' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_image_style'          => 'image-carousel-1',
						'crafto_image_price_heading!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_price_padding',
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
						'{{WRAPPER}} .price-content-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_image_style'          => 'image-carousel-1',
						'crafto_image_price_heading!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_carousel_label',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_carousel_label_typography',
					'selector'  => '{{WRAPPER}} .label',
					'condition' => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_carousel_label_color',
					'selector'       => '{{WRAPPER}} .label',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_carousel_label_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .label',
					'condition' => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_carousel_label_border',
					'selector'  => '{{WRAPPER}} .label',
					'condition' => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_carousel_label_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_label_padding',
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
						'{{WRAPPER}} .label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_carousel_label_margin',
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
						'{{WRAPPER}} .label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_image_style'           => 'image-carousel-1',
						'crafto_image_carousel_label!' => '',
					],
				]
			);
			$this->end_controls_section();

			Button_Group_Control::button_style_fields(
				$this,
				[
					'type'  => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
				[
					'condition' => [
						'crafto_content_show' => 'yes',
						'crafto_image_style'  => 'image-carousel-1',
					],
				]
			);
			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_content_show!' => 'yes',
						'crafto_image_style!'  => 'image-carousel-3',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_image_size',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-images-carousel-wrapper .elementor-images-carousel .swiper-slide-image' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_size_height',
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
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-images-carousel-wrapper .elementor-images-carousel .swiper-slide-image' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_gallery_vertical_align',
				[
					'label'     => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Start', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'flex-end'   => [
							'title' => esc_html__( 'End', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'condition' => [
						'crafto_slides_to_show!' => '1',
						'crafto_image_style'     => 'image-carousel-2',
					],
					'selectors' => [
						'{{WRAPPER}} .swiper-wrapper' => 'display: flex; align-items: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_image_border',
					'selector' => '{{WRAPPER}} .elementor-images-carousel-wrapper .elementor-images-carousel .swiper-slide-image',
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
						'{{WRAPPER}} .elementor-images-carousel-wrapper .elementor-images-carousel .swiper-slide-image, {{WRAPPER}} .image-carousel-2 figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_caption',
				[
					'label'     => esc_html__( 'Caption', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_caption_type!' => '',
						'crafto_image_style!'  => [
							'image-carousel-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_caption_align',
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
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .elementor-image-carousel-caption' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_caption_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-image-carousel-caption' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_caption_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .elementor-image-carousel-caption',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_icon',
				[
					'label'     => esc_html__( 'Hover Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_image_icon'  => 'yes',
						'crafto_image_style' => 'image-carousel-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_icon_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .icon-box',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_icon_color',
					'selector'       => '{{WRAPPER}} .icon-box i:before, {{WRAPPER}} .icon-box svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 75,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .icon-box i, {{WRAPPER}} .icon-box svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_box_size',
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
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .icon-box' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_icon_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_carousel_overlay',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_image_style'          => 'image-carousel-2',
						'crafto_image_enable_overlay' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_image_carousel_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .swiper-slide-inner',
				]
			);
			$this->add_control(
				'crafto_image_carousel_opacity',
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
						'{{WRAPPER}} .swiper-slide-inner:hover  img' => 'opacity: {{SIZE}};',
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
			$this->add_control(
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
						'{{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .swiper .swiper-pagination, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .number-style-3 .swiper-pagination-wrapper' => 'right: {{SIZE}}{{UNIT}}',
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
		 * Render image carousel widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings             = $this->get_settings_for_display();
			$image_carousel_style = $this->get_settings( 'crafto_image_style' );
			$crafto_image_icon    = ( isset( $settings['crafto_image_icon'] ) && $settings['crafto_image_icon'] ) ? $settings['crafto_image_icon'] : '';
			$crafto_image_overlay = ( isset( $settings['crafto_image_enable_overlay'] ) && $settings['crafto_image_enable_overlay'] ) ? $settings['crafto_image_enable_overlay'] : '';

			if ( empty( $settings['crafto_carousel'] ) ) {
				return;
			}

			$slides                  = [];
			$crafto_slide_width_auto = $this->get_settings( 'crafto_slide_width_auto' );

			if ( ! empty( $settings['crafto_image_carousel_title_link']['url'] ) ) {
				$this->add_link_attributes( '_link', $settings['crafto_image_carousel_title_link'] );
				$this->add_render_attribute( '_link', 'class', 'title-link' );
			}

			/* icon */
			$custom_link = '';
			$is_new      = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$migrated    = isset( $settings['__fa4_migrated']['crafto_image_select_icon'] );

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_image_select_icon'], [ 'aria-hidden' => 'true' ] );
				$custom_link .= ob_get_clean();
			} elseif ( isset( $settings['crafto_image_select_icon']['value'] ) && ! empty( $settings['crafto_image_select_icon']['value'] ) ) {
				$custom_link .= '<i class="' . esc_attr( $settings['crafto_image_select_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

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

			switch ( $image_carousel_style ) {
				case 'image-carousel-1':
				case 'image-carousel-2':
				case 'image-carousel-3':
					foreach ( $settings['crafto_carousel'] as $index => $attachment ) {
						$link_tag   = '';
						$image_html = '';
						$image_url  = '';

						$default_attr['class'] = 'swiper-slide-image';

						if ( ! empty( $attachment['id'] ) && ! wp_attachment_is_image( $attachment['id'] ) ) {
							$attachment['id'] = '';
						}
						if ( ! empty( $attachment['id'] ) ) {
							$image_array = wp_get_attachment_image_src( $attachment['id'], $settings['crafto_thumbnail_size'] );
							$image_url   = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';
						} elseif ( ! empty( $attachment['url'] ) ) {
							$image_src = Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], $settings['crafto_thumbnail_size'], $settings );

							if ( ! $image_src && isset( $attachment['url'] ) ) {
								$image_url = $attachment['url'];
							}
						}

						if ( 0 === $attachment['id'] ) {
							if ( ! empty( $image_url ) ) {
								$image_html = '<img src="' . esc_url( $image_url ) . '">';
							}
						} else {
							if ( ! empty( $attachment['id'] ) && ! wp_attachment_is_image( $attachment['id'] ) ) {
								$attachment['id'] = '';
							}
							if ( '' !== $attachment['id'] ) {
								$image_html = wp_kses_post( crafto_get_attachment_image_html( $settings, $settings['crafto_thumbnail_size'], $attachment, $default_attr ) );
							} elseif ( ! empty( $image_url ) ) {
								$image_html = '<img src="' . esc_url( $image_url ) . '">';
							}
						}

						$link = $this->get_link_url( $attachment, $settings );

						$img_alt = '';
						if ( isset( $attachment ) && isset( $attachment['id'] ) && ! empty( $attachment['id'] ) ) {
							$img_alt = get_post_meta( $attachment['id'], '_wp_attachment_image_alt', true );

							if ( empty( $img_alt ) ) {
								$img_alt = esc_attr( get_the_title( $attachment['id'] ) );
							}
						}
						if ( $link ) {
							$link_key = 'link_' . $index;

							$this->add_render_attribute(
								$link_key,
								[
									'data-elementor-open-lightbox' => 'no',
									'class'      => 'image-link',
									'aria-label' => $img_alt,
								]
							);

							if ( ! empty( $settings['crafto_link']['url'] ) ) {
								$this->add_link_attributes( $link_key, $settings['crafto_link'] );
							}

							if ( 'file' === $settings['crafto_link_to'] && 'yes' === $settings['crafto_open_lightbox'] ) {
								$this->add_render_attribute(
									$link_key,
									[
										'data-group' => $this->get_id(),
										'class'      => 'lightbox-group-gallery-item',
									],
								);

								$crafto_image_title_lightbox_popup   = get_theme_mod( 'crafto_image_title_lightbox_popup', '0' );
								$crafto_image_caption_lightbox_popup = get_theme_mod( 'crafto_image_caption_lightbox_popup', '0' );

								if ( '1' === $crafto_image_title_lightbox_popup ) {
									$crafto_attachment_title = get_the_title( $attachment['id'] );
									if ( ! empty( $crafto_attachment_title ) ) {
										$this->add_render_attribute(
											$link_key,
											[
												'title' => $crafto_attachment_title,
											],
										);
									}
								}
								if ( '1' === $crafto_image_caption_lightbox_popup ) {
									$crafto_lightbox_caption = wp_get_attachment_caption( $attachment['id'] );
									if ( ! empty( $crafto_lightbox_caption ) ) {
										$this->add_render_attribute(
											$link_key,
											[
												'data-lightbox-caption' => $crafto_lightbox_caption,
											],
										);
									}
								}
							}
							$link_tag = '<a href="' . $link['url'] . '" ' . $this->get_render_attribute_string( $link_key ) . '>';
						}
						$image_caption = $this->get_image_caption( $attachment );
						if ( 'image-carousel-1' === $image_carousel_style || 'image-carousel-2' === $image_carousel_style ) {
							if ( 'yes' === $this->get_settings( 'crafto_content_show' ) && 'image-carousel-1' === $image_carousel_style ) {
								$slide_html = '<div class="swiper-slide ' . $crafto_slide_width_auto . '" style="background-image:url(' . esc_url( $image_url ) . ');">' . $link_tag . '<figure class="swiper-slide-inner">';
							} elseif ( 'yes' === $crafto_image_overlay ) {
								$slide_html = '<div class="swiper-slide ' . $crafto_slide_width_auto . '">' . $link_tag . '<figure class="swiper-slide-inner image-overlay">' . $image_html;  // phpcs:ignore
							} else {
								$slide_html = '<div class="swiper-slide ' . $crafto_slide_width_auto . '">' . $link_tag . '<figure class="swiper-slide-inner">' . $image_html;  // phpcs:ignore
							}
							if ( 'yes' === $crafto_image_icon ) {
								$slide_html .= '<div class="gallery-hover"><div class="icon-box">' . $custom_link . '</div></div>';
							}
							if ( ! empty( $image_caption ) ) {
								$slide_html .= '<figcaption class="elementor-image-carousel-caption">' . $image_caption . '</figcaption>';
							}
							$slide_html .= '</figure>';
							if ( $link ) {
								$slide_html .= '</a>';
							}
							$slide_html .= '</div>';
							$slides[]    = $slide_html;
						} else {
							$slide_html  = '<div class="swiper-slide ' . $crafto_slide_width_auto . '"><div class="cover-background" style="background-image: url(' . esc_url( $image_url ) . ');">';
							$slide_html .= '</div></div>';
							$slides[]    = $slide_html;
						}
					}
					break;
			}

			if ( empty( $slides ) ) {
				return;
			}

			$slides_count                   = count( $settings['crafto_carousel'] );
			$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
			$crafto_slider_cursor           = $this->get_settings( 'crafto_slider_cursor' );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
			$crafto_pagination_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );
			$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
			$sliderconfig                   = array(
				'navigation'       => $crafto_navigation,
				'pagination'       => $crafto_pagination,
				'pagination_style' => $crafto_pagination_style,
				'number_style'     => $crafto_pagination_number_style,
				'autoplay'         => $this->get_settings( 'crafto_autoplay' ),
				'centered_slides'  => $this->get_settings( 'crafto_centeredslides' ),
				'autoplay_speed'   => $this->get_settings( 'crafto_autoplay_speed' ),
				'pause_on_hover'   => $this->get_settings( 'crafto_pause_on_hover' ),
				'loop'             => $this->get_settings( 'crafto_infinite' ),
				'effect'           => $this->get_settings( 'crafto_effect' ),
				'speed'            => $this->get_settings( 'crafto_speed' ),
				'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
				'image_spacing'    => $this->get_settings( 'crafto_items_spacing' ),
				'auto_slide'       => $this->get_settings( 'crafto_slide_width_auto' ),
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
			/* END slider breakpoints */

			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}
			$this->add_render_attribute(
				[
					'carousel-wrapper' => [
						'class'         => [
							'elementor-images-carousel-wrapper',
							'swiper',
							$image_carousel_style,
							$crafto_slider_cursor,
							$magic_cursor,
						],
						'data-settings' => wp_json_encode( $sliderconfig ),
					],
					'carousel'         => [
						'class' => 'elementor-images-carousel swiper-wrapper',
					],
				],
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
			if ( 'yes' === $this->get_settings( 'crafto_image_stretch' ) ) {
				$this->add_render_attribute(
					'carousel',
					'class',
					'swiper-image-stretch',
				);
			}

			$this->add_render_attribute(
				'crafto_carousel_heading',
				[
					'class' => 'heading',
				],
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
				]
			);
			?>
			<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
				<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
					<?php echo implode( '', $slides ); // phpcs:ignore ?>
				</div>
				<?php
				if ( 1 < $slides_count ) {
					$this->swiper_pagination();
				}
				?>
			</div>
			<?php
			if ( 'yes' === $this->get_settings( 'crafto_content_show' ) && 'image-carousel-1' === $image_carousel_style ) {
				?>
				<div class="image-carousel-wrapper">
					<div class="content-wrap">
						<?php
						if ( ! empty( $settings['crafto_image_carousel_subheading'] ) ) {
							?>
							<div class="subheading"><?php echo esc_html( $settings['crafto_image_carousel_subheading'] ); ?></div>
							<?php
						}
						if ( ! empty( $settings['crafto_image_carousel_heading'] ) ) {
							?>
							<<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'crafto_carousel_heading' ); ?>>
							<?php
							if ( ! empty( $settings['crafto_image_carousel_title_link']['url'] ) ) {
								?>
								<a <?php $this->print_render_attribute_string( '_link' ); ?>>
									<?php echo esc_html( $settings['crafto_image_carousel_heading'] ); ?>
								</a>
								<?php
							} else {
								echo esc_html( $settings['crafto_image_carousel_heading'] );
							}
							?>
							</<?php echo $this->get_settings( 'crafto_header_size'); // phpcs:ignore ?>>
							<?php
						}
						if ( ! empty( $settings['crafto_image_carousel_description'] ) ) {
							?>
							<div class="description">
								<?php echo sprintf( '%s', wp_kses_post( $settings['crafto_image_carousel_description'] ) ); // phpcs:ignore ?>
							</div>
							<?php
						}
						?>
					</div>
					<div class="price-content-box">
						<?php
						if ( ! empty( $settings['crafto_image_price_heading'] ) || ! empty( $settings['crafto_image_carousel_label'] ) ) {
							?>
							<div class="price">
								<?php
								echo sprintf( '%s', wp_kses_post( $settings['crafto_image_price_heading'] ) ); // phpcs:ignore
								if ( ! empty( $settings['crafto_image_carousel_label'] ) ) {
									?>
									<span class="label">
										<?php echo sprintf( '%s', wp_kses_post( $settings['crafto_image_carousel_label'] ) );  // phpcs:ignore?>
									</span>
									<?php
								}
								?>
							</div>
							<?php
						}
						Button_Group_Control::render_button_content( $this, 'primary' );
						?>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * Return swiper pagination.
		 */
		public function swiper_pagination() {
			$settings                       = $this->get_settings_for_display();
			$previous_arrow_icon            = '';
			$next_arrow_icon                = '';
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$previous_icon_migrated         = isset( $settings['__fa4_migrated']['crafto_previous_arrow_icon'] );
			$next_icon_migrated             = isset( $settings['__fa4_migrated']['crafto_next_arrow_icon'] );
			$crafto_navigation              = isset( $settings['crafto_navigation'] ) ? $settings['crafto_navigation'] : '';
			$crafto_pagination              = isset( $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';
			$crafto_pagination_style        = isset( $settings['crafto_pagination_style'] ) ? $settings['crafto_pagination_style'] : '';
			$crafto_pagination_number_style = isset( $settings['crafto_pagination_number_style'] ) ? $settings['crafto_pagination_number_style'] : '';

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

			if ( 'yes' === $crafto_navigation && 'number-style-4' !== $crafto_pagination_number_style ) {
				?>
				<div class="elementor-swiper-button elementor-swiper-button-prev">
					<?php echo $previous_arrow_icon; // phpcs:ignore ?>
					<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'crafto-addons' ); ?></span>
				</div>
				<div class="elementor-swiper-button elementor-swiper-button-next">
					<?php echo $next_arrow_icon; // phpcs:ignore ?>
					<span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'crafto-addons' ); ?></span>
				</div>
				<?php
			}

			if ( 'yes' === $crafto_pagination && 'dots' === $crafto_pagination_style ) {
				?>
				<div class="swiper-pagination"></div>
				<?php
			}

			if ( 'yes' === $crafto_pagination && 'number' === $crafto_pagination_style && 'number-style-1' === $crafto_pagination_number_style || 'number-style-2' === $crafto_pagination_number_style ) {
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

		/**
		 * Retrieve image carousel link URL.
		 *
		 * @access private
		 *
		 * @param array  $attachment comment about this variable.
		 *
		 * @param object $instance comment about this variable.
		 *
		 * @return array|string|false An array/string containing the attachment URL, or false if no link.
		 */
		private function get_link_url( $attachment, $instance ) {

			if ( 'none' === $instance['crafto_link_to'] ) {
				return false;
			}
			if ( 'custom' === $instance['crafto_link_to'] ) {
				if ( empty( $instance['crafto_link']['url'] ) ) {
					return false;
				}
				return $instance['crafto_link'];
			}

			return [
				'url' => wp_get_attachment_url( $attachment['id'] ),
			];
		}

		/**
		 * Retrieve image carousel caption.
		 *
		 * @access private
		 *
		 * @param array $attachment comment about this variable.
		 *
		 * @return string The caption of the image.
		 */
		private function get_image_caption( $attachment ) {

			$caption_type = $this->get_settings_for_display( 'crafto_caption_type' );

			if ( empty( $caption_type ) ) {
				return '';
			}
			$attachment_post = get_post( $attachment['id'] );
			if ( 'caption' === $caption_type ) {
				return $attachment_post->post_excerpt;
			}
			if ( 'title' === $caption_type ) {
				return $attachment_post->post_title;
			}

			return $attachment_post->post_content;
		}
	}
}
