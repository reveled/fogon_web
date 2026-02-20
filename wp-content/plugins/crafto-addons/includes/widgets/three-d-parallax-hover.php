<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;

/**
 * Crafto widget for 3D Parallax Hover.
 *
 * @package Crafto
 */

// If class `Three_D_Parallax_Hover` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Three_D_Parallax_Hover' ) ) {
	/**
	 * Define `Three_D_Parallax_Hover` class.
	 */
	class Three_D_Parallax_Hover extends Widget_Base {
		/**
		 * Retrieve the list of scripts the 3d parallax hover widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$three_d_parallax_hover_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$three_d_parallax_hover_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$three_d_parallax_hover_scripts[] = 'atropos';
				}
				$three_d_parallax_hover_scripts[] = 'crafto-tilt-box-widget';
			}
			return $three_d_parallax_hover_scripts;
		}

		/**
		 * Retrieve the list of styles the 3d parallax hover widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$three_d_parallax_hover_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$three_d_parallax_hover_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$three_d_parallax_hover_styles[] = 'atropos';
				}
				$three_d_parallax_hover_styles[] = 'crafto-3d-parallax-hover-widget';
			}
			return $three_d_parallax_hover_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve 3d parallax hover widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-3d-parallax-hover';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve 3d parallax hover widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto 3D Parallax Hover', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve 3d parallax hover widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-info-box crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/3d-parallax-hover/';
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
				'image',
				'flip',
				'overlap',
				'three',
				'3d',
				'3d parallax',
				'3d card',
			];
		}

		/**
		 * Register 3d parallax hover widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_3d_parallax_hover_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'three-d-parallax-hover-1',
					'options' => [
						'three-d-parallax-hover-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'three-d-parallax-hover-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_image',
				[
					'label'     => esc_html__( 'Image Layer 1', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_3d_parallax_hover_style' => [
							'three-d-parallax-hover-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_second_image',
				[
					'label'     => esc_html__( 'Image Layer 2', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_3d_parallax_hover_style' => [
							'three-d-parallax-hover-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_title',
				[
					'label'     => esc_html__( 'Heading Layer 1', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'create brands', 'crafto-addons' ),
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_second_title',
				[
					'label'     => esc_html__( 'Heading Layer 2', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'design', 'crafto-addons' ),
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_3d_parallax_hover_setting_section',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_first_layer_offset',
				[
					'label' => esc_html__( 'Layer 1 Offset', 'crafto-addons' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -10,
							'max' => 10,
						],
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_second_layer_offset',
				[
					'label' => esc_html__( 'Layer 2 Offset', 'crafto-addons' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -10,
							'max' => 10,
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'separator' => 'none',
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-1',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_3d_parallax_hover_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_3d_parallax_hover_alignment',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
						'start'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .atropos-inner' => 'justify-content: {{VALUE}}',
					],
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_3d_parallax_hover_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .atropos-inner',
				]
			);
			$this->add_responsive_control(
				'crafto_3d_parallax_hover_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
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
						'{{WRAPPER}} .atropos-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_3d_parallax_hover_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
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
						'{{WRAPPER}} .atropos-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'      => 'crafto_3d_parallax_hover_title_shadow',
					'selector'  => '{{WRAPPER}} .second-title',
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_first_heading',
				[
					'label'     => esc_html__( 'Heading 1', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'           => 'crafto_3d_parallax_hover_first_title_typography',
					'selector'       => '{{WRAPPER}} .first-title',
					'fields_options' => [
						'typography' => [
							'label' => esc_html__( 'Typography', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_first_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .first-title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_second_heading',
				[
					'label'     => esc_html__( 'Heading 2', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'           => 'crafto_3d_parallax_hover_second_title_typography',
					'selector'       => '{{WRAPPER}} .second-title',
					'fields_options' => [
						'typography' => [
							'label' => esc_html__( 'Typography', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->add_control(
				'crafto_3d_parallax_hover_second_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .second-title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_3d_parallax_hover_style' => 'three-d-parallax-hover-2',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render 3d parallax hover widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                        = $this->get_settings_for_display();
			$crafto_3d_parallax_first_title  = ( isset( $settings['crafto_3d_parallax_hover_title'] ) && $settings['crafto_3d_parallax_hover_title'] ) ? $settings['crafto_3d_parallax_hover_title'] : '';
			$crafto_3d_parallax_second_title = ( isset( $settings['crafto_3d_parallax_hover_second_title'] ) && $settings['crafto_3d_parallax_hover_second_title'] ) ? $settings['crafto_3d_parallax_hover_second_title'] : '';
			$crafto_image_atropos_offset     = ( isset( $settings['crafto_3d_parallax_hover_first_layer_offset']['size'] ) && ! empty( $settings['crafto_3d_parallax_hover_first_layer_offset']['size'] ) ) ? (float) $settings['crafto_3d_parallax_hover_first_layer_offset']['size'] : 0;
			$crafto_tilt_atropos_offset      = ( isset( $settings['crafto_3d_parallax_hover_second_layer_offset']['size'] ) && ! empty( $settings['crafto_3d_parallax_hover_second_layer_offset']['size'] ) ) ? (float) $settings['crafto_3d_parallax_hover_second_layer_offset']['size'] : 0;

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'three-d-parallax-hover-wrapper',
					$settings['crafto_3d_parallax_hover_style'],
				],
			);
			$this->add_render_attribute(
				'3d-parallax-hover',
				'class',
				[
					'three-d-parallax-hover',
				],
			);

			if ( ! empty( $settings['crafto_3d_parallax_hover_image']['id'] ) ) {
				$thumbnail_id     = $settings['crafto_3d_parallax_hover_image']['id'];
				$crafto_image_alt = Control_Media::get_image_alt( $settings['crafto_3d_parallax_hover_image'] );

				if ( empty( $crafto_image_alt ) ) {
					$crafto_image_alt = esc_attr( get_the_title( $settings['crafto_3d_parallax_hover_image']['id'] ) );
				}

				$default_attr = array(
					'class'               => 'image-layer-1',
					'data-atropos-offset' => $crafto_image_atropos_offset,
				);

				$crafto_3d_parallax_hover_image = wp_get_attachment_image( $thumbnail_id, $settings['crafto_thumbnail_size'], '', $default_attr );

				wp_get_attachment_image( $thumbnail_id, $settings['crafto_thumbnail_size'], '', $default_attr );
			} elseif ( ! empty( $settings['crafto_3d_parallax_hover_image']['url'] ) ) {
				$crafto_3d_parallax_hover_image_url = $settings['crafto_3d_parallax_hover_image']['url'];
				$crafto_3d_parallax_hover_image_alt = esc_attr__( 'Placeholder Image', 'crafto-addons' );
				$crafto_3d_parallax_hover_image     = sprintf( '<img class="image-layer-1" src="%1$s" alt="%2$s" data-atropos-offset="%3$s" />', esc_url( $crafto_3d_parallax_hover_image_url ), esc_attr( $crafto_3d_parallax_hover_image_alt ), $crafto_image_atropos_offset );
			}
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				$this->crafto_3d_parallax_hover_start();
				switch ( $settings['crafto_3d_parallax_hover_style'] ) {
					case 'three-d-parallax-hover-1':
					default:
						?>
						<div data-atropos-offset="<?php echo esc_attr( $crafto_tilt_atropos_offset ); ?>">
							<div <?php $this->print_render_attribute_string( '3d-parallax-hover' ); ?>>
								<?php
								if ( ! empty( $settings['crafto_3d_parallax_hover_second_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_3d_parallax_hover_second_image']['id'] ) ) {
									$settings['crafto_3d_parallax_hover_second_image']['id'] = '';
								}
								if ( isset( $settings['crafto_3d_parallax_hover_second_image'] ) && isset( $settings['crafto_3d_parallax_hover_second_image']['id'] ) && ! empty( $settings['crafto_3d_parallax_hover_second_image']['id'] ) ) {
									crafto_get_attachment_html( $settings['crafto_3d_parallax_hover_second_image']['id'], $settings['crafto_3d_parallax_hover_second_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
								} elseif ( isset( $settings['crafto_3d_parallax_hover_second_image'] ) && isset( $settings['crafto_3d_parallax_hover_second_image']['url'] ) && ! empty( $settings['crafto_3d_parallax_hover_second_image']['url'] ) ) {
									crafto_get_attachment_html( $settings['crafto_3d_parallax_hover_second_image']['id'], $settings['crafto_3d_parallax_hover_second_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
								}
								?>
							</div>
						</div>
						<?php
						if ( ! empty( $crafto_3d_parallax_hover_image ) ) {
							echo sprintf( '%s', $crafto_3d_parallax_hover_image ); // phpcs:ignore
						}
						break;
					case 'three-d-parallax-hover-2':
						?>
						<div data-atropos-offset="<?php echo esc_attr( $crafto_tilt_atropos_offset ); ?>">
							<div <?php $this->print_render_attribute_string( '3d-parallax-hover' ); ?>>
								<span class="first-title"><?php echo esc_html( $crafto_3d_parallax_first_title ); ?></span>
							</div>
						</div>
						<div class="second-offset">
						<span class="second-title" data-atropos-offset="<?php echo esc_attr( $crafto_image_atropos_offset ); ?>"><?php echo esc_html( $crafto_3d_parallax_second_title ); ?></span></div>
						<?php
						break;
				}
				$this->crafto_3d_parallax_hover_end();
				?>
			</div>
			<?php
		}

		/**
		 * 3D Parallax Hover Wrapper Start
		 *
		 * @access public
		 */
		public function crafto_3d_parallax_hover_start() {
			?>
			<div class="atropos has-atropos">
			<div class="atropos-scale">
			<div class="atropos-rotate">
			<div class="atropos-inner">
			<?php
		}

		/**
		 * 3D Parallax Hover Wrapper End
		 *
		 * @access public
		 */
		public function crafto_3d_parallax_hover_end() {
			?>
			</div></div></div></div>
			<?php
		}
	}
}
