<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use CraftoAddons\Controls\Groups\Button_Group_Control;

/**
 *
 * Crafto widget for Instagram.
 *
 * @package Crafto
 * @since   1.0
 */

// If class `Instagram` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Instagram' ) ) {
	/**
	 * Define Instagram class
	 */
	class Instagram extends Widget_Base {
		/**
		 * Retrieve the list of scripts the instagram widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$instagram_scripts            = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$instagram_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$instagram_scripts[] = 'swiper';

					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$instagram_scripts[] = 'crafto-magic-cursor';
					}
				}

				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$instagram_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$instagram_scripts[] = 'isotope';
				}

				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					$instagram_scripts[] = 'anime';
				}
				$instagram_scripts[] = 'crafto-instagram-widget';
			}

			return $instagram_scripts;
		}

		/**
		 * Retrieve the list of styles the crafto instagram depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @since 1.3.0
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$instagram_styles             = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$instagram_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$instagram_styles = [
						'swiper',
						'nav-pagination',
					];

					if ( is_rtl() ) {
						$instagram_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$instagram_styles[] = 'crafto-magic-cursor';
					}
				}
				$instagram_styles[] = 'crafto-instagram-widget';
			}
			return $instagram_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-instagram';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Instagram', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-instagram-gallery crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/instagram/';
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
				'social media',
				'feed',
				'gallery',
				'insta',
			];
		}

		/**
		 * Register instagram widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_instaaccount',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_access_token',
				[
					'label'       => esc_html__( 'Access Token', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'description' => sprintf(
						'%1$s <a target="_blank" href="%2$s" rel="noopener noreferrer">%3$s</a> %4$s',
						esc_html__( 'Follow the steps', 'crafto-addons' ),
						esc_url( 'https://developers.facebook.com/docs/instagram-basic-display-api/getting-started' ),
						esc_html__( 'Instagram', 'crafto-addons' ),
						esc_html__( 'to get the Access Token. This access token applies to the instagram.', 'crafto-addons' ),
					),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_instafeed',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_no_items_to_show',
				[
					'label'      => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => 6,
					],
					'range'      => [
						'px' =>
						[
							'min'  => 1,
							'max'  => 100,
							'step' => 1,
						],
					],
					'size_units' => '',
				]
			);

			$this->add_control(
				'crafto_feed_layout',
				[
					'label'   => esc_html__( 'Layout', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'grid',
					'options' => [
						'grid'     => esc_html__( 'Grid', 'crafto-addons' ),
						'carousel' => esc_html__( 'Carousel', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_image_stretch',
				[
					'label'        => esc_html__( 'Enable Image Stretch', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_feed_layout' => 'carousel',
					],
				]
			);
			$this->add_control(
				'crafto_icon',
				[
					'label'            => esc_html__( 'Hover Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fab fa-instagram',
						'library' => 'fa-brands',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_layout_style',
				[
					'label'     => esc_html__( 'Grid', 'crafto-addons' ),
					'condition' => [
						'crafto_feed_layout' => 'grid',
					],
				]
			);

			$this->add_control(
				'crafto_enable_masonry',
				[
					'label'        => esc_html__( 'Enable Masonry Layout', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_responsive_control(
				'crafto_column_settings',
				[
					'label'   => esc_html__( 'Number of Columns', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 3,
					],
					'range'   => [
						'px' => [
							'min'  => 1,
							'max'  => 6,
							'step' => 1,
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_columns_gap',
				[
					'label'     => esc_html__( 'Columns Gap', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 10,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} ul li.grid-gutter' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.grid'           => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_instagram_bottom_spacing',
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
				]
			);

			$this->end_controls_section();

			// Carousel Slider.
			Button_Group_Control::button_content_fields(
				$this,
				[
					'type'    => 'primary',
					'label'   => esc_html__( 'Button', 'crafto-addons' ),
					'default' => '',
					'repeat'  => 'no',
				],
			);

			Button_Group_Control::button_style_fields(
				$this,
				[
					'type'  => 'primary',
					'label' => esc_html__( 'Button', 'crafto-addons' ),
				],
			);
			$this->start_controls_section(
				'crafto_icon_section_style',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .instagram-feed figure a .insta-counts i' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_icon_overlay_background_color',
				[
					'label'     => esc_html__( 'Overlay Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .instagram-feed figure a .insta-counts' => 'background-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_image_box',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
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
						'{{WRAPPER}} .instagram-feed figure' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_brand_logo_carousel_setting',
				[
					'label'     => esc_html__( 'Slider Setting', 'crafto-addons' ),
					'condition' => [
						'crafto_feed_layout' => 'carousel',
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
						'crafto_feed_layout' => 'carousel',
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
						'crafto_feed_layout' => 'carousel',
					],
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
						'crafto_pagination'  => 'yes',
						'crafto_feed_layout' => 'carousel',
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
		 * Render instagram widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                = $this->get_settings_for_display();
			$is_new                  = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_access_token     = ! empty( $settings['crafto_access_token'] ) ? $settings['crafto_access_token'] : get_theme_mod( 'crafto_instagram_api_access_token', '' );
			$crafto_no_items_to_show = ! empty( $settings['crafto_no_items_to_show']['size'] ) ? $settings['crafto_no_items_to_show']['size'] : '';
			$crafto_feed_layout      = ! empty( $settings['crafto_feed_layout'] ) ? $settings['crafto_feed_layout'] : '';
			/* Column Settings */
			$crafto_column_class      = array();
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';
			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );
			/* End Column Settings */
			$migrated = isset( $settings['__fa4_migrated']['crafto_icon'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $crafto_access_token ) {
				$crafto_instagram_api_data = wp_remote_get( 'https://graph.instagram.com/me/media?count=-1&fields=media_type,media_url,permalink&limit=' . $crafto_no_items_to_show . '&access_token=' . $crafto_access_token, array( 'timeout' => 2000 ) );

				if ( ! empty( $crafto_instagram_api_data ) && ! is_wp_error( $crafto_instagram_api_data ) || wp_remote_retrieve_response_code( $crafto_instagram_api_data ) === 200 ) {

					$crafto_instagram_api_data = json_decode( $crafto_instagram_api_data['body'] );

					if ( ! empty( $crafto_instagram_api_data->data ) ) {

						if ( $crafto_no_items_to_show ) {
							$crafto_instagram_api_data->data = array_slice( $crafto_instagram_api_data->data, 0, $crafto_no_items_to_show, true );
						}

						switch ( $crafto_feed_layout ) {
							case 'carousel':
								$settings                       = $this->get_settings_for_display();
								$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
								$crafto_slider_cursor           = $this->get_settings( 'crafto_slider_cursor' );
								$crafto_navigation              = $this->get_settings( 'crafto_navigation' );
								$crafto_arrows_icon_shape_style = $this->get_settings( 'crafto_arrows_icon_shape_style' );
								$crafto_navigation_v_alignment  = $this->get_settings( 'crafto_navigation_v_alignment' );
								$crafto_navigation_h_alignment  = $this->get_settings( 'crafto_pagination_h_align' );
								$crafto_pagination              = $this->get_settings( 'crafto_pagination' );
								$crafto_pagination_style        = $this->get_settings( 'crafto_pagination_style' );
								$crafto_pagination_dots_style   = $this->get_settings( 'crafto_pagination_dots_style' );
								$crafto_pagination_number_style = $this->get_settings( 'crafto_pagination_number_style' );
								$crafto_effect                  = $this->get_settings( 'crafto_effect' );

								$data_settings = array(
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

								$effect = [
									'fade',
									'flip',
									'cube',
									'cards',
									'coverflow',
								];

								$slider_viewport = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
								$data_settings   = array_merge( $data_settings, $slider_viewport );
								if ( '1' === $this->get_settings( 'crafto_slides_to_show' )['size'] && in_array( $crafto_effect, $effect, true ) ) { // phpcs:ignore
									$data_settings['effect'] = $crafto_effect;
								}

								$magic_cursor   = '';
								$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
								if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
									$magic_cursor = crafto_get_magic_cursor_data();
								}
								$this->add_render_attribute(
									[
										'carousel'         => [
											'class' => 'instagram-feed-carousel swiper-wrapper',
										],
										'carousel-wrapper' => [
											'id'    => 'instagram-feed-' . esc_attr( $this->get_id() ),
											'class' => [
												'instagram-feed-carousel-wrapper',
												'swiper',
												'instagram-feed',
												$crafto_slider_cursor,
												$magic_cursor,
											],
											'data-settings' => wp_json_encode( $data_settings ),
										],
									],
								);

								if ( ! empty( $crafto_rtl ) ) {
									$this->add_render_attribute( 'carousel-wrapper', 'dir', $crafto_rtl );
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
								if ( 'yes' === $this->get_settings( 'crafto_image_stretch' ) ) {
									$this->add_render_attribute( 'carousel', 'class', 'swiper-image-stretch' );
								}
								?>
								<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
									<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
									<?php
									$i = 0;
									foreach ( $crafto_instagram_api_data->data as $key => $instagram_data ) {
										if ( $i < $crafto_no_items_to_show ) {
											if ( 'IMAGE' === $instagram_data->media_type || 'CAROUSEL_ALBUM' === $instagram_data->media_type ) {
												++$i;
												?>
												<div class="swiper-slide">
													<figure>
													<a href="<?php echo esc_url( $instagram_data->permalink ); ?>" target="_blank">
														<img class="insta-image skip-lazy" src="<?php echo esc_url( $instagram_data->media_url ); ?>" alt="<?php echo esc_attr__( 'Instagram Image', 'crafto-addons' ); ?>" />
														<?php
														if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_icon']['value'] ) ) {
															?>
															<span class="insta-counts">
																<?php
																if ( $is_new || $migrated ) {
																	Icons_Manager::render_icon( $settings['crafto_icon'], [ 'aria-hidden' => 'true' ] );
																} elseif ( isset( $settings['crafto_icon']['value'] ) && ! empty( $settings['crafto_icon']['value'] ) ) {
																	?>
																	<i class ="<?php echo esc_attr( $settings['crafto_icon']['value'] ); ?>" aria-hidden = "true"></i>
																	<?php
																}
																?>
															</span>
															<?php
														}
														?>
														<div class="screen-reader-text"><?php echo esc_html__( 'Instagram Image', 'crafto-addons' ); ?></div>
													</a>
													</figure>
												</div>
												<?php
											}
										}
									}
									?>
									</div>
									<div class="instagram-button">
										<?php Button_Group_Control::render_button_content( $this, 'primary' ); ?>
									</div>
									<?php
									$previous_arrow_icon    = '';
									$next_arrow_icon        = '';
									$is_new                 = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
									$previous_icon_migrated = isset( $settings['__fa4_migrated']['crafto_previous_arrow_icon'] );
									$next_icon_migrated     = isset( $settings['__fa4_migrated']['crafto_next_arrow_icon'] );
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
											<?php
											if ( ! empty( $previous_arrow_icon ) ) {
												echo sprintf( '%s', $previous_arrow_icon ); // phpcs:ignore
											}
											?>
											<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'crafto-addons' ); ?></span>
										</div>
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
									?>
								</div>
								<?php
								break;
							default:
								$this->add_render_attribute(
									[
										'instagram-feed-inner' => [
											'id'    => 'instagram-feed-' . esc_attr( $this->get_id() ),
											'class' => [
												'instagram-feed',
												'grid',
												$crafto_column_class_list,
											],
										],
									]
								);
								if ( 'yes' === $settings['crafto_enable_masonry'] ) {
									$this->add_render_attribute(
										[
											'instagram-feed-inner' => [
												'class' => [
													'instagram-feed-masonry',
												],
											],
										]
									);
								}
								?>
								<ul <?php $this->print_render_attribute_string( 'instagram-feed-inner' ); ?>>
									<?php
									$i = 0;
									foreach ( $crafto_instagram_api_data->data as $key => $instagram_data ) {
										if ( $i < $crafto_no_items_to_show ) {
											if ( 'IMAGE' === $instagram_data->media_type || 'CAROUSEL_ALBUM' === $instagram_data->media_type ) {
												if ( 0 === $i && 'yes' === $settings['crafto_enable_masonry'] ) {
													echo '<li class="grid-sizer d-none p-0 m-0"></li>';
												}
												++$i;
												?>
												<li class="grid-item grid-gutter">
													<figure>
														<a href="<?php echo esc_url( $instagram_data->permalink ); ?>" target = "_blank">
															<img class="insta-image" src="<?php echo esc_url( $instagram_data->media_url ); ?>" alt="<?php echo esc_attr__( 'Instagram Image', 'crafto-addons' ); ?>"/>
															<?php
															if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_icon']['value'] ) ) {
																?>
																<span class="insta-counts">
																	<?php
																	if ( $is_new || $migrated ) {
																		Icons_Manager::render_icon( $settings['crafto_icon'], [ 'aria-hidden' => 'true' ] );
																	} elseif ( isset( $settings['crafto_icon']['value'] ) && ! empty( $settings['crafto_icon']['value'] ) ) {
																		?>
																		<i class="<?php echo esc_attr( $settings['crafto_icon']['value'] ); ?>" aria-hidden = "true"></i>
																		<?php
																	}
																	?>
																</span>
																<?php
															}
															?>
															<div class="screen-reader-text"><?php echo esc_html__( 'Instagram Image', 'crafto-addons' ); ?></div>
														</a>
													</figure>
												</li>
												<?php
											} elseif ( isset( $instagram_data->media_type ) && 'VIDEO' === $instagram_data->media_type ) {
												?>
												<li class="grid-item grid-gutter">
													<div class="col-video-wrapper">
														<a href="<?php echo esc_url( $instagram_data->permalink ); ?>" target="_blank">
															<video playsinline autoplay muted loop controls>
																<source src="<?php echo esc_url( $instagram_data->media_url ); ?>" />
																<?php
																if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_icon']['value'] ) ) {
																	?>
																	<span class="insta-counts">
																		<?php
																		if ( $is_new || $migrated ) {
																			Icons_Manager::render_icon( $settings['crafto_icon'], [ 'aria-hidden' => 'true' ] );
																		} elseif ( isset( $settings['crafto_icon']['value'] ) && ! empty( $settings['crafto_icon']['value'] ) ) {
																			?>
																			<i class="<?php echo esc_attr( $settings['crafto_icon']['value'] ); ?>" aria-hidden = "true"></i>
																			<?php
																		}
																		?>
																	</span>
																	<?php
																}
																?>
															</video>
															<div class="screen-reader-text"><?php echo esc_html__( 'Instagram Image', 'crafto-addons' ); ?></div>
														</a>
													</div>
												</li>
												<?php
											}
										}
									}
									?>
								</ul>
								<div class="instagram-button">
									<?php Button_Group_Control::render_button_content( $this, 'primary' ); ?>
								</div>
								<?php
								break;
						}
					}
				}
			}
		}
	}
}
