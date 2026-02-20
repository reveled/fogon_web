<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_archive_portfolio_template() ) {
	return;
}
/**
 * Crafto widget for archive portfolio.
 *
 * @package Crafto
 */

// If class `Portfolio_Archive` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Portfolio_Archive' ) ) {
	/**
	 * Define `Portfolio_Archive` class.
	 */
	class Portfolio_Archive extends Widget_Base {
		/**
		 * Retrieve the list of scripts the portfolio archive widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$portfolio_archive_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$portfolio_archive_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$portfolio_archive_scripts[] = 'magnific-popup';
					$portfolio_archive_scripts[] = 'crafto-lightbox-gallery';
				}

				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$portfolio_archive_scripts[] = 'atropos';
				}

				if ( crafto_disable_module_by_key( 'justified-gallery' ) ) {
					$portfolio_archive_scripts[] = 'justified-gallery';
				}

				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$portfolio_archive_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$portfolio_archive_scripts[] = 'isotope';
				}

				if ( crafto_disable_module_by_key( 'infinite-scroll' ) ) {
					$portfolio_archive_scripts[] = 'infinite-scroll';
				}

				if ( crafto_disable_module_by_key( 'appear' ) ) {
					$portfolio_archive_scripts[] = 'appear';
				}

				if ( crafto_disable_module_by_key( 'fitvids' ) ) {
					$portfolio_archive_scripts[] = 'jquery.fitvids';
				}
				$portfolio_archive_scripts[] = 'crafto-portfolio-widget';
			}
			return $portfolio_archive_scripts;
		}
		/**
		 * Retrieve the list of styles the portfolio archive widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$portfolio_archive_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$portfolio_archive_styles[] = 'crafto-vendors-rtl';
				} else {
					$portfolio_archive_styles[] = 'crafto-vendors';
				}
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$portfolio_archive_styles[] = 'magnific-popup';
				}

				if ( crafto_disable_module_by_key( 'justified-gallery' ) ) {
					$portfolio_archive_styles[] = 'justified-gallery';
				}

				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$portfolio_archive_styles[] = 'atropos';
				}

				if ( is_rtl() ) {
					$portfolio_archive_styles[] = 'crafto-portfolio-rtl-widget';
				}
				$portfolio_archive_styles[] = 'crafto-portfolio-widget';
			}
			return $portfolio_archive_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-archive-portfolio';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Portfolio Archive', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-posts-grid crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/portfolio-archive/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
		 * @return string Widget categories.
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
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'portfolio',
				'masonry',
				'grid',
				'gallery',
				'list',
				'project',
				'term',
				'taxonomy',
				'category',
			];
		}

		/**
		 * Register portfolio archive widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_portolio_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_portfolio_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'portfolio-classic',
					'options'            => [
						'portfolio-classic'           => esc_html__( 'Classic', 'crafto-addons' ),
						'portfolio-boxed'             => esc_html__( 'Boxed', 'crafto-addons' ),
						'portfolio-transform'         => esc_html__( 'Transform', 'crafto-addons' ),
						'portfolio-creative'          => esc_html__( 'Creative', 'crafto-addons' ),
						'portfolio-attractive'        => esc_html__( 'Attractive', 'crafto-addons' ),
						'portfolio-clean'             => esc_html__( 'Clean', 'crafto-addons' ),
						'portfolio-simple'            => esc_html__( 'Simple', 'crafto-addons' ),
						'portfolio-modern'            => esc_html__( 'Modern', 'crafto-addons' ),
						'portfolio-justified-gallery' => esc_html__( 'Justified Gallery', 'crafto-addons' ),
						'portfolio-parallax'          => esc_html__( 'Parallax', 'crafto-addons' ),
						'portfolio-contemporary'      => esc_html__( 'Contemporary', 'crafto-addons' ),

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
						'crafto_portfolio_style!' => [
							'portfolio-justified-gallery',
							'portfolio-parallax',
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
						'size' => 15,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-wrap:not(.portfolio-metro) .portfolio-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul:not(.portfolio-metro).portfolio-wrap'               => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .portfolio-wrap.portfolio-metro .portfolio-item'       => 'padding: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_portfolio_style!' => [
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_portfolio_bottom_spacing',
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
						'{{WRAPPER}} .portfolio-wrap .portfolio-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style!' => [
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
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
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_portfolio_style!' => [
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_metro_positions',
				[
					'label'       => esc_html__( 'Metro Grid Positions', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Mention the positions (comma separated like 1, 4, 7) where that image will cover spacing of multiple columns and / or rows considering the image width and height.', 'crafto-addons' ),
					'condition'   => [
						'crafto_portfolio_style!' => [
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_last_row',
				[
					'label'     => esc_html__( 'Last Row (Justify)', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'nojustify',
					'options'   => [
						'nojustify' => esc_html__( 'No Justify', 'crafto-addons' ),
						'justify'   => esc_html__( 'Justify', 'crafto-addons' ),
						'left'      => esc_html__( 'Left', 'crafto-addons' ),
						'center'    => esc_html__( 'Center', 'crafto-addons' ),
						'right'     => esc_html__( 'Right', 'crafto-addons' ),
						'hide'      => esc_html__( 'Hide', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_portfolio_style' => 'portfolio-justified-gallery',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portolio_content_data',
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
				'crafto_include_portfolio_ids',
				[
					'label'       => esc_html__( 'Include Portfolio', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_portfolio_array' ) ? crafto_get_portfolio_array() : [],
					'description' => esc_html__( 'You can use this option to add certain portfolios from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'include',
					],
				]
			);
			$this->add_control(
				'crafto_exclude_portfolio_ids',
				[
					'label'       => esc_html__( 'Exclude Portfolio', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_portfolio_array' ) ? crafto_get_portfolio_array() : [],
					'description' => esc_html__( 'You can use this option to remove certain portfolios from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_post_ids' => 'exclude',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_parallax',
				[
					'label'     => esc_html__( 'Parallax effects', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'no-parallax' => esc_html__( 'No Parallax', 'crafto-addons' ),
						'0.1'         => esc_html__( 'Parallax Effect 1', 'crafto-addons' ),
						'0.2'         => esc_html__( 'Parallax Effect 2', 'crafto-addons' ),
						'0.3'         => esc_html__( 'Parallax Effect 3', 'crafto-addons' ),
						'0.4'         => esc_html__( 'Parallax Effect 4', 'crafto-addons' ),
						'0.5'         => esc_html__( 'Parallax Effect 5', 'crafto-addons' ),
					],
					'default'   => '0.5',
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-parallax',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_data_atropos_offset',
				[
					'label'     => esc_html__( 'Portfolio Offset', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => -5,
							'max' => 5,
						],
					],
					'condition' => [
						'crafto_portfolio_style' => 'portfolio-attractive',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_atropos_mobile',
				[
					'label'        => esc_html__( 'Enable Atropos in Mobile', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_portfolio_style' => 'portfolio-attractive',
					],
				],
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portolio_content_extra_option',
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
					'condition'    => [
						'crafto_portfolio_style!' => [
							'portfolio-justified-gallery',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_show_custom_link',
				[
					'label'        => esc_html__( 'Enable Link Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_portfolio_style' => [
							'portfolio-boxed',
							'portfolio-simple',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_open_lightbox',
				[
					'label'        => esc_html__( 'Enable Gallery', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_portfolio_style!' => [
							'portfolio-parallax',
							'portfolio-justified-gallery',
							'portfolio-boxed',
							'portfolio-simple',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_open_lightbox_icon',
				[
					'label'        => esc_html__( 'Enable Gallery Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_portfolio_style' => [
							'portfolio-boxed',
							'portfolio-simple',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_group_gallery',
				[
					'label'        => esc_html__( 'Enable Group Gallery', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_portfolio_open_lightbox' => 'yes',
						'crafto_portfolio_style!'        => [
							'portfolio-parallax',
							'portfolio-justified-gallery',
							'portfolio-boxed',
							'portfolio-simple',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_icon_group_gallery',
				[
					'label'        => esc_html__( 'Enable Group Gallery', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_portfolio_open_lightbox_icon' => 'yes',
						'crafto_portfolio_style' => [
							'portfolio-boxed',
							'portfolio-simple',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_justified_group_gallery',
				[
					'label'        => esc_html__( 'Enable Group Gallery', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_portfolio_style' => 'portfolio-justified-gallery',
					],
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
						'crafto_portfolio_style!' => [
							'portfolio-transform',
							'portfolio-clean',
							'portfolio-modern',
							'portfolio-creative',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_read_more_button',
				[
					'label'        => esc_html__( 'Enable Button', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_portfolio_style' => 'portfolio-parallax',
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
					'default'   => esc_html__( 'Read More', 'crafto-addons' ),
					'condition' => [
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style' => 'portfolio-parallax',
					],
				]
			);
			$this->add_control(
				'crafto_button_style',
				[
					'label'     => esc_html__( 'Button Style', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'border',
					'options'   => [
						''              => esc_html__( 'Solid', 'crafto-addons' ),
						'border'        => esc_html__( 'Border', 'crafto-addons' ),
						'double-border' => esc_html__( 'Double Border', 'crafto-addons' ),
						'underline'     => esc_html__( 'Underline', 'crafto-addons' ),
						'expand-border' => esc_html__( 'Expand Width', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style' => 'portfolio-parallax',
					],
				]
			);
			$this->add_control(
				'crafto_button_size',
				[
					'label'          => esc_html__( 'Button Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'xs',
					'options'        => [
						'xs' => esc_html__( 'Extra Small', 'crafto-addons' ),
						'sm' => esc_html__( 'Small', 'crafto-addons' ),
						'md' => esc_html__( 'Medium', 'crafto-addons' ),
						'lg' => esc_html__( 'Large', 'crafto-addons' ),
						'xl' => esc_html__( 'Extra Large', 'crafto-addons' ),
					],
					'style_transfer' => true,
					'condition'      => [
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style' => 'portfolio-parallax',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_read_more_button_icon',
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
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style' => 'portfolio-parallax',
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style' => 'portfolio-parallax',
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_button_style!'   => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_portfolio_style' => 'portfolio-parallax',
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_icon_shape_style!' => 'default',
						'crafto_button_style!'     => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_portfolio_style'   => 'portfolio-parallax',
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
						'crafto_button_icon_align!' => 'switch',
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style'    => 'portfolio-parallax',
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style' => 'portfolio-parallax',
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
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_button_style'    => 'expand-border',
						'crafto_portfolio_style' => 'portfolio-parallax',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_enable_animation',
				[
					'label'        => esc_html__( 'Enable Parallax Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_enable_masonry' => '',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_animation_value',
				[
					'label'     => esc_html__( 'Value', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'condition' => [
						'crafto_portfolio_enable_animation' => 'yes',
						'crafto_enable_masonry' => '',
					],
				]
			);
			$this->add_control(
				'crafto_button_hover_animation',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						'crafto_button_style!'   => [
							'double-border',
							'underline',
							'expand-border',
						],
						'crafto_portfolio_read_more_button' => 'yes',
						'crafto_portfolio_style' => 'portfolio-parallax',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_row_height',
				[
					'label'              => esc_html__( 'Row Height', 'crafto-addons' ),
					'type'               => Controls_Manager::NUMBER,
					'dynamic'            => [
						'active' => true,
					],
					'default'            => 500,
					'frontend_available' => true,
					'condition'          => [
						'crafto_portfolio_style' => 'portfolio-justified-gallery',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_grid_animation',
				[
					'label'     => esc_html__( 'Entrance Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::ANIMATION,
					'condition' => [
						'crafto_portfolio_style!' => 'portfolio-parallax',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_grid_animation_duration',
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
						'crafto_portfolio_grid_animation!' => '',
						'crafto_portfolio_style!'          => 'portfolio-parallax',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_grid_animation_delay',
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
						'crafto_portfolio_grid_animation!' => '',
						'crafto_portfolio_style!'          => 'portfolio-parallax',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_pagination',
				[
					'label'      => esc_html__( 'Pagination', 'crafto-addons' ),
					'show_label' => false,
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
				'crafto_portfolio_section_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_overlay_icon_v_alignment',
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
						'{{WRAPPER}} .portfolio-hover, {{WRAPPER}} .portfolio-parallax .portfolio-caption' => 'align-items: {{VALUE}};',
						'{{WRAPPER}} .portfolio-boxed .portfolio-caption-text, {{WRAPPER}} .portfolio-attractive .portfolio-caption, {{WRAPPER}} .portfolio-simple .portfolio-caption, {{WRAPPER}} .portfolio-parallax .portfolio-caption' => 'text-align: {{VALUE}};',
					],
					'condition'   => [
						'crafto_portfolio_style!' => [
							'portfolio-contemporary',
							'portfolio-creative',
							'portfolio-transform',
							'portfolio-clean',
							'portfolio-modern',
							'portfolio-justified-gallery',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_overlay_icon_h_alignment',
				[
					'label'       => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options'     => [
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
					'selectors'   => [
						'{{WRAPPER}} .portfolio-hover' => 'justify-content: {{VALUE}};',
					],
					'condition'   => [
						'crafto_portfolio_style' => [
							'portfolio-classic',
							'portfolio-attractive',
							'portfolio-boxed',
							'portfolio-contemporary',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_general_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-boxed',
							'portfolio-creative',
							'portfolio-transform',
							'portfolio-simple',
							'portfolio-modern',
							'portfolio-justified-gallery',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_general_padding',
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
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-justified-gallery .portfolio-hover, {{WRAPPER}} .portfolio-parallax .portfolio-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_image_heading',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-boxed',
							'portfolio-simple',
							'portfolio-contemporary',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_portfolio_item_image_style'
			);
			$this->start_controls_tab(
				'crafto_portfolio_item_image_normal_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-simple',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'      => 'crafto_portfolio_item_css_normal_filters',
					'selector'  => '{{WRAPPER}} .portfolio-simple .portfolio-box .portfolio-image img',
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-simple',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_portfolio_item_image_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-simple',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'      => 'crafto_portfolio_item_css_filters',
					'selector'  => '{{WRAPPER}} .portfolio-simple .portfolio-box:hover .portfolio-image img',
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-simple',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_portfolio_item_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-wrap:not(.portfolio-contemporary) .portfolio-item .portfolio-image, {{WRAPPER}} .portfolio-contemporary .portfolio-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-boxed',
							'portfolio-simple',
							'portfolio-contemporary',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_content_box_heading',
				[
					'label'     => esc_html__( 'Content Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_portfolio_style!' => [
							'portfolio-classic',
							'portfolio-attractive',
							'portfolio-clean',
							'portfolio-creative',
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_portfolio_content_box_tabs' );
				$this->start_controls_tab(
					'crafto_portfolio_content_box_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style' => [
								'portfolio-boxed',
								'portfolio-simple',
								'portfolio-contemporary',
							],
						],
					],
				);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'      => 'crafto_portfolio_content_box_color',
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
								'crafto_portfolio_style!' => [
									'portfolio-classic',
									'portfolio-attractive',
									'portfolio-creative',
									'portfolio-justified-gallery',
									'portfolio-parallax',
								],
							],
							'selector'  => '{{WRAPPER}} .portfolio-wrap:not(.portfolio-boxed, .portfolio-clean, .portfolio-simple) .portfolio-caption, {{WRAPPER}} .portfolio-boxed .portfolio-box, {{WRAPPER}} .portfolio-wrap:not(.portfolio-classic, .portfolio-contemporary, .portfolio-clean, .portfolio-modern) .portfolio-hover .subtitle, {{WRAPPER}} .portfolio-clean .portfolio-box:hover, {{WRAPPER}} .portfolio-simple .portfolio-box ',
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_portfolio_content_box_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style' => [
								'portfolio-boxed',
								'portfolio-simple',
								'portfolio-contemporary',
							],
						],
					]
				);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'      => 'crafto_portfolio_content_box_hover_color',
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
							'selector'  => '{{WRAPPER}} .portfolio-wrap:not(.portfolio-boxed, .portfolio-simple) .portfolio-box:hover .portfolio-caption, {{WRAPPER}} .portfolio-boxed .portfolio-box:hover, {{WRAPPER}} .portfolio-simple .portfolio-box:hover',
							'condition' => [
								'crafto_portfolio_style' => [
									'portfolio-boxed',
									'portfolio-simple',
									'portfolio-contemporary',
								],
							],
						]
					);
					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'crafto_portfolio_title_hover_shadow',
							'selector'  => '{{WRAPPER}} .portfolio-boxed .portfolio-box:hover',
							'condition' => [
								'crafto_portfolio_style' => [
									'portfolio-boxed',
								],
							],
						],
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_portfolio_content_box_shadow',
					'selector'  => '{{WRAPPER}} .portfolio-caption',
					'condition' => [
						'crafto_portfolio_style!' => [
							'portfolio-classic',
							'portfolio-boxed',
							'portfolio-attractive',
							'portfolio-clean',
							'portfolio-creative',
							'portfolio-simple',
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_content_box_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-caption, {{WRAPPER}} .portfolio-wrap:not(.portfolio-modern) .portfolio-hover .subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style!' => [
							'portfolio-classic',
							'portfolio-attractive',
							'portfolio-clean',
							'portfolio-boxed',
							'portfolio-creative',
							'portfolio-simple',
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
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
					'condition'  => [
						'crafto_portfolio_style!' => [
							'portfolio-classic',
							'portfolio-attractive',
							'portfolio-clean',
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-caption, {{WRAPPER}} .portfolio-wrap:not(.portfolio-creative, .portfolio-modern, .portfolio-contemporary) .portfolio-hover .subtitle, {{WRAPPER}} .portfolio-wrap.portfolio-creative .portfolio-hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_settings',
				[
					'label'      => esc_html__( 'Image', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-parallax',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_Image_height',
				[
					'label'       => esc_html__( 'Image Height', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 1600,
							'min' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .has-parallax-background' => 'height: {{SIZE}}{{UNIT}}',
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
					'selector' => '{{WRAPPER}} .portfolio-hover .title, {{WRAPPER}} .portfolio-wrap:not(.portfolio-parallax) .portfolio-caption a, {{WRAPPER}} .portfolio-hover .portfolio-caption .portfolio-caption-text .title, {{WRAPPER}} .portfolio-title, {{WRAPPER}} .portfolio-transform .title, {{WRAPPER}} .portfolio-parallax .portfolio-caption .title',
				]
			);
			$this->start_controls_tabs( 'crafto_portfolio_title_tabs' );
				$this->start_controls_tab(
					'crafto_portfolio_title_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style!' => [
								'portfolio-classic',
								'portfolio-creative',
								'portfolio-attractive',
								'portfolio-clean',
								'portfolio-modern',
								'portfolio-transform',
								'portfolio-justified-gallery',
								'portfolio-parallax',
							],
						],
					]
				);
				$this->add_control(
					'crafto_portfolio_title_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .title, {{WRAPPER}} .title a, {{WRAPPER}} .portfolio-title' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_portfolio_title_margin',
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
							'{{WRAPPER}} .title, {{WRAPPER}} .title a, {{WRAPPER}} .portfolio-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_portfolio_style!' => [
								'portfolio-boxed',
								'portfolio-creative',
								'portfolio-simple',
								'portfolio-modern',
								'portfolio-justified-gallery',
								'portfolio-contemporary',
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_portfolio_title_width',
					[
						'label'      => esc_html__( 'Width', 'crafto-addons' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => [
							'%',
							'custom',
						],
						'range'      => [
							'%' => [
								'min' => 0,
								'max' => 100,
							],
						],
						'default'    => [
							'unit' => '%',
						],
						'selectors'  => [
							'{{WRAPPER}} .title' => 'width: {{SIZE}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_portfolio_style' => 'portfolio-contemporary',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_portfolio_title_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style!' => [
								'portfolio-classic',
								'portfolio-creative',
								'portfolio-attractive',
								'portfolio-clean',
								'portfolio-modern',
								'portfolio-transform',
								'portfolio-justified-gallery',
								'portfolio-parallax',
							],
						],
					]
				);
				$this->add_control(
					'crafto_portfolio_title_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .portfolio-box:hover .title, {{WRAPPER}} .portfolio-box:hover .title a' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_portfolio_style!' => [
								'portfolio-classic',
								'portfolio-creative',
								'portfolio-attractive',
								'portfolio-clean',
								'portfolio-modern',
								'portfolio-transform',
								'portfolio-justified-gallery',
								'portfolio-parallax',
							],
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'      => 'crafto_title_text_shadow',
					'selector'  => '{{WRAPPER}} .portfolio-parallax .portfolio-caption .title',
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-parallax',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portfolio_section_subtitle_style',
				[
					'label'      => esc_html__( 'Subtitle', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_show_post_subtitle' => 'yes',
						'crafto_portfolio_style!' => 'portfolio-justified-gallery',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_portfolio_subtitle_typography',
					'selector' => '{{WRAPPER}} .subtitle',
				]
			);
			$this->start_controls_tabs( 'crafto_portfolio_subtitle_tabs' );
				$this->start_controls_tab(
					'crafto_portfolio_subtitle_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style!' => [
								'portfolio-classic',
								'portfolio-transform',
								'portfolio-creative',
								'portfolio-attractive',
								'portfolio-clean',
								'portfolio-modern',
								'portfolio-parallax',
								'portfolio-contemporary',
							],
						],
					]
				);
				$this->add_control(
					'crafto_portfolio_subtitle_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .portfolio-hover .subtitle, {{WRAPPER}} .portfolio-caption .portfolio-caption-text .subtitle, {{WRAPPER}} .portfolio-caption .subtitle, {{WRAPPER}} .portfolio-hover .portfolio-caption .portfolio-caption-text .subtitle' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_portfolio_subtitle_margin',
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
							'{{WRAPPER}} .subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						],
						'condition'  => [
							'crafto_portfolio_style!' => [
								'portfolio-transform',
								'portfolio-classic',
								'portfolio-creative',
								'portfolio-clean',
								'portfolio-simple',
								'portfolio-contemporary',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_portfolio_subtitle_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style!' => [
								'portfolio-classic',
								'portfolio-transform',
								'portfolio-creative',
								'portfolio-attractive',
								'portfolio-clean',
								'portfolio-modern',
								'portfolio-parallax',
								'portfolio-contemporary',
							],
						],
					]
				);
				$this->add_control(
					'crafto_portfolio_subtitle_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .portfolio-box:hover .subtitle' => 'color: {{VALUE}};',
						],
						'condition' => [
							'crafto_portfolio_style!' => [
								'portfolio-classic',
								'portfolio-transform',
								'portfolio-creative',
								'portfolio-attractive',
								'portfolio-clean',
								'portfolio-modern',
								'portfolio-parallax',
								'portfolio-contemporary',
							],
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_portfolio_subtitle_shadow',
					'selector'  => '{{WRAPPER}} .portfolio-box .subtitle',
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-creative',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_portfolio_subtitle_bg_color',
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
						'crafto_portfolio_style' => [
							'portfolio-creative',
						],
					],
					'selector'  => '{{WRAPPER}} .portfolio-box .subtitle',
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_subtitle_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-box .subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-creative',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_subtitle_padding',
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
					'condition'  => [
						'crafto_portfolio_style' => [
							'portfolio-creative',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-box .subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_portfolio_section_separator_style',
				[
					'label'      => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_style' => 'portfolio-simple',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_portfolio_separator_tabs' );
				$this->start_controls_tab(
					'crafto_portfolio_separator_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_portfolio_separator_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .portfolio-caption .separator-line' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_portfolio_separator_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_portfolio_separator_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .portfolio-box:hover .separator-line' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_portfolio_separator_width',
				[
					'label'     => esc_html__( 'Width', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-caption .separator-line' => 'width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portfolio_section_overlay_style',
				[
					'label'     => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_portfolio_enable_overlay' => 'yes',
						'crafto_portfolio_style!'         => [
							'portfolio-transform',
							'portfolio-clean',
							'portfolio-modern',
							'portfolio-creative',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_portfolio_overlay_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Overlay Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .portfolio-overlay, {{WRAPPER}} .portfolio-contemporary .portfolio-box, {{WRAPPER}} .portfolio-classic .portfolio-item .portfolio-image, {{WRAPPER}} .portfolio-attractive .portfolio-item .portfolio-image, {{WRAPPER}} .portfolio-simple .portfolio-item .portfolio-image, {{WRAPPER}} .portfolio-justified-gallery .portfolio-image',
					'condition'      => [
						'crafto_portfolio_style!' => [
							'portfolio-transform',
							'portfolio-creative',
						],
					],
				]
			);
			$this->add_control(
				'crafto_portfolio_image_hover_opacity',
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
						'{{WRAPPER}} .portfolio-wrap:not(.portfolio-parallax) .portfolio-box:hover .portfolio-image img, {{WRAPPER}} .portfolio-parallax .portfolio-overlay' => 'opacity: {{SIZE}};',
					],
					'condition' => [
						'crafto_portfolio_style' => [
							'portfolio-classic',
							'portfolio-attractive',
							'portfolio-boxed',
							'portfolio-simple',
							'portfolio-justified-gallery',
							'portfolio-parallax',
						],
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
						'crafto_portfolio_style!' => [
							'portfolio-classic',
							'portfolio-creative',
							'portfolio-transform',
							'portfolio-parallax',
						],
					],
				]
			);
			$this->start_controls_tabs( 'crafto_portfolio_icons_tabs' );
				$this->start_controls_tab(
					'crafto_portfolio_icons_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_portfolio_style!' => [
								'portfolio-attractive',
								'portfolio-clean',
								'portfolio-modern',
								'portfolio-contemporary',
								'portfolio-justified-gallery',
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
								'{{WRAPPER}} .portfolio-icon i, {{WRAPPER}} .portfolio-caption i, {{WRAPPER}} .portfolio-justified-gallery .portfolio-hover i' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'crafto_portfolio_icons_bg_color',
						[
							'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .portfolio-icon a, {{WRAPPER}} .portfolio-caption i, {{WRAPPER}} .portfolio-justified-gallery .portfolio-hover i' => 'background-color: {{VALUE}};',
							],
							'condition' => [
								'crafto_portfolio_style!' => [
									'portfolio-attractive',
									'portfolio-clean',
									'portfolio-modern',
									'portfolio-contemporary',
									'portfolio-justified-gallery',
								],
							],
						]
					);
					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'crafto_portfolio_icons_box_shadow',
							'selector'  => '{{WRAPPER}} .portfolio-icon a, {{WRAPPER}} .portfolio-caption i, {{WRAPPER}} .portfolio-justified-gallery .portfolio-hover i',
							'condition' => [
								'crafto_portfolio_style!' => [
									'portfolio-attractive',
									'portfolio-clean',
									'portfolio-modern',
									'portfolio-contemporary',
									'portfolio-justified-gallery',
								],
							],
						]
					);
				$this->end_controls_tab();
					$this->start_controls_tab(
						'crafto_portfolio_icons_hover_tab',
						[
							'label'     => esc_html__( 'Hover', 'crafto-addons' ),
							'condition' => [
								'crafto_portfolio_style!' => [
									'portfolio-attractive',
									'portfolio-clean',
									'portfolio-modern',
									'portfolio-contemporary',
									'portfolio-justified-gallery',
								],
							],
						]
					);
					$this->add_control(
						'crafto_portfolio_icons_hover_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .portfolio-icon a:hover i, {{WRAPPER}} .portfolio-box:hover .portfolio-caption i' => 'color: {{VALUE}};',
							],
							'condition' => [
								'crafto_portfolio_style!' => [
									'portfolio-attractive',
									'portfolio-clean',
									'portfolio-modern',
									'portfolio-contemporary',
									'portfolio-justified-gallery',
								],
							],
						]
					);
					$this->add_control(
						'crafto_portfolio_icons_bg_hover_color',
						[
							'label'     => esc_html__( 'Hover Background Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .portfolio-icon a:hover, {{WRAPPER}} .portfolio-box:hover .portfolio-caption i' => 'background-color: {{VALUE}};',
							],
							'condition' => [
								'crafto_portfolio_style!' => [
									'portfolio-attractive',
									'portfolio-clean',
									'portfolio-modern',
									'portfolio-contemporary',
									'portfolio-justified-gallery',
								],
							],
						]
					);
					$this->add_group_control(
						Group_Control_Box_Shadow::get_type(),
						[
							'name'      => 'crafto_portfolio_icons_hover_box_shadow',
							'selector'  => '{{WRAPPER}} .portfolio-icon a:hover',
							'condition' => [
								'crafto_portfolio_style!' => [
									'portfolio-attractive',
									'portfolio-clean',
									'portfolio-modern',
									'portfolio-contemporary',
									'portfolio-simple',
									'portfolio-justified-gallery',
								],
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
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
						'{{WRAPPER}} .portfolio-icon i, {{WRAPPER}} .portfolio-caption i, {{WRAPPER}} .portfolio-justified-gallery .portfolio-hover i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_box_size',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-icon a, {{WRAPPER}} .portfolio-caption i, {{WRAPPER}} .portfolio-justified-gallery .portfolio-hover i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_portfolio_style!' => [
							'portfolio-attractive',
							'portfolio-clean',
							'portfolio-modern',
							'portfolio-contemporary',
							'portfolio-justified-gallery',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_space',
				[
					'label'     => esc_html__( 'Spacing Between Icons', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-icon .lightbox-group-gallery-item, {{WRAPPER}} .portfolio-caption i' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .portfolio-icon .lightbox-group-gallery-item, .rtl {{WRAPPER}} .portfolio-caption i' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_portfolio_style!' => [
							'portfolio-attractive',
							'portfolio-clean',
							'portfolio-modern',
							'portfolio-justified-gallery',
							'portfolio-contemporary',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_portfolio_icons_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'default'    => [
						'unit'   => '%',
						'top'    => 50,
						'right'  => 50,
						'bottom' => 50,
						'left'   => 50,
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-icon a, {{WRAPPER}} .portfolio-caption i, {{WRAPPER}} .portfolio-justified-gallery .portfolio-hover i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style!' => [
							'portfolio-attractive',
							'portfolio-clean',
							'portfolio-modern',
							'portfolio-contemporary',
							'portfolio-justified-gallery',
						],
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
						'{{WRAPPER}} .portfolio-icon-wrap .subtitle + .portfolio-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_portfolio_style' => 'portfolio-contemporary',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_portfolio_read_more_style',
				[
					'label'      => esc_html__( 'Button', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_portfolio_style' => 'portfolio-parallax',
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
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
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-content-wrapper' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:focus .elementor-button-content-wrapper' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} a.elementor-button:hover i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:focus i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:focus i, {{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-round:hover .elementor-button-icon i, {{WRAPPER}} .crafto-button-wrapper a.elementor-button.elementor-button.btn-icon-circle:hover .elementor-button-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:hover .elementor-button-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_portfolio_read_more_button_icon[value]!'   => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_read_more_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.elementor-button:hover'                                                         => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button:focus'                                                         => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.btn-double-border:hover'                                       => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.btn-double-border:hover:after'                                 => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.btn-double-border:focus'                                       => 'border-color: {{VALUE}};',
						'{{WRAPPER}} a.elementor-button.elementor-animation-btn-expand-ltr:hover .btn-hover-animation' => 'border-color: {{VALUE}};',
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
						'crafto_portfolio_read_more_button_icon[value]!' => '',
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
			$this->end_controls_tab();
			$this->end_controls_tabs();
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
		 * Render portfolio archive widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {

			global $crafto_portfolio_unique_id;

			$portfolio_infinite_scroll_classes    = '';
			$settings                             = $this->get_settings_for_display();
			$crafto_default_parallax              = $this->get_settings( 'crafto_portfolio_parallax' );
			$crafto_include_portfolio_ids         = $this->get_settings( 'crafto_include_portfolio_ids' );
			$crafto_exclude_portfolio_ids         = $this->get_settings( 'crafto_exclude_portfolio_ids' );
			$portfolio_style                      = ( isset( $settings['crafto_portfolio_style'] ) && $settings['crafto_portfolio_style'] ) ? $settings['crafto_portfolio_style'] : '';
			$portfolio_enable_filter              = ( isset( $settings['crafto_enable_filter'] ) && $settings['crafto_enable_filter'] ) ? $settings['crafto_enable_filter'] : '';
			$crafto_portfolio_atropos_mobile      = ( isset( $settings['crafto_portfolio_atropos_mobile'] ) && $settings['crafto_portfolio_atropos_mobile'] ) ? $settings['crafto_portfolio_atropos_mobile'] : '';
			$crafto_portfolio_last_row            = ( isset( $settings['crafto_portfolio_last_row'] ) && $settings['crafto_portfolio_last_row'] ) ? $settings['crafto_portfolio_last_row'] : '';
			$crafto_portfolio_data_atropos_offset = ( isset( $settings['crafto_portfolio_data_atropos_offset']['size'] ) && ! empty( $settings['crafto_portfolio_data_atropos_offset']['size'] ) ) ? (int) $settings['crafto_portfolio_data_atropos_offset']['size'] : 0;
			$crafto_thumbnail                     = ( isset( $settings['crafto_thumbnail'] ) && $settings['crafto_thumbnail'] ) ? $settings['crafto_thumbnail'] : 'full';
			/* Column Settings */
			$crafto_column_desktop_column = ! empty( $settings['crafto_column_settings'] ) ? $settings['crafto_column_settings'] : '3';
			$crafto_column_laptop_column  = ! empty( $settings['crafto_column_settings_laptop'] ) ? $settings['crafto_column_settings_laptop']['size'] : '';

			$crafto_column_class_list = '';
			$crafto_column_ratio      = '';
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

			$crafto_column_class = [];

			$crafto_column_class[] = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[] = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';

			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );
			/* End Column Settings */

			$portfolio_show_post_title         = ( isset( $settings['crafto_portfolio_show_post_title'] ) && $settings['crafto_portfolio_show_post_title'] ) ? $settings['crafto_portfolio_show_post_title'] : '';
			$portfolio_show_post_subtitle      = ( isset( $settings['crafto_portfolio_show_post_subtitle'] ) && $settings['crafto_portfolio_show_post_subtitle'] ) ? $settings['crafto_portfolio_show_post_subtitle'] : '';
			$portfolio_show_group_gallery      = ( isset( $settings['crafto_portfolio_group_gallery'] ) && $settings['crafto_portfolio_group_gallery'] ) ? $settings['crafto_portfolio_group_gallery'] : '';
			$portfolio_show_group_icon_gallery = ( isset( $settings['crafto_portfolio_icon_group_gallery'] ) && $settings['crafto_portfolio_icon_group_gallery'] ) ? $settings['crafto_portfolio_icon_group_gallery'] : '';
			$portfolio_show_lightbox           = ( isset( $settings['crafto_portfolio_open_lightbox'] ) && $settings['crafto_portfolio_open_lightbox'] ) ? $settings['crafto_portfolio_open_lightbox'] : '';
			$portfolio_show_lightbox_icon      = ( isset( $settings['crafto_portfolio_open_lightbox_icon'] ) && $settings['crafto_portfolio_open_lightbox_icon'] ) ? $settings['crafto_portfolio_open_lightbox_icon'] : '';
			$portfolio_orderby                 = ( isset( $settings['crafto_portfolio_orderby'] ) && $settings['crafto_portfolio_orderby'] ) ? $settings['crafto_portfolio_orderby'] : '';
			$portfolio_order                   = ( isset( $settings['crafto_portfolio_order'] ) && $settings['crafto_portfolio_order'] ) ? $settings['crafto_portfolio_order'] : '';
			$crafto_pagination                 = ( isset( $settings['crafto_pagination'] ) && $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';
			$crafto_enable_masonry             = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';
			$crafto_enable_animation           = ( isset( $settings['crafto_portfolio_enable_animation'] ) && $settings['crafto_portfolio_enable_animation'] ) ? $settings['crafto_portfolio_enable_animation'] : '';
			$crafto_animation_value            = ( isset( $settings['crafto_portfolio_animation_value'] ) && $settings['crafto_portfolio_animation_value'] ) ? $settings['crafto_portfolio_animation_value'] : '';

			// Entrance Animation.
			$crafto_portfolio_grid_animation          = ( isset( $settings['crafto_portfolio_grid_animation'] ) && $settings['crafto_portfolio_grid_animation'] ) ? $settings['crafto_portfolio_grid_animation'] : '';
			$crafto_portfolio_grid_animation_duration = ( isset( $settings['crafto_portfolio_grid_animation_duration'] ) && $settings['crafto_portfolio_grid_animation_duration'] ) ? $settings['crafto_portfolio_grid_animation_duration'] : '';
			$crafto_portfolio_grid_animation_delay    = ( isset( $settings['crafto_portfolio_grid_animation_delay'] ) && $settings['crafto_portfolio_grid_animation_delay'] ) ? $settings['crafto_portfolio_grid_animation_delay'] : 100;

			// Check if portfolio id and class.
			$crafto_portfolio_unique_id = ! empty( $crafto_portfolio_unique_id ) ? $crafto_portfolio_unique_id : 1;
			$crafto_portfolio_id        = 'crafto-portfolio';
			$crafto_portfolio_id       .= '-' . $crafto_portfolio_unique_id;
			++$crafto_portfolio_unique_id;

			$query_args = array(
				'post_status' => 'publish',
			);

			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
				$query_args['post_type'] = 'portfolio';
			} else {
				if ( is_singular( 'themebuilder' ) ) {
					$query_args['post_type'] = 'portfolio';
				} else {
					global $wp_query;
					$query_args = $wp_query->query_vars;
				}
			}

			if ( ! empty( $crafto_include_portfolio_ids ) ) {
				$crafto_include_portfolio_ids = array_merge( $crafto_include_portfolio_ids );
			}

			if ( ! empty( $crafto_exclude_portfolio_ids ) ) {
				$crafto_exclude_portfolio_ids = array_merge( $crafto_exclude_portfolio_ids );
			}

			if ( ! empty( $crafto_include_portfolio_ids ) ) {
				$query_args['post__in'] = $crafto_include_portfolio_ids;
			}

			if ( ! empty( $crafto_exclude_portfolio_ids ) ) {
				$query_args['post__not_in'] = $crafto_exclude_portfolio_ids;
			}

			if ( ! empty( $portfolio_orderby ) ) {
				$query_args['orderby'] = $portfolio_orderby;
			}

			if ( ! empty( $portfolio_order ) ) {
				$query_args['order'] = $portfolio_order;
			}

			$portfolio_grid_status_filter = ( 'yes' === $portfolio_enable_filter ) ? 'portfolio-grid-with-filter' : 'portfolio-grid-without-filter';

			$wp_query = new \WP_Query( $query_args ); // phpcs:ignore

			$datasettings = [
				'pagination_type'                 => $crafto_pagination,
				'crafto_portfolio_atropos_mobile' => $crafto_portfolio_atropos_mobile,
				'crafto_enable_masonry'           => $crafto_enable_masonry,
			];

			$this->add_render_attribute(
				'wrapper',
				[
					'class' => [
						$portfolio_style,
					],
				],
			);

			if ( '' !== $this->get_settings( 'crafto_portfolio_metro_positions' ) ) {
				$this->add_render_attribute(
					'wrapper',
					[
						'class' => [
							'portfolio-metro',
						],
					],
				);
			}

			if ( ( 'yes' === $crafto_enable_masonry || 'yes' === $portfolio_enable_filter ) && 'portfolio-parallax' !== $portfolio_style ) {
				// common class for all styles.
				$this->add_render_attribute(
					'wrapper',
					[
						'class' => [
							'portfolio-wrap',
							'grid-masonry',
						],
					],
				);
			} else {
				// common class for all styles.
				$this->add_render_attribute(
					'wrapper',
					[
						'class' => [
							'portfolio-wrap',
							'no-masonry',
						],
					],
				);
			}

			$loader_class = '';
			if ( ! Plugin::$instance->editor->is_edit_mode() ) {
				$loader_class = 'yes' === $settings['crafto_section_enable_grid_preloader'] ? 'grid-loading' : '';
			} elseif ( ! Plugin::$instance->preview->is_preview_mode() ) {
				$loader_class = 'yes' === $settings['crafto_section_enable_grid_preloader'] ? 'grid-loading' : '';
			}

			$this->add_render_attribute(
				'main_wrapper',
				[
					'class' => [
						'filter-content',
					],
				],
			);

			switch ( $portfolio_style ) {
				case 'portfolio-justified-gallery':
					$this->add_render_attribute(
						'wrapper',
						[
							'class'                   => [
								'portfolio-grid',
								'justified-gallery',
								$portfolio_grid_status_filter,
								$crafto_portfolio_id,
							],
							'data-filter-status'      => $portfolio_enable_filter,
							'data-portfolio-settings' => wp_json_encode( $datasettings ),
							'data-last-row'           => $crafto_portfolio_last_row,
						],
					);
					break;
				case 'portfolio-parallax':
					$this->add_render_attribute(
						'wrapper',
						[
							'class'                   => [
								'portfolio-grid',
								$portfolio_grid_status_filter,
								$crafto_portfolio_id,
							],
							'data-filter-status'      => $portfolio_enable_filter,
							'data-portfolio-settings' => wp_json_encode( $datasettings ),
						],
					);
					break;
				default:
					if ( 'yes' === $crafto_enable_masonry || 'yes' === $portfolio_enable_filter ) {
						$this->add_render_attribute(
							'wrapper',
							[
								'class'                   => [
									'portfolio-grid',
									'grid',
									$loader_class,
									$portfolio_grid_status_filter,
									$crafto_column_class_list,
								],
								'data-filter-status'      => $portfolio_enable_filter,
								'data-portfolio-settings' => wp_json_encode( $datasettings ),
								'data-uniqueid'           => $crafto_portfolio_id,
							],
						);
					} else {
						$this->add_render_attribute(
							'wrapper',
							[
								'class'                   => [
									'grid',
									$loader_class,
									$portfolio_grid_status_filter,
									$crafto_column_class_list,
								],
								'data-filter-status'      => $portfolio_enable_filter,
								'data-portfolio-settings' => wp_json_encode( $datasettings ),
								'data-uniqueid'           => $crafto_portfolio_id,
							],
						);
					}
					break;
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
					'class' => 'portfolio-box',
				],
			);

			if ( 'yes' !== $settings['crafto_portfolio_enable_overlay'] ) {
				$this->add_render_attribute(
					'parallax_overlay',
					[
						'class' => 'disable-overlay',
					],
				);
			}
			$this->add_render_attribute(
				'parallax_overlay',
				[
					'class' => 'portfolio-overlay',
				],
			);

			/* Portfolio Metro */
			$crafto_portfolio_metro_positions = $this->get_settings( 'crafto_portfolio_metro_positions' );
			$crafto_double_grid_position      = ( ! empty( $crafto_portfolio_metro_positions ) ) ? array_map( 'intval', explode( ',', $crafto_portfolio_metro_positions ) ) : [];
			if ( $wp_query->have_posts() ) {
				?>
				<div <?php $this->print_render_attribute_string( 'main_wrapper' ); ?>>
					<?php
					crafto_start_wrapper( $this ); // phpcs:ignore

					$index            = 0;
					$grid_count       = 1;
					$i                = 1;
					$grid_metro_count = 1;
					$row              = 1;
					$l_row            = 1;
					$col              = 1;
					$l_col            = 1;

					while ( $wp_query->have_posts() ) {
						$wp_query->the_post();

						if ( 0 === $index % $crafto_column_ratio ) {
							$grid_count = 1;
						}

						$cat_slug_cls          = [];
						$image_url             = '';
						$inner_wrap_key        = 'inner_wrap_' . $index;
						$attractive_wrap_key   = 'inner_wrap_' . $index;
						$custom_link_key       = 'custom_link_' . $index;
						$link_key              = 'link_' . $index;
						$title_link_key        = 'title_link_' . $index;
						$group_link_key        = 'group_' . $index;
						$title_group_link_key  = 'title_group_' . $index;
						$crafto_subtitle       = crafto_post_meta( 'crafto_subtitle' );
						$portfolio_link_target = crafto_post_meta( 'crafto_portfolio_link_target' );
						$cat                   = get_the_terms( get_the_ID(), 'portfolio-category' );
						$tag                   = get_the_terms( get_the_ID(), 'portfolio-tags' );
						$thumbnail_id          = get_post_thumbnail_id( get_the_ID() );

						if ( has_post_format( 'link', get_the_ID() ) ) {
							$portfolio_external_link = crafto_post_meta( 'crafto_portfolio_external_link' );
							$portfolio_link_target   = crafto_post_meta( 'crafto_portfolio_link_target' );
							$portfolio_external_link = ( ! empty( $portfolio_external_link ) ) ? $portfolio_external_link : '#';
							$portfolio_link_target   = ( ! empty( $portfolio_link_target ) ) ? $portfolio_link_target : '_self';
						} elseif ( has_post_format( 'video', get_the_ID() ) ) {
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

						if ( ! empty( $cat ) && ! is_wp_error( $cat ) ) {
							foreach ( $cat as $c ) {
								$cat_slug_cls[] = 'portfolio-filter-' . $c->term_id;
							}
						}
						if ( ! empty( $tag ) && ! is_wp_error( $tag ) ) {
							foreach ( $tag as $t ) {
								$cat_slug_cls[] = 'portfolio-filter-' . $t->term_id;
							}
						}

						$crafto_subtitle     = ( $crafto_subtitle ) ? str_replace( '||', '<br />', $crafto_subtitle ) : '';
						$cat_slug_class_list = implode( ' ', $cat_slug_cls );

						if ( 'portfolio-justified-gallery' === $portfolio_style ) {
							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class' => [
										'jg-entry',
										'grid-item',
										$cat_slug_class_list,
										$portfolio_infinite_scroll_classes,
									],
								],
							);
						} elseif ( 'portfolio-parallax' === $portfolio_style ) {
							if ( has_post_thumbnail() ) {
								$featured_img_url = get_the_post_thumbnail_url( get_the_ID(), $crafto_thumbnail );
							} else {
								$featured_img_url = Utils::get_placeholder_image_src();
							}
							$crafto_parallax_ratio = ( 'no-parallax' !== $crafto_default_parallax ) ? esc_attr( $crafto_default_parallax ) : '';
							$crafto_parallax_class = ( 'no-parallax' !== $crafto_default_parallax ) ? 'has-parallax-background' : 'no-parallax';
							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class' => [
										'grid-item',
										'cover-background',
										$crafto_parallax_class,
										$cat_slug_class_list,
									],
									'style' => [
										'background-image: url(' . esc_url( $featured_img_url ) . ');',
									],
									'data-parallax-background-ratio' => $crafto_parallax_ratio,
								],
							);
						} else {
							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class' => [
										'portfolio-item',
										'grid-item',
										$cat_slug_class_list,
										$portfolio_infinite_scroll_classes,
									],
								],
							);
						}

						if ( 'portfolio-attractive' === $portfolio_style ) {
							$this->add_render_attribute(
								$attractive_wrap_key,
								[
									'class' => [
										'grid-item',
										'atropos',
										'has-atropos',
										$cat_slug_class_list,
										$portfolio_infinite_scroll_classes,
									],
								],
							);
						}

						if ( ! empty( $crafto_double_grid_position ) && in_array( $grid_metro_count, $crafto_double_grid_position, true ) ) {
							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class' => [
										'grid-item-double',
									],
								]
							);
						}

						// Entrance Animation.
						if ( '' !== $crafto_portfolio_grid_animation && 'none' !== $crafto_portfolio_grid_animation && 'portfolio-parallax' !== $portfolio_style ) {
							$this->add_render_attribute(
								$inner_wrap_key,
								[
									'class'                => [
										'crafto-animated',
										'elementor-invisible',
									],
									'data-animation'       => [
										$crafto_portfolio_grid_animation,
										$crafto_portfolio_grid_animation_duration,
									],
									'data-animation-delay' => $grid_count * $crafto_portfolio_grid_animation_delay,
								]
							);
						}

						$animation_val = true;
						switch ( $portfolio_style ) {
							case 'portfolio-parallax':
								$animation_val = false;
								break;
							case 'portfolio-justified-gallery':
								$animation_val = false;
								break;
						}

						if ( true === $animation_val ) {
							if ( 'yes' === $crafto_enable_animation ) {

								$published_posts           = $wp_query->post_count;
								$number_of_desktop_columns = $crafto_column_desktop_column['size'];
								$number_of_desktop_rows    = ceil( $published_posts / $number_of_desktop_columns );

								$number_of_laptop_columns = intval( $crafto_column_laptop_column );
								if ( $number_of_laptop_columns > 0 ) {
									$number_of_laptop_rows = ceil( $published_posts / $number_of_laptop_columns );
								} else {
									$number_of_laptop_rows = 0;
								}

								if ( $row <= $number_of_desktop_rows ) {

									$current_animation_d_value = $crafto_animation_value / pow( 2, $row - 1 );

									if ( $col <= $number_of_desktop_columns ) {

										$animation_wrapper = "row_{$row}_column_{$col}_inner_wrap";

										if ( 1 === $col % 2 ) {
											$this->add_render_attribute(
												$animation_wrapper,
												[
													'data-bottom-top' => 'transform: translateY(' . $current_animation_d_value . 'px)',
													'data-top-bottom' => 'transform: translateY(' . -$current_animation_d_value . 'px)',
													'data-dektop-bottom-top' => 'transform: translateY(' . $current_animation_d_value . 'px)',
													'data-dektop-top-bottom' => 'transform: translateY(' . -$current_animation_d_value . 'px)',
													'class' => 'portfolio-animation',
												]
											);

										} else {
											$this->add_render_attribute(
												$animation_wrapper,
												[
													'data-bottom-top' => 'transform: translateY(' . -$current_animation_d_value . 'px)',
													'data-top-bottom' => 'transform: translateY(' . $current_animation_d_value . 'px)',
													'data-dektop-bottom-top' => 'transform: translateY(' . -$current_animation_d_value . 'px)',
													'data-dektop-top-bottom' => 'transform: translateY(' . $current_animation_d_value . 'px)',
													'class' => 'portfolio-animation',
												]
											);
										}
									}
								}

								if ( $l_row <= $number_of_laptop_rows ) {

									$laptop_current_animation_value = $crafto_animation_value / pow( 2, $l_row - 1 );
									if ( $l_col <= $number_of_laptop_columns ) {

										$animation_wrapper = "row_{$row}_column_{$col}_inner_wrap";

										if ( 1 === $l_col % 2 ) {
											$this->add_render_attribute(
												$animation_wrapper,
												[
													'data-laptop-bottom-top' => 'transform: translateY(' . $laptop_current_animation_value . 'px)',
													'data-laptop-top-bottom' => 'transform: translateY(' . -$laptop_current_animation_value . 'px)',
												]
											);

										} else {
											$this->add_render_attribute(
												$animation_wrapper,
												[
													'data-laptop-bottom-top' => 'transform: translateY(' . -$laptop_current_animation_value . 'px)',
													'data-laptop-top-bottom' => 'transform: translateY(' . $laptop_current_animation_value . 'px)',
												]
											);
										}
									}
								}
							}
						}

						/* Start Lightbox */
						if ( has_post_thumbnail() ) {
							$image_url = get_the_post_thumbnail_url( get_the_ID(), $crafto_thumbnail );

							$crafto_image_title_lightbox_popup   = get_theme_mod( 'crafto_image_title_lightbox_popup', '0' );
							$crafto_image_caption_lightbox_popup = get_theme_mod( 'crafto_image_caption_lightbox_popup', '0' );

							if ( '1' === $crafto_image_title_lightbox_popup ) {
								$crafto_attachment_title = get_the_title( $thumbnail_id );
								if ( ! empty( $crafto_attachment_title ) ) {
									$this->add_render_attribute(
										$link_key,
										[
											'title' => $crafto_attachment_title,
										]
									);
								}
							}

							if ( '1' === $crafto_image_caption_lightbox_popup ) {
								$crafto_lightbox_caption = wp_get_attachment_caption( $thumbnail_id );
								if ( ! empty( $crafto_lightbox_caption ) ) {
									$this->add_render_attribute(
										$link_key,
										[
											'data-lightbox-caption' => $crafto_lightbox_caption,
										]
									);
								}
							}
						} else {
							$image_url = Utils::get_placeholder_image_src();
						}

						$this->add_render_attribute(
							$link_key,
							[
								'href'       => $image_url,
								'data-group' => $this->get_id(),
								'class'      => 'lightbox-group-gallery-item',
								'data-elementor-open-lightbox' => 'no',
							]
						);
						$this->add_render_attribute(
							$title_link_key,
							[
								'href'       => $image_url,
								'data-group' => 'title_' . $this->get_id(),
								'class'      => 'lightbox-group-gallery-item',
								'data-elementor-open-lightbox' => 'no',
							]
						);
						/* Group Lightbox. */
						if ( ( ( 'yes' === $portfolio_show_lightbox || 'yes' === $portfolio_show_lightbox_icon ) && ( 'yes' === $portfolio_show_group_gallery ) || 'yes' === $portfolio_show_group_icon_gallery ) ) {
							$this->add_render_attribute(
								$group_link_key,
								[
									'href'       => $image_url,
									'data-group' => get_the_ID(),
									'data-elementor-open-lightbox' => 'no',
								]
							);
							$this->add_render_attribute(
								$title_group_link_key,
								[
									'href'       => $image_url,
									'data-group' => 'title_' . get_the_ID(),
									'data-elementor-open-lightbox' => 'no',
								]
							);
						}
						/* End Lightbox */

						switch ( $portfolio_style ) {
							case 'portfolio-classic':
							default:
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									if ( 'yes' === $portfolio_show_lightbox ) {
										if ( 'yes' === $portfolio_show_group_gallery ) {
											?>
											<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
											<?php
										} else {
											?>
											<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<?php
										}
									} else {
										?>
										<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
										<div class="portfolio-image">
											<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
											<div class="portfolio-hover">
												<?php
												if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
													if ( 'yes' === $portfolio_show_post_title ) {
														?>
														<span class="title"><?php the_title(); ?></span>
														<?php
													}
													if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
														printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
													}
												}
												?>
											</div>
										</div>
									</div>
									<?php
									if ( 'yes' === $portfolio_show_lightbox ) {
										?>
										</a>
										<?php
									} else {
										?>
										</a>
										<?php
									}
									if ( 'yes' === $portfolio_show_group_gallery && 'yes' === $portfolio_show_lightbox ) {
										$this->crafto_group_gallery();
									}
									?>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-boxed':
								$crafto_single_portfolio_item_hover_color = crafto_post_meta( 'crafto_single_portfolio_item_hover_color' );

								$crafto_item_hover_color_style = '';
								if ( $crafto_single_portfolio_item_hover_color ) {
									$crafto_item_hover_color_style = ' style="background-color:' . $crafto_single_portfolio_item_hover_color . '"';
								}
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
										<div class="portfolio-image">
											<?php
											if ( '' === $portfolio_show_lightbox_icon && '' === $settings['crafto_portfolio_show_custom_link'] ) {
												?>
												<a href="<?php the_permalink(); ?>">
												<?php
											}
											crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore
											if ( 'yes' === $settings['crafto_portfolio_enable_overlay'] ) {
												?>
												<div class="portfolio-overlay"<?php echo sprintf( '%s', $crafto_item_hover_color_style ); // phpcs:ignore ?>></div>
												<?php
											}
											if ( '' === $portfolio_show_lightbox_icon && '' === $settings['crafto_portfolio_show_custom_link'] ) {
												?>
												</a>
												<?php
											}
											?>
											<div class="portfolio-hover">
												<div class="portfolio-icon">
													<?php
													if ( 'yes' === $portfolio_show_lightbox_icon ) {
														if ( 'yes' === $portfolio_show_group_icon_gallery ) {
															?>
															<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
															<?php
														} else {
															?>
															<a <?php $this->print_render_attribute_string( $link_key ); ?>>
															<?php
														}
														?>
														<i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
														</a>
														<?php
													}
													if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
														?>
														<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
															<i class="fa-solid fa-plus" aria-hidden="true"></i>
														</a>
														<?php
													}
													?>
												</div>
											</div>
										</div>
										<?php
										if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
											?>
											<div class="portfolio-caption">
												<div class="portfolio-caption-text">
													<?php
													if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
														printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
													}

													if ( 'yes' === $portfolio_show_post_title ) {
														?>
														<span class="title">
															<?php
															if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
																?>
																<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
																	<?php the_title(); ?>
																</a>
																<?php
															} elseif ( 'yes' === $portfolio_show_lightbox_icon ) {
																if ( 'yes' === $portfolio_show_group_icon_gallery ) {
																	?>
																	<a <?php $this->print_render_attribute_string( $title_group_link_key ); ?>>
																	<?php
																} else {
																	?>
																	<a <?php $this->print_render_attribute_string( $title_link_key ); ?>>
																	<?php
																}
																the_title();
																?>
																</a>
																<?php
															} else {
																?>
																<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
																	<?php the_title(); ?>
																</a>
																<?php
															}
															?>
														</span>
														<?php
													}
													?>
												</div>
											</div>
											<?php
										}
										if ( 'yes' === $portfolio_show_group_icon_gallery && 'yes' === $portfolio_show_lightbox_icon ) {
											$this->crafto_group_gallery();
										}
										if ( 'yes' === $portfolio_show_group_icon_gallery && 'yes' === $portfolio_show_lightbox_icon && 'yes' === $portfolio_show_post_title ) {
											$this->crafto_title_group_gallery();
										}
										?>
									</div>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-transform':
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									?>
									<div class="mousetip-wrapper">
										<?php
										if ( 'yes' === $portfolio_show_lightbox ) {
											if ( 'yes' === $portfolio_show_group_gallery ) {
												?>
												<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
												<?php
											} else {
												?>
												<a <?php $this->print_render_attribute_string( $link_key ); ?>>
												<?php
											}
										} else {
											?>
											<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
											<?php
										}
										?>
										<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
											<div class="portfolio-image">
												<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
											</div>
										</div>
										<?php
										if ( 'yes' === $portfolio_show_lightbox ) {
											?>
											</a>
											<?php
										} else {
											?>
											</a>
											<?php
										}
										if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
											?>
											<div class="portfolio-caption caption">
												<?php
												if ( 'yes' === $portfolio_show_post_title ) {
													?>
													<span class="title"><?php the_title(); ?></span>
													<?php
												}
												if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
													printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
												}
												?>
											</div>
											<?php
										}
										if ( 'yes' === $portfolio_show_group_gallery && 'yes' === $portfolio_show_lightbox ) {
											$this->crafto_group_gallery();
										}
										?>
									</div>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-creative':
								$crafto_single_portfolio_item_hover_color = crafto_post_meta( 'crafto_single_portfolio_item_hover_color' );

								$crafto_item_hover_color_style = '';
								if ( $crafto_single_portfolio_item_hover_color ) {
									$crafto_item_hover_color_style = ' style="background-color:' . $crafto_single_portfolio_item_hover_color . '"';
								}
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									if ( 'yes' === $portfolio_show_lightbox ) {
										if ( 'yes' === $portfolio_show_group_gallery ) {
											?>
											<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
											<?php
										} else {
											?>
											<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<?php
										}
									} else {
										?>
										<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
										<div class="portfolio-image">
											<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
										</div>
										<div class="portfolio-hover"<?php echo sprintf( '%s', $crafto_item_hover_color_style ); // phpcs:ignore ?>>
											<?php
											if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
												if ( 'yes' === $portfolio_show_post_title ) {
													?>
													<div class="portfolio-title" data-text="<?php the_title(); ?>"></div>
													<?php
												}
												if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
													printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
												}
											}
											?>
										</div>
									</div>
									<?php
									if ( 'yes' === $portfolio_show_lightbox ) {
										?>
										</a>
										<?php
									} else {
										?>
										</a>
										<?php
									}
									if ( 'yes' === $portfolio_show_group_gallery && 'yes' === $portfolio_show_lightbox ) {
										$this->crafto_group_gallery();
									}
									?>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-attractive':
								?>
								<li <?php $this->print_render_attribute_string( $attractive_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									?>
									<div class="atropos-scale">
										<div class="atropos-rotate">
											<div class="atropos-inner" data-atropos-offset="<?php echo esc_attr( (int) $crafto_portfolio_data_atropos_offset ); ?>">
												<?php
												if ( 'yes' === $portfolio_show_lightbox ) {
													if ( 'yes' === $portfolio_show_group_gallery ) {
														?>
														<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
														<?php
													} else {
														?>
														<a <?php $this->print_render_attribute_string( $link_key ); ?>>
														<?php
													}
												} else {
													?>
													<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
													<?php
												}
												?>
												<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
													<div class="portfolio-image">
														<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
													</div>
													<div class="portfolio-hover">
														<div class="portfolio-icon">
															<i class="bi bi-arrow-up-right" aria-hidden="true"></i>
														</div>
														<?php
														if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
															?>
															<div class="portfolio-caption">
																<?php
																if ( 'yes' === $portfolio_show_post_title ) {
																	?>
																	<span class="title"><?php the_title(); ?></span>
																	<?php
																}
																if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
																	printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
																}
																?>
															</div>
															<?php
														}
														?>
													</div>
												</div>
												<?php
												if ( 'yes' === $portfolio_show_lightbox ) {
													?>
													</a>
													<?php
												} else {
													?>
													</a>
													<?php
												}
												if ( 'yes' === $portfolio_show_group_gallery && 'yes' === $portfolio_show_lightbox ) {
													$this->crafto_group_gallery();
												}
												?>
											</div>
										</div>
									</div>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-clean':
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									if ( 'yes' === $portfolio_show_lightbox ) {
										if ( 'yes' === $portfolio_show_group_gallery ) {
											?>
											<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
											<?php
										} else {
											?>
											<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<?php
										}
									} else {
										?>
										<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
										<div class="portfolio-image">
											<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
										</div>
										<div class="portfolio-hover">
											<?php
											if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
												?>
												<div class="portfolio-caption">
													<div class="portfolio-caption-text">
														<?php
														if ( 'yes' === $portfolio_show_post_title ) {
															?>
															<span class="title"><?php the_title(); ?></span>
															<?php
														}
														if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
															printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
														}
														?>
													</div>
													<i class="line-icon-Arrow-OutRight" aria-hidden="true"></i>
												</div>
												<?php
											}
											?>
										</div>
									</div>
									<?php
									if ( 'yes' === $portfolio_show_lightbox ) {
										?>
										</a>
										<?php
									} else {
										?>
										</a>
										<?php
									}
									if ( 'yes' === $portfolio_show_group_gallery && 'yes' === $portfolio_show_lightbox ) {
										$this->crafto_group_gallery();
									}
									?>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-simple':
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
										<div class="portfolio-image">
											<?php
											if ( '' === $portfolio_show_lightbox_icon && '' === $settings['crafto_portfolio_show_custom_link'] ) {
												?>
												<a href="<?php the_permalink(); ?>">
												<?php
											}
											crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore
											if ( '' === $portfolio_show_lightbox_icon && '' === $settings['crafto_portfolio_show_custom_link'] ) {
												?>
												</a>
												<?php
											}
											?>
											<div class="portfolio-hover">
												<?php
												if ( 'yes' === $portfolio_show_lightbox_icon || 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
													?>
													<div class="portfolio-icon">
														<?php
														if ( 'yes' === $portfolio_show_lightbox_icon ) {
															if ( 'yes' === $portfolio_show_group_icon_gallery ) {
																?>
																<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
																<?php
															} else {
																?>
																<a <?php $this->print_render_attribute_string( $link_key ); ?>>
																<?php
															}
															?>
															<i class="feather icon-feather-search" aria-hidden="true"></i>
															</a>
															<?php
														}
														if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
															?>
															<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
																<i class="feather icon-feather-link" aria-hidden="true"></i>
															</a>
															<?php
														}
														?>
													</div>
													<?php
												}
												?>
											</div>
										</div>
										<?php
										if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
											?>
											<div class="portfolio-caption">
												<?php
												if ( 'yes' === $portfolio_show_post_title ) {
													?>
													<span class="title">
														<?php
														if ( 'yes' === $settings['crafto_portfolio_show_custom_link'] ) {
															?>
															<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
																<?php the_title(); ?>
															</a>
															<?php
														} elseif ( 'yes' === $portfolio_show_lightbox_icon ) {
															if ( 'yes' === $portfolio_show_group_icon_gallery ) {
																?>
																<a <?php $this->print_render_attribute_string( $title_group_link_key ); ?>>
																<?php
															} else {
																?>
																<a <?php $this->print_render_attribute_string( $title_link_key ); ?>>
																<?php
															}
															the_title();
															?>
															</a>
															<?php
														} else {
															?>
															<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
																<?php the_title(); ?>
															</a>
															<?php
														}
														?>
													</span>
													<?php
												}
												if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
													?>
													<span class="separator-line"></span>
													<?php
													printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
												}
												?>
											</div>
											<?php
										}
										if ( 'yes' === $portfolio_show_group_icon_gallery && 'yes' === $portfolio_show_lightbox_icon ) {
											$this->crafto_group_gallery();
										}
										if ( 'yes' === $portfolio_show_group_icon_gallery && 'yes' === $portfolio_show_lightbox_icon && 'yes' === $portfolio_show_post_title ) {
											$this->crafto_title_group_gallery();
										}
										?>
									</div>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-modern':
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									if ( 'yes' === $portfolio_show_lightbox ) {
										if ( 'yes' === $portfolio_show_group_gallery ) {
											?>
											<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
											<?php
										} else {
											?>
											<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<?php
										}
									} else {
										?>
										<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
										<div class="portfolio-image">
											<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
										</div>
										<div class="portfolio-hover">
											<div class="portfolio-caption">
												<?php
												if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
													?>
													<div class="portfolio-caption-text">
														<?php
														if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
															printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
														}
														if ( 'yes' === $portfolio_show_post_title ) {
															?>
															<span class="title"><?php the_title(); ?></span>
															<?php
														}
														?>
													</div>
													<?php
												}
												?>
												<div class="portfolio-icon">
													<i class="feather icon-feather-plus" aria-hidden="true"></i>
												</div>
											</div>
										</div>
									</div>
									<?php
									if ( 'yes' === $portfolio_show_lightbox ) {
										?>
										</a>
										<?php
									} else {
										?>
										</a>
										<?php
									}
									if ( 'yes' === $portfolio_show_group_gallery && 'yes' === $portfolio_show_lightbox ) {
										$this->crafto_group_gallery();
									}
									?>
									</div>
								</li>
								<?php
								break;
							case 'portfolio-justified-gallery':
								$crafto_single_portfolio_item_hover_color = crafto_post_meta( 'crafto_single_portfolio_item_hover_color' );

								$crafto_item_hover_color_style = '';
								if ( $crafto_single_portfolio_item_hover_color ) {
									$crafto_item_hover_color_style = ' style="background-color:' . $crafto_single_portfolio_item_hover_color . '"';
								}
								?>
								<div <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<div class="anime-wrap">
										<?php
										if ( 'yes' === $settings['crafto_portfolio_justified_group_gallery'] ) {
											?>
											<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
											<?php
										} else {
											?>
											<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<?php
										}
										?>
										<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
											<div class="portfolio-image">
												<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
											</div>
											<div class="portfolio-hover"<?php echo sprintf( '%s', $crafto_item_hover_color_style ); // phpcs:ignore ?>>
												<i class="feather icon-feather-search" aria-hidden="true"></i>
												<?php
												if ( 'yes' === $portfolio_show_post_title ) {
													?>
													<span class="title"><?php the_title(); ?></span>
													<?php
												}
												?>
											</div>
										</div>
										</a>
									</div>
									<?php
									if ( 'yes' === $settings['crafto_portfolio_justified_group_gallery'] ) {
										$this->crafto_group_gallery();
									}
									?>
								</div>
								<?php
								break;
							case 'portfolio-parallax':
								?>
								<div <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<div <?php $this->print_render_attribute_string( 'parallax_overlay' ); ?>></div>
										<?php
										if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) || 'yes' === $settings['crafto_portfolio_read_more_button'] ) {
											?>
											<div class="portfolio-caption caption">
												<?php
												if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
													echo sprintf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) ); // phpcs:ignore
												}
												if ( 'yes' === $portfolio_show_post_title ) {
													?>
													<span class="title"><?php the_title(); ?></span>
													<?php
												}
												crafto_post_read_more_button( $this, $index ); // phpcs:ignore
												?>
											</div>
											<?php
										}
										?>
								</div>
								<?php
								break;
							case 'portfolio-contemporary':
								?>
								<li <?php $this->print_render_attribute_string( $inner_wrap_key ); ?>>
									<?php
									if ( 'yes' === $crafto_enable_animation ) {
										?>
										<div <?php $this->print_render_attribute_string( $animation_wrapper ); ?>>
										<?php
									} else {
										?>
										<div class="portfolio-box-wrap">
										<?php
									}
									if ( 'yes' === $portfolio_show_lightbox ) {
										if ( 'yes' === $portfolio_show_group_gallery ) {
											?>
											<a <?php $this->print_render_attribute_string( $group_link_key ); ?>>
											<?php
										} else {
											?>
											<a <?php $this->print_render_attribute_string( $link_key ); ?>>
											<?php
										}
									} else {
										?>
										<a <?php $this->print_render_attribute_string( $custom_link_key ); ?>>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'portfolio_box' ); ?>>
										<div class="portfolio-image">
											<?php crafto_get_portfolio_thumbnail( $settings ); // phpcs:ignore ?>
										</div>
										<?php
										if ( 'yes' === $portfolio_show_post_title || ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) ) {
											?>
											<div class="portfolio-hover">
												<div class="portfolio-caption">
													<?php
													if ( 'yes' === $portfolio_show_post_title ) {
														?>
														<div class="portfolio-caption-text">
															<?php
															if ( 'yes' === $portfolio_show_post_title ) {
																?>
																<span class="title"><?php the_title(); ?></span>
																<?php
															}
															?>
														</div>
														<?php
													}
													?>
													<div class="portfolio-icon-wrap">
														<?php
														if ( 'yes' === $portfolio_show_post_subtitle && $crafto_subtitle ) {
															printf( '<span class="subtitle">%s</span>', esc_html( $crafto_subtitle ) );
														}
														?>
														<div class="portfolio-icon">
															<i class="bi bi-arrow-right" aria-hidden="true"></i>
														</div>
													</div>
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<?php
									if ( 'yes' === $portfolio_show_lightbox ) {
										?>
										</a>
										<?php
									} else {
										?>
										</a>
										<?php
									}
									if ( 'yes' === $portfolio_show_group_gallery && 'yes' === $portfolio_show_lightbox ) {
										$this->crafto_group_gallery();
									}
									?>
									</div>
								</li>
								<?php
								break;
						}
						++$index;
						++$grid_metro_count;
						++$grid_count;
						++$i;
						$animation_val = true;

						switch ( $portfolio_style ) {
							case 'portfolio-parallax':
								$animation_val = false;
								break;
							case 'portfolio-justified-gallery':
								$animation_val = false;
								break;
						}

						if ( true === $animation_val && 'yes' === $crafto_enable_animation ) {
							if ( $col === $number_of_desktop_columns ) {
								++$row;
								$col = 0;
							}

							if ( $l_col === $number_of_laptop_columns ) {
								++$l_row;
								$l_col = 0;
							}
						}
						++$col;
						++$l_col;
					}

					crafto_end_wrapper( $this ); // phpcs:ignore
					crafto_post_pagination( $wp_query, $settings );
					wp_reset_postdata();
					?>
				</div>
				<?php
			}
		}

		/**
		 * Display portfolio title group gallery.
		 */
		public function crafto_title_group_gallery() {

			$gallery                  = [];
			$crafto_portfolio_gallery = crafto_post_meta( 'crafto_portfolio_gallery' );

			if ( $crafto_portfolio_gallery ) {
				$gallery = explode( ',', $crafto_portfolio_gallery );
			}
			if ( ! empty( $gallery ) ) {
				?>
				<div class="hide-image" data-group="<?php echo 'title_' . get_the_ID(); // phpcs:ignore ?>">
					<?php
					foreach ( $gallery as $val ) {
						$group_image_src = wp_get_attachment_url( $val );
						$group_image_alt = crafto_option_image_alt( $val );
						$image_alt       = ! empty( $group_image_alt['alt'] ) ? ' alt="' . esc_attr( $group_image_alt['alt'] ) . '"' : ' alt="' . esc_attr__( 'Image', 'crafto-addons' ) . '"';
						?>
							<a href="<?php echo esc_url( $group_image_src ); ?>" data-group="<?php echo 'title_' . get_the_ID(); // phpcs:ignore ?>">
								<img src="<?php echo esc_url( $group_image_src ); ?>" <?php echo esc_attr( $image_alt ); ?>>
							</a>
							<?php
					}
					?>
				</div>
				<?php
			}
		}

		/**
		 * Display portfolio group gallery.
		 */
		public function crafto_group_gallery() {

			$gallery                  = [];
			$crafto_portfolio_gallery = crafto_post_meta( 'crafto_portfolio_gallery' );

			if ( $crafto_portfolio_gallery ) {
				$gallery = explode( ',', $crafto_portfolio_gallery );
			}
			if ( ! empty( $gallery ) ) {
				?>
				<div class="hide-image" data-group="<?php echo get_the_ID(); // phpcs:ignore ?>">
					<?php
					foreach ( $gallery as $val ) {
						$group_image_src = wp_get_attachment_url( $val );
						$group_image_alt = crafto_option_image_alt( $val );
						$image_alt       = ! empty( $group_image_alt['alt'] ) ? ' alt="' . esc_attr( $group_image_alt['alt'] ) . '"' : ' alt="' . esc_attr__( 'Image', 'crafto-addons' ) . '"';
						?>
						<a href="<?php echo esc_url( $group_image_src ); ?>" data-group="<?php echo get_the_ID(); // phpcs:ignore ?>">
							<img src="<?php echo esc_url( $group_image_src ); ?>" <?php echo esc_attr( $image_alt ); ?>>
						</a>
						<?php
					}
					?>
				</div>
				<?php
			}
		}

	}
}
