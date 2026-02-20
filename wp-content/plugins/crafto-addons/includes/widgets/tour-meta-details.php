<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for tours meta details.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_tour_template() ) {
	return;
}


// If class `Tour_Meta_Details` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Tour_Meta_Details' ) ) {

	/**
	 * Define `Tour_Meta_Details` class.
	 */
	class Tour_Meta_Details extends Widget_Base {
		/**
		 * Retrieve the list of styles the tour meta widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$tour_meta_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$tour_meta_styles[] = 'crafto-widgets-rtl';
				} else {
					$tour_meta_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$tour_meta_styles[] = 'crafto-tour-meta-rtl';
				}
				$tour_meta_styles[] = 'crafto-tour-meta';
			}
			return $tour_meta_styles;
		}
		/**
		 * Get widget name.
		 *
		 * Retrieve tour meta details widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-tours-meta-details';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve tour meta details widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Tour Meta Data', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve tour meta details widget icon.
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
			return 'https://crafto.themezaa.com/documentation/tour-meta-data/';
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
				'crafto-single',
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
				'trip',
				'data',
				'info',
				'days',
				'age',
				'activities',
				'person',
				'travel',
			];
		}

		/**
		 * Register tour meta details widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_tours_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'In Preview, tours meta details are dummy, while the original tours meta information is retrieved from the relevant post.', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'crafto_show_tours_days',
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
				'crafto_tours_show_activity',
				[
					'label'        => esc_html__( 'Enable Activities', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_tours_meta_details_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_tours_meta_margin',
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
						'{{WRAPPER}} .tours-meta-box li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_tours_icons_heading',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_tours_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .single-tours-day i, {{WRAPPER}} .single-person-age i, {{WRAPPER}} .activity-name i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_tours_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-tours-day i, {{WRAPPER}} .single-person-age i, {{WRAPPER}} .activity-name i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tours_icon_space',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .single-tours-day i, {{WRAPPER}} .single-person-age i, {{WRAPPER}} .activity-name i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_tours_Text_heading',
				[
					'label'     => esc_html__( 'Text', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tours_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .single-tours-day, {{WRAPPER}} .single-person-age, {{WRAPPER}} .activity-name',
				]
			);
			$this->add_control(
				'crafto_tours_day_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .single-tours-day, {{WRAPPER}} .single-person-age, {{WRAPPER}} .activity-name' => 'color: {{VALUE}};',
					],
				]
			);
		}

		/**
		 * Render tours meta details widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                   = $this->get_settings_for_display();
			$crafto_show_tours_days     = ( isset( $settings['crafto_show_tours_days'] ) && $settings['crafto_show_tours_days'] ) ? $settings['crafto_show_tours_days'] : '';
			$crafto_tours_show_activity = ( isset( $settings['crafto_tours_show_activity'] ) && $settings['crafto_tours_show_activity'] ) ? $settings['crafto_tours_show_activity'] : '';

			$crafto_tours_days = crafto_post_meta( 'crafto_single_tours_days' );

			$tour_cat = [];
			if ( crafto_is_editor_mode() ) { // phpcs:ignore
				if ( 'yes' === $crafto_show_tours_days ) {
					$tour_cat[] = '<li class="activity-name"><i class="bi bi-calendar-check icon-extra-medium"></i>' . esc_html__( 'Days', 'crafto-addons' ) . '</li>';
				}
				$tour_cat[] = '<li class="activity-name"><i class="fa-regular fa-star"></i>' . esc_html__( 'Air rides', 'crafto-addons' ) . '</li>';
				$tour_cat[] = '<li class="activity-name"><i class="fa-regular fa-map"></i>' . esc_html__( 'Beaches', 'crafto-addons' ) . '</li>';

			} else {
				$tour_activities = get_the_terms( get_the_ID(), 'tour-activity' );

				if ( ! empty( $tour_activities ) ) {
					foreach ( $tour_activities as $activity ) {
						$term_id              = $activity->term_id;
						$crafto_activity_icon = get_term_meta( $term_id, 'crafto_activity_icon', true );

						$crafto_activity_icon_html = '';
						if ( $crafto_activity_icon ) {
							$crafto_activity_icon_html = '<i class="' . $crafto_activity_icon . '"></i>';
						}
						$tour_cat[] = '<li class="activity-name">' . $crafto_activity_icon_html . esc_html( $activity->name ) . '</li>';
					}
				}
			}
			$tour_activity = ( is_array( $tour_cat ) && ! empty( $tour_cat ) ) ? implode( ' ', $tour_cat ) : '';

			if ( ( 'yes' === $crafto_show_tours_days && ! empty( $crafto_tours_days ) ) || ( 'yes' === $crafto_tours_show_activity && ! empty( $tour_activity ) ) ) {
				?>
				<div class="tours-meta-wrapper">
					<ul class="tours-meta-box">
						<?php
						if ( 'yes' === $crafto_show_tours_days && ! empty( $crafto_tours_days ) ) {
							?>
							<li class="single-tours-day">
								<i class="bi bi-calendar-check icon-extra-medium"></i>
								<?php echo esc_html( $crafto_tours_days ); ?>
							</li>
							<?php
						}

						if ( 'yes' === $crafto_tours_show_activity && ! empty( $tour_activity ) ) {
							echo $tour_activity; // phpcs:ignore
						}
						?>
					</ul>
				</div>
				<?php
			}
		}
	}
}
