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
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use CraftoAddons\Controls\Groups\Button_Group_Control;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for fancy text box.
 *
 * @package Crafto
 */

// If class `Fancy_Text_Box` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Fancy_Text_Box' ) ) {
	/**
	 * Define `Fancy_Text_Box` class.
	 */
	class Fancy_Text_Box extends Widget_Base {
		/**
		 * Retrieve the list of scripts the crafto fancy text box depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @since 1.3.0
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-fancy-text-box-widget'	];
			}
		}

		/**
		 * Retrieve the list of styles the crafto fancy text box depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @since 1.3.0
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$fancy_box_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$fancy_box_styles[] = 'crafto-widgets-rtl';
				} else {
					$fancy_box_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$fancy_box_styles[] = 'crafto-fancy-text-box-rtl-widget';
				}
				$fancy_box_styles[] = 'crafto-fancy-text-box-widget';
			}
			return $fancy_box_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve crafto fancy text box widget name.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-fancy-text-box';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve crafto fancy text box widget title.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Fancy Text Box', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve crafto fancy text box widget icon.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-image-box crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/fancy-text-box/';
		}
		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the crafto fancy text box widget belongs to.
		 *
		 * @since 2.0.0
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
		 * @since 2.1.0
		 * @access public
		 *
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'content',
				'info',
				'animated text',
				'text effect',
				'styled text',
			];
		}

		/**
		 * Get button sizes.
		 *
		 * Retrieve an array of button sizes for the  fancy text box widget.
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
		 * Register crafto fancy text box widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_fancy_text_box_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_styles',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'fancy-text-box-style-1',
					'options' => [
						'fancy-text-box-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'fancy-text-box-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'fancy-text-box-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'fancy-text-box-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'fancy-text-box-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
						'fancy-text-box-style-6' => esc_html__( 'Style 6', 'crafto-addons' ),
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_box_image_section',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
				]
			);
			$this->add_control(
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
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'exclude'   => [
						'custom',
					],
					'separator' => 'none',
					'condition' => [
						'crafto_image[url]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_image_fetch_priority',
				[
					'label'   => esc_html__( 'Fetch Priority', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' => esc_html__( 'Default', 'crafto-addons' ),
						'high' => esc_html__( 'High', 'crafto-addons' ),
						'low'  => esc_html__( 'Low', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_image_lazy_loading',
				[
					'label'   => esc_html__( 'Lazy Loading', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'no',
					'options' => [
						'no'  => esc_html__( 'Default', 'crafto-addons' ),
						'yes' => esc_html__( 'Yes', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_image_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_image[url]!'           => '',
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-6',
							'fancy-text-box-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_box_overlay_section',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-3',
							'fancy-text-box-style-4',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_overlay',
				[
					'label'        => esc_html__( 'Enable Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_lable_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Label', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_label_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_fancy_text_box_label!' => '',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_title_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write Title Here', 'crafto-addons' ),
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
					'default' => 'span',
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_secondary_title',
				[
					'label'       => esc_html__( 'Hover Box Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Add title', 'crafto-addons' ),
					'condition'   => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_html_size',
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
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_title_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_fancy_text_box_title!'  => '',
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-5',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_hover_box_link',
				[
					'label'       => esc_html__( 'Hover Box Title Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_fancy_text_box_secondary_title!' => '',
						'crafto_fancy_text_box_styles' => 'fancy-text-box-style-5',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_content_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_content',
				[
					'label'      => esc_html__( 'Content', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => true,
					'default'    => esc_html__( 'Lorem ipsum is simply dummy..', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_content_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_CONTENT,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-6',
						],
					],
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_list_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'List Title', 'crafto-addons' ),
					'label_block' => true,
				]
			);

			$repeater->add_control(
				'crafto_list_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}}',
					],
				]
			);

			$repeater->add_control(
				'crafto_bg_list_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'list',
				[
					'label'       => esc_html__( 'Label Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_list_title' => esc_html__( 'Label', 'crafto-addons' ),
						],
						[
							'crafto_list_title' => esc_html__( 'Label', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_list_title }}}',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_box_icon_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-3',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'icon-feather-arrow-right',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'condition'        => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-5',
						],
					],
				],
			);
			$this->add_control(
				'crafto_icon_view',
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
						'crafto_fancy_text_box_icon[value]!' => '',
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-4',
							'fancy-text-box-style-5',
						],
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
					'prefix_class' => 'elementor-shape-',
					'condition'    => [
						'crafto_fancy_text_box_icon[value]!' => '',
						'crafto_icon_view!'             => 'default',
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-4',
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_fancy_text_box_icon[value]!' => '',
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-1',
							'fancy-text-box-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_icons',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fa-solid fa-star',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'condition'        => [
						'crafto_fancy_text_box_image'  => '',
						'crafto_fancy_text_box_styles' => 'fancy-text-box-style-5',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_images',
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
						'crafto_fancy_text_box_image'  => 'yes',
						'crafto_fancy_text_box_styles' => 'fancy-text-box-style-5',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_box_price_title_section',
				[
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_price_number_title',
				[
					'label'       => esc_html__( 'Price', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( '$255', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_price_title',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Per month', 'crafto-addons' ),
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_button_icon_section',
				[
					'label'     => esc_html__( 'Button Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_button_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'icon-feather-arrow-right',
						'library' => 'feather',
					],
					'skin'             => 'inline',
				],
			);
			$this->add_control(
				'crafto_button_icon_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => '#',
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_button_section',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => 'Click here',
					'placeholder' => esc_html__( 'Click here', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_link',
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
				'crafto_fancy_text_button_size',
				[
					'label'          => esc_html__( 'Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'xs',
					'options'        => self::get_button_sizes(),
					'style_transfer' => true,
				]
			);
			$this->add_control(
				'crafto_fancy_text_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'label_block'      => false,
					'type'             => Controls_Manager::ICONS,
					'recommended'      => [
						'fa-solid' => [
							'angle-left',
							'angle-right',
							'long-arrow-alt-left',
							'long-arrow-alt-right',
						],
					],
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'icon-feather-arrow-right',
						'library' => 'feather',
					],
					'skin'             => 'inline',
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_icon_align',
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
						'crafto_fancy_text_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_button_icon_indent',
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
						'crafto_fancy_text_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 15,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_fancy_text_selected_icon[value]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_css_id',
				[
					'label'       => esc_html__( 'Button ID', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'title'       => esc_html__( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'crafto-addons' ),
					'description' => esc_html__( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'crafto-addons' ),
					'separator'   => 'before',
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_hover_animation',
				[
					'label' => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);

			$this->end_controls_section();

			Button_Group_Control::button_content_fields(
				$this,
				[
					'type'    => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => esc_html__( 'Click here', 'crafto-addons' ),
					'repeat'  => 'no',
				],
				[
					'condition' => [
						'crafto_fancy_text_box_styles' => 'fancy-text-box-style-1',
					],
				],
			);

			$this->start_controls_section(
				'crafto_fancy_text_box_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_text_aligment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => '',
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
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .fancy-text-box-wrapper' => 'text-align: {{VALUE}};',
						'{{WRAPPER}} .elementor-icon' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-4',
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_general_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .fancy-text-box-wrapper' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-1',
							'fancy-text-box-style-3',
							'fancy-text-box-style-4',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_fancy_text_box_general_shadow',
					'selector'  => '{{WRAPPER}} .fancy-text-box-wrapper',
					'condition' => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_fancy_general_border',
					'selector'  => '{{WRAPPER}} .fancy-text-box-wrapper',
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-1',
							'fancy-text-box-style-2',
							'fancy-text-box-style-3',
							'fancy-text-box-style-4',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_general_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .fancy-text-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_content_box_padding',
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
						'{{WRAPPER}} .fancy-text-box-style-1 .fancy-text-box, {{WRAPPER}} .fancy-text-box-style-2 .fancy-text-border, {{WRAPPER}} .fancy-text-box-style-3 .fancy-text-border, {{WRAPPER}} .fancy-text-box-style-5 figcaption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-4',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_style_content_box',
				[
					'label'     => esc_html__( 'Content Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-4',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_general_content_box_padding',
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
						'{{WRAPPER}} .content-box, {{WRAPPER}} .fancy-text-box-style-6 .fancy-text-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-4',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_tex_border_color_hover_heading',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_border_color_hover',
				[
					'label'     => esc_html__( 'Separator Hover Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .fancy-text-box-style-2:hover .fancy-text-border, {{WRAPPER}} .fancy-text-box-style-3:hover .fancy-text-border' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_image_box',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_fancy_image_box_shadow',
					'selector' => '{{WRAPPER}} .box-image',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_fancy_image_box_border',
					'selector'  => '{{WRAPPER}} .box-image',
					'condition' => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_image_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .box-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_image_box_overlay',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_fancy_text_box_overlay' => 'yes',
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-3',
							'fancy-text-box-style-4',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_fancy_text_image_box_overlay_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .fancy-text-box-wrapper:hover .box-overlay, {{WRAPPER}} .fancy-text-box-style-1 .box-image .box-overlay, {{WRAPPER}} .fancy-text-box-style-2 .box-overlay',
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_image_box_icon_opacity',
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
						'{{WRAPPER}} .fancy-text-box-wrapper:hover .box-overlay' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_box_overlay_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .fancy-text-box-wrapper:hover .box-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_image_overlay',
				[
					'label'     => esc_html__( 'Image Overlay', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_image_overlay_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .fancy-text-box-style-5 .box-image .image-overlay',
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_image_overlay_opacity',
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
						'{{WRAPPER}} .fancy-text-box-style-5 .box-image .image-overlay' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-1!',
							'fancy-text-box-style-2!',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_title_style_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_fancy_text_box_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .fancy-text-box .title, {{WRAPPER}} .fancy-text-box-style-5 figcaption .title',
				]
			);
			$this->start_controls_tabs(
				'crafto_fancy_text_box_title_tabs'
			);
			$this->start_controls_tab(
				'crafto_fancy_text_box_title_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles!' => 'fancy-text-box-style-5',
						'crafto_title_link[url]!'       => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .fancy-text-box .title, {{WRAPPER}} .fancy-text-box-style-5 figcaption .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_fancy_text_box_title_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles!' => 'fancy-text-box-style-5',
						'crafto_title_link[url]!'       => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_title_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .fancy-text-box a.title-link .title:hover, {{WRAPPER}} .fancy-text-box-content a.title-link .title:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_styles!' => 'fancy-text-box-style-5',
						'crafto_title_link[url]!'       => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_color_hover',
				[
					'label'     => esc_html__( 'Box Hover Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}}:hover .fancy-text-box-style-2 .fancy-text-box .title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_fancy_text_title_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_fancy_text_box_styles!' => 'fancy-text-box-style-5',
						'crafto_title_link[url]!'       => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_title_width',
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
						'{{WRAPPER}} .fancy-text-box .title' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_title_margin',
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
						'{{WRAPPER}} .fancy-text-box .title, {{WRAPPER}} .fancy-text-box-style-5 figcaption .title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_secondary_title_section',
				[
					'label'     => esc_html__( 'Hover Box Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_secondary_title_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .fancy-text-box-style-5 figcaption .secondary-title',
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_secondary_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .fancy-text-box-style-5 figcaption .secondary-title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_label_style_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_fancy_text_box_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .box-image .category-label',
				]
			);
			$this->start_controls_tabs( 'crafto_fancy_text_box_label_tabs' );
			$this->start_controls_tab(
				'crafto_fancy_text_box_label_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_label_link[url]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_label_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' =>
					[
						'{{WRAPPER}} .box-image .category-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_fancy_text_label_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .box-image .category-label',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_fancy_text_box_label_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_label_link[url]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_label_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .box-image .category-label:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_label_link[url]!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_fancy_text_label_hover_background_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} a.label-link:hover .category-label, {{WRAPPER}} .category-label:hover',
					'condition' => [
						'crafto_label_link[url]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_label_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .category-label:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_label_link[url]!' => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_fancy_text_label_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_label_link[url]!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_fancy_text_box_label_border',
					'selector' => '{{WRAPPER}} .category-label',
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_label_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .category-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_label_padding',
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
						'{{WRAPPER}} .box-image .category-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_label_margin',
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
						'{{WRAPPER}} .box-image .category-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_content_style_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_fancy_text_box_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .fancy-text-box .content, {{WRAPPER}} .fancy-text-box-style-5 .content',
				]
			);
			$this->start_controls_tabs(
				'crafto_fancy_text_content_style',
			);
			$this->start_controls_tab(
				'crafto_fancy_text_content_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .fancy-text-box .content, {{WRAPPER}} .fancy-text-box-style-5 .content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_fancy_text_content_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_content_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .fancy-text-box-style-2 .fancy-text-box .content, {{WRAPPER}}:hover .fancy-text-box-style-3 .fancy-text-box .content' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_content_opacity',
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
						'{{WRAPPER}}:hover .fancy-text-box-style-2 .fancy-text-box .content, {{WRAPPER}}:hover .fancy-text-box-style-3 .fancy-text-box .content' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_fancy_text_content_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_content_width',
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
							'min'  => 15,
							'max'  => 500,
							'step' => 1,
						],
						'%'  => [
							'min' => 15,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
					],
					'selectors'  => [
						'{{WRAPPER}} .fancy-text-box .content, {{WRAPPER}} .fancy-text-box-style-5 .content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_content_margin',
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
						'{{WRAPPER}}  .fancy-text-box .content, {{WRAPPER}} .fancy-text-box-style-5 .content' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_icon_section_style',
				[
					'label'      => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-1',
									],
									[
										'name'     => 'crafto_fancy_text_box_icon[value]',
										'operator' => '!==',
										'value'    => '',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-2',
									],
									[
										'name'     => 'crafto_fancy_text_box_icon[value]',
										'operator' => '!==',
										'value'    => '',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-4',
									],
									[
										'name'     => 'crafto_fancy_text_box_icon[value]',
										'operator' => '!==',
										'value'    => '',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-5',
									],
									[
										'name'     => 'crafto_fancy_text_box_icons[value]',
										'operator' => '!==',
										'value'    => '',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .fancy-icon i, {{WRAPPER}} .elementor-icon a i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-icon svg, {{WRAPPER}} .fancy-icon svg, {{WRAPPER}} .elementor-icon a svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_fancy_text_box_image!' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_icons_bg_color',
				[
					'label'      => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'       => Controls_Manager::COLOR,
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'background-color: {{VALUE}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-4',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_icon_view',
										'operator' => '===',
										'value'    => 'stacked',
									],
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-1',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_icon_border_color',
				[
					'label'      => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'       => Controls_Manager::COLOR,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_icon_view',
										'operator' => '===',
										'value'    => 'framed',
									],
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-1',
									],
								],
							],
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_icon_border_width',
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
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_icon_view',
										'operator' => '===',
										'value'    => 'framed',
									],
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-1',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_icon_border_radius',
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
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-4',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_icon_view',
										'operator' => '!==',
										'value'    => 'default',
									],
									[
										'name'     => 'crafto_fancy_text_box_styles',
										'operator' => '===',
										'value'    => 'fancy-text-box-style-1',
									],
								],
							],
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon, {{WRAPPER}} .fancy-text-box-style-4 .fancy-text-border .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_icon_width',
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
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_image_width',
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
						'{{WRAPPER}} .content-box-wrapper img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_image'  => 'yes',
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_icon_padding',
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
						'{{WRAPPER}} .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles!' => [
							'fancy-text-box-style-4',
							'fancy-text-box-style-5',
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_spacing',
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
						'{{WRAPPER}} .fancy-text-box-style-5 figcaption .content-box-wrapper .elementor-icon, {{WRAPPER}} .fancy-text-box-style-5 figcaption .content-box-wrapper img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_box_title_price_style_section',
				[
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_fancy_text_box_title_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .fancy-text-box .price-number',
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_title_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' =>
					[
						'{{WRAPPER}} .fancy-text-box .price-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_title_price_padding',
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
						'{{WRAPPER}} .fancy-text-box-style-4 .fancy-text-border' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_title_price_margin',
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
						'{{WRAPPER}} .fancy-text-box .price-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_style_price',
				[
					'label'     => esc_html__( 'Lable', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_fancy_text_box_title_price_lable_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .fancy-text-box .price-title',
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_title_price_lable_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' =>
					[
						'{{WRAPPER}} .fancy-text-box .price-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_box_title_price_lable_margin',
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
						'{{WRAPPER}} .fancy-text-box .price-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_style_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_fancy_text_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .fancy-text-label span',
				]
			);
			$this->add_control(
				'crafto_fancy_text_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .fancy-text-label span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_padding',
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
						'{{WRAPPER}} .fancy-text-label span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_fancy_text_button_icon_section_style',
				[
					'label'     => esc_html__( 'Button Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_fancy_text_box_button_icon[value]!' => '',
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_button_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_fancy_text_button_iconbox_shadow',
					'selector' => '{{WRAPPER}} .button-icon',
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .button-icon, {{WRAPPER}} .fancy-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .button-icon, {{WRAPPER}} .fancy-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_icons_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .button-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_fancy_text_box_button_section_style',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_fancy_text_box_styles' => [
							'fancy-text-box-style-2',
							'fancy-text-box-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_fancy_text_box_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .elementor-button-text',
				]
			);
			$this->start_controls_tabs(
				'crafto_fancy_text_box_button_style',
			);
			$this->start_controls_tab(
				'crafto_fancy_text_button_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_fancy_text_box_button_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_button_icon_color',
					'selector'       => '{{WRAPPER}} .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-round .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-icon-circle .elementor-button-icon i, {{WRAPPER}} .elementor-button-icon svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_fancy_text_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_fancy_text_button_hover_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}}:hover .elementor-button-content-wrapper' => 'color: {{VALUE}};',
						'{{WRAPPER}}:focus .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_button_hover_icon_color',
					'selector'       => '{{WRAPPER}}:hover a.elementor-button i, {{WRAPPER}}:focus a.elementor-button:focus, {{WRAPPER}}:hover .elementor-button .elementor-button-content-wrapper svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_fancy_text_primary_button_padding',
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
						'{{WRAPPER}} .crafto_primary_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_primary_button_margin',
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
						'{{WRAPPER}} .crafto_primary_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_fancy_text_primary_button_display',
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
						'{{WRAPPER}} a.crafto_primary_button' => 'display: {{VALUE}}',
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
						'crafto_fancy_text_box_styles' => 'fancy-text-box-style-1',
					],
				],
			);
		}

		/**
		 * Render fancy text box widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings               = $this->get_settings_for_display();
			$fancy_text_box_styles  = ( isset( $settings['crafto_fancy_text_box_styles'] ) && $settings['crafto_fancy_text_box_styles'] ) ? $settings['crafto_fancy_text_box_styles'] : 'fancy-text-box-style-1';
			$fancy_text_box_title   = ( isset( $settings['crafto_fancy_text_box_title'] ) && $settings['crafto_fancy_text_box_title'] ) ? $settings['crafto_fancy_text_box_title'] : '';
			$fancy_text_box_label   = ( isset( $settings['crafto_fancy_text_box_label'] ) && $settings['crafto_fancy_text_box_label'] ) ? $settings['crafto_fancy_text_box_label'] : '';
			$fancy_text_box_content = ( isset( $settings['crafto_fancy_text_box_content'] ) && $settings['crafto_fancy_text_box_content'] ) ? $settings['crafto_fancy_text_box_content'] : '';
			$fancy_image_link       = ( isset( $settings['crafto_image_link']['url'] ) && $settings['crafto_image_link']['url'] ) ? $settings['crafto_image_link']['url'] : '';
			$fancy_label_link       = ( isset( $settings['crafto_label_link']['url'] ) && $settings['crafto_label_link']['url'] ) ? $settings['crafto_label_link']['url'] : '';
			$fancy_icon_link        = ( isset( $settings['crafto_icon_link']['url'] ) && $settings['crafto_icon_link']['url'] ) ? $settings['crafto_icon_link']['url'] : '';
			$fancy_image_overlay    = ( isset( $settings['crafto_fancy_text_box_overlay'] ) && $settings['crafto_fancy_text_box_overlay'] ) ? $settings['crafto_fancy_text_box_overlay'] : '';
			$fetch_priority         = isset( $settings['crafto_image_fetch_priority'] ) && ! empty( $settings['crafto_image_fetch_priority'] ) ? $settings['crafto_image_fetch_priority'] : 'none';
			$crafto_lazy_loading    = isset( $settings['crafto_image_lazy_loading'] ) && ! empty( $settings['crafto_image_lazy_loading'] ) ? $settings['crafto_image_lazy_loading'] : 'no';

			/* For Box Icon */
			$is_new        = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_migrated = isset( $settings['__fa4_migrated']['crafto_fancy_text_box_icon'] );

			$is_new1        = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_migrated1 = isset( $settings['__fa4_migrated']['crafto_fancy_text_box_button_icon'] );

			// button hover animation.
			$hover_animation_button              = $settings['crafto_fancy_text_button_hover_animation'];
			$crafto_fancy_text_button_icon_align = $settings['crafto_fancy_text_button_icon_align'];

			$custom_animation_class       = '';
			$custom_animation_div         = '';
			$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();

			if ( ! empty( $hover_animation_effect_array ) || ! empty( $settings['crafto_fancy_text_button_hover_animation'] ) ) {
				$this->add_render_attribute( 'crafto_primary_button', 'class', 'elementor-animation-' . $this->get_settings( 'crafto_fancy_text_button_hover_animation' ) );
				if ( in_array( $this->get_settings( 'crafto_fancy_text_button_hover_animation' ), $hover_animation_effect_array, true ) ) {
					$custom_animation_class = 'btn-custom-effect';
					if ( ! in_array( $this->get_settings( 'crafto_fancy_text_button_hover_animation' ), array( 'btn-switch-icon', 'btn-switch-text' ), true ) ) {
						$custom_animation_div = '<span class="btn-hover-animation"></span>';
					}
				}
			}
			$this->add_render_attribute( 'crafto_primary_button', 'class', $custom_animation_class );

			if ( 'btn-reveal-icon' === $hover_animation_button && 'left' === $crafto_fancy_text_button_icon_align ) {
				$this->add_render_attribute( 'crafto_primary_button', 'class', 'btn-reveal-icon-left' );
			}

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'fancy-text-box-wrapper',
							$fancy_text_box_styles,
						],
					],
				]
			);

			$this->add_render_attribute(
				[
					'crafto_btn_wrapper' => [
						'class' => [
							'elementor-button-wrapper',
							'crafto-button-wrapper',
							'crafto-primary-wrapper',
						],
					],
				]
			);

			if ( ! empty( $settings['crafto_fancy_text_button_link']['url'] ) ) {
				$this->add_render_attribute( 'crafto_primary_button', 'class', 'elementor-button-link' );
				$this->add_render_attribute( 'crafto_primary_button', 'href', $settings['crafto_fancy_text_button_link']['url'] );

				if ( $settings['crafto_fancy_text_button_link']['is_external'] ) {
					$this->add_render_attribute( 'crafto_primary_button', 'target', '_blank' );
				}

				if ( $settings['crafto_fancy_text_button_link']['nofollow'] ) {
					$this->add_render_attribute( 'crafto_primary_button', 'rel', 'nofollow' );
				}
			}

			$this->add_render_attribute( 'crafto_primary_button', 'class', [ 'elementor-button', 'crafto_primary_button' ] );
			$this->add_render_attribute( 'crafto_primary_button', 'role', 'button' );

			if ( ! empty( $settings['crafto_primary_button_size'] ) ) {
				$this->add_render_attribute( 'crafto_primary_button', 'class', 'elementor-size-' . $settings['crafto_primary_button_size'] );
			}

			// Link on Image.
			$img_alt = '';
			if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
				$img_alt = get_post_meta( $settings['crafto_image']['id'], '_wp_attachment_image_alt', true );
				if ( empty( $img_alt ) ) {
					$img_alt = esc_attr( get_the_title( $settings['crafto_image']['id'] ) );
				}
			}

			if ( ! empty( $settings['crafto_image_link']['url'] ) ) {
				$this->add_link_attributes( '_imagelink', $settings['crafto_image_link'] );
				$this->add_render_attribute( '_imagelink', 'class', 'image-link' );
				$this->add_render_attribute( '_imagelink', 'aria-label', $img_alt );
			}
			// End Link on Image.

			// Link on Icon.
			if ( ! empty( $settings['crafto_icon_link']['url'] ) ) {
				$this->add_link_attributes( '_iconlink', $settings['crafto_icon_link'] );
				$this->add_render_attribute( '_iconlink', 'class', 'icon-link' );
			}
			// End Link on Image.

			// Link on Button Icon.
			if ( ! empty( $settings['crafto_button_icon_link']['url'] ) ) {
				$this->add_link_attributes( '_buttoniconlink', $settings['crafto_button_icon_link'] );
			}
			// End Link on Button Icon.

			// Link on Text.
			if ( ! empty( $settings['crafto_title_link']['url'] ) ) {
				$this->add_render_attribute( '_titlelink', 'class', 'title-link' );
				$this->add_link_attributes( '_titlelink', $settings['crafto_title_link'] );
			}
			// End Link on Text.

			// Link on Hover Text.
			if ( ! empty( $settings['crafto_hover_box_link']['url'] ) ) {
				$this->add_render_attribute( '_hovertitlelink', 'class', 'hover-title-link' );
				$this->add_link_attributes( '_hovertitlelink', $settings['crafto_hover_box_link'] );
			}
			// End Link on Hover Text.

			// Link on Label.
			if ( ! empty( $settings['crafto_label_link']['url'] ) ) {
				$this->add_render_attribute( '_labellink', 'class', 'label-link' );
				$this->add_link_attributes( '_labellink', $settings['crafto_label_link'] );
			}
			// End Link on Text.
			switch ( $fancy_text_box_styles ) {
				case 'fancy-text-box-style-1':
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="box-image">
							<?php
							if ( '' !== $fancy_image_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
								$settings['crafto_image']['id'] = '';
							}
							if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							}
							if ( 'yes' === $fancy_image_overlay ) {
								?>
								<div class="box-overlay"></div>
								<?php
							}
							if ( $is_new || $icon_migrated ) {
								if ( '' !== $settings['crafto_fancy_text_box_icon']['value'] ) {
									?>
									<span class="elementor-icon">
										<?php
										if ( '' !== $fancy_icon_link ) {
											?>
											<a <?php $this->print_render_attribute_string( '_iconlink' ); ?>>
											<?php
										}
										Icons_Manager::render_icon( $settings['crafto_fancy_text_box_icon'] );
										if ( '' !== $fancy_icon_link ) {
											?>
											</a>
											<?php
										}
										?>
									</span>
									<?php
								}
							} elseif ( isset( $settings['crafto_fancy_text_box_icons']['value'] ) && ! empty( $settings['crafto_fancy_text_box_icons']['value'] ) ) {
								?>
								<span class="elementor-icon">
									<i class="<?php echo esc_attr( $settings['crafto_fancy_text_box_icons']['value'] ); ?>"></i>
								</span>
								<?php
							}
							if ( '' !== $fancy_image_link ) {
								?>
								</a>
								<?php
							}
							?>
						</div>
						<?php
						if ( ! empty( $fancy_text_box_title ) || ! empty( $fancy_text_box_content ) ) {
							?>
							<figcaption class="fancy-text-box">
								<?php
								$this->crafto_fancy_text_title();
								$this->crafto_fancy_text_content();
								Button_Group_Control::render_button_content( $this, 'primary' );
								?>
							</figcaption>
							<?php
						}
						?>
					</figure>
					<?php
					break;
				case 'fancy-text-box-style-2':
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="box-image">
							<?php
							if ( '' !== $fancy_image_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
								$settings['crafto_image']['id'] = '';
							}
							if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							}
							if ( '' !== $fancy_image_link ) {
								?>
								</a>
								<?php
							}
							if ( ! empty( $fancy_text_box_label ) ) {
								if ( '' !== $fancy_label_link ) {
									?>
									<a <?php $this->print_render_attribute_string( '_labellink' ); ?>>
									<?php
								}
								?>
								<div class="category-label">
									<?php echo sprintf( '%s', $fancy_text_box_label ); // phpcs:ignore ?>
								</div>
								<?php
								if ( '' !== $fancy_label_link ) {
									?>
									</a>
									<?php
								}
							}
							?>
						</div>
						<?php
						if ( ! empty( $fancy_text_box_title ) || ! empty( $fancy_text_box_content ) ) {
							?>
							<figcaption class="fancy-text-box">
								<div class="fancy-text-border">
									<?php
									if ( $is_new || $icon_migrated ) {
										if ( '' !== $settings['crafto_fancy_text_box_icon']['value'] ) {
											?>
											<div class="elementor-icon">
												<?php
												Icons_Manager::render_icon( $settings['crafto_fancy_text_box_icon'] );
												?>
											</div>
											<?php
										}
									} elseif ( isset( $settings['crafto_fancy_text_box_icons']['value'] ) && ! empty( $settings['crafto_fancy_text_box_icons']['value'] ) ) {
										?>
										<span class="elementor-icon">
											<i class="<?php echo esc_attr( $settings['crafto_fancy_text_box_icons']['value'] ); ?>"></i>
										</span>
										<?php
									}
									$this->crafto_fancy_text_title();
									$this->crafto_fancy_text_content();
									?>
								</div>
								<?php
								if ( ! empty( $settings['crafto_fancy_text_button_text'] ) ) {
									?>
									<div <?php $this->print_render_attribute_string( 'crafto_btn_wrapper' ); ?>>
										<a <?php $this->print_render_attribute_string( 'crafto_primary_button' ); ?>>
											<?php
												self::repeater_button_render_text();
												echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
											?>
										</a>
									</div>
									<?php
								}
								if ( 'yes' === $fancy_image_overlay ) {
									?>
									<div class="box-overlay"></div>
									<?php
								}
								?>
							</figcaption>
							<?php
						}
						?>
					</figure>
					<?php
					break;
				case 'fancy-text-box-style-3':
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="box-image">
							<?php
							if ( '' !== $fancy_image_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
								$settings['crafto_image']['id'] = '';
							}
							if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							}
							if ( '' !== $fancy_image_link ) {
								?>		
								</a>
								<?php
							}
							if ( ! empty( $fancy_text_box_label ) ) {
								if ( '' !== $fancy_label_link ) {
									?>
									<a <?php $this->print_render_attribute_string( '_labellink' ); ?>>
									<?php
								}
								?>
								<div class="category-label">
									<?php echo sprintf( '%s', $fancy_text_box_label ); // phpcs:ignore ?>
								</div>
								<?php
								if ( '' !== $fancy_label_link ) {
									?>
									</a>
									<?php
								}
							}
							?>
						</div>
						<?php
						if ( ! empty( $fancy_text_box_title ) || ! empty( $fancy_text_box_content ) ) {
							?>
							<figcaption class="fancy-text-box">
								<div class="fancy-text-border">
									<?php
									$this->crafto_fancy_text_title();
									$this->crafto_fancy_text_content();
									?>
								</div>
								<?php
								if ( ! empty( $settings['crafto_fancy_text_button_text'] ) ) {
									?>
									<div <?php $this->print_render_attribute_string( 'crafto_btn_wrapper' ); ?>>
										<a <?php $this->print_render_attribute_string( 'crafto_primary_button' ); ?>>
											<?php
											self::repeater_button_render_text();
											echo sprintf( '%s', $custom_animation_div ); // phpcs:ignore
											?>
										</a>
									</div>
									<?php
								}
								?>
							</figcaption>
							<?php
						}
						?>
					</figure>
					<?php
					break;
				case 'fancy-text-box-style-4':
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="box-image">
							<?php
							if ( '' !== $fancy_image_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
								$settings['crafto_image']['id'] = '';
							}
							if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							}
							if ( '' !== $fancy_image_link ) {
								?>		
								</a>
								<?php
							}
							?>
						</div>
						<?php
						if ( ! empty( $fancy_text_box_title ) || ! empty( $fancy_text_box_content ) ) {
							?>
							<figcaption class="fancy-text-box">
								<div class="content-box">
									<?php
									$this->crafto_fancy_text_title();
									$this->crafto_fancy_text_content();
									?>
								</div>
								<div class="fancy-text-border">
									<?php
									$this->fancy_text_box_price_title();
									if ( $is_new || $icon_migrated ) {
										if ( '' !== $settings['crafto_fancy_text_box_icon']['value'] ) {
											?>
											<div class="elementor-icon">
												<?php
												if ( '' !== $fancy_icon_link ) {
													?>
													<a <?php $this->print_render_attribute_string( '_iconlink' ); ?>>
													<?php
												}
												Icons_Manager::render_icon( $settings['crafto_fancy_text_box_icon'] );
												if ( '' !== $fancy_icon_link ) {
													?>
													</a>
													<?php
												}
												?>
											</div>
											<?php
										}
									}
									?>
								</div>
							</figcaption>
							<?php
						}
						?>
					</figure>
					<?php
					break;
				case 'fancy-text-box-style-5':
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="box-image">
							<?php
							if ( '' !== $fancy_image_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
								$settings['crafto_image']['id'] = '';
							}
							if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							}
							if ( '' !== $fancy_image_link ) {
								?>
								</a>
								<?php
							}
							?>
							<div class="image-overlay"></div>
						</div>
						<figcaption class="fancy-text-box-content">
							<div class="content-box-wrapper">
								<?php
								if ( 'none' !== $settings['crafto_fancy_text_box_image'] ) {
									$this->crafto_get_fancy_text_icon_image( $settings );
								}
								$this->crafto_fancy_text_secondary_title();
								$this->crafto_fancy_text_content();
								if ( $is_new1 || $icon_migrated1 ) {
									if ( '' !== $settings['crafto_button_icon_link']['url'] ) {
										?>
										<a <?php $this->print_render_attribute_string( '_buttoniconlink' ); ?>>
										<?php
									}
									if ( '' !== $settings['crafto_fancy_text_box_button_icon']['value'] ) {
										?>
										<div>
											<div class="button-icon">
												<?php Icons_Manager::render_icon( $settings['crafto_fancy_text_box_button_icon'] ); ?>
											</div>
										</div>
										<span class="screen-reader-text"><?php echo esc_html__( 'Read More', 'crafto-addons' ); ?></span>
										<?php
									}
								} elseif ( isset( $settings['crafto_fancy_text_box_button_icon']['value'] ) && ! empty( $settings['crafto_fancy_text_box_button_icon']['value'] ) ) {
									?>
									<span class="button-icon">
										<i class="<?php echo esc_attr( $settings['icon'] ); ?>"></i>
									</span>
									<?php
								}
								if ( '' !== $settings['crafto_button_icon_link']['url'] ) {
									?>
									</a>
									<?php
								}
								if ( 'yes' === $fancy_image_overlay ) {
									?>
									<div class="box-overlay"></div>
									<?php
								}
								?>
							</div>
							<?php $this->crafto_fancy_text_title(); ?>
						</figcaption>
					</figure>
					<?php
					break;
				case 'fancy-text-box-style-6':
					if ( '' !== $fancy_image_link ) {
						?>
						<a <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
						<?php
					}
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="box-image">
							<?php
							if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
								$settings['crafto_image']['id'] = '';
							}
							if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_thumbnail_size'], $fetch_priority, $crafto_lazy_loading ); // phpcs:ignore
							}
							?>
						</div>
						<?php
						if ( ! empty( $fancy_text_box_title ) || ! empty( $fancy_text_box_content ) ) {
							?>
							<figcaption class="fancy-text-box">
								<div class="content-box">
									<?php
									$this->crafto_fancy_text_title();
									$this->crafto_fancy_text_content();
									?>
								</div>
								<?php
								$has_labels = false;
								foreach ( $settings['list'] as $item ) {
									if ( ! empty( $item['crafto_list_title'] ) ) {
										$has_labels = true;
										break;
									}
								}
								if ( $has_labels ) {
									?>
									<div class="fancy-text-label">
										<?php
										foreach ( $settings['list'] as $item ) {
											echo '<span class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . '">' . $item['crafto_list_title'] . '</span>'; // phpcs:ignore
										}
										?>
									</div>
									<?php
								}
								?>
							</figcaption>
							<?php
						}
						?>
					</figure>
					<?php
					if ( '' !== $fancy_image_link ) {
						?>		
						</a>
						<?php
					}
					break;
			}
		}

		/**
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access public
		 */
		protected function repeater_button_render_text() {
			$settings = $this->get_settings_for_display();
			$migrated = isset( $settings['__fa4_migrated']['crafto_fancy_text_selected_icon'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! $is_new && empty( $settings['crafto_fancy_text_button_icon_align'] ) ) {
				$settings['crafto_fancy_text_button_icon_align'] = $this->get_settings( 'crafto_fancy_text_button_icon_align' );
			}

			$this->add_render_attribute(
				[
					'crafto_primary_content_wrapper' => [
						'class' => 'elementor-button-content-wrapper',
					],
					'crafto_primary_icon-align'      => [
						'class' => [
							'elementor-button-icon',
							'elementor-align-icon-' . $settings['crafto_fancy_text_button_icon_align'],
						],
					],
					'crafto_primary_text'            => [
						'class' => 'elementor-button-text',
					],
				]
			);
			?>
			<span <?php $this->print_render_attribute_string( 'crafto_primary_content_wrapper' ); ?>>
				<?php
				if ( ! empty( $settings['crafto_fancy_text_selected_icon'] ) || ! empty( $settings['crafto_fancy_text_selected_icon']['value'] ) ) {
					?>
					<span <?php $this->print_render_attribute_string( 'crafto_primary_icon-align' ); ?>>
						<?php
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings['crafto_fancy_text_selected_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['crafto_fancy_text_selected_icon']['value'] ) && ! empty( $settings['crafto_fancy_text_selected_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings['crafto_fancy_text_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
						?>
					</span>
					<?php
				}
				if ( 'btn-switch-icon' === $this->get_settings( 'crafto_fancy_text_button_hover_animation' ) ) {
					if ( ! empty( $settings['crafto_fancy_text_selected_icon'] ) || ! empty( $settings['crafto_fancy_text_selected_icon']['value'] ) ) {
						?>
						<span <?php $this->print_render_attribute_string( 'crafto_primary_icon-align' ); ?>>
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings['crafto_fancy_text_selected_icon'], [ 'aria-hidden' => 'true' ] );
							} elseif ( isset( $settings['crafto_fancy_text_selected_icon']['value'] ) && ! empty( $settings['crafto_fancy_text_selected_icon']['value'] ) ) {
								?>
								<i class="<?php echo esc_attr( $settings['crafto_fancy_text_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
								<?php
							}
							?>
						</span>
						<?php
					}
				}
				if ( 'btn-switch-text' === $this->get_settings( 'crafto_fancy_text_button_hover_animation' ) ) {
					$this->add_render_attribute(
						[
							'crafto_primary_text' => [
								'data-btn-text' => wp_strip_all_tags( $settings['crafto_fancy_text_button_text'] ),
							],
						],
					);
				}
				if ( ! empty( $settings['crafto_fancy_text_button_text'] ) ) {
					?>
					<span <?php $this->print_render_attribute_string( 'crafto_primary_text' ); ?>>
						<?php echo sprintf( '%s', esc_html( $settings['crafto_fancy_text_button_text'] ) ); // phpcs:ignore ?>
					</span>
					<?php
				}
				?>
			</span>
			<?php
		}
		/**
		 *
		 * Fancy text content box.
		 */
		public function crafto_fancy_text_content() {
			$settings               = $this->get_settings_for_display();
			$fancy_text_box_content = ( isset( $settings['crafto_fancy_text_box_content'] ) && $settings['crafto_fancy_text_box_content'] ) ? $settings['crafto_fancy_text_box_content'] : '';

			if ( ! empty( $fancy_text_box_content ) ) {
				?>
				<div class="content">
					<?php $this->print_text_editor( $fancy_text_box_content ); ?>
				</div>
				<?php
			}
		}
		/**
		 *
		 * Fancy text content box.
		 */
		public function crafto_fancy_text_title() {
			$settings              = $this->get_settings_for_display();
			$fancy_text_box_title  = ( isset( $settings['crafto_fancy_text_box_title'] ) && $settings['crafto_fancy_text_box_title'] ) ? $settings['crafto_fancy_text_box_title'] : '';
			$fancy_title_link      = ( isset( $settings['crafto_title_link']['url'] ) && $settings['crafto_title_link']['url'] ) ? $settings['crafto_title_link']['url'] : '';
			$fancy_text_box_styles = ( isset( $settings['crafto_fancy_text_box_styles'] ) && $settings['crafto_fancy_text_box_styles'] ) ? $settings['crafto_fancy_text_box_styles'] : 'fancy-text-box-style-1';

			if ( ! empty( $fancy_text_box_title ) ) {
				?>
				<div>
					<?php
					if ( 'fancy-text-box-style-6' !== $fancy_text_box_styles ) {
						if ( '' !== $fancy_title_link ) {
							?>
							<a <?php $this->print_render_attribute_string( '_titlelink' ); ?>>
							<?php
						}
					}
					?>
					<<?php Utils::print_validated_html_tag( $settings['crafto_header_size'] ); ?> class="title">
					<?php echo sprintf( '%s', $fancy_text_box_title ); // phpcs:ignore ?>
					</<?php Utils::print_validated_html_tag( $settings['crafto_header_size'] ); ?>>
					<?php
					if ( 'fancy-text-box-style-6' !== $fancy_text_box_styles ) {
						if ( '' !== $fancy_title_link ) {
							?>
							</a>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
		}

		/**
		 *
		 * Fancy text content box.
		 */
		public function crafto_fancy_text_secondary_title() {
			$settings                       = $this->get_settings_for_display();
			$fancy_text_box_secondary_title = ( isset( $settings['crafto_fancy_text_box_secondary_title'] ) && $settings['crafto_fancy_text_box_secondary_title'] ) ? $settings['crafto_fancy_text_box_secondary_title'] : '';
			$fancy_secondary_title_link     = ( isset( $settings['crafto_hover_box_link']['url'] ) && $settings['crafto_hover_box_link']['url'] ) ? $settings['crafto_hover_box_link']['url'] : '';

			if ( ! empty( $fancy_text_box_secondary_title ) ) {
				if ( '' !== $fancy_secondary_title_link ) {
					?>
					<a <?php $this->print_render_attribute_string( '_hovertitlelink' ); ?>>
					<?php
				}
				?>
				<<?php Utils::print_validated_html_tag( $settings['crafto_html_size'] ); ?> class="secondary-title">
				<?php echo sprintf( '%s', $fancy_text_box_secondary_title ); // phpcs:ignore ?>
				</<?php Utils::print_validated_html_tag( $settings['crafto_html_size'] ); ?>>
				<?php
				if ( '' !== $fancy_secondary_title_link ) {
					?>
					</a>
					<?php
				}
			}
		}

		/**
		 * Return icon or image
		 *
		 * @param array $settings data.
		 */
		public function crafto_get_fancy_text_icon_image( $settings ) {
			$icon     = '';
			$migrated = isset( $settings['__fa4_migrated']['crafto_fancy_text_box_icons'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_fancy_text_box_icons'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_fancy_text_box_icons']['value'] ) && ! empty( $settings['crafto_fancy_text_box_icons']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $settings['crafto_fancy_text_box_icons']['value'] ) . '" aria-hidden="true"></i>';
			}
			$settings = $this->get_settings_for_display();

			if ( ! empty( $settings['crafto_fancy_text_box_images']['id'] ) && ! wp_attachment_is_image( $settings['crafto_fancy_text_box_images']['id'] ) ) {
				$settings['crafto_fancy_text_box_images']['id'] = '';
			}
			if ( isset( $settings['crafto_fancy_text_box_images'] ) && isset( $settings['crafto_fancy_text_box_images']['id'] ) && ! empty( $settings['crafto_fancy_text_box_images']['id'] ) ) {
				crafto_get_attachment_html( $settings['crafto_fancy_text_box_images']['id'], $settings['crafto_fancy_text_box_images']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			} elseif ( isset( $settings['crafto_fancy_text_box_images'] ) && isset( $settings['crafto_fancy_text_box_images']['url'] ) && ! empty( $settings['crafto_fancy_text_box_images']['url'] ) ) {
				crafto_get_attachment_html( $settings['crafto_fancy_text_box_images']['id'], $settings['crafto_fancy_text_box_images']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
			}
			if ( ! empty( $icon ) && ( '' === $settings['crafto_fancy_text_box_image'] ) ) {
				?>
				<div class="elementor-icon">
					<?php printf( '%s', $icon ); // phpcs:ignore ?>
				</div>
				<?php
			}
		}
		/**
		 *
		 * Fancy text Price box.
		 */
		public function fancy_text_box_price_title() {
			$settings                          = $this->get_settings_for_display();
			$fancy_text_box_price_title        = ( isset( $settings['crafto_fancy_text_box_price_title'] ) && $settings['crafto_fancy_text_box_price_title'] ) ? $settings['crafto_fancy_text_box_price_title'] : '';
			$fancy_text_box_price_number_title = ( isset( $settings['crafto_fancy_text_box_price_number_title'] ) && $settings['crafto_fancy_text_box_price_number_title'] ) ? $settings['crafto_fancy_text_box_price_number_title'] : '';

			if ( ! empty( $fancy_text_box_price_title ) || ! empty( $fancy_text_box_price_number_title ) ) {
				?>
				<div class="price-title">
					<span class="price-number"><?php echo sprintf( '%s', $fancy_text_box_price_number_title ); // phpcs:ignore ?></span>
					<?php echo sprintf( '%s', $fancy_text_box_price_title ); // phpcs:ignore ?>
				</div>
				<?php
			}
		}
	}
}
