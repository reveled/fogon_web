<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for social icons.
 *
 * @package Crafto
 */

// If class `Social_Icons` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Social_Icons' ) ) {
	/**
	 * Define `Social_Icons` class.
	 */
	class Social_Icons extends Widget_Base {
		/**
		 * Retrieve the list of styles the social icons widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$social_icons_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$social_icons_styles[] = 'crafto-widgets-rtl';
				} else {
					$social_icons_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$social_icons_styles[] = 'crafto-social-icons-rtl';
				}
				$social_icons_styles[] = 'crafto-social-icons';
			}
			return $social_icons_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve social icons widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-social-icons';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve social icons widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Social Icons', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve social icons widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-social-icons crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/social-icons/';
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
				'link',
				'social network',
				'social bar',
				'follow us',
			];
		}

		/**
		 * Register social icons widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_social_icon',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_social_icon_layout_type',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default'             => esc_html__( 'Style 1', 'crafto-addons' ),
						'social-icon-style-1' => esc_html__( 'Style 2', 'crafto-addons' ),
						'social-icon-style-2' => esc_html__( 'Style 3', 'crafto-addons' ),
						'social-icon-style-3' => esc_html__( 'Style 4', 'crafto-addons' ),
						'social-icon-style-4' => esc_html__( 'Style 5', 'crafto-addons' ),
						'social-icon-style-5' => esc_html__( 'Style 6', 'crafto-addons' ),
					],
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_social_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'default'          => [
						'value'   => 'fa-brands fa-wordpress',
						'library' => 'fa-brands',
					],
					'fa4compatibility' => 'social',
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$repeater->add_control(
				'crafto_social_icon_custom_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'label_block' => true,
					'description' => esc_html__( 'Applicable in Style 3 & 6 only.', 'crafto-addons' ),

				]
			);
			$repeater->add_control(
				'crafto_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'label_block' => true,
					'default'     => [
						'is_external' => true,
					],
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$repeater->start_controls_tabs( 'crafto_social_icon_tabs' );
			$repeater->start_controls_tab(
				'crafto_social_icon_icon_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_item_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper ul {{CURRENT_ITEM}}.elementor-social-icon i, {{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon .social-icon-text' => 'color: {{VALUE}};',
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-social-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_item_icon_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_item_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-icon, {{WRAPPER}} .social-icons-wrapper.social-icon-style-3 {{CURRENT_ITEM}}.elementor-icon:after' => 'border-color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_social_icon_icon_tab_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_hover_item_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper ul {{CURRENT_ITEM}}.elementor-social-icon:hover i, {{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-social-icon:hover .social-icon-text' => 'color: {{VALUE}};',
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-social-icon:hover svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_hover_item_icon_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-icon:hover .crafto-social-hover-effect, {{WRAPPER}} .default.social-icons-wrapper {{CURRENT_ITEM}}.elementor-icon:hover, {{WRAPPER}} .social-icon-style-2.social-icons-wrapper {{CURRENT_ITEM}}.elementor-icon:hover, {{WRAPPER}} .social-icons-wrapper.social-icon-style-3 {{CURRENT_ITEM}}.elementor-icon:hover:after, {{WRAPPER}} .social-icon-style-4.social-icons-wrapper {{CURRENT_ITEM}}.elementor-icon span' => 'background-color: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_hover_item_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-icon:hover, {{WRAPPER}} .social-icons-wrapper.social-icon-style-3 {{CURRENT_ITEM}}.elementor-icon:hover:after' => 'border-color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'crafto_social_icon_list',
				[
					'label'       => esc_html__( 'Social Icons', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_social_icon'          => [
								'value'   => 'fa-brands fa-facebook-f',
								'library' => 'fa-brands',
							],
							'crafto_hover_item_animation' => '',
						],
						[
							'crafto_social_icon'          => [
								'value'   => 'fab fa-x-twitter',
								'library' => 'fa-brands',
							],
							'crafto_hover_item_animation' => '',
						],
						[
							'crafto_social_icon'          => [
								'value'   => 'fa-brands fa-linkedin-in',
								'library' => 'fa-brands',
							],
							'crafto_hover_item_animation' => '',
						],
					],
					'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( crafto_social_icon, social, true, migrated, true ) }}}',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_social_icon_settings',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_responsive_control(
				'crafto_social_icon_show_text',
				[
					'label'        => esc_html__( 'Enable Label', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'crafto_social_icon_layout_type' => [
							'default',
						],
					],

				]
			);
			$this->add_control(
				'crafto_social_icon_list_view',
				[
					'label'        => esc_html__( 'Orientation', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'default'      => 'horizontal',
					'options'      => [
						'horizontal' => [
							'title' => esc_html__( 'Horizontal', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-h',
						],
						'vertical'   => [
							'title' => esc_html__( 'Vertical', 'crafto-addons' ),
							'icon'  => 'eicon-ellipsis-v',
						],
					],
					'prefix_class' => 'elementor-icon-view-',
				],
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_social_general_style',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_social_icon_text_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector'  => '{{WRAPPER}} .elementor-social-icon .social-icon-text',
					'condition' => [
						'crafto_social_icon_layout_type!' => [
							'social-icon-style-1',
							'social-icon-style-3',
							'social-icon-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'              => [
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
					'default'              => 'left',
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end' : 'right',
					],
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_social_icon_list_view'    => 'horizontal',
						'crafto_social_icon_layout_type!' => 'social-icon-style-5',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_social_icon_alignment',
				[
					'label'       => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => 'flex-start',
					'options'     => [
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
					'selectors'   => [
						'{{WRAPPER}}' => 'display: flex; justify-content: {{VALUE}};',
						'{{WRAPPER}}.elementor-icon-view-vertical .social-icons-wrapper ul li' => 'text-align: {{VALUE}};',
					],
					'condition'   => [
						'crafto_social_icon_list_view'    => 'vertical',
						'crafto_social_icon_layout_type!' => 'social-icon-style-5',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_text_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'              => [
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
					'default'              => 'center',
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end' : 'right',
					],
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					],
					'condition' => [
						'crafto_social_icon_layout_type' => 'social-icon-style-5',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_social_icon_general_tabs' );
				$this->start_controls_tab(
					'crafto_social_icon_general_tab',
					[
						'label' => esc_html__( 'Normal', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_item_icon_general_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-icon i, {{WRAPPER}} .elementor-icon .social-icon-text' => 'color: {{VALUE}};',
							'{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_item_icon_general_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-icon:not(.crafto-hover-effect), {{WRAPPER}} .elementor-icon .crafto-social-hover-effect, {{WRAPPER}} .social-icon-style-4 .elementor-icon' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_social_icon_layout_type' => [
								'social-icon-style-3',
							],
						],
					]
				);
				$this->end_controls_tab();

				$this->start_controls_tab(
					'crafto_social_icon_general_tab_hover',
					[
						'label' => esc_html__( 'Hover', 'crafto-addons' ),
					]
				);
				$this->add_responsive_control(
					'crafto_hover_item_icon_general_text_color',
					[
						'label'     => esc_html__( 'Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-social-icon:hover i' => 'color: {{VALUE}};',
							'{{WRAPPER}} .elementor-social-icon:hover .social-icon-text' => 'color: {{VALUE}};',
							'{{WRAPPER}} .elementor-social-icon:hover svg' => 'fill: {{VALUE}};',
						],
					]
				);
				$this->add_control(
					'crafto_hover_item_icon_general_bg_color',
					[
						'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-icon:not(.crafto-hover-effect):hover'   => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .elementor-icon:hover .crafto-social-hover-effect' => 'background-color: {{VALUE}};',
							'{{WRAPPER}} .social-icon-style-3.social-icons-wrapper ul li a.elementor-icon:hover:after, {{WRAPPER}} .social-icon-style-4.social-icons-wrapper ul li a.elementor-icon span' => 'background-color: {{VALUE}};',
						],
						'condition' => [
							'crafto_social_icon_layout_type!' => [
								'default',
								'social-icon-style-2',
								'social-icon-style-5',
							],
						],
					]
				);
				$this->add_control(
					'crafto_social_icon_item_hvr_effect',
					[
						'label'        => esc_html__( 'Enable Slide On Hover', 'crafto-addons' ),
						'type'         => Controls_Manager::SWITCHER,
						'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
						'label_off'    => esc_html__( 'No', 'crafto-addons' ),
						'return_value' => 'yes',
						'default'      => '',
						'condition'    => [
							'crafto_social_icon_layout_type' => [
								'default',
							],
						],
					]
				);
				$this->add_group_control(
					Group_Control_Box_Shadow::get_type(),
					[
						'name'      => 'crafto_icon_hover_shadow',
						'selector'  => '{{WRAPPER}} .elementor-social-icon:hover',
						'condition' => [
							'crafto_social_icon_layout_type' => [
								'default',
								'social-icon-style-3',
							],
						],
					]
				);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_icon_border',
					'selector'  => '{{WRAPPER}} .social-icon-style-3 .elementor-social-icon, {{WRAPPER}} .default.social-icons-wrapper ul li, {{WRAPPER}} .social-icon-style-5.social-icons-wrapper ul li',
					'condition' => [
						'crafto_social_icon_layout_type' => [
							'default',
							'social-icon-style-3',
							'social-icon-style-5',
						],
					],
				]
			);
			$this->add_control(
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
						'{{WRAPPER}} .elementor-icon:not(.crafto-hover-effect), {{WRAPPER}} .elementor-icon .crafto-social-hover-effect, .social-icon-style-3.social-icons-wrapper ul li a.elementor-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_social_icon_layout_type' => [
							'default',
							'social-icon-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_padding',
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
						'{{WRAPPER}} .default.social-icons-wrapper ul li a.elementor-icon, {{WRAPPER}} .social-icon-style-5.social-icons-wrapper ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_social_icon_layout_type' => [
							'default',
							'social-icon-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_margin',
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
						'{{WRAPPER}} .elementor-social-icon, {{WRAPPER}} .social-icon-style-5.social-icons-wrapper ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_social_icon_layout_type!' => [
							'social-icon-style-5',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_social_style',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 6,
							'max' => 25,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-social-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .elementor-social-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_general_icon_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 150,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-social-icon' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_social_icon_layout_type!' => [
							'social-icon-style-2',
							'social-icon-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_height',
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
							'min' => 6,
							'max' => 150,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-social-icon' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_social_icon_layout_type!' => [
							'social-icon-style-2',
							'social-icon-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_spacing',
				[
					'label'     => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .default.social-icons-wrapper ul li a.elementor-icon .social-icon-text' => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .default.social-icons-wrapper ul li a.elementor-icon .social-icon-text' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_social_icon_show_text!' => '',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_social_hover',
				[
					'label' => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_hover_animation',
				[
					'label'     => esc_html__( 'Hover Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						'crafto_social_icon_layout_type!' => [
							'social-icon-style-2',
							'social-icon-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_icon_hover_opacity',
				[
					'label'       => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 1,
					],
					'range'       => [
						'px' => [
							'max' => 1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .elementor-social-icon:hover' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_hover_transform',
				[
					'label'       => esc_html__( 'Transform', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 1.3,
					],
					'range'       => [
						'px' => [
							'max'  => 2,
							'step' => 0.1,
						],
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .elementor-social-icon:hover' => '-webkit-transform: scale( {{SIZE}} ); -ms-transform: scale( {{SIZE}} ); -o-transform: scale( {{SIZE}} ); transform: scale( {{SIZE}} );',
					],
					'condition'   => [
						'crafto_hover_animation' => 'scale-effect',
					],
				]
			);

			$this->add_control(
				'crafto_icon_hover_transition',
				[
					'label'       => esc_html__( 'Transition Duration', 'crafto-addons' ),
					'type'        => Controls_Manager::SLIDER,
					'size_units'  => [
						's',
						'ms',
						'custom',
					],
					'default'     => [
						'size' => 0.3,
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
						'{{WRAPPER}} .elementor-social-icon:hover' => 'transition: all {{SIZE}}{{UNIT}}; -webkit-transition: all {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_verticalbar',
				[
					'label' => esc_html__( 'Sticky Bar', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_default_verticalbar_color',
				[
					'label'     => esc_html__( 'Default Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'header .navbar .verticalbar-wrap ul li a.elementor-social-icon i'  => 'color: {{VALUE}};',
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_verticalbar_highlight_tab'
			);
			$this->start_controls_tab(
				'crafto_verticalbar_highlight_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_verticalbar_highlight_color',
				[
					'label'       => esc_html__( 'Highlight Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => [
						'header .navbar .verticalbar-highlight ul li a.elementor-social-icon i' => 'color: {{VALUE}};',
					],
					'description' => esc_html__( 'This will be applicable in header only.', 'crafto-addons' ),
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_verticalbar_highlight_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_verticalbar_highlight_hover_color',
				[
					'label'       => esc_html__( 'Highlight Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => [
						'header .navbar .verticalbar-highlight ul li a.elementor-social-icon:hover i' => 'color: {{VALUE}};',
					],
					'description' => esc_html__( 'This will be applicable in header only.', 'crafto-addons' ),
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render social icons widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings = $this->get_settings_for_display();

			$fallback_defaults = [
				'fa fa-facebook',
				'fa fa-twitter',
				'fa fa-linkedin',
			];

			$crafto_animation_style_list = array(
				'social-icon-style-1',
				'social-icon-style-4',
			);

			$migration_allowed = Icons_Manager::is_migration_allowed();
			$this->add_render_attribute(
				[
					'wrapper' => [
						'class' => [
							$settings['crafto_social_icon_layout_type'],
							'social-icons-wrapper',
						],
					],
				]
			);
			if ( 'yes' === $settings['crafto_social_icon_item_hvr_effect'] ) {
				$this->add_render_attribute(
					'icon_class',
					'class',
					[
						'slide-on-hover',
					],
				);
			}
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<ul <?php $this->print_render_attribute_string( 'icon_class' ); ?>>
					<?php
					foreach ( $settings['crafto_social_icon_list'] as $index => $item ) {
						$social   = '';
						$migrated = isset( $item['__fa4_migrated']['crafto_social_icon'] );
						$is_new   = empty( $item['social'] ) && $migration_allowed;

						// add old default.
						if ( empty( $item['social'] ) && ! $migration_allowed ) {
							$item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
						}

						if ( ! empty( $item['social'] ) ) {
							$social = str_replace( 'fa fa-', '', $item['social'] );
						}

						if ( ( $is_new || $migrated ) && 'svg' !== $item['crafto_social_icon']['library'] ) {
							$social = explode( ' ', $item['crafto_social_icon']['value'], 2 );
							if ( empty( $social[1] ) ) {
								$social = '';
							} else {
								$social = str_replace( array( 'fa-', 'ti-' ), '', $social[1] );
							}
						}
						if ( 'svg' === $item['crafto_social_icon']['library'] ) {
							$social = '';
						}
						$social_label = ucwords( is_string( $social ) && ! empty( $social ) ? $social : 'social-icon' );
						$link_key     = 'link_' . $index;

						$this->add_render_attribute(
							$link_key,
							'class',
							[
								'elementor-icon',
								'elementor-social-icon',
								'elementor-social-icon-' . $social,
								'elementor-repeater-item-' . $item['_id'],
							],
						);

						if ( ! $this->get_render_attribute_string( $link_key ) || strpos( $this->get_render_attribute_string( $link_key ), 'aria-label=' ) === false ) {
							$this->add_render_attribute(
								$link_key,
								'aria-label',
								$social_label
							);
						}

						$this->add_render_attribute(
							$link_key,
							'href',
							( $item['crafto_link']['url'] ) ? $item['crafto_link']['url'] : '#'
						);

						if ( $item['crafto_link']['is_external'] ) {
							$this->add_render_attribute( $link_key, 'target', '_blank' );
						}

						if ( $item['crafto_link']['nofollow'] ) {
							$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
						}

						$crafto_animation_div   = '';
						$crafto_animation_class = '';

						switch ( $settings['crafto_social_icon_layout_type'] ) {
							case 'social-icon-style-1':
								if ( ! empty( $settings['crafto_hover_animation'] ) ) {
									$this->add_render_attribute( $link_key, 'class', 'hvr-' . $settings['crafto_hover_animation'] );
								}
								if ( in_array( $settings['crafto_social_icon_layout_type'], $crafto_animation_style_list, true ) ) {
									$crafto_animation_class = 'crafto-hover-effect';
									$crafto_animation_div   = '<span class="crafto-social-hover-effect"></span>';
								}
								$this->add_render_attribute( $link_key, 'class', $crafto_animation_class );
								?>
								<li>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<span class="elementor-screen-only"><?php echo esc_html( ucwords( $social ) ); ?></span>
										<?php
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $item['crafto_social_icon'] );
										} elseif ( isset( $item['crafto_social_icon']['value'] ) && ! empty( $item['crafto_social_icon']['value'] ) ) {
											?>
											<i class="<?php echo esc_attr( $item['crafto_social_icon']['value'] ); ?>"></i>
											<?php
										}
										?>
										<?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?>
									</a>
								</li>
								<?php
								break;
							case 'social-icon-style-2':
								?>
								<li>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<?php
										if ( $item['crafto_social_icon_custom_text'] ) {
											?>
											<span class="social-icon-text alt-font">
												<?php echo esc_html( $item['crafto_social_icon_custom_text'] ); ?>
											</span>
											<?php
										} else {
											?>
											<span class="social-icon-text alt-font">
												<?php echo ucwords( $social ); // phpcs:ignore ?>
											</span>
											<?php
										}

										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $item['crafto_social_icon'] );
										} elseif ( isset( $item['crafto_social_icon']['value'] ) && ! empty( $item['crafto_social_icon']['value'] ) ) {
											?>
											<i class="<?php echo esc_attr( $item['crafto_social_icon']['value'] ); ?>"></i>
											<?php
										}
										?>
									</a>
								</li>
								<?php
								break;
							case 'social-icon-style-3':
								?>
								<li>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<span class="elementor-screen-only"><?php echo esc_html( ucwords( $social ) ); ?></span>
										<?php
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $item['crafto_social_icon'] );
										} elseif ( isset( $item['crafto_social_icon']['value'] ) && ! empty( $item['crafto_social_icon']['value'] ) ) {
											?>
											<i class="<?php echo esc_attr( $item['crafto_social_icon']['value'] ); ?>"></i>
											<?php
										}
										?>
									</a>
								</li>
								<?php
								break;
							case 'social-icon-style-4':
								if ( ! empty( $settings['crafto_hover_animation'] ) ) {
									$this->add_render_attribute( $link_key, 'class', 'hvr-' . $settings['crafto_hover_animation'] );
								}
								if ( in_array( $settings['crafto_social_icon_layout_type'], $crafto_animation_style_list, true ) ) {

									$crafto_animation_class = 'crafto-hover-effect';
									$crafto_animation_div   = '<span class="crafto-social-hover-effect"></span>';
								}
								$this->add_render_attribute( $link_key, 'class', $crafto_animation_class );
								?>
								<li>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<span class="elementor-screen-only"><?php echo esc_html( ucwords( $social ) ); ?></span>
										<?php
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $item['crafto_social_icon'] );
										} elseif ( isset( $item['crafto_social_icon']['value'] ) && ! empty( $item['crafto_social_icon']['value'] ) ) {
											?>
											<i class="<?php echo esc_attr( $item['crafto_social_icon']['value'] ); ?>"></i>
											<?php
										}
										echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore 
										?>
									</a>
								</li>
								<?php
								break;
							case 'social-icon-style-5':
							default:
								if ( ! empty( $settings['crafto_hover_animation'] ) ) {
									$this->add_render_attribute( $link_key, 'class', 'hvr-' . $settings['crafto_hover_animation'] );
								}
								if ( in_array( $settings['crafto_social_icon_layout_type'], $crafto_animation_style_list, true ) ) {

									$crafto_animation_class = 'crafto-hover-effect';
									$crafto_animation_div   = '<span class="crafto-social-hover-effect"></span>';
								}
								$this->add_render_attribute( $link_key, 'class', $crafto_animation_class );
								?>
								<li>
									<a <?php $this->print_render_attribute_string( $link_key ); ?>>
										<span class="elementor-screen-only"><?php echo esc_html( ucwords( $social ) ); ?></span>
										<?php
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $item['crafto_social_icon'] );
										} elseif ( isset( $item['crafto_social_icon']['value'] ) && ! empty( $item['crafto_social_icon']['value'] ) ) {
											?>
											<i class="<?php echo esc_attr( $item['crafto_social_icon']['value'] ); ?>"></i>
											<?php
										}

										if ( 'social-icon-style-5' === $settings['crafto_social_icon_layout_type'] ) {
											$this->render_icon_text( $item, $social );
										} elseif ( 'yes' === $settings['crafto_social_icon_show_text'] ) {
												$this->render_icon_text( $item, $social );
										}
										echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore
										?>
									</a>
								</li>
								<?php
								break;
						}
					}
					?>
				</ul>
			</div>
			<?php
		}

		/**
		 *
		 * @param string $item get the custom text.
		 * @param string $social get the default text.
		 */
		public function render_icon_text( $item, $social ) {
			if ( isset( $item['crafto_social_icon_custom_text'] ) && ! empty( $item['crafto_social_icon_custom_text'] ) ) {
				?>
				<span class="social-icon-text alt-font">
					<?php echo esc_html( $item['crafto_social_icon_custom_text'] ); ?>
				</span>
				<?php
			} else {
				?>
				<span class="social-icon-text alt-font">
					<?php echo ucwords( $social ); // phpcs:ignore ?>
				</span>
				<?php
			}
		}
	}
}
