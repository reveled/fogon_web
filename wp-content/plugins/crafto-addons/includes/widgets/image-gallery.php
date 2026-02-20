<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 * Crafto widget for Image Gallery.
 *
 * @package Crafto
 */

// If class `Image_Gallery` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Image_Gallery' ) ) {
	/**
	 * Define `Image_Gallery` class.
	 */
	class Image_Gallery extends Widget_Base {
		/**
		 * Retrieve the list of scripts the Image Gallery widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$image_gallery_scripts        = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$image_gallery_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$image_gallery_scripts[] = 'swiper';
					if ( '0' === $crafto_disable_all_animation && crafto_disable_module_by_key( 'anime' ) ) {
						$image_gallery_scripts[] = 'crafto-magic-cursor';
					}
				}

				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$image_gallery_scripts[] = 'magnific-popup';
					$image_gallery_scripts[] = 'crafto-lightbox-gallery';
				}

				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$image_gallery_scripts[] = 'atropos';
				}

				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$image_gallery_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$image_gallery_scripts[] = 'isotope';
				}
				$image_gallery_scripts[] = 'crafto-image-gallery-widget';
			}

			return $image_gallery_scripts;
		}

		/**
		 * Retrieve the list of styles the Image Gallery widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$image_gallery_styles         = [];
			$crafto_disable_all_animation = get_theme_mod( 'crafto_disable_all_animation', '0' );

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$image_gallery_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'swiper' ) ) {
					$image_gallery_styles = [
						'swiper',
						'nav-pagination',
					];

					if ( is_rtl() ) {
						$image_gallery_styles[] = 'nav-pagination-rtl';
					}

					if ( '0' === $crafto_disable_all_animation ) {
						$image_gallery_styles[] = 'crafto-magic-cursor';
					}
				}

				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$image_gallery_styles[] = 'magnific-popup';
					$image_gallery_styles[] = 'crafto-lightbox-gallery';
				}

				if ( crafto_disable_module_by_key( 'atropos' ) ) {
					$image_gallery_styles[] = 'atropos';
				}
				$image_gallery_styles[] = 'crafto-image-gallery-widget';
			}
			return $image_gallery_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-image-gallery';
		}

		/**
		 * Retrieve the widget title
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Image Gallery', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-gallery-grid crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/image-gallery/';
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
				'lightbox',
				'group',
				'media',
				'grid',
				'popup',
			];
		}

		/**
		 * Register Image Gallery widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_image_gallery_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_image_gallery_style',
				[
					'label'   => esc_html__( 'Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'normal',
					'options' => [
						'normal'     => esc_html__( 'Normal', 'crafto-addons' ),
						'attractive' => esc_html__( 'Attractive', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_image_gallery_data',
				[
					'label'      => esc_html__( 'Add Images', 'crafto-addons' ),
					'type'       => Controls_Manager::GALLERY,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => false,
					'default'    => [
						[
							'id'  => 0,
							'url' => Utils::get_placeholder_image_src(),
						],
						[
							'id'  => 0,
							'url' => Utils::get_placeholder_image_src(),
						],
						[
							'id'  => 0,
							'url' => Utils::get_placeholder_image_src(),
						],
					],
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
				'crafto_image_gallery_metro_positions',
				[
					'label'       => esc_html__( 'Metro Grid Positions', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'description' => esc_html__( 'Mention the positions (comma separated like 1, 4, 7) where that image will cover spacing of multiple columns and / or rows considering the image width and height.', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_column_settings',
				[
					'label'   => esc_html__( 'Number of Columns', 'crafto-addons' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 3,
					],
					'range'   => [
						'px' => [
							'min'  => 1,
							'max'  => 6,
							'step' => 1,
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_gallery_columns_gap',
				[
					'label'     => esc_html__( 'Columns Gap', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 15,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors' => [
						'{{WRAPPER}} ul:not(.image-gallery-metro) li.grid-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul:not(.image-gallery-metro).grid'         => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.image-gallery-metro li.grid-item'       => 'padding: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_image_gallery_bottom_spacing',
				[
					'label'      => esc_html__( 'Bottom Gap', 'crafto-addons' ),
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
						'{{WRAPPER}} ul li.grid-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_image_gallery_link',
				[
					'label'   => esc_html__( 'Link', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'file',
					'options' => [
						'file' => esc_html__( 'Media File', 'crafto-addons' ),
						'none' => esc_html__( 'None', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_image_gallery_lightbox',
				[
					'label'     => esc_html__( 'Lightbox', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'yes',
					'options'   => [
						'yes' => esc_html__( 'Yes', 'crafto-addons' ),
						'no'  => esc_html__( 'No', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_image_gallery_link' => 'file',
					],
				]
			);
			$this->add_control(
				'crafto_image_gallery_animation',
				[
					'label'       => esc_html__( 'Entrance Animation', 'crafto-addons' ),
					'type'        => Controls_Manager::ANIMATION,
					'description' => esc_html__( 'Add animation and then see preview', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_image_gallery_animation_duration',
				[
					'label'     => esc_html__( 'Animation Duration', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '',
					'options'   => [
						'slow' => esc_html__( 'Slow', 'crafto-addons' ),
						''     => esc_html__( 'Normal', 'crafto-addons' ),
						'fast' => esc_html__( 'Fast', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_image_gallery_animation!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_image_gallery_animation_delay',
				[
					'label'     => esc_html__( 'Animation Delay', 'crafto-addons' ),
					'type'      => Controls_Manager::NUMBER,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => '',
					'min'       => 0,
					'max'       => 1500,
					'step'      => 50,
					'condition' => [
						'crafto_image_gallery_animation!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_image_hover_effect',
				[
					'label'   => esc_html__( 'Image Hover Effect', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'zoom-in',
					'options' => [
						'default'  => esc_html__( 'Default', 'crafto-addons' ),
						'zoom-in'  => esc_html__( 'Zoom In', 'crafto-addons' ),
						'zoom-out' => esc_html__( 'Zoom Out', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_image_data_atropos_offset',
				[
					'label'     => esc_html__( '3D Parallax Offset', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => -5,
							'max' => 5,
						],
					],
					'condition' => [
						'crafto_image_gallery_style' => 'attractive',   // IN.
					],
				]
			);
			$this->add_control(
				'crafto_image_atropos_mobile',
				[
					'label'        => esc_html__( 'Enable 3D Parallax in Mobile', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'no',
					'condition'    => [
						'crafto_image_gallery_style' => 'attractive',   // IN.
					],
				],
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_gallery_icon_section',
				[
					'label'     => esc_html__( 'Hover Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_image_gallery_link' => 'file',
					],
				]
			);
			$this->add_control(
				'crafto_image_gallery_icon',
				[
					'label'        => esc_html__( 'Enable Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);

			$this->add_control(
				'crafto_image_gallery_select_icon',
				[
					'label'            => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'feather icon-feather-zoom-in',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_image_gallery_icon' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_gallery_images',
				[
					'label' => esc_html__( 'Images', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_image_border',
					'selector' => '{{WRAPPER}} .gallery-box',
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
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .gallery-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_image_box_shadow',
					'selector' => '{{WRAPPER}} .gallery-box',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_icon',
				[
					'label'     => esc_html__( 'Hover Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_image_gallery_link' => 'file',
					],
				]
			);
			$this->add_control(
				'crafto_icon_background_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .gallery-box .icon-box' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_icon_color',
					'selector'       => '{{WRAPPER}} .gallery-box i:before, {{WRAPPER}} .gallery-box svg',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_size',
				[
					'label'     => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .gallery-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .gallery-box svg' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_box_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
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
						'{{WRAPPER}} .gallery-box .icon-box' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_icon_border',
					'selector' => '{{WRAPPER}} .gallery-box .icon-box',
				]
			);
			$this->add_control(
				'crafto_icon_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .gallery-box .icon-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_image_gallery_image_overlay',
				[
					'label' => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_image_gallery_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .gallery-image',
				]
			);
			$this->add_control(
				'crafto_image_overlay_hover_opacity',
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
						'{{WRAPPER}} .gallery-box:hover .gallery-image img' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render image gallery widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( ! $settings['crafto_image_gallery_data'] ) {
				return;
			}

			$crafto_image_data_atropos_offset = ( isset( $settings['crafto_image_data_atropos_offset']['size'] ) && ! empty( $settings['crafto_image_data_atropos_offset']['size'] ) ) ? (int) $settings['crafto_image_data_atropos_offset']['size'] : 0;
			$crafto_image_atropos_mobile      = ( isset( $settings['crafto_image_atropos_mobile'] ) && $settings['crafto_image_atropos_mobile'] ) ? $settings['crafto_image_atropos_mobile'] : '';
			$crafto_image_gallery_style       = ( isset( $settings['crafto_image_gallery_style'] ) && $settings['crafto_image_gallery_style'] ) ? $settings['crafto_image_gallery_style'] : '';

			/* Column Settings */
			$crafto_column_desktop_column = ! empty( $settings['crafto_column_settings'] ) ? $settings['crafto_column_settings'] : '3';
			$crafto_column_ratio          = '';
			switch ( $crafto_column_desktop_column ) {
				case '1':
					$crafto_column_ratio = 1;
					break;
				case '2':
					$crafto_column_ratio = 2;
					break;
				case '3':
				default:
					$crafto_column_ratio = 3;
					break;
				case '4':
					$crafto_column_ratio = 4;
					break;
				case '5':
					$crafto_column_ratio = 5;
					break;
				case '6':
					$crafto_column_ratio = 6;
					break;
			}

			$crafto_column_class      = [];
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';
			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );
			/* End Column Settings */

			// Entrance Animation.
			$crafto_image_gallery_animation          = ( isset( $settings['crafto_image_gallery_animation'] ) && $settings['crafto_image_gallery_animation'] ) ? $settings['crafto_image_gallery_animation'] : '';
			$crafto_image_gallery_animation_duration = ( isset( $settings['crafto_image_gallery_animation_duration'] ) && $settings['crafto_image_gallery_animation_duration'] ) ? $settings['crafto_image_gallery_animation_duration'] : '';
			$crafto_image_gallery_animation_delay    = ( isset( $settings['crafto_image_gallery_animation_delay'] ) && $settings['crafto_image_gallery_animation_delay'] ) ? $settings['crafto_image_gallery_animation_delay'] : 100;

			$crafto_image_gallery_icon = ( isset( $settings['crafto_image_gallery_icon'] ) && $settings['crafto_image_gallery_icon'] ) ? $settings['crafto_image_gallery_icon'] : '';
			$crafto_image_gallery_link = ( isset( $settings['crafto_image_gallery_link'] ) && $settings['crafto_image_gallery_link'] ) ? $settings['crafto_image_gallery_link'] : '';

			$crafto_image_gallery_thumbnail = $this->get_settings( 'crafto_thumbnail' );
			$crafto_image_gallery_lightbox  = isset( $settings['crafto_image_gallery_lightbox'] ) ? $settings['crafto_image_gallery_lightbox'] : null;
			$crafto_image_hover_effect      = isset( $settings['crafto_image_hover_effect'] ) ? $settings['crafto_image_hover_effect'] : null;

			/* Icon */
			$custom_link = '';
			$is_new      = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$migrated    = isset( $settings['__fa4_migrated']['crafto_image_gallery_select_icon'] );

			if ( $is_new || $migrated ) {
				ob_start();
				Icons_Manager::render_icon( $settings['crafto_image_gallery_select_icon'], [ 'aria-hidden' => 'true' ] );
				$custom_link .= ob_get_clean();
			} elseif ( isset( $settings['crafto_image_gallery_select_icon']['value'] ) && ! empty( $settings['crafto_image_gallery_select_icon']['value'] ) ) {
				$custom_link .= '<i class="' . esc_attr( $settings['crafto_image_gallery_select_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			$datasettings = array(
				'crafto_image_atropos_mobile' => $crafto_image_atropos_mobile,
			);

			$this->add_render_attribute(
				'main_wrapper',
				[
					'class'               => [
						'image-gallery-grid',
						'grid',
						$crafto_column_class_list,
					],
					'data-image-settings' => wp_json_encode( $datasettings ),
				],
			);

			if ( '' !== $this->get_settings( 'crafto_image_gallery_metro_positions' ) ) {
				$this->add_render_attribute(
					'main_wrapper',
					[
						'class' => [
							'image-gallery-metro',
						],
					],
				);
			}

			$this->add_render_attribute(
				'gallery-box',
				[
					'class' => [
						'gallery-box',
						$crafto_image_hover_effect,
					],
				]
			);

			if ( ! empty( $settings['crafto_image_gallery_data'] ) ) {
				?>
				<ul <?php $this->print_render_attribute_string( 'main_wrapper' ); ?>>
					<?php
					if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
						?>
						<li class="grid-sizer"></li>
						<?php
					}

					$index            = 0;
					$grid_count       = 1;
					$grid_metro_count = 1;
					foreach ( $settings['crafto_image_gallery_data'] as $image ) {
						$id        = $image['id'];
						$image_url = isset( $image['url'] ) && ! empty( $image['url'] ) ? $image['url'] : '';

						$key = $index;
						if ( 0 === $index % $crafto_column_ratio ) {
							$grid_count = 1;
						}

						$link_wrapper                = $key . '_link_wrapper';
						$inner_wrapper               = $key . '_inner_wrapper';
						$crafto_blog_metro_positions = $this->get_settings( 'crafto_image_gallery_metro_positions' );
						$crafto_double_grid_position = ! empty( $crafto_blog_metro_positions ) ? explode( ',', $crafto_blog_metro_positions ) : array();

						if ( ! empty( $crafto_double_grid_position ) && in_array( $grid_metro_count, $crafto_double_grid_position ) ) { // phpcs:ignore
							$this->add_render_attribute(
								$inner_wrapper,
								'class',
								'grid-item grid-item-double',
								true
							);
						} else {
							$this->add_render_attribute(
								$inner_wrapper,
								'class',
								'grid-item',
								true
							);
						}

						// Entrance Animation.
						if ( '' !== $crafto_image_gallery_animation && 'none' !== $crafto_image_gallery_animation ) {
							$this->add_render_attribute(
								$inner_wrapper,
								[
									'class'                => [
										'crafto-animated',
										'elementor-invisible',
									],
									'data-animation'       => [
										$crafto_image_gallery_animation,
										$crafto_image_gallery_animation_duration,
									],
									'data-animation-delay' => $grid_count * $crafto_image_gallery_animation_delay,
								]
							);
						}

						if ( 'attractive' === $crafto_image_gallery_style ) {
							$this->add_render_attribute(
								$inner_wrapper,
								[
									'class' => [
										'has-atropos',
										'atropos',
									],
								]
							);
						}
						$image_html = '';
						if ( 'file' === $crafto_image_gallery_link ) {
							if ( 0 === $id ) {
								if ( ! empty( $image_url ) ) {
									$image_html = $image_url;
								}
							} else {
								if ( ! empty( $id ) && ! wp_attachment_is_image( $id ) ) {
									$id = '';
								}
								if ( '' !== $id ) {
									$image_html = wp_get_attachment_image_url( $id, $crafto_image_gallery_thumbnail );
								} elseif ( ! empty( $image_url ) ) {
									$image_html = $image_url;
								}
							}

							$this->add_render_attribute(
								$link_wrapper,
								[
									'href' => $image_html,
									'data-elementor-open-lightbox' => 'no',
								]
							);

							if ( 'yes' === $crafto_image_gallery_lightbox ) {
								$this->add_render_attribute(
									$link_wrapper,
									[
										'data-group' => $this->get_id(),
										'class'      => 'lightbox-group-gallery-item',
									]
								);

								$crafto_image_title_lightbox_popup   = get_theme_mod( 'crafto_image_title_lightbox_popup', '0' );
								$crafto_image_caption_lightbox_popup = get_theme_mod( 'crafto_image_caption_lightbox_popup', '0' );

								if ( '1' === $crafto_image_title_lightbox_popup ) {
									$crafto_attachment_title = get_the_title( $id );
									if ( ! empty( $crafto_attachment_title ) ) {
										$this->add_render_attribute(
											$link_wrapper,
											[
												'title' => $crafto_attachment_title,
											]
										);
									}
								}
								if ( '1' === $crafto_image_caption_lightbox_popup ) {
									$crafto_lightbox_caption = wp_get_attachment_caption( $id );
									if ( ! empty( $crafto_lightbox_caption ) ) {
										$this->add_render_attribute(
											$link_wrapper,
											[
												'data-lightbox-caption' => $crafto_lightbox_caption,
											]
										);
									}
								}
							}
						}
						?>
						<li <?php $this->print_render_attribute_string( $inner_wrapper ); ?>>
							<?php
							if ( 'attractive' === $crafto_image_gallery_style ) {
								?>
								<div class="atropos-scale">
									<div class="atropos-rotate">
										<div class="atropos-inner" data-atropos-offset="<?php echo esc_attr( (int) $crafto_image_data_atropos_offset ); ?>">
								<?php
							}
							?>
							<div <?php $this->print_render_attribute_string( 'gallery-box' ); ?>>
								<?php
								if ( 'file' === $crafto_image_gallery_link ) {
									?>
									<a <?php $this->print_render_attribute_string( $link_wrapper ); ?>>
									<?php
								}
								?>
								<div class="gallery-image">
									<?php
									if ( 0 === $id ) {
										if ( ! empty( $image_url ) ) {
											echo '<img src="' . esc_url( $image_url ) . '">';
										}
									} else {
										if ( ! empty( $id ) && ! wp_attachment_is_image( $id ) ) {
											$id = '';
										}
										if ( '' !== $id ) {
											echo wp_kses_post( crafto_get_attachment_image_html( $settings, $crafto_image_gallery_thumbnail, $image, [] ) );
										} elseif ( ! empty( $image_url ) ) {
											echo '<img src="' . esc_url( $image_url ) . '">';
										}
									}

									if ( 'yes' === $crafto_image_gallery_icon && 'none' !== $crafto_image_gallery_link ) {
										?>
										<div class="gallery-hover">
											<div class="icon-box">
												<?php printf( '%s', $custom_link ); // phpcs:ignore ?>
											</div>
										</div>
										<?php
									}
									?>
								</div>
								<?php
								if ( 'file' === $crafto_image_gallery_link ) {
									?>
									</a>
									<?php
								}
								?>
							</div>
							<?php
							if ( 'attractive' === $crafto_image_gallery_style ) {
								?>
									</div>
								</div>
							</div>
								<?php
							}
							?>
						</li>
						<?php
						++$index;
						++$grid_metro_count;
						++$grid_count;
					}
					?>
				</ul>
				<?php
			}
		}
	}
}
