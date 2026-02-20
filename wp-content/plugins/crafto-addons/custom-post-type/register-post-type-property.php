<?php
/**
 * Register Custom Post Type - "Property".
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Property custom post type
 */
$labels = array(
	'name'               => _x( 'Property', 'Projects', 'crafto-addons' ),
	'singular_name'      => _x( 'Property', 'Project', 'crafto-addons' ),
	'add_new'            => _x( 'Add New', 'Project', 'crafto-addons' ),
	'add_new_item'       => esc_html__( 'Add New Property', 'crafto-addons' ),
	'edit_item'          => esc_html__( 'Edit Property', 'crafto-addons' ),
	'new_item'           => esc_html__( 'New Property', 'crafto-addons' ),
	'all_items'          => esc_html__( 'All Properties', 'crafto-addons' ),
	'view_item'          => esc_html__( 'View Property', 'crafto-addons' ),
	'search_items'       => esc_html__( 'Search Properties', 'crafto-addons' ),
	'not_found'          => esc_html__( 'No Property found', 'crafto-addons' ),
	'not_found_in_trash' => esc_html__( 'No Property found in the Trash', 'crafto-addons' ),
	'parent_item_colon'  => '',
	'menu_name'          => esc_html__( 'Property', 'crafto-addons' ),
);

$args = array(
	'labels'        => $labels,
	'description'   => esc_html__( 'Holds our properties and property specific data', 'crafto-addons' ),
	'public'        => true,
	'menu_icon'     => 'dashicons-building',
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

$crafto_property_url_slug = get_theme_mod( 'crafto_property_url_slug', '' );

if ( ! empty( $crafto_property_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_property_url_slug ),
	);
}

register_post_type( 'properties', $args );

/**
 * Property types
 */
$labels = array(
	'name'              => _x( 'Property Types', 'taxonomy general name', 'crafto-addons' ),
	'singular_name'     => _x( 'Property Types', 'taxonomy singular name', 'crafto-addons' ),
	'search_items'      => esc_html__( 'Search Types', 'crafto-addons' ),
	'all_items'         => esc_html__( 'All Property Types', 'crafto-addons' ),
	'parent_item'       => esc_html__( 'Parent Property Type', 'crafto-addons' ),
	'parent_item_colon' => esc_html__( 'Parent Property Type:', 'crafto-addons' ),
	'edit_item'         => esc_html__( 'Edit Property Type', 'crafto-addons' ),
	'update_item'       => esc_html__( 'Update Property Type', 'crafto-addons' ),
	'add_new_item'      => esc_html__( 'Add New Property Type', 'crafto-addons' ),
	'new_item_name'     => esc_html__( 'New Property Type Name', 'crafto-addons' ),
	'menu_name'         => esc_html__( 'Property Types', 'crafto-addons' ),
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

$crafto_property_types_url_slug = get_theme_mod( 'crafto_property_types_url_slug', '' );
if ( ! empty( $crafto_property_types_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_property_types_url_slug ),
	);
}

register_taxonomy( 'properties-types', 'properties', $args );

/**
 * Property Agent
 */

$labels = array(
	'name'              => _x( 'Property Agents', 'taxonomy general name', 'crafto-addons' ),
	'singular_name'     => _x( 'Property Agent', 'taxonomy singular name', 'crafto-addons' ),
	'search_items'      => esc_html__( 'Search Property Agents', 'crafto-addons' ),
	'all_items'         => esc_html__( 'All Property Agents', 'crafto-addons' ),
	'parent_item'       => esc_html__( 'Parent Property Agent', 'crafto-addons' ),
	'parent_item_colon' => esc_html__( 'Parent Property Agent:', 'crafto-addons' ),
	'edit_item'         => esc_html__( 'Edit Property Agent', 'crafto-addons' ),
	'update_item'       => esc_html__( 'Update Property Agent', 'crafto-addons' ),
	'add_new_item'      => esc_html__( 'Add New Property Agent', 'crafto-addons' ),
	'new_item_name'     => esc_html__( 'New Property Agent Name', 'crafto-addons' ),
	'menu_name'         => esc_html__( 'Property Agents', 'crafto-addons' ),
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

$crafto_property_tags_url_slug = get_theme_mod( 'crafto_property_agents_url_slug', '' );
if ( ! empty( $crafto_property_tags_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_property_tags_url_slug ),
	);
}

register_taxonomy( 'properties-agents', 'properties', $args );
