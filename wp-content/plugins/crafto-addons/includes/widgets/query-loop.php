<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Dynamic_Select;

/**
 * Crafto widget for Crafto Query Loop.
 *
 * @package Crafto
 * @since   1.0
 */

// If class `Query_Loop` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Query_Loop' ) ) {
	/**
	 * Define `Query_Loop` class.
	 */
	class Query_Loop extends Widget_Base {
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-loop-builder';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Loop Builder', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-loop-builder crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/loop-builder/';
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
				'loop',
				'item',
				'dynamic',
				'list',
				'grid',
				'archive',
				'blog',
				'news',
				'article',
				'recent',
				'related',
				'repeater',
				'products',
				'posts',
				'portfolio',
				'cpt',
				'query',
				'custom',
				'builder',
				'query',
				'source',
				'meta',
				'global',
				'multiple',
				'taxonomy',
				'term',
				'category',
				'tags',
				'author',
				'parameter',
				'argument',
				'current',
				'manual',
				'selection',
			];
		}

		/**
		 * Retrieve the list of scripts the Query Loop widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$query_loop_scripts = [];

			if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
				$query_loop_scripts[] = 'imagesloaded';
			}

			if ( crafto_disable_module_by_key( 'isotope' ) ) {
				$query_loop_scripts[] = 'isotope';
			}

			if ( crafto_disable_module_by_key( 'infinite-scroll' ) ) {
				$query_loop_scripts[] = 'infinite-scroll';
			}

			if ( crafto_disable_module_by_key( 'fitvids' ) ) {
				$query_loop_scripts[] = 'jquery.fitvids';
			}

			if ( crafto_disable_module_by_key( 'swiper' ) ) {
				$query_loop_scripts[] = 'swiper';
			}

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$query_loop_scripts[] = 'crafto-widgets';
			} else {
				$query_loop_scripts[] = 'crafto-blog-list-widget';
			}
			return $query_loop_scripts;
		}

		/**
		 * Retrieve the list of styles the Query Loop widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$query_loop_styles = [];

			if ( crafto_disable_module_by_key( 'swiper' ) ) {
				$query_loop_styles[] = 'swiper';
			}

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$query_loop_styles[] = 'crafto-widgets';
			} else {
				$query_loop_styles[] = 'crafto-blog-list-widget';
			}

			return $query_loop_styles;
		}

		/**
		 * Render post navigation widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_loop_item_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
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
						'{{WRAPPER}} ul li.grid-gutter'   => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.crafto-loop-item' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
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
				]
			);
			$this->add_control(
				'crafto_items_per_page',
				[
					'label'   => esc_html__( 'Number of Items to Show', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [
						'active' => true,
					],
					'default' => 12,
				]
			);
			$this->add_control(
				'crafto_enable_masonry',
				[
					'label'        => esc_html__( 'Enable Masonry Layout', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_post_content_data',
				[
					'label' => esc_html__( 'Data', 'crafto-addons' ),
				]
			);

			$crafto_post_types = [];
			if ( function_exists( 'crafto_get_post_types' ) ) {
				$crafto_post_types = crafto_get_post_types();
			}

			$crafto_extra_types = [
				'manual_selection' => esc_html__( 'Manual Selection', 'crafto-addons' ),
				'current_query'    => esc_html__( 'Current Query', 'crafto-addons' ),
			];

			$crafto_post_types = array_merge( $crafto_post_types, $crafto_extra_types );

			$this->add_control(
				'crafto_post_type_source',
				[
					'label'   => esc_html__( 'Source Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $crafto_post_types,
					'default' => 'post',
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
						'title'         => esc_html__( 'Title', 'crafto-addons' ),
						'modified'      => esc_html__( 'Last Modified', 'crafto-addons' ),
						'random'        => esc_html__( 'Random', 'crafto-addons' ),
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
				'crafto_posts_selected_ids',
				[
					'label'       => esc_html__( 'Search & Select', 'crafto-addons' ),
					'type'        => Dynamic_Select::TYPE,
					'multiple'    => true,
					'label_block' => true,
					'query_args'  => [
						'query' => 'posts',
					],
					'condition'   => [
						'crafto_post_type_source' => 'manual_selection',
					],
				]
			);

			$this->start_controls_tabs(
				'crafto_args_tabs',
			);

			$this->start_controls_tab(
				'crafto_include_by_tab',
				[
					'label'     => esc_html__( 'Include By', 'crafto-addons' ),
					'condition' => [
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);

			$this->add_control(
				'crafto_include_by',
				[
					'label'       => esc_html__( 'Include By', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'label_block' => true,
					'multiple'    => true,
					'options'     => [
						'authors' => esc_html__( 'Authors', 'crafto-addons' ),
						'terms'   => esc_html__( 'Terms', 'crafto-addons' ),
					],
					'condition'   => [
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);
			$this->add_control(
				'crafto_posts_include_author_ids',
				[
					'label'       => esc_html__( 'Authors', 'crafto-addons' ),
					'type'        => Dynamic_Select::TYPE,
					'multiple'    => true,
					'label_block' => true,
					'query_args'  => [
						'query' => 'authors',
					],
					'condition'   => [
						'crafto_include_by'        => 'authors',
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);

			$this->add_control(
				'crafto_posts_include_term_ids',
				[
					'label'       => esc_html__( 'Terms', 'crafto-addons' ),
					'description' => esc_html__( 'Terms are items in a taxonomy. The available taxonomies are: Categories, Tags, Formats and custom taxonomies.', 'crafto-addons' ),
					'type'        => Dynamic_Select::TYPE,
					'multiple'    => true,
					'label_block' => true,
					'placeholder' => esc_html__( 'Type and select terms', 'crafto-addons' ),
					'query_args'  => [
						'query'        => 'terms',
						'widget_props' => [
							'post_type' => 'crafto_post_type_source',
						],
					],
					'condition'   => [
						'crafto_include_by'        => 'terms',
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_exclude_by_tab',
				[
					'label'     => esc_html__( 'Exclude By', 'crafto-addons' ),
					'condition' => [
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);

			$this->add_control(
				'crafto_exclude_by',
				[
					'label'       => esc_html__( 'Exclude By', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => [
						'authors'          => esc_html__( 'Authors', 'crafto-addons' ),
						'current_post'     => esc_html__( 'Current Post', 'crafto-addons' ),
						'manual_selection' => esc_html__( 'Manual Selection', 'crafto-addons' ),
						'terms'            => esc_html__( 'Terms', 'crafto-addons' ),
					],
					'condition'   => [
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);
			$this->add_control(
				'crafto_posts_exclude_ids',
				[
					'label'       => esc_html__( 'Search & Select', 'crafto-addons' ),
					'type'        => Dynamic_Select::TYPE,
					'multiple'    => true,
					'label_block' => true,
					'query_args'  => [
						'query'        => 'posts',
						'widget_props' => [
							'post_type' => 'crafto_post_type_source',
						],
					],
					'condition'   => [
						'crafto_exclude_by'        => 'manual_selection',
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);
			$this->add_control(
				'crafto_posts_exclude_author_ids',
				[
					'label'       => esc_html__( 'Authors', 'crafto-addons' ),
					'type'        => Dynamic_Select::TYPE,
					'multiple'    => true,
					'label_block' => true,
					'query_args'  => [
						'query' => 'authors',
					],
					'condition'   => [
						'crafto_exclude_by'        => 'authors',
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);
			$this->add_control(
				'crafto_posts_exclude_term_ids',
				[
					'label'       => esc_html__( 'Terms', 'crafto-addons' ),
					'description' => esc_html__( 'Terms are items in a taxonomy. The available taxonomies are: Categories, Tags, Formats and custom taxonomies.', 'crafto-addons' ),
					'type'        => Dynamic_Select::TYPE,
					'multiple'    => true,
					'label_block' => true,
					'placeholder' => esc_html__( 'Type and select terms', 'crafto-addons' ),
					'query_args'  => [
						'query'        => 'terms',
						'widget_props' => [
							'post_type' => 'crafto_post_type_source',
						],
					],
					'condition'   => [
						'crafto_exclude_by'        => 'terms',
						'crafto_post_type_source!' => [
							'manual_selection',
							'current_query',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_query_loop_offset',
				[
					'label'     => esc_html__( 'Offset', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'crafto_post_type_source!' => 'current_query',
					],
				]
			);
			$this->add_control(
				'query_id',
				[
					'label'       => esc_html__( 'Query ID', 'crafto-addons' ),
					'description' => esc_html__( 'Give your Query a custom unique id to allow server side filtering', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'separator'   => 'before',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_post_content_settings',
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
				]
			);

			$this->add_control(
				'crafto_thumbnail',
				[
					'label'          => esc_html__( 'Image Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'full',
					'options'        => ( function_exists( 'crafto_get_thumbnail_image_sizes' ) ) ? crafto_get_thumbnail_image_sizes() : [],
					'style_transfer' => true,
					'condition'      => [
						'crafto_show_post_thumbnail' => 'yes',
					],
				]
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
				'crafto_show_post_like',
				[
					'label'        => esc_html__( 'Enable Like Count', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
				],
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
					],
				]
			);
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
				)
			);
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
						'condition'    => [
							'crafto_show_post_comments' => 'yes',
						],
					],
				)
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
						'.rtl {{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_read_more_button_icon[value]!' => '',
						'crafto_button_icon_align!' => 'switch',
						'crafto_show_post_read_more_button' => 'yes',
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
					'condition'    => [
						'crafto_post_type_source' => 'post',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_pagination',
				[
					'label' => esc_html__( 'Pagination', 'crafto-addons' ),
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
						'library' => 'fa-solid',
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
						'library' => 'fa-solid',
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
				'crafto_section_loop_item_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_loop_item_content_box_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .post-details',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_loop_item_post_shadow',
					'selector' => '{{WRAPPER}} .blog-post',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_loop_item_post_border',
					'selector' => '{{WRAPPER}} .blog-post',
				]
			);
			$this->add_responsive_control(
				'crafto_loop_item_post_border_radius',
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
				]
			);
			$this->add_responsive_control(
				'crafto_loop_item_content_box_padding',
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
						'{{WRAPPER}} .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_loop_item_title_style',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_loop_item_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .entry-title',
				]
			);

			$this->start_controls_tabs(
				'crafto_loop_item_title_tabs',
			);

			$this->start_controls_tab(
				'crafto_loop_item_title_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_loop_item_title_color',
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
				'crafto_loop_item_title_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_loop_item_title_hover_color',
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
				'crafto_loop_item_title_width',
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
				'crafto_loop_item_title_min_height',
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
				]
			);
			$this->add_responsive_control(
				'crafto_loop_item_title_margin',
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
				'crafto_section_loop_item_content_style',
				[
					'label'      => esc_html__( 'Excerpt', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_loop_item_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .entry-content',
				]
			);
			$this->add_control(
				'crafto_loop_item_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .entry-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_loop_item_content_width',
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
			$this->add_responsive_control(
				'crafto_loop_item_content_margin',
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
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_loop_item_date_style_heading',
				[
					'label' => esc_html__( 'Date', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_loop_item_date_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .post-date',
				]
			);
			$this->add_control(
				'crafto_loop_item_date_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-date' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_loop_item_author_style',
				[
					'label' => esc_html__( 'Author', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_loop_item_author_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .author-name a',
				]
			);

			$this->start_controls_tabs(
				'crafto_loop_item_author_tabs',
			);

			$this->start_controls_tab(
				'crafto_loop_item_author_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_loop_item_author_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .author-name a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_loop_item_author_border',
					'selector' => '{{WRAPPER}} .author-name a',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_loop_item_author_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_loop_item_author_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .author-name a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_loop_item_author_hover_border',
					'selector' => '{{WRAPPER}} .author-name a:hover',
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_loop_item_categories_style',
				[
					'label'     => esc_html__( 'Category', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_type_source!' => [
							'page',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_loop_item_categories_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .blog-category a',
				]
			);

			$this->start_controls_tabs(
				'crafto_loop_item_categories_tabs'
			);

			$this->start_controls_tab(
				'crafto_loop_item_categories_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_loop_itemcategories_bg__color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .blog-category a',
				]
			);

			$this->add_control(
				'crafto_loop_item_categories_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-category a' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_loop_item_categories_border',
					'selector' => '{{WRAPPER}} .blog-category a',
				]
			);

			$this->add_responsive_control(
				'crafto_loop_item_categories_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .blog-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_loop_item_categories_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_loop_item_categories_hover_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .blog-category a:hover',
				]
			);

			$this->add_control(
				'crafto_loop_item_categories_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-category a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_loop_item_categories_hover_border',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .blog-category a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_loop_item_categories_padding',
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
					'selector'       => '{{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-button .elementor-animation-btn-expand-ltr .btn-hover-animation',
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
		}

		/**
		 * Render Query Loop widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			global $crafto_blog_unique_id;

			$settings = $this->get_settings_for_display();

			$crafto_show_post_title  = $this->get_settings( 'crafto_show_post_title' );
			$crafto_post_type_source = $this->get_settings( 'crafto_post_type_source' );
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
			// END No. of Column.

			$crafto_post_date_format           = ( isset( $settings['crafto_post_date_format'] ) && $settings['crafto_post_date_format'] ) ? $settings['crafto_post_date_format'] : '';
			$crafto_thumbnail                  = ( isset( $settings['crafto_thumbnail'] ) && $settings['crafto_thumbnail'] ) ? $settings['crafto_thumbnail'] : 'full';
			$crafto_post_excerpt_length        = ( isset( $settings['crafto_post_excerpt_length'] ) && $settings['crafto_post_excerpt_length'] ) ? $settings['crafto_post_excerpt_length'] : '';
			$crafto_enable_masonry             = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';
			$crafto_show_post_author_text      = $this->get_settings( 'crafto_show_post_author_text' );
			$crafto_show_post_author           = ( isset( $settings['crafto_show_post_author'] ) && $settings['crafto_show_post_author'] ) ? $settings['crafto_show_post_author'] : '';
			$crafto_show_post_date             = ( isset( $settings['crafto_show_post_date'] ) && $settings['crafto_show_post_date'] ) ? $settings['crafto_show_post_date'] : '';
			$crafto_show_post_thumbnail        = ( isset( $settings['crafto_show_post_thumbnail'] ) && $settings['crafto_show_post_thumbnail'] ) ? $settings['crafto_show_post_thumbnail'] : '';
			$crafto_show_post_excerpt          = ( isset( $settings['crafto_show_post_excerpt'] ) && $settings['crafto_show_post_excerpt'] ) ? $settings['crafto_show_post_excerpt'] : '';
			$crafto_show_post_read_more_button = ( isset( $settings['crafto_show_post_read_more_button'] ) && $settings['crafto_show_post_read_more_button'] ) ? $settings['crafto_show_post_read_more_button'] : '';
			$crafto_show_post_thumbnail_icon   = ( isset( $settings['crafto_show_post_thumbnail_icon'] ) && $settings['crafto_show_post_thumbnail_icon'] ) ? $settings['crafto_show_post_thumbnail_icon'] : '';
			$crafto_show_post_category         = ( isset( $settings['crafto_show_post_category'] ) && $settings['crafto_show_post_category'] ) ? $settings['crafto_show_post_category'] : '';
			$crafto_post_icon                  = ( isset( $settings['crafto_post_icon'] ) && $settings['crafto_post_icon'] ) ? $settings['crafto_post_icon'] : '';
			$crafto_show_post_like             = ( isset( $settings['crafto_show_post_like'] ) && $settings['crafto_show_post_like'] ) ? $settings['crafto_show_post_like'] : '';
			$crafto_show_post_comments         = ( isset( $settings['crafto_show_post_comments'] ) && $settings['crafto_show_post_comments'] ) ? $settings['crafto_show_post_comments'] : '';
			$crafto_show_post_author_image     = ( isset( $settings['crafto_show_post_author_image'] ) && $settings['crafto_show_post_author_image'] ) ? $settings['crafto_show_post_author_image'] : '';

			// Pagination.
			$crafto_pagination = ( isset( $settings['crafto_pagination'] ) && $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';

			// Check if blog id and class.
			$crafto_blog_unique_id = ! empty( $crafto_blog_unique_id ) ? $crafto_blog_unique_id : 1;
			$crafto_blog_id        = 'crafto-blog-loop';
			$crafto_blog_id       .= '-' . $crafto_blog_unique_id;
			++$crafto_blog_unique_id;

			$datasettings = array(
				'pagination_type' => $crafto_pagination,
			);

			$this->add_render_attribute(
				'wrapper',
				[
					'data-uniqueid'      => $crafto_blog_id,
					'class'              => [
						$crafto_blog_id,
						'grid',
						'crafto-blog-list',
						'blog-classic',
						$crafto_column_class_list,
						$crafto_pagination,
					],
					'data-blog-settings' => wp_json_encode( $datasettings ),
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

			$query_args = $this->crafto_get_query_args();
			$the_query  = new \WP_Query( $query_args );

			if ( $the_query->have_posts() ) {
				?>
				<ul <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<?php
					if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
						?>
						<li class="grid-sizer d-none p-0 m-0"></li>
						<?php
					}

					$index = 0;
					while ( $the_query->have_posts() ) :
						$the_query->the_post();

						$cat_slug_cls      = [];
						$inner_wrapper_key = 'inner_wrapper_' . $index;
						$blog_post_key     = 'blog_post_' . $index;

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
						<li <?php $this->print_render_attribute_string( $inner_wrapper_key ); ?>>
							<div class="blog-post">
								<?php
								if ( ! post_password_required() && 'yes' === $crafto_show_post_thumbnail && has_post_thumbnail() ) {
									?>
									<div class="blog-post-images">
										<?php
										if ( has_post_thumbnail() ) {
											?>
											<a href="<?php the_permalink(); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
												<?php
												$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
												$alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
												if ( '' === $alt ) {
													$alt = get_the_title();
												}
												echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $alt ) );
												if ( 'yes' === $crafto_show_post_thumbnail_icon ) {
													crafto_get_post_formats_icon(); // phpcs:ignore
												}
												?>
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
									if ( 'yes' === $crafto_show_post_author || 'yes' === $crafto_show_post_category || 'yes' === $crafto_show_post_date ) {
										?>
										<div class="post-author-meta">
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
													if ( 'portfolio' === $crafto_post_type_source || 'product' === $crafto_post_type_source || 'properties' === $crafto_post_type_source || 'tours' === $crafto_post_type_source || 'lp_course' === $crafto_post_type_source ) {
														$crafto_post_category = $this->crafto_get_category_list( get_the_ID(), false );
													} else {
														$crafto_post_category = crafto_post_category( get_the_ID(), false );
													}
													echo $crafto_post_category; // phpcs:ignore
												}
												if ( 'yes' === $crafto_show_post_date ) {
													?>
													<a class="post-date published" href="<?php the_permalink(); ?>">
														<?php
														if ( 'yes' === $crafto_post_icon ) {
															?>
															<i class="feather icon-feather-calendar"></i>
															<?php
														}
														?>
														<span><?php echo esc_html( get_the_date( $crafto_post_date_format, get_the_ID() ) ); ?></span>
													</a>
													<?php
												}
												?>
											</div>
										</div>
										<?php
									}

									if ( 'yes' === $crafto_show_post_title ) {
										?>
										<a href="<?php the_permalink(); ?>" class="entry-title"><?php the_title(); ?></a>
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
						++$index;
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
				<?php
				get_next_posts_page_link( $the_query->max_num_pages );
				crafto_post_pagination( $the_query, $settings );
			}
		}
		/**
		 * Returns the Crafto category list.
		 *
		 * @param int    $id         The ID to retrieve categories for.
		 * @param bool   $separator  Whether to include a separator in the list. Default is true.
		 * @param string $count      The number of categories to retrieve. Default is '10'.
		 *
		 * @return array The list of categories.
		 */
		public function crafto_get_category_list( $id, $separator = true, $count = '10' ) {
			$term_cat                = [];
			$crafto_post_type_source = $this->get_settings( 'crafto_post_type_source' );
			if ( 'portfolio' === $crafto_post_type_source ) {
				$terms = get_the_terms( $id, 'portfolio-category' );
			} elseif ( 'product' === $crafto_post_type_source ) {
				$terms = get_the_terms( $id, 'product_cat' );
			} elseif ( 'properties' === $crafto_post_type_source ) {
				$terms        = [];
				$types_terms  = get_the_terms( $id, 'properties-types' );
				$agents_terms = get_the_terms( $id, 'properties-agents' );
				if ( $types_terms && ! is_wp_error( $types_terms ) ) {
					$terms = array_merge( $terms, $types_terms );
				}

				if ( $agents_terms && ! is_wp_error( $agents_terms ) ) {
					$terms = array_merge( $terms, $agents_terms );
				}
			} elseif ( 'tours' === $crafto_post_type_source ) {
				$terms        = [];
				$types_terms  = get_the_terms( $id, 'tour-destination' );
				$agents_terms = get_the_terms( $id, 'tour-activity' );
				if ( $types_terms && ! is_wp_error( $types_terms ) ) {
					$terms = array_merge( $terms, $types_terms );
				}

				if ( $agents_terms && ! is_wp_error( $agents_terms ) ) {
					$terms = array_merge( $terms, $agents_terms );
				}
			} else {
				$terms = get_the_terms( $id, 'course_category' );
			}
			foreach ( array_slice( $terms, 0, intval( $count ) ) as $term ) {
				$term_link  = get_term_link( $term->term_id );
				$term_cat[] = '<a rel="category tag" href="' . esc_url( $term_link ) . '">' . esc_html( $term->name ) . '</a>';
			}

			return implode( $separator ? ', ' : '', $term_cat );
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
		 * Returns the query arguments.
		 *
		 * @return array The query arguments array.
		 */
		public function crafto_get_query_args() {

			$settings = $this->get_settings_for_display();

			$crafto_post_type_source    = $this->get_settings( 'crafto_post_type_source' );
			$crafto_posts_exclude_ids   = $this->get_settings( 'crafto_posts_exclude_ids' );
			$crafto_ignore_sticky_posts = $this->get_settings( 'crafto_ignore_sticky_posts' );
			$crafto_items_per_page      = $this->get_settings( 'crafto_items_per_page' );
			$crafto_query_loop_offset   = $this->get_settings( 'crafto_query_loop_offset' );
			$query_args                 = [];

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$args = $this->set_meta_query_args();

			$args['post_status']      = 'publish';
			$args['suppress_filters'] = false;
			$exclude_by               = $this->get_group_control_query_param_by( 'exclude' );

			if ( 0 < $crafto_query_loop_offset ) {
				$args['offset_to_fix'] = $crafto_query_loop_offset;
			}

			$args['posts_per_page'] = intval( $crafto_items_per_page ); // phpcs:ignore
			$args['paged']          = $paged;

			if ( 'post' === $crafto_post_type_source && 'yes' === $crafto_ignore_sticky_posts ) {
				$args['ignore_sticky_posts'] = true;
				if ( in_array( 'current_post', $exclude_by, true ) ) {
					$args['post__not_in'] = [ get_the_ID() ];
				}
			}

			if ( 'manual_selection' === $crafto_post_type_source ) {
				$selected_ids      = $this->get_settings_for_display( 'crafto_posts_selected_ids' );
				$selected_ids      = wp_parse_id_list( $selected_ids );
				$args['post_type'] = 'any';
				if ( ! empty( $selected_ids ) ) {
					$args['post__in'] = $selected_ids;
				}

				$args['ignore_sticky_posts'] = true;
			} elseif ( 'current_query' === $crafto_post_type_source ) {
				$args = $GLOBALS['wp_query']->query_vars;
				$args = apply_filters( 'crafto_query_loop_current_query', $args );
			} elseif ( 'related_post_type' === $crafto_post_type_source ) {
				$post_id           = get_queried_object_id();
				$related_post_id   = is_singular() && ( 0 !== $post_id ) ? $post_id : null;
				$args['post_type'] = get_post_type( $related_post_id );
				$exclude_by        = $this->get_group_control_query_param_by( 'exclude' );

				if ( in_array( 'current_post', $exclude_by, true ) ) {
					$args['post__not_in'] = [ get_the_ID() ];
				}

				$args = $this->get_author_args( $args, $settings, $related_post_id );
				$args = $this->get_terms_args( $args, $settings );

				$args['ignore_sticky_posts'] = true;

				$args = apply_filters( 'crafto_query_loop_related_query', $args );
			} else {
				$args['post_type'] = $crafto_post_type_source;
				$exclude_by        = $this->get_group_control_query_param_by( 'exclude' );

				$current_post = [];
				if ( in_array( 'current_post', $exclude_by, true ) && is_singular() ) {
					$current_post = [ get_the_ID() ];
				}

				if ( in_array( 'manual_selection', $exclude_by, true ) ) {
					$exclude_ids          = $crafto_posts_exclude_ids;
					$args['post__not_in'] = array_merge( $current_post, wp_parse_id_list( $exclude_ids ) );
				}

				$args = $this->get_author_args( $args, $settings );
				$args = $this->get_terms_args( $args, $settings );
			}

			if ( $this->get_settings_for_display( 'query_id' ) ) {
				add_action( 'pre_get_posts', [ $this, 'pre_get_posts_query_filter' ] );
			}

			// fixing custom offset.
			// https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination.
			add_action( 'pre_get_posts', [ $this, 'fix_query_offset' ], 1 );
			add_filter( 'found_posts', [ $this, 'prefix_adjust_offset_pagination' ], 1, 2 );

			return $args;
		}

		/**
		 * Returns the meta query arguments.
		 *
		 * @return array The meta query arguments array.
		 */
		private function set_meta_query_args() {
			$crafto_post_type_source = $this->get_settings( 'crafto_post_type_source' );
			$args                    = [];

			if ( 'current_query' === $crafto_post_type_source ) {
				return [];
			}

			$args['order']   = $this->get_settings_for_display( 'crafto_order' );
			$args['orderby'] = $this->get_settings_for_display( 'crafto_orderby' );

			return $args;
		}

		/**
		 * Gets query parameters based on the provided arguments.
		 *
		 * @param string $by The parameter to filter by.
		 *
		 * @return array|mixed The query parameters or a specific value based on the input.
		 */
		private function get_group_control_query_param_by( $by = 'exclude' ) {
			$map_by = [
				'exclude' => 'crafto_exclude_by',
				'include' => 'crafto_include_by',
			];

			$setting = $this->get_settings_for_display( $map_by[ $by ] );

			return ( ! empty( $setting ) ? $setting : [] );
		}
		/**
		 * Returns an array of author arguments.
		 *
		 * @param array        $args The arguments array.
		 * @param array        $settings The settings array.
		 * @param WP_Post|null $post The post object or null if not provided. Default is null.
		 *
		 * @return array The modified author arguments array.
		 */
		private function get_author_args( $args, $settings, $post = null ) {
			$include_by    = $this->get_group_control_query_param_by( 'include' );
			$exclude_by    = $this->get_group_control_query_param_by( 'exclude' );
			$include_users = [];
			$exclude_users = [];

			if ( in_array( 'authors', $include_by, true ) ) {
				$include_users = wp_parse_id_list( $settings['crafto_posts_include_author_ids'] );
			} elseif ( $post ) {
				$include_users = get_post_field( 'post_author', $post );
			}

			if ( in_array( 'authors', $exclude_by, true ) ) {
				$exclude_users = wp_parse_id_list( $settings['crafto_posts_exclude_author_ids'] );
				$include_users = array_diff( $include_users, $exclude_users );
			}

			if ( ! empty( $include_users ) ) {
				$args['author__in'] = $include_users;
			}

			if ( ! empty( $exclude_users ) ) {
				$args['author__not_in'] = $exclude_users;
			}

			return $args;
		}
		/**
		 * Returns an array of terms arguments.
		 *
		 * @param array $args The arguments array.
		 * @param array $settings The settings array.
		 *
		 * @return array The modified terms arguments array.
		 */
		private function get_terms_args( $args, $settings ) {
			$include_by    = $this->get_group_control_query_param_by( 'include' );
			$exclude_by    = $this->get_group_control_query_param_by( 'exclude' );
			$include_terms = [];
			$terms_query   = [];

			if ( in_array( 'terms', $include_by, true ) ) {
				$include_terms = wp_parse_id_list( $settings['crafto_posts_include_term_ids'] );
			}

			if ( in_array( 'terms', $exclude_by, true ) ) {
				$exclude_terms = wp_parse_id_list( $settings['crafto_posts_exclude_term_ids'] );
				$include_terms = array_diff( $include_terms, $exclude_terms );
			}

			if ( ! empty( $include_terms ) ) {
				$tax_terms_map = $this->map_group_control_query( $include_terms );

				foreach ( $tax_terms_map as $tax => $terms ) {
					$terms_query[] = [
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'IN',
					];
				}
			}

			if ( ! empty( $exclude_terms ) ) {
				$tax_terms_map = $this->map_group_control_query( $exclude_terms );

				foreach ( $tax_terms_map as $tax => $terms ) {
					$terms_query[] = [
						'taxonomy' => $tax,
						'field'    => 'term_id',
						'terms'    => $terms,
						'operator' => 'NOT IN',
					];
				}
			}

			if ( ! empty( $terms_query ) ) {
				$args['tax_query']             = $terms_query; // phpcs:ignore
				$args['tax_query']['relation'] = 'AND';
			}

			return $args;
		}
		/**
		 * Returns the map group control.
		 *
		 * Initializes the $term_ids array to store term IDs.
		 *
		 * @param array $term_ids Array of term ids.
		 */
		private function map_group_control_query( $term_ids = [] ) {

			$terms = get_terms(
				[
					'term_taxonomy_id' => $term_ids,
					'hide_empty'       => false,
				]
			);

			$tax_terms_map = [];

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					$taxonomy                     = $term->taxonomy;
					$tax_terms_map[ $taxonomy ][] = $term->term_id;
				}
			}

			return $tax_terms_map;
		}

		/**
		 * @param WP_Query $query fix the offset.
		 */
		public function fix_query_offset( &$query ) {
			if ( isset( $query->query_vars['offset_to_fix'] ) ) {
				if ( $query->is_paged ) {
					$page_offset = $query->query_vars['offset_to_fix'] + ( ( $query->query_vars['paged'] - 1 ) * $query->query_vars['posts_per_page'] );
					$query->set( 'offset', $page_offset );
				} else {
					$query->set( 'offset', $query->query_vars['offset_to_fix'] );
				}
			}
		}

		/**
		 * Adjusted number of found posts after applying the offset
		 *
		 * @param mixed $found_posts The original total number of found posts.
		 *
		 * @param mixed $query Query object.
		 */
		public function prefix_adjust_offset_pagination( $found_posts, $query ) {
			if ( isset( $query->query_vars['offset_to_fix'] ) ) {
				$offset_to_fix = intval( $query->query_vars['offset_to_fix'] );

				if ( $offset_to_fix ) {
					$found_posts -= $offset_to_fix;
				}
			}

			return $found_posts;
		}

		/**
		 * @param WP_Query $wp_query fix the offset.
		 */
		public function pre_get_posts_query_filter( $wp_query ) {
			if ( $this ) {
				$query_id = $this->get_settings_for_display( 'query_id' );
				do_action( "crafto_query_loop/{$query_id}", $wp_query, $this );
			}
		}
	}
}
