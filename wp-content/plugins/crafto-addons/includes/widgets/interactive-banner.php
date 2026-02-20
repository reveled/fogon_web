<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for Interactive Banner.
 *
 * @package Crafto
 */

// If class `Interactive_Banner` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Interactive_Banner' ) ) {
	/**
	 * Define `Interactive_Banner` class.
	 */
	class Interactive_Banner extends Widget_Base {
		/**
		 * Retrieve the list of scripts the interactive banner widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$interactive_banner_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$interactive_banner_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$interactive_banner_scripts[] = 'atropos';
				}
				$interactive_banner_scripts[] = 'crafto-interactive-banner';
			}
			return $interactive_banner_scripts;
		}

		/**
		 * Retrieve the list of styles the crafto interactive banner depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @since 1.3.0
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$interactive_banner_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$interactive_banner_styles[] = 'crafto-widgets-rtl';
				} else {
					$interactive_banner_styles[] = 'crafto-widgets';
				}
			} else {
				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$interactive_banner_styles[] = 'atropos';
				}

				if ( is_rtl() ) {
					$interactive_banner_styles[] = 'crafto-interactive-banner-rtl';
				}
				$interactive_banner_styles[] = 'crafto-interactive-banner';
			}
			return $interactive_banner_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-interactive-banner';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Interactive Banner', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-banner crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/interactive-banner/';
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
				'promo',
				'modern',
				'Overlay',
				'info',
			];
		}

		/**
		 * Register interactive banner widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_interactive_banner_description_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),

				]
			);
			$this->add_control(
				'crafto_interactive_banner_styles',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'interactive-banner-style-1',
					'options' => [
						'interactive-banner-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'interactive-banner-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'interactive-banner-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'interactive-banner-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'interactive-banner-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_bg_image',
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
					'condition' => [
						'crafto_bg_image[url]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_link_on_image',
				[
					'label'        => esc_html__( 'Enable Link on Whole Box', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_bg_image[url]!'            => '',
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-1',
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
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
						'crafto_bg_image[url]!' => '',
						'crafto_link_on_image!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_icon_link',
				[
					'label'       => esc_html__( 'Link on Icon and Title', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
					'condition'   => [
						'crafto_link_on_image'             => '',
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-1',
							'interactive-banner-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_category_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Label', 'crafto-addons' ),
					'condition'   => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-3',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_title_text',
				[
					'label'       => esc_html__( 'Heading', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write heading here', 'crafto-addons' ),
					'label_block' => true,

				]
			);
			$this->add_control(
				'crafto_title_size',
				[
					'label'   => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
						'h1'   => 'H1',
						'h2'   => 'H2',
						'h3'   => 'H3',
						'h4'   => 'H4',
						'h5'   => 'H5',
						'h6'   => 'H6',
						'div'  => 'div',
						'span' => 'span',
						'p'    => 'p',
					],
					'default' => 'h5',
				]
			);
			$this->add_control(
				'crafto_description_text',
				[
					'label'      => esc_html__( 'Description', 'crafto-addons' ),
					'type'       => Controls_Manager::TEXTAREA,
					'show_label' => true,
					'dynamic'    => [
						'active' => true,
					],
					'rows'       => 10,
					'separator'  => 'none',
					'default'    => esc_html__( 'Lorem ipsum dolor sit amet.', 'crafto-addons' ),
					'condition'  => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_label',
				[
					'label'       => esc_html__( 'Offer Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'GET 50% OFF', 'crafto-addons' ),
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-2',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_link_enable',
				[
					'label'        => esc_html__( 'Enable CTA on Hover', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
					'condition'    => [
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
					'condition'   => [
						'crafto_link_enable!'              => '',
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_link_enable!'              => '',
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-2',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_interactive_banner_button',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'condition' => [
						'crafto_interactive_banner_styles' => 'interactive-banner-style-4',
					],
				]
			);
			$this->add_control(
				'crafto_button_text',
				[
					'label'       => esc_html__( 'Button Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Click Here', 'crafto-addons' ),
					'placeholder' => esc_html__( 'Click here', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_button_link',
				[
					'label'       => esc_html__( 'Button Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_interactive_banner_icon',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-4',
						],
					],
				]
			);

			$this->add_control(
				'crafto_custom_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);

			$this->add_control(
				'crafto_icons',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => array(
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					),
					'condition'        => [
						'crafto_custom_image' => '',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);

			$this->add_control(
				'crafto_image',
				[
					'label'     => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_custom_image!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_image',
					'default'   => 'large',
					'separator' => 'none',
					'condition' => [
						'crafto_custom_image!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_icon_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'default',
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'condition'    => [
						'crafto_custom_image'    => '',
						'crafto_icons[library]!' => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
					],
					'prefix_class' => 'elementor-view-',
				]
			);
			$this->add_control(
				'crafto_icon_shape',
				[
					'label'        => esc_html__( 'Shape', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => esc_html__( 'Circle', 'crafto-addons' ),
						'square' => esc_html__( 'Square', 'crafto-addons' ),
					],
					'default'      => 'circle',
					'condition'    => [
						'crafto_icon_view!'      => 'default',
						'crafto_custom_image'    => '',
						'crafto_icons[library]!' => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
					],
					'prefix_class' => 'elementor-shape-',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_carousel_setting',
				[
					'label' => esc_html__( 'Tilt Effect', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_interactive_till_effect',
				[
					'label'        => esc_html__( 'Enable Tilt Effect', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'effect_off'   => esc_html__( 'No', 'crafto-addons' ),
					'effect_on'    => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_interactive_banner_data_atropos_offset',
				[
					'label'     => esc_html__( 'Tilt Offset', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => -5,
							'max' => 5,
						],
					],
					'condition' => [
						'crafto_interactive_till_effect' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_interactive_banner_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_alignment',
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
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .interactive-banner' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-1',
							'interactive-banner-style-2',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_align_position',
				[
					'label'     => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .interactive-banner' => 'align-items: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_align_vertical',
				[
					'label'     => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center'     => [
							'title' => esc_html__( 'center', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .interactive-banner' => 'justify-content: {{VALUE}};',
					],
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-3',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_interactive_overlay',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .interactive-box-overlay, {{WRAPPER}} .interactive-banner',
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_interactive_box_shadow',
					'selector' => '{{WRAPPER}} .interactive-banner-wrapper',
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-4 .banner-box, {{WRAPPER}} .interactive-banner-wrapper:not(.interactive-banner-style-4)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_padding',
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
						'{{WRAPPER}} .interactive-banner-wrapper .interactive-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_slide_button',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_interactive_banner_styles' => 'interactive-banner-style-4',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_button_typography_opt',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .crafto-button-wrapper .elementor-button-text',
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_button_bg_color_opt',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} a.elementor-button-link',
				]
			);
			$this->start_controls_tabs(
				'crafto_interactive_banner_button_tab'
			);
			$this->start_controls_tab(
				'crafto_interactive_banner_button_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_button_text_color_opt',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-button-wrapper .elementor-button-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_interactive_banner_button_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_button_text_hover_color_opt',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-button-link:hover .elementor-button-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_button_box_size_opt',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 100,
							'max' => 200,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-button-wrapper a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'separator' => 'before',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_icon_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-1',
							'interactive-banner-style-2',
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 75,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-icon img' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_interactive_banner_shape_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 0,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .elementor-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_icon_view!' => 'default',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-3',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				],
			);
			$this->add_responsive_control(
				'crafto_interactivebanner_shape_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 0,
							'max' => 150,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .elementor-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-2',
							'interactive-banner-style-3',
							'interactive-banner-style-4',
						],
					],
				],
			);
			$this->add_responsive_control(
				'crafto_icon_space',
				[
					'label'      => esc_html__( 'Icon Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .interactive-banner-wrapper:not(.interactive-banner-style-3, .interactive-banner-style-5) .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-3 .elementor-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-5 .elementor-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-5 .elementor-icon' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-3 .elementor-icon' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'icon_tabs' );
			$this->start_controls_tab(
				'crafto_icon_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image'    => '',
						'crafto_icon_link[url]!' => '',
						'crafto_link_on_image'   => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image'    => '',
						'crafto_icon_link[url]!' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon i, {{WRAPPER}}.elementor-view-default .elementor-icon i, {{WRAPPER}}.elementor-view-stacked .elementor-icon i'     => 'color: {{VALUE}};',
						'{{WRAPPER}} .interactive-banner-style-3 .elementor-icon i, {{WRAPPER}} .interactive-banner-style-5 .elementor-icon i'     => 'color: {{VALUE}};',
						'{{WRAPPER}} .interactive-banner-style-3 .elementor-icon svg, {{WRAPPER}} .interactive-banner-style-5 .elementor-icon svg'     => 'fill: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon svg, {{WRAPPER}}.elementor-view-default .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'       => 'stacked',
						'crafto_custom_image'    => '',
						'crafto_icon_link[url]!' => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'       => 'framed',
						'crafto_custom_image'    => '',
						'crafto_icon_link[url]!' => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_default_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_custom_image'    => '',
						'crafto_icon_link[url]!' => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-2',
							'interactive-banner-style-3',
							'interactive-banner-style-4',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-4',
						],
						'crafto_view!' => [
							'default',
							'stacked',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles!' => 'interactive-banner-style-3',
						'crafto_view!' => [
							'default',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_colors_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_custom_image'    => '',
						'crafto_link_on_image'   => '',
						'crafto_icon_link[url]!' => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-5',
						],
					],
				]
			);

			$this->add_control(
				'crafto_icon_hover_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'condition' => [
						'crafto_icon_link[url]!' => '',
						'crafto_custom_image'    => '',
						'crafto_link_on_image'   => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-5',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-3 .icon-wrap:hover .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon i, {{WRAPPER}}.elementor-view-default:hover .elementor-icon i, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i'     => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-default:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg, {{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-3 .icon-wrap:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_hover_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'       => 'stacked',
						'crafto_icon_link[url]!' => '',
						'crafto_custom_image'    => '',
						'crafto_link_on_image'   => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_icon_view'       => 'framed',
						'crafto_icon_link[url]!' => '',
						'crafto_custom_image'    => '',
						'crafto_link_on_image'   => '',
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_icon_box_shadow',
					'selector'  => '{{WRAPPER}} .interactive-banner-wrapper .elementor-icon',
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-2',
							'interactive-banner-style-3',
							'interactive-banner-style-5',
						],
						'crafto_icon_view!' => 'default',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_interactive_banner_title_style_section',
				[
					'label' => esc_html__( 'Heading', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_interactive_banner_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .interactive-banner .title',
				]
			);
			$this->start_controls_tabs( 'title_tabs' );
			$this->start_controls_tab(
				'crafto_title_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-2',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
						'crafto_icon_link[url]!' => '',
						'crafto_link_on_image'   => '',
					],
				]
			);
			$this->add_control(
				'crafto_interactive_banner_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .interactive-banner .title, {{WRAPPER}} .interactive-banner .title a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_title_colors_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-2',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
						'crafto_icon_link[url]!' => '',
						'crafto_link_on_image'   => '',
					],
				]
			);
			$this->add_control(
				'crafto_interactive_banner_title_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-1 .title a:hover, {{WRAPPER}} .interactive-banner-wrapper.interactive-banner-style-3 .icon-wrap:hover .title' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_icon_link[url]!' => '',
						'crafto_link_on_image'   => '',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_interactive_banner_heading_separator',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-2',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
						'crafto_icon_link[url]!' => '',
						'crafto_link_on_image'   => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_title_width',
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
							'min'  => 0,
							'max'  => 500,
							'step' => 1,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner .title' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_title_margin',
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
						'{{WRAPPER}} .interactive-banner .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_interactive_banner_label_style_section',
				[
					'label'     => esc_html__( 'Offer Text', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-2',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_interactive_banner_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .interactive-banner-wrapper .label',
				]
			);
			$this->add_control(
				'crafto_interactive_banner_label_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .interactive-banner-wrapper .label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_interactive_banner_label_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .interactive-banner-wrapper .label',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_interactive_banner_label_border',
					'selector' => '{{WRAPPER}} .interactive-banner-wrapper .label',
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_label_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_label_padding',
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
						'{{WRAPPER}} .interactive-banner-wrapper .label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_interactive_banner_icon_box_style_section',
				[
					'label'     => esc_html__( 'Call to Action', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_interactive_banner_styles' => 'interactive-banner-style-2',
						'crafto_link_enable'               => 'yes',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_icon_button_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .read-more-icon' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_interactive_banner_button_shape_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 0,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .read-more-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				],
			);
			$this->add_control(
				'crafto_interactive_banner_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .interactive-banner-wrapper .read-more-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .interactive-banner-wrapper .read-more-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_interactive_banner_icon_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .interactive-banner-wrapper .read-more-icon',
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_icon_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .read-more-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_interactive_banner_description_style_section',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_interactive_banner_styles' => [
							'interactive-banner-style-1',
							'interactive-banner-style-3',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_content_alignment',
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
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .interactive-banner .description' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-2',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_interactive_banner_description_typography',
					'selector' => '{{WRAPPER}} .interactive-banner .description',
				]
			);
			$this->add_control(
				'crafto_interactive_banner_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .interactive-banner .description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_interactive_banner_description_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner .description' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_description_width',
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
							'min'  => 15,
							'max'  => 500,
							'step' => 1,
						],
						'%'  => [
							'min' => 15,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner .description' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_interactive_banner_description_margin',
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
						'{{WRAPPER}} .interactive-banner .description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_interactive_banner_category_style_section',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-3',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
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
					'selector' => '{{WRAPPER}} .interactive-banner-wrapper .interactive-banner-category-text',
				]
			);
			$this->add_control(
				'crafto_interactive_category_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' =>
					[
						'{{WRAPPER}} .interactive-banner-wrapper .interactive-banner-category-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_interactive_category_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .interactive-banner-wrapper .interactive-banner-category-text' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-2',
							'interactive-banner-style-3',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_category_box_shadow',
					'selector'  => '{{WRAPPER}} .interactive-banner-wrapper .interactive-banner-category-text',
					'condition' => [
						'crafto_interactive_banner_styles' => 'interactive-banner-style-1',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_interactive_category_border',
					'selector'  => '{{WRAPPER}} .interactive-banner-wrapper .interactive-banner-category-text',
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-2',
							'interactive-banner-style-3',
							'interactive-banner-style-4',
							'interactive-banner-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_feature_category_box_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .interactive-banner-category-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles' => 'interactive-banner-style-1',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_category_box_margin',
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
						'{{WRAPPER}} .interactive-banner-wrapper .interactive-banner-category-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles' => 'interactive-banner-style-2',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_box_overlay',
				[
					'label' => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->start_controls_tabs( 'crafto_tabs_background_overlay' );
			$this->start_controls_tab(
				'crafto_tab_background_overlay',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_image_box_overlay_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .interactive-banner-wrapper .box-overlay',
				]
			);
			$this->add_control(
				'crafto_image_box_overlay_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper .box-overlay' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
						],
					],
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_tab_background_hvr_overlay',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-4',
						],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_hvr_overlay_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .interactive-banner-wrapper:hover .box-overlay',
					'condition' => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-4',
						],
					],
				]
			);

			$this->add_control(
				'crafto_image_box_overlay_hvr_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max'  => 1,
							'min'  => 0.10,
							'step' => 0.01,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .interactive-banner-wrapper:hover .box-overlay' => 'opacity: {{SIZE}};',
					],
					'condition'  => [
						'crafto_interactive_banner_styles!' => [
							'interactive-banner-style-1',
							'interactive-banner-style-4',
						],
					],
				]
			);

			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render interactive banner widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                  = $this->get_settings_for_display();
			$interactive_banner_styles = ( isset( $settings['crafto_interactive_banner_styles'] ) && $settings['crafto_interactive_banner_styles'] ) ? $settings['crafto_interactive_banner_styles'] : 'interactive-banner-style-1';
			$crafto_title_text         = ( isset( $settings['crafto_title_text'] ) && $settings['crafto_title_text'] ) ? $settings['crafto_title_text'] : '';
			$link_on_image             = ( isset( $settings['crafto_link_on_image'] ) && $settings['crafto_link_on_image'] ) ? $settings['crafto_link_on_image'] : '';
			$crafto_description_text   = ( isset( $settings['crafto_description_text'] ) && $settings['crafto_description_text'] ) ? $settings['crafto_description_text'] : '';
			$crafto_label              = ( isset( $settings['crafto_label'] ) && $settings['crafto_label'] ) ? $settings['crafto_label'] : '';
			$crafto_category_text      = ( isset( $settings['crafto_category_text'] ) && $settings['crafto_category_text'] ) ? $settings['crafto_category_text'] : '';
			$crafto_button_text        = ( isset( $settings['crafto_button_text'] ) && $settings['crafto_button_text'] ) ? $settings['crafto_button_text'] : '';

			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							'interactive-banner-wrapper',
							$interactive_banner_styles,
						],
					],
				]
			);
			if ( ! empty( $settings['crafto_button_link']['url'] ) ) {
				$this->add_render_attribute( 'crafto_button', 'class', 'elementor-button-link' );
				$this->add_render_attribute( 'crafto_button', 'href', $settings['crafto_button_link']['url'] );
			}
			// Link on Image.
			if ( ! empty( $settings['crafto_image_link']['url'] ) ) {
				$this->add_link_attributes(
					'_imagelink',
					$settings['crafto_image_link'],
				);
			}
			// End Link on Image.
			// Link on Icon.
			$img_alt = '';
			if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
				$img_alt = get_post_meta( $settings['crafto_image']['id'], '_wp_attachment_image_alt', true );
				if ( empty( $img_alt ) ) {
					$img_alt = esc_attr( get_the_title( $settings['crafto_image']['id'] ) );
				}
			}
			if ( ! empty( $settings['crafto_icon_link']['url'] ) ) {
				$this->add_link_attributes( '_iconlink', $settings['crafto_icon_link'] );
				$this->add_render_attribute( '_iconlink', 'class', 'image-link' );
				$this->add_render_attribute( '_iconlink', 'class', 'icon-wrap' );
				$this->add_render_attribute( '_iconlink', 'aria-label', $img_alt );
			}
			// End Link on Icon.
			$this->crafto_interactive_wrapper_start();
			?>
			<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?> >
				<?php
				switch ( $interactive_banner_styles ) {
					case 'interactive-banner-style-1':
						if ( ! empty( $settings['crafto_bg_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_bg_image']['id'] ) ) {
							$settings['crafto_bg_image']['id'] = '';
						}
						if ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['id'] ) && ! empty( $settings['crafto_bg_image']['id'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['url'] ) && ! empty( $settings['crafto_bg_image']['url'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}
						if ( ! empty( $crafto_category_text ) || ! empty( $crafto_title_text ) || ! empty( $crafto_description_text ) ) {
							if ( 'yes' === $link_on_image && ! empty( $settings['crafto_image_link']['url'] ) ) {
								?>
								<a class="interactive-banner" <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							} else {
								?>
								<figcaption class="interactive-banner">
								<?php
							}
							?>
							<div class="fancy-icon">
								<?php
								if ( '' === $link_on_image && ! empty( $settings['crafto_icon_link']['url'] ) ) {
									?>
									<a <?php $this->print_render_attribute_string( '_iconlink' ); ?>>
									<?php
								}
								$this->interactive_banner_render_icon();
								if ( '' === $link_on_image && ! empty( $settings['crafto_icon_link']['url'] ) ) {
									?>
									</a>
									<?php
								}
								?>
							</div>
							<?php
							if ( ! empty( $crafto_category_text ) ) {
								?>
								<div class="interactive-banner-category-text">
									<?php echo sprintf( '%s', $crafto_category_text ); // phpcs:ignore ?>
								</div>
								<?php
							}
							if ( ! empty( $crafto_title_text ) ) {
								?>
								<<?php echo $settings['crafto_title_size']; // phpcs:ignore ?> class="title">
									<?php
									if ( '' === $link_on_image && ! empty( $settings['crafto_icon_link']['url'] ) ) {
										?>
										<a <?php $this->print_render_attribute_string( '_iconlink' ); ?>>
										<?php
									}
									echo sprintf( '%s', $crafto_title_text ); // phpcs:ignore
									if ( '' === $link_on_image && ! empty( $settings['crafto_icon_link']['url'] ) ) {
										?>
										</a>
										<?php
									}
									?>
								</<?php echo $settings['crafto_title_size']; // phpcs:ignore ?>>
								<?php
							}
							if ( ! empty( $crafto_description_text ) ) {
								?>
								<p class="description">
									<?php echo sprintf( '%s', $crafto_description_text ); // phpcs:ignore ?>
								</p>
								<?php
							}
							?>
							<div class="box-overlay"></div>
							<div class="interactive-box-overlay"></div>
							<?php
							if ( 'yes' === $link_on_image && ! empty( $settings['crafto_image_link']['url'] ) ) {
								?>
								</a>
								<?php
							} else {
								?>
								</figcaption>
								<?php
							}
						}
						break;
					case 'interactive-banner-style-2':
						if ( ! empty( $settings['crafto_bg_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_bg_image']['id'] ) ) {
							$settings['crafto_bg_image']['id'] = '';
						}
						if ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['id'] ) && ! empty( $settings['crafto_bg_image']['id'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['url'] ) && ! empty( $settings['crafto_bg_image']['url'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}

						if ( ! empty( $crafto_category_text ) || ! empty( $crafto_title_text ) ) {
							?>
							<div class="box-overlay"></div>
							<figcaption class="interactive-banner">
								<div class="fancy-icon">
									<?php $this->interactive_banner_render_icon(); ?>
								</div>
								<?php
								if ( ! empty( $crafto_category_text ) ) {
									?>
									<div class="interactive-banner-category-text">
										<?php echo sprintf( '%s', $crafto_category_text ); // phpcs:ignore ?>
									</div>
									<?php
								}

								if ( ! empty( $crafto_title_text ) ) {
									?>
									<<?php echo $settings['crafto_title_size']; ?> class="title"><?php // phpcs:ignore
										echo sprintf( '%s', $crafto_title_text ); // phpcs:ignore
									?>
									</<?php echo $settings['crafto_title_size']; // phpcs:ignore ?>>
									<?php
								}

								if ( ! empty( $crafto_label ) ) {
									?>
									<span class="label">
										<?php echo sprintf( '%s', $crafto_label ); // phpcs:ignore ?>
									</span>
									<?php
								}
								$this->crafto_get_link_icon( $settings );
								?>
							</figcaption>
							<?php
						}
						break;
					case 'interactive-banner-style-3':
						if ( ! empty( $settings['crafto_bg_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_bg_image']['id'] ) ) {
							$settings['crafto_bg_image']['id'] = '';
						}
						if ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['id'] ) && ! empty( $settings['crafto_bg_image']['id'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['url'] ) && ! empty( $settings['crafto_bg_image']['url'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}
						?>
						<div class="box-overlay"></div>
						<?php
						if ( ! empty( $crafto_category_text ) || ! empty( $crafto_title_text ) ) {
							if ( 'yes' === $link_on_image && ! empty( $settings['crafto_image_link']['url'] ) ) {
								?>
								<a class="interactive-banner" <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							} else {
								?>
								<figcaption class="interactive-banner">
								<?php
							}
							?>
								<?php
								if ( ! empty( $crafto_description_text ) ) {
									?>
									<p class="description">
										<?php echo sprintf( '%s', $crafto_description_text ); // phpcs:ignore ?>
									</p>
									<?php
								}
								if ( ! empty( $crafto_title_text ) ) {
									if ( ! empty( $settings['crafto_icon_link']['url'] ) ) {
										?>
										<a <?php $this->print_render_attribute_string( '_iconlink' ); ?>>
										<?php
									} else {
										?>
										<div class="icon-wrap">
										<?php
									}
									?>
									<div class="fancy-icon">
										<?php $this->interactive_banner_render_icon(); ?>
									</div>
									<<?php echo $settings['crafto_title_size']; ?> class="title"><?php // phpcs:ignore
										echo sprintf( '%s', $crafto_title_text ); // phpcs:ignore
									?>
									</<?php echo $settings['crafto_title_size']; // phpcs:ignore ?>>
									<?php
									if ( ! empty( $settings['crafto_icon_link']['url'] ) ) {
										?>
										</a>
										<?php
									} else {
										?>
										</div>
										<?php
									}
								}
								?>
							</figcaption>
							<?php
						}
						break;
					case 'interactive-banner-style-4':
						?>
						<div class="banner-box">
							<?php
							if ( ! empty( $settings['crafto_bg_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_bg_image']['id'] ) ) {
								$settings['crafto_bg_image']['id'] = '';
							}
							if ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['id'] ) && ! empty( $settings['crafto_bg_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['url'] ) && ! empty( $settings['crafto_bg_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							?>
							<div class="box-overlay"></div>
							<div class="elementor-button-wrapper crafto-button-wrapper crafto-button-wrapper">
								<?php
								if ( ! empty( $settings['crafto_button_link']['url'] ) ) {
									?>
									<a <?php $this->print_render_attribute_string( 'crafto_button' ); ?>>
									<?php
								} else {
									?>
									<a href="#" class="elementor-button-link">
									<?php
								}
								?>
									<span class="elementor-button-content-wrapper">
										<span class="elementor-button-text"><?php echo esc_html( $crafto_button_text ); ?></span>
									</span>
								</a>
							</div>
						</div>
						<?php
						if ( ! empty( $crafto_title_text ) ) {
							?>
							<figcaption class="interactive-banner">
								<<?php echo $settings['crafto_title_size']; ?> class="title"><?php // phpcs:ignore
									echo sprintf( '%s', $crafto_title_text ); // phpcs:ignore
								?>
								</<?php echo $settings['crafto_title_size']; // phpcs:ignore ?>>
								<?php
								if ( ! empty( $crafto_description_text ) ) {
									?>
									<p class="description">
										<?php echo sprintf( '%s', $crafto_description_text ); // phpcs:ignore ?>
									</p>
									<?php
								}
								?>
							</figcaption>
							<?php
						}
						break;
					case 'interactive-banner-style-5':
						if ( ! empty( $settings['crafto_bg_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_bg_image']['id'] ) ) {
							$settings['crafto_bg_image']['id'] = '';
						}
						if ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['id'] ) && ! empty( $settings['crafto_bg_image']['id'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_bg_image'] ) && isset( $settings['crafto_bg_image']['url'] ) && ! empty( $settings['crafto_bg_image']['url'] ) ) {
							crafto_get_attachment_html( $settings['crafto_bg_image']['id'], $settings['crafto_bg_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}
						if ( ! empty( $crafto_title_text ) || ! empty( $crafto_description_text ) ) {
							if ( 'yes' === $link_on_image && ! empty( $settings['crafto_image_link']['url'] ) ) {
								?>
								<a class="interactive-banner" <?php $this->print_render_attribute_string( '_imagelink' ); ?>>
								<?php
							} else {
								?>
								<figcaption class="interactive-banner">
								<?php
							}
							if ( ! empty( $crafto_label ) ) {
								?>
								<span class="label">
									<?php echo sprintf( '%s', $crafto_label ); // phpcs:ignore ?>
								</span>
								<?php
							}
							?>
							<div class="fancy-text-content">
								<?php
								if ( ! empty( $crafto_title_text ) || ! empty( $crafto_description_text ) ) {
									?>
									<div class="content-wrapper">
										<?php
										if ( ! empty( $crafto_title_text ) ) {
											?>
											<<?php echo $settings['crafto_title_size']; ?> class="title"><?php // phpcs:ignore
												echo sprintf( '%s', $crafto_title_text ); // phpcs:ignore
											?>
											</<?php echo $settings['crafto_title_size']; // phpcs:ignore ?>>
											<?php
										}
										if ( ! empty( $crafto_description_text ) ) {
											?>
											<p class="description">
												<?php echo sprintf( '%s', $crafto_description_text ); // phpcs:ignore ?>
											</p>
											<?php
										}
										?>
									</div>
									<?php
								}
								?>
								<div class="fancy-icon">
									<?php $this->interactive_banner_render_icon(); ?>
								</div>
							</div>
							<div class="box-overlay"></div>
							<?php
							if ( 'yes' === $link_on_image && ! empty( $settings['crafto_image_link']['url'] ) ) {
								?>
								</a>
								<?php
							} else {
								?>
								</figcaption>
								<?php
							}
						}
						break;
				}
				?>
			</figure>
			<?php
			$this->crafto_interactive_wrapper_end();
		}

		/**
		 * Widget effect start.
		 *
		 * @access public
		 */
		public function crafto_interactive_wrapper_start() {
			$settings                                      = $this->get_settings_for_display();
			$crafto_interactive_till_effect                = $this->get_settings( 'crafto_interactive_till_effect' );
			$crafto_interactive_banner_data_atropos_offset = ( isset( $settings['crafto_interactive_banner_data_atropos_offset']['size'] ) && ! empty( $settings['crafto_interactive_banner_data_atropos_offset']['size'] ) ) ? $settings['crafto_interactive_banner_data_atropos_offset']['size'] : '';

			if ( 'yes' === $crafto_interactive_till_effect ) {
				?>
				<div class="atropos has-atropos">
					<div class="atropos-scale">
						<div class="atropos-rotate">
							<div class="atropos-inner" data-atropos-offset="<?php echo esc_attr( (int) $crafto_interactive_banner_data_atropos_offset ); ?>">
				<?php
			}
		}

		/**
		 * Widget effect end.
		 *
		 * @access public
		 */
		public function crafto_interactive_wrapper_end() {
			$crafto_interactive_till_effect = $this->get_settings( 'crafto_interactive_till_effect' );
			if ( 'yes' === $crafto_interactive_till_effect ) {
				?>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		/**
		 * Return icon for link
		 *
		 * @param array $settings data.
		 */
		public function crafto_get_link_icon( $settings ) {
			$icon     = '';
			$migrated = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( $is_new || $migrated ) {
				ob_start();
					Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
				$icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
				$icon .= '<i class="' . esc_attr( $settings['crafto_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			if ( ! empty( $settings['crafto_link'] ) ) {
				$this->crafto_start_anchor( $settings );
				if ( ! empty( $icon ) && isset( $settings['crafto_selected_icon'] ) ) {
					?>
					<div class="read-more-icon">
						<?php printf( '%s', $icon ); // phpcs:ignore ?>
					</div>
					<?php
				} else {
					?>
					<div class="read-more-icon">
						<i class="bi bi-arrow-right-short"></i>
					</div>
					<?php
				}
				?>
				<span class="screen-reader-text"><?php echo esc_html__( 'Read More', 'crafto-addons' ); ?></span>
				<?php
				$this->crafto_end_anchor( $settings );
			}
		}
		/**
		 *
		 * Return start anchor tag
		 *
		 * @param array $settings data.
		 */
		public function crafto_start_anchor( $settings ) {
			$is_external = '';
			if ( 'on' === $settings['crafto_link']['is_external'] ) {
				$is_external = 'target=_blank';
			}
			if ( ! empty( $settings['crafto_link'] ) ) {
				?>
				<a href="<?php echo $settings['crafto_link']['url']; // phpcs:ignore ?>" <?php echo esc_attr( $is_external ); ?> class="interactive-banner-link">
				<?php
			}
		}
		/**
		 * Return end anchor tag
		 *
		 * @param array $settings data.
		 */
		public function crafto_end_anchor( $settings ) {
			if ( ! empty( $settings['crafto_link'] ) ) {
				?>
				</a>
				<?php
			}
		}
		/**
		 *
		 * Render icon widget text.
		 *
		 * @access protected
		 */
		protected function interactive_banner_render_icon() {

			$settings = $this->get_settings_for_display();

			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );

			$migrated = isset( $settings['__fa4_migrated']['crafto_icons'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! empty( $settings['crafto_icons']['value'] ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'icon-wrapper' ); // phpcs:ignore ?>>
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $settings['crafto_icons'], [ 'aria-hidden' => 'true' ] );
					} elseif ( isset( $settings['crafto_icons']['value'] ) && ! empty( $settings['crafto_icons']['value'] ) ) {
						$this->add_render_attribute( 'icon', 'class', $settings['crafto_icons']['value'] );
						$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
						?>
						<i <?php $this->print_render_attribute_string( 'icon' ); // phpcs:ignore ?>></i>
						<?php
					}
					?>
				</div>
				<?php
			} elseif ( ! empty( $settings['crafto_custom_image'] ) ) {
				?>
				<div class="elementor-icon">
					<?php
					if ( ! empty( $settings['crafto_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_image']['id'] ) ) {
						$settings['crafto_image']['id'] = '';
					}
					if ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['id'] ) && ! empty( $settings['crafto_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_image_size'] ); // phpcs:ignore
					} elseif ( isset( $settings['crafto_image'] ) && isset( $settings['crafto_image']['url'] ) && ! empty( $settings['crafto_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_image']['id'], $settings['crafto_image']['url'], $settings['crafto_image_size'] ); // phpcs:ignore
					}
					?>
				</div>
				<?php
			}
		}
	}
}
