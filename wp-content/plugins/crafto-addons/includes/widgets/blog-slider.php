<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for blog slider.
 *
 * @package Crafto
 */

// If class `Blog_Slider` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Blog_Slider' ) ) {

	class Blog_Slider extends Widget_Base {

		/**
		 * Retrieve the list of scripts the blog slider widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$blog_slider_scripts          = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$blog_slider_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$blog_slider_scripts[] = 'swiper';
					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$blog_slider_scripts[] = 'crafto-magic-cursor';
					}
				}
				$blog_slider_scripts[] = 'crafto-default-carousel';
			}

			return $blog_slider_scripts;
		}

		/**
		 * Retrieve the list of styles the blog slider widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$blog_slider_styles           = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$blog_slider_styles[] = 'crafto-widgets-rtl';
				} else {
					$blog_slider_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$blog_slider_styles = [
						'swiper',
						'nav-pagination',
					];

					if ( is_rtl() ) {
						$blog_slider_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$blog_slider_styles[] = 'crafto-magic-cursor';
					}
				}

				if ( is_rtl() ) {
					$blog_slider_styles[] = 'crafto-blog-slider-rtl-widget';
				}
				$blog_slider_styles[] = 'crafto-blog-slider-widget';
			}
			return $blog_slider_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-blog-post-slider';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Blog Slider', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/blog-slider/';
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
				'blog',
				'slider',
				'post',
				'carousel',
				'post carousel',
				'blog slider',
				'post slider',
			];
		}

		/**
		 * Register blog slider widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_blog_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_post_data_style',
				[
					'label'              => esc_html__( 'Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'blog-post-style-1',
					'options'            => [
						'blog-post-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'blog-post-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'blog-post-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_post_per_page',
				[
					'label'   => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => 3,
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_slider_data',
				[
					'label' => esc_html__( 'Data', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_orderby',
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
				'crafto_order',
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
				'crafto_post_data_source',
				[
					'label'   => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'categories',
					'options' => [
						'categories' => esc_html__( 'Categories', 'crafto-addons' ),
						'tags'       => esc_html__( 'Tags', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_categories_list',
				[
					'label'       => esc_html__( 'Categories', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'category' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_post_data_source' => 'categories',
					],
				]
			);
			$this->add_control(
				'crafto_tags_list',
				[
					'label'       => esc_html__( 'Tags', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_tags_list' ) ? crafto_get_tags_list( 'post_tag' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_post_data_source' => 'tags',
					],
				]
			);
			$this->add_control(
				'crafto_blog_slider_offset',
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
				'crafto_post_slider_extra_option',
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
				'crafto_show_post_category',
				[
					'label'        => esc_html__( 'Enable Categories', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_post_data_style' => [
							'blog-post-style-1',
							'blog-post-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_category_limit',
				[
					'label'     => esc_html__( 'Post Category Limit', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => 1,
					'condition' => [
						'crafto_show_post_category' => 'yes',
						'crafto_post_data_style'    => [
							'blog-post-style-1',
							'blog-post-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_date',
				[
					'label'        => esc_html__( 'Enable Date', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_post_icon',
				[
					'label'        => esc_html__( 'Enable Date Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_show_post_date'   => 'yes',
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_post_date_format',
				[
					'label'       => esc_html__( 'Post Date Format', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'description' => sprintf(
						'%1$s <a target="_blank" href="%2$s" rel="noopener noreferrer">%3$s</a> %4$s',
						esc_html__( 'Date format should be like F j, Y', 'crafto-addons' ),
						esc_url( 'https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples' ),
						esc_html__( 'click here', 'crafto-addons' ),
						esc_html__( 'to see other date formats.', 'crafto-addons' )
					),
					'condition'   => [
						'crafto_show_post_date'   => 'yes',
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_like',
				[
					'label'        => esc_html__( 'Enable Like Count', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_like_text',
				[
					'label'        => esc_html__( 'Enable Like Label', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'inline-block',
					'default'      => '',
					'selectors'    => [
						'{{WRAPPER}} .blog-like span.posts-like' => 'display: {{VALUE}} !important;',
					],
					'condition'    => [
						'crafto_show_post_like'  => 'yes',
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_comments',
				[
					'label'        => esc_html__( 'Enable Comments Count', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_comments_text',
				[
					'label'        => esc_html__( 'Enable Comments Label', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'inline-block',
					'default'      => '',
					'selectors'    => [
						'{{WRAPPER}} .comment-link span.comment-text' => 'display: {{VALUE}} !important;',
					],
					'condition'    => [
						'crafto_show_post_comments' => 'yes',
						'crafto_post_data_style'    => 'blog-post-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_title',
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
				'crafto_show_post_excerpt',
				[
					'label'        => esc_html__( 'Enable Excerpt', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_post_data_style' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_post_excerpt_length',
				[
					'label'     => esc_html__( 'Excerpt Length', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'min'       => 1,
					'default'   => 18,
					'condition' => [
						'crafto_show_post_excerpt' => 'yes',
						'crafto_post_data_style'   => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_author',
				[
					'label'        => esc_html__( 'Enable Author', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_author_image',
				[
					'label'        => esc_html__( 'Enable Author Avtar', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_show_post_author' => 'yes',
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_author_text',
				[
					'label'     => esc_html__( 'Author Before Text', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'By&nbsp;', 'crafto-addons' ),
					'condition' => [
						'crafto_show_post_author' => 'yes',
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_ignore_sticky_posts',
				[
					'label'        => esc_html__( 'Ignore Sticky Posts', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_blog_post_slider_config',
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
				'crafto_section_blog_post_slide_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_blog_post_slider_content_box_alignment',
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
						'{{WRAPPER}} .post-details' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
						'{{WRAPPER}} .blog-post-style-1 .blog-category' => 'justify-content: {{VALUE}};',
					],
					'condition'   => [
						'crafto_post_data_style!' => 'blog-post-style-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_blog_post_slider_content_box_bg_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .post-details, {{WRAPPER}} .blog-box',
					'condition' => [
						'crafto_post_data_style' => 'blog-post-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_blog_slider_shadow',
					'selector'  => '{{WRAPPER}} .blog-box',
					'condition' => [
						'crafto_post_data_style!' => 'blog-post-style-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_blog_post_slider_border',
					'selector'       => '{{WRAPPER}} .blog-box',
					'fields_options' => [
						'border' => [
							'label' => esc_html__( 'Border Style', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_post_data_style!' => 'blog-post-style-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_slider_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_data_style!' => 'blog-post-style-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_post_slider_content_box_padding',
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
						'{{WRAPPER}} .blog-post-slider-wrapper .post-details, {{WRAPPER}} .blog-post-style-2 .post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_post_slider_content_box_margin',
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
						'{{WRAPPER}} .blog-post-style-2, {{WRAPPER}} .blog-post-style-3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_data_style' => [
							'blog-post-style-2',
							'blog-post-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_post_slider_container',
				[
					'label'     => esc_html__( 'Slider Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_post_data_style' => 'blog-post-style-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_post_slider_padding',
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
						'{{WRAPPER}} .swiper.blog-post-style-1 ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_data_style' => 'blog-post-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_post_slider_swiper_slide',
				[
					'label'     => esc_html__( 'Swiper Slide', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_post_slider_swiper_tabs'
			);
			$this->start_controls_tab(
				'crafto_normal_post_slider_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_post_slider_swiper_opacity',
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
						'{{WRAPPER}} .blog-post-style-2 .swiper-slide' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_post_slider_hover_style',
				[
					'label'     => esc_html__( 'Active', 'crafto-addons' ),
					'condition' => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_swiper_active_opacity',
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
						'{{WRAPPER}} .blog-post-style-2 .swiper-slide-active' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_image',
				[
					'label'      => esc_html__( 'Image', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_post_data_style' => [
							'blog-post-style-2',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_section_image_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-box .post-images img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_blog_post_slider_category_meta_style_section',
				[
					'label'      => esc_html__( 'Category', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_post_category' => 'yes',
						'crafto_post_data_style'    => [
							'blog-post-style-1',
							'blog-post-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_slider_category_meta_typography',
					'selector' => '{{WRAPPER}} .post-details .blog-category a',
				]
			);
			$this->start_controls_tabs(
				'crafto_blog_post_slider_category_meta_tabs',
			);
				$this->start_controls_tab(
					'crafto_blog_post_slider_category_meta_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_blog_post_slider_category_meta_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .post-details .blog-category a' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'     => 'crafto_blog_post_slider_category_meta_bg_color',
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
							'selector' => '{{WRAPPER}} .post-details .blog-category a',
						]
					);
					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'           => 'crafto_blog_post_slider_category_meta_border',
							'selector'       => '{{WRAPPER}} .post-details .blog-category a',
							'fields_options' => [
								'border' => [
									'label' => esc_html__( 'Border Style', 'crafto-addons' ),
								],
							],
						]
					);
					$this->add_responsive_control(
						'crafto_post_slider_category_border_radius',
						[
							'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [
								'px',
								'%',
								'custom',
							],
							'selectors'  => [
								'{{WRAPPER}} .post-details .blog-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_blog_post_slider_category_meta_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_blog_post_slider_category_meta_hover_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .blog-box:hover .blog-category a' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'     => 'crafto_blog_post_slider_category_meta_hover_bg_color',
							'types'    => [ 'classic', 'gradient' ],
							'exclude'  => [
								'image',
								'position',
								'attachment',
								'attachment_alert',
								'repeat',
								'size',
							],
							'selector' => '{{WRAPPER}} .blog-box:hover .blog-category a',
						]
					);
					$this->add_group_control(
						Group_Control_Border::get_type(),
						[
							'name'           => 'crafto_blog_post_slider_category_meta_hover_border',
							'selector'       => '{{WRAPPER}} .blog-box:hover .blog-category a',
							'fields_options' => [
								'border' => [
									'label' => esc_html__( 'Border Style', 'crafto-addons' ),
								],
							],
						]
					);
					$this->add_responsive_control(
						'crafto_post_slider_category_border_hover_radius',
						[
							'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
							'type'       => Controls_Manager::DIMENSIONS,
							'size_units' => [
								'px',
								'%',
								'custom',
							],
							'selectors'  => [
								'{{WRAPPER}} .blog-box:hover .blog-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_blog_post_slider_category_meta_spacing',
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
							'min' => 1,
							'max' => 100,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 30,
					],
					'selectors'  => [
						'{{WRAPPER}} .post-details .blog-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_blog_post_slider_category_meta_padding',
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
						'{{WRAPPER}} .post-details .blog-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_blog_post_slider_category_meta_box_shadow',
					'selector' => '{{WRAPPER}} .post-details .blog-category a',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_blog_post_slide_title_style',
				[
					'label'      => esc_html__( 'Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_post_title' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_slider_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .post-details .entry-title, {{WRAPPER}} .post-title .entry-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_blog_post_slider_title_tabs',
			);
				$this->start_controls_tab(
					'crafto_blog_post_slider_title_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_blog_post_slider_title_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .post-details .entry-title, {{WRAPPER}} .post-title .entry-title' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_blog_post_slider_title_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_blog_post_slider_title_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .post-details a.entry-title:hover, {{WRAPPER}} .post-title a.entry-title:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_blog_post_slider_title_margin',
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
							'max' => 50,
						],
					],
					'separator'  => 'before',
					'selectors'  => [
						'{{WRAPPER}} .post-details .entry-title, {{WRAPPER}} .post-title .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_blog_slider_content_style',
				[
					'label'      => esc_html__( 'Excerpt', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_post_data_style'   => 'blog-post-style-1',
						'crafto_show_post_excerpt' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_slider_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .entry-content',
				]
			);
			$this->add_control(
				'crafto_blog_slider_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .entry-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_slider_content_width',
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
					'selectors'  => [
						'{{WRAPPER}} .entry-content' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_slider_content_margin',
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
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .entry-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_slider_content_padding',
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
						'{{WRAPPER}} .entry-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_blog_post_date_style_heading',
				[
					'label'     => esc_html__( 'Date', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_date'   => 'yes',
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_meta_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .post-date',
				]
			);
			$this->add_control(
				'crafto_blog_post_meta_date_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-date, {{WRAPPER}} .blog-post-slider-wrapper:not(.blog-post-style-3) .post-date i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_blog_post_meta_date_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-date i' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_post_data_style' => 'blog-post-style-3',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_blog_post_likes_style_heading',
				[
					'label'     => esc_html__( 'Like', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_like' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_meta_likes_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .post-meta-like a',
				]
			);
			$this->start_controls_tabs(
				'crafto_blog_post_meta_likes_tabs',
			);
			$this->start_controls_tab(
				'crafto_blog_post_meta_likes_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_blog_post_meta_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .posts-like-count, {{WRAPPER}} .posts-like' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_blog_post_meta_likes_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-meta-like a i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_blog_post_meta_likes_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_blog_post_meta_likes_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-meta-like a:hover .posts-like-count, {{WRAPPER}} .post-meta-like a:hover .posts-like' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_blog_post_number_style_heading',
				[
					'label'     => esc_html__( 'Like Number', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_meta_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .posts-like-count',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_blog_post_meta_comment_style_heading',
				[
					'label'     => esc_html__( 'Comment', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_comments' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_meta_comment_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .post-meta-comments a',
				]
			);
			$this->start_controls_tabs(
				'crafto_blog_post_meta_comment_tabs',
			);
				$this->start_controls_tab(
					'crafto_blog_post_meta_comment_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_blog_post_meta_comment_number_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .comment-count, {{WRAPPER}} .comment-text' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'crafto_blog_post_meta_comment_color',
						[
							'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .post-meta-comments a i' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_blog_post_meta_comment_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_blog_post_meta_comment_hover_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .post-meta-comments a:hover .comment-count, {{WRAPPER}} .post-meta-comments a:hover .comment-text' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_blog_post_comment_number_style_heading',
				[
					'label'     => esc_html__( 'Comment Number', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_meta_comment_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .comment-count',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_blog_post_author_style_heading',
				[
					'label'     => esc_html__( 'Author', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_author' => 'yes',
						'crafto_post_data_style!' => 'blog-post-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_post_meta_author_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .author-name, {{WRAPPER}} .author-name a',
				]
			);
			$this->start_controls_tabs(
				'crafto_blog_post_meta_author_tabs',
			);
				$this->start_controls_tab(
					'crafto_blog_post_meta_author_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_blog_post_meta_author_by_color',
					[
						'label'     => esc_html__( 'Before Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .author-name' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'           => 'crafto_blog_post_meta_author_color',
						'selector'       => '{{WRAPPER}} .author-name a',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Color', 'crafto-addons' ),
							],
						],
					]
				);
				$this->add_control(
					'crafto_blog_post_meta_author_Icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .author-name i' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_post_data_style' => 'blog-post-style-3',
						],
					],
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'crafto_blog_post_meta_author_border',
						'selector' => '{{WRAPPER}} .author-name a',
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_blog_post_meta_author_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'           => 'crafto_blog_post_meta_author_hover_color',
						'selector'       => '{{WRAPPER}} .author-name a:hover, {{WRAPPER}} .blog-only-text .blog-post:hover .author-name a',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Color', 'crafto-addons' ),
							],
						],
					]
				);
				$this->add_control(
					'crafto_blog_post_meta_author_border_hover_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .author-name a:hover' => 'border-color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_separator_style_heading',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_data_style' => 'blog-post-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_post_meta_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-meta a:after, {{WRAPPER}} .post-meta > span:after' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_meta_separator_size',
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
							'max' => 40,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-meta a:after, {{WRAPPER}} .post-meta > span:after' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_meta_separator_margin',
				[
					'label'              => esc_html__( 'Margin', 'crafto-addons' ),
					'type'               => Controls_Manager::DIMENSIONS,
					'size_units'         => [
						'px',
						'%',
						'custom',
					],
					'placeholder'        => [
						'top'    => 'auto',
						'right'  => '',
						'bottom' => 'auto',
						'left'   => '',
					],
					'selectors'          => [
						'{{WRAPPER}} .post-meta a:after, {{WRAPPER}} .post-meta > span:after' => 'margin-left: {{LEFT}}{{UNIT}} !important; margin-right: {{RIGHT}}{{UNIT}} !important;',
					],
					'allowed_dimensions' => 'horizontal',
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
			$this->start_controls_section(
				'crafto_blog_post_image_box_overlay',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_data_style' => [
							'blog-post-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_blog_post_image_box_overlay_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .post-images .box-overlay',
				]
			);
			$this->add_control(
				'crafto_blog_post_opacity',
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
						'{{WRAPPER}} .post-images .box-overlay' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Register blog post slider widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                      = $this->get_settings_for_display();
			$crafto_post_data_source       = $this->get_settings( 'crafto_post_data_source' );
			$crafto_categories_list        = $this->get_settings( 'crafto_categories_list' );
			$crafto_post_excerpt_length    = $this->get_settings( 'crafto_post_excerpt_length' );
			$crafto_show_post_excerpt      = ( isset( $settings['crafto_show_post_excerpt'] ) && $settings['crafto_show_post_excerpt'] ) ? $settings['crafto_show_post_excerpt'] : '';
			$crafto_post_data_style        = ( isset( $settings['crafto_post_data_style'] ) && $settings['crafto_post_data_style'] ) ? $settings['crafto_post_data_style'] : 'blog-post-style-1';
			$crafto_show_post_date         = ( isset( $settings['crafto_show_post_date'] ) && $settings['crafto_show_post_date'] ) ? $settings['crafto_show_post_date'] : '';
			$crafto_post_icon              = ( isset( $settings['crafto_post_icon'] ) && $settings['crafto_post_icon'] ) ? $settings['crafto_post_icon'] : '';
			$crafto_post_date_format       = ( isset( $settings['crafto_post_date_format'] ) && $settings['crafto_post_date_format'] ) ? $settings['crafto_post_date_format'] : '';
			$crafto_show_post_comments     = ( isset( $settings['crafto_show_post_comments'] ) && $settings['crafto_show_post_comments'] ) ? $settings['crafto_show_post_comments'] : '';
			$crafto_show_post_like         = ( isset( $settings['crafto_show_post_like'] ) && $settings['crafto_show_post_like'] ) ? $settings['crafto_show_post_like'] : '';
			$crafto_show_post_author       = ( isset( $settings['crafto_show_post_author'] ) && $settings['crafto_show_post_author'] ) ? $settings['crafto_show_post_author'] : '';
			$crafto_show_post_author_image = ( isset( $settings['crafto_show_post_author_image'] ) && $settings['crafto_show_post_author_image'] ) ? $settings['crafto_show_post_author_image'] : '';
			$crafto_slider_cursor          = $this->get_settings( 'crafto_slider_cursor' );
			$crafto_tags_list              = $this->get_settings( 'crafto_tags_list' );
			$crafto_post_per_page          = $this->get_settings( 'crafto_post_per_page' );
			$crafto_blog_slider_offset     = $this->get_settings( 'crafto_blog_slider_offset' );
			$crafto_ignore_sticky_posts    = $this->get_settings( 'crafto_ignore_sticky_posts' );
			$crafto_show_post_title        = $this->get_settings( 'crafto_show_post_title' );
			$crafto_show_post_category     = $this->get_settings( 'crafto_show_post_category' );
			$crafto_category_limit         = ( isset( $settings['crafto_category_limit'] ) && $settings['crafto_category_limit'] ) ? $settings['crafto_category_limit'] : '1';
			$crafto_orderby                = $this->get_settings( 'crafto_orderby' );
			$crafto_order                  = $this->get_settings( 'crafto_order' );
			$crafto_show_post_author_text  = $this->get_settings( 'crafto_show_post_author_text' );

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$magic_cursor   = '';
			$allowtouchmove = $this->get_settings( 'crafto_allowtouchmove' );
			if ( 'yes' === $allowtouchmove && 'yes' === $crafto_slider_cursor ) {
				$magic_cursor = crafto_get_magic_cursor_data();
			}

			$query_args = array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => intval( $crafto_post_per_page ), // phpcs:ignore
				'paged'          => $paged,
			);

			if ( ! empty( $crafto_blog_slider_offset ) ) {
				$query_args['offset'] = $crafto_blog_slider_offset;
			}

			if ( 'tags' === $crafto_post_data_source ) {
				if ( ! empty( $crafto_tags_list ) ) {
					$query_args['tag_slug__in'] = $crafto_tags_list;
				}
			} elseif ( ! empty( $crafto_categories_list ) ) {
					$query_args['category_name'] = implode( ',', $crafto_categories_list );
			}

			if ( ! empty( $crafto_orderby ) ) {
				$query_args['orderby'] = $crafto_orderby;
			}
			if ( ! empty( $crafto_order ) ) {
				$query_args['order'] = $crafto_order;
			}

			if ( 'yes' === $crafto_ignore_sticky_posts ) {
				$query_args['ignore_sticky_posts'] = true;
				$query_args['post__not_in']        = get_option( 'sticky_posts' );
			}

			$blog_query = new \WP_Query( $query_args );

			if ( $blog_query->have_posts() ) {

				$slides       = [];
				$slides_count = '';

				$index = 0;
				while ( $blog_query->have_posts() ) :
					$blog_query->the_post();

					$post_format       = get_post_format( get_the_ID() );
					$inner_wrapper_key = '_inner_wrapper_' . $index;
					$blog_post_key     = 'blog_post_' . $index;
					$title_link_key    = 'title_' . $index;
					$custom_link_key   = 'custom_link_' . $index;
					$date_link_key     = 'date_' . $index;
					$overlay_link_key  = 'overlay_' . $index;

					$this->add_render_attribute(
						$inner_wrapper_key,
						[
							'class' => [
								'elementor-repeater-item-' . get_the_ID(),
								'swiper-slide',
								$magic_cursor,
							],
						]
					);
					ob_start();
					$crafto_thumbnail = $this->get_settings( 'crafto_thumbnail' );

					$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), $crafto_thumbnail );
					$bg_style_attr    = $featured_img_url ? 'style="background-image: url(\'' . esc_url( $featured_img_url ) . '\');"' : '';

					$this->add_render_attribute(
						$blog_post_key,
						[
							'class' => [
								'blog-box',
							],
						],
					);

					if ( 'link' === $post_format || has_post_format( 'link', get_the_ID() ) ) {
						$post_external_link = crafto_post_meta( 'crafto_post_external_link' );
						$post_link_target   = crafto_post_meta( 'crafto_post_link_target' );

						if ( '' !== $post_external_link ) {
							$post_external_link = ( ! empty( $post_external_link ) ) ? $post_external_link : '#';
							$post_link_target   = ( ! empty( $post_link_target ) ) ? $post_link_target : '_self';
						}
					} else {
						$post_external_link = get_permalink();
						$post_link_target   = '_self';
					}

					$this->add_render_attribute(
						$custom_link_key,
						[
							'href'   => $post_external_link,
							'target' => $post_link_target,
						],
					);

					$this->add_render_attribute(
						$title_link_key,
						[
							'href'   => $post_external_link,
							'target' => $post_link_target,
							'class'  => 'entry-title',
						],
					);

					$this->add_render_attribute(
						$date_link_key,
						[
							'target' => $post_link_target,
							'class'  => 'post-date published',
						],
					);

					$this->add_render_attribute(
						$overlay_link_key,
						[
							'href'   => $post_external_link,
							'target' => $post_link_target,
							'class'  => 'box-overlay',
						],
					);
					?>
					<div <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
						<?php
						switch ( $crafto_post_data_style ) {
							case 'blog-post-style-1':
								?>
								<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
									<?php
									if ( ! empty( $featured_img_url ) ) {
										?>
										<div class="blog-post-images cover-background" <?php echo $bg_style_attr; //phpcs:ignore ?>>
											<a <?php $this->print_render_attribute_string( $overlay_link_key ); ?>>
												<span class="screen-reader-text"><?php echo esc_html__( 'Read More', 'crafto-addons' ); ?></span>
											</a>
										</div>
										<?php
									}
									if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt ) {
										?>
										<div class="post-details d-flex flex-column justify-content-center">
											<?php
											if ( 'yes' === $crafto_show_post_category ) {
												?>
												<span class="blog-category alt-font">
													<?php
													$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit );
													echo sprintf( '%s', $crafto_post_category ); // phpcs:ignore
													?>
												</span>
												<?php
											}
											if ( 'yes' === $crafto_show_post_title ) {
												?>
												<a <?php $this->print_render_attribute_string( $title_link_key ); ?>><?php the_title(); ?></a>
												<?php
											}

											if ( 'yes' === $crafto_show_post_excerpt ) {
												$show_excerpt_grid = ! empty( $crafto_post_excerpt_length ) ? crafto_get_the_excerpt_theme( $crafto_post_excerpt_length ) : crafto_get_the_excerpt_theme( 15 );
												if ( ! empty( $show_excerpt_grid ) ) {
													?>
													<div class="entry-content">
														<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); ?>
													</div>
													<?php
												}
											}
											?>
										</div>
										<?php
									}
									?>
								</div>
								<?php
								break;
							case 'blog-post-style-2':
								if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_post_icon || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) || 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) || 'yes' === $crafto_show_post_title || ! empty( $crafto_show_post_author_text ) || 'yes' === $crafto_show_post_author_image || ! empty( $featured_img_url ) ) {
									?>
									<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
										<?php
										if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_post_icon || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) || 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) || 'yes' === $crafto_show_post_title || ! empty( $crafto_show_post_author_text ) || 'yes' === $crafto_show_post_author_image ) {
											?>
											<div class="post-content">
												<?php
												if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_post_icon || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) || 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) {
													?>
													<div class="post-meta">  
														<?php
														if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_post_icon ) {
															?>
															<span <?php $this->print_render_attribute_string( $date_link_key ); ?>>
																<?php
																if ( 'yes' === $crafto_post_icon ) {
																	?>
																	<i class="feather icon-feather-calendar"></i>
																	<?php
																}
																?>
																<span><?php echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ); ?></span>
															</span>
															<?php
														}
														if ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
															$this->crafto_post_comments();
														}
														if ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) {
															?>
															<span class="post-meta-like">
																<?php echo crafto_blog_post_like_button( get_the_ID() ); // phpcs:ignore ?>
															</span>
															<?php
														}
														?>
													</div>
													<?php
												}
												if ( 'yes' === $crafto_show_post_title ) {
													?>
													<div class="post-title">
														<a <?php $this->print_render_attribute_string( $title_link_key ); ?>><?php the_title(); ?></a>
													</div>
													<?php
												}
												if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
													?>
													<div class="author-name">
														<?php
														if ( 'yes' === $crafto_show_post_author_image ) {
															$alt = get_the_author_meta( 'display_name' );
															echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
														}
														if ( ! empty( $crafto_show_post_author_text ) || get_the_author() ) {
															?>
															<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
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
										if ( has_post_thumbnail() ) {
											?>
											<div class="post-images">
												<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
													<?php
													$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
													$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
													if ( '' === $alt ) {
														$alt = get_the_title( $thumbnail_id );
													}
													echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) )
													?>
												</a>
											</div>
											<?php
										}
										?>
									</div>
									<?php
								}
								break;
							case 'blog-post-style-3':
								?>
								<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
									<?php
									if ( has_post_thumbnail() ) {
										?>
										<div class="post-images">
											<?php
											$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
											$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
											if ( '' === $alt ) {
												$alt = get_the_title( $thumbnail_id );
											}
											echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) )
											?>
											<div class="box-overlay"></div>
										</div>
										<?php
									}
									?>
									<div class="post-details image-content">
										<?php
										if ( 'yes' === $crafto_show_post_category ) {
											?>
											<span class="blog-category alt-font">
												<?php
												$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit );
												echo sprintf( '%s', $crafto_post_category ); // phpcs:ignore
												?>
											</span>
											<?php
										}
										if ( 'yes' === $crafto_show_post_title ) {
											?>
											<a <?php $this->print_render_attribute_string( $title_link_key ); ?>><?php the_title(); ?></a>
											<?php
										}
										?>
										<div class="post-meta">
											<?php
											if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
												?>
												<div class="author-name">
													<?php
													if ( 'yes' === $crafto_show_post_author_image ) {
														$alt = get_the_author_meta( 'display_name' );
														echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
													} else {
														?>
														<i class="feather icon-feather-message-circle"></i>
														<?php
													}
													if ( ! empty( $crafto_show_post_author_text ) || get_the_author() ) {
														?>
														<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
														<?php
													}
													?>
												</div>
												<?php
											}
											if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_post_icon ) {
												?>
												<span <?php $this->print_render_attribute_string( $date_link_key ); ?>>
													<?php
													if ( 'yes' === $crafto_post_icon ) {
														?>
														<i class="feather icon-feather-calendar"></i>
														<?php
													}
													?>
													<span><?php echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ); ?></span>
												</span>
												<?php
											}
											?>
										</div>
									</div>
								</div>
								<?php
								break;
						}
						?>
					</div>
					<?php
					$slides[] = ob_get_contents();
					ob_end_clean();
					++$index;
				endwhile;
				wp_reset_postdata();

				if ( empty( $slides ) ) {
					return;
				}

				$slides_count                   = $blog_query->post_count;
				$crafto_rtl                     = $this->get_settings( 'crafto_rtl' );
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
					'autoplay_speed'   => $this->get_settings( 'crafto_autoplay_speed' ),
					'pause_on_hover'   => $this->get_settings( 'crafto_pause_on_hover' ),
					'loop'             => $this->get_settings( 'crafto_infinite' ),
					'effect'           => $this->get_settings( 'crafto_effect' ),
					'speed'            => $this->get_settings( 'crafto_speed' ),
					'image_spacing'    => $this->get_settings( 'crafto_items_spacing' ),
					'allowtouchmove'   => $this->get_settings( 'crafto_allowtouchmove' ),
				);

				/* START slider breakpoints */
				$slider_viewport      = \Crafto_Addons_Extra_Functions::crafto_slider_breakpoints( $this );
				$slide_settings_array = array_merge( $slider_config, $slider_viewport );
				$crafto_effect        = $this->get_settings( 'crafto_effect' );

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
							'class'         => [
								'blog-post-slider-wrapper',
								'swiper',
								$crafto_post_data_style,
							],
							'data-settings' => wp_json_encode( $slide_settings_array ),
						],
						'carousel'         => [
							'class' => 'blog-post-slider swiper-wrapper',
						],
					]
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
				?>
				<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
					<div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
						<?php echo implode( '', $slides ); // phpcs:ignore ?>
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
		/**
		 * Post Comments.
		 *
		 * @return void
		 */
		public function crafto_post_comments() {
			?>
			<span class="post-meta-comments">
				<?php crafto_post_comments(); ?>
			</span>
			<?php
		}
	}
}
