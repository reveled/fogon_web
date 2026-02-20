<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for tours header bar details.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_tour_template() ) {
	return;
}

// If class `Tour_Header_Bar` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Tour_Header_Bar' ) ) {
	/**
	 * Define `Tour_Header_Bar` class.
	 */
	class Tour_Header_Bar extends Widget_Base {
		/**
		 * Retrieve the list of styles the tour header bar widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$tour_header_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$tour_header_styles[] = 'crafto-widgets-rtl';
				} else {
					$tour_header_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$tour_header_styles[] = 'crafto-star-rating-rtl';
					$tour_header_styles[] = 'crafto-tour-header-rtl';
				}
				$tour_header_styles[] = 'crafto-star-rating';
				$tour_header_styles[] = 'crafto-tour-header';
			}
			return $tour_header_styles;
		}
		/**
		 * Get widget name.
		 *
		 * Retrieve tour header bar widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-trip-header';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve tour header bar widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Tour Title Bar', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve tour header bar widget icon.
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
			return 'https://crafto.themezaa.com/documentation/tour-title-bar/';
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
				'image',
				'header',
				'title',
				'meta',
				'price',
				'location',
				'destination',
				'place',
				'travel',
				'trip',
				'address',
			];
		}

		/**
		 * Register tour header bar widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_trip_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'In Preview, tours details are dummy, while the original tours information is retrieved from the relevant post.', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);

			$this->add_control(
				'crafto_show_trip_title',
				[
					'label'        => esc_html__( 'Enable Title', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_trip_title_tag',
				[
					'label'     => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
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
					'default'   => 'h3',
					'condition' => [
						'crafto_show_trip_title' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_trip_show_pr_person',
				[
					'label'        => esc_html__( 'Enable Price', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_trip_show_pr_person_text',
				[
					'label'     => esc_html__( 'Price Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Per Person', 'crafto-addons' ),
					'condition' => [
						'crafto_trip_show_pr_person' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_trip_show_destination',
				[
					'label'        => esc_html__( 'Enable Destination', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_trip_show_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'default'          => [
						'value'   => 'bi bi-geo-alt icon-small',
						'library' => 'bi-regular',
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'condition'        => [
						'crafto_trip_show_destination' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_trip_show_review',
				[
					'label'        => esc_html__( 'Enable Reviews', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_trip_title_style',
				[
					'label'     => esc_html__( 'Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_trip_title' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_trip_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .trip-header-wrapper .trip-header-title',
				]
			);
			$this->add_control(
				'crafto_trip_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trip-header-wrapper .trip-header-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_trip_title_margin',
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
						'{{WRAPPER}} .trip-header-wrapper .trip-header-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_trip_price_style',
				[
					'label'     => esc_html__( 'Price', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_trip_show_pr_person' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_trip_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .trip-header-wrapper .trip-person-price',
				]
			);
			$this->add_control(
				'crafto_trip_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trip-header-wrapper .trip-person-price' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_trip_price_margin',
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
						'{{WRAPPER}} .trip-header-wrapper .trip-person-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_trip_per_person_style',
				[
					'label'     => esc_html__( 'Price Label', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_trip_per_person_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .trip-header-wrapper .trip-person-text',
				]
			);
			$this->add_control(
				'crafto_trip_per_person_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trip-header-wrapper .trip-person-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_trip_destination_style',
				[
					'label'     => esc_html__( 'Destination', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_trip_show_destination' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_trip_destination_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .trip-destinations',
				]
			);
			$this->add_control(
				'crafto_trip_destination_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .destination-name' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_trip_destination_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trip-destinations i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .trip-destinations svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_trip_show_icon[value]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_trip_destination_icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 15,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .trip-destinations i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .trip-destinations svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_trip_show_icon[value]!' => '',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_trip_review_style',
				[
					'label'     => esc_html__( 'Review', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_trip_show_review' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_trip_reviews_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .trip-reviews',
				]
			);
			$this->add_control(
				'crafto_trip_reviews_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .trip-reviews' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_trip_star_rating_icon_size',
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
						'{{WRAPPER}} .elementor-star-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render tours header bar widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                        = $this->get_settings_for_display();
			$crafto_show_trip_title          = ( isset( $settings['crafto_show_trip_title'] ) && $settings['crafto_show_trip_title'] ) ? $settings['crafto_show_trip_title'] : '';
			$crafto_trip_show_pr_person      = ( isset( $settings['crafto_trip_show_pr_person'] ) && $settings['crafto_trip_show_pr_person'] ) ? $settings['crafto_trip_show_pr_person'] : '';
			$crafto_trip_show_destination    = ( isset( $settings['crafto_trip_show_destination'] ) && $settings['crafto_trip_show_destination'] ) ? $settings['crafto_trip_show_destination'] : '';
			$crafto_trip_show_pr_person_text = ( isset( $settings['crafto_trip_show_pr_person_text'] ) && $settings['crafto_trip_show_pr_person_text'] ) ? $settings['crafto_trip_show_pr_person_text'] : '';
			$migrated                        = isset( $settings['__fa4_migrated']['crafto_trip_show_icon'] );
			$is_new                          = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$icon_tag                        = 'span';
			$crafto_trip_show_review         = ( isset( $settings['crafto_trip_show_review'] ) && $settings['crafto_trip_show_review'] ) ? $settings['crafto_trip_show_review'] : '';

			$crafto_tours_price       = crafto_post_meta( 'crafto_single_tours_price' );
			$crafto_tours_review      = crafto_post_meta( 'crafto_single_tours_review' );
			$crafto_tours_star_rating = crafto_post_meta( 'crafto_single_tours_star_rating' );
			$crafto_tours_destination = crafto_post_meta( 'crafto_single_tours_destination' );

			$crafto_title         = '';
			$tour_destination     = '';
			$crafto_review_output = '';
			$crafto_price_output  = '';
			$crafto_rating_output = '';

			if ( crafto_is_editor_mode() ) { // phpcs:ignore
				$crafto_title         = esc_html__( 'This is a dummy title', 'crafto-addons' );
				$tour_destination     = '<span class="destination-name">' . esc_html__( 'Maldives, South Asia', 'crafto-addons' ) . '</span>';
				$crafto_review_output = esc_html__( '16 Reviews', 'crafto-addons' );
				$crafto_price_output  = esc_html__( '$1599', 'crafto-addons' );
				$crafto_rating_output = esc_html__( '5', 'crafto-addons' );
			} else {
				$crafto_title         = get_the_title();
				$crafto_review_output = $crafto_tours_review;
				$crafto_price_output  = $crafto_tours_price;
				$crafto_rating_output = $crafto_tours_star_rating;
				$tour_destination     = '<span class="destination-name">' . esc_html( $crafto_tours_destination ) . '</span>';
			}
			?>
			<div class="trip-header-wrapper">
				<div class="title-rating-wrapper">
					<?php
					if ( 'yes' === $crafto_show_trip_title && ! empty( $crafto_title ) ) {
						?>
						<<?php echo esc_html( $this->get_settings( 'crafto_trip_title_tag' ) ); ?> class="trip-header-title">
							<?php echo esc_html( $crafto_title ); ?>
						</<?php echo esc_html( $this->get_settings( 'crafto_trip_title_tag' ) ); ?>>
						<?php
					}
					?>
					<ul>
						<?php
						if ( 'yes' === $crafto_trip_show_destination && ! empty( $tour_destination ) ) {
							?>
							<li class="trip-destinations">
								<?php
								if ( ! empty( $settings['crafto_trip_show_icon']['value'] ) ) {
									?>
									<?php
								}
								if ( $is_new || $migrated ) {
									Icons_Manager::render_icon( $settings['crafto_trip_show_icon'], [ 'aria-hidden' => 'true' ] );
								} elseif ( isset( $settings['crafto_trip_show_icon']['value'] ) && ! empty( $settings['crafto_trip_show_icon']['value'] ) ) {
									echo '<i class="' . esc_attr( $settings['crafto_trip_show_icon']['value'] ) . '" aria-hidden="true"></i>';
								}
								if ( ! empty( $settings['crafto_trip_show_icon']['value'] ) ) {
									?>
									</<?php echo $icon_tag; // phpcs:ignore ?>>
									<?php
								}
								?>
								<?php echo $tour_destination; // phpcs:ignore ?>
							</li>
							<?php
						}

						if ( 'yes' === $crafto_trip_show_review && ! empty( $crafto_review_output ) ) {
							?>
							<li>
							<div class="review-star-icon elementor--star-style-star_fontawesome">
								<?php
								$icon           = '';
								$icon_html      = '';
								$rating         = (float) $crafto_rating_output > 5 ? 5 : $crafto_rating_output;
								$floored_rating = ( $rating ) ? (int) $rating : 0;

								if ( $rating ) {
									for ( $stars = 1; $stars <= 5; $stars++ ) {
										if ( $stars <= $floored_rating ) {
											$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
										} else {
											$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
										}
									}
								}

								if ( ! empty( $icon_html ) ) {
									?>
									<div class="elementor-star-rating">
										<?php echo sprintf( '%s', $icon_html ); // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
							</div>
								<?php
								if ( ! empty( $crafto_review_output ) ) {
									?>
									<span class="trip-reviews">
										<?php echo esc_html( $crafto_review_output ); ?>
									</span>
									<?php
								}
								?>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php
				if ( 'yes' === $crafto_trip_show_pr_person && ! empty( $crafto_price_output ) ) {
					?>
					<div class="pricing-wrapper">
						<div class="trip-person-price">
							<?php echo esc_html( $crafto_price_output ); ?>
						</div>
						<span class="trip-person-text">
							<?php echo esc_html( $crafto_trip_show_pr_person_text ); ?>
						</span>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
