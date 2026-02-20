<?php
/**
 * WordPress Import Init
 *
 * @package WordPress
 * @subpackage Importer
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	return;
}

/** Display verbose errors */
if ( ! defined( 'IMPORT_DEBUG' ) ) {
	define( 'IMPORT_DEBUG', WP_DEBUG );
}

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) ) {
		require $class_wp_importer;
	}
}

/** WXR_Parser class */
if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser.php' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';
}

/** WXR_Parser_SimpleXML class */
if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';
}

/** WXR_Parser_XML class */
if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';
}

/** WXR_Parser_Regex class */
if ( file_exists( dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php' ) ) {
	require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';
}

/** WP_Import class */
if ( file_exists( dirname( __FILE__ ) . '/class-wp-import.php' ) ) {
	require_once dirname( __FILE__ ) . '/class-wp-import.php';
}

/**
 * WordPress Import Initialize
 */
function wordpress_importer_init() {
	load_plugin_textdomain( 'crafto-addons' );

	/**
	 * WordPress Importer object for registering the import callback
	 *
	 * @global WP_Import $wp_import WP Import Object.
	 */
	$GLOBALS['wp_import'] = new WP_Import();
	// phpcs:ignore WordPress.WP.CapitalPDangit
	register_importer( 'wordpress', 'WordPress', __( 'Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.', 'crafto-addons' ), array( $GLOBALS['wp_import'], 'dispatch' ) );
}
add_action( 'admin_init', 'wordpress_importer_init' );
