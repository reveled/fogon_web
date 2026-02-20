<?php
namespace CraftoAddons\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Crafto widget for property meta.
 *
 * @package Crafto
 */

if ( \Elementor\Plugin::instance()->editor->is_edit_mode() && class_exists( 'Crafto_Builder_Helper' ) && ! \Crafto_Builder_Helper::is_theme_builder_single_property_template() ) {
	return;
}

// If class `Property_Meta` doesn't exists yet.
if ( ! class_exists( 'CraftoAddons\Widgets\Property_Meta' ) ) {
	/**
	 * Define `Property_Meta` class.
	 */
	class Property_Meta extends Widget_Base {
		/**
		 * Retrieve the list of styles the property meta widget depended on.
		 *
		 * Used to set styles dependencies required to run the widget.
		 *
		 * @access public
		 *
		 * @return array Widget styles dependencies.
		 */
		public function get_style_depends() {
			if ( \Crafto_Addons_Extra_Functions::crafto_editor_load_compressed_assets() ) {
				return [ 'crafto-widgets' ];
			} else {
				return [ 'crafto-property-meta-widget' ];
			}
		}

		/**
		 * Retrieve the widget name.
		 *
		 * @access public
		 *
		 * @return string Widget name.
		 */
		public function get_name() {
			return 'crafto-property-meta';
		}

		/**
		 * Retrieve the widget title.
		 *
		 * @access public
		 *
		 * @return string Widget title.
		 */
		public function get_title() {
			return esc_html__( 'Crafto Property Meta', 'crafto-addons' );
		}

		/**
		 * Retrieve the widget icon.
		 *
		 * @access public
		 *
		 * @return string Widget icon.
		 */
		public function get_icon() {
			return 'eicon-meta-data crafto-element-icon';
		}
		/**
		 * Retrieve the custom help url.
		 *
		 * @access public
		 *
		 * @return string url.
		 */
		public function get_custom_help_url() {
			return 'https://crafto.themezaa.com/documentation/property-meta/';
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
				'property meta',
				'property details',
				'details',
				'real estate data',
			];
		}

		/**
		 * Register property meta widget controls.
		 *
		 * Adds different input fields to allow the user to change and customize the widget settings.
		 *
		 * @access protected
		 */
		protected function register_controls() {

			$this->start_controls_section(
				'crafto_section_content_property',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
				]
			);
			$this->add_control(
				'crafto_note',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( esc_html__( 'In Preview, property meta details are dummy, while the original property meta information is retrieved from the relevant post.', 'crafto-addons' ) ),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);

			$repeater = new Repeater();

			$repeater->add_control(
				'crafto_property_meta_type',
				[
					'label'         => esc_html__( 'Meta Type', 'crafto-addons' ),
					'type'          => Controls_Manager::SELECT,
					'default'       => 'size',
					'options'       => [
						'status'   => esc_html__( 'Status', 'crafto-addons' ),
						'size'     => esc_html__( 'Size', 'crafto-addons' ),
						'type'     => esc_html__( 'Types', 'crafto-addons' ),
						'price'    => esc_html__( 'Price', 'crafto-addons' ),
						'bedroom'  => esc_html__( 'Bedrooms', 'crafto-addons' ),
						'bathroom' => esc_html__( 'Bathrooms', 'crafto-addons' ),
						'year'     => esc_html__( 'Year', 'crafto-addons' ),
					],
					'prevent_empty' => false,
				]
			);

			$repeater->add_control(
				'crafto_property_meta_label',
				[
					'label'       => esc_html__( 'Label', 'crafto-addons' ),
					'type'        => Controls_Manager::TEXT,
					'dynamic'     => [
						'active' => true,
					],
					'label_block' => true,
					'default'     => esc_html__( 'Dummy title', 'crafto-addons' ),
				]
			);

			$this->add_control(
				'crafto_property_meta_obj',
				[
					'label'       => esc_html__( 'Property Meta Items', 'crafto-addons' ),
					'type'        => Controls_Manager::REPEATER,
					'show_label'  => false,
					'fields'      => $repeater->get_controls(),
					'default'     => [
						[
							'crafto_property_meta_type' => 'size',
							'crafto_property_meta_type' => 'price',
							'crafto_property_meta_type' => 'year',
							'crafto_property_meta_type' => 'status',
						],
						[
							'crafto_property_meta_type' => 'size',
							'crafto_property_meta_type' => 'price',
							'crafto_property_meta_type' => 'year',
							'crafto_property_meta_type' => 'status',
						],
						[
							'crafto_property_meta_type' => 'size',
							'crafto_property_meta_type' => 'price',
							'crafto_property_meta_type' => 'year',
							'crafto_property_meta_type' => 'status',
						],
						[
							'crafto_property_meta_type' => 'size',
							'crafto_property_meta_type' => 'price',
							'crafto_property_meta_type' => 'year',
							'crafto_property_meta_type' => 'status',
						],
					],
					'title_field' => '<span style="text-transform: capitalize">{{{ crafto_property_meta_type }}}</span>',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'crafto_section_style_general',
				[
					'label' => esc_html__( 'General', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'crafto_meta_border_color',
				[
					'label'     => esc_html__( 'Separator Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-meta-box' => 'border-right-color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'crafto_meta_border_width',
				[
					'label'     => esc_html__( 'Separator Width', 'crafto-addons' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .property-meta-box' => 'border-right-width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_property_meta_padding',
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
						'{{WRAPPER}} .property-meta-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'crafto_property_meta_margin',
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
						'{{WRAPPER}} .property-meta-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'crafto_property_meta_border',
					'default'  => '1px',
					'selector' => '{{WRAPPER}} .property-meta-wrapper',
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_title',
				[
					'label' => esc_html__( 'Title', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_meta_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .property-meta-box',
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_meta_text_shadow',
					'selector' => '{{WRAPPER}} .property-meta-box',
				]
			);
			$this->add_control(
				'crafto_meta_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-meta-box' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'crafto_section_style_label',
				[
					'label' => esc_html__( 'Label', 'crafto-addons' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'crafto_meta_label_typography',
					'global'   => [
						'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
					],
					'selector' => '{{WRAPPER}} .property-meta-box .property-label',
				]
			);
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'crafto_meta_label_shadow',
					'selector' => '{{WRAPPER}} .property-meta-box .property-label',
				]
			);
			$this->add_control(
				'crafto_meta_label_color',
				[
					'label'     => esc_html__( 'Color', 'crafto-addons' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .property-meta-box .property-label' => 'color: {{VALUE}};',
					],
				]
			);
			$this->end_controls_section();
		}

		/**
		 * Render property meta widget output on the frontend.
		 *
		 * Written in PHP and used to generate the final HTML.
		 *
		 * @access protected
		 */
		protected function render() {

			$settings                        = $this->get_settings_for_display();
			$crafto_property_types           = get_terms( 'properties-types' );
			$crafto_property_price           = crafto_post_meta( 'crafto_property_price' );
			$crafto_property_status          = crafto_post_meta( 'crafto_property_status' );
			$crafto_property_year_built      = crafto_post_meta( 'crafto_property_year_built' );
			$crafto_property_size            = crafto_post_meta( 'crafto_property_size' );
			$crafto_property_no_of_bedrooms  = crafto_post_meta( 'crafto_property_no_of_bedrooms' );
			$crafto_property_no_of_bathrooms = crafto_post_meta( 'crafto_property_no_of_bathrooms' );

			$crafto_cat_output = '';
			if ( ! empty( $crafto_property_types ) ) {
				$count = 0;
				foreach ( $crafto_property_types as $types ) {
					if ( 1 === $count ) {
						break;
					}
					$crafto_cat_output .= '<a href="' . esc_url( get_category_link( $types->term_id ) ) . '">' . esc_html( $types->name ) . '</a>';
					++$count;
				}
			}
			?>
			<div class="property-meta-wrapper">
					<div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2">
					<?php
					if ( crafto_is_editor_mode() ) {
						foreach ( $settings['crafto_property_meta_obj'] as $item ) {
							?>
							<div class="col alt-font property-meta-box">
								<span class="property-label"><?php echo esc_html__( 'Dummy Content:', 'crafto-addons' ); ?></span>
								<?php echo esc_html__( 'Dummy Area', 'crafto-addons' ); ?>
							</div>
							<?php
						}
					} elseif ( ! empty( $settings['crafto_property_meta_obj'] ) ) {
						foreach ( $settings['crafto_property_meta_obj'] as $item ) {
								$crafto_property_meta_type = ! empty( $item['crafto_property_meta_type'] ) && isset( $item['crafto_property_meta_type'] ) ? $item['crafto_property_meta_type'] : '';

								$crafto_property_val = '';

							switch ( $crafto_property_meta_type ) {
								case 'size':
										$crafto_property_val = $crafto_property_size;
									break;
								case 'type':
										$crafto_property_val = $crafto_cat_output;
									break;
								case 'price':
										$crafto_property_val = $crafto_property_price;
									break;
								case 'status':
										$crafto_property_val = ucfirst( $crafto_property_status );
									break;
								case 'bedroom':
										$crafto_property_val = $crafto_property_no_of_bedrooms;
									break;
								case 'bathroom':
										$crafto_property_val = $crafto_property_no_of_bathrooms;
									break;
								case 'year':
										$crafto_property_val = $crafto_property_year_built;
									break;
								case 'land-area':
										$crafto_property_val = $crafto_property_size;
									break;
							}

							if ( ! empty( $crafto_property_val ) ) {
								?>
								<div class="col alt-font property-meta-box">
									<span class="property-label"><?php echo esc_html( $item['crafto_property_meta_label'] ); ?></span>
									<?php echo sprintf( '%s', $crafto_property_val); // phpcs:ignore ?>
								</div>
								<?php
							}
						}
					}
					?>
					</div>
			</div>
			<?php
		}
	}
}
