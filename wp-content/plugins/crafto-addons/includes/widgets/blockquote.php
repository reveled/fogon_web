<?php
namespace CraftoAddons\Widgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for blockquote.
 *
 * @package Crafto
 */

// If class `Blockquote` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Blockquote' ) ) {
	/**
	 * Define `Blockquote` class.
	 */
	class Blockquote extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-blockquote';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Blockquote', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-blockquote crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/blockquote/';
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
				'testimonial',
				'citation',
				'box',
				'text',
				'highlighted',
			];
		}

		/**
		 * Register blockquote widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {
			$this->start_controls_section(
				'crafto_blockquote_general_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_blockquote_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
					'label_block'      => false,
				]
			);
			$this->add_control(
				'crafto_blockquote_content',
				[
					'label'   => esc_html__( 'Content', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXTAREA,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'crafto-addons' ),
					'rows'    => 10,
				]
			);

			$this->add_control(
				'crafto_blockquote_author_name',
				[
					'label'   => esc_html__( 'Author', 'crafto-addons' ),
					'type'    => Controls_Manager::TEXT,
					'dynamic' => [
						'active' => true,
					],
					'default' => esc_html__( 'Colene Landin', 'crafto-addons' ),
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_blockquote_general_style_section',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_text_align',
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
					'selectors' => [
						'{{WRAPPER}} .elementor-blockquote' => 'text-align: {{VALUE}}',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_blockquote_border',
					'selector' => '{{WRAPPER}} blockquote',
				]
			);

			$this->add_responsive_control(
				'crafto_blockquote_padding',
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
						'{{WRAPPER}} blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_margin',
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
						'{{WRAPPER}} blockquote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_blockquote_icon_style_section',
				[
					'label'     => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'crafto_blockquote_icon[value]!' => '',
					],
				]
			);
			$this->add_control(
				'crafto_blockquote_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} blockquote i'   => 'color: {{VALUE}}',
						'{{WRAPPER}} blockquote svg' => 'fill: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_icon_size',
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
							'min' => 0,
							'max' => 100,
						],
						'%'  => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} blockquote i'   => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} blockquote svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_icon_padding',
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
						'{{WRAPPER}} blockquote i, {{WRAPPER}} blockquote svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_icon_margin',
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
						'{{WRAPPER}} blockquote i, {{WRAPPER}} blockquote svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_blockquote_content_style_section',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blockquote_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_TEXT,
					],
					'selector' => '{{WRAPPER}} blockquote > p',
				]
			);
			$this->add_control(
				'crafto_blockquote_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} blockquote > p' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_content_padding',
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
						'{{WRAPPER}} blockquote > p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_content_margin',
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
						'{{WRAPPER}} blockquote > p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_blockquote_author_style_section',
				[
					'label' => esc_html__( 'Author', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_blockquote_author_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} blockquote footer',
				]
			);
			$this->add_control(
				'crafto_blockquote_author_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} blockquote footer' => 'color: {{VALUE}}',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_author_padding',
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
						'{{WRAPPER}} blockquote footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_blockquote_author_margin',
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
						'{{WRAPPER}} blockquote footer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render blockquote widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @since 1.0
		 * @access protected
		 */
		protected function render() {
			$settings = $this->get_settings_for_display();
			$migrated = isset( $settings['__fa4_migrated']['crafto_blockquote_icon'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			$this->add_inline_editing_attributes( 'crafto_blockquote_content' );
			$this->add_inline_editing_attributes( 'crafto_blockquote_author_name', 'none' );

			if ( ! empty( $settings['crafto_blockquote_content'] ) || ! empty( $settings['crafto_blockquote_author_name'] ) || ! empty( $settings['icon'] ) || ! empty( $settings['crafto_blockquote_icon']['value'] ) ) {
				?>
				<blockquote class="elementor-blockquote">
					<?php
					if ( ! empty( $settings['icon'] ) || ! empty( $settings['crafto_blockquote_icon']['value'] ) ) {
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings['crafto_blockquote_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['crafto_blockquote_icon']['value'] ) && ! empty( $settings['crafto_blockquote_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings['crafto_blockquote_icon'] ); ?>" aria-hidden="true"></i>
							<?php
						}
					}

					if ( ! empty( $settings['crafto_blockquote_content'] ) ) {
						?>
						<p><?php echo sprintf( '%s', $settings['crafto_blockquote_content'] ); // phpcs:ignore ?></p>
						<?php
					}
					if ( ! empty( $settings['crafto_blockquote_author_name'] ) ) {
						?>
						<footer><?php echo esc_html( $settings['crafto_blockquote_author_name'] ); ?></footer>
						<?php
					}
					?>
				</blockquote>
				<?php
			}
		}
	}
}
