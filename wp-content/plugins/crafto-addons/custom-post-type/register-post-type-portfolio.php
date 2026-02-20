<?php
/**
 * Register Custom Post Type - "Portfolio".
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Portfolio custom post type
 */
$labels = array(
	'name'               => _x( 'Portfolio', 'Projects', 'crafto-addons' ),
	'singular_name'      => _x( 'Portfolio', 'Project', 'crafto-addons' ),
	'add_new'            => _x( 'Add New', 'Project', 'crafto-addons' ),
	'add_new_item'       => esc_html__( 'Add New Project', 'crafto-addons' ),
	'edit_item'          => esc_html__( 'Edit Project', 'crafto-addons' ),
	'new_item'           => esc_html__( 'New Project', 'crafto-addons' ),
	'all_items'          => esc_html__( 'All Projects', 'crafto-addons' ),
	'view_item'          => esc_html__( 'View Project', 'crafto-addons' ),
	'search_items'       => esc_html__( 'Search Projects', 'crafto-addons' ),
	'not_found'          => esc_html__( 'No Projects found', 'crafto-addons' ),
	'not_found_in_trash' => esc_html__( 'No Projects found in the Trash', 'crafto-addons' ),
	'parent_item_colon'  => '',
	'menu_name'          => esc_html__( 'Portfolio', 'crafto-addons' ),
);

$args = array(
	'labels'        => $labels,
	'description'   => esc_html__( 'Holds our project and project specific data', 'crafto-addons' ),
	'public'        => true,
	'menu_icon'     => 'dashicons-portfolio',
	'menu_position' => 21,
	'show_in_rest'  => true,
	'show_ui'       => true,
	'supports'      => array(
		'title',
		'thumbnail',
		'editor',
		'author',
		'excerpt',
		'post-formats',
		'comments',
		'revisions',
		'page-attributes',
		'elementor',
	),
	'taxonomies'    => [ 'post_format' ],
	'has_archive'   => true,
	'hierarchical'  => true,
);

$crafto_portfolio_url_slug = get_theme_mod( 'crafto_portfolio_url_slug', '' );

if ( ! empty( $crafto_portfolio_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_portfolio_url_slug ),
	);
}
register_post_type( 'portfolio', $args );

/**
 * Portflio Category
 */
$labels = array(
	'name'              => _x( 'Portfolio Categories', 'taxonomy general name', 'crafto-addons' ),
	'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name', 'crafto-addons' ),
	'search_items'      => esc_html__( 'Search categories', 'crafto-addons' ),
	'all_items'         => esc_html__( 'All Categories', 'crafto-addons' ),
	'parent_item'       => esc_html__( 'Parent Category', 'crafto-addons' ),
	'parent_item_colon' => esc_html__( 'Parent Category:', 'crafto-addons' ),
	'edit_item'         => esc_html__( 'Edit Category', 'crafto-addons' ),
	'update_item'       => esc_html__( 'Update Category', 'crafto-addons' ),
	'add_new_item'      => esc_html__( 'Add New Category', 'crafto-addons' ),
	'new_item_name'     => esc_html__( 'New Category Name', 'crafto-addons' ),
	'menu_name'         => esc_html__( 'Categories', 'crafto-addons' ),
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

$crafto_portfolio_cat_url_slug = get_theme_mod( 'crafto_portfolio_cat_url_slug', '' );
if ( ! empty( $crafto_portfolio_cat_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_portfolio_cat_url_slug ),
	);
}
register_taxonomy( 'portfolio-category', 'portfolio', $args );

/**
 * Portflio Tag
 */

$labels = array(
	'name'              => _x( 'Portfolio Tags', 'taxonomy general name', 'crafto-addons' ),
	'singular_name'     => _x( 'Portfolio Tag', 'taxonomy singular name', 'crafto-addons' ),
	'search_items'      => esc_html__( 'Search tags', 'crafto-addons' ),
	'all_items'         => esc_html__( 'All Tags', 'crafto-addons' ),
	'parent_item'       => esc_html__( 'Parent Tag', 'crafto-addons' ),
	'parent_item_colon' => esc_html__( 'Parent Tag:', 'crafto-addons' ),
	'edit_item'         => esc_html__( 'Edit Tag', 'crafto-addons' ),
	'update_item'       => esc_html__( 'Update Tag', 'crafto-addons' ),
	'add_new_item'      => esc_html__( 'Add New Tag', 'crafto-addons' ),
	'new_item_name'     => esc_html__( 'New Tag Name', 'crafto-addons' ),
	'menu_name'         => esc_html__( 'Tags', 'crafto-addons' ),
);

$args = array(
	'labels'            => $labels,
	'public'            => true,
	'show_ui'           => true,
	'hierarchical'      => false,
	'show_admin_column' => true,
	'show_in_nav_menus' => true,
	'query_var'         => true,
	'show_in_rest'      => true,
);

$crafto_portfolio_tags_url_slug = get_theme_mod( 'crafto_portfolio_tags_url_slug', '' );
if ( ! empty( $crafto_portfolio_tags_url_slug ) ) {
	$args['rewrite'] = array(
		'slug' => trim( $crafto_portfolio_tags_url_slug ),
	);
}
register_taxonomy( 'portfolio-tags', 'portfolio', $args );
