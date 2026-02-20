<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for map location.
 *
 * @package Crafto
 */

// If class `Map_Location` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Map_Location' ) ) {
	/**
	 * Define `Map_Location` class.
	 */
	class Map_Location extends Widget_Base {
		/**
		 * Retrieve the list of scripts the map location widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$map_location_scripts   = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$map_location_scripts[] = 'crafto-widgets';
			} else {
				$crafto_optimize_bootstrap = get_theme_mod( 'crafto_optimize_bootstrap', '0' );
				if ( '1' === $crafto_optimize_bootstrap ) {
					$map_location_scripts[] = 'bootstrap-tooltips';
				}
				$map_location_scripts[] = 'crafto-map-location';
			}
			return $map_location_scripts;
		}
		/**
		 * Retrieve the list of styles the map location widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [
					'crafto-video-button',
				];
			}
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve map location widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-map-location';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve map location widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Map Location', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve map location widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-google-maps crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/map-location/';
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
				'tooltip',
				'indicator',
				'target',
				'place',
				'locality',
				'placement',
				'point',
				'position',
				'spot',
				'marker',
				'business',
				'pin',
				'postcode',
				'longitude',
				'latitude',
			];
		}

		/**
		 * Register map location widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_map_location_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_map_location_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'fas fa-location-dot',
						'library' => 'fa-solid',
					],
				]
			);
			$this->add_control(
				'crafto_map_location_tooltip_title',
				[
					'label'       => esc_html__( 'Tooltip Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
				]
			);
			$this->add_control(
				'crafto_map_location_tooltip_description',
				[
					'label'   => esc_html__( 'Tooltip Description', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'rows'    => 10,
				]
			);
			$this->add_control(
				'crafto_map_location_box_position',
				[
					'label'       => esc_html__( 'Tooltip Position', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'bottom',
					'options'     => [
						'bottom' => esc_html__( 'Bottom', 'crafto-addons' ),
						'top'    => esc_html__( 'Top', 'crafto-addons' ),
						'right'  => esc_html__( 'Right', 'crafto-addons' ),
						'left'   => esc_html__( 'Left', 'crafto-addons' ),
					],
					'description' => esc_html__( 'Changes will appear in the preview after saving.', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_map_location_enable_animation',
				[
					'label'        => esc_html__( 'Enable Ripple Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_map_location_section_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_map_location_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .location-icon i'   => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .location-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_map_location_icon_box_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 20,
							'max' => 250,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .location-icon' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .location-icon-sonar-bfr' => 'height: calc( {{SIZE}}{{UNIT}} + 50px ); width: calc( {{SIZE}}{{UNIT}} + 50px )',
					],
				]
			);
			$this->add_control(
				'crafto_map_location_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .location-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .location-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_map_location_icon_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .location-icon',
				]
			);
			$this->add_responsive_control(
				'crafto_map_location_icon_margin',
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
						'{{WRAPPER}} .map-location-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_map_location_box',
				[
					'label'     => esc_html__( 'Tooltip Background', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_map_location_box_background',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						':not(.woocommerce, .woocommerce-demo-store) .tooltip .tooltip-inner' => 'background-color: {{VALUE}};',
						'body:not(.woocommerce, .woocommerce-demo-store) .tooltip.bs-tooltip-auto[data-popper-placement^=bottom] .tooltip-arrow:before,.bs-tooltip-bottom .tooltip-arrow:before' => 'border-bottom-color: {{VALUE}};',

						'body:not(.woocommerce, .woocommerce-demo-store) .tooltip.bs-tooltip-auto[data-popper-placement^=top] .tooltip-arrow:before,.bs-tooltip-top .tooltip-arrow:before' => 'border-top-color: {{VALUE}};',

						'body:not(.woocommerce, .woocommerce-demo-store) .tooltip.bs-tooltip-auto[data-popper-placement^=left] .tooltip-arrow:before,.bs-tooltip-start .tooltip-arrow:before' => 'border-left-color: {{VALUE}};',

						'body:not(.woocommerce, .woocommerce-demo-store) .tooltip.bs-tooltip-auto[data-popper-placement^=right] .tooltip-arrow:before,.bs-tooltip-end .tooltip-arrow:before' => 'border-right-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_map_location_title',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_map_location_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '.tooltip .tooltip-inner .tooltip-title',
				]
			);
			$this->add_control(
				'crafto_map_location_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'.tooltip .tooltip-inner .tooltip-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_map_location_title_margin',
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
						'.tooltip .tooltip-inner .tooltip-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_map_location_description',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_map_location_description_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '.tooltip .tooltip-inner .tooltip-description',
				]
			);
			$this->add_control(
				'crafto_map_location_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'.tooltip .tooltip-inner .tooltip-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_map_location_description_margin',
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
						'.tooltip .tooltip-inner .tooltip-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_video_button_sonar_style_heading',
				[
					'label'     => esc_html__( 'Ripple Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_map_location_enable_animation' => 'yes',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_video_button_icon_bg_animation_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .location-sonar .location-icon-sonar-bfr',
					'condition'      => [
						'crafto_map_location_enable_animation' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_sonar_animation_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .location-sonar .location-icon-sonar-bfr' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_map_location_enable_animation' => 'yes',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render map location widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$hover_tooltip_title         = '';
			$hover_tooltip_description   = '';
			$settings                    = $this->get_settings_for_display();
			$migrated                    = isset( $settings['esc_html__fa4_migrated']['crafto_map_location_icon'] );
			$is_new                      = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_tooltip_title        = ( isset( $settings['crafto_map_location_tooltip_title'] ) && $settings['crafto_map_location_tooltip_title'] ) ? $settings['crafto_map_location_tooltip_title'] : '';
			$crafto_tooltip_description  = ( isset( $settings['crafto_map_location_tooltip_description'] ) && $settings['crafto_map_location_tooltip_description'] ) ? $settings['crafto_map_location_tooltip_description'] : '';
			$crafto_tooltip_box_position = ( isset( $settings['crafto_map_location_box_position'] ) && $settings['crafto_map_location_box_position'] ) ? $settings['crafto_map_location_box_position'] : '';

			$migrated = isset( $settings['__fa4_migrated']['crafto_map_location_icon'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! empty( $crafto_tooltip_title ) ) {
				$hover_tooltip_title = '<span class="tooltip-title">' . $crafto_tooltip_title . '</span>';
			}
			if ( ! empty( $crafto_tooltip_description ) ) {
				$hover_tooltip_description = '<p class="tooltip-description">' . $crafto_tooltip_description . '</p>';
			}

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'map-location-wrap',
						],
					],
				],
			);

			$this->add_render_attribute(
				[
					'tooltip-wrap' => [
						'data-bs-toggle'         => 'tooltip',
						'data-bs-placement'      => $crafto_tooltip_box_position,
						'data-bs-html'           => 'true',
						'aria-label'             => $hover_tooltip_title . $hover_tooltip_description,
						'data-bs-original-title' => $hover_tooltip_title . $hover_tooltip_description,
					],
				],
			);

			$this->add_render_attribute(
				[
					'icon_sonar' => [
						'class' => [
							'video-icon-sonar-bfr',
							'location-icon-sonar-bfr',
						],
					],
				],
			);
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				if ( ! empty( $crafto_tooltip_title ) || ! empty( $hover_tooltip_description ) ) {
					?>
					<div <?php $this->print_render_attribute_string( 'tooltip-wrap' ); ?>>
					<?php
				}
				?>
				<span class="video-icon location-icon">
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $settings['crafto_map_location_icon'], [ 'aria-hidden' => 'true' ] );
					} elseif ( isset( $settings['crafto_map_location_icon']['value'] ) && ! empty( $settings['crafto_map_location_icon']['value'] ) ) {
						?>
						<i class="<?php echo esc_attr( $settings['crafto_map_location_icon']['value'] ); ?>" aria-hidden="true"></i>
						<?php
					}
					if ( 'yes' === $settings['crafto_map_location_enable_animation'] ) {
						?>
						<span class="video-icon-sonar location-sonar">
							<span <?php $this->print_render_attribute_string( 'icon_sonar' ); ?>></span>
						</span>
						<?php
					}
					?>
				</span>
				<?php
				if ( ! empty( $crafto_tooltip_title ) || ! empty( $hover_tooltip_description ) ) {
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
