<?php
namespace craftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for counter.
 *
 * @package Crafto
 */

// If class `Counter` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Counter' ) ) {
	/**
	 * Define `Counter` class.
	 */
	class Counter extends Widget_Base {
		/**
		 * Retrieve the list of scripts the counter widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$counter_scripts = [ 'wp-util' ];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$counter_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'appear' ) && crafto_disable_module_by_key( 'anime' ) ) {
					$counter_scripts = [
						'appear',
						'anime',
						'animation',
					];
				}
				$counter_scripts[] = 'crafto-counter-widget';
			}

			return $counter_scripts;
		}

		/**
		 * Retrieve the list of styles the counter widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$counter_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$counter_styles[] = 'crafto-widgets-rtl';
				} else {
					$counter_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$counter_styles[] = 'crafto-counter-rtl-widget';
				}

				$counter_styles[] = 'crafto-counter-widget';
			}
			return $counter_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve counter widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-counter';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve counter widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Counter', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve counter widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-counter crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/counter/';
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
				'counter',
				'number',
				'random',
				'count',
				'counter widget',
				'animated number',
				'achievement',
			];
		}

		/**
		 * Register counter widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_vertical_counter_settings',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_vertical_counter_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'vertical-counter-style-1',
					'options' => [
						'vertical-counter-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'vertical-counter-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'vertical-counter-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'vertical-counter-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'vertical-counter-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_counter_number',
				[
					'label'   => esc_html__( 'Counter Number', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'default' => 1234,
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'crafto_prefix',
				[
					'label'     => esc_html__( 'Prefix', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => '',
					'condition' => [
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_suffix',
				[
					'label'     => esc_html__( 'Suffix', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => '',
					'condition' => [
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Cool Number', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Cool Number', 'crafto-addons' ),
					'condition'   => [
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_separator',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_vertical_counter_title_size',
				[
					'label'     => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default'   => 'div',
					'condition' => [
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-3',
							'vertical-counter-style-4',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_vertical_counter_content',
				[
					'label'      => esc_html__( 'Description', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => false,
					'default'    => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'crafto-addons' ),
					'condition'  => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_position',
				[
					'label'     => esc_html__( 'Content Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'bottom',
					'options'   => [
						'top'    => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_view',
				[
					'label'   => esc_html__( 'View', 'crafto-addons' ),
					'type'    => Controls_Manager::HIDDEN,
					'default' => 'traditional',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_vertical_counter_animation',
				[
					'label'     => esc_html__( 'Settings', 'crafto-addons' ),
					'condition' => [
						'crafto_vertical_counter_style' => 'vertical-counter-style-4',
						'crafto_selected_icon[value]!'  => '',
					],
				]
			);
			$this->add_control(
				'crafto_enable_float_vertical_counter_effect',
				[
					'label'        => esc_html__( 'Enable Floating Effect on Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_general',
				[
					'label'     => esc_html__( 'General', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-4',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_counter_aligment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'center',
					'options'              => [
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
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .vertical-counter-wrapper' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
					],
				],
			);
			$this->start_controls_tabs( 'crafto_counter_style_tabs' );
				$this->start_controls_tab(
					'crafto_counter_style_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_vertical_counter_style' => [
								'vertical-counter-style-3',
							],
						],
					],
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_counter_color',
						'selector'  => '{{WRAPPER}} .vertical-counter-wrapper',
						'condition' => [
							'crafto_vertical_counter_style' => [
								'vertical-counter-style-3',
							],
						],
					]
				);

				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_counter_style_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_vertical_counter_style' => [
								'vertical-counter-style-3',
							],
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'crafto_hover_counter_color',
						'selector'  => '{{WRAPPER}} .block-overlay',
						'condition' => [
							'crafto_vertical_counter_style' => [
								'vertical-counter-style-3',
							],
						],
					]
				);

				$this->add_control(
					'crafto_counter_hover_border',
					[
						'label'     => esc_html__( 'Border color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .vertical-counter-wrapper:hover' => 'border-color: {{VALUE}}',
						],
						'condition' => [
							'crafto_vertical_counter_style' => [
								'vertical-counter-style-3',
							],
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_counter_border',
					'separator' => 'before',
					'selector'  => '{{WRAPPER}} .vertical-counter-wrapper',
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_counter_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .vertical-counter-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_counter_padding',
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
						'{{WRAPPER}} .vertical-counter-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_number',
				[
					'label' => esc_html__( 'Number', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_typography_number',
					'selector' => '{{WRAPPER}} .vertical-counter-wrapper .vertical-counter',
				]
			);
			$this->start_controls_tabs(
				'crafto_vertical_counter_number_tab'
			);
			$this->start_controls_tab(
				'crafto_vertical_counter_number_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .vertical-counter-wrapper .vertical-counter' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_vertical_counter_number_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_number_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .vertical-counter-wrapper .vertical-counter' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_vertical_heading_style_prefix',
				[
					'label'     => esc_html__( 'prefix', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_prefix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_vertical_counter_number_prefix_typography',
					'exclude'   => [
						'text_transform',
						'text_decoration',
						'letter_spacing',
					],
					'selector'  => '{{WRAPPER}} .number-prefix',
					'condition' => [
						'crafto_prefix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_vertical_counter_number_prefix_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .number-prefix' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_prefix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_prefix_hover_color',
				[
					'label'     => esc_html__( 'Prefix Hover Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .number-prefix' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_prefix[value]!'         => '',
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				],
			);
			$this->add_responsive_control(
				'crafto_vertical_counter_number_prefix_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .number-prefix'      => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .number-prefix' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_prefix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_vertical_heading_style_suffix',
				[
					'label'     => esc_html__( 'Suffix', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_suffix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_vertical_counter_number_suffix_typography',
					'exclude'   => [
						'text_transform',
						'text_decoration',
						'letter_spacing',
					],
					'selector'  => '{{WRAPPER}} .number-suffix',
					'condition' => [
						'crafto_suffix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_vertical_counter_number_suffix_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .number-suffix' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_suffix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_suffix_hover_color',
				[
					'label'     => esc_html__( 'Suffix Hover Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .number-suffix' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_suffix[value]!'         => '',
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				],
			);
			$this->add_responsive_control(
				'crafto_vertical_counter_number_suffix_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .number-suffix'      => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .number-suffix' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_suffix[value]!'          => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_label',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_label[value]!'           => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_typography_title',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .vertical-counter-wrapper .title',
				]
			);
			$this->add_control(
				'crafto_label_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .vertical-counter-wrapper .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_vertical_counter_title_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 25,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .vertical-counter-wrapper .title' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-4',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_content',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_vertical_counter_content[value]!' => '',
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_typography_content',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .vertical-counter-wrapper .content',
				]
			);
			$this->start_controls_tabs(
				'crafto_vertical_counter_content_tab'
			);
			$this->start_controls_tab(
				'crafto_vertical_counter_content_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_vertical_counter_content_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_content_width',
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
							'max' => 200,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .vertical-counter-wrapper .content' => 'width: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_vertical_counter_content_margin',
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
						'{{WRAPPER}} .vertical-counter-wrapper .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_separator',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-2',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_separator_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .vertical-counter-style-2 .separator',
				]
			);
			$this->add_responsive_control(
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
							'min' => 6,
							'max' => 20,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .vertical-counter-style-2 .separator' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_separator_bottom_offset',
				[
					'label'      => esc_html__( 'Bottom Offset', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 15,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .vertical-counter-style-2 .separator' => 'bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_icon',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_selected_icon[value]!'   => '',
						'crafto_vertical_counter_style!' => [
							'vertical-counter-style-2',
							'vertical-counter-style-5',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_vertical_counter_icon_tab'
			);
			$this->start_controls_tab(
				'crafto_vertical_counter_icon_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_vertical_counter_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .verticle-counter-icon'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .verticle-counter-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_vertical_counter_icon_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_vertical_counter_icon_hover_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}}:hover .verticle-counter-icon'  => 'color: {{VALUE}};',
						'{{WRAPPER}}:hover .verticle-counter-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-3',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 14,
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .verticle-counter-icon'   => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_vertical_counter_icon_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .verticle-counter-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .verticle-counter-icon' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_vertical_counter_top_spacing',
				[
					'label'      => esc_html__( 'Top Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => -30,
							'max' => 30,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .verticle-counter-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-4',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_icon_separator_style',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_vertical_counter_style' => [
							'vertical-counter-style-5',
						],
						'crafto_icon_separator'         => 'yes',

					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_icon_separator_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .horizontal-separator',
				]
			);
			$this->add_control(
				'crafto_icon_separator_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .horizontal-separator' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_separator_thickness',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 5,
						],
						'%'  => [
							'min' => 1,
							'max' => 80,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .horizontal-separator' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_separator_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .horizontal-separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render counter widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                      = $this->get_settings_for_display();
			$counter_number                = $this->get_settings( 'crafto_counter_number' );
			$crafto_vertical_counter_style = ( isset( $settings['crafto_vertical_counter_style'] ) && $settings['crafto_vertical_counter_style'] ) ? $settings['crafto_vertical_counter_style'] : '';
			$migrated                      = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new                        = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_content_position       = ( isset( $settings['crafto_content_position'] ) && $settings['crafto_content_position'] ) ? $settings['crafto_content_position'] : '';
			$crafto_icon_separator         = ( isset( $settings['crafto_icon_separator'] ) && $settings['crafto_icon_separator'] ) ? $settings['crafto_icon_separator'] : '';

			$crafto_navigation_v_alignment = $this->get_settings( 'crafto_navigation_v_alignment' );

			if ( ! empty( $crafto_navigation_v_alignment ) ) {
				$this->add_render_attribute(
					[
						'vertical-counter-wrapper' => [
							'class' => [
								'navigation-' . $crafto_navigation_v_alignment,
							],
						],
					]
				);
			}

			if ( empty( $counter_number ) ) {
				return;
			}

			$button_key                                  = '';
			$crafto_enable_float_vertical_counter_effect = $this->get_settings( 'crafto_enable_float_vertical_counter_effect' );

			if ( ! empty( $crafto_enable_float_vertical_counter_effect ) ) {
				$button_key = 'animation-float';
			}

			$this->add_render_attribute(
				[
					'wrapper-inner' => [
						'class' => [
							'elementor-counter-number-wrapper',
							$button_key,
						],
					],
				]
			);

			$this->add_render_attribute(
				'counter',
				'class',
				[
					'vertical-counter-wrapper',
					$crafto_vertical_counter_style,
					$crafto_content_position,
				]
			);
			$this->add_render_attribute(
				'counter_number',
				[
					'class'      => [
						'vertical-counter',
						'd-inline-flex',
					],
					'data-value' => $counter_number,
				],
			);
			$this->add_render_attribute(
				[
					'content-wrapper' => [
						'class' => 'elementor-button-content-wrapper',
					],
				],
			);
			$this->add_render_attribute(
				[
					'icon-align' => [
						'class' => [
							'verticle-counter-icon',
						],
					],
				],
			);
			switch ( $crafto_vertical_counter_style ) {
				case 'vertical-counter-style-1':
					?>
					<div <?php $this->print_render_attribute_string( 'counter' ); ?>>
						<?php
						if ( ! empty( $this->get_settings( 'crafto_prefix' ) ) || '0' === $this->get_settings( 'crafto_prefix' ) ) {
							?>
							<span class="number-prefix">
								<?php echo esc_html( $this->get_settings( 'crafto_prefix' ) ); ?>
							</span>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'counter_number' ); ?>></div>
						<?php
						if ( ! empty( $this->get_settings( 'crafto_suffix' ) ) || '0' === $this->get_settings( 'crafto_suffix' ) ) {
							?>
							<span class="number-suffix">
								<?php echo esc_html( $this->get_settings( 'crafto_suffix' ) ); ?>
							</span>
							<?php
						}
						if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_selected_icon']['value'] ) ) {
							?>
							<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
								<?php
								if ( $is_new || $migrated ) {
									Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
								} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
									?>
									<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
									<?php
								}
								?>
							</span>
							<?php
						}
						if ( ! empty( $this->get_settings( 'crafto_label' ) ) ) {
							?>
							<<?php echo $this->get_settings( 'crafto_vertical_counter_title_size' ); // phpcs:ignore ?> class="title">
								<?php echo esc_html( $this->get_settings( 'crafto_label' ) ); ?>
							</<?php echo $this->get_settings( 'crafto_vertical_counter_title_size' ); // phpcs:ignore ?>>
							<?php
						}
						?>
					</div>
					<?php
					break;
				case 'vertical-counter-style-2':
					?>
					<div <?php $this->print_render_attribute_string( 'counter' ); ?>>
						<div class="number-wrap">
							<div class="separator"></div>
							<div <?php $this->print_render_attribute_string( 'counter_number' ); ?>></div>
						</div>
						<?php
						if ( ! empty( $this->get_settings( 'crafto_label' ) ) ) {
							?>
							<<?php echo $this->get_settings( 'crafto_vertical_counter_title_size' ); // phpcs:ignore ?> class="title">
								<?php echo esc_html( $this->get_settings( 'crafto_label' ) ); ?>
							</<?php echo $this->get_settings( 'crafto_vertical_counter_title_size' ); // phpcs:ignore ?>>
							<?php
						}
						?>
					</div>
					<?php
					break;
				case 'vertical-counter-style-3':
					?>
					<div <?php $this->print_render_attribute_string( 'counter' ); ?>>
						<div class="vertical-counter-wrap">
							<?php
							if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_selected_icon']['value'] ) ) {
								?>
								<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
									<?php
									if ( $is_new || $migrated ) {
										Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
										?>
										<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
										<?php
									}
									?>
								</span>
								<?php
							}
							if ( ! empty( $this->get_settings( 'crafto_prefix' ) ) || '0' === $this->get_settings( 'crafto_prefix' ) ) {
								?>
								<span class="number-prefix">
									<?php echo esc_html( $this->get_settings( 'crafto_prefix' ) ); ?>
								</span>
								<?php
							}
							?>
							<div <?php $this->print_render_attribute_string( 'counter_number' ); ?>></div>
							<?php
							if ( ! empty( $this->get_settings( 'crafto_suffix' ) ) || '0' === $this->get_settings( 'crafto_suffix' ) ) {
								?>
								<span class="number-suffix">
									<?php echo esc_html( $this->get_settings( 'crafto_suffix' ) ); ?>
								</span>
								<?php
							}
							?>
						</div>
						<?php
						if ( ! empty( $this->get_settings( 'crafto_vertical_counter_content' ) ) ) {
							?>
							<div class="content-wrap">
								<div class="content">
									<?php echo ( $this->get_settings( 'crafto_vertical_counter_content' ) ); // phpcs:ignore ?>
								</div>
							</div>
							<div class="block-overlay"></div>
							<?php
						}
						?>
					</div>
					<?php
					break;
				case 'vertical-counter-style-4':
					?>
					<div <?php $this->print_render_attribute_string( 'counter' ); ?>>
						<div class="counter-wrapper">
							<div <?php $this->print_render_attribute_string( 'wrapper-inner' ); ?>>
								<span class="number-prefix">
									<?php echo esc_html( $this->get_settings( 'crafto_prefix' ) ); ?>
								</span>
								<?php
								if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_selected_icon']['value'] ) ) {
									?>
									<span <?php $this->print_render_attribute_string( 'icon-align' ); ?>>
									<?php
									if ( $is_new || $migrated ) {
										Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
										?>
										<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
										<?php
									}
									?>
									</span>
									<?php
								}
								?>
								<div <?php $this->print_render_attribute_string( 'counter_number' ); ?>></div>
								<span class="number-suffix">
									<?php echo esc_html( $this->get_settings( 'crafto_suffix' ) ); ?>
								</span>
							</div>
							<?php
							if ( $settings['crafto_label'] ) { ?>
								<div class="title" <?php $this->print_render_attribute_string( 'counter-title' ); ?>>
									<?php $this->print_unescaped_setting( 'crafto_label' ); ?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
					break;
				case 'vertical-counter-style-5':
					?>
					<div <?php $this->print_render_attribute_string( 'counter' ); ?>>
						<div class="counter-wrapper">
							<div <?php $this->print_render_attribute_string( 'wrapper-inner' ); ?>>
								<span class="number-prefix"></span>
								<span <?php $this->print_render_attribute_string( 'counter_number' ); ?>></span>
								<span class="number-suffix"></span>
							</div>
							<?php
							if ( $settings['crafto_label'] ) { ?>
								<div class="title" <?php $this->print_render_attribute_string( 'counter-title' ); ?>>
									<?php $this->print_unescaped_setting( 'crafto_label' ); ?>
								</div>
								<?php
							}
							?>
							<?php
							if ( 'yes' === $crafto_icon_separator && 'vertical-counter-style-5' === $crafto_vertical_counter_style ) {
								?>
								<div class="horizontal-separator"></div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
					break;
			}
		}
	}
}
