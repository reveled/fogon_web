<?php
/**
 * Metabox For Tour Setting.
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

crafto_meta_box_text(
	'crafto_single_tours_destination_single',
	apply_filters( 'crafto_tour_destination_meta_label', esc_html__( 'Tour Destination', 'crafto-addons' ) ),
	esc_html__( 'Enter the destination for the tour.', 'crafto-addons' ),
	'',
);

crafto_meta_box_text(
	'crafto_single_tours_days_single',	
	apply_filters( 'crafto_tour_duration_meta_label', esc_html__( 'Tour Duration', 'crafto-addons' ) ),
	esc_html__( 'Enter the total number of days for the tour, e.g. 10 days.', 'crafto-addons' ),
	'',
);

crafto_meta_box_text(
	'crafto_single_tours_price_single',	
	apply_filters( 'crafto_tour_price_meta_label', esc_html__( 'Tour Price', 'crafto-addons' ) ),
	esc_html__( 'Enter the per person price for the tour.', 'crafto-addons' ),
	'',
);

crafto_meta_box_text(
	'crafto_single_tours_discount_price_single',
	apply_filters( 'crafto_tour_discount_price_meta_label', esc_html__( 'Discounted Tour Price', 'crafto-addons' ) ),
	esc_html__( 'Enter the discounted per person price for the tour.', 'crafto-addons' ),
	'',
);
crafto_meta_box_number(
	'crafto_single_tours_star_rating_single',	
	apply_filters( 'crafto_tour_star_rating_meta_label', esc_html__( 'Star Rating', 'crafto-addons' ) ),
	esc_html__( 'Set the star rating for this tour (1-5 stars).', 'crafto-addons' ),
	'',
);

crafto_meta_box_text(
	'crafto_single_tours_review_single',	
	apply_filters( 'crafto_tour_review_meta_label', esc_html__( 'Review Count', 'crafto-addons' ) ),
	esc_html__( 'Enter the total number of reviews for this tour.', 'crafto-addons' ),
	'',
);
crafto_before_main_separator_end(
	'separator_main_end',
	''
);
