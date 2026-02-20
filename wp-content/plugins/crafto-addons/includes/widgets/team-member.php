<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for team member.
 *
 * @package Crafto
 */

// If class `Team_Member` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Team_Member' ) ) {
	/**
	 * Define `Team_Member` class.
	 */
	class Team_Member extends Widget_Base {
		/**
		 * Retrieve the list of scripts the team member widget depended on.
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
				return [ 'crafto-team-member-widget' ];
			}
		}

		/**
		 * Retrieve the list of styles the team member widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$team_member_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$team_member_styles[] = 'crafto-widgets-rtl';
				} else {
					$team_member_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$team_member_styles[] = 'crafto-star-rating-rtl';
					$team_member_styles[] = 'crafto-team-member-rtl-widget';
				}
				$team_member_styles[] = 'crafto-star-rating';
				$team_member_styles[] = 'crafto-team-member-widget';
			}
			return $team_member_styles;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve team member widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-team-member';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve team member widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Team Member', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve team member widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-person crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/team-member/';
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
				'staff',
				'profile',
				'employee',
				'about us',
				'our team',
				'team section',
				'person',
				'team showcase',
				'bio',
				'block',
				'grid',
				'layout',
				'card',
			];
		}

		/**
		 * Register team member widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_team_member_section_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'team-style-1',
					'options' => [
						'team-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'team-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'team-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'team-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
						'team-style-5' => esc_html__( 'Style 5', 'crafto-addons' ),
						'team-style-6' => esc_html__( 'Style 6', 'crafto-addons' ),
						'team-style-7' => esc_html__( 'Style 7', 'crafto-addons' ),
						'team-style-8' => esc_html__( 'Style 8', 'crafto-addons' ),
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_team_member_tabs',
			);
			$this->start_controls_tab(
				'crafto_team_member_content_tab',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_image',
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
			$this->add_control(
				'crafto_team_member_hover_image',
				[
					'label'     => esc_html__( 'Hover Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_team_member_style' => 'team-style-6',
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
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_image_position',
				[
					'label'        => esc_html__( 'Image Position', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'left'  => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'top'   => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'prefix_class' => 'elementor%s-position-',
					'condition'    => [
						'crafto_team_member_style' => [
							'team-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_team_member_full_name',
				[
					'label'   => esc_html__( 'Name', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Patrick Smith', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_title_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_position',
				[
					'label'   => esc_html__( 'Position', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Executive Chef', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_description',
				[
					'label'     => esc_html__( 'Description', 'crafto-addons' ),
					'type'      => Controls_Manager::WYSIWYG,
					'dynamic'   => [
						'active' => true,
					],
					'condition' => [
						'crafto_team_member_style!' => [
							'team-style-4',
							'team-style-6',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_team_member_social_tab',
				[
					'label' => esc_html__( 'Social', 'crafto-addons' ),
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_team_member_social_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
					'default'          => [
						'value'   => 'fab fa-facebook-f',
						'library' => 'fa-brands',
					],
				]
			);
			$repeater->add_control(
				'crafto_team_member_social_label',
				[
					'label'   => esc_html__( 'Label', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Label', 'crafto-addons' ),
				]
			);
			$repeater->add_control(
				'crafto_team_member_label_visible',
				[
					'label'        => esc_html__( 'Enable Lable?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$repeater->add_control(
				'crafto_team_member_social_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'label_block' => true,
					'dynamic'     => [
						'active' => true,
					],
					'default'     => [
						'url' => '#',
					],
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
				'crafto_item_icon_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-social-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$repeater->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_item_icon_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon i, {{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon svg, {{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon .team-member-socials-label',
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
				'crafto_hover_item_icon_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icons-wrapper {{CURRENT_ITEM}}.elementor-social-icon:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$repeater->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_hover_icon_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Icon Color', 'crafto-addons' ),
						],
					],
					'selector'       => '{{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon:hover i, {{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon:hover svg, {{WRAPPER}} {{CURRENT_ITEM}}.elementor-social-icon:hover .team-member-socials-label',
				]
			);
			$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'crafto_team_member_social_icon_items',
				[
					'label'       => esc_html__( 'Social Icon', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'show_label'  => false,
					'default'     => [
						[
							'crafto_team_member_social_icon'   => [
								'value'   => 'fab fa-facebook-f',
								'library' => 'fa-brands',
							],
							'crafto_team_member_social_label' => esc_html__( 'Facebook', 'crafto-addons' ),
							'crafto_team_member_social_link'  => [
								'default' => [
									'url' => '#',
								],
							],
							'crafto_team_member_label_visible' => 'false',
						],
						[
							'crafto_team_member_social_icon'   => [
								'value'   => 'fab fa-instagram',
								'library' => 'fa-brands',
							],
							'crafto_team_member_social_label'  => esc_html__( 'Instagram', 'crafto-addons' ),
							'crafto_team_member_social_link'  => [
								'default' => [
									'url' => '#',
								],
							],
							'crafto_team_member_label_visible' => 'false',
						],
						[
							'crafto_team_member_social_icon'   => [
								'value'   => 'fab fa-x-twitter',
								'library' => 'fa-brands',
							],
							'crafto_team_member_social_label'  => esc_html__( 'Twitter', 'crafto-addons' ),
							'crafto_team_member_social_link'  => [
								'default' => [
									'url' => '#',
								],
							],
							'crafto_team_member_label_visible' => 'false',
						],
					],
					'title_field' => '{{{ crafto_team_member_social_label }}}',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_team_member_icon_image_section',
				[
					'label'     => esc_html__( 'Review', 'crafto-addons' ),
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-3',
							'team-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_team_member_icon_number',
				[
					'label'   => esc_html__( 'Number', 'crafto-addons' ),
					'type'    => Controls_Manager::NUMBER,
					'dynamic' => [
						'active' => true,
					],
				]
			);
			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'fas fa-star',
						'library' => 'fa-solid',
					],
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_team_member_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_align',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'options'              => [
						'left'    => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'  => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-center',
						],
						'right'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-right',
						],
						'justify' => [
							'title' => esc_html__( 'Justified', 'crafto-addons' ),
							'icon'  => 'eicon-text-align-justify',
						],
					],
					'default'              => '',
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end' : 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .team-member'         => 'text-align: {{VALUE}};',
						'{{WRAPPER}} .team-member-overlay' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_team_member_style!' => [
							'team-style-6',
						],
					],
				],
			);
			$this->add_responsive_control(
				'crafto_team_member_vertical_position',
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
							'title' => esc_html__( 'Middle', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .team-member' => 'display: flex; justify-content: {{VALUE}};',
						'{{WRAPPER}} .team-style-3 > figcaption' => 'display: flex; justify-content: {{VALUE}};',
						'{{WRAPPER}} .team-style-2 .team-member-overlay' => 'display: flex; justify-content: {{VALUE}};',
						'{{WRAPPER}} .team-style-7 .team-member-overlay' => 'display: flex; justify-content: {{VALUE}};',
					],
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-7',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_horizontal_position',
				[
					'label'     => esc_html__( 'Horizontal Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
						'flex-start' => [
							'title' => esc_html__( 'Left', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-left',
						],
						'center'     => [
							'title' => esc_html__( 'Center', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-center',
						],
						'flex-end'   => [
							'title' => esc_html__( 'Right', 'crafto-addons' ),
							'icon'  => 'eicon-h-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .team-style-1 .team-member-overlay' => 'display: flex; align-items: {{VALUE}};',
						'{{WRAPPER}} .team-style-3 >figcaption' => 'display: flex; align-items: {{VALUE}};',
						'{{WRAPPER}} .team-style-2 .team-member-overlay' => 'display: flex; align-items: {{VALUE}};',
						'{{WRAPPER}} .team-style-2 >figcaption' => 'display: flex; align-items: {{VALUE}};',
						'{{WRAPPER}} .team-style-7 .team-member-overlay' => 'display: flex; align-items: {{VALUE}};',
						'{{WRAPPER}} .team-style-8 figcaption' => 'display: flex; align-items: {{VALUE}};',
					],
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-3',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_team_member_image_box_shadow',
					'exclude'   => [
						'box_shadow_position',
					],
					'selector'  => '{{WRAPPER}} .team-member',
					'condition' => [
						'crafto_team_member_style!' => [
							'team-style-2',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-1',
							'team-style-3',
							'team-style-4',
							'team-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_team_member_image_figcaption_heading_divider',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_team_member_style!' => [
							'team-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_team_member_image_figcaption_heading_title',
				[
					'label'     => esc_html__( 'Content Box', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_team_member_style!' => [
							'team-style-4',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_team_member_figcaption_style'
			);
			$this->start_controls_tab(
				'crafto_content_block_figcaption_normal_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_team_member_image_figcaption_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .team-member figcaption, .team-style-5',
					'condition' => [
						'crafto_team_member_style!' => [
							'team-style-2',
							'team-style-4',
							'team-style-6',
							'team-style-7',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_team_member_image_figcaption_bg',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .team-style-6 .team-member-content, {{WRAPPER}} .team-style-8 figcaption',
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-6',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_team_member_figcaption_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_team_member_image_figcaption_hover_bg',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .team-member:hover figcaption',
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-1',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_team_figcaption_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-style-8 figcaption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_image_figcaption_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member figcaption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style!' => [
							'team-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_image_figcaption_paddings',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-style-6 .team-member-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-6',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_team_member_image_style',
				[
					'label'      => esc_html__( 'Image', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_team_member_style!' => [
							'team-style-1',
							'team-style-5',
							'team-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_image_display',
				[
					'label'     => esc_html__( 'Display', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						''             => esc_html__( 'Default', 'crafto-addons' ),
						'block'        => esc_html__( 'Block', 'crafto-addons' ),
						'inline'       => esc_html__( 'Inline', 'crafto-addons' ),
						'inline-block' => esc_html__( 'Inline Block', 'crafto-addons' ),
						'none'         => esc_html__( 'None', 'crafto-addons' ),
					],
					'selectors' => [
						'{{WRAPPER}} .team-style-2 .team-member-image img' => 'display: {{VALUE}}',
						'{{WRAPPER}} .team-style-7 .team-member-image img' => 'display: {{VALUE}}',
						'{{WRAPPER}} .team-style-8 .team-member-image img' => 'display: {{VALUE}}',
					],
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_team_member_custom_image_size',
				[
					'label'        => esc_html__( 'Enable Custom Image Size', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_team_member_style!' => [
							'team-style-2',
							'team-style-4',
							'team-style-5',
							'team-style-6',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_image_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'em',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 800,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member-image .inner-team-img img, {{WRAPPER}} .team-style-5 .team-image img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_team_member_custom_image_size' => 'yes',
						'crafto_team_member_style!' => [
							'team-style-2',
							'team-style-5',
							'team-style-6',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_image_height',
				[
					'label'      => esc_html__( 'Height', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'em',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 800,
						],
						'%'  => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member-image .inner-team-img img, {{WRAPPER}} .team-style-5 .team-image img' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_custom_image_size' => 'yes',
						'crafto_team_member_style!' => [
							'team-style-2',
							'team-style-5',
							'team-style-6',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_team_member_image_border',
					'selector'  => '{{WRAPPER}} .team-member:not(.team-style-2) .team-member-image img, {{WRAPPER}} .team-style-2 .team-member-image',
					'condition' => [
						'crafto_team_member_style!' => [
							'team-style-1',
							'team-style-4',
							'team-style-5',
							'team-style-6',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_team_member_image_style'
			);
			$this->start_controls_tab(
				'crafto_team_member_image_normal_style',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-4',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'      => 'crafto_image_css_normal_filters',
					'selector'  => '{{WRAPPER}} .team-style-2 .team-member-image img, {{WRAPPER}} .team-style-4 .team-member-image img, {{WRAPPER}} .team-style-7 .team-member-image img, {{WRAPPER}} .team-style-8 .team-member-image img',
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-4',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_team_member_image_hover_style',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-4',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name'      => 'crafto_image_css_filters',
					'selector'  => '{{WRAPPER}} .team-style-2:hover .team-member-image img, {{WRAPPER}} .team-style-4:hover .team-member-image img, {{WRAPPER}} .team-style-7:hover .team-member-image img, {{WRAPPER}} .team-style-8:hover .team-member-image img',
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-4',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_responsive_control(
				'crafto_team_member_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member-image img, .team-style-5 .team-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .team-member-image .team-member-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						'{{WRAPPER}} .team-style-8 .team-member-overlay' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style!' => [
							'team-style-1',
							'team-style-4',
							'team-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_image_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-3',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_team_member_name_style',
				[
					'label'      => esc_html__( 'Name', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_team_member_name_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .team-member .team-member-name',
				]
			);
			$this->start_controls_tabs(
				'crafto_team_member_title_style'
			);
			$this->start_controls_tab(
				'crafto_content_block_title_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_name_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member .team-member-name' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_team_member_title_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_name_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member .title-link:hover .team-member-name' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_name_box_hover_color',
				[
					'label'     => esc_html__( 'Item Hover Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member:hover .team-member-name, {{WRAPPER}} .team-member:hover .title-link .team-member-name' => 'color: {{VALUE}};',
					],
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-1',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_team_member_name_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'separator'  => 'before',
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member .team-member-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_team_member_designation_style',
				[
					'label'      => esc_html__( 'Position', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_team_member_designation_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .team-member .team-member-designation',
				]
			);
			$this->add_control(
				'crafto_team_member_designation_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member .team-member-designation' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_designation_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member .team-member-designation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_team_member_description_style',
				[
					'label'      => esc_html__( 'Description', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_team_member_style!' => [
							'team-style-4',
							'team-style-6',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_team_member_description_typography',
					'selector' => '{{WRAPPER}} .team-member .team-member-description',
				]
			);
			$this->add_control(
				'crafto_team_member_description_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member .team-member-description' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_description_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'%'  => [
							'min' => 1,
							'max' => 100,
						],
						'px' => [
							'min' => 1,
							'max' => 100,
						],
					],
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member .team-member-description' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_description_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member .team-member-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_description_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member .team-member-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_anchor_tag_title',
				[
					'label'     => esc_html__( 'Link', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_team_member_anchor_tag_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .team-member-description a',
				]
			);
			$this->start_controls_tabs(
				'crafto_team_member_anchor_tabs',
			);
			$this->start_controls_tab(
				'crafto_team_member_anchor_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_team_member_anchor_tag_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member-description a' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_team_member_anchor_tag_border',
					'selector' => '{{WRAPPER}} .team-member-description a',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_team_member_anchor_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_anchor_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member-description a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_anchor_border_hover_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member-description a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_team_member_social_style',
				[
					'label'      => esc_html__( 'Social', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_team_member_social_items_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .social-icon > a > .team-member-socials-label',
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_social_icon_font_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 10,
							'max' => 50,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .social-icon > a > i, {{WRAPPER}} .social-icon > a > svg' => 'font-size: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_social_icon_width',
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
							'max' => 80,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .social-icon a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_social_items_spacing',
				[
					'label'      => esc_html__( 'Spacer', 'crafto-addons' ),
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
					'default'    => [
						'unit' => 'px',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member:not(.team-style-4, .team-style-6) .social-icon a:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .team-member.team-style-4 .social-icon a:not(:last-child), {{WRAPPER}} .team-member.team-style-6 .social-icon a:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .team-member:not(.team-style-4, .team-style-6) .social-icon a:not(:last-child)' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_social_items_bottom_spacer',
				[
					'label'      => esc_html__( 'Bottom Spacer', 'crafto-addons' ),
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
					'default'    => [
						'unit' => 'px',
						'size' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member.team-style-2 .social-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .team-member.team-style-7 .social-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .team-member.team-style-8 .social-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_team_member_social_icon_tabs',
			);
			$this->start_controls_tab(
				'crafto_team_member_social_icon_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				],
			);
			$this->add_control(
				'crafto_team_member_social_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icon > a > i, {{WRAPPER}} .social-icon > a > .team-member-socials-label' => 'color: {{VALUE}};',
						'{{WRAPPER}} .social-icon > a > svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_social_icon_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icon > a' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_team_member_social_icon_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_team_member_social_icon_hover_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icon > a:hover i, {{WRAPPER}} .social-icon > a:hover .team-member-socials-label' => 'color: {{VALUE}};',
						'{{WRAPPER}} .social-icon > a:hover > svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_social_icon_hover_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .social-icon > a:hover' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_social_icon_hover_transition',
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
						'{{WRAPPER}} .social-icon > a:hover' => 'transition: all {{SIZE}}{{UNIT}}; -webkit-transition: all {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_team_member_social_icon_border',
					'selector'  => '{{WRAPPER}} .social-icon > a',
					'separator' => 'before',
				]
			);
			$this->add_control(
				'crafto_team_member_social_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .social-icon > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_separator',
				[
					'label'      => esc_html__( 'Sparator', 'crafto-addons' ),
					'type'       => Controls_Manager::HEADING,
					'separator'  => 'before',
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_team_member_style',
										'operator' => '===',
										'value'    => 'team-style-3',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_team_member_style',
										'operator' => '===',
										'value'    => 'team-style-5',
									],
									[
										'name'     => 'crafto_team_member_image_position',
										'operator' => '===',
										'value'    => 'left',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_team_member_style',
										'operator' => '===',
										'value'    => 'team-style-5',
									],
									[
										'name'     => 'crafto_team_member_image_position',
										'operator' => '===',
										'value'    => 'right',
									],
								],
							],
						],
					],
				]
			);
			$this->add_control(
				'crafto_social_border',
				[
					'label'      => esc_html__( 'Color', 'crafto-addons' ),
					'type'       => Controls_Manager::COLOR,
					'selectors'  => [
						'{{WRAPPER}} .social-icon' => 'border-color: {{VALUE}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'terms' => [
									[
										'name'     => 'crafto_team_member_style',
										'operator' => '===',
										'value'    => 'team-style-3',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_team_member_style',
										'operator' => '===',
										'value'    => 'team-style-5',
									],
									[
										'name'     => 'crafto_team_member_image_position',
										'operator' => '===',
										'value'    => 'left',
									],
								],
							],
							[
								'relation' => 'and',
								'terms'    => [
									[
										'name'     => 'crafto_team_member_style',
										'operator' => '===',
										'value'    => 'team-style-5',
									],
									[
										'name'     => 'crafto_team_member_image_position',
										'operator' => '===',
										'value'    => 'right',
									],
								],
							],
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_team_member_overlay_style',
				[
					'label'      => esc_html__( 'Overlay', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-4',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_team_member_background_overlay',
				[
					'label'        => esc_html__( 'Background Overlay', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-4',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_team_member_background_overlay_color',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Overlay Color', 'crafto-addons' ),
						],
					],
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .team-member:not(.team-style-4) .team-member-overlay, {{WRAPPER}} .team-member.team-style-4 .team-member-overlay + figcaption',
					'condition'      => [
						'crafto_team_member_background_overlay' => 'yes',
						'crafto_team_member_style' => [
							'team-style-2',
							'team-style-4',
							'team-style-7',
							'team-style-8',
						],
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_team_member_icon_number_style',
				[
					'label'      => esc_html__( 'Review', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_team_member_style' => [
							'team-style-3',
							'team-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_team_member_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .team-member-icon',
				]
			);
			$this->add_control(
				'crafto_team_member_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-member-icon' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_number_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .team-image .team-member-icon i, {{WRAPPER}} .team-member-image .team-member-icon i'      => 'color: {{VALUE}};',
						'{{WRAPPER}} .team-image .team-member-icon svg, {{WRAPPER}} .team-member-image .team-member-icon svg ' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_team_member_number_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .team-member-icon' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_team_member_style' => [
							'team-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_number_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_number_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_team_member_number_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .team-member-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render team member widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$crafto_team_member_hover_image = '';
			$settings                       = $this->get_settings_for_display();
			$team_member_style              = ( isset( $settings['crafto_team_member_style'] ) && $settings['crafto_team_member_style'] ) ? $settings['crafto_team_member_style'] : 'team-style-1';
			$team_member_icon_number        = ( isset( $settings['crafto_team_member_icon_number'] ) && $settings['crafto_team_member_icon_number'] ) ? $settings['crafto_team_member_icon_number'] : '';
			$image_bg_overlay               = ( isset( $settings['crafto_team_member_background_overlay'] ) && $settings['crafto_team_member_background_overlay'] ) ? $settings['crafto_team_member_background_overlay'] : '';
			$team_title_link                = ( isset( $settings['crafto_title_link']['url'] ) && $settings['crafto_title_link']['url'] ) ? $settings['crafto_title_link']['url'] : '';
			$migrated                       = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new                         = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! empty( $settings['crafto_team_member_hover_image']['url'] ) ) {
				$thumbnail_id       = $settings['crafto_team_member_hover_image']['id'];
				$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
				$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
				$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
				$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

				$image_array                        = wp_get_attachment_image_src( $settings['crafto_team_member_hover_image']['id'], $settings['crafto_thumbnail_size'] );
				$crafto_team_member_hover_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';

				$default_attr = array(
					'class' => 'hover-switch-image',
					'title' => esc_attr( $crafto_image_title ),
				);

				$crafto_team_member_hover_image = wp_get_attachment_image( $thumbnail_id, $settings['crafto_thumbnail_size'], '', $default_attr );
			} elseif ( ! empty( $settings['crafto_team_member_hover_image']['url'] ) ) {
				$crafto_team_member_hover_image_url = $settings['crafto_team_member_hover_image']['url'];
				$crafto_image_alt                   = esc_attr__( 'Placeholder Image', 'crafto-addons' );
				$crafto_team_member_hover_image     = sprintf( '<img src="%1$s" alt="%2$s" class="hover-switch-image" />', $crafto_team_member_hover_image_url, $crafto_image_alt );
			}

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					$team_member_style,
					'team-member',
					'social-icons-wrapper',
				]
			);

			$this->add_render_attribute(
				'team_image',
				'class',
				'team-member-image',
			);

			// Link on Text.
			if ( ! empty( $settings['crafto_title_link']['url'] ) ) {
				$this->add_render_attribute( '_titlelinks', 'class', 'title-link' );
				$this->add_link_attributes( '_titlelinks', $settings['crafto_title_link'] );
			}

			switch ( $team_member_style ) {
				case 'team-style-1':
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<?php
						if ( '' !== $team_title_link ) {
							?>
							<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
							<?php
						}
						?>
						<div <?php $this->print_render_attribute_string( 'team_image' ); ?>>
							<?php
							if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
								$settings['crafto_team_member_image']['id'] = '';
							}
							if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							?>
						</div>
						<?php
						if ( '' !== $team_title_link ) {
							?>
							</a>
							<?php
						}
						?>
						<figcaption>
							<?php
							$this->render_team_member_title();
							$this->render_team_member_position();
							$this->render_team_member_description();
							$this->render_team_member_social_icon();
							?>
						</figcaption>
					</figure>
					<?php
					break;
				case 'team-style-2':
					if ( 'yes' === $image_bg_overlay ) {
						$this->add_render_attribute(
							'inner_wrapper_details',
							'class',
							'team-member-overlay'
						);

						$this->add_render_attribute(
							'inner_wrapper_image',
							'class',
							'team-member-image'
						);
					}
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'inner_wrapper_image' ); ?>>
							<?php
							if ( '' !== $team_title_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
								$settings['crafto_team_member_image']['id'] = '';
							}
							if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							if ( '' !== $team_title_link ) {
								?>
								</a>
								<?php
							}
							if ( 'yes' === $image_bg_overlay ) {
								?>
								<div <?php $this->print_render_attribute_string( 'inner_wrapper_details' ); ?>>
									<?php
									$this->render_team_member_social_icon();
									$this->render_team_member_description();
									?>
								</div>
								<?php
							}
							?>
						</div>
						<figcaption>
							<?php
							$this->render_team_member_title();
							$this->render_team_member_position();
							?>
						</figcaption>
					</figure>
					<?php
					break;
				case 'team-style-3':
					if ( 'yes' === $image_bg_overlay ) {
						$this->add_render_attribute(
							'inner_wrapper_details',
							'class',
							[
								'team-member-overlay',
							]
						);
					}
					$this->add_render_attribute(
						'inner_wrapper_image',
						'class',
						[
							'team-member-image',
						]
					);
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<figcaption>
							<div <?php $this->print_render_attribute_string( 'inner_wrapper_image' ); ?>>
								<?php
								if ( '' !== $team_title_link ) {
									?>
									<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
									<?php
								}
								?>
								<div class="inner-team-img">
									<?php
									if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
										$settings['crafto_team_member_image']['id'] = '';
									}
									if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
										crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
										crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
									}
									?>
								</div>
								<?php
								if ( '' !== $team_title_link ) {
									?>
									</a>
									<?php
								}
								if ( ! empty( $team_member_icon_number ) ) {
									?>
									<div class="team-member-icon">
										<?php
										if ( $is_new || $migrated ) {
											Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
										} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
											echo '<i class="' . esc_attr( $settings['crafto_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
										}
										echo esc_html( $team_member_icon_number );
										?>
									</div>
									<?php
								}
								?>
							</div>
							<?php
							$this->render_team_member_title();
							$this->render_team_member_position();
							$this->render_team_member_description();
							$this->render_team_member_social_icon();
							?>
						</figcaption>
					</figure>
					<?php
					break;
				case 'team-style-4':
					if ( 'yes' === $image_bg_overlay ) {
						$this->add_render_attribute(
							'inner_wrapper_image',
							'class',
							[
								'team-member-overlay',
							]
						);
					}
					$this->add_render_attribute(
						'inner_wrapper_image',
						'class',
						'team-member-image',
					);
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'inner_wrapper_image' ); ?>>
							<?php
							if ( '' !== $team_title_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
								$settings['crafto_team_member_image']['id'] = '';
							}
							if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							if ( '' !== $team_title_link ) {
								?>
								</a>
								<?php
							}
							?>
						</div>
						<figcaption>
							<div class="team-member-content">
								<?php
								$this->render_team_member_title();
								$this->render_team_member_position();
								?>
							</div>
							<?php
							$this->render_team_member_social_icon();
							?>
						</figcaption>
					</figure>
					<?php
					break;
				case 'team-style-5':
					if ( 'yes' === $image_bg_overlay ) {
						$this->add_render_attribute(
							'inner_wrapper_details',
							'class',
							[
								'team-member-overlay',
							]
						);
						$this->add_render_attribute(
							'inner_wrapper_image',
							'class',
							[
								'team-member-image',
							]
						);
					}
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
					<div class="team-image">
						<?php
						if ( '' !== $team_title_link ) {
							?>
							<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
							<?php
						}
						if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
							$settings['crafto_team_member_image']['id'] = '';
						}
						if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
							crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
				            crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
						}
						if ( '' !== $team_title_link ) {
							?>
							</a>
							<?php
						}
						if ( ! empty( $team_member_icon_number ) ) {
							?>
							<div class="team-member-icon">
								<?php
								if ( $is_new || $migrated ) {
									Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
								} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
									echo '<i class="' . esc_attr( $settings['crafto_selected_icon']['value'] ) . '" aria-hidden="true"></i>';
								}
								echo esc_html( $team_member_icon_number );
								?>
							</div>
							<?php
						}
						?>
					</div>
					<figcaption>
						<?php
						$this->render_team_member_title();
						$this->render_team_member_position();
						$this->render_team_member_description();
						$this->render_team_member_social_icon();
						?>
					</figcaption>
					<?php
					// Close the <a> tag here, outside of the figcaption, but still inside the figure.
					if ( '' !== $team_title_link ) {
						?>
						</a>
						<?php
					}
					?>
				</figure>

					<?php
					break;
				case 'team-style-6':
					$this->add_render_attribute(
						'inner_wrapper_image',
						'class',
						'team-member-image'
					);
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'inner_wrapper_image' ); ?>>
							<?php
							if ( '' !== $team_title_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
								$settings['crafto_team_member_image']['id'] = '';
							}
							if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							if ( '' !== $team_title_link ) {
								?>
								</a>
								<?php
							}
							if ( ! empty( $crafto_team_member_hover_image ) ) {
								echo sprintf( '%s', $crafto_team_member_hover_image ); // phpcs:ignore
							}
							?>
						</div>
						<figcaption>
							<?php
							$this->render_team_member_social_icon();
							?>
							<div class="team-member-content">
								<?php
								$this->render_team_member_title();
								$this->render_team_member_position();
								?>
							</div>
						</figcaption>
					</figure>
					<?php
					break;
				case 'team-style-7':
					if ( 'yes' === $image_bg_overlay ) {
						$this->add_render_attribute(
							'inner_wrapper_details',
							'class',
							'team-member-overlay'
						);

						$this->add_render_attribute(
							'inner_wrapper_image',
							'class',
							'team-member-image'
						);
					}
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'inner_wrapper_image' ); ?>>
							<?php
							if ( '' !== $team_title_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
								$settings['crafto_team_member_image']['id'] = '';
							}
							if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							if ( '' !== $team_title_link ) {
								?>
								</a>
								<?php
							}
							?>
							<figcaption <?php $this->print_render_attribute_string( 'inner_wrapper_details' ); ?>>
								<?php
								$this->render_team_member_social_icon();
								$this->render_team_member_title();
								$this->render_team_member_position();
								?>
							</figcaption>
						</div>						
					</figure>
					<?php
					break;
				case 'team-style-8':
					if ( 'yes' === $image_bg_overlay ) {
						$this->add_render_attribute(
							'inner_wrapper_details',
							'class',
							'team-member-overlay'
						);

					}
					$this->add_render_attribute(
						'inner_wrapper_image',
						'class',
						'team-member-image'
					);
					?>
					<figure <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
						<div <?php $this->print_render_attribute_string( 'inner_wrapper_image' ); ?>>
							<?php
							if ( '' !== $team_title_link ) {
								?>
								<a <?php $this->print_render_attribute_string( '_titlelinks' ); ?>>
								<?php
							}
							if ( ! empty( $settings['crafto_team_member_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_team_member_image']['id'] ) ) {
								$settings['crafto_team_member_image']['id'] = '';
							}
							if ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['id'] ) && ! empty( $settings['crafto_team_member_image']['id'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							} elseif ( isset( $settings['crafto_team_member_image'] ) && isset( $settings['crafto_team_member_image']['url'] ) && ! empty( $settings['crafto_team_member_image']['url'] ) ) {
								crafto_get_attachment_html( $settings['crafto_team_member_image']['id'], $settings['crafto_team_member_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
							}
							if ( '' !== $team_title_link ) {
								?>
								</a>
								<?php
							}

							if ( 'yes' === $image_bg_overlay ) {
								?>
								<div <?php $this->print_render_attribute_string( 'inner_wrapper_details' ); ?>></div>
								<?php
							}
							?>
						</div>
						<figcaption>
							<?php
							$this->render_team_member_social_icon();
							$this->render_team_member_title();
							$this->render_team_member_position();
							?>
						</figcaption>
					</figure>
					<?php
					break;
			}
		}

		/**
		 *
		 * Render Team member widget title.
		 *
		 * @access protected
		 */
		protected function render_team_member_title() {
			$settings              = $this->get_settings_for_display();
			$team_member_full_name = $this->get_settings( 'crafto_team_member_full_name' );
			$team_title_link       = ( isset( $settings['crafto_title_link']['url'] ) && $settings['crafto_title_link']['url'] ) ? $settings['crafto_title_link']['url'] : '';

			// Link on Text.
			if ( ! empty( $settings['crafto_title_link']['url'] ) ) {
				$this->add_render_attribute( '_titlelink', 'class', 'title-link' );
				$this->add_link_attributes( '_titlelink', $settings['crafto_title_link'] );
			}

			if ( ! empty( $team_member_full_name ) ) {
				if ( '' !== $team_title_link ) {
					?>
					<a <?php $this->print_render_attribute_string( '_titlelink' ); ?>>
					<?php
				}
				?>
				<span class="team-member-name"><?php echo esc_html( $team_member_full_name ); ?></span>
				<?php
				if ( '' !== $team_title_link ) {
					?>
					</a>
					<?php
				}
			}
		}

		/**
		 *
		 * Render Team member widget position.
		 *
		 * @access protected
		 */
		protected function render_team_member_position() {
			$team_member_position = $this->get_settings( 'crafto_team_member_position' );
			if ( ! empty( $team_member_position ) ) {
				?>
				<div class="team-member-designation">
					<?php echo esc_html( $team_member_position ); ?>
				</div>
				<?php
			}
		}

		/**
		 *
		 * Render Team member widget description.
		 *
		 * @access protected
		 */
		protected function render_team_member_description() {
			$team_member_description = $this->get_settings( 'crafto_team_member_description' );
			if ( ! empty( $team_member_description ) ) {
				?>
				<div class="team-member-description">
					<?php echo sprintf( '%s', wp_kses_post( $team_member_description ) ); // phpcs:ignore ?>
				</div>
				<?php
			}
		}

		/**
		 *
		 * Render Team member widget social icon.
		 *
		 * @access protected
		 */
		protected function render_team_member_social_icon() {
			$settings          = $this->get_settings_for_display();
			$team_member_style = ( isset( $settings['crafto_team_member_style'] ) && $settings['crafto_team_member_style'] ) ? $settings['crafto_team_member_style'] : 'team-style-1';
			$social_icon_items = ( isset( $settings['crafto_team_member_social_icon_items'] ) && $settings['crafto_team_member_social_icon_items'] ) ? $settings['crafto_team_member_social_icon_items'] : '';
			$migrated          = isset( $settings['__fa4_migrated']['crafto_team_member_social_icon'] );
			$is_new            = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$attr_array        = array( 'aria-hidden' => 'true' );

			$this->add_render_attribute(
				'elementor_icon',
				'class',
				'elementor-social-icon',
			);

			if ( is_array( $social_icon_items ) && ! empty( $social_icon_items ) ) {
				?>
				<div class="social-icon">
					<?php
					$social = '';
					foreach ( $social_icon_items as $key => $icon_data ) {

						$link_key = 'link_' . $key;

						if ( ! empty( $icon_data['social'] ) ) {
							$social = str_replace( 'fa fa-', '', $icon_data['social'] );
						}

						if ( ( $is_new || $migrated ) && 'svg' !== $icon_data['crafto_team_member_social_icon']['library'] ) {
							$social = explode( ' ', $icon_data['crafto_team_member_social_icon']['value'], 2 );
							if ( empty( $social[1] ) ) {
								$social = '';
							} else {
								$social = str_replace( array( 'fa-', 'ti-' ), '', $social[1] );
							}
						}

						if ( 'svg' === $icon_data['crafto_team_member_social_icon']['library'] ) {
							$social = '';
						}

						$this->add_render_attribute(
							$link_key,
							'class',
							[
								'elementor-social-icon',
								'elementor-repeater-item-' . $icon_data['_id'],
							]
						);

						if ( ! empty( $icon_data['crafto_team_member_social_link']['url'] ) ) {
							$this->add_link_attributes( $link_key, $icon_data['crafto_team_member_social_link'] );
						}

						if ( ! empty( $icon_data['crafto_team_member_social_icon'] ) && ! empty( $icon_data['crafto_team_member_social_link']['url'] ) ) {
							?>
							<a <?php $this->print_render_attribute_string( $link_key ); ?>>
								<span class="elementor-screen-only"><?php echo esc_html( ucwords( $social ) ); ?></span>
								<?php
								if ( $is_new || $migrated ) {
									Icons_Manager::render_icon( $icon_data['crafto_team_member_social_icon'], $attr_array );
								} elseif ( isset( $icon_data['crafto_team_member_social_icon']['value'] ) && ! empty( $icon_data['crafto_team_member_social_icon']['value'] ) ) {
									?>
									<i class="<?php echo esc_attr( $icon_data['crafto_team_member_social_icon']['value'] ); ?>" aria-hidden="true"></i>
									<?php
								}

								if ( filter_var( $icon_data['crafto_team_member_label_visible'], FILTER_VALIDATE_BOOLEAN ) ) {
									echo sprintf( '<span class="team-member-socials-label">%s</span>', esc_html( $icon_data['crafto_team_member_social_label'] ) ); // phpcs:ignore
								}

								if ( 'team-style-3' === $team_member_style ) {
									?>
									<span class="crafto-social-hover-effect"></span>
									<?php
								}
								?>
							</a>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
		}
	}
}
