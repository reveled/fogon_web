<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for process step.
 *
 * @package Crafto
 */

// If class `Process_Step` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Process_Step' ) ) {
	/**
	 * Define `Process_Step` class.
	 */
	class Process_Step extends Widget_Base {
		/**
		 * Retrieve the list of styles the process step widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$process_step_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$process_step_styles[] = 'crafto-widgets-rtl';
				} else {
					$process_step_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$process_step_styles[] = 'crafto-process-step-rtl-widget';
				}
				$process_step_styles[] = 'crafto-process-step-widget';
			}
			return $process_step_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve process step widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-process-step';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve process step widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Process Steps', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve process step widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-exchange crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/process-steps/';
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
				'step flow',
				'steps',
				'process',
				'workflow',
				'timeline',
				'step by step',
			];
		}

		/**
		 * Register process step widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_process_step_settings',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_process_step_style',
				[
					'label'       => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'process-step-style-1',
					'options'     => [
						'process-step-style-1'  => esc_html__( 'Style 1', 'crafto-addons' ),
						'process-step-style-2'  => esc_html__( 'Style 2', 'crafto-addons' ),
						'process-step-style-3'  => esc_html__( 'Style 3', 'crafto-addons' ),
						'process-step-style-4'  => esc_html__( 'Style 4', 'crafto-addons' ),
						'process-step-style-5'  => esc_html__( 'Style 5', 'crafto-addons' ),
						'process-step-style-6'  => esc_html__( 'Style 6', 'crafto-addons' ),
						'process-step-style-7'  => esc_html__( 'Style 7', 'crafto-addons' ),
						'process-step-style-8'  => esc_html__( 'Style 8', 'crafto-addons' ),
						'process-step-style-9'  => esc_html__( 'Style 9', 'crafto-addons' ),
						'process-step-style-10' => esc_html__( 'Style 10', 'crafto-addons' ),
					],
					'label_block' => false,
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_process_step_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'separator'   => 'none',
				]
			);
			$repeater->add_control(
				'crafto_process_step_description',
				[
					'label'      => esc_html__( 'Description', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => true,
					'default'    => esc_html__( 'Lorem ipsum amet consectetur adipiscing', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_process_step_icon',
				[
					'label'            => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'default'          => [
						'value'   => 'fa-solid fa-star',
						'library' => 'fa-solid',
					],
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'description'      => esc_html__( 'Applicable in style 2,5 & 9 only.', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_process_step_image',
				[
					'label'       => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'description' => esc_html__( 'Applicable in style 5 only.', 'crafto-addons' ),
				]
			);
			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'crafto_thumbnail',
					'default' => 'full',
					'exclude' => [
						'custom',
					],
				]
			);
			$this->add_control(
				'crafto_process_step',
				[
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_process_step_title' => esc_html__( 'Process Step 1', 'crafto-addons' ),
							'crafto_process_step_description' => esc_html__( 'Lorem ipsum amet consectetur adipiscing.', 'crafto-addons' ),
						],
						[
							'crafto_process_step_title' => esc_html__( 'Process Step 2', 'crafto-addons' ),
							'crafto_process_step_description' => esc_html__( 'Lorem ipsum amet consectetur adipiscing.', 'crafto-addons' ),
						],
						[
							'crafto_process_step_title' => esc_html__( 'Process Step 3', 'crafto-addons' ),
							'crafto_process_step_description' => esc_html__( 'Lorem ipsum amet consectetur adipiscing.', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_process_step_title }}}',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_content_settings',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_process_step_title_size',
				[
					'label'   => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
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
					'default' => 'div',
				]
			);
			$this->add_control(
				'crafto_process_step_direction',
				[
					'label'     => esc_html__( 'Orientation', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'vertical',
					'options'   => [
						'horizontal' => [
							'title' => esc_html__( 'Horizontal', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-h',
						],
						'vertical'   => [
							'title' => esc_html__( 'Vertical', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-v',
						],
					],
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_enable_process_number_prefix',
				[
					'label'        => esc_html__( 'Enable Leading Zero', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_process_step_style!' => [
							'process-step-style-5',
							'process-step-style-9',
						],
					],
				]
			);
			$this->add_control(
				'crafto_display_separator',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'conditions'   => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-4',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-5',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-3',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-2',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-8',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_process_step_direction',
										'operator' => '===',
										'value'    => 'vertical',
									],
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-1',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_number_postion',
				[
					'label'     => esc_html__( 'Number Position', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'number-up',
					'options'   => [
						'number-up'   => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'number-down' => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-2',
							'process-step-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_number_position',
				[
					'label'          => esc_html__( 'Number Position', 'crafto-addons' ),
					'type'           => Controls_Manager::CHOOSE,
					'default'        => 'left',
					'mobile_default' => 'top',
					'options'        => [
						'left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'top'   => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'prefix_class'   => 'elementor-position-',
					'toggle'         => true,
					'condition'      => [
						'crafto_process_step_style' => [
							'process-step-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_right_icon',
				[
					'label'            => esc_html__( 'Process Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'icon-feather-chevron-right',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_enable_process_number_prefix' => 'yes',
						'crafto_process_step_style' => [
							'process-step-style-7',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_process_step_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_horizontal_alighnment',
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
						'{{WRAPPER}} .process-step-item' => 'align-items: {{VALUE}};',
					],
					'condition'   => [
						'crafto_process_step_style'     => 'process-step-style-1',
						'crafto_process_step_direction' => 'horizontal',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_content_spacer',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
						'size' => 50,
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-item .process-content' => 'padding-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-1',
							'process-step-style-3!',
							'process-step-style-8!',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_general_aligment',
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
						'{{WRAPPER}} .process-step-item, {{WRAPPER}} .process-step-style-10' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_general_alignment',
				[
					'label'        => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'label_block'  => false,
					'default'      => 'center',
					'options'      => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'prefix_class' => 'elementor%s-position-',
					'condition'    => [
						'crafto_process_step_style' => [
							'process-step-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_content_bottom_spacer',
				[
					'label'      => esc_html__( 'Bottom Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_process_step_style!' => [
							'process-step-style-1',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_process_step_icon_style',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-2',
							'process-step-style-5',
							'process-step-style-9',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_process_step_styles_tabs',
				[
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-2!',
							'process-step-style-5!',
							'process-step-style-9',
						],
					],
				]
			);
				$this->start_controls_tab(
					'crafto_normal_process_step_style',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_process_step_style' => [
								'process-step-style-2!',
								'process-step-style-5!',
								'process-step-style-9',
							],
						],
					]
				);
				$this->add_control(
					'crafto_process_step_icon_normal_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .process-step-box .process-step-icon i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .process-step-box .process-step-icon svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							'crafto_process_step_style' => [
								'process-step-style-2',
								'process-step-style-5',
								'process-step-style-9',
							],
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'           => 'crafto_process_step_icon_bg_color',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
						'selector'       => '{{WRAPPER}} .process-step-style-9 .process-step-icon-box',
						'condition'      => [
							'crafto_process_step_style' => [
								'process-step-style-2!',
								'process-step-style-5!',
								'process-step-style-9',
							],
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_hover_process_step_style',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_process_step_style' => [
								'process-step-style-2!',
								'process-step-style-5!',
								'process-step-style-9',
							],
						],
					]
				);
				$this->add_control(
					'crafto_process_step_icon_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .process-step-item:hover .process-step-icon i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .process-step-item:hover .process-step-icon svg' => 'fill: {{VALUE}};',
						],
						'condition' => [
							'crafto_process_step_style' => [
								'process-step-style-2!',
								'process-step-style-5!',
								'process-step-style-9',
							],
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'           => 'crafto_process_step_icon_bg_hover',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
						'selector'       => '{{WRAPPER}} .process-step-style-9 .process-step-item:hover .process-step-icon-box',
						'condition'      => [
							'crafto_process_step_style' => [
								'process-step-style-2!',
								'process-step-style-5!',
								'process-step-style-9',
							],
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_icon_hr',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-2!',
							'process-step-style-5!',
							'process-step-style-9',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_process_step_icon_box_shadow',
					'selector'  => '{{WRAPPER}} .process-step-style-9 .process-step-icon-box',
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-2!',
							'process-step-style-5!',
							'process-step-style-9',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-box .process-step-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .process-step-box .process-step-icon svg' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-2',
							'process-step-style-5',
							'process-step-style-9',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_icon_box_width',
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
							'min' => 10,
							'max' => 200,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-9 .process-step-icon-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-2!',
							'process-step-style-5!',
							'process-step-style-9',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_box_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-2 .process-step-icon-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .process-step-style-9 .process-step-icon-box' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .process-step-style-9 .process-step-icon-box' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-2',
							'process-step-style-9',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_process_step_image_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Overlay Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .box-overlay',
					'condition'      => [
						'crafto_process_step_style' => [
							'process-step-style-2!',
							'process-step-style-5',
							'process-step-style-9!',
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_image_opacity',
				[
					'label'      => esc_html__( 'Overlay Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
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
						'{{WRAPPER}} .process-step-icon .box-overlay' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-2!',
							'process-step-style-5',
							'process-step-style-9!',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_process_step_image_style',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_image_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 350,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-5 .process-step-icon' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_box_image_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-5 .process-step-item-box' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'      => 'crafto_process_step_image_css_filters',
					'selector'  => '{{WRAPPER}} .process-step-icon img, {{WRAPPER}} .process-step-icon-box img, {{WRAPPER}} .process-step-item-box img',
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-9',
						],
					],
				]
			);
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_process_step_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-icon-box img, {{WRAPPER}} .process-step-style-5 .process-step-icon, {{WRAPPER}} .process-step-style-9 .process-step-item-box img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-5',
							'process-step-style-9',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_process_step_number_style',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_process_step_style!' => [
							'process-step-style-5',
							'process-step-style-9',
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_number_type',
				[
					'label'     => esc_html__( 'Title Type', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'normal' => [
							'title' => esc_html__( 'Normal', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter-bold',
						],
						'stroke' => [
							'title' => esc_html__( 'Stroke', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter',
						],
					],
					'default'   => 'stroke',
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_process_step_number',
					'selector'       => '{{WRAPPER}} .process-step-item-number',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_process_step_number_type' => 'stroke',
						'crafto_process_step_style'       => [
							'process-step-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_process_step_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .process-step-box .process-step-number, {{WRAPPER}} .process-step-style-6 .process-step-item-number',
				]
			);
			$this->start_controls_tabs(
				'crafto_process_step_number_tabs'
			);
			$this->start_controls_tab(
				'crafto_process_step_number_normal_tab',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_process_step_style!' => [
							'process-step-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .process-step-box .process-step-number, {{WRAPPER}} .process-step-style-6 .process-step-item-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_process_step_number_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .process-step-style-1 .process-step-number-bfr, {{WRAPPER}} .process-step-style-8 .process-step-number-bfr, {{WRAPPER}} .process-step-style-2 .process-step-number-bfr, {{WRAPPER}} .process-step-style-4 .process-step-item-number, {{WRAPPER}} .process-step-style-7 .process-step-item-number, {{WRAPPER}} .process-step-style-10 .process-step-number',
					'condition'      => [
						'crafto_process_step_style!' => [
							'process-step-style-3',
							'process-step-style-8',
							'process-step-style-6',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_process_step_number_hover_tab',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_process_step_style!' => [
							'process-step-style-6',
						],
					],
				],
			);
			$this->add_control(
				'crafto_process_step_number_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .process-step-style-1 .process-step-item:hover .process-step-number-bfr, {{WRAPPER}} .process-step-style-2 .process-step-item:hover .process-step-number-bfr, {{WRAPPER}} .process-step-style-3 .process-step-item:hover .process-step-number, {{WRAPPER}} .process-step-style-4 .process-step-item:hover .process-step-number-bfr, {{WRAPPER}} .process-step-style-7 .process-step-item:hover .process-step-number-bfr, {{WRAPPER}} .process-step-style-8 .process-step-item:hover .process-step-number-bfr, {{WRAPPER}} .process-step-style-10 .process-step-item:hover .process-step-number'  => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_process_step_number_hover_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .process-step-style-1 .process-step-item:hover .process-step-number-bfr, {{WRAPPER}} .process-step-style-2 .process-step-item:hover .process-step-number-bfr, {{WRAPPER}} .process-step-style-4 .process-step-item:hover .process-step-number-afr, {{WRAPPER}} .process-step-style-7 .process-step-item:hover .process-step-number-afr, {{WRAPPER}} .process-step-style-10 .process-step-item:hover .process-step-number',
					'condition'      => [
						'crafto_process_step_style!' => [
							'process-step-style-3',
							'process-step-style-8',
							'process-step-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_number_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .process-step-style-1 .process-step-item:hover .process-step-number-bfr' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-1',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_process_step_number_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .process-step-style-1 .process-step-item-number .process-step-number-bfr, {{WRAPPER}} .process-step-style-2 .process-step-item-number .process-step-number-bfr, {{WRAPPER}} .process-step-style-4 .process-step-item-number, {{WRAPPER}} .process-step-style-7 .process-step-item-number' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
					'condition'  => [
						'crafto_process_step_style!' => [
							'process-step-style-3',
							'process-step-style-6',
							'process-step-style-8',
							'process-step-style-10',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_number_width',
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
							'min' => 10,
							'max' => 200,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-10 .process-step-number' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-10',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_number_height',
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
							'min' => 10,
							'max' => 200,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-10 .process-step-number' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_style' => [
							'process-step-style-10',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_number_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'unit' => 'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-1 .process-step-item-box, {{WRAPPER}}.elementor-position-left .process-step-style-10 .process-step-number' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .process-step-style-2 .process-step-item-box, {{WRAPPER}} .process-step-style-3 .process-step-item-number, {{WRAPPER}} .process-step-style-7 .process-step-item-box, {{WRAPPER}}.elementor-position-top .process-step-style-10 .process-step-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}.elementor-position-right .process-step-style-10 .process-step-number' => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .process-step-style-1 .process-step-item-box' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-left .process-step-style-10 .process-step-number' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-right .process-step-style-10 .process-step-number' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-1',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-7',
									],
								],
							],
							[
								'terms' => [
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-10',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_process_step_number_postion',
										'operator' => '===',
										'value'    => 'number-up',
									],
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-2',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_process_step_number_postion',
										'operator' => '===',
										'value'    => 'number-up',
									],
									[
										'name'     => 'crafto_process_step_style',
										'operator' => '===',
										'value'    => 'process-step-style-3',
									],
								],
							],
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_process_step_number_margin_top',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-3 .process-step-item-number' => 'margin-top: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_process_step_number_postion' => 'number-down',
						'crafto_process_step_style' => [
							'process-step-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_process_step_number_border',
					'selector'  => '{{WRAPPER}} .process-step-style-1 .process-step-number-bfr, {{WRAPPER}} .process-step-style-2 .process-step-number-bfr, {{WRAPPER}} .process-step-style-4 .process-step-item-number, {{WRAPPER}} .process-step-style-7 .process-step-item-number',
					'condition' => [
						'crafto_process_step_style!' => [
							'process-step-style-3',
							'process-step-style-6',
							'process-step-style-8',
							'process-step-style-10',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_process_step_number_box_shadow',
					'selector'  => '{{WRAPPER}} .process-step-style-1.process-step-box .process-step-number-bfr, {{WRAPPER}} .process-step-style-2.process-step-box .process-step-number-bfr, {{WRAPPER}} .process-step-style-4 .process-step-item-number',
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-1',
							'process-step-style-2',
							'process-step-style-4',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_process_step_title_style',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_process_step_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .process-step-box .process-step-title',
				]
			);
			$this->add_control(
				'crafto_process_step_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .process-step-box .process-step-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_title_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-box .process-step-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_process_step_content_style',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_process_step_content_typography',
					'selector' => '{{WRAPPER}} .process-step-box .process-step-content',
				]
			);
			$this->add_control(
				'crafto_process_step_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .process-step-box .process-step-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_content_width',
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
							'min' => 10,
							'max' => 200,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-box .process-step-content' => 'width: {{SIZE}}{{UNIT}}; display: inline-block',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_process_step_box_style',
				[
					'label'     => esc_html__( 'Step Point', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-3',
						],
						'crafto_display_separator'  => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_process_step_box_bfr_heading',
				[
					'label' => esc_html__( 'Outer Circle', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_box_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-3 .process-step-box-bfr' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_process_step_box_tabs'
			);
			$this->start_controls_tab(
				'crafto_process_step_box_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_process_step_box_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .process-step-style-3 .process-step-box-bfr',
					'separator'      => 'after',
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_process_step_box_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_process_step_box_hover_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .process-step-style-3 .process-step-item:hover .process-step-box-bfr',
					'separator'      => 'after',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_process_step_box_shadow',
					'selector' => '{{WRAPPER}} .process-step-style-3 .process-step-box-bfr',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_process_step_box_border',
					'selector' => '{{WRAPPER}} .process-step-style-3 .process-step-box-bfr',
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_box_bfr_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-3 .process-step-box-bfr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'crafto_process_step_box_afr_heading',
				[
					'label'     => esc_html__( 'Inner Circle', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_afr_box_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 25,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-3 .process-step-box-afr' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_process_step_afr_box_tabs'
			);
			$this->start_controls_tab(
				'crafto_process_step_box_afr_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_process_step_afr_box_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .process-step-style-3 .process-step-box-afr',
					'separator'      => 'after',
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_process_step_afr_box_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_process_step_box_afr_hover_bg_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
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
					'selector'       => '{{WRAPPER}} .process-step-style-3 .process-step-item:hover .process-step-box-afr',
					'separator'      => 'after',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_process_step_box_afr_shadow',
					'selector' => '{{WRAPPER}} .process-step-style-3 .process-step-box-afr',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_process_step_box_afr_border',
					'selector' => '{{WRAPPER}} .process-step-style-3 .process-step-box-afr',
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_box_afr_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .process-step-style-3 .process-step-box-afr' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_process_step_box_afr_bfr_margin',
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
						'{{WRAPPER}} .process-step-style-3 .process-step-item-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_process_step_separator_style_section',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_display_separator'   => 'yes',
						'crafto_process_step_style!' => [
							'process-step-style-6',
							'process-step-style-7',
							'process-step-style-9',
							'process-step-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .process-step-box .process-step-separator' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_process_step_item_color',
				[
					'label'     => esc_html__( 'Vertical Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .process-step-style-8 .process-step-item' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_process_step_style' => [
							'process-step-style-8',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_right_icon_style_section',
				[
					'label'     => esc_html__( 'Process Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_enable_process_number_prefix' => 'yes',
						'crafto_process_step_right_icon[value]!' => '',
						'crafto_process_step_style' => [
							'process-step-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_process_step_right_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .process-step-box .progress-right-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .process-step-box .progress-right-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_process_step_right_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .process-step-box .progress-right-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .process-step-box .progress-right-icon svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render process step widget output on the frontend.
		 * Make sure value does no exceed 100%.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( empty( $settings['crafto_process_step'] ) ) {
				return;
			}

			$crafto_process_step_style           = ( isset( $settings['crafto_process_step_style'] ) && $settings['crafto_process_step_style'] ) ? $settings['crafto_process_step_style'] : '';
			$process_step_number_position        = ( isset( $settings['crafto_process_step_number_postion'] ) && $settings['crafto_process_step_number_postion'] ) ? $settings['crafto_process_step_number_postion'] : '';
			$crafto_enable_process_number_prefix = ( isset( $settings['crafto_enable_process_number_prefix'] ) && $settings['crafto_enable_process_number_prefix'] ) ? $settings['crafto_enable_process_number_prefix'] : '';
			$crafto_display_separator            = ( isset( $settings['crafto_display_separator'] ) && $settings['crafto_display_separator'] ) ? $settings['crafto_display_separator'] : '';
			$crafto_process_step_direction       = ( isset( $settings['crafto_process_step_direction'] ) && $settings['crafto_process_step_direction'] ) ? $settings['crafto_process_step_direction'] : '';
			$crafto_process_step_number_type     = ( isset( $settings['crafto_process_step_number_type'] ) && $settings['crafto_process_step_number_type'] ) ? $settings['crafto_process_step_number_type'] : '';
			if ( 'vertical' === $crafto_process_step_direction ) {
				$this->add_render_attribute(
					'wrapper',
					'class',
					[
						'processstep-direction-vertical',
					]
				);
			} else {
				$this->add_render_attribute(
					'wrapper',
					'class',
					[
						'processstep-direction-horizontal',
					]
				);
			}
			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'process-step-box',
					$crafto_process_step_style,
					$process_step_number_position,
				]
			);
			$this->add_render_attribute(
				'process_step_number',
				'class',
				[
					'process-step-item-number',
				]
			);
			if ( 'stroke' === $crafto_process_step_number_type ) {
				$this->add_render_attribute(
					'process_step_number',
					'class',
					[
						'text-stroke',
					]
				);
			}
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				switch ( $crafto_process_step_style ) {
					case 'process-step-style-1':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<div class="process-step-item-box">
									<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
										<span class="process-step-number-bfr process-step-number">
											<?php echo esc_html( $process_number ); ?>
										</span>
									</div>
									<?php
									if ( 'yes' === $crafto_display_separator && 'vertical' === $crafto_process_step_direction ) {
										?>
										<span class="process-step-item-box-bfr process-step-separator"></span>
										<?php
									}
									?> 
								</div>
								<?php
								$this->render_process_content_block( $item );
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-2':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<?php
								$this->render_icon_box( $item );
								$this->render_process_content_block( $item );
								?>
								<div class="process-step-item-box">
									<?php
									if ( 'yes' === $crafto_display_separator ) {
										?>
										<span class="process-step-item-box-bfr process-step-separator"></span>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
										<span class="process-step-number-bfr process-step-number">
											<?php echo esc_html( $process_number ); ?>
										</span>
									</div>
								</div>
							</div>
							<?php
						}
						break;
					case 'process-step-style-3':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
									<span class="process-step-number">
										<?php echo esc_html( $process_number ); ?>
									</span>
								</div>
								<?php
								if ( 'yes' === $crafto_display_separator ) {
									?>
									<div class="process-step-item-box">
										<span class="process-step-item-box-bfr process-step-separator"></span>
										<span class="process-step-box-bfr">
											<span class="process-step-box-afr"></span>
										</span>
									</div>
									<?php
								}
								$this->render_process_content_block( $item );
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-4':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<div class="process-step-item-box">
									<?php
									if ( 'yes' === $crafto_display_separator ) {
										?>
										<span class="process-step-item-box-bfr process-step-separator"></span>
										<?php
									}
									?>
									<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
										<span class="process-step-number-bfr process-step-number">
											<?php echo esc_html( $process_number ); ?>
										</span>
										<div class="process-step-number-afr"></div>
									</div>
								</div>
								<?php
								$this->render_process_content_block( $item );
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-5':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							?>
							<div class="process-step-item">
								<div class="process-step-item-box">
									<?php
									if ( 'yes' === $crafto_display_separator ) {
										?>
										<span class="process-step-item-box-bfr process-step-separator"></span>
										<?php
									}
									?>
									<div class="process-step-icon">
										<?php
										if ( ( 'icon' === $item['crafto_process_step_icon'] ) || ( ! empty( $item['crafto_process_step_image'] ) ) ) {
											if ( ! empty( $item['crafto_process_step_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_process_step_image']['id'] ) ) {
												$item['crafto_process_step_image']['id'] = '';
											}
											if ( isset( $item['crafto_process_step_image'] ) && isset( $item['crafto_process_step_image']['id'] ) && ! empty( $item['crafto_process_step_image']['id'] ) ) {
												crafto_get_attachment_html( $item['crafto_process_step_image']['id'], $item['crafto_process_step_image']['url'], $item['crafto_thumbnail_size'] ); // phpcs:ignore
											} elseif ( isset( $item['crafto_process_step_image'] ) && isset( $item['crafto_process_step_image']['url'] ) && ! empty( $item['crafto_process_step_image']['url'] ) ) {
												crafto_get_attachment_html( $item['crafto_process_step_image']['id'], $item['crafto_process_step_image']['url'], $item['crafto_thumbnail_size'] ); // phpcs:ignore
											}
											?>
											<?php $this->render_icon_box( $item );
										}
										?>
									</div>
								</div>
								<?php
									$this->render_process_content_block( $item );
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-6':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
									<?php echo esc_html( $process_number ); ?>
								</div>
								<?php
								if ( ! empty( $item['crafto_process_step_title'] ) ) {
									?>
									<<?php echo $this->get_settings( 'crafto_process_step_title_size' ); // phpcs:ignore ?> class="process-step-title">
										<?php echo esc_html( $item['crafto_process_step_title'] ); ?>
									</<?php echo $this->get_settings( 'crafto_process_step_title_size' ); // phpcs:ignore ?>>
									<?php
								}
								if ( ! empty( $item['crafto_process_step_description'] ) ) {
									?>
									<div class="process-step-content">
										<?php echo sprintf( '%s', wp_kses_post( $item['crafto_process_step_description'] ) ); // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-7':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<div class="process-step-item-box">
									<?php
									if ( ! empty( $settings['crafto_process_step_right_icon']['value'] ) ) {
										?>
										<span class="progress-right-icon">
											<?php
											$icon      = '';
											$migrated7 = isset( $settings['__fa4_migrated']['crafto_process_step_right_icon'] );
											$is_new7   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
											if ( $is_new7 || $migrated7 ) {
												ob_start();
												Icons_Manager::render_icon( $settings['crafto_process_step_right_icon'], [ 'aria-hidden' => 'true' ] );
												$icon .= ob_get_clean();
											} elseif ( isset( $settings['crafto_process_step_right_icon']['value'] ) && ! empty( $settings['crafto_process_step_right_icon']['value'] ) ) {
												$icon .= '<i class="' . esc_attr( $settings['crafto_process_step_right_icon']['value'] ) . '" aria-hidden="true"></i>';
											}
											echo sprintf( '%s', $icon ); // phpcs:ignore 
											?>
										</span>
										<?php
									}
									if ( ! empty( $process_number ) ) {
										?>
										<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
											<span class="process-step-number-bfr process-step-number">
												<?php echo esc_html( $process_number ); ?>
											</span>
											<div class="process-step-number-afr"></div>
										</div>
										<?php
									}
									?>
								</div>
								<?php
									$this->render_process_content_block( $item );
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-8':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<div class="process-step-item-box">
									<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
										<span class="process-step-number-bfr process-step-number">
											<?php echo esc_html( $process_number ); ?>
										</span>
										<?php
										if ( 'yes' === $crafto_display_separator ) {
											?>
											<span class="process-step-item-box-bfr process-step-separator"></span>
											<?php
										}
										?>
									</div>
								</div>
								<?php
									$this->render_process_content_block( $item );
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-9':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							?>
							<div class="process-step-item">
								<?php
									$this->render_icon_box( $item );
									$this->render_process_content_block( $item );
								?>
							</div>
							<?php
						}
						break;
					case 'process-step-style-10':
						foreach ( $settings['crafto_process_step'] as $index => $item ) {
							if ( 'yes' === $crafto_enable_process_number_prefix ) {
								$process_number = sprintf( '%02d', ++$index );
							} else {
								$process_number = ++$index;
							}
							?>
							<div class="process-step-item">
								<div <?php $this->print_render_attribute_string( 'process_step_number' ); ?>>
									<span class="process-step-number">
										<?php echo esc_html( $process_number ); ?>
									</span>
								</div>
								<?php $this->render_process_content_block( $item ); ?>
							</div>
							<?php
						}
						break;
				}
				?>
			</div>
			<?php
		}
		/**
		 * Render Process Content block.
		 *
		 * @access protected
		 * @param mixed $item The item to render the icon for.
		 */
		protected function render_process_content_block( $item ) {
			if ( ! empty( $item['crafto_process_step_title'] ) || ! empty( $item['crafto_process_step_description'] ) ) {
				?>
				<div class="process-content">
					<?php
					if ( ! empty( $item['crafto_process_step_title'] ) ) {
						?>
						<<?php echo $this->get_settings( 'crafto_process_step_title_size' ); // phpcs:ignore ?> class="process-step-title">
							<?php echo esc_html( $item['crafto_process_step_title'] ); ?>
						</<?php echo $this->get_settings( 'crafto_process_step_title_size' ); // phpcs:ignore ?>>
						<?php
					}

					if ( ! empty( $item['crafto_process_step_description'] ) ) {
						?>
						<div class="process-step-content">
							<?php echo sprintf( '%s', wp_kses_post( $item['crafto_process_step_description'] ) ); // phpcs:ignore?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
		}
		/**
		 * Render icon for process steps.
		 *
		 * @access protected
		 * @param mixed $item The item to render the icon for.
		 */
		protected function render_icon_box( $item ) {
			$icon                      = '';
			$settings                  = $this->get_settings_for_display();
			$migrated                  = isset( $item['__fa4_migrated']['crafto_process_step_icon'] );
			$is_new                    = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_process_step_style = ( isset( $settings['crafto_process_step_style'] ) && $settings['crafto_process_step_style'] ) ? $settings['crafto_process_step_style'] : '';

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $item['crafto_process_step_icon'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $item['crafto_process_step_icon']['value'] ) && ! empty( $item['crafto_process_step_icon']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $item['crafto_process_step_icon']['value'] ) . '" aria-hidden="true"></i>';
			}
			if ( ! empty( $icon ) ) {
				if ( 'process-step-style-5' === $crafto_process_step_style ) {
					?>
					<div class="box-overlay"></div>
					<span class="number"><?php echo sprintf( '%s', $icon ); // phpcs:ignore ?></span>
					<?php
				} else {
					?>
					<div class="process-step-icon-box">
						<div class="process-step-icon">
							<?php printf( '%s', $icon ); // phpcs:ignore ?>
						</div>
					</div>
					<?php
				}
			}
		}
	}
}
