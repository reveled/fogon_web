<?php
/**
 * Register Custom Post Type - "Tour".
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tour custom post type
 */
$labels = array(
	'name'               => _x( 'Tour', 'Tour', 'crafto-addons' ),
	'singular_name'      => _x( 'Tour', 'Tour', 'crafto-addons' ),
	'add_new'            => _x( 'Add New Tour', 'Tour', 'crafto-addons' ),
	'add_new_item'       => esc_html__( 'Add New Tour', 'crafto-addons' ),
	'edit_item'          => esc_html__( 'Edit Tour', 'crafto-addons' ),
	'new_item'           => esc_html__( 'New Tour', 'crafto-addons' ),
	'all_items'          => esc_html__( 'All Tour', 'crafto-addons' ),
	'view_item'          => esc_html__( 'View Tour', 'crafto-addons' ),
	'search_items'       => esc_html__( 'Search Tour', 'crafto-addons' ),
	'not_found'          => esc_html__( 'No Tour Found', 'crafto-addons' ),
	'not_found_in_trash' => esc_html__( 'No Tour Found in the Trash', 'crafto-addons' ),
	'parent_item_colon'  => '',
	'menu_name'          => esc_html__( 'Tour', 'crafto-addons' ),
);

$args = array(
	'labels'        => $labels,
	'description'   => esc_html__( 'Holds our tour and tour specific data', 'crafto-addons' ),
	'public'        => true,
	'menu_icon'     => 'dashicons-location',
	'menu_position' => 21,
	'show_in_rest'  => true,
	'show_ui'       => true,
	'supports'      => array(
		'title',
		'thumbnail',
		'editor',
		'author',
		'excerpt',
		'comments',
		'revisions',
		'page-attributes',
		'elementor',
	),
	'has_archive'   => true,
	'hierarchical'  => true,
);

$crafto_tours_url_slug = get_theme_mod( 'crafto_tours_url_slug', '' );
if ( ! empty( $crafto_tours_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_tours_url_slug ),
	);
}

register_post_type( 'tours', $args );

/**
 * Tour Destinations
 */
$labels = array(
	'name'              => _x( 'Destinations', 'taxonomy general name', 'crafto-addons' ),
	'singular_name'     => _x( 'Destination', 'taxonomy singular name', 'crafto-addons' ),
	'search_items'      => esc_html__( 'Search Destinations', 'crafto-addons' ),
	'all_items'         => esc_html__( 'All Destinations', 'crafto-addons' ),
	'parent_item'       => esc_html__( 'Parent Destination', 'crafto-addons' ),
	'parent_item_colon' => esc_html__( 'Parent Destination:', 'crafto-addons' ),
	'edit_item'         => esc_html__( 'Edit Destination', 'crafto-addons' ),
	'update_item'       => esc_html__( 'Update Destination', 'crafto-addons' ),
	'add_new_item'      => esc_html__( 'Add New Destination', 'crafto-addons' ),
	'new_item_name'     => esc_html__( 'New Destination Name', 'crafto-addons' ),
	'menu_name'         => esc_html__( 'Destinations', 'crafto-addons' ),
);

$args = array(
	'labels'            => $labels,
	'public'            => true,
	'show_ui'           => true,
	'hierarchical'      => true,
	'show_admin_column' => true,
	'show_in_nav_menus' => true,
	'show_in_rest'      => true,
);

$crafto_tours_destinations_url_slug = get_theme_mod( 'crafto_tours_destinations_url_slug', '' );
if ( ! empty( $crafto_tours_destinations_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_tours_destinations_url_slug ),
	);
}

register_taxonomy( 'tour-destination', 'tours', $args );

/**
 * Tour Activities
 */

$labels = array(
	'name'              => _x( 'Activities', 'taxonomy general name', 'crafto-addons' ),
	'singular_name'     => _x( 'Activity', 'taxonomy singular name', 'crafto-addons' ),
	'search_items'      => esc_html__( 'Search activities', 'crafto-addons' ),
	'all_items'         => esc_html__( 'All Activities', 'crafto-addons' ),
	'parent_item'       => esc_html__( 'Parent Activity', 'crafto-addons' ),
	'parent_item_colon' => esc_html__( 'Parent Activity:', 'crafto-addons' ),
	'edit_item'         => esc_html__( 'Edit Activity', 'crafto-addons' ),
	'update_item'       => esc_html__( 'Update Activity', 'crafto-addons' ),
	'add_new_item'      => esc_html__( 'Add New Activity', 'crafto-addons' ),
	'new_item_name'     => esc_html__( 'New Activity Name', 'crafto-addons' ),
	'menu_name'         => esc_html__( 'Activities', 'crafto-addons' ),
);

$args = array(
	'labels'            => $labels,
	'public'            => true,
	'show_ui'           => true,
	'hierarchical'      => true,
	'show_admin_column' => true,
	'show_in_nav_menus' => true,
	'show_in_rest'      => true,
);

$crafto_tours_activities_url_slug = get_theme_mod( 'crafto_tours_activities_url_slug', '' );
if ( ! empty( $crafto_tours_activities_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_tours_activities_url_slug ),
	);
}

register_taxonomy( 'tour-activity', 'tours', $args );
