<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Crafto widget for image.
 *
 * @package Crafto
 */

// If class `Image` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Image' ) ) {
	/**
	 * Define `Image` class.
	 */
	class Image extends Widget_Base {
		/**
		 * Retrieve the list of scripts the image widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$image_scripts                = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$image_scripts[] = 'crafto-widgets';
			} else {
				if ( '0' === $crafto_disable_all_animation ) {
					if ( crafto_disable_module_by_key( 'anime' ) ) {
						$image_scripts[] = 'anime';
						$image_scripts[] = 'animation';
					}

					if ( crafto_disable_module_by_key( 'parallax-liquid' ) ) {
						$image_scripts[] = 'parallax-liquid';
					}
				}

				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$image_scripts[] = 'atropos';
				}
				$image_scripts[] = 'crafto-tilt-box-widget';
				$image_scripts[] = 'crafto-image-widget';
			}

			return $image_scripts;
		}

		/**
		 * Retrieve the list of styles the image widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$image_styles = [];

			if ( crafto_disable_module_by_key( 'atropos' ) ) {
				$image_styles[] = 'atropos';
			}
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$image_styles[] = 'crafto-widgets';
			} else {
				$image_styles[] = 'crafto-image-widget';
			}
			return $image_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-image';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Image', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/image/';
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
				'photo',
				'visual',
				'picture',
				'media',
			];
		}

		/**
		 * Register Image widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_image_title',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_image',
				[
					'label'   => esc_html__( 'Choose Image', 'crafto-addons' ),
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
			$this->add_control(
				'crafto_image_fetch_priority',
				[
					'label'   => esc_html__( 'Fetch Priority', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => [
						'none' => esc_html__( 'Default', 'crafto-addons' ),
						'high' => esc_html__( 'High', 'crafto-addons' ),
						'low'  => esc_html__( 'Low', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_image_lazy_loading',
				[
					'label'   => esc_html__( 'Lazy Loading', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'no',
					'options' => [
						'no'  => esc_html__( 'Default', 'crafto-addons' ),
						'yes' => esc_html__( 'Yes', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_image_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
					'condition'   => [
						'crafto_image[url]!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_align',
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
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-image-wrapper'  => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_parallax',
				[
					'label' => esc_html__( 'Parallax', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_parallax',
				[
					'label'        => esc_html__( 'Enable Parallax', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'parallax',
					'separator'    => 'before',
				]
			);

			$this->add_control(
				'crafto_image_parallax_ratio',
				[
					'label'     => esc_html__( 'Parallax Ratio', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'unit' => 'px',
						'size' => 1.5,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1.5,
							'step' => 0.1,
						],
					],
					'condition' => [
						'crafto_parallax' => 'parallax',
					],
				]
			);

			$this->add_control(
				'crafto_image_scale_fraction_ratio',
				[
					'label'     => esc_html__( 'Scale Fraction Ratio', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.0001,
						],
					],
					'condition' => [
						'crafto_parallax' => 'parallax',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_floating_effect',
				[
					'label' => esc_html__( 'Floating Effect', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_image_float',
				[
					'label'        => esc_html__( 'Enable Floating Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'separator'    => 'before',
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'crafto_image_float_delay',
				[
					'label'       => esc_html__( 'Delay', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 0,
						'unit' => 'ms',
					],
					'condition'   => [
						'crafto_image_float' => 'yes',
					],
					'render_type' => 'template',
					'selectors'   => [
						'{{WRAPPER}} .animation-float' => '--float-delay: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_image_float_duration',
				[
					'label'       => esc_html__( 'Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 2000,
						'unit' => 'ms',
					],
					'condition'   => [
						'crafto_image_float' => 'yes',
					],
					'render_type' => 'template',
					'selectors'   => [
						'{{WRAPPER}} .animation-float' => '--float-duration: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_image_float_easing',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'linear',
					'options'   => [
						'linear'      => esc_html__( 'linear', 'crafto-addons' ),
						'ease'        => esc_html__( 'ease', 'crafto-addons' ),
						'ease-in'     => esc_html__( 'easeIn', 'crafto-addons' ),
						'ease-out'    => esc_html__( 'easeOut', 'crafto-addons' ),
						'ease-in-out' => esc_html__( 'easeInOut', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .animation-float' => '--float-animation-ease: {{VALUE}}',
					],
					'condition' => [
						'crafto_image_float' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_reveal_effect',
				[
					'label' => esc_html__( 'Reveal Effect', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_reveal_effect_settings',
				[
					'label'        => esc_html__( 'Enable Reveal Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'separator'    => 'before',
				]
			);
			$this->add_control(
				'crafto_reveal_effect_ease',
				[
					'label'     => esc_html__( 'Easing', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'easeOutQuad',
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
						'crafto_reveal_effect_settings' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_reveal_effect_direction',
				[
					'label'     => esc_html__( 'Direction', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'lr',
					'options'   => [
						'lr' => esc_html__( 'Left to Right', 'crafto-addons' ),
						'rl' => esc_html__( 'Right to Left', 'crafto-addons' ),
						'tb' => esc_html__( 'Top to Bottom', 'crafto-addons' ),
						'bt' => esc_html__( 'Bottom to Top', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_reveal_effect_settings' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_reveal_effect_colors',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'global'    => false,
					'default'   => '#FFCD28',
					'condition' => [
						'crafto_reveal_effect_settings' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_reveal_effect_duration',
				[
					'label'      => esc_html__( 'Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						'size' => 100,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_reveal_effect_settings' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_reveal_effect_delay',
				[
					'label'      => esc_html__( 'Delay', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
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
						'size' => 0,
						'unit' => 'ms',
					],
					'condition'  => [
						'crafto_reveal_effect_settings' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_shadow',
				[
					'label' => esc_html__( 'Shadow', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_enable_image_shadow',
				[
					'label'        => esc_html__( 'Enable Image Shadow', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				],
			);

			$this->add_control(
				'crafto_image_delay',
				[
					'label'     => esc_html__( 'Animation Delay', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => 100,
					'condition' => [
						'crafto_enable_image_shadow' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_3d_parallax_hover',
				[
					'label' => esc_html__( '3D Parallax Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_enable_3d_parallax_hover',
				[
					'label'        => esc_html__( 'Enable 3D Parallax Hover', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				],
			);
			$this->add_control(
				'crafto_3d_parallax_hover_image_offset',
				[
					'label'     => esc_html__( 'Image Offset', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => -5,
							'max' => 5,
						],
					],
					'condition' => [
						'crafto_enable_3d_parallax_hover' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_image_grayscale_on_scroll',
				[
					'label' => esc_html__( 'Grayscale on Scroll', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_enable_grayscale_on_scroll',
				[
					'label'        => esc_html__( 'Enable Grayscale on Scroll', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'default'      => '',
					'return_value' => 'yes',
				],
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_image_width',
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
							'max' => 1000,
						],
						'vw' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'      => [
						'{{WRAPPER}} .liquid-parallax-box, {{WRAPPER}} .image-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_space',
				[
					'label'          => esc_html__( 'Max Width', 'crafto-addons' ),
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
							'max' => 1000,
						],
						'vw' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'      => [
						'{{WRAPPER}} .liquid-parallax-box, {{WRAPPER}} .image-wrapper img' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_height',
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
							'max' => 500,
						],
						'vh' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .liquid-parallax-box, {{WRAPPER}} .image-wrapper img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_object_fit',
				[
					'label'     => esc_html__( 'Object Fit', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'condition' => [
						'crafto_image_height[size]!' => '',
					],
					'options'   => [
						''        => esc_html__( 'Default', 'crafto-addons' ),
						'fill'    => esc_html__( 'Fill', 'crafto-addons' ),
						'cover'   => esc_html__( 'Cover', 'crafto-addons' ),
						'contain' => esc_html__( 'Contain', 'crafto-addons' ),
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_object_position',
				[
					'label'     => esc_html__( 'Object Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'center center' => esc_html__( 'Center Center', 'crafto-addons' ),
						'center left'   => esc_html__( 'Center Left', 'crafto-addons' ),
						'center right'  => esc_html__( 'Center Right', 'crafto-addons' ),
						'top center'    => esc_html__( 'Top Center', 'crafto-addons' ),
						'top left'      => esc_html__( 'Top Left', 'crafto-addons' ),
						'top right'     => esc_html__( 'Top Right', 'crafto-addons' ),
						'bottom center' => esc_html__( 'Bottom Center', 'crafto-addons' ),
						'bottom left'   => esc_html__( 'Bottom Left', 'crafto-addons' ),
						'bottom right'  => esc_html__( 'Bottom Right', 'crafto-addons' ),
					],
					'default'   => 'center center',
					'selectors' => [
						'{{WRAPPER}} img' => 'object-position: {{VALUE}};',
					],
					'condition' => [
						'crafto_image_object_fit' => 'cover',
					],
				]
			);
			$this->add_control(
				'crafto_image_separator_panel_style',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);
			$this->start_controls_tabs(
				'crafto_image_effects'
			);
			$this->start_controls_tab(
				'normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_image_opacity',
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
						'{{WRAPPER}} img' => 'opacity: {{SIZE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'     => 'crafto_image_css_filters',
					'selector' => '{{WRAPPER}} img',
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_image_opacity_hover',
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
						'{{WRAPPER}}:hover img' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'     => 'crafto_image_css_filters_hover',
					'selector' => '{{WRAPPER}}:hover .image-wrapper',
				]
			);
			$this->add_control(
				'crafto_image_background_hover_transition',
				[
					'label'      => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						's',
						'ms',
						'custom',
					],
					'range'      => [
						's' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'default'    => [
						'unit' => 's',
					],
					'selectors'  => [
						'{{WRAPPER}} .liquid-parallax-box, {{WRAPPER}} .liquid-parallax, {{WRAPPER}} .image-wrapper img' => 'transition-duration: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_image_hover_animation',
				[
					'label' => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'  => Controls_Manager::HOVER_ANIMATION,
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_image_border',
					'selector'  => '{{WRAPPER}} .liquid-parallax-box, {{WRAPPER}} .image-wrapper img',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_image_border_radius',
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
						'{{WRAPPER}} .liquid-parallax-box, {{WRAPPER}} .image-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_image_box_shadow',
					'exclude'  => [
						'crafto_image_box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .liquid-parallax-box, {{WRAPPER}} .image-box:not(.shadow-in) .image-wrapper img, {{WRAPPER}} .image-box.shadow-animation.shadow-in',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render image widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$crafto_reveal_values = [];
			$settings             = $this->get_settings_for_display();
			$hover_animation      = $settings['crafto_image_hover_animation'];
			$grayscale_animation  = $settings['crafto_enable_grayscale_on_scroll'];
			$fetch_priority       = isset( $settings['crafto_image_fetch_priority'] ) && ! empty( $settings['crafto_image_fetch_priority'] ) ? $settings['crafto_image_fetch_priority'] : 'none';
			$crafto_lazy_loading  = isset( $settings['crafto_image_lazy_loading'] ) && ! empty( $settings['crafto_image_lazy_loading'] ) ? $settings['crafto_image_lazy_loading'] : 'no';

			$crafto_image_float                = $settings['crafto_image_float'];
			$crafto_image_parallax_ratio       = $settings['crafto_image_parallax_ratio'];
			$crafto_image_scale_fraction_ratio = $settings['crafto_image_scale_fraction_ratio'];
			$crafto_image_parallax_ratio       = ( isset( $crafto_image_parallax_ratio['size'] ) & ! empty( $crafto_image_parallax_ratio['size'] ) ) ? $crafto_image_parallax_ratio['size'] : 0.5;
			$crafto_image_scale_fraction_ratio = ( isset( $crafto_image_scale_fraction_ratio['size'] ) & ! empty( $crafto_image_scale_fraction_ratio['size'] ) ) ? $crafto_image_scale_fraction_ratio['size'] : '';

			// Start Reveal Effect.
			$crafto_enable_effect     = $settings['crafto_reveal_effect_settings'];
			$crafto_image_easing      = $settings['crafto_reveal_effect_ease'];
			$crafto_image_direction   = $settings['crafto_reveal_effect_direction'];
			$crafto_image_colors      = $settings['crafto_reveal_effect_colors'];
			$crafto_image_duration    = ( isset( $settings['crafto_reveal_effect_duration']['size'] ) ) ? $settings['crafto_reveal_effect_duration']['size'] : '';
			$crafto_image_start_delay = ( isset( $settings['crafto_reveal_effect_delay']['size'] ) ) ? $settings['crafto_reveal_effect_delay']['size'] : '';

			// 3D Parallax Hover.
			$crafto_enable_3d_parallax_hover = $settings['crafto_enable_3d_parallax_hover'];
			$crafto_atropos_offset           = ( isset( $settings['crafto_3d_parallax_hover_image_offset']['size'] ) && ! empty( $settings['crafto_3d_parallax_hover_image_offset']['size'] ) ) ? (int) $settings['crafto_3d_parallax_hover_image_offset']['size'] : 0;

			if ( 'yes' === $crafto_enable_effect ) {
				$crafto_reveal_values['effect'] = 'slide';
				if ( ! empty( $crafto_image_duration ) ) {
					$crafto_reveal_values['duration'] = (float) ( $crafto_image_duration );
				}

				if ( ! empty( $crafto_image_start_delay ) ) {
					$crafto_reveal_values['delay'] = (float) ( $crafto_image_start_delay );
				}

				if ( 'none' !== $crafto_image_easing ) {
					$crafto_reveal_values['easing'] = $crafto_image_easing;
				}
				if ( 'none' !== $crafto_image_direction ) {
					$crafto_reveal_values['direction'] = $crafto_image_direction;
				}
				if ( ! empty( $crafto_image_colors ) ) {
					$crafto_reveal_values['color'] = $crafto_image_colors;
				}

				$crafto_reveal_effect = ! empty( $crafto_reveal_values ) ? $crafto_reveal_values : [];
			}
			// End Reveal Effect.

			// Start Image Shadow.
			$crafto_image_shadow = $settings['crafto_enable_image_shadow'];
			$crafto_image_delay  = $settings['crafto_image_delay'];

			$class_arr = array( 'elementor-animation-' . esc_attr( $hover_animation ) );

			$default_attr = [];
			if ( 'none' !== $fetch_priority ) {
				$default_attr['fetchpriority'] = $fetch_priority;
			}

			if ( 'yes' === $crafto_lazy_loading ) {
				$default_attr['loading'] = 'lazy';
			}

			if ( 'parallax' === $settings['crafto_parallax'] ) {
				$class_arr[] = 'liquid-parallax';
				$class_arr[] = 'has-parallax-liquid';

				$default_attr['data-parallax-scale']          = esc_attr( $crafto_image_parallax_ratio );
				$default_attr['data-parallax-scale-fraction'] = esc_attr( $crafto_image_scale_fraction_ratio );
			}

			if ( 'yes' === $crafto_image_float ) {
				$class_arr[] = 'has-float';
				$class_arr[] = 'animation-float' . esc_attr( $hover_animation );
			}

			$class_list            = implode( ' ', $class_arr );
			$default_attr['class'] = $class_list;

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'crafto-image-wrapper',
						],
					],
				]
			);

			$this->add_render_attribute(
				[
					'parallax' => [
						'class' => [
							'image-wrapper',
						],
					],
				]
			);

			if ( 'parallax' === $settings['crafto_parallax'] ) {
				$this->add_render_attribute(
					[
						'parallax_box' => [
							'class' => [
								'liquid-parallax-box',
							],
						],
					]
				);
			} else {
				$this->add_render_attribute(
					[
						'parallax_box' => [
							'class' => [
								'image-box',
							],
						],
					]
				);
			}

			if ( 'yes' === $crafto_enable_effect ) {
				$this->add_render_attribute(
					[
						'parallax_box' => [
							'class'      => [
								'entrance-animation',
								'reveal-effect',
							],
							'data-anime' => wp_json_encode( $crafto_reveal_effect ),
						],
					]
				);
			}

			if ( 'yes' === $crafto_image_shadow ) {
				$this->add_render_attribute(
					[
						'parallax_box' => [
							'class'                 => [
								'shadow-animation',
							],
							'data-shadow-animation' => $crafto_image_shadow,
							'data-animation-delay'  => $crafto_image_delay,
						],
					]
				);
			}

			// Link on Image.
			$img_alt = '';
			if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
				$img_alt = get_post_meta( $settings['crafto_image']['id'], '_wp_attachment_image_alt', true );
				if ( empty( $img_alt ) ) {
					$img_alt = esc_attr( get_the_title( $settings['crafto_image']['id'] ) );
				}
			}

			if ( ! empty( $settings['crafto_image_link']['url'] ) ) {
				$this->add_link_attributes( '_imagelink', $settings['crafto_image_link'] );
				$this->add_render_attribute( '_imagelink', 'class', 'image-link' );
				$this->add_render_attribute( '_imagelink', 'aria-label', $img_alt );
			}
			// End Link on Image.
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				if ( ! empty( $settings['crafto_image_link']['url'] ) ) {
					?>
					<a <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
					<?php
				}
				?>
				<div <?php $this->print_render_attribute_string( 'parallax_box' ); ?>>
					<div <?php $this->print_render_attribute_string( 'parallax' ); ?>>
						<?php
						if ( 'yes' === $grayscale_animation ) {
							?>
							<div data-0-top="filter: grayscale(1);" data-15-bottom="filter: grayscale(0);">
							<?php
						}
						if ( 'yes' === $crafto_enable_3d_parallax_hover ) {
							?>
							<div class="atropos has-atropos">
							<div class="atropos-scale">
							<div class="atropos-rotate">
							<div class="atropos-inner" data-atropos-offset="<?php echo esc_attr( (int) $crafto_atropos_offset ); ?>">
							<?php
						}

						echo wp_kses_post( crafto_get_attachment_image_html( $settings, $settings['crafto_thumbnail_size'], $settings['crafto_image'], $default_attr ) );

						if ( 'yes' === $crafto_enable_3d_parallax_hover ) {
							?>
							</div>
							</div>
							</div>
							</div>
							<?php
						}
						if ( 'yes' === $grayscale_animation ) {
							?>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
				if ( ! empty( $settings['crafto_image_link']['url'] ) ) {
					?>
					</a>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
}
