<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for Testimonial.
 *
 * @package Crafto
 */

// If class `Testimonial` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Testimonial' ) ) {
	/**
	 * Define `Testimonial` class.
	 */
	class Testimonial extends Widget_Base {
		/**
		 * Retrieve the list of styles the crafto testimonial depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @since 1.3.0
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$testimonial_style = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$testimonial_style[] = 'crafto-widgets-rtl';
				} else {
					$testimonial_style[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$testimonial_style[] = 'crafto-star-rating-rtl';
					$testimonial_style[] = 'crafto-testimonial-rtl-widget';
				}
				$testimonial_style[] = 'crafto-star-rating';
				$testimonial_style[] = 'crafto-testimonial-widget';
			}
			return $testimonial_style;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve testimonial widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-testimonial';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve testimonial widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Testimonial', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve testimonial widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-testimonial crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/testimonial/';
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
				'blockquote',
				'review',
				'author',
				'quote',
				'feedback',
			];
		}

		/**
		 * Register testimonial widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_testimonial_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_testimonial_style',
				[
					'label'       => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'testimonials-style-1',
					'options'     => [
						'testimonials-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'testimonials-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'testimonials-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'testimonials-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'testimonials-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
						'testimonials-style-6' => esc_html__( 'Style 6', 'crafto-addons' ),
						'testimonials-style-7' => esc_html__( 'Style 7', 'crafto-addons' ),
					],
					'label_block' => true,
				]
			);
			$this->start_controls_tabs( 'crafto_testimonial_tabs' );
			$this->start_controls_tab(
				'crafto_testimonial_image_tab',
				[
					'label' => esc_html__( 'Avatar', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_testimonial_image',
				[
					'label'   => esc_html__( 'Avatar', 'crafto-addons' ),
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
					'separator' => 'none',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_testimonial_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_testimonial_name',
				[
					'label'   => esc_html__( 'Name', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'John Doe', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_testimonial_job',
				[
					'label'   => esc_html__( 'Position', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'default' => esc_html__( 'Designer', 'crafto-addons' ),
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_content',
				[
					'label'   => esc_html__( 'Content', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'rows'    => '10',
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec.', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_testimonial_date',
				[
					'label'     => esc_html__( 'Date', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'default'   => esc_html__( '11-06-2025', 'crafto-addons' ),
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_client_logo',
				[
					'label'     => esc_html__( 'Client Logo', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_client_logo_thumbnail',
					'default'   => 'full',
					'separator' => 'none',
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-6',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_testimonial_icon_tab',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-2',
							'testimonials-style-3',
							'testimonials-style-4',
							'testimonials-style-5',
							'testimonials-style-6',
							'testimonials-style-7',
						],
					],
				],
			);
			$this->add_control(
				'crafto_testimonial_review_icon',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'dynamic'   => [
						'active' => true,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.5,
						],
					],
					'default'   => [
						'size' => 4,
					],
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-2',
							'testimonials-style-3',
							'testimonials-style-4',
							'testimonials-style-5',
							'testimonials-style-6',
							'testimonials-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_star_style',
				[
					'label'        => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'star_fontawesome' => esc_html__( 'Font Awesome', 'crafto-addons' ),
						'star_unicode'     => esc_html__( 'Unicode', 'crafto-addons' ),
						'star_bootstrap'   => esc_html__( 'Bootstrap', 'crafto-addons' ),
					],
					'default'      => 'star_bootstrap',
					'render_type'  => 'template',
					'prefix_class' => 'elementor--star-style-',
				]
			);
			$this->add_control(
				'crafto_testimonial_unmarked_star_style',
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
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_testimonial_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_testimonial_box_background',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .testimonials-style-1.testimonials, {{WRAPPER}} .testimonials-style-2 .testimonial-content, {{WRAPPER}} .testimonials-style-3 .testimonial-content, {{WRAPPER}} .testimonials-style-4.testimonials, {{WRAPPER}} .testimonials-style-5.testimonials, {{WRAPPER}} .testimonials-style-6.testimonials, {{WRAPPER}} .testimonials-style-7.testimonials' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .testimonials-style-2 .testimonial-content:after, {{WRAPPER}} .testimonials-style-3 .testimonial-content:after' => 'border-top-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_contentbox_border_color',
				[
					'label'     => esc_html__( 'Box Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .testimonial-content' => 'border-color: {{VALUE}};',
						'{{WRAPPER}} .testimonials-style-3 .testimonial-content:before' => 'border-top-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_testimonial_box_shadow',
					'selector' => '{{WRAPPER}} .testimonials-style-1.testimonials, {{WRAPPER}} .testimonials-style-2 .testimonial-content, {{WRAPPER}} .testimonials-style-3 .testimonial-content, {{WRAPPER}} .testimonials-style-4.testimonials, {{WRAPPER}} .testimonials-style-5.testimonials, {{WRAPPER}} .testimonials-style-6.testimonials, {{WRAPPER}} .testimonials-style-7.testimonials',
				]
			);
			$this->add_control(
				'crafto_testimonial_box_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .testimonials' => 'opacity: {{SIZE}};',
					],
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_testimonial_box_border',
					'selector'  => '{{WRAPPER}} .testimonials',
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-1',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-style-1.testimonials, {{WRAPPER}} .testimonials-style-2 .testimonial-content, {{WRAPPER}} .testimonials-style-3 .testimonial-content, {{WRAPPER}} .testimonials-style-4.testimonials, {{WRAPPER}} .testimonials-style-5.testimonials, {{WRAPPER}} .testimonials-style-6.testimonials, {{WRAPPER}} .testimonials-style-7.testimonials' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_padding',
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
						'{{WRAPPER}} .testimonials-style-1.testimonials, {{WRAPPER}} .testimonials-style-2 .testimonial-content, {{WRAPPER}} .testimonials-style-3 .testimonial-content, {{WRAPPER}} .testimonials-style-4.testimonials, {{WRAPPER}} .testimonials-style-5 .testimonials-author-box, {{WRAPPER}} .testimonials-style-6 .testimonial-middle, {{WRAPPER}} .testimonials-style-7.testimonials' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_margin',
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
						'{{WRAPPER}} .testimonials-style-1.testimonials, {{WRAPPER}} .testimonials-style-2 .testimonial-content, {{WRAPPER}} .testimonials-style-3 .testimonial-content, {{WRAPPER}} .testimonials-style-4.testimonials, {{WRAPPER}} .testimonials-style-5.testimonials, {{WRAPPER}} .testimonials-style-6.testimonials, {{WRAPPER}} .testimonials-style-7.testimonials' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_footer_box_heading',
				[
					'label'     => esc_html__( 'Name Container', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-5',
							'testimonials-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_meta_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .testimonials-style-5 .testimonial-footer, {{WRAPPER}} .testimonials-style-6 .testimonial-footer' => 'border-top-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-5',
							'testimonials-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_footer_box_padding',
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
						'{{WRAPPER}} .testimonials-style-5 .testimonial-footer, {{WRAPPER}} .testimonials-style-6 .testimonial-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_style' => [
							'testimonials-style-5',
							'testimonials-style-6',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_testimonial_image',
				[
					'label'     => esc_html__( 'Avatar', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_style!' => [
							'testimonials-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 20,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-image-box img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_image_border',
					'selector'  => '{{WRAPPER}} .testimonials-image-box img',
					'condition' => [
						'crafto_testimonial_style!' => [
							'testimonials-style-1',
							'testimonials-style-2',
							'testimonials-style-3',
							'testimonials-style-4',
							'testimonials-style-5',
							'testimonials-style-7',
						],
					],
				]
			);
			$this->add_control(
				'crafto_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonials-image-box img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_image_margin',
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
						'{{WRAPPER}} .testimonials-image-box img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_testimonial_client_logo',
				[
					'label'     => esc_html__( 'Client Logo', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_style' => 'testimonials-style-6',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_client_logo_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'default'    => [
						'unit' => '%',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-middle img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_client_logo_margin',
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
						'{{WRAPPER}} .testimonial-middle img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_testimonial_name',
				[
					'label' => esc_html__( 'Name', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_name_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .testimonial-name',
				]
			);
			$this->add_control(
				'crafto_testimonial_name_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .testimonial-name' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_name_margin',
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
						'{{WRAPPER}} .testimonial-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_testimonial_position',
				[
					'label' => esc_html__( 'Position', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_position_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .testimonial-position',
				]
			);
			$this->add_control(
				'crafto_testimonial_position_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .testimonial-position' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_testimonial_content',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_content_typography',
					'selector' => '{{WRAPPER}} .testimonial-content, {{WRAPPER}} .testimonials-style-5 .testimonials-author-details,{{WRAPPER}} .testimonials-style-6 .testimonials-author-details',
				]
			);
			$this->add_control(
				'crafto_testimonial_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .testimonial-content, {{WRAPPER}} .testimonials-style-5 .testimonials-author-details,{{WRAPPER}} .testimonials-style-6 .testimonials-author-details' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_content_margin',
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
						'{{WRAPPER}} .testimonials-style-1 .testimonial-content, {{WRAPPER}} .testimonials-style-4 .testimonial-content, {{WRAPPER}} .testimonials-style-7 .testimonial-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_style' => [
							'testimonials-style-1',
							'testimonials-style-4',
							'testimonials-style-7',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_testimonial_rating_number',
				[
					'label'     => esc_html__( 'Rating Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_number_typography',
					'selector' => '{{WRAPPER}} .star-rating-number',
				]
			);
			$this->add_control(
				'crafto_testimonial_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .star-rating-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_number_margin',
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
						'{{WRAPPER}} .star-rating-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_testimonial_icon',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_style!' => [
							'testimonials-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_icon_size',
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
							'max' => 30,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-star-rating, {{WRAPPER}} .elementor-star-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-star-rating i:not(.elementor-star-empty):before' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_testimonial_style!' => [
							'testimonials-style-1',
						],
					],
				]
			);
			$this->add_control(
				'testimonial_stars_unmarked_color',
				[
					'label'     => esc_html__( 'Unmarked Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-star-rating i:after, {{WRAPPER}} .elementor-star-rating i.elementor-star-empty:before, {{WRAPPER}}.elementor--star-style-star_unicode .elementor-star-rating i' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_testimonial_style!' => [
							'testimonials-style-1',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_testimonial_icon_box_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .elementor-star-rating',
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_testimonial_icon_border',
					'selector'  => '{{WRAPPER}} .elementor-star-rating',
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-6',
						],
					],
				]
			);
			$this->add_control(
				'crafto_testimonial_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-star-rating' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_testimonial_style' => [
							'testimonials-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_icon_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-star-rating, {{WRAPPER}} .elementor-star-rating i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_testimonial_date',
				[
					'label'     => esc_html__( 'Date', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_testimonial_style' => [
							'testimonials-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_testimonial_date_typography',
					'selector' => '{{WRAPPER}} .testimonial-date',
				]
			);
			$this->add_control(
				'crafto_testimonial_date_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .testimonial-date' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_testimonial_datebox_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .testimonial-date',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_testimonial_date_border',
					'selector' => '{{WRAPPER}} .testimonial-date',
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_date_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .testimonial-date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_testimonial_date_padding',
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
						'{{WRAPPER}} .testimonial-date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render testimonial widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                   = $this->get_settings_for_display();
			$crafto_testimonial_image   = '';
			$crafto_testimonial_style   = ( isset( $settings['crafto_testimonial_style'] ) && $settings['crafto_testimonial_style'] ) ? $settings['crafto_testimonial_style'] : '';
			$crafto_testimonial_content = ( isset( $settings['crafto_testimonial_content'] ) && $settings['crafto_testimonial_content'] ) ? $settings['crafto_testimonial_content'] : '';
			$crafto_testimonial_name    = ( isset( $settings['crafto_testimonial_name'] ) && $settings['crafto_testimonial_name'] ) ? $settings['crafto_testimonial_name'] : '';
			$crafto_testimonial_job     = ( isset( $settings['crafto_testimonial_job'] ) && $settings['crafto_testimonial_job'] ) ? $settings['crafto_testimonial_job'] : '';

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'testimonials',
					$settings['crafto_testimonial_style'],
				]
			);

			$this->add_render_attribute(
				'_content',
				'class',
				'testimonial-content',
			);

			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php
			switch ( $crafto_testimonial_style ) {
				case 'testimonials-style-1':
				default:
					?>
					<div class="testimonials-author testimonials-image-box">
						<?php
						if ( ! empty( $settings['crafto_testimonial_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_testimonial_image']['id'] ) ) {
							$settings['crafto_testimonial_image']['id'] = '';
						}
						if ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['id'] ) && ! empty( $settings['crafto_testimonial_image']['id'] ) ) {
							crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['url'] ) && ! empty( $settings['crafto_testimonial_image']['url'] ) ) {
							crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}
						?>
					</div>
					<?php
					if ( ! empty( $crafto_testimonial_content ) || ! empty( $crafto_testimonial_name ) ) {
						?>
						<div class="testimonials-content-box">
							<?php
							if ( ! empty( $crafto_testimonial_content ) ) {
								?>
								<div <?php $this->print_render_attribute_string( '_content' ); ?>>
									<?php echo sprintf( '%s', wp_kses_post( $crafto_testimonial_content ) ); // phpcs:ignore ?>
								</div>
								<?php
							}
							if ( ! empty( $crafto_testimonial_name ) ) {
								?>
								<span class="testimonial-name">
									<?php echo esc_html( $crafto_testimonial_name ); ?>
								</span>
								<?php
							}
							if ( ! empty( $crafto_testimonial_job ) ) {
								?>
								<span class="testimonial-position">
									<?php echo esc_html( $crafto_testimonial_job ); ?>
								</span>
								<?php
							}
							?>
						</div>
						<?php
					}
					break;
				case 'testimonials-style-5':
					?>
					<div class="testimonials-author-box">
						<div class="testimonials-author testimonials-image-box">
							<?php
							if ( ! empty( $settings['crafto_testimonial_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_testimonial_image']['id'] ) ) {
								$settings['crafto_testimonial_image']['id'] = '';
							}
							if ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['id'] ) && ! empty( $settings['crafto_testimonial_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['url'] ) && ! empty( $settings['crafto_testimonial_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							?>
						</div>
						<?php
						if ( ! empty( $crafto_testimonial_content ) ) {
							?>
							<div class="testimonials-author-details">
								<?php echo sprintf( '%s', wp_kses_post( $crafto_testimonial_content ) ); // phpcs:ignore ?>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					if ( ! empty( $crafto_testimonial_job ) || ! empty( $crafto_testimonial_name ) ) {
						?>
						<div class="testimonial-footer">
							<?php
							if ( ! empty( $crafto_testimonial_name ) ) {
								?>
								<span class="testimonial-name">
									<?php echo esc_html( $crafto_testimonial_name ); ?>
								</span>
								<?php
							}
							if ( ! empty( $crafto_testimonial_job ) ) {
								?>
								<span class="testimonial-position">
									<?php echo esc_html( $crafto_testimonial_job ); ?>
								</span>
								<?php
							}
							if ( ! empty( $settings['crafto_testimonial_review_icon']['size'] ) ) {
								echo $this->get_rating_icon( $settings ); // phpcs:ignore
							}
							?>
						</div>
						<?php
					}
					break;
				case 'testimonials-style-2':
				case 'testimonials-style-3':
				case 'testimonials-style-4':
				case 'testimonials-style-7':
					echo $this->get_testimonial_content( $crafto_testimonial_name, $crafto_testimonial_content, $crafto_testimonial_job, $crafto_testimonial_image );  // phpcs:ignore
					break;
				case 'testimonials-style-6':
					?>
					<div class="testimonials-author-box">
						<div class="testimonials-author testimonials-image-box">
							<?php
							if ( ! empty( $settings['crafto_testimonial_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_testimonial_image']['id'] ) ) {
								$settings['crafto_testimonial_image']['id'] = '';
							}
							if ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['id'] ) && ! empty( $settings['crafto_testimonial_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['url'] ) && ! empty( $settings['crafto_testimonial_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							?>
						</div>
						<?php
						if ( ! empty( $settings['crafto_testimonial_review_icon']['size'] ) ) {
							echo $this->get_rating_icon( $settings ); // phpcs:ignore
						}
						?>
					</div>
					<div class="testimonial-middle">
						<?php
						if ( ! empty( $settings['crafto_testimonial_client_logo']['id'] ) && ! wp_attachment_is_image( $settings['crafto_testimonial_client_logo']['id'] ) ) {
							$settings['crafto_testimonial_client_logo']['id'] = '';
						}
						if ( isset( $settings['crafto_testimonial_client_logo'] ) && isset( $settings['crafto_testimonial_client_logo']['id'] ) && ! empty( $settings['crafto_testimonial_client_logo']['id'] ) ) {
							crafto_get_attachment_html( $settings['crafto_testimonial_client_logo']['id'], $settings['crafto_testimonial_client_logo']['url'], $settings['crafto_client_logo_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_testimonial_client_logo'] ) && isset( $settings['crafto_testimonial_client_logo']['url'] ) && ! empty( $settings['crafto_testimonial_client_logo']['url'] ) ) {
							crafto_get_attachment_html( $settings['crafto_testimonial_client_logo']['id'], $settings['crafto_testimonial_client_logo']['url'], $settings['crafto_client_logo_thumbnail_size'] ); // phpcs:ignore
						}
						if ( ! empty( $crafto_testimonial_content ) ) {
							?>
							<div class="testimonials-author-details">
								<?php echo sprintf( '%s', wp_kses_post( $crafto_testimonial_content ) ); // phpcs:ignore ?>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					if ( ! empty( $crafto_testimonial_job ) || ! empty( $crafto_testimonial_name ) ) {
						?>
						<div class="testimonial-footer">
							<?php
							if ( ! empty( $crafto_testimonial_name ) ) {
								?>
								<span class="testimonial-name">
									<?php echo esc_html( $crafto_testimonial_name ); ?>
								</span>
								<?php
							}
							if ( ! empty( $crafto_testimonial_job ) ) {
								?>
								<span class="testimonial-position">
									<?php echo esc_html( $crafto_testimonial_job ); ?>
								</span>
								<?php
							}
							?>
						</div>
						<?php
					}
					break;
			}
			?>
				</div>
			<?php
		}
		/**
		 * @since 2.3.0
		 * @access protected
		 * @param array $settings Widget data.
		 */
		protected function get_rating_icon( $settings ) {
			$layout_type = $this->get_settings( 'crafto_testimonial_style' );
			$icon        = '';

			if ( 'star_unicode' === $settings['crafto_testimonial_star_style'] ) {
				$icon = '&#9733;';

				if ( 'outline' === $settings['crafto_testimonial_unmarked_star_style'] ) {
					$icon = '&#9734;';
				}
			}

			$icon_html      = '';
			$rating         = (float) $settings['crafto_testimonial_review_icon']['size'] > 5 ? 5 : $settings['crafto_testimonial_review_icon']['size'];
			$floored_rating = ( $rating ) ? (int) $rating : 0;
			$result         = ( $rating ) ? number_format_i18n( $rating, 1 ) : 0;

			for ( $stars = 1; $stars <= 5; $stars++ ) {
				if ( $stars <= $floored_rating ) {
					$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
				} elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
					$icon_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">' . $icon . '</i>';
				} else {
					$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
				}
			}

			if ( 'testimonials-style-4' === $layout_type && ! empty( $result ) ) {
				return '<div class="review-star-icon"><div class="star-rating-number">' . $result . '</div><div class="elementor-star-rating">' . $icon_html . '</div></div>';
			} else {
				return '<div class="elementor-star-rating">' . $icon_html . '</div>'; // phpcs:ignore
			}
		}
		/**
		 * Retrieve testimonial content options.
		 *
		 * @param string $crafto_testimonial_name to get name.
		 * @param string $crafto_testimonial_content to get content.
		 * @param string $crafto_testimonial_job to get job content.
		 * @param string $crafto_testimonial_image to get image of testimonial.
		 *
		 * @access public
		 */
		public function get_testimonial_content( $crafto_testimonial_name, $crafto_testimonial_content, $crafto_testimonial_job, $crafto_testimonial_image ) {
			$settings                 = $this->get_settings_for_display();
			$crafto_testimonial_style = ( isset( $settings['crafto_testimonial_style'] ) && $settings['crafto_testimonial_style'] ) ? $settings['crafto_testimonial_style'] : '';
			$crafto_testimonial_date  = $settings['crafto_testimonial_date'];
			if ( $this->get_settings( 'crafto_testimonial_content_hover_animation' ) ) {
				$this->add_render_attribute( '_content', 'class', 'hvr-' . $this->get_settings( 'crafto_testimonial_content_hover_animation' ) );
			}
			if ( 'testimonials-style-7' !== $crafto_testimonial_style ) {
				if ( ! empty( $crafto_testimonial_content ) ) {
					?>
					<div <?php $this->print_render_attribute_string( '_content' ); ?>>
						<?php echo sprintf( '%s', wp_kses_post( $crafto_testimonial_content ) ); // phpcs:ignore ?>
					</div>
					<?php
				}
			}
			?>
			<div class="testimonials-author-box">
				<div class="testimonials-author testimonials-image-box">
					<?php
					if ( ! empty( $settings['crafto_testimonial_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_testimonial_image']['id'] ) ) {
						$settings['crafto_testimonial_image']['id'] = '';
					}
					if ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['id'] ) && ! empty( $settings['crafto_testimonial_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					} elseif ( isset( $settings['crafto_testimonial_image'] ) && isset( $settings['crafto_testimonial_image']['url'] ) && ! empty( $settings['crafto_testimonial_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_testimonial_image']['id'], $settings['crafto_testimonial_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					}
					?>
					</div>
				<div class="testimonials-author-details">
					<?php
					if ( 'testimonials-style-7' === $crafto_testimonial_style ) {
						if ( ! empty( $settings['crafto_testimonial_review_icon']['size'] ) ) {
							echo $this->get_rating_icon( $settings ); // phpcs:ignore
						}
					}
					if ( ! empty( $crafto_testimonial_name ) ) {
						if ( ! empty( $settings['crafto_link']['url'] ) ) {
							?>
							<a <?php $this->print_render_attribute_string( 'link' ); ?>>
								<span class="testimonial-name">
									<?php echo esc_html( $crafto_testimonial_name ); ?>
								</span>
							</a>
							<?php
						} else {
							?>
							<span class="testimonial-name">
								<?php echo esc_html( $crafto_testimonial_name ); ?>
							</span>
							<?php
						}
					}
					if ( ! empty( $crafto_testimonial_job ) ) {
						?>
						<span class="testimonial-position">
							<?php echo esc_html( $crafto_testimonial_job ); ?>
						</span>
						<?php
					}
					if ( 'testimonials-style-2' === $crafto_testimonial_style || 'testimonials-style-3' === $crafto_testimonial_style ) {
						if ( ! empty( $settings['crafto_testimonial_review_icon']['size'] ) ) {
							echo $this->get_rating_icon( $settings ); // phpcs:ignore
						}
					}
					?>
				</div>
			</div>
			<?php
			if ( 'testimonials-style-7' === $crafto_testimonial_style ) {
				if ( ! empty( $crafto_testimonial_content ) ) {
					?>
					<div <?php $this->print_render_attribute_string( '_content' ); ?>>
						<?php echo sprintf( '%s', wp_kses_post( $crafto_testimonial_content ) ); // phpcs:ignore ?>
					</div>
					<?php
				}
			}
			if ( 'testimonials-style-4' === $crafto_testimonial_style ) {
				?>
				<div class="testimonial-footer">
					<?php
					if ( ! empty( $settings['crafto_testimonial_review_icon']['size'] ) ) {
						echo $this->get_rating_icon( $settings ); // phpcs:ignore
					}
					if ( ! empty( $crafto_testimonial_date ) ) {
						?>
						<div class="testimonial-date">
							<?php echo esc_html( $crafto_testimonial_date ); ?>
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
