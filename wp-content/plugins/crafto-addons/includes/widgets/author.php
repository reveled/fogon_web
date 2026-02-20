<?php
namespace craftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for author.
 *
 * @package Crafto
 */

// If class `Author` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Author' ) ) {
	/**
	 * Define `Author` class.
	 */
	class Author extends Widget_Base {

		/**
		 * Retrieve the list of styles the author widget depended on.
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
				return [ 'crafto-author-widget' ];
			}
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve author widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-author';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve author widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Author', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve author widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-person crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/author/';
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
				'number',
				'avtar',
				'post Count',
				'author info',
				'profile',
				'author meta',
				'author bio',
			];
		}

		/**
		 * Register author widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_author_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_author_list',
				[
					'label'       => esc_html__( 'Author', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT2,
					'multiple'    => true,
					'label_block' => true,
					'options'     => $this->crafto_get_authors_list(),
				]
			);
			$this->add_control(
				'crafto_show_post_author',
				[
					'label'        => esc_html__( 'Enable Author', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->add_control(
				'crafto_show_post_author_image',
				[
					'label'        => esc_html__( 'Enable Avtar', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_show_post_author' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_show_post_author_count',
				[
					'label'        => esc_html__( 'Enable Post Count', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_show_post_author' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_post_artical_text',
				[
					'label'     => esc_html__( 'Count Label', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'ARTICLES', 'crafto-addons' ),
					'condition' => [
						'crafto_show_post_author'       => 'yes',
						'crafto_show_post_author_count' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_author_image',
				[
					'label'     => esc_html__( 'Avtar', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_author_image' => 'yes',
						'crafto_show_post_author'       => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_image_width',
				[
					'label'          => esc_html__( 'Width', 'crafto-addons' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'unit' => '%',
					],
					'tablet_default' => [
						'unit' => '%',
					],
					'mobile_default' => [
						'unit' => '%',
					],
					'size_units'     => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'range'          => [
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
					'selectors'      => [
						'{{WRAPPER}} .author-image img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_image_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
						'vh' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .author-image img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_author_image_border',
					'selector' => '{{WRAPPER}} .author-image img',
				]
			);
			$this->add_responsive_control(
				'crafto_author_image_border_radius',
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
						'{{WRAPPER}} .author-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_author_name',
				[
					'label'     => esc_html__( 'Author Name', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_author' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_blog_post_meta_author_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .author-box-content .author-name, {{WRAPPER}} .author-name a',
					'condition' => [
						'crafto_show_post_author' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'      => 'crafto_blog_post_meta_author_color',
					'selector'  => '{{WRAPPER}} .author-box-content .author-name',
					'condition' => [
						'crafto_show_post_author' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_author_post_count',
				[
					'label'     => esc_html__( 'Post Count', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_author'       => 'yes',
						'crafto_show_post_author_count' => 'yes',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_author_post_count_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .author-box-content a',
					'condition' => [
						'crafto_show_post_author' => 'yes',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_author_post_count_meta_author_tabs' );
				$this->start_controls_tab(
					'crafto_author_post_count_normal_tab',
					[
						'label'     => esc_html__( 'Normal', 'crafto-addons' ),
						'condition' => [
							'crafto_show_post_author' => 'yes',
						],
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'      => 'crafto_author_post_count_color',
						'selector'  => '{{WRAPPER}} .author-box-content a',
						'condition' => [
							'crafto_show_post_author' => 'yes',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_post_count_author_hover_tab',
					[
						'label'     => esc_html__( 'Hover', 'crafto-addons' ),
						'condition' => [
							'crafto_show_post_author' => 'yes',
						],
					]
				);
				$this->add_group_control(
					Text_Gradient_Background::get_type(),
					[
						'name'      => 'crafto_author_post_count_hover_color',
						'selector'  => '{{WRAPPER}} .author-box-content a:hover',
						'condition' => [
							'crafto_show_post_author' => 'yes',
						],
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render author widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                      = $this->get_settings_for_display();
			$crafto_show_post_author_image = ( isset( $settings['crafto_show_post_author_image'] ) && $settings['crafto_show_post_author_image'] ) ? $settings['crafto_show_post_author_image'] : '';
			$crafto_post_artical_text      = ( isset( $settings['crafto_post_artical_text'] ) && $settings['crafto_post_artical_text'] ) ? $settings['crafto_post_artical_text'] : '';
			$crafto_show_post_author       = ( isset( $settings['crafto_show_post_author'] ) && $settings['crafto_show_post_author'] ) ? $settings['crafto_show_post_author'] : '';
			$crafto_show_post_author_count = ( isset( $settings['crafto_show_post_author_count'] ) && $settings['crafto_show_post_author_count'] ) ? $settings['crafto_show_post_author_count'] : '';
			$crafto_author_list            = $this->get_settings( 'crafto_author_list' );

			$items_list = $crafto_author_list;
			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'author-post-list',
						],
					],
				]
			);

			if ( is_array( $items_list ) && ! empty( $items_list ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<?php
					foreach ( $items_list as $author ) {
						$user_info = get_userdata( $author );
						?>
						<div class="author-box">
							<div class="author-image">
								<?php
								if ( 'yes' === $crafto_show_post_author_image ) {
									echo get_avatar( $user_info->ID, '30' );
								}
								?>
							</div>
							<?php
							if ( 'yes' === $crafto_show_post_author && get_the_author() ) {
								?>
								<div class="author-box-content">
									<span class="author-name">
										<?php echo esc_html( $user_info->display_name ); ?>
									</span>
									<a href="<?php echo esc_url( $user_info->user_url ); ?>">
										<?php
										if ( 'yes' === $crafto_show_post_author_count ) {
											echo count_user_posts( $user_info->ID ) . ' ' . esc_html( $crafto_post_artical_text ); // phpcs:ignore
										}
										?>
									</a>
								</div>
								<?php
							}
							?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
		}

		/**
		 * Return all authors array.
		 */
		public function crafto_get_authors_list() {
			$authors = get_users();

			$authors_array = array();
			if ( ! empty( $authors ) && ! is_wp_error( $authors ) ) {
				foreach ( $authors as $author ) {
					$authors_array[ $author->ID ] = $author->display_name;
				}
			}
			return $authors_array;
		}
	}
}
