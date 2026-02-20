<?php
namespace CraftoAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Crafto widget for portfolio slider.
 *
 * @package Crafto
 * @since   1.0
 */

// If class `Portfolio_Slider` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Portfolio_Slider' ) ) {
	/**
	 * Define `Portfolio_Slider` class.
	 */
	class Portfolio_Slider extends Widget_Base {
		/**
		 * Retrieve the list of scripts the portfolio slider widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$portfolio_slider_scripts     = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$portfolio_slider_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$portfolio_slider_scripts[] = 'swiper';

					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$portfolio_slider_scripts[] = 'crafto-magic-cursor';
					}
				}

				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$portfolio_slider_scripts[] = 'imagesloaded';
				}
				$portfolio_slider_scripts[] = 'crafto-portfolio-slider-widget';
			}
			return $portfolio_slider_scripts;
		}
		/**
		 * Retrieve the list of styles the portfolio slider widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$portfolio_slider_styles      = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$portfolio_slider_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$portfolio_slider_styles[] = 'swiper';
					$portfolio_slider_styles[] = 'nav-pagination';

					if ( is_rtl() ) {
						$portfolio_slider_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$portfolio_slider_styles[] = 'crafto-magic-cursor';
					}
				}
				$portfolio_slider_styles[] = 'crafto-portfolio-widget';
			}
			return $portfolio_slider_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-portfolio-slider';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Portfolio Slider', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-posts-carousel crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/portfolio-slider/';
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
				'gallery',
				'album',
				'photography',
				'vertical',
				'project',
				'carousel',
				'lightbox',
				'popup',
				'portfolio slider',
				'project slider',
				'slider widget',
			];
		}

		/**
		 * Register portfolio slider widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_portfolio_section_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_portfolio_style',
				[
					'label'              => esc_html__( 'Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'portfolio-slider-style-1',
					'options'            => [
						'portfolio-slider-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'portfolio-slider-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'portfolio-slider-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_portfolio_post_per_page',
				[
					'label'   => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => 8,
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portolio_slider_content_data',
				[
					'label' => esc_html__( 'Data', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_portfolio_orderby',
				[
					'label'   => esc_html__( 'Order By', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'date',
					'options' => [
						'date'          => esc_html__( 'Date', 'crafto-addons' ),
						'ID'            => esc_html__( 'ID', 'crafto-addons' ),
						'author'        => esc_html__( 'Author', 'crafto-addons' ),
						'title'         => esc_html__( 'Title', 'crafto-addons' ),
						'modified'      => esc_html__( 'Modified', 'crafto-addons' ),
						'rand'          => esc_html__( 'Random', 'crafto-addons' ),
						'comment_count' => esc_html__( 'Comment count', 'crafto-addons' ),
						'menu_order'    => esc_html__( 'Menu order', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_order',
				[
					'label'   => esc_html__( 'Sort By', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'DESC',
					'options' => [
						'DESC' => esc_html__( 'Descending', 'crafto-addons' ),
						'ASC'  => esc_html__( 'Ascending', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_type_selection',
				[
					'label'              => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'portfolio-category',
					'options'            => [
						'portfolio-category' => esc_html__( 'Category', 'crafto-addons' ),
						'portfolio-tags'     => esc_html__( 'Tags', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_portfolio_categories_list',
				[
					'label'       => esc_html__( 'Categories', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'portfolio-category' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_portfolio_type_selection' => 'portfolio-category',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_tags_list',
				[
					'label'       => esc_html__( 'Tags', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_tags_list' ) ? crafto_get_tags_list( 'portfolio-tags' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_portfolio_type_selection' => 'portfolio-tags',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_slider_offset',
				[
					'label'   => esc_html__( 'Offset', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_section_settings',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_thumbnail',
				[
					'label'          => esc_html__( 'Image Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'full',
					'options'        => function_exists( 'crafto_get_thumbnail_image_sizes' ) ? crafto_get_thumbnail_image_sizes() : [],
					'style_transfer' => true,
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
			$this->add_control(
				'crafto_portfolio_show_post_title',
				[
					'label'        => esc_html__( 'Enable Title', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_portfolio_show_post_subtitle',
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
				'crafto_portfolio_show_custom_link',
				[
					'label'        => esc_html__( 'Enable Link', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_portfolio_enable_overlay',
				[
					'label'        => esc_html__( 'Enable Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_portfolio_style' => [
							'portfolio-slider-style-2',
							'portfolio-slider-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_custom_link_icon_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_portfolio_show_custom_link' => 'yes',
						'crafto_portfolio_style' => [
							'portfolio-slider-style-1',
							'portfolio-slider-style-3',
						],
					],
				]
			);

			$this->add_control(
				'crafto_portfolio_custom_link_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'bi bi-arrow-right',
						'library' => 'bi',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_image_carousel_setting',
				[
					'label' => esc_html__( 'Slider Settings', 'crafto-addons' ),
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
							'max' => 500,
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
					'default'      => 'yes',
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
				'crafto_mousewheel',
				[
					'label'        => esc_html__( 'Enable Mousewheel', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
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
				'crafto_portfolio_section_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-slider-style-1',
							'portfolio-slider-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_content_box_alignment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => 'center',
					'options'     => [
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
					'selectors'   => [
						'{{WRAPPER}} .portfolio-caption' => 'text-align: {{VALUE}};',
					],
					'condition'   => [
						'crafto_portfolio_style' => 'portfolio-slider-style-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_content_padding',
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
						'{{WRAPPER}} .portfolio-slider-style-1 .portfolio-caption, {{WRAPPER}} .portfolio-slider-style-2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-slider-style-1',
							'portfolio-slider-style-2',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portfolio_content_box_heading',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_portfolio_style!' => 'portfolio-slider-style-1',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_portfolio_content_box_tabs',
			);
			$this->start_controls_tab(
				'crafto_portfolio_content_box_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_portfolio_style' => 'portfolio-slider-style-3',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_portfolio_content_box_bg_color',
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
					'selector' => '{{WRAPPER}} .portfolio-item .portfolio-caption, {{WRAPPER}} .portfolio-colorful .portfolio-item .portfolio-caption',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_portfolio_content_box_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_portfolio_style' => 'portfolio-slider-style-3',
					],
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_portfolio_content_box_bg_hover_color',
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
					'selector'  => '{{WRAPPER}} .hover-box-slide-text:hover .portfolio-caption',
					'condition' => [
						'crafto_portfolio_style' => 'portfolio-slider-style-3',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_portfolio_content_box_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_portfolio_style' => 'portfolio-slider-style-3',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_portfolio_content_box_shadow',
					'selector' => '{{WRAPPER}} .portfolio-item .portfolio-caption',
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_content_box_padding',
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
						'{{WRAPPER}} .portfolio-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_section_title_style',
				[
					'label'      => esc_html__( 'Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_show_post_title' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_portfolio_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .portfolio-caption .title',
				]
			);
			$this->start_controls_tabs(
				'crafto_portfolio_title_tabs',
			);
				$this->start_controls_tab(
					'crafto_portfolio_title_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style' => 'portfolio-slider-style-3',
						],
					]
				);
				$this->add_control(
					'crafto_portfolio_title_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .portfolio-item .portfolio-caption .title'   => 'color: {{VALUE}};',
							'{{WRAPPER}} .portfolio-item .portfolio-caption .title a' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_portfolio_title_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style' => 'portfolio-slider-style-3',
						],
					],
				);
					$this->add_control(
						'crafto_portfolio_title_hover_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .portfolio-item .portfolio-caption .title a:hover'                         => 'color: {{VALUE}};',
								'{{WRAPPER}} .portfolio-slider-style-1 .portfolio-item .portfolio-caption .title:hover' => 'color: {{VALUE}};',
								'{{WRAPPER}} .portfolio-slider-style-3 .hover-box-slide-text:hover .title'              => 'color: {{VALUE}};',
							],
							'condition' => [
								'crafto_portfolio_style' => 'portfolio-slider-style-3',
							],
						],
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_section_subtitle_style',
				[
					'label'      => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				],
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_portfolio_subtitle_typography',
					'selector' => '{{WRAPPER}} .portfolio-swiper-slider:not(.portfolio-slider-style-3) .portfolio-caption .subtitle, {{WRAPPER}} .portfolio-slider-style-3 .subtitle span',
				]
			);

			$this->add_control(
				'crafto_portfolio_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .portfolio-swiper-slider:not(.portfolio-slider-style-3) .portfolio-item .portfolio-caption .subtitle, {{WRAPPER}} .portfolio-slider-style-3 .subtitle span' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_section_overlay_style',
				[
					'label'      => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_enable_overlay' => 'yes',
						'crafto_portfolio_style'          => [
							'portfolio-slider-style-2',
							'portfolio-slider-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_portfolio_overlay_color',
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
					'selector' => '{{WRAPPER}} .bg-overlay, {{WRAPPER}} .hover-box-slide-text:hover .portfolio-image img',
				]
			);
			$this->add_control(
				'crafto_portfolio_overlay_opacity',
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
						'{{WRAPPER}} .bg-overlay, {{WRAPPER}} .hover-box-slide-text:hover .portfolio-image img' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_icons_style',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_portfolio_custom_link_icon[library]!' => '',
						'crafto_portfolio_style!' => [
							'portfolio-slider-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_icons_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .portfolio-item .portfolio-hover .portfolio-icon i, {{WRAPPER}} .icon-box i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .portfolio-item .portfolio-hover .portfolio-icon svg, {{WRAPPER}} .icon-box svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_portfolio_icons_background',
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
					'selector'  => '{{WRAPPER}} .icon-box',
					'condition' => [
						'crafto_portfolio_style!' => 'portfolio-slider-style-3',
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
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .icon-box i, {{WRAPPER}} .portfolio-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .icon-box svg, {{WRAPPER}} .portfolio-icon svg' => 'width: {{SIZE}}{{UNIT}};',
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
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style!' => 'portfolio-slider-style-3',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_icon_margin',
				[
					'label'      => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => -50,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-slider-style-3 .subtitle span + .portfolio-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style!' => 'portfolio-slider-style-1',
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
		 * Render portfolio slider widget output on the frontend.
		 *
		 * @param array $instance widget Id.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render( $instance = [] ) {

			$settings                       = $this->get_settings_for_display();
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$custom_link_icon_migrated      = isset( $settings['__fa4_migrated']['crafto_portfolio_custom_link_icon'] );
			$portfolio_style                = ( isset( $settings['crafto_portfolio_style'] ) && $settings['crafto_portfolio_style'] ) ? $settings['crafto_portfolio_style'] : '';
			$portfolio_type_selection       = ( isset( $settings['crafto_portfolio_type_selection'] ) && $settings['crafto_portfolio_type_selection'] ) ? $settings['crafto_portfolio_type_selection'] : 'portfolio-category';
			$portfolio_categories_list      = ( isset( $settings['crafto_portfolio_categories_list'] ) && $settings['crafto_portfolio_categories_list'] ) ? $settings['crafto_portfolio_categories_list'] : array();
			$portfolio_tags_list            = ( isset( $settings['crafto_portfolio_tags_list'] ) && $settings['crafto_portfolio_tags_list'] ) ? $settings['crafto_portfolio_tags_list'] : array();
			$portfolio_post_per_page        = ( isset( $settings['crafto_portfolio_post_per_page'] ) && $settings['crafto_portfolio_post_per_page'] ) ? $settings['crafto_portfolio_post_per_page'] : 8;
			$crafto_portfolio_slider_offset = ( isset( $settings['crafto_portfolio_slider_offset'] ) && $settings['crafto_portfolio_slider_offset'] ) ? $settings['crafto_portfolio_slider_offset'] : '';
			$portfolio_show_post_title      = ( isset( $settings['crafto_portfolio_show_post_title'] ) && $settings['crafto_portfolio_show_post_title'] ) ? $settings['crafto_portfolio_show_post_title'] : '';
			$portfolio_show_post_subtitle   = ( isset( $settings['crafto_portfolio_show_post_subtitle'] ) && $settings['crafto_portfolio_show_post_subtitle'] ) ? $settings['crafto_portfolio_show_post_subtitle'] : '';
			$portfolio_orderby              = ( isset( $settings['crafto_portfolio_orderby'] ) && $settings['crafto_portfolio_orderby'] ) ? $settings['crafto_portfolio_orderby'] : '';
			$portfolio_order                = ( isset( $settings['crafto_portfolio_order'] ) && $settings['crafto_portfolio_order'] ) ? $settings['crafto_portfolio_order'] : '';
			$crafto_thumbnail               = ( isset( $settings['crafto_thumbnail'] ) && $settings['crafto_thumbnail'] ) ? $settings['crafto_thumbnail'] : 'full';

			if ( 'portfolio-tags' === $portfolio_type_selection ) {
				$categories_to_display_ids = ( ! empty( $portfolio_tags_list ) ) ? $portfolio_tags_list : array();
			} else {
				$categories_to_display_ids = ( ! empty( $portfolio_categories_list ) ) ? $portfolio_categories_list : array();
			}

			// If no categories are chosen or "All categories", we need to load all available categories.
			if ( ! is_array( $categories_to_display_ids ) || 0 === count( $categories_to_display_ids ) ) {

				$terms = get_terms( $portfolio_type_selection );

				if ( ! is_array( $categories_to_display_ids ) ) {
					$categories_to_display_ids = array();
				}
				foreach ( $terms as $term ) {
					$categories_to_display_ids[] = $term->slug;
				}
			} else {
				$categories_to_display_ids = array_values( $categories_to_display_ids );
			}

			$query_args = array(
				'post_type'      => 'portfolio',
				'post_status'    => 'publish',
				'posts_per_page' => intval( $portfolio_post_per_page ), // phpcs:ignore
				'no_found_rows'  => true,
			);

			if ( ! empty( $crafto_portfolio_slider_offset ) ) {
				$query_args['offset'] = $crafto_portfolio_slider_offset;
			}

			if ( ! empty( $categories_to_display_ids ) ) {
				$query_args['tax_query'] = [ // phpcs:ignore
					[
						'taxonomy' => $portfolio_type_selection,
						'field'    => 'slug',
						'terms'    => $categories_to_display_ids,
					],
				];
			}
			if ( ! empty( $portfolio_orderby ) ) {
				$query_args['orderby'] = $portfolio_orderby;
			}

			if ( ! empty( $portfolio_order ) ) {
				$query_args['order'] = $portfolio_order;
			}

			$portfolio_query                = new \WP_Query( $query_args );
			$slides_count                   = $portfolio_query->post_count;
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

			$slider_config = array(
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
				'mousewheel'       => $this->get_settings( 'crafto_mousewheel' ),
				'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
				'slider-style'     => $portfolio_style,
			);

			$slider_viewport = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
			$sliderconfig    = array_merge( $slider_config, $slider_viewport );
			$crafto_effect   = $this->get_settings( 'crafto_effect' );

			$effect = [
				'fade',
			];

			if ( '1' === $this->get_settings( 'crafto_slides_to_show' )['size'] && in_array( $crafto_effect, $effect, true ) ) {
				$sliderconfig['effect'] = $crafto_effect;
			}

			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}
			$this->add_render_attribute(
				[
					'carousel-wrapper' =>
					[
						'class'         => [
							'portfolio-swiper-slider',
							'swiper',
							$portfolio_style,
							$magic_cursor,
						],
						'data-settings' => wp_json_encode( $sliderconfig ),
					],
					'carousel'         => [
						'class' => 'swiper-wrapper',
					],
				],
			);

			if ( 'portfolio-slider-style-2' === $portfolio_style ) {
				$this->add_render_attribute(
					[
						'carousel-wrapper' => [
							'class' => 'full-screen-slide',
						],
					],
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
					],
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
			if ( ! empty( $crafto_rtl ) ) {
				$this->add_render_attribute( 'carousel-wrapper', 'dir', $crafto_rtl );
			}

			if ( 'yes' === $this->get_settings( 'crafto_image_stretch' ) ) {
				$this->add_render_attribute( 'carousel', 'class', 'swiper-image-stretch' );
			}

			if ( 'yes' !== $settings['crafto_portfolio_enable_overlay'] ) {
				$this->add_render_attribute(
					'portfolio_box',
					[
						'class' => 'disable-overlay',
					],
				);
			}

			$this->add_render_attribute(
				'portfolio_box',
				[
					'class' => 'hover-box-slide-text',
				],
			);

			if ( $portfolio_query->have_posts() ) {
				?>
				<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
					<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
						<?php
						$index = 0;
						while ( $portfolio_query->have_posts() ) :
							$portfolio_query->the_post();

							$inner_wrap_key        = 'inner_wrap_' . $index;
							$custom_link_key       = 'custom_link_' . $index;
							$crafto_subtitle       = crafto_post_meta( 'crafto_subtitle' );
							$has_post_format       = crafto_post_meta( 'crafto_portfolio_post_type' );
							$portfolio_link_target = crafto_post_meta( 'crafto_portfolio_link_target' );

							if ( 'link' === $has_post_format || has_post_format( 'link', get_the_ID() ) ) {
								$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_external_link' );
								$portfolio_link_target   = crafto_post_meta( 'crafto_portfolio_link_target' );
								$portfolio_external_link = ( ! empty( $portfolio_external_link ) ) ? $portfolio_external_link : '#';
								$portfolio_link_target   = ( ! empty( $portfolio_link_target ) ) ? $portfolio_link_target : '_self';
							} elseif ( 'video' === $has_post_format || has_post_format( 'video', get_the_ID() ) ) {
								$portfolio_video_type = crafto_post_meta( 'crafto_portfolio_video_type' );
								if ( 'self' === $portfolio_video_type ) {
									$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_video_mp4' );
								} else {
									$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_external_video' );
								}

								$this->add_render_attribute(
									$custom_link_key,
									[
										'class' => 'popup-video',
									],
								);
							} else {
								$portfolio_external_link = get_permalink();
								$portfolio_link_target   = '_self';
							}

							$this->add_render_attribute(
								$custom_link_key,
								[
									'href'   => $portfolio_external_link,
									'target' => $portfolio_link_target,
								],
							);
							$crafto_subtitle = ( $crafto_subtitle ) ? str_replace( '||', '<br />', $crafto_subtitle ) : '';

							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class' => [
										'portfolio-item',
										'swiper-slide',
									],
								],
							);
							switch ( $portfolio_style ) {
								case 'portfolio-slider-style-1':
								default:
									$this->add_render_attribute(
										$custom_link_key,
										[
											'class' => 'box-link',
										],
									);
									?>
									<div <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
										<div class="position-relative box-image">
											<?php
											crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore
											if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
												?>
												<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
												<?php
											}
											if ( ! empty( $settings['crafto_portfolio_custom_link_icon']['value'] ) ) {
												?>
												<span class="icon-box">
													<?php
													if ( $is_new || $custom_link_icon_migrated ) {
														Icons_Manager::render_icon( $settings['crafto_portfolio_custom_link_icon'], [ 'aria-hidden' => 'true' ] );
													} elseif ( isset( $settings['crafto_portfolio_custom_link_icon']['value'] ) && ! empty( $settings['crafto_portfolio_custom_link_icon']['value'] ) ) {
														?>
														<i class="<?php echo esc_attr( $settings['crafto_portfolio_custom_link_icon']['value'] ); ?>" aria-hidden="true"></i>
														<?php
													}
													?>
												</span>
												<span class="screen-reader-text"><?php echo esc_html__( 'Read More', 'crafto-addons' ); ?></span>
												<?php
											}
											if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
												?>
												</a>
												<?php
											}
											?>
										</div>
										<div class="portfolio-caption">
											<?php
											if ( 'yes' === $portfolio_show_post_title ) {
												?>
												<span class="title alt-font"><?php the_title(); ?></span>
												<?php
											}
											if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
												?>
												<span class="subtitle alt-font"><?php echo esc_html( $crafto_subtitle ); ?></span>
												<?php
											}
											?>
										</div>
									</div>
									<?php
									break;
								case 'portfolio-slider-style-2':
									if ( has_post_thumbnail() ) {
										$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), $crafto_thumbnail );
									} else {
										$featured_img_url = Utils::get_placeholder_image_src();
									}

									$this->add_render_attribute(
										$custom_link_key,
										[
											'class' => [
												'box-link',
												'force-magic-cursor',
											],
										],
									);

									if ( ! empty( $featured_img_url ) ) {
										$this->add_render_attribute(
											$inner_wrap_key,
											[
												'style' => [
													'background-image: url(' . esc_url( $featured_img_url ) . ');',
												],
											],
										);
									}
									?>
									<div <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
										<?php
										if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
											?>
											<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
											<?php
										}
										?>
										<div class="portfolio-caption">
											<?php
											if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
												?>
												<span class="subtitle"><?php echo esc_html( $crafto_subtitle ); ?></span>
												<?php
											}
											if ( 'yes' === $portfolio_show_post_title ) {
												?>
												<span class="title"><?php the_title(); ?></span>
												<?php
											}
											?>
										</div>
										<?php
										if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
											?>
											</a>
											<?php
										}
										if ( 'yes' === $settings['crafto_portfolio_enable_overlay'] ) {
											?>
											<div class="bg-overlay"></div>
											<?php
										}
										?>
									</div>
									<?php
									break;
								case 'portfolio-slider-style-3':
									?>
									<div <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
										<?php
										if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
											?>
											<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
											<?php
										}
										?>
										<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
											<div class="portfolio-image">
												<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
											</div>
											<div class="portfolio-hover d-flex justify-content-end flex-column">
												<div class="portfolio-caption">
													<?php
													if ( 'yes' === $portfolio_show_post_title ) {
														?>
														<div class="title alt-font">
															<span><?php the_title(); ?></span>
														</div>
														<?php
													}
													?>
													<div class="subtitle alt-font">
														<?php
														if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
															?>
															<span><?php echo esc_html( $crafto_subtitle ); ?></span>
															<?php
														}
														if ( ! empty( $settings['crafto_portfolio_custom_link_icon']['value'] ) ) {
															?>
															<div class="portfolio-icon">
																<?php
																if ( $is_new || $custom_link_icon_migrated ) {
																	Icons_Manager::render_icon( $settings['crafto_portfolio_custom_link_icon'], [ 'aria-hidden' => 'true' ] );
																} else {
																	?>
																	<i class="<?php echo esc_attr( $settings['crafto_portfolio_custom_link_icon']['value'] ); ?>" aria-hidden="true"></i>
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
										</div>
										<?php
										if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
											?>
										</a>
											<?php
										}
										?>
									</div>
									<?php
									break;
							}
							++$index;
						endwhile;
						wp_reset_postdata();
						?>
					</div>
					<?php
					if ( 1 < $slides_count ) {
						echo sprintf( '%s', $this->crafto_swiper_pagination() );  // phpcs:ignore
					}
					?>
				</div>
				<?php
			}
		}
		/**
		 * Crafto open lightbox link function.
		 *
		 * @return mixed
		 */
		public function crafto_swiper_pagination() {

			$previous_arrow_icon            = '';
			$next_arrow_icon                = '';
			$settings                       = $this->get_settings_for_display();
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
				?>
				<div class="elementor-swiper-button elementor-swiper-button-prev">
					<?php if ( ! empty( $previous_arrow_icon ) ) {
						echo sprintf( '%s', $previous_arrow_icon );  // phpcs:ignore
					} ?>
					<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'crafto-addons' ); ?></span>
				</div>
				<div class="elementor-swiper-button elementor-swiper-button-next">
					<?php if ( ! empty( $next_arrow_icon ) ) {
						echo sprintf( '%s', $next_arrow_icon );  // phpcs:ignore
					}  ?>
					<span class ="elementor-screen-only"><?php echo esc_html__( 'Next', 'crafto-addons' ); ?></span>
				</div>
				<?php
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
