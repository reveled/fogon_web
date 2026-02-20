<?php
/**
 * Metabox For Custom CSS.
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
crafto_meta_box_custom_css(
	'crafto_performance_custom_css',
	esc_html__( 'Custom CSS', 'crafto-addons' ),
	esc_html__( 'Add custom CSS styles specific to this post or page.', 'crafto-addons' ),
);
crafto_before_main_separator_end(
	'separator_main_end',
	''
);
