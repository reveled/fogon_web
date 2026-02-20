<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_archive_tours_template() ) {
	return;
}

/**
 * Crafto widget for Archive tours.
 *
 * @package Crafto
 */

// If class `Tour_Archive` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Tour_Archive' ) ) {
	/**
	 * Define `Tour_Archive` class.
	 */
	class Tour_Archive extends Widget_Base {
		/**
		 * Retrieve the list of scripts the tour archive widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$tours_archive_scripts        = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$tours_archive_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$tours_archive_scripts[] = 'imagesloaded';
				}
				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$tours_archive_scripts[] = 'isotope';
				}
				if ( crafto_disable_module_by_key( 'infinite-scroll' ) ) {
					$tours_archive_scripts[] = 'infinite-scroll';
				}
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$tours_archive_scripts[] = 'swiper';
					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$tours_archive_scripts[] = 'crafto-magic-cursor';
					}
				}
				$tours_archive_scripts[] = 'crafto-default-carousel';
				$tours_archive_scripts[] = 'crafto-tour-widget';
			}
			return $tours_archive_scripts;
		}

		/**
		 * Retrieve the list of styles the tour archive widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$tours_archive_styles         = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$tours_archive_styles[] = 'crafto-widgets-rtl';
				} else {
					$tours_archive_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$tours_archive_styles[] = 'swiper';
					$tours_archive_styles[] = 'nav-pagination';

					if ( is_rtl() ) {
						$tours_archive_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$tours_archive_styles[] = 'crafto-magic-cursor';
					}
				}

				if ( is_rtl() ) {
					$tours_archive_styles[] = 'crafto-star-rating-rtl';
					$tours_archive_styles[] = 'crafto-tour-rtl-widget';
				}
				$tours_archive_styles[] = 'crafto-star-rating';
				$tours_archive_styles[] = 'crafto-tours-widget';
			}
			return $tours_archive_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve tour archive widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-archive-tours';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve tour archive widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Tour Archive', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve tour archive widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-info-box crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/tour-archive/';
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
				'crafto-archive',
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
				'tour',
				'grid',
				'list',
				'term',
				'taxonomy',
				'category',
				'travel archive',
				'trip list',
			];
		}

		/**
		 * Register tour archive widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_tours_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tours_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'tours-grid',
					'options'            => [
						'tours-grid'   => esc_html__( 'Grid', 'crafto-addons' ),
						'tours-slider' => esc_html__( 'Slider', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->add_responsive_control(
				'crafto_column_settings',
				[
					'label'     => esc_html__( 'Number of Columns', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 3,
					],
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 6,
							'step' => 1,
						],
					],
					'condition' => [
						'crafto_tours_style' => 'tours-grid',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tours_columns_gap',
				[
					'label'      => esc_html__( 'Columns Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 15,
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} ul li.grid-gutter' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.grid'           => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tours_style' => 'tours-grid',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_tours_bottom_spacing',
				[
					'label'      => esc_html__( 'Bottom Gap', 'crafto-addons' ),
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
						'{{WRAPPER}} ul li.grid-gutter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tours_style' => 'tours-grid',
					],
				]
			);
			$this->add_control(
				'crafto_tour_archive_offset',
				[
					'label'   => esc_html__( 'Offset', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [
						'active' => true,
					],
					'default' => '',
				]
			);
			$this->add_control(
				'crafto_enable_masonry',
				[
					'label'        => esc_html__( 'Enable Masonry Layout', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_tours_extra_option',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tours_show_thumbnail',
				[
					'label'        => esc_html__( 'Enable Thumbnail', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_tours_thumbnail',
				[
					'label'          => esc_html__( 'Image Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'full',
					'options'        => function_exists( 'crafto_get_thumbnail_image_sizes' ) ? crafto_get_thumbnail_image_sizes() : [],
					'style_transfer' => true,
					'condition'      => [
						'crafto_tours_show_thumbnail' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_show_title',
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
				'crafto_tours_show_excerpt',
				[
					'label'        => esc_html__( 'Enable Excerpt', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_tours_style' => 'tours-grid',
					],
				]
			);
			$this->add_control(
				'crafto_tours_excerpt_length',
				[
					'label'     => esc_html__( 'Excerpt Length', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'min'       => 1,
					'default'   => 9,
					'condition' => [
						'crafto_tours_show_excerpt' => 'yes',
						'crafto_tours_style'        => 'tours-grid',
					],
				]
			);
			$this->add_control(
				'crafto_show_tours_days',
				[
					'label'        => esc_html__( 'Enable Days', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_tours_show_price',
				[
					'label'        => esc_html__( 'Enable Price', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_tours_show_discount_price',
				[
					'label'        => esc_html__( 'Enable Discount Price', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_tours_show_destination',
				[
					'label'        => esc_html__( 'Enable Destination', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_tours_style' => 'tours-grid',
					],
				]
			);
			$this->add_control(
				'crafto_tours_show_review',
				[
					'label'        => esc_html__( 'Enable Review', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_pagination',
				[
					'label'      => esc_html__( 'Pagination', 'crafto-addons' ),
					'show_label' => false,
					'condition'  => [
						'crafto_tours_style' => 'tours-grid',
					],
				]
			);
			$this->add_control(
				'crafto_pagination',
				[
					'label'   => esc_html__( 'Pagination', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''                           => esc_html__( 'None', 'crafto-addons' ),
						'number-pagination'          => esc_html__( 'Number', 'crafto-addons' ),
						'next-prev-pagination'       => esc_html__( 'Next / Previous', 'crafto-addons' ),
						'infinite-scroll-pagination' => esc_html__( 'Infinite Scroll', 'crafto-addons' ),
						'load-more-pagination'       => esc_html__( 'Load More', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_pagination_next_label',
				[
					'label'     => esc_html__( 'Next Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'NEXT', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_next_icon',
				[
					'label'                  => esc_html__( 'Next Icon', 'crafto-addons' ),
					'type'                   => Controls_Manager::ICONS,
					'fa4compatibility'       => 'icon',
					'default'                => [
						'value'   => 'feather icon-feather-arrow-right',
						'library' => 'feather-solid',
					],
					'recommended'            => [
						'fa-solid'   => [
							'angle-right',
							'caret-square-right',
						],
						'fa-regular' => [
							'caret-square-right',
						],
					],
					'skin'                   => 'inline',
					'exclude_inline_options' => 'svg',
					'label_block'            => false,
					'condition'              => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_prev_label',
				[
					'label'     => esc_html__( 'Previous Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'PREV', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_prev_icon',
				[
					'label'                  => esc_html__( 'Previous Icon', 'crafto-addons' ),
					'type'                   => Controls_Manager::ICONS,
					'fa4compatibility'       => 'icon',
					'default'                => [
						'value'   => 'feather icon-feather-arrow-left',
						'library' => 'feather-solid',
					],
					'recommended'            => [
						'fa-solid'   => [
							'angle-left',
							'caret-square-left',
						],
						'fa-regular' => [
							'caret-square-left',
						],
					],
					'skin'                   => 'inline',
					'exclude_inline_options' => 'svg',
					'label_block'            => false,
					'condition'              => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->add_control(
				'crafto_pagination_load_more_button_label',
				[
					'label'       => esc_html__( 'Button Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Load more', 'crafto-addons' ),
					'render_type' => 'template',
					'condition'   => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_tours_slider_config',
				[
					'label'     => esc_html__( 'Slider Settings', 'crafto-addons' ),
					'condition' => [
						'crafto_tours_style' => 'tours-slider',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_slides_to_show',
				[
					'label'     => esc_html__( 'Slides Per View', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 2,
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
					'label'      => esc_html__( 'Item Spacing', 'crafto-addons' ),
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
					'default'      => 'yes',
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
					'label'     => esc_html__( 'Navigation', 'crafto-addons' ),
					'condition' => [
						'crafto_tours_style' => 'tours-slider',
					],
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
					'label'     => esc_html__( 'Pagination', 'crafto-addons' ),
					'condition' => [
						'crafto_tours_style' => 'tours-slider',
					],
				]
			);
			$this->add_control(
				'crafto_slider_pagination',
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
						'crafto_slider_pagination' => 'yes',
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
						'crafto_slider_pagination' => 'yes',
						'crafto_pagination_style'  => 'dots',
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
						'crafto_slider_pagination' => 'yes',
						'crafto_pagination_style'  => 'number',
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
						'crafto_slider_pagination' => 'yes',
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
						'crafto_slider_pagination'    => 'yes',
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
						'crafto_slider_pagination'    => 'yes',
						'crafto_pagination_direction' => 'vertical',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_grid_preloader',
				[
					'label' => esc_html__( 'Preloader', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_section_enable_grid_preloader',
				[
					'label'        => esc_html__( 'Enable Preloader', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_section_grid_preloader_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .grid-loading::after' => 'background: {{VALUE}};',
					],
					'condition' => [
						'crafto_section_enable_grid_preloader' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_tours_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_tours_content_box_alignment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
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
				]
			);
			$this->add_control(
				'crafto_tours_content_box_heading',
				[
					'label'     => esc_html__( 'Content Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tours_content_box_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .tours-packages-wrapper .tours-box-content-wrap',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_tours_content_box_shadow',
					'selector' => '{{WRAPPER}} .tours-packages-wrapper .tours-box-content-wrap',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_tours_content_box_border',
					'selector' => '{{WRAPPER}} .tours-packages-wrapper .tours-box-content-wrap',
				]
			);
			$this->add_responsive_control(
				'crafto_tours_content_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .tours-packages-wrapper .tours-box-content-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tours_content_padding',
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
						'{{WRAPPER}} .tours-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tours_thumbnail_style',
				[
					'label'      => esc_html__( 'Tour Thumbnail', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_tours_show_thumbnail' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_tours_image_border',
					'selector' => '{{WRAPPER}} .tours-image img',
				]
			);
			$this->add_responsive_control(
				'crafto_tours_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .tours-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tours_day_style',
				[
					'label'      => esc_html__( 'Tour Days', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_tours_days' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tours_day_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .tours-content-wrapper .tours-day',
				]
			);
			$this->add_control(
				'crafto_tours_day_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tours-content-wrapper .tours-day' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_tours_day_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tours-content-wrapper .tours-day' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tours_day_padding',
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
						'{{WRAPPER}} .tours-content-wrapper .tours-day' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tours_price_style',
				[
					'label'      => esc_html__( 'Tour Price', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_tours_show_price',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_tours_show_discount_price',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_tours_just_text_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .price-wrap .text-label',
					'condition' => [
						'crafto_tours_show_price' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_just_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .price-wrap .text-label' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_tours_show_price' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_price_heading',
				[
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tours_show_price' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_tours_price_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .price-wrap .tours-price',
					'condition' => [
						'crafto_tours_show_price' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .price-wrap .tours-price' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_tours_show_price' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_price_separator',
				[
					'type'       => Controls_Manager::DIVIDER,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_tours_show_price',
										'operator' => '!==',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_tours_show_discount_price',
										'operator' => '!==',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_tours_show_price',
										'operator' => '===',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_tours_show_discount_price',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_tours_discount_price_heading',
				[
					'label'     => esc_html__( 'Discount Price', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_tours_show_discount_price' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_tours_discount_price_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .price-wrap .tours-discount-price',
					'condition' => [
						'crafto_tours_show_discount_price' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_discount_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .price-wrap .tours-discount-price' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_tours_show_discount_price' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tours_discount_price_margin',
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
						'{{WRAPPER}} .price-wrap .tours-discount-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tours_show_discount_price' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_discount_price_separator_heading',
				[
					'label'     => esc_html__( 'Strikethrough', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tours_show_discount_price' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_discount_price_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .price-wrap .discount-price-separator' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_tours_show_discount_price' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_separator_height',
				[
					'label'      => esc_html__( 'Separator Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 5,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .price-wrap .discount-price-separator' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tours_show_discount_price' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tours_title_style',
				[
					'label'      => esc_html__( 'Tour Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_tours_show_title' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tours_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .tours-content-wrapper .tours-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_tours_title_tabs',
			);
			$this->start_controls_tab(
				'crafto_tours_title_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tours_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tours-content-wrapper .tours-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tours_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tours_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tours-content-wrapper a:hover .tours-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_tours_title_margin',
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
						'{{WRAPPER}} .tours-content-wrapper .tours-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tours_content_style',
				[
					'label'      => esc_html__( 'Tour Content', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_tours_show_excerpt' => 'yes',
						'crafto_tours_style'        => 'tours-grid',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tours_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .entry-content',
				]
			);
			$this->add_control(
				'crafto_tours_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .entry-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tours_content_width',
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
						'size' => 95,
					],
					'selectors'  => [
						'{{WRAPPER}} .entry-content' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tours_content_margin',
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
						'{{WRAPPER}} .entry-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tours_destination_style',
				[
					'label'      => esc_html__( 'Tour Destination', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_tours_show_destination' => 'yes',
						'crafto_tours_style'            => 'tours-grid',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tours_destination_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .destination-review-wrap .destinations',
				]
			);
			$this->start_controls_tabs(
				'crafto_tours_destination_tabs',
			);
			$this->start_controls_tab(
				'crafto_tours_destination_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tours_destination_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .destination-review-wrap .destinations a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tours_destination_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tours_destination_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .destination-review-wrap .destinations:hover a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_tours_destination_margin',
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
						'{{WRAPPER}} .destinations i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tours_review_style',
				[
					'label'      => esc_html__( 'Tour Review', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_tours_show_review' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tours_star_rating_heading',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_tours_star_rating_icon_size',
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
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-star-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_tours_reviews_heading',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tours_reviews_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .tours-reviews',
				]
			);
			$this->add_control(
				'crafto_tours_reviews_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tours-reviews' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_pagination_style',
				[
					'label'      => esc_html__( 'Pagination', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'conditions' => [
						'relation'            => 'or',
						'terms'               => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_pagination',
										'operator' => '===',
										'value'    => 'number-pagination',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_pagination',
										'operator' => '===',
										'value'    => 'next-prev-pagination',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_pagination',
										'operator' => '===',
										'value'    => 'load-more-pagination',
									],
								],
							],
						],
						'crafto_tours_style!' => 'tours-slider',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pagination_alignment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => 'center',
					'options'     => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors'   => [
						'{{WRAPPER}} .crafto-pagination' => 'display: flex; justify-content: {{VALUE}};',
					],
					'condition'   => [
						'crafto_pagination' => 'number-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_pagination_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .page-numbers li .page-numbers, {{WRAPPER}} .new-post a , {{WRAPPER}} .old-post a',
					'condition' => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_pagination_tabs',
			);
				$this->start_controls_tab(
					'crafto_pagination_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					]
				);
				$this->add_control(
					'crafto_pagination_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers , {{WRAPPER}} .new-post a , {{WRAPPER}} .old-post a' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_pagination_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					],
				);
				$this->add_control(
					'crafto_pagination_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers:hover, {{WRAPPER}} .new-post a:hover , {{WRAPPER}} .old-post a:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
								'next-prev-pagination',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_pagination_bg_hover_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-pagination .page-numbers li a.next:hover, {{WRAPPER}} .crafto-pagination .page-numbers li a.prev:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => [
								'number-pagination',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_pagination_bg_hover_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers:hover, {{WRAPPER}} .new-post a:hover , {{WRAPPER}} .old-post a:hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_pagination_active_tab',
					[
						'label'     => esc_html__( 'Active', 'crafto-addons' ),
						'condition' => [
							'crafto_pagination' => 'number-pagination',
						],
					],
				);
				$this->add_control(
					'crafto_pagination_active_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .page-numbers li .page-numbers.current' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_pagination' => 'number-pagination',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_pagination_bg_active_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-pagination .page-numbers li .page-numbers.current' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_pagination_border',
					'selector'  => '{{WRAPPER}} .post-pagination, {{WRAPPER}} .crafto-pagination',
					'condition' => [
						'crafto_pagination' => 'next-prev-pagination',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pagination_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .page-numbers li a i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'number-pagination',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_pagination_space',
				[
					'label'      => esc_html__( 'Space Between', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .page-numbers li' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .page-numbers li' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'number-pagination',
					],
				],
			);
			$this->add_responsive_control(
				'crafto_pagination_margin',
				[
					'label'      => esc_html__( 'Top Space', 'crafto-addons' ),
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
						'{{WRAPPER}} .crafto-pagination, {{WRAPPER}} .post-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => [
							'number-pagination',
							'next-prev-pagination',
						],
					],
				]
			);

			// load more button style.
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				],
			);
			$this->start_controls_tabs( 'crafto_tabs_button_style' );
			$this->start_controls_tab(
				'crafto_tab_button_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_control(
				'crafto_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_background_color',
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
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tab_button_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_control(
				'crafto_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-pagination .view-more-button:hover, {{WRAPPER}} .post-pagination .view-more-button:focus'         => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_button_background_hover_color',
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
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button:hover, {{WRAPPER}} .post-pagination .view-more-button:focus',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);

			$this->add_control(
				'crafto_button_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-pagination .view-more-button:hover, {{WRAPPER}} .post-pagination .view-more-button:focus' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				],
			);
			$this->add_control(
				'crafto_load_more_button_hover_transition',
				[
					'label'       => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'transition-duration: {{SIZE}}s',
					],
					'condition'   => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_border',
					'selector'       => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition'      => [
						'crafto_pagination' => 'load-more-pagination',
					],
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_button_box_shadow',
					'selector'  => '{{WRAPPER}} .post-pagination .view-more-button',
					'condition' => [
						'crafto_pagination' => 'load-more-pagination',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_text_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'em',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .post-pagination .view-more-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_pagination' => 'load-more-pagination',
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
						'crafto_tours_style' => 'tours-slider',
						'crafto_navigation'  => 'yes',
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
						'crafto_tours_style'       => 'tours-slider',
						'crafto_slider_pagination' => 'yes',
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
						'crafto_slider_pagination' => 'yes',
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
						'crafto_slider_pagination'    => 'yes',
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
						'crafto_slider_pagination'    => 'yes',
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
						'crafto_slider_pagination'        => 'yes',
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
						'crafto_slider_pagination'        => 'yes',
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
						'crafto_slider_pagination' => 'yes',
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
						'crafto_slider_pagination' => 'yes',
						'crafto_pagination_style'  => 'number',
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
						'crafto_slider_pagination' => 'yes',
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
						'crafto_slider_pagination'       => 'yes',
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
						'crafto_slider_pagination' => 'yes',
						'crafto_pagination_style'  => 'number',

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
						'crafto_slider_pagination'      => 'yes',
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
						'crafto_slider_pagination'       => 'yes',
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
						'crafto_slider_pagination' => 'yes',
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
						'crafto_slider_pagination'       => 'yes',
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
						'crafto_slider_pagination'        => 'yes',
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
						'crafto_slider_pagination'        => 'yes',
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
						'crafto_slider_pagination'       => 'yes',
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
						'crafto_slider_pagination'     => 'yes',
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
						'crafto_slider_pagination'        => 'yes',
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
		 * Render tour archive widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			global $crafto_tour_unique_id;
			$settings                   = $this->get_settings_for_display();
			$crafto_tour_archive_offset = $this->get_settings( 'crafto_tour_archive_offset' );

			$crafto_enable_masonry              = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';
			$tours_style                        = ( isset( $settings['crafto_tours_style'] ) && $settings['crafto_tours_style'] ) ? $settings['crafto_tours_style'] : '';
			$crafto_tours_show_excerpt          = ( isset( $settings['crafto_tours_show_excerpt'] ) && $settings['crafto_tours_show_excerpt'] ) ? $settings['crafto_tours_show_excerpt'] : '';
			$crafto_tours_excerpt_length        = ( isset( $settings['crafto_tours_excerpt_length'] ) && $settings['crafto_tours_excerpt_length'] ) ? $settings['crafto_tours_excerpt_length'] : '';
			$crafto_show_tours_days             = ( isset( $settings['crafto_show_tours_days'] ) && $settings['crafto_show_tours_days'] ) ? $settings['crafto_show_tours_days'] : '';
			$crafto_tours_show_price            = ( isset( $settings['crafto_tours_show_price'] ) && $settings['crafto_tours_show_price'] ) ? $settings['crafto_tours_show_price'] : '';
			$crafto_tours_show_discount_price   = ( isset( $settings['crafto_tours_show_discount_price'] ) && $settings['crafto_tours_show_discount_price'] ) ? $settings['crafto_tours_show_discount_price'] : '';
			$crafto_tours_show_title            = ( isset( $settings['crafto_tours_show_title'] ) && $settings['crafto_tours_show_title'] ) ? $settings['crafto_tours_show_title'] : '';
			$crafto_tours_show_destination      = ( isset( $settings['crafto_tours_show_destination'] ) && $settings['crafto_tours_show_destination'] ) ? $settings['crafto_tours_show_destination'] : '';
			$crafto_tours_show_thumbnail        = ( isset( $settings['crafto_tours_show_thumbnail'] ) && $settings['crafto_tours_show_thumbnail'] ) ? $settings['crafto_tours_show_thumbnail'] : '';
			$crafto_tours_show_review           = ( isset( $settings['crafto_tours_show_review'] ) && $settings['crafto_tours_show_review'] ) ? $settings['crafto_tours_show_review'] : '';
			$crafto_tours_content_box_alignment = ( isset( $settings['crafto_tours_content_box_alignment'] ) && $settings['crafto_tours_content_box_alignment'] ) ? $settings['crafto_tours_content_box_alignment'] : '';
			$crafto_alignment_main_class        = '';

			// pagination.
			$crafto_pagination = ( isset( $settings['crafto_pagination'] ) && $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';

			// Check if tours id and class.
			$crafto_tour_unique_id = ! empty( $crafto_tour_unique_id ) ? $crafto_tour_unique_id : 1;
			$crafto_tour_id        = 'crafto-tour';
			$crafto_tour_id       .= '-' . $crafto_tour_unique_id;
			++$crafto_tour_unique_id;

			/* Column Settings */
			$crafto_column_desktop_column = ! empty( $settings['crafto_column_settings'] ) ? $settings['crafto_column_settings'] : '3';
			$crafto_column_class_list     = '';
			$crafto_column_ratio          = '';

			switch ( $crafto_column_desktop_column ) {
				case '1':
					$crafto_column_ratio = 1;
					break;
				case '2':
					$crafto_column_ratio = 2;
					break;
				case '3':
				default:
					$crafto_column_ratio = 3;
					break;
				case '4':
					$crafto_column_ratio = 4;
					break;
				case '5':
					$crafto_column_ratio = 5;
					break;
				case '6':
					$crafto_column_ratio = 6;
					break;
			}

			$crafto_column_class      = array();
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';
			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );

			// END No. of Column.

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			if ( ! empty( $portfolio_order ) ) {
				$query_args['order'] = $portfolio_order;
			}

			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
				$query_args['post_type'] = 'tours';
			} else {
				if ( is_singular( 'themebuilder' ) ) {
					$query_args['post_type'] = 'tours';
				} else {
					global $wp_query;
					$query_args = $wp_query->query_vars;
				}
			}

			$query_args['paged'] = $paged;

			if ( ! empty( $crafto_tour_archive_offset ) ) {
				$query_args['offset'] = $crafto_tour_archive_offset;
			}

			if ( ! empty( $crafto_exclude_portfolio ) ) {
				$query_args['post__not_in'] = $crafto_exclude_portfolio;
			}

			$the_query = new \WP_Query( $query_args );

			$datasettings = array(
				'pagination_type' => $crafto_pagination,
			);

			$this->add_render_attribute(
				'wrapper',
				[
					'data-uniqueid'      => $crafto_tour_id,
					'class'              => [
						$crafto_tour_id,
						'grid',
						'yes' === $settings['crafto_section_enable_grid_preloader'] ? 'grid-loading' : '',
						$crafto_column_class_list,
						'crafto-tour-list',
						$crafto_pagination,
					],
					'data-tour-settings' => wp_json_encode( $datasettings ),
				]
			);

			if ( 'yes' === $crafto_enable_masonry ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					'grid-masonry'
				);
			} else {
				$this->add_render_attribute(
					'wrapper',
					'class',
					'no-masonry'
				);
			}

			switch ( $crafto_tours_content_box_alignment ) {
				case 'center':
					$crafto_alignment_main_class = 'text-center';
					break;
				case 'right':
					$crafto_alignment_main_class = 'text-end';
					break;
			}

			$this->add_render_attribute(
				'content-wrap',
				[
					'class' => [
						'tours-content-wrapper',
						$crafto_alignment_main_class,
					],
				]
			);

			switch ( $tours_style ) {
				case 'tours-grid':
					if ( $the_query->have_posts() ) {
						?>
						<div class="tours-packages-wrapper">
							<ul <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
								<?php
								$index      = 0;
								$grid_count = 1;

								if ( 0 === $index % $crafto_column_ratio ) {
									$grid_count = 1;
								}
								while ( $the_query->have_posts() ) {
									$the_query->the_post();

									$destination                 = [];
									$crafto_tours_days           = crafto_post_meta( 'crafto_single_tours_days' );
									$crafto_tours_price          = crafto_post_meta( 'crafto_single_tours_price' );
									$crafto_tours_discount_price = crafto_post_meta( 'crafto_single_tours_discount_price' );
									$crafto_tours_review         = crafto_post_meta( 'crafto_single_tours_review' );
									$crafto_tours_star_rating    = crafto_post_meta( 'crafto_single_tours_star_rating' );
									$categories                  = get_the_terms( get_the_ID(), 'tour-destination' );

									if ( ! empty( $categories ) ) {
										foreach ( $categories as $category ) {
											$category_link = get_category_link( $category->term_id );
											$destination[] = '<a rel="category tag" href="' . esc_url( $category_link ) . '"><i class="feather icon-feather-map-pin"></i>' . esc_html( $category->name ) . '</a>';
										}
									}
									$tour_destination = ( is_array( $destination ) && ! empty( $destination ) ) ? implode( ' ', $destination ) : '';

									?>
									<li class="grid-sizer d-none p-0 m-0"></li>
									<li class="grid-item grid-gutter">
										<div class="tours-box-content-wrap">
											<?php
											if ( 'yes' === $crafto_tours_show_thumbnail && has_post_thumbnail() ) {
												$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
												$image_key    = 'image_' . $index;
												$img_alt      = '';
												$img_alt      = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
												if ( empty( $img_alt ) ) {
													$img_alt = esc_attr( get_the_title( $thumbnail_id ) );
												}
												$this->add_render_attribute( $image_key, 'class', 'image-link' );
												$this->add_render_attribute( $image_key, 'aria-label', $img_alt );
												?>
												<div class="tours-image">
													<a href="<?php the_permalink(); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
													<?php
													$post_thumbanail  = '';
													$crafto_thumbnail = ( isset( $settings['crafto_tours_thumbnail'] ) && $settings['crafto_tours_thumbnail'] ) ? $settings['crafto_tours_thumbnail'] : 'full';
													$post_thumbanail = get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail ); // phpcs:ignore
													echo sprintf( '%s', $post_thumbanail ); // phpcs:ignore
													?>
													</a>
												</div>
												<?php
											}
											?>
											<div <?php $this->print_render_attribute_string( 'content-wrap' ); ?>>
												<?php
												if ( 'yes' === $crafto_show_tours_days && ! empty( $crafto_tours_days ) ) {
													?>
													<div class="tours-day"><?php echo $crafto_tours_days; // phpcs:ignore ?></div>
													<?php
												}

												if ( ! empty( $crafto_tours_price ) || ! empty( $crafto_tours_discount_price ) ) {
													?>
													<div class="price-wrap">
														<?php
														if ( 'yes' === $crafto_tours_show_price && ! empty( $crafto_tours_price ) ) {
															?>
															<span class="text-label"><?php echo esc_html__( 'JUST', 'crafto-addons' ); ?></span>
															<span class="tours-price"><?php echo esc_html( $crafto_tours_price ); ?></span>
															<?php
														}
														if ( 'yes' === $crafto_tours_show_discount_price && ! empty( $crafto_tours_discount_price ) ) {
															?>
															<span class="tours-discount-price"><?php echo esc_html( $crafto_tours_discount_price ); ?>
																<span class="discount-price-separator"></span>
															</span>
															<?php
														}
														?>
													</div>
													<?php
												}

												if ( 'yes' === $crafto_tours_show_title ) {
													?>
													<a href="<?php the_permalink(); ?>" class="tours-title"><?php the_title(); ?></a>
													<?php
												}

												if ( 'yes' === $crafto_tours_show_excerpt ) {
													$show_excerpt_grid = ! empty( $crafto_tours_excerpt_length ) ? crafto_get_the_excerpt_theme( $crafto_tours_excerpt_length ) : crafto_get_the_excerpt_theme( 15 );
													if ( ! empty( $show_excerpt_grid ) ) {
														?>
														<p class="entry-content">
															<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
														</p>
														<?php
													}
												}
												if ( 'yes' === $crafto_tours_show_destination || 'yes' === $crafto_tours_show_review ) {
													?>
													<div class="destination-review-wrap">
														<?php
														if ( 'yes' === $crafto_tours_show_destination && ! empty( $tour_destination ) ) {
															?>
															<div class="destinations">
																<?php echo $tour_destination; // phpcs:ignore ?>
															</div>  
															<?php
														}

														if ( 'yes' === $crafto_tours_show_review && ! empty( $crafto_tours_review ) ) {
															?>
															<div class="review-wrap">
																<div class="review-star-icon elementor--star-style-star_bootstrap">
																	<?php
																	$icon           = '';
																	$icon_html      = '';
																	$rating         = (float) $crafto_tours_star_rating > 5 ? 5 : $crafto_tours_star_rating;
																	$floored_rating = ( $rating ) ? (int) $rating : 0;
																	if ( $rating ) {
																		for ( $stars = 1; $stars <= 5; $stars++ ) {
																			if ( $stars <= $floored_rating ) {
																				$icon_html .= '<i class="bi bi-star-fill">' . $icon . '</i>';
																			} else {
																				$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
																			}
																		}
																	}
																	if ( ! empty( $icon_html ) ) {
																		?>
																		<div class="elementor-star-rating">
																			<?php echo sprintf( '%s', $icon_html ); // phpcs:ignore ?>
																		</div>
																		<?php
																	}
																	?>
																</div>
																<span class="tours-reviews">
																	<?php echo esc_html( $crafto_tours_review ); ?>
																</span>
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
									</li>
									<?php
									++$index;
									++$grid_count;
								}
								wp_reset_query(); // phpcs:ignore
								?>
							</ul>
						</div>
						<?php
					}
					crafto_post_pagination( $the_query, $settings );
					break;
				case 'tours-slider':
					if ( $the_query->have_posts() ) {
						$slides = [];
						$index  = 0;

						while ( $the_query->have_posts() ) {
							$the_query->the_post();

							$inner_wrapper_key           = '_inner_wrapper_' . $index;
							$crafto_tours_days           = crafto_post_meta( 'crafto_single_tours_days' );
							$crafto_tours_price          = crafto_post_meta( 'crafto_single_tours_price' );
							$crafto_tours_discount_price = crafto_post_meta( 'crafto_single_tours_discount_price' );
							$crafto_tours_review         = crafto_post_meta( 'crafto_single_tours_review' );
							$crafto_tours_star_rating    = crafto_post_meta( 'crafto_single_tours_star_rating' );

							$this->add_render_attribute(
								$inner_wrapper_key,
								[
									'class' => [
										'elementor-repeater-item-' . get_the_ID(),
										'swiper-slide',
									],
								],
							);

							ob_start();
							?>
							<div <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
								<div class="tours-box-content-wrap">
									<?php
									if ( 'yes' === $crafto_tours_show_thumbnail && has_post_thumbnail() ) {
										$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
										$image_key    = 'image_' . $index;
										$img_alt      = '';
										$img_alt      = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
										if ( empty( $img_alt ) ) {
											$img_alt = esc_attr( get_the_title( $thumbnail_id ) );
										}
										$this->add_render_attribute( $image_key, 'class', 'image-link' );
										$this->add_render_attribute( $image_key, 'aria-label', $img_alt );
										?>
										<div class="tours-image">
											<a href="<?php the_permalink(); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
											<?php
											$post_thumbanail  = '';
											$crafto_thumbnail = ( isset( $settings['crafto_tours_thumbnail'] ) && $settings['crafto_tours_thumbnail'] ) ? $settings['crafto_tours_thumbnail'] : 'full';
											$post_thumbanail = get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail ); // phpcs:ignore
											echo sprintf( '%s', $post_thumbanail ); // phpcs:ignore
											?>
											</a>
										</div>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'content-wrap' ); ?>>
										<?php
										if ( 'yes' === $crafto_show_tours_days && ! empty( $crafto_tours_days ) ) {
											?>
											<div class="tours-day"><?php echo $crafto_tours_days; // phpcs:ignore ?></div>
											<?php
										}
										if ( ! empty( $crafto_tours_price ) || ! empty( $crafto_tours_discount_price ) ) {
											?>
											<div class="price-wrap">
												<?php
												if ( 'yes' === $crafto_tours_show_price && ! empty( $crafto_tours_price ) ) {
													?>
													<span class="text-label"><?php echo esc_html__( 'JUST', 'crafto-addons' ); ?></span>
													<span class="tours-price"><?php echo esc_html( $crafto_tours_price ); ?></span>  
													<?php
												}
												if ( 'yes' === $crafto_tours_show_discount_price && ! empty( $crafto_tours_discount_price ) ) {
													?>
													<span class="tours-discount-price"><?php echo esc_html( $crafto_tours_discount_price ); ?>
														<span class="discount-price-separator"></span>
													</span>
													<?php
												}
												?>
											</div>
											<?php
										}
										if ( 'yes' === $crafto_tours_show_title ) {
											?>
											<a href="<?php the_permalink(); ?>" class="tours-title"><?php the_title(); ?></a>
											<?php
										}
										if ( 'yes' === $crafto_tours_show_review && ! empty( $crafto_tours_review ) ) {
											?>
											<div class="destination-review-wrap">
												<?php
												if ( 'yes' === $crafto_tours_show_destination && ! empty( $tour_destination ) ) {
													?>
													<div class="destinations">
														<?php echo $tour_destination; // phpcs:ignore ?>
													</div>  
													<?php
												}

												if ( 'yes' === $crafto_tours_show_review && ! empty( $crafto_tours_review ) ) {
													?>
													<div class="review-wrap">
														<div class="review-star-icon elementor--star-style-star_fontawesome">
															<?php
															$icon      = '';
															$icon_html = '';

															$rating         = (float) $crafto_tours_star_rating > 5 ? 5 : $crafto_tours_star_rating;
															$floored_rating = ( $rating ) ? (int) $rating : 0;
															if ( $rating ) {
																for ( $stars = 1; $stars <= 5; $stars++ ) {
																	if ( $stars <= $floored_rating ) {
																		$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
																	} else {
																		$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
																	}
																}
															}
															if ( ! empty( $icon_html ) ) {
																?>
																<div class="elementor-star-rating">
																	<?php echo sprintf( '%s', $icon_html ); // phpcs:ignore ?>
																</div>
																<?php
															}
															?>
														</div>
														<span class="tours-reviews">
															<?php echo esc_html( $crafto_tours_review ); ?>
														</span>
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
							$slides[] = ob_get_contents();
							ob_end_clean();
							++$index;
						}
						wp_reset_postdata();

						if ( empty( $slides ) ) {
							return;
						}

						$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
						$crafto_slider_cursor           = $this->get_settings( 'crafto_slider_cursor' );
						$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
						$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
						$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
						$crafto_navigation_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
						$crafto_pagination              = $this->get_settings( 'crafto_slider_pagination' );
						$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
						$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
						$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );

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
							'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
							'image_spacing'    => $this->get_settings( 'crafto_items_spacing' ),
						);

						$crafto_effect = $this->get_settings( 'crafto_effect' );

						$effect = [
							'fade',
							'flip',
							'cube',
							'coverflow',
						];

						if ( '1' === $this->get_settings( 'crafto_slides_to_show' )['size'] && in_array( $crafto_effect, $effect, true ) ) {
							$slider_config['effect'] = $crafto_effect;
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

						$slider_viewport      = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
						$slide_settings_array = array_merge( $slider_config, $slider_viewport );

						$magic_cursor   = '';
						$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
						if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
							$magic_cursor = crafto_get_magic_cursor_data();
						}

						$this->add_render_attribute(
							[
								'carousel-wrapper' => [
									'class'         => [
										'tours-packages-wrapper',
										'swiper',
										$magic_cursor,
									],
									'data-settings' => wp_json_encode( $slide_settings_array ),
								],
								'carousel'         => [
									'class' => 'tours-slider swiper-wrapper',
								],
							],
						);

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

						if ( ! empty( $crafto_rtl ) ) {
							$this->add_render_attribute( 'carousel-wrapper', 'dir', $crafto_rtl );
						}
						?>
						<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
							<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
								<?php echo implode( '', $slides ); // phpcs:ignore ?>
							</div>
							<?php $this->swiper_pagination(); ?>
						</div>
						<?php
					}
					break;
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
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$previous_icon_migrated         = isset( $settings['__fa4_migrated']['crafto_previous_arrow_icon'] );
			$next_icon_migrated             = isset( $settings['__fa4_migrated']['crafto_next_arrow_icon'] );
			$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
			$crafto_pagination              = $this->get_settings( 'crafto_slider_pagination' );
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
