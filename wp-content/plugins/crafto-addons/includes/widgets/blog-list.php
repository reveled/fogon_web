<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for blog list.
 *
 * @package Crafto
 */

// If class `Blog_List` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Blog_List' ) ) {
	/**
	 * Define `Blog_List` class.
	 */
	class Blog_List extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-blog-list';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Blog List', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-list crafto-element-icon';
		}

		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/blog-list/';
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
				'article',
				'post',
				'list',
				'archive',
				'grid',
				'taxonomy',
				'term',
				'category',
				'news',
			];
		}

		/**
		 * Retrieve the list of scripts the blog list widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$blog_list_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$blog_list_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$blog_list_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$blog_list_scripts[] = 'isotope';
				}

				if ( crafto_disable_module_by_key( 'infinite-scroll' ) ) {
					$blog_list_scripts[] = 'infinite-scroll';
				}

				if ( crafto_disable_module_by_key( 'fitvids' ) ) {
					$blog_list_scripts[] = 'jquery.fitvids';
				}

				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$blog_list_scripts[] = 'swiper';
				}

				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$blog_list_scripts[] = 'magnific-popup';
					$blog_list_scripts[] = 'crafto-lightbox-gallery';
				}
				$blog_list_scripts[] = 'crafto-blog-list-widget';
			}
			return $blog_list_scripts;
		}

		/**
		 * Retrieve the list of styles the blog list widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$blog_list_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$blog_list_styles[] = 'crafto-widgets-rtl';
				} else {
					$blog_list_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$blog_list_styles[] = 'swiper';
				}

				if ( is_rtl() ) {
					$blog_list_styles[] = 'crafto-blog-list-rtl-widget';
				}
				$blog_list_styles[] = 'crafto-blog-list-widget';
			}
			return $blog_list_styles;
		}

		/**
		 * Register blog list widget controls.
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
				'crafto_blog_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'blog-grid',
					'options' => [
						'blog-grid'       => esc_html__( 'Grid', 'crafto-addons' ),
						'blog-classic'    => esc_html__( 'Classic', 'crafto-addons' ),
						'blog-metro'      => esc_html__( 'Metro', 'crafto-addons' ),
						'blog-masonry'    => esc_html__( 'Masonry', 'crafto-addons' ),
						'blog-simple'     => esc_html__( 'Simple', 'crafto-addons' ),
						'blog-side-image' => esc_html__( 'Side Image', 'crafto-addons' ),
						'blog-standard'   => esc_html__( 'Standard', 'crafto-addons' ),
						'blog-only-text'  => esc_html__( 'Only Text', 'crafto-addons' ),
						'blog-modern'     => esc_html__( 'Modern', 'crafto-addons' ),
						'blog-split'      => esc_html__( 'Split', 'crafto-addons' ),
						'hero-blog'       => esc_html__( 'Hero Blog', 'crafto-addons' ),
						'blog-full-image' => esc_html__( 'Full Image', 'crafto-addons' ),
					],
				]
			);
			if ( class_exists( 'Give' ) ) {
				$source = [
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-classic',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-metro',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-full-image',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-masonry',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-simple',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-side-image',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-standard',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-only-text',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-modern',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-split',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'hero-blog',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_enable_donation_form',
										'operator' => '===',
										'value'    => '',
									],
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-grid',
									],
								],
							],
						],
					],
				];
			} else {
				$source = [];
			}
			$this->add_control(
				'crafto_post_type_source',
				array_merge(
					[
						'label'              => esc_html__( 'Source', 'crafto-addons' ),
						'type'               => Controls_Manager::SELECT,
						'default'            => 'post',
						'options'            => [
							'post'    => esc_html__( 'Post', 'crafto-addons' ),
							'related' => esc_html__( 'Related', 'crafto-addons' ),
						],
						'frontend_available' => true,
					],
					$source,
				)
			);
			$this->add_responsive_control(
				'crafto_column_settings',
				[
					'label'     => esc_html__( 'Number of Columns', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 3,
					],
					'separator' => 'before',
					'range'     => [
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
					'label'      => esc_html__( 'Columns Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
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
						'{{WRAPPER}} ul:not(.blog-metro-active) li.grid-gutter'   => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul:not(.blog-metro-active).crafto-blog-list' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.blog-metro-active li.grid-gutter'         => 'padding: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_bottom_spacing',
				[
					'label'      => esc_html__( 'Bottom Gap', 'crafto-addons' ),
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
					'selectors'  => [
						'{{WRAPPER}} ul li.grid-gutter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_metro_positions' => '',
					],
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
					'default' => 12,
				]
			);
			if ( class_exists( 'Give' ) ) {
				$this->add_control(
					'crafto_enable_donation_form',
					[
						'label'        => esc_html__( 'Enable Donation Goal', 'crafto-addons' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
						'label_off'    => esc_html__( 'No', 'crafto-addons' ),
						'default'      => 'yes',
						'return_value' => 'yes',
						'condition'    => [
							'crafto_blog_style' => [
								'blog-grid',
							],
						],
					]
				);
			}
			$this->add_control(
				'crafto_enable_masonry',
				[
					'label'        => esc_html__( 'Enable Masonry Layout', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_blog_style!' => [
							'blog-masonry',
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_metro_positions',
				[
					'label'       => esc_html__( 'Metro Grid Positions', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'description' => esc_html__( 'Mention the positions (comma separated like 1, 4, 7) where that image will cover spacing of multiple columns and / or rows considering the image width and height.', 'crafto-addons' ),
					'condition'   => [
						'crafto_blog_style' => [
							'blog-metro',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_content_data',
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
				'crafto_post_type_selection',
				[
					'label'     => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'categories',
					'options'   => [
						'categories' => esc_html__( 'Categories', 'crafto-addons' ),
						'tags'       => esc_html__( 'Tags', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_post_type_source' => 'post',
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
						'crafto_post_type_source'    => 'post',
						'crafto_post_type_selection' => 'categories',
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
						'crafto_post_type_source'    => 'post',
						'crafto_post_type_selection' => 'tags',
					],
				]
			);
			$this->add_control(
				'crafto_include_exclude_post_ids',
				[
					'label'   => esc_html__( 'Include/Exclude', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'include',
					'options' => [
						'include' => esc_html__( 'Include', 'crafto-addons' ),
						'exclude' => esc_html__( 'Exclude', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_include_post_ids',
				[
					'label'       => esc_html__( 'Include Posts', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_get_post_array(),
					'description' => esc_html__( 'You can use this option to add certain posts from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'include',
					],
				]
			);
			$this->add_control(
				'crafto_exclude_post_ids',
				[
					'label'       => esc_html__( 'Exclude Posts', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_get_post_array(),
					'description' => esc_html__( 'You can use this option to remove certain posts from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'exclude',
					],
				]
			);
			$this->add_control(
				'crafto_offset',
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
				'crafto_post_extra_option',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_show_post_thumbnail',
				[
					'label'        => esc_html__( 'Enable Thumbnail', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-simple',
							'blog-modern',
							'blog-full-image',
						],
					],
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
					'condition'      => [
						'crafto_show_post_thumbnail' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_format',
				[
					'label'        => esc_html__( 'Enable Featured Image', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'description'  => esc_html__( 'If NO is selected then it will display block as per post format type like audio, video, gallery, etc… otherwise it will show post featured image no matter what is post format type.', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_show_post_thumbnail' => 'yes',
						'crafto_blog_style!'         => [
							'blog-metro',
							'blog-simple',
							'blog-side-image',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'hero-blog',
							'blog-full-image',
						],
					],
				]
			);
			$post_type_icon = [];
			if ( class_exists( 'Give' ) ) {
				$post_type_icon = [
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-classic',
									],
									[
										'name'     => 'crafto_show_post_thumbnail',
										'operator' => '===',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_show_post_format',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-masonry',
									],
									[
										'name'     => 'crafto_show_post_thumbnail',
										'operator' => '===',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_show_post_format',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-standard',
									],
									[
										'name'     => 'crafto_show_post_thumbnail',
										'operator' => '===',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_show_post_format',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'hero-blog',
									],
									[
										'name'     => 'crafto_show_post_thumbnail',
										'operator' => '===',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_show_post_format',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_enable_donation_form',
										'operator' => '===',
										'value'    => '',
									],
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-grid',
									],
									[
										'name'     => 'crafto_show_post_thumbnail',
										'operator' => '===',
										'value'    => 'yes',
									],
									[
										'name'     => 'crafto_show_post_format',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
						],
					],
				];
			} else {
				$post_type_icon = [
					'condition' => [
						'crafto_show_post_thumbnail' => 'yes',
						'crafto_show_post_format'    => 'yes',
						'crafto_blog_style!'         => [
							'blog-simple',
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-side-image',
							'blog-split',
							'blog-full-image',
						],
					],
				];
			}
			$this->add_control(
				'crafto_show_post_thumbnail_icon',
				array_merge(
					[
						'label'        => esc_html__( 'Enable Post Type Icon', 'crafto-addons' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
						'label_off'    => esc_html__( 'No', 'crafto-addons' ),
						'return_value' => 'yes',
					],
					$post_type_icon,
				)
			);
			$this->add_control(
				'crafto_show_post_category',
				[
					'label'        => esc_html__( 'Enable Category', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
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
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-simple',
							'blog-full-image',
						],
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
						'crafto_blog_style!'       => [
							'blog-metro',
							'blog-simple',
							'blog-full-image',
						],
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
						'crafto_blog_style!' => [
							'blog-simple',
							'blog-split',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_author_icon',
				[
					'label'        => esc_html__( 'Enable Author Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_show_post_author' => 'yes',
						'crafto_blog_style'       => 'blog-standard',
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
						'crafto_blog_style!'      => [
							'blog-simple',
							'blog-split',
						],
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
						'crafto_blog_style!'      => [
							'blog-simple',
							'blog-split',
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
						'crafto_show_post_date' => 'yes',
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
						'crafto_show_post_date' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_post_change_date_format',
				[
					'label'        => esc_html__( 'Enable Passing Time (x day ago)', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_show_post_date' => 'yes',
						'crafto_blog_style'     => 'blog-split',
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
					'default'      => 'yes',
					'condition'    => [
						'crafto_blog_style' => [
							'blog-side-image',
							'hero-blog',
							'blog-modern',
						],
					],
				]
			);
			$this->add_control(
				'crafto_image_position',
				[
					'label'        => esc_html__( 'Enable Zigzag Image Position', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_blog_style' => [
							'blog-side-image',
							'hero-blog',
						],
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
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-simple',
							'blog-only-text',
							'blog-split',
							'blog-full-image',
						],
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
						'crafto_show_post_like' => 'yes',
						'crafto_blog_style!'    => [
							'blog-metro',
							'blog-simple',
							'blog-only-text',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			if ( class_exists( 'Give' ) ) {
				$comment_count = [
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-classic',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-masonry',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-side-image',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-standard',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-modern',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'hero-blog',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_enable_donation_form',
										'operator' => '===',
										'value'    => '',
									],
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-grid',
									],
								],
							],
						],
					],
				];
			} else {
				$comment_count = [
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-simple',
							'blog-only-text',
							'blog-split',
							'blog-full-image',
						],
					],
				];
			}
			$this->add_control(
				'crafto_show_post_comments',
				array_merge(
					[
						'label'        => esc_html__( 'Enable Comments Count', 'crafto-addons' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
						'label_off'    => esc_html__( 'No', 'crafto-addons' ),
						'return_value' => 'yes',
					],
					$comment_count,
				)
			);
			if ( class_exists( 'Give' ) ) {
				$comment_label = [
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-classic',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-masonry',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-side-image',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-standard',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-modern',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'hero-blog',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_enable_donation_form',
										'operator' => '===',
										'value'    => '',
									],
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-grid',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
						],
					],
				];
			} else {
				$comment_label = [
					'condition' => [
						'crafto_show_post_comments' => 'yes',
						'crafto_blog_style!'        => [
							'blog-metro',
							'blog-simple',
							'blog-only-text',
							'blog-split',
							'blog-full-image',
						],
					],
				];
			}
			$this->add_control(
				'crafto_show_post_comments_text',
				array_merge(
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
					],
					$comment_label,
				)
			);
			$this->add_control(
				'crafto_show_post_count',
				[
					'label'        => esc_html__( 'Enable Number', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_blog_style' => 'blog-only-text',
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'line-icon-Arrow-OutRight',
						'library' => 'icomoon',
					],
					'condition'        => [
						'crafto_blog_style' => 'blog-simple',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->add_control(
				'crafto_image_grey_scale',
				[
					'label'        => esc_html__( 'Enable Image Grayscale', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_blog_style' => [
							'blog-classic',
							'blog-split',
							'blog-only-text',

						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_read_more_button',
				[
					'label'        => esc_html__( 'Enable Button', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_read_more_text',
				[
					'label'     => esc_html__( 'Button Text', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'More reading', 'crafto-addons' ),
					'condition' => [
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_style',
				[
					'label'     => esc_html__( 'Button Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'underline',
					'options'   => [
						''              => esc_html__( 'Solid', 'crafto-addons' ),
						'border'        => esc_html__( 'Border', 'crafto-addons' ),
						'double-border' => esc_html__( 'Double Border', 'crafto-addons' ),
						'underline'     => esc_html__( 'Underline', 'crafto-addons' ),
						'expand-border' => esc_html__( 'Expand Width', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_size',
				[
					'label'          => esc_html__( 'Button Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'lg',
					'options'        => [
						'xs' => esc_html__( 'Extra Small', 'crafto-addons' ),
						'sm' => esc_html__( 'Small', 'crafto-addons' ),
						'md' => esc_html__( 'Medium', 'crafto-addons' ),
						'lg' => esc_html__( 'Large', 'crafto-addons' ),
						'xl' => esc_html__( 'Extra Large', 'crafto-addons' ),
					],
					'style_transfer' => true,
					'condition'      => [
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_post_read_more_button_icon',
				[
					'label'            => esc_html__( 'Button Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'default'          => [
						'value'   => 'fas fa-arrow-right',
						'library' => 'fa-solid',
					],
					'condition'        => [
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_icon_align',
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
						'crafto_post_read_more_button_icon[value]!' => '',
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_shape_style',
				[
					'label'     => esc_html__( 'Icon Shape Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'options'   => [
						'default'         => esc_html__( 'Default', 'crafto-addons' ),
						'btn-icon-round'  => esc_html__( 'Round Edge', 'crafto-addons' ),
						'btn-icon-circle' => esc_html__( 'Circle', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_post_read_more_button_icon[value]!' => '',
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_blog_style!'   => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_shape_size',
				[
					'label'      => esc_html__( 'Icon Shape Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .btn-icon-round .elementor-button-icon, {{WRAPPER}} .btn-icon-circle .elementor-button-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_read_more_button_icon[value]!' => '',
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_icon_shape_style!' => 'default',
						'crafto_button_style!'     => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_blog_style!'       => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_button_icon_indent',
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
						'.rtl {{WRAPPER}} .elementor-button .elementor-align-icon-right'  => 'margin-inline-start: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_read_more_button_icon[value]!' => '',
						'crafto_button_icon_align!' => 'switch',
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!'        => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_button_icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 15,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_post_read_more_button_icon[value]!' => '',
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_expand_width',
				[
					'label'      => esc_html__( 'Expand Width', 'crafto-addons' ),
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
						'{{WRAPPER}} .elementor-animation-btn-expand-ltr .btn-hover-animation' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_button_style' => 'expand-border',
						'crafto_blog_style!'  => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_button_hover_animation',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						'crafto_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!'   => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_ignore_sticky_posts',
				[
					'label'        => esc_html__( 'Enable Ignore Sticky Posts', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_post_enable_overlay',
				[
					'label'        => esc_html__( 'Enable Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_blog_style!' => [
							'blog-classic',
							'blog-grid',
							'hero-blog',
							'blog-masonry',
							'blog-side-image',
							'blog-standard',
							'blog-modern',
							'blog-split',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_grid_animation',
				[
					'label' => esc_html__( 'Entrance Animation', 'crafto-addons' ),
					'type'  => Controls_Manager::ANIMATION,
				]
			);
			$this->add_control(
				'crafto_blog_grid_animation_duration',
				[
					'label'     => esc_html__( 'Animation Duration', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						'slow' => esc_html__( 'Slow', 'crafto-addons' ),
						''     => esc_html__( 'Normal', 'crafto-addons' ),
						'fast' => esc_html__( 'Fast', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_blog_grid_animation!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_blog_grid_animation_delay',
				[
					'label'     => esc_html__( 'Animation Delay', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => '',
					'min'       => 0,
					'max'       => 1500,
					'step'      => 50,
					'condition' => [
						'crafto_blog_grid_animation!' => '',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_filter',
				[
					'label'      => esc_html__( 'Filter', 'crafto-addons' ),
					'show_label' => false,
					'condition'  => [
						'crafto_post_type_source' => 'post',
					],
				]
			);
			$this->add_control(
				'crafto_enable_filter',
				[
					'label'        => esc_html__( 'Enable Post Filter', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_post_categories_orderby',
				[
					'label'     => esc_html__( 'Order By', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'name',
					'options'   => [
						'name'  => esc_html__( 'Name', 'crafto-addons' ),
						'slug'  => esc_html__( 'Slug', 'crafto-addons' ),
						'id'    => esc_html__( 'Id', 'crafto-addons' ),
						'count' => esc_html__( 'Count', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_post_categories_order',
				[
					'label'     => esc_html__( 'Sort By', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'DESC',
					'options'   => [
						'DESC' => esc_html__( 'Descending', 'crafto-addons' ),
						'ASC'  => esc_html__( 'Ascending', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_filter_post_type_selection',
				[
					'label'     => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'category',
					'options'   => [
						'category' => esc_html__( 'Categories', 'crafto-addons' ),
						'post_tag' => esc_html__( 'Tags', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_filter_categories_list',
				[
					'label'       => esc_html__( 'Categories', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'category' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_filter_post_type_selection' => 'category',
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_filter_tags_list',
				[
					'label'       => esc_html__( 'Tags', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_tags_list' ) ? crafto_get_tags_list( 'post_tag' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_filter_post_type_selection' => 'post_tag',
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_default_category_selected',
				[
					'label'       => esc_html__( 'Default Categories as Selected', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'category' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_filter_post_type_selection' => 'category',
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_default_tags_selected',
				[
					'label'       => esc_html__( 'Default Tags as Selected', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_tags_list' ) ? crafto_get_tags_list( 'post_tag' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_filter_post_type_selection' => 'post_tag',
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_show_all_text_filter',
				[
					'label'        => esc_html__( 'Show "All" Label in Filter', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_enable_filter' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_show_all_label',
				[
					'label'     => esc_html__( '"All" Filter Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'All', 'crafto-addons' ),
					'condition' => [
						'crafto_show_all_text_filter' => 'yes',
						'crafto_enable_filter'        => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_pagination',
				[
					'label'      => esc_html__( 'Pagination', 'crafto-addons' ),
					'show_label' => false,
					'condition'  => [
						'crafto_enable_filter' => '',
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
				'crafto_section_blog_list_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_control(
				'crafto_blog_list_content_box_alignment',
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
					'condition'   => [
						'crafto_blog_style!' => [
							'blog-classic',
							'blog-side-image',
							'hero-blog',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_blog_list_content_box_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-blog-list:not(.blog-masonry) .blog-post, {{WRAPPER}} .blog-side-image .post-details, {{WRAPPER}} .blog-standard .post-details, {{WRAPPER}} .hero-blog .post-details, {{WRAPPER}} .blog-masonry .post-details',
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-classic',
							'blog-simple',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_blog_list_blog_post_shadow',
					'selector'  => '{{WRAPPER}} .blog-post',
					'condition' => [
						'crafto_blog_style!' => [
							'blog-classic',
							'blog-modern',
							'blog-split',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_blog_list_blog_post_border',
					'selector'  => '{{WRAPPER}} .blog-post',
					'condition' => [
						'crafto_blog_style!' => [
							'blog-classic',
							'blog-modern',
							'blog-split',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_blog_post_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-post' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style!' => [
							'blog-classic',
							'blog-modern',
							'blog-split',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_blog_post_content_shadow_title',
				[
					'label'     => esc_html__( 'Post Content Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_blog_style' => [
							'blog-modern',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_blog_content_box_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'condition' => [
						'crafto_blog_style' => [
							'blog-modern',
						],
					],
					'selector'  => '{{WRAPPER}} .blog-modern .post-details .post-content-wrapper',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_blog_list_blog_post_content_shadow',
					'selector'  => '{{WRAPPER}} .blog-modern .post-details',
					'condition' => [
						'crafto_blog_style' => [
							'blog-modern',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_blog_post_content_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-modern .post-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  =>
					[
						'crafto_blog_style' => [
							'blog-modern',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_blog_post_content_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-details' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'blog-modern',
							'blog-side-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_post_content_box_padding',
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
						'{{WRAPPER}} .crafto-blog-list:not(.blog-metro, .blog-modern, .blog-full-image) .post-details, {{WRAPPER}} .blog-metro.crafto-blog-list .content, {{WRAPPER}} .blog-full-image.crafto-blog-list .content, {{WRAPPER}} .blog-modern .post-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			if ( class_exists( 'Give' ) ) {
				$this->add_control(
					'crafto_blog_list_donation_separator',
					[
						'label'     => esc_html__( 'Separator', 'crafto-addons' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
						'condition' => [
							'crafto_enable_donation_form' => 'yes',
							'crafto_show_post_read_more_button' => 'yes',
							'crafto_blog_style'           => [
								'blog-grid',
							],
						],
					]
				);
				$this->add_control(
					'crafto_blog_list_donation_separator_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-button-wrapper' => 'border-top-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_enable_donation_form' => 'yes',
							'crafto_show_post_read_more_button' => 'yes',
							'crafto_blog_style'           => [
								'blog-grid',
							],
						],
					]
				);
			}
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_blog_list_image_style',
				[
					'label'      => esc_html__( 'Thumbnail', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_post_thumbnail' => 'yes',
						'crafto_blog_style!'         => [
							'blog-grid',
							'blog-metro',
							'blog-masonry',
							'blog-simple',
							'blog-only-text',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_blog_list_thumbnail_shadow',
					'selector'  => '{{WRAPPER}} .blog-post-images',
					'condition' => [
						'crafto_blog_style' => [
							'blog-modern',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_image_border',
					'selector'  => '{{WRAPPER}} .blog-post-images',
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-side-image',
							'hero-blog',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_responsive_control(
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
						'{{WRAPPER}} .blog-post-images' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-side-image',
							'hero-blog',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_border_content_width',
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
						'{{WRAPPER}} .blog-post-images' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-side-image',
							'blog-split',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_border_content_height',
				[
					'label'      => esc_html__( 'Min Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 500,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-post-images, {{WRAPPER}} .post-image-wrap' => 'min-height: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-side-image',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_blog_list_title_style',
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
					'name'     => 'crafto_blog_list_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .entry-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_blog_list_title_tabs',
			);
				$this->start_controls_tab(
					'crafto_blog_list_title_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_blog_list_title_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .entry-title' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_blog_list_title_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_blog_list_title_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .entry-title:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_blog_list_title_width',
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
							'min' => 1,
							'max' => 200,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 100,
					],
					'selectors'  => [
						'{{WRAPPER}} .entry-title' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_title_min_height',
				[
					'label'      => esc_html__( 'Min Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .entry-title' => 'min-height: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'blog-grid',
							'blog-classic',
							'blog-simple',
							'blog-standard',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_title_margin',
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
						'{{WRAPPER}} .entry-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_blog_list_content_style',
				[
					'label'      => esc_html__( 'Excerpt', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_post_excerpt' => 'yes',
						'crafto_blog_style!'       => [
							'blog-simple',
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_list_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .entry-content',
				]
			);
			$this->add_control(
				'crafto_blog_list_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .entry-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_content_width',
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
					],
					'selectors'  => [
						'{{WRAPPER}} .entry-content' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			if ( class_exists( 'Give' ) ) {
				$excerpt_spacer = [
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-classic',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-metro',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-full-image',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-masonry',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-simple',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-side-image',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-standard',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-modern',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'hero-blog',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_enable_donation_form',
										'operator' => '===',
										'value'    => '',
									],
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-grid',
									],
								],
							],
						],
					],
				];
			} else {
				$excerpt_spacer = [
					'condition' => [
						'crafto_blog_style!' => [
							'blog-only-text',
							'blog-split',
						],
					],
				];
			}
			$this->add_responsive_control(
				'crafto_blog_list_content_margin',
				array_merge(
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
					],
					$excerpt_spacer,
				)
			);
			$this->end_controls_section();

			if ( class_exists( 'Give' ) ) {
				$this->start_controls_section(
					'crafto_section_blog_list_progress_style',
					[
						'label'      => esc_html__( 'Donation Goal', 'crafto-addons' ),
						'tab'        => Controls_Manager::TAB_STYLE,
						'show_label' => false,
						'condition'  => [
							'crafto_enable_donation_form' => 'yes',
							'crafto_blog_style'           => 'blog-grid',
						],
					]
				);
				$this->add_control(
					'crafto_blog_post_progress_fill_bg_color',
					[
						'label'     => esc_html__( 'Bar Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .donation-form .donation-progress-bar, {{WRAPPER}} .donation-form .elementor-progress-percentage' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .donation-form .elementor-progress-percentage:after' => 'border-top-color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_blog_post_progress_color',
					[
						'label'     => esc_html__( 'Bar Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .donation-form .crafto-donation-progress' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_blog_post_progress_margin',
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
							'{{WRAPPER}} .donation-form .crafto-donation-progress' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
				$this->add_control(
					'crafto_blog_post_progress_goal',
					[
						'label'     => esc_html__( 'Goal/Raised', 'crafto-addons' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'name'     => 'crafto_blog_post_progress_goal_typography',
						'global'   => [
							'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
						],
						'selector' => '{{WRAPPER}} .donation-form .goal-amount, {{WRAPPER}} .donation-form .raised-amount',
					],
				);
				$this->add_control(
					'crafto_blog_post_progress_goal_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .donation-form .goal-amount, {{WRAPPER}} .donation-form .raised-amount' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_blog_post_goal_number_color',
					[
						'label'     => esc_html__( 'Title Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .donation-form .goal-amount span, {{WRAPPER}} .donation-form .raised-amount span' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_section();
			}

			$this->start_controls_section(
				'crafto_section_blog_list_meta_style',
				[
					'label'      => esc_html__( 'Meta', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_blog_style' => [
							'blog-modern',
							'blog-masonry',
							'blog-classic',
							'blog-standard',
						],
					],
				]
			);
			$this->add_control(
				'crafto_post_meta_categories_date_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-modern .post-details .post-author-wrapper, {{WRAPPER}} .blog-masonry .post-meta' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .blog-masonry .post-meta:after' => 'border-top-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style!' => [
							'blog-classic',
							'blog-standard',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_meta_categories_date_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-modern .post-author-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style!' => [
							'blog-masonry',
							'blog-classic',
							'blog-standard',
							'blog-modern',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_meta_categories_date_padding',
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
						'{{WRAPPER}} .blog-modern .post-author-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style!' => [
							'blog-masonry',
							'blog-classic',
							'blog-standard',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_meta_margin',
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
						'{{WRAPPER}} .crafto-blog-list:not(.blog-standard) .post-author-meta, {{WRAPPER}} .blog-standard .post-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style!' => [
							'blog-masonry',
							'blog-modern',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_meta_spacer',
				[
					'label'      => esc_html__( 'Horizontal Spacer', 'crafto-addons' ),
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
						'{{WRAPPER}} .blog-standard .post-meta>span' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .blog-standard .post-meta>span' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style!' => [
							'blog-masonry',
							'blog-modern',
							'blog-classic',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_date_style_heading',
				[
					'label'     => esc_html__( 'Date', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_date' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_list_meta_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .post-date, {{WRAPPER}} .blog-masonry .post-date-wrapper',
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-date, {{WRAPPER}} .blog-masonry .post-date-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_date_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-masonry .post-date-wrapper i, {{WRAPPER}} .blog-side-image .post-date-wrapper i, {{WRAPPER}} .hero-blog .post-date-wrapper i, {{WRAPPER}} .blog-standard .post-date i, {{WRAPPER}} .blog-split .post-date-wrapper i' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_post_icon'  => 'yes',
						'crafto_blog_style' => [
							'blog-masonry',
							'blog-side-image',
							'hero-blog',
							'blog-standard',
							'blog-split',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_list_meta_date_margin',
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
						'{{WRAPPER}} .post-date-wrapper, {{WRAPPER}} .blog-simple .post-date, {{WRAPPER}} .blog-metro .post-date, {{WRAPPER}} .blog-full-image .post-date, {{WRAPPER}} .blog-only-text .post-date' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style!' => [
							'blog-grid',
							'blog-classic',
							'blog-masonry',
							'blog-standard',
							'blog-modern',
							'hero-blog',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_author_style_heading',
				[
					'label'     => esc_html__( 'Author', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_author' => 'yes',
						'crafto_blog_style!'      => [
							'blog-simple',
							'blog-split',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'           => 'crafto_blog_list_meta_author_typography',
					'global'         => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'       => '{{WRAPPER}} .author-name, {{WRAPPER}} .author-name a',
					'fields_options' => [
						'typography' => [
							'label' => esc_html__( 'Typography', 'crafto-addons' ),
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_blog_list_meta_author_tabs' );
				$this->start_controls_tab(
					'crafto_blog_list_meta_author_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'           => 'crafto_blog_list_meta_author_by_color',
						'selector'       => '{{WRAPPER}} .author-name',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Before Text Color', 'crafto-addons' ),
							],
						],
						'condition'      => [
							'crafto_blog_style!' => [
								'hero-blog',
								'blog-standard',
								'blog-split',
								'blog-side-image',
							],
						],
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'           => 'crafto_blog_list_meta_author_color',
						'selector'       => '{{WRAPPER}} .author-name a',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Author Color', 'crafto-addons' ),
							],
						],
					]
				);
				$this->add_control(
					'crafto_blog_list_meta_author_icon_color',
					[
						'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .author-name i' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_blog_style' => [
								'blog-standard',
							],
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'crafto_blog_list_meta_author_border',
						'selector'  => '{{WRAPPER}} .author-name a',
						'condition' => [
							'crafto_blog_style' => [
								'blog-grid',
								'hero-blog',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_blog_list_meta_author_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'           => 'crafto_blog_list_meta_author_hover_color',
						'selector'       => '{{WRAPPER}} .author-name a:hover, {{WRAPPER}} .blog-only-text .blog-post:hover .author-name a',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Author Color', 'crafto-addons' ),
							],
						],
					]
				);
				$this->add_control(
					'crafto_blog_list_meta_author_border_hover_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .author-name a:hover' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_blog_style' => [
								'blog-grid',
							],
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_blog_list_meta_author_margin',
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
						'{{WRAPPER}} .crafto-blog-list:not(.blog-side-image) .author-name, {{WRAPPER}} .blog-side-image .post-author-meta' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
					'condition'  => [
						'crafto_blog_style' => [
							'blog-only-text',
							'blog-side-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_author_separator',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_blog_style' => [
							'blog-side-image',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_author_separator_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .horizontal-separator',
					'condition'      => [
						'crafto_blog_style' => [
							'blog-side-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_author_separator_thickness',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
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
						'{{WRAPPER}} .horizontal-separator' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'blog-side-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_separator_length',
				[
					'label'      => esc_html__( 'Length', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .horizontal-separator' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'blog-side-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_separator_spacing',
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
							'max' => 15,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .horizontal-separator' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .horizontal-separator' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'blog-side-image',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_likes_style_heading',
				[
					'label'     => esc_html__( 'Like', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_like' => 'yes',
						'crafto_blog_style!'    => [
							'blog-metro',
							'blog-simple',
							'blog-only-text',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_blog_list_meta_likes_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .post-meta-like a',
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_blog_list_meta_likes_tabs' );
			$this->start_controls_tab(
				'crafto_blog_list_meta_likes_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_likes_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-meta-like a i' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_number_color',
				[
					'label'     => esc_html__( 'Label Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .posts-like-count' => 'color: {{VALUE}};',
						'{{WRAPPER}} .posts-like'       => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_blog_list_meta_likes_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_likes_hover_color',
				[
					'label'     => esc_html__( 'Label Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-meta-like a:hover .posts-like-count' => 'color: {{VALUE}};',
						'{{WRAPPER}} .post-meta-like a:hover .posts-like' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			if ( class_exists( 'Give' ) ) {
				$comment = [
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-classic',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-masonry',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-side-image',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-standard',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-modern',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'hero-blog',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_enable_donation_form',
										'operator' => '===',
										'value'    => '',
									],
									[
										'name'     => 'crafto_blog_style',
										'operator' => '===',
										'value'    => 'blog-grid',
									],
									[
										'name'     => 'crafto_show_post_comments',
										'operator' => '===',
										'value'    => 'yes',
									],
								],
							],
						],
					],
				];
			} else {
				$comment = [
					'condition' => [
						'crafto_show_post_comments' => 'yes',
						'crafto_blog_style!'        => [
							'blog-metro',
							'blog-simple',
							'blog-only-text',
							'blog-split',
							'blog-full-image',
						],
					],
				];
			}
			$this->start_controls_section(
				'crafto_post_meta_comment_style_heading',
				array_merge(
					[
						'label' => esc_html__( 'Comment', 'crafto-addons' ),
						'tab'   => Controls_Manager::TAB_STYLE,
					],
					$comment,
				)
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_blog_list_meta_comment_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .post-meta-comments a',
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_blog_list_meta_comment_tabs' );
			$this->start_controls_tab(
				'crafto_blog_list_meta_comment_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_comment_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-meta-comments a i' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_comment_number_color',
				[
					'label'     => esc_html__( 'Label Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .comment-count' => 'color: {{VALUE}};',
						'{{WRAPPER}} .comment-text'  => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_blog_list_meta_comment_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_control(
				'crafto_blog_list_meta_comment_hover_color',
				[
					'label'     => esc_html__( 'Label Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-meta-comments a:hover .comment-count' => 'color: {{VALUE}};',
						'{{WRAPPER}} .post-meta-comments a:hover .comment-text'  => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-full-image',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_categories_style_heading',
				[
					'label'     => esc_html__( 'Category', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_category' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_list_meta_categories_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .blog-category a:not(.post-date), {{WRAPPER}} .blog-side-image .blog-category, {{WRAPPER}} .hero-blog .blog-category, {{WRAPPER}} .blog-split .post-author-meta a, {{WRAPPER}} .blog-simple .blog-post .blog-category',
				]
			);
			$this->start_controls_tabs( 'crafto_blog_list_meta_categories_tabs' );
				$this->start_controls_tab(
					'crafto_blog_list_meta_categories_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_blog_list_meta_categories_bg_color',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} .blog-grid:not(.blog-masonry) .blog-category a, {{WRAPPER}} .blog-metro .blog-category a, {{WRAPPER}} .blog-masonry .blog-category a, {{WRAPPER}} .blog-side-image .blog-category a, {{WRAPPER}} .hero-blog .blog-category a, {{WRAPPER}} .blog-standard .blog-category a, {{WRAPPER}} .blog-only-text .blog-category a, {{WRAPPER}} .blog-full-image .blog-category a',
						'condition' => [
							'crafto_blog_style!' => [
								'blog-classic',
								'blog-simple',
								'blog-modern',
								'blog-split',
								'hero-blog',
							],
						],
					]
				);
				$this->add_control(
					'crafto_blog_list_meta_categories_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .blog-category a:not(.post-date), {{WRAPPER}} .blog-side-image .blog-category, {{WRAPPER}} .hero-blog .blog-category, {{WRAPPER}} .blog-split .post-author-meta a, {{WRAPPER}} .blog-simple .blog-post .blog-category, {{WRAPPER}} .blog-split .blog-category, {{WRAPPER}} .blog-modern .blog-category' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'      => 'crafto_blog_list_meta_categories_border',
						'selector'  => '{{WRAPPER}} .blog-category a:not(.post-date)',
						'condition' => [
							'crafto_blog_style!' => [
								'blog-side-image',
								'hero-blog',
								'blog-classic',
								'blog-simple',
								'blog-modern',
								'blog-split',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_blog_list_meta_categories_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [
							'px',
							'%',
							'custom',
						],
						'selectors'  => [
							'{{WRAPPER}} .blog-category a:not(.post-date)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_blog_style!' => [
								'blog-side-image',
								'hero-blog',
								'blog-classic',
								'blog-simple',
								'blog-modern',
								'blog-split',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_blog_list_meta_categories_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					],
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_blog_list_meta_categories_hover_bg_color',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} .blog-grid:not(.blog-masonry) .blog-post:hover .blog-category a, {{WRAPPER}} .blog-metro .blog-post:hover .blog-category a, {{WRAPPER}} .blog-masonry .blog-post:hover .blog-category a, {{WRAPPER}} .blog-side-image  .blog-post:hover .blog-category a, {{WRAPPER}} .hero-blog .blog-post:hover .blog-category a, {{WRAPPER}} .blog-standard  .blog-post:hover .blog-category a, {{WRAPPER}} .blog-only-text .blog-post:hover .blog-category a, {{WRAPPER}} .blog-full-image .blog-post:hover .blog-category a ',
						'condition' => [
							'crafto_blog_style!' => [
								'blog-classic',
								'blog-simple',
								'blog-modern',
								'hero-blog',
								'blog-split',
							],
						],
					]
				);
				$this->add_control(
					'crafto_blog_list_meta_categories_hover_color',
					[
						'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .blog-grid:not(.blog-standard) .blog-post:hover .blog-category a, {{WRAPPER}} .blog-standard .blog-post:hover .blog-category a, {{WRAPPER}} .blog-side-image .blog-post:hover .blog-category a, {{WRAPPER}} .hero-blog .blog-post .blog-category a:hover, {{WRAPPER}} .blog-classic .blog-category a:not(.post-date):hover, {{WRAPPER}} .blog-modern .blog-category a:not(.post-date):hover, {{WRAPPER}} .blog-metro:not(.post-date) .blog-post:hover .blog-category a, {{WRAPPER}} .blog-masonry .blog-post:hover .blog-category a, {{WRAPPER}} .blog-simple .blog-post:hover .blog-category a, {{WRAPPER}} .blog-only-text .blog-post:hover .blog-category a, {{WRAPPER}} .blog-simple .blog-post .blog-category, {{WRAPPER}} .blog-split .blog-category a:hover, {{WRAPPER}} .blog-full-image .blog-post:hover .blog-category a' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_post_hover_border_color',
					[
						'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .blog-post:hover .blog-category a:not(.post-date)' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_blog_style!' => [
								'blog-side-image',
								'hero-blog',
								'blog-classic',
								'blog-simple',
								'blog-modern',
								'blog-split',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->end_controls_tabs();
				$this->add_control(
					'crafto_blog_category_separator',
					[
						'type'      => Controls_Manager::DIVIDER,
						'style'     => 'thick',
						'condition' => [
							'crafto_blog_style!' => [
								'blog-classic',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_blog_list_meta_categories_padding',
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
							'{{WRAPPER}} .blog-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_blog_style!' => [
								'blog-simple',
								'blog-classic',
								'hero-blog',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_blog_list_category_margin',
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
							'{{WRAPPER}} .blog-simple .blog-category, {{WRAPPER}} .blog-side-image .blog-category, {{WRAPPER}} .blog-only-text .blog-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_blog_style' => [
								'blog-simple',
								'blog-side-image',
								'blog-only-text',
							],
						],
					]
				);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_dot_separator_style',
				[
					'label'     => esc_html__( 'Dot Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-classic',
						],
					],
				]
			);
			$this->add_control(
				'crafto_dot_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '#d6d5d5',
					'selectors' => [
						'{{WRAPPER}} .blog-category a:after, {{WRAPPER}} .hero-blog-bottom >div:after, {{WRAPPER}} .hero-blog .post-meta>span:after, {{WRAPPER}} .post-meta-separator, {{WRAPPER}} .post-author-meta a:after, {{WRAPPER}} .post-author-meta span:after, {{WRAPPER}} .hero-blog-bottom >div:after, {{WRAPPER}} .blog-classic .author-name:after' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-classic',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_dot_separator_size',
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
							'max' => 30,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-category a:after, {{WRAPPER}} .hero-blog-bottom >div:after, {{WRAPPER}} .hero-blog .post-meta>span:after, {{WRAPPER}} .post-meta-separator, {{WRAPPER}} .post-author-meta a:after, {{WRAPPER}} .blog-classic .author-name:after' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-classic',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_dot_separator_margin',
				[
					'label'      => esc_html__( 'Horizontal Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-category a:after, {{WRAPPER}} .hero-blog-bottom >div:after, {{WRAPPER}} .hero-blog .post-meta>span:after,  {{WRAPPER}} .blog-classic .author-name:after' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-classic',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_separator_style_heading',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_separator'  => 'yes',
						'crafto_blog_style' => [
							'hero-blog',
							'blog-modern',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_separator_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .horizontal-separator, {{WRAPPER}} .post-meta-separator',
					'condition'      => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-modern',
						],
					],
				]
			);
			$this->add_control(
				'crafto_separator_thickness',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .horizontal-separator' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .post-meta-separator' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-modern',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_separator_length',
				[
					'label'      => esc_html__( 'Length', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 30,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .horizontal-separator' => 'width: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .post-meta-separator' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-modern',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_separator_spacing',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .post-meta-separator, {{WRAPPER}} .horizontal-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_blog_style' => [
							'hero-blog',
							'blog-modern',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_meta_icon_style',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_blog_list_icon[value]!' => '',
						'crafto_blog_style'             => [
							'blog-simple',
						],
					],
				]
			);
			$this->add_control(
				'crafto_post_meta_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-hover-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .blog-hover-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_meta_icon_size',
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
						'{{WRAPPER}} .blog-hover-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .blog-hover-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_read_more_style',
				[
					'label'      => esc_html__( 'Button', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_post_read_more_button' => 'yes',
						'crafto_blog_style!' => [
							'blog-metro',
							'blog-only-text',
							'blog-modern',
							'blog-split',
							'blog-full-image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_read_more_display',
				[
					'label'     => esc_html__( 'Display', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''             => esc_html__( 'Default', 'crafto-addons' ),
						'block'        => esc_html__( 'Block', 'crafto-addons' ),
						'inline-block' => esc_html__( 'Inline Block', 'crafto-addons' ),
						'none'         => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-button' => 'display: {{VALUE}}',
					],
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_read_more_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_read_more_text_shadow',
					'selector' => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
				]
			);

			$this->start_controls_tabs( 'crafto_read_more_tabs' );

			$this->start_controls_tab(
				'crafto_read_more_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_read_more_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.elementor-button .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_read_more_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.elementor-button i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_post_read_more_button_icon[value]!' => '',
					],
				],
			);
			$this->add_control(
				'crafto_read_more_double_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button.btn-double-border, {{WRAPPER}}  a.elementor-button.btn-double-border::after, {{WRAPPER}}  a.elementor-button.elementor-button, {{WRAPPER}}  a.elementor-button.elementor-animation-btn-expand-ltr .btn-hover-animation' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_read_more_background_color',
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
					'selector'  => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} a.elementor-button.elementor-animation-btn-expand-ltr .btn-hover-animation',
					'condition' => [
						'crafto_button_style!' => [
							'border',
							'double-border',
							'underline',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_read_more_shape_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-round .elementor-button-icon, {{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-circle .elementor-button-icon ',
					'condition'      => [
						'crafto_button_style!'    => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style' => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						'crafto_post_read_more_button_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_read_more_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-button',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_read_more_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_read_more_hover_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-content-wrapper, {{WRAPPER}} a.elementor-button:focus .elementor-button-content-wrapper' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_read_more_hover_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover i, {{WRAPPER}} a.elementor-button:focus i, {{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-round:hover .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-circle:hover .elementor-button-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_post_read_more_button_icon[value]!' => '',
					],
				],
			);
			$this->add_control(
				'crafto_read_more_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} a.elementor-button.btn-double-border:hover, {{WRAPPER}} a.elementor-button.btn-double-border:hover:after, {{WRAPPER}} a.elementor-button.btn-double-border:focus, {{WRAPPER}} a.elementor-button.elementor-animation-btn-expand-ltr:hover .btn-hover-animation'                                                         => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.btn-double-border:hover, {{WRAPPER}} a.elementor-button.btn-double-border:hover:after'                  => 'border-color: {{VALUE}} !important;',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_read_more_hover_background_color',
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
					'condition' => [
						'crafto_button_style!' => [
							'double-border',
							'underline',
							'expand-border',
						],
					],
					'selector'  => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} a.elementor-button:focus',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_read_more_hover_shape_background_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-round:hover .elementor-button-icon, {{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-circle:hover .elementor-button-icon',
					'condition'      => [
						'crafto_button_style!'    => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_icon_shape_style' => [
							'btn-icon-round',
							'btn-icon-circle',
						],
						'crafto_post_read_more_button_icon[value]!' => '',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Shape Background Type', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_read_more_hover_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-button:hover',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_read_more_underline_height',
				[
					'label'     => esc_html__( 'Border Thickness', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-button-wrapper .elementor-button.btn-underline' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_button_style' => [
							'underline',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_read_more_border',
					'selector'       => '{{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-button.elementor-animation-btn-expand-ltr .btn-hover-animation',
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
					],
					'exclude'        => [
						'color',
					],
					'condition'      => [
						'crafto_button_style!' => [
							'double-border',
							'underline',
						],
					],
				]
			);
			$this->add_control(
				'crafto_read_more_border_radius',
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
						'{{WRAPPER}} a.elementor-button, {{WRAPPER}} a.elementor-button::after' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_button_style!' => [
							'underline',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_read_more_padding',
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
						'{{WRAPPER}} .elementor-button:not(.btn-double-border), {{WRAPPER}} a.btn-double-border .elementor-button-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_read_more_margin',
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
						'{{WRAPPER}} .elementor-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_image_overlay_heading',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_enable_overlay' => 'yes',
						'crafto_blog_style!'         => [
							'blog-classic',
							'blog-grid',
							'hero-blog',
							'blog-masonry',
							'blog-side-image',
							'blog-standard',
							'blog-split',
							'blog-modern',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_image_overlay_tabs' );
				$this->start_controls_tab(
					'crafto_image_overlay_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_blog_style!' => [
								'blog-classic',
								'blog-metro',
								'blog-grid',
								'blog-simple',
								'hero-blog',
								'blog-only-text',
								'blog-full-image',
							],
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_overlay_color',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} ul:not(.blog-metro, .blog-simple) .blog-post-images, {{WRAPPER}} ul:not(.blog-simple) .blog-post-images .blog-overlay, {{WRAPPER}} .blog-simple .blog-post-images .box-gradient-overlay, {{WRAPPER}} .blog-only-text .box-overlay',
						'condition' => [
							'crafto_blog_style!' => [
								'blog-masonry',
								'blog-classic',
								'blog-side-image',
								'hero-blog',
								'blog-standard',
								'blog-grid',
							],
						],
					]
				);
				$this->add_control(
					'crafto_image_opacity',
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
							'{{WRAPPER}} ul:not(.blog-metro, .blog-simple) .blog-post-images, {{WRAPPER}} ul:not(.blog-simple) .blog-post-images .blog-overlay, {{WRAPPER}} .blog-simple .blog-post-images .box-gradient-overlay' => 'opacity: {{SIZE}};',
						],
						'condition'  => [
							'crafto_blog_style!' => [
								'blog-classic',
								'blog-grid',
								'hero-blog',
								'blog-only-text',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_image_overlay_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_blog_style!' => [
								'blog-classic',
								'blog-metro',
								'blog-grid',
								'blog-simple',
								'hero-blog',
								'blog-only-text',
								'blog-full-image',
							],
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_overlay_hover_color',
						'exclude'   => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'  => '{{WRAPPER}} ul:not(.blog-metro) .blog-post-images:hover, {{WRAPPER}} .blog-post-images:hover .blog-overlay',
						'condition' => [
							'crafto_blog_style!' => [
								'blog-masonry',
								'blog-classic',
								'blog-simple',
								'blog-side-image',
								'hero-blog',
								'blog-metro',
								'blog-standard',
								'blog-grid',
								'blog-only-text',
								'blog-full-image',
							],
						],
					]
				);
				$this->add_control(
					'crafto_image_overlay_hover_opacity',
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
							'{{WRAPPER}} ul:not(.blog-metro) .blog-post-images:hover, {{WRAPPER}} .blog-post-images:hover .blog-overlay' => 'opacity: {{SIZE}};',
						],
						'condition'  => [
							'crafto_blog_style!' => [
								'blog-classic',
								'blog-metro',
								'blog-grid',
								'blog-simple',
								'hero-blog',
								'blog-only-text',
								'blog-full-image',
							],
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_post_meta_box_overlay_settings',
				[
					'label'     => esc_html__( 'Box Overlay Settings', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_blog_style' => [
							'blog-simple',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_blog_list_box_overlay_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .box-overlay, {{WRAPPER}} .blog-simple .post-details .box-overlay',
					'condition' => [
						'crafto_blog_style' => [
							'blog-simple',
						],
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
						'relation' => 'or',
						'terms'    => [
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_pagination',
										'operator' => '===',
										'value'    => 'number-pagination',
									],
									[
										'name'     => 'crafto_enable_filter',
										'operator' => '===',
										'value'    => '',
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
									[
										'name'     => 'crafto_enable_filter',
										'operator' => '===',
										'value'    => '',
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
									[
										'name'     => 'crafto_enable_filter',
										'operator' => '===',
										'value'    => '',
									],
								],
							],
						],
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
				'crafto_section_blog_filter_general_style',
				[
					'label'      => esc_html__( 'Filter', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_post_type_source' => 'post',
						'crafto_enable_filter'    => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_section_blog_filter_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
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
					'selectors' => [
						'{{WRAPPER}} .blog-grid-filter' => 'justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_blog_filter_bg_color',
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
					'selector' => '{{WRAPPER}} .blog-grid-filter',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_blog_filter_border',
					'selector' => '{{WRAPPER}} .blog-grid-filter.nav-tabs',
				]
			);
			$this->add_control(
				'crafto_blog_filter_border_radius',
				[
					'label'     => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .blog-grid-filter' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_filter_padding',
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
						'{{WRAPPER}} .blog-grid-filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_filter_margin',
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
						'{{WRAPPER}} .blog-grid-filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_blog_filter_box_shadow',
					'selector' => '{{WRAPPER}} .blog-grid-filter',
				]
			);
			$this->add_control(
				'crafto_blog_filter_items_style_heading',
				[
					'label'     => esc_html__( 'Filter', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blog_filter_items_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .blog-grid-filter li span',
				]
			);
			$this->start_controls_tabs( 'crafto_blog_filter_items_tabs' );
				$this->start_controls_tab( 'crafto_blog_filter_items_normal_tab', [ 'label' => esc_html__( 'Normal', 'crafto-addons' ) ] );
					$this->add_control(
						'crafto_blog_filter_items_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .blog-grid-filter > li > span' => 'color: {{VALUE}};',
								'{{WRAPPER}} .blog-grid-filter li.active span' => 'border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab( 'crafto_blog_filter_items_hover_tab', [ 'label' => esc_html__( 'Hover', 'crafto-addons' ) ] );
					$this->add_control(
						'crafto_blog_filter_items_hover_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .blog-grid-filter > li > span:hover, {{WRAPPER}} .blog-grid-filter > li.active > span' => 'color: {{VALUE}}; border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_blog_filter_separator_width',
				[
					'label'      => esc_html__( 'Border Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-grid-filter li span' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_filter_items_padding',
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
						'{{WRAPPER}} .blog-grid-filter li span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blog_filter_items_margin',
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
						'{{WRAPPER}} .blog-grid-filter li span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render blog list widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {

			$settings                          = $this->get_settings_for_display();
			$crafto_blog_style                 = $this->get_settings( 'crafto_blog_style' );
			$crafto_post_type_source           = $this->get_settings( 'crafto_post_type_source' );
			$crafto_donation_form              = $this->get_settings( 'crafto_enable_donation_form' );
			$crafto_post_type_selection        = $this->get_settings( 'crafto_post_type_selection' );
			$crafto_include_exclude_post_ids   = $this->get_settings( 'crafto_include_exclude_post_ids' );
			$crafto_include_post_ids           = $this->get_settings( 'crafto_include_post_ids' );
			$crafto_exclude_post_ids           = $this->get_settings( 'crafto_exclude_post_ids' );
			$crafto_show_post_title            = $this->get_settings( 'crafto_show_post_title' );
			$crafto_show_post_count            = $this->get_settings( 'crafto_show_post_count' );
			$crafto_ignore_sticky_posts        = $this->get_settings( 'crafto_ignore_sticky_posts' );
			$crafto_post_per_page              = $this->get_settings( 'crafto_post_per_page' );
			$crafto_enable_filter              = $this->get_settings( 'crafto_enable_filter' );
			$crafto_categories_list            = $this->get_settings( 'crafto_categories_list' );
			$crafto_tags_list                  = $this->get_settings( 'crafto_tags_list' );
			$crafto_filter_post_type_selection = $this->get_settings( 'crafto_filter_post_type_selection' );
			$crafto_filter_categories_list     = $this->get_settings( 'crafto_filter_categories_list' );
			$crafto_filter_tags_list           = $this->get_settings( 'crafto_filter_tags_list' );
			$show_all_text_filter              = $this->get_settings( 'crafto_show_all_text_filter' );
			$show_all_label                    = $this->get_settings( 'crafto_show_all_label' );
			$default_category_selected         = $this->get_settings( 'crafto_default_category_selected' );
			$default_tags_selected             = $this->get_settings( 'crafto_default_tags_selected' );
			$post_categories_orderby           = $this->get_settings( 'crafto_post_categories_orderby' );
			$post_categories_order             = $this->get_settings( 'crafto_post_categories_order' );
			$crafto_image_grey_scale           = $this->get_settings( 'crafto_image_grey_scale' );
			$crafto_offset                     = $this->get_settings( 'crafto_offset' );

			/* Column Settings */
			$crafto_column_desktop_column = ! empty( $settings['crafto_column_settings'] ) ? $settings['crafto_column_settings'] : '3';
			$crafto_column_class_list     = '';
			$crafto_column_ratio          = '';

			if ( 'blog-side-image' !== $crafto_blog_style || 'hero-blog' !== $crafto_blog_style ) {
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

			$crafto_enable_masonry                  = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';
			$crafto_show_post_like                  = ( isset( $settings['crafto_show_post_like'] ) && $settings['crafto_show_post_like'] ) ? $settings['crafto_show_post_like'] : '';
			$crafto_image_position                  = ( isset( $settings['crafto_image_position'] ) && $settings['crafto_image_position'] ) ? $settings['crafto_image_position'] : '';
			$crafto_show_post_format                = ( isset( $settings['crafto_show_post_format'] ) && $settings['crafto_show_post_format'] ) ? $settings['crafto_show_post_format'] : '';
			$crafto_show_post_date                  = ( isset( $settings['crafto_show_post_date'] ) && $settings['crafto_show_post_date'] ) ? $settings['crafto_show_post_date'] : '';
			$crafto_post_change_date_format         = ( isset( $settings['crafto_post_change_date_format'] ) && $settings['crafto_post_change_date_format'] ) ? $settings['crafto_post_change_date_format'] : '';
			$crafto_post_icon                       = ( isset( $settings['crafto_post_icon'] ) && $settings['crafto_post_icon'] ) ? $settings['crafto_post_icon'] : '';
			$crafto_show_post_author_icon           = ( isset( $settings['crafto_show_post_author_icon'] ) && $settings['crafto_show_post_author_icon'] ) ? $settings['crafto_show_post_author_icon'] : '';
			$crafto_separator                       = ( isset( $settings['crafto_separator'] ) && $settings['crafto_separator'] ) ? $settings['crafto_separator'] : '';
			$crafto_show_post_thumbnail             = ( isset( $settings['crafto_show_post_thumbnail'] ) && $settings['crafto_show_post_thumbnail'] ) ? $settings['crafto_show_post_thumbnail'] : '';
			$crafto_show_post_category              = ( isset( $settings['crafto_show_post_category'] ) && $settings['crafto_show_post_category'] ) ? $settings['crafto_show_post_category'] : '';
			$crafto_category_limit                  = ( isset( $settings['crafto_category_limit'] ) && $settings['crafto_category_limit'] ) ? $settings['crafto_category_limit'] : '1';
			$crafto_show_post_author                = ( isset( $settings['crafto_show_post_author'] ) && $settings['crafto_show_post_author'] ) ? $settings['crafto_show_post_author'] : '';
			$crafto_show_post_author_image          = ( isset( $settings['crafto_show_post_author_image'] ) && $settings['crafto_show_post_author_image'] ) ? $settings['crafto_show_post_author_image'] : '';
			$crafto_show_post_excerpt               = ( isset( $settings['crafto_show_post_excerpt'] ) && $settings['crafto_show_post_excerpt'] ) ? $settings['crafto_show_post_excerpt'] : '';
			$crafto_show_post_comments              = ( isset( $settings['crafto_show_post_comments'] ) && $settings['crafto_show_post_comments'] ) ? $settings['crafto_show_post_comments'] : '';
			$crafto_show_overlay                    = ( isset( $settings['crafto_post_enable_overlay'] ) && $settings['crafto_post_enable_overlay'] ) ? $settings['crafto_post_enable_overlay'] : '';
			$crafto_show_post_read_more_button      = ( isset( $settings['crafto_show_post_read_more_button'] ) && $settings['crafto_show_post_read_more_button'] ) ? $settings['crafto_show_post_read_more_button'] : '';
			$crafto_post_date_format                = ( isset( $settings['crafto_post_date_format'] ) && $settings['crafto_post_date_format'] ) ? $settings['crafto_post_date_format'] : '';
			$crafto_thumbnail                       = ( isset( $settings['crafto_thumbnail'] ) && $settings['crafto_thumbnail'] ) ? $settings['crafto_thumbnail'] : 'full';
			$crafto_show_post_thumbnail_icon        = ( isset( $settings['crafto_show_post_thumbnail_icon'] ) && $settings['crafto_show_post_thumbnail_icon'] ) ? $settings['crafto_show_post_thumbnail_icon'] : '';
			$crafto_post_excerpt_length             = ( isset( $settings['crafto_post_excerpt_length'] ) && $settings['crafto_post_excerpt_length'] ) ? $settings['crafto_post_excerpt_length'] : '';
			$crafto_blog_list_content_box_alignment = ( isset( $settings['crafto_blog_list_content_box_alignment'] ) && $settings['crafto_blog_list_content_box_alignment'] ) ? $settings['crafto_blog_list_content_box_alignment'] : '';
			$crafto_orderby                         = ( isset( $settings['crafto_orderby'] ) && $settings['crafto_orderby'] ) ? $settings['crafto_orderby'] : '';
			$crafto_order                           = ( isset( $settings['crafto_order'] ) && $settings['crafto_order'] ) ? $settings['crafto_order'] : '';
			$crafto_show_post_author_text           = $this->get_settings( 'crafto_show_post_author_text' );

			// Entrance Animation.
			$crafto_blog_grid_animation          = ( isset( $settings['crafto_blog_grid_animation'] ) && $settings['crafto_blog_grid_animation'] ) ? $settings['crafto_blog_grid_animation'] : '';
			$crafto_blog_grid_animation_duration = ( isset( $settings['crafto_blog_grid_animation_duration'] ) && $settings['crafto_blog_grid_animation_duration'] ) ? $settings['crafto_blog_grid_animation_duration'] : '';
			$crafto_blog_grid_animation_delay    = ( isset( $settings['crafto_blog_grid_animation_delay'] ) && $settings['crafto_blog_grid_animation_delay'] ) ? $settings['crafto_blog_grid_animation_delay'] : 100;

			// Pagination.
			$crafto_pagination = ( isset( $settings['crafto_pagination'] ) && $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';

			$crafto_alignment_main_class = '';
			switch ( $crafto_blog_list_content_box_alignment ) {
				case 'center':
					$crafto_alignment_main_class = 'text-center';
					break;
				case 'right':
					$crafto_alignment_main_class = 'text-end';
					break;
			}

			if ( 'yes' === $crafto_enable_filter && 'post' === $crafto_post_type_source ) {
				if ( 'post_tag' === $crafto_filter_post_type_selection ) {
					$categories_to_display_ids = ( ! empty( $crafto_filter_tags_list ) ) ? $crafto_filter_tags_list : [];
				} else {
					$categories_to_display_ids = ( ! empty( $crafto_filter_categories_list ) ) ? $crafto_filter_categories_list : [];
				}

				// If no categories are chosen or "All categories", we need to load all available categories.
				if ( ! is_array( $categories_to_display_ids ) || count( $categories_to_display_ids ) === 0 ) {
					$terms = get_terms( $crafto_filter_post_type_selection );
					if ( ! is_array( $categories_to_display_ids ) ) {
						$categories_to_display_ids = [];
					}
					foreach ( $terms as $term ) {
						$categories_to_display_slug[] = $term->slug;
					}
				} elseif ( ! empty( $categories_to_display_ids ) && ! is_wp_error( $categories_to_display_ids ) ) {
					foreach ( $categories_to_display_ids as $slug ) {
						$categories_to_display_slug[] = $slug;
					}
				}

				$query_filter_args = [];
				if ( ! empty( $categories_to_display_slug ) ) {
					$query_filter_args['slug'] = $categories_to_display_slug;
				}

				if ( ! empty( $post_categories_orderby ) ) {
					$query_filter_args['orderby'] = $post_categories_orderby;
				}

				if ( ! empty( $post_categories_order ) ) {
					$query_filter_args['order'] = $post_categories_order;
				}

				if ( ! empty( $crafto_filter_post_type_selection ) ) {
					$query_filter_args['taxonomy'] = $crafto_filter_post_type_selection;
				}

				$tax_terms = get_terms( $query_filter_args );

				if ( is_array( $tax_terms ) && 0 === count( $tax_terms ) ) {
					return;
				}

				$this->add_render_attribute(
					'filter_wrapper',
					[
						'class' => [
							'blog-grid-filter',
							'nav',
							'nav-tabs',
						],
					]
				);
				?>
				<ul <?php $this->print_render_attribute_string( 'filter_wrapper' ); ?>>
					<?php
					$active_class = '';
					if ( 'post_tag' === $crafto_filter_post_type_selection ) {
						if ( 'yes' === $show_all_text_filter ) {
							$active_class = empty( $default_tags_selected ) ? 'active' : '';
						}
					} elseif ( 'yes' === $show_all_text_filter ) {
							$active_class = empty( $default_category_selected ) ? 'active' : '';
					}
					$this->add_render_attribute(
						'filter_li',
						[
							'class' => [
								'nav',
								$active_class,
							],
						],
					);

					$this->add_render_attribute(
						'filter_a',
						[
							'data-filter' => '*',
						]
					);

					if ( 'yes' === $show_all_text_filter ) {
						?>
						<li <?php $this->print_render_attribute_string( 'filter_li' ); ?>>
							<span <?php $this->print_render_attribute_string( 'filter_a' ); ?>>
								<?php
								echo esc_html( $show_all_label );
								?>
							</span>
						</li>
						<?php
					}

					foreach ( $tax_terms as $index => $tax_term ) {
						$active_class  = '';
						$filter_li_key = 'filter_li' . $index;
						$filter_a_key  = 'filter_a' . $index;

						if ( 'post_tag' === $crafto_filter_post_type_selection ) {
							$active_class = ( $default_tags_selected === $tax_term->slug ) ? 'active' : '';
						} else {
							$active_class = ( $default_category_selected === $tax_term->slug ) ? 'active' : '';
						}
						$this->add_render_attribute( $filter_li_key, [ 'class' => [ 'nav', $active_class ] ] );
						$this->add_render_attribute(
							$filter_a_key,
							[
								'data-filter' => '.blog-filter-' . $tax_term->term_id,
							]
						);
						?>
						<li <?php $this->print_render_attribute_string( $filter_li_key ); ?>>
							<span <?php $this->print_render_attribute_string( $filter_a_key ); ?>>
								<?php echo esc_html( $tax_term->name ); ?>
							</span>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			}

			$datasettings = array(
				'pagination_type' => $crafto_pagination,
			);

			$this->add_render_attribute(
				'wrapper',
				[
					'class'              => [
						'grid',
						'crafto-blog-list',
						'yes' === $settings['crafto_section_enable_grid_preloader'] ? 'grid-loading' : '',
						$crafto_blog_style,
						$crafto_column_class_list,
					],
					'data-blog-settings' => wp_json_encode( $datasettings ),
				]
			);

			if ( ! empty( $crafto_pagination ) ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					$crafto_pagination
				);
			}

			switch ( $crafto_blog_style ) {
				case 'blog-grid':
				case 'blog-classic':
				case 'blog-simple':
				case 'blog-modern':
				case 'blog-standard':
				case 'blog-side-image':
				case 'hero-blog':
				case 'blog-only-text':
				case 'blog-split':
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
					break;
				case 'blog-masonry':
				case 'blog-metro':
				case 'blog-full-image':
					$this->add_render_attribute(
						'wrapper',
						'class',
						'grid-masonry'
					);
					break;
			}

			if ( 'yes' === $crafto_image_position ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					'side-image-right'
				);
			}

			if ( '' !== $this->get_settings( 'crafto_blog_metro_positions' ) ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					'blog-metro-active'
				);
			}

			if ( 'yes' === $crafto_donation_form && 'blog-grid' === $crafto_blog_style && class_exists( 'Give' ) ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					'donation-form'
				);
			}

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$query_args = array(
				'post_status'    => 'publish',
				'posts_per_page' => intval( $crafto_post_per_page ), // phpcs:ignore
				'paged'          => $paged,
			);

			if ( ! empty( $crafto_offset ) ) {
				$query_args['offset'] = $crafto_offset;
			}

			if ( 'yes' === $crafto_donation_form && 'blog-grid' === $crafto_blog_style && class_exists( 'Give' ) ) {
				$query_args['post_type'] = 'give_forms';
			} elseif ( 'related' === $crafto_post_type_source ) {
				$query_args['post_type'] = 'post';
			} elseif ( ! empty( $crafto_post_type_source ) ) {
				$query_args['post_type'] = $crafto_post_type_source;
			} else {
				$query_args['post_type'] = 'post';
			}

			if ( 'post' === $crafto_post_type_source ) {
				if ( 'tags' === $crafto_post_type_selection ) {
					if ( ! empty( $crafto_tags_list ) ) {
						$valid_tags = [];
						foreach ( $crafto_tags_list as $tag_slug ) {
							if ( term_exists( $tag_slug, 'post_tag' ) ) {
								$valid_tags[] = $tag_slug;
							}
						}

						if ( ! empty( $valid_tags ) ) {
							$query_args['tag_slug__in'] = $valid_tags;
						}
					}
				} elseif ( ! empty( $crafto_categories_list ) ) {
					// Verify each category exists before using it.
					$valid_categories = [];
					foreach ( $crafto_categories_list as $category_slug ) {
						if ( term_exists( $category_slug, 'category' ) ) {
							$valid_categories[] = $category_slug;
						}
					}

					if ( ! empty( $valid_categories ) ) {
						$query_args['category_name'] = implode( ',', $valid_categories );
					}
				}
			} elseif ( 'related' === $crafto_post_type_source ) {
				$query_args['category__in'] = wp_get_post_categories( get_the_ID() );
				$query_args['post__not_in'] = array( get_the_ID() );
			}

			if ( 'yes' === $crafto_ignore_sticky_posts ) {
				$query_args['ignore_sticky_posts'] = true;
				if ( ! empty( $crafto_exclude_post_ids ) ) {
					$crafto_exclude_post_ids = array_merge( $crafto_exclude_post_ids, get_option( 'sticky_posts' ) );
				} elseif ( 'related' !== $crafto_post_type_source ) {
					$query_args['post__not_in'] = get_option( 'sticky_posts' );
				}
			}

			if ( 'include' === $crafto_include_exclude_post_ids ) {
				if ( ! empty( $crafto_include_post_ids && 'related' !== $crafto_post_type_source ) ) {
					$query_args['post__in'] = $crafto_include_post_ids;
				}
			} elseif ( 'exclude' === $crafto_include_exclude_post_ids ) {
				if ( ! empty( $crafto_exclude_post_ids && 'related' !== $crafto_post_type_source ) ) {
					$query_args['post__not_in'] = $crafto_exclude_post_ids;
				}
			}

			if ( ! empty( $crafto_orderby ) ) {
				$query_args['orderby'] = $crafto_orderby;
			}

			if ( ! empty( $crafto_order ) ) {
				$query_args['order'] = $crafto_order;
			}

			$the_query = new \WP_Query( $query_args );

			if ( $the_query->have_posts() ) {
				?>
				<ul <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<?php
					if ( 'blog-metro' === $crafto_blog_style ) {
						?>
						<li class="grid-sizer"></li>
						<?php
					} else {
						?>
						<li class="grid-sizer d-none p-0 m-0"></li>
						<?php
					}

					$index            = 0;
					$grid_count       = 1;
					$grid_metro_count = 1;
					$count_number     = 1;
					$i                = 1;

					while ( $the_query->have_posts() ) :
						$the_query->the_post();

						$count_number_text = ( $count_number < 10 ) ? '0' . $count_number : $count_number;

						if ( 'blog-side-image' !== $crafto_blog_style || 'hero-blog' !== $crafto_blog_style ) {
							if ( 0 === $index % $crafto_column_ratio ) {
								$grid_count = 1;
							}
						}

						$post_format       = get_post_format( get_the_ID() );
						$inner_wrapper_key = 'inner_wrapper_' . $index;
						$blog_post_key     = 'blog_post_' . $index;
						$image_key         = 'image_' . $index;
						$title_link_key    = 'title_' . $index;
						$custom_link_key   = 'custom_link_' . $index;
						$date_link_key     = 'date_' . $index;
						$overlay_link_key  = 'overlay_' . $index;
						$post_image_key    = 'post_image_' . $index;

						$post_cat     = [];
						$cat_slug_cls = [];
						$categories   = get_the_terms( get_the_ID(), 'category' );
						if ( $categories && ! is_wp_error( $categories ) ) {
							foreach ( $categories as $cat ) {
								$cat_slug_cls[] = 'blog-filter-' . $cat->term_id;
								$cat_link       = get_category_link( $cat->term_id );
								$post_cat[]     = '<a href="' . esc_url( $cat_link ) . '" rel="category tag">' . esc_html( $cat->name ) . '</a>';
							}
						}

						$tags = get_the_terms( get_the_ID(), 'post_tag' );
						if ( $tags && ! is_wp_error( $tags ) ) {
							foreach ( $tags as $tag ) {
								$cat_slug_cls[] = 'blog-filter-' . $tag->term_id;
								$cat_link       = get_category_link( $tag->term_id );
								$post_cat[]     = '<a href="' . esc_url( $cat_link ) . '" rel="category tag">' . esc_html( $tag->name ) . '</a>';
							}
						}

						$cat_slug_class_list = implode( ' ', $cat_slug_cls );
						$post_class_list     = get_post_class( array( 'grid-item', 'grid-gutter', $cat_slug_class_list ) );

						$this->add_render_attribute(
							$inner_wrapper_key,
							[
								'class' => $post_class_list,
							]
						);

						$this->add_render_attribute(
							$blog_post_key,
							[
								'class' => [
									'blog-post',
								],
							]
						);

						if ( ! empty( $crafto_alignment_main_class ) ) {

							$this->add_render_attribute(
								$blog_post_key,
								[
									'class' => [
										$crafto_alignment_main_class,
									],
								]
							);
						}

						// Entrance Animation.
						if ( '' !== $crafto_blog_grid_animation && 'none' !== $crafto_blog_grid_animation ) {
							$this->add_render_attribute(
								$inner_wrapper_key,
								[
									'class'                => [
										'crafto-animated',
										'elementor-invisible',
									],
									'data-animation'       => [
										$crafto_blog_grid_animation,
										$crafto_blog_grid_animation_duration,
									],
									'data-animation-delay' => $grid_count * $crafto_blog_grid_animation_delay,
								]
							);
						}

						$currency_symbol = '';
						if ( 'yes' === $crafto_donation_form && class_exists( 'Give' ) ) {
							$give_settings    = get_option( 'give_settings' );
							$give_goal_option = get_post_meta( get_the_ID(), '_give_goal_option' );
							$category         = get_the_term_list( get_the_ID(), 'give_forms_category' );
							$goal             = get_post_meta( get_the_ID(), '_give_set_goal' );
							$raised           = get_post_meta( get_the_ID(), '_give_form_earnings' );
							$percentage       = ( isset( $raised ) && ! empty( $raised ) && isset( $goal[0] ) && 0 !== $goal[0] ) ? ( $raised[0] / $goal[0] ) * 100 : '';
							$currency_symbol  = give_currency_symbol();

							if ( 100 < $percentage ) {
								$percentage = 100;
							}
						}

						$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
						$img_alt      = '';
						$img_alt      = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
						if ( empty( $img_alt ) ) {
							$img_alt = esc_attr( get_the_title( $thumbnail_id ) );
						}
						$this->add_render_attribute( $image_key, 'class', 'image-link' );
						$this->add_render_attribute( $image_key, 'aria-label', $img_alt );

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
								'class' => 'post-date published',
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

						$this->add_render_attribute(
							$post_image_key,
							[
								'href'   => $post_external_link,
								'target' => $post_link_target,
								'class'  => 'post-image-hover',
							],
						);

						switch ( $crafto_blog_style ) {
							case 'blog-grid':
								if ( 'yes' === $crafto_show_post_date || ( 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<?php
											if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
												?>
												<div class="blog-post-images">
													<?php
													if ( 'gallery' === $post_format && '' === $crafto_show_post_format ) {
														$this->crafto_post_gallery_format();
													} elseif ( 'video' === $post_format && '' === $crafto_show_post_format ) {
														$this->crafto_post_video_format(); // phpcs:ignore
													} elseif ( 'quote' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_quote_format(); // phpcs:ignore
													} elseif ( 'audio' === $post_format && '' === $crafto_show_post_format ) {
														$this->crafto_post_audio_format(); // phpcs:ignore
													} else {
														?>
														<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
															<?php
															$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
															$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
															if ( '' === $alt ) {
																$alt = get_the_title( $thumbnail_id );
															}
															echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
															if ( 'yes' === $crafto_show_post_thumbnail_icon ) {
																crafto_get_post_formats_icon(); // phpcs:ignore
															}
															?>
															<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
														</a>
														<?php
													}
													?>
												</div>
												<?php
											}

											if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments || ! empty( $show_excerpt_grid ) || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
												?>
												<div class="post-details">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<div class="blog-category alt-font">
															<?php
															if ( 'yes' === $crafto_donation_form && class_exists( 'Give' ) && 'enabled' === $give_settings['categories'] ) {
																echo $category; // phpcs:ignore
															}
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit );
															echo $crafto_post_category; // phpcs:ignore
															?>
														</div>
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
															<p class="entry-content">
																<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); ?>
															</p>
															<?php
														}
													}

													if ( 'yes' === $crafto_donation_form && class_exists( 'Give' ) && isset( $give_goal_option[0] ) && 'enabled' === $give_goal_option[0] && ! empty( $percentage ) && ! empty( $goal ) && ! empty( $raised ) ) {
														$goal_amount   = ( isset( $goal[0] ) && $goal[0] ) ? (int) $goal[0] : 0;
														$raised_amount = ( isset( $raised[0] ) && $raised[0] ) ? (int) $raised[0] : 0;
														?>
														<div class="crafto-donation-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo esc_attr( (int) $percentage ); ?>">
															<div class="donation-progress-bar" data-max="<?php echo esc_attr( (int) $percentage ); ?>">
																<span class="elementor-progress-percentage">
																	<?php echo esc_html( (int) $percentage ) . esc_html__( '%', 'crafto-addons' ); ?>
																</span>
															</div>
														</div>
														<div class="donation-amount">
															<div class="goal-amount">
																<span><?php echo esc_html__( 'Goal: ', 'crafto-addons' ); ?></span>
																<?php echo esc_html( $currency_symbol . number_format( $goal_amount ) ); ?>
															</div>
															<div class="raised-amount">
																<span><?php echo esc_html__( 'Raised: ', 'crafto-addons' ); ?></span>
																<?php echo esc_html( $currency_symbol . number_format( $raised_amount ) ); ?>
															</div>
														</div>
														<?php
													}

													if ( 'yes' !== $crafto_donation_form && ! class_exists( 'Give' ) ) {
														if ( 'yes' === $crafto_show_post_read_more_button ) {
															crafto_post_read_more_button( $this, $index ); // phpcs:ignore
														}
													}
													if ( 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_date || ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) || ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) ) {
														$class = '';
														if ( 'yes' === $crafto_show_post_author && get_the_author() && '' === $crafto_show_post_date ) {
															$class = ' auther-on';
														} elseif ( 'yes' === $crafto_show_post_date && '' === $crafto_show_post_author ) {
															$class = ' date-on';
														}
														?>
														<div class="post-meta post-meta-grid d-flex align-items-center<?php echo esc_html( $class ); ?>">
															<?php
															if ( 'yes' === $crafto_show_post_author && get_the_author() || 'yes' === $crafto_show_post_date ) {
																?>
																<div class="post-author-meta">
																	<?php
																	if ( 'yes' === $crafto_show_post_date ) {
																		?>
																		<span class="post-date published">
																			<?php
																			if ( 'yes' === $crafto_post_icon ) {
																				?>
																				<i class="feather icon-feather-calendar"></i>
																				<?php
																			}
																			?>
																			<span>
																				<?php echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ); ?>
																			</span>
																		</span>
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
																			?>
																			<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
																		</div>
																		<?php
																	}
																	?>
																</div>
																<?php
															}
															if ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) {
																?>
																<span class="post-meta-like">
																	<?php echo crafto_blog_post_like_button( get_the_ID() ); // phpcs:ignore ?>
																</span>
																<?php
															}
															if ( 'yes' !== $crafto_donation_form && ! class_exists( 'Give' ) ) {
																if ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
																	$this->crafto_post_comments();
																}
															}
															?>
														</div>
														<?php
													}
													?>
												</div>
												<?php
												if ( 'yes' === $crafto_donation_form && class_exists( 'Give' ) ) {
													if ( 'yes' === $crafto_show_post_read_more_button ) {
														crafto_post_read_more_button( $this, $index ); // phpcs:ignore
													}
												}
											}
											?>
										</div>
									</li>
									<?php
								}
								break;
							case 'blog-classic':
								if ( 'yes' === $crafto_show_post_date || ( 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div class="blog-post">
											<?php
											if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
												?>
												<div class="blog-post-images">
													<?php
													if ( 'gallery' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_gallery_format(); // phpcs:ignore
													} elseif ( 'video' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_video_format(); // phpcs:ignore
													} elseif ( 'quote' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_quote_format(); // phpcs:ignore
													} elseif ( 'audio' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_audio_format(); // phpcs:ignore
													} else {
														?>
														<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
															<?php
															$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
															$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
															if ( '' === $alt ) {
																$alt = get_the_title( $thumbnail_id );
															}
															if ( 'yes' === $crafto_image_grey_scale ) {
																echo get_the_post_thumbnail(
																	get_the_ID(),
																	$crafto_thumbnail,
																	array(
																		'alt' => $alt,
																		'class' => 'image-greyscale',
																	)
																);
															} else {
																echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
															}
															if ( 'yes' === $crafto_show_post_thumbnail_icon ) {
																crafto_get_post_formats_icon(); // phpcs:ignore
															}
															?>
															<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
														</a>
														<?php
													}
													?>
												</div>
												<?php
											}
											?>
											<div class="post-details">
												<?php
												if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date || 'yes' === $crafto_post_icon || 'yes' === $crafto_show_post_author ) {
													?>
													<div class="post-author-meta">
														<?php
														if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_author ) {
															?>
															<div class="blog-category alt-font">
																<?php
																if ( 'yes' === $crafto_show_post_author ) {
																	?>
																	<div class="author-name">
																		<?php
																		if ( 'yes' === $crafto_show_post_author_image ) {
																			$alt = get_the_author_meta( 'display_name' );
																			echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
																		}
																		if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
																			?>
																			<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
																			<?php
																		}
																		?>
																	</div>
																	<?php
																}
																if ( 'yes' === $crafto_show_post_category ) {
																	$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit );
																	echo $crafto_post_category; // phpcs:ignore
																}
														}
														if ( 'yes' === $crafto_show_post_date ) {
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
														if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_author ) {
															?>
															</div>
															<?php
														}
														?>
													</div>
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
														<p class="entry-content">
															<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
														</p>
														<?php
													}
												}
												if ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
													?>
													<div class="post-meta d-flex align-items-center">
														<?php
														if ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) {
															?>
															<span class="post-meta-like">
																<?php echo crafto_blog_post_like_button( get_the_ID() ); // phpcs:ignore ?>
															</span>
															<?php
														}
														if ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
															$this->crafto_post_comments();
														}
														?>
													</div>
													<?php
												}
												if ( 'yes' === $crafto_show_post_read_more_button ) {
													crafto_post_read_more_button( $this, $index ); // phpcs:ignore
												}
												?>
											</div>
										</div>
									</li>
									<?php
								}
								break;
							case 'blog-metro':
								$crafto_blog_metro_positions = $this->get_settings( 'crafto_blog_metro_positions' );
								$crafto_double_grid_position = ! empty( $crafto_blog_metro_positions ) ? array_map( 'intval', explode( ',', $crafto_blog_metro_positions ) ) : [];

								if ( ! empty( $crafto_double_grid_position ) && in_array( $grid_metro_count, $crafto_double_grid_position, true ) ) {
									$this->add_render_attribute(
										$inner_wrapper_key,
										[
											'class' => 'grid-item-double',
										],
									);
								}

								if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_title ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<figure <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<div class="blog-post-images">
												<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
													<?php
													if ( has_post_thumbnail() ) {
														$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
														$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
														if ( '' === $alt ) {
															$alt = get_the_title( $thumbnail_id );
														}
														echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
													} else {
														?>
														<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title(); ?>">
														<?php
													}
													?>
													<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
												</a>
												<?php
												if ( 'yes' === $crafto_show_overlay ) {
													?>
													<div class="blog-overlay"></div>
													<?php
												}
												?>
											</div>
											<?php
											if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_author ) {
												?>
												<figcaption class="content">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit ); // phpcs:ignore
															echo $crafto_post_category; // phpcs:ignore
															?>
														</span>
														<?php
													}
													if ( 'yes' === $crafto_show_post_date ) {
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
													if ( 'yes' === $crafto_show_post_title ) {
														?>
														<a <?php $this->print_render_attribute_string( $title_link_key ); ?>><?php the_title(); ?></a>
														<?php
													}
													if ( 'yes' === $crafto_show_post_author_image || 'yes' === $crafto_show_post_author ) {
														?>
														<div class="post-details">
															<div class="author-name">
																<?php
																if ( 'yes' === $crafto_show_post_author_image ) {
																	$alt = get_the_author_meta( 'display_name' );
																	echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
																}
																if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
																	?>
																	<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
																	<?php
																}
																?>
															</div>
														</div>
														<?php
													}
													?>
												</figcaption>
												<?php
											}
											?>
										</figure>
									</li>
									<?php
								}
								break;
							case 'blog-masonry':
								if ( 'yes' === $crafto_show_post_date || ( 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<div class="post-meta d-flex align-items-center">
												<?php
												if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
													?>
													<span class="author-name">
														<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
															<?php
															if ( 'yes' === $crafto_show_post_author_image ) {
																$alt = get_the_author_meta( 'display_name' );
																echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
															}
															?>
															<span class="screen-reader-text"><?php echo esc_html__( 'Author', 'crafto-addons' ); ?></span>
														</a>
														<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?><span class="screen-reader-text"><?php echo esc_html__( 'Author', 'crafto-addons' ); ?></span></a></span>
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
											if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
												?>
												<div class="blog-post-images">
													<?php
													if ( 'gallery' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_gallery_format(); // phpcs:ignore
													} elseif ( 'video' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_video_format(); // phpcs:ignore
													} elseif ( 'quote' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_quote_format(); // phpcs:ignore
													} elseif ( 'audio' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_audio_format(); // phpcs:ignore
													} else { ?>
														<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
															<?php
															$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
															$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
															if ( '' === $alt ) {
																$alt = get_the_title( $thumbnail_id );
															}
															echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
															if ( 'yes' === $crafto_show_post_thumbnail_icon ) {
																crafto_get_post_formats_icon(); // phpcs:ignore
															}
															?>
															<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
														</a>
														<?php
													}
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit ); // phpcs:ignore
															echo $crafto_post_category; // phpcs:ignore
															?>
														</span>
														<?php
													}
													?>
												</div>
												<?php
											}
											if ( 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_read_more_button ) {
												?>
												<div class="post-details">
													<?php
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
																<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
															</div>
															<?php
														}
													}
													if ( 'yes' === $crafto_show_post_read_more_button ) {
														crafto_post_read_more_button( $this, $index ); // phpcs:ignore
													}
													if ( 'yes' === $crafto_show_post_date ) {
														?>
														<div class="d-flex align-items-center post-date-wrapper">
															<?php
															if ( 'yes' === $crafto_post_icon ) {
																?>
																<i class="feather icon-feather-calendar"></i>
																<?php
															}
															?>
															<span><?php echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ); ?></span>
														</div>
														<?php
													}
													?>
												</div>
												<?php
											}
											?>
										</div>
									</li>
									<?php
								}
								break;
							case 'blog-simple':
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
									<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
										<div class="blog-post-images">
											<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
												<?php
												if ( has_post_thumbnail() ) {
													$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
													$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
													if ( '' === $alt ) {
														$alt = get_the_title( $thumbnail_id );
													}
													echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
												} else {
													?>
													<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title(); ?>">
													<?php
												}
												?>
												<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
											</a>
											<?php
											if ( 'yes' === $crafto_show_overlay ) {
												?>
												<span class="box-overlay"></span>
												<span class="box-gradient-overlay"></span>
												<?php
											}
											?>
										</div>
										<?php
										if ( 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date ) {
											?>
											<div class="post-content-wrapper">
												<?php
												$is_new        = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
												$icon_migrated = isset( $settings['__fa4_migrated']['crafto_blog_list_icon'] );
												if ( $is_new || $icon_migrated ) {
													?>
													<div class="blog-hover-icon">
														<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
															<?php Icons_Manager::render_icon( $settings[ 'crafto_blog_list_icon' ] ); // phpcs:ignore ?>
															<span class="screen-reader-text"><?php echo esc_html__( 'Hover Icon', 'crafto-addons' ); ?></span>
														</a>
													</div>
													<?php
												}
												?>
												<div class="post-details">
													<div class="post-details-wrapper">
														<?php
														if ( 'yes' === $crafto_show_post_category ) {
															?>
															<span class="blog-category alt-font">
																<?php
																$crafto_post_category = crafto_post_category( get_the_ID(), true, $crafto_category_limit ); // phpcs:ignore
																echo $crafto_post_category; // phpcs:ignore
																?>
															</span>
															<?php
														}
														if ( 'yes' === $crafto_show_post_date && 'yes' === $crafto_post_icon ) {
															?>
															<span class="post-date published">
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
														} elseif ( 'yes' === $crafto_show_post_date ) {
															echo '<span class="post-date published">' . esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ) . '</span><time class="updated d-none" datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date( $crafto_post_date_format ) ) . '</time>';
														}
														if ( 'yes' === $crafto_show_post_title ) {
															?>
															<a <?php $this->print_render_attribute_string( $title_link_key ); ?>><?php the_title(); ?></a>
															<?php
														}
														?>
														<div class="hover-text">
															<?php
															if ( 'yes' === $crafto_show_post_read_more_button ) {
																crafto_post_read_more_button( $this, $index ); // phpcs:ignore
															}
															?>
														</div>
													</div>
													<div class="box-overlay"></div>
												</div>
											</div>
											<?php
										}
										?>
									</div>
								</li>
								<?php
								break;
							case 'blog-side-image':
								$this->add_render_attribute(
									$blog_post_key,
									[
										'class' => [
											'd-md-flex d-block flex-row h-100',
										],
									],
								);
								if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<?php
											$featured_img_url  = get_the_post_thumbnail_url( get_the_ID(), $crafto_thumbnail );
											$featured_bg_style = ( $featured_img_url ) ? ' style="background-image: url(\'' . esc_url( $featured_img_url ) . '\');"' : '';
											if ( ! post_password_required() && ! empty( $featured_img_url ) ) {
												?>
												<div class="blog-post-images">
												<div class="post-image-wrap" <?php echo $featured_bg_style; //phpcs:ignore ?>>
													<a <?php $this->print_render_attribute_string( $post_image_key ); ?>></a>
												</div>
												</div>
												<?php
											}

											if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
												?>
												<div class="post-details d-flex flex-column justify-content-center align-items-start">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit ); // phpcs:ignore
															echo $crafto_post_category; // phpcs:ignore
															?>
														</span>
														<?php
													}
													if ( 'yes' === $crafto_show_post_date ) {
														?>
														<div class="post-date-wrapper d-flex align-items-center">
															<?php
															if ( 'yes' === $crafto_post_icon ) {
																?>
																<i class="feather icon-feather-calendar"></i>
																<?php
															}
															?>
															<span><?php echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ); ?></span>
														</div>
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
													if ( 'yes' === $crafto_show_post_read_more_button ) {
														crafto_post_read_more_button( $this, $index ); // phpcs:ignore
													}
													if ( 'yes' === $crafto_show_post_author || 'yes' === $crafto_separator ) {
														?>
														<div class="post-author-meta d-flex align-items-center">
															<?php
															if ( 'yes' === $crafto_separator ) {
																?>
																<div class="horizontal-separator"></div>
																<?php
															}
															if ( 'yes' === $crafto_show_post_author_image ) {
																$alt = get_the_author_meta( 'display_name' );
																echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
															}
															if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
																?>
																<span class="author-name">
																	<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
																	<?php
																	echo esc_html( $crafto_show_post_author_text );
																	echo esc_html( get_the_author() );
																	?>
																	</a>
																</span>
																<?php
															}
															?>
														</div>
														<?php
													}
													if ( ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) || ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) ) {
														?>
														<div class="post-meta d-flex align-items-center">
															<?php
															if ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) {
																?>
																<span class="post-meta-like">
																	<?php echo crafto_blog_post_like_button( get_the_ID() ); // phpcs:ignore ?>
																</span>
																<?php
															}
															if ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
																$this->crafto_post_comments();
															}
															?>
														</div>
														<?php
													}
													?>
												</div>
												<?php
											}
											?>
										</div>
									</li>
									<?php
								}
								break;
							case 'blog-standard':
								if ( ( 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<?php
											if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
												?>
												<div class="blog-post-images">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit ); // phpcs:ignore
															echo $crafto_post_category; // phpcs:ignore
															?>
														</span>
														<?php
													}

													if ( 'gallery' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_gallery_format(); // phpcs:ignore
													} elseif ( 'video' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_video_format(); // phpcs:ignore
													} elseif ( 'quote' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_quote_format(); // phpcs:ignore
													} elseif ( 'audio' === $post_format && '' === $crafto_show_post_format ) {
														echo $this->crafto_post_audio_format(); // phpcs:ignore
													} else {
														?>
														<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
															<?php
															$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
															$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
															if ( '' === $alt ) {
																$alt = get_the_title( $thumbnail_id );
															}
															echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
															if ( 'yes' === $crafto_show_post_thumbnail_icon ) {
																crafto_get_post_formats_icon(); // phpcs:ignore
															}
															?>
															<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
														</a>
														<?php
													}
													?>
												</div>
												<?php
											}
											?>
											<div class="post-details">
												<?php
												if ( 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) || 'yes' === $crafto_show_post_date ) {
													?>
													<div class="post-meta">
														<?php
														if ( 'yes' === $crafto_show_post_date ) {
															?>
															<span class="post-date published">
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
														if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
															?>
															<span class="post-author-meta">
																<?php
																if ( 'yes' === $crafto_show_post_author_image ) {
																	$alt = get_the_author_meta( 'display_name' );
																	echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
																}
																if ( ! empty( $crafto_show_post_author_text ) || 'yes' === $crafto_show_post_author_icon ) {
																	?>
																	<span class="author-name">
																		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
																			<?php
																			if ( 'yes' === $crafto_show_post_author_icon ) {
																				?>
																				<i class="fa-regular fa-user blog-icon"></i>
																				<?php
																			}
																			echo esc_html( $crafto_show_post_author_text );
																			echo esc_html( get_the_author() );
																			?>
																		</a>
																	</span>
																	<?php
																}
																?>
															</span>
															<?php
														}
														if ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
															$this->crafto_post_comments();
														}
														if ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) {
															?>
															<span class="post-meta-like"><?php echo crafto_blog_post_like_button( get_the_ID() ); // phpcs:ignore ?></span>
															<?php
														}
														?>
													</div>
													<?php
												}
												if ( 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button ) {
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
													if ( 'yes' === $crafto_show_post_read_more_button ) {
														crafto_post_read_more_button( $this, $index ); // phpcs:ignore
													}
												}
												?>
											</div>
										</div>
									</li>
									<?php
								}
								break;
							case 'blog-only-text':
								if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || ( 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) || 'yes' === $crafto_show_post_author ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<div class="box-overlay"></div>
											<?php
											if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
												?>
												<div class="blog-post-images">
													<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
														<?php
														$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
														$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
														if ( '' === $alt ) {
															$alt = get_the_title( $thumbnail_id );
														}
														if ( 'yes' === $crafto_image_grey_scale ) {
															echo get_the_post_thumbnail(
																get_the_ID(),
																$crafto_thumbnail,
																array(
																	'alt' => $alt,
																	'class' => 'image-greyscale',
																)
															);
														} else {
															echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
														}
														?>
														<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
													</a>
												</div>
												<?php
											}

											if ( 'yes' === $crafto_show_post_count || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_author ) {
												?>
												<div class="post-details">
													<?php
													if ( 'yes' === $crafto_show_post_count ) {
														?>
														<span class="post-count">
															<?php echo $count_number_text; // phpcs:ignore ?>
														</span>
														<?php
													}

													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit ); // phpcs:ignore
															echo $crafto_post_category; // phpcs:ignore
															?>
														</span>
														<?php
													}
													if ( 'yes' === $crafto_show_post_date ) {
														?>
														<span class="post-date published">
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
													if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
														?>
														<div class="author-name">
															<?php
															if ( 'yes' === $crafto_show_post_author_image ) {
																$alt = get_the_author_meta( 'display_name' );
																echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
															}
															?>
															<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
														</div>
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
																<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
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
									</li>
									<?php
								}
								break;
							case 'blog-modern':
								if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<div class="blog-post-images">
												<?php
												if ( has_post_thumbnail() ) {
													?>
													<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
														<?php
														$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
														$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
														if ( '' === $alt ) {
															$alt = get_the_title( $thumbnail_id );
														}
														echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
														?>
														<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
													</a>
													<?php
												}
												?>
											</div>
											<div class="post-details">
												<div class="post-content-wrapper">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<div class="hover-text">
															<span class="blog-category alt-font">
																<?php
																$crafto_post_category = crafto_post_category( get_the_ID(), true, $crafto_category_limit ); // phpcs:ignore
																echo $crafto_post_category; // phpcs:ignore
																?>
															</span>
														</div>
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
																<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
															</div>
															<?php
														}
													}
													?>
													<div class="post-meta d-flex align-items-center">
														<?php
														if ( 'yes' === $crafto_show_post_like && function_exists( 'crafto_blog_post_like_button' ) ) {
															?>
															<span class="post-meta-like">
																<?php echo crafto_blog_post_like_button( get_the_ID() ); // phpcs:ignore ?>
															</span>
															<?php
														}
														if ( 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
															$this->crafto_post_comments();
														}
														?>
													</div>
												</div>
												<?php
												if ( 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_like ) {
													?>
													<div class="post-author-wrapper">
														<?php
														if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
															?>
															<span class="post-author-meta">
																<?php
																if ( 'yes' === $crafto_show_post_author_image ) {
																	$alt = get_the_author_meta( 'display_name' );
																	echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
																}
																?>
																<span class="author-name"><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
															</span>
															<?php
														}
														if ( 'yes' === $crafto_separator ) {
															?>
															<span class="post-meta-separator"></span>
															<?php
														}
														if ( 'yes' === $crafto_show_post_date ) {
															?>
															<span class="post-date published">
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
													<?php
												}
												?>
											</div>
										</div>
									</li>
									<?php
								}
								break;
							case 'blog-split':
								$this->add_render_attribute(
									$blog_post_key,
									[
										'class' => [ 'd-sm-flex d-block align-items-center' ],
									],
								);
								if ( ( 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_category ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<?php
											$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), $crafto_thumbnail );
											if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
												?>
												<div class="blog-post-images">
													<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
														<?php
														$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
														$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
														if ( '' === $alt ) {
															$alt = get_the_title( $thumbnail_id );
														}
														if ( 'yes' === $crafto_image_grey_scale ) {
															echo get_the_post_thumbnail(
																get_the_ID(),
																$crafto_thumbnail,
																array(
																	'alt'   => $alt,
																	'class' => 'image-greyscale',
																)
															);
														} else {
															echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
														}
														?>
														<span class="screen-reader-text"><?php echo esc_html__( 'Post Thumbnail', 'crafto-addons' ); ?></span>
													</a>
												</div>
												<?php
											}
											if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_category ) {
												?>
												<div class="post-details">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), true, $crafto_category_limit ); // phpcs:ignore
															echo $crafto_post_category; // phpcs:ignore
															?>
														</span>
														<?php
													}
													if ( 'yes' === $crafto_show_post_date ) {
														?>
														<div class="post-date-wrapper">
															<?php
															if ( 'yes' === $crafto_post_icon ) {
																?>
																<i class="feather icon-feather-calendar"></i>
																<?php
															}
															?>
															<span class="post-date alt-font published">
																<?php
																$posted = get_the_time( 'U' );
																if ( '' === $crafto_post_change_date_format ) {
																	echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) );
																} else {
																	echo esc_html( human_time_diff( $posted, current_time( 'U' ) ) ) . ' ago'; // phpcs:ignore
																}
																?>
															</span>
														</div>
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
																<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
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
									</li>
									<?php
								}
								break;
							case 'hero-blog':
								$this->add_render_attribute(
									$blog_post_key,
									[
										'class' => [
											'd-md-flex d-block flex-lg-row h-100 flex-column',
										],
									],
								);
								if ( ( 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<div <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<?php
											if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
												?>
												<div class="blog-post-images">
													<div class="post-image-wrap">
														<a <?php $this->print_render_attribute_string( $overlay_link_key ); ?>>
															<?php
															if ( has_post_thumbnail() ) {
																$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
																$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
																if ( '' === $alt ) {
																	$alt = get_the_title( $thumbnail_id );
																}
																echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
															} else {
																?>
																<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title(); ?>">
																<?php
															}

															if ( 'yes' === $crafto_show_post_thumbnail_icon ) {
																crafto_get_post_formats_icon(); // phpcs:ignore
															}
															?>
														</a>
													</div>
												</div>
												<?php
											}
											if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_excerpt || 'yes' === $crafto_show_post_read_more_button || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
												?>
												<div class="post-details">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit );
															echo $crafto_post_category; // phpcs:ignore
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
													if ( 'yes' === $crafto_show_post_read_more_button ) {
														crafto_post_read_more_button( $this, $index ); // phpcs:ignore
													}
													?>
													<div class="meta-wrapper">
														<?php
														if ( 'yes' === $crafto_separator ) {
															?>
															<div class="horizontal-separator"></div>
															<?php
														}
														?>
														<div class="hero-blog-bottom">
															<?php
															if ( 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_category ) {
																if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
																	?>
																	<div class="post-author-meta d-flex align-items-center">
																		<?php
																		if ( 'yes' === $crafto_show_post_author_image ) {
																			$alt = get_the_author_meta( 'display_name' );
																			echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
																		}
																		?>
																		<span class="author-name">
																			<?php echo esc_html( $crafto_show_post_author_text ); ?>
																			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
																				<?php echo esc_html( get_the_author() ); ?>
																			</a>
																		</span>
																	</div>
																	<?php
																}
															}
															if ( 'yes' === $crafto_show_post_date ) {
																?>
																<div class="post-date-wrapper d-flex align-items-center">
																	<?php
																	if ( 'yes' === $crafto_post_icon ) {
																		?>
																		<i class="feather icon-feather-calendar"></i>
																		<?php
																	}
																	?>
																	<span class="post-date published">
																		<?php echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ); ?>
																	</span>
																	<time class="updated d-none" datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ) // phpcs:ignore ?>">
																		<?php echo esc_html( get_the_modified_date( $crafto_post_date_format ) ); ?>
																	</time>
																</div>
																<?php
															}
															if ( 'yes' === $crafto_show_post_like || 'yes' === $crafto_show_post_comments && ( comments_open() || get_comments_number() ) ) {
																?>
																<div class="post-meta d-flex align-items-center">
																	<?php
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
															?>
														</div>
													</div>
												</div>
												<?php
											}
											?>
										</div>
									</li>
									<?php
								}
								break;
							case 'blog-full-image':
								$crafto_blog_metro_positions = $this->get_settings( 'crafto_blog_metro_positions' );
								$crafto_double_grid_position = ! empty( $crafto_blog_metro_positions ) ? array_map( 'intval', explode( ',', $crafto_blog_metro_positions ) ) : [];

								if ( ! empty( $crafto_double_grid_position ) && in_array( $grid_metro_count, $crafto_double_grid_position, true ) ) {
									$this->add_render_attribute(
										$inner_wrapper_key,
										[
											'class' => 'grid-item-double',
										],
									);
								}

								if ( 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_title ) {
									?>
									<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
										<figure <?php $this->print_render_attribute_string( $blog_post_key ); ?>>
											<?php
											if ( ! post_password_required() ) {
												?>
												<div class="blog-post-images">
													<a <?php $this->print_render_attribute_string( $custom_link_key ); ?> <?php $this->print_render_attribute_string( $image_key ); ?>>
														<?php
														if ( has_post_thumbnail() ) {
															$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
															$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
															if ( '' === $alt ) {
																$alt = get_the_title( $thumbnail_id );
															}
															echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
														} else {
															?>
															<img src="<?php echo esc_url( Utils::get_placeholder_image_src() ); ?>" alt="<?php the_title(); ?>">
															<?php
														}
														?>
													</a>
													<?php
													if ( 'yes' === $crafto_show_overlay ) {
														?>
														<div class="blog-overlay"></div>
														<?php
													}
													?>
												</div>
												<?php
											}

											if ( 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date || 'yes' === $crafto_show_post_title || 'yes' === $crafto_show_post_author ) {
												?>
												<figcaption class="content">
													<?php
													if ( 'yes' === $crafto_show_post_category ) {
														?>
														<span class="blog-category alt-font">
															<?php
															$crafto_post_category = crafto_post_category( get_the_ID(), false, $crafto_category_limit ); // phpcs:ignore
															echo $crafto_post_category; // phpcs:ignore
															?>
														</span>
														<?php
													}
													if ( 'yes' === $crafto_show_post_title ) {
														?>
														<a <?php $this->print_render_attribute_string( $title_link_key ); ?>><?php the_title(); ?></a>
														<?php
													}
													if ( 'yes' === $crafto_show_post_author_image || 'yes' === $crafto_show_post_author ) {
														?>
														<div class="post-details">
															<div class="author-name">
																<?php
																if ( 'yes' === $crafto_show_post_author_image ) {
																	$alt = get_the_author_meta( 'display_name' );
																	echo get_avatar( get_the_author_meta( 'ID' ), '30', '', $alt );
																}
																if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
																	?>
																	<span><?php echo esc_html( $crafto_show_post_author_text ); ?><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></span>
																	<?php
																}
																?>
															</div>
															<?php
															if ( 'yes' === $crafto_show_post_date ) {
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
														<?php
													}
													?>
												</figcaption>
												<?php
											}
											?>
										</figure>
									</li>
									<?php
								}
								break;
						}
						++$index;
						++$grid_metro_count;
						++$grid_count;
						++$count_number;
						++$i;
					endwhile;
					get_next_posts_page_link( $the_query->max_num_pages );
					?>
				</ul>
				<?php
				crafto_post_pagination( $the_query, $settings );
				wp_reset_postdata();
			}
		}

		/**
		 * Post gallery format.
		 */
		public function crafto_post_gallery_format() {
			$crafto_blog_lightbox_gallery = crafto_post_meta( 'crafto_lightbox_image' );
			$crafto_blog_gallery          = crafto_post_meta( 'crafto_gallery' );

			if ( $crafto_blog_gallery ) {
				$crafto_gallery = explode( ',', $crafto_blog_gallery );
			} else {
				$crafto_gallery = array();
			}

			$crafto_gallery_length = count( $crafto_gallery );

			if ( '1' === $crafto_blog_lightbox_gallery ) {
				$crafto_popup_id = 'blog-' . get_the_ID();
				if ( is_array( $crafto_gallery ) && ! empty( $crafto_gallery ) ) {
					?>
					<ul class="blog-post-gallery-grid row-cols-lg-3 row-cols-md-2 row-cols-1 row">
						<?php
						if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
							?>
							<li class="grid-gallery-sizer grid-sizer d-none p-0 m-0"></li>
							<?php
						}

						foreach ( $crafto_gallery as $key => $value ) {
							$crafto_thumb = wp_get_attachment_url( $value );
							if ( $crafto_thumb ) {
								// Lightbox.
								$crafto_attachment_attributes        = '';
								$crafto_image_title_lightbox_popup   = get_theme_mod( 'crafto_image_title_lightbox_popup', '0' );
								$crafto_image_caption_lightbox_popup = get_theme_mod( 'crafto_image_caption_lightbox_popup', '0' );

								if ( '1' === $crafto_image_title_lightbox_popup ) {
									$crafto_attachment_title       = get_the_title( $value );
									$crafto_attachment_attributes .= ! empty( $crafto_attachment_title ) ? ' title="' . $crafto_attachment_title . '"' : '';
								}

								if ( '1' === $crafto_image_caption_lightbox_popup ) {
									$crafto_lightbox_caption       = wp_get_attachment_caption( $value );
									$crafto_attachment_attributes .= ! empty( $crafto_lightbox_caption ) ? ' data-lightbox-caption="' . $crafto_lightbox_caption . '"' : '';
								}
								?>
								<li class="grid-gallery-item">
									<a href="<?php echo esc_url( $crafto_thumb ); ?>" data-elementor-open-lightbox="no" data-group="lightbox-gallery-<?php echo esc_attr( $crafto_popup_id ); ?>" class="lightbox-group-gallery-item"<?php echo sprintf( '%s', $crafto_attachment_attributes ); // phpcs:ignore ?>>
										<figure>
											<div class="portfolio-img">
												<?php echo wp_get_attachment_image( $value, 'full' ); ?>
											</div>
											<figcaption>
												<div class="blog-post-gallery-hover-content">
													<?php
													$gallery_icon = apply_filters( 'crafto_post_format_gallery_icon', '<i class="feather icon-feather-search"></i>' );
													echo sprintf( '%s', $gallery_icon ); // phpcs:ignore
													?>
												</div>
											</figcaption>
										</figure>
									</a>
								</li>
								<?php
							}
						}
						?>
					</ul>
					<?php
				}
			} elseif ( is_array( $crafto_gallery ) && ! empty( $crafto_gallery ) ) {
				?>
					<div class="blog-image">
						<div class="post-format-slider swiper">
							<div class="swiper-wrapper">
								<?php
								foreach ( $crafto_gallery as $key => $value ) {
									?>
									<div class="swiper-slide">
										<?php echo wp_get_attachment_image( $value, 'full' ); ?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
							if ( $crafto_gallery_length > 1 ) {
								?>
								<div class="swiper-pagination"></div>
								<div class="swiper-button-next"></div>
								<div class="swiper-button-prev"></div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
			}
		}

		/**
		 * Post video format HTML.
		 */
		public function crafto_post_video_format() {
			$crafto_video_type = crafto_post_meta( 'crafto_video_type' );

			if ( 'self' === $crafto_video_type ) {
				$crafto_video_mp4   = crafto_post_meta( 'crafto_video_mp4' );
				$crafto_video_ogg   = crafto_post_meta( 'crafto_video_ogg' );
				$crafto_video_webm  = crafto_post_meta( 'crafto_video_webm' );
				$crafto_mute        = crafto_post_meta( 'crafto_enable_mute' );
				$crafto_enable_mute = ( '1' === $crafto_mute ) ? ' muted' : '';

				if ( $crafto_video_mp4 || $crafto_video_ogg || $crafto_video_webm ) {
					?>
					<div class="blog-image fit-videos blog-video">
						<video<?php echo esc_attr( $crafto_enable_mute ); ?> playsinline autoplay loop controls>
							<?php
							if ( ! empty( $crafto_video_mp4 ) ) {
								?>
								<source src="<?php echo esc_url( $crafto_video_mp4 ); ?>" type="video/mp4">
								<?php
							}

							if ( ! empty( $crafto_video_ogg ) ) {
								?>
								<source src="<?php echo esc_url( $crafto_video_ogg ); ?>" type="video/ogg">
								<?php
							}

							if ( ! empty( $crafto_video_webm ) ) {
								?>
								<source src="<?php echo esc_url( $crafto_video_webm ); ?>" type="video/webm">
								<?php
							}
							?>
						</video>
					</div>
					<?php
				}
			} else {
				$crafto_video_url = crafto_post_meta( 'crafto_video' );
				if ( strpos( $crafto_video_url, 'player.vimeo.com' ) === true ) {
					$fullscreen_class = ' webkitAllowFullScreen mozallowfullscreen allowFullScreen';
				} else {
					$fullscreen_class = ' allowFullScreen="true"';
				}
				if ( $crafto_video_url ) {
					?>
					<div class="blog-image fit-videos blog-video">
						<iframe src="<?php echo esc_url( $crafto_video_url ); ?>" width="640" height="360" frameborder="0"<?php echo esc_attr( $fullscreen_class ); ?> allow="autoplay; fullscreen"></iframe>
					</div>
					<?php
				}
			}
		}

		/**
		 * Post quote format.
		 */
		public function crafto_post_quote_format() {
			$crafto_blog_quote   = crafto_post_meta( 'crafto_quote' );
			$crafto_quote_author = crafto_post_meta( 'crafto_quote_author' );
			if ( $crafto_blog_quote ) {
				?>
				<div class="blog-image crafto-blog-blockquote">
					<?php
					$blockquote_icon = apply_filters( 'crafto_post_format_blockquote_icon', '<i class="fa-solid fa-quote-left"></i>' );
					echo sprintf( '%s', $blockquote_icon ); // phpcs:ignore
					?>
					<div class="blockquote-content alt-font">
						<?php echo esc_html( $crafto_blog_quote ); ?>
					</div>
					<div class="blockquote-author">
						<?php echo esc_html( $crafto_quote_author ); ?>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * Post audio format.
		 */
		public function crafto_post_audio_format() {
			$crafto_blog_audio = crafto_post_meta( 'crafto_audio' );
			if ( $crafto_blog_audio ) {
				?>
				<div class="blog-image fit-videos crafto-blog-audio">
					<?php
					if ( $crafto_blog_audio ) {
						echo wp_oembed_get( $crafto_blog_audio ); // phpcs:ignore
					} else {
						printf( $crafto_blog_audio ); // phpcs:ignore
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

		/**
		 * Return post array
		 */
		public function crafto_get_post_array() {
			global $wpdb;

			$post_types = [ 'post' ];
			if ( class_exists( 'Give' ) ) {
				$post_types[] = 'give_forms';
			}

			// Prepare post type placeholders for safe SQL.
			$placeholders = implode( ',', array_fill( 0, count( $post_types ), '%s' ) );
			// phpcs:ignore
			$query = $wpdb->prepare(
				"
				SELECT ID, post_title
				FROM {$wpdb->posts}
				WHERE post_type IN ($placeholders)
				AND post_status = 'publish'
				ORDER BY post_title ASC
			",
			...$post_types // phpcs:ignore
			);

			$results = $wpdb->get_results( $query, OBJECT_K ); // phpcs:ignore

			$post_array = [];

			if ( ! empty( $results ) ) {
				foreach ( $results as $id => $row ) {
					$post_array[ $id ] = $row->post_title ? esc_html( $row->post_title ) : esc_html__( '(no title)', 'crafto-addons' );
				}
			}

			return $post_array;
		}
	}
}
