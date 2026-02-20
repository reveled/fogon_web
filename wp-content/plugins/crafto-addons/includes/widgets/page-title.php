<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for Page Title.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_page_title_template() ) {
	return;
}

if ( ! class_exists( 'CraftoAddons\Widgets\Page_Title' ) ) {

	class Page_Title extends Widget_Base {
		/**
		 * Retrieve the list of scripts the page title widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$page_title_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$page_title_scripts[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$page_title_scripts[] = 'swiper';
				}

				if ( crafto_disable_module_by_key( 'custom-parallax' ) ) {
					$page_title_scripts[] = 'custom-parallax';
				}

				if ( crafto_disable_module_by_key( 'fitvids' ) ) {
					$page_title_scripts[] = 'jquery.fitvids';
				}

				if ( '0' === $crafto_disable_all_animation ) {
					if ( crafto_disable_module_by_key( 'appear' ) ) {
						$page_title_scripts[] = 'appear';
					}

					if ( crafto_disable_module_by_key( 'anime' ) ) {
						$page_title_scripts[] = 'splitting';
						$page_title_scripts[] = 'anime';
						$page_title_scripts[] = 'crafto-fancy-text-effect';
					}
				}
				$page_title_scripts[] = 'crafto-page-title-widget';
			}
			return $page_title_scripts;
		}

		/**
		 * Retrieve the list of styles the page title widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$page_title_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$image_carousel_styles[] = 'crafto-vendors-rtl';
				} else {
					$image_carousel_styles[] = 'crafto-vendors';
				}
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$page_title_styles[] = 'swiper';
				}

				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					$page_title_styles[] = 'splitting';
				}

				if ( is_rtl() ) {
					$page_title_styles[] = 'crafto-page-title-widget-rtl';
				}
				$page_title_styles[] = 'crafto-page-title-widget';
			}
			return $page_title_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-page-title';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Page Title', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-title crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/crafto-page-title/';
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
				'crafto-page-title',
			];
		}

		/**
		 * Register page title widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_page_title_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_page_title_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'left-alignment',
					'options'            => [
						'left-alignment'         => esc_html__( 'Left Alignment', 'crafto-addons' ),
						'right-alignment'        => esc_html__( 'Right Alignment', 'crafto-addons' ),
						'center-alignment'       => esc_html__( 'Center Alignment', 'crafto-addons' ),
						'big-typography'         => esc_html__( 'Big Typography', 'crafto-addons' ),
						'big-typography-content' => esc_html__( 'Big Typography with Content', 'crafto-addons' ),
						'big-typography-image'   => esc_html__( 'Big Typography with Image', 'crafto-addons' ),
						'parallax-background'    => esc_html__( 'Parallax Background', 'crafto-addons' ),
						'gallery-background'     => esc_html__( 'Gallery Background', 'crafto-addons' ),
						'background-video'       => esc_html__( 'Video Background', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_page_title_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_page_enable_title_heading',
				[
					'label'        => esc_html__( 'Enable Title Bar', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_page_title_text',
				[
					'label'       => esc_html__( 'Custom Page Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'description' => esc_html__( 'The custom page title will replace the page and post titles', 'crafto-addons' ),
					'condition'   => [
						'crafto_page_enable_title_heading!' => '',
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
					'default'   => 'h1',
					'condition' => [
						'crafto_page_enable_title_heading!' => '',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_page_subtitle_section',
				[
					'label' => esc_html__( 'Subtitle', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_page_subtitle_enable',
				[
					'label'        => esc_html__( 'Enable Subtitle', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_page_subtitle',
				[
					'label'       => esc_html__( 'Custom Subtitle', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'description' => esc_html__( 'The custom subtitle will replace the page and post subtitles.', 'crafto-addons' ),
					'condition'   => [
						'crafto_page_subtitle_enable!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_page_icon_enable',
				[
					'label'        => esc_html__( 'Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'crafto_page_title_style' => [
							'big-typography',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_page_icon_enable' => 'yes',
						'crafto_page_title_style' => [
							'big-typography',
						],
					],
				]
			);
			$this->add_control(
				'crafto_separator',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-content',
						],
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_page_content_section',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography-content',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_content_enable',
				[
					'label'        => esc_html__( 'Enable Content', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				],
			);
			$this->add_control(
				'crafto_page_content',
				[
					'label'       => esc_html__( 'Content', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'default'     => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin non odio accumsan, dapibus urna et, rhoncus neque lorem ipsum is simply printing.', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_page_content_enable!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_content_separator',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'crafto_page_title_style' => [
							'big-typography-content',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_background_section',
				[
					'label' => esc_html__( 'Background', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_page_title_enable_bg_image',
				[
					'label'        => esc_html__( 'Enable Background Image', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_page_title_style!' => [
							'gallery-background',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fallback_image',
				[
					'label'     => esc_html__( 'Choose Background Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_page_title_enable_bg_image!' => '',
						'crafto_page_title_style!' => [
							'gallery-background',
						],
					],
				]
			);
			$this->add_responsive_control(
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
						'{{WRAPPER}} .cover-background' => 'background-position: {{VALUE}};',
					],
					'condition' => [
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_page_title_style!'    => 'gallery-background',
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
						'{{WRAPPER}} .cover-background' => 'background-position-x: {{SIZE}}{{UNIT}} {{crafto_bg_img_xpos.SIZE}}{{crafto_bg_img_xpos.UNIT}}',
					],
					'condition'  => [
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_bg_img_position'      => 'initial',
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
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_bg_img_position'      => 'initial',
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
						'(desktop+){{WRAPPER}} .cover-background' => 'background-attachment: {{VALUE}};',
					],
					'condition' => [
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_page_title_style!'    => 'gallery-background',
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
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_bg_img_attachment'    => 'fixed',
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
						'{{WRAPPER}} .cover-background' => 'background-repeat: {{VALUE}};',
					],
					'condition' => [
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_page_title_style!'    => 'gallery-background',
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
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_page_title_style!'    => 'gallery-background',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_bg_img_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
						'vw' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'required'   => true,
					'selectors'  => [
						'{{WRAPPER}} .cover-background' => 'background-size: {{SIZE}}{{UNIT}} auto',
					],
					'condition'  => [
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_fallback_image[url]!' => '',
						'crafto_page_title_style!'    => 'gallery-background',
					],
				]
			);

			$this->add_control(
				'crafto_image_gallery_data',
				[
					'label'      => esc_html__( 'Add Images', 'crafto-addons' ),
					'type'       => Controls_Manager::GALLERY,
					'default'    => [],
					'show_label' => false,
					'condition'  => [
						'crafto_page_title_style' => 'gallery-background',
					],
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
					'condition' => [
						'crafto_page_title_enable_bg_image' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_parallax',
				[
					'label'        => esc_html__( 'Enable Parallax', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'parallax',
					'condition'    => [
						'crafto_page_title_style!' => [
							'gallery-background',
							'background-video',
							'big-typography-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_title_parallax',
				[
					'label'     => esc_html__( 'Parallax Effects', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'unit' => 'px',
						'size' => 1.5,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1.5,
							'step' => 0.1,
						],
					],
					'condition' => [
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_parallax'             => 'parallax',
						'crafto_fallback_image[url]!' => '',
						'crafto_page_title_style!'    => [
							'gallery-background',
							'background-video',
							'big-typography-image',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_title_video_section',
				[
					'label'     => esc_html__( 'Video', 'crafto-addons' ),
					'condition' => [
						'crafto_page_title_style' => [
							'background-video',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_title_video_type',
				[
					'label'     => esc_html__( 'Video Source Type', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'self'     => esc_html__( 'Self-Hosted', 'crafto-addons' ),
						'external' => esc_html__( 'External Video', 'crafto-addons' ),
					],
					'default'   => 'self',
					'separator' => 'before',
					'condition' => [
						'crafto_page_title_style' => 'background-video',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_video_mp4',
				[
					'label'       => esc_html__( 'Video Link (MP4)', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_page_title_video_type' => 'self',
						'crafto_page_title_style'      => 'background-video',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_video_ogg',
				[
					'label'       => esc_html__( 'Video Link (OGG)', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_page_title_video_type' => 'self',
						'crafto_page_title_style'      => 'background-video',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_video_webm',
				[
					'label'       => esc_html__( 'Video Link (WEBM)', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_page_title_video_type' => 'self',
						'crafto_page_title_style'      => 'background-video',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_video_youtube',
				[
					'label'       => esc_html__( 'External Video URL', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'description' => esc_html__( 'Add the YouTube embed URL (e.g. https://www.youtube.com/embed/xxxxxxxx) or the Vimeo embed URL (e.g. https://player.vimeo.com/video/xxxxxxxx). You can find these in the src attribute of the video’s embed iframe code.', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_page_title_video_type' => 'external',
						'crafto_page_title_style'      => 'background-video',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_video_loop',
				[
					'label'        => esc_html__( 'Loop Video', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'separator'    => 'before',
					'condition'    => [
						'crafto_page_title_video_type' => 'self',
						'crafto_page_title_style'      => 'background-video',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_video_muted',
				[
					'label'        => esc_html__( 'Mute Video', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_page_title_video_type' => 'self',
						'crafto_page_title_style'      => 'background-video',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_title_breadcrumb_section',
				[
					'label' => esc_html__( 'Breadcrumb', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_page_title_breadcrumb',
				[
					'label'        => esc_html__( 'Enable Breadcrumb', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_page_breadcrumb_position',
				[
					'label'     => esc_html__( 'Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'title-area',
					'options'   => [
						'title-area'       => esc_html__( 'In the title area', 'crafto-addons' ),
						'after-title-area' => esc_html__( 'After the title area', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_page_title_breadcrumb' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_breadcrumb_alignment',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'left',
					'options'   => [
						'left'   => esc_html__( 'Left', 'crafto-addons' ),
						'center' => esc_html__( 'Center', 'crafto-addons' ),
						'right'  => esc_html__( 'Right', 'crafto-addons' ),
					],
					'selectors_dictionary' => [
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'condition' => [
						'crafto_page_title_breadcrumb'    => 'yes',
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
					'selectors' => [
						'{{WRAPPER}} .main-title-breadcrumb' => 'text-align: {{VALUE}}',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_title_scroll_to_down_section',
				[
					'label'     => esc_html__( 'Scroll Button', 'crafto-addons' ),
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-image',
							'gallery-background',
							'big-typography-content',
							'gallery-background',
							'background-video',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_title_scroll_to_down',
				[
					'label'        => esc_html__( 'Enable Scroll Button', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_page_title_scroll_to_section_id',
				[
					'label'       => esc_html__( 'Anchor ID', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'about',
					'title'       => esc_html__( 'Add your next section id WITHOUT the Hash key. e.g: my-id', 'crafto-addons' ),
					'description' => esc_html__( 'Assign the Anchor ID of the target section for scrolling on button click.', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_page_title_scroll_to_down' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Choose Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fa-solid fa-arrow-down',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_page_title_scroll_to_down' => 'yes',
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
					'condition'    => [
						'crafto_page_title_scroll_to_down' => 'yes',
					],
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
						'crafto_view!'                     => 'default',
						'crafto_page_title_scroll_to_down' => 'yes',
					],
					'prefix_class' => 'elementor-shape-',
				]
			);
			$this->add_control(
				'crafto_scroll_to_down_position',
				[
					'label'     => esc_html__( 'Button Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'content-area',
					'options'   => [
						'content-area'       => esc_html__( 'In content area', 'crafto-addons' ),
						'after-content-area' => esc_html__( 'After content area', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_page_title_scroll_to_down' => 'yes',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_title_settings',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_title_position',
				[
					'label'                => esc_html__( 'Title Position', 'crafto-addons' ),
					'type'                 => Controls_Manager::SELECT,
					'default'              => 'bottom',
					'options'              => [
						'top'    => esc_html__( 'Top', 'crafto-addons' ),
						'bottom' => esc_html__( 'Bottom', 'crafto-addons' ),
					],
					'selectors_dictionary' => [
						'top'    => '-5',
						'bottom' => '',
					],
					'render_type'          => 'ui',
					'selectors'            => [
						'{{WRAPPER}} .crafto-main-title' => 'order: {{VALUE}};',
					],
					'condition'            => [
						'crafto_page_title_style!' => [
							'left-alignment',
							'right-alignment',
							'center-alignment',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_height',
				[
					'label'       => esc_html__( 'Height', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 1000,
							'min' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .title-content-wrap, {{WRAPPER}} .crafto-main-title-wrap.background-video' => 'height: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_meta_category',
				[
					'label'        => esc_html__( 'Category', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'description'  => esc_html__( 'If yes, a category will display in page title area', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'crafto_page_title_meta_author',
				[
					'label'        => esc_html__( 'Author', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'description'  => esc_html__( 'If yes, a author will display in page title area', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_meta_author_text',
				[
					'label'     => esc_html__( 'Author Text', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'By&nbsp;', 'crafto-addons' ),
					'condition' => [
						'crafto_page_title_meta_author'   => 'yes',
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);

			$this->add_control(
				'crafto_page_title_meta_date',
				[
					'label'        => esc_html__( 'Date', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'description'  => esc_html__( 'If yes, a date will display in page title area', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_meta_date_format',
				[
					'label'       => esc_html__( 'Date Format', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'description' => sprintf(
						'%1$s <a target="_blank" href="%2$s" rel="noopener noreferrer">%3$s</a> %4$s',
						esc_html__( 'Date format should be like F j, Y', 'crafto-addons' ),
						esc_url( 'https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples' ),
						esc_html__( 'click here', 'crafto-addons' ),
						esc_html__( 'to see other date formates.', 'crafto-addons' )
					),
					'condition'   => [
						'crafto_page_title_meta_date'     => 'yes',
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_title_fancy_text_animation',
				[
					'label' => esc_html__( 'Effects', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_fancy_text_animation',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
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

			$this->add_control(
				'crafto_subtitle_fancy_text_animation',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings',
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
				'crafto_subtitle_data_fancy_text_settings_effect',
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
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_ease',
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
						'crafto_subtitle_data_fancy_text_settings_effect' => 'custom',
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_colors',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#ffe400',
					'condition' => [
						'crafto_subtitle_data_fancy_text_settings_effect' => 'slide',
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_start_delay',
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
						'crafto_subtitle_data_fancy_text_settings_effect' => 'custom',
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_duration',
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
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_speed',
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
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
						'crafto_subtitle_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_x_opacity',
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
						'crafto_subtitle_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_y_opacity',
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
						'crafto_subtitle_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
						'crafto_subtitle_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_translate_x',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_translate_xx',
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
						'crafto_subtitle_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_translate_xy',
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
						'crafto_subtitle_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_translate_y',
				[
					'label'     => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_translate_yx',
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
						'crafto_subtitle_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_translate_yy',
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
						'crafto_subtitle_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
						'crafto_subtitle_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_rotate',
				[
					'label'     => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_x_rotate',
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
						'crafto_subtitle_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_y_rotate',
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
						'crafto_subtitle_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_filter_settings_popover',
				[
					'label'        => esc_html__( 'Blur', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
						'crafto_subtitle_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_blur',
				[
					'label'     => esc_html__( 'Blur', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_x_filter',
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
						'crafto_subtitle_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_y_filter',
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
						'crafto_subtitle_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_clippath_settings_popover',
				[
					'label'        => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_subtitle_data_fancy_text_settings' => 'yes',
						'crafto_subtitle_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_subtitle_data_fancy_text_clippath',
				[
					'label'     => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_x_clippath',
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
						'crafto_subtitle_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_subtitle_data_fancy_text_settings_y_clippath',
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
						'crafto_subtitle_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();


			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_title_entrance_animation',
				[
					'label' => esc_html__( 'Entrance Animation', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_entrance_animation',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
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
				'crafto_subtitle_entrance_animation',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
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
				'crafto_content_entrance_animation',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography-content',
						],
					],
				],
			);

			$this->add_control(
				'crafto_content_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_page_title_style' => [
							'big-typography-content',
						],
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_content_ent_settings_ease',
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
						'crafto_content_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_content_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_settings_start_delay',
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
						'crafto_content_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_duration',
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
						'crafto_content_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_stagger',
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
						'crafto_content_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_x',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_y',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_xx',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_xy',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_yx',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_yy',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_zx',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_translate_zy',
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
						'crafto_content_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_x_opacity',
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
						'crafto_content_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_y_opacity',
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
						'crafto_content_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotation_xx',
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
						'crafto_content_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotation_xy',
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
						'crafto_content_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotation_yx',
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
						'crafto_content_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotation_yy',
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
						'crafto_content_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotation_zx',
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
						'crafto_content_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_rotation_zy',
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
						'crafto_content_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_perspective_x',
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
						'crafto_content_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_perspective_y',
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
						'crafto_content_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_content_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_content_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_content_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_scale_x',
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
						'crafto_content_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_content_ent_anim_opt_scale_y',
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
						'crafto_content_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->add_control(
				'crafto_breadcrumb_entrance_animation',
				[
					'label'     => esc_html__( 'Breadcrumb', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);			

			$this->add_control(
				'crafto_breadcrumb_ent_settings',
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
				'crafto_breadcrumb_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_breadcrumb_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_breadcrumb_ent_settings_ease',
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
						'crafto_breadcrumb_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_breadcrumb_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_settings_start_delay',
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
						'crafto_breadcrumb_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_duration',
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
						'crafto_breadcrumb_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_stagger',
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
						'crafto_breadcrumb_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_breadcrumb_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_x',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_y',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_xx',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_xy',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_yx',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_yy',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_zx',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_translate_zy',
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
						'crafto_breadcrumb_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_breadcrumb_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_x_opacity',
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
						'crafto_breadcrumb_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_y_opacity',
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
						'crafto_breadcrumb_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_breadcrumb_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotation_xx',
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
						'crafto_breadcrumb_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotation_xy',
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
						'crafto_breadcrumb_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotation_yx',
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
						'crafto_breadcrumb_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotation_yy',
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
						'crafto_breadcrumb_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotation_zx',
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
						'crafto_breadcrumb_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_rotation_zy',
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
						'crafto_breadcrumb_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_breadcrumb_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_perspective_x',
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
						'crafto_breadcrumb_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_perspective_y',
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
						'crafto_breadcrumb_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_breadcrumb_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_breadcrumb_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_scale_x',
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
						'crafto_breadcrumb_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_breadcrumb_ent_anim_opt_scale_y',
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
						'crafto_breadcrumb_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->add_control(
				'crafto_scrolltodown_entrance_animation',
				[
					'label'     => esc_html__( 'Scroll Button', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-image',
							'gallery-background',
							'big-typography-content',
						],
					],
				]
			);

			$this->add_control(
				'crafto_scrolltodown_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'   => [
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-image',
							'gallery-background',
							'big-typography-content',
						],
					],
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_scrolltodown_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_scrolltodown_ent_settings_ease',
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
						'crafto_scrolltodown_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_scrolltodown_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_settings_start_delay',
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
						'crafto_scrolltodown_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_duration',
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
						'crafto_scrolltodown_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_stagger',
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
						'crafto_scrolltodown_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_scrolltodown_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_x',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_y',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_xx',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_xy',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_yx',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_yy',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_zx',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_translate_zy',
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
						'crafto_scrolltodown_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_scrolltodown_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_x_opacity',
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
						'crafto_scrolltodown_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_y_opacity',
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
						'crafto_scrolltodown_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_scrolltodown_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotation_xx',
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
						'crafto_scrolltodown_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotation_xy',
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
						'crafto_scrolltodown_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotation_yx',
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
						'crafto_scrolltodown_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotation_yy',
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
						'crafto_scrolltodown_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotation_zx',
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
						'crafto_scrolltodown_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_rotation_zy',
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
						'crafto_scrolltodown_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_scrolltodown_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_perspective_x',
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
						'crafto_scrolltodown_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_perspective_y',
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
						'crafto_scrolltodown_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_scrolltodown_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_scrolltodown_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_scale_x',
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
						'crafto_scrolltodown_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_scrolltodown_ent_anim_opt_scale_y',
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
						'crafto_scrolltodown_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_content_alignment',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
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
					'selectors' => [
						'{{WRAPPER}} .title-inner-content' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_page_title_style' => [
							'center-alignment',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_text_alignment',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => '',
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
					'selectors' => [
						'{{WRAPPER}} .big-typography .crafto-main-title' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_alignment',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
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
					'selectors' => [
						'{{WRAPPER}} .title-inner-content' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
						'{{WRAPPER}} .big-typography .title-inner-content .crafto-main-subtitle' => 'justify-content: {{VALUE}};',
					],
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-image',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_page_title_wrapper_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .main-title-inner',
				]
			);
			$this->add_responsive_control(
				'crafto_page_title_wrapper_padding',
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
						'{{WRAPPER}} .main-title-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_title_wrapper_margin',
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
						'{{WRAPPER}} .main-title-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_page_title_wrapper_box_shadow',
					'selector' => '{{WRAPPER}} .main-title-inner',
				]
			);
			$this->add_control(
				'crafto_title_container_separator_heading',
				[
					'label'     => esc_html__( 'Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_title_container_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 2200,
						],
					],
					'default'    => [
						'size' => 1250,
					],
					'selectors'  => [
						'{{WRAPPER}} .title-container' => 'max-width: {{SIZE}}px',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_background_overlay_style_section',
				[
					'label'     => esc_html__( 'Background Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_page_title_enable_bg_image' => 'yes',
						'crafto_page_title_style!' => 'big-typography-image',
					],
				]
			);
			$this->add_control(
				'crafto_background_overlay',
				[
					'label'        => esc_html__( 'Enable Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_title_overlay_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'default'   => '#DF1B1B',
					'selector'  => '{{WRAPPER}} .background-overlay',
					'condition' => [
						'crafto_background_overlay' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_title_overlay_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 0.5,
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .background-overlay' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_background_overlay' => 'yes',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_title_style_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'title_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-main-title',
					'condition' => [
						'crafto_page_title_style' => 'big-typography',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_type',
				[
					'label'     => esc_html__( 'Title Type', 'crafto-addons' ),
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
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-content',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_content_blocks_number_title_color',
					'selector'       => '{{WRAPPER}} .crafto-main-title',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_page_title_type'  => 'stroke',
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-content',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_page_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-main-title',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_page_title_color',
					'selector'       => '{{WRAPPER}} .crafto-main-title',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_page_title_type!' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_page_title_text_shadow',
					'selector' => '{{WRAPPER}} .crafto-main-title',
				]
			);
			$this->add_control(
				'crafto_page_title_opacity',
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
						'{{WRAPPER}} .crafto-main-title' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_title_width',
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
							'min' => 18,
							'max' => 200,
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
						'{{WRAPPER}} .crafto-main-title' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'titlte_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-main-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_page_title_style' => 'big-typography',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_page_title_border',
					'selector'  => '{{WRAPPER}} .crafto-main-title',
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_title_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-main-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'range'      => [
						'em' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'condition'  => [
						'crafto_page_title_style' => [
							'center-alignment',
							'big-typography',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_title_spacing',
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
							'min' => 10,
							'max' => 50,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-main-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_page_icon_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_page_title_style' => [
							'big-typography',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .title-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .title-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_icon_size',
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
							'max' => 100,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .title-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .title-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_icon_spacing',
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
						'{{WRAPPER}} .title-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'.rtl {{WRAPPER}} .title-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_page_subtitle_style_section',
				[
					'label'     => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_page_subtitle_enable' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'subtitle_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-main-subtitle',
					'condition' => [
						'crafto_page_title_style' => 'big-typography',
					],
				]
			);
			$this->add_control(
				'crafto_page_subtitle_type',
				[
					'label'     => esc_html__( 'Title Type', 'crafto-addons' ),
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
						'crafto_page_title_style!' => [
							'left-alignment',
							'right-alignment',
							'center-alignment',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_page_title_subtitle_stroke_color',
					'selector'       => '{{WRAPPER}} .crafto-main-subtitle',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_page_subtitle_type' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_page_subtitle_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-main-subtitle',
				]
			);

			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_page_subtitle_color',
					'selector'       => '{{WRAPPER}} .crafto-main-subtitle',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_page_subtitle_type!' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_page_subtitle_text_shadow',
					'selector' => '{{WRAPPER}} .crafto-main-subtitle',
				]
			);
			$this->add_control(
				'crafto_page_subtitle_opacity',
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
						'{{WRAPPER}} .crafto-main-subtitle' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_subtitle_width',
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
							'min' => 18,
							'max' => 200,
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
						'{{WRAPPER}} .crafto-main-subtitle' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_subtitle_margin_bottom',
				[
					'label'       => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 150,
							'min' => 0,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .crafto-main-subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'   => [
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-image',
							'parallax-background',
							'gallery-background',
							'background-video',
							'big-typography-content',
						],
					],
				]
			);
			$this->add_responsive_control(
				'subtitlte_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-main-subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_page_title_style' => 'big-typography',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_subtitle_spacing',
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
						'{{WRAPPER}} .crafto-main-subtitle, .rtl {{WRAPPER}} .crafto-main-title-wrap .crafto-main-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_page_title_style' => 'center-alignment',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_subtitle_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-main-subtitle, .rtl {{WRAPPER}} .crafto-main-title-wrap .crafto-main-subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'range'      => [
						'em' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'condition'  => [
						'crafto_page_title_style' => [
							'big-typography',
							'center-alignment',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_title_separator_style',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_separator'        => 'yes',
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-content',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_separator_style',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_page_title_style' => [
							'left-alignment',
							'right-alignment',
							'center-alignment',
						],
					],
				]
			);
			$this->add_control(
				'crafto_page_subtitle_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-main-subtitle:before' => 'border-left-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_page_title_style' => [
							'left-alignment',
							'right-alignment',
							'center-alignment',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_separator_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
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
					'condition'      => [
						'crafto_separator'        => 'yes',
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-content',
						],
					],
					'selector'       => '{{WRAPPER}} .separator',
				]
			);
			$this->add_responsive_control(
				'crafto_separator_width',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ 'px', 'custom' ],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 50,
							'step' => 1,
						],
					],
					'condition'  => [
						'crafto_separator'        => 'yes',
						'crafto_page_title_style' => [
							'big-typography',
							'big-typography-content',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .separator' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_page_content_style_section',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_page_content_enable' => 'yes',
						'crafto_page_title_style'    => [
							'big-typography-content',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_page_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-main-content',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_page_content_color',
					'selector'       => '{{WRAPPER}} .crafto-main-content',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_content_width',
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
							'min' => 18,
							'max' => 200,
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
						'{{WRAPPER}} .crafto-main-content' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_content_padding',
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
						'{{WRAPPER}} .page-title-small-content'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_content_style',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_page_content_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .page-title-small-content .separator' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_page_content_separator_width',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .page-title-small-content .separator' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_breadcrumb_style_section',
				[
					'label'     => esc_html__( 'Breadcrumb', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_page_title_breadcrumb' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_page_breadcrumb_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .main-title-breadcrumb li, {{WRAPPER}} .main-title-breadcrumb li a',
				]
			);
			$this->start_controls_tabs(
				'crafto_page_breadcrumb_tabs'
			);
			$this->start_controls_tab(
				'crafto_page_breadcrumb_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_page_breadcrumb_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-title-breadcrumb li, {{WRAPPER}} .main-title-breadcrumb li a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_page_breadcrumb_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_page_breadcrumb_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-title-breadcrumb li a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_page_breadcrumb_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .main-breadcrumb-section',
					'fields_options' => [
						'background' => [
							'separator' => 'before',
						],
					],
					'condition'      => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_page_breadcrumb_border',
					'default'   => '1px',
					'selector'  => '{{WRAPPER}} .main-breadcrumb-section',
					'condition' => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_page_breadcrumb_box_shadow',
					'selector'  => '{{WRAPPER}} .main-breadcrumb-section',
					'condition' => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);
			$this->add_control(
				'crafto_page_breadcrumb_separator_heading',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_page_breadcrumb_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .main-title-breadcrumb > li:after' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_page_breadcrumb_padding',
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
						'{{WRAPPER}} .main-breadcrumb-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_page_breadcrumb_margin',
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
						'{{WRAPPER}} .main-breadcrumb-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_page_breadcrumb_position' => 'after-title-area',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_page_scroll_to_down_style_section',
				[
					'label'     => esc_html__( 'Scroll Button', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_page_title_scroll_to_down' => 'yes',
						'crafto_page_title_style'          => [
							'big-typography',
							'big-typography-image',
							'gallery-background',
							'background-video',
							'big-typography-content',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_scroll_down_shape_size',
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
							'max' => 100,
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
			$this->add_control(
				'crafto_scroll_down_icon_size',
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
							'max' => 40,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_scroll_down_bottom',
				[
					'label'      => esc_html__( 'Bottom', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => -100,
							'max' => 100,
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
						'{{WRAPPER}} .down-section' => 'bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_scroll_to_down_position' => 'content-area',
					],
				]
			);
			$this->add_control(
				'crafto_page_title_scroll_button_style',
				[
					'label'     => esc_html__( 'Icon Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->start_controls_tabs(
				'crafto_icon_style_tabs',
			);
			$this->start_controls_tab(
				'crafto_icon_style_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_primary_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon i, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-default .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg, {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_secondary_color',
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
				'crafto_scroll_down_icon_border_color',
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
				'crafto_scroll_down_border_width',
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
				'crafto_scroll_down_border_radius',
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
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_hover_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover i, {{WRAPPER}}.elementor-view-stacked .elementor-icon:hover i, {{WRAPPER}}.elementor-view-default .elementor-icon:hover i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon:hover svg, {{WRAPPER}}.elementor-view-default .elementor-icon:hover svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_hover_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => 'stacked',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon:hover'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_scroll_down_icon_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon:hover'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_scroll_down_separator',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_scroll_down_box_shadow',
					'selector' => '{{WRAPPER}} .crafto-main-title-wrap .down-section .down-section-link, {{WRAPPER}} .crafto-main-title-wrap + .down-section a',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render page title widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			if ( is_singular( 'attachment' ) ) {
				return;
			}

			global $post;

			$settings = $this->get_settings_for_display();

			$crafto_page_title_enable = $this->get_settings( 'crafto_page_enable_title_heading' );
			$crafto_subtitle_enable   = $this->get_settings( 'crafto_page_subtitle_enable' );
			$crafto_separator         = ( isset( $settings['crafto_separator'] ) && $settings['crafto_separator'] ) ? $settings['crafto_separator'] : '';
			$crafto_content_separator = ( isset( $settings['crafto_content_separator'] ) && $settings['crafto_content_separator'] ) ? $settings['crafto_content_separator'] : '';

			if ( '' === $crafto_page_title_enable && '' === $crafto_subtitle_enable ) {
				return;
			}

			$crafto_page_title               = '';
			$crafto_page_subtitle            = '';
			$crafto_page_content             = '';
			$crafto_title_bg_image_url       = '';
			$crafto_title_bg_multiple_image  = '';
			$crafto_single_post_meta_output  = '';
			$crafto_page_title_video_mp4     = '';
			$crafto_page_title_video_ogg     = '';
			$crafto_page_title_video_webm    = '';
			$crafto_page_title_video_youtube = '';
			$crafto_breadcrumb_attribute     = '';
			$crafto_breadcrumb_class         = '';
			$crafto_title_class              = '';
			$crafto_subtitle_class           = '';
			$crafto_content_class            = '';
			$crafto_content_enable           = $this->get_settings( 'crafto_page_content_enable' );
			$crafto_icon_enable              = $this->get_settings( 'crafto_page_icon_enable' );
			$crafto_page_title_style         = $this->get_settings( 'crafto_page_title_style' );
			$crafto_default_title            = $this->get_settings( 'crafto_page_title_text' );
			$crafto_default_subtitle         = $this->get_settings( 'crafto_page_subtitle' );
			$crafto_default_content          = $this->get_settings( 'crafto_page_content' );
			$crafto_enable_breadcrumb        = $this->get_settings( 'crafto_page_title_breadcrumb' );
			$crafto_breadcrumb_position      = $this->get_settings( 'crafto_page_breadcrumb_position' );
			$crafto_enable_category          = $this->get_settings( 'crafto_page_title_meta_category' );
			$crafto_enable_author            = $this->get_settings( 'crafto_page_title_meta_author' );
			$crafto_author_text              = $this->get_settings( 'crafto_page_title_meta_author_text' );
			$crafto_enable_date              = $this->get_settings( 'crafto_page_title_meta_date' );
			$crafto_date_format              = $this->get_settings( 'crafto_page_title_meta_date_format' );
			$crafto_enable_title_image       = $this->get_settings( 'crafto_page_title_enable_bg_image' );
			$crafto_image_gallery_data       = $this->get_settings( 'crafto_image_gallery_data' );
			$crafto_image_gallery_ids        = wp_list_pluck( $crafto_image_gallery_data, 'id' );
			$crafto_page_title_video_type    = $this->get_settings( 'crafto_page_title_video_type' );
			$crafto_default_video_mp4        = $this->get_settings( 'crafto_page_title_video_mp4' );
			$crafto_default_video_ogg        = $this->get_settings( 'crafto_page_title_video_ogg' );
			$crafto_default_video_webm       = $this->get_settings( 'crafto_page_title_video_webm' );
			$crafto_default_video_youtube    = $this->get_settings( 'crafto_page_title_video_youtube' );
			$crafto_page_title_video_loop    = $this->get_settings( 'crafto_page_title_video_loop' );
			$crafto_page_title_video_muted   = $this->get_settings( 'crafto_page_title_video_muted' );
			$crafto_default_parallax         = $settings['crafto_page_title_parallax'];
			$crafto_default_parallax         = ( isset( $crafto_default_parallax['size'] ) & ! empty( $crafto_default_parallax['size'] ) ) ? $crafto_default_parallax['size'] : '';
			$is_new                          = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$migrated1                       = isset( $settings['__fa4_migrated']['crafto_page_icon'] );

			if ( is_woocommerce_activated() && ( is_product_category() || is_product_tag() || is_tax( 'product_brand' ) || is_shop() ) ) {
				$crafto_page_title           = woocommerce_page_title( false );
				$crafto_title_class          = 'crafto-product-archive-title';
				$crafto_subtitle_class       = 'crafto-product-archive-subtitle';
				$crafto_content_class        = 'crafto-product-archive-content';
				$crafto_breadcrumb_class     = 'crafto-product-archive-breadcrumb';
				$crafto_breadcrumb_attribute = '';
				$crafto_page_subtitle        = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_subtitle', '' );
				$crafto_page_content         = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_content', '' );
				// Background / Gallery image.
				$crafto_title_bg_image          = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_bg_image', '' );
				$crafto_title_bg_multiple_image = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_bg_multiple_image', '' );
				// END Background / Gallery image.
				// For background video style.
				$crafto_page_title_video_mp4     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_video_mp4', '' );
				$crafto_page_title_video_ogg     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_video_ogg', '' );
				$crafto_page_title_video_webm    = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_video_webm', '' );
				$crafto_page_title_video_youtube = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_product_archive_title_video_youtube', '' );
				// END background video style.

			} elseif ( is_woocommerce_activated() && is_product() ) {
				$crafto_title_class          = 'crafto-single-product-title';
				$crafto_subtitle_class       = 'crafto-single-product-subtitle';
				$crafto_content_class        = 'crafto-single-product-content';
				$crafto_breadcrumb_class     = 'crafto-single-product-breadcrumb';
				$crafto_breadcrumb_attribute = '';
				$crafto_page_title           = get_the_title();
				$crafto_page_subtitle        = crafto_post_meta( 'crafto_single_product_title_subtitle' );
				$crafto_page_content         = crafto_post_meta( 'crafto_single_product_title_content' );
				// Background / Gallery image.
				$crafto_title_bg_image          = crafto_post_meta( 'crafto_single_product_title_bg_image' );
				$crafto_title_bg_multiple_image = crafto_post_meta( 'crafto_single_product_title_bg_multiple_image' );
				// END Background / Gallery image
				// For background video style.
				$crafto_page_title_video_mp4     = crafto_post_meta( 'crafto_single_product_title_video_mp4' );
				$crafto_page_title_video_ogg     = crafto_post_meta( 'crafto_single_product_title_video_ogg' );
				$crafto_page_title_video_webm    = crafto_post_meta( 'crafto_single_product_title_video_webm' );
				$crafto_page_title_video_youtube = crafto_post_meta( 'crafto_single_product_title_video_youtube' );
				// END background video style.
			} elseif ( is_tax( 'course_category' ) || is_tax( 'course_tag' ) || is_post_type_archive( 'lp_course' ) ) { // if lp course archive.
				if ( is_tax( 'course_category' ) || is_tax( 'course_tag' ) ) {
					$crafto_lp_course_archive_title = sprintf( '%s', single_tag_title( '', false ) );
				} elseif ( empty( $crafto_default_title ) ) {

						/**
						 * Filter to modify course archive page title.
						 *
						 * @since 1.0
						 */
						$crafto_lp_course_archive_title = apply_filters( 'crafto_course_archive_page_title', esc_html__( 'Courses', 'crafto-addons' ) );
				} else {
						$crafto_lp_course_archive_title = $crafto_default_title;
				}

				$crafto_page_title           = $crafto_lp_course_archive_title;
				$crafto_title_class          = 'crafto-course-archive-title';
				$crafto_subtitle_class       = 'crafto-course-archive-subtitle';
				$crafto_content_class        = 'crafto-course-archive-content';
				$crafto_breadcrumb_class     = 'crafto-course-archive-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';

			} elseif ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) ) { // if Portfolio archive.
				if ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) ) {
					$crafto_portfolio_archive_title = sprintf( '%s', single_tag_title( '', false ) );
				} elseif ( empty( $crafto_default_title ) ) {

						/**
						 * Filter to modify portfolio archive page title.
						 *
						 * @since 1.0
						 */
						$crafto_portfolio_archive_title = apply_filters( 'crafto_portfolio_archive_page_title', esc_html__( 'Portfolios', 'crafto-addons' ) );
				} else {
						$crafto_portfolio_archive_title = $crafto_default_title;
				}

				$crafto_page_title           = $crafto_portfolio_archive_title;
				$crafto_title_class          = 'crafto-portfolio-archive-title';
				$crafto_subtitle_class       = 'crafto-portfolio-archive-subtitle';
				$crafto_content_class        = 'crafto-portfolio-archive-content';
				$crafto_breadcrumb_class     = 'crafto-portfolio-archive-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';
				$crafto_page_subtitle        = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_subtitle', '' );
				$crafto_page_content         = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_content', '' );
				// Background / Gallery image.
				$crafto_title_bg_image          = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_bg_image', '' );
				$crafto_title_bg_multiple_image = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_bg_multiple_image', '' );
				// END Background / Gallery image
				// For background video style.
				$crafto_page_title_video_mp4     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_video_mp4', '' );
				$crafto_page_title_video_ogg     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_video_ogg', '' );
				$crafto_page_title_video_webm    = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_video_webm', '' );
				$crafto_page_title_video_youtube = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_portfolio_archive_title_video_youtube', '' );
				// END background video style.

			} elseif ( is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) ) { // if Property archive.
				if ( is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) ) {
					$crafto_properties_archive_title = sprintf( '%s', single_tag_title( '', false ) );
				} elseif ( empty( $crafto_default_title ) ) {

						/**
						 * Filter to modify property archive page title.
						 *
						 * @since 1.0
						 */
						$crafto_properties_archive_title = apply_filters( 'crafto_property_archive_page_title', esc_html__( 'Properties', 'crafto-addons' ) );
				} else {
						$crafto_properties_archive_title = $crafto_default_title;
				}

				$crafto_page_title           = $crafto_properties_archive_title;
				$crafto_title_class          = 'crafto-default-title';
				$crafto_subtitle_class       = 'crafto-default-subtitle';
				$crafto_content_class        = 'crafto-default-content';
				$crafto_breadcrumb_class     = ' crafto-default-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';
				$crafto_page_subtitle        = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_properties_archive_title_subtitle', '' );
				// Background / Gallery image.
				$crafto_title_bg_image          = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_properties_archive_title_bg_image', '' );
				$crafto_title_bg_multiple_image = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_properties_archive_title_bg_multiple_image', '' );
				// END Background / Gallery image.
				// For background video style.
				$crafto_page_title_video_mp4     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_properties_archive_title_video_mp4', '' );
				$crafto_page_title_video_ogg     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_properties_archive_title_video_ogg', '' );
				$crafto_page_title_video_webm    = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_properties_archive_title_video_webm', '' );
				$crafto_page_title_video_youtube = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_properties_archive_title_video_youtube', '' );
				// END background video style.

			} elseif ( is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) { // if Tour archive.
				if ( is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) ) {
					$crafto_tours_archive_title = sprintf( '%s', single_tag_title( '', false ) );
				} elseif ( empty( $crafto_default_title ) ) {

						/**
						 * Filter to modify tour archive page title.
						 *
						 * @since 1.0
						 */
						$crafto_tours_archive_title = apply_filters( 'crafto_tours_archive_page_title', esc_html__( 'Tours', 'crafto-addons' ) );
				} else {
						$crafto_tours_archive_title = $crafto_default_title;
				}

				$crafto_page_title           = $crafto_tours_archive_title;
				$crafto_title_class          = 'crafto-default-title';
				$crafto_subtitle_class       = 'crafto-default-subtitle';
				$crafto_content_class        = 'crafto-default-content';
				$crafto_breadcrumb_class     = ' crafto-default-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';
				$crafto_page_subtitle        = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_tour_archive_title_subtitle', '' );
				// Background / Gallery image.
				$crafto_title_bg_image          = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_tour_archive_title_bg_image', '' );
				$crafto_title_bg_multiple_image = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_tour_archive_title_bg_multiple_image', '' );
				// END Background / Gallery image.
				// For background video style.
				$crafto_page_title_video_mp4     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_tour_archive_title_video_mp4', '' );
				$crafto_page_title_video_ogg     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_tour_archive_title_video_ogg', '' );
				$crafto_page_title_video_webm    = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_tour_archive_title_video_webm', '' );
				$crafto_page_title_video_youtube = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_tour_archive_title_video_youtube', '' );
				// END background video style.

			} elseif ( is_search() || is_category() || is_tag() || is_archive() ) { // if Post category, tag, archive page.
				if ( is_tag() ) {
					$crafto_archive_title = sprintf( '%s', single_tag_title( '', false ) );
				} elseif ( is_author() ) {
					$crafto_archive_title = sprintf( '%s', get_the_author() );
				} elseif ( is_category() ) {
					$crafto_archive_title = sprintf( '%s', single_tag_title( '', false ) );
				} elseif ( is_year() ) {
					$crafto_archive_title = sprintf( '%s', get_the_date( _x( 'Y', 'yearly archives date format', 'crafto-addons' ) ) );
				} elseif ( is_month() ) {
					$crafto_archive_title = sprintf( '%s', get_the_date( _x( 'F Y', 'monthly archives date format', 'crafto-addons' ) ) );
				} elseif ( is_day() ) {
					$crafto_archive_title = sprintf( '%s', get_the_date( _x( 'd', 'daily archives date format', 'crafto-addons' ) ) );
				} elseif ( is_search() ) {

					if ( empty( $crafto_default_title ) ) {

						/**
						 * Filter to modify search result page title.
						 *
						 * @since 1.0
						 */
						$crafto_archive_title = apply_filters( 'crafto_search_result_page_title', esc_html__( 'Search results for&nbsp;', 'crafto-addons' ) );
						$crafto_archive_title = $crafto_archive_title . '"' . get_search_query() . '"';
					} else {
						$crafto_archive_title = $crafto_default_title;
					}
				} elseif ( is_archive() ) {
					if ( empty( $crafto_default_title ) ) {

						/**
						 * Filter to modify archive page title.
						 *
						 * @since 1.0
						 */
						$crafto_archive_title = apply_filters( 'crafto_archive_page_title', esc_html__( 'Archives', 'crafto-addons' ) );
					} else {
						$crafto_archive_title = $crafto_default_title;
					}
				} else {
					$crafto_archive_title = get_the_title();
				}

				$crafto_page_title           = $crafto_archive_title;
				$crafto_title_class          = 'crafto-archive-title';
				$crafto_subtitle_class       = 'crafto-archive-subtitle';
				$crafto_content_class        = 'crafto-archive-content';
				$crafto_breadcrumb_class     = 'crafto-archive-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';
				$crafto_page_subtitle        = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_subtitle', '' );
				$crafto_page_content         = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_content', '' );
				// Background / Gallery image.
				$crafto_title_bg_image          = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_bg_image', '' );
				$crafto_title_bg_multiple_image = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_bg_multiple_image', '' );
				// END Background / Gallery image
				// For background video style.
				$crafto_page_title_video_mp4     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_video_mp4', '' );
				$crafto_page_title_video_ogg     = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_video_ogg', '' );
				$crafto_page_title_video_webm    = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_video_webm', '' );
				$crafto_page_title_video_youtube = \Crafto_Addons_Extra_Functions::crafto_taxonomy_title_option( 'crafto_archive_title_video_youtube', '' );
				// END background video style.
			} elseif ( is_home() ) { // if Home page.
				$crafto_title_class          = 'crafto-default-title';
				$crafto_subtitle_class       = 'crafto-default-subtitle';
				$crafto_content_class        = 'crafto-default-content';
				$crafto_breadcrumb_class     = ' crafto-default-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';

				if ( empty( $crafto_default_title ) ) {

					/**
					 * Filter to modify home archive page title.
					 *
					 * @since 1.0
					 */
					$crafto_page_title = apply_filters( 'crafto_home_archive_page_title', esc_html__( 'Blog', 'crafto-addons' ) );
				} else {
					$crafto_page_title = $crafto_default_title;
				}
			} elseif ( 'portfolio' === get_post_type() && is_singular( 'portfolio' ) ) { // if single portfolio.
				$crafto_author_url           = '';
				$crafto_author               = '';
				$crafto_title_class          = 'crafto-single-portfolio-title';
				$crafto_subtitle_class       = 'crafto-single-portfolio-subtitle';
				$crafto_content_class        = 'crafto-single-portfolio-content';
				$crafto_breadcrumb_class     = 'crafto-single-portfolio-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';

				if ( is_object( $post ) && $post ) {
					$crafto_author_url = get_author_posts_url( $post->post_author );
					$crafto_author     = get_the_author_meta( 'display_name', $post->post_author );
				}

				// Post meta output.
				if ( ! crafto_is_editor_mode() ) { // phpcs:ignore
					if ( 'yes' === $crafto_enable_date ) {
						$crafto_post_meta_array[] = '<li>' . esc_html( get_the_date( $crafto_date_format ) ) . '</li>';
					}
					if ( 'yes' === $crafto_enable_author && $crafto_author ) {
						$crafto_post_meta_array[] = '<li><span>' . esc_html( $crafto_author_text ) . ' <a href="' . esc_url( $crafto_author_url ) . '"> ' . esc_html( $crafto_author ) . '</a></span></li>';
					}
					if ( 'yes' === $crafto_enable_category ) {
						ob_start();
							crafto_single_post_meta_category( get_the_ID() );
							$crafto_post_meta_array[] = ob_get_contents();
						ob_end_clean();
					}
					if ( ! empty( $crafto_post_meta_array ) ) {
						$crafto_single_post_meta_output .= '<ul class="crafto-post-details-meta alt-font">';
						$crafto_single_post_meta_output .= implode( '', $crafto_post_meta_array ); // phpcs:ignore
						$crafto_single_post_meta_output .= '</ul>';
					}
				}
				// END Post meta output.

				$crafto_page_title    = get_the_title();
				$crafto_page_subtitle = crafto_post_meta( 'crafto_single_portfolio_title_subtitle' );
				$crafto_page_content  = crafto_post_meta( 'crafto_single_portfolio_title_content' );
				// Background / Gallery image.
				$crafto_title_bg_image          = crafto_post_meta( 'crafto_single_portfolio_title_bg_image' );
				$crafto_title_bg_multiple_image = crafto_post_meta( 'crafto_single_portfolio_title_bg_multiple_image' );
				// END Background / Gallery image
				// For background video style.
				$crafto_page_title_video_mp4     = crafto_post_meta( 'crafto_single_portfolio_title_video_mp4' );
				$crafto_page_title_video_ogg     = crafto_post_meta( 'crafto_single_portfolio_title_video_ogg' );
				$crafto_page_title_video_webm    = crafto_post_meta( 'crafto_single_portfolio_title_video_webm' );
				$crafto_page_title_video_youtube = crafto_post_meta( 'crafto_single_portfolio_title_video_youtube' );
				// END background video style.

			} elseif ( 'properties' === get_post_type() && is_singular( 'properties' ) ) { // if single properties.
				$crafto_author_url           = '';
				$crafto_author               = '';
				$crafto_title_class          = 'crafto-single-property-title';
				$crafto_subtitle_class       = 'crafto-single-property-subtitle';
				$crafto_content_class        = 'crafto-single-property-content';
				$crafto_breadcrumb_class     = 'crafto-single-property-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';

				if ( is_object( $post ) && $post ) {
					$crafto_author_url = get_author_posts_url( $post->post_author );
					$crafto_author     = get_the_author_meta( 'display_name', $post->post_author );
				}

				// Post meta output.
				if ( ! crafto_is_editor_mode() ) { // phpcs:ignore
					if ( 'yes' === $crafto_enable_date ) {
						$crafto_post_meta_array[] = '<li>' . esc_html( get_the_date( $crafto_date_format ) ) . '</li>';
					}
					if ( 'yes' === $crafto_enable_author && $crafto_author ) {
						$crafto_post_meta_array[] = '<li><span>' . esc_html( $crafto_author_text ) . ' <a href="' . esc_url( $crafto_author_url ) . '"> ' . esc_html( $crafto_author ) . '</a></span></li>';
					}
					if ( 'yes' === $crafto_enable_category ) {
						ob_start();
							crafto_single_post_meta_category( get_the_ID() );
							$crafto_post_meta_array[] = ob_get_contents();
						ob_end_clean();
					}
					if ( ! empty( $crafto_post_meta_array ) ) {
						$crafto_single_post_meta_output .= '<ul class="crafto-post-details-meta alt-font">';
						$crafto_single_post_meta_output .= implode( '', $crafto_post_meta_array ); // phpcs:ignore
						$crafto_single_post_meta_output .= '</ul>';
					}
				}
				// END Post meta output.

				$crafto_page_title    = get_the_title();
				$crafto_page_subtitle = crafto_post_meta( 'crafto_single_property_title_subtitle' );
				$crafto_page_content  = crafto_post_meta( 'crafto_single_property_title_content' );
				// Background / Gallery image.
				$crafto_title_bg_image          = crafto_post_meta( 'crafto_single_property_title_bg_image' );
				$crafto_title_bg_multiple_image = crafto_post_meta( 'crafto_single_property_title_bg_multiple_image' );
				// END Background / Gallery image
				// For background video style.
				$crafto_page_title_video_mp4     = crafto_post_meta( 'crafto_single_property_title_video_mp4' );
				$crafto_page_title_video_ogg     = crafto_post_meta( 'crafto_single_property_title_video_ogg' );
				$crafto_page_title_video_webm    = crafto_post_meta( 'crafto_single_property_title_video_webm' );
				$crafto_page_title_video_youtube = crafto_post_meta( 'crafto_single_property_title_video_youtube' );
				// END background video style.
			} elseif ( 'tours' === get_post_type() && is_singular( 'tours' ) ) { // if single tours.
				$crafto_author_url           = '';
				$crafto_author               = '';
				$crafto_title_class          = 'crafto-single-tours-title';
				$crafto_subtitle_class       = 'crafto-single-tours-subtitle';
				$crafto_content_class        = 'crafto-single-tours-content';
				$crafto_breadcrumb_class     = 'crafto-single-tours-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';

				if ( is_object( $post ) && $post ) {
					$crafto_author_url = get_author_posts_url( $post->post_author );
					$crafto_author     = get_the_author_meta( 'display_name', $post->post_author );
				}

				// Post meta output.
				if ( ! crafto_is_editor_mode() ) { // phpcs:ignore
					if ( 'yes' === $crafto_enable_date ) {
						$crafto_post_meta_array[] = '<li>' . esc_html( get_the_date( $crafto_date_format ) ) . '</li>';
					}
					if ( 'yes' === $crafto_enable_author && $crafto_author ) {
						$crafto_post_meta_array[] = '<li><span>' . esc_html( $crafto_author_text ) . ' <a href="' . esc_url( $crafto_author_url ) . '"> ' . esc_html( $crafto_author ) . '</a></span></li>';
					}
					if ( 'yes' === $crafto_enable_category ) {
						ob_start();
							crafto_single_post_meta_category( get_the_ID() );
							$crafto_post_meta_array[] = ob_get_contents();
						ob_end_clean();
					}
					if ( ! empty( $crafto_post_meta_array ) ) {
						$crafto_single_post_meta_output .= '<ul class="crafto-post-details-meta alt-font">';
						$crafto_single_post_meta_output .= implode( '', $crafto_post_meta_array ); // phpcs:ignore
						$crafto_single_post_meta_output .= '</ul>';
					}
				}
				// END Post meta output.

				$crafto_page_title    = get_the_title();
				$crafto_page_subtitle = crafto_post_meta( 'crafto_single_tours_title_subtitle' );
				$crafto_page_content  = crafto_post_meta( 'crafto_single_tours_title_content' );
				// Background / Gallery image.
				$crafto_title_bg_image          = crafto_post_meta( 'crafto_single_tours_title_bg_image' );
				$crafto_title_bg_multiple_image = crafto_post_meta( 'crafto_single_tours_title_bg_multiple_image' );
				// END Background / Gallery image
				// For background video style.
				$crafto_page_title_video_mp4     = crafto_post_meta( 'crafto_single_tours_title_video_mp4' );
				$crafto_page_title_video_ogg     = crafto_post_meta( 'crafto_single_tours_title_video_ogg' );
				$crafto_page_title_video_webm    = crafto_post_meta( 'crafto_single_tours_title_video_webm' );
				$crafto_page_title_video_youtube = crafto_post_meta( 'crafto_single_tours_title_video_youtube' );
				// END background video style.
			} elseif ( 'lp_course' === get_post_type() && is_singular( 'lp_course' ) ) { // if single lp_course.
				$crafto_author_url           = '';
				$crafto_author               = '';
				$crafto_title_class          = 'crafto-single-course-title';
				$crafto_subtitle_class       = 'crafto-single-course-subtitle';
				$crafto_content_class        = 'crafto-single-course-content';
				$crafto_breadcrumb_class     = 'crafto-single-course-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';

				if ( is_object( $post ) && $post ) {
					$crafto_author_url = get_author_posts_url( $post->post_author );
					$crafto_author     = get_the_author_meta( 'display_name', $post->post_author );
				}

				// Post meta output.
				if ( ! crafto_is_editor_mode() ) { // phpcs:ignore
					if ( 'yes' === $crafto_enable_date ) {
						$crafto_post_meta_array[] = '<li>' . esc_html( get_the_date( $crafto_date_format ) ) . '</li>';
					}
					if ( 'yes' === $crafto_enable_author && $crafto_author ) {
						$crafto_post_meta_array[] = '<li><span>' . esc_html( $crafto_author_text ) . ' <a href="' . esc_url( $crafto_author_url ) . '"> ' . esc_html( $crafto_author ) . '</a></span></li>';
					}
					if ( 'yes' === $crafto_enable_category ) {
						ob_start();
							crafto_single_post_meta_category( get_the_ID() );
							$crafto_post_meta_array[] = ob_get_contents();
						ob_end_clean();
					}
					if ( ! empty( $crafto_post_meta_array ) ) {
						$crafto_single_post_meta_output .= '<ul class="crafto-post-details-meta alt-font">';
						$crafto_single_post_meta_output .= implode( '', $crafto_post_meta_array ); // phpcs:ignore
						$crafto_single_post_meta_output .= '</ul>';
					}
				}
				// END Post meta output.

				$crafto_page_title = get_the_title();

			} elseif ( is_single() ) { // if single post.
				$crafto_author_url           = '';
				$crafto_author               = '';
				$crafto_title_class          = 'crafto-single-post-title';
				$crafto_subtitle_class       = 'crafto-single-post-subtitle';
				$crafto_content_class        = 'crafto-single-post-content';
				$crafto_breadcrumb_class     = 'crafto-single-post-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';

				if ( is_object( $post ) && $post ) {
					$crafto_author_url = get_author_posts_url( $post->post_author );
					$crafto_author     = get_the_author_meta( 'display_name', $post->post_author );
				}

				$category_list = crafto_post_category( get_the_ID(), false );

				// Post meta output.
				if ( ! crafto_is_editor_mode() ) { // phpcs:ignore
					if ( 'yes' === $crafto_enable_date ) {
						$crafto_post_meta_array[] = '<li>' . esc_html( get_the_date( $crafto_date_format ) ) . '</li>';
					}
					if ( 'yes' === $crafto_enable_author && $crafto_author ) {
						$crafto_post_meta_array[] = '<li><span>' . esc_html( $crafto_author_text ) . ' <a href="' . esc_url( $crafto_author_url ) . '"> ' . esc_html( $crafto_author ) . '</a></span></li>';
					}
					if ( 'yes' === $crafto_enable_category ) {
						ob_start();
							crafto_single_post_meta_category( get_the_ID() );
							$crafto_post_meta_array[] = ob_get_contents();
						ob_end_clean();
					}
					if ( ! empty( $crafto_post_meta_array ) ) {
						$crafto_single_post_meta_output .= '<ul class="crafto-post-details-meta alt-font">';
						$crafto_single_post_meta_output .= implode( '', $crafto_post_meta_array ); // phpcs:ignore
						$crafto_single_post_meta_output .= '</ul>';
					}
				}

				// END Post meta output.

				$crafto_page_title    = get_the_title();
				$crafto_page_subtitle = crafto_post_meta( 'crafto_single_post_title_subtitle' );
				$crafto_page_content  = crafto_post_meta( 'crafto_single_post_title_content' );
				// Background / Gallery image.
				$crafto_title_bg_image          = crafto_post_meta( 'crafto_single_post_title_bg_image' );
				$crafto_title_bg_multiple_image = crafto_post_meta( 'crafto_single_post_title_bg_multiple_image' );
				// END Background / Gallery image
				// For background video style.
				$crafto_page_title_video_mp4     = crafto_post_meta( 'crafto_single_post_title_video_mp4' );
				$crafto_page_title_video_ogg     = crafto_post_meta( 'crafto_single_post_title_video_ogg' );
				$crafto_page_title_video_webm    = crafto_post_meta( 'crafto_single_post_title_video_webm' );
				$crafto_page_title_video_youtube = crafto_post_meta( 'crafto_single_post_title_video_youtube' );
				// END background video style.

			} else {
				$crafto_title_class          = 'crafto-page-title';
				$crafto_subtitle_class       = 'crafto-page-subtitle';
				$crafto_content_class        = 'crafto-page-content';
				$crafto_breadcrumb_class     = 'crafto-page-breadcrumb';
				$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';
				$crafto_page_title           = get_the_title();
				$crafto_page_subtitle        = crafto_post_meta( 'crafto_page_title_subtitle' );
				$crafto_page_content         = crafto_post_meta( 'crafto_page_title_content' );
				// Background / Gallery image.
				$crafto_title_bg_image          = crafto_post_meta( 'crafto_page_title_bg_image' );
				$crafto_title_bg_multiple_image = crafto_post_meta( 'crafto_page_title_bg_multiple_image' );
				// END Background / Gallery image.
				// For background video style.
				$crafto_page_title_video_mp4     = crafto_post_meta( 'crafto_page_title_video_mp4' );
				$crafto_page_title_video_ogg     = crafto_post_meta( 'crafto_page_title_video_ogg' );
				$crafto_page_title_video_webm    = crafto_post_meta( 'crafto_page_title_video_webm' );
				$crafto_page_title_video_youtube = crafto_post_meta( 'crafto_page_title_video_youtube' );
				// END background video style.
			}

			// Enable Title Bar.
			$crafto_title = '';
			if ( ! empty( $crafto_default_title ) ) {
				$crafto_title = $crafto_default_title;
			} else {
				$crafto_title = $crafto_page_title;
			}

			// Subtitle.
			$crafto_subtitle = '';
			if ( ! empty( $crafto_page_subtitle ) ) {
				$crafto_subtitle = $crafto_page_subtitle;
			} else {
				$crafto_subtitle = $crafto_default_subtitle;
			}
			// END Subtitle.

			// Content.
			$crafto_content = '';
			if ( ! empty( $crafto_page_content ) ) {
				$crafto_content = $crafto_page_content;
			} else {
				$crafto_content = $crafto_default_content;
			}
			// END Content.

			// Background image.
			$crafto_title_bg_image_url = '';
			if ( 'yes' === $crafto_enable_title_image ) {
				if ( ! empty( $crafto_title_bg_image ) ) {
					$crafto_title_bg_image_url = wp_get_attachment_url( $crafto_title_bg_image );
				} else {
					if ( ! empty( $settings['crafto_fallback_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_fallback_image']['id'] ) ) {
						$settings['crafto_fallback_image']['id'] = '';
					}

					if ( ! empty( $settings['crafto_fallback_image']['id'] ) ) {
						$image_array               = wp_get_attachment_image_src( $settings['crafto_fallback_image']['id'], $settings['crafto_thumbnail_size'] );
						$crafto_title_bg_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';
					} elseif ( ! empty( $settings['crafto_fallback_image']['url'] ) ) {
						$image_src = Group_Control_Image_Size::get_attachment_image_src( $settings['crafto_fallback_image']['id'], $settings['crafto_thumbnail_size'], $settings );
						if ( ! $image_src && isset( $settings['crafto_fallback_image']['url'] ) ) {
							$crafto_title_bg_image_url = $settings['crafto_fallback_image']['url'];
						}
					}
				}	
			}
			// END Background image.

			// Image Gallery.
			$crafto_bg_multiple_image = '';
			if ( ! empty( $crafto_title_bg_multiple_image ) ) {
				$crafto_bg_multiple_image = explode( ',', $crafto_title_bg_multiple_image );
			} elseif ( ! empty( $crafto_image_gallery_ids ) ) {
				$crafto_bg_multiple_image = $crafto_image_gallery_ids;
			}
			// END Gallery.

			// Background video.
			$crafto_title_video_mp4     = '';
			$crafto_title_video_ogg     = '';
			$crafto_title_video_webm    = '';
			$crafto_title_video_youtube = '';
			if ( ! empty( $crafto_page_title_video_mp4 ) ) {
				$crafto_title_video_mp4 = $crafto_page_title_video_mp4;
			} else {
				$crafto_title_video_mp4 = $crafto_default_video_mp4;
			}

			if ( ! empty( $crafto_page_title_video_ogg ) ) {
				$crafto_title_video_ogg = $crafto_page_title_video_ogg;
			} else {
				$crafto_title_video_ogg = $crafto_default_video_ogg;
			}

			if ( ! empty( $crafto_page_title_video_webm ) ) {
				$crafto_title_video_webm = $crafto_page_title_video_webm;
			} else {
				$crafto_title_video_webm = $crafto_default_video_webm;
			}

			if ( ! empty( $crafto_page_title_video_youtube ) ) {
				$crafto_title_video_youtube = $crafto_page_title_video_youtube;
			} else {
				$crafto_title_video_youtube = $crafto_default_video_youtube . '?autoplay=1&mute=1&enablejsapi=1';
			}
			// END Background video.

			$this->add_render_attribute(
				'main-title-wrapper',
				[
					'class' => [
						'crafto-main-title-wrap',
						'main-title-inner',
						$crafto_title_class . '-wrap',
						$crafto_page_title_style,
					],
				]
			);

			switch ( $crafto_page_title_style ) {
				case 'left-alignment':
				case 'right-alignment':
				case 'center-alignment':
				case 'big-typography':
				case 'parallax-background':
				case 'big-typography-content':
					$crafto_default_parallax       = ( ! empty( $crafto_default_parallax ) && 'no-parallax' !== $crafto_default_parallax ) ? esc_attr( $crafto_default_parallax ) : '';
					$crafto_default_parallax_class = ! empty( $crafto_default_parallax ) ? 'parallax' : 'cover-background';

					if ( ! empty( $crafto_title_bg_image_url ) ) {
						$this->add_render_attribute(
							'main-title-wrapper',
							[
								'class' => $crafto_default_parallax_class,
								'style' => 'background-image: url(' . esc_url( $crafto_title_bg_image_url ) . ');',
							],
						);
					}

					if ( ! empty( $crafto_title_bg_image_url ) && $crafto_default_parallax ) {
						$this->add_render_attribute(
							'main-title-wrapper',
							[
								'class' => 'has-parallax-background',
								'data-parallax-background-ratio' => $crafto_default_parallax,
							],
						);
					}
					break;
				case 'background-video':
					if ( 'self' === $crafto_page_title_video_type ) {
						$this->add_render_attribute(
							'video',
							[
								'class'    => 'html-video',
								'autoplay' => 'autoplay',
							],
						);
						if ( 'yes' === $crafto_page_title_video_loop ) {
							$this->add_render_attribute(
								'video',
								[
									'loop' => 'loop',
								],
							);
						}
						if ( 'yes' === $crafto_page_title_video_muted ) {
							$this->add_render_attribute(
								'video',
								[
									'muted' => 'muted',
								],
							);
						}
						if ( ! empty( $crafto_title_bg_image_url ) ) {
							$this->add_render_attribute(
								'video',
								[
									'poster' => esc_url( $crafto_title_bg_image_url ),
								],
							);
						}
					}
					break;
			}

			$this->add_render_attribute(
				'main-container',
				[
					'class' => [
						'title-container',
					],
				],
			);

			$this->add_render_attribute(
				'main-row',
				[
					'class' => [
						'title-content-wrap',
					],
				],
			);

			$this->add_render_attribute(
				'title',
				[
					'class' => [
						'crafto-main-title',
						$crafto_title_class,
					],
				],
			);
			if ( crafto_is_editor_mode() && is_single() && 'themebuilder' === get_post_type() ) { // phpcs:ignore
				$crafto_title    = esc_html__( 'Page title goes here', 'crafto-addons' );
				$crafto_subtitle = esc_html__( 'Page subtitle goes here', 'crafto-addons' );
			}

			$crafto_page_title_type = ( isset( $settings['crafto_page_title_type'] ) && ! empty( $settings['crafto_page_title_type'] ) ) ? $settings['crafto_page_title_type'] : '';
			$page_title_anim        = $this->render_anime_animation( $this, 'title' );
			$page_title_fancy_text  = $this->render_fancy_text_animation( $this, 'title' );

			if ( ! empty( $page_title_fancy_text ) ) {
				$page_title_fancy_text_animation = wp_json_encode( $page_title_fancy_text );
				$fancy_text_values['string']     = [ $crafto_title ];
				$data_fancy_text                 = ! empty( $fancy_text_values ) ? wp_json_encode( $fancy_text_values ) : '';
				$title_fancy_text                = wp_json_encode( array_merge( json_decode( $data_fancy_text, true ), json_decode( $page_title_fancy_text_animation, true ) ) );
			}
			if ( ! empty( $page_title_anim ) && '[]' !== $page_title_anim ) {
				$this->add_render_attribute(
					'title',
					[
						'class'      => 'entrance-animation',
						'data-anime' => $page_title_anim,
					],
				);
			}
			if ( ! empty( $title_fancy_text ) ) {
				$this->add_render_attribute(
					'title',
					[
						'class'           => 'fancy-text-rotator',
						'data-fancy-text' => $title_fancy_text,
					],
				);
			}
			if ( 'stroke' === $crafto_page_title_type ) {
				$this->add_render_attribute(
					'title',
					'class',
					[
						'text-stroke',
					]
				);
			}
			$this->add_render_attribute(
				'subtitle',
				[
					'class' => [
						'crafto-main-subtitle',
						$crafto_subtitle_class,
					],
				],
			);

			$this->add_render_attribute(
				'content',
				[
					'class' => [
						'crafto-main-content',
						$crafto_content_class,
					],
				],
			);

			$crafto_page_subtitle_type = ( isset( $settings['crafto_page_subtitle_type'] ) && ! empty( $settings['crafto_page_subtitle_type'] ) ) ? $settings['crafto_page_subtitle_type'] : '';
			$page_subtitle_anim        = $this->render_anime_animation( $this, 'subtitle' );
			$page_breadcrumb_anime     = $this->render_anime_animation( $this, 'breadcrumb' );
			$page_subtitle_fancy_text  = $this->render_fancy_text_animation( $this, 'subtitle' );

			if ( ! empty( $page_subtitle_fancy_text ) ) {
				$page_subtitle_fancy_text_animation   = wp_json_encode( $page_subtitle_fancy_text );
				$fancy_text_subtitle_values['string'] = [ $crafto_subtitle ];
				$subtitle_data_fancy_text             = ! empty( $fancy_text_subtitle_values ) ? wp_json_encode( $fancy_text_subtitle_values ) : '';
				$subtitle_fancy_text                  = wp_json_encode( array_merge( json_decode( $subtitle_data_fancy_text, true ), json_decode( $page_subtitle_fancy_text_animation, true ) ) );
			}

			if ( ! empty( $page_subtitle_anim ) && '[]' !== $page_subtitle_anim ) {
				$this->add_render_attribute(
					'subtitle',
					[
						'class'      => 'entrance-animation',
						'data-anime' => $page_subtitle_anim,
					],
				);
			}

			if ( ! empty( $subtitle_fancy_text ) ) {
				$this->add_render_attribute(
					'subtitle',
					[
						'class'           => 'fancy-text-rotator fancy-text',
						'data-fancy-text' => $subtitle_fancy_text,
					],
				);
			}
			if ( 'stroke' === $crafto_page_subtitle_type ) {
				$this->add_render_attribute(
					'subtitle',
					'class',
					[
						'text-stroke',
					]
				);
			}
			
			$page_title_content_anim = $this->render_anime_animation( $this, 'content' );

			if ( ! empty( $page_title_content_anim ) && '[]' !== $page_title_content_anim ) {
				$this->add_render_attribute(
					'content',
					[
						'class'      => 'entrance-animation',
						'data-anime' => $page_title_content_anim,
					],
				);
			}
			// In title area.
			$this->add_render_attribute(
				'title-breadcrumb',
				[
					'class' => [
						'crafto-main-title-breadcrumb',
						'main-title-breadcrumb',
						$crafto_title_class . '-breadcrumb',
					],
				]
			);
			// In title area.
			if ( ! empty( $page_breadcrumb_anime ) && '[]' !== $page_breadcrumb_anime ) {
				$this->add_render_attribute(
					'title-breadcrumb',
					[
						'class'      => 'entrance-animation',
						'data-anime' => $page_breadcrumb_anime,
					],
				);
			}
			// After title area.
			$this->add_render_attribute(
				'main-breadcrumb',
				[
					'class' => [
						'crafto-main-breadcrumb',
						'main-breadcrumb-section',
						$crafto_breadcrumb_class,
					],
				],
			);

			// After title area.
			if ( ! empty( $page_breadcrumb_anime ) && '[]' !== $page_breadcrumb_anime ) {
				$this->add_render_attribute(
					'main-breadcrumb',
					[
						'class'      => 'entrance-animation',
						'data-anime' => $page_breadcrumb_anime,
					],
				);
			}

			switch ( $crafto_page_title_style ) {
				case 'left-alignment':
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
								'align-items-center',
							],
						],
					);
					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) && ! empty( $crafto_title_bg_image_url ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div class="col-xl-8 col-lg-6 text-center text-lg-start">
									<?php
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
											<?php echo esc_html( $crafto_title ); ?>
										</<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>>
										<?php
									}
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>><?php echo esc_html( $crafto_subtitle ); ?></span>
										<?php
									}
									?>
								</div>
								<div class="col-xl-4 col-lg-6 text-center d-flex text-lg-end justify-content-center justify-content-lg-end breadcrumb-wrapper">
									<?php
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
										</ul>
										<?php
									}
									if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
										?>
										<div class="crafto-single-post-meta vertical-align-middle">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<?php
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'right-alignment':
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
								'align-items-center',
								'justify-content-center',
							],
						],
					);
					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) && ! empty( $crafto_title_bg_image_url ) ) {
							?><div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div class="col-xl-4 col-lg-6 text-center d-flex text-lg-start justify-content-center justify-content-lg-start breadcrumb-wrapper">
									<?php
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
										</ul>
										<?php
									}
									if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
										?>
										<div class="crafto-single-post-meta vertical-align-middle">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?>
								</div>
								<div class="col-xl-8 col-lg-6 text-center text-lg-end">
									<?php
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
											echo esc_html( $crafto_title );
										?></<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>>
										<?php
									}
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>><?php echo esc_html( $crafto_subtitle ); ?></span>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<?php
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'center-alignment':
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
								'align-items-center',
								'justify-content-center',
							],
						],
					);
					$this->add_render_attribute(
						'title-content-box',
						[
							'class' => [
								'col-12',
							],
						],
					);

					$this->add_render_attribute(
						'title-content-box',
						[
							'class' => [
								'title-inner-content',
							],
						],
					);
					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) && ! empty( $crafto_title_bg_image_url ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div <?php $this->print_render_attribute_string( 'title-content-box' ); ?>>
									<?php
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
											echo esc_html( $crafto_title );
										?></<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore?>>
										<?php
									}
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>><?php echo esc_html( $crafto_subtitle ); ?></span>
										<?php
									}
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
										</ul>
										<?php
									}
									if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
										?>
										<div class="crafto-single-post-meta vertical-align-middle">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<?php
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'big-typography':
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
								'align-items-stretch',
								'small-screen',
							],
						],
					);

					$this->add_render_attribute(
						'title-content-box',
						[
							'class' => [
								'col-12',
								'd-flex',
								'flex-column',
								'justify-content-center',
								'title-inner-content',
							],
						],
					);

					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) && ! empty( $crafto_title_bg_image_url ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div <?php $this->print_render_attribute_string( 'title-content-box' ); ?>>
									<?php
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>>
											<?php
											if ( 'yes' === $crafto_separator ) {
												?>
												<span class="separator"></span>
												<?php
											}

											if ( 'yes' === $crafto_icon_enable ) {
												?>
												<span class="title-icon">
													<?php
													if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_page_icon']['value'] ) ) {
														if ( $is_new || $migrated1 ) {
															Icons_Manager::render_icon( $settings['crafto_page_icon'], [ 'aria-hidden' => 'true' ] );
														} elseif ( isset( $settings['crafto_page_icon']['value'] ) && ! empty( $settings['crafto_page_icon']['value'] ) ) {
															?>
															<i class="<?php echo esc_attr( $settings['crafto_page_icon']['value'] ); ?>" aria-hidden="true"></i>
																<?php
														}
													}
													?>
												</span>
												<?php
											}

											if ( ! empty( $page_subtitle_anim ) ) {
												?>
												<span class="page-subtitle-anime"><?php echo esc_html( $crafto_subtitle ); ?></span>
												<?php
											} else {
												echo esc_html( $crafto_subtitle );
											}
											?>
										</span>
										<?php
									}
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
											echo esc_html( $crafto_title );
										?></<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
										<?php
									}
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore  ?>
										</ul>
										<?php
									}
									if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
										?>
										<div class="crafto-single-post-meta vertical-align-middle">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
							<?php
							$this->page_title_scroll_to_down();
							?>
						</div>
					</div>
					<?php
					$this->page_title_after_content_scroll_to_down();
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'big-typography-content':
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
								'align-items-start',
								'align-items-lg-end',
								'justify-content-end',
								'flex-column',
								'flex-lg-row',
							],
						],
					);
					$this->add_render_attribute(
						'title-content-box',
						[
							'class' => [
								'col-xl-6 col-lg-7',
							],
						],
					);
					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) && ! empty( $crafto_title_bg_image_url ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div <?php $this->print_render_attribute_string( 'title-content-box' ); ?>>
									<?php
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>>
											<?php
											if ( 'yes' === $crafto_separator ) {
												?>
												<span class="separator"></span>
												<?php
											}
											echo esc_html( $crafto_subtitle ); ?>
										</span>
										<?php
									}
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
											echo esc_html( $crafto_title );
										?></<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
										<?php
									}
									?>
								</div>
								<div class="col-lg-5 offset-xl-1 page-title-small-content">
									<?php
									if ( 'yes' === $crafto_content_enable && $crafto_content ) {
										?>
										<?php
										if ( 'yes' === $crafto_content_separator ) {
											?>
											<span class="separator"></span>
											<?php
										}
										?>
										<div <?php $this->print_render_attribute_string( 'content' ); ?>>
										<?php echo esc_html( $crafto_content ); ?>
										</div>
										<?php
									}
									?>
								</div>
								<?php
								if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
									?>
									<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
										<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
									</ul>
									<?php
								}
								if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
									?>
									<div class="crafto-single-post-meta vertical-align-middle">
										<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
							</div>
							<?php $this->page_title_scroll_to_down(); ?>
						</div>
					</div>
					<?php
					$this->page_title_after_content_scroll_to_down();
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'big-typography-image':
					if ( ! empty( $crafto_title_bg_image_url ) ) {
						$this->add_render_attribute(
							'image',
							[
								'class' => 'cover-background',
								'style' => 'background-image: url(' . esc_url( $crafto_title_bg_image_url ) . ');',
							],
						);
					}
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
							],
						],
					);
					$this->add_render_attribute(
						'title-content-box',
						[
							'class' => [
								'col-md-6',
								'd-flex',
								'flex-column',
								'justify-content-center',
								'title-inner-content',
							],
						],
					);

					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) && ! empty( $crafto_title_bg_image_url ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
							<div <?php $this->print_render_attribute_string( 'title-content-box' ); ?>>
									<?php
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>>
											<?php
											if ( 'yes' === $crafto_separator ) {
												?>
												<span class="separator"></span>
												<?php
											}
											echo esc_html( $crafto_subtitle ); ?>
										</span>
										<?php
									}
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
											echo esc_html( $crafto_title );
										?></<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
										<?php
									}
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore  ?>
										</ul>
										<?php
									}
									?>
								</div>
								<?php
								if ( ! empty( $crafto_title_bg_image_url ) ) {
									?>
									<div class="col-md-6 page-title-image">
										<div <?php $this->print_render_attribute_string( 'image' ); ?>></div>
									</div>
									<?php
								}
								if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
									?>
									<div class="crafto-single-post-meta vertical-align-middle">
										<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
							</div>
							<?php $this->page_title_scroll_to_down(); ?>
						</div>
					</div>
					<?php
					$this->page_title_after_content_scroll_to_down();
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'parallax-background':
					$this->add_render_attribute(
						'main-row',
						[
							'class' =>
							[
								'row',
								'align-items-stretch',
								'justify-content-center',
								'small-screen',
							],
						],
					);

					if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
						$this->add_render_attribute(
							'main-row',
							[
								'class' =>
								[
									'breadcrumb-in-title-area',
								],
							],
						);
					}
					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) && ! empty( $crafto_title_bg_image_url ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div class="col-12 text-center d-flex align-items-center justify-content-center flex-column">
									<div class="parallax-content-wrap">
										<?php
										if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
											?>
											<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>><?php echo esc_html( $crafto_subtitle ); ?></span>
											<?php
										}
										if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
											?>
											<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
												echo esc_html( $crafto_title );
											?></<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>>
											<?php
										}
										?>
									</div>
									<?php
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
										</ul>
										<?php
									}
									if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
										?>
										<div class="crafto-single-post-meta vertical-align-middle">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<?php
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'gallery-background':
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
								'align-items-center',
								'justify-content-center',
								'one-third-screen',
							],
						],
					);
					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div class="col-12 col-xl-6 col-lg-7 col-md-10  d-flex flex-column justify-content-center align-items-center text-center">
									<?php
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>><?php echo esc_html( $crafto_subtitle ); ?></span>
										<?php
									}
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
											echo esc_html( $crafto_title );
										?></<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>>
										<?php
									}
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
										</ul>
										<?php
									}
									if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
										?>
										<div class="crafto-single-post-meta vertical-align-middle">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?>
								</div>
								<?php $this->page_title_scroll_to_down(); ?>
							</div>
						</div>
						<?php
						if ( is_array( $crafto_bg_multiple_image ) && ! empty( $crafto_bg_multiple_image ) ) {
							?>
							<div class="swiper page-title-slider">
								<div class="swiper-wrapper">
									<?php
									foreach ( $crafto_bg_multiple_image as $id ) {
										$crafto_image_url = wp_get_attachment_image_url( $id, $settings['crafto_thumbnail_size'] );
										$crafto_bg_url    = ( $crafto_image_url ) ? ' style="background-image:url(' . esc_url( $crafto_image_url ) . ');"' : '';
										if ( $crafto_bg_url ) {
											?>
											<div class="swiper-slide cover-background"<?php echo sprintf( '%s', $crafto_bg_url ); // phpcs:ignore ?>></div>
											<?php
										}
									}
									?>
								</div>
							</div>
							<?php
						} else {
							$crafto_default_bg_url = ' style="background-image:url(' . esc_url( Utils::get_placeholder_image_src() ) . ');"';
							?>
							<div class="swiper page-title-slider">
								<div class="swiper-wrapper">
									<div class="swiper-slide cover-background"<?php echo sprintf( '%s', $crafto_default_bg_url ); // phpcs:ignore ?>></div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					$this->page_title_after_content_scroll_to_down();
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
				case 'background-video':
					$this->add_render_attribute(
						'main-title-wrapper',
						[
							'class' => [
								'one-third-screen',
							],
						],
					);
					$this->add_render_attribute(
						'main-row',
						[
							'class' => [
								'row',
								'align-items-center',
								'justify-content-center',
								'one-third-screen',
							],
						],
					);
					?>
					<div <?php $this->print_render_attribute_string( 'main-title-wrapper' ); ?>>
						<?php
						if ( 'yes' === $this->get_settings( 'crafto_background_overlay' ) ) {
							?>
							<div class="background-overlay"></div>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
							<div <?php $this->print_render_attribute_string( 'main-row' ); ?>>
								<div class="col-12 col-xl-6 col-lg-7 col-md-10  d-flex flex-column text-center">
									<?php
									if ( 'yes' === $crafto_subtitle_enable && $crafto_subtitle ) {
										?>
										<span <?php $this->print_render_attribute_string( 'subtitle' ); ?>><?php echo esc_html( $crafto_subtitle ); ?></span>
										<?php
									}
									if ( 'yes' === $crafto_page_title_enable && $crafto_title ) {
										?>
										<<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'title' ); ?>><?php
											echo esc_html( $crafto_title );
										?></<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>>
										<?php
									}
									if ( 'yes' === $crafto_enable_breadcrumb && 'title-area' === $crafto_breadcrumb_position ) {
										?>
										<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
											<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
										</ul>
										<?php
									}
									if ( ! empty( $crafto_single_post_meta_output ) && 'after-title-area' === $crafto_breadcrumb_position ) {
										?>
										<div class="crafto-single-post-meta vertical-align-middle">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?> 
								</div>
								<?php $this->page_title_scroll_to_down(); ?>
							</div>
						</div>
						<?php
						if ( 'self' === $crafto_page_title_video_type && ( $crafto_title_video_mp4 || $crafto_title_video_ogg || $crafto_title_video_webm ) ) {
							?>
							<video <?php $this->print_render_attribute_string( 'video' ); ?> playsinline>
								<?php
								if ( $crafto_title_video_mp4 ) {
									?>
									<source type="video/mp4" src="<?php echo esc_url( $crafto_title_video_mp4 ); ?>" />
									<?php
								}
								if ( $crafto_title_video_ogg ) {
									?>
									<source type="video/ogg" src="<?php echo esc_url( $crafto_title_video_ogg ); ?>" />
									<?php
								}
								if ( $crafto_title_video_webm ) {
									?>
									<source type="video/webm" src="<?php echo esc_url( $crafto_title_video_webm ); ?>" />
									<?php
								}
								?>
							</video>
							<?php
						} elseif ( 'external' === $crafto_page_title_video_type && ( $crafto_title_video_youtube ) ) {
							?>
							<div class="external-fit-videos fit-videos width-100">
								<iframe width="540" height="315" src="<?php echo esc_url( $crafto_title_video_youtube ); ?>"></iframe>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					$this->page_title_after_content_scroll_to_down();
					if ( 'yes' === $crafto_enable_breadcrumb && 'after-title-area' === $crafto_breadcrumb_position ) {
						$this->crafto_page_title_breadcrumb();
					}
					break;
			}
		}

		/**
		 * Post Comments.
		 *
		 * @return void
		 */
		public function crafto_page_title_breadcrumb() {
			$crafto_breadcrumb_attribute = ' itemscope="" itemtype="http://schema.org/BreadcrumbList"';
			?>
			<div <?php $this->print_render_attribute_string( 'main-breadcrumb' ); ?><?php echo sprintf( '%s', $crafto_breadcrumb_attribute ); ?>><?php // phpcs:ignore ?>
				<div <?php $this->print_render_attribute_string( 'main-container' ); ?>>
					<div class="row m-0">
						<div class="col-12">
							<ul <?php $this->print_render_attribute_string( 'title-breadcrumb' ); ?>><?php // phpcs:ignore ?>
								<?php echo crafto_breadcrumb_display(); // phpcs:ignore ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		/**
		 * Page title scroll Button.
		 *
		 * @return void
		 */
		public function page_title_scroll_to_down() {
			if ( is_woocommerce_activated() && is_product() ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_product_title_callto_section_id' );
			} elseif ( 'portfolio' === get_post_type() && is_singular( 'portfolio' ) ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_portfolio_title_callto_section_id' );
			} elseif ( 'properties' === get_post_type() && is_singular( 'properties' ) ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_property_title_callto_section_id' );
			} elseif ( is_single() ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_post_title_callto_section_id' );
			} else {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_page_title_callto_section_id' );
			}
			$settings                       = $this->get_settings_for_display();
			$migrated                       = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_scroll_to_down          = $this->get_settings( 'crafto_page_title_scroll_to_down' );
			$crafto_scroll_to_section_id    = $this->get_settings( 'crafto_page_title_scroll_to_section_id' );
			$crafto_scroll_to_down_position = $this->get_settings( 'crafto_scroll_to_down_position' );
			$scroll_to_down_anime           = $this->render_anime_animation( $this, 'scrolltodown' );

			if ( ! empty( $scroll_to_down_anime ) && '[]' !== $scroll_to_down_anime ) {
				$this->add_render_attribute(
					'scroll-to-down',
					[
						'class'      => [
							'entrance-animation',
							'down-section',
							'text-center',
						],
						'data-anime' => $scroll_to_down_anime,
					],
				);
			} else {
				$this->add_render_attribute(
					'scroll-to-down',
					[
						'class' => [
							'down-section',
							'text-center',
						],
					],
				);
			}
			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
				$crafto_icon = ob_get_clean();
			} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				$crafto_icon = '<i class="' . esc_attr( $settings['crafto_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
			// scroll to next section id.
			$crafto_title_callto_section_id = '';
			if ( ! empty( $crafto_page_title_callto_section_id ) ) {
				$crafto_title_callto_section_id = $crafto_page_title_callto_section_id;
			} elseif ( ! empty( $crafto_scroll_to_section_id ) ) {
				$crafto_title_callto_section_id = $crafto_scroll_to_section_id;
			}
			if ( 'yes' === $crafto_scroll_to_down ) {
				if ( 'content-area' === $crafto_scroll_to_down_position ) {
					?>
					<div <?php $this->print_render_attribute_string( 'scroll-to-down' ); ?>>
						<a href="#<?php echo $crafto_title_callto_section_id; // phpcs:ignore ?>" class="section-link down-section-link elementor-icon" aria-label="down-section">
							<?php
							if ( ! empty( $crafto_icon ) ) {
								echo sprintf( '%s', $crafto_icon ); // phpcs:ignore
							}
							?>
						</a>
					</div>
					<?php
				}
			}
		}
		/**
		 * Page title after content scroll Button.
		 *
		 * @return void
		 */
		public function page_title_after_content_scroll_to_down() {
			if ( is_woocommerce_activated() && is_product() ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_product_title_callto_section_id' );
			} elseif ( 'portfolio' === get_post_type() && is_singular( 'portfolio' ) ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_portfolio_title_callto_section_id' );
			} elseif ( 'properties' === get_post_type() && is_singular( 'properties' ) ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_property_title_callto_section_id' );
			} elseif ( is_single() ) {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_single_post_title_callto_section_id' );
			} else {
				$crafto_page_title_callto_section_id = crafto_post_meta( 'crafto_page_title_callto_section_id' );
			}
			$settings                       = $this->get_settings_for_display();
			$migrated                       = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_scroll_to_down          = $this->get_settings( 'crafto_page_title_scroll_to_down' );
			$crafto_scroll_to_section_id    = $this->get_settings( 'crafto_page_title_scroll_to_section_id' );
			$crafto_scroll_to_down_position = $this->get_settings( 'crafto_scroll_to_down_position' );

			$this->add_render_attribute(
				'scroll-to-down',
				[
					'class' => [
						'down-section',
						'text-center',
					],
				],
			);

			$crafto_icon = '';
			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
				$crafto_icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				ob_start();
				?>
				<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
				<?php
				$crafto_icon .= ob_get_clean();
			}
			// scroll to next section id.
			$crafto_title_callto_section_id = '';
			if ( ! empty( $crafto_page_title_callto_section_id ) ) {
				$crafto_title_callto_section_id = $crafto_page_title_callto_section_id;
			} elseif ( ! empty( $crafto_scroll_to_section_id ) ) {
				$crafto_title_callto_section_id = $crafto_scroll_to_section_id;
			}
			if ( 'yes' === $crafto_scroll_to_down ) {
				if ( 'after-content-area' === $crafto_scroll_to_down_position ) {
					?>
					<div <?php $this->print_render_attribute_string( 'scroll-to-down' ); ?>>
						<a href="#<?php echo $crafto_title_callto_section_id; // phpcs:ignore ?>" class="section-link down-section-link elementor-icon" aria-label="down-section">
							<?php
							if ( ! empty( $crafto_icon ) ) {
								echo sprintf( '%s', $crafto_icon ); // phpcs:ignore
							} else {
								?>
								<i class="ti-arrow-down"></i>
								<?php
							}
							?>
						</a>
					</div>
					<?php
				}
			}
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
