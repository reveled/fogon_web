<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for property price.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_property_template() ) {
	return;
}

// If class `Property_Price` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Property_Price' ) ) {
	/**
	 * Define `Property_Price` class.
	 */
	class Property_Price extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-property-price';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Property Price', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-price-list crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/property-price/';
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
				'crafto-single',
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
				'rate',
				'amount',
				'price',
			];
		}

		/**
		 * Register property price widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_content_property',
				[
					'label' => esc_html__( 'Content', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'In Preview, property price detail are dummy, while the original property price detail is retrieved from the relevant post.', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_price',
				[
					'label' => esc_html__( 'Price', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .property-price',
				]
			);

			$this->add_control(
				'crafto_price_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-price' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_price_spacing',
				[
					'label'     => esc_html__( 'Spacing', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .property-price' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_price_label',
				[
					'label' => esc_html__( 'Label', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_price_label_typography',
					'selector' => '{{WRAPPER}} .property-price-label',
				]
			);

			$this->add_control(
				'crafto_price_label_meta_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-price-label' => 'color: {{VALUE}};',
					],
				]
			);

			$this->end_controls_section();
		}

		/**
		 * Render icon property price widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$crafto_property_price      = crafto_post_meta( 'crafto_property_price' );
			$crafto_property_price_text = crafto_post_meta( 'crafto_property_price_text' );

			$crafto_property_price_output      = '';
			$crafto_property_price_text_output = '';

			if ( crafto_is_editor_mode() ) {
				$crafto_property_price_output      = esc_html__( '$1,00,000', 'crafto-addons' );
				$crafto_property_price_text_output = esc_html__( '$3,700 - Per sq. ft.', 'crafto-addons' );
			} else {
				$crafto_property_price_output      = $crafto_property_price;
				$crafto_property_price_text_output = $crafto_property_price_text;
			}

			if ( ! empty( $crafto_property_price_output ) ) {
				?>
				<div class="property-price">
					<?php echo esc_html( $crafto_property_price_output ); ?>
				</div>
				<?php
			}

			if ( ! empty( $crafto_property_price_text_output ) ) {
				?>
				<span class="property-price-label">
					<?php echo esc_html( $crafto_property_price_text_output ); ?>
				</span>
				<?php
			}
		}
	}
}
