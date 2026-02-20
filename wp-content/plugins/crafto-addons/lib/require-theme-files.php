<?php
/**
 * Include Required files
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Helper function to include a file if it exists.
 *
 * @param string $file_path The path to the file.
 */
function crafto_include_file( $file_path ) {
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}

/**
 * Include general files.
 */
$general_files = [
	CRAFTO_ADDONS_LIB_DIR . '/crafto-helpers.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-builder-helper.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-extra-function.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-crafto-gutenberg-blocks.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-crafto-post-share-shortcode.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-mailchimp.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-enqueue-scripts-styles.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-crafto-register-scripts-styles.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-breadcrumb-navigation.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-excerpt.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-blog-post-like.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-ai-helper.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-crafto-filesystem.php',
	CRAFTO_ADDONS_LIB_DIR . '/classes/class-archive-meta.php',
	CRAFTO_ADDONS_CUSTOMIZER . '/customizer.php',
	CRAFTO_ADDONS_METABOX_DIR . '/meta-box.php',
	CRAFTO_ADDONS_ROOT . '/lib/icon-list.php',
	CRAFTO_ADDONS_ROOT . '/lib/dynamic-select-input-module.php',
	CRAFTO_ADDONS_ROOT . '/lib/heading-highlight-svg.php',
	CRAFTO_ADDONS_IMPORT . '/importer.php',
];

foreach ( $general_files as $file ) {
	crafto_include_file( $file );
}

/**
 * Include custom post types files.
 */
$post_type_files = [
	CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH . '/register-post-type-property.php',
	CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH . '/register-post-type-portfolio.php',
	CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH . '/register-post-type-tours.php',
	CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH . '/register-custom-post-type/class-register-custom-post-type.php',
	CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH . '/register-custom-post-type/class-register-custom-taxonomy.php',
	CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH . '/register-custom-post-type/custom-post-type-helper.php',
	CRAFTO_ADDONS_CUSTOM_POST_TYPE_PATH . '/register-custom-post-type/class-register-custom-meta.php',
];

foreach ( $post_type_files as $file ) {
	crafto_include_file( $file );
}

/**
 * Includes WooCommerce files if WooCommerce is activated.
 */
if ( is_woocommerce_activated() ) {
	$woocommerce_files = [
		CRAFTO_ADDONS_ROOT . '/lib/woocommerce/crafto-woocommerce-extra-functions.php',
		CRAFTO_ADDONS_ROOT . '/lib/woocommerce/crafto-addons-ajax-functions.php',
		CRAFTO_ADDONS_ROOT . '/lib/woocommerce/crafto-woocommerce-global-functions.php',
		CRAFTO_ADDONS_ROOT . '/lib/woocommerce/crafto-addons-core-functions.php',
		CRAFTO_ADDONS_ROOT . '/lib/woocommerce/crafto-addons-template-functions.php',
		CRAFTO_ADDONS_ROOT . '/lib/woocommerce/crafto-addons-template-hooks.php',
		CRAFTO_ADDONS_ROOT . '/woocommerce/crafto-variation-swatch.php',
		CRAFTO_ADDONS_ROOT . '/woocommerce/crafto-woocommerce-meta.php',
	];

	foreach ( $woocommerce_files as $file ) {
		crafto_include_file( $file );
	}
}
