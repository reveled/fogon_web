<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;  // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

/**
 *
 * Crafto widget for star rating.
 *
 * @package Crafto
 */

// If class `Star_Rating` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Star_Rating' ) ) {
	/**
	 * Define `Star_Rating` class.
	 */
	class Star_Rating extends Widget_Base {
		/**
		 * Retrieve the list of styles the star rating widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$star_rating_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$star_rating_styles[] = 'crafto-widgets-rtl';
				} else {
					$star_rating_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$star_rating_styles[] = 'crafto-star-rating-rtl';
				}
				$star_rating_styles[] = 'crafto-star-rating';
			}
			return $star_rating_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve star rating widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-star-rating';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve star rating widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Rating', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve star rating widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-rating crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/rating/';
		}
		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the star rating widget belongs to.
		 *
		 * Used to determine where to display the widget in the editor.
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
				'rate',
				'review',
				'score',
				'user',
			];
		}

		/**
		 * Register star rating widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_rating_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_rating_styles',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'rating-style-1',
					'options' => [
						'rating-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'rating-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_rating_star',
				[
					'label'   => esc_html__( 'Star Rating', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'dynamic' => [
						'active' => true,
					],
					'range'   => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.5,
						],
					],
					'default' => [
						'size' => 4,
					],
				]
			);
			$this->add_control(
				'crafto_rating_style',
				[
					'label'        => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'star_fontawesome' => esc_html__( 'Font Awesome', 'crafto-addons' ),
						'star_unicode'     => esc_html__( 'Unicode', 'crafto-addons' ),
						'star_bootstrap'   => esc_html__( 'Bootstrap', 'crafto-addons' ),
					],
					'default'      => 'star_fontawesome',
					'render_type'  => 'template',
					'prefix_class' => 'elementor--star-style-',
				]
			);
			$this->add_control(
				'crafto_unmarked_rating_style',
				[
					'label'        => esc_html__( 'Unmarked Style', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'solid'   => [
							'title' => esc_html__( 'Solid', 'crafto-addons' ),
							'icon'  => 'eicon-star',
						],
						'outline' => [
							'title' => esc_html__( 'Outline', 'crafto-addons' ),
							'icon'  => 'eicon-star-o',
						],
					],
					'default'      => 'solid',
					'prefix_class' => 'elementor-star-',
				]
			);
			$this->add_control(
				'crafto_rating_review_number',
				[
					'label'     => esc_html__( 'Reviews', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( '2505 Reviews', 'crafto-addons' ),
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_rating_review_text',
				[
					'label'     => esc_html__( 'Score', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Excellent score', 'crafto-addons' ),
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_rating_image_section',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_control(
				'crafto_rating_image',
				[
					'label'   => esc_html__( 'Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
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
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_rating_genaral_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_rating_aligment',
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
						'right' => is_rtl() ? 'end'   : 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .star-rating-wrap' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_rating_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .star-rating-wrap:not(.rating-style-2) .rating-content-box, {{WRAPPER}} .rating-style-2.star-rating-wrap',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_rating_shadow',
					'selector' => '{{WRAPPER}} .star-rating-wrap',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_rating_border',
					'selector'  => '{{WRAPPER}} .rating-content-box',
					'condition' => [
						'crafto_rating_styles' => 'rating-style-2',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .star-rating-wrap:not(.rating-style-2) .rating-content-box, {{WRAPPER}} .rating-style-2.star-rating-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_padding',
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
						'{{WRAPPER}} .rating-content-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_margin',
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
						'{{WRAPPER}} .star-rating-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_rating_styles' => 'rating-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_star_rating_content_box',
				[
					'label'     => esc_html__( 'Logo Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_rating_review_text_color',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .rating-style-1.star-rating-wrap',
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_review_text_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .rating-style-1.star-rating-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_rating_image_style_section',
				[
					'label'     => esc_html__( 'Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_image_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'unit' => '%',
					],
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'range'      => [
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
						'px' => [
							'min' => 1,
							'max' => 200,
						],
						'vw' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_image_spacing',
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
						'{{WRAPPER}} img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_rating_number_style_section',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'           => 'crafto_rating_number_typography',
					'fields_options' => [
						'line_height' => [
							'size_units' => [
								'px',
								'%',
								'em',
								'rem',
								'custom',
							],
						],
					],
					'selector'       => '{{WRAPPER}} .star-rating-number',
				]
			);
			$this->add_control(
				'crafto_rating_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .star-rating-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_review_icon_style_section',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_review_icon_typography',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 15,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .review-star-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_review_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .review-star-icon i:not(.elementor-star-empty):before' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_review_icon_unmarked_color',
				[
					'label'     => esc_html__( 'Unmarked Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .review-star-icon i:after, {{WRAPPER}} .review-star-icon i.elementor-star-empty:before, {{WRAPPER}}.elementor--star-style-star_unicode .review-star-icon i' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_review_icon_margin',
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
						'{{WRAPPER}} .review-star-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_rating_review_text_style_section',
				[
					'label'     => esc_html__( 'Reviews', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_rating_review_text_typography',
					'selector' => '{{WRAPPER}} .rating-review-number',
				]
			);
			$this->add_control(
				'crafto_rating_review_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .rating-review-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_review_text_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .rating-review-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_rating_label_style',
				[
					'label'     => esc_html__( 'Score', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_rating_styles' => 'rating-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'           => 'crafto_typography',
					'fields_options' => [
						'line_height' => [
							'size_units' => [
								'px',
								'%',
								'em',
								'rem',
								'custom',
							],
						],
					],
					'selector'       => '{{WRAPPER}} .review-text',
				]
			);
			$this->add_control(
				'crafto_rating_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .review-text' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_rating_label_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .review-text',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_rating_label_border',
					'selector' => '{{WRAPPER}} .review-text',
				]
			);
			$this->add_responsive_control(
				'crafto_rating_label_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .review-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_rating_label_padding',
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
						'{{WRAPPER}} .review-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}
		/**
		 * Render star rating widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings             = $this->get_settings_for_display();
			$crafto_rating_styles = $this->get_settings( 'crafto_rating_styles' );
			$crafto_review_number = $this->get_settings( 'crafto_rating_review_number' );
			$crafto_review_text   = $this->get_settings( 'crafto_rating_review_text' );

			$this->add_render_attribute(
				'wrapper',
				[
					'class' => [
						'star-rating-wrap',
						$crafto_rating_styles,
					],
				]
			);
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<div class="rating-content-box">
					<?php
					$this->get_rating_icon( $settings );
					if ( 'rating-style-1' === $crafto_rating_styles ) {
						if ( ! empty( $crafto_review_number ) || ! empty( $crafto_review_text ) ) {
							?>
							<div class="star-rating-content">
								<?php
								if ( ! empty( $crafto_review_number ) ) {
									?>
									<span class="rating-review-number">
										<?php echo sprintf( '%s', $crafto_review_number ); // phpcs:ignore ?>
									</span>
									<?php
								}

								if ( ! empty( $crafto_review_text ) ) {
									?>
									<div class="review-text">
										<?php echo sprintf( '%s', $crafto_review_text ); // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
						}
					}
					?>
				</div>
				<?php
				if ( ! empty( $settings['crafto_rating_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_rating_image']['id'] ) ) {
					$settings['crafto_rating_image']['id'] = '';
				}
				if ( isset( $settings['crafto_rating_image'] ) && isset( $settings['crafto_rating_image']['id'] ) && ! empty( $settings['crafto_rating_image']['id'] ) ) {
					crafto_get_attachment_html( $settings['crafto_rating_image']['id'], $settings['crafto_rating_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
				} elseif ( isset( $settings['crafto_rating_image'] ) && isset( $settings['crafto_rating_image']['url'] ) && ! empty( $settings['crafto_rating_image']['url'] ) ) {
					crafto_get_attachment_html( $settings['crafto_rating_image']['id'], $settings['crafto_rating_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
				}
				?>
			</div>
			<?php
		}

		/**
		 * Retrieve Rating Icon
		 *
		 * @since 1.0
		 * @access protected
		 * @param array $item Widget data.
		 */
		protected function get_rating_icon( $item ) {
			$settings             = $this->get_settings_for_display();
			$crafto_rating_styles = $settings['crafto_rating_styles'];
			$icon                 = '';

			if ( 'star_unicode' === $item['crafto_rating_style'] ) {
				$icon = '&#9733;';
				if ( 'outline' === $item['crafto_unmarked_rating_style'] ) {
					$icon = '&#9734;';
				}
			}

			$icon_html      = '';
			$rating         = (float) $item['crafto_rating_star']['size'] > 5 ? 5 : $item['crafto_rating_star']['size'];
			$floored_rating = ( $rating ) ? (int) $rating : 0;
			$result         = ( $rating ) ? number_format_i18n( $rating, 1 ) : 0;

			if ( $rating ) {
				for ( $stars = 1; $stars <= 5; $stars++ ) {
					if ( $stars <= $floored_rating ) {
						$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
					} elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
						$icon_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">' . $icon . '</i>';
					} else {
						$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
					}
				}
			}

			if ( ! empty( $result ) || ! empty( $icon_html ) ) {
				?>
				<div class="review-star-icon">
					<?php
					if ( 'rating-style-1' === $crafto_rating_styles ) {
						if ( ! empty( $result ) ) {
							?>
							<div class="star-rating-number">
								<?php echo esc_html( $result ); ?>
							</div>
							<?php
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
			}
		}
	}
}
