<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for Crafto Brand Logo.
 *
 * @package Crafto
 */

// If class `Brand_Logo` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Brand_Logo' ) ) {
	/**
	 * Define `Brand_Logo` class.
	 */
	class Brand_Logo extends Widget_Base {
		/**
		 * Retrieve the list of styles the brand logo widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$brand_logo_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$brand_logo_styles[] = 'crafto-widgets-rtl';
				} else {
					$brand_logo_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$brand_logo_styles[] = 'crafto-brand-logo-rtl';
				}
				$brand_logo_styles[] = 'crafto-brand-logo';
			}
			return $brand_logo_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-brand-logo';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Brand Logos', 'crafto-addons' );
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
			return 'https://crafto.themezaa.com/documentation/brand-logos/';
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
				'image',
				'photo',
				'visual',
				'clients',
				'partners',
				'sponsors',
			];
		}

		/**
		 * Register crafto brand logo controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_brand_logo',
				[
					'label' => esc_html__( 'Brand Logos', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs(
				'crafto_brand_logo_image_tabs'
			);
			$repeater->start_controls_tab(
				'crafto_brand_logo_image_tab',
				[
					'label' => esc_html__( 'Logo', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_brand_logo_image',
				[
					'label'   => esc_html__( 'Logo', 'crafto-addons' ),
					'type'    => Controls_Manager::MEDIA,
					'dynamic' => [
						'active' => true,
					],
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_brand_logo_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				],
			);
			$repeater->add_control(
				'crafto_brand_logo_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'icon-feather-plus',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$repeater->add_control(
				'crafto_brand_logo_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => esc_html__( 'Write title here', 'crafto-addons' ),
					'label_block' => true,
				]
			);
			$repeater->add_control(
				'crafto_brand_logo_description',
				[
					'label'   => esc_html__( 'Description', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Lorem Ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();

			$this->add_control(
				'crafto_brand_logos',
				[
					'label'      => esc_html__( 'Brand Logos', 'crafto-addons' ),
					'show_label' => false,
					'type'       => Controls_Manager::REPEATER,
					'fields'     => $repeater->get_controls(),
					'default'    => [
						[
							'crafto_brand_logo_title' => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_brand_logo_description' => esc_html__( 'Lorem Ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
							'crafto_brand_logo_image' => Utils::get_placeholder_image_src(),

						],
						[
							'crafto_brand_logo_title' => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_brand_logo_description' => esc_html__( 'Lorem Ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
							'crafto_brand_logo_image' => Utils::get_placeholder_image_src(),
						],
						[
							'crafto_brand_logo_title' => esc_html__( 'Write title here', 'crafto-addons' ),
							'crafto_brand_logo_description' => esc_html__( 'Lorem Ipsum is simply dummy the text of the printing & typesetting.', 'crafto-addons' ),
							'crafto_brand_logo_image' => Utils::get_placeholder_image_src(),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_brand_logo_content_setting',
				[
					'label' => esc_html__( 'Content Settings', 'crafto-addons' ),
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
			$this->add_responsive_control(
				'crafto_column_settings',
				[
					'label'     => esc_html__( 'Number of Columns', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 3,
					],
					'separator' => 'before',
					'range'     => [
						'px' => [
							'min'  => 1,
							'max'  => 6,
							'step' => 1,
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_columns_gap',
				[
					'label'      => esc_html__( 'Columns Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'default'    => [
						'size' => 15,
					],
					'range'      => [
						'px' => [
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} ul li.grid-gutter' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} ul.crafto-brand-logo-list' => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_logo_bottom_spacing',
				[
					'label'      => esc_html__( 'Bottom Gap', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} ul li.grid-gutter' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_brand_logo_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_brand_logo_info_alignment',
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
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .brand-logo-info-inner' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_box_background_color',
				[
					'label'     => esc_html__( 'Background', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-brand-logo-wrapper' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_brand_logo_general_padding',
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
						'{{WRAPPER}} .crafto-brand-logo-wrapper .brand-logo-info-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_box_height',
				[
					'label'      => esc_html__( 'Box Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
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
						'{{WRAPPER}} .crafto-brand-logo-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_image',
				[
					'label' => esc_html__( 'Logo', 'crafto-addons' ),
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
						'{{WRAPPER}} .crafto-brand-logo-wrapper img' => 'width: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .crafto-brand-logo-wrapper img' => 'max-width: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .crafto-brand-logo-wrapper img' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_icon_title',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .brand-logo-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .brand-logo-icon svg' => 'width: {{SIZE}}{{UNIT}}; height:auto;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_max_width',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
						'%'  => [
							'min' => 40,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-brand-logo-wrapper .brand-logo-info-wrapper' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .brand-logo-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .brand-logo-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_background_color',
				[
					'label'     => esc_html__( 'Background', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-brand-logo-wrapper .brand-logo-info-wrapper' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
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
					'selector' => '{{WRAPPER}} .brand-logo-info-inner .brand-logo-title',
				]
			);
			$this->add_control(
				'crafto_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .brand-logo-info-inner .brand-logo-title' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_title_bottom_spacer',
				[
					'label'      => esc_html__( 'Bottom Spacer', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .brand-logo-info-inner .brand-logo-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_description',
				[
					'label' => esc_html__( 'Description', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_description_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .brand-logo-info-inner .brand-logo-description',
				]
			);
			$this->add_control(
				'crafto_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .brand-logo-info-inner .brand-logo-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}
		/**
		 * Render crafto brand logo widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                 = $this->get_settings_for_display();
			$crafto_column_class_list = '';
			$crafto_column_class      = array();
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings'] ) ? 'grid-' . $settings['crafto_column_settings']['size'] . 'col' : 'grid-3col';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_laptop'] ) ? 'xl-grid-' . $settings['crafto_column_settings_laptop']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet_extra'] ) ? 'lg-grid-' . $settings['crafto_column_settings_tablet_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_tablet'] ) ? 'md-grid-' . $settings['crafto_column_settings_tablet']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile_extra'] ) ? 'sm-grid-' . $settings['crafto_column_settings_mobile_extra']['size'] . 'col' : '';
			$crafto_column_class[]    = ! empty( $settings['crafto_column_settings_mobile'] ) ? 'xs-grid-' . $settings['crafto_column_settings_mobile']['size'] . 'col' : '';
			$crafto_column_class      = array_filter( $crafto_column_class );
			$crafto_column_class_list = implode( ' ', $crafto_column_class );

			$this->add_render_attribute(
				'wrapper',
				[
					'class' => [
						'grid',
						'crafto-brand-logo-list',
						$crafto_column_class_list,
					],
				],
			);
			?>
			<ul <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php
			foreach ( $settings['crafto_brand_logos'] as $index => $item ) {
				$wrapper_key = 'wrapper_' . $index;
				$this->add_render_attribute(
					$wrapper_key,
					[
						'class' => [
							'grid-item',
							'grid-gutter',
							'elementor-repeater-item-' . $item['_id'],
						],
					],
				);
				$icon     = '';
				$migrated = isset( $item['__fa4_migrated']['crafto_brand_logo_icon'] );
				$is_new   = empty( $item['icon'] ) && Icons_Manager::is_migration_allowed();

				if ( $is_new || $migrated ) {
					ob_start();
						Icons_Manager::render_icon( $item['crafto_brand_logo_icon'], [ 'aria-hidden' => 'true' ] );
					$icon .= ob_get_clean();
				} elseif ( isset( $item['crafto_brand_logo_icon']['value'] ) && ! empty( $item['crafto_brand_logo_icon']['value'] ) ) {
					$icon .= '<i class="' . esc_attr( $item['crafto_brand_logo_icon']['value'] ) . '" aria-hidden="true"></i>';
				}
				?>
				<li <?php $this->print_render_attribute_string( $wrapper_key ); ?>>
					<div class="crafto-brand-logo-wrapper">
						<?php
						if ( ! empty( $item['crafto_brand_logo_image']['id'] ) && ! wp_attachment_is_image( $item['crafto_brand_logo_image']['id'] ) ) {
							$item['crafto_brand_logo_image']['id'] = '';
						}
						if ( isset( $item['crafto_brand_logo_image'] ) && isset( $item['crafto_brand_logo_image']['id'] ) && ! empty( $item['crafto_brand_logo_image']['id'] ) ) {
							crafto_get_attachment_html( $item['crafto_brand_logo_image']['id'], $item['crafto_brand_logo_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $item['crafto_brand_logo_image'] ) && isset( $item['crafto_brand_logo_image']['url'] ) && ! empty( $item['crafto_brand_logo_image']['url'] ) ) {
							crafto_get_attachment_html( $item['crafto_brand_logo_image']['id'], $item['crafto_brand_logo_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}
						?>
						<div class="brand-logo-info">
							<div class="brand-logo-info-wrapper">
							<?php
							if ( ! empty( $icon ) ) {
								?>
								<div class="brand-logo-icon elementor-icon">
									<?php printf( '%s', $icon ); // phpcs:ignore ?>
								</div>
								<?php
							}
							if ( ! empty( $item['crafto_brand_logo_title'] ) || ! empty( $item['crafto_brand_logo_description'] ) ) {
								?>
								<div class="brand-logo-info-inner">
									<?php
									if ( ! empty( $item['crafto_brand_logo_title'] ) ) { ?>
										<span class="brand-logo-title">
											<?php
												echo esc_attr( $item['crafto_brand_logo_title'] );
											?>
										</span>
										<?php
									}
									if ( ! empty( $item['crafto_brand_logo_description'] ) ) { ?>
										<p class="brand-logo-description">
											<?php
												echo esc_attr( $item['crafto_brand_logo_description'] );
											?>
										</p>
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
				</li>
				<?php
			}
			?>
			</ul>
			<?php
		}
	}
}
