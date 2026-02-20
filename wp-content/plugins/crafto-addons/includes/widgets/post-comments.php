<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for post comments.
 *
 * @package Crafto
 */

// If class `Post_Comments` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Comments' ) ) {
	/**
	 * Define `Post_Comments` class.
	 */
	class Post_Comments extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-comments';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Comments', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-comments crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-comments/';
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
		 * Register post comments widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_comment_title_style',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .comment-reply-title',
				]
			);
			$this->add_control(
				'crafto_comment_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .comment-reply-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_comments_name',
				[
					'label' => esc_html__( 'Name', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_name_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .logged-in-as, {{WRAPPER}} .comment-text-box .comment-title-edit-link a',
				]
			);
			$this->start_controls_tabs( 'crafto_comment_name_tabs' );
			$this->start_controls_tab(
				'crafto_comment_name_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_comment_name_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .logged-in-as' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_comment_link_text_color',
				[
					'label'     => esc_html__( 'Link Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .logged-in-as a, {{WRAPPER}} .comment-text-box .comment-title-edit-link a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_comment_name_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_comment_link_hover_text_color',
				[
					'label'     => esc_html__( 'Link Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .logged-in-as a:hover, {{WRAPPER}} .comment-text-box .comment-title-edit-link a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_author_image',
				[
					'label' => esc_html__( 'Avatar', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_avatar_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 150,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-comments-wrap .blog-comment li .comment-image-box' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_avatar_icon_margin',
				[
					'label'     => esc_html__( 'space', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-comments-wrap .blog-comment li .comment-image-box' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .crafto-comments-wrap .blog-comment li .comment-image-box' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_author_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-comments-wrap .blog-comment li .comment-image-box img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_comment_Fields_style',
				[
					'label' => esc_html__( 'Fields', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_comment_label_style',
				[
					'label' => esc_html__( 'Label', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .crafto-comment-form label',
				]
			);
			$this->add_control(
				'crafto_comment_label_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-comment-form label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_comment_style_input_separator',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control(
				'crafto_comment_style_input',
				[
					'label' => esc_html__( 'Input', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_comment_input_box_background',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]'   => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]'  => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]'    => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap textarea'              => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_input_box_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-comments-wrap input[type*="text"], 
					{{WRAPPER}} .crafto-comments-wrap input[type*="email"], 
					{{WRAPPER}} .crafto-comments-wrap input[type*="url"],
					{{WRAPPER}} .crafto-comments-wrap textarea',
				]
			);
			$this->add_control(
				'crafto_comment_input_box_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]' => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap textarea'             => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_comment_input_box_placeholder_color',
				[
					'label'     => esc_html__( 'Placeholder Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]::-webkit-input-placeholder'  => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]::-moz-placeholder'           => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]:-ms-input-placeholder'       => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]::-webkit-input-placeholder' => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]::-moz-placeholder'          => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]:-ms-input-placeholder'      => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]::-webkit-input-placeholder'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]::-moz-placeholder'            => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]:-ms-input-placeholder'        => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap textarea::-webkit-input-placeholder'             => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap textarea::-moz-placeholder'                      => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-comments-wrap textarea:-ms-input-placeholder'                  => 'color: {{VALUE}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_comment_border_tabs' );
			$this->start_controls_tab(
				'crafto_comment_active_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_comment_input_border',
					'selector' => '{{WRAPPER}} .crafto-comments-wrap input[type*="text"], 
					{{WRAPPER}} .crafto-comments-wrap input[type*="email"], 
					{{WRAPPER}} .crafto-comments-wrap input[type*="url"],
					{{WRAPPER}} .crafto-comments-wrap textarea',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_comment_input_box_shadow',
					'selector' => '{{WRAPPER}} .crafto-comments-wrap input[type*="text"], 
					{{WRAPPER}} .crafto-comments-wrap input[type*="email"], 
					{{WRAPPER}} .crafto-comments-wrap input[type*="url"],
					{{WRAPPER}} .crafto-comments-wrap textarea',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_comment_border_focus_tab',
				[
					'label' => esc_html__( 'Focus', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_blog_post_meta_author_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]:focus, 
						{{WRAPPER}} .crafto-comments-wrap input[type*="email"]:focus, 
						{{WRAPPER}} .crafto-comments-wrap input[type*="url"]:focus,
						{{WRAPPER}} .crafto-comments-wrap textarea:focus' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_comment_input_box_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]'  => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]'   => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
						'{{WRAPPER}} .crafto-comments-wrap textarea'             => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_comment_input_box_margin',
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
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .crafto-comments-wrap textarea'             => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_comment_input_box_padding',
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
						'{{WRAPPER}} .crafto-comments-wrap input[type*="text"]'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .crafto-comments-wrap input[type*="url"]'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .crafto-comments-wrap textarea'             => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_comment_style_textarea_separator',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->add_control(
				'crafto_comment_style_textarea',
				[
					'label' => esc_html__( 'Textarea', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_comment_textarea_resize',
				[
					'label'     => esc_html__( 'Resize', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'vertical',
					'options'   => [
						'none'       => esc_html__( 'None', 'crafto-addons' ),
						'horizontal' => esc_html__( 'Horizontal', 'crafto-addons' ),
						'vertical'   => esc_html__( 'Vertical', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-comments-wrap textarea' => 'resize: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_comment_textarea_box_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 100,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-comments-wrap textarea' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_comment_button_style',
				[
					'label' => esc_html__( 'Comment Button', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .submit',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_comment_button_box_shadow',
					'selector' => '{{WRAPPER}} .submit',
				]
			);
			$this->add_control(
				'crafto_comment_button_width',
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
							'min' => 0,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .submit' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_comment_button_tabs' );
			$this->start_controls_tab(
				'crafto_comment_button_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_comment_button_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .submit',
				]
			);
			$this->add_control(
				'crafto_comment_button_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .submit' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_comment_button_border',
					'selector' => '{{WRAPPER}} .submit',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_comment_button_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_comment_button_hover_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .submit:hover',
				]
			);
			$this->add_control(
				'crafto_comment_button_hover_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .submit:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_comment_button_hover_border',
					'selector' => '{{WRAPPER}} .submit:hover',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_comment_button_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .submit' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_comment_button_margin',
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
						'{{WRAPPER}} .submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_comment_button_padding',
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
						'{{WRAPPER}} .submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_comment_reply-label_style',
				[
					'label' => esc_html__( 'Reply Label', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_reply-label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} a.comment-reply-link.inner-link',
				]
			);
			$this->start_controls_tabs( 'crafto_comment_reply-label_tabs' );
			$this->start_controls_tab(
				'crafto_comment_reply-label_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_comment_reply-label_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.comment-reply-link.inner-link' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_comment_reply-label_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a.comment-reply-link.inner-link',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_comment_reply-label_border',
					'selector' => '{{WRAPPER}} a.comment-reply-link.inner-link',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_comment_reply-label_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_comment_reply-label_hover_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} a.comment-reply-link.inner-link:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_comment_reply-label_hover_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a.comment-reply-link.inner-link:hover',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_comment_reply-label_hover_border',
					'selector' => '{{WRAPPER}} a.comment-reply-link.inner-link:hover',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_comment_date-time_style',
				[
					'label' => esc_html__( 'Date & Time', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_date-time_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .comment-text-box .comments-date',
				]
			);
			$this->add_control(
				'crafto_comment_date-time_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .comments-date' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_comment_style',
				[
					'label' => esc_html__( 'Comment', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_comment_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .crafto-comments-wrap .blog-comment li ul.children li:last-child',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_comment_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .comment-text p',
				]
			);
			$this->add_control(
				'crafto_comment_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .comment-text p' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post comments widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			// If comments are open or we have at least one comment, load up the comment template.
			if ( ( comments_open() || get_comments_number() ) && get_option( 'thread_comments' ) ) {
				?>
				<div class="crafto-comments-wrap">
					<?php comments_template(); ?>
				</div>
				<?php
			} else {
				?>
				<div class="alert alert-warning" role="alert">
					<?php echo esc_html__( 'Comments are closed. Switch on comments from either the discussion box on the WordPress post edit screen or from the WordPress discussion settings.', 'crafto-addons' ); ?>
				</div>
				<?php
			}
		}
	}
}
