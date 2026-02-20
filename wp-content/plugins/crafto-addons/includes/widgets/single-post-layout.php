<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget for image.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_post_template() ) {
	return;
}

// If class `Single_Post_Layout` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Single_Post_Layout' ) ) {

	/**
	 * Define `Single_Post_Layout` class.
	 */
	class Single_Post_Layout extends Widget_Base {
		/**
		 * Retrieve the list of scripts the single post layout widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$single_post_layout_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$single_post_layout_scripts[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

				if ( '0' === $crafto_disable_all_animation ) {
					if ( crafto_disable_module_by_key( 'appear' ) ) {
						$single_post_layout_scripts[] = 'appear';
					}

					if ( crafto_disable_module_by_key( 'anime' ) ) {
						$single_post_layout_scripts[] = 'splitting';
						$single_post_layout_scripts[] = 'anime';
						$single_post_layout_scripts[] = 'crafto-fancy-text-effect';
					}
				}

				if ( crafto_disable_module_by_key( 'custom-parallax' ) ) {
					$single_post_layout_scripts[] = 'custom-parallax';
				}

				$single_post_layout_scripts[] = 'crafto-single-post-layout';
			}

			return $single_post_layout_scripts;
		}

		/**
		 * Retrieve the list of styles the single post layout widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$styles[] = 'crafto-vendors';
			} else {
				$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

				if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
					$styles[] = 'splitting';
				}
			}
			return $styles;
		}


		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-post-layout';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Post Layout', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/post-layout/';
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
				'layout',
				'post',
				'single',
				'blog',
				'style',
				'content',
				'custom',
				'detail',
				'article',
				'news',
			];
		}

		/**
		 * Register post layout widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_content',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_post_layout_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'modern',
					'options'            => [
						'modern'   => esc_html__( 'Modern', 'crafto-addons' ),
						'simple'   => esc_html__( 'Simple', 'crafto-addons' ),
						'creative' => esc_html__( 'Creative', 'crafto-addons' ),
						'classic'  => esc_html__( 'Classic', 'crafto-addons' ),
						'clean'    => esc_html__( 'Clean', 'crafto-addons' ),
					],
					'render_type'        => 'template',
					'prefix_class'       => 'single-',
					'frontend_available' => true,
				]
			);
			$this->add_control(
				'crafto_show_post_image',
				[
					'label'        => esc_html__( 'Enable Post Image', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => '1',
					'default'      => '1',
					'condition'    => [
						'crafto_post_layout_style' => [
							'creative',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_title',
				[
					'label'        => esc_html__( 'Enable Post Title', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => '1',
					'default'      => '1',
				]
			);
			$this->add_control(
				'crafto_show_post_category',
				[
					'label'        => esc_html__( 'Enable Post Category', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => '1',
					'default'      => '1',
				]
			);
			$this->add_control(
				'crafto_show_post_category_text',
				[
					'label'     => esc_html__( 'Before Text', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'In', 'crafto-addons' ),
					'condition' => [
						'crafto_show_post_category' => '1',
						'crafto_post_layout_style'  => [
							'creative',
							'classic',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_author',
				[
					'label'        => esc_html__( 'Enable Post Author', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => '1',
					'default'      => '1',
				]
			);
			$this->add_control(
				'crafto_show_post_author_text',
				[
					'label'     => esc_html__( 'Before Text', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'By', 'crafto-addons' ),
					'condition' => [
						'crafto_show_post_author'  => '1',
						'crafto_post_layout_style' => [
							'modern',
							'classic',
							'creative',
							'clean',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_date',
				[
					'label'        => esc_html__( 'Enable Post Date', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => '1',
					'default'      => '1',
					'condition'    => [
						'crafto_post_layout_style!' => [
							'classic',
							'clean',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_author_image',
				[
					'label'        => esc_html__( 'Enable Post Author Avatar', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => '1',
					'default'      => '1',
					'condition'    => [
						'crafto_post_layout_style' => [
							'modern',
							'simple',
							'classic',
						],
					],
				]
			);
			$this->add_control(
				'crafto_show_post_date_text',
				[
					'label'     => esc_html__( 'Before Text', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'On', 'crafto-addons' ),
					'condition' => [
						'crafto_show_post_date'    => '1',
						'crafto_post_layout_style' => [
							'modern',
							'creative',
						],
					],
				]
			);
			$this->add_control(
				'crafto_post_date_format',
				[
					'label'       => esc_html__( 'Date format', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'description' => sprintf(
						'%1$s <a target="_blank" href="%2$s" rel="noopener noreferrer">%3$s</a> %4$s',
						esc_html__( 'Date format should be like F j, Y', 'crafto-addons' ),
						esc_url( 'https://wordpress.org/support/article/formatting-date-and-time/#format-string-examples' ),
						esc_html__( 'click here', 'crafto-addons' ),
						esc_html__( 'to see other date formats.', 'crafto-addons' )
					),
					'condition'   => [
						'crafto_show_post_date'     => '1',
						'crafto_post_layout_style!' => [
							'classic',
							'clean',
						],
					],
				]
			);

			$this->add_control(
				'crafto_show_post_bottom_icon',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => '1',
					'default'      => '1',
					'condition'    => [
						'crafto_post_layout_style' => [
							'classic',
						],
					],
				]
			);
			$this->add_control(
				'crafto_single_post_overlay_enable',
				[
					'label'        => esc_html__( 'Enable Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_post_layout_style' => [
							'simple',
							'clean',
						],
					],
				]
			);
			$this->add_control(
				'crafto_full_screen',
				[
					'label'        => esc_html__( 'Full Screen Height', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => 'yes',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_post_layout_style' => 'clean',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_layout_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 2000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .full-screen' => 'height: {{SIZE}}{{UNIT}} !important',
					],
					'condition'  => [
						'crafto_full_screen'       => 'yes',
						'crafto_post_layout_style' => 'clean',
					],
				]
			);
			$this->add_control(
				'crafto_parallax_effect',
				[
					'label'     => esc_html__( 'Parallax Effects', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'condition' => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
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
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_post_layout_title_effect',
				[
					'label' => esc_html__( 'Title Effect', 'crafto-addons' ),
				]
			);

			// Crafto_Fancy_Text_Effect_Group::add_fancy_text_content_fields( $this, 'title' );

			$this->add_control(
				'crafto_title_data_fancy_text_settings',
				[
					'label'        => esc_html__( 'Enable Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_effect',
				[
					'label'       => esc_html__( 'Effect', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'wave',
					'options'   => [
						'wave'        => esc_html__( 'Wave', 'crafto-addons' ),
						'smooth-wave' => esc_html__( 'Smooth Wave', 'crafto-addons' ),
						'curve'       => esc_html__( 'Curve', 'crafto-addons' ),
						'rotate'      => esc_html__( 'Rotate', 'crafto-addons' ),
						'slide'       => esc_html__( 'Slide', 'crafto-addons' ),
						'jump'        => esc_html__( 'Jump', 'crafto-addons' ),
						'zoom'        => esc_html__( 'Zoom', 'crafto-addons' ),
						'rubber-band' => esc_html__( 'Rubber Band', 'crafto-addons' ),
						'fade'        => esc_html__( 'Fade', 'crafto-addons' ),
						'custom'      => esc_html__( 'Custom', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_ease',
				[
					'label'       => esc_html__( 'Easing', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_colors',
				[
					'label'       => esc_html__( 'Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'default'     => '#ffe400',
					'condition' => [
						'crafto_title_data_fancy_text_settings_effect' => 'slide',
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_start_delay',
				[
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						's' => [
							'min'  => 10,
							'max'  => 3000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 's',
					],
					'condition'  => [
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						's' => [
							'min'  => 3000,
							'max'  => 10000,
							'step' => 100,
						],
					],
					'default'    => [
						'unit' => 's',
					],
					'condition'  => [
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_speed',
				[
					'label'       => esc_html__( 'Speed', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
					],
					'range'       => [
						'px' => [
							'min'  => 0,
							'max'  => 500,
							'step' => 5,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_settings' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_opacity',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_opacity',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_translate_x',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_xx',
				[
					'label'         => esc_html__( 'Start', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_xy',
				[
					'label'         => esc_html__( 'End', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'     => 'after',
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_translate_y',
				[
					'label'     => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_yx',
				[
					'label'         => esc_html__( 'Start', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_translate_yy',
				[
					'label'         => esc_html__( 'End', 'crafto-addons' ),
					'type'          => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'     => 'after',
					'condition'  => [
						'crafto_title_data_fancy_text_translate_settings_popover' => 'yes',
					],'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_rotate',
				[
					'label'     => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_rotate',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_rotate',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_filter_settings_popover',
				[
					'label'        => esc_html__( 'Blur', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_blur',
				[
					'label'     => esc_html__( 'Blur', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_filter',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_filter',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1000,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_title_data_fancy_text_filter_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_clippath_settings_popover',
				[
					'label'        => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_title_data_fancy_text_settings' => 'yes',
						'crafto_title_data_fancy_text_settings_effect' => 'custom',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_title_data_fancy_text_clippath',
				[
					'label'     => esc_html__( 'clipPath', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_x_clippath',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units'  => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 1,
						],
					],
					'condition'  => [
						'crafto_title_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_title_data_fancy_text_settings_y_clippath',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 1,
						],
					],
					'condition'  => [
						'crafto_title_data_fancy_text_clippath_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_post_layout_entrance_animation',
				[
					'label' => esc_html__( 'Entrance Animation', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_primary_ent_settings',
				[
					'label'        => esc_html__( 'Enable Animation', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'render_type'  => 'none',

				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_popover',
				[
					'label'        => esc_html__( 'Settings', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();

			$this->add_control(
				'crafto_primary_ent_settings_ease',
				[
					'label'       => esc_html__( 'Easing', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'easeOutQuad',
					'options'   => [
						'none'            => esc_html__( 'None', 'crafto-addons' ),
						'linear'          => esc_html__( 'linear', 'crafto-addons' ),
						'easeInQuad'      => esc_html__( 'easeInQuad', 'crafto-addons' ),
						'easeInCubic'     => esc_html__( 'easeInCubic', 'crafto-addons' ),
						'easeInQuart'     => esc_html__( 'easeInQuart', 'crafto-addons' ),
						'easeInQuint'     => esc_html__( 'easeInQuint', 'crafto-addons' ),
						'easeInSine'      => esc_html__( 'easeInSine', 'crafto-addons' ),
						'easeInExpo'      => esc_html__( 'easeInExpo', 'crafto-addons' ),
						'easeInCirc'      => esc_html__( 'easeInCirc', 'crafto-addons' ),
						'easeInBack'      => esc_html__( 'easeInBack', 'crafto-addons' ),
						'easeInBounce'    => esc_html__( 'easeInBounce', 'crafto-addons' ),
						'easeOutQuad'     => esc_html__( 'easeOutQuad', 'crafto-addons' ),
						'easeOutCubic'    => esc_html__( 'easeOutCubic', 'crafto-addons' ),
						'easeOutQuart'    => esc_html__( 'easeOutQuart', 'crafto-addons' ),
						'easeOutQuint'    => esc_html__( 'easeOutQuint', 'crafto-addons' ),
						'easeOutSine'     => esc_html__( 'easeOutSine', 'crafto-addons' ),
						'easeOutExpo'     => esc_html__( 'easeOutExpo', 'crafto-addons' ),
						'easeOutCirc'     => esc_html__( 'easeOutCirc', 'crafto-addons' ),
						'easeOutBack'     => esc_html__( 'easeOutBack', 'crafto-addons' ),
						'easeOutBounce'   => esc_html__( 'easeOutBounce', 'crafto-addons' ),
						'easeInOutQuad'   => esc_html__( 'easeInOutQuad', 'crafto-addons' ),
						'easeInOutCubic'  => esc_html__( 'easeInOutCubic', 'crafto-addons' ),
						'easeInOutQuart'  => esc_html__( 'easeInOutQuart', 'crafto-addons' ),
						'easeInOutQuint'  => esc_html__( 'easeInOutQuint', 'crafto-addons' ),
						'easeInOutSine'   => esc_html__( 'easeInOutSine', 'crafto-addons' ),
						'easeInOutExpo'   => esc_html__( 'easeInOutExpo', 'crafto-addons' ),
						'easeInOutCirc'   => esc_html__( 'easeInOutCirc', 'crafto-addons' ),
						'easeInOutBack'   => esc_html__( 'easeInOutBack', 'crafto-addons' ),
						'easeInOutBounce' => esc_html__( 'easeInOutBounce', 'crafto-addons' ),
						'easeOutInQuad'   => esc_html__( 'easeOutInQuad', 'crafto-addons' ),
						'easeOutInCubic'  => esc_html__( 'easeOutInCubic', 'crafto-addons' ),
						'easeOutInQuart'  => esc_html__( 'easeOutInQuart', 'crafto-addons' ),
						'easeOutInQuint'  => esc_html__( 'easeOutInQuint', 'crafto-addons' ),
						'easeOutInSine'   => esc_html__( 'easeOutInSine', 'crafto-addons' ),
						'easeOutInExpo'   => esc_html__( 'easeOutInExpo', 'crafto-addons' ),
						'easeOutInCirc'   => esc_html__( 'easeOutInCirc', 'crafto-addons' ),
						'easeOutInBack'   => esc_html__( 'easeOutInBack', 'crafto-addons' ),
						'easeOutInBounce' => esc_html__( 'easeOutInBounce', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_primary_ent_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_settings_elements',
				[
					'label'        => esc_html__( 'Animation Item by Item', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'On', 'crafto-addons' ),
					'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_primary_ent_anim_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_settings_start_delay',
				[
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_primary_ent_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						'ms' => [
							'min'  => 100,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 600,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_primary_ent_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_stagger',
				[
					'label'       => esc_html__( 'Stagger', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 10000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 300,
					],
					'condition'  => [
						'crafto_primary_ent_anim_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_ent_anim_translate_settings_popover',
				[
					'label'        => esc_html__( 'Translate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate',
				[
					'label' => esc_html__( 'Translate', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_x',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'   => 'after',
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translatex',
				[
					'label' => esc_html__( 'Translate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_xx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_xy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'   => 'after',
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translatey',
				[
					'label' => esc_html__( 'Translate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_yx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 50,
					],
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_yy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'   => 'after',
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translatez',
				[
					'label' => esc_html__( 'Translate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_zx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_translate_zy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -500,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_translate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_ent_anim_opacity_settings_popover',
				[
					'label'        => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_ent_anim_opacity',
				[
					'label' => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_x_opacity',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_y_opacity',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 1,
					],
					'condition'  => [
						'crafto_primary_ent_anim_opacity_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_ent_anim_rotate_settings_popover',
				[
					'label'        => esc_html__( 'Rotate', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotatex',
				[
					'label' => esc_html__( 'Rotate X', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotation_xx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotation_xy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'   => 'after',
					'condition' => [
						'crafto_primary_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotatey',
				[
					'label' => esc_html__( 'Rotate Y', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotation_yx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotation_yy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'separator'   => 'after',
					'condition'  => [
						'crafto_primary_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotatez',
				[
					'label' => esc_html__( 'Rotate Z', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotation_zx',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_rotation_zy',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => -360,
							'max'  => 360,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_rotate_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_ent_anim_perspective_settings_popover',
				[
					'label'        => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_ent_anim_perspective',
				[
					'label' => esc_html__( 'Perspective', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_perspective_x',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_perspective_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 100,
							'max'  => 2000,
							'step' => 10,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_perspective_settings_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->end_popover();
			$this->add_control(
				'crafto_primary_ent_anim_scale_opt_popover',
				[
					'label'        => esc_html__( 'Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => esc_html__( 'Default', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Custom', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_primary_ent_settings' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->start_popover();
			$this->add_control(
				'crafto_primary_ent_anim_scale',
				[
					'label' => esc_html__( 'Scale', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_scale_x',
				[
					'label'       => esc_html__( 'Start', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type' => 'none',
				]
			);
			$this->add_control(
				'crafto_primary_ent_anim_opt_scale_y',
				[
					'label'       => esc_html__( 'End', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.1,
						],
					],
					'default'    => [
						'size' => 0,
					],
					'condition'  => [
						'crafto_primary_ent_anim_scale_opt_popover' => 'yes',
					],
					'render_type'  => 'none',
				]
			);
			$this->end_popover();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_post_layout_hover_effect_settings',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'condition' => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
				]
			);
			$this->add_control(
				'crafto_post_layout_hover_animation',
				[
					'label' => esc_html__( 'Select Animation', 'crafto-addons' ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_post_layout_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_text_alignment',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
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
					'condition' => [
						'crafto_post_layout_style' => [
							'simple',
							'clean',
						],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_single_post_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .overlap-section',
					'condition' => [
						'crafto_post_layout_style' => 'modern',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_single_post_shadow',
					'selector'  => '{{WRAPPER}} .overlap-section',
					'condition' => [
						'crafto_post_layout_style' => 'modern',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_layout_container_width',
				[
					'label'      => esc_html__( 'Container Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 2000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .single-post-layout' => 'max-width: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_single_post_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .overlap-section, {{WRAPPER}} .cover-background, {{WRAPPER}} .image-box img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'modern',
							'classic',
							'clean',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_single_post_margin',
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
						'{{WRAPPER}} .overlap-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style' => 'modern',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_single_post_padding',
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
						'{{WRAPPER}} .overlap-section, {{WRAPPER}}.elementor-element:not(.single-clean) .crafto-main-layout-wrap, {{WRAPPER}}.single-clean .crafto-single-post-meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'modern',
							'creative',
							'classic',
							'clean',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_overlay_style',
				[
					'label'     => esc_html__( 'Post Overlay', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_single_post_overlay_enable' => 'yes',
						'crafto_post_layout_style' => [
							'simple',
							'clean',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_single_post_overlay',
					'selector' => '{{WRAPPER}} .bg-overlay',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_post_layout_title_style',
				[
					'label'     => esc_html__( 'Post Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_title' => '1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .post-title, {{WRAPPER}} .crafto-main-title',
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-title, {{WRAPPER}} .crafto-main-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-title, {{WRAPPER}} .crafto-main-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_width',
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
							'max' => 500,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-main-title' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'simple',
							'classic',
							'clean',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_meta_cat_style',
				[
					'label'     => esc_html__( 'Post Category', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_category' => '1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_meta_cat_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-single-post-categories a, {{WRAPPER}} .crafto-single-post-author ul a',
				]
			);
			$this->start_controls_tabs( 'crafto_meta_cat_tabs' );
			$this->start_controls_tab(
				'crafto_meta_cat_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_meta_cat_bg_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .crafto-single-post-categories a, {{WRAPPER}} .crafto-single-post-author ul a',
					'condition'      => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
				]
			);
			$this->add_control(
				'crafto_meta_cat_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-single-post-categories a, {{WRAPPER}} .crafto-single-post-author ul a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_meta_cat_shadow',
					'selector'  => '{{WRAPPER}} .crafto-single-post-categories a',
					'condition' => [
						'crafto_post_layout_style' => [
							'modern',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_meta_cat_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_meta_cat_hover_bg_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} .crafto-single-post-categories a:hover, {{WRAPPER}} .crafto-single-post-author ul a:hover',
					'condition'      => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
				]
			);
			$this->add_control(
				'crafto_meta_cat_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-single-post-categories a:hover, {{WRAPPER}} .crafto-single-post-author ul a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_meta_cat_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-single-post-categories a:hover, {{WRAPPER}} .crafto-single-post-author ul a:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_meta_cat__hover_shadow',
					'selector'  => '{{WRAPPER}} .crafto-single-post-categories a:hover',
					'condition' => [
						'crafto_post_layout_style!' => [
							'simple',
							'creative',
							'classic',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_meta_cat_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
							'simple',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_meta_cat_border',
					'selector'  => '{{WRAPPER}} .crafto-single-post-categories a, {{WRAPPER}} .crafto-single-post-author ul a',
					'condition' => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_meta_cat_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-single-post-categories a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_category_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}}.single-modern .crafto-single-post-categories' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}}.single-simple .post-detail-meta'              => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'modern',
							'simple',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_meta_cat_margin',
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
						'{{WRAPPER}} .crafto-single-post-categories ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'clean',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_meta_cat_padding',
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
						'{{WRAPPER}} .crafto-single-post-categories a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'modern',
							'clean',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_meta_date_style',
				[
					'label'     => esc_html__( 'Post Date', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_date'     => '1',
						'crafto_post_layout_style!' => [
							'clean',
							'classic',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_meta_date_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .date, {{WRAPPER}} .crafto-single-post-date',
				]
			);
			$this->add_control(
				'crafto_meta_date_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .date, {{WRAPPER}} .crafto-single-post-date' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_meta_author_style',
				[
					'label'     => esc_html__( 'Post Author', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_show_post_author' => '1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_meta_author_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .author, {{WRAPPER}} .crafto-single-post-author a',
				]
			);
			$this->start_controls_tabs( 'crafto_meta_author_tabs' );
			$this->start_controls_tab(
				'crafto_meta_author_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_meta_author_color',
					'selector'       => '{{WRAPPER}} .author a, {{WRAPPER}} .crafto-single-post-author a',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_meta_author_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_meta_author_hover_color',
					'selector'       => '{{WRAPPER}} .author a:hover, {{WRAPPER}} .crafto-single-post-author a:hover',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'crafto_meta_author_image_heading',
				[
					'label'     => esc_html__( 'Post Author Avatar', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_post_layout_style'      => [
							'modern',
							'simple',
							'classic',
						],
						'crafto_show_post_author_image' => '1',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_meta_author_image_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-author-avatar img, {{WRAPPER}} .crafto-single-post-author img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style'      => [
							'modern',
							'simple',
							'classic',
						],
						'crafto_show_post_author_image' => '1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_spacing',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-single-post-author' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_post_layout_style'      => [
							'modern',
						],
						'crafto_show_post_author_image' => '1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_author_bottom_spacing',
				[
					'label'      => esc_html__( 'Image Offset', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => -100,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-author-avatar' => 'bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_post_layout_style'      => [
							'modern',
						],
						'crafto_show_post_author_image' => '1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_meta_author_image_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'%',
					],
					'range'      => [
						'%' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-author-avatar img, {{WRAPPER}} .crafto-single-post-author img' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style'      => [
							'modern',
							'simple',
							'classic',
						],
						'crafto_show_post_author_image' => '1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_meta_author_image_border',
					'selector'  => '{{WRAPPER}} .crafto-author-avatar img, {{WRAPPER}} .crafto-single-post-author img',
					'condition' => [
						'crafto_post_layout_style'      => [
							'modern',
							'simple',
							'classic',
						],
						'crafto_show_post_author_image' => '1',
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_meta_label_style',
				[
					'label'     => esc_html__( 'Before Text', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_layout_style' => [
							'modern',
							'creative',
							'classic',
							'clean',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_before_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .text-label',
				]
			);
			$this->add_control(
				'crafto_meta_label_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .text-label' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_meta_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-detail-meta, {{WRAPPER}} .crafto-single-post-author' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'simple',
							'creative',
							'classic',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_meta_thumbnail_style',
				[
					'label'     => esc_html__( 'Post Image', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_layout_style' => [
							'creative',
						],
						'crafto_show_post_image'   => '1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_thumbnail_margin',
				[
					'label'      => esc_html__( 'Bottom Offset', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => -500,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .image-box' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'creative',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_post_thumbnail_padding',
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
						'{{WRAPPER}} .container-fluid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_post_layout_style' => [
							'creative',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_meta_separator_style',
				[
					'label'     => esc_html__( 'Meta Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_layout_style' => [
							'simple',
						],
					],
				]
			);
			$this->add_control(
				'crafto_meta_separator_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .post-detail-meta a::before' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_meta_separator_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .post-detail-meta a::before' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_bottom_icon_style',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_layout_style' => [
							'classic',
						],
					],
				]
			);
			$this->add_control(
				'crafto_meta_bottom_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .icon-post-single' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_bg_overlay_style',
				[
					'label'     => esc_html__( 'Background', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_post_layout_style' => [
							'creative',
						],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_background_image',
					'selector' => '{{WRAPPER}} .background-overlay',
				]
			);
			$this->add_responsive_control(
				'crafto_layout_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 1000,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .background-overlay' => 'height: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render post layout widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                       = $this->get_settings_for_display();
			$crafto_full_screen             = '';
			$crafto_cat_output              = '';
			$crafto_post_author_meta_output = '';
			$crafto_bg_image_url            = '';
			$crafto_single_post_meta_output = '';
			$crafto_post_parallax_class     = '';
			$crafto_post_author_meta_array  = [];
			$crafto_post_parallax_output    = $this->get_settings( 'crafto_parallax_effect' )['size'];
			$crafto_post_layout_style       = $this->get_settings( 'crafto_post_layout_style' );
			$crafto_show_post_title         = $this->get_settings( 'crafto_show_post_title' );
			$crafto_header_size             = $this->get_settings( 'crafto_header_size' );
			$crafto_show_post_category      = $this->get_settings( 'crafto_show_post_category' );
			$crafto_show_post_date          = $this->get_settings( 'crafto_show_post_date' );
			$crafto_show_post_author        = $this->get_settings( 'crafto_show_post_author' );
			$crafto_show_post_author_image  = $this->get_settings( 'crafto_show_post_author_image' );
			$crafto_show_post_image         = $this->get_settings( 'crafto_show_post_image' );
			$crafto_show_post_bottom_icon   = $this->get_settings( 'crafto_show_post_bottom_icon' );
			$crafto_text_alignment          = $this->get_settings( 'crafto_text_alignment' );
			$crafto_post_date_format        = $this->get_settings( 'crafto_post_date_format' );
			$crafto_show_post_author_text   = $this->get_settings( 'crafto_show_post_author_text' );
			$crafto_show_post_date_text     = $this->get_settings( 'crafto_show_post_date_text' );
			$crafto_show_post_category_text = $this->get_settings( 'crafto_show_post_category_text' );
			$crafto_thumbnail               = $this->get_settings( 'crafto_thumbnail' );

			$crafto_post_layout_hover_animation = $this->get_settings( 'crafto_post_layout_hover_animation' );

			$crafto_blog_image           = crafto_post_meta( 'crafto_featured_image' );
			$crafto_post_layout_bg_image = crafto_post_meta( 'crafto_post_layout_bg_image' );

			$crafto_author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
			if ( ! is_singular( 'themebuilder' ) ) {
				while ( have_posts() ) :
					the_post();
					$crafto_author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
				endwhile;
				wp_reset_postdata();
			}

			$crafto_author     = get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) );
			$crafto_categories = get_the_category();
			$crafto_author_alt = get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) ) ? get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) ) : esc_html__( 'Author', 'crafto-addons' );

			if ( crafto_is_editor_mode() ) { // phpcs:ignore
				$crafto_the_title = esc_html__( 'This is a dummy title', 'crafto-addons' );
			} else {
				$crafto_the_title = get_the_title();
			}

			if ( crafto_is_editor_mode() ) { // phpcs:ignore
				$crafto_bg_image_url = ' style="background-image: url(' . esc_url( Utils::get_placeholder_image_src() ) . ');"';
			} elseif ( ! empty( $crafto_post_layout_bg_image ) ) {
				$crafto_bg_image_url = ' style="background-image: url(' . esc_url( wp_get_attachment_url( $crafto_post_layout_bg_image ) ) . ');"';
			} elseif ( has_post_thumbnail() ) {
				$crafto_bg_image_url = ' style="background-image: url(' . esc_url( get_the_post_thumbnail_url( get_the_ID(), $crafto_thumbnail ) ) . ');"';
			}

			$crafto_post_parallax_output = '';
			if ( ! empty( $crafto_post_parallax_output ) ) {
				$crafto_post_parallax_output = ' data-parallax-background-ratio="' . esc_attr( $crafto_post_parallax_output ) . '"';
				$crafto_post_parallax_class  = ' has-parallax-background';
			}
			
			$page_title_anim       = $this->render_anime_animation( $this, 'primary' );
			$post_title_fancy_text = $this->render_fancy_text_animation( $this, 'title' );

			if ( ! empty( $post_title_fancy_text ) ) {
				$fancy_text_animation        = wp_json_encode( $post_title_fancy_text );
				$fancy_text_values['string'] = [ $crafto_the_title ];
				$data_fancy_text             = ! empty( $fancy_text_values ) ? wp_json_encode( $fancy_text_values ) : '';
				$title_fancy_text            = wp_json_encode( array_merge( json_decode( $data_fancy_text, true ), json_decode( $fancy_text_animation, true ) ) );
			}

			if ( ! empty( $title_fancy_text ) ) {
				$this->add_render_attribute(
					'title',
					[
						'class'           => 'fancy-text-rotator',
						'data-fancy-text' => $title_fancy_text,
					],
				);
			}

			if ( 'modern' === $crafto_post_layout_style ) {
				$this->add_render_attribute(
					'title',
					[
						'class' => 'post-title',
					],
				);
			} else {
				$this->add_render_attribute(
					'title',
					[
						'class' => 'crafto-main-title',
					],
				);
			}

			if ( 'clean' === $crafto_post_layout_style ) {
				$this->add_render_attribute(
					'meta_wrap',
					[
						'class' => 'crafto-single-post-meta-wrap',
					],
				);
			} elseif ( 'modern' === $crafto_post_layout_style ) {
				$this->add_render_attribute(
					'meta_wrap',
					[
						'class' => 'col-12 overlap-section text-center',
					],
				);
			} elseif ( 'creative' === $crafto_post_layout_style ) {
				$this->add_render_attribute(
					'meta_wrap',
					[
						'class' => 'col-12 text-center content-box',
					],
				);
			} elseif ( 'classic' === $crafto_post_layout_style ) {
				$this->add_render_attribute(
					'meta_wrap',
					[
						'class' => 'col-12 position-relative text-center',
					],
				);
			} elseif ( 'simple' === $crafto_post_layout_style ) {
				$this->add_render_attribute(
					'meta_wrap',
					[
						'class' => 'col-12',
					],
				);
			}

			if ( ! empty( $page_title_anim ) && '[]' !== $page_title_anim ) {
				$this->add_render_attribute(
					'meta_wrap',
					[
						'class'      => 'entrance-animation',
						'data-anime' => $page_title_anim,
					],
				);
			}

			$this->add_render_attribute(
				[
					'animation' => [
						'class' => [
							'elementor-categories',
						],
					],
				],
			);

			/* Post layout hover animation */
			$hover_animation_effect_array = \Crafto_Addons_Extra_Functions::crafto_custom_hover_animation_effect();

			if ( ! empty( $hover_animation_effect_array ) && ! empty( $crafto_post_layout_hover_animation ) ) {
				if ( 'modern' === $crafto_post_layout_style || 'clean' === $crafto_post_layout_style ) {
					$this->add_render_attribute( 'animation', 'class', 'elementor-animation-' . $crafto_post_layout_hover_animation );
				}
			}

			switch ( $crafto_post_layout_style ) {
				case 'modern':
					if ( crafto_is_editor_mode() ) { // phpcs:ignore
						$crafto_cat_output .= '<ul>';
						$crafto_cat_output .= '<li><a '. $this->get_render_attribute_string( 'animation' ) .' href="' . trailingslashit( get_home_url() ) . '">' . esc_html__( 'Uncategorized', 'crafto-addons' ) .'</a></li>'; // phpcs:ignore
						$crafto_cat_output .= '</ul>';
					} elseif ( ! empty( $crafto_categories ) ) {
						$crafto_cat_output .= '<ul>';
						foreach ( $crafto_categories as $category ) {
							$crafto_cat_output .= '<li><a ' . $this->get_render_attribute_string( 'animation' ) . ' href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
						}
						
						$crafto_cat_output .= '</ul>';
					}

					if ( '1' === $crafto_show_post_author && $crafto_author ) {
						/**
						 * Apply filters for get post author prefix so user can modify it.
						 *
						 * @since 1.0
						 */
						$crafto_post_author_meta_array[] = '<span class="author"><span class="text-label">' . esc_html( $crafto_show_post_author_text ) . ' </span><a href="' . esc_url( $crafto_author_url ) . '">' . esc_html( $crafto_author ) . '</a>' . ( '1' === $crafto_show_post_date ? '<span class="text-label"> ' . esc_html( $crafto_show_post_date_text ) . ' </span>' : '' ) . '</span>';
					}

					if ( '1' === $crafto_show_post_date ) {
						$crafto_post_author_meta_array[] = '<span class="date">' . esc_html( get_the_date( $crafto_post_date_format ) ) . '</span>';
					}

					if ( is_array( $crafto_post_author_meta_array ) && 0 !== count( $crafto_post_author_meta_array ) ) {
						$crafto_post_author_meta_output .= implode( '', $crafto_post_author_meta_array );
					}
					?>
					<div class="crafto-main-layout-wrap">
						<div class="one-fourth-screen cover-background<?php echo $crafto_post_parallax_class; ?>"<?php echo sprintf( '%1$s %2$s', $crafto_post_parallax_output, $crafto_bg_image_url ); // phpcs:ignore ?>></div>
						<div class="single-post-layout container">
							<div class="row align-items-end justify-content-center h-100">
								<div <?php $this->print_render_attribute_string( 'meta_wrap' ); ?>>
									<?php
									if ( '1' === $crafto_show_post_category ) {
										?>
										<div class="crafto-single-post-categories alt-font">
											<?php echo sprintf( '%s', $crafto_cat_output ); // phpcs:ignore ?>
										</div>
										<?php
									}

									if ( '1' === $crafto_show_post_title ) {
										?>
										<<?php echo esc_attr( $crafto_header_size ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
										<?php
										echo $crafto_the_title; // phpcs:ignore
										?>
										</<?php echo esc_attr( $crafto_header_size ); ?>>
										<?php
									}

									if ( '1' === $crafto_show_post_author || '1' === $crafto_show_post_author_image || '1' === $crafto_show_post_date ) {
										?>
										<div class="crafto-single-post-author">
											<?php
											echo sprintf( '%s', $crafto_post_author_meta_output ); // phpcs:ignore
											if ( '1' === $crafto_show_post_author_image ) {
												?>
												<span class="crafto-author-avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), '130', '', $crafto_author_alt ); ?></span>
												<?php
											}
											?>
										</div>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<?php
					break;
				case 'simple':
					if ( crafto_is_editor_mode() ) { // phpcs:ignore
						$crafto_cat_output .= '<ul class="crafto-single-post-categories">';
						$crafto_cat_output .= '<li><a href="' . trailingslashit( get_home_url() ) . '">' . esc_html__( 'Uncategorized', 'crafto-addons' ) .'</a></li>'; // phpcs:ignore
						$crafto_cat_output .= '</ul>';
					} elseif ( ! empty( $crafto_categories ) ) {
						$crafto_cat_output .= '<ul class="crafto-single-post-categories">';
						foreach ( $crafto_categories as $category ) {
							$crafto_cat_output .= '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
						}
						$crafto_cat_output .= '</ul>';
					}

					$crafto_text_alignment_class = '';
					switch ( $crafto_text_alignment ) {
						case 'left':
						default:
							$crafto_text_alignment_class = ' text-start';
							break;
						case 'center':
							$crafto_text_alignment_class = ' text-center';
							break;
						case 'right':
							$crafto_text_alignment_class = ' text-end';
							break;
					}
					?>
					<div class="crafto-main-layout-wrap cover-background one-fifth-screen d-flex align-items-center <?php echo esc_attr( $crafto_text_alignment_class ); ?>"<?php echo sprintf( '%s', $crafto_bg_image_url ); // phpcs:ignore ?>>
						<?php
						if ( 'yes' === $settings['crafto_single_post_overlay_enable'] ) {
							?>
							<div class="bg-overlay"></div>
							<?php
						}
						?>
						<div class="single-post-layout container">
							<div class="row">
								<div <?php $this->print_render_attribute_string( 'meta_wrap' ); ?>>
									<div class="post-detail-meta">
										<?php
										if ( '1' === $crafto_show_post_date ) {
											?>
											<span class="crafto-single-post-date">
												<?php echo esc_html( get_the_date( $crafto_post_date_format ) ); ?>
											</span>
											<?php
										}

										if ( '1' === $crafto_show_post_category ) {
											echo sprintf( '%s', $crafto_cat_output ); // phpcs:ignore
										}
										?>
									</div>
									<?php
									if ( '1' === $crafto_show_post_title ) {
										?>
										<<?php echo esc_attr( $crafto_header_size ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
										<?php echo $crafto_the_title; // phpcs:ignore ?>
										</<?php echo esc_attr( $crafto_header_size ); ?>>
										<?php
									}

									if ( ( '1' === $crafto_show_post_author || '1' === $crafto_show_post_author_image ) && $crafto_author ) {
										?>
										<span class="crafto-single-post-author">
											<?php
											if ( '1' === $crafto_show_post_author_image ) {
												echo get_avatar( get_the_author_meta( 'ID' ), '80', '', $crafto_author_alt );
											}
											if ( '1' === $crafto_show_post_author ) {
												?>
												<span>
													<a href="<?php echo esc_url( $crafto_author_url ); ?>" rel="author">
														<?php echo esc_html( $crafto_author ); ?>
													</a>
												</span>
												<?php
											}
											?>
										</span>
										<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
					<?php
					break;
				case 'creative':
					$crafto_post_meta_output_array = [];
					if ( '1' === $crafto_show_post_author && $crafto_author ) {
						/**
						 * Apply filters for get post author prefix so user can modify it.
						 *
						 * @since 1.0
						 */
						if ( '1' === $crafto_show_post_author || '1' === $crafto_show_post_category ) // phpcs:ignore
						$crafto_post_meta_output_array[] = '<span class="author"><span class="text-label">' . esc_html( $crafto_show_post_author_text ) . ' </span><a href="' . esc_url( $crafto_author_url ) . '" rel="author">' . esc_html( $crafto_author ) . '</a>' . ( '1' === $crafto_show_post_category ? '<span class="text-label"> ' . esc_html( $crafto_show_post_category_text ) . ' </span>' : '' ) . '</span>';
					}

					if ( crafto_is_editor_mode() ) { // phpcs:ignore
						$crafto_cat_output .= '<ul>';
						$crafto_cat_output .= '<li><a href="' . trailingslashit( get_home_url() ) . '">' . esc_html__( 'Uncategorized', 'crafto-addons' ) .'</a></li>'; // phpcs:ignore
						$crafto_cat_output .= '</ul>';
					} elseif ( ! empty( $crafto_categories ) ) {
							$crafto_cat_output .= '<ul>';
							$count              = 1;
						foreach ( $crafto_categories as $category ) {
							$crafto_cat_output .= '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
							if ( 1 === $count ) {
								break;
							}
							++$count;
						}
						$crafto_cat_output .= '</ul>';
					}

					if ( '1' === $crafto_show_post_category ) {
						$crafto_post_meta_output_array[] = $crafto_cat_output;
					}

					if ( '1' === $crafto_show_post_date ) {
						$crafto_post_meta_output_array[] = ( '1' === $crafto_show_post_date ? '<span class="text-label"> ' . esc_html( $crafto_show_post_date_text ) . ' </span>' : '' ) . '<span class="date">' . esc_html( get_the_date( $crafto_post_date_format ) ) . '</span>';
					}

					if ( is_array( $crafto_post_meta_output_array ) && 0 !== count( $crafto_post_meta_output_array ) ) {

						/**
						 * Apply filters for get post meta details so user can modify it.
						 *
						 * @since 1.0
						 */
						$crafto_post_meta_output_array = apply_filters( 'crafto_meta_single_post_clean_creative', $crafto_post_meta_output_array );

						$crafto_single_post_meta_output .= implode( '', $crafto_post_meta_output_array );
					}
					?>
					<div class="crafto-main-layout-wrap">
						<div class="background-overlay"></div>
						<div class="single-post-layout container">
							<div class="row justify-content-center">
								<div <?php $this->print_render_attribute_string( 'meta_wrap' ); ?>>
									<?php
									if ( '1' === $crafto_show_post_author || '1' === $crafto_show_post_date || '1' === $crafto_show_post_category ) {
										?>
										<div class="crafto-single-post-author">
											<?php echo sprintf( '%s', $crafto_single_post_meta_output ); // phpcs:ignore ?>
										</div>
										<?php
									}

									if ( '1' === $crafto_show_post_title ) {
										?>
										<<?php echo esc_attr( $crafto_header_size ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
										<?php echo $crafto_the_title; // phpcs:ignore ?>
										</<?php echo esc_attr( $crafto_header_size ); ?>>
										<?php
									}
									?>
								</div>
							</div>
						</div>
						<?php
						if ( '1' === $crafto_show_post_image ) {
							?>
							<div class="container-fluid">
								<div class="row justify-content-center">
									<div class="col-12 image-box">
										<?php
										if ( crafto_is_editor_mode() ) { // phpcs:ignore
											?>
											<img src="<?php echo Utils::get_placeholder_image_src(); // phpcs:ignore ?>" alt="<?php echo esc_attr__( 'Post Thumbnail', 'crafto-addons' ); ?>"/>
											<?php
										} elseif ( ! empty( $crafto_post_layout_bg_image ) ) {
											echo wp_get_attachment_image( $crafto_post_layout_bg_image, $crafto_thumbnail );
										} elseif ( has_post_thumbnail() ) {
											the_post_thumbnail();
										}
										?>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php
					break;
				case 'classic':
					if ( crafto_is_editor_mode() ) { // phpcs:ignore
						$crafto_cat_output .= '<ul>';
						$crafto_cat_output .= '<li><a href="' . trailingslashit( get_home_url() ) . '">' . esc_html__( 'Uncategorized', 'crafto-addons' ) .'</a></li>'; // phpcs:ignore
						$crafto_cat_output .= '</ul>';
					} elseif ( ! empty( $crafto_categories ) ) {
						$count              = 0;
						$crafto_cat_output .= '<ul>';
						foreach ( $crafto_categories as $category ) {
							if ( 1 === $count ) {
								break;
							}
							
							$crafto_cat_output .= '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
							++$count;
						}
						
						$crafto_cat_output .= '</ul>';
					}
					?>
					<div class="crafto-main-layout-wrap cover-background">
						<div class="single-post-layout container">
							<div class="row justify-content-center">
								<div class="col-12 image-box">
									<?php
									if ( crafto_is_editor_mode() ) { // phpcs:ignore
										?>
										<img src="<?php echo Utils::get_placeholder_image_src(); // phpcs:ignore ?>" alt="<?php echo esc_attr__( 'Post Thumbnail', 'crafto-addons' ); ?>"/>
										<?php
									} elseif ( ! empty( $crafto_post_layout_bg_image ) ) {
										echo wp_get_attachment_image( $crafto_post_layout_bg_image, $crafto_thumbnail );
									} elseif ( has_post_thumbnail() ) {
										the_post_thumbnail();
									}
									?>
								</div>
								<div <?php $this->print_render_attribute_string( 'meta_wrap' ); ?>>
									<div class="crafto-single-post-author">
										<?php
										if ( ( '1' === $crafto_show_post_author || '1' === $crafto_show_post_author_image ) && $crafto_author ) {
											if ( '1' === $crafto_show_post_author_image ) {
												?>
												<span class="crafto-author-avatar">
													<?php echo get_avatar( get_the_author_meta( 'ID' ), '150', '', $crafto_author_alt ); ?>
												</span>
												<?php
											}

											if ( '1' === $crafto_show_post_author ) {
												echo sprintf(
													'<span class="text-label">%1$s </span><a href="%2$s" rel="author">%3$s</a>',
													esc_html( $crafto_show_post_author_text ),
													esc_url( $crafto_author_url ),
													esc_html( $crafto_author ),
												);
											}
										}

										if ( '1' === $crafto_show_post_category ) {
											?>
											<span class="text-label">
												<?php echo esc_html( $crafto_show_post_category_text ); ?>
											</span>
											<?php
											echo sprintf( '%s', $crafto_cat_output ); // phpcs:ignore
										}
										?>
									</div>
									<?php
									if ( '1' === $crafto_show_post_title ) {
										?>
										<<?php echo esc_attr( $crafto_header_size ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
										<?php
										echo $crafto_the_title; // phpcs:ignore
										?>
										</<?php echo esc_attr( $crafto_header_size ); ?>>
										<?php
									}

									if ( '1' === $crafto_show_post_bottom_icon ) {
										/**
										 * Apply filters for get post author label details so user can modify it.
										 *
										 * @since 1.0
										 */
										$crafto_bottom_icon = apply_filters( 'crafto_bottom_icon_single_post_classic', __( '<i class="feather icon-feather-more-horizontal- icon-post-single"></i>', 'crafto-addons' ) );

										echo sprintf( '%s', $crafto_bottom_icon ); // phpcs:ignore
									}
									?>
								</div>
							</div>
						</div>
						</div>
					<?php
					break;
				case 'clean':
					if ( crafto_is_editor_mode() ) { // phpcs:ignore
						$crafto_cat_output .= '<ul>';
						$crafto_cat_output .= '<li><a '. $this->get_render_attribute_string( 'animation' ) .' href="' . trailingslashit( get_home_url() ) . '">' . esc_html__( 'Uncategorized', 'crafto-addons' ) .'</a></li>'; // phpcs:ignore
						$crafto_cat_output .= '</ul>';
					} elseif ( ! empty( $crafto_categories ) ) {
							$crafto_cat_output .= '<ul>';
						foreach ( $crafto_categories as $category ) {
							$crafto_cat_output .= '<li><a ' . $this->get_render_attribute_string( 'animation' ) . ' href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
						}
						
						$crafto_cat_output .= '</ul>';
					}

					$crafto_text_alignment_class = '';
					switch ( $crafto_text_alignment ) {
						case 'left':
						default:
							$crafto_text_alignment_class = ' text-start';
							break;
						case 'center':
							$crafto_text_alignment_class = ' text-center';
							break;
						case 'right':
							$crafto_text_alignment_class = ' text-end';
							break;
					}

					if ( 'yes' === $this->get_settings( 'crafto_full_screen' ) ) {
						$crafto_full_screen = 'full-screen';
					}

					$this->add_render_attribute(
						[
							'carousel-wrapper' => [
								'class' => [
									'col-12',
									'd-flex',
									'align-items-center',
									$crafto_full_screen,
									$crafto_text_alignment_class,
								],
							],
						]
					);
					?>
					<div class="crafto-main-layout-wrap cover-background<?php echo $crafto_post_parallax_class; ?>"<?php echo sprintf( '%1$s %2$s', $crafto_post_parallax_output, $crafto_bg_image_url ); // phpcs:ignore ?>>
						<?php
						if ( 'yes' === $settings['crafto_single_post_overlay_enable'] ) {
							?>
							<div class="bg-overlay"></div>
							<?php
						}
						?>
						<div class="single-post-layout container">
							<div class="row">
							<div <?php $this->print_render_attribute_string( 'carousel-wrapper' ); ?>>
								<?php
								if ( '1' === $crafto_show_post_author || '1' === $crafto_show_post_category ) {
									?>
									<div <?php $this->print_render_attribute_string( 'meta_wrap' ); ?>>
									<?php
									if ( '1' === $crafto_show_post_author && $crafto_author ) {
										?>
										<div class="crafto-single-post-author alt-font">
											<span class="author-label">
												<span class="text-label">
													<?php echo esc_html( $crafto_show_post_author_text ); ?>
												</span>
											</span>
											<span class="author-url">
												<a href="<?php echo esc_url( $crafto_author_url ); ?>" rel="author"><?php echo esc_html( $crafto_author ); ?></a>
											</span>
										</div>
										<?php
									}

									if ( '1' === $crafto_show_post_title ) {
										?>
										<<?php echo esc_attr( $crafto_header_size ); ?> <?php $this->print_render_attribute_string( 'title' ); ?>>
										<?php echo $crafto_the_title; // phpcs:ignore ?>
										</<?php echo esc_attr( $crafto_header_size ); ?>>
										<?php
									}

									if ( '1' === $crafto_show_post_category ) {
										?>
										<div class="crafto-single-post-categories alt-font">
											<?php echo sprintf( '%s', $crafto_cat_output ); // phpcs:ignore ?>
										</div>
										<?php
									}
									?>
									</div>
									<?php
								}
								?>
								</div>
							</div>
						</div>
					</div>
					<?php
					break;
			}
		}

		/**
		 * Render animation effect frontend
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public function render_anime_animation( $element, $data_type = 'primary' ) {
			$prefix = 'crafto_' . $data_type . '_';
			// Data Anime Values.
			$crafto_animation_settings  = $element->get_settings( $prefix . 'ent_settings' );
			$ent_settings_ease          = $element->get_settings( $prefix . 'ent_settings_ease' );
			$ent_settings_elements      = $element->get_settings( $prefix . 'ent_settings_elements' );
			$ent_settings_start_delay   = ( isset( $element->get_settings( $prefix . 'ent_settings_start_delay' )['size'] ) ) ? $element->get_settings( $prefix . 'ent_settings_start_delay' )['size'] : '';
			$ent_settings_duration      = ( isset( $element->get_settings( $prefix . 'ent_anim_opt_duration' )['size'] ) ) ? $element->get_settings( $prefix . 'ent_anim_opt_duration' )['size'] : '';
			$ent_settings_stagger           = ( isset( $element->get_settings( $prefix . 'ent_anim_stagger' )['size'] ) ) ? $element->get_settings( $prefix . 'ent_anim_stagger' )['size'] : '';
			$ent_settings_opacity_x     = $element->get_settings( $prefix . 'ent_anim_opt_x_opacity' );
			$ent_settings_opacity_y     = $element->get_settings( $prefix . 'ent_anim_opt_y_opacity' );
			$ent_settings_perspective_x = $element->get_settings( $prefix . 'ent_anim_opt_perspective_x' );
			$ent_settings_perspective_y = $element->get_settings( $prefix . 'ent_anim_opt_perspective_y' );
			$ent_settings_rotatex_xx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_xx' );
			$ent_settings_rotatex_xy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_xy' );
			$ent_settings_rotatey_yx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_yx' );
			$ent_settings_rotatey_yy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_yy' );
			$ent_settings_rotatez_zx    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_zx' );
			$ent_settings_rotatez_zy    = $element->get_settings( $prefix . 'ent_anim_opt_rotation_zy' );
			$ent_settings_transalte_x   = $element->get_settings( $prefix . 'ent_anim_opt_translate_x' );
			$ent_settings_transalte_y   = $element->get_settings( $prefix . 'ent_anim_opt_translate_y' );
			$ent_settings_transalte_xx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_xx' );
			$ent_settings_transalte_xy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_xy' );
			$ent_settings_transalte_yx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_yx' );
			$ent_settings_transalte_yy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_yy' );
			$ent_settings_transalte_zx  = $element->get_settings( $prefix . 'ent_anim_opt_translate_zx' );
			$ent_settings_transalte_zy  = $element->get_settings( $prefix . 'ent_anim_opt_translate_zy' );
			$ent_settings_scale_x       = $element->get_settings( $prefix . 'ent_anim_opt_scale_x' );
			$ent_settings_scale_y       = $element->get_settings( $prefix . 'ent_anim_opt_scale_y' );

			$ent_values = [];
			if ( 'yes' === $crafto_animation_settings ) {
				if ( 'yes' === $ent_settings_elements ) {
					$ent_values['el'] = 'childs';
				}

				if ( 'none' !== $ent_settings_ease ) {
					$ent_values['easing'] = $ent_settings_ease;
				}

				if ( ! empty( $ent_settings_start_delay ) ) {
					$ent_values['delay'] = (float) ( $ent_settings_start_delay );
				}

				if ( ! empty( $ent_settings_duration ) ) {
					$ent_values['duration'] = (float) ( $ent_settings_duration );
				}

				if ( ! empty( $ent_settings_stagger ) ) {
					$ent_values['staggervalue'] = (float) ( $ent_settings_stagger );
				}

				if ( ! empty( $ent_settings_opacity_x ) && ! empty( $ent_settings_opacity_y ) && $ent_settings_opacity_x !== $ent_settings_opacity_y ) {
					$ent_values['opacity'] = [ (float) $ent_settings_opacity_x['size'], (float) $ent_settings_opacity_y['size'] ];
				}

				if ( ! empty( $ent_settings_perspective_x ) && ! empty( $ent_settings_perspective_y ) && ( 0 !== $ent_settings_perspective_x['size'] ) && ( 0 !== $ent_settings_perspective_y['size'] ) ) {
					$ent_values['perspective'] = [ (float) $ent_settings_perspective_x['size'], (float) $ent_settings_perspective_y['size'] ];
				}

				if ( ! empty( $ent_settings_rotatex_xx ) && ! empty( $ent_settings_rotatex_xy ) && $ent_settings_rotatex_xx !== $ent_settings_rotatex_xy ) {
					$ent_values['rotateX'] = [ (int) $ent_settings_rotatex_xx['size'], (int) $ent_settings_rotatex_xy['size'] ];
				}

				if ( ! empty( $ent_settings_rotatey_yx ) && ! empty( $ent_settings_rotatey_yy ) && $ent_settings_rotatey_yx !== $ent_settings_rotatey_yy ) {
					$ent_values['rotateY'] = [ (int) $ent_settings_rotatey_yx['size'], (int) $ent_settings_rotatey_yy['size'] ];
				}

				if ( ! empty( $ent_settings_rotatez_zx ) && ! empty( $ent_settings_rotatez_zy ) && $ent_settings_rotatez_zx !== $ent_settings_rotatez_zy ) {
					$ent_values['rotateZ'] = [ (int) $ent_settings_rotatez_zx['size'], (int) $ent_settings_rotatez_zy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_x ) && ! empty( $ent_settings_transalte_y ) && $ent_settings_transalte_x !== $ent_settings_transalte_y ) {
					$ent_values['translate'] = [ (float) $ent_settings_transalte_x['size'], (float) $ent_settings_transalte_y['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_xx ) && ! empty( $ent_settings_transalte_xy ) && $ent_settings_transalte_xx !== $ent_settings_transalte_xy ) {
					$ent_values['translateX'] = [ (float) $ent_settings_transalte_xx['size'], (float) $ent_settings_transalte_xy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_yx ) && ! empty( $ent_settings_transalte_yy ) && $ent_settings_transalte_yx !== $ent_settings_transalte_yy ) {
					$ent_values['translateY'] = [ (float) $ent_settings_transalte_yx['size'], (float) $ent_settings_transalte_yy['size'] ];
				}

				if ( ! empty( $ent_settings_transalte_zx ) && ! empty( $ent_settings_transalte_zy ) && $ent_settings_transalte_zx !== $ent_settings_transalte_zy ) {
					$ent_values['translateZ'] = [ (float) $ent_settings_transalte_zx['size'], (float) $ent_settings_transalte_zy['size'] ];
				}

				if ( ! empty( $ent_settings_scale_x ) && ! empty( $ent_settings_scale_y ) && $ent_settings_scale_x !== $ent_settings_scale_y ) {
					$ent_values['scale'] = [ (float) $ent_settings_scale_x['size'], (float) $ent_settings_scale_y['size'] ];
				}
			}

			$data_anime = ! empty( $ent_values ) ? $ent_values : [];
			
			return wp_json_encode( $data_anime );
		}

		/**
		 * Return Data Fancy Text Animation.
		 *
		 * @since 1.0
		 * @param object $element Widget data.
		 * @param string $data_type Widget data.
		 * @access public
		 */
		public function render_fancy_text_animation( $element, $data_type = 'primary' ) {
			$prefix = 'crafto_' . $data_type . '_';
			// Data Fancy Text Values.
			$crafto_fancy_text_animation_enable    = $element->get_settings( $prefix . 'data_fancy_text_settings' );
			$data_fancy_text_settings_colors       = $element->get_settings( $prefix . 'data_fancy_text_settings_colors' );
			$data_fancy_text_settings_effect       = $element->get_settings( $prefix . 'data_fancy_text_settings_effect' );
			$data_fancy_text_settings_ease         = $element->get_settings( $prefix . 'data_fancy_text_settings_ease' );
			$data_fancy_text_settings_start_delay  = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_start_delay' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_start_delay' )['size'] : '';
			$data_fancy_text_settings_duration     = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_duration' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_duration' )['size'] : '';
			$data_fancy_text_settings_speed        = isset( $element->get_settings( $prefix . 'data_fancy_text_settings_speed' )['size'] ) ? $element->get_settings( $prefix . 'data_fancy_text_settings_speed' )['size'] : '';
			$data_fancy_text_settings_x_opacity    = $element->get_settings( $prefix . 'data_fancy_text_settings_x_opacity' );
			$data_fancy_text_settings_y_opacity    = $element->get_settings( $prefix . 'data_fancy_text_settings_y_opacity' );
			$data_fancy_text_settings_translate_xx = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_xx' );
			$data_fancy_text_settings_translate_xy = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_xy' );
			$data_fancy_text_settings_translate_yx = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_yx' );
			$data_fancy_text_settings_translate_yy = $element->get_settings( $prefix . 'data_fancy_text_settings_translate_yy' );
			$data_fancy_text_settings_x_filter     = $element->get_settings( $prefix . 'data_fancy_text_settings_x_filter' );
			$data_fancy_text_settings_y_filter     = $element->get_settings( $prefix . 'data_fancy_text_settings_y_filter' );
			$data_fancy_text_settings_x_clippath   = $element->get_settings( $prefix . 'data_fancy_text_settings_x_clippath' );
			$data_fancy_text_settings_y_clippath   = $element->get_settings( $prefix . 'data_fancy_text_settings_y_clippath' );
			$data_fancy_text_settings_x_rotate     = $element->get_settings( $prefix . 'data_fancy_text_settings_x_rotate' );
			$data_fancy_text_settings_y_rotate     = $element->get_settings( $prefix . 'data_fancy_text_settings_y_rotate' );

			$fancy_text_value_arr = [];
			if ( 'yes' === $crafto_fancy_text_animation_enable ) {
				if ( 'custom' !== $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['effect'] = $data_fancy_text_settings_effect;
				}

				if ( 'wave' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'up';
				}

				if ( 'rubber-band' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'left';
				}

				if ( 'slide' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'right';
				}

				if ( 'smooth-wave' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['direction'] = 'down';
				}

				if ( 'none' !== $data_fancy_text_settings_ease ) {
					$fancy_text_value_arr['easing'] = $data_fancy_text_settings_ease;
				}

				if ( ! empty( $data_fancy_text_settings_colors ) && 'slide' === $data_fancy_text_settings_effect ) {
					$fancy_text_value_arr['color'] = $data_fancy_text_settings_colors;
				}

				if ( ! empty( $data_fancy_text_settings_duration ) ) {
					$fancy_text_value_arr['duration'] = (float) ( $data_fancy_text_settings_duration );
				}

				if ( ! empty( $data_fancy_text_settings_speed ) ) {
					$fancy_text_value_arr['speed'] = (float) ( $data_fancy_text_settings_speed );
				}

				if ( 'custom' === $data_fancy_text_settings_effect ) {
					if ( ! empty( $data_fancy_text_settings_start_delay ) ) {
						$fancy_text_value_arr['delay'] = (float) ( $data_fancy_text_settings_start_delay );
					}

					if ( ! empty( $data_fancy_text_settings_x_opacity ) && ! empty( $data_fancy_text_settings_y_opacity ) && $data_fancy_text_settings_x_opacity !== $data_fancy_text_settings_y_opacity ) {
						$fancy_text_value_arr['opacity'] = [ (float) $data_fancy_text_settings_x_opacity['size'], (float) $data_fancy_text_settings_y_opacity['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_x_rotate ) && ! empty( $data_fancy_text_settings_y_rotate ) && $data_fancy_text_settings_x_rotate !== $data_fancy_text_settings_y_rotate ) {
						$fancy_text_value_arr['rotate'] = [ (int) $data_fancy_text_settings_x_rotate['size'], (int) $data_fancy_text_settings_y_rotate['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_translate_xx ) && ! empty( $data_fancy_text_settings_translate_xy ) && $data_fancy_text_settings_translate_xx !== $data_fancy_text_settings_translate_xy ) {
						$fancy_text_value_arr['translateX'] = [ (float) $data_fancy_text_settings_translate_xx['size'], (float) $data_fancy_text_settings_translate_xy['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_translate_yx ) && ! empty( $data_fancy_text_settings_translate_yy ) && $data_fancy_text_settings_translate_yx !== $data_fancy_text_settings_translate_yy ) {
						$fancy_text_value_arr['translateY'] = [ (float) $data_fancy_text_settings_translate_yx['size'], (float) $data_fancy_text_settings_translate_yy['size'] ];
					}

					if ( ! empty( $data_fancy_text_settings_x_filter ) && ! empty( $data_fancy_text_settings_y_filter ) && $data_fancy_text_settings_x_filter !== $data_fancy_text_settings_y_filter ) {
						$fancy_text_value_arr['filter'] = [ 'blur(' . (float) $data_fancy_text_settings_x_filter['size'] . 'px)', 'blur(' . (float) $data_fancy_text_settings_y_filter['size'] . 'px)' ];
					}

					if ( ! empty( $data_fancy_text_settings_x_clippath ) && ! empty( $data_fancy_text_settings_y_clippath ) && $data_fancy_text_settings_x_clippath !== $data_fancy_text_settings_y_clippath ) {
						$fancy_text_value_arr['clipPath'] = [ 'inset(' . (float) $data_fancy_text_settings_x_clippath['top'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['right'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['bottom'] . 'px ' . (float) $data_fancy_text_settings_x_clippath['left'] . 'px)', 'inset(' . (float) $data_fancy_text_settings_y_clippath['top'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['right'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['bottom'] . 'px ' . (float) $data_fancy_text_settings_y_clippath['left'] . 'px)' ];
					}
				}
			}

			$data_fancy_text = ! empty( $fancy_text_value_arr ) ? $fancy_text_value_arr : [];
			
			return $data_fancy_text;
		}
	}
}
