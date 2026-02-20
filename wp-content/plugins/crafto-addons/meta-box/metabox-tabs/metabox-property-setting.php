<?php
/**
 * Metabox For Property Setting.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
crafto_after_main_separator_start(
	'separator_main_start',
	''
);

$crafto_property_status = array(
	'rent' => esc_html__( 'Rent', 'crafto-addons' ),
	'sell' => esc_html__( 'Sell', 'crafto-addons' ),
);

crafto_meta_box_dropdown(
	'crafto_property_status_single',
	apply_filters( 'crafto_property_status_meta_label', esc_html__( 'Property Listing Type', 'crafto-addons' ) ),
	apply_filters( 'crafto_property_status_list', $crafto_property_status ), // phpcs:ignore
	esc_html__( 'Choose whether the property is for sale or rent.', 'crafto-addons' ),
);
crafto_meta_box_text(
	'crafto_property_price_single',
	apply_filters( 'crafto_property_total_price_meta_label', esc_html__( 'Total Price', 'crafto-addons' ) ),
	esc_html__( 'Enter the total price of the property.', 'crafto-addons' ),
	'',
	'',
	esc_html__( 'e.g. $6,95,000', 'crafto-addons' ),
);
crafto_meta_box_text(
	'crafto_property_price_text_single',
	apply_filters( 'crafto_property_price_meta_label', esc_html__( 'Price per Unit', 'crafto-addons' ) ),
	esc_html__( 'Enter the price per unit (e.g. sq ft, sq m).', 'crafto-addons' ),
	'',
	'',
	esc_html__( 'e.g. $3,700 - Per sq. ft.', 'crafto-addons' ),
);
crafto_meta_box_upload_multiple(
	'crafto_property_multiple_image_single',
	apply_filters( 'crafto_property_gallery_image_meta_label', esc_html__( 'Property Gallery Images', 'crafto-addons' ) ),
	esc_html__( 'Add property multiple images.', 'crafto-addons' ),
);
crafto_meta_box_number(
	'crafto_property_no_of_bedrooms_single',
	apply_filters( 'crafto_property_no_of_bedroom_meta_label', esc_html__( 'Bedrooms', 'crafto-addons' ) ),
	esc_html__( 'How many bedrooms you want.', 'crafto-addons' ),
);
crafto_meta_box_number(
	'crafto_property_no_of_bathrooms_single',
	apply_filters( 'crafto_property_no_of_bathroom_meta_label', esc_html__( 'Bathrooms', 'crafto-addons' ) ),
	esc_html__( 'How many bathrooms you want.', 'crafto-addons' ),
);
crafto_meta_box_text(
	'crafto_property_size_single',
	apply_filters( 'crafto_property_size_meta_label', esc_html__( 'Property Size', 'crafto-addons' ) ),
	esc_html__( 'Add property size in sq ft.', 'crafto-addons' ),
	'',
	'',
	esc_html__( 'e.g. 700sq ft', 'crafto-addons' ),
);
crafto_meta_box_text(
	'crafto_property_year_built_single',
	apply_filters( 'crafto_property_year_built_meta_label', esc_html__( 'Year of Build', 'crafto-addons' ) ),
	esc_html__( 'Enter the year the property was built.', 'crafto-addons' ),
	'',
	'',
	esc_html__( 'e.g. 2016', 'crafto-addons' ),
);
crafto_meta_box_text(
	'crafto_property_address_single',
	apply_filters( 'crafto_property_address_meta_label', esc_html__( 'Full Address', 'crafto-addons' ) ),
	esc_html__( 'Enter the full address of the property.', 'crafto-addons' ),
	'',
	'',
	'',
);
crafto_before_main_separator_end(
	'separator_main_end',
	''
);
