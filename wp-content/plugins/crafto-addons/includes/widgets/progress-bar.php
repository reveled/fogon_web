<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for progress bar.
 *
 * @package Crafto
 */

// If class `Progress_Bar` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Progress_Bar' ) ) {
	/**
	 * Define `Progress_Bar` class.
	 */
	class Progress_Bar extends Widget_Base {
		/**
		 * Retrieve the list of scripts the  progress bar widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-progress-bar-widget' ];
			}
		}
		/**
		 * Retrieve the list of styles the  progress bar widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$progress_bar_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$progress_bar_styles[] = 'crafto-widgets-rtl';
				} else {
					$progress_bar_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$progress_bar_styles[] = 'crafto-progress-bar-rtl-widget';
				}
				$progress_bar_styles[] = 'crafto-progress-bar-widget';
			}
			return $progress_bar_styles;
		}
		/**
		 * Get widget name.
		 *
		 * Retrieve progress bar widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-progress-bar';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve progress bar widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Progress Bar', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve progress bar widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-skill-bar crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/progress-bar/';
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
				'progress',
				'bar',
				'skill',
				'goal bar',
				'progress widget',
			];
		}

		/**
		 * Register progress widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_progress_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_progress_styles',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'progress-style-1',
					'options' => [
						'progress-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'progress-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_progress',
				[
					'label' => esc_html__( 'Progress Bar', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_inner_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'e.g. Web Designer', 'crafto-addons' ),
					'default'     => esc_html__( 'Web Designer', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_display_percentage',
				[
					'label'        => esc_html__( 'Disable percentage', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_progress_percent',
				[
					'label'       => esc_html__( 'Percentage', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'%',
					],
					'default'     => [
						'size' => 50,
						'unit' => '%',
					],
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_position_percentage',
				[
					'label'     => esc_html__( 'Position Percentage', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'default' => [
							'title' => esc_html__( 'Default', 'crafto-addons' ),
						],
						'fixed'   => [
							'title' => esc_html__( 'Fixed', 'crafto-addons' ),
						],
					],
					'default'   => 'default',
					'condition' => [
						'crafto_display_percentage' => '',
						'crafto_progress_styles'    => [
							'progress-style-1',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_progress_style',
				[
					'label' => esc_html__( 'Progress Bar', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->start_controls_tabs( 'crafto_progress_bar_color_tabs' );
				$this->start_controls_tab(
					'crafto_progress_bar_skill_color_tab',
					[
						'label' => esc_html__( 'Bar Color', 'crafto-addons' ),
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'     => 'crafto_bar_color',
						'exclude'  => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector' => '{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-bar',
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_progress_bar_bg_color_tab',
					[
						'label' => esc_html__( 'Background', 'crafto-addons' ),
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'     => 'crafto_bar_bg_color',
						'exclude'  => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector' => '{{WRAPPER}} .elementor-progress-wrapper, {{WRAPPER}} .progress-style-2 .progress-inner',
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_bar_thickness',
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
							'max' => 100,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-progress-bar'  => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .crafto-progress-wrapper' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .progress-style-2 .progress-inner, {{WRAPPER}} .progress-style-2 .progress-inner .elementor-progress-bar' => 'height: {{SIZE}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_control(
				'crafto_bar_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-progress-bar, {{WRAPPER}} .progress-style-2 .progress-inner .elementor-progress-bar'  => 'border-radius: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .crafto-progress-wrapper, {{WRAPPER}} .progress-style-2 .progress-inner' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'default'    => [
						'unit' => 'px',
						'size' => 0,
					],
				]
			);
			$this->add_control(
				'crafto_percentage_text_heading',
				[
					'label'     => esc_html__( 'Percentage', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_display_percentage' => '',
					],
				]
			);
			$this->add_control(
				'crafto_percentage_bg_color',
				[
					'label'     => esc_html__( 'Background', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-percentage' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-progress-wrapper:not(.progress-style-2) .elementor-progress-bar .elementor-progress-percentage:after' => 'border-top-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_progress_styles' => [
							'progress-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_bar_percentage_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'exclude'   => [
						'line_height',
					],
					'condition' => [
						'crafto_display_percentage' => '',
					],
					'selector'  => '{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-percentage',
				]
			);
			$this->add_control(
				'crafto_bar_percentage_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-percentage' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_display_percentage' => '',
					],
				]
			);
			$this->add_control(
				'crafto_progess_bar_spacing',
				[
					'label'     => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-progress-wrapper:not(.progress-style-2) .elementor-progress-bar .elementor-progress-percentage' => 'bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_display_percentage' => '',
						'crafto_progress_styles'    => [
							'progress-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_progress_bar_padding',
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
						'{{WRAPPER}} .elementor-progress-wrapper .elementor-progress-percentage' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_display_percentage' => '',
						'crafto_progress_styles'    => [
							'progress-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_progress_bar_margin',
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
					'separator'  => 'before',
					'selectors'  => [
						'{{WRAPPER}} .crafto-progress-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_title_style_section',
				[
					'label' => esc_html__( 'Label', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'selector' => '{{WRAPPER}} .elementor-progress-text',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-progress-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_progess_bar_label_spacing',
				[
					'label'     => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-progress-wrapper:not(.progress-style-2) .elementor-progress-text' => 'bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_progress_styles' => [
							'progress-style-1',
						],
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render progress bar widget output on the frontend.
		 * Make sure value does no exceed 100%.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                   = $this->get_settings_for_display();
			$progress_styles            = ( isset( $settings['crafto_progress_styles'] ) && $settings['crafto_progress_styles'] ) ? $settings['crafto_progress_styles'] : 'progress-style-1';
			$progress_percentage        = is_numeric( $settings['crafto_progress_percent']['size'] ) ? $settings['crafto_progress_percent']['size'] : '0';
			$crafto_inner_text          = ( isset( $settings['crafto_inner_text'] ) && $settings['crafto_inner_text'] ) ? $settings['crafto_inner_text'] : '';
			$crafto_position_percentage = ( isset( $settings['crafto_position_percentage'] ) && $settings['crafto_position_percentage'] ) ? $settings['crafto_position_percentage'] : '';

			if ( 100 < $progress_percentage ) {
				$progress_percentage = 100;
			}

			$this->add_render_attribute(
				'wrapper',
				[
					'class'          => [
						'elementor-progress-wrapper',
						'crafto-progress-wrapper',
						$crafto_position_percentage,
						$progress_styles,
					],
					'role'           => 'progressbar',
					'aria-valuemin'  => '0',
					'aria-valuemax'  => '100',
					'aria-valuenow'  => $progress_percentage,
					'aria-valuetext' => $crafto_inner_text,
					'aria-label'     => $crafto_inner_text,
				]
			);

			$this->add_render_attribute(
				'progress-bar',
				[
					'class'    => 'elementor-progress-bar',
					'data-max' => $progress_percentage,
				]
			);

			$this->add_render_attribute(
				'crafto_inner_text',
				[
					'class' => 'elementor-progress-text',
				]
			);

			$this->add_inline_editing_attributes( 'crafto_inner_text' );

			switch ( $progress_styles ) {
				case 'progress-style-1':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'progress-bar' ); ?>>
							<?php
							if ( ! empty( $crafto_inner_text ) ) {
								?>
								<span <?php $this->print_render_attribute_string( 'crafto_inner_text' ); ?>>
									<?php echo esc_html( $crafto_inner_text ); ?>
								</span>
								<?php
							}
							if ( 'yes' !== $this->get_settings( 'crafto_display_percentage' ) ) {
								?>
								<span class="elementor-progress-percentage">
									<?php echo esc_html( $progress_percentage ) . esc_html__( '%', 'crafto-addons' ); ?>
								</span>
								<?php
							}
							?>
						</div>
					</div>
					<?php
					break;
				case 'progress-style-2':
					?>
					<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div class="progress-inner">
							<div <?php $this->print_render_attribute_string( 'progress-bar' ); ?>>
								<?php
								if ( 'yes' !== $this->get_settings( 'crafto_display_percentage' ) ) {
									?>
									<span class="elementor-progress-percentage">
										<?php echo esc_html( $progress_percentage ) . esc_html__( '%', 'crafto-addons' ); ?>
									</span>
									<?php
								}
								?>
							</div>
							<?php
							if ( ! empty( $crafto_inner_text ) ) {
								?>
								<span <?php $this->print_render_attribute_string( 'crafto_inner_text' ); ?>>
									<?php echo esc_html( $crafto_inner_text ); ?>
								</span>
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
