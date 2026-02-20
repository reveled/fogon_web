<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;  // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for google map.
 *
 * @package Crafto
 */

// If class `Google_Map` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Google_Map' ) ) {
	/**
	 * Define `Google_Map` class.
	 */
	class Google_Map extends Widget_Base {
		/**
		 * Retrieve the list of scripts the google map widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [
					'crafto-mapstyles',
					'crafto-widgets',
				];
			} else {
				return [ 'crafto-googleapis' ];
			}
		}

		/**
		 * Retrieve the list of styles the google map widget depended on.
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
				return [ 'crafto-google-maps-widget' ];
			}
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve google map widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-google-maps';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve google map widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Google Map', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve google map widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-google-maps crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/google-map/';
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
				'google',
				'address',
				'place',
				'map',
				'embed',
				'location',
				'iframe',
				'store locator',
				'business location',
				'contact map',
			];
		}

		/**
		 * Register google map widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_google_maps',
				[
					'label' => esc_html__( 'Google Map', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_google_maps_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'silver',
					'options'            => [
						'silver'            => esc_html__( 'Default', 'crafto-addons' ),
						'retro'             => esc_html__( 'Retro', 'crafto-addons' ),
						'dark'              => esc_html__( 'Dark', 'crafto-addons' ),
						'standard'          => esc_html__( 'Standard', 'crafto-addons' ),
						'night'             => esc_html__( 'Night', 'crafto-addons' ),
						'aubergine'         => esc_html__( 'Aubergine', 'crafto-addons' ),
						'cloud-based-style' => esc_html__( 'Cloud Based Style', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);

			$this->add_control(
				'crafto_google_maps_id',
				[
					'label'       => esc_html__( 'Map ID', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					/* translators: %1$s is the start of anchor tag*/

					/* translators: %2$s is the end of anchor tag*/
					'description' => sprintf( esc_html__( 'A map ID is a unique identifier for Google Map styling and configuration settings in Google Cloud. For more details, see %1$screate map IDs%2$s.', 'crafto-addons' ), '<a href="https://developers.google.com/maps/documentation/javascript/map-ids/get-map-id/" target="_blank" rel="noopener noreferrer">', '</a>' ),
				]
			);

			$repeater = new Repeater();
			$repeater->start_controls_tabs( 'crafto_maps_tabs' );
			$repeater->start_controls_tab(
				'crafto_maps_address_tab',
				[
					'label' => esc_html__( 'Address', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_maps_address',
				[
					'type'    => Controls_Manager::TEXTAREA,
					'rows'    => 4,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( '7420 Shore Rd, Brooklyn, NY 11209, USA', 'crafto-addons' ),
				]
			);
			$repeater->end_controls_tab();

			$repeater->start_controls_tab(
				'crafto_maps_infowindow_tab',
				[
					'label' => esc_html__( 'Marker Bubble', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_maps_infowindow',
				[
					'label'        => esc_html__( 'Enable Marker Bubble', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$repeater->add_control(
				'crafto_infowindow_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_maps_infowindow' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_infowindow_address',
				[
					'label'       => esc_html__( 'Address', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write address here', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_maps_infowindow' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_heading_infowindow_button',
				[
					'label'     => esc_html__( 'Button', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_maps_infowindow' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_infowindow_button_text',
				[
					'label'       => esc_html__( 'Butoon Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'View Larger Map', 'crafto-addons' ),
					'label_block' => true,
					'condition'   => [
						'crafto_maps_infowindow' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_infowindow_button_link',
				[
					'label'       => esc_html__( 'Button Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'default'     => [
						'url' => '#',
					],
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_maps_infowindow' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'crafto_defaultopen_infowindow',
				[
					'label'        => esc_html__( 'Always Open Bubble', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'crafto_maps_infowindow' => 'yes',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();

			$this->add_control(
				'crafto_maps',
				[
					'label'   => esc_html__( 'Items', 'crafto-addons' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => [
						[
							'crafto_maps_address' => esc_html__( '7420 Shore Rd, Brooklyn, NY 11209, USA', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_google_maps_height',
				[
					'label'     => esc_html__( 'Height', 'crafto-addons' ),
					'type'      => Controls_Manager::TEXT,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => '550px',
					'selectors' => [
						'{{WRAPPER}} .google-map' => 'height: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_google_map_marker',
				[
					'label'     => esc_html__( 'Marker', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'default',
					'separator' => 'before',
					'options'   => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'image'   => esc_html__( 'Image', 'crafto-addons' ),
						'html'    => esc_html__( 'Circle', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_map_color_marker',
				[
					'label'     => esc_html__( 'Circle Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .arrow-box.html-marker' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'crafto_google_map_marker' => [
							'html',
						],
					],
				]
			);
			$this->add_control(
				'crafto_map_animation_color',
				[
					'label'     => esc_html__( 'Grow Circle Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .arrow-box.html-marker span:first-child+span, {{WRAPPER}} .arrow-box.html-marker span:first-child' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'crafto_google_map_marker' => [
							'html',
						],
					],
				]
			);
			$this->add_control(
				'crafto_map_image_marker',
				[
					'label'     => esc_html__( 'Image Marker', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'crafto_google_map_marker' => [
							'image',
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_map_image_marker_height',
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
							'max' => 150,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'size' => 80,
					],
					'condition'  => [
						'crafto_google_map_marker' => [
							'image',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_map_image_marker_width',
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
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'size' => 108,
					],
					'condition'  => [
						'crafto_google_map_marker' => [
							'image',
						],
					],
				]
			);

			$this->add_control(
				'crafto_zoom',
				[
					'label'     => esc_html__( 'Scale Map', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 13,
					],
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 20,
						],
					],
					'separator' => 'before',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_control_section',
				[
					'label' => esc_html__( 'Map Control', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_scrollwheel_control',
				[
					'label'        => esc_html__( 'Enable Scrollwheel', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'crafto_zoom_control',
				[
					'label'        => esc_html__( 'Enable Zoom', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'crafto_scalecontrol',
				[
					'label'        => esc_html__( 'Enable Scale', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'crafto_streetviewcontrol',
				[
					'label'        => esc_html__( 'Enable Street View', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'crafto_fullscreencontrol',
				[
					'label'        => esc_html__( 'Enable Fullscreen', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
				]
			);
			$this->add_control(
				'crafto_disable_defaultui',
				[
					'label'        => esc_html__( 'Disable Control', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_info_box_style_section',
				[
					'label' => esc_html__( 'Marker Bubble', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_info_box_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .infowindow' => 'background-color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_info_box_size',
				[
					'label'   => esc_html__( 'Width', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 230,
					],
					'range'   => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_infobox_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .gm-style .gm-style-iw-c' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_infobox_padding',
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
						'{{WRAPPER}} .infowindow' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_infobox_box_shadow',
					'selector' => '{{WRAPPER}} .gm-style .gm-style-iw-c',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_infobox_title_section',
				[
					'label' => esc_html__( 'Marker Bubble Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .infowindow .info-title',
				]
			);

			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .infowindow .info-title' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_margin',
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
						'{{WRAPPER}} .infowindow .info-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_infobox_content_section',
				[
					'label' => esc_html__( 'Marker Bubble Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .infowindow p',
				]
			);

			$this->add_control(
				'crafto_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .infowindow p' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_margin',
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
						'{{WRAPPER}} .infowindow p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_infobox_button_section',
				[
					'label' => esc_html__( 'Marker Bubble Button', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_button_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .google-maps-link .map-btn',
				]
			);

			$this->add_control(
				'crafto_button_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .google-maps-link .map-btn' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_button_background_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .google-maps-link .map-btn, {{WRAPPER}} .gm-style .gm-style-iw-tc::after',
				]
			);

			$this->add_responsive_control(
				'crafto_button_padding',
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
						'{{WRAPPER}} .google-maps-link .map-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Render google map widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function render() {

			global $crafto_map_unique_id;

			$marker_image        = '';
			$image_marker_height = '';
			$image_marker_width  = '';
			$settings            = $this->get_settings_for_display();
			$map_address         = $settings['crafto_maps'];

			$cookie_name_array            = [];
			$cookie_blog                  = 'crafto_gdpr_cookie' . ( is_multisite() ? '-' . get_current_blog_id() : '' );
			$crafto_gdpr_enable           = get_theme_mod( 'crafto_gdpr_enable', '0' );
			$crafto_google_maps_enable    = get_theme_mod( 'crafto_google_maps_enable', '1' );
			$crafto_gdpr_google_maps_text = get_theme_mod( 'crafto_gdpr_google_maps_text', esc_html__( 'This website uses Google Maps service, allowing to display interactive maps.', 'crafto-addons' ) );

			if ( isset( $_COOKIE[ $cookie_blog ] ) && ! empty( $_COOKIE[ $cookie_blog ] ) ) {
				$cookie_name_array = explode( ',', $_COOKIE[ $cookie_blog ] ); // phpcs:ignore
			}

			if ( 'image' === $settings['crafto_google_map_marker'] ) {
				$marker_image        = $settings['crafto_map_image_marker']['url'];
				$image_marker_height = $settings['crafto_map_image_marker_height']['size'];
				$image_marker_width  = $settings['crafto_map_image_marker_width']['size'];
			}

			$map_settings = array(
				'maps_style'            => $this->get_settings( 'crafto_google_maps_style' ),
				'address'               => $map_address,
				'zoom'                  => $settings['crafto_zoom']['size'] ? intval( $settings['crafto_zoom']['size'] ) : 14,
				'marker_type'           => $this->get_settings( 'crafto_google_map_marker' ),
				'marker_image'          => $marker_image,
				'scrollwheel'           => $this->get_settings( 'crafto_scrollwheel_control' ),
				'zoom_control'          => $this->get_settings( 'crafto_zoom_control' ),
				'scalecontrol'          => $this->get_settings( 'crafto_scalecontrol' ),
				'streetviewcontrol'     => $this->get_settings( 'crafto_streetviewcontrol' ),
				'fullscreencontrol'     => $this->get_settings( 'crafto_fullscreencontrol' ),
				'disabledefaultUI'      => $this->get_settings( 'crafto_disable_defaultui' ),
				'infobox_maxWidth'      => $settings['crafto_info_box_size']['size'] ? intval( $settings['crafto_info_box_size']['size'] ) : 14,
				'image_marker_height'   => $image_marker_height,
				'image_marker_width'    => $image_marker_width,
				'crafto_google_maps_id' => ( isset( $settings['crafto_google_maps_id'] ) && $settings['crafto_google_maps_id'] ) ? $settings['crafto_google_maps_id'] : '',
			);

			$crafto_map_unique_id = ! empty( $crafto_map_unique_id ) ? $crafto_map_unique_id : 1;
			$crafto_map_id        = 'googlemap';
			$crafto_map_id       .= '-' . $crafto_map_unique_id;
			++$crafto_map_unique_id;

			$should_enable_tracking = ( '0' === $crafto_google_maps_enable ) || ( ! empty( $cookie_name_array ) && in_array( 'google_map', $cookie_name_array, true ) );

			if ( $should_enable_tracking || '0' === $crafto_gdpr_enable || \Crafto_Addons_Extra_Functions::is_crafto_elementor_editor_preview_mode() ) {
				$this->add_render_attribute(
					[
						'googlemap' => [
							'class'         => [
								'google-map',
							],
							'id'            => [
								$crafto_map_id,
							],
							'data-uniqueid' => $crafto_map_id,
							'data-settings' => wp_json_encode( $map_settings ),
						],
					]
				);
				?>
				<div <?php $this->print_render_attribute_string( 'googlemap' ); ?>></div>
				<?php
			} else {
				?>
				<div class="crafto-gdpr-no-consent-inner">
					<div class="crafto-gdpr-no-consent-notice-text"><?php echo esc_html( $crafto_gdpr_google_maps_text ); ?></div>
				</div>
				<?php
			}
		}
	}
}
