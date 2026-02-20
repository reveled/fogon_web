<?php
namespace CraftoAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Crafto widget for vertical portfolio.
 *
 * @package Crafto
 * @since   1.0
 */

// If class `Vertical_Portfolio` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Vertical_Portfolio' ) ) {
	/**
	 * Define `Vertical_Portfolio` class.
	 */
	class Vertical_Portfolio extends Widget_Base {
		/**
		 * Retrieve the list of scripts the vertical portfolio widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$vertical_portfolio_scripts = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$vertical_portfolio_scripts[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$vertical_portfolio_scripts[] = 'swiper';

					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$vertical_portfolio_scripts[] = 'crafto-magic-cursor';
					}
				}

				if ( '0' === $crafto_disable_all_animation ) {
					if ( crafto_disable_module_by_key( 'appear' ) ) {
						$vertical_portfolio_scripts[] = 'appear';
					}

					if ( crafto_disable_module_by_key( 'anime' ) ) {
						$vertical_portfolio_scripts[] = 'anime';
						$vertical_portfolio_scripts[] = 'splitting';
						$vertical_portfolio_scripts[] = 'crafto-fancy-text-effect';
					}
				}
				$vertical_portfolio_scripts[] = 'crafto-vertical-portfolio-carousel';
			}

			return $vertical_portfolio_scripts;
		}

		/**
		 * Retrieve the list of styles the vertical portfolio widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$vertical_portfolio_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$vertical_portfolio_styles[] = 'crafto-widgets-rtl';
				} else {
					$vertical_portfolio_styles[] = 'crafto-widgets';
				}
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$vertical_portfolio_styles[] = 'swiper';
					$vertical_portfolio_styles[] = 'nav-pagination';

					if ( is_rtl() ) {
						$vertical_portfolio_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$vertical_portfolio_styles[] = 'crafto-magic-cursor';
					}
				}

				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					$vertical_portfolio_styles[] = 'splitting';
				}

				if ( is_rtl() ) {
					$vertical_portfolio_styles[] = 'crafto-vertical-portfolio-rtl';
				}
				$vertical_portfolio_styles[] = 'crafto-vertical-portfolio-widget';
			}
			return $vertical_portfolio_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-vertical-portfolio';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Vertical Portfolio', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-slider-vertical crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/vertical-portfolio/';
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
				'Portfolio',
				'photography',
				'vertical',
				'project',
				'carousel',
				'work',
				'case studies',
			];
		}

		/**
		 * Register vertical portfolio widget controls.
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
				'crafto_portfolio_post_per_page',
				[
					'label'   => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => 5,
				]
			);
			$this->add_control(
				'crafto_vertical_portfolio_offset',
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
				'crafto_portfolio_show_marquees_text',
				[
					'label'        => esc_html__( 'Enable Marquees Text', 'crafto-addons' ),
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
				'crafto_thumbnail',
				[
					'label'          => esc_html__( 'Image Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'full',
					'options'        => function_exists( 'crafto_get_thumbnail_image_sizes' ) ? crafto_get_thumbnail_image_sizes() : [],
					'style_transfer' => true,
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
			$this->add_control(
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
				]
			);
			$this->add_control(
				'crafto_full_screen',
				[
					'label'        => esc_html__( 'Enable Full Screen Slider', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
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
				'crafto_vertical_portfolio_fancy_text_animation',
				[
					'label' => esc_html__( 'Effects', 'crafto-addons' ),
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
					'label'       => esc_html__( 'Effect', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'wave',
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_ease',
				[
					'label'       => esc_html__( 'Easing', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'easeOutQuad',
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_colors',
				[
					'label'       => esc_html__( 'Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'default'     => '#ffe400',
					'condition'   => [
						'crafto_title_data_fancy_text_settings_effect' => 'slide',
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_start_delay',
				[
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_speed',
				[
					'label'       => esc_html__( 'Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_opacity',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'         => esc_html__( 'Start', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
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
					],'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_xy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition' => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
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
					'label'         => esc_html__( 'Start', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
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
					],'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_yy',
				[
					'label'         => esc_html__( 'End', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
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
					'separator'     => 'after',
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_rotate',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_filter',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::DIMENSIONS,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_clippath',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::DIMENSIONS,
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
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_vertical_portfolio_entrance_animation',
				[
					'label' => esc_html__( 'Entrance Animation', 'crafto-addons' ),
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
					'label'       => esc_html__( 'Easing', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'easeOutQuad',
					'options'     => [
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_stagger',
				[
					'label'       => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_xy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_yy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_title_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_translate_zy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_y_opacity',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_xy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_yy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'separator'   => 'after',
					'condition'  => [
						'crafto_title_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_rotation_zy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_perspective_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
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
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_ent_anim_opt_scale_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
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
					'render_type' => 'none',
				]
			);
			$this->end_popover();
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
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_content_max_width',
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
						'{{WRAPPER}} .slider-text-middle-main' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_vertical_portfolio_title_style',
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
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .content-wrap .title',
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-wrap .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_title_text_shadow',
					'selector' => '{{WRAPPER}} .content-wrap .title span',
				]
			);
			$this->add_responsive_control(
				'crafto_arrows_right_position',
				[
					'label'      => esc_html__( 'Set Offset', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
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
					],
					'selectors'  => [
						'{{WRAPPER}} .content-wrap .title' => 'right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .content-wrap .title' => 'left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_vertical_portfolio_subtitle_style',
				[
					'label'      => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_show_post_subtitle' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_subtitle_vertical_position',
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
						'{{WRAPPER}} .subtitle-wrap' => 'align-items: {{VALUE}};',
					],
					'default'   => 'center',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_subtitle_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .subtitle-wrap .subtitle',
				]
			);
			$this->add_control(
				'crafto_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .subtitle-wrap .subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_vertical_portfolio_number_style',
				[
					'label'      => esc_html__( 'Number', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .number-wrap',
				]
			);
			$this->add_control(
				'crafto_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .number-wrap' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_separater_heading',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_separater_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .number-wrap span' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_separater_width',
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
							'max' => 100,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .number-wrap span' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_separater_height',
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
							'max' => 10,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .number-wrap span' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_separator_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .vertical-portfolio-slider .portfolio-item .number-wrap span' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .vertical-portfolio-slider .portfolio-item .number-wrap span' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_vertical_portfolio_marquees_text_style',
				[
					'label'      => esc_html__( 'Marquees Text', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_show_marquees_text' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_marquees_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .marquees-text span',
				]
			);
			$this->add_control(
				'crafto_marquees_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .marquees-text span' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-prev i, {{WRAPPER}} .swiper .elementor-swiper-button.elementor-swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-widget-container .elementor-swiper-button.elementor-swiper-button-prev svg, {{WRAPPER}} .elementor-widget-container .elementor-swiper-button.elementor-swiper-button-next svg, {{WRAPPER}} .elementor-widget-container .elementor-swiper-button.elementor-swiper-button-next svg' => 'width: {{SIZE}}{{UNIT}}; height: auto',
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
						'{{WRAPPER}} .swiper-pagination-vertical.swiper-pagination-bullets, {{WRAPPER}}.pagination-vertical-right .number-style-3 .swiper-pagination-wrapper, {{WRAPPER}} .number-style-3 .swiper-pagination-wrapper' => 'right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.pagination-vertical-left .swiper .swiper-pagination, {{WRAPPER}}.pagination-vertical-left .number-style-3 .swiper-pagination-wrapper' => 'left: {{SIZE}}{{UNIT}}',
						'.rtl {{WRAPPER}} .swiper-rtl.vertical-portfolio-slider .swiper-pagination-vertical.swiper-pagination-bullets, .rtl {{WRAPPER}} .swiper-rtl.number-style-3 .swiper-pagination-wrapper' => 'left: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'crafto_pagination'    => 'yes',
						'crafto_dots_position' => 'inside',
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
							'max' => 25,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .swiper-pagination-vertical .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-left .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet, {{WRAPPER}}.pagination-direction-vertical.pagination-vertical-right .number-style-2 .swiper-pagination.swiper-numbers .swiper-pagination-bullet' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
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
		 * Render vertical portfolio widget output on the frontend.
		 *
		 * @param array $instance widget Id.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render( $instance = [] ) {
			$settings                               = $this->get_settings_for_display();
			$portfolio_type_selection               = ( isset( $settings['crafto_portfolio_type_selection'] ) && $settings['crafto_portfolio_type_selection'] ) ? $settings['crafto_portfolio_type_selection'] : 'portfolio-category';
			$portfolio_categories_list              = ( isset( $settings['crafto_portfolio_categories_list'] ) && $settings['crafto_portfolio_categories_list'] ) ? $settings['crafto_portfolio_categories_list'] : [];
			$portfolio_tags_list                    = ( isset( $settings['crafto_portfolio_tags_list'] ) && $settings['crafto_portfolio_tags_list'] ) ? $settings['crafto_portfolio_tags_list'] : [];
			$portfolio_post_per_page                = ( isset( $settings['crafto_portfolio_post_per_page'] ) && $settings['crafto_portfolio_post_per_page'] ) ? $settings['crafto_portfolio_post_per_page'] : 5;
			$crafto_vertical_portfolio_offset       = ( isset( $settings['crafto_vertical_portfolio_offset'] ) && $settings['crafto_vertical_portfolio_offset'] ) ? $settings['crafto_vertical_portfolio_offset'] : '';
			$portfolio_show_post_title              = ( isset( $settings['crafto_portfolio_show_post_title'] ) && $settings['crafto_portfolio_show_post_title'] ) ? $settings['crafto_portfolio_show_post_title'] : '';
			$crafto_portfolio_show_marquees_text    = ( isset( $settings['crafto_portfolio_show_marquees_text'] ) && $settings['crafto_portfolio_show_marquees_text'] ) ? $settings['crafto_portfolio_show_marquees_text'] : '';
			$portfolio_show_post_subtitle           = ( isset( $settings['crafto_portfolio_show_post_subtitle'] ) && $settings['crafto_portfolio_show_post_subtitle'] ) ? $settings['crafto_portfolio_show_post_subtitle'] : '';
			$portfolio_orderby                      = ( isset( $settings['crafto_portfolio_orderby'] ) && $settings['crafto_portfolio_orderby'] ) ? $settings['crafto_portfolio_orderby'] : '';
			$portfolio_order                        = ( isset( $settings['crafto_portfolio_order'] ) && $settings['crafto_portfolio_order'] ) ? $settings['crafto_portfolio_order'] : '';
			$crafto_parallax                        = $this->get_settings( 'crafto_parallax' );
			$crafto_slide_parallax_amount           = $this->get_settings( 'crafto_slide_parallax_amount' );
			$crafto_slide_parallax_container_amount = $this->get_settings( 'crafto_slide_parallax_container_amount' );

			if ( 'portfolio-tags' === $portfolio_type_selection ) {
				$categories_to_display_ids = ! empty( $portfolio_tags_list ) ? $portfolio_tags_list : [];
			} else {
				$categories_to_display_ids = ! empty( $portfolio_categories_list ) ? $portfolio_categories_list : [];
			}

			// If no categories are chosen or "All categories", we need to load all available categories.
			if ( ! is_array( $categories_to_display_ids ) || 0 === count( $categories_to_display_ids ) ) {
				$terms = get_terms( $portfolio_type_selection );
				if ( ! is_array( $categories_to_display_ids ) ) {
					$categories_to_display_ids = [];
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

			if ( ! empty( $crafto_vertical_portfolio_offset ) ) {
				$query_args['offset'] = $crafto_vertical_portfolio_offset;
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
			$crafto_direction               = 'vertical';
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
			$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
			$crafto_navigation_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
			$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
			$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
			$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
			$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );

			$slider_config = array(
				'navigation'       => $crafto_navigation,
				'pagination'       => $crafto_pagination,
				'pagination_style' => $crafto_pagination_style,
				'number_style'     => $crafto_pagination_number_style,
				'autoplay'         => $this->get_settings( 'crafto_autoplay' ),
				'parallax'         => $this->get_settings( 'crafto_parallax' ),
				'autoplay_speed'   => $this->get_settings( 'crafto_autoplay_speed' ),
				'pause_on_hover'   => $this->get_settings( 'crafto_pause_on_hover' ),
				'loop'             => $this->get_settings( 'crafto_infinite' ),
				'effect'           => $this->get_settings( 'crafto_effect' ),
				'speed'            => $this->get_settings( 'crafto_speed' ),
				'image_spacing'    => $this->get_settings( 'crafto_items_spacing' ),
				'mousewheel'       => $this->get_settings( 'crafto_mousewheel' ),
				'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
				'direction'        => 'vertical',
			);

			$slider_viewport = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
			$sliderconfig    = array_merge( $slider_config, $slider_viewport );
			$crafto_effect   = $this->get_settings( 'crafto_effect' );

			$effect = [
				'fade',
			];

			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}

			if ( '1' === $this->get_settings( 'crafto_slides_to_show' )['size'] && in_array( $crafto_effect, $effect, true ) ) {
				$sliderconfig['effect'] = $crafto_effect;
			}

			$crafto_full_screen = '';
			if ( 'yes' === $this->get_settings( 'crafto_full_screen' ) ) {
				$crafto_full_screen = 'full-screen-slide';
			}

			$this->add_render_attribute(
				[
					'carousel-wrapper' =>
					[
						'class'         => [
							'vertical-portfolio-slider',
							'swiper',
							$crafto_full_screen,
							$crafto_slider_cursor,
							$magic_cursor,
							$crafto_direction,
						],
						'data-settings' => wp_json_encode( $sliderconfig ),
					],
					'carousel'         => [
						'class' => 'swiper-wrapper',
					],
				],
			);

			if ( 'vertical' === $crafto_direction ) {
				$this->add_render_attribute(
					[
						'carousel-wrapper' => [
							'class' =>
							[
								'slider-vertical',
								'pagination-direction-vertical',
							],
						],
					],
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

			$vertical_portfolio_anim = $this->render_anime_animation( $this, 'title' );
			
			if ( ! empty( $vertical_portfolio_anim ) && '[]' !== $vertical_portfolio_anim ) {
				$this->add_render_attribute(
					'subtitle_anime',
					[
						'class'      => 'has-anime-effect',
						'data-anime' => $vertical_portfolio_anim,
					],
				);
			}

			$this->add_render_attribute(
				'subtitle_anime',
				[
					'class' => 'subtitle',
				],
			);

			if ( $portfolio_query->have_posts() ) {
				?>
				<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
					<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
						<?php
						$index        = 0;
						$count_number = 1;
						while ( $portfolio_query->have_posts() ) :
							$portfolio_query->the_post();

							$inner_wrap_key    = 'inner_wrap_' . $index;
							$fancy_title       = 'fancy_title_' . $index;
							$crafto_subtitle   = crafto_post_meta( 'crafto_subtitle' );
							$count_number_text = ( $count_number < 10 ) ? '0' . $count_number : $count_number;
							$crafto_subtitle   = ( $crafto_subtitle ) ? str_replace( '||', '<br />', $crafto_subtitle ) : '';
							
							$vertical_portfolio_fancy_text = $this->render_fancy_text_animation( $this, 'title' );

							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class' => [
										'vertical-portfolio-item',
										'swiper-slide',
									],
								],
							);

							if ( ! empty( $vertical_portfolio_fancy_text ) ) {
								$fancy_text_animation        = wp_json_encode( $vertical_portfolio_fancy_text );
								$fancy_text_values['string'] = [ get_the_title() ];
								$data_fancy_text             = ! empty( $fancy_text_values ) ? wp_json_encode( $fancy_text_values ) : '';
								$title_fancy_text            = wp_json_encode( array_merge( json_decode( $data_fancy_text, true ), json_decode( $fancy_text_animation, true ) ) );
							}

							if ( ! empty( $title_fancy_text ) ) {
								$this->add_render_attribute(
									$fancy_title,
									[
										'class'           => 'slide-text-rotator slider-title',
										'data-fancy-text' => $title_fancy_text,
									],
								);
							}

							?>
							<div <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
								<?php
								if ( 'yes' === $crafto_parallax ) {
									echo '<div ' . $this->get_render_attribute_string( 'slider-parallax' ) . '>'; // phpcs:ignore
								}
								?>
								<div <?php $this->print_render_attribute_string( 'slider-text-middle' ); ?>>
									<div class="row h-100 position-relative">
										<div class="col-lg-10 col-md-11 portfolio-item">
											<div class="content-wrap">
												<?php
												if ( 'yes' === $portfolio_show_post_subtitle ) {
													?>
													<div class="subtitle-main-wrap">
														<div class="subtitle-wrap">
															<div <?php $this->print_render_attribute_string( 'subtitle_anime' ); ?>>
																<span><?php echo esc_html( $crafto_subtitle ); ?></span>
															</div>
														</div>
													</div>
													<?php
												}
												?>
												<div class="number-wrap"><span></span> <?php echo esc_html( $count_number_text ); ?></div>
												<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
												<?php
												if ( 'yes' === $portfolio_show_post_title ) {
													?>
													<div class="title">
														<span <?php $this->print_render_attribute_string( $fancy_title ); ?>><?php the_title(); ?></span>
													</div>
													<?php
												}
												?>
											</div>
										</div>
									</div>
									<!-- start marquees -->
									<?php
									if ( 'yes' === $crafto_portfolio_show_marquees_text ) {
										?>
										<div class="marquees-text"><span><?php the_title(); ?></span></div> 
										<?php
									}
									?>
									<!-- end marquees -->
								</div>
								<?php
								if ( 'yes' === $crafto_parallax ) {
									echo '</div>';
								}
								?>
							</div>
							<?php
							++$index;
							++$count_number;
						endwhile;
						wp_reset_postdata();
						?>
					</div>
					<?php
					if ( 1 < $slides_count ) {
						get_swiper_pagination( $settings ); // phpcs:ignore
					}
					?>
				</div>
				<?php
			}
		}

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
