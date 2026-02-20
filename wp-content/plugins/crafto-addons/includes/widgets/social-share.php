<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for Social Share.
 *
 * @package Crafto
 */

// If class `Social_Share` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Social_Share' ) ) {
	class Social_Share extends Widget_Base {
		/**
		 * Retrieve the list of styles the social share widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$social_share_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$social_share_styles[] = 'crafto-widgets-rtl';
				} else {
					$social_share_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$social_share_styles[] = 'crafto-social-share-rtl';
				}
				$social_share_styles[] = 'crafto-social-share';
			}
			return $social_share_styles;
		}
		/**
		 * Get widget name.
		 *
		 * Retrieve Crafto social share widget name.
		 *
		 * @return string Widget name.
		 * @since 1.0.0
		 * @access public
		 */
		public function get_name() {
			return 'crafto-social-share';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve Crafto social share widget title.
		 *
		 * @return string Widget title.
		 * @since 1.0.0
		 * @access public
		 */
		public function get_title() {
			return esc_html__( 'Crafto Social Share', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve Crafto social share widget icon.
		 *
		 * @return string Widget icon.
		 * @since 1.0.0
		 * @access public
		 */
		public function get_icon() {
			return 'eicon-share crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/crafto-social-share/';
		}
		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the Crafto social share widget belongs to.
		 *
		 * Used to determine where to display the widget in the editor.
		 *
		 * @return array Widget categories.
		 * @since 1.0.0
		 * @access public
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
		 * @return array Widget keywords.
		 * @since 1.0.0
		 * @access public
		 */
		public function get_keywords() {
			return [
				'media',
				'marketing',
				'network',
			];
		}

		/**
		 * Register widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'Crafto',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'social_share_layout_type',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'social-share-default',
					'options' => [
						'social-share-default' => esc_html__( 'Style 1', 'crafto-addons' ),
						'social-share-style-1' => esc_html__( 'Style 2', 'crafto-addons' ),
						'social-share-style-2' => esc_html__( 'Style 3', 'crafto-addons' ),
						'social-share-style-3' => esc_html__( 'Style 4', 'crafto-addons' ),
						'social-share-style-4' => esc_html__( 'Style 5', 'crafto-addons' ),
						'social-share-style-5' => esc_html__( 'Style 6', 'crafto-addons' ),
					],
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_social_share_network',
				[
					'label'       => esc_html__( 'Network', 'crafto-addons' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => false,
					'default'     => 'facebook',
					'options'     => [
						'facebook'    => esc_html__( 'Facebook', 'crafto-addons' ),
						'twitter'     => esc_html__( 'Twitter', 'crafto-addons' ),
						'linkedin'    => esc_html__( 'Linkedin', 'crafto-addons' ),
						'pinterest'   => esc_html__( 'Pinterest', 'crafto-addons' ),
						'reddit'      => esc_html__( 'Reddit', 'crafto-addons' ),
						'stumbleupon' => esc_html__( 'StumbleUpon', 'crafto-addons' ),
						'digg'        => esc_html__( 'Digg', 'crafto-addons' ),
						'dribbble'    => esc_html__( 'Dribbble', 'crafto-addons' ),
						'behance'     => esc_html__( 'Behance', 'crafto-addons' ),
						'vk'          => esc_html__( 'VK', 'crafto-addons' ),
						'xing'        => esc_html__( 'XING', 'crafto-addons' ),
						'telegram'    => esc_html__( 'Telegram', 'crafto-addons' ),
						'ok'          => esc_html__( 'Ok', 'crafto-addons' ),
						'viber'       => esc_html__( 'Viber', 'crafto-addons' ),
						'whatsapp'    => esc_html__( 'WhatsApp', 'crafto-addons' ),
					],
				]
			);
			$repeater->add_control(
				'crafto_social_share_custom_text',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => '',
					'description' => esc_html__( 'Applicable in style 3 & 6 only.', 'crafto-addons' ),
				]
			);
			$repeater->start_controls_tabs( 'crafto_social_icon_tabs' );
			$repeater->start_controls_tab(
				'crafto_social_share_icon_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_social_share_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper {{CURRENT_ITEM}}.social-sharing-icon i, {{WRAPPER}} .social-share-wrapper {{CURRENT_ITEM}}.social-sharing-icon .social-icon-text' => 'color: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_social_share_icon_bgcolor',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper {{CURRENT_ITEM}}.social-sharing-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_social_share_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper li {{CURRENT_ITEM}}.social-sharing-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'crafto_social_share_icon_tab_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_hover_social_share_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper {{CURRENT_ITEM}}.social-sharing-icon:hover i, {{WRAPPER}} .social-share-wrapper {{CURRENT_ITEM}}.social-sharing-icon:hover .social-icon-text' => 'color: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_hover_social_share_icon_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper.social-share-default {{CURRENT_ITEM}}.social-sharing-icon:hover, {{WRAPPER}} .social-share-wrapper.social-share-style-1 {{CURRENT_ITEM}}.social-sharing-icon:hover .social-share-hover-effect, {{WRAPPER}} .social-share-wrapper.social-share-style-2 {{CURRENT_ITEM}}.social-sharing-icon:hover, {{WRAPPER}} .social-share-wrapper.social-share-style-3 {{CURRENT_ITEM}}.social-sharing-icon:hover:after, {{WRAPPER}} .social-share-wrapper.social-share-style-4 {{CURRENT_ITEM}}.social-sharing-icon span, {{WRAPPER}} .social-share-wrapper.social-share-style-5 {{CURRENT_ITEM}}.social-sharing-icon:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$repeater->add_control(
				'crafto_hover_social_share_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper li {{CURRENT_ITEM}}.social-sharing-icon:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			$repeater->end_controls_tabs();

			$this->add_control(
				'crafto_social_share_item',
				[
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'title_field' => '{{ crafto_social_share_network }}',
					'show_label'  => false,
					'default'     => [
						[
							'crafto_social_share_network' => 'facebook',
						],
						[
							'crafto_social_share_network' => 'twitter',
						],
						[
							'crafto_social_share_network' => 'linkedin',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'section_social_share_settings',
				[
					'label' => esc_html__( 'Settings', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_social_share_show_text',
				[
					'label'        => esc_html__( 'Enable Label', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'condition'    => [
						'social_share_layout_type' => [
							'social-share-default',
						],
					],
				]
			);
			$this->add_control(
				'crafto_share_buttons_list_view',
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
				]
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
					'name'      => 'crafto_social_share_text_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector'  => '{{WRAPPER}} .social-sharing-icon .social-icon-text',
					'condition' => [
						'social_share_layout_type!' => [
							'social-share-style-1',
							'social-share-style-3',
							'social-share-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_social_share_align',
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
					'toggle'               => false,
					'default'              => 'left',
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end' : 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_share_buttons_list_view' => 'horizontal',
						'social_share_layout_type!'      => 'social-share-style-5',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_social_share_alignment',
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
						'{{WRAPPER}} .social-share-wrapper' => 'display: flex; justify-content: {{VALUE}};',
						'{{WRAPPER}}.elementor-icon-view-vertical .social-share-wrapper ul li' => 'text-align: {{VALUE}};',
					],
					'condition'   => [
						'crafto_share_buttons_list_view' => 'vertical',
						'social_share_layout_type!'      => 'social-share-style-5',
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
						'right' => is_rtl() ? 'end'   : 'right',
					],
					'selectors' => [
						'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					],
					'condition' => [
						'social_share_layout_type' => 'social-share-style-5',
					],
				]
			);
			$this->start_controls_tabs( 'crafto_social_share' );
			$this->start_controls_tab(
				'crafto_social_share_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_social_share_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper ul li a i, {{WRAPPER}} .social-share-wrapper .social-icon-text' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_social_share_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper .social-sharing-icon' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'social_share_layout_type' => [
							'social-share-style-3',
						],
					],
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_social_share_list_active',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_social_share_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper .social-sharing-icon:hover i, {{WRAPPER}} .social-share-wrapper .social-sharing-icon:hover .social-icon-text' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_social_share_hover_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-share-wrapper.social-share-default .social-sharing-icon:hover, {{WRAPPER}} .social-share-wrapper.social-share-style-1 .social-sharing-icon:hover .social-share-hover-effect, {{WRAPPER}} .social-share-wrapper.social-share-style-2 .social-sharing-icon:hover,{{WRAPPER}} .social-share-wrapper.social-share-style-3 .social-sharing-icon:hover:after, {{WRAPPER}} .social-share-wrapper.social-share-style-4 .social-sharing-icon span' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'social_share_layout_type!' => [
							'social-share-default',
							'social-share-style-2',
							'social-share-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'social_share_box_shadow',
					'selector'  => '{{WRAPPER}} .social-share-wrapper ul li a:hover',
					'condition' => [
						'social_share_layout_type' => [
							'social-share-default',
							'social-share-style-3',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'social_icon_border',
					'selector'  => '{{WRAPPER}} .social-share-default.social-share-wrapper ul li a.social-sharing-icon, {{WRAPPER}} .social-share-style-3.social-share-wrapper ul li a.social-sharing-icon, {{WRAPPER}} .social-share-style-5.social-share-wrapper ul li',
					'condition' => [
						'social_share_layout_type' => [
							'social-share-default',
							'social-share-style-3',
							'social-share-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_social_share_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .social-share-wrapper  li a.social-sharing-icon, .social-share-style-3.social-share-wrapper ul li a.social-sharing-icon:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'social_share_layout_type' => [
							'social-share-default',
							'social-share-style-3',
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
						'{{WRAPPER}} .social-share-default.social-share-wrapper ul li a.social-sharing-icon, {{WRAPPER}} .social-share-style-5.social-share-wrapper ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'social_share_layout_type' => [
							'social-share-default',
							'social-share-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_social_share_share_margin',
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
						'{{WRAPPER}} .social-share-wrapper ul li a.social-sharing-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'social_share_layout_type!' => [
							'social-share-style-5',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_social_icon_style',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_social_share_icon_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 25,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .social-share-wrapper ul li a.social-sharing-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_social_share_icon_width',
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
							'min' => 6,
							'max' => 100,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .social-sharing-icon' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'social_share_layout_type!' => [
							'social-share-style-2',
							'social-share-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_social_share_icon_height',
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
							'max' => 300,
						],
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
					],
					'default'    => [
						'unit' => 'px',
					],
					'selectors'  => [
						'{{WRAPPER}} .social-sharing-icon' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'social_share_layout_type!' => [
							'social-share-style-2',
							'social-share-style-5',
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
						'{{WRAPPER}} .social-share-wrapper li:not(:last-child) .social-sharing-icon i' => 'margin-left: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .social-share-wrapper li .social-sharing-icon i' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'crafto_social_share_show_text!' => '',
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
				'crafto_icon_hover_animation',
				[
					'label'     => esc_html__( 'Hover Animation', 'crafto-addons' ),
					'type'      => Controls_Manager::HOVER_ANIMATION,
					'condition' => [
						'social_share_layout_type!' => [
							'social-share-style-2',
							'social-share-style-3',
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
						'{{WRAPPER}} .social-sharing-icon:hover' => 'opacity: {{SIZE}};',
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
						'{{WRAPPER}} .social-sharing-icon:hover' => '-webkit-transform: scale( {{SIZE}} ); -ms-transform: scale( {{SIZE}} ); -o-transform: scale( {{SIZE}} ); transform: scale( {{SIZE}} );',
					],
					'condition'   => [
						'crafto_icon_hover_animation' => 'scale-effect',
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
						'{{WRAPPER}} .social-sharing-icon:hover' => 'transition: all {{SIZE}}{{UNIT}}; -webkit-transition: all {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_social_share_style_verticalbar',
				[
					'label' => esc_html__( 'Sticky Bar', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->start_controls_tabs( 'crafto_verticalbar_social_share' );
			$this->start_controls_tab(
				'crafto_verticalbar_social_share_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_social_share_verticalbar_highlight_color',
				[
					'label'       => esc_html__( 'Highlight Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => [
						'.verticalbar-wrap.verticalbar-highlight ul li a.social-sharing-icon i, .verticalbar-wrap.verticalbar-highlight .social-share-wrapper .social-icon-text' => 'color: {{VALUE}} !important;',
					],
					'description' => esc_html__( 'This will be applicable in header only.', 'crafto-addons' ),
				]
			);
			$this->end_controls_tab();

			$this->start_controls_tab(
				'crafto_verticalbar_social_share_list_active',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_social_share_verticalbar_highlight_hover_color',
				[
					'label'     => esc_html__( 'Highlight Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'.verticalbar-wrap.verticalbar-highlight ul li a.social-sharing-icon:hover i, .verticalbar-wrap.verticalbar-highlight .social-share-wrapper .social-sharing-icon:hover .social-icon-text' => 'color: {{VALUE}} !important;',
					],
				]
			);
			$this->add_control(
				'crafto_verticalbar_social_share_hover_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'.verticalbar-wrap.verticalbar-highlight .social-share-wrapper.social-share-default .social-sharing-icon:hover, .verticalbar-wrap.verticalbar-highlight .social-share-wrapper.social-share-style-1 .social-sharing-icon:hover .social-share-hover-effect, .verticalbar-wrap.verticalbar-highlight .social-share-wrapper.social-share-style-2 .social-sharing-icon:hover, .verticalbar-wrap.verticalbar-highlight .social-share-wrapper.social-share-style-3 .social-sharing-icon:hover:after, .verticalbar-wrap.verticalbar-highlight .social-share-wrapper.social-share-style-4 .social-sharing-icon span' => 'background-color: {{VALUE}}; !important;',
					],
				]
			);
			$this->add_control(
				'crafto_verticalbar_social_icon_border_hover',
				[
					'label'       => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'        => Controls_Manager::COLOR,
					'selectors'   => [
						'.verticalbar-wrap.verticalbar-highlight .social-share-wrapper ul li a.social-sharing-icon:hover' => 'border-color: {{VALUE}}; !important;',
					],
					'description' => esc_html__( 'This will be applicable in header only.', 'crafto-addons' ),
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
		}

		/**
		 * Render Crafto Social Share output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function render() {
			$settings     = $this->get_settings_for_display();
			$social_icons = $settings['crafto_social_share_item'];

			$this->add_render_attribute(
				'icon_position',
				'class',
				[
					'social-share-wrapper',
					$settings['social_share_layout_type'],
				]
			);

			$crafto_animation_div        = '';
			$crafto_animation_class      = '';
			$crafto_animation_style_list = array(
				'social-share-default',
				'social-share-style-1',
				'social-share-style-4',
			);
			if ( in_array( $settings['social_share_layout_type'], $crafto_animation_style_list, true ) ) {
				$crafto_animation_class = 'crafto-hover-effect';
				$crafto_animation_div   = '<span class="social-share-hover-effect"></span>';
			}

			$crafto_text_style_list = array(
				'social-share-style-2',
			);

			$crafto_text_view_style_list = array(
				'social-share-default',
				'social-share-style-5',
			);
			?>
			<div <?php $this->print_render_attribute_string( 'icon_position' ); ?>>
				<ul <?php $this->print_render_attribute_string( 'icon_class' ); ?>>
					<?php
					global $post;
					foreach ( $social_icons as $index => $icon ) :

						$link_key          = 'link_' . $index;
						$social_media_name = $icon['crafto_social_share_network'];

						$this->add_render_attribute(
							$link_key,
							'class',
							[
								'social-sharing-icon',
								'elementor-repeater-item-' . $icon['_id'],
								$social_media_name,
								$crafto_animation_class,
							]
						);
						$crafto_text_div = '';
						if ( in_array( $settings['social_share_layout_type'], $crafto_text_style_list, true ) ) {

							if ( $icon['crafto_social_share_custom_text'] ) {
								$crafto_text_div = '<span class="social-icon-text alt-font">' . ucwords( $icon['crafto_social_share_custom_text'] ) . '</span>';
							} else {
								$crafto_text_div = '<span class="social-icon-text alt-font">' . ucwords( $social_media_name ) . '</span>';
							}
						}
						$crafto_text_view_div = '';
						if ( in_array( $settings['social_share_layout_type'], $crafto_text_view_style_list, true ) ) {
							if ( 'social-share-default' === $settings['social_share_layout_type'] ) {
								if ( 'yes' === $settings['crafto_social_share_show_text'] ) {
									if ( $icon['crafto_social_share_custom_text'] ) {
										$crafto_text_view_div = '<span class="social-icon-text alt-font">' . ucwords( $icon['crafto_social_share_custom_text'] ) . '</span>';
									} else {
										$crafto_text_view_div = '<span class="social-icon-text alt-font">' . ucwords( $social_media_name ) . '</span>';
									}
								}
							} elseif ( $icon['crafto_social_share_custom_text'] ) {
									$crafto_text_view_div = '<span class="social-icon-text alt-font">' . ucwords( $icon['crafto_social_share_custom_text'] ) . '</span>';
							} else {
								$crafto_text_view_div = '<span class="social-icon-text alt-font">' . ucwords( $social_media_name ) . '</span>';
							}
						}
						if ( ! empty( $settings['crafto_icon_hover_animation'] ) ) {
							$this->add_render_attribute( $link_key, 'class', 'hvr-' . $settings['crafto_icon_hover_animation'] );
						}
						$permalink  = (string) get_permalink( $post->ID );
						$post_title = rawurlencode( get_the_title( $post->ID ) );
						switch ( $social_media_name ) {
							case 'facebook':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//www.facebook.com/sharer.php?u=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-facebook-f"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'twitter':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//twitter.com/share?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;"  rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fab fa-x-twitter"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'linkedin':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" target="_blank" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;"  rel="nofollow" title="<?php echo esc_attr( $post_title ); ?>"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-linkedin-in"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'pinterest':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//pinterest.com/pin/create/button/?url=<?php echo esc_url( $permalink ); ?>&amp;description=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="nofollow" target="_blank" title="<?php echo esc_attr( $post_title ); ?>"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-pinterest-p"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'reddit':
								?>
								<li><a  href="//reddit.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-reddit"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'stumbleupon':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="http://www.stumbleupon.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-stumbleupon"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'digg':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//www.digg.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-digg"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'dribbble':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//www.dribbble.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-dribbble"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?><span class="screen-reader-text"><?php echo esc_html__( 'Share the Post', 'crafto-addons' ); ?></span></a></li>
								<?php
								break;
							case 'behance':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//www.behance.com/submit?url=<?php echo esc_url( $permalink ); ?>&amp;title=<?php echo esc_attr( $post_title ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-behance"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?><span class="screen-reader-text"><?php echo esc_html__( 'Share the Post', 'crafto-addons' ); ?></span></a></li>
								<?php
								break;
							case 'vk':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//vk.com/share.php?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-vk"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'xing':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//www.xing.com/app/user?op=share&url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-xing"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'telegram':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//t.me/share/url?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-telegram-plane"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'ok':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//connect.ok.ru/offer?url=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-odnoklassniki"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'viber':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//viber://forward?text=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-viber"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
							case 'whatsapp':
								?>
								<li><a <?php $this->print_render_attribute_string( $link_key ); ?> href="//api.whatsapp.com/send?text=<?php echo esc_url( $permalink ); ?>" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" data-pin-custom="true"><?php echo sprintf( '%s', $crafto_text_div ); // phpcs:ignore ?><i class="fa-brands fa-whatsapp"></i><?php echo sprintf( '%s', $crafto_text_view_div ); // phpcs:ignore ?><?php echo sprintf( '%s', $crafto_animation_div ); // phpcs:ignore ?></a></li>
								<?php
								break;
						}
						endforeach;
					?>
				</ul>
			</div>
			<?php
		}
	}
}
