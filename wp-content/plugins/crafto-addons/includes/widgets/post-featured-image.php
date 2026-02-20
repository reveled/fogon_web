<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for image.
 *
 * @package Crafto
 */

// If class `Post_Featured_Image` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Featured_Image' ) ) {
	/**
	 * Define `Post-Feature-Image` class.
	 */
	class Post_Featured_Image extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-feature-image';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Featured Image', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-image crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-featured-image/';
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
				'gallery',
				'format',
				'video',
				'blockquote',
				'audio',
				'photo',
				'visual',
				'thumbnail',
				'post',
				'single',
				'blog',
				'post image',
			];
		}

		/**
		 * Register post featured image widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_content_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'This is a placeholder featured image, the original post image is pulled from relevant post.', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'crafto_thumbnail',
				[
					'label'          => esc_html__( 'Image Size', 'crafto-addons' ),
					'type'           => Controls_Manager::SELECT,
					'default'        => 'full',
					'options'        => function_exists( 'crafto_get_thumbnail_image_sizes' ) ? crafto_get_thumbnail_image_sizes() : [],
					'style_transfer' => true,
				]
			);
			$this->add_control(
				'crafto_show_caption_title',
				[
					'label'     => esc_html__( 'Show Image Caption', 'crafto-addons' ),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off' => esc_html__( 'No', 'crafto-addons' ),
					'default'   => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_featured_img_text_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'start'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'end'    => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .blog-image, {{WRAPPER}} .blog-image .wp-caption-text' => 'text-align: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'     => 'crafto_featured_img_css_filters',
					'selector' => '{{WRAPPER}} .blog-image img',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_featured_img_box_shadow',
					'exclude'  => [
						'crafto_image_box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .blog-image img',
				]
			);
			$this->add_control(
				'crafto_featured_img_opacity',
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
						'{{WRAPPER}} .blog-image img' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_featured_img_content_margin',
				[
					'label'     => esc_html__( 'Bottom Spacing', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => '',
						'unit' => 'px',
					],
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 500,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .blog-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_featured_img_border',
					'selector'  => '{{WRAPPER}} .blog-image img',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_featured_img_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
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
						'{{WRAPPER}} .blog-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_caption',
				[
					'label' => esc_html__( 'Caption', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_author_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .wp-caption-text',
				]
			);
			$this->add_control(
				'crafto_caption_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .wp-caption-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_caption_margin',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => -2000,
							'max' => 2000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .wp-caption-text' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post featured image widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings           = $this->get_settings_for_display();
			static $did_posts   = [];
			$elementor_instance = \Elementor\Plugin::instance();
			$post               = get_post();

			if ( post_password_required( $post->ID ) ) {
				return get_the_password_form( $post->ID );
			}

			// Avoid recursion.
			if ( isset( $did_posts[ $post->ID ] ) ) {
				return;
			}

			$did_posts[ $post->ID ] = true;
			// End avoid recursion.

			$editor                    = $elementor_instance->editor;
			$is_edit_mode              = $editor->is_edit_mode();
			$crafto_thumbnail          = ( isset( $settings['crafto_thumbnail'] ) && $settings['crafto_thumbnail'] ) ? $settings['crafto_thumbnail'] : 'full';
			$crafto_show_caption_title = $this->get_settings( 'crafto_show_caption_title' );

			if ( ! $is_edit_mode && ! is_preview() && ! is_singular( 'themebuilder' ) ) {
				// Include Post Format Data.
				if ( ! post_password_required() ) {
					/* Image Alt, Title, Caption */
					$crafto_blog_image           = crafto_post_meta( 'crafto_featured_image' );
					$crafto_post_layout_bg_image = crafto_post_meta( 'crafto_post_layout_bg_image' );

					if ( ! is_singular( 'post' ) ) {
						$crafto_blog_image = '0';
					}

					if ( is_singular( 'post' ) && ( has_post_thumbnail() && '0' !== $crafto_blog_image ) || ! empty( $crafto_post_layout_bg_image ) ) {
						?>
						<div class="blog-image">
							<?php
							// Lazy-loading attributes should be skipped for thumbnails since they are immediately in the viewport.
							if ( ! empty( $crafto_post_layout_bg_image ) ) {
								echo '<img src="' . esc_url( $crafto_post_layout_bg_image ) . '" alt="' . esc_attr__( 'Featured Image', 'crafto-addons' ) . '" />';
							} else {
								the_post_thumbnail( $crafto_thumbnail, array( 'loading' => false ) );
							}

							if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) {
								?>
								<?php
								if ( 'yes' === $crafto_show_caption_title ) {
									?>
									<figcaption class="wp-caption-text">
										<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
									</figcaption>
									<?php
								}
								?>
								<?php
							}
							?>
						</div>
						<?php
					} elseif ( has_post_thumbnail() ) {
						?>
						<div class="blog-image">
							<?php the_post_thumbnail( $crafto_thumbnail, array( 'loading' => false ) ); ?>
							<?php
							if ( wp_get_attachment_caption( get_post_thumbnail_id() ) ) {
								?>
								<?php
								if ( 'yes' === $crafto_show_caption_title ) {
									?>
									<figcaption class="wp-caption-text">
										<?php echo wp_kses_post( wp_get_attachment_caption( get_post_thumbnail_id() ) ); ?>
									</figcaption>
									<?php
								}
								?>
								<?php
							}
							?>
						</div>
						<?php
					}
				}
			} else {
				?>
				<div class="blog-image">
					<img src="<?php echo Utils::get_placeholder_image_src(); // phpcs:ignore ?>" alt="<?php echo esc_attr__( 'Featured Image', 'crafto-addons' ); ?>"/>
				</div>
				<?php
			}
			// Restore edit mode state.
			$elementor_instance->editor->set_edit_mode( $is_edit_mode );
		}
	}
}
