<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for pie chart.
 *
 * @package Crafto
 */

// If class `Pie_Chart` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Pie_Chart' ) ) {
	/**
	 * Define `Pie_Chart` class.
	 */
	class Pie_Chart extends Widget_Base {
		/**
		 * Retrieve the list of script the pie chart widget depended on.
		 *
		 * Used to set script dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget script dependencies.
		 */
		public function get_script_depends() {
			$pie_chart_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$pie_chart_scripts[] = 'crafto-widgets';
			} else {
				$pie_chart_scripts[] = 'crafto-pie-chart-widget';
			}
			return $pie_chart_scripts;
		}

		/**
		 * Retrieve the list of styles the pie chart widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-pie-chart-widget' ];
			}
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-pie-chart';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Pie Chart', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-loading crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/pie-chart/';
		}
		/**
		 * Retrieve the widget categories.
		 *
		 * @access public
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
		 * @return array Widget keywords.
		 */
		public function get_keywords() {
			return [
				'canvas',
				'figure',
				'graph',
				'stats',
				'analytics',
				'infographic',
				'circle chart',
				'data visualization',
			];
		}

		/**
		 * Register pie chart widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_pie_chart_content_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_pie_chart_title',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_pie_chart_title_size',
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
				'crafto_pie_chart_percent',
				[
					'label'   => esc_html__( 'Percentage', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 90,
					],
					'range'   => [
						'min' => 1,
						'max' => 100,
					],
				]
			);
			$this->add_control(
				'crafto_pie_chart_line_width',
				[
					'label'   => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 7,
					],
					'range'   => [
						'min' => 1,
						'max' => 20,
					],
				]
			);
			$this->add_control(
				'crafto_pie_chart_content',
				[
					'label'      => esc_html__( 'Content', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => true,
				]
			);
			$this->add_control(
				'crafto_pie_chart_inner_circle',
				[
					'label'        => esc_html__( 'Enable Inner Circle', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_pie_chart_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_align_position',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
						'start'  => [
							'title' => esc_html__( 'left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .pie-charts' => 'align-items: {{VALUE}}; text-align: {{VALUE}};',
						'{{WRAPPER}} .pie-charts .chart-text' => 'align-items: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_pie_chart_style',
				[
					'label' => esc_html__( 'Chart', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_pie_chart_track_color',
				[
					'label'   => esc_html__( 'Track Color', 'crafto-addons' ),
					'type'    => Controls_Manager::COLOR,
					'global'  => false,
					'default' => '#ededed',
				]
			);
			$this->add_control(
				'crafto_pie_chart_start_color',
				[
					'label'   => esc_html__( 'Start Color', 'crafto-addons' ),
					'type'    => Controls_Manager::COLOR,
					'global'  => false,
					'default' => '#5758D6',
				]
			);
			$this->add_control(
				'crafto_pie_chart_end_color',
				[
					'label'   => esc_html__( 'End Color', 'crafto-addons' ),
					'type'    => Controls_Manager::COLOR,
					'global'  => false,
					'default' => '#5758D6',
				]
			);
			$this->add_control(
				'crafto_pie_chart_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'unit' => 'px',
						'size' => 120,
					],
					'range'      => [
						'px' => [
							'min' => 100,
							'max' => 300,
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 50,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .chart-canvas' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_pie_chart_number_style_section',
				[
					'label' => esc_html__( 'Percent', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_pie_chart_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .chart-percent .percent',
				]
			);
			$this->add_control(
				'crafto_pie_chart_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .chart-percent .percent' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_pie_chart_inner_circle_style_section',
				[
					'label'     => esc_html__( 'Inner Circle', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_pie_chart_inner_circle' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_number_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 0,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .chart-percent .inner-circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_pie_chart_number_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .chart-percent .inner-circle',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_pie_chart_number_shadow',
					'selector' => '{{WRAPPER}} .chart-percent .inner-circle',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_pie_chart_number_border',
					'selector' => '{{WRAPPER}} .chart-percent .inner-circle',
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_number_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .chart-percent .inner-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_pie_chart_title_style_section',
				[
					'label' => esc_html__( 'Label', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_pie_chart_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .chart-text .chart-title',
				]
			);
			$this->add_control(
				'crafto_pie_chart_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .chart-text .chart-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_title_padding',
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
						'{{WRAPPER}} .chart-text .chart-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_title_margin',
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
						'{{WRAPPER}} .chart-text .chart-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_pie_chart_content_style_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_pie_chart_content_typography',
					'selector' => '{{WRAPPER}} .chart-text .chart-content',
				]
			);
			$this->add_control(
				'crafto_pie_chart_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .chart-text .chart-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_content_width',
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
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .chart-text .chart-content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_content_padding',
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
						'{{WRAPPER}} .chart-text .chart-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_pie_chart_content_margin',
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
						'{{WRAPPER}} .chart-text .chart-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render Pie Chart widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                     = $this->get_settings_for_display();
			$crafto_pie_chart_title       = $this->get_settings( 'crafto_pie_chart_title' );
			$crafto_pie_chart_content     = $this->get_settings( 'crafto_pie_chart_content' );
			$chart_size                   = ( $settings['crafto_pie_chart_size']['size'] ) ? $settings['crafto_pie_chart_size']['size'] : 180;
			$crafto_pie_chart_percent     = ( $settings['crafto_pie_chart_percent']['size'] ) ? $settings['crafto_pie_chart_percent']['size'] : 90;
			$crafto_pie_chart_line_width  = ( $settings['crafto_pie_chart_line_width']['size'] ) ? $settings['crafto_pie_chart_line_width']['size'] : 7;
			$crafto_pie_chart_track_color = ( $this->get_settings( 'crafto_pie_chart_track_color' ) ) ? $this->get_settings( 'crafto_pie_chart_track_color' ) : '#ededed';
			$crafto_pie_chart_start_color = ( $this->get_settings( 'crafto_pie_chart_start_color' ) ) ? $this->get_settings( 'crafto_pie_chart_start_color' ) : '#5758D6';
			$crafto_pie_chart_end_color   = ( $this->get_settings( 'crafto_pie_chart_end_color' ) ) ? $this->get_settings( 'crafto_pie_chart_end_color' ) : '#5758D6';

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'pie-chart',
				]
			);

			$this->add_render_attribute(
				[
					'chart-settings' => [
						'class'            => 'chart',
						'data-line-width'  => $crafto_pie_chart_line_width,
						'data-percent'     => $crafto_pie_chart_percent,
						'data-track-color' => $crafto_pie_chart_track_color,
						'data-start-color' => $crafto_pie_chart_start_color,
						'data-end-color'   => $crafto_pie_chart_end_color,
						'data-size'        => $chart_size,
					],
				]
			);

			if ( 'yes' === $settings['crafto_pie_chart_inner_circle'] ) {
				$this->add_render_attribute(
					'percent',
					'class',
					[
						'inner-circle',
					]
				);
			}
			$this->add_render_attribute(
				'percent',
				'class',
				[
					'percent',
				]
			);
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div class="pie-charts">
					<div class="chart-canvas-inner">
						<div class="chart-canvas chart-percent">
							<span <?php $this->print_render_attribute_string( 'chart-settings' ); ?>>
								<span <?php $this->print_render_attribute_string( 'percent' ); ?>></span>
								<canvas height="180" width="180"></canvas>
							</span>
						</div>
					</div>
					<?php
					if ( ! empty( $crafto_pie_chart_title ) || ! empty( $crafto_pie_chart_content ) ) {
						?>
						<div class="chart-text">
							<?php
							if ( $crafto_pie_chart_title ) {
								?>
								<<?php echo $this->get_settings( 'crafto_pie_chart_title_size' ); // phpcs:ignore ?> class="chart-title">
									<?php $this->print_unescaped_setting( 'crafto_pie_chart_title' ); ?>
								</<?php echo $this->get_settings( 'crafto_pie_chart_title_size' ); // phpcs:ignore ?>>
								<?php
							}
							if ( $crafto_pie_chart_content ) {
								?>
								<div class="chart-content">
									<?php $this->print_text_editor( $settings['crafto_pie_chart_content'] ); ?>
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
			<?php
		}
	}
}
