<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 *
 * Crafto widget for site logo.
 *
 * @package Crafto
 * @since   1.0
 */

// If class `Site_Logo` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Site_Logo' ) ) {
	/**
	 * Define `Site_Logo` class.
	 */
	class Site_Logo extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-site-logo';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Site Logo', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-site-logo crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/site-logo/';
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
				'crafto-header',
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
				'branding',
				'identity',
				'website',
				'theme',
				'header',
				'footer',
				'image',
			];
		}

		/**
		 * Register the widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_site_logo_content_section',
				[
					'label' => esc_html__( 'Site Logo', 'crafto-addons' ),
				]
			);
			$this->start_controls_tabs( 'crafto_site_logo_content_tabs' );
				$this->start_controls_tab( 'crafto_site_logo_content_tab', [ 'label' => esc_html__( 'Logo', 'crafto-addons' ) ] );
				$this->add_control(
					'crafto_site_logo',
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
						'name'      => 'crafto_site_logo_image_size',
						'default'   => 'full',
						'exclude'   => [ 'custom' ],
						'separator' => 'none',
					]
				);
				$this->add_control(
					'crafto_site_logo_ratina_heading',
					[
						'label'     => esc_html__( 'Retina Logo', 'crafto-addons' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'crafto_site_logo_ratina',
					[
						'label'   => esc_html__( 'Choose Image', 'crafto-addons' ),
						'type'    => Controls_Manager::MEDIA,
						'dynamic' => [
							'active' => true,
						],
					]
				);
				$this->add_group_control(
					Group_Control_Image_Size::get_type(),
					[
						'name'      => 'crafto_site_logo_ratina_image_size',
						'default'   => 'full',
						'exclude'   => [ 'custom' ],
						'separator' => 'none',
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'crafto_site_sticky_logo_content_tab',
					[
						'label' => esc_html__( 'Sticky Logo', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_site_sticky_logo',
					[
						'label'       => esc_html__( 'Choose Image', 'crafto-addons' ),
						'type'        => Controls_Manager::MEDIA,
						'dynamic'     => [
							'active' => true,
						],
						'default'     => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'description' => esc_html__( 'Applicable in scrolled and sticky header version only.', 'crafto-addons' ),
					]
				);
				$this->add_group_control(
					Group_Control_Image_Size::get_type(),
					[
						'name'      => 'crafto_site_sticky_logo_image_size',
						'default'   => 'full',
						'exclude'   => [ 'custom' ],
						'separator' => 'none',
					]
				);
				$this->add_control(
					'crafto_site_sticky_logo_ratina_heading',
					[
						'label'     => esc_html__( 'Retina Logo', 'crafto-addons' ),
						'type'      => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);

				$this->add_control(
					'crafto_site_sticky_logo_ratina',
					[
						'label'   => esc_html__( 'Choose Image', 'crafto-addons' ),
						'type'    => Controls_Manager::MEDIA,
						'dynamic' => [
							'active' => true,
						],
					]
				);
				$this->add_group_control(
					Group_Control_Image_Size::get_type(),
					[
						'name'      => 'crafto_site_sticky_logo_ratina_image_size',
						'default'   => 'full',
						'exclude'   => [ 'custom' ],
						'separator' => 'none',
					]
				);

				$this->add_control(
					'crafto_display_on_mega_menu_hover_logo',
					[
						'label'        => esc_html__( 'Display On Mega Menu Hover', 'crafto-addons' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'On', 'crafto-addons' ),
						'label_off'    => esc_html__( 'Off', 'crafto-addons' ),
						'default'      => '',
						'return_value' => 'yes',
					]
				);

				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_site_mobile_logo_content_section',
				[
					'label' => esc_html__( 'Mobile Logo', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_site_mobile_logo',
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
					'name'      => 'crafto_site_mobile_image_size',
					'default'   => 'full',
					'exclude'   => [ 'custom' ],
					'separator' => 'none',
				]
			);
			$this->add_control(
				'crafto_site_mobile_ratina_heading',
				[
					'label'     => esc_html__( 'Retina Logo', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_control(
				'crafto_site_mobile_logo_ratina',
				[
					'label'   => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_site_mobile_logo_ratina_image_size',
					'default'   => 'full',
					'exclude'   => [ 'custom' ],
					'separator' => 'none',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_site_logo_settings_section',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_h1_logo_font_page',
				[
					'label'        => esc_html__( 'H1 in Logo on Homepage', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);

			$this->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Custom Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => '',
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_site_logo_style_section',
				[
					'label' => esc_html__( 'Logo', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'crafto_site_logo_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'vw',
						'custom',
					],
					'range'      => [
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
					'selectors'  => [
						'{{WRAPPER}} .navbar-brand img, {{WRAPPER}} .mobile-logo' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_site_logo_space',
				[
					'label'      => esc_html__( 'Max Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-brand img, {{WRAPPER}} .mobile-logo' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_site_logo_max_height',
				[
					'label'      => esc_html__( 'Max Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .navbar-brand img, {{WRAPPER}} .mobile-logo' => 'max-height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'crafto_site_logo_separator',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);

			$this->start_controls_tabs( 'crafto_site_logo_style_tabs' );
				$this->start_controls_tab(
					'crafto_site_logo_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_site_logo_opacity',
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
							'{{WRAPPER}} .default-logo' => 'opacity: {{SIZE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name'     => 'crafto_site_logo_css_filters',
						'selector' => '{{WRAPPER}} .default-logo',
					]
				);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'crafto_site_logo_style_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_site_logo_opacity_hover',
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
							'{{WRAPPER}} .default-logo:hover' => 'opacity: {{SIZE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name'     => 'crafto_site_logo_css_filters_hover',
						'selector' => '{{WRAPPER}} .default-logo:hover',
					]
				);
				$this->add_control(
					'crafto_site_logo_hover_transition',
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
							'{{WRAPPER}} .default-logo' => 'transition-duration: {{SIZE}}{{UNIT}}',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_site_logo_border',
					'selector'  => '{{WRAPPER}} .default-logo',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_site_logo_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .default-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_site_logo_padding',
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
						'{{WRAPPER}} .navbar-brand' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_site_logo_box_shadow',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .default-logo',
				]
			);
			$this->end_controls_section();

			/* Sticky Logo Style */
			$this->start_controls_section(
				'crafto_site_sticky_logo_style_section',
				[
					'label' => esc_html__( 'Sticky Logo', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_site_sticky_logo_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'vw',
						'custom',
					],
					'range'      => [
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
					'selectors'  => [
						'{{WRAPPER}} .alt-logo' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_site_sticky_logo_space',
				[
					'label'      => esc_html__( 'Max Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .alt-logo' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_site_sticky_logo_max_height',
				[
					'label'      => esc_html__( 'Max Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
						'px' => [
							'min' => 1,
							'max' => 1000,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .alt-logo' => 'max-height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'crafto_site_sticky_logo_separator',
				[
					'type'  => Controls_Manager::DIVIDER,
					'style' => 'thick',
				]
			);

			$this->start_controls_tabs(
				'crafto_site_sticky_logo_style_tabs'
			);
				$this->start_controls_tab(
					'crafto_site_sticky_logo_style_normal_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_site_sticky_logo_opacity',
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
							'{{WRAPPER}} .alt-logo' => 'opacity: {{SIZE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name'     => 'crafto_site_sticky_logo_css_filters',
						'selector' => '{{WRAPPER}} .alt-logo',
					]
				);

				$this->end_controls_tab();

				$this->start_controls_tab(
					'crafto_site_sticky_logo_style_hover_tab',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					],
				);
				$this->add_control(
					'crafto_site_sticky_logo_opacity_hover',
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
							'{{WRAPPER}} .alt-logo:hover' => 'opacity: {{SIZE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Css_Filter::get_type(),
					[
						'name'     => 'crafto_site_sticky_logo_css_filters_hover',
						'selector' => '{{WRAPPER}} .alt-logo:hover',
					]
				);
				$this->add_control(
					'crafto_site_sticky_logo_hover_transition',
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
							'{{WRAPPER}} .alt-logo' => 'transition-duration: {{SIZE}}{{UNIT}}',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_site_sticky_logo_border',
					'selector'  => '{{WRAPPER}} .alt-logo',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_site_sticky_logo_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
					],
					'selectors'  => [
						'{{WRAPPER}} .alt-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_site_sticky_logo_box_shadow',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .alt-logo',
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render site logo widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			$crafto_h1_logo_font_page = ( isset( $settings['crafto_h1_logo_font_page'] ) && ! empty( $settings['crafto_h1_logo_font_page'] ) ) ? $settings['crafto_h1_logo_font_page'] : '';

			// Logo.
			$site_logo_url    = '';
			$site_logo_width  = '';
			$site_logo_height = '';
			if ( ! empty( $settings['crafto_site_logo']['id'] ) ) {
				$site_logo_array = wp_get_attachment_image_src( $settings['crafto_site_logo']['id'], 'crafto_site_logo_image_size' );
				if ( is_array( $site_logo_array ) && ! empty( $site_logo_array ) ) {
					$site_logo_url    = isset( $site_logo_array[0] ) ? $site_logo_array[0] : null;
					$site_logo_width  = isset( $site_logo_array[1] ) ? $site_logo_array[1] : null;
					$site_logo_height = isset( $site_logo_array[2] ) ? $site_logo_array[2] : null;
				}
			} elseif ( ! empty( $settings['crafto_site_logo']['url'] ) ) {
				$site_logo_url = $settings['crafto_site_logo']['url'];
			}

			// Ratina Logo.
			$site_logo_ratina_url = '';
			if ( ! empty( $settings['crafto_site_logo_ratina']['id'] ) ) {
				$site_logo_ratina_url = Group_Control_Image_Size::get_attachment_image_src( $settings['crafto_site_logo_ratina']['id'], 'crafto_site_logo_ratina_image_size', $settings );
			} elseif ( ! empty( $settings['crafto_site_logo_ratina']['url'] ) ) {
				$site_logo_ratina_url = $settings['crafto_site_logo_ratina']['url'];
			}

			// Sticky Logo.
			$site_sticky_logo_url    = '';
			$site_sticky_logo_width  = '';
			$site_sticky_logo_height = '';
			if ( ! empty( $settings['crafto_site_sticky_logo']['id'] ) ) {
				$site_sticky_logo_array = wp_get_attachment_image_src( $settings['crafto_site_sticky_logo']['id'], 'crafto_site_sticky_logo_image_size' );
				if ( is_array( $site_sticky_logo_array ) && ! empty( $site_sticky_logo_array ) ) {
					$site_sticky_logo_url    = isset( $site_sticky_logo_array[0] ) ? $site_sticky_logo_array[0] : null;
					$site_sticky_logo_width  = isset( $site_sticky_logo_array[1] ) ? $site_sticky_logo_array[1] : null;
					$site_sticky_logo_height = isset( $site_sticky_logo_array[2] ) ? $site_sticky_logo_array[2] : null;
				}
			} elseif ( ! empty( $settings['crafto_site_sticky_logo']['url'] ) ) {
				$site_sticky_logo_url = $settings['crafto_site_sticky_logo']['url'];
			}

			// Sticky Ratina Logo.
			$site_sticky_logo_ratina_url = '';
			if ( ! empty( $settings['crafto_site_sticky_logo_ratina']['id'] ) ) {
				$site_sticky_logo_ratina_url = Group_Control_Image_Size::get_attachment_image_src( $settings['crafto_site_sticky_logo_ratina']['id'], 'crafto_site_sticky_logo_image_size', $settings );

			} elseif ( ! empty( $settings['crafto_site_sticky_logo_ratina']['url'] ) ) {
				$site_sticky_logo_ratina_url = $settings['crafto_site_sticky_logo_ratina']['url'];
			}

			// Mobile Logo.
			$site_mobile_logo_url    = '';
			$site_mobile_logo_width  = '';
			$site_mobile_logo_height = '';
			if ( ! empty( $settings['crafto_site_mobile_logo']['id'] ) ) {
				$site_mobile_logo_array = wp_get_attachment_image_src( $settings['crafto_site_mobile_logo']['id'], 'crafto_site_mobile_image_size' );
				if ( is_array( $site_mobile_logo_array ) && ! empty( $site_mobile_logo_array ) ) {
					$site_mobile_logo_url    = isset( $site_mobile_logo_array[0] ) ? $site_mobile_logo_array[0] : null;
					$site_mobile_logo_width  = isset( $site_mobile_logo_array[1] ) ? $site_mobile_logo_array[1] : null;
					$site_mobile_logo_height = isset( $site_mobile_logo_array[2] ) ? $site_mobile_logo_array[2] : null;
				}
			} elseif ( ! empty( $settings['crafto_site_mobile_logo']['url'] ) ) {
				$site_mobile_logo_url = $settings['crafto_site_mobile_logo']['url'];
			}

			// Mobile Ratina Logo.
			$site_mobile_logo_ratina_url = '';
			if ( ! empty( $settings['crafto_site_mobile_logo_ratina']['id'] ) ) {
				$site_mobile_logo_ratina_url = Group_Control_Image_Size::get_attachment_image_src( $settings['crafto_site_mobile_logo_ratina']['id'], 'crafto_site_mobile_logo_ratina_image_size', $settings );

			} elseif ( ! empty( $settings['crafto_site_mobile_logo_ratina']['url'] ) ) {
				$site_mobile_logo_ratina_url = $settings['crafto_site_mobile_logo_ratina']['url'];
			}

			$mega_menu_hover_class = '';
			if ( 'yes' === $settings['crafto_display_on_mega_menu_hover_logo'] ) {
				$mega_menu_hover_class = 'mega-menu-hover-yes';
			}

			$this->add_render_attribute( 'link', 'class', 'navbar-brand' );
			if ( ! empty( $settings['crafto_link']['url'] ) ) {
				$this->add_link_attributes( 'link', $settings['crafto_link'] );
			} else {
				$this->add_render_attribute( 'link', 'href', trailingslashit( get_home_url() ) );
			}

			if ( ! empty( $mega_menu_hover_class ) ) {
				$this->add_render_attribute(
					'link',
					[
						'class' => [
							$mega_menu_hover_class,
						],
					],
				);
			}

			// Default logo attribute.
			$site_logo_attr = [
				'class'         => [
					'default-logo',
				],
				'src'           => $site_logo_url,
				'alt'           => get_bloginfo( 'name' ),
				'fetchpriority' => 'high',
			];

			if ( ! empty( $site_logo_height ) ) {
				$site_logo_attr['height'] = $site_logo_height;
			}

			if ( ! empty( $site_logo_width ) ) {
				$site_logo_attr['width'] = $site_logo_width;
			}

			if ( ! empty( $site_logo_ratina_url ) ) {
				$site_logo_attr['data-at2x'] = $site_logo_ratina_url;
			}

			$this->add_render_attribute(
				'logo',
				$site_logo_attr,
			);

			// Sticky logo attribute.
			$site_sticky_logo_attr = [
				'class'   => [
					'alt-logo',
				],
				'src'     => $site_sticky_logo_url,
				'alt'     => get_bloginfo( 'name' ),
				'loading' => 'lazy',
			];

			if ( ! empty( $site_sticky_logo_height ) ) {
				$site_sticky_logo_attr['height'] = $site_sticky_logo_height;
			}

			if ( ! empty( $site_sticky_logo_width ) ) {
				$site_sticky_logo_attr['width'] = $site_sticky_logo_width;
			}

			if ( ! empty( $site_sticky_logo_ratina_url ) ) {
				$site_sticky_logo_attr['data-at2x'] = $site_sticky_logo_ratina_url;
			}

			$this->add_render_attribute(
				'sticky_logo',
				$site_sticky_logo_attr,
			);

			// Mobile logo attribute.
			$site_mobile_logo_attr = [
				'class' => [
					'mobile-logo',
				],
				'src'   => $site_mobile_logo_url,
				'alt'   => get_bloginfo( 'name' ),
			];

			if ( ! empty( $site_mobile_logo_height ) ) {
				$site_mobile_logo_attr['height'] = $site_mobile_logo_height;
			}

			if ( ! empty( $site_mobile_logo_width ) ) {
				$site_mobile_logo_attr['width'] = $site_mobile_logo_width;
			}

			if ( ! empty( $site_mobile_logo_ratina_url ) ) {
				$site_mobile_logo_attr['data-at2x'] = $site_mobile_logo_ratina_url;
			}

			if ( ! $this->crafto_is_device() ) {
				$site_mobile_logo_attr['loading'] = 'lazy';
			}

			$this->add_render_attribute(
				'mobile_logo',
				$site_mobile_logo_attr,
			);

			if ( is_front_page() && 'yes' === $crafto_h1_logo_font_page ) {
				?>
				<h1>
				<?php
			}

			if ( ! empty( $site_logo_url ) || ! empty( $site_sticky_logo_url ) ) {
				?>
				<a <?php $this->print_render_attribute_string( 'link' ); ?>>
					<?php
					if ( ! empty( $site_logo_url ) ) {
						?>
						<img <?php $this->print_render_attribute_string( 'logo' ); ?>/>
						<?php
					}
					if ( ! empty( $site_sticky_logo_url ) ) {
						?>
						<img <?php $this->print_render_attribute_string( 'sticky_logo' ); ?>/>
						<?php
					}
					if ( ! empty( $site_mobile_logo_url ) ) {
						?>
						<img <?php $this->print_render_attribute_string( 'mobile_logo' ); ?>/>
						<?php
					}
					?>
				</a>
				<?php
			} else {
				$this->add_render_attribute( 'site-title', 'class', 'site-title' );
				if ( ! empty( $settings['crafto_link']['url'] ) ) {
					$this->add_link_attributes( 'site-title', $settings['crafto_link'] );
				} else {
					$this->add_render_attribute( 'site-title', 'href', trailingslashit( get_home_url() ) );
				}
				?>
				<a <?php $this->print_render_attribute_string( 'site-title' ); ?>>
					<span class="logo">
						<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
					</span>
				</a>
				<?php
			}

			if ( is_front_page() && 'yes' === $crafto_h1_logo_font_page ) {
				?>
				</h1>
				<?php
			}
		}

		/**
		 * Check device or not.
		 */
		public function crafto_is_device() {
			$is_mobile = isset( $_SERVER['HTTP_USER_AGENT'] ) && preg_match( '/(android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini)/i', $_SERVER['HTTP_USER_AGENT'] ); // phpcs:ignore
			return $is_mobile;
		}
	}
}
