<?php
namespace CraftoAddons\Controls\Groups;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;

/**
 * Crafto icon group control.
 *
 * A base control for creating icon control. Displays input fields to define
 * icon or image.
 *
 * @package Crafto
 */

// If class `Icon_Group_Control` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Controls\Groups\Icon_Group_Control' ) ) {

	/**
	 * Define Icon_Group_Control class
	 */
	class Icon_Group_Control {
		/**
		 * Icon Group widget constructor.
		 *
		 * Initializing the Elementor modules manager.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param array  $name Widget arguments.
		 * @param array  $default_arr Widget arguments.
		 * @access public
		 */
		public static function icon_fields( $element, $name = '', $default_arr = array() ) {

			$prefix = '';
			if ( ! empty( $name ) ) {
				$prefix = 'crafto_' . $name . '_';
			} else {
				$prefix = 'crafto_';
			}

			if ( empty( $default_arr ) ) {

				$default_arr = array(
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				);
			}

			$element->add_control(
				$prefix . 'custom_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);

			$element->add_control(
				$prefix . 'icons',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => $default_arr,
					'condition'        => [
						$prefix . 'custom_image' => '',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);

			$element->add_control(
				$prefix . 'image',
				[
					'label'     => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						$prefix . 'custom_image!' => '',
					],
				]
			);
			$element->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => $prefix . 'image',
					'default'   => 'large',
					'separator' => 'none',
					'condition' => [
						$prefix . 'custom_image!' => '',
					],
				]
			);
			$element->add_control(
				$prefix . 'icon_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'default',
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'condition'    => [
						$prefix . 'custom_image' => '',
					],
					'prefix_class' => 'elementor-view-',
				]
			);
			$element->add_control(
				$prefix . 'icon_shape',
				[
					'label'        => esc_html__( 'Shape', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => esc_html__( 'Circle', 'crafto-addons' ),
						'square' => esc_html__( 'Square', 'crafto-addons' ),
					],
					'default'      => 'circle',
					'condition'    => [
						$prefix . 'icon_view!'   => 'default',
						$prefix . 'custom_image' => '',
					],
					'prefix_class' => 'elementor-shape-',
				]
			);
		}

		/**
		 * Icon Group Style widget constructor.
		 *
		 * Initializing the Elementor modules manager.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param array  $name Widget arguments.
		 * @access public
		 */
		public static function icon_style_fields( $element, $name = '' ) {

			$prefix = '';
			if ( ! empty( $name ) ) {
				$prefix = 'crafto_' . $name . '_';
			} else {
				$prefix = 'crafto_';
			}

			$element->add_responsive_control(
				$prefix . '_image_width',
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
						'{{WRAPPER}} .elementor-icon img' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'custom_image!' => '',
					],
				]
			);
			$element->add_control(
				$prefix . '_image_height',
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
						'{{WRAPPER}} .elementor-icon img' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						$prefix . 'custom_image!' => '',
					],
				]
			);
			$element->add_control(
				$prefix . 'icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 6,
							'max' => 300,
						],
					],
					'condition'  => [
						$prefix . 'custom_image' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$element->start_controls_tabs( 'icon_tabs' );
			$element->start_controls_tab(
				$prefix . 'icon_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						$prefix . 'custom_image' => '',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'icon_primary_color',
				[
					'label'     => esc_html__( 'Primary Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						$prefix . 'custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}:hover .elementor-icon'                                                                         => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'                                                        => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'icon_secondary_color',
				[
					'label'     => esc_html__( 'Secondary Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						$prefix . 'icon_view!'   => 'default',
						$prefix . 'custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}:hover .elementor-icon'                      => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'      => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'     => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$element->end_controls_tab();
			$element->start_controls_tab(
				$prefix . 'icon_colors_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						$prefix . 'custom_image' => '',
					],
				]
			);

			$element->add_responsive_control(
				$prefix . 'icon_hover_primary_color',
				[
					'label'     => esc_html__( 'Primary Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						$prefix . 'custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}:hover .elementor-icon'                                                                                     => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon'                                                              => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon, {{WRAPPER}}.elementor-view-default:hover .elementor-icon'     => 'color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon, {{WRAPPER}}.elementor-view-default:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$element->add_responsive_control(
				$prefix . 'icon_hover_secondary_color',
				[
					'label'     => esc_html__( 'Secondary Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						$prefix . 'icon_view!'   => 'default',
						$prefix . 'custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}:hover .elementor-icon'                            => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon'      => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon'     => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$element->end_controls_tab();
			$element->end_controls_tabs();
		}

		/**
		 * Render icon group control output on the frontend.
		 *
		 * @param object $element Widget data.
		 * @param array  $name Widget arguments.
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access public
		 */
		public static function render_icon_content( $element, $name = '' ) {

			$prefix = '';
			if ( ! empty( $name ) ) {
				$prefix = 'crafto_' . $name . '_';
			} else {
				$prefix = 'crafto_';
			}

			$settings = $element->get_settings_for_display();

			$element->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );

			$migrated = isset( $settings['__fa4_migrated'][ $prefix . 'icons' ] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! empty( $settings[ $prefix . 'icons' ]['value'] ) ) {
				?>
				<div <?php echo $element->get_render_attribute_string( 'icon-wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $settings[ $prefix . 'icons' ], [ 'aria-hidden' => 'true' ] );
					} elseif ( isset( $settings['icons']['value'] ) && ! empty( $settings['icons']['value'] ) ) {
						$element->add_render_attribute( 'icon', 'class', $settings['icon']['value'] );
						$element->add_render_attribute( 'icon', 'aria-hidden', 'true' );
						?>
						<i <?php echo $element->get_render_attribute_string( 'icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></i>
						<?php
					}
					?>
				</div>
				<?php
			} elseif ( ! empty( $settings[ $prefix . 'custom_image' ] ) ) {
				?>
				<div class="elementor-icon">
					<?php
					echo Group_Control_Image_Size::get_attachment_image_html( $settings, $prefix . 'image', $prefix . 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					?>
				</div>
				<?php
			}
		}
	}
}
