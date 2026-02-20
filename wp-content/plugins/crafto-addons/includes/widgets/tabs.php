<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Plugin;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Classes\Elementor_Templates;

/**
 *
 * Crafto widget for tabs.
 *
 * @package Crafto
 */

// If class `Tabs` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Tabs' ) ) {
	/**
	 * Define `Tabs` class.
	 */
	class Tabs extends Widget_Base {
		/**
		 * Retrieve the list of styles the tabs widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$tabs_styles = [];
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$tabs_styles[] = 'crafto-widgets-rtl';
				} else {
					$tabs_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$tabs_styles[] = 'crafto-tabs-rtl-widget';
				}
				$tabs_styles[] = 'crafto-tabs-widget';
			}
			return $tabs_styles;
		}

		/**
		 * Retrieve the list of scripts the tabs carousel widget depended on.
		 *
		 * Used to set scripts dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget scripts dependencies.
		 */
		public function get_script_depends() {
			$dependency_arr = [];

			$crafto_optimize_bootstrap = get_theme_mod( 'crafto_optimize_bootstrap', '0' );
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				$dependency_arr[] = 'crafto-widgets';
			} else {
				if ( '1' === $crafto_optimize_bootstrap ) {
					$dependency_arr[] = 'bootstrap-tab';
				}
				$dependency_arr[] = 'crafto-tabs-widget';
			}
			return $dependency_arr;
		}

		/**
		 * Get widget name.
		 *
		 * Retrieve tabs widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-tabs';
		}

		/**
		 * Get widget title.
		 *
		 * Retrieve tabs widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Tabs', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 *
		 * Retrieve tabs widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-tabs crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/tabs/';
		}
		/**
		 * Get widget categories.
		 *
		 * Retrieve the list of categories the tabs widget belongs to.
		 *
		 * Used to determine where to display the widget in the editor.
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
				'tabs',
				'accordion',
				'toggle',
				'tabbed',
			];
		}

		/**
		 * Register tabs widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_tabs',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_tab_style',
				[
					'label'   => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'tab-style-1',
					'options' => [
						'tab-style-1'  => esc_html__( 'Style 1', 'crafto-addons' ),
						'tab-style-2'  => esc_html__( 'Style 2', 'crafto-addons' ),
						'tab-style-3'  => esc_html__( 'Style 3', 'crafto-addons' ),
						'tab-style-4'  => esc_html__( 'Style 4', 'crafto-addons' ),
						'tab-style-5'  => esc_html__( 'Style 5', 'crafto-addons' ),
						'tab-style-6'  => esc_html__( 'Style 6', 'crafto-addons' ),
						'tab-style-7'  => esc_html__( 'Style 7', 'crafto-addons' ),
						'tab-style-8'  => esc_html__( 'Style 8', 'crafto-addons' ),
						'tab-style-9'  => esc_html__( 'Style 9', 'crafto-addons' ),
						'tab-style-10' => esc_html__( 'Style 10', 'crafto-addons' ),
						'tab-style-11' => esc_html__( 'Style 11', 'crafto-addons' ),
					],
				]
			);
			$this->add_control(
				'crafto_tab_main_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Add Title', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_control(
				'crafto_tab_main_subtitle',
				[
					'label'       => esc_html__( 'Subtitle', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => esc_html__( 'Add Subtitle', 'crafto-addons' ),
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$repeater = new Repeater();
			$repeater->start_controls_tabs(
				'crafto_tabs_content_tabs',
				[
					'label' => esc_html__( 'Tabs', 'crafto-addons' ),
				]
			);
				$repeater->start_controls_tab(
					'crafto_icon_tab',
					[
						'label' => esc_html__( 'Icon', 'crafto-addons' ),
					],
				);
					$repeater->add_control(
						'crafto_item_use_image',
						[
							'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
							'type'         => Controls_Manager::SWITCHER,
							'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
							'label_off'    => esc_html__( 'No', 'crafto-addons' ),
							'return_value' => 'yes',
							'default'      => '',
						]
					);
					$repeater->add_control(
						'crafto_item_icon',
						[
							'label'            => esc_html__( 'Icon', 'crafto-addons' ),
							'type'             => Controls_Manager::ICONS,
							'fa4compatibility' => 'icon',
							'skin'             => 'inline',
							'label_block'      => false,
							'condition'        => [
								'crafto_item_use_image' => '',
							],
						]
					);
					$repeater->add_control(
						'crafto_item_image',
						[
							'label'     => esc_html__( 'Image', 'crafto-addons' ),
							'type'      => Controls_Manager::MEDIA,
							'dynamic'   => [
								'active' => true,
							],
							'condition' => [
								'crafto_item_use_image' => 'yes',
							],
						]
					);
					$repeater->add_control(
						'crafto_image_fetch_priority',
						[
							'label'     => esc_html__( 'Fetch Priority', 'crafto-addons' ),
							'type'      => Controls_Manager::SELECT,
							'default'   => 'none',
							'options'   => [
								'none' => esc_html__( 'Default', 'crafto-addons' ),
								'high' => esc_html__( 'High', 'crafto-addons' ),
								'low'  => esc_html__( 'Low', 'crafto-addons' ),
							],
							'condition' => [
								'crafto_item_use_image' => 'yes',
							],
						]
					);
				$repeater->end_controls_tab();
				$repeater->start_controls_tab(
					'crafto_content_tab',
					[
						'label' => esc_html__( 'Content', 'crafto-addons' ),
					],
				);
					$repeater->add_control(
						'crafto_tab_title',
						[
							'label'       => esc_html__( 'Title', 'crafto-addons' ),
							'type'        => Controls_Manager::TEXT,
							'dynamic'     => [
								'active' => true,
							],
							'default'     => esc_html__( 'Tab Title', 'crafto-addons' ),
							'label_block' => true,
						]
					);
					$repeater->add_control(
						'crafto_tab_subtitle',
						[
							'label'       => esc_html__( 'Subtitle', 'crafto-addons' ),
							'type'        => Controls_Manager::TEXT,
							'dynamic'     => [
								'active' => true,
							],
							'label_block' => true,
							'description' => esc_html__( 'Applicable in style 8 only.', 'crafto-addons' ),
						]
					);
					$repeater->add_control(
						'crafto_item_content_type',
						[
							'label'       => esc_html__( 'Content Type', 'crafto-addons' ),
							'type'        => Controls_Manager::SELECT,
							'default'     => 'editor',
							'options'     => [
								'template' => esc_html__( 'Template', 'crafto-addons' ),
								'editor'   => esc_html__( 'Editor', 'crafto-addons' ),
							],
							'label_block' => true,
						]
					);
					$repeater->add_control(
						'crafto_item_template_id',
						[
							'label'       => esc_html__( 'Choose Template', 'crafto-addons' ),
							'label_block' => true,
							'type'        => Controls_Manager::SELECT2,
							'default'     => '0',
							'options'     => Elementor_Templates::get_elementor_templates_options(),
							'condition'   => [
								'crafto_item_content_type' => 'template',
							],
						]
					);
					$repeater->add_control(
						'crafto_item_content',
						[
							'label'     => esc_html__( 'Content', 'crafto-addons' ),
							'type'      => Controls_Manager::WYSIWYG,
							'dynamic'   => [
								'active' => true,
							],
							'default'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
							'condition' => [
								'crafto_item_content_type' => 'editor',
							],
						]
					);
				$repeater->end_controls_tab();
			$repeater->end_controls_tabs();
			$this->add_control(
				'crafto_tabs',
				[
					'label'       => esc_html__( 'Tab Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_tab_title'    => esc_html__( 'Tab #1', 'crafto-addons' ),
							'crafto_item_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
						],
						[
							'crafto_tab_title'    => esc_html__( 'Tab #2', 'crafto-addons' ),
							'crafto_item_content' => esc_html__( 'Lorem maecenas cursus nec odio id finibus. Aliquam dolor ligula, dignissim vel urna molestie, blandit porta nisi. Praesent non risus vel sem luctus dapibus.', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_tab_title }}}',
					'condition'   => [
						'crafto_tab_style!' => [
							'tab-style-3',
						],
					],
				]
			);

			$repeater_style3 = new Repeater();
			$repeater_style3->start_controls_tabs(
				'crafto_tabs_content_tabs',
				[
					'label' => esc_html__( 'Tabs', 'crafto-addons' ),
				]
			);
				$repeater_style3->start_controls_tab(
					'crafto_icon_tab',
					[
						'label' => esc_html__( 'Icon', 'crafto-addons' ),
					],
				);
					$repeater_style3->add_control(
						'crafto_item_icon',
						[
							'label'            => esc_html__( 'Icon', 'crafto-addons' ),
							'type'             => Controls_Manager::ICONS,
							'fa4compatibility' => 'icon',
							'skin'             => 'inline',
							'label_block'      => false,
							'default'          => [
								'value'   => 'fa-solid fa-check',
								'library' => 'fa-solid',
							],
						]
					);
				$repeater_style3->end_controls_tab();
				$repeater_style3->start_controls_tab(
					'crafto_content_tab',
					[
						'label' => esc_html__( 'Content', 'crafto-addons' ),
					],
				);
					$repeater_style3->add_control(
						'crafto_tab_title',
						[
							'label'       => esc_html__( 'Title', 'crafto-addons' ),
							'type'        => Controls_Manager::TEXT,
							'dynamic'     => [
								'active' => true,
							],
							'default'     => esc_html__( 'Tab Title', 'crafto-addons' ),
							'label_block' => true,
						]
					);
					$repeater_style3->add_control(
						'crafto_tab_offer',
						[
							'label'   => esc_html__( 'Offer', 'crafto-addons' ),
							'type'    => Controls_Manager::TEXT,
							'default' => esc_html__( 'Save 20%', 'crafto-addons' ),
						]
					);
					$repeater_style3->add_control(
						'crafto_tab_price',
						[
							'label'   => esc_html__( 'Price', 'crafto-addons' ),
							'type'    => Controls_Manager::TEXT,
							'default' => esc_html__( '$10', 'crafto-addons' ),
						]
					);
					$repeater_style3->add_control(
						'crafto_tab_month',
						[
							'label'   => esc_html__( 'Month', 'crafto-addons' ),
							'type'    => Controls_Manager::TEXT,
							'default' => esc_html__( 'Per month', 'crafto-addons' ),
						]
					);
					$repeater_style3->add_control(
						'crafto_item_content_type',
						[
							'label'       => esc_html__( 'Content Type', 'crafto-addons' ),
							'type'        => Controls_Manager::SELECT,
							'default'     => 'editor',
							'options'     => [
								'template' => esc_html__( 'Template', 'crafto-addons' ),
								'editor'   => esc_html__( 'Editor', 'crafto-addons' ),
							],
							'label_block' => true,
						]
					);
					$repeater_style3->add_control(
						'crafto_item_template_id',
						[
							'label'       => esc_html__( 'Choose Template', 'crafto-addons' ),
							'label_block' => true,
							'type'        => Controls_Manager::SELECT2,
							'default'     => '0',
							'options'     => Elementor_Templates::get_elementor_templates_options(),
							'condition'   => [
								'crafto_item_content_type' => 'template',
							],
						]
					);
					$repeater_style3->add_control(
						'crafto_item_content',
						[
							'label'     => esc_html__( 'Content', 'crafto-addons' ),
							'type'      => Controls_Manager::WYSIWYG,
							'dynamic'   => [
								'active' => true,
							],
							'default'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
							'condition' => [
								'crafto_item_content_type' => 'editor',
							],
						]
					);
				$repeater_style3->end_controls_tab();
				$repeater_style3->start_controls_tab(
					'crafto_current_item_styles_tab',
					[
						'label' => esc_html__( 'Style', 'crafto-addons' ),
					],
				);
				$repeater_style3->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'     => 'crafto_tabs_control_current_item_background',
						'exclude'  => [
							'image',
							'position',
							'attachment',
							'attachment_alert',
							'repeat',
							'size',
						],
						'selector' => '{{WRAPPER}} .crafto-tabs .nav-tabs {{CURRENT_ITEM}}.nav-item a.nav-link',
					]
				);

				$repeater_style3->add_group_control(
					Group_Control_Border::get_type(),
					[
						'name'     => 'crafto_tabs_control_current_item_border',
						'selector' => '{{WRAPPER}} .crafto-tabs:not(.tab-style-1):not(.tab-style-11) .nav-tabs {{CURRENT_ITEM}}.nav-item a.nav-link',
					]
				);
				$repeater_style3->end_controls_tab();
			$repeater_style3->end_controls_tabs();
			$this->add_control(
				'crafto_tabs_style3',
				[
					'label'       => esc_html__( 'Tab Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'fields'      => $repeater_style3->get_controls(),
					'default'     => [
						[
							'crafto_tab_title' => esc_html__( 'Primary', 'crafto-addons' ),
							'crafto_tab_offer' => esc_html__( 'Save 20%', 'crafto-addons' ),
							'crafto_tab_price' => esc_html__( '$10', 'crafto-addons' ),
							'crafto_tab_month' => esc_html__( 'Per month', 'crafto-addons' ),
						],
						[
							'crafto_tab_title' => esc_html__( 'Popular', 'crafto-addons' ),
							'crafto_tab_offer' => esc_html__( 'Save 30%', 'crafto-addons' ),
							'crafto_tab_price' => esc_html__( '$19', 'crafto-addons' ),
							'crafto_tab_month' => esc_html__( 'Per month', 'crafto-addons' ),
						],
						[
							'crafto_tab_title' => esc_html__( 'Premium', 'crafto-addons' ),
							'crafto_tab_offer' => esc_html__( 'Save 35%', 'crafto-addons' ),
							'crafto_tab_price' => esc_html__( '$28', 'crafto-addons' ),
							'crafto_tab_month' => esc_html__( 'Per month', 'crafto-addons' ),
						],
					],
					'title_field' => '{{{ crafto_tab_title }}}',
					'condition'   => [
						'crafto_tab_style' => [
							'tab-style-3',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_settings_data',
				[
					'label'     => esc_html__( 'Settings', 'crafto-addons' ),
					'condition' => [
						'crafto_tab_style!' => 'tab-style-3',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'thumbnail',
					'exclude'   => [
						'custom',
					],
					'separator' => 'none',
				]
			);
			$this->add_control(
				'crafto_reverse_direction',
				[
					'label'        => esc_html__( 'Enable Reverse Direction', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_tab_style' => [
							'tab-style-5',
						],
					],
				]
			);
			$this->add_control(
				'crafto_bottom_border',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => 'yes',
					'condition'    => [
						'crafto_tab_style' => [
							'tab-style-2',
							'tab-style-5',
							'tab-style-10',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tab_header_size',
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
					'default'   => 'h3',
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_control(
				'crafto_enable_number',
				[
					'label'        => esc_html__( 'Enable Number', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
					'condition'    => [
						'crafto_tab_style' => [
							'tab-style-7',
							'tab-style-8',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_general_style',
				[
					'label'      => esc_html__( 'General', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_v_alignment',
				[
					'label'       => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'        => Controls_Manager::CHOOSE,
					'label_block' => false,
					'default'     => '',
					'options'     => [
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
					'selectors'   => [
						'{{WRAPPER}} .tab-style-1, {{WRAPPER}} .tab-style-11' => 'align-items: {{VALUE}};',
					],
					'condition'   => [
						'crafto_tab_style' => [
							'tab-style-1',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tabs_container_background',
					'selector' => '{{WRAPPER}} .crafto-tabs',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_tabs_container_border',
					'selector' => '{{WRAPPER}} .crafto-tabs',
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_container_padding',
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
						'{{WRAPPER}} .crafto-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-1',
							'tab-style-2',
							'tab-style-10',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_container_margin',
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
						'{{WRAPPER}} .crafto-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-1',
							'tab-style-2',
							'tab-style-6',
							'tab-style-10',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_container_style_heading',
				[
					'label'     => esc_html__( 'Container Styles', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_container_style_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-container-wrap',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_post_likes_hover_shadow',
					'selector'  => '{{WRAPPER}} .crafto-container-wrap',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-5',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_post_likes_border',
					'default'   => '1px',
					'selector'  => '{{WRAPPER}} .crafto-container-wrap',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_container_style_padding',
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
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-5',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-container-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_container_style_width',
				[
					'label'      => esc_html__( 'Max Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 1400,
						],
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-5',
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-container-wrap .nav-tabs' => 'max-width: {{SIZE}}{{UNIT}}',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tabs_control_style',
				[
					'label'      => esc_html__( 'Tabs Control', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_wrapper_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .tab-style-3.crafto-tabs .nav-tabs, {{WRAPPER}} .tab-style-8.crafto-tabs .crafto-container-wrap, {{WRAPPER}} .tab-style-9.crafto-tabs .nav-tabs' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-3',
							'tab-style-8',
							'tab-style-9',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_controls_aligment',
				[
					'label'     => esc_html__( 'Tabs Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => '',
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
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-4',
							'tab-style-6',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs' => 'display:flex; justify-content: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_tabs_content_wrapper_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-tabs .nav-tabs',
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-3',
							'tab-style-4',
							'tab-style-6',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_tabs_control_wrapper_border',
					'selector'  => '{{WRAPPER}} .crafto-tabs .nav-tabs',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-9',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_wrapper_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-9',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_wrapper_padding',
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
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-5',
							'tab-style-6',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_title_wrap_margin',
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
						'{{WRAPPER}} .crafto-tabs:not(.tab-style-8) .nav-tabs, {{WRAPPER}} .tab-style-8.crafto-tabs .crafto-container-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-5',
							'tab-style-10	',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_tabs_control_wrapper_box_shadow',
					'selector'  => '{{WRAPPER}} .crafto-tabs .nav-tabs',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-8',
							'tab-style-9',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tabs_switch_style',
				[
					'label'      => esc_html__( 'Tabs Switch', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
					'condition'  => [
						'crafto_tab_style' => 'tab-style-4',
					],
				]
			);

			$this->start_controls_tabs( 'tabs_switch_styles_icon' );
			$this->start_controls_tab(
				'crafto_tabs_switch_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tabs_normal_switch_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .nav-link:after',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tabs_switch_active',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tabs_switch_active_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .nav-link:before',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tabs_control_item_style',
				[
					'label'      => esc_html__( 'Tab Items', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_controls_text_aligment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'left',
					'options'   => [
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
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end' : 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs:not(.tab-style-11) .nav-tabs > li.nav-item > a.nav-link , {{WRAPPER}} .tab-style-2 .nav-tabs, {{WRAPPER}} .tab-style-10 .nav-tabs, {{WRAPPER}} .tab-style-11 li.nav-item' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-3',
							'tab-style-4',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_style_heading',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-1',
							'tab-style-2',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_position',
				[
					'label'     => esc_html__( 'Icon Position', 'crafto-addons' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'nav-icon-top',
					'options'   => [
						'nav-icon-top'  => esc_html__( 'Icon on Top', 'crafto-addons' ),
						'nav-icon-left' => esc_html__( 'Inline Icon & Heading', 'crafto-addons' ),
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-1',
							'tab-style-2',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_icon_right_spacing',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}} .nav-tabs .nav-item.nav-icon-left .nav-link i, {{WRAPPER}} .nav-tabs .nav-item.nav-icon-left .nav-link .tab-title-image, {{WRAPPER}} .nav-tabs .nav-item.nav-icon-left svg' => 'margin-right: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .nav-tabs .nav-item.nav-icon-top .nav-link i, {{WRAPPER}} .nav-tabs .nav-item.nav-icon-top .nav-link .tab-title-image, {{WRAPPER}} .nav-tabs .nav-item.nav-icon-top svg' => 'margin-bottom: {{SIZE}}{{UNIT}}',
						'.rtl {{WRAPPER}} .nav-tabs .nav-item.nav-icon-left .nav-link i, .rtl {{WRAPPER}} .nav-tabs .nav-item.nav-icon-left .nav-link .tab-title-image, .rtl {{WRAPPER}} .nav-tabs .nav-item.nav-icon-left svg' => 'margin-inline-end: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-1',
							'tab-style-2',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_navigation_heading_divider',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-3',
							'tab-style-8',
							'tab-style-10',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_state_style_heading',
				[
					'label' => esc_html__( 'Navigation', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->start_controls_tabs( 'tabs_control_styles' );
			$this->start_controls_tab(
				'crafto_tabs_control_normal',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tabs_control_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link',
				]
			);
			$this->add_control(
				'crafto_tabs_control_label_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link span, {{WRAPPER}} .tab-style-9 .nav-tabs .nav-item a.nav-link span, {{WRAPPER}} .tab-style-3 .nav-link .tab-title, {{WRAPPER}} .tab-style-3 .nav-link .tab-price' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_month_color',
				[
					'label'     => esc_html__( 'Month Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tab-style-3 .tab-month' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_tabs_control_background',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link, .tab-style-7 .nav-tabs .nav-item .nav-link .tabs-icon',
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link i, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link .tabs-icon i, {{WRAPPER}} .nav-item a.nav-link .tabs-icon' => 'color: {{VALUE}}',
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link svg, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link .tabs-icon svg, {{WRAPPER}} .nav-item a.nav-link svg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_border_color',
				[
					'label'     => esc_html__( 'Icon Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tab-style-3 .nav-tabs .nav-item a.nav-link .tab-icon' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link i, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link .tabs-icon i, {{WRAPPER}} .nav-item a.nav-link .tabs-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .nav-item a.nav-link svg, {{WRAPPER}} .nav-tabs .nav-item .nav-link .tab-title-image' => 'width: {{SIZE}}{{UNIT}}',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-3',
							'tab-style-4',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_subtitle_color',
				[
					'label'     => esc_html__( 'Subtitle Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-tabs .nav-item a.nav-link .sub-title' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_number_color',
				[
					'label'     => esc_html__( 'Number Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-tabs .nav-item a.nav-link span.tabs-number' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_enable_number' => 'yes',
						'crafto_tab_style'     => [
							'tab-style-7',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'crafto_tabs_control_border',
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link, {{WRAPPER}} .tab-style-10 .nav-tabs',
					'condition'   => [
						'crafto_tab_style!' => [
							'tab-style-4',
							'tab-style-5',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .tab-style-1 .nav-tabs .nav-item a.nav-link, {{WRAPPER}} .tab-style-11 .nav-tabs .nav-item a.nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-1',
							'tab-style-11',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tabs_control_hover',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tabs_control_label_typography_hover',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover',
				]
			);
			$this->add_control(
				'crafto_tabs_control_label_color_hover',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover span' => 'color: {{VALUE}}',
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_month_hover_color',
				[
					'label'     => esc_html__( 'Month Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tab-style-3 .nav-tabs .nav-item a.nav-link:hover .tab-month' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_color_hover',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover i, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link:hover .tabs-icon i, {{WRAPPER}} .nav-item a.nav-link:hover .tabs-icon' => 'color: {{VALUE}}',
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover svg, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link:hover .tabs-icon svg, {{WRAPPER}} .nav-item a.nav-link:hover svg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_tabs_control_background_hover',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover, {{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover .bg-hover, .tab-style-7 .nav-tabs .nav-item .nav-link:hover span.tabs-icon',
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_border_hover',
				[
					'label'     => esc_html__( 'Icon Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tab-style-3 .nav-tabs .nav-item a.nav-link:hover .tab-icon' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_border_hover',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
							'tab-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_icon_size_hover',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover i, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link:hover .tabs-icon i, {{WRAPPER}} .nav-item a.nav-link.hover .tabs-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover .tab-title-image, {{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link:hover svg' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-3',
							'tab-style-4',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_subtitle_hover_color',
				[
					'label'     => esc_html__( 'Subtitle Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-tabs .nav-item a.nav-link:hover .sub-title' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_number_hover_color',
				[
					'label'     => esc_html__( 'Number Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-tabs .nav-item a.nav-link:hover span.tabs-number' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_enable_number' => 'yes',
						'crafto_tab_style'     => [
							'tab-style-7',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_label_hover_animation',
				[
					'label'     => esc_html__( 'Hover Effect', 'crafto-addons' ),
					'type'      => 'icon-hover-animation',
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tabs_control_active',
				[
					'label' => esc_html__( 'Active', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tabs_control_label_typography_active',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active',
				]
			);
			$this->add_control(
				'crafto_tabs_control_label_color_active',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active span' => 'color: {{VALUE}}',
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_month_active_color',
				[
					'label'     => esc_html__( 'Month Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tab-style-3 .nav-tabs .nav-item a.nav-link.active .tab-month' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_color_active',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active i, {{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active .tabs-icon i, {{WRAPPER}} .nav-item a.nav-link.active .tabs-icon' => 'color: {{VALUE}}',
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active svg, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item a.nav-link.active .tabs-icon svg, {{WRAPPER}} .nav-item a.nav-link.active svg' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_tabs_control_background_active',
					'exclude'   => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'  => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active, {{WRAPPER}} .tab-style-7 .nav-tabs .nav-item .nav-link.active .bg-hover, .tab-style-7 .nav-tabs .nav-item .nav-link.active .tabs-icon',
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_icon_border_active',
				[
					'label'     => esc_html__( 'Icon Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .tab-style-3 .nav-tabs .nav-item a.nav-link.active .tab-icon' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-3',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_border_active',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
							'tab-style-5',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_icon_size_active',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 18,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active i, {{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active .tabs-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active .tab-title-image, {{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link.active svg' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-3',
							'tab-style-4',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_subtitle_active_color',
				[
					'label'     => esc_html__( 'Subtitle Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-tabs .nav-item a.nav-link.active .sub-title' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_number_active_color',
				[
					'label'     => esc_html__( 'Number Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-tabs .nav-item a.nav-link.active span.tabs-number' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_enable_number' => 'yes',
						'crafto_tab_style'     => [
							'tab-style-7',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_tabs_content_box_shadow_active',
					'selector'  => '{{WRAPPER}} .crafto-tabs:not(.tab-style-1):not(.tab-style-11) .nav-tabs .nav-item a.nav-link.active',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-2',
							'tab-style-6',
							'tab-style-10',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_tabs_control_separator_style_heading',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-2',
							'tab-style-5',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'           => 'crafto_tabs_control_border_color',
					'exclude'        => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector'       => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item .tab-border',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Separator Color', 'crafto-addons' ),
						],
					],
					'condition'      => [
						'crafto_tab_style' => [
							'tab-style-2',
							'tab-style-5',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_border_height',
				[
					'label'      => esc_html__( 'Separator Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'default'    => [
						'size' => 2,
					],
					'range'      => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item .tab-border' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-2',
							'tab-style-5',
							'tab-style-11',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_offer_style_heading',
				[
					'label'     => esc_html__( 'Offer', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tab_style' => 'tab-style-3',
					],
				]
			);
			$this->start_controls_tabs(
				'tabs_control_styles_offer',
				[
					'condition' => [
						'crafto_tab_style' => 'tab-style-3',
					],
				]
			);
			$this->start_controls_tab(
				'crafto_tabs_control_offer_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_tab_style' => 'tab-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_normal_offer_color',
				[
					'label'     => esc_html__( 'Text Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .offer' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tabs_normal_offer_background',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .offer',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_offer_box_border',
					'selector' => '{{WRAPPER}} .offer',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tabs_control_offer_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_tab_style' => 'tab-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_color_offer_hover',
				[
					'label'     => esc_html__( 'Offer Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-link:hover .offer' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tabs_control_offer_background_hover',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .nav-link:hover .offer',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_offer_hover_box_border',
					'selector' => '{{WRAPPER}} .nav-link:hover .offer',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_tabs_control_offer_active',
				[
					'label'     => esc_html__( 'Active', 'crafto-addons' ),
					'condition' => [
						'crafto_tab_style' => 'tab-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_color_offer_active',
				[
					'label'     => esc_html__( 'Offer Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .nav-link.active .offer' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tabs_control_offer_background_active',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
					'selector' => '{{WRAPPER}} .nav-link.active .offer',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_offer_active_box_border',
					'selector' => '{{WRAPPER}} .nav-link.active .offer',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_tabs_offer_border_radius',
				[
					'label'      => esc_html__( 'Offer Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .offer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => 'tab-style-3',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_number_style_heading',
				[
					'label'     => esc_html__( 'Number Styles', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-7',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_tabs_control_number_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .nav-tabs .nav-item a.nav-link .tabs-number',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-7',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_number_margin',
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
						'{{WRAPPER}} .nav-tabs .nav-item a.nav-link .tabs-number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-7',
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_subtitle_style_heading',
				[
					'label'     => esc_html__( 'Subtitle Styles', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-8',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_tabs_control_subtitle_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .nav-tabs .nav-item a.nav-link .sub-title',
					'condition' => [
						'crafto_tab_style' => [
							'tab-style-8',
						],
					],
				]
			);
			$this->add_control(
				'crafto_tab_title_style',
				[
					'label'     => esc_html__( 'Main Title', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_tab_main_title_typography',
					'selector'  => '{{WRAPPER}} .crafto-container-wrap .title-wrap .title',
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_control(
				'crafto_tab_main_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-container-wrap .title-wrap .title' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tab_main_title_margin',
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
						'{{WRAPPER}} .crafto-container-wrap .title-wrap .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_control(
				'crafto_tab_subtitle_style',
				[
					'label'     => esc_html__( 'Main Subtitle', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crafto_tab_subtitle_typography',
					'global'    => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector'  => '{{WRAPPER}} .crafto-container-wrap .title-wrap .main-subtitle',
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_control(
				'crafto_tab_subtitle_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-container-wrap .title-wrap .main-subtitle' => 'color: {{VALUE}}',
					],
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_tab_subtitle_border',
					'selector'  => '{{WRAPPER}} .crafto-container-wrap .title-wrap .main-subtitle',
					'condition' => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tab_subtitle_margin',
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
						'{{WRAPPER}} .crafto-container-wrap .title-wrap .main-subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => 'tab-style-8',
					],
				]
			);
			$this->add_control(
				'crafto_tabs_control_divider',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style' => [
							'tab-style-6',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_padding',
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
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_control_margin',
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
						'{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_tab_style!' => [
							'tab-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_tabs_control_box_shadow',
					'selector'  => '{{WRAPPER}} .crafto-tabs .nav-tabs .nav-item a.nav-link',
					'condition' => [
						'crafto_tab_style!' => [
							'tab-style-4',
						],
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_tabs_content_style',
				[
					'label'      => esc_html__( 'Tabs Content', 'crafto-addons' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'show_label' => false,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_tabs_content_typography',
					'selector' => '{{WRAPPER}} .crafto-tabs .tab-content',
				]
			);
			$this->add_control(
				'crafto_tabs_content_text_color',
				[
					'label'     => esc_html__( 'Text color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crafto-tabs .tab-content' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'crafto_tabs_content_background',
					'selector' => '{{WRAPPER}} .crafto-tabs .tab-content',
					'exclude'  => [
						'image',
						'position',
						'attachment',
						'attachment_alert',
						'repeat',
						'size',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_tabs_content_padding',
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
						'{{WRAPPER}} .crafto-tabs .tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_tabs_content_margin',
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
						'{{WRAPPER}} .crafto-tabs .tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}
		/**
		 * Render tabs widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                    = $this->get_settings_for_display();
			$tab_style                   = $this->get_settings( 'crafto_tab_style' );
			$id_int                      = $this->get_id_int();
			$migrated                    = isset( $settings['__fa4_migrated']['crafto_item_icon'] );
			$is_new                      = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
			$crafto_icon_hover_animation = ( isset( $settings['crafto_tabs_control_label_hover_animation'] ) && $settings['crafto_tabs_control_label_hover_animation'] ) ? 'hvr-' . $settings['crafto_tabs_control_label_hover_animation'] : '';
			$crafto_reverse_direction    = ( isset( $settings['crafto_reverse_direction'] ) && $settings['crafto_reverse_direction'] ) ? $settings['crafto_reverse_direction'] : '';

			$this->add_render_attribute(
				'tabs_wrapper',
				[
					'class' => [
						'crafto-tabs',
						$settings['crafto_tab_style'],
					],
				],
			);

			$this->add_render_attribute(
				'nav_tab_wrap',
				[
					'class' => [
						'nav',
						'nav-tabs',
						'alt-font',
					],
				],
			);

			$this->add_render_attribute(
				'main_title',
				[
					'class' => [
						'title',
						'alt-font',
					],
				],
			);

			if ( 'yes' === $crafto_reverse_direction ) {
				$this->add_render_attribute(
					'tabs_wrapper',
					[
						'class' => [
							'reverse-direction',
						],
					],
				);
			}

			if ( 'tab-style-3' === $tab_style ) {
				$tabs = $this->get_settings_for_display( 'crafto_tabs_style3' );
			} else {
				$tabs = $this->get_settings_for_display( 'crafto_tabs' );
			}
			?>
			<div <?php $this->print_render_attribute_string( 'tabs_wrapper' ); ?>>
				<?php
				if ( 'tab-style-8' === $tab_style ) {
					$this->tab_content();
				}
				?>
				<?php $this->start_container_wrap(); ?>
				<?php
				if ( 'tab-style-8' === $tab_style ) {
					?>
					<div class="title-wrap">
						<span class="main-subtitle"><?php echo esc_html( $settings['crafto_tab_main_subtitle'] ); ?></span>
						<<?php Utils::print_validated_html_tag( $settings['crafto_tab_header_size'] ); ?> <?php $this->print_render_attribute_string( 'main_title' ); ?>><?php echo esc_html( $settings['crafto_tab_main_title'] ); ?></<?php Utils::print_validated_html_tag( $settings['crafto_tab_header_size'] ); ?>>
					</div>
					<?php
				}
				?>
				<ul <?php $this->print_render_attribute_string( 'nav_tab_wrap' ); ?>>
					<?php
					if ( ! empty( $tabs ) ) {
						$active_title_index = 1;
						foreach ( $tabs as $index => $item ) {

							$title_icon             = '';
							$title_image            = '';
							$tab_count              = $index + 1;
							$active_class           = ( 1 === $active_title_index ) ? 'active' : '';
							$tab_title_setting_key  = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
							$tab_anchor_setting_key = $this->get_repeater_setting_key( 'tab_title_anchor', 'tabs', $index );
							$this->add_render_attribute(
								$tab_title_setting_key,
								[
									'class' => [
										'elementor-repeater-item-' . $item['_id'],
										'nav-item',
										$settings['crafto_tabs_control_icon_position'],
									],
								],
							);
							if ( 'tab-style-11' === $tab_style ) {
								$this->add_render_attribute(
									$tab_anchor_setting_key,
									[
										'class' => [
											'tab-link',
										],
									]
								);
							}
							$this->add_render_attribute(
								$tab_anchor_setting_key,
								[
									'class'          => [
										'nav-link',
										$active_class,
									],
									'data-bs-toggle' => 'tab',
									'href'           => '#tab-' . $id_int . $tab_count,
								]
							);

							if ( ! empty( $crafto_icon_hover_animation ) ) {
								$this->add_render_attribute( $tab_anchor_setting_key, 'class', $crafto_icon_hover_animation );
								$crafto_icon_hover = 'hvr-icon';
							} else {
								$crafto_icon_hover = 'hvr-none';
							}

							if ( $is_new || $migrated ) {
								ob_start();
									Icons_Manager::render_icon(
										$item['crafto_item_icon'],
										[
											'class'       => $crafto_icon_hover,
											'aria-hidden' => 'true',
										],
									);
								$title_icon .= ob_get_clean();
							} elseif ( isset( $item['crafto_item_icon']['value'] ) && ! empty( $item['crafto_item_icon']['value'] ) ) {
								$title_icon .= '<i class="' . esc_attr( $item['crafto_item_icon']['value'] ) . esc_attr( $crafto_icon_hover ) . '" aria-hidden="true"></i>';
							}

							if ( ! empty( $item['crafto_item_image']['id'] ) ) {
								$thumbnail_id       = $item['crafto_item_image']['id'];
								$crafto_img_alt     = ! empty( $thumbnail_id ) ? crafto_option_image_alt( $thumbnail_id ) : array();
								$crafto_img_title   = ! empty( $thumbnail_id ) ? crafto_option_image_title( $thumbnail_id ) : array();
								$crafto_image_alt   = ( isset( $crafto_img_alt['alt'] ) && ! empty( $crafto_img_alt['alt'] ) ) ? $crafto_img_alt['alt'] : '';
								$crafto_image_title = ( isset( $crafto_img_title['title'] ) && ! empty( $crafto_img_title['title'] ) ) ? $crafto_img_title['title'] : '';

								$image_array     = wp_get_attachment_image_src( $item['crafto_item_image']['id'], $settings['crafto_thumbnail_size'] );
								$title_image_url = isset( $image_array[0] ) && ! empty( $image_array[0] ) ? $image_array[0] : '';

								$fetch_priority = isset( $item['crafto_image_fetch_priority'] ) && ! empty( $item['crafto_image_fetch_priority'] ) ? $item['crafto_image_fetch_priority'] : 'none';

								$default_attr = array(
									'class' => 'tab-title-image',
									'title' => esc_attr( $crafto_image_title ),
								);

								if ( 'none' !== $fetch_priority ) {
									$default_attr['fetchpriority'] = esc_attr( $fetch_priority );
								}

								$title_image = wp_get_attachment_image( $thumbnail_id, $settings['crafto_thumbnail_size'], '', $default_attr );

							} elseif ( ! empty( $item['crafto_item_image']['url'] ) ) {
								$title_image_url  = $item['crafto_item_image']['url'];
								$crafto_image_alt = esc_attr__( 'Placeholder Image', 'crafto-addons' );
								$title_image      = sprintf( '<span class="tab-title-image"><img src="%1$s" alt="%2$s" class="elementor-tabs-label-image" /></span>', esc_url( $title_image_url ), esc_attr( $crafto_image_alt ) );
							}
							?>
							<li <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>>
								<a <?php $this->print_render_attribute_string( $tab_anchor_setting_key ); ?>>
									<?php
									switch ( $settings['crafto_tab_style'] ) {
										case 'tab-style-1':
										case 'tab-style-11':
											if ( $title_image || $title_icon ) {
												?>
												<span>
													<?php
													echo ( 'yes' === $item['crafto_item_use_image'] ) ? $title_image : $title_icon; // phpcs:ignore 
													?>
												</span>
												<?php
											}
											?>
											<span>
												<?php
												echo esc_html( $item['crafto_tab_title'] );
												if ( 'yes' === $settings['crafto_bottom_border'] ) {
													?>
													<span class="tab-border bg-base-color"></span>
													<?php
												}
												?>
											</span>
											<?php
											break;
										case 'tab-style-2':
										case 'tab-style-5':
										case 'tab-style-6':
										case 'tab-style-10':
											if ( $title_image || $title_icon ) {
												?>
												<span>
													<?php
													echo ( 'yes' === $item['crafto_item_use_image'] ) ? $title_image : $title_icon; // phpcs:ignore
													?>
												</span>
												<?php
											}
											echo esc_html( $item['crafto_tab_title'] );
											if ( 'tab-style-10' !== $tab_style ) {
												if ( 'yes' === $settings['crafto_bottom_border'] ) {
													?>
													<span class="tab-border bg-base-color"></span>
													<?php
												}
											}
											break;
										case 'tab-style-7':
											$number_zero = '';
											if ( $tab_count < 10 ) {
												$number_zero = '0';
											}
											if ( 'yes' === $settings['crafto_enable_number'] ) {
												?>
												<span class="tabs-number"><?php echo esc_html( $number_zero . $tab_count ); ?></span>
												<?php
											}
											?>
											<span><?php echo esc_html( $item['crafto_tab_title'] ); ?></span>
											<?php
											if ( $title_image || $title_icon ) {
												?>
												<span class="tabs-icon"><?php echo ( 'yes' === $item['crafto_item_use_image'] ) ? $title_image : $title_icon; // phpcs:ignore ?></span>
												<?php
											}
											?>
											<span class="bg-hover"></span>
											<?php
											break;
										case 'tab-style-8':
											$number_zero = '';
											if ( $tab_count < 10 ) {
												$number_zero = '0';
											}
											?>
											<?php
											if ( $title_image || $title_icon ) {
												?>
												<span class="tabs-icon"><?php echo ( 'yes' === $item['crafto_item_use_image'] ) ? $title_image : $title_icon; // phpcs:ignore ?></span>
												<?php
											}
											if ( 'yes' === $settings['crafto_enable_number'] ) {
												?>
												<span class="tabs-number"><?php echo esc_html( $number_zero . $tab_count ); ?></span>
												<?php
											}
											if ( ! empty( $item['crafto_tab_title'] ) ) {
												?>
												<span><?php echo esc_html( $item['crafto_tab_title'] ); ?></span>
												<?php
											}
											if ( ! empty( $item['crafto_tab_subtitle'] ) ) {
												?>
												<span class="sub-title"><?php echo esc_html( $item['crafto_tab_subtitle'] ); ?></span>
												<?php
											}
											?>
											<?php
											break;
										case 'tab-style-9':
											if ( $title_image || $title_icon ) {
												?>
												<span class="tabs-icon">
													<?php
													echo ( 'yes' === $item['crafto_item_use_image'] ) ? $title_image : $title_icon; // phpcs:ignore 
													?>
												</span>
												<?php
											}
											?>
											<span><?php echo esc_html( $item['crafto_tab_title'] ); ?></span>
											<span class="bg-hover"></span>
											<?php
											break;
										case 'tab-style-3':
											if ( ! empty( $title_icon ) || ! empty( $item['crafto_tab_title'] ) ) {
												?>
												<div class="title-icon-wrap">
													<?php
													if ( ! empty( $title_icon ) ) {
														?>
														<div class="tab-icon">
															<?php echo $title_icon; // phpcs:ignore ?>
														</div>
														<?php
													}
													?>
													<span class="tab-title">
														<?php echo esc_html( $item['crafto_tab_title'] ); ?>
													</span>
												</div>
												<?php
											}
											?>
											<div class="offer">
												<?php echo esc_html( $item['crafto_tab_offer'] ); ?>
											</div>
											<div class="price-wrap">
												<span class="tab-price">
													<?php echo esc_html( $item['crafto_tab_price'] ); ?>
												</span>
												<span class="tab-month">
													<?php echo esc_html( $item['crafto_tab_month'] ); ?>
												</span>
											</div>
											<?php
											break;
										case 'tab-style-4':
											if ( $title_image || $title_icon ) {
												?>
												<span>
													<?php
													echo ( 'yes' === $item['crafto_item_use_image'] ) ? $title_image : $title_icon; // phpcs:ignore 
													?>
												</span>
												<?php
											}
											?>
											<span class="tab-nav-text"><?php echo esc_html( $item['crafto_tab_title'] ); ?></span>
											<?php
											break;
									}
									++$active_title_index;
									?>
								</a>
							</li>
							<?php
						}
					}
					?>
				</ul>
				<?php $this->end_container_wrap(); ?>
				<?php
				if ( 'tab-style-8' !== $tab_style ) {
					$this->tab_content();
				}
				?>
			</div>
			<?php
		}

		/**
		 *
		 * Function to show tab content
		 */
		public function tab_content() {
			$tab_style = $this->get_settings( 'crafto_tab_style' );
			$id_int    = $this->get_id_int();

			if ( 'tab-style-3' === $tab_style ) {
				$tabs = $this->get_settings_for_display( 'crafto_tabs_style3' );
			} else {
				$tabs = $this->get_settings_for_display( 'crafto_tabs' );
			}
			?>
			<div class="tab-content">
				<?php
				if ( ! empty( $tabs ) ) {
					$active_content_index = 1;
					foreach ( $tabs as $index => $item ) {
						$tab_count               = $index + 1;
						$tab_content_setting_key = $this->get_repeater_setting_key( 'item_content', 'tabs', $index );
						$active_class            = ( 1 === $active_content_index ) ? 'in active show' : '';

						if ( 'tab-style-11' === $tab_style ) {
							$this->add_render_attribute(
								$tab_content_setting_key,
								[
									'id'    => 'tab-' . $id_int . $tab_count,
									'class' => [
										'section',
									],
								],
							);
						} else {
							$this->add_render_attribute(
								$tab_content_setting_key,
								[
									'id'    => 'tab-' . $id_int . $tab_count,
									'class' => [
										'tab-pane',
										'fade',
										$active_class,
									],
								],
							);
						}
						?>
						<div <?php $this->print_render_attribute_string( $tab_content_setting_key ); ?>>
							<?php
							if ( 'template' === $item['crafto_item_content_type'] ) {
								if ( '0' !== $item['crafto_item_template_id'] ) {
									$template_content = \Crafto_Addons_Extra_Functions::crafto_get_builder_content_for_display( $item['crafto_item_template_id'] );
									if ( ! empty( $template_content ) ) {
										if ( Plugin::$instance->editor->is_edit_mode() ) {
											$edit_url = add_query_arg(
												array(
													'elementor' => '',
												),
												get_permalink( $item['crafto_item_template_id'] )
											);
											echo sprintf( '<div class="edit-template-with-light-box elementor-template-edit-cover" data-template-edit-link="%s"><i aria-hidden="true" class="eicon-edit"></i><span>%s</span></div>', esc_url( $edit_url ), esc_html__( 'Edit Template', 'crafto-addons' ) ); // phpcs:ignore
										}
										echo sprintf( '%s', $template_content ); // phpcs:ignore
									} else {
										echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
									}
								} else {
									echo sprintf( '%s', no_template_content_message() ); // phpcs:ignore
								}
							} else {
								echo sprintf( '%s', $this->parse_text_editor( $item['crafto_item_content'] ) ); // phpcs:ignore
							}
							?>
						</div>
						<?php
						++$active_content_index;
					}
				}
				?>
			</div>
			<?php
		}

		/**
		 *
		 * Start div tag for tab title
		 */
		public function start_container_wrap() {
			$tab_style = $this->get_settings( 'crafto_tab_style' );
			if ( 'tab-style-5' === $tab_style || 'tab-style-8' === $tab_style ) {
				echo '<div class="crafto-container-wrap">';
			}
		}

		/**
		 *
		 * End div tag for tab title
		 */
		public function end_container_wrap() {
			$tab_style = $this->get_settings( 'crafto_tab_style' );
			if ( 'tab-style-5' === $tab_style || 'tab-style-8' === $tab_style ) {
				echo '</div>';
			}
		}
	}
}
