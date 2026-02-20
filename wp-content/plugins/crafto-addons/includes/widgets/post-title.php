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
 * Crafto widget for post title.
 *
 * @package Crafto
 */

// If class `Post_Title` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Post_Title' ) ) {
	/**
	 * Define `Post_Title` class.
	 */
	class Post_Title extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-title';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Title', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-title crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/post-title/';
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
				'post',
				'blog',
				'single',
				'meta',
				'title',
				'heading',
			];
		}

		/**
		 * Register post title widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'In Preview, post title is dummy, while the original post title is retrieved from the relevant post, page, archive, etc...', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
			$this->add_control(
				'crafto_header_size',
				[
					'label'   => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'h1'  => 'H1',
						'h2'  => 'H2',
						'h3'  => 'H3',
						'h4'  => 'H4',
						'h5'  => 'H5',
						'h6'  => 'H6',
						'div' => 'div',
						'p'   => 'p',
					],
					'default' => 'h1',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_title',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .post-title',
				]
			);

			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-title' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_title_top_spacing',
				[
					'label'      => esc_html__( 'Top Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-title' => 'margin-top: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_title_bottom_spacing',
				[
					'label'      => esc_html__( 'Bottom Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Render post title widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$crafto_property_title_output = '';
			$crafto_page_title            = '';

			if ( is_woocommerce_activated() && ( is_product_category() || is_product_tag() || is_tax( 'product_brand' ) || is_shop() ) ) {

				$crafto_page_title = woocommerce_page_title( false );

			} elseif ( is_woocommerce_activated() && is_product() ) {

				$crafto_page_title = get_the_title();

			} elseif ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) || is_post_type_archive( 'portfolio' ) ) {

				if ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-tags' ) ) {

					$crafto_portfolio_archive_title = sprintf( '%s', single_cat_title( '', false ) );

				} else {

					$crafto_portfolio_archive_title = apply_filters( 'crafto_portfolio_archive_page_title', esc_html__( 'Portfolio Archives', 'crafto-addons' ) );
				}

				$crafto_page_title = $crafto_portfolio_archive_title;

			} elseif ( is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) || is_post_type_archive( 'properties' ) ) {

				if ( is_tax( 'properties-types' ) || is_tax( 'properties-agents' ) ) {

					$crafto_property_archive_title = sprintf( '%s', single_tag_title( '', false ) );

				} else {

					/**
					 * Filter to modify property archive page title.
					 *
					 * @since 1.0
					 */
					$crafto_property_archive_title = apply_filters( 'crafto_property_archive_page_title', esc_html__( 'Property Archives', 'crafto-addons' ) );

				}

				$crafto_page_title = $crafto_property_archive_title;

			} elseif ( is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) || is_post_type_archive( 'tours' ) ) {

				if ( is_tax( 'tour-destination' ) || is_tax( 'tour-activity' ) ) {

					$crafto_property_archive_title = sprintf( '%s', single_tag_title( '', false ) );

				} else {

					/**
					 * Filter to modify tours archive page title.
					 *
					 * @since 1.0
					 */
					$crafto_property_archive_title = apply_filters( 'crafto_tours_archive_page_title', esc_html__( 'Tour Archives', 'crafto-addons' ) );

				}

				$crafto_page_title = $crafto_property_archive_title;

			} elseif ( is_search() || is_category() || is_tag() || is_archive() ) { // if Post category, tag, archive page.

				if ( is_tag() ) {

					$crafto_archive_title = sprintf( '%s', single_tag_title( '', false ) );

				} elseif ( is_author() ) {

					$crafto_archive_title = sprintf( '%s', get_the_author() );

				} elseif ( is_category() ) {

					$crafto_archive_title = sprintf( '%s', single_cat_title( '', false ) );

				} elseif ( is_year() ) {

					$crafto_archive_title = sprintf( '%s', get_the_date( _x( 'Y', 'yearly archives date format', 'crafto-addons' ) ) );

				} elseif ( is_month() ) {

					$crafto_archive_title = sprintf( '%s', get_the_date( _x( 'F Y', 'monthly archives date format', 'crafto-addons' ) ) );

				} elseif ( is_day() ) {

					$crafto_archive_title = sprintf( '%s', get_the_date( _x( 'd', 'daily archives date format', 'crafto-addons' ) ) );

				} elseif ( is_search() ) {
					/**
					 * Filter to modify search result page title.
					 *
					 * @since 1.0
					 */
					$crafto_archive_title = apply_filters( 'crafto_search_result_page_title', esc_html__( 'Search Results For&nbsp;', 'crafto-addons' ) );
					$crafto_archive_title = $crafto_archive_title . '"' . get_search_query() . '"'; // phpcs:ignore

				} elseif ( is_archive() ) {

					/**
					 * Filter to modify archive page title.
					 *
					 * @since 1.0
					 */
					$crafto_archive_title = apply_filters( 'crafto_archive_page_title', esc_html__( 'Archives', 'crafto-addons' ) );

				} else {

					$crafto_archive_title = get_the_title();
				}

				$crafto_page_title = $crafto_archive_title;

			} elseif ( is_home() ) { // if Home page.

				/**
				 * Filter to modify home archive page title.
				 *
				 * @since 1.0
				 */
				$crafto_page_title = apply_filters( 'crafto_home_archive_page_title', esc_html__( 'Blog', 'crafto-addons' ) );

			} else {

				$crafto_page_title = get_the_title();
			}

			if ( crafto_is_editor_mode() ) { // phpcs:ignore
				$crafto_property_title_output = esc_html__( 'This is a dummy title', 'crafto-addons' );
			} else {
				$crafto_property_title_output = $crafto_page_title;
			}

			if ( ! empty( $crafto_property_title_output ) ) {
				?>
				<<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?> class="post-title">
					<?php echo esc_html( $crafto_property_title_output ); ?>
				</<?php echo esc_html( $this->get_settings( 'crafto_header_size' ) ); ?>>
				<?php
			}
		}
	}
}
