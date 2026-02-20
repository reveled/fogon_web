<?php
/**
 * Excerpt Class.
 *
 * @package Crafto
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If class `Crafto_Excerpt` doesn't exists yet.
if ( ! class_exists( 'Crafto_Excerpt' ) ) {
	/**
	 * Define Crafto_Excerpt class
	 */
	class Crafto_Excerpt {

		public static $length = 34;

		/**
		 * Static method to get excerpt or content length.
		 *
		 * @param int $new_length Custom length. Defaults to the class property.
		 *
		 * @return string The trimmed excerpt.
		 */
		public static function crafto_get_by_length( $new_length = 34 ) {
			return self::crafto_get( $new_length );
		}

		/**
		 * Retrieve the excerpt or trimmed content.
		 *
		 * @param int $new_length Desired length of the excerpt.
		 *
		 * @return string The processed excerpt.
		 */
		public static function crafto_get( $new_length ) {
			global $post;

			$crafto_output_data = '';
			$crafto_content     = get_the_content();
			$pattern            = get_shortcode_regex();

			// Use the post excerpt if it exists.
			if ( $post->post_excerpt ) {
				$crafto_output_data = $post->post_excerpt;
			} else {
				$crafto_output_data = preg_replace_callback( "/$pattern/s", 'crafto_extract_shortcode_contents', $crafto_content );
			}

			// Handle password-protected content.
			if ( post_password_required() ) {
				$crafto_output_data = $crafto_content;
			} elseif ( $new_length > 0 ) {
				$crafto_output_data = wp_trim_words( $crafto_output_data, $new_length, '...' );
			} else {
				$crafto_output_data = wp_trim_words( $crafto_output_data, $new_length, '' );
			}
			return $crafto_output_data;
		}
	}
}
