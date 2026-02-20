<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

/**
 * Crafto widget for inline SVG.
 *
 * @package Crafto
 */

// If class 'Inline_SVG' doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Inline_SVG' ) ) {
	/**
	 * Define 'Inline_SVG' class.
	 */
	class Inline_SVG extends Widget_Base {

		/**
		 * Get widget name.
		 *
		 * Retrieve inline SVG widget name.
		 */
		public function get_name() {
			return 'crafto-inline-svg';
		}

		/**
		 * Get widget title.
		 * Retrieve inline SVG widget title.
		 *
		 * @access public
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Inline SVG', 'crafto-addons' );
		}

		/**
		 * Get widget icon.
		 * Retrieve inline SVG widget icon.
		 *
		 * @access public
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-notification crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/inline-svg/';
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
				'SVG',
				'icon',
				'vector',
				'custom',
				'graphic',
				'canvas',
			];
		}

		/**
		 * Register inline SVG widget controls.
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_section_svg',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_custom_svg',
				[
					'label'      => esc_html__( 'SVG Code', 'crafto-addons' ),
					'type'       => Controls_Manager::TEXTAREA,
					'show_label' => true,
					'dynamic'    => [
						'active' => true,
					],
					'rows'       => 10,
				]
			);
			$this->add_control(
				'crafto_inline_svg_link',
				[
					'label'       => esc_html__( 'Link', 'crafto-addons' ),
					'type'        => Controls_Manager::URL,
					'dynamic'     => [
						'active' => true,
					],
					'placeholder' => esc_html__( 'https://your-link.com', 'crafto-addons' ),
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_icon',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_inline_svg_text_align',
				[
					'label'     => esc_html__( 'Alignment', 'crafto-addons' ),
					'type'      => Controls_Manager::CHOOSE,
					'options'   => [
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
					'selectors_dictionary' => [
						'left' => is_rtl() ? 'start' : 'left',
						'right' => is_rtl() ? 'end': 'right',
					],
					'default'   => 'center',
					'selectors' => [
						'{{WRAPPER}} .custom-svg-icon' => 'text-align: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'crafto_inline_svg_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'global'    => [
						'default' => Global_Colors::COLOR_PRIMARY,
					],
					'selectors' => [
						'{{WRAPPER}} .custom-svg-icon svg' => 'fill: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'eael_inline_svg_size',
				[
					'label'      => esc_html__( 'Size', 'crafto-addons' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [
						'px',
						'%',
					],
					'range'      => [
						'px' => [
							'min'  => 1,
							'max'  => 500,
							'step' => 1,
						],
					],
					'default'    => [
						'size' => 100,
					],
					'selectors'  => [
						'{{WRAPPER}} .custom-svg-icon svg' => 'font-size: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render inline svg widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {
			$icon_tag = '';
			$settings = $this->get_settings_for_display();

			$this->add_render_attribute(
				'crafto_custom_svg',
				'class',
				[
					'custom-svg-icon',
				]
			);
			$icon_tag = 'a';
			$this->add_link_attributes( 'crafto_inline_svg_link', $settings['crafto_inline_svg_link'] );
			$link_attributes = $this->get_render_attribute_string( 'crafto_inline_svg_link' );

			if ( ! empty( $settings['crafto_custom_svg'] ) ) :
				?>
				<div <?php $this->print_render_attribute_string( 'crafto_custom_svg' ); ?>>
					<?php
					if ( ! empty( $settings['crafto_inline_svg_link']['url'] ) ) {
						?>
						<<?php echo implode( ' ', [ $icon_tag, $link_attributes ] ); // phpcs:ignore ?>>
						<?php
					}
					?>
					<?php echo sprintf( '%s', $settings['crafto_custom_svg'] );// phpcs:ignore ?>
					</<?php echo $icon_tag; // phpcs:ignore ?>>		
				</div>
				<?php
			endif;
		}
	}
}
