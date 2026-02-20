<?php
/**
 * Crafto Addons Core Functions.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 *
 * @param string $template_name The name of the template file to include.
 * @param array  $args Optional. An associative array of arguments to pass to the template.
 * @param string $template_path Optional. The path to the template directory to use for locating the template.
 * @param string $default_path Optional. The fallback path to the template directory if the template cannot be found in the specified $template_path.
 */
function crafto_addons_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( ! empty( $args ) && is_array( $args ) ) {
	    extract( $args ); // @codingStandardsIgnoreLine
	}

	$located = crafto_addons_locate_template( $template_name, $template_path, $default_path );

	if ( ! file_exists( $located ) ) {
		return;
	}

	// Allow 3rd party plugin filter template file from their plugin.
	$located = apply_filters( 'crafto_addons_get_template', $located, $template_name, $args, $template_path, $default_path );

	do_action( 'crafto_addons_before_template_part', $template_name, $template_path, $located, $args );

	include $located;

	do_action( 'crafto_addons_after_template_part', $template_name, $template_path, $located, $args );
}

/**
 * Like crafto_addons_get_template, but returns the HTML instead of outputting.
 *
 * @param string $template_name The name of the template file to include.
 * @param array  $args Optional. An associative array of arguments to pass to the template.
 * @param string $template_path Optional.
 * @param string $default_path Optional.
 */
function crafto_addons_get_template_html( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	ob_start();
	crafto_addons_get_template( $template_name, $args, $template_path, $default_path );
	return ob_get_clean();
}

/**
 * Locate a template and return the path for inclusion.
 *
 * @param string $template_name The name of the template file to locate. This should be a relative path from the template directory.
 * @param string $template_path Optional. The path to the directory where templates are located.
 * @param string $default_path Optional. The fallback path to use if the template cannot be found in the specified `$template_path`.
 */
function crafto_addons_locate_template( $template_name, $template_path = '', $default_path = '' ) {

	// Template path.
	$crafto_addons_template_path = apply_filters( 'crafto_addons_template_path', 'crafto/' );

	// Plugin path.
	$crafto_addons_plugin_path = CRAFTO_ADDONS_ROOT;

	if ( ! $template_path ) {
		$template_path = $crafto_addons_template_path;
	}

	if ( ! $default_path ) {
		$default_path = $crafto_addons_plugin_path . '/templates/';
	}

	// Look within passed path within the theme - this is priority.
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name,
		)
	);

	// Get default template/.
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}

	// Return what we found.
	return apply_filters( 'crafto_addons_locate_template', $template, $template_name, $template_path );
}
