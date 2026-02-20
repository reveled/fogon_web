<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 *
 * Crafto widget for property address.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_property_template() ) {
	return;
}

// If class `Property_Address` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Property_Address' ) ) {
	/**
	 * Define `Property_Address` class.
	 */
	class Property_Address extends Widget_Base {

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-property-address';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Property Address', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-text crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/property-address/';
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
				'location',
				'map',
				'place',
				'property location',
				'address display',
			];
		}

		/**
		 * Register property address widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_content_address',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'In Preview, property address is dummy, while the original property address is retrieved from the relevant property post.', 'crafto-addons' ) ),
					'separator'       => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);

			$this->add_control(
				'crafto_selected_icon',
				[
					'label'            => esc_html__( 'Icon', 'crafto-addons' ),
					'type'             => Controls_Manager::ICONS,
					'label_block'      => false,
					'fa4compatibility' => 'icon',
					'skin'             => 'inline',
				]
			);
			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_icon',
				[
					'label' => esc_html__( 'Icon', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'crafto_icon_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-location i' => 'color: {{VALUE}};',
						'{{WRAPPER}} .property-location svg' => 'fill: {{VALUE}};',
					],
				]
			);

			$this->add_responsive_control(
				'crafto_icon_size',
				[
					'label'     => esc_html__( 'Size', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .property-location i' => 'font-size: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .property-location svg' => 'width: {{SIZE}}{{UNIT}};',
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
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .property-location i' => 'margin-right: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}} .property-location svg' => 'margin-right: {{SIZE}}{{UNIT}};',
						'.rtl {{WRAPPER}} .property-location i, .rtl {{WRAPPER}} .property-location svg' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_title',
				[
					'label' => esc_html__( 'Address', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_title_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
					],
					'selector' => '{{WRAPPER}} .property-location',
				]
			);
			$this->add_control(
				'crafto_text_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-location' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render property address widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings = $this->get_settings_for_display();
			$migrated = isset( $settings['__fa4_migrated']['crafto_selected_icon'] );
			$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

			$crafto_property_address = crafto_post_meta( 'crafto_property_address' );

			$crafto_property_address_output = '';
			$crafto_property_address_arry   = array();

			if ( ! empty( $crafto_property_address ) ) {
				$crafto_property_address_arry[] = $crafto_property_address;
			}

			$crafto_property_address_str = ! empty( $crafto_property_address_arry ) ? implode( ' ', $crafto_property_address_arry ) : '';

			if ( crafto_is_editor_mode() ) { // phpcs:ignore
				$crafto_property_address_output = esc_html__( '4403 Pick street plensant view, New york', 'crafto-addons' );
			} else {
				$crafto_property_address_output = $crafto_property_address_str;
			}

			if ( ! empty( $crafto_property_address_output ) ) {
				?>
				<div class="property-location">
					<?php
					if ( ! empty( $settings['crafto_selected_icon'] ) || ! empty( $settings['crafto_selected_icon'] ) ) {
						if ( $is_new || $migrated ) {
							Icons_Manager::render_icon( $settings['crafto_selected_icon'], [ 'aria-hidden' => 'true' ] );
						} elseif ( isset( $settings['crafto_selected_icon']['value'] ) && ! empty( $settings['crafto_selected_icon']['value'] ) ) {
							?>
							<i class="<?php echo esc_attr( $settings['crafto_selected_icon']['value'] ); ?>" aria-hidden="true"></i>
							<?php
						}
					}
					echo esc_html( $crafto_property_address_output );
					?>
				</div>
				<?php
			}
		}
	}
}
