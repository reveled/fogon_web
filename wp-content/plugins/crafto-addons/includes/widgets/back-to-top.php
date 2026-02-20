<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for back to top.
 *
 * @package Crafto
 */

// If class `Back_to_Top` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Back_to_Top' ) ) {
	/**
	 * Define `Back_to_Top` class.
	 */
	class Back_To_Top extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-back-to-top';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Back To Top', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-arrow-up crafto-element-icon';
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
				'scroll top',
				'go to top',
				'top button',
				'scroll button',
				'up button',
				'scroll up',
				'top',
				'arrow up',
				'scroll',
				'back',
				'page up',
			];
		}

		/**
		 * Retrieve the list of scripts the back to top widget depended on.
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
				return [ 'crafto-back-to-top-widget' ];
			}
		}

		/**
		 * Retrieve the list of styles the back to top widget depended on.
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
				return [ 'crafto-back-to-top-widget' ];
			}
		}

		/**
		 * Register back to top widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_back_to_top_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_back_to_top_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'back-to-top-style-1',
					'options' => [
						'back-to-top-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'back-to-top-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_back_to_top_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'feather icon-feather-arrow-up',
						'library' => 'feather-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_back_to_top_style' => 'back-to-top-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_hide_back_to_top_tablet',
				[
					'label'        => esc_html__( 'Show on Tablet', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'crafto_back_to_top_text',
				[
					'label'       => esc_html__( 'Back to Top Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Scroll', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Scroll', 'crafto-addons' ),
					'condition'   => [
						'crafto_back_to_top_style' => 'back-to-top-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_back_to_top_position',
				[
					'label'   => esc_html__( 'Back to Top Position', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'right',
					'options' => [
						'left'  => esc_html__( 'Left', 'crafto-addons' ),
						'right' => esc_html__( 'Right', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_back_to_top_offset',
				[
					'label'     => esc_html__( 'Offset', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => '',
					'condition'  => [
						'crafto_back_to_top_style' => 'back-to-top-style-1',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_back_to_top_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_back_to_top_style' => 'back-to-top-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_back_to_top_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-scroll-progress .crafto-scroll-text',
				]
			);
			$this->add_responsive_control(
				'crafto_back_to_top_icon_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px'  => [
							'min' => 0,
							'max' => 500,
						],
						'%'   => [
							'min' => 0,
							'max' => 100,
						],
						'em'  => [
							'min' => 0,
							'max' => 100,
						],
						'rem' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-scroll-progress .crafto-scroll-line' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_back_to_top_icon_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px'  => [
							'min' => 0,
							'max' => 500,
						],
						'%'   => [
							'min' => 0,
							'max' => 100,
						],
						'em'  => [
							'min' => 0,
							'max' => 100,
						],
						'rem' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-scroll-progress .crafto-scroll-line' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_back_to_top_icon_style',
				[
					'label'      => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'   => [
						'crafto_back_to_top_style' => 'back-to-top-style-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_back_to_top_icon_size',
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
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top, {{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_back_to_top_icon_max_width',
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
							'min' => 0,
							'max' => 200,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_back_to_top_icon_box_shadow',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top',
				]
			);
			$this->add_responsive_control(
				'crafto_back_to_top_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_icon_tab' );
			$this->start_controls_tab(
				'crafto_icon_colors_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_back_to_top_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top' => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_back_to_top_icon_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top' => 'background-color: {{VALUE}};',
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
				'crafto_back_to_top_icon_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top:hover' => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top:hover svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_back_to_top_icon_hover_background_color',
				[
					'label'     => esc_html__( 'Icon Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-scroll-top-arrow .crafto-scroll-top:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render back to top widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                    = $this->get_settings_for_display();
			$crafto_back_to_top_style    = $this->get_settings( 'crafto_back_to_top_style' );
			$show_on_tablet              = $this->get_settings( 'crafto_hide_back_to_top_tablet' );
			$mobile_class                = ( 'yes' !== $show_on_tablet ) ? ' hide-in-tablet' : '';
			$crafto_back_to_top_position = $this->get_settings( 'crafto_back_to_top_position', 'right' );
			$add_visible_class           = (
				! empty( $settings['crafto_back_to_top_style'] ) ||
				! empty( $settings['crafto_back_to_top_selected_icon']['value'] ) ||
				! empty( $settings['crafto_back_to_top_text'] ) ||
				! empty( $settings['crafto_back_to_top_position'] ) ||
				! empty( $offset_value ) ||
				'yes' === $show_on_tablet
			);

			$crafto_position_cls = '';
			if ( 'left' === $crafto_back_to_top_position ) {
				$crafto_position_cls = ' crafto-scroll-to-top-left';
			}

			switch ( $crafto_back_to_top_style ) {
				case 'back-to-top-style-1':
					$offset_value = $this->get_settings( 'crafto_back_to_top_offset' );
					$position     = $this->get_settings( 'crafto_back_to_top_position', 'right' );

					$inline_style = '';
					if ( '' !== $offset_value && is_numeric( $offset_value ) ) {
						$inline_style = sprintf( '%s: %dpx;', esc_attr( $position ), (int) $offset_value );
					}

					if ( $add_visible_class ) {
						$progress_classes[] = 'visible';
					}
					$progress_base = 'crafto-scroll-progress' . $mobile_class . $crafto_position_cls;
					?>
					<div class="<?php echo esc_attr( $progress_base . ' ' . implode( ' ', $progress_classes ) ); ?>" style="<?php echo esc_attr( $inline_style ); ?>">
						<div class="crafto-scroll-top">
							<span class="crafto-scroll-text">
								<?php
								if ( ! empty( $this->get_settings( 'crafto_back_to_top_text' ) ) ) {
									echo esc_html( $this->get_settings( 'crafto_back_to_top_text' ) );
								}
								?>
							</span>
							<span class="crafto-scroll-line">
								<span class="crafto-scroll-point"></span>
							</span>
						</div>
					</div>
					<?php
					break;
				case 'back-to-top-style-2':
					if ( ! isset( $settings['icon'] ) && ! Icons_Manager::is_migration_allowed() ) {
						$settings['icon'] = 'feather icon-feather-arrow-up';
					}

					$migrated = isset( $settings['__fa4_migrated']['crafto_back_to_top_selected_icon'] );
					$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

					if ( $add_visible_class ) {
						$arrow_classes[] = 'visible';
					}
					$arrow_base = 'crafto-scroll-top-arrow' . $mobile_class . $crafto_position_cls;
					?>
					<div class="<?php echo esc_attr( $arrow_base . ' ' . implode( ' ', $arrow_classes ) ); ?>">
						<a href="#" class="crafto-scroll-top">
							<?php
							if ( $is_new || $migrated ) {
								Icons_Manager::render_icon( $settings['crafto_back_to_top_selected_icon'], [ 'aria-hidden' => 'true' ] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_back_to_top_selected_icon']['value'] ) && ! empty( $settings['crafto_back_to_top_selected_icon']['value'] ) ) {
								echo '<i class="' . esc_attr( $settings['crafto_back_to_top_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
							}
							?>
							<span class="screen-reader-text">
								<?php echo esc_html__( 'Back to Top', 'crafto-addons' ); ?>
							</span>
						</a>
					</div>
					<?php
					break;
			}
		}
	}
}
