<?php
namespace CraftoAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Classes\Elementor_Templates;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Crafto widget for Hamburger Menu.
 *
 * @package Crafto
 */

// If class `Hamburger_Menu` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Hamburger_Menu' ) ) {
	/**
	 * Define `Hamburger_Menu` class.
	 */
	class Hamburger_Menu extends Widget_Base {

		/**
		 * Retrieve the list of scripts the hamburger menu widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-hamburger-menu-widget' ];
			}
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-hamburger-menu';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Hamburger Menu', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-menu-bar crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/hamburger-menu/';
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
				'menu',
				'nav',
				'navigation',
				'toggle',
				'slide',
				'button',
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
				'crafto_hamburger_menu_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_hamburger_menu_layout_type',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'hamburger-menu-default',
					'options' => [
						'hamburger-menu-default' => esc_html__( 'Default', 'crafto-addons' ),
						'hamburger-menu-modern'  => esc_html__( 'Hamburger Menu Modern', 'crafto-addons' ),
						'hamburger-menu-half'    => esc_html__( 'Hamburger Menu Half', 'crafto-addons' ),
						'hamburger-menu-full'    => esc_html__( 'Hamburger Menu Full', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_item_template_id',
				[
					'label'       => esc_html__( 'Choose Template', 'crafto-addons' ),
					'label_block' => true,
					'type'        => Controls_Manager::SELECT,
					'default'     => '0',
					'options'     => Elementor_Templates::get_elementor_templates_options(),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_hamburger_menu_settings_section',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_hamburger_menu_position',
				[
					'label'   => esc_html__( 'Menu Open Direction', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'right',
					'options' => [
						'right' => esc_html__( 'Right', 'crafto-addons' ),
						'left'  => esc_html__( 'Left', 'crafto-addons' ),
						'top'   => esc_html__( 'Top', 'crafto-addons' ),
					],
				]
			);
			$this->add_responsive_control(
				'crafto_hamburger_menu_width',
				[
					'label'      => esc_html__( 'Menu Panel Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'%',
						'px',
						'custom',
					],
					'range'      => [
						'%'  => [
							'max' => 100,
							'min' => 20,
						],
						'px' => [
							'max' => 1000,
							'min' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .hamburger-menu-half, {{WRAPPER}} .hamburger-menu-modern' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_hamburger_menu_layout_type' => [
							'hamburger-menu-half',
							'hamburger-menu-modern',
						],
					],
				]
			);

			$this->add_control(
				'crafto_toggle_icon_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
				]
			);

			$this->add_control(
				'crafto_toggle_text_align',
				[
					'label'   => esc_html__( 'Label Position', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'right',
					'options' => [
						'left'  => esc_html__( 'Left', 'crafto-addons' ),
						'right' => esc_html__( 'Right', 'crafto-addons' ),
					],
				]
			);

			$this->add_control(
				'crafto_heading_close_icon',
				[
					'label'     => esc_html__( 'Close Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_close_icon',
				[
					'label'            => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'show_label'       => true,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fa-solid fa-times',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_left_menu_container_style_section',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->start_controls_tabs( 'crafto_hamburger_menu_icon_tabs' );
				$this->start_controls_tab(
					'crafto_hamburger_menu_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_hamburger_menu_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .header-push-button span' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_hamburger_menu_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_hamburger_menu_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .header-push-button:hover span' => 'background-color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_hamburger_menu_toggle_height',
				[
					'label'       => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						'px',
						'custom',
					],
					'range'       => [
						'px' => [
							'max' => 3,
							'min' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .header-push-button span' => 'height: {{SIZE}}{{UNIT}}',
					],
					'separator'   => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_menu_toggle_text_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .header-push-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_menu_toggle_icon_text_heading',
				[
					'label'     => esc_html__( 'Label', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_menu_mobile_toggle_text_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .toggle-menu-word',
				]
			);

			$this->start_controls_tabs( 'crafto_menu_mobile_toggle_text_tabs' );
				$this->start_controls_tab(
					'crafto_menu_mobile_toggle_text_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_menu_mobile_toggle_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .toggle-menu-word' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_menu_mobile_toggle_text_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_menu_mobile_toggle_text_hover_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .push-button:hover .toggle-menu-word' => 'color: {{VALUE}};',
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_menu_toggle_text_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'rem',
						'em',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .toggle-menu-word' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_hamburger_menu_open_panel_style_section',
				[
					'label'     => esc_html__( 'Hamburger Menu Panel', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_hamburger_menu_layout_type!' => [
							'hamburger-menu-full',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_hamburger_menu_shadow',
					'selector'  => '{{WRAPPER}} .hamburger-menu-half .hamburger-menu, {{WRAPPER}} .hamburger-menu-modern .hamburger-menu',
					'condition' => [
						'crafto_hamburger_menu_layout_type' => [
							'hamburger-menu-modern',
							'hamburger-menu-half',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_hamburger_menu_background_panel',
					'selector'       => '{{WRAPPER}} .hamburger-menu',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'condition'      => [
						'crafto_hamburger_menu_layout_type' => [
							'hamburger-menu-default',
							'hamburger-menu-modern',
							'hamburger-menu-half',
						],
					],
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Background Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_hamburger_menu_close_icon_style_section',
				[
					'label' => esc_html__( 'Close Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->start_controls_tabs(
				'crafto_hamburger_menu_close_icon_tabs_styles',
			);
				$this->start_controls_tab(
					'crafto_hamburger_menu_close_icon_tabs_control_normal',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_hamburger_menu_close_icon_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .hamburger-menu .close-menu'     => 'color: {{VALUE}};',
							'{{WRAPPER}} .hamburger-menu .close-menu svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'           => 'crafto_hamburger_menu_close_icon_bcakground',
						'exclude'        => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'       => '{{WRAPPER}} .hamburger-menu .close-menu',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Background Color', 'crafto-addons' ),
							],
						],
					]
				);
				$this->add_responsive_control(
					'crafto_hamburger_menu_close_icon_font_size',
					[
						'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
						'type'       => Controls_Manager::SLIDER,
						'size_units' => [
							'px',
						],
						'range'      => [
							'px' => [
								'min' => 10,
								'max' => 50,
							],
						],
						'selectors'  => [
							'{{WRAPPER}} .hamburger-menu-wrapper .close-menu' => 'font-size: {{SIZE}}{{UNIT}}',
							'{{WRAPPER}} .hamburger-menu-wrapper .close-menu svg' => 'width: {{SIZE}}{{UNIT}}',
						],
					]
				);
				$this->add_responsive_control(
					'crafto_hamburger_menu_close_icon_height_width',
					[
						'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
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
							'{{WRAPPER}} .hamburger-menu-wrapper .close-menu' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
						],
					]
				);
				$this->end_controls_tab();
				$this->start_controls_tab(
					'crafto_hamburger_menu_close_icon_tabs_control_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_control(
					'crafto_hamburger_menu_close_icon_color_hover',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .hamburger-menu-wrapper .close-menu:hover'     => 'color: {{VALUE}};',
							'{{WRAPPER}} .hamburger-menu-wrapper .close-menu:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'           => 'crafto_hamburger_menu_close_icon_hovr_bcakground',
						'exclude'        => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector'       => '{{WRAPPER}} .hamburger-menu .close-menu:hover',
						'fields_options' => [
							'background' => [
								'label' => esc_html__( 'Background Color', 'crafto-addons' ),
							],
						],
					]
				);
				$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render hamburger menu widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings   = $this->get_settings_for_display();
			$migrated   = isset( $settings['__fa4_migrated']['crafto_close_icon'] );
			$is_new     = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$text_align = $settings['crafto_toggle_text_align'];

			$this->add_render_attribute(
				[
					'toggle-menu'        => [
						'href' => '#',
					],
					'navigation-wrapper' => [
						'class' => 'hamburger-menu',
					],
					'close-menu'         => [
						'class' => 'close-menu',
						'href'  => '#',
					],
				]
			);

			$this->add_render_attribute(
				[
					'hamburger-menu-wrapper' => [
						'class' => [
							'hamburger-menu-wrapper',
							$settings['crafto_hamburger_menu_layout_type'],
							$settings['crafto_hamburger_menu_position'],
						],
					],
				]
			);

			$this->add_render_attribute(
				'toggle-menu-wrapper',
				'class',
				[
					'header-push-button',
					$text_align,
				]
			);
			$this->add_render_attribute(
				'toggle-menu',
				'class',
				[
					'push-button',
				]
			);
			?>
			<div <?php $this->print_render_attribute_string( 'toggle-menu-wrapper' ); // phpcs:ignore ?>>
				<a <?php $this->print_render_attribute_string( 'toggle-menu' ); ?> aria-label="<?php echo esc_attr__( 'Toggle Menu', 'crafto-addons' ); ?>">
					<?php
					if ( isset( $settings['crafto_toggle_icon_text'] ) && ! empty( $settings['crafto_toggle_icon_text'] ) ) {
						?>
						<div class="toggle-menu-word alt-font"><?php echo esc_html( $settings['crafto_toggle_icon_text'] ); ?></div>
						<?php
					}
					?>
					<div class="toggle-menu-inner">
						<span></span>
						<span></span>
						<span></span>
						<span></span>
					</div>
				</a>
			</div>
			<div <?php $this->print_render_attribute_string( 'hamburger-menu-wrapper' ); ?>>
				<?php
				if ( '0' !== $settings['crafto_item_template_id'] ) {
					$template_content = \Crafto_Addons_Extra_Functions::crafto_get_builder_content_for_display( $settings['crafto_item_template_id'] );
					if ( ! empty( $template_content ) ) {
						if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
							$edit_url = add_query_arg(
								array(
									'elementor' => '',
								),
								get_permalink( $settings['crafto_item_template_id'] )
							);
							echo sprintf( '<div class="edit-template-with-light-box elementor-template-edit-cover" data-template-edit-link="%s"><i aria-hidden="true" class="eicon-edit"></i><span>%s</span></div>', esc_url( $edit_url ), esc_html__( 'Edit Template', 'crafto-addons' ) ); // phpcs:ignore
						}
						?>
						<div <?php $this->print_render_attribute_string( 'navigation-wrapper' ); ?>>
							<a <?php $this->print_render_attribute_string( 'close-menu' ); ?>>
								<span class="screen-reader-text d-none"><?php echo esc_html__( 'close menu button', 'crafto-addons' ); ?></span>
								<?php
								if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_close_icon']['value'] ) ) {
									if ( $is_new || $migrated ) {
										Icons_Manager::render_icon( $settings['crafto_close_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( isset( $settings['crafto_close_icon']['value'] ) && ! empty( $settings['crafto_close_icon']['value'] ) ) {
										?>
										<i class="<?php echo esc_attr( $settings['crafto_close_icon']['value'] ); ?>" aria-hidden="true"></i>
										<?php
									}
								}
								?>
							</a>
							<?php printf( '%s', $template_content );  // phpcs:ignore ?>
						</div>
						<?php
					} else {
						printf( '%s', no_template_content_message() );  // phpcs:ignore
					}
				} else {
					printf( '%s', no_template_content_message() );  // phpcs:ignore
				}
				?>
			</div>
			<?php
		}
	}
}
