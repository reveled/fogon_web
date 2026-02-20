<?php
/**
 * Crafto File System.
 *
 * @package Crafto
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Crafto_Filesystem' ) ) {

	/**
	 * Define Crafto_Filesystem class.
	 */
	final class Crafto_Filesystem {
		/**
		 *
		 * Return init filesystem.
		 */
		public static function init_filesystem() {
			global $wp_filesystem;

			// Default credentials array.
			$credentials = [];

			if ( ! defined( 'FS_METHOD' ) ) {
				define( 'FS_METHOD', 'direct' );
			}

			// Define filesystem method if not already defined.
			if ( ! defined( 'FS_METHOD' ) ) {
				define( 'FS_METHOD', 'direct' );
			}

			// Determine the filesystem method.
			$method = defined( 'FS_METHOD' ) ? FS_METHOD : false;

				// Handle FTP method if specified.
			if ( 'ftpext' === $method ) {
				$credentials = self::get_ftp_credentials();
			}

			// Initialize the filesystem if it's not already set.
			if ( empty( $wp_filesystem ) ) {
				require_once wp_normalize_path( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem( $credentials );
			}

			return $wp_filesystem;
		}

		/**
		 * Get FTP credentials.
		 *
		 * @return array An array of FTP credentials.
		 */
		private static function get_ftp_credentials() {
			$credentials = [];

			// Hostname.
			$credentials['hostname'] = defined( 'FTP_HOST' ) ? preg_replace( '|\w+://|', '', FTP_HOST ) : null; // phpcs:ignore

			// Username and password.
			$credentials['username'] = defined( 'FTP_USER' ) ? FTP_USER : null;
			$credentials['password'] = defined( 'FTP_PASS' ) ? FTP_PASS : null;

			// Set FTP port if defined.
			if ( isset( $credentials['hostname'] ) && strpos( $credentials['hostname'], ':' ) !== false ) {
				list( $credentials['hostname'], $credentials['port'] ) = explode( ':', $credentials['hostname'], 2 );
				if ( ! is_numeric( $credentials['port'] ) ) {
					unset( $credentials['port'] );
				}
			}

			// Determine connection type.
			if ( defined( 'FTP_SSL' ) && FTP_SSL ) {
				$credentials['connection_type'] = 'ftps';
			} elseif ( empty( array_filter( $credentials ) ) ) {
				$credentials['connection_type'] = null;
			} else {
				$credentials['connection_type'] = 'ftp';
			}

			return $credentials;
		}
	}

	// Initialize the Crafto_Filesystem class.
	new Crafto_Filesystem();
}
