<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for search form.
 *
 * @package Crafto
 */

// If class `Search_Form` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Search_Form' ) ) {
	/**
	 * Define `Search_Form` class.
	 */
	class Search_Form extends Widget_Base {
		/**
		 * Retrieve the list of scripts the search form widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$search_form_scripts       = [];
			$crafto_optimize_bootstrap = get_theme_mod( 'crafto_optimize_bootstrap', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$search_form_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$search_form_scripts[] = 'magnific-popup';
				}

				if ( '1' === $crafto_optimize_bootstrap ) {
					$search_form_scripts[] = 'bootstrap-tab';
				}
				$search_form_scripts[] = 'crafto-search-form-widget';
			}
			return $search_form_scripts;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-search-form';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Search Form', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-search crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/search-form/';
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
				'crafto-header',
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
				'ajax search',
				'search bar',
			];
		}

		/**
		 * Register the widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_search_form_section_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_search_form_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'simple',
					'options'            => [
						'popup'  => esc_html__( 'Popup', 'crafto-addons' ),
						'simple' => esc_html__( 'Simple', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'crafto_search_form_search_by',
				[
					'label'              => esc_html__( 'Search By', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT2,
					'multiple'           => true,
					'label_block'        => true,
					'options'            => $this->crafto_get_post_type_array(),
					'frontend_available' => true,
					'default'            => [
						'post',
						'page',
					],
				]
			);

			$this->add_control(
				'custom_search_form_search_type',
				[
					'label'       => esc_html__( 'Custom post type', 'crafto-addons' ),
					'description' => esc_html__( 'Enter the custom post type slug', 'crafto-addons' ),
					'placeholder' => 'my-post-type-slug',
					'type'        => Controls_Manager::TEXT,
					'condition'   => [
						'crafto_search_form_search_by' => 'custom',
					],
				]
			);

			$this->add_control(
				'crafto_item_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'icon-simple-line-magnifier',
						'library' => 'simpleline',
					],
					'condition'        => [
						'crafto_search_form_style' => 'popup',
					],
					'separator'        => 'before',
				]
			);
			$this->add_control(
				'crafto_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'default'      => 'default',
					'condition'    => [
						'crafto_search_form_style' => 'popup',
					],
					'prefix_class' => 'elementor-view-',
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
					'condition'    => [
						'crafto_view!'             => 'default',
						'crafto_search_form_style' => 'popup',
					],
					'prefix_class' => 'elementor-shape-',
				]
			);

			$this->add_control(
				'crafto_search_icon_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_search_icon_align',
				[
					'label'     => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'right',
					'toggle'    => false,
					'options'   => [
						'left'  => [
							'title' => esc_html__( 'Start', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'right' => [
							'title' => esc_html__( 'End', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'condition' => [
						'crafto_search_form_style' => [
							'popup',
						],
						'crafto_search_icon_text!' => '',
					],
					'separator' => 'after',
				]
			);

			$this->add_control(
				'crafto_search_form_label',
				[
					'label'       => esc_html__( 'Popup Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'What are you looking for?', 'crafto-addons' ),
					'condition'   => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_control(
				'crafto_search_form_placeholder',
				[
					'label'       => esc_html__( 'Placeholder', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Enter your keywords...', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_search_form_button_icon',
				[
					'label'            => esc_html__( 'Button Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'default'          => [
						'value'   => 'icon-feather-search',
						'library' => 'feather',
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->add_control(
				'crafto_live_search_form_fullscreen',
				[
					'label'        => esc_html__( 'Full Screen Popup', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_search_form_style' => 'popup',
					],
				]
			);
			$this->add_control(
				'crafto_live_search_form',
				[
					'label'        => esc_html__( 'Enable Live Search', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_live_search_form_popular_tags',
				[
					'label'        => esc_html__( 'Popular Tags', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_search_form_style' => 'popup',
					],
				]
			);
			$this->add_control(
				'crafto_disable_label_in_tablet',
				[
					'label'        => esc_html__( 'Disable Label in Tablet', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_live_search_post_length',
				[
					'label'     => esc_html__( 'Title Length', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'min'       => 1,
					'condition' => [
						'crafto_live_search_form' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_live_search_form_tags_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'label_block' => false,
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Popular:', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'crafto_live_search_form_popular_tags' => 'yes',
						'crafto_search_form_style' => 'popup',
					],
				]
			);

			$this->add_control(
				'crafto_live_search_form_tags',
				[
					'label'       => esc_html__( 'Tags', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::REPEATER,
					'default'     => [
						[
							'title' => esc_html__( 'Chairs', 'crafto-addons' ),
						],
						[
							'title' => esc_html__( 'Sofas', 'crafto-addons' ),
						],
						[
							'title' => esc_html__( 'Tables', 'crafto-addons' ),
						],
					],
					'fields'      => [
						[
							'name'        => 'title',
							'label'       => esc_html__( 'Title', 'crafto-addons' ),
							'label_block' => false,
							'type'        => Controls_Manager::TEXT,
							'placeholder' => esc_html__( "Tag's title", 'crafto-addons' ),
							'default'     => '',
						],
					],
					'title_field' => '{{{ title }}}',
					'condition'   => [
						'crafto_live_search_form_popular_tags' => 'yes',
						'crafto_search_form_style' => 'popup',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_icon_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_size',
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
						'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_max_width',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .elementor-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view!' => 'default',
					],
				]
			);
			$this->start_controls_tabs( 'icon_colors' );

			$this->start_controls_tab(
				'crafto_search_form_icon_colors_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-framed .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg, {{WRAPPER}}.elementor-view-framed .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_form_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => 'stacked',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_form_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_icon_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view' => [
							'framed',
						],
					],
				]
			);
			$this->add_control(
				'crafto_search_form_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ '%', 'px', 'custom' ],
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
					'condition'  => [
						'crafto_view!' => 'default',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_search_form_icon_colors_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_hover_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_form_hover_primary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => 'stacked',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_form_icon_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_icon_text_heading',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_search_icon_text!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_search_form_icon_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .search-form-wrapper .icon-text, {{WRAPPER}} .simple-search-form .icon-text',
				]
			);
			$this->start_controls_tabs(
				'crafto_search_form_icon_text_tabs',
			);
				$this->start_controls_tab(
					'crafto_search_form_icon_text_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_search_form_style' => [
								'popup',
							],
						],
					],
				);
				$this->add_responsive_control(
					'crafto_search_form_icon_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .search-form-wrapper .icon-text, {{WRAPPER}} .simple-search-form .icon-text' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
					$this->start_controls_tab(
						'crafto_search_form_icon_text_hover_tab',
						[
							'label'     => esc_html__( 'Hover', 'crafto-addons' ),
							'condition' => [
								'crafto_search_form_style' => [
									'popup',
								],
							],
						],
					);
					$this->add_responsive_control(
						'crafto_search_form_icon_text_hvr_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-form-icon:hover .icon-text' => 'color: {{VALUE}};',
							],
							'condition' => [
								'crafto_search_form_style' => [
									'popup',
								],
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_overlay_section',
				[
					'label'     => esc_html__( 'Popup Background', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_overlay_background',
					'selector'  => '{{WRAPPER}} .search-form',
					'condition' => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_control(
				'crafto_search_form_overlay_color',
				[
					'label'     => esc_html__( 'Overlay Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .search-form-wrapper .form-wrapper' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_label_style',
				[
					'label'      => esc_html__( 'Popup Heading', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_label_aligment',
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
						'{{WRAPPER}} .form-wrapper .search-form .search-label' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_search_form_label_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector'  => '{{WRAPPER}} .search-form-box .search-label',
					'condition' => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_control(
				'crafto_search_form_label_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .search-form-box .search-label' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_label_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .search-form-box .search-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_input_style',
				[
					'label'      => esc_html__( 'Input', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_search_form_input_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .search-form-box .search-input, {{WRAPPER}} .search-form-simple-box .search-input',
				]
			);
			$this->add_control(
				'crafto_search_form_input_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .search-form-box .search-input'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .search-form-simple-box .search-input' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_form_input_placeholder_color',
				[
					'label'     => esc_html__( 'Placeholder Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .search-form-box .search-input::-webkit-input-placeholder, {{WRAPPER}} .search-form-simple-box .search-input::-webkit-input-placeholder' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_form_input_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .search-form-box .search-input'        => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .search-form-simple-box .search-input' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_search_form_input_border',
					'selector' => '{{WRAPPER}} .search-form-box .search-input, {{WRAPPER}} .search-form-simple-box .search-input, {{WRAPPER}} .simple-search-form .search-form-simple-box .search-dropdown .simple-search-results:has(ul), {{WRAPPER}} .simple-search-form .search-form-simple-box .search-loader, {{WRAPPER}} .simple-search-form .search-form-simple-box .search-dropdown p',
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_input_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .search-form-box .search-input'        => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .search-form-simple-box .search-input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .simple-search-form .search-form-simple-box .search-dropdown .simple-search-results:has(ul), {{WRAPPER}} .simple-search-form .search-form-simple-box .search-loader, {{WRAPPER}} .simple-search-form .search-form-simple-box .search-dropdown p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_input_padding',
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
						'{{WRAPPER}} .search-form-box .search-input'        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .search-form-simple-box .search-input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_search_form_input_box_shadow',
					'selector' => '{{WRAPPER}} .search-form-box .search-input, {{WRAPPER}} .search-form-simple-box .search-input',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_button_section',
				[
					'label'      => esc_html__( 'Search Button', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_button_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 40,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .search-form-box .search-button, {{WRAPPER}} .search-form-simple-box .search-button > i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .search-form-box .search-button svg, {{WRAPPER}} .search-form-simple-box .search-button > svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_search_form_button_icon_tabs' );
				$this->start_controls_tab(
					'crafto_search_form_button_icon_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_search_form_button_icon_primary_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .search-form-box .search-button, {{WRAPPER}} .search-form-simple-box .search-button'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
							'{{WRAPPER}} .search-form-box .search-button svg, {{WRAPPER}} .search-form-simple-box .search-button svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_search_form_button_background_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .search-form-box .search-button, {{WRAPPER}} .search-form-simple-box .search-button' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_search_form_button_icon_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);

				$this->add_responsive_control(
					'crafto_search_form_button_icon_hover_primary_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .search-form-box .search-button:hover, {{WRAPPER}} .search-form-simple-box .search-button:hover'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
							'{{WRAPPER}} .search-form-box .search-button:hover svg, {{WRAPPER}} .search-form-simple-box .search-button:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_search_form_button_hover_background_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .search-form-box .search-button:hover, {{WRAPPER}} .search-form-simple-box .search-button:hover' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_search_form_button_icon_padding',
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
						'{{WRAPPER}} .search-form-box .search-button, {{WRAPPER}} .search-form-simple-box .search-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_search_form_close_btn_style',
				[
					'label'      => esc_html__( 'Close Button', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_search_form_style' => [
							'popup',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_search_form_close_btn_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .search-form-wrapper .search-close',
				]
			);
			$this->start_controls_tabs(
				'crafto_search_form_close_btn_tabs',
			);
				$this->start_controls_tab(
					'crafto_search_form_close_btn_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
					$this->add_control(
						'crafto_search_form_close_btn_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-close' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_responsive_control(
						'crafto_search_form_close_btn_bg_color',
						[
							'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-close' => 'background-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_search_form_close_btn_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					],
				);
					$this->add_control(
						'crafto_search_form_close_btn_hvr_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-close:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_responsive_control(
						'crafto_search_form_close_btn_hvr_bg_color',
						[
							'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-close:hover' => 'background-color: {{VALUE}};',
							],
						]
					);
					$this->add_control(
						'crafto_search_form_close_btn_hover_transition',
						[
							'label'       => esc_html__( 'Transition Duration', 'crafto-addons' ),
							'type'        => Controls_Manager::SLIDER,
							'size_units'  => [
								's',
								'ms',
								'custom',
							],
							'range'       => [
								's' => [
									'max'  => 3,
									'step' => 0.1,
								],
							],
							'default'     => [
								'unit' => 's',
							],
							'render_type' => 'ui',
							'selectors'   => [
								'{{WRAPPER}} .search-form-wrapper .search-close' => 'transition-duration: {{SIZE}}{{UNIT}}',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_popular_tags_style',
				[
					'label'      => esc_html__( 'Popular Tags', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_search_form_style' => [
							'popup',
						],
						'crafto_live_search_form_popular_tags' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_search_form_popular_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .search-form-wrapper .search-form-tag-wrap .tags-label',
				]
			);
			$this->add_control(
				'crafto_search_form_popular_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .search-form-wrapper .search-form-tag-wrap .tags-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_form_popular_tags_title',
				[
					'label'     => esc_html__( 'Tags', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_search_form_popular_tags_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .search-form-wrapper .search-form-tag-wrap .search-form-tags-items a',
				]
			);
			$this->start_controls_tabs( 'search_form_popular_tags_tabs' );
				$this->start_controls_tab(
					'crafto_search_form_popular_tags_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_search_form_popular_tags_normal_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-form-tag-wrap .search-form-tags-items a' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_search_form_popular_tags_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_search_form_popular_tags_color_hover',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-form-tag-wrap .search-form-tags-items a:hover' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_search_form_ajax_search_style',
				[
					'label'      => esc_html__( 'Tab Items', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_search_form_style' => [
							'popup',
						],
						'crafto_live_search_form'  => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_search_form_ajax_search_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs .nav-item .nav-link',
				]
			);
			$this->start_controls_tabs( 'crafto_search_form_ajax_search_tabs' );
				$this->start_controls_tab(
					'crafto_search_form_ajax_search_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_search_form_ajax_search_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs .nav-item .nav-link' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_search_form_ajax_search_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_search_form_ajax_search_color_hover',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs .nav-item .nav-link:hover' => 'color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_search_form_ajax_search_active',
					[
						'label' => esc_html__( 'Active', 'crafto-addons' ),
					]
				);
					$this->add_control(
						'crafto_search_form_ajax_search_color_active',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs .nav-item .nav-link.active' => 'color: {{VALUE}};',
								'{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs li .nav-link::before' => 'background-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_search_form_ajax_search_border_padding',
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
						'{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_search_form_ajax_tab_content_style',
				[
					'label'      => esc_html__( 'Tab Content', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_search_form_style' => [
							'popup',
						],
						'crafto_live_search_form'  => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_search_form_ajax_search_border',
				[
					'label'      => esc_html__( 'Separator Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 5,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
					],
					'separator'  => 'before',
				]
			);

			$this->add_responsive_control(
				'crafto_search_form_ajax_search_border_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .search-form-wrapper .search-results-container .nav-tabs' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_search_tag_content_button_title',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_search_tag_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .view-more-btn-container a.view-more-btn',
				]
			);
			$this->start_controls_tabs( 'crafto_search_tag_button_tabs' );
				$this->start_controls_tab(
					'crafto_search_tag_button_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'crafto_search_tag_button_bcakground',
							'exclude'        => [
								'image',
								'position',
								'attachment',
								'attachment_alert',
								'repeat',
								'size',
							],
							'selector'       => '{{WRAPPER}} .view-more-btn-container a.view-more-btn',
							'fields_options' => [
								'background' => [
									'label' => esc_html__( 'Background Color', 'crafto-addons' ),
								],
							],
						]
					);
					$this->add_control(
						'crafto_search_tag_button_color',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .view-more-btn-container a.view-more-btn' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_responsive_control(
						'crafto_search_tag_button_border_color',
						[
							'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .view-more-btn-container a.view-more-btn' => 'border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_search_tag_button_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
					$this->add_group_control(
						Group_Control_Background::get_type(),
						[
							'name'           => 'crafto_search_tag_button_bcakground_hover',
							'exclude'        => [
								'image',
								'position',
								'attachment',
								'attachment_alert',
								'repeat',
								'size',
							],
							'selector'       => '{{WRAPPER}} .view-more-btn-container a.view-more-btn:hover',
							'fields_options' => [
								'background' => [
									'label' => esc_html__( 'Background Color', 'crafto-addons' ),
								],
							],
						]
					);
					$this->add_control(
						'crafto_search_tag_button_color_hover',
						[
							'label'     => esc_html__( 'Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .view-more-btn-container a.view-more-btn:hover' => 'color: {{VALUE}};',
							],
						]
					);
					$this->add_responsive_control(
						'crafto_search_tag_button_border_hover_color',
						[
							'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
							'type'      => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .view-more-btn-container a.view-more-btn:hover' => 'border-color: {{VALUE}};',
							],
						]
					);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'crafto_search_tag_button_border',
					'selector'       => '{{WRAPPER}} .view-more-btn-container a.view-more-btn',
					'fields_options' => [
						'border' => [
							'separator' => 'before',
						],
					],
					'exclude'        => [
						'color',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_search_tag_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .view-more-btn-container a.view-more-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_search_tag_button_padding',
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
						'{{WRAPPER}} .view-more-btn-container a.view-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render search form widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                       = $this->get_settings_for_display();
			$input_unique_id                = wp_unique_id( 'search-form-input' );
			$form_unique_id                 = wp_unique_id( 'search-form-' );
			$crafto_search_form_style       = ( isset( $settings['crafto_search_form_style'] ) && $settings['crafto_search_form_style'] ) ? $settings['crafto_search_form_style'] : '';
			$search_form_placeholder        = ( isset( $settings['crafto_search_form_placeholder'] ) && $settings['crafto_search_form_placeholder'] ) ? $settings['crafto_search_form_placeholder'] : '';
			$crafto_search_form_label       = ( isset( $settings['crafto_search_form_label'] ) && $settings['crafto_search_form_label'] ) ? $settings['crafto_search_form_label'] : '';
			$crafto_search_icon_text        = ( isset( $settings['crafto_search_icon_text'] ) && $settings['crafto_search_icon_text'] ) ? $settings['crafto_search_icon_text'] : '';
			$crafto_disable_label_in_tablet = ( isset( $settings['crafto_disable_label_in_tablet'] ) && $settings['crafto_disable_label_in_tablet'] ) ? $settings['crafto_disable_label_in_tablet'] : '';
			$icon_is_new                    = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_migrated                  = isset( $settings['__fa4_migrated']['crafto_search_form_button_icon'] );
			$migrated                       = isset( $settings['__fa4_migrated']['crafto_item_icon'] );
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon                           = '';
			$disable_label                  = 'yes' === $crafto_disable_label_in_tablet ? 'disable-label' : '';
			$search_type                    = $settings['crafto_search_form_search_by'];
			$crafto_live_search_post_length = ( isset( $settings['crafto_live_search_post_length'] ) && $settings['crafto_live_search_post_length'] ) ? $settings['crafto_live_search_post_length'] : '';

			if ( is_array( $search_type ) && in_array( 'custom', $search_type, true ) ) {
				if ( empty( $settings['custom_search_form_search_type'] ) ) {
					$search_type = array_diff( $search_type, [ 'custom' ] );
				} else {
					$key                 = array_search( 'custom', $search_type, true );
					$search_type[ $key ] = $settings['custom_search_form_search_type'];
				}
			}

			if ( ! is_array( $search_type ) && 'custom' === $search_type ) {
				if ( empty( $settings['custom_search_form_search_type'] ) ) {
					$search_type = '';
				} else {
					$search_type = $settings['custom_search_form_search_type'];
				}
			}

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_item_icon'], [ 'aria-hidden' => 'true' ] );
				$icon = ob_get_clean();
			} elseif ( isset( $settings['crafto_item_icon']['value'] ) && ! empty( $settings['crafto_item_icon']['value'] ) ) {
				$icon = '<i class="' . esc_attr( $settings['crafto_item_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			$this->add_render_attribute(
				'wrapper',
				[
					'class' => [
						'simple-search-form',
						$disable_label,
					],
				],
			);

			$fullscreen_class = '';
			if ( 'yes' === $settings['crafto_live_search_form_fullscreen'] ) {
				$fullscreen_class = 'fullscreen';
			}

			$live_search_class = '';
			if ( 'yes' === $settings['crafto_live_search_form'] ) {
				$live_search_class = ' has-live-search';
			}

			switch ( $crafto_search_form_style ) {
				case 'popup':
				default:
					?>
					<div class="search-form-wrapper <?php echo esc_attr( $disable_label ); ?>">
						<a href="#" class="search-form-icon icon-<?php echo esc_attr( $settings['crafto_search_icon_align'] ); ?>" aria-label="<?php echo esc_attr__( 'search form icon', 'crafto-addons' ); ?>">
							<span class="screen-reader-text d-none"><?php echo esc_html__( 'search form icon', 'crafto-addons' ); ?></span>
							<?php
							if ( ! empty( $icon ) ) {
								?>
								<div class="elementor-icon">
									<?php printf( '%s', $icon ); // phpcs:ignore ?>
								</div>
								<?php
							}
							if ( $crafto_search_icon_text ) {
								?>
								<span class="icon-text"><?php echo esc_html( $crafto_search_icon_text ); ?></span>
								<?php
							}
							?>
						</a>
						<div class="form-wrapper">
							<button title="<?php echo esc_attr__( 'Close', 'crafto-addons' ); ?>" type="button" class="search-close alt-font" aria-label="<?php echo esc_attr__( 'Search close', 'crafto-addons' ); ?>"><?php echo esc_html__( '×', 'crafto-addons' ); ?></button>

							<form id="<?php echo esc_attr( $form_unique_id ); ?>" role="search" method="get" class="search-form <?php echo esc_html( $crafto_search_form_style . ' ' . $fullscreen_class ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="search-form-content-wrap">
								<div class="search-form-box">
									<?php
									if ( ! empty( $crafto_search_form_label ) ) {
										?>
										<label for="<?php echo esc_attr( $input_unique_id ); ?>" class="search-label alt-font">
											<?php echo esc_html( $crafto_search_form_label ); ?>
										</label>
										<?php
									}
									?>
									<div class="btn-wrap">
										<input class="search-input alt-font<?php echo esc_attr( $live_search_class ); ?>" id="<?php echo esc_attr( $input_unique_id ); ?>" placeholder="<?php echo esc_attr( $search_form_placeholder ); ?>" name="s" value="<?php echo get_search_query(); ?>" type="text" autocomplete="off">
										<?php
										if ( is_array( $search_type ) ) {
											foreach ( $search_type as $type ) {
												?>
												<input type="hidden" name="post_type[]" class="search-post-types-list" value="<?php echo esc_attr( $type ); ?>" />
												<?php
											}
										} else {
											?>
											<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type ); ?>" />
											<?php
										}
										?>
										<button type="submit" class="search-button">
											<span class="screen-reader-text d-none"><?php echo esc_html__( 'button', 'crafto-addons' ); ?></span>
											<?php
											if ( $icon_is_new || $icon_migrated ) {
												Icons_Manager::render_icon( $settings['crafto_search_form_button_icon'], [ 'aria-hidden' => 'true' ] );
											} elseif ( isset( $settings['crafto_search_form_button_icon']['value'] ) && ! empty( $settings['crafto_search_form_button_icon']['value'] ) ) {
												?>
												<i class="<?php echo esc_attr( $settings['crafto_search_form_button_icon']['value'] ); ?>" aria-hidden="true"></i>
												<?php
											}
											?>
										</button>
									</div>
								</div>
								<?php
								if ( 'yes' === $settings['crafto_live_search_form_popular_tags'] ) {
									?>
									<div class="search-form-tag-wrap">
										<div class="tags-label"><?php echo esc_html( $settings['crafto_live_search_form_tags_label'] ); ?></div>
										<div class="search-form-tags-items">
											<?php
											$base_url    = home_url( '/' );
											$total_items = count( $settings['crafto_live_search_form_tags'] );
											$counter     = 0;

											foreach ( $settings['crafto_live_search_form_tags'] as $item ) {
												$post_types_query = http_build_query( [ 'post_type' => $search_type ] );
												$search_query     = $item['title'];

												$href = "{$base_url}?s={$search_query}&{$post_types_query}";
												++$counter;

												echo '<a href="' . esc_url( $href ) . '" class="search-form-tags-item">' . esc_html( $search_query ) . '</a>';
												if ( $counter < $total_items ) {
													echo ', ';
												}
											}
											?>
										</div>
									</div>
									<?php
								}
								if ( 'yes' === $settings['crafto_live_search_form'] ) {
									?>
									<div class="search-loader" style="display: none;"></div>
									<div id="live-search-results" class="search-results-container" data-post-length="<?php echo esc_attr( $crafto_live_search_post_length ); ?>"></div>
									<?php
								}
								?>
								</div>
							</form>
						</div>
					</div>
					<?php
					break;
				case 'simple':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<?php
						if ( $crafto_search_icon_text ) {
							?>
							<span class="icon-text"><?php echo esc_html( $crafto_search_icon_text ); ?></span>
							<?php
						}
						?>
						<form id="<?php echo esc_attr( $form_unique_id ); ?>" role="search" method="get" class="search-form <?php echo esc_html( $crafto_search_form_style ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<div class="search-form-simple-box">
								<input class="search-input alt-font<?php echo esc_attr( $live_search_class ); ?>" id="<?php echo esc_attr( $input_unique_id ); ?>" placeholder="<?php echo esc_attr( $search_form_placeholder ); ?>" name="s" value="<?php echo get_search_query(); ?>" type="text" autocomplete="off">
								<?php
								if ( is_array( $search_type ) ) {
									foreach ( $search_type as $type ) {
										?>
										<input type="hidden" name="post_type[]" class="search-post-types-list" value="<?php echo esc_attr( $type ); ?>" />
										<?php
									}
								} else {
									?>
									<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type ); ?>" />
									<?php
								}
								?>
								<button type="submit" class="search-button">
									<span class="screen-reader-text d-none"><?php echo esc_html__( 'button', 'crafto-addons' ); ?></span>
									<?php
									if ( $icon_is_new || $icon_migrated ) {
										Icons_Manager::render_icon( $settings['crafto_search_form_button_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( isset( $settings['crafto_search_form_button_icon']['value'] ) && ! empty( $settings['crafto_search_form_button_icon']['value'] ) ) {
										?>
										<i class="<?php echo esc_attr( $settings['crafto_search_form_button_icon']['value'] ); ?>" aria-hidden="true"></i>
										<?php
									}
									?>
								</button>
								<?php
								if ( 'yes' === $settings['crafto_live_search_form'] ) {
									?>
									<div class="search-loader" style="display: none;"></div>
									<div class="crafto-live-search-results search-dropdown" data-post-length="<?php echo esc_attr( $crafto_live_search_post_length ); ?>"></div>
									<?php
								}
								?>
							</div>
						</form>
					</div>
					<?php
					break;
			}
		}

		/**
		 * Return post array
		 */
		public static function crafto_get_post_type_array() {
			$source = [];
			if ( class_exists( 'Give' ) ) {
				$source['give-forms'] = esc_html__( 'Give Forms', 'crafto-addons' );
			} elseif ( 'lp_course' === get_post_type() ) {
				$source['lp_course'] = esc_html__( 'LearnPress Course', 'crafto-addons' );
			} elseif ( is_woocommerce_activated() ) {
				// 'product' option is already in default options, so no need to add it here.
				$source['product'] = esc_html__( 'Product', 'crafto-addons' );
			}

			$custom_post_type = apply_filters( 'crafto_get_post_type_data', get_option( 'crafto_register_post_types', [] ), get_current_blog_id() );
			if ( ! empty( $custom_post_type ) ) {
				foreach ( $custom_post_type as $key => $post_type_array ) {
					if ( ! empty( $post_type_array ) ) {
						$key   = $post_type_array['name'];
						$label = $post_type_array['label'];

						$source[ $key ] = $label;
					}
				}
			}

			$options = array_merge(
				$source, // Merge with dynamic sources.
				[
					'post'       => esc_html__( 'Post', 'crafto-addons' ),
					'page'       => esc_html__( 'Page', 'crafto-addons' ),
					'portfolio'  => esc_html__( 'Portfolio', 'crafto-addons' ),
					'tours'      => esc_html__( 'Tour', 'crafto-addons' ),
					'properties' => esc_html__( 'Property', 'crafto-addons' ),
					'custom'     => esc_html__( 'Custom', 'crafto-addons' ),
				],
			);
			return $options;
		}
	}
}
