<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for post likes.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_post_template() ) {
	return;
}

// If class `Post_Likes` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Likes' ) ) {
	/**
	 * Define `Post_Likes` class.
	 */
	class Post_Likes extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-likes';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Likes', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'line-icon-Like crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-likes/';
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
				'likes',
				'vote',
				'reaction',
			];
		}

		/**
		 * Register post likes widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_style_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_post_likes_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-blog-detail-like a',
				]
			);
			$this->start_controls_tabs( 'crafto_post_likes_style_tabs' );
			$this->start_controls_tab(
				'crafto_post_likes_style_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_post_likes_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .crafto-blog-detail-like a',
				]
			);
			$this->add_control(
				'crafto_post_likes_text_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .posts-like-count' => 'color: {{VALUE}};',
						'{{WRAPPER}} .posts-like'       => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_post_likes_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-blog-detail-like i' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_post_likes_shadow',
					'selector' => '{{WRAPPER}} .crafto-blog-detail-like a',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_post_likes_style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_post_likes_hover_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .crafto-blog-detail-like a:hover',
				]
			);
			$this->add_control(
				'crafto_post_likes_text_hover_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-blog-detail-like a:hover .posts-like-count' => 'color: {{VALUE}};',
						'{{WRAPPER}} .crafto-blog-detail-like a:hover .posts-like' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_post_likes_hover_shadow',
					'selector' => '{{WRAPPER}} .crafto-blog-detail-like a:hover',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_post_likes_border',
					'default'  => '1px',
					'selector' => '{{WRAPPER}} .crafto-blog-detail-like a',
				]
			);
			$this->add_responsive_control(
				'crafto_post_likes_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-blog-detail-like a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_likes_margin',
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
						'{{WRAPPER}} .crafto-blog-detail-like a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_likes_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'em',
						'%',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-blog-detail-like a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_post_likes_counter_style_heading',
				[
					'label'     => esc_html__( 'Like counter', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_post_likes_style_font_weight',
				[
					'label'     => esc_html__( 'Font weight', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '600',
					'options'   => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'100'     => esc_html__( '100', 'crafto-addons' ),
						'200'     => esc_html__( '200', 'crafto-addons' ),
						'300'     => esc_html__( '300', 'crafto-addons' ),
						'400'     => esc_html__( '400', 'crafto-addons' ),
						'500'     => esc_html__( '500', 'crafto-addons' ),
						'600'     => esc_html__( '600', 'crafto-addons' ),
						'700'     => esc_html__( '700', 'crafto-addons' ),
						'800'     => esc_html__( '800', 'crafto-addons' ),
						'900'     => esc_html__( '900', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-blog-detail-like a .posts-like-count' => 'font-weight: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post likes widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			if ( class_exists( 'Crafto_Blog_Post_Likes' ) ) {
				?>
				<div class="crafto-blog-detail-like">
					<ul>
						<li><?php echo \Crafto_Blog_Post_Likes::crafto_get_simple_likes_button( get_the_ID() ); // phpcs:ignore ?></li>
					</ul>
				</div>
				<?php
			} else {
				?>
				<div class="alert alert-warning" role="alert"><?php echo esc_html__( 'Post likes does not visible may be missing that file.', 'crafto-addons' ); ?></div>
				<?php
			}
		}
	}
}
