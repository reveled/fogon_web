<?php
/**
 * WooCommerce Attributes Taxonomy
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crafto_Set_Attribute_Taxonomies' ) ) {
	/**
	 * Define Crafto_Set_Attribute_Taxonomies Class
	 */
	class Crafto_Set_Attribute_Taxonomies {

		/**
		 * Add WooCommerce Attributes.
		 *
		 * @param array $attributes Various type of Attributes.
		 */
		public function add_woocommerce_attribute_taxonomies( $attributes ) {
			global $wpdb;

			$transient_name = 'wc_attribute_taxonomies';
			delete_transient( $transient_name );
			// phpcs:ignore
			$wpdb->insert(
				$wpdb->prefix . 'woocommerce_attribute_taxonomies',
				array(
					'attribute_name'    => 'color',
					'attribute_label'   => 'Color',
					'attribute_type'    => 'select',
					'attribute_orderby' => 'menu_order',
					'attribute_public'  => '0',
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				),
			);

			register_taxonomy(
				'pa_color',
				'product',
				array(
					'label'        => esc_html__( 'Product', 'crafto-addons' ),
					'rewrite'      => array(
						'slug' => 'pa_color',
					),
					'hierarchical' => true,
				)
			);

			if ( ! empty( $attributes ) ) {
				foreach ( $attributes as $key => $value ) {
					// phpcs:ignore
					$wpdb->insert(
						$wpdb->prefix . 'woocommerce_attribute_taxonomies',
						array(
							'attribute_name'    => $key,
							'attribute_label'   => $value,
							'attribute_type'    => 'select',
							'attribute_orderby' => 'menu_order',
							'attribute_public'  => '0',
						),
						array(
							'%s',
							'%s',
							'%s',
							'%s',
							'%s',
						),
					);

					register_taxonomy(
						'pa_' . $key,
						'product',
						array(
							'label'        => $value,
							'rewrite'      => array(
								'slug' => 'pa_' . $key,
							),
							'hierarchical' => true,
						)
					);
				}
			}
			// phpcs:ignore
			$attribute_taxonomies = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'woocommerce_attribute_taxonomies' );
			set_transient( $transient_name, $attribute_taxonomies );
		}
	} // end of class

	new Crafto_Set_Attribute_Taxonomies();

} // end of class_exists
