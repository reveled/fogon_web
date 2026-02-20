<?php
/**
 * Extend Widgets Features
 *
 * @package Crafto
 */

namespace CraftoAddons\Classes;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group;


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Widget_Extended` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Classes\Widget_Extended' ) ) {

	/**
	 * Define Widget_Extended class
	 */
	class Widget_Extended {
		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'elementor/element/text-editor/section_editor/before_section_end', [ $this, 'crafto_add_text_editor_section_tab' ], 10, 2 );

			add_action( 'elementor/element/icon/section_style_icon/before_section_end', [ $this, 'crafto_add_icon_section_tab' ], 10, 2 );

			if ( class_exists( 'LearnPress' ) ) {
				add_action( 'elementor/element/learnpress_list_courses/section_title/before_section_end', [ $this, 'crafto_add_learnpress_title_courses_tab' ], 10, 2 );
				add_action( 'elementor/element/learnpress_list_courses/section_instructor/before_section_end', [ $this, 'crafto_add_learnpress_title_instractor_tab' ], 10, 2 );
				add_action( 'elementor/element/learnpress_list_courses/section_price/before_section_end', [ $this, 'crafto_add_learnpress_price_tab' ], 10, 2 );
				add_action( 'elementor/element/learnpress_list_courses/section_course_image/after_section_end', [ $this, 'crafto_add_list_courses_custom_section_tab' ], 10, 2 );
				add_action( 'elementor/element/learnpress_list_courses/section_title/before_section_start', [ $this, 'crafto_add_list_courses_general_section_tab' ], 10, 2 );
			}

			add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'crafto_scrolling_animation_section_tab' ], 10, 2 );
			add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'crafto_entrance_animation_section_tab' ], 10, 2 );
			add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'crafto_float_animation_section_tab' ], 10, 2 );
			add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'crafto_advanced_section_tab' ], 10, 2 );

			add_action( 'elementor/frontend/before_render', [ $this, 'crafto_custom_animation_html_render' ], 10, 2 );
			add_action( 'elementor/frontend/before_render', [ $this, 'crafto_float_animation_html_render' ], 10, 2 );
		}

		/**
		 * Text Editor Widget's extra options
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param object $args Widget arguments.
		 * @access public
		 */
		public function crafto_add_text_editor_section_tab( $element, $args ) {

			$element->add_responsive_control(
				'crafto_margin_bottom_space',
				[
					'label'     => esc_html__( 'Bottom Spacing', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-widget-text-editor p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
		}

		/**
		 * Learnpress Title Courses Widget's remove options
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_add_learnpress_title_courses_tab( $element ) {

			$element->remove_control( 'title_text_display' );
		}

		/**
		 * Learnpress Genral Widget's extra options.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_add_list_courses_general_section_tab( $element ) {

			$element->start_controls_section(
				'crafto_layout_general_tab_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$element->add_control(
				'crafto_list_courses_background_color',
				[
					'label'     => esc_html__( 'Box Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .learn-press-courses .course-content' => 'background-color: {{VALUE}};',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_list_courses_padding',
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
						'{{WRAPPER}} .learn-press-courses .course-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$element->end_controls_section();
		}

		/**
		 * Learnpress Title Instructor Widget's remove option.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_add_learnpress_title_instractor_tab( $element ) {

			$element->remove_control( 'instructor_text_display' );
		}

		/**
		 * Learnpress price Widget's remove option.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_add_learnpress_price_tab( $element ) {

			$element->remove_control( 'price_text_display' );
		}


		/**
		 * Icon Widget's extra options
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param object $args Widget arguments.
		 * @access public
		 */
		public function crafto_add_icon_section_tab( $element, $args ) {

			$element->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_icon_box_shadow',
					'selector' => '{{WRAPPER}} .elementor-icon',
				]
			);

			$element->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_icon_background',
					'selector'       => '{{WRAPPER}} .elementor-icon i:before',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
		}

		/**
		 * Learnpress List Courses Widget's extra options
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param object $args Widget arguments.
		 * @access public
		 */
		public function crafto_add_list_courses_custom_section_tab( $element, $args ) {

			$element->start_controls_section(
				'crafto_layout_category_tab_style',
				[
					'label' => esc_html__( 'Category', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$element->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_category_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .course-content .course-categories a',
				]
			);
			$element->start_controls_tabs( 'crafto_category_color_tab' );
				$element->start_controls_tab(
					'crafto_category_normal_color',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$element->add_control(
					'crafto_category_text_normal_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .course-content .course-categories a' => 'color: {{VALUE}};',
						],
					]
				);
				$element->end_controls_tab();
				$element->start_controls_tab(
					'crafto_category_hover_color',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$element->add_control(
					'crafto_category_text_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .course-categories a:hover' => 'color: {{VALUE}};',
						],
					]
				);
				$element->end_controls_tab();
			$element->end_controls_tabs();
			$element->end_controls_section();

			$element->start_controls_section(
				'crafto_layout_lessons_tab_style',
				[
					'label' => esc_html__( 'Lessons', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$element->add_control(
				'crafto_lessons_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .meta-item-lesson .course-count-item' => 'color: {{VALUE}};',
					],
				]
			);
			$element->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_lessons_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .meta-item-lesson .course-count-item',
				]
			);
			$element->add_control(
				'crafto_lessons_icon',
				[
					'label'     => esc_html__( 'Lesson Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$element->add_control(
				'crafto_lessons_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .meta-item-lesson:before' => 'color: {{VALUE}};',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_lessons_icon_size',
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
						'{{WRAPPER}} .meta-item-lesson:before' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_lessons_icon_margin',
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
						'{{WRAPPER}} .meta-item-lesson:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$element->end_controls_section();
			$element->start_controls_section(
				'crafto_layout_students_tab_style',
				[
					'label' => esc_html__( 'Students', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$element->add_control(
				'crafto_students_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .meta-item-student .course-count-student' => 'color: {{VALUE}};',
					],
				]
			);
			$element->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_students_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .meta-item-student .course-count-student',
				]
			);
			$element->add_control(
				'crafto_students_icon',
				[
					'label'     => esc_html__( 'Student Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$element->add_control(
				'crafto_students_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .meta-item-student:before' => 'color: {{VALUE}};',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_students_icon_size',
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
						'{{WRAPPER}} .meta-item-student:before' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$element->add_responsive_control(
				'crafto_students_icon_margin',
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
						'{{WRAPPER}} .meta-item-student:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$element->end_controls_section();
		}

		/**
		 * Crafto Advanced Options
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_advanced_section_tab( $element ) {

			$element->start_controls_section(
				'crafto_layout_tab_style',
				[
					'label' => esc_html__( 'Crafto Settings', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_ADVANCED,
				]
			);

			$element->add_responsive_control(
				'crafto_overflow_settings',
				[
					'label'     => esc_html__( 'Overflow', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''        => esc_html__( 'Default', 'crafto-addons' ),
						'hidden'  => esc_html__( 'Hidden', 'crafto-addons' ),
						'visible' => esc_html__( 'Visible', 'crafto-addons' ),
						'none'    => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} > .elementor-widget-container' => 'overflow: {{VALUE}}',
					],
				]
			);
			$element->end_controls_section();
		}

		/**
		 *  Crafto Animation Options ( Scrolling Animation )
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_scrolling_animation_section_tab( $element ) {
			if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
				Crafto_Common_Animation_Group::add_scrolling_animation_controls( $element );
			}
		}

		/**
		 * Crafto Animation Options ( Anime(JS) Animation )
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_entrance_animation_section_tab( $element ) {
			if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
				Crafto_Common_Animation_Group::add_entrance_animation_controls( $element );
			}
		}

		/**
		 * Crafto Float Animation Options.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_float_animation_section_tab( $element ) {
			if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
				Crafto_Common_Animation_Group::add_float_animation_controls( $element );
			}
		}

		/**
		 * Crafto custom animation render on frontend
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_custom_animation_html_render( $element ) {
			if ( 'section' !== $element->get_name() && 'column' !== $element->get_name() && 'container' !== $element->get_name() ) {
				if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
					Crafto_Common_Animation_Group::render_custom_animation( $element );
				}
			}
		}

		/**
		 * Crafto float animation render on frontend.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @access public
		 */
		public function crafto_float_animation_html_render( $element ) {
			if ( 'section' !== $element->get_name() && 'column' !== $element->get_name() && 'container' !== $element->get_name() ) {
				if ( class_exists( 'CraftoAddons\Controls\Groups\Crafto_Common_Animation_Group' ) ) {
					Crafto_Common_Animation_Group::crafto_render_float_custom_animation( $element );
				}
			}
		}
	}
}
