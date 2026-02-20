<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_archive_property_template() ) {
	return;
}

/**
 *
 * Crafto widget for Archive property.
 *
 * @package Crafto
 */

// If class `Property_Archive` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Property_Archive' ) ) {
	/**
	 * Define `Property_Archive` class.
	 */
	class Property_Archive extends Widget_Base {
		/**
		 * Retrieve the list of scripts the property archive widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$property_archive_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$property_archive_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$property_archive_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$property_archive_scripts[] = 'isotope';
				}

				if ( crafto_disable_module_by_key( 'infinite-scroll' ) ) {
					$property_archive_scripts[] = 'infinite-scroll';
				}
				$property_archive_scripts[] = 'crafto-property-widget';
			}
			return $property_archive_scripts;
		}

		/**
		 * Retrieve the list of styles the property archive widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$property_archive_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$property_archive_styles[] = 'crafto-widgets-rtl';
				} else {
					$property_archive_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$property_archive_styles[] = 'crafto-property-rtl-widget';
				}
				$property_archive_styles[] = 'crafto-property-widget';
			}
			return $property_archive_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-archive-property';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Property Archive', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-welcome crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/property-address/';
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
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'property',
				'masonry',
				'grid',
				'gallery',
				'category',
				'tags',
				'term',
			];
		}

		/**
		 * Register property archive widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_property_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
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
						'{{WRAPPER}} ul.crafto-property-list' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_property_bottom_spacing',
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
				'crafto_property_content_data',
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
				'crafto_property_type_selection',
				[
					'label'   => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'properties-types',
					'options' => [
						'properties-types'         => esc_html__( 'Types', 'crafto-addons' ),
						'properties-agents'        => esc_html__( 'Agents', 'crafto-addons' ),
						'properties-listing-types' => esc_html__( 'Listing Type', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_property_types_list',
				[
					'label'       => esc_html__( 'Types', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'properties-types' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_property_type_selection' => 'properties-types',
					],
				]
			);
			$this->add_control(
				'crafto_property_agents_list',
				[
					'label'       => esc_html__( 'Agents', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => function_exists( 'crafto_get_categories_list' ) ? crafto_get_categories_list( 'properties-agents' ) : [], // phpcs:ignore
					'condition'   => [
						'crafto_property_type_selection' => 'properties-agents',
					],
				]
			);
			$this->add_control(
				'crafto_property_listing_type_list',
				[
					'label'       => esc_html__( 'Listing Type', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'options'     => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'rent'    => esc_html__( 'Rent', 'crafto-addons' ),
						'sell'    => esc_html__( 'Sell', 'crafto-addons' ),
					],
					'default'     => 'default',
					'condition'   => [
						'crafto_property_type_selection' => 'properties-listing-types',
					],
				]
			);
			$this->add_control(
				'crafto_include_exclude_property_ids',
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
				'crafto_include_property_ids',
				[
					'label'       => esc_html__( 'Include Posts', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_get_properties_array(),
					'description' => esc_html__( 'You can use this option to add certain propertys from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_property_ids' => 'include',
					],
				]
			);
			$this->add_control(
				'crafto_exclude_property_ids',
				[
					'label'       => esc_html__( 'Exclude Posts', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_get_properties_array(),
					'description' => esc_html__( 'You can use this option to remove certain propertys from the list.', 'crafto-addons' ),
					'condition'   => [
						'crafto_include_exclude_property_ids' => 'exclude',
					],
				]
			);
			$this->add_control(
				'crafto_property_archive_offset',
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
				'crafto_property_extra_option',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_show_property_thumbnail',
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
					'options'        => function_exists( 'crafto_get_thumbnail_image_sizes' ) ? crafto_get_thumbnail_image_sizes() : [],
					'style_transfer' => true,
					'condition'      => [
						'crafto_show_property_thumbnail' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_property_enable_status',
				[
					'label'        => esc_html__( 'Enable Status', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_show_property_title',
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
				'crafto_show_property_excerpt',
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
				'crafto_property_excerpt_length',
				[
					'label'     => esc_html__( 'Excerpt Length', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'min'       => 1,
					'default'   => 18,
					'condition' => [
						'crafto_show_property_excerpt' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_show_property_address',
				[
					'label'        => esc_html__( 'Enable Address', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_property_enable_bedroom',
				[
					'label'        => esc_html__( 'Enable Bedrooms', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_property_enable_bedroom_text',
				[
					'label'        => esc_html__( 'Enable Bedrooms Label', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_property_enable_bedroom' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_property_enable_bathroom',
				[
					'label'        => esc_html__( 'Enable Bathrooms', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_property_enable_bathroom_text',
				[
					'label'        => esc_html__( 'Enable Bathrooms Label', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_property_enable_bathroom' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_property_enable_price_text',
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
				'crafto_enable_button',
				[
					'label'        => esc_html__( 'Enable Button', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_view_details_text',
				[
					'label'     => esc_html__( 'Button Text', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'View Details', 'crafto-addons' ),
					'condition' => [
						'crafto_enable_button' => 'yes',
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
				'crafto_property_genaral_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_property_aligment',
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
						'{{WRAPPER}}  .property-wrapper' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_property_content_heading',
				[
					'label'     => esc_html__( 'Content Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_property_content_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .properties-details',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_property_status_style_section',
				[
					'label' => esc_html__( 'Status', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_property_status_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .property-status',
				]
			);
			$this->add_control(
				'crafto_property_status_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-status' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_property_status_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .property-status',
				]
			);
			$this->add_responsive_control(
				'crafto_property_status_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .property-status' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_property_title_style',
				[
					'label'      => esc_html__( 'Title', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_property_title' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_property_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .property-title',
				]
			);
			$this->add_control(
				'crafto_property_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_property_description_style',
				[
					'label'      => esc_html__( 'Description', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_show_property_excerpt' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tours_description_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .property-content',
				]
			);
			$this->add_control(
				'crafto_property_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_meta_content_style',
				[
					'label'      => esc_html__( 'Meta Content', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_control(
				'crafto_property_number',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_meta_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .icon-text',
				]
			);
			$this->add_control(
				'crafto_meta_number_color',
				[
					'label'     => esc_html__( 'Number Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .icon-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_property_label',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_meta_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .icon-label',
				]
			);
			$this->add_control(
				'crafto_meta_label_color',
				[
					'label'     => esc_html__( 'Label color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .icon-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_property_button_section_style',
				[
					'label' => esc_html__( 'Button', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);
			$this->start_controls_tabs( 'crafto_tabs_property_button_style' );
			$this->start_controls_tab(
				'crafto_tab_property_button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_property_button_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-button-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_property_button_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_property_button_border',
					'selector' => '{{WRAPPER}} a.elementor-button',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tab_property_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_button_text_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-button-text:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_property_property_button_background_hover_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a.elementor-button:hover',
				],
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_property_button_hover_border',
					'selector' => '{{WRAPPER}} a.elementor-button:hover',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_property_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} a.elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_price_style',
				[
					'label'      => esc_html__( 'Price', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .property-price',
				]
			);
			$this->add_control(
				'crafto_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-price' => 'color: {{VALUE}};',
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
		 * Render property archive widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			global $crafto_property_unique_id;
			$settings = $this->get_settings_for_display();
			// Check if property id and class.
			$crafto_property_unique_id = ! empty( $crafto_property_unique_id ) ? $crafto_property_unique_id : 1;
			$crafto_property_id        = 'crafto-property';
			$crafto_property_id       .= '-' . $crafto_property_unique_id;
			++$crafto_property_unique_id;

			$crafto_property_archive_offset    = ( isset( $settings['crafto_property_archive_offset'] ) && $settings['crafto_property_archive_offset'] ) ? $settings['crafto_property_archive_offset'] : '';
			$property_type_selection           = ( isset( $settings['crafto_property_type_selection'] ) && $settings['crafto_property_type_selection'] ) ? $settings['crafto_property_type_selection'] : 'properties-types';
			$crafto_property_types_list        = $this->get_settings( 'crafto_property_types_list' );
			$crafto_property_agents_list       = $this->get_settings( 'crafto_property_agents_list' );
			$crafto_property_listing_type_list = $this->get_settings( 'crafto_property_listing_type_list' );
			$crafto_show_property_title        = ( isset( $settings['crafto_show_property_title'] ) && $settings['crafto_show_property_title'] ) ? $settings['crafto_show_property_title'] : '';
			$crafto_show_property_thumbnail    = ( isset( $settings['crafto_show_property_thumbnail'] ) && $settings['crafto_show_property_thumbnail'] ) ? $settings['crafto_show_property_thumbnail'] : '';
			$crafto_thumbnail                  = ( isset( $settings['crafto_thumbnail'] ) && $settings['crafto_thumbnail'] ) ? $settings['crafto_thumbnail'] : 'full';
			$crafto_show_property_excerpt      = ( isset( $settings['crafto_show_property_excerpt'] ) && $settings['crafto_show_property_excerpt'] ) ? $settings['crafto_show_property_excerpt'] : '';
			$crafto_property_excerpt_length    = ( isset( $settings['crafto_property_excerpt_length'] ) && $settings['crafto_property_excerpt_length'] ) ? $settings['crafto_property_excerpt_length'] : '';
			$crafto_show_property_address      = ( isset( $settings['crafto_show_property_address'] ) && $settings['crafto_show_property_address'] ) ? $settings['crafto_show_property_address'] : '';
			$crafto_enable_button              = ( isset( $settings['crafto_enable_button'] ) && $settings['crafto_enable_button'] ) ? $settings['crafto_enable_button'] : '';

			$crafto_enable_no_of_bathroom = ( isset( $settings['crafto_property_enable_bathroom'] ) && $settings['crafto_property_enable_bathroom'] ) ? $settings['crafto_property_enable_bathroom'] : '';
			$crafto_enable_bathroom_label = ( isset( $settings['crafto_property_enable_bathroom_text'] ) && $settings['crafto_property_enable_bathroom_text'] ) ? $settings['crafto_property_enable_bathroom_text'] : '';

			$crafto_enable_no_of_bedroom = ( isset( $settings['crafto_property_enable_bedroom'] ) && $settings['crafto_property_enable_bedroom'] ) ? $settings['crafto_property_enable_bedroom'] : '';
			$crafto_enable_bedroom_label = ( isset( $settings['crafto_property_enable_bedroom_text'] ) && $settings['crafto_property_enable_bedroom_text'] ) ? $settings['crafto_property_enable_bedroom_text'] : '';

			$crafto_property_enable_price          = ( isset( $settings['crafto_property_enable_price_text'] ) && $settings['crafto_property_enable_price_text'] ) ? $settings['crafto_property_enable_price_text'] : '';
			$crafto_property_enable_status         = ( isset( $settings['crafto_property_enable_status'] ) && $settings['crafto_property_enable_status'] ) ? $settings['crafto_property_enable_status'] : '';
			$crafto_property_content_box_alignment = ( isset( $settings['crafto_property_content_box_alignment'] ) && $settings['crafto_property_content_box_alignment'] ) ? $settings['crafto_property_content_box_alignment'] : '';
			$crafto_include_exclude_property_ids   = $this->get_settings( 'crafto_include_exclude_property_ids' );
			$crafto_include_property_ids           = $this->get_settings( 'crafto_include_property_ids' );
			$crafto_exclude_property_ids           = $this->get_settings( 'crafto_exclude_property_ids' );
			$crafto_orderby                        = ( isset( $settings['crafto_orderby'] ) && $settings['crafto_orderby'] ) ? $settings['crafto_orderby'] : '';
			$crafto_order                          = ( isset( $settings['crafto_order'] ) && $settings['crafto_order'] ) ? $settings['crafto_order'] : '';

			$property_types_list_to_display_ids  = ( ! empty( $crafto_property_types_list ) ) ? $crafto_property_types_list : array();
			$property_agents_list_to_display_ids = ( ! empty( $crafto_property_agents_list ) ) ? $crafto_property_agents_list : array();

			$crafto_enable_masonry = ( isset( $settings['crafto_enable_masonry'] ) && $settings['crafto_enable_masonry'] ) ? $settings['crafto_enable_masonry'] : '';

			// pagination.
			$crafto_pagination = ( isset( $settings['crafto_pagination'] ) && $settings['crafto_pagination'] ) ? $settings['crafto_pagination'] : '';

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

			if ( Plugin::$instance->editor->is_edit_mode() || Plugin::$instance->preview->is_preview_mode() ) {
				$query_args['post_type'] = 'properties';
			} else {
				if ( is_singular( 'themebuilder' ) ) {
					$query_args['post_type'] = 'properties';
				} else {
					global $wp_query;
					$query_args = $wp_query->query_vars;
				}
			}

			$query_args['post_status'] = 'publish';
			$query_args['paged']       = $paged;

			if ( ! empty( $crafto_property_archive_offset ) ) {
				$query_args['offset'] = $crafto_property_archive_offset;
			}

			if ( 'include' === $crafto_include_exclude_property_ids ) {
				if ( ! empty( $crafto_include_property_ids ) ) {
					$query_args['post__in'] = $crafto_include_property_ids;
				}
			} elseif ( 'exclude' === $crafto_include_exclude_property_ids ) {
				if ( ! empty( $crafto_exclude_property_ids ) ) {
					$query_args['post__not_in'] = $crafto_exclude_property_ids;
				}
			}

			if ( ! empty( $crafto_orderby ) ) {
				$query_args['orderby'] = $crafto_orderby;
			}

			if ( ! empty( $crafto_order ) ) {
				$query_args['order'] = $crafto_order;
			}
			if ( 'properties-listing-types' === $property_type_selection ) {
				if ( ! empty( $crafto_property_listing_type_list ) && 'default' !== $crafto_property_listing_type_list ) {
					$query_args['meta_query'] = [ // phpcs:ignore
						[
							'key'     => 'crafto_global_meta',
							'value'   => sprintf( ':"%s";', $crafto_property_listing_type_list ),
							'compare' => 'LIKE',
						],
					];
				}
			}
			if ( 'properties-agents' === $property_type_selection ) {
				if ( ! empty( $crafto_property_agents_list ) ) {
					$query_args['tax_query'] = [ // phpcs:ignore
						[
							'taxonomy' => 'properties-agents',
							'field'    => 'slug',
							'terms'    => $property_agents_list_to_display_ids,
						],
					];
				}
			} elseif ( ! empty( $crafto_property_types_list ) ) {
					$query_args['tax_query'] = [ // phpcs:ignore
						[
							'taxonomy' => 'properties-types',
							'field'    => 'slug',
							'terms'    => $property_types_list_to_display_ids,
						],
					];
			}

			$the_query = new \WP_Query( $query_args );

			$datasettings = array(
				'pagination_type' => $crafto_pagination,
			);

			$this->add_render_attribute(
				'wrapper',
				[
					'class'                  => [
						'grid',
						'crafto-property-list',
						'yes' === $settings['crafto_section_enable_grid_preloader'] ? 'grid-loading' : '',
						$crafto_column_class_list,
						$crafto_property_id,
					],
					'data-uniqueid'          => $crafto_property_id,
					'data-property-settings' => wp_json_encode( $datasettings ),
				]
			);

			if ( 'yes' === $crafto_enable_masonry ) {
				$this->add_render_attribute(
					'wrapper',
					[
						'class' => 'grid-masonry',
					]
				);
			}

			$index                       = 0;
			$grid_count                  = 1;
			$crafto_alignment_main_class = '';

			switch ( $crafto_property_content_box_alignment ) {
				case 'center':
					$crafto_alignment_main_class = 'text-center';
					break;
				case 'right':
					$crafto_alignment_main_class = 'text-end';
					break;
			}

			if ( 0 === $index % $crafto_column_ratio ) {
				$grid_count = 1;
			}
			?>
			<div class="property-wrapper">
				<ul <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<li class="grid-sizer p-0 m-0"></li>
					<?php
					if ( $the_query->have_posts() ) {
						$index = 0;
						while ( $the_query->have_posts() ) {
							$the_query->the_post();

							$crafto_property_status = crafto_post_meta( 'crafto_property_status' );
							$crafto_property_price  = crafto_post_meta( 'crafto_property_price' );

							$crafto_property_address         = crafto_post_meta( 'crafto_property_address' );
							$crafto_property_no_of_bedrooms  = crafto_post_meta( 'crafto_property_no_of_bedrooms' );
							$crafto_property_no_of_bathrooms = crafto_post_meta( 'crafto_property_no_of_bathrooms' );
							$crafto_property_size            = crafto_post_meta( 'crafto_property_size' );

							$crafto_property_address_arry = array();

							if ( ! empty( $crafto_property_address ) ) {
								$crafto_property_address_arry[] = $crafto_property_address;
							}

							$crafto_property_address_str = ! empty( $crafto_property_address_arry ) ? implode( ' ', $crafto_property_address_arry ) : '';

							$button_key         = 'button_' . $index;
							$button_link_key    = 'button_link_' . $index;
							$button_content_key = 'button_content_wrapper_' . $index;
							$button_text_key    = 'button_text_' . $index;

							$this->add_render_attribute(
								$button_key,
								'class',
								'elementor-button-wrapper',
							);

							$this->add_render_attribute(
								$button_link_key,
								[
									'href'  => get_permalink(),
									'class' => [
										'elementor-button-link',
										'elementor-button',
										'property-post-button',
									],
									'role'  => 'button',
								]
							);

							$this->add_render_attribute(
								[
									$button_content_key => [
										'class' => 'elementor-button-content-wrapper',
									],
									$button_text_key    => [
										'class' => 'elementor-button-text',
									],
								]
							);

							$this->add_render_attribute(
								'content-wrap',
								[
									'class' => [
										'property-content-wrapper',
										$crafto_alignment_main_class,
									],
								]
							);
							?>
							<li class="grid-item grid-gutter">
								<div class="property-details-content-wrap">
									<div class="property-images">
										<?php
										if ( 'yes' === $crafto_property_enable_status && 'yes' === $crafto_show_property_thumbnail ) {
											?>
											<div class="property-status property-status-<?php echo esc_html( $crafto_property_status ); ?>">
												<?php echo esc_html( $crafto_property_status ); ?>
											</div>
											<?php
										}

										if ( 'yes' === $crafto_show_property_thumbnail && has_post_thumbnail() ) {
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
											<a href="<?php the_permalink(); ?>" <?php $this->print_render_attribute_string( $image_key ); ?>>
												<?php
												$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
												$image_alt    = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
												if ( '' === $image_alt ) {
													$image_alt = get_the_title( $thumbnail_id );
												}
												echo get_the_post_thumbnail( get_the_ID(), $crafto_thumbnail, array( 'alt' => $image_alt ) );
												?>
											</a>
											<?php
										}
										?>
									</div>
									<div class="properties-details">
										<div class="content-wrapper">
											<?php
											if ( 'yes' === $crafto_show_property_title ) {
												?>
												<a href="<?php the_permalink(); ?>" class="property-title"><?php the_title(); ?></a>
												<?php
											}

											if ( 'yes' === $crafto_show_property_excerpt ) {
												$show_excerpt_grid = ! empty( $crafto_property_excerpt_length ) ? crafto_get_the_excerpt_theme( $crafto_property_excerpt_length ) : crafto_get_the_excerpt_theme( 15 );
												if ( ! empty( $show_excerpt_grid ) ) {
													?>
													<p class="property-content">
														<?php echo sprintf( '%s', wp_kses_post( $show_excerpt_grid ) ); // phpcs:ignore ?>
													</p>
													<?php
												}
											}

											if ( 'yes' === $crafto_show_property_address ) {
												?>
												<p class="property-content">
													<?php echo esc_html( $crafto_property_address_str ); ?>
												</p>
												<?php
											}
											?>
											<div class="row">
												<?php
												if ( 'yes' === $crafto_enable_no_of_bedroom && ! empty( $crafto_property_no_of_bedrooms ) ) {
													/**
													 * Filter to modify bedroom icon
													 *
													 * @since 1.0
													 */
													$crafto_property_bedroom_icon = apply_filters( 'crafto_property_bedroom_icon', CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/bedroom-small-icon.svg' );

													/**
													 * Filter to modify bedroom label
													 *
													 * @since 1.0
													 */
													$crafto_property_bedroom_label = apply_filters( 'crafto_property_bedroom_label', esc_html__( 'Bedrooms', 'crafto-addons' ) );
													?>
													<div class="col property-icon-box">
														<div class="icon-text">
															<img src="<?php echo esc_url( $crafto_property_bedroom_icon ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'Bedroom', 'crafto-addons' ); ?>">
															<span><?php echo esc_html( $crafto_property_no_of_bedrooms ); ?></span>					
														</div>
														<?php
														if ( 'yes' === $crafto_enable_bedroom_label ) {
															?>
															<span class="icon-label"><?php echo esc_html( $crafto_property_bedroom_label ); ?></span>
															<?php
														}
														?>
													</div>
													<?php
												}

												if ( 'yes' === $crafto_enable_no_of_bathroom && ! empty( $crafto_property_no_of_bathrooms ) ) {

													/**
													 * Filter to modify bathroom icon
													 *
													 * @since 1.0
													 */
													$crafto_property_bathroom_icon = apply_filters( 'crafto_property_bathroom_icon', CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/bathroom-small-icon.svg' );

													/**
													 * Filter to modify bathroom label
													 *
													 * @since 1.0
													 */
													$crafto_property_bathroom_label = apply_filters( 'crafto_property_bathroom_label', esc_html__( 'Bathroom', 'crafto-addons' ) );
													?>
													<div class="col property-icon-box">
														<div class="icon-text">
															<img src="<?php echo esc_url( $crafto_property_bathroom_icon ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'Bathroom', 'crafto-addons' ); ?>">
															<span><?php echo sprintf( '%s', $crafto_property_no_of_bathrooms ); // phpcs:ignore ?></span>
														</div>
														<?php
														if ( 'yes' === $crafto_enable_bathroom_label ) {
															?>
															<span class="icon-label"><?php echo esc_html( $crafto_property_bathroom_label ); ?></span>
															<?php
														}
														?>
													</div>
													<?php
												}

												if ( ! empty( $crafto_property_size ) ) {

													/**
													 * Filter to modify property size icon
													 *
													 * @since 1.0
													 */
													$crafto_property_size_icon = apply_filters( 'crafto_property_size_icon', CRAFTO_ADDONS_ROOT_URI . '/includes/assets/images/size-small-icon.svg' );

													/**
													 * Filter to modify property size label
													 *
													 * @since 1.0
													 */
													$crafto_property_size_label = apply_filters( 'crafto_property_size_label', esc_html__( 'Living area', 'crafto-addons' ) );
													?>
													<div class="col property-icon-box">
														<div class="icon-text">
															<img src="<?php echo esc_url( $crafto_property_size_icon ); ?>" class="attachment-full size-full" alt="<?php echo esc_attr__( 'Living area', 'crafto-addons' ); ?>">
															<span><?php echo sprintf( '%s', $crafto_property_size ); // phpcs:ignore ?></span>
														</div>
														<span class="icon-label"><?php echo esc_html( $crafto_property_size_label ); ?></span>
													</div>
													<?php
												}
												?>
											</div>
										</div>
										<?php
										if ( ( 'yes' === $crafto_enable_button ) || ( 'yes' === $crafto_property_enable_price && ! empty( $crafto_property_price ) ) ) {
											?>
											<div class="property-action-wrap">
												<?php
												if ( 'yes' === $crafto_enable_button ) {
													crafto_property_view_details_button( $this, $index ); // phpcs:ignore
												}
												if ( 'yes' === $crafto_property_enable_price && ! empty( $crafto_property_price ) ) {
													?>
													<div class="property-price">
														<?php echo esc_html( $crafto_property_price ); ?>
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
					}
					get_next_posts_page_link( $the_query->max_num_pages );
					?>
				</ul>
			</div>
			<?php
			wp_reset_postdata();
			crafto_post_pagination( $the_query, $settings );
		}

		/**
		 * Return property categories array.
		 */
		public static function crafto_get_property_types() {

			$categories_array = [];

			$categories = get_terms(
				[
					'taxonomy'   => 'properties-types',
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
				]
			);

			if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					$categories_array[ $category->slug ] = $category->name;
				}
			}
			return $categories_array;
		}

		/**
		 * Return property agents array.
		 */
		public static function crafto_get_property_agents() {

			$agents_array = [];

			$agents = get_terms(
				[
					'taxonomy'   => 'properties-agents',
					'hide_empty' => false,
					'orderby'    => 'name',
					'order'      => 'ASC',
				]
			);

			if ( ! is_wp_error( $agents ) && ! empty( $agents ) ) {
				foreach ( $agents as $tag ) {
					$agents_array[ $tag->slug ] = $tag->name;
				}
			}
			return $agents_array;
		}

		/**
		 * Return properties array
		 */
		public function crafto_get_properties_array() {
			global $wpdb;
			// phpcs:ignore
			$results = $wpdb->get_results( "
				SELECT ID, post_title
				FROM {$wpdb->posts}
				WHERE post_type = 'properties'
				AND post_status = 'publish'
				ORDER BY post_title ASC
			", OBJECT_K ); // phpcs:ignore

			$post_array = [];

			foreach ( $results as $id => $row ) {
				$post_array[ $id ] = $row->post_title ? $row->post_title : esc_html__( '(no title)', 'crafto-addons' );
			}

			return $post_array;
		}
	}
}
