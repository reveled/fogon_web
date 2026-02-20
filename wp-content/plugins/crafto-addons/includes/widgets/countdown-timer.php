<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for countdown timer.
 *
 * @package Crafto
 */

// If class `Countdown_Timer` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Countdown_Timer' ) ) {
	/**
	 * Define `Countdown_Timer` class.
	 */
	class Countdown_Timer extends Widget_Base {
		/**
		 * Retrieve the list of scripts the countdown timer widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$countdown_timer_scripts   = [];
			$countdown_timer_scripts[] = 'wp-util';

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				if ( crafto_disable_module_by_key( 'jquery-countdown' ) ) {
					$countdown_timer_scripts[] = 'jquery-countdown';
				}
				$countdown_timer_scripts[] = 'crafto-countdown-widget';

				return $countdown_timer_scripts;
			}
		}

		/**
		 * Retrieve the list of styles the countdown timer widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$countdown_timer_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$countdown_timer_styles[] = 'crafto-widgets-rtl';
				} else {
					$countdown_timer_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$countdown_timer_styles[] = 'crafto-countdown-widget-rtl';
				}
				$countdown_timer_styles[] = 'crafto-countdown-widget';
			}
			return $countdown_timer_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-countdown';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Countdown Timer', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-countdown crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/countdown-timer/';
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
				'count',
				'number',
				'coming soon',
				'sale',
				'launch',
			];
		}

		/**
		 * Register countdown timer widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_countdown_general_section',
				[
					'label' => esc_html__( 'Countdown', 'crafto-addons' ),
				]
			);

			$default_date = gmdate(
				'Y-m-d',
				strtotime( '+1 month' ) + ( (int) get_option( 'gmt_offset' ) * HOUR_IN_SECONDS )
			);

			$this->add_control(
				'crafto_due_date',
				[
					'label'          => esc_html__( 'Due Date', 'crafto-addons' ),
					'type'           => Controls_Manager::DATE_TIME,
					'dynamic'        => [
						'active' => true,
					],
					'default'        => $default_date,
					'picker_options' => [
						'enableTime' => false,
					],
				]
			);
			$this->add_control(
				'crafto_countdown_show_separator',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'yes'          => esc_html__( 'Yes', 'crafto-addons' ),
					'no'           => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				],
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_countdown_settings_section',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);

			$this->start_controls_tabs(
				'crafto_countdown_tabs'
			);
			$this->start_controls_tab(
				'crafto_countdown_day_tab',
				[
					'label' => esc_html__( 'Days', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_countdown_day_show',
				[
					'label'        => esc_html__( 'Enable Days', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_countdown_day_label',
				[
					'label'     => esc_html__( 'Days Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Days', 'crafto-addons' ),
					'condition' => [
						'crafto_countdown_day_show' => 'yes',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_countdown_hours_tab',
				[
					'label' => esc_html__( 'Hours', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_countdown_hours_show',
				[
					'label'        => esc_html__( 'Enable Hours', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_countdown_hours_label',
				[
					'label'     => esc_html__( 'Hours Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Hours', 'crafto-addons' ),
					'condition' => [
						'crafto_countdown_hours_show' => 'yes',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_countdown_minutes_tab',
				[
					'label' => esc_html__( 'Minutes', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_countdown_minutes_show',
				[
					'label'        => esc_html__( 'Enable Minutes', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_countdown_minutes_label',
				[
					'label'     => esc_html__( 'Minutes Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Minutes', 'crafto-addons' ),
					'condition' => [
						'crafto_countdown_minutes_show' => 'yes',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_countdown_seconds_tab',
				[
					'label' => esc_html__( 'Seconds', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_countdown_seconds_show',
				[
					'label'        => esc_html__( 'Enable Seconds', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_countdown_seconds_label',
				[
					'label'     => esc_html__( 'Seconds Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Seconds', 'crafto-addons' ),
					'condition' => [
						'crafto_countdown_seconds_show' => 'yes',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_countdown_general_style_section',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_control(
				'crafto_countdown_items_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				array(
					'name'     => 'crafto_countdown_items_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-countdown-wrapper .counter-box',
				)
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_countdown_items_border',
					'selector' => '{{WRAPPER}} .elementor-countdown-wrapper .counter-box',
				]
			);
			$this->add_control(
				'crafto_countdown_items_border_radius',
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
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_countdown_items_width',
				[
					'label'      => esc_html__( 'Shape Width', 'crafto-addons' ),
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
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_countdown_items_min_height',
				[
					'label'      => esc_html__( 'Shape Height', 'crafto-addons' ),
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
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box' => 'min-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_countdown_items_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_countdown_digits_style_section',
				[
					'label'      => esc_html__( 'Digits', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_countdown_digits_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .elementor-countdown-wrapper .counter-box .number',
				]
			);
			$this->add_control(
				'crafto_countdown_digits_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box .number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_countdown_digits_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box .number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_countdown_digits_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box .number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_countdown_labels_style_section',
				[
					'label'      => esc_html__( 'Labels', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_control(
				'crafto_countdown_labels_positions',
				[
					'label'        => esc_html__( 'Positions', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'top'    => esc_html__( 'Top', 'crafto-addons' ),
						'bottom' => esc_html__( 'Bottom', 'crafto-addons' ),
					],
					'default'      => 'bottom',
					'prefix_class' => 'elementor-label-',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_countdown_labels_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .elementor-countdown-wrapper .counter-box span',
				]
			);
			$this->add_control(
				'crafto_countdown_labels_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box span' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_countdown_labels_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_countdown_labels_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_countdown_separator_style_section',
				[
					'label'      => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_countdown_show_separator' => 'yes',
					],
				]
			);

			$this->add_control(
				'crafto_countdown_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-countdown-wrapper .number:after' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_countdown_show_separator' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_countdown_separator_thickness',
				[
					'label'     => esc_html__( 'Separator Thickness', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 60,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-countdown-wrapper .counter-box .number:after' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_countdown_show_separator' => 'yes',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render countdown timer widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                        = $this->get_settings_for_display();
			$countdown_styles                = ( isset( $settings['crafto_countdown_styles'] ) && $settings['crafto_countdown_styles'] ) ? $settings['crafto_countdown_styles'] : 'countdown-style-1';
			$due_date                        = ( isset( $settings['crafto_due_date'] ) && $settings['crafto_due_date'] ) ? $settings['crafto_due_date'] : '';
			$crafto_countdown_show_separator = ( isset( $settings['crafto_countdown_show_separator'] ) && $settings['crafto_countdown_show_separator'] ) ? '':'hide-separator'; // phpcs:ignore
			$day_label                       = ( isset( $settings['crafto_countdown_day_label'] ) && $settings['crafto_countdown_day_label'] ) ? $settings['crafto_countdown_day_label'] : esc_html__( 'Days', 'crafto-addons' );
			$hours_label                     = ( isset( $settings['crafto_countdown_hours_label'] ) && $settings['crafto_countdown_hours_label'] ) ? $settings['crafto_countdown_hours_label'] : esc_html__( 'Hours', 'crafto-addons' );
			$minutes_label                   = ( isset( $settings['crafto_countdown_minutes_label'] ) && $settings['crafto_countdown_minutes_label'] ) ? $settings['crafto_countdown_minutes_label'] : esc_html__( 'Minutes', 'crafto-addons' );
			$seconds_label                   = ( isset( $settings['crafto_countdown_seconds_label'] ) && $settings['crafto_countdown_seconds_label'] ) ? $settings['crafto_countdown_seconds_label'] : esc_html__( 'Seconds', 'crafto-addons' );

			$data_settings = [
				'day_show'      => $this->get_settings( 'crafto_countdown_day_show' ),
				'minutes_show'  => $this->get_settings( 'crafto_countdown_minutes_show' ),
				'hours_show'    => $this->get_settings( 'crafto_countdown_hours_show' ),
				'seconds_show'  => $this->get_settings( 'crafto_countdown_seconds_show' ),
				'day_label'     => $day_label,
				'hours_label'   => $hours_label,
				'minutes_label' => $minutes_label,
				'seconds_label' => $seconds_label,
			];

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class'           => [
							'elementor-countdown-wrapper',
							'countdown',
						],
						'data-enddate'    => $due_date,
						'data-today-date' => gmdate( 'Y-m-d' ),
						'data-settings'   => wp_json_encode( $data_settings ),
					],
				]
			);

			switch ( $countdown_styles ) {
				case 'countdown-style-1':
					$this->add_render_attribute(
						[
							'wrapper' => [
								'class' => [
									'counter-box-1',
									$crafto_countdown_show_separator,
								],
							],
						]
					);
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>></div>
					<?php
					break;
			}
		}
	}
}
