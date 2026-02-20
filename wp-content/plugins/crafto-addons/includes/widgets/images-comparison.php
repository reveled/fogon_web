<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

/**
 * Crafto widget for image comparison.
 *
 * @package Crafto
 */

// If class `Images_Comparison` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Images_Comparison' ) ) {
	/**
	 * Define `Images_Comparison` class.
	 */
	class Images_Comparison extends Widget_Base {
		/**
		 * Retrieve the list of scripts the image comparison widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$images_comparison_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$images_comparison_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'image-compare-viewer' ) ) {
					$images_comparison_scripts[] = 'image-compare-viewer';
				}
				$images_comparison_scripts[] = 'crafto-images-comparison';
			}
			return $images_comparison_scripts;
		}

		/**
		 * Retrieve the list of styles the image comparison widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$images_comparison_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$images_comparison_styles[] = 'crafto-widgets-rtl';
				} else {
					$images_comparison_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'image-compare-viewer' ) ) {
					$images_comparison_styles[] = 'image-compare-viewer';
				}

				if ( is_rtl() ) {
					$images_comparison_styles[] = 'crafto-images-comparison-rtl';
				}
				$images_comparison_styles[] = 'crafto-images-comparison';
			}
			return $images_comparison_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-images-comparison';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Image Comparison', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-image crafto-element-icon';
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
				'photos',
				'visual',
				'comparison',
				'compare',
				'before',
				'after',
				'difference',
			];
		}

		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/image-comparison/';
		}

		/**
		 * Register image comparison widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_image_compare_title',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_before_image',
				[
					'label'       => esc_html__( 'Before Image', 'crafto-addons' ),
					'description' => esc_html__( 'Use same size image for before and after for better preview.', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'default'     => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_after_image',
				[
					'label'       => esc_html__( 'After Image', 'crafto-addons' ),
					'description' => esc_html__( 'Use same size image for before and after for better preview.', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'default'     => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'dynamic'     => [
						'active' => true,
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'exclude'   => [
						'custom',
					],
					'separator' => 'none',
				]
			);
			$this->add_control(
				'crafto_before_label',
				[
					'label'       => esc_html__( 'Before Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'Before Label', 'crafto-addons' ),
					'default'     => esc_html__( 'Before', 'crafto-addons' ),
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_after_label',
				[
					'label'       => esc_html__( 'After Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => esc_html__( 'After Label', 'crafto-addons' ),
					'default'     => esc_html__( 'After', 'crafto-addons' ),
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_content_settings',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_CONTENT,
				]
			);

			$this->add_control(
				'crafto_orientation',
				[
					'label'   => esc_html__( 'Orientation', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'horizontal',
					'options' => [
						'horizontal' => esc_html__( 'Horizontal', 'crafto-addons' ),
						'vertical'   => esc_html__( 'Vertical', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_default_offset',
				[
					'label'   => esc_html__( 'Before Image Visiblity', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 70,
					],
					'range'   => [
						'px' => [
							'max' => 100,
							'min' => 0,
						],
					],
				]
			);

			$this->add_control(
				'crafto_no_overlay',
				[
					'label'        => esc_html__( 'Overlay', 'crafto-addons' ),
					'description'  => esc_html__( 'Do not show the overlay with before and after.', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'crafto_on_hover',
				[
					'label'        => esc_html__( 'Show Label on Hover?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_no_overlay' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_before_after_vertical_align',
				[
					'label'                => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'toggle'               => false,
					'options'              => [
						'top'    => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'bottom' => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'default'              => 'center',
					'selectors_dictionary' => [
						'top'    => 'top: 0; bottom: unset;',
						'center' => 'top: 50%; transform: translateY(-50%); bottom: unset;',
						'bottom' => 'bottom: 0;',
					],
					'selectors'            => [
						'{{WRAPPER}} .crafto-image-compare .icv__icv--horizontal .icv__label' => '{{VALUE}};',
					],
					'condition'            => [
						'crafto_no_overlay'  => 'yes',
						'crafto_orientation' => 'horizontal',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_before_after_horizontal_align',
				[
					'label'                => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'toggle'               => false,
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
					'default'              => 'center',
					'selectors_dictionary' => [
						'left'   => 'left: 0; right: auto;',
						'center' => 'left: 50%; transform: translateX(-50%);',
						'right'  => 'right: 0; left: auto;',
					],
					'selectors'            => [
						'{{WRAPPER}} .crafto-image-compare .icv__label.vertical' => '{{VALUE}};',
					],
					'condition'            => [
						'crafto_no_overlay'  => 'yes',
						'crafto_orientation' => 'vertical',
					],
				]
			);

			$this->add_control(
				'crafto_move_slider_on_hover',
				[
					'label'        => esc_html__( 'Slide on Hover', 'crafto-addons' ),
					'description'  => esc_html__( 'Move slider on mouse hover?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'crafto_add_circle',
				[
					'label'        => esc_html__( 'Add Circle In Bar?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'crafto_add_circle_blur',
				[
					'label'        => esc_html__( 'Add Circle Blur?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'condition'    => [
						'crafto_add_circle' => 'yes',
					],
				]
			);

			$this->add_control(
				'crafto_add_circle_shadow',
				[
					'label'        => esc_html__( 'Circle Shadow?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'condition'    => [
						'crafto_add_circle' => 'yes',
					],
				]
			);

			$this->add_control(
				'crafto_smoothing',
				[
					'label'        => esc_html__( 'Smoothing?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'yes',
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'crafto_smoothing_amount',
				[
					'label'     => esc_html__( 'Smoothing Amount', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 400,
					],
					'range'     => [
						'px' => [
							'max'  => 1000,
							'min'  => 100,
							'step' => 10,
						],
					],
					'condition' => [
						'crafto_smoothing' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style',
				[
					'label' => esc_html__( 'Style', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_after_before_typography',
					'label'    => esc_html__( 'Typography', 'crafto-addons' ),
					'selector' => '{{WRAPPER}} .crafto-image-compare .icv__label',
				]
			);

			$this->start_controls_tabs( 'crafto_tabs_image_compare_style' );

				$this->start_controls_tab(
					'tcrafto_ab_image_compare_before_style',
					[
						'label' => esc_html__( 'Before', 'crafto-addons' ),
					]
				);

				$this->add_control(
					'crafto_before_background',
					[
						'label'     => esc_html__( 'Background', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-image-compare .icv__label.icv__label-before' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'crafto_before_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-image-compare .icv__label.icv__label-before' => 'color: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'crafto_tab_image_compare_after_style',
					[
						'label' => esc_html__( 'After', 'crafto-addons' ),
					]
				);

				$this->add_control(
					'crafto_after_background',
					[
						'label'     => esc_html__( 'Background', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-image-compare .icv__label.icv__label-after' => 'background-color: {{VALUE}};',
						],
					]
				);

				$this->add_control(
					'crafto_after_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crafto-image-compare .icv__label.icv__label-after' => 'color: {{VALUE}};',
						],
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'crafto_tab_image_compare_bar_style',
					[
						'label' => esc_html__( 'Bar', 'crafto-addons' ),
					]
				);

				$this->add_control(
					'crafto_bar_color',
					[
						'label'   => esc_html__( 'Bar Color', 'crafto-addons' ),
						'type'    => Controls_Manager::COLOR,
						'default' => '#fff',
					]
				);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_after_before_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'em',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-image-compare .icv__label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);

			$this->add_control(
				'crafto_after_before_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-image-compare .icv__label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_overlay_color',
				[
					'label'     => esc_html__( 'Overlay Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-image-compare .crafto-image-compare-overlay:before' => 'background: {{VALUE}};',
					],
					'condition' => [
						'crafto_no_overlay' => 'yes',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render image comparison widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( $settings['crafto_default_offset']['size'] < 1 ) {
				$settings['crafto_default_offset']['size'] = $settings['crafto_default_offset']['size'] * 100;
			}

			$this->add_render_attribute(
				[
					'image-compare' => [
						'id'            => 'image-compare-' . $this->get_id(),
						'class'         => [ 'image-compare' ],
						'data-settings' => [
							wp_json_encode(
								array_filter(
									[
										'id'               => 'image-compare-' . $this->get_id(),
										'default_offset_pct' => $settings['crafto_default_offset']['size'],
										'orientation'      => ( 'horizontal' === $settings['crafto_orientation'] ) ? false : true,
										'before_label'     => esc_attr( $settings['crafto_before_label'] ),
										'after_label'      => esc_attr( $settings['crafto_after_label'] ),
										'no_overlay'       => ( 'yes' === $settings['crafto_no_overlay'] ) ? true : false,
										'on_hover'         => ( 'yes' === $settings['crafto_on_hover'] ) ? true : false,
										'move_slider_on_hover' => ( 'yes' === $settings['crafto_move_slider_on_hover'] ) ? true : false,
										'add_circle'       => ( 'yes' === $settings['crafto_add_circle'] ) ? true : false,
										'add_circle_blur'  => ( 'yes' === $settings['crafto_add_circle_blur'] ) ? true : false,
										'add_circle_shadow' => ( 'yes' === $settings['crafto_add_circle_shadow'] ) ? true : false,
										'smoothing'        => ( 'yes' === $settings['crafto_smoothing'] ) ? true : false,
										'smoothing_amount' => $settings['crafto_smoothing_amount']['size'],
										'bar_color'        => $settings['crafto_bar_color'],
									]
								)
							),
						],
					],
				]
			);

			if ( 'yes' === $settings['crafto_no_overlay'] ) {
				$this->add_render_attribute(
					'image-compare',
					'class',
					'crafto-image-compare-overlay',
				);
			}
			?>
			<div class="crafto-image-compare">
				<div <?php $this->print_render_attribute_string( 'image-compare' ); ?>>
					<?php
					if ( ! empty( $settings['crafto_before_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_before_image']['id'] ) ) {
						$settings['crafto_before_image']['id'] = '';
					}
					if ( isset( $settings['crafto_before_image'] ) && isset( $settings['crafto_before_image']['id'] ) && ! empty( $settings['crafto_before_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_before_image']['id'], $settings['crafto_before_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					} elseif ( isset( $settings['crafto_before_image'] ) && isset( $settings['crafto_before_image']['url'] ) && ! empty( $settings['crafto_before_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_before_image']['id'], $settings['crafto_before_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					}

					if ( ! empty( $settings['crafto_after_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_after_image']['id'] ) ) {
						$settings['crafto_after_image']['id'] = '';
					}
					if ( isset( $settings['crafto_after_image'] ) && isset( $settings['crafto_after_image']['id'] ) && ! empty( $settings['crafto_after_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_after_image']['id'], $settings['crafto_after_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					} elseif ( isset( $settings['crafto_after_image'] ) && isset( $settings['crafto_after_image']['url'] ) && ! empty( $settings['crafto_after_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_after_image']['id'], $settings['crafto_after_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					}
					?>
				</div>
			</div>
			<?php
		}
	}
}
