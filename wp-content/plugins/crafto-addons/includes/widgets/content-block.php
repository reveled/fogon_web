<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use CraftoAddons\Controls\Groups\Text_Gradient_Background;

/**
 *
 * Crafto widget for content block.
 *
 * @package Crafto
 */

// If class `Content_Block` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Content_Block' ) ) {
	/**
	 * Define `Content_Block` class.
	 */
	class Content_Block extends Widget_Base {
		/**
		 * Retrieve the list of styles the content block widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			$content_block_styles = [];

			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				if ( is_rtl() ) {
					$content_block_styles[] = 'crafto-widgets-rtl';
				} else {
					$content_block_styles[] = 'crafto-widgets';
				}
			} else {
				if ( is_rtl() ) {
					$content_block_styles[] = 'crafto-star-rating-rtl';
					$content_block_styles[] = 'crafto-content-box-rtl';
				}
				$content_block_styles[] = 'crafto-star-rating';
				$content_block_styles[] = 'crafto-content-box';
			}
			return $content_block_styles;
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-content-block';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Content Block', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-post-info crafto-element-icon';
		}

		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/content-block/';
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
				'text',
				'information',
				'reusable',
			];
		}

		/**
		 * Register content block widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_content_block_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_block_style',
				[
					'label'              => esc_html__( 'Select Style', 'crafto-addons' ),
					'type'               => Controls_Manager::SELECT,
					'default'            => 'block-style-1',
					'options'            => [
						'block-style-1' => esc_html__( 'Style 1', 'crafto-addons' ),
						'block-style-2' => esc_html__( 'Style 2', 'crafto-addons' ),
						'block-style-3' => esc_html__( 'Style 3', 'crafto-addons' ),
						'block-style-4' => esc_html__( 'Style 4', 'crafto-addons' ),
					],
					'frontend_available' => true,
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_number_section',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-2',
							'block-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_number',
				[
					'label'       => esc_html__( 'Number', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'show_label'  => true,
					'label_block' => true,
					'default'     => esc_html__( '01', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_header_number_size',
				[
					'label'   => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
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
					'default' => 'div',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_content_block_icon_image_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-2',
							'block-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_custom_image',
				[
					'label'        => esc_html__( 'Use Image?', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_content_block_icons',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'default'          => [
						'value'   => 'bi-briefcase',
						'library' => 'feather',
					],
					'skin'             => 'inline',
					'label_block'      => false,
					'condition'        => [
						'crafto_content_block_custom_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_image',
				[
					'label'     => esc_html__( 'Choose Image', 'crafto-addons' ),
					'type'      => Controls_Manager::MEDIA,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crafto_content_block_custom_image!' => '',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'crafto_thumbnail',
					'default'   => 'large',
					'separator' => 'none',
					'condition' => [
						'crafto_content_block_custom_image!' => '',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_icons_position',
				[
					'label'        => esc_html__( 'Position', 'crafto-addons' ),
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
					'default'      => [
						'top',
					],
					'prefix_class' => 'elementor%s-position-',
					'condition'    => [
						'crafto_content_block_style!' => [
							'block-style-4',
						],
					],
				]
			);

			$this->add_responsive_control(
				'crafto_content_block_icons_vertical_alignment',
				[
					'label'     => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'default'   => 'center',
					'options'   => [
						'start'  => [
							'title' => esc_html__( 'Top', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center' => [
							'title' => esc_html__( 'Middle', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'end'    => [
							'title' => esc_html__( 'Bottom', 'crafto-addons' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .content-block.content-block-style-2' => 'align-items: {{VALUE}};',
					],
					'condition' => [
						'crafto_content_block_icons_position!' => 'top',
						'crafto_content_block_style!' => [
							'block-style-1',
							'block-style-3',
							'block-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_image_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 500,
						],
						'%'  => [
							'max' => 100,
							'min' => 1,
						],
					],
					'default'    => [
						'unit' => '%',
						'size' => 25,
					],
					'condition'  => [
						'crafto_content_block_custom_image!' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_icon_view',
				[
					'label'        => esc_html__( 'View', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'default' => esc_html__( 'Default', 'crafto-addons' ),
						'stacked' => esc_html__( 'Stacked', 'crafto-addons' ),
						'framed'  => esc_html__( 'Framed', 'crafto-addons' ),
					],
					'default'      => 'default',
					'condition'    => [
						'crafto_content_block_custom_image' => '',
						'crafto_content_block_icons[value]!' => '',
					],
					'prefix_class' => 'elementor-view-',
				]
			);
			$this->add_control(
				'crafto_content_block_icon_shape',
				[
					'label'        => esc_html__( 'Shape', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'circle' => esc_html__( 'Circle', 'crafto-addons' ),
						'square' => esc_html__( 'Square', 'crafto-addons' ),
					],
					'default'      => 'circle',
					'condition'    => [
						'crafto_content_block_icon_view!' => 'default',
						'crafto_content_block_custom_image' => '',
						'crafto_content_block_icons[value]!' => '',
					],
					'prefix_class' => 'elementor-shape-',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_big_title_section',
				[
					'label'     => esc_html__( 'Large Title', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_big_title',
				[
					'label'       => esc_html__( 'Title', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Write Large Title Here', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_content_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_block_title',
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
			$this->add_control(
				'crafto_header_size',
				[
					'label'   => esc_html__( 'Title HTML Tag', 'crafto-addons' ),
					'type'    => Controls_Manager::SELECT,
					'options' => [
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
					'default' => 'div',
				]
			);
			$this->add_control(
				'crafto_content_block_title_link',
				[
					'label'       => esc_html__( 'Enable Link on Title', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
					'default'     => [
						'url' => '#',
					],
					'condition'   => [
						'crafto_content_block_style!' => [
							'block-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_content',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'type'      => Controls_Manager::WYSIWYG,
					'dynamic'   => [
						'active' => true,
					],
					'default'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-3',
						],
					],
					'separator' => 'before',
				]
			);
			$repeater = new Repeater();
			$repeater->add_control(
				'crafto_content_block_item_content',
				[
					'label'      => esc_html__( 'Content', 'crafto-addons' ),
					'type'       => Controls_Manager::WYSIWYG,
					'dynamic'    => [
						'active' => true,
					],
					'show_label' => false,
					'default'    => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_contents_block',
				[
					'label'     => esc_html__( 'Content Items', 'crafto-addons' ),
					'type'      => Controls_Manager::REPEATER,
					'fields'    => $repeater->get_controls(),
					'default'   => [
						[
							'crafto_content_block_item_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
						],
						[
							'crafto_content_block_item_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
						],
						[
							'crafto_content_block_item_content' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'crafto-addons' ),
						],
					],
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-3',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_rating_star_section',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-2',
							'block-style-3',
							'block-style-4',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_rating_star_stretch',
				[
					'label'        => esc_html__( 'Enable Rating', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => '',
					'return_value' => 'yes',
				]
			);
			$this->add_control(
				'crafto_content_block_star_style',
				[
					'label'        => esc_html__( 'Select Icon', 'crafto-addons' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => [
						'star_fontawesome' => esc_html__( 'Font Awesome', 'crafto-addons' ),
						'star_unicode'     => esc_html__( 'Unicode', 'crafto-addons' ),
						'star_bootstrap'   => esc_html__( 'Bootstrap', 'crafto-addons' ),
					],
					'default'      => 'star_fontawesome',
					'render_type'  => 'template',
					'prefix_class' => 'elementor--star-style-',
					'condition'    => [
						'crafto_content_block_rating_star_stretch' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_unmarked_star_style',
				[
					'label'        => esc_html__( 'Unmarked Style', 'crafto-addons' ),
					'type'         => Controls_Manager::CHOOSE,
					'options'      => [
						'solid'   => [
							'title' => esc_html__( 'Solid', 'crafto-addons' ),
							'icon'  => 'eicon-star',
						],
						'outline' => [
							'title' => esc_html__( 'Outline', 'crafto-addons' ),
							'icon'  => 'eicon-star-o',
						],
					],
					'default'      => 'solid',
					'prefix_class' => 'elementor-star-',
					'condition'    => [
						'crafto_content_block_rating_star_stretch' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_rating_star',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'dynamic'   => [
						'active' => true,
					],
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 5,
							'step' => 0.5,
						],
					],
					'default'   => [
						'size' => 4,
					],
					'condition' => [
						'crafto_content_block_rating_star_stretch' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_karat_number',
				[
					'label'       => esc_html__( 'Rating Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'condition'   => [
						'crafto_content_block_style' => 'block-style-1',
						'crafto_content_block_rating_star_stretch' => 'yes',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_contents_block_separator',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_style' => 'block-style-2',
					],
				]
			);
			$this->add_control(
				'crafto_contents_block_enable_separator',
				[
					'label'        => esc_html__( 'Enable Separator', 'crafto-addons' ),
					'type'         => Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Yes', 'crafto-addons' ),
					'label_off'    => esc_html__( 'No', 'crafto-addons' ),
					'return_value' => 'yes',
					'default'      => '',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_content_block_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_alignment',
				[
					'label'                => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'                 => Controls_Manager::CHOOSE,
					'default'              => 'left',
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
					'selectors_dictionary' => [
						'left'  => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'selectors' => [
						'{{WRAPPER}} .content-block' => 'text-align: {{VALUE}};',
					],
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_vertical_position',
				[
					'label'     => esc_html__( 'Vertical Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
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
						'{{WRAPPER}} .content-block' => 'align-items: {{VALUE}};',
					],
					'default'   => 'center',
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-2',
							'block-style-3',
							'block-style-4',
						],
					],
				]
			);
			$this->start_controls_tabs(
				'crafto_content_blocks_style'
			);
			$this->start_controls_tab(
				'crafto_content_blocks_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_content_block_box_background',
					'selector'  => '{{WRAPPER}} .content-block',
					'separator' => 'after',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_blocks_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'crafto_content_block_box_hover_background',
					'selector'  => '{{WRAPPER}} .content-block:not(.content-block-style-4):hover, {{WRAPPER}} .content-block.content-block-style-4 .content-block-overlay',
					'separator' => 'after',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'crafto_content_block_box_shadow',
					'selector' => '{{WRAPPER}} .content-block',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_content_block_box_border',
					'selector' => '{{WRAPPER}} .content-block',
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_box_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],

				]
			);
			$this->add_responsive_control(
				'crafto_content_block_box_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style!' => [
							'block-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_featured_content_block_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .content-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator'  => 'before',
					'condition'  => [
						'crafto_content_block_style' => [
							'block-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_box_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_number_style_section',
				[
					'label'     => esc_html__( 'Number', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-2',
							'block-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_block_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .content-block .number',
				]
			);
			$this->add_control(
				'crafto_content_block_number_type',
				[
					'label'   => esc_html__( 'Title Type', 'crafto-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'normal' => [
							'title' => esc_html__( 'Normal', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter-bold',
						],
						'stroke' => [
							'title' => esc_html__( 'Stroke', 'crafto-addons' ),
							'icon'  => 'eicon-t-letter',
						],
					],
					'default' => 'normal',
				]
			);
			$this->start_controls_tabs( 'crafto_content_blocks_number_style' );
			$this->start_controls_tab(
				'crafto_content_block_number_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_content_blocks_number_title_color',
					'selector'       => '{{WRAPPER}} .content-block .number',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_content_block_number_type' => 'stroke',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-block .number' => 'color: {{VALUE}};',
					],
					'separator' => 'after',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_blocks_number_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_group_control(
				Group_Control_Text_Stroke::get_type(),
				[
					'name'           => 'crafto_stroke_content_blocks_number_title_hvr_color',
					'selector'       => '{{WRAPPER}} .content-block:hover .number',
					'fields_options' => [
						'text_stroke' => [
							'default' => [
								'size' => 1,
							],
						],
					],
					'condition'      => [
						'crafto_content_block_number_type' => 'stroke',
					],
				]
			);
			$this->add_control(
				'crafto_content_blocks_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-block:hover .number' => 'color: {{VALUE}};',
					],
					'separator' => 'after',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_control(
				'crafto_content_block_number_bg_color',
				[
					'label'     => esc_html__( 'Shape Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .content-block .number' => 'background-color: {{VALUE}};',
					],
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_number_size',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => '',
						'unit' => 'px',
					],
					'range'      => [
						'px' =>
						[
							'min' => 0,
							'max' => 150,
						],
					],
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .number' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style' => [
							'block-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'crafto_content_block_number_box_shadow',
					'selector'  => '{{WRAPPER}} .content-block .number',
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-3',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_content_block_number_border',
					'selector'  => '{{WRAPPER}} .content-block .number',
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_number_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style' => [
							'block-style-1',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_number_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .number'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style!' => [
							'block-style-2',
							'block-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_number_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .number' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style' => [
							'block-style-1',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_big_title_style_section',
				[
					'label'     => esc_html__( 'Large Title', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-4',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_block_big_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .big-title',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_blocks_big_title_style'
			);
			$this->start_controls_tab(
				'crafto_content_block_big_title_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_block_big_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-block .big-title'   => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_blocks_big_title_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_block_hover_big_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-block:hover .big-title'   => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_content_block_big_title_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .big-title' => 'opacity: {{SIZE}};',
					],
					'separator'  => 'before',
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_big_title_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .big-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_icon_image_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-2',
							'block-style-4',
						],
						'crafto_content_block_icons[value]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_icon_size',
				[
					'label'      => esc_html__( 'Icon Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 6,
							'max' => 100,
						],
					],
					'condition'  => [
						'crafto_content_block_custom_image' => '',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_icon_padding',
				[
					'label'      => esc_html__( 'Shape Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' =>
						[
							'min' => 0,
							'max' => 50,
						],
						'em' =>
						[
							'min' => 0,
							'max' => 5,
						],
					],
					'condition'  => [
						'crafto_content_block_custom_image' => '',
						'crafto_content_block_icon_view!' => 'default',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_icon_space',
				[
					'label'      => esc_html__( 'Icon Spacing', 'crafto-addons' ),
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
						'{{WRAPPER}}' => '--icon-box-icon-margin: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-left .content-block-style-2 .elementor-icon' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}}.elementor-position-right .content-block-style-2 .elementor-icon' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->start_controls_tabs( 'icon_tabs' );
			$this->start_controls_tab(
				'crafto_content_block_icon_colors_normal',
				[
					'label'     => esc_html__( 'Normal', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_custom_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_icon_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked .elementor-icon i, {{WRAPPER}}.elementor-view-framed .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked .elementor-icon svg, {{WRAPPER}}.elementor-view-framed .elementor-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_content_block_custom_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_icon_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_content_block_icon_view' => [
							'stacked',
						],
						'crafto_content_block_custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon'  => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_content_block_icon_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed .elementor-icon'  => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_width',
				[
					'label'      => esc_html__( 'Border Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_icon_view!' => [
							'default',
							'stacked',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_icon_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .elementor-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_icon_view!' => [
							'default',
						],
					],
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_block_icon_colors_hover',
				[
					'label'     => esc_html__( 'Hover', 'crafto-addons' ),
					'condition' => [
						'crafto_content_block_custom_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_icon_hover_primary_color',
				[
					'label'     => esc_html__( 'Icon Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon i:before, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon i, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon i' => 'color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-default:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg, {{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg' => 'fill: {{VALUE}};',
					],
					'condition' => [
						'crafto_content_block_custom_image' => '',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_icon_hover_secondary_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_content_block_icon_view' => [
							'stacked',
						],
						'crafto_content_block_custom_image' => '',
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_icon_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'crafto_content_block_icon_view' => [
							'framed',
						],
					],
					'selectors' => [
						'{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'border-color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_icon_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-2',
							'block-style-4!',
						],
					],
					'selectors' => [
						'{{WRAPPER}}:hover .content-block .elementor-icon' => 'opacity: {{SIZE}};',
					],
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_box_style_section',
				[
					'label'     => esc_html__( 'Content Container', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-1',
						],
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_content_block_boxs_border',
					'selector' => '{{WRAPPER}} .content-wrap',
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_boxs_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_content_style_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_control(
				'crafto_content_block_title_heading',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_block_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .content-block .title, {{WRAPPER}} .content-block .title a',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_blocks_title_style'
			);
			$this->start_controls_tab(
				'crafto_content_block_title_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_block_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-block .title'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .content-block .title a' => 'color: {{VALUE}};',
					],
					'separator' => 'after',
				]
			);

			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_blocks_title_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_block_hover_title_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .content-block:hover .title'   => 'color: {{VALUE}};',
						'{{WRAPPER}} .content-block:hover .title a' => 'color: {{VALUE}};',
						'{{WRAPPER}} .content-block .title a:hover' => 'color: {{VALUE}};',
					],
					'separator' => 'after',
				]
			);

			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_responsive_control(
				'crafto_content_block_title_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style!' => [
							'block-style-2',
							'block-style-3',
							'block-style-4',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_title_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_content_heading',
				[
					'label'     => esc_html__( 'Content', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} .content-block .content,{{WRAPPER}} .content-block p',
				]
			);
			$this->start_controls_tabs(
				'crafto_content_blocks_content_style'
			);
			$this->start_controls_tab(
				'crafto_content_block_content_normal_style',
				[
					'label' => esc_html__( 'Normal', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_block_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .content-block .content,{{WRAPPER}} .content-block p' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .content' => 'opacity: {{SIZE}};',
					],
					'separator'  => 'after',
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'crafto_content_blocks_content_hover_style',
				[
					'label' => esc_html__( 'Hover', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_content_blocks_hover_content_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .content-block:hover .content, {{WRAPPER}} .content-block:hover .content p' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_hover_opacity',
				[
					'label'      => esc_html__( 'Opacity', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'range'      => [
						'px' => [
							'min'  => 0.1,
							'max'  => 1,
							'step' => 0.1,
						],
					],
					'size_units' => [
						'px',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block:hover .content' => 'opacity: {{SIZE}};',
					],
					'separator'  => 'after',
				]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crafto_content_block_border',
					'selector'  => '{{WRAPPER}} .content-block-style-3 .content-box .content',
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_content_width',
				[
					'label'      => esc_html__( 'Width', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => '',
						'unit' => 'px',
					],
					'size_units' => [
						'px',
						'%',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 50,
							'max' => 500,
						],
						'%'  => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block .content' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_content_padding',
				[
					'label'      => esc_html__( 'Padding', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block-style-1 .content-wrap .content, {{WRAPPER}} .content-block-style-3 .content-box .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style' => [
							'block-style-1',
							'block-style-3',
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_content_margin',
				[
					'label'      => esc_html__( 'Margin', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'vw',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .content-block-style-1 .content-wrap .content, {{WRAPPER}} .content-block-style-3 .content-box .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'crafto_content_block_style' => [
							'block-style-1',
							'block-style-3',
						],
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_content_block_separator_style_section',
				[
					'label'     => esc_html__( 'Separator', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_content_block_style' => [
							'block-style-2',
						],
					],
				]
			);
			$this->add_control(
				'crafto_content_block_separator_thickness',
				[
					'label'      => esc_html__( 'Thickness', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 1,
							'max' => 5,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .border-hover-separator' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_separator_bg_color',
				[
					'label'     => esc_html__( 'Background Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .border-hover-separator' => 'background-color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_start_rating_icon_style_section',
				[
					'label'     => esc_html__( 'Rating', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_content_block_style!' => [
							'block-style-2',
							'block-style-3',
							'block-style-4',
						],
						'crafto_content_block_rating_star_stretch' => 'yes',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_rating_star_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'custom',
					],
					'range'      => [
						'px' => [
							'min' => 6,
							'max' => 100,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .review-star-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_content_block_rating_star_color',
					'selector'       => '{{WRAPPER}} .review-star-icon i:not(.elementor-star-empty):before',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Marked Color', 'crafto-addons' ),
						],
					],
				]
			);

			$this->add_group_control(
				Text_Gradient_Background::get_type(),
				[
					'name'           => 'crafto_rating_star_unmarked_color',
					'selector'       => '{{WRAPPER}} .review-star-icon i:after, {{WRAPPER}} .review-star-icon i.elementor-star-empty:before, {{WRAPPER}}.elementor--star-style-star_unicode .review-star-icon i',
					'fields_options' => [
						'background' => [
							'label' => esc_html__( 'Unmarked Color', 'crafto-addons' ),
						],
					],
				]
			);
			$this->add_responsive_control(
				'crafto_content_block_rating_star_space',
				[
					'label'      => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'%',
						'em',
						'rem',
						'custom',
					],
					'selectors'  => [
						'{{WRAPPER}} .review-star-icon i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_control(
				'crafto_content_block_number_heading',
				[
					'label'     => esc_html__( 'Review Label', 'crafto-addons' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_content_block_karat_number_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .review-number',
				]
			);
			$this->add_control(
				'crafto_content_block_karat_number_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'default'   => '',
					'selectors' => [
						'{{WRAPPER}} .review-number' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Retrieve Rating Icon
		 *
		 * @since 1.0
		 * @access protected
		 * @param array $settings Widget data.
		 */
		protected function get_rating_icon( $settings ) {

			$icon = '';

			if ( 'star_unicode' === $settings['crafto_content_block_star_style'] ) {
				$icon = '&#9733;';

				if ( 'outline' === $settings['crafto_content_block_unmarked_star_style'] ) {
					$icon = '&#9734;';
				}
			}

			$icon_html      = '';
			$rating         = (float) $settings['crafto_content_block_rating_star']['size'] > 5 ? 5 : $settings['crafto_content_block_rating_star']['size'];
			$floored_rating = ( $rating ) ? (int) $rating : 0;

			if ( $rating ) {
				for ( $stars = 1; $stars <= 5; $stars++ ) {
					if ( $stars <= $floored_rating ) {
						$icon_html .= '<i class="elementor-star-full">' . $icon . '</i>';
					} elseif ( $floored_rating + 1 === $stars && $rating !== $floored_rating ) {
						$icon_html .= '<i class="elementor-star-' . ( $rating - $floored_rating ) * 10 . '">' . $icon . '</i>';
					} else {
						$icon_html .= '<i class="elementor-star-empty">' . $icon . '</i>';
					}
				}
			}

			return '<div class="elementor-star-rating">' . $icon_html . '</div>'; // phpcs:ignore
		}

		/**
		 * Render content block widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$settings                         = $this->get_settings_for_display();
			$content_style                    = ( isset( $settings['crafto_content_block_style'] ) && $settings['crafto_content_block_style'] ) ? $settings['crafto_content_block_style'] : 'block-style-2';
			$bigtitle                         = ( isset( $settings['crafto_content_block_big_title'] ) && $settings['crafto_content_block_big_title'] ) ? $settings['crafto_content_block_big_title'] : '';
			$number                           = ( isset( $settings['crafto_content_block_number'] ) && $settings['crafto_content_block_number'] ) ? $settings['crafto_content_block_number'] : '';
			$review_number                    = ( isset( $settings['crafto_content_block_karat_number'] ) && $settings['crafto_content_block_karat_number'] ) ? $settings['crafto_content_block_karat_number'] : '';
			$crafto_content_block_number_type = ( isset( $settings['crafto_content_block_number_type'] ) && ! empty( $settings['crafto_content_block_number_type'] ) ) ? $settings['crafto_content_block_number_type'] : '';

			$this->add_render_attribute(
				'wrapper',
				'class',
				[
					'content-block',
					'content-' . $content_style,
				]
			);

			$this->add_render_attribute(
				'crafto_contents_block',
				'class',
				'elementor-content_block-content',
			);

			$this->add_render_attribute( 'content_block_title', 'class', 'title' );

			if ( ! empty( $settings['crafto_content_block_title_link']['url'] ) ) {
				$this->add_link_attributes( '_link', $settings['crafto_content_block_title_link'] );
				$this->add_render_attribute( '_link', 'class', 'title-link' );
			}

			$this->add_render_attribute( 'content_block_number', 'class', 'number' );
			if ( 'stroke' === $crafto_content_block_number_type ) {
				$this->add_render_attribute( 'content_block_number', 'class', 'text-stroke' );
			}
			$this->add_render_attribute( 'content_block_content', 'class', 'content' );
			$this->add_render_attribute( 'content_box', 'class', 'content-box' );

			if ( $this->get_settings( 'crafto_content_block_hover_animation' ) ) {
				$this->add_render_attribute(
					'wrapper',
					[
						'class' => [
							'content-block-hover',
							'hvr-' . $this->get_settings( 'crafto_content_block_hover_animation' ),
						],
					],
				);
			}
			?>
			<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
				<?php
				switch ( $content_style ) {
					case 'block-style-1':
						if ( ! empty( $number ) ) {
							?>
							<<?php echo $this->get_settings( 'crafto_header_number_size' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<?php $this->print_render_attribute_string( 'content_block_number' ); ?>>
								<?php echo $number; // phpcs:ignore. ?>
							</<?php echo $this->get_settings( 'crafto_header_number_size' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php
						}
						?>
						<div class="content-wrap">
							<?php
							$this->render_content_block_title();
							if ( 'yes' === $this->get_settings( 'crafto_content_block_rating_star_stretch' ) || ! empty( $review_number ) ) {
								?>
								<div class="review-star-icon">
									<?php echo $this->get_rating_icon( $settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
									<?php
									if ( ! empty( $review_number ) ) {
										?>
										<span class="review-number"><?php echo esc_html( $review_number ); ?></span>
										<?php
									}
									?>
								</div>
								<?php
							}
							$this->render_content_block_content();
							?>
						</div>
						<?php
						break;
					case 'block-style-2':
						$this->render_icon_image();
						?>
						<div class="content-wrap">
							<?php
							if ( ! empty( $subtitle ) ) {
								?>
								<div <?php $this->print_render_attribute_string( 'content_block_subtitle' ); ?>>
									<?php echo esc_html( $subtitle ); ?>
								</div>
								<?php
							}
							$this->render_content_block_title();
							$this->render_content_block_content();
							?>
						</div>
						<?php
						if ( 'yes' === $settings['crafto_contents_block_enable_separator'] ) {
							?>
							<div class="border-hover-separator"></div>
							<?php
						}
						break;
					case 'block-style-3':
						?>
						<div <?php $this->print_render_attribute_string( 'crafto_contents_block' ); ?>>
							<div <?php $this->print_render_attribute_string( 'content_box' ); ?>>
								<<?php echo $this->get_settings( 'crafto_header_number_size' ); // phpcs:ignore ?> <?php $this->print_render_attribute_string( 'content_block_number' ); ?>><?php echo esc_html( $number ); ?></<?php echo $this->get_settings( 'crafto_header_number_size' ); // phpcs:ignore ?>>
								<?php
								$this->render_content_block_title();
								foreach ( $settings['crafto_contents_block'] as $index => $item ) {
									$index                 = ++$index;
									$content_block_content = 'content_' . $index;
									$content               = ( isset( $item['crafto_content_block_item_content'] ) && $item['crafto_content_block_item_content'] ) ? $item['crafto_content_block_item_content'] : '';

									$this->add_render_attribute(
										[
											$content_block_content => [
												'class' => 'content',
											],
										]
									);
									?>
									<div <?php $this->print_render_attribute_string( $content_block_content ); ?>>
										<?php echo $content; // phpcs:ignore ?>
									</div>
									<?php
								}
								?>
							</div>
							<div class="feature-box-overlay bg-base-color"></div>
						</div>
						<?php
						break;
					case 'block-style-4':
						$this->render_icon_image();
						if ( ! empty( $bigtitle ) ) {
							?>
							<div class="big-title"><?php echo esc_html( $bigtitle ); ?></div>
							<?php
						}
						?>
						<div class="content-wrap">
							<?php
							if ( ! empty( $subtitle ) ) {
								?>
								<div <?php $this->print_render_attribute_string( 'content_block_subtitle' ); ?>>
									<?php echo esc_html( $subtitle ); ?>
								</div>
								<?php
							}
							$this->render_content_block_title();
							$this->render_content_block_content();
							?>
							<div class="content-block-overlay"></div>
						</div>
						<?php
						break;
				}
				?>
			</div>
			<?php
		}

		/**
		 * Render Content block widget title.
		 *
		 * @access protected
		 */
		protected function render_content_block_title() {
			$settings      = $this->get_settings_for_display();
			$title         = ( isset( $settings['crafto_content_block_title'] ) && $settings['crafto_content_block_title'] ) ? $settings['crafto_content_block_title'] : '';
			$link_on_title = ( isset( $settings['crafto_content_block_title_link']['url'] ) && $settings['crafto_content_block_title_link']['url'] ) ? $settings['crafto_content_block_title_link']['url'] : '';

			if ( ! empty( $settings['crafto_content_block_title_link']['url'] ) ) {
				$this->add_link_attributes( '_links', $settings['crafto_content_block_title_link'] );
				$this->add_render_attribute( '_links', 'class', 'title-link' );
			}

			if ( ! empty( $title ) ) {
				?>
				<<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>
				<?php $this->print_render_attribute_string( 'content_block_title' ); ?>>
				<?php
				if ( '' !== $link_on_title ) {
					?>
					<a <?php $this->print_render_attribute_string( '_links' ); ?>>
						<?php echo esc_html( $title ); ?>
					</a>
					<?php
				} else {
					echo esc_html( $title );
				}
				?>
				</<?php echo $this->get_settings( 'crafto_header_size' ); // phpcs:ignore ?>>
				<?php
			}
		}

		/**
		 * Render Content block widget content.
		 *
		 * @access protected
		 */
		protected function render_content_block_content() {
			$settings = $this->get_settings_for_display();
			$content  = ( isset( $settings['crafto_content_block_content'] ) && $settings['crafto_content_block_content'] ) ? $settings['crafto_content_block_content'] : '';

			if ( ! empty( $content ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'content_block_content' ); ?>>
					<?php echo sprintf( '%s', wp_kses_post( $content ) ); // phpcs:ignore. ?>
				</div>
				<?php
			}
		}

		/**
		 * Render Content block widget icon or image.
		 *
		 * @access protected
		 */
		protected function render_icon_image() {
			$settings = $this->get_settings_for_display();

			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon' );

			if ( ! empty( $settings['icon'] ) ) {
				$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
				$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
			}

			$migrated = isset( $settings['__fa4_migrated']['crafto_content_block_icons'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			if ( ! empty( $settings['crafto_content_block_icons']['value'] ) ) {
				?>
				<div <?php $this->print_render_attribute_string( 'icon-wrapper' ); ?>>
					<?php
					if ( $is_new || $migrated ) {
						Icons_Manager::render_icon( $settings['crafto_content_block_icons'], [ 'aria-hidden' => 'true' ] );
					} elseif ( isset( $settings['crafto_content_block_icons']['value'] ) && ! empty( $settings['crafto_content_block_icons']['value'] ) ) {
						?>
						<i <?php $this->print_render_attribute_string( 'icon' ); ?>></i>
						<?php
					}
					?>
				</div>
				<?php
			} elseif ( ! empty( $settings['crafto_content_block_custom_image'] ) ) {
				?>
				<div class="elementor-icon">
					<?php
					if ( ! empty( $settings['crafto_content_block_image']['id'] ) && ! wp_attachment_is_image( $settings['crafto_content_block_image']['id'] ) ) {
						$settings['crafto_content_block_image']['id'] = '';
					}
					if ( isset( $settings['crafto_content_block_image'] ) && isset( $settings['crafto_content_block_image']['id'] ) && ! empty( $settings['crafto_content_block_image']['id'] ) ) {
						crafto_get_attachment_html( $settings['crafto_content_block_image']['id'], $settings['crafto_content_block_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					} elseif ( isset( $settings['crafto_content_block_image'] ) && isset( $settings['crafto_content_block_image']['url'] ) && ! empty( $settings['crafto_content_block_image']['url'] ) ) {
						crafto_get_attachment_html( $settings['crafto_content_block_image']['id'], $settings['crafto_content_block_image']['url'], $settings['crafto_thumbnail_size'] ); // phpcs:ignore
					}
					?>
				</div>
				<?php
			}
		}
	}
}
