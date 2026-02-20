<?php
namespace CraftoAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Crafto widget for media gallery.
 *
 * @package Crafto
 */

// If class `Media_Gallery` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Media_Gallery' ) ) {

	/**
	 *
	 * Define Class `Media Gallery`
	 */
	class Media_Gallery extends Widget_Base {
		/**
		 * Retrieve the list of scripts the media gallery widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$media_gallery_scripts = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$media_gallery_scripts[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$media_gallery_scripts[] = 'magnific-popup';
					$media_gallery_scripts[] = 'crafto-lightbox-gallery';
				}

				if ( crafto_disable_module_by_key( 'imagesloaded' ) ) {
					$media_gallery_scripts[] = 'imagesloaded';
				}

				if ( crafto_disable_module_by_key( 'isotope' ) ) {
					$media_gallery_scripts[] = 'isotope';
				}

				if ( crafto_disable_module_by_key( 'fitvids' ) ) {
					$media_gallery_scripts[] = 'jquery.fitvids';
				}
				$media_gallery_scripts[] = 'crafto-media-gallery-widget';
			}
			return $media_gallery_scripts;
		}

		/**
		 * Retrieve the list of styles the media gallery widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$media_gallery_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$media_gallery_styles[] = 'crafto-widgets';
			} else {
				if ( crafto_disable_module_by_key( 'magnific-popup' ) ) {
					$media_gallery_styles[] = 'magnific-popup';
				}
				$media_gallery_styles[] = 'crafto-media-gallery-widget';
			}
			return $media_gallery_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-media-gallery';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Media Gallery', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/media-gallery/';
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
				'media',
				'carousel',
				'image',
				'video',
				'lightbox',
				'photo gallery',
				'media widget',
			];
		}

		/**
		 * Register media gallery widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_media_gallery',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'crafto_image',
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
			$repeater->add_control(
				'crafto_media_gallery_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write Title Here', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_video_source',
				[
					'label'   => esc_html__( 'Source', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'youtube',
					'options' => [
						'youtube'    => esc_html__( 'YouTube', 'crafto-addons' ),
						'vimeo'      => esc_html__( 'Vimeo', 'crafto-addons' ),
						'selfhosted' => esc_html__( 'Self Hosted', 'crafto-addons' ),
					],
				]
			);
			$repeater->add_control(
				'crafto_selfhosted_video_link',
				[
					'label'       => esc_html__( 'Choose Video File', 'crafto-addons' ),
					'type'        => Controls_Manager::MEDIA,
					'dynamic'     => [
						'active' => true,
					],
					'media_types' => [
						'video',
					],
					'condition'   => [
						'crafto_video_source' => 'selfhosted',
					],
				]
			);
			$repeater->add_control(
				'crafto_youtube_video_link',
				[
					'label'       => esc_html__( 'YouTube Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://www.youtube.com/watch?v=XHOmBV4js_E', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'condition'   => [
						'crafto_video_source' => 'youtube',
					],
				]
			);
			$repeater->add_control(
				'crafto_vimeo_video_link',
				[
					'label'       => esc_html__( 'Vimeo Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => __( 'https://vimeo.com/235215203', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'separator'   => 'after',
					'condition'   => [
						'crafto_video_source' => 'vimeo',
					],
				]
			);
			$repeater->add_control(
				'crafto_media_overlay_color',
				[
					'label'     => esc_html__( 'Overlay Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}} .portfolio-image' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_media_gallery_list',
				[
					'label'   => esc_html__( 'Items', 'crafto-addons' ),
					'type'    => Controls_Manager::REPEATER,
					'fields'  => $repeater->get_controls(),
					'default' => [
						[
							'crafto_image'               => Utils::get_placeholder_image_src(),
							'crafto_media_gallery_title' => esc_html__( 'Write title here', 'crafto-addons' ),
						],
						[
							'crafto_image'               => Utils::get_placeholder_image_src(),
							'crafto_media_gallery_title' => esc_html__( 'Write title here', 'crafto-addons' ),
						],
						[
							'crafto_image'               => Utils::get_placeholder_image_src(),
							'crafto_media_gallery_title' => esc_html__( 'Write title here', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_media_gallery_setting',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
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
				'crafto_media_gallery_columns_gap',
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
						'{{WRAPPER}} ul li.grid-item' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.grid'         => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_media_gallery_bottom_spacing',
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
				'crafto_title_size',
				[
					'label'     => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
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
					'default'   => 'div',
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'full',
					'exclude'   => [ 'custom' ],
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_media_gallery_icon',
				[
					'label'        => esc_html__( 'Enable Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'separator'    => 'before',
				]
			);
			$this->add_control(
				'crafto_media_gallery_select_icon',
				[
					'label'            => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'fas fa-play',
						'library' => 'fa-solid',
					],
					'condition'        => [
						'crafto_media_gallery_icon' => 'yes',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_media_gallery_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_media_gallery_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .gallery-title',
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_media_gallery_title_color',
					'selector'       => '{{WRAPPER}} .gallery-title',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Color', 'crafto-addons' ),
						],
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_media_gallery_images',
				[
					'label' => esc_html__( 'Image', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_image_border',
					'selector' => '{{WRAPPER}} .portfolio-box .portfolio-image',
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
						'{{WRAPPER}} .portfolio-box .portfolio-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_icon',
				[
					'label' => esc_html__( 'Hover Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .image-gallery-box i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .image-gallery-box svg' => 'fill: {{VALUE}};',
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
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .image-gallery-box i, {{WRAPPER}} .image-gallery-box svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_shape_size',
				[
					'label'     => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .image-gallery-box .icon, {{WRAPPER}} .image-gallery-box .icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_icon_border',
					'selector' => '{{WRAPPER}} .portfolio-hover .icon',
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .portfolio-hover .icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_media_gallery_image_overlay',
				[
					'label' => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_media_gallery_color',
					'types'    => [ 'classic', 'gradient' ],
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .portfolio-image',
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
						'{{WRAPPER}} .portfolio-box.image-gallery-box:hover .portfolio-image img' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render media gallery widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			if ( ! $settings['crafto_media_gallery_list'] ) {
				return;
			}

			$crafto_media_gallery_icon = ( isset( $settings['crafto_media_gallery_icon'] ) && $settings['crafto_media_gallery_icon'] ) ? $settings['crafto_media_gallery_icon'] : '';

			/* Column Settings */
			$crafto_column_class      = array();
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';
			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );
			/* End Column Settings */

			$this->add_render_attribute(
				'main_wrapper',
				[
					'class' => [
						'image-gallery-grid',
						'grid',
						$crafto_column_class_list,
					],
				]
			);

			$custom_icon = '';
			$is_new      = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$migrated    = isset( $settings['__fa4_migrated']['crafto_media_gallery_select_icon'] );

			if ( $is_new || $migrated ) {
				ob_start();
				Icons_Manager::render_icon( $settings['crafto_media_gallery_select_icon'], [ 'aria-hidden' => 'true' ] );
				$custom_icon .= ob_get_clean();
			} elseif ( isset( $settings['crafto_media_gallery_select_icon']['value'] ) && ! empty( $settings['crafto_media_gallery_select_icon']['value'] ) ) {
				$custom_icon .= '<i class="' . esc_attr( $settings['crafto_media_gallery_select_icon']['value'] ) . '" aria-hidden="true"></i>';
			}

			if ( ! empty( $settings['crafto_media_gallery_list'] ) ) {
				?>
				<ul <?php $this->print_render_attribute_string( 'main_wrapper' ); ?>>
					<?php
					if ( crafto_disable_module_by_key( 'isotope' ) && crafto_disable_module_by_key( 'imagesloaded' ) ) {
						?>
						<li class="grid-sizer d-none p-0 m-0"></li>
						<?php
					}

					foreach ( $settings['crafto_media_gallery_list'] as $key => $item ) {
						$link_wrapper  = $key . '_link_wrapper';
						$inner_wrapper = $key . '_inner_wrapper';

						$this->add_render_attribute(
							$link_wrapper,
							[
								'data-elementor-open-lightbox' => 'no',
							]
						);

						$link_flag = false;
						if ( ! empty( $item['crafto_youtube_video_link'] ) && '' !== $item['crafto_youtube_video_link']['url'] ) {
							$this->add_render_attribute(
								$link_wrapper,
								[
									'href'  => $item['crafto_youtube_video_link']['url'],
									'class' => 'popup-youtube',
								]
							);

							$link_flag = true;
						} elseif ( ! empty( $item['crafto_vimeo_video_link']['url'] ) ) {
							$this->add_render_attribute(
								$link_wrapper,
								[
									'href'  => $item['crafto_vimeo_video_link']['url'],
									'class' => 'popup-youtube',
								]
							);
							$link_flag = true;
						} elseif ( ! empty( $item['crafto_selfhosted_video_link']['url'] ) ) {
							$this->add_render_attribute(
								$link_wrapper,
								[
									'href'  => $item['crafto_selfhosted_video_link']['url'],
									'class' => 'popup-youtube',
								]
							);
							$link_flag = true;
						} elseif ( ! empty( $item['crafto_image'] ) ) {
							$this->add_render_attribute(
								$link_wrapper,
								[
									'href'  => $item['crafto_image']['url'],
									'class' => 'lightbox-group-gallery-item',
								]
							);
							$link_flag = true;
						}

						if ( ! empty( $item['crafto_image']['id'] ) ) {
							$crafto_attachment_title = get_the_title( $item['crafto_image']['id'] );
							$crafto_lightbox_caption = wp_get_attachment_caption( $item['crafto_image']['id'] );
							$this->add_render_attribute(
								$link_wrapper,
								[
									'title' => $crafto_attachment_title,
									'data-lightbox-caption' => $crafto_lightbox_caption,
								]
							);
						}

						$this->add_render_attribute(
							$inner_wrapper,
							[
								'class' => [
									'grid-item',
									'elementor-repeater-item-' . $item['_id'],
								],
							]
						);

						$image_exist = false;
						if ( ! empty( $item['crafto_image']['id'] ) ) {
							$image_exist = true;
						} elseif ( ! empty( $item['crafto_image']['url'] ) ) {
							$image_exist = true;
						}

						if ( $image_exist ) {
							?>
							<li <?php $this->print_render_attribute_string( $inner_wrapper ); ?>>
								<?php
								if ( $link_flag ) {
									?>
									<a <?php $this->print_render_attribute_string( $link_wrapper ); ?>>
									<?php
								}
								?>
								<div class="portfolio-box image-gallery-box">
									<div class="portfolio-image fit-videos">
										<?php
										if ( ! empty( $item['crafto_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_image']['id'] ) ) {
											$item['crafto_image']['id'] = '';
										}
										if ( isset( $item['crafto_image'] ) && isset( $item['crafto_image']['id'] ) && ! empty( $item['crafto_image']['id'] ) ) {
											crafto_get_attachment_html( $item['crafto_image']['id'], $item['crafto_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										} elseif ( isset( $item['crafto_image'] ) && isset( $item['crafto_image']['url'] ) && ! empty( $item['crafto_image']['url'] ) ) {
											crafto_get_attachment_html( $item['crafto_image']['id'], $item['crafto_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
										}
										?>
									</div>
									<?php
									if ( 'yes' === $crafto_media_gallery_icon || $item['crafto_media_gallery_title'] ) {
										?>
										<div class="portfolio-hover">
											<?php
											if ( $item['crafto_media_gallery_title'] ) {
												?>
												<<?php echo $this->get_settings( 'crafto_title_size' ); // phpcs:ignore ?> class="gallery-title" data-text="<?php echo esc_html( $item['crafto_media_gallery_title'] ); ?>"><span class="screen-reader-text"><?php echo esc_html( $item['crafto_media_gallery_title'] ); ?></span>
												</<?php echo $this->get_settings( 'crafto_title_size' ); // phpcs:ignore ?>>
												<?php
											}
											if ( $settings['crafto_media_gallery_select_icon'] ) {
												?>
												<span class="icon"><?php echo sprintf( '%s', $custom_icon ); // phpcs:ignore ?></span>
												<?php
											}
											?>
										</div>
										<?php
									}
									?>
								</div>
								<?php
								if ( $link_flag ) {
									?>
									</a>
									<?php
								}
								?>
							</li>
							<?php
						}
					}
					?>
				</ul>
				<?php
			}
		}
	}
}
