<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for lists.
 *
 * @package Crafto
 */

// If class `Lists` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Lists' ) ) {
	/**
	 * Define `Lists` class.
	 */
	class Lists extends Widget_Base {
		/**
		 * Retrieve the list of styles the Lists widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$lists_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$lists_styles[] = 'crafto-widgets-rtl';
				} else {
					$lists_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$lists_styles[] = 'crafto-lists-rtl';
				}

				$lists_styles[] = 'crafto-lists';
			}
			return $lists_styles;
		}
		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-lists';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Lists', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-bullet-list crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/lists/';
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
				'icon',
				'list',
				'bullet',
				'checklist',
				'text',
			];
		}
		/**
		 * Register lists widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_lists_content_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_text',
				[
					'label'       => esc_html__( 'Text', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'List Item', 'crafto-addons' ),
					'default'     => esc_html__( 'List Item', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'default'          => [
						'value'   => 'fa-solid fa-check',
						'library' => 'fa-solid',
					],
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
				]
			);
			$repeater->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_item_icon_icon_color',
					'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}} .elementor-icon-list-icon i',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_list',
				[
					'label'       => esc_html__( 'List', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'show_label'  => false,
					'default'     => [
						[
							'crafto_text'          => esc_html__( 'List Item 1', 'crafto-addons' ),
							'crafto_selected_icon' => [
								'value'   => 'far fa-arrow-alt-circle-right',
								'library' => 'fa-regular',
							],
						],
						[
							'crafto_text'          => esc_html__( 'List Item 2', 'crafto-addons' ),
							'crafto_selected_icon' => [
								'value'   => 'far fa-arrow-alt-circle-right',
								'library' => 'fa-regular',
							],
						],
						[
							'crafto_text'          => esc_html__( 'List Item 3', 'crafto-addons' ),
							'crafto_selected_icon' => [
								'value'   => 'far fa-arrow-alt-circle-right',
								'library' => 'fa-regular',
							],
						],
					],
					'title_field' => '{{{ elementor.helpers.renderIcon( this, crafto_selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ crafto_text }}}',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_lists_settings_section',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_view',
				[
					'label'          => esc_html__( 'Layout', 'crafto-addons' ),
					'type'           => Controls_Manager::CHOOSE,
					'default'        => 'traditional',
					'options'        => [
						'traditional' => [
							'title' => esc_html__( 'Default', 'crafto-addons' ),
							'icon'  => 'eicon-editor-list-ul',
						],
						'inline'      => [
							'title' => esc_html__( 'Inline', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-h',
						],
					],
					'render_type'    => 'template',
					'classes'        => 'elementor-control-start-end',
					'style_transfer' => true,
					'prefix_class'   => 'elementor-icon-list--layout-',
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_icon_list',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_icon_align',
				[
					'label'        => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'   => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'prefix_class' => 'elementor%s-align-',
				]
			);
			$this->add_responsive_control(
				'crafto_align_vertical',
				[
					'label'     => esc_html__( 'Vertical Align', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
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
						'{{WRAPPER}} .elementor-icon-list-items' => 'justify-content: {{VALUE}};',
					],
					'condition' => [
						'crafto_view' => 'inline',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_space_between',
				[
					'label'      => esc_html__( 'Space Between', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_view' => 'traditional',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_section_icon_list_tabs',
			);
			$this->start_controls_tab(
				'crafto_section_icon_list_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_section_icon_list_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_section_icon_list_border',
					'selector' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item',
				]
			);
			$this->add_responsive_control(
				'crafto_section_icon_list_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_section_icon_list_box_shadow',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item',
				]
			);
			$this->add_responsive_control(
				'crafto_lists_box_padding',
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
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_lists_box_margin',
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
						'{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_view' => 'inline',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_section_icon_list_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_section_icon_list_hover_bg_color',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_section_icon_list_border_hover',
					'selector' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover',
				]
			);
			$this->add_responsive_control(
				'crafto_section_icon_list_border_hover_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_section_icon_list_hover_box_shadow',
					'exclude'  => [
						'box_shadow_position',
					],
					'selector' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover',
				]
			);
			$this->add_responsive_control(
				'crafto_lists_box_hover_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_lists_box__hover_transition',
				[
					'label'       => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 0.6,
						'unit' => 's',
					],
					'range'       => [
						's' => [
							'max'  => 3,
							'step' => 0.1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item' => 'transition-duration: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_icon_style',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_icon_self_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
						'left'   => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'right'  => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors_dictionary' => [
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-list-icon' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 14,
					],
					'range'      => [
						'px' => [
							'min' => 6,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-list-icon i, {{WRAPPER}} .elementor-icon-list-icon svg'   => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_line_height',
				[
					'label'      => esc_html__( 'Line Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-list-icon i' => 'line-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_icon_tabs'
			);
			$this->start_controls_tab(
				'crafto_icon_color_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-list-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_icon_color_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_icon_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_hover_item_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_item_icon_color' => 'custom',
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon:hover i, {{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon:hover i:before' => 'color: {{VALUE}};',
						'{{WRAPPER}} {{CURRENT_ITEM}}.elementor-icon:hover svg'                                                           => 'fill: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_text_style',
				[
					'label' => esc_html__( 'Text', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_icon_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .elementor-icon-list-text',
				]
			);
			$this->add_control(
				'crafto_text_indent',
				[
					'label'      => esc_html__( 'Space Between Icon and Text', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_text_tabs',
			);
			$this->start_controls_tab(
				'crafto_text_color_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
				$this->add_control(
					'crafto_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'default'   => '',
						'selectors' => [
							'{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
						],
					]
				);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_text_color_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_text_color_hover',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render icon list widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();

			$this->add_render_attribute(
				'crafto_icon_list',
				'class',
				'elementor-icon-list-items',
			);
			$this->add_render_attribute(
				'list_item',
				'class',
				'elementor-icon-list-item',
			);

			if ( 'inline' === $settings['crafto_view'] ) {
				$this->add_render_attribute(
					'crafto_icon_list',
					'class',
					'elementor-inline-items',
				);
				$this->add_render_attribute(
					'list_item',
					'class',
					'elementor-inline-item',
				);
			}

			if ( ! empty( $settings['crafto_icon_list'] ) ) {
				?>
				<ul <?php $this->print_render_attribute_string( 'crafto_icon_list' ); ?>>
					<?php
					foreach ( $settings['crafto_icon_list'] as $index => $item ) {
						$list_item_key = 'crafto_list_' . $index;

						$repeater_setting_key = $this->get_repeater_setting_key(
							'crafto_text',
							'crafto_icon_list',
							$index,
						);
						$this->add_render_attribute(
							$list_item_key,
							'class',
							[
								'elementor-icon-list-item',
								'elementor-repeater-item-' . $item['_id'],
							]
						);
						$this->add_render_attribute(
							$repeater_setting_key,
							'class',
							'elementor-icon-list-text',
						);

						$migration_allowed = Icons_Manager::is_migration_allowed();
						?>
						<li <?php $this->print_render_attribute_string( $list_item_key ); ?>>
							<?php
							if ( ! empty( $item['crafto_link']['url'] ) ) {
								$link_key = 'crafto_link_' . $index;
								$this->add_link_attributes( $link_key, $item['crafto_link'] );
								?>
								<a <?php $this->print_render_attribute_string( $link_key ); ?>>
								<?php
							}

							$migrated = isset( $item['__fa4_migrated']['crafto_selected_icon'] );
							$is_new   = ! isset( $item['icon'] ) && $migration_allowed;

							if ( ! empty( $settings['icon'] ) || ! empty( $item['crafto_selected_icon']['value'] ) ) {
								?>
								<span class="elementor-icon-list-icon">
									<?php
									if ( $is_new || $migrated ) {
										Icons_Manager::render_icon( $item['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
									} elseif ( isset( $item['crafto_selected_icon']['value'] ) && ! empty( $item['crafto_selected_icon']['value'] ) ) {
										?>
										<i class="<?php echo esc_attr( $item['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
										<?php
									}
									?>
								</span>
								<?php
							}
							?>
							<span <?php $this->print_render_attribute_string( $repeater_setting_key ); ?>><?php echo esc_html( $item['crafto_text'] ); ?></span>
							<?php
							if ( ! empty( $item['crafto_link']['url'] ) ) {
								?>
								</a>
								<?php
							}
							?>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			}
		}
	}
}
