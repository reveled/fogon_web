<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

/**
 *
 * Crafto widget for table.
 *
 * @package Crafto
 */

// If class `Table` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Table' ) ) {
	/**
	 * Define `Table` class.
	 */
	class Table extends Widget_Base {
		/**
		 * Retrieve the list of styles the table widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$table_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$table_styles[] = 'crafto-widgets-rtl';
				} else {
					$table_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$table_styles[] = 'crafto-table-rtl-widget';
				}
				$table_styles[] = 'crafto-table-widget';
			}
			return $table_styles;
		}
		/**
		 * Get widget name.
		 *
		 * Retrieve table widget name.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-table';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve table widget title.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Table', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve table widget icon.
		 *
		 * @since 1.0.0
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-table crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/table/';
		}
		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the table widget belongs to.
		 *
		 * @since 1.0.0
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
				'data table',
				'html table',
				'info table',
				'schedule table',
			];
		}

		/**
		 * Register widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function register_controls() {
			/* Table Header Start */
			$this->start_controls_section(
				'crafto_content_table_header',
				[
					'label' => esc_html__( 'Table Header', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);

			$repeater_header = new Repeater();

			$repeater_header->add_control(
				'crafto_text',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'placeholder' => esc_html__( 'Table header', 'crafto-addons' ),
					'default'     => esc_html__( 'Table header', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$repeater_header->add_control(
				'crafto_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'              => [
						'left'   =>
						[
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' =>
						[
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  =>
						[
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end'   : 'right',
					],
					'default'              => '',
					'selectors' => [
						'{{WRAPPER}} .crafto-table-header {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_table_header',
				[
					'label'       => esc_html__( 'Table Header Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater_header->get_controls(),
					'default'     => [
						[
							'crafto_text' => esc_html__( 'Table Header', 'crafto-addons' ),
						],
						[
							'crafto_text' => esc_html__( 'Table Header', 'crafto-addons' ),
						],
						[
							'crafto_text' => esc_html__( 'Table Header', 'crafto-addons' ),
						],
						[
							'crafto_text' => esc_html__( 'Table Header', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_text }}}',
				]
			);

			$this->end_controls_section();

			/* Table Body Start */
			$this->start_controls_section(
				'crafto_content_table_body',
				[
					'label' => esc_html__( 'Table Body', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);

			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_text',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'label_block' => true,
					'default'     => esc_html__( 'Table Data', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Table Data', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$repeater->add_control(
				'crafto_description',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_body_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'              => [
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
					'default'              => '',
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end'   : 'right',
					],
					'selectors'            => [
						'{{WRAPPER}} .crafto-table-body {{CURRENT_ITEM}} .inner-box' => 'text-align: {{VALUE}};',
					],
				],
			);
			$repeater->add_control(
				'crafto_tooltip',
				[
					'label'        => esc_html__( 'Enable Tooltip', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$repeater->add_control(
				'crafto_tooltip_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'default'     => esc_html__( 'Tooltip Title', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'crafto_tooltip' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_tooltip_subtitle',
				[
					'label'       => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'crafto_tooltip' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_tooltip_description',
				[
					'label'       => esc_html__( 'Description', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXTAREA,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_tooltip' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_tooltip_button_text',
				[
					'label'       => esc_html__( 'Button', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Click Here', 'crafto-addons' ),
					'condition'   => [
						'crafto_tooltip' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_tooltip_button_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => '#',
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'condition'   => [
						'crafto_tooltip' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_tooltip_up',
				[
					'label'        => esc_html__( 'Enable Tooltip Open in the Top', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_tooltip' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_tooltip_left',
				[
					'label'        => esc_html__( 'Enable Tooltip Open in the Left', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_tooltip' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_body_title_style',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$repeater->start_controls_tabs(
				'crafto_table_body_title_style'
			);
			$repeater->start_controls_tab(
				'crafto_table_body_title_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_table_body_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body {{CURRENT_ITEM}}.crafto-time-table-box .title ' => 'color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_table_body_title_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_body_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body {{CURRENT_ITEM}}.crafto-time-table-box:hover .title' => 'color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$repeater->add_control(
				'crafto_body_description_style',
				[
					'label' => esc_html__( 'Description', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$repeater->start_controls_tabs(
				'crafto_table_body_description_style'
			);
			$repeater->start_controls_tab(
				'crafto_table_description_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_table_body_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body {{CURRENT_ITEM}}.crafto-time-table-box .description' => 'color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_table_body_description_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_table_body_description_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body {{CURRENT_ITEM}}.crafto-time-table-box:hover .description' => 'color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$repeater->add_control(
				'crafto_body_background_style',
				[
					'label' => esc_html__( 'Background', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$repeater->start_controls_tabs(
				'crafto_table_body_background_style'
			);
			$repeater->start_controls_tab(
				'crafto_table_body_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$repeater->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_body_background_normal',
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
					'selector' => '{{WRAPPER}} .crafto-table-body {{CURRENT_ITEM}}.crafto-time-table-box',
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_table_body_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$repeater->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_table_body_background_hover',
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
					'selector' => '{{WRAPPER}} .crafto-table-body {{CURRENT_ITEM}}.crafto-time-table-box:hover:before',
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'crafto_table_body',
				[
					'label'       => esc_html__( 'Table Body Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_text' => esc_html__( 'Body Content', 'crafto-addons' ),
						],
						[
							'crafto_text' => esc_html__( 'Body Content', 'crafto-addons' ),
						],
						[
							'crafto_text' => esc_html__( 'Body Content', 'crafto-addons' ),
						],
						[
							'crafto_text' => esc_html__( 'Body Content', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_text }}}',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'label'    => esc_html__( 'Border', 'crafto-addons' ),
					'name'     => 'crafto_table_border',
					'selector' => '{{WRAPPER}} .crafto-time-table-box',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_table_header_style',
				[
					'label' => esc_html__( 'Table Header', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'crafto_header_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'              => [
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
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end'   : 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-table-header .crafto-time-table-box' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'    => esc_html__( 'Typography', 'crafto-addons' ),
					'name'     => 'crafto_header_typography',
					'selector' => '{{WRAPPER}} .crafto-table-header',
				]
			);
			$this->add_control(
				'crafto_header_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-header .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_header_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-header .crafto-time-table-box' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_header_padding',
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
						'{{WRAPPER}} .crafto-table-header .crafto-time-table-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_table_body_style',
				[
					'label' => esc_html__( 'Table Body', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'crafto_body_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'              => [
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
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body .crafto-time-table-box' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_body_padding',
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
						'{{WRAPPER}} .crafto-table-body .crafto-time-table-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->start_controls_tabs(
				'crafto_table_blocks_style'
			);
			$this->start_controls_tab(
				'crafto_table_blocks_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'background',
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
					'selector' => '{{WRAPPER}} .crafto-table-body .crafto-time-table-box',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_table_blocks_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_table_blocks_box_background',
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
					'selector' => '{{WRAPPER}} .crafto-table-body .crafto-time-table-box:hover:before',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_title_style_heading',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'selector' => '{{WRAPPER}} .crafto-table-body .title',
				]
			);
			$this->start_controls_tabs(
				'crafto_table_title_blocks_style'
			);
			$this->start_controls_tab(
				'crafto_table_title_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_body_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_table_title_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_body_text_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body .crafto-time-table-box + .crafto-time-table-box:hover .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_description_style_heading',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_description_typography',
					'selector' => '{{WRAPPER}} .crafto-table-body .description',
				]
			);
			$this->start_controls_tabs(
				'crafto_table_description_blocks_style'
			);
			$this->start_controls_tab(
				'crafto_table_description_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_body_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body .description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_table_description_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_body_description_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-table-body .crafto-time-table-box + .crafto-time-table-box:hover .description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_tooltip_body_style',
				[
					'label' => esc_html__( 'Tooltip', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_tooltip_style_text_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'left',
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
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end' : 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .tooltip-detail' => 'text-align: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_tooltip_style_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tooltip-detail' => 'background-color: {{VALUE}}',
						'{{WRAPPER}} .tooltip-detail::after' => 'border-bottom-color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tooltip_style_width',
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
							'max' => 500,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .tooltip-detail' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tooltip_style_general_padding',
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
						'{{WRAPPER}} .tooltip-detail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_tooltip_style_shadow',
					'selector' => '{{WRAPPER}} .tooltip-detail, {{WRAPPER}} .tooltip-detail',
				]
			);
			$this->add_control(
				'crafto_tooltip_style_heading',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tooltip_title_typography',
					'selector' => '{{WRAPPER}} .tooltip-detail .tooltip-title',
				]
			);
			$this->add_control(
				'crafto_tooltip_body_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'separator' => 'after',
					'selectors' => [
						'{{WRAPPER}} .tooltip-detail .tooltip-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_tooltip_style_subtitle',
				[
					'label' => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tooltip_subtitle_typography',
					'selector' => '{{WRAPPER}} .tooltip-detail .tooltip-subtitle',
				]
			);
			$this->add_control(
				'crafto_tooltip_body_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tooltip-detail .tooltip-subtitle' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tooltip_body_subtitle_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'separator'  => 'after',
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .tooltip-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				],
			);
			$this->add_control(
				'crafto_tooltip_style_description',
				[
					'label' => esc_html__( 'Description', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tooltip_description_typography',
					'selector' => '{{WRAPPER}} .tooltip-detail .tooltip-description',
				]
			);
			$this->add_control(
				'crafto_tooltip_body_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tooltip-detail .tooltip-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tooltip_body_description_margin',
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
						'{{WRAPPER}} .tooltip-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				],
			);
			$this->add_control(
				'crafto_tooltip_style_button',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tooltip_button_typography',
					'selector' => '{{WRAPPER}} .tooltip-detail .tooltip-button',
				]
			);
			$this->add_control(
				'crafto_tooltip_body_button_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tooltip-detail .tooltip-button' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_tooltip_border',
					'selector' => '{{WRAPPER}} .tooltip-detail .tooltip-button, {{WRAPPER}} .tooltip-detail .tooltip-button',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function render() {

			$settings = $this->get_settings_for_display();
			?>
			<div class="crafto-time-schedule-scroll">
				<?php
				if ( is_array( $settings['crafto_table_header'] ) && ! empty( $settings['crafto_table_header'] ) ) {
					?>
					<div class="crafto-time-table crafto-table-header">
						<?php
						$header_count = count( $settings['crafto_table_header'] );
						foreach ( $settings['crafto_table_header'] as $index => $item ) {

							$title = isset( $item['crafto_text'] ) && ! empty( $item['crafto_text'] ) ? $item['crafto_text'] : '';

							$repeater_setting_key = $this->get_repeater_setting_key( 'crafto_text', 'crafto_table_header', $index );
							$this->add_inline_editing_attributes( $repeater_setting_key );
							$this->add_render_attribute(
								[
									$repeater_setting_key => [
										'class' => [
											'elementor-inline-editing',
											'elementor-repeater-item-' . $item['_id'],
											'inner-box',
										],
									],
								],
							);

							if ( ! empty( $title ) ) {
								?>
								<div class="crafto-time-table-box">
									<div <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>>
										<span class="title"><?php echo esc_html( $title ); ?></span>
									</div>
								</div>
								<?php
							}
						}
						?>
					</div>
					<?php
				}
				if ( is_array( $settings['crafto_table_body'] ) && ! empty( $settings['crafto_table_body'] ) ) {
					?>
					<div class="crafto-time-table crafto-table-body">
						<?php
						$j = 0;
						foreach ( $settings['crafto_table_body'] as $index => $item ) {
							$title               = isset( $item['crafto_text'] ) && ! empty( $item['crafto_text'] ) ? $item['crafto_text'] : '';
							$description         = isset( $item['crafto_description'] ) && ! empty( $item['crafto_description'] ) ? $item['crafto_description'] : '';
							$tooltip_title       = isset( $item['crafto_tooltip_title'] ) && ! empty( $item['crafto_tooltip_title'] ) ? $item['crafto_tooltip_title'] : '';
							$tooltip_subtitle    = isset( $item['crafto_tooltip_subtitle'] ) && ! empty( $item['crafto_tooltip_subtitle'] ) ? $item['crafto_tooltip_subtitle'] : '';
							$tooltip_description = isset( $item['crafto_tooltip_description'] ) && ! empty( $item['crafto_tooltip_description'] ) ? $item['crafto_tooltip_description'] : '';
							$link_key            = 'link_' . $index;
							$tooltip_key         = 'tooltip_' . $index;

							$table_body_key = $this->get_repeater_setting_key( 'crafto_text', 'crafto_table_body', $index );
							$this->add_render_attribute(
								[
									$table_body_key => [
										'class' => [
											'elementor-repeater-item-' . $item['_id'],
											'crafto-time-table-box',
										],
									],
								],
							);
							$this->add_render_attribute(
								[
									$tooltip_key => [
										'class' => [
											'tooltip-detail',
										],
									],
								],
							);

							if ( 'yes' === $item['crafto_tooltip_up'] ) {
								$this->add_render_attribute( $tooltip_key, 'class', 'tooltip-up' );
							}
							if ( 'yes' === $item['crafto_tooltip_left'] ) {
								$this->add_render_attribute( $tooltip_key, 'class', 'tooltip-left' );
							}

							if ( ! empty( $item['crafto_tooltip_button_link']['url'] ) ) {
								$this->add_link_attributes( $link_key, $item['crafto_tooltip_button_link'] );
								$this->add_render_attribute( $link_key, 'class', 'tooltip-button' );
							}

							$this->add_render_attribute( $link_key, 'role', 'button' );

							if ( $header_count === $j ) {
								?>
								</div>
								<div class="crafto-time-table crafto-table-body">
								<?php
							}
							?>
							<div <?php $this->print_render_attribute_string( $table_body_key ); ?>>
								<div class="inner-box">
									<?php
									if ( ! empty( $title ) ) {
										?>
										<span class="title"><?php echo esc_html( $title ); ?></span>
										<?php
									}
									if ( ! empty( $description ) ) {
										?>
										<div class="description"><?php echo esc_html( $description ); ?></div>
										<?php
									}
									?>
								</div>
								<?php
								if ( ! empty( $tooltip_title ) || ! empty( $tooltip_subtitle ) || ! empty( $tooltip_description ) || $item['crafto_tooltip_button_text'] ) {
									?>
									<div <?php $this->print_render_attribute_string( $tooltip_key ); ?>>
										<div class="tooltip-detail-inner">
											<?php
											if ( ! empty( $tooltip_title ) ) {
												?>
												<span class="tooltip-title"><?php echo esc_html( $tooltip_title ); ?></span>
												<?php
											}
											if ( ! empty( $tooltip_subtitle ) ) {
												?>
												<span class="tooltip-subtitle"><?php echo esc_html( $tooltip_subtitle ); ?></span>
												<?php
											}
											if ( ! empty( $tooltip_description ) ) {
												?>
												<p class="tooltip-description"><?php echo esc_html( $tooltip_description ); ?></p>
												<?php
											}
											if ( $item['crafto_tooltip_button_text'] ) {
												?>
												<a <?php $this->print_render_attribute_string( $link_key ); ?>>				
													<?php echo esc_html( $item['crafto_tooltip_button_text'] ); ?>
												</a>
												<?php
											}
											?>
										</div>
									</div>
									<?php
								}
								?>
							</div>
							<?php
							if ( $header_count === $j ) {
								$j = 0;
							}
							++$j;
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
