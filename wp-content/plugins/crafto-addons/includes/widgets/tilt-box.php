<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;


/**
 * Crafto widget for tilt box.
 *
 * @package Crafto
 */

// If class `Tilt_Box` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Tilt_Box' ) ) {
	/**
	 * Define `Tilt_Box` class.
	 */
	class Tilt_Box extends Widget_Base {
		/**
		 * Retrieve the list of scripts the tilt box widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$tilt_box_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$tilt_box_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$tilt_box_scripts[] = 'atropos';
				}
				$tilt_box_scripts[] = 'crafto-tilt-box-widget';
			}
			return $tilt_box_scripts;
		}

		/**
		 * Retrieve the list of styles the tilt box widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$tilt_box_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$tilt_box_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$tilt_box_styles[] = 'atropos';
				}
				$tilt_box_styles[] = 'crafto-tilt-box-widget';
			}
			return $tilt_box_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve tilt box widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-tilt-box';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve tilt box widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Tilt Box', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve tilt box widget icon.
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
			return 'https://crafto.themezaa.com/documentation/tilt-box/';
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
				'fancy',
				'overlap',
				'vertical',
				'text-rotate',
				'tilt effect',
				'hover animation',
			];
		}

		/**
		 * Register tilt box widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_tilt_box_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tilt_box_icon_image_section',
				[
					'label' => esc_html__( 'Icon and Image', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_item_use_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_item_use_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_item_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_item_use_image' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'condition' => [
						'crafto_item_use_image' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_tilt_box_title_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_tilt_box_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_tilt_box_title_size',
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
				'crafto_tilt_box_content_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_description_text',
				[
					'label'   => esc_html__( 'Description', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus', 'crafto-addons' ),
					'rows'    => 10,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_tilt_box_setting_section',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tilt_box_image_atropos_offset',
				[
					'label' => esc_html__( 'Tilt Offset', 'crafto-addons' ),
					'type'  => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -10,
							'max' => 10,
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_tilt_box_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_tilt_box_aligment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => '',
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
						'{{WRAPPER}} .tilt-box-wrapper' => 'text-align: {{VALUE}};',
					],
				],
			);
			$this->add_control(
				'crafto_tilt_box_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tilt-box' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_tilt_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .tilt-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tilt_box_padding',
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
						'{{WRAPPER}} .tilt-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tilt_box_margin',
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
						'{{WRAPPER}} .tilt-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				],
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_tilt_box_icon_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_selected_icon[value]!' => '',
						'crafto_item_use_image'        => '',
					],
				]
			);
			$this->start_controls_tabs( 'icon_colors' );

			$this->start_controls_tab(
				'crafto_icon_colors_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .tilt-box i:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .tilt-box svg'      => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_colors_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_hover_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .tilt-box-wrapper:hover .tilt-box i:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} .tilt-box-wrapper:hover .tilt-box svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .tilt-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .tilt-box svg' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_space',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 15,
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .tilt-box i, {{WRAPPER}} .tilt-box svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_item_use_image' => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_size',
				[
					'label'          => esc_html__( 'Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => '',
						'unit' => 'px',
					],
					'tablet_default' => [
						'unit' => 'px',
					],
					'mobile_default' => [
						'unit' => 'px',
					],
					'size_units'     => [
						'px',
						'custom',
					],
					'selectors'      => [
						'{{WRAPPER}} .tilt-box img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_height_size',
				[
					'label'          => esc_html__( 'Height', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => '',
						'unit' => 'px',
					],
					'tablet_default' => [
						'unit' => 'px',
					],
					'mobile_default' => [
						'unit' => 'px',
					],
					'size_units'     => [
						'px',
						'custom',
					],
					'selectors'      => [
						'{{WRAPPER}} .tilt-box img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_space',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 15,
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .tilt-box img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_tilt_box_title_style_section',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_tilt_box_title_type',
				[
					'label'   => esc_html__( 'Title Type', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'normal' => [
							'title' => esc_html__( 'Normal', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter-bold',
						],
						'stroke' => [
							'title' => esc_html__( 'Stroke', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter',
						],
					],
					'default' => 'normal',
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_tilt_box_title_color',
					'selector'       => '{{WRAPPER}} .tilt-box-wrapper .title',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_tilt_box_title_type' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'      => 'crafto_tile_box_title_text_shadow',
					'selector'  => '{{WRAPPER}} .tilt-box-wrapper .title',
					'condition' => [
						'crafto_tilt_box_title_type' => 'stroke',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tilt_box_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .tilt-box-wrapper .title',
				]
			);
			$this->add_control(
				'crafto_tilt_box_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .tilt-box-wrapper .title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tilt_box_title_margin',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .tilt-box-wrapper .title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_tilt_box_description_style_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tilt_box_description_style_typography',
					'selector' => '{{WRAPPER}} .tilt-box .content',
				]
			);
			$this->add_control(
				'crafto_tilt_box_description_style_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .tilt-box .content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tilt_box_description_style_width',
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
							'min'  => 15,
							'max'  => 1000,
							'step' => 1,
						],
						'%'  => [
							'min' => 15,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .tilt-box .content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render tilt box widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                    = $this->get_settings_for_display();
			$crafto_tilt_box_title       = ( isset( $settings['crafto_tilt_box_title'] ) && $settings['crafto_tilt_box_title'] ) ? $settings['crafto_tilt_box_title'] : '';
			$crafto_description_text     = ( isset( $settings['crafto_description_text'] ) && $settings['crafto_description_text'] ) ? $settings['crafto_description_text'] : '';
			$crafto_image_atropos_offset = ( isset( $settings['crafto_tilt_box_image_atropos_offset']['size'] ) && ! empty( $settings['crafto_tilt_box_image_atropos_offset']['size'] ) ) ? $settings['crafto_tilt_box_image_atropos_offset']['size'] : 0;
			$crafto_tilt_box_title_type  = ( isset( $settings['crafto_tilt_box_title_type'] ) && $settings['crafto_tilt_box_title_type'] ) ? $settings['crafto_tilt_box_title_type'] : '';

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'tilt-box-wrapper',
				],
			);
			$this->add_render_attribute(
				'tilt-box',
				'class',
				[
					'tilt-box',
				],
			);
			$this->add_render_attribute(
				'title',
				'class',
				[
					'title',
				],
			);
			if ( 'stroke' === $crafto_tilt_box_title_type ) {
				$this->add_render_attribute(
					'title',
					'class',
					[
						'text-stroke',
					],
				);
			}
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div class="atropos has-atropos">
					<div class="atropos-scale">
						<div class="atropos-rotate">
							<div class="atropos-inner" data-atropos-offset="<?php echo esc_attr( (int) $crafto_image_atropos_offset ); ?>">
								<div <?php $this->print_render_attribute_string( 'tilt-box' ); ?>>
									<?php
									$this->get_image_icon(); // phpcs:ignore
									if ( ! empty( $crafto_tilt_box_title ) ) {
										?>
										<<?php echo $this->get_settings( 'crafto_tilt_box_title_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
											<?php echo esc_html( $crafto_tilt_box_title ); ?>
										</<?php echo $this->get_settings( 'crafto_tilt_box_title_size' ); // phpcs:ignore ?>>
										<?php
									}
									if ( ! empty( $crafto_description_text ) ) {
										?>
										<div class="content">
											<?php echo $crafto_description_text; // phpcs:ignore. ?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		/**
		 * Retrieve icon image.
		 *
		 * @access public
		 */
		public function get_image_icon() {
			$icon     = '';
			$settings = $this->get_settings_for_display();
			$migrated = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new   = ! isset( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $is_new || $migrated ) {
				ob_start();
				Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $settings['crafto_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			if ( ! empty( $settings['crafto_selected_icon']['value'] ) || ! empty( $settings['crafto_item_image'] ) ) {
				if ( 'yes' === $settings['crafto_item_use_image'] ) {
					if ( ! empty( $settings['crafto_item_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_item_image']['id'] ) ) {
						$settings['crafto_item_image']['id'] = '';
					}
					if ( isset( $settings['crafto_item_image'] ) && isset( $settings['crafto_item_image']['id'] ) && ! empty( $settings['crafto_item_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_item_image']['id'], $settings['crafto_item_image']['url'], $settings['crafto_thumbnail_size'] );
					} elseif ( isset( $settings['crafto_item_image'] ) && isset( $settings['crafto_item_image']['url'] ) && ! empty( $settings['crafto_item_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_item_image']['id'], $settings['crafto_item_image']['url'], $settings['crafto_thumbnail_size'] );
					}
				} else {
					echo $icon; // phpcs:ignore
				}
			}
		}
	}
}
